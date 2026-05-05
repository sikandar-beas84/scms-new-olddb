<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentDetailsModel extends Model
{
    protected $table      = 'student_details';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'student_id', 
        'code', 
        'form_no', 
        'bs_id', 
        'stream_id', 
        'class_id', 
        'section_id', 
        'roll_num', 
        'first_name', 
        'middle_name', 
        'surname', 
        'd_o_b', 
        'gender', 
        'blood_grp', 
        'caste', 
        'image', 
        'aadhaar_no', 
        'admission_number', 
        'admission_date', 
        'school_house_id', 
        'promotion', 
        'academic_status', 
        'tc_date', 
        'tc_no',
        'pen_no',
        'appar_id',
        'tc_required',
        'admission', 
        'status', 
        'created_by', 
        'created_date', 
        'session_year_id', 
        'session_result_status', 
        'ad_exam_qualified', 
        'rejection_reason', 
        'fail_consideration', 
        'fail_cons_remarks', 
        'relative', 
        'relative_name', 
        'relative_code', 
        'relationship', 
        'comment', 
        'student_admit', 
        'ad_exam_qualified_submitted_date',
        'ad_exam_qualified_pass_fail_date',
        'ad_exam_qualified_submitted_by',
        'ad_exam_qualified_pass_fail_submitted_by',
        'updated_by',
        'updated_date',
        'shift',
        'academic_status_free_updated_by',
        'academic_status_free_updated_at',
    ];

    /**
     * Get the latest non-empty form number from the `student_detail` table.
     *
     * This method fetches the most recently added student form number that is not empty.
     * It orders the records by `id` in descending order to get the latest entry and
     * limits the query to a single result.
     *
     * @return string|null Returns the latest form number as a string if found, 
     *                     or null if no valid form number exists.
     */
    public function lastestFormNoOld()
    {
        $builder = $this->db->table('student_details');
        $builder->select('form_no');
        $builder->where('form_no !=', '');
        $builder->orderBy('id', 'DESC');
        $builder->limit(1);

        $query = $builder->get();
        $row = $query->getRow();

        return $row ? $row->form_no : null;      
    }

    public function lastestFormNo()
    {
        $builder = $this->db->table('student_details');

        $builder->select('form_no');
        $builder->where('form_no IS NOT NULL', null, false);
        $builder->where('form_no <>', '');
        $builder->where("form_no ~ '^SCMS/[^/]+/[^/]+$'", null, false);
        $builder->orderBy('id', 'DESC');
        $builder->limit(1);

        $query = $builder->get();
        $row = $query->getRow();

        return $row ? $row->form_no : null;
    }
    
    /**
     * Delete a student record from the `student_detail` table by form number.
     *
     * This method removes all records that match the provided form number.
     * It uses a Query Builder delete operation to safely remove the row(s).
     *
     * @param string $form_no The form number of the student to delete.
     * @return bool Returns true on successful deletion, false otherwise.
     */
    public function del_form($form_no)
    {
        $builder = $this->db->table('student_details');
        return $builder->where('form_no', $form_no)->delete();
    }
    
    public function get_form_details($fid)
    {
        $builder = $this->db->table('student_details');

        // Join with casting using NULLIF to avoid empty string cast errors
        $builder->join('class c', 'c.id = NULLIF(student_details.class_id, \'\')::integer', 'left');
        $builder->join('admission_exam_schedule aes', 'aes.class_id = NULLIF(student_details.class_id, \'\')::integer', 'left');
        $builder->join('student_transport_financial stf', 'stf.student_id = student_details.student_id', 'left');
        $builder->join('stoppage_master sm', 'sm.stoppage_id = NULLIF(stf.stoppage, \'\')::integer', 'left');
        $builder->join('student_personal_details spd', 'spd.student_id = student_details.student_id', 'left');
        $builder->join('religion r', 'r.id = NULLIF(spd.religion, \'\')::integer', 'left');

        $builder->select('student_details.*, c.class_name, sm.stoppage_name, r.name AS religion_name, aes.exam_date, aes.exam_time');
        $builder->where('student_details.form_no', $fid);

        $query = $builder->get();
        return $query->getRowArray();
    }

    public function update_entrance_exam_result($totalstudent, $formData, $session_year_id)
    {
        // echo "<pre>"; print_r($totalstudent); 
        // echo "<pre>"; print_r($formData); 
        // echo "<pre>"; print_r($session_year_id); 
        // die();

        $updatedCount = 0;

        // Loop through 1 to totalstudent count
        for ($i = 1; $i <= $totalstudent; $i++) {

            $form_no = $formData['form_no_' . $i] ?? null;
            $class_id = isset($formData['class_id_' . $i]) ? (int) $formData['class_id_' . $i] : null;

            // Skip if form_no is empty or "null"
            if (empty($form_no) || $form_no === 'null') {
                continue;
            }

            // Prepare update data
            $updateData = [
                // 'form_no' => $form_no,
                'session_year_id' => $session_year_id,
                'rejection_reason' => $formData['reject_reason_' . $i] ?? '',
            ];

            if(isset($formData['result_' . $i]) && $formData['result_' . $i] !=''){
                $updateData['ad_exam_qualified'] = $formData['result_' . $i];  

                $get_user_id = session()->get('user_id');

                if( isset($formData['result_' . $i]) && ($formData['result_' . $i] == 2 || $formData['result_' . $i] == 1 || $formData['result_' . $i] == 0) ) {
                    $updateData['ad_exam_qualified_pass_fail_date'] = date('Y-m-d');
                    $updateData['ad_exam_qualified_pass_fail_submitted_by'] = $get_user_id;
                }

                if( isset($formData['result_' . $i]) && ($formData['result_' . $i] == 3 || $formData['result_' . $i] == 4) ) {
                    $updateData['ad_exam_qualified_submitted_date'] = date('Y-m-d');
                    $updateData['ad_exam_qualified_submitted_by'] = $get_user_id;
                }

                // ad_exam_qualified_submitted_date
                // ad_exam_qualified_pass_fail_date
                // ad_exam_qualified_submitted_by
                // ad_exam_qualified_pass_fail_submitted_by
                // 0-Fail, 1-Pass, 2-Not Appeared, 3-Submitted, 4- Not Submitted, 5 - Reject  
            }

            if(isset($formData['class_id_' . $i]) && $formData['class_id_' . $i] !=''){
                $updateData['class_id'] = $formData['class_id_' . $i];    
            }

            // Remove null or empty values
            $updateData = array_filter($updateData, fn($v) => $v !== null && $v !== '');

            // Perform update only if form_no exists
            if (!empty($updateData)) {
                $this->where('form_no', $form_no)->where('session_year_id',$session_year_id)->set($updateData)->update();

                $record = $this->select('student_id')->where('form_no', $form_no)->where('session_year_id',$session_year_id)->first();
                $student_id = $record['student_id'] ?? null;
                
                // ✅ Update class_id in students table if applicable
                if ($student_id && isset($formData['class_id_' . $i])) {
                    $builder = $this->db->table('student');
                    $builder->where('id', $student_id);
                    $builder->update(['class_id' => $class_id]);

                    // Get the last executed query
                    // echo $this->db->getLastQuery();
                }

                $updatedCount++;
            }
        }

        return $updatedCount > 0;
    }

    public function get_reg_details($formNo, $sessionYearId)
    {
        $builder = $this->db->table('student_details');
        
        $builder->select('
            student_details.form_no,
            student_transport_financial.stoppage,
            student_transport_financial.bus_id,
            student_parents_guardians.father_name,
            student_details.class_id,
            student_details.section_id,
            student_details.first_name,
            student_details.admission,
            student_details.ad_exam_qualified,
            student_details.fail_consideration,
            class.id AS class_id,
            class.class_name,
            fees_structure_master.*,
            admission_exam_schedule.exam_date,
            admission_exam_schedule.exam_time,
            session_year.session_name,
            stoppage_master.stoppage_name,
            stoppage_master.stoppage_fare,
            registration_fees.payment_status
        ');

        // ✅ Joins
        $builder->join('class', 'class.id = CAST(student_details.class_id AS INTEGER)', 'left', false);
        $builder->join('admission_exam_schedule', 'admission_exam_schedule.class_id = CAST(student_details.class_id AS INTEGER)', 'left', false);
        $builder->join('fees_structure_master', 'fees_structure_master.class_id = CAST(student_details.class_id AS INTEGER)', 'left', false);
        $builder->join('student_transport_financial', 'student_transport_financial.student_id = student_details.student_id', 'left');
        // $builder->join('stoppage_master', 'stoppage_master.stoppage_id = CAST(student_transport_financial.stoppage AS INTEGER)', 'left', false);
        $builder->join('stoppage_master', 'stoppage_master.stoppage_id = NULLIF(student_transport_financial.stoppage, \'\')::INTEGER', 'left', false);
        $builder->join('registration_fees', 'registration_fees.form_no = student_details.form_no', 'left');
        $builder->join('session_year', 'session_year.id = ' . (int) $sessionYearId, 'left', false);

        $builder->join('student_parents_guardians', 'student_parents_guardians.student_id = student_details.student_id', 'left');
        



        // ✅ Filters
        $builder->where('student_details.form_no', $formNo);
        $builder->where('session_year.id', $sessionYearId);
        $builder->where('fees_structure_master.session_year_id', $sessionYearId);
        $builder->where('admission_exam_schedule.session_year_id', $sessionYearId);
        $builder->where('admission_exam_schedule.phase', '1');

        $query = $builder->get();

        $getLastQuery = $this->db->getLastQuery();
        // echo "<pre>"; print_r($getLastQuery); die();

        return $query->getRowArray(); // return single row object
    }

    public function studentListForAjaxCall($class_id, $code, $student_name, $section_id, $father_name, $mother_name)
    {
        $session_year_id = session()->get('session_year_id');
        $where_in = ['Bonafide', 'Free'];

        $builder = $this->db->table('student');

        $builder->select('
            student.code,
            student.id AS s_id,
            student.class_id,

            student_details.id AS student_details_id,
            student_details.d_o_b,
            student_details.first_name,
            student_details.middle_name,
            student_details.surname,
            student_details.form_no,
            student_details.academic_status,
            student_details.section_id,
            student_details.roll_num,
            student_details.image,

            class.class_name,
            admin_users.first_name as teacher_first_name,
            admin_users.last_name as teacher_last_name,
            section.teacher_id,
            section.section_name,

            student_transport_financial.allow_transport,
            student_transport_financial.allow_readmission,
            student_transport_financial.stoppage,
            student_transport_financial.bus_id,

            bus_master.bus_licence_no,
            stoppage_master.stoppage_name,

            student_personal_details.permanent_address,
            student_personal_details.lkg_onw_sec_lang,
            
            student_parents_guardians.mothers_is_gurgent,
            student_parents_guardians.mother_name,
            student_parents_guardians.father_name,
            student_parents_guardians.father_mobile,
            student_parents_guardians.mother_mobile,


            (SELECT ad_payment_status 
             FROM student_fee_structure 
             WHERE student_fee_structure.student_code = student.code AND student_fee_structure.session_year_id = student.session_year_id
             ORDER BY id ASC LIMIT 1) AS ad_payment_status,

            (SELECT id 
             FROM student_fee_structure 
             WHERE student_fee_structure.student_code = student.code AND student_fee_structure.session_year_id = student.session_year_id
             ORDER BY id ASC LIMIT 1) AS fees_id,

            (SELECT tuition_fee 
             FROM student_fee_structure 
             WHERE student_fee_structure.student_code = student.code AND student_fee_structure.session_year_id = student.session_year_id
             ORDER BY id ASC LIMIT 1) AS tuition_fee,

            (SELECT bus_services 
             FROM student_fee_structure 
             WHERE student_fee_structure.student_code = student.code AND student_fee_structure.session_year_id = student.session_year_id
             ORDER BY id ASC LIMIT 1) AS bus_services,

            (SELECT payment_status 
             FROM student_stationary_items 
             WHERE student_stationary_items.student_id = student.id AND student_stationary_items.session_year_id = student.session_year_id 
             ORDER BY id ASC LIMIT 1) AS sti_payment_status,

            (SELECT payment_status 
             FROM student_tblc_items 
             WHERE student_tblc_items.student_id = student.id AND student_tblc_items.session_year_id = student.session_year_id 
             ORDER BY id ASC LIMIT 1) AS tblc_payment_status

        ');

        $builder->join('student_details', 'student_details.student_id = student.id', 'left');
        $builder->join('class', 'class.id = student.class_id', 'left');
        
        $builder->join('section', 'section.id = student.section_id', 'left');
        $builder->join('admin_users', 'admin_users.id = CAST(section.teacher_id AS INTEGER)', 'left');
        $builder->join('student_parents_guardians', 'student_parents_guardians.student_id = student.id', 'left');
        $builder->join('student_transport_financial', 'student_transport_financial.student_id = student.id', 'left');
        $builder->join('student_personal_details', 'student_personal_details.student_id = student.id', 'left');

        /* ✅ Add Your New Joins (NULL safe) */
        $builder->join('bus_master', 'bus_master.bus_id = NULLIF(student_transport_financial.bus_id, \'\')::INTEGER', 'left');
        $builder->join('stoppage_master', 'stoppage_master.stoppage_id = NULLIF(student_transport_financial.stoppage, \'\')::INTEGER', 'left');
        // $builder->join('student_fee_structure', 'student_fee_structure.student_code = student.code', 'left');


        // Filters
        if (!empty($code)) {
            $builder->where('student.code', $code);
        }

        if (!empty($student_name)) {
            $builder->like('LOWER(student_details.first_name)', strtolower($student_name), false);
        }

        if (!empty($father_name)) {
            $builder->like('LOWER(student_parents_guardians.father_name)', strtolower($father_name), false);
        }

        if (!empty($mother_name)) {
            $builder->like('LOWER(student_parents_guardians.mother_name)', strtolower($mother_name), false);
        }

        if (!empty($class_id)) {
            $builder->where('student.class_id', $class_id);
        }

        if (!empty($section_id)) {
            $builder->where('student_details.section_id', $section_id);
        }

        $builder->where('student.session_year_id', $session_year_id);
        $builder->where('student_details.session_year_id', $session_year_id);
        $builder->where('student_details.admission', 1);
        $builder->whereIn('student_details.academic_status', $where_in);
        

        $query = $builder->get();

        $getLastQuery = $this->db->getLastQuery();
        // echo "<pre>"; print_r($getLastQuery); die();

        return $query->getResultArray();
    }

    public function get_student_details_against_form_no($form_no = '')
    {
        if( !isset($form_no) || empty($form_no) ) {
            return [];
        }

        $builder = $this->db->table('student_details');

        $builder->join('class c', 'c.id = NULLIF(student_details.class_id, \'\')::integer', 'left');
        $builder->join('section s', 's.id = NULLIF(student_details.section_id, \'\')::integer', 'left');

        $builder->select('
            student_details.id as student_details_id,
            student_details.student_id,
            student_details.code,
            student_details.first_name,
            student_details.middle_name,
            student_details.surname,
            student_details.roll_num,
            student_details.class_id,
            student_details.section_id,

            c.class_name,
            s.section_name
        ');
        
        $builder->where('student_details.form_no', $form_no);
        $builder->orderBy('student_details.id', 'DESC');

        $builder->limit(1);

        $query = $builder->get();

        $getLastQuery = $this->db->getLastQuery();
        // echo "<pre>"; print_r($getLastQuery); die();
        
        return $query->getRowArray();
    }

    public function get_admsn_bus_date($code)
    {
        $session_year_id = session()->get('session_year_id');

        $builder = $this->db->table('student_details');

        $builder->join('student_transport_financial', 'student_transport_financial.student_id = student_details.student_id', 'left');

        $builder->select('student_details.admission_date, student_transport_financial.stoppage, student_transport_financial.bus_alloted_date');
        $builder->where('code', $code);
        $builder->where('session_year_id', $session_year_id);

        return $builder->get()->getRowArray();
    }

    public function get_form_submission_report($class_id='', $ad_exam_qualified='', $from_date='', $to_date='')
    {
        $session_year_id = session()->get('session_year_id');
        $where_in = ['Bonafide', 'Free'];

        $builder = $this->db->table('student_details');

        $builder->select('
            student_details.*, 
            class.class_name,
            admin_users.first_name as created_by_first_name,
            admin_users.last_name as created_by_last_name,
            section.section_name,
            student_parents_guardians.father_name,
            student_parents_guardians.mother_name
        ');

        $builder->join('class', 'class.id = NULLIF(student_details.class_id, \'\')::integer', 'left');
        $builder->join('admin_users', 'admin_users.id = CAST(student_details.created_by AS INTEGER)', 'left');
        $builder->join('section', 'section.id = CAST(student_details.section_id AS INTEGER)', 'left');
        // $builder->join('student_parents_guardians', 'student_parents_guardians.student_id = NULLIF(student_details.student_id, \'\')::integer', 'left');
        $builder->join('student_parents_guardians', 'student_parents_guardians.student_id = student_details.student_id', 'left');
        

        $builder->where('student_details.session_year_id', $session_year_id);
        $builder->whereIn('student_details.academic_status', $where_in);

        if( !empty($class_id) ) {
            if( isset($class_id) && $class_id == "all" ) { // This is for all class means class will be blank
                $class_id = '';
            }
            $builder->where('student_details.class_id', $class_id);
        }

        if( !empty($ad_exam_qualified) ) {
            // $builder->where('student_details.ad_exam_qualified', $ad_exam_qualified);
            $builder->where(
                "CAST(student_details.ad_exam_qualified AS INTEGER) = {$ad_exam_qualified}",
                null,
                false
            );
        }

        /*if (!empty($from_date) && !empty($to_date)) {
            $builder->where("DATE(student_details.created_date) >=", $from_date);
            $builder->where("DATE(student_details.created_date) <=", $to_date);
        }*/

        if (!empty($from_date) && !empty($to_date)) {

            $builder->groupStart() // start bracket
                ->where("DATE(student_details.ad_exam_qualified_submitted_date) >=", $from_date)
                ->where("DATE(student_details.ad_exam_qualified_submitted_date) <=", $to_date)
            ->groupEnd();

            $builder->orGroupStart()
                ->where("DATE(student_details.ad_exam_qualified_pass_fail_date) >=", $from_date)
                ->where("DATE(student_details.ad_exam_qualified_pass_fail_date) <=", $to_date)
            ->groupEnd();
        }

        $query = $builder->get();
        // pr($this->db->getLastQuery());

        return $query->getResultArray();

        // return $builder->get()->getResultArray();
    }

    public function get_form_not_admitted_report($class_id='', $ad_exam_qualified=1, $from_date='', $to_date='', $admitted_status = 0)
    {
        $session_year_id = session()->get('session_year_id');
        if( isset($class_id) && $class_id == "all" ) { // This is for all class means class will be blank
            $class_id = '';
        }

        $builder = $this->db->table('student_details');

        $builder->select('
            student_details.*, 
            class.class_name,
            admin_users.first_name as created_by_first_name,
            admin_users.last_name as created_by_last_name,
            student_parents_guardians.father_name,
            student_parents_guardians.mother_name
        ');

        $builder->join('class', 'class.id = NULLIF(student_details.class_id, \'\')::integer', 'left');
        $builder->join('admin_users', 'admin_users.id = CAST(student_details.created_by AS INTEGER)', 'left');
        $builder->join('student_parents_guardians', 'student_parents_guardians.student_id = student_details.student_id', 'left');

        $builder->where('student_details.session_year_id', $session_year_id);

        if( !empty($class_id) ) {
            $builder->where('student_details.class_id', $class_id);
        }

        /*if( !empty($ad_exam_qualified) ) {
            $builder->where('student_details.ad_exam_qualified', $ad_exam_qualified);
        } else {
            $builder->where('student_details.ad_exam_qualified::int IN (0,1,2)', null, false); // Fail, Pass, Not admitted
        }*/

        if(isset($admitted_status) && $admitted_status == 0)
        $builder->where('student_details.ad_exam_qualified::int = 1', null, false);

        if (!empty($from_date) && !empty($to_date)) {
            $builder->where("DATE(student_details.created_date) >=", $from_date);
            $builder->where("DATE(student_details.created_date) <=", $to_date);
        }

        if(isset($admitted_status) && $admitted_status != '') {
            if ($admitted_status == 0) {
                $builder->where('student_details.admission', 0);
            } elseif ($admitted_status == 1) {
                $builder->where('student_details.admission', 1);
                $builder->whereIn('student_details.academic_status', ['Bonafide', 'Free']);
            } else {
                $builder->where('student_details.admission !=', 1);
            }
        } else {
            $builder->where('student_details.admission !=', 1);
        }

        $query = $builder->get();
        // pr($this->db->getLastQuery());

        return $query->getResultArray();
    }
    
    public function get_form_admitted_report($class_id='', $ad_exam_qualified=1, $from_date='', $to_date='')
    {
        $session_year_id = session()->get('session_year_id');
        if( isset($class_id) && $class_id == "all" ) { // This is for all class means class will be blank
            $class_id = '';
        }

        $builder = $this->db->table('student_details');

        $builder->select('
            student_details.*, 
            class.class_name,
            admin_users.first_name as created_by_first_name,
            admin_users.last_name as created_by_last_name,
            student_parents_guardians.father_name,
            student_parents_guardians.mother_name,
            student_parents_guardians.father_mobile,
            student_parents_guardians.mother_mobile,
            student_personal_details.second_language,
            student_personal_details.permanent_address,
            student_personal_details.pincode,
            student_personal_details.telephone_resi,
            section.section_name,
        ');

        $builder->join('class', 'class.id = NULLIF(student_details.class_id, \'\')::integer', 'left');
        $builder->join('admin_users', 'admin_users.id = CAST(student_details.created_by AS INTEGER)', 'left');
        $builder->join('student_parents_guardians', 'student_parents_guardians.student_id = student_details.student_id', 'left');
        $builder->join('student_personal_details', 'student_personal_details.student_id = student_details.student_id', 'left');
        $builder->join('section', 'section.id = NULLIF(student_details.section_id, \'\')::integer', 'left');

        $builder->where('student_details.admission', 1);
        $builder->where('student_details.session_year_id', $session_year_id);

        if( !empty($class_id) ) {
            $builder->where('student_details.class_id', $class_id);
        }

        /*if( !empty($ad_exam_qualified) ) {
            $builder->where('student_details.ad_exam_qualified', $ad_exam_qualified);
        } else {
            $builder->where('student_details.ad_exam_qualified::int IN (0,1,2)', null, false); // Fail, Pass, Not admitted
        }*/

        $builder->where('student_details.ad_exam_qualified::int = 1', null, false);

        if (!empty($from_date) && !empty($to_date)) {
            $builder->where("DATE(student_details.created_date) >=", $from_date);
            $builder->where("DATE(student_details.created_date) <=", $to_date);
        }

        $query = $builder->get();
        // pr($this->db->getLastQuery());

        return $query->getResultArray();
    }

    public function get_student_admitted_report($class_id='', $ad_exam_qualified=1, $from_date='', $to_date='')
    {
        $session_year_id = session()->get('session_year_id');
        if( isset($class_id) && $class_id == "all" ) { // This is for all class means class will be blank
            $class_id = '';
        }

        $builder = $this->db->table('student_details');

        $builder->select('
            student_details.*, 
            class.class_name,
            admin_users.first_name as created_by_first_name,
            admin_users.last_name as created_by_last_name,
            student_parents_guardians.father_name,
            student_parents_guardians.mother_name,
            student_parents_guardians.father_mobile,
            student_parents_guardians.mother_mobile,
            student_personal_details.second_language,
            student_personal_details.permanent_address,
            student_personal_details.pincode,
            student_personal_details.telephone_resi,
            section.section_name,
            student_fee_structure.id as student_fee_structure_id,
            student_fee_structure.payment_amount,
            student_fee_structure.academic_payment_amt,
            student_fee_structure.bus_payment_amt,
            student_fee_structure.payee_name,
            student_fee_structure.ad_payment_status,
        ');

        $builder->join('class', 'class.id = NULLIF(student_details.class_id, \'\')::integer', 'left');
        // $builder->join('admin_users', 'admin_users.id = CAST(student_details.created_by AS INTEGER)', 'left');
        $builder->join('admin_users', "admin_users.id = NULLIF(student_details.created_by, '')::int", 'left');
        $builder->join('student_parents_guardians', 'student_parents_guardians.student_id = student_details.student_id', 'left');
        $builder->join('student_personal_details', 'student_personal_details.student_id = student_details.student_id', 'left');
        $builder->join('section', 'section.id = NULLIF(student_details.section_id, \'\')::integer', 'left');

        $builder->join('student_fee_structure', "student_fee_structure.student_code = student_details.code AND student_fee_structure.ad_payment_status = 1 AND student_fee_structure.month_id = 4 AND student_fee_structure.session_year_id = {$session_year_id}", 'inner');

        // $builder->where('student_details.admission', 1);
        $builder->where('student_details.session_year_id', $session_year_id);

        if( !empty($class_id) ) {
            $builder->where('student_details.class_id', $class_id);
        }

        /*if( !empty($ad_exam_qualified) ) {
            $builder->where('student_details.ad_exam_qualified', $ad_exam_qualified);
        } else {
            $builder->where('student_details.ad_exam_qualified::int IN (0,1,2)', null, false); // Fail, Pass, Not admitted
        }*/



        // $builder->where('student_details.ad_exam_qualified::int = 1', null, false);
        // $builder->where("NULLIF(student_details.ad_exam_qualified, '')::int = 1", null, false);

        if (!empty($from_date) && !empty($to_date)) {
            $builder->where("DATE(student_details.created_date) >=", $from_date);
            $builder->where("DATE(student_details.created_date) <=", $to_date);
        }

        $builder->whereIn('student_details.academic_status', ['Bonafide', 'Free']);
        // $builder->where('student_fee_structure.ad_payment_status', 1);
        // $builder->where('student_fee_structure.month_id', 4);
        // $builder->where('student_fee_structure.session_year_id', $session_year_id);

        $query = $builder->get();
        // pr($this->db->getLastQuery());

        return $query->getResultArray();
    }

    public function get_form_pass_fail_report($class_id='', $ad_exam_qualified='')
    {
        if( isset($class_id) && $class_id == "all" ) { // This is for all class means class will be blank
            $class_id = '';
        }
        
        $session_year_id = session()->get('session_year_id');
        $builder = $this->db->table('student_details');

        $builder->select('
            student_details.*, 
            class.class_name,
            admin_users.first_name as created_by_first_name,
            admin_users.last_name as created_by_last_name,
            student_parents_guardians.father_name,
            student_parents_guardians.mother_name,
            student_parents_guardians.father_mobile,
            student_parents_guardians.mother_mobile,
            student_personal_details.second_language,
            student_personal_details.permanent_address,
            student_personal_details.pincode,
            section.section_name,
        ');

        $builder->join('class', 'class.id = NULLIF(student_details.class_id, \'\')::integer', 'left');
        $builder->join('admin_users', 'admin_users.id = CAST(student_details.created_by AS INTEGER)', 'left');
        $builder->join('student_parents_guardians', 'student_parents_guardians.student_id = student_details.student_id', 'left');
        $builder->join('student_personal_details', 'student_personal_details.student_id = student_details.student_id', 'left');
        $builder->join('section', 'section.id = NULLIF(student_details.section_id, \'\')::integer', 'left');

        $builder->where('student_details.session_year_id', $session_year_id);

        if( !empty($class_id) ) {
            $builder->where('student_details.class_id', $class_id);
        }

        if ($ad_exam_qualified !== '' && $ad_exam_qualified !== null) {
            $builder->where('student_details.ad_exam_qualified', (string) $ad_exam_qualified);
        }

        $query = $builder->get();
        // pr($this->db->getLastQuery());

        return $query->getResultArray();
    }

    public function allot_student_roll($code, $roll_num){
        $builder = $this->db->table('student_details');

        $builder->set('roll_num', $roll_num);
        $builder->where('code', $code);
        $builder->where('session_year_id', session()->get('session_year_id'));

        return $builder->update();
    }

    public function get_student_details_by_code($student_code)
    {

        if( !isset($student_code) || $student_code == '' )
            return [];

        $builder = $this->db->table('student_details');

        $builder->select('
            student.id,
            student.code,
            student.class_id,
            student.section_id,
            student.status as student_status,
            student.session_year_id,

            student_details.id as student_details_id,
            student_academic_history.id as student_academic_history_id,
            student_documents.id as student_documents_id,
            student_elective_subjects.id as student_elective_subjects_id,
            student_parents_guardians.id as student_parents_guardians_id,
            student_personal_details.id as student_personal_details_id,
            student_transport_financial.id as student_transport_financial_id,

            student_details.shift,
            student_details.form_no,
            student_details.bs_id,
            student_details.stream_id,
            student_details.class_id,
            student_details.section_id,
            student_details.roll_num,
            student_details.first_name,
            student_details.middle_name,
            student_details.surname,
            student_details.d_o_b,
            student_details.gender,
            student_details.blood_grp,
            student_details.caste,
            student_details.image,
            student_details.aadhaar_no,
            student_details.admission_number,
            student_details.admission_date,
            student_details.school_house_id,
            student_details.promotion,
            student_details.academic_status,
            student_details.tc_date,
            student_details.admission,
            student_details.status,
            student_details.created_by,
            student_details.created_date,
            student_details.session_year_id,
            student_details.session_result_status,
            student_details.ad_exam_qualified,
            student_details.rejection_reason,
            student_details.fail_consideration,
            student_details.fail_cons_remarks,
            student_details.relative,
            student_details.relative_name,
            student_details.relative_code,
            student_details.relationship,
            student_details.comment,
            student_details.student_admit,
            student_details.tc_required,
            student_details.tc_no,
            student_details.pen_no,
            student_details.appar_id,
            student_documents.signature,
            student_documents.f_image,
            student_documents.m_image,
            student_documents.f_signature,
            student_documents.m_signature,
            student_documents.g_image,
            student_documents.g_signature,
            student_documents.stu_signature,
            student_documents.cast_certificate,
            student_documents.caste_photocopy,
            student_documents.application,
            student_documents.trans_cert,
            student_documents.migration_cert,
            student_documents.any_special_cert,
            student_elective_subjects.first_elective_sub,
            student_elective_subjects.second_elective_sub,
            student_elective_subjects.third_elective_sub,
            student_elective_subjects.fourth_elective_sub,
            student_elective_subjects.fifth_elective_sub,
            student_elective_subjects.sixth_elective_sub,
            student_elective_subjects.last_year_marksheet,
            student_elective_subjects.student_birth_certificate,
            student_elective_subjects.student_admit,
            student_elective_subjects.father_id,
            student_elective_subjects.mother_id,
            student_elective_subjects.cast_certificate,
            student_parents_guardians.father_name,
            student_parents_guardians.father_occupation,
            student_parents_guardians.father_designation,
            student_parents_guardians.father_office_address,
            student_parents_guardians.father_office_phone,
            student_parents_guardians.father_mobile,
            student_parents_guardians.father_qualification,
            student_parents_guardians.father_annual_income,
            student_parents_guardians.father_aadhaar_no,
            student_parents_guardians.father_id,
            student_parents_guardians.mother_name,
            student_parents_guardians.mother_occupation,
            student_parents_guardians.mother_designation,
            student_parents_guardians.mother_office_address,
            student_parents_guardians.mother_office_phone,
            student_parents_guardians.mother_mobile,
            student_parents_guardians.mother_qualification,
            student_parents_guardians.mother_annual_income,
            student_parents_guardians.mother_aadhaar_no,
            student_parents_guardians.mother_id,
            student_parents_guardians.mothers_is_gurgent,
            student_parents_guardians.local_guar_name,
            student_parents_guardians.local_guar_occupation,
            student_parents_guardians.local_guar_stu_relation,
            student_parents_guardians.local_guar_gender,
            student_parents_guardians.local_guar_annual_income,
            student_parents_guardians.local_guar_aadhaar_no,
            student_parents_guardians.local_guar_phone,
            student_parents_guardians.local_guar_office_phone,
            student_parents_guardians.local_guar_address,
            student_parents_guardians.family_earn_memb,
            student_parents_guardians.dependent,
            student_personal_details.mother_language,
            student_personal_details.second_language,
            student_personal_details.immunization,
            student_personal_details.medical_condition,
            student_personal_details.only_child,
            student_personal_details.religion,
            student_personal_details.nationality,
            student_personal_details.bpl,
            student_personal_details.bpl_number,
            student_personal_details.lkg_onw_sec_lang,
            student_personal_details.std_three_sec_lang,
            student_personal_details.telephone_resi,
            student_personal_details.pincode,
            student_personal_details.permanent_address,
            student_personal_details.residential_address,
            student_personal_details.residential_phone,
            student_personal_details.residential_mobile,
            student_personal_details.email,
            student_personal_details.whatsapp_number_one,
            student_personal_details.whatsapp_number_two,
            student_transport_financial.bank_acc_no,
            student_transport_financial.bank_ifsc_no,
            student_transport_financial.transport_required,
            student_transport_financial.stoppage,
            student_transport_financial.bus_id,
            student_transport_financial.bus_alloted_date,
            student_transport_financial.allow_transport,
            student_transport_financial.deposit_refund_status,
            student_transport_financial.refund_date,
            student_transport_financial.refund_message,
            student_transport_financial.sm_refund_amount,
            student_transport_financial.sm_refund_date,
            student_transport_financial.allow_readmission,
            student_transport_financial.dmg_prd,
            student_transport_financial.dmg_prd_price,
            student_transport_financial.dmg_prd_img,
            student_academic_history.last_ac_certificate AS last_ac_certificate,
            student_academic_history.last_ac_exam_passed AS last_ac_exam_passed,
            student_academic_history.last_ac_year AS last_ac_year,
            student_academic_history.last_ac_board AS last_ac_board,
            student_academic_history.last_ac_school_name AS last_ac_school_name,
            student_academic_history.last_ac_roll_no AS last_ac_roll_no,
            student_academic_history.last_ac_max_mark AS last_ac_max_mark,
            student_academic_history.last_ac_marks AS last_ac_marks,
            student_academic_history.last_school_detail AS last_school_detail,
            student_academic_history.transfer_certificate AS transfer_certificate,
            student_academic_history.marksheet AS marksheet,
            student_academic_history.last_year_marksheet AS last_year_marksheet,
            student_academic_history.tc_required AS tc_required,
            student_academic_history.pre_school_tc_date AS pre_school_tc_date,
            student_academic_history.migration_required AS migration_required,
            student_academic_history.migration_date AS migration_date
        ');

        // Main relation: main_students.id = student_details.student_id
        $builder->join('student', 'student.id = student_details.student_id', 'left');

        // student_details.student_id = all other tables student_id
        $builder->join('student_academic_history', 'student_academic_history.student_id = student.id', 'left');
        $builder->join('student_documents', 'student_documents.student_id = student.id', 'left');
        $builder->join('student_elective_subjects', 'student_elective_subjects.student_id = student.id', 'left');
        $builder->join('student_parents_guardians', 'student_parents_guardians.student_id = student.id', 'left');
        $builder->join('student_personal_details', 'student_personal_details.student_id = student.id', 'left');
        $builder->join('student_transport_financial', 'student_transport_financial.student_id = student.id', 'left');

        // where conditions
        $builder->where('student_details.code', $student_code);
        $builder->where('student_details.session_year_id', session()->get('session_year_id'));

        $query = $builder->get();
        // pr($this->db->getLastQuery());

        return $query->getRowArray();
    }

    public function copy_student_details(int $id, int $newStudentId, int $classId, int $sectionId, int $sessionId)
    {
        // 1️⃣ Fetch old record
        $studentDetails = $this->find($id);

        if (!$studentDetails) {
            return false;
        }

        // 2️⃣ Remove primary key (VERY IMPORTANT)
        unset($studentDetails['id']);

        // 3️⃣ Override required fields
        $studentDetails['student_id']      = $newStudentId;
        $studentDetails['class_id']        = $classId;
        $studentDetails['section_id']      = $sectionId;
        $studentDetails['session_year_id'] = $sessionId;
        $studentDetails['promotion']       = 'Y'; // optional
        $studentDetails['created_date']    = date('Y-m-d H:i:s');
        $studentDetails['shift']           = 'Morning';

        // 4️⃣ Insert copied record
        $this->insert($studentDetails);

        // 5️⃣ Return new ID
        return $this->getInsertID();
    }

    public function getTodayBirthdays($session_year_id)
    {
        $sql = "
            SELECT 
                sd.id,
                TRIM(CONCAT(sd.first_name, ' ', sd.surname)) AS full_name,
                sd.d_o_b AS dob,
                spd.email,
                sd.image,
                'student' AS type
            FROM student_details sd
            INNER JOIN student_personal_details spd 
                ON sd.student_id = spd.student_id
            WHERE EXTRACT(MONTH FROM sd.d_o_b) = EXTRACT(MONTH FROM CURRENT_DATE)
              AND EXTRACT(DAY FROM sd.d_o_b) = EXTRACT(DAY FROM CURRENT_DATE)
              AND sd.session_year_id = ?
              AND spd.email IS NOT NULL
              AND spd.email != ''

            UNION

            SELECT 
                au.id,
                TRIM(CONCAT(au.first_name, ' ', au.last_name)) AS full_name,
                au.date_of_birth AS dob,
                au.email,
                au.image,
                'staff' AS type
            FROM admin_users au
            WHERE EXTRACT(MONTH FROM au.date_of_birth) = EXTRACT(MONTH FROM CURRENT_DATE)
              AND EXTRACT(DAY FROM au.date_of_birth) = EXTRACT(DAY FROM CURRENT_DATE)
              AND au.email IS NOT NULL
              AND au.email != ''
        ";

        return $this->db->query($sql, [$session_year_id])->getResultArray();
    }
}