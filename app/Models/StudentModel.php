<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentModel extends Model
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

    public function ent_exam_student_list($class_id='', $session_year_id='', $ad_exam_qualified='', $form_no='', $is_admission_done='')
    {
        $builder = $this->db->table('student');

        // Join with casting using NULLIF to avoid empty string cast errors
        $builder->join('student_details', 'student_details.student_id = student.id', 'left');
        $builder->join('student_personal_details', 'student_personal_details.student_id = student.id', 'left');
        $builder->join('registration_fees', 'registration_fees.form_no = student_details.form_no', 'left');
        $builder->join('class c', 'c.id = student.class_id', 'left');
        $builder->join('student_parents_guardians spg', 'spg.student_id = student.id', 'left');
        $builder->join('student_elective_subjects ses', 'ses.student_id = student.id', 'left');
        $builder->join('student_documents sd', 'sd.student_id = student.id', 'left');

        // $builder->join('registration_fees rf', 'registration_fees.form_no = student_details.form_no', 'left');

        $builder->select('
            student.id as student_id,
            student_details.id,
            student_details.code,
            student_details.d_o_b,
            student_details.admission,
            student_details.form_no,
            student_details.rejection_reason,
            student_details.first_name,
            student_details.middle_name,
            student_details.surname,
            student_details.created_date,
            student_details.student_admit,
            student_details.ad_exam_qualified,
            student_details.image,
            c.id as class_id,
            c.class_name,
            spg.father_name,
            spg.mother_name,
            ses.last_year_marksheet,
            ses.student_admit,
            ses.student_birth_certificate,
            spg.father_id,
            spg.mother_id,
            sd.cast_certificate,
            registration_fees.reg_fee_id,
            registration_fees.payment_date,
            registration_fees.payment_type,
            registration_fees.payment_amount,
            registration_fees.pos_bank_name,
            registration_fees.pos_reference_number,
            registration_fees.payee_name,
            registration_fees.cheque_number,
            registration_fees.added_by,
            registration_fees.t_user_id,
            registration_fees.payment_status,
            student_personal_details.second_language,
        ');

        if( isset($class_id) && !empty($class_id) )
            $builder->where('student.class_id', $class_id);

        if( isset($session_year_id) && !empty($session_year_id) )
            $builder->where('student_details.session_year_id', $session_year_id);

        if( isset($ad_exam_qualified) && (!empty($ad_exam_qualified) || $ad_exam_qualified == '0') )
            $builder->where('student_details.ad_exam_qualified', $ad_exam_qualified);

        if( isset($form_no) && !empty($form_no) )
            $builder->where('student_details.form_no', $form_no);

        if( isset($is_admission_done) && $is_admission_done != '' )
            $builder->where('student_details.admission', (int) $is_admission_done);

        $query = $builder->get();

        $lastQuery = $this->db->getLastQuery();
        // echo "<pre>"; print_r($lastQuery); die();

        return $query->getResultArray();
    }

    public function getAdmittedStudentCount($classId)
    {
        $session = session();
        $session_year_id = $session->get('session_year_id');
        $session_start_date = $session->get('session_start_date');

        $y = date('y', strtotime($session_start_date)); // 2-digit year

        return $this->like('code', $y, 'after')
                    ->where('class_id', $classId)
                    ->where('session_year_id', $session_year_id)
                    ->countAllResults();
    }

    public function form_selling_report($class_id='', $payment_mode='', $start_date='', $end_date='', $user_id='', $session_year_id='', $ad_exam_qualified='', $form_no='')
    {
        $builder = $this->db->table('student');

        // Join with casting using NULLIF to avoid empty string cast errors
        $builder->join('student_details', 'student_details.student_id = student.id', 'left');
        $builder->join('student_personal_details', 'student_personal_details.student_id = student.id', 'left');
        $builder->join('registration_fees', 'registration_fees.form_no = student_details.form_no', 'left');
        $builder->join('class c', 'c.id = student.class_id', 'left');
        $builder->join('student_parents_guardians spg', 'spg.student_id = student.id', 'left');
        $builder->join('student_elective_subjects ses', 'ses.student_id = student.id', 'left');
        $builder->join('student_documents sd', 'sd.student_id = student.id', 'left');

        $builder->join('admin_users', 'admin_users.id =  CAST(student_details.created_by AS INTEGER)', 'left');

        $builder->select('
            student.id as student_id,
            student_details.id,
            student_details.code,
            student_details.d_o_b,
            student_details.admission,
            student_details.form_no,
            student_details.rejection_reason,
            student_details.first_name,
            student_details.middle_name,
            student_details.surname,
            student_details.created_date,
            student_details.student_admit,
            student_details.ad_exam_qualified,
            student_details.image,
            student_details.created_by,
            admin_users.first_name || \' \' || admin_users.last_name AS collected_by_full_name,
            c.id as class_id,
            c.class_name,
            spg.father_name,
            spg.mother_name,
            ses.last_year_marksheet,
            ses.student_admit,
            ses.student_birth_certificate,
            spg.father_id,
            spg.mother_id,
            sd.cast_certificate,
            registration_fees.reg_fee_id,
            registration_fees.payment_date,
            registration_fees.payment_type,
            registration_fees.payment_amount,
            registration_fees.pos_bank_name,
            registration_fees.pos_reference_number,
            registration_fees.payee_name,
            registration_fees.cheque_number,
            registration_fees.added_by,
            registration_fees.t_user_id,
            registration_fees.payment_status,
            student_personal_details.second_language,
            SUM(CAST(registration_fees.payment_amount AS numeric)) OVER () AS total_payment
        ');

        if( isset($class_id) && $class_id == 'all' ) 
            $class_id = '';

        if( isset($class_id) && !empty($class_id) )
            $builder->where('student.class_id', $class_id);

        if( isset($payment_mode) && !empty($payment_mode) )
            $builder->where('registration_fees.payment_type', $payment_mode);

        if( isset($user_id) && !empty($user_id) )
            $builder->where('registration_fees.t_user_id', $user_id);

        if( isset($session_year_id) && !empty($session_year_id) )
            $builder->where('student_details.session_year_id', $session_year_id);

        if( isset($ad_exam_qualified) && !empty($ad_exam_qualified) )
            $builder->where('student_details.ad_exam_qualified', $ad_exam_qualified);

        if( isset($form_no) && !empty($form_no) )
            $builder->where('student_details.form_no', $form_no);

        if (!empty($start_date) && !empty($end_date)) {
            $builder->where('DATE(registration_fees.payment_date) >=', $start_date)
                    ->where('DATE(registration_fees.payment_date) <=', $end_date);
        }

        $builder->where('student_details.status', 1);

        $query = $builder->get();

        $lastQuery = $this->db->getLastQuery();
        // echo "<pre>"; print_r($lastQuery); die();

        return $query->getResultArray();
    }

    public function get_student_details_by_id($student_id)
    {

        if( !isset($student_id) || $student_id == '' )
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
            s.section_name
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

        // where conditions
        $builder->where('student.id', $student_id);
        $builder->where('student.status', 1);
        $builder->where('student.session_year_id', session()->get('session_year_id'));

        $query = $builder->get();
        // pr($this->db->getLastQuery());

        return $query->getRowArray();
    }

    public function getStudentsForIdCard($class_id, $section_id, $student_code)
    {
        $builder = $this->db->table('student');

        $builder->select([
            'student.id',
            'student.code AS student_code',
            'student.class_id',
            'student.section_id',
            'student.session_year_id',
            'student_details.id as student_details_id',
            'student_details.shift',
            'student_details.form_no',
            'student_details.bs_id',
            'student_details.stream_id',
            'student_details.class_id as details_class_id', // Added alias to avoid conflict
            'student_details.section_id as details_section_id', // Added alias to avoid conflict
            'student_details.roll_num',
            'student_details.first_name',
            'student_details.middle_name',
            'student_details.surname',
            'student_details.d_o_b',
            'student_details.gender',
            'student_details.blood_grp',
            'student_details.caste',
            'student_details.image',
            'student_details.aadhaar_no',
            'student_details.admission_number',
            'student_details.admission_date',
            'student_details.school_house_id',
            'student_details.promotion',
            'student_details.academic_status',
            'student_details.tc_date',
            'student_details.admission',
            'student_details.status as details_status', // Added alias to avoid conflict
            'student_details.created_by',
            'student_details.created_date',
            'student_details.session_year_id as details_session_year_id', // Added alias to avoid conflict
            'student_details.session_result_status',
            'student_details.ad_exam_qualified',
            'student_details.rejection_reason',
            'student_details.fail_consideration',
            'student_details.fail_cons_remarks',
            'student_details.relative',
            'student_details.relative_name',
            'student_details.relative_code',
            'student_details.relationship',
            'student_details.comment',
            'student_details.student_admit',
            'student_details.tc_required',
            'student_details.tc_no',
            'student_details.pen_no',
            'student_details.appar_id',

            'student_parents_guardians.mothers_is_gurgent',
            'student_parents_guardians.father_name',
            'student_parents_guardians.mother_name',

            'student_personal_details.permanent_address',
        ]);

        $builder->join('student_details', 'student_details.student_id = student.id', 'left');
        $builder->join('student_parents_guardians', 'student_parents_guardians.student_id = student.id', 'left');
        $builder->join('student_personal_details', 'student_personal_details.student_id = student.id', 'left');


        // Mandatory conditions
        $builder->where('student.class_id', $class_id);
        $builder->where('student.status', 1); // active only
        $builder->where('student.session_year_id', session('session_year_id'));

        // Optional filters
        if (!empty($section_id)) {
            $builder->where('student.section_id', $section_id);
        }

        if (!empty($student_code)) { // Changed variable name from $code to $student_code
            $builder->where('student.code', $student_code);
        } else {
            $builder->where('student.code !=', '');
        }

        $builder->orderBy('student.code', 'ASC');

        // return $builder->get()->getResultArray();

        $query = $builder->get();
        // pr($this->db->getLastQuery());

        return $query->getResultArray();
    }

    public function promoted_student_list($class_id, $section_id){
        $session_year_id = session()->get('session_year_id');
        $where_in = ['Bonafide', 'Free'];

        $builder = $this->db->table('student');
        $builder->select('
            student.id as studentID,
            student.code as studentCode,
            student.class_id as studentClassId,
            student.section_id as studentSectionId,
            student.status as studentStatus,
            student_details.*, 
            class.class_name,
            admin_users.first_name as created_by_first_name,
            admin_users.last_name as created_by_last_name,
            section.section_name,
            student_parents_guardians.father_name,
            student_parents_guardians.mother_name
        ');

        $builder->join('student_details', 'student_details.student_id = student.id', 'left');
        $builder->join('class', 'class.id = student.class_id', 'left');
        $builder->join('admin_users', 'admin_users.id = CAST(student_details.created_by AS INTEGER)', 'left');
        $builder->join('section', 'section.id = student.section_id', 'left');
        $builder->join('student_parents_guardians', 'student_parents_guardians.student_id = student.id', 'left');
        $builder->join(
            'student_fee_structure',
            "student_fee_structure.student_code = student.code
             AND student_fee_structure.month_id = 4
             AND student_fee_structure.ad_payment_status = 1
             AND student_fee_structure.session_year_id = $session_year_id",
            'inner',
            false
        );

        $builder->where('student.session_year_id', $session_year_id);
        $builder->where('student.class_id', $class_id);
        $builder->where('student.section_id', $section_id);
        $builder->whereIn('student_details.academic_status', $where_in);

        $builder->orderBy('student_details.first_name', 'ASC');

        $query = $builder->get();
        // pr($this->db->getLastQuery());

        return $query->getResultArray();
    }

    public function readmission_student_list_check($class_id, $section_id, $nextSessionYearId)
    {
        $session_year_id = session()->get('session_year_id');

        $builder = $this->db->table('student as s');

        $builder->select('
            s.id as studentID,
            s.code as studentCode,
            s.class_id as studentClassId,
            s.section_id as studentSectionId,
            s.status as studentStatus,

            sd.first_name,
            sd.middle_name,
            sd.surname,
            sd.roll_num,
            sd.d_o_b,
            sd.session_result_status
        ');

        $builder->join('student_details sd', 'sd.student_id = s.id', 'left');
        $builder->join('class c', 'c.id = s.class_id', 'left');
        $builder->join('section sec', 'sec.id = s.section_id', 'left');

        // 👇 Join same student table for NEXT session check
        if (!empty($nextSessionYearId)) {
            $builder->join(
                'student as s_next',
                's_next.code = s.code AND s_next.session_year_id = '.$this->db->escape($nextSessionYearId),
                'left'
            );
        }

        // ✅ Current session students only
        $builder->where('s.session_year_id', $session_year_id);

        // ✅ Exclude students already in next session
        if (!empty($nextSessionYearId)) {
            $builder->where('s_next.id IS NULL', null, false);
        }

        // ✅ Class & section filter
        $builder->where('s.class_id', $class_id);
        $builder->where('s.section_id', $section_id);

        $builder->orderBy('sd.first_name', 'ASC');

        $query = $builder->get();
        // pr($this->db->getLastQuery());

        return $query->getResultArray();
    }

    public function readmission_student_list($class_id, $section_id)
    {
        $session_year_id = session()->get('session_year_id');

        $builder = $this->db->table('student_details');

        $builder->select('
            student_details.code,
            student_details.first_name,
            student_details.middle_name,
            student_details.surname,
            student_details.class_id,
            student_details.section_id,
            student_details.roll_num,
            student_details.d_o_b,
            student_details.session_result_status
        ');

        $builder->join('student', 'student.id = student_details.student_id', 'left');
        $builder->join('class', 'class.id = CAST(student_details.class_id AS INTEGER)', 'left');
        $builder->join('section', 'section.id = CAST(student_details.section_id AS INTEGER)', 'left');

        // ✅ Current session students only
        $builder->where('student_details.session_year_id', $session_year_id);

        // ✅ Class & section filter
        $builder->where('student_details.class_id', $class_id);
        $builder->where('student_details.section_id', $section_id);

        $builder->orderBy('student_details.first_name', 'ASC');

        $query = $builder->get();
        // pr($this->db->getLastQuery());

        return $query->getResultArray();
    }

    public function next_session_years_student_delete_by_class($next_id, $code)
    {
        $builder = $this->db->table('student');
        $builderDetails = $this->db->table('student_details');
        $builderFeeStructure = $this->db->table('student_fee_structure');
        $builderAcademicHistory = $this->db->table('student_academic_history');

        $builderDocuments = $this->db->table('student_documents');
        $builderElectiveSubjects = $this->db->table('student_elective_subjects');
        $builderParentsGuardians = $this->db->table('student_parents_guardians');
        $builderPersonalDetails = $this->db->table('student_personal_details');
        $builderTransportFinancial = $this->db->table('student_transport_financial');

        // 1️⃣ Check if student exists
        // $exists = $builder->where('session_year_id', $next_id)->where('code', $code)->countAllResults();
        $exists = $builder->where('session_year_id', $next_id)->where('code', $code)->get()->getRowArray();
        $existsStudentId = $exists['id'] ?? '';
        
        // pr($exists);
        if( !empty($exists) ) {
            // student
            $builder->where('session_year_id', $next_id)->where('code', $code)->delete();

            $existsDetails = $builderDetails->where('session_year_id', $next_id)->where('code', $code)->countAllResults();
            if ($existsDetails > 0) {
                $builderDetails->where('session_year_id', $next_id)->where('code', $code)->delete();
            }
            
            $existsAcademicHistory = $builderAcademicHistory->where('student_id', $existsStudentId)->where('student_code', $code)->countAllResults();
            if ($existsAcademicHistory > 0) {
                $builderAcademicHistory->where('student_id', $existsStudentId)->where('student_code', $code)->delete();
            }

            // student_documents
            $existsDocuments = $builderDocuments->where('student_id', $existsStudentId)->where('student_code', $code)->countAllResults();
            if ($existsDocuments > 0) {
                $builderDocuments->where('student_id', $existsStudentId)->where('student_code', $code)->delete();
            }

            // student_elective_subjects
            $existsElectiveSubjects = $builderElectiveSubjects->where('student_id', $existsStudentId)->where('student_code', $code)->countAllResults();
            if ($existsElectiveSubjects > 0) {
                $builderElectiveSubjects->where('student_id', $existsStudentId)->where('student_code', $code)->delete();
            }

            // student_parents_guardians
            $existsParentsGuardians = $builderParentsGuardians->where('student_id', $existsStudentId)->where('student_code', $code)->countAllResults();
            if ($existsParentsGuardians > 0) {
                $builderParentsGuardians->where('student_id', $existsStudentId)->where('student_code', $code)->delete();
            }

            // student_personal_details
            $existsPersonalDetails = $builderPersonalDetails->where('student_id', $existsStudentId)->where('student_code', $code)->countAllResults();
            if ($existsPersonalDetails > 0) {
                $builderPersonalDetails->where('student_id', $existsStudentId)->where('student_code', $code)->delete();
            }

            // student_transport_financial
            $existsTransportFinancial = $builderTransportFinancial->where('student_id', $existsStudentId)->where('student_code', $code)->countAllResults();
            if ($existsTransportFinancial > 0) {
                $builderTransportFinancial->where('student_id', $existsStudentId)->where('student_code', $code)->delete();
            }

            $existsFeeStructure = $builderFeeStructure->where('session_year_id', $next_id)->where('student_code', $code)->countAllResults();
            if ($existsFeeStructure > 0) {
                $builderFeeStructure->where('session_year_id', $next_id)->where('student_code', $code)->delete();
            }
        }
    }

    public function get_student_to_be_promoted($class_id, $session_year_id, $code)
    {
        $builder = $this->db->table('student');
        $builder->select('
            student.id as studentID,
            student.code as studentCode,
            student.class_id as studentClassId,
            student.section_id as studentSectionId,
            student.status as studentStatus,
            student_details.*, 
            class.class_name,
            section.section_name,
            student_parents_guardians.father_name,
            student_parents_guardians.mother_name
        ');

        $builder->join('student_details', 'student_details.student_id = student.id', 'left');
        $builder->join('class', 'class.id = student.class_id', 'left');
        $builder->join('section', 'section.id = student.section_id', 'left');

        $builder->join('student_academic_history', 'student_academic_history.student_id = student.id', 'left');
        $builder->join('student_documents', 'student_documents.student_id = student.id', 'left');
        $builder->join('student_elective_subjects', 'student_elective_subjects.student_id = student.id', 'left');
        $builder->join('student_parents_guardians', 'student_parents_guardians.student_id = student.id', 'left');
        $builder->join('student_personal_details', 'student_personal_details.student_id = student.id', 'left');
        $builder->join('student_transport_financial', 'student_transport_financial.student_id = student.id', 'left');

        $builder->where('student.class_id', $class_id);
        $builder->where('student.session_year_id', $session_year_id);
        $builder->where('student.code', $code);
        $builder->where('student.status', 1);

        $query = $builder->get();
        // pr($this->db->getLastQuery());

        return $query->getRowArray();
    }

    public function copy_student_data(int $id, int $classId, int $sectionId, int $sessionId)
    {
        // 1️⃣ Fetch old record
        $student = $this->find($id);

        if (!$student) {
            return false;
        }

        // 2️⃣ Remove primary key (VERY IMPORTANT)
        unset($student['id']);

        // 3️⃣ Override required fields
        $student['class_id']        = $classId;
        $student['section_id']      = $sectionId;
        $student['session_year_id'] = $sessionId;
        
        // 4️⃣ Insert copied record
        $this->insert($student);

        // 5️⃣ Return new ID
        return $this->getInsertID();
    }
}