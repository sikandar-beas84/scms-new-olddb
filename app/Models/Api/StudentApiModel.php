<?php
namespace App\Models\Api;
use CodeIgniter\Model;

class StudentApiModel extends Model
{
    protected $table      = 'student';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [ 
        'code', 
        'class_id', 
        'section_id', 
        'status', 
        'session_year_id', 
    ];

    public function student_details_by_id($code, $session_year_id)
    {

        if( !isset($code) || $code == '' )
            return [];

        $builder = $this->db->table('student');

        $builder->select('
            student.id,
            student.code,
            student.class_id,
            student.section_id,
            student.status as student_status,
            student.session_year_id,

            student_details.id as student_details_id,

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


            c.class_name,
            s.section_name
        ');

        // Main relation: main_students.id = student_details.student_id
        $builder->join('student_details', 'student_details.student_id = student.id', 'left');

        $builder->join('class c', 'c.id = NULLIF(student_details.class_id, \'\')::integer', 'left');
        $builder->join('section s', 's.id = NULLIF(student_details.section_id, \'\')::integer', 'left');

        // where conditions
        //$builder->where('student.id', $student_id);
        $builder->where('student.status', 1);
        $builder->where('student.session_year_id', $session_year_id);
        $builder->where('student.code', $code);

        $query = $builder->get();
        // pr($this->db->getLastQuery());

        return $query->getRowArray();
    }

    public function get_admsn_bus_date($code,$session_year_id)
    {

        $builder = $this->db->table('student_details');

        $builder->join('student_transport_financial', 'student_transport_financial.student_id = student_details.student_id', 'left');

        $builder->select('student_details.admission_date, student_transport_financial.stoppage, student_transport_financial.bus_alloted_date');
        $builder->where('code', $code);
        $builder->where('session_year_id', $session_year_id);

        return $builder->get()->getRowArray();
    }

    public function get_student_details_by_id($code, $session_year_id)
    {

        if( !isset($code) || $code == '' )
            return [];

        $builder = $this->db->table('student');

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
            student_academic_history.migration_date AS migration_date,

            c.class_name,
            s.section_name,
            au.first_name || \' \' || au.last_name AS teacher_full_name,
            TO_CHAR(student_details.admission_date, \'Mon FMDD YYYY\') AS admissiondate
        ');

        // Main relation: main_students.id = student_details.student_id
        $builder->join('student_details', 'student_details.student_id = student.id', 'left');

        // student_details.student_id = all other tables student_id
        $builder->join('student_academic_history', 'student_academic_history.student_id = student.id', 'left');
        $builder->join('student_documents', 'student_documents.student_id = student.id', 'left');
        $builder->join('student_elective_subjects', 'student_elective_subjects.student_id = student.id', 'left');
        $builder->join('student_parents_guardians', 'student_parents_guardians.student_id = student.id', 'left');
        $builder->join('student_personal_details', 'student_personal_details.student_id = student.id', 'left');
        $builder->join('student_transport_financial', 'student_transport_financial.student_id = student.id', 'left');

        $builder->join('class c', 'c.id = NULLIF(student_details.class_id, \'\')::integer', 'left');
        $builder->join('section s', 's.id = NULLIF(student_details.section_id, \'\')::integer', 'left');
        $builder->join('admin_users au', 'au.id = s.teacher_id', 'left');

        // where conditions
        //$builder->where('student.id', $student_id);
        $builder->where('student.status', 1);
        $builder->where('student.session_year_id', $session_year_id);
        $builder->where('student.code', $code);

        $query = $builder->get();
        // pr($this->db->getLastQuery());

        return $query->getRowArray();
    }
    
    public function get_student_exam_date($class_id, $session_year_id)
    {

        if( !isset($class_id) || $class_id == '' )
            return [];

        $builder = $this->db->table('admission_exam_schedule');

        $builder->select('
            admission_exam_schedule.id,
            admission_exam_schedule.class_id,
            admission_exam_schedule.exam_date,
            admission_exam_schedule.exam_time,
            admission_exam_schedule.session_year_id,
            admission_exam_schedule.phase,

        ');

        $builder->where('admission_exam_schedule.status', 1);
        $builder->where('admission_exam_schedule.session_year_id', $session_year_id);
        $builder->where('admission_exam_schedule.class_id', $class_id);

        $query = $builder->get();
        // pr($this->db->getLastQuery());

        return $query->getResultArray();
    }

    public function get_students_fee_structure($code, $month_id='')
    {

        if( !isset($code) || $code == '' )
            return [];

        $builder = $this->db->table('student_fee_structure');

        $builder->select('
            student_fee_structure.id,
            student_fee_structure.student_code,
            student_fee_structure.month_id,
            student_fee_structure.admission_fee,
            student_fee_structure.development_fee,
            student_fee_structure.exam_fee,
            student_fee_structure.security_deposite,
            student_fee_structure.tuition_fee,
            student_fee_structure.payment_amount,

            student_fee_structure.festival_celebration_fee,
            student_fee_structure.games_sports_fee,
            student_fee_structure.audio_visual_lab_fee,
            student_fee_structure.library_fee,
            student_fee_structure.electricity_maintenance_fee,
            student_fee_structure.computer_fee,
            student_fee_structure.session_charges,
            student_fee_structure.bus_services,
            student_fee_structure.ad_payment_status,

        ');

        if (!empty($month_id)) { // Changed variable name from $code to $student_code
            $builder->where('student_fee_structure.month_id', $month_id);
        }

        $builder->where('student_fee_structure.student_code', $code);

        $builder->orderBy('student_fee_structure.month_id', 'ASC');

        $query = $builder->get();
        // pr($this->db->getLastQuery());

        return $query->getResultArray();
    }

    public function getAcademicPaymentsByDate(
        $session_year_id,
        $startDate,
        $endDate,
        $class_id,
        $user_id,
        $payment_mode,
        $payment_month,
        $student_code,
        $bus_user_id='',
        $date_filter_used=1
    ) {

        
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

            student_details.first_name, 
            student_details.d_o_b, 
            admin_users.first_name AS added_by_first_name, 
            admin_users.last_name  AS added_by_last_name,
            class.class_name,

            tblc.item_ids    AS tblc_item_ids,
            tblc.item_qtys   AS tblc_item_qtys,
            tblc.item_price  AS tblc_item_price,
            tblc.price       AS tblc_price,

            st.item_ids      AS stationary_item_ids,
            st.item_qtys     AS stationary_item_qtys,
            st.item_price    AS stationary_item_price,
            st.price         AS stationary_price
            SQL
        );
        /* ===== MAIN JOINS ===== */
        $builder->join(
            'student_details',
            'student_details.code = student_fee_structure.student_code',
            'left'
        );

        $builder->join(
            'class',
            "class.id = NULLIF(student_details.class_id, '')::integer",
            'left',
            false
        );

        $builder->join(
            'admin_users',
            'admin_users.id = student_fee_structure.t_user_id',
            'left'
        );

        /* ===== AGGREGATED TBLC ITEMS ===== */
        $builder->join(
            "(SELECT
                student_id,
                STRING_AGG(item_ids, ',')   AS item_ids,
                STRING_AGG(item_qtys, ',')  AS item_qtys,
                STRING_AGG(item_price, ',') AS item_price,
                SUM(price)                  AS price
              FROM student_tblc_items
              GROUP BY student_id
            ) tblc",
            'tblc.student_id = student_details.student_id',
            'left',
            false
        );

        /* ===== AGGREGATED STATIONARY ITEMS ===== */
        $builder->join(
            "(SELECT
                student_id,
                STRING_AGG(item_ids, ',')   AS item_ids,
                STRING_AGG(item_qtys, ',')  AS item_qtys,
                STRING_AGG(item_price, ',') AS item_price,
                SUM(price)                  AS price
              FROM student_stationary_items
              GROUP BY student_id
            ) st",
            'st.student_id = student_details.student_id',
            'left',
            false
        );

        /* ===== FILTERS ===== */
        // if (!empty($startDate) && !empty($endDate)) {
        //     $builder->where("DATE(student_fee_structure.created_date) >=", $startDate);
        //     $builder->where("DATE(student_fee_structure.created_date) <=", $endDate);
        // }

        if (!empty($startDate) && !empty($endDate)) {
            if( $date_filter_used == 0 ) {
                $builder->where('student_fee_structure.bus_payment_date >=', $startDate . ' 00:00:00');
                $builder->where('student_fee_structure.bus_payment_date <', date('Y-m-d', strtotime($endDate . ' +1 day')) . ' 00:00:00');
            } else {
                $builder->where('student_fee_structure.created_date >=', $startDate . ' 00:00:00');
                $builder->where('student_fee_structure.created_date <', date('Y-m-d', strtotime($endDate . ' +1 day')) . ' 00:00:00');
            }
        }

        if (!empty($class_id)) {
            $builder->where('student_details.class_id', $class_id);
        }

        // if (!empty($user_id)) {
        //     $builder->where('student_fee_structure.t_user_id', $user_id);
        // }

        if (!empty($bus_user_id)) {
            $builder->where('student_fee_structure.bus_t_user_id', $bus_user_id);
        }
        

        if (!empty($payment_mode)) {
            if ($date_filter_used == 0) {
                $builder->like('student_fee_structure.bus_payment_mode', $payment_mode);
            } else {
                $builder->like('student_fee_structure.ad_payment_mode', $payment_mode);
            }
        }

        if (!empty($payment_month)) {
            $builder->where('student_fee_structure.month_id', $payment_month);
        }

        if (!empty($student_code)) {
            $builder->where('student_fee_structure.student_code', $student_code);
        }

        $builder->where('student_details.session_year_id', $session_year_id);
        $builder->where('student_fee_structure.session_year_id', $session_year_id);
        

        // exclude invalid modes like "cash."
        // $builder->where("RIGHT(student_fee_structure.ad_payment_mode, 1) <>", '.', false);
        // $builder->where(
        //     "RIGHT(student_fee_structure.ad_payment_mode, 1) <> '.'",
        //     null,
        //     false
        // );

        // if( $date_filter_used == 0 ) {
        //     $builder->where("student_fee_structure.bus_payment_mode NOT LIKE '%.'", null, false);
        // }else {
        //     $builder->where("student_fee_structure.ad_payment_mode NOT LIKE '%.'", null, false);
        // }



        $builder->orderBy('student_fee_structure.created_date', 'ASC');

        $query = $builder->get();

        // $lastQuery = $this->db->getLastQuery();
        // pr($lastQuery);
        
        return $query->getResultArray();
    }

}