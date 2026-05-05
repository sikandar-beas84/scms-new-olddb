<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentFeeStructureModel extends Model
{
    protected $table      = 'student_fee_structure';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [ 
        'student_code',
        'form_no',
        'month_id',
        'fine',
        'admission_fee',
        'development_fee',
        'exam_fee',
        'festival_celebration_fee',
        'games_sports_fee',
        'audio_visual_lab_fee',
        'library_fee',
        'electricity_maintenance_fee',
        'computer_fee',
        'session_charges',
        'security_deposite',
        'tuition_fee',
        'bus_services',
        'bus_fee_fine',
        'payment_amount',
        'academic_payment_amt',
        'bus_payment_amt',
        'total_stationary_fee',
        'ad_payment_status',
        'bus_payment_status',
        'payment_due_date',
        'created_date',
        'bus_payment_date',
        'ad_payment_mode',
        'bus_payment_mode',
        'cheque_number',
        'pos_bank_name',
        'pos_reference_number',
        'transaction_no',
        'payee_name',
        't_user_id',
        'added_by',
        'bus_cheque_number',
        'bus_pos_bank_name',
        'bus_pos_reference_number',
        'bus_payee_name',
        'bus_t_user_id',
        'bus_added_by',
        'cons_admission_fee',
        'cons_development_fee',
        'cons_exam_fee',
        'cons_festival_celebration_fee',
        'cons_games_sports_fee',
        'cons_audio_visual_lab_fee',
        'cons_library_fee',
        'cons_electricity_maintenance_fee',
        'cons_computer_fee',
        'cons_session_charges',
        'cons_security_deposite',
        'cons_tuition_fee',
        'cons_bus_services',
        'remarks',
        'adv_bal_used',
        'session_year_id',
        'allow_bus_report',
        'allow_payment_report',
    ];

    public function getFirstMonthFee($code)
    {
        if(!isset($code) || $code == '' )
            return [];

        $session_year_id = session()->get('session_year_id');

        $builder = $this->db->table('student_fee_structure');

        $builder->select('
            student_fee_structure.*,
            student_fee_structure.id as fees_id,
            student_transport_financial.stoppage,
            student_transport_financial.bus_id,
            student_transport_financial.allow_readmission,
            student_transport_financial.allow_transport,
            student_details.first_name,
            student_details.form_no,
            student_details.class_id,
            student_details.section_id,
            student.id as student_id,
            student.status
        ');

        $builder->join('student_details', 'student_details.code = student_fee_structure.student_code', 'left');
        $builder->join('student', 'student.id = student_details.student_id', 'left');
        $builder->join('student_transport_financial', 'student_transport_financial.student_id = student_details.student_id', 'left');

        $builder->where('student_fee_structure.student_code', $code);
        $builder->where('student_fee_structure.session_year_id', $session_year_id);
        $builder->where('student_details.session_year_id', $session_year_id);

        $builder->orderBy('student_fee_structure.id', 'ASC');
        $builder->limit(1);

        $query = $builder->get();
        // $lastQuery = $this->db->getLastQuery();
        // pr($lastQuery);
        return $query->getRowArray(); // same as row()
    }

    public function getStudentFeeStructure($code, $sessionYearId='')
    {
        if (!$code) {
            return [];
        }

        // $session_year_id = session()->get('session_year_id');
        $session_year_id = !empty($sessionYearId) ? $sessionYearId : session()->get('session_year_id');

        $builder = $this->db->table('student_fee_structure');

        $builder->select('
            student_fee_structure.*,
            student_fee_structure.id AS fee_id,
            class.class_name,
            student_details.first_name,
            student_details.roll_num,
            student_parents_guardians.father_name,
            student_parents_guardians.mother_name
        ');

        $builder->join('student_details', 'student_details.code = student_fee_structure.student_code', 'left');
        $builder->join('class', 'class.id = CAST(student_details.class_id AS INTEGER)', 'left');
        $builder->join('student_parents_guardians', 'student_parents_guardians.student_id = student_details.student_id', 'left');

        $builder->where('student_fee_structure.student_code', $code);
        $builder->where('student_fee_structure.session_year_id', $session_year_id);
        $builder->where('student_details.session_year_id', $session_year_id);

        $builder->orderBy('student_fee_structure.id', 'ASC');

        $query = $builder->get();

        return $query->getResultArray();  // same as result()
    }

    public function get_mnth_due_fee($id)
    {
        $builder = $this->db->table('student_fee_structure');

        $builder->select("
            payment_amount,
            ad_payment_status,
            bus_payment_status,
            created_date,
            bus_payment_date,
            payment_due_date,
            fine,
            admission_fee,
            session_charges,
            security_deposite,
            tuition_fee,
            (COALESCE(fine,0) + COALESCE(admission_fee,0) + COALESCE(session_charges,0) + COALESCE(security_deposite,0) + COALESCE(tuition_fee,0)) AS total
        ");

        $builder->where('id', $id);

        return $builder->get()->getRowArray(); // returns a single row object
    }

    public function update_admission_payment($id,$data)
    {
        if( !isset($id) || empty($id) ) {
            return 0;
        }

        // Get the month fee record
        $result = $this->get_mnth_due_fee($id);
        
        if ($result && $result['ad_payment_status'] == 1) {
            // Remove fields that should not be updated if payment is already done
            unset(
                $data['fine'],
                $data['ad_payment_status'],
                $data['ad_payment_mode'],
                $data['cheque_number'],
                $data['pos_bank_name'],
                $data['pos_reference_number'],
                $data['payee_name'],
                $data['t_user_id'],
                $data['added_by']
                // 'created_date' can also be unset if needed
            );
        }
       
        // Using CI4 Builder
        $builder = $this->db->table('student_fee_structure');
        $updated = $builder->where('id', $id)->update($data);

        return $updated ? $id : 0;
    }

    public function bus_services_fee($studentCode, $monthId, $sessionYearId)
    {
        // 🔒 Check required parameters
        if (empty($studentCode) || empty($monthId) || empty($sessionYearId)) {
            return 0;
        }

        $builder = $this->db->table('student_fee_structure');

        $builder->select('bus_services');
        $builder->where('student_code', $studentCode);
        $builder->where('month_id', $monthId);
        $builder->where('session_year_id', $sessionYearId);
        $builder->where('bus_payment_status', 0);

        $row = $builder->get()->getRow();

        return $row ? (int) $row->bus_services : 0;
    }

    public function get_fee_row_by_april_month($monthId, $code)
    {
        if(!isset($monthId) || $monthId == '' )
            return [];

        if(!isset($code) || $code == '' )
            return [];

        $session_year_id = session()->get('session_year_id');

        $builder = $this->db->table('student_fee_structure');

        $builder->select('
            student_fee_structure.*
        ');

        $builder->where('student_fee_structure.student_code', $code);
        $builder->where('student_fee_structure.month_id', $monthId);
        $builder->where('student_fee_structure.session_year_id', $session_year_id);

        $builder->orderBy('student_fee_structure.id', 'ASC');
        $builder->limit(1);

        $query = $builder->get();
        // $lastQuery = $this->db->getLastQuery();
        // pr($lastQuery);
        return $query->getRowArray(); // same as row()
    }

    public function studentdata_save($student_data)
    {
        $session_year_id = session()->get('session_year_id');

        $student_code = $student_data['student_code'];
        $month_id     = $student_data['month_id'];

        unset($student_data['student_code']);
        unset($student_data['month_id']);

        return $this->where('student_code', $student_code)
                    ->where('month_id', $month_id)
                    ->where('session_year_id', $session_year_id)
                    ->set($student_data)
                    ->update();
    }

    /**
     * Carry forward tuition fee to next month
     */
    public function carryNextMonthTuitionFee($monthId, $code, $amount)
    {
        $sessionYearId = session()->get('session_year_id');

        $this->db->transStart();

        $result = $this->builder()
            ->where('month_id', $monthId)
            ->where('student_code', $code)
            ->where('session_year_id', $sessionYearId)
            ->set('tuition_fee', 'tuition_fee + ' . (float)$amount, false)
            ->update();

        $this->db->transComplete();

        return $this->db->transStatus() && $result;
    }

    /**
     * Carry forward bus fee to next month
     */
    public function carryNextMonthBusFee($monthId, $code, $amount)
    {
        $sessionYearId = session()->get('session_year_id');

        $this->db->transStart();

        $result = $this->builder()
            ->where('month_id', $monthId)
            ->where('student_code', $code)
            ->where('session_year_id', $sessionYearId)
            ->set('bus_services', 'bus_services + ' . (float)$amount, false)
            ->update();

        $this->db->transComplete();

        return $this->db->transStatus() && $result;
    }

    public function get_student_statonary_item_collection_lists_for_ajax_call($student_code, $session_year_id='', $month_id='')
    {
        // student_fee_structure
        $builder = $this->db->table('student_fee_structure');

        $getSessionYearId = ($session_year_id != '') ? $session_year_id : session()->get('session_year_id');

        $getMonthId = ($month_id != '') ? $month_id : 4;

        $builder->select("
            student_fee_structure.ad_payment_status,
            student_fee_structure.session_year_id,
            student_details.code,
            student_details.student_id,
            student_details.class_id,
            student_details.first_name,
            student_details.middle_name,
            student_details.surname,
            SUM(item_master.qty * item_master.price) AS total_price
        ");

        $builder->join('student_details', 'student_fee_structure.student_code = student_details.code', 'left');
        $builder->join('item_master', 'item_master.class_id = CAST(student_details.class_id AS INTEGER)', 'left');

        // Apply filters
        if (!empty($student_code)) {
            $builder->where('student_fee_structure.student_code', $student_code);
            $builder->where('student_details.code', $student_code); // redundant but safe
        }

        $builder->where([
            'student_fee_structure.session_year_id' => $getSessionYearId,
            'student_fee_structure.month_id'        => $getMonthId,
            'student_details.session_year_id'        => $getSessionYearId,
            'item_master.sec_lang'                  => 'Bengali',
            'item_master.session_year_id'           => $getSessionYearId
        ]);

        $builder->groupBy([
            'student_details.class_id',
            'student_fee_structure.ad_payment_status',
            'student_fee_structure.session_year_id',
            'student_details.code',
            'student_details.student_id',
            'student_details.first_name',
            'student_details.middle_name',
            'student_details.surname'
        ]);

        $query = $builder->get();

        // $lastQuery = $this->db->getLastQuery();
        // pr($lastQuery);

        return $query->getResultArray(); // or getResultArray()
    }
    
    public function get_student_april_month_fees_details($student_code, $month_id = '', $session_year_id = '')
    {
        $sessionYearId = $session_year_id ?: session()->get('session_year_id');
        $month_id = $month_id ?: 4;

        if (empty($student_code) || empty($month_id)) {
            return [];
        }

        $builder = $this->builder();

        $builder->where('month_id', (int)$month_id);
        $builder->where('student_code', $student_code);
        $builder->where('session_year_id', (int)$sessionYearId);

        $query = $builder->get();
        
        // $lastQuery = $this->db->getLastQuery();
        // pr($lastQuery);

        $result = $query->getRowArray();

        return !empty($result) ? $result : [];
    }

    public function dailyBusPaymentReport($class_id='', $from_date='', $to_date='', $payment_mode='', $t_user_id='', $student_code='')
    {
        $sessionYearId = session()->get('session_year_id') ?? '';

        $builder = $this->db->table('student_fee_structure');

        $builder->select(<<<SQL
            student_fee_structure.*,
            CASE student_fee_structure.month_id
                WHEN 1 THEN 'January'
                WHEN 2 THEN 'February'
                WHEN 3 THEN 'March'
                WHEN 4 THEN 'April'
                WHEN 5 THEN 'May'
                WHEN 6 THEN 'June'
                WHEN 7 THEN 'July'
                WHEN 8 THEN 'August'
                WHEN 9 THEN 'September'
                WHEN 10 THEN 'October'
                WHEN 11 THEN 'November'
                WHEN 12 THEN 'December'
            END AS month_name,
            student_details.student_id,
            student_details.code,
            student_details.class_id,
            student_transport_financial.stoppage,
            CONCAT(student_details.first_name, ' ', student_details.middle_name, ' ', student_details.surname) AS full_name
            SQL
        );

        $builder->join('student_details', 'student_fee_structure.student_code = student_details.code', 'inner');
        $builder->join('student_transport_financial', 'student_transport_financial.student_id = student_details.student_id', 'left');

        if (!empty($payment_mode)) {
            $builder->where('student_fee_structure.bus_payment_mode', $payment_mode);
        }

        if (!empty($class_id)) {
            $builder->where('student_details.class_id', $class_id);
        }

        if (!empty($student_code)) {
            $builder->where('student_fee_structure.student_code', $student_code);
        }

        if (!empty($t_user_id)) {
            $builder->where('student_fee_structure.bus_t_user_id', $t_user_id);
        }

        if (!empty($from_date) && !empty($to_date)) {
            $builder->where('student_fee_structure.bus_payment_date >=', $from_date . ' 00:00:00');
            $builder->where('student_fee_structure.bus_payment_date <=', $to_date . ' 23:59:59');
        } elseif (!empty($from_date)) {
            $builder->where('student_fee_structure.bus_payment_date >=', $from_date . ' 00:00:00');
        } elseif (!empty($to_date)) {
            $builder->where('student_fee_structure.bus_payment_date <=', $to_date . ' 23:59:59');
        }

        $builder->where('student_fee_structure.bus_payment_status', 1);
        $builder->where('student_details.session_year_id', $sessionYearId);
        $builder->where('student_fee_structure.session_year_id', $sessionYearId);

        $query = $builder->get();

        // $lastQuery = $this->db->getLastQuery();
        // pr($lastQuery);

        return $query->getResultArray();
    }

    public function busPaidReport($from_date='', $to_date='')
    {
        $sessionYearId = session()->get('session_year_id') ?? '';

        $builder = $this->db->table('student_fee_structure');

        $builder->select("
            student_fee_structure.*,
            student_details.student_id,
            student_details.code,
            student_details.class_id,
            student_transport_financial.stoppage,
            student_transport_financial.bus_id,
            student_transport_financial.bus_alloted_date as stud_bus_alloted_date,
            
            bus_master.bus_serial_no,
            bus_master.bus_licence_no,
            bus_master.bus_seating_capacity,
            bus_master.bus_driver_name,
            bus_master.bus_driver_phone,
            bus_master.vendor_id,
            bus_master.area_id,
            student_parents_guardians.mothers_is_gurgent,
            student_parents_guardians.mother_name,
            student_parents_guardians.father_name,
            student_parents_guardians.father_mobile,
            student_parents_guardians.mother_mobile,

            CONCAT(student_details.first_name, ' ', student_details.middle_name, ' ', student_details.surname) AS full_name,
            CASE student_fee_structure.month_id
                WHEN 1 THEN 'January'
                WHEN 2 THEN 'February'
                WHEN 3 THEN 'March'
                WHEN 4 THEN 'April'
                WHEN 5 THEN 'May'
                WHEN 6 THEN 'June'
                WHEN 7 THEN 'July'
                WHEN 8 THEN 'August'
                WHEN 9 THEN 'September'
                WHEN 10 THEN 'October'
                WHEN 11 THEN 'November'
                WHEN 12 THEN 'December'
            END AS month_name
        ");

        $builder->join('student_details', 'student_fee_structure.student_code = student_details.code', 'inner');
        $builder->join('student_transport_financial', 'student_transport_financial.student_id = student_details.student_id', 'left');
        $builder->join('bus_master', 'bus_master.bus_id = CAST(student_transport_financial.bus_id AS INTEGER)', 'left');
        $builder->join('student', 'student_details.student_id = student.id', 'left');
        $builder->join('student_parents_guardians', 'student.id = student_parents_guardians.student_id', 'left');

        if (!empty($from_date) && !empty($to_date)) {
            $builder->where('student_fee_structure.bus_payment_date >=', $from_date . ' 00:00:00');
            $builder->where('student_fee_structure.bus_payment_date <=', $to_date . ' 23:59:59');
        } elseif (!empty($from_date)) {
            $builder->where('student_fee_structure.bus_payment_date >=', $from_date . ' 00:00:00');
        } elseif (!empty($to_date)) {
            $builder->where('student_fee_structure.bus_payment_date <=', $to_date . ' 23:59:59');
        }

        $builder->where('student_fee_structure.bus_payment_status', 1);
        $builder->where('student_details.session_year_id', $sessionYearId);
        $builder->where('student_fee_structure.session_year_id', $sessionYearId);

        $query = $builder->get();

        // $lastQuery = $this->db->getLastQuery();
        // pr($lastQuery);

        return $query->getResultArray();
    }
    
}