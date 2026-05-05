<?php
namespace App\Controllers\Admin;
use DateTime;
use DatePeriod;
use DateInterval;
use Mpdf\Mpdf;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\StudentModel;
use App\Models\StudentDetailsModel;
use App\Models\ConfigurationModel;
use App\Models\RegistrationFeesModel;
use App\Models\StoppageMasterModel;
use App\Models\BusMasterModel;
use App\Models\BusToStoppageModel;
use App\Models\ItemMasterModel;
use App\Models\SectionModel;
use App\Models\SessionYearModel;
use App\Models\TblcMasterModel;
use App\Models\StudentTransportFinancialModel;
use App\Models\StudentTransactionModel;

use App\Models\StudentTblcItemsModel;
use App\Models\StudentStationaryItemsModel;
use App\Models\StudentFeeStructureModel;
use App\Models\AdminUserModel;
use App\Models\StudentFeeInvoiceModel;
use App\Models\ReligionModel;
use App\Models\StudentPersonalDetailsModel;
use App\Models\StudentParentsGuardiansModel;
use App\Models\StudentElectiveSubjectsModel;
use App\Models\StudentDocumentsModel;
use App\Models\StudentAcademicHistoryModel;
use App\Models\FeesStructureMasterModel;
use App\Models\StoppageFareMasterModel;
use App\Models\PaymentOrderModel;



class Student extends BaseController
{
    protected $session;
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // echo 'Old is gold';
    }

    public function entrance_exam_student_list() 
    {
        $data['title'] = "Entrance Exam Student List";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $configurationModel = new ConfigurationModel();

        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();
        $data['admission_reg_fee'] = $configurationModel->get_configuration_by_key('admission_registration_fee');

        $data['f_name'] = $this->session->get('f_name');
        $data['user_id'] = $this->session->get('user_id');

        echo view('admin/student/entrance-exam-student-list', $data);  

        echo view('admin/common/footer', $data);

        // $data['class_list'] = $this->student_model->get_all_list('class');
        // $data['stream_list'] = $this->student_model->stream_list();
        // $data['admission_reg_fee'] = $this->configuration_model->get_configuration_by_key('admission_registration_fee');
        // $this->load->view('entrance_exam_student_list', $data);
    }

    function ajax_request_ent_exam_student_list()
    {
        $studentModel = new StudentModel();
        $classModel = new ClassModel();

        $class_id = $this->request->getPost('class_id');
        $ad_exam_qualified = $this->request->getPost('ad_exam_qualified') ?? '';
        if( !isset($class_id) || $class_id == '' ) {
            return $this->response->setJSON(['student_list' => [], 'class_list' => []]);
        }

        $get_session_year_id = $this->session->get('session_year_id');

        $student_list = $studentModel->ent_exam_student_list($class_id, $get_session_year_id, $ad_exam_qualified);
        $class_list = $classModel->orderBy('id', 'ASC')->findAll();

        return $this->response->setJSON(['student_list' => $student_list, 'class_list' => $class_list]);
    }

    function ajax_request_add_reg_payment()
    {
        $data = [];
        $data = $this->request->getPost();
        
        $registrationFeesModel = new RegistrationFeesModel();
        $result = $registrationFeesModel->add_reg_payment($data);

        if( $result ) {
            $studentDetailsModel = new StudentDetailsModel();
            $form_no = ($data['form_no']) ?? '';
            $update_data['ad_exam_qualified'] = 4;
            $studentDetailsModel
                ->where('form_no', $form_no)
                ->set($update_data)
                ->update();
        }

        echo $result;
    }

    function entrance_exam_student_action()
    {
        // Get all POST data from the AJAX request
        $postData = $this->request->getPost();

        if (empty($postData)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No data received.'
            ]);
        }

        // Loop through each field and update accordingly
        foreach ($postData as $key => $value) {
            // Example input names: result_5 or reject_reason_5
            if (strpos($key, 'result_') === 0) {
                $id = str_replace('result_', '', $key);
                $result = $value;
                $reason = $postData['reject_reason_' . $id] ?? null;

                // Save/update the student record
                // $studentModel->update($id, [
                //     'ad_exam_qualified' => $result,
                //     'rejection_reason' => $reason,
                //     'updated_at' => date('Y-m-d H:i:s')
                // ]);
            }
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'All data saved successfully.'
        ]);

        echo "<pre>"; print_r($postData); die();
    }

    function ajax_save_admisssion_student_details()
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request method.'
            ]);
        }
        // return $this->response->setJSON([
        //     'status' => 'success',
        //     'message' => 'Data updated successfully.',
        //     'data' => $this->request->getPost()
        // ]);
        $totalstudent = $this->request->getPost('totalstudent');
        $formData = $this->request->getPost('formData');
        $session_year_id = $this->session->get('session_year_id');

        $studentDetailsModel = new StudentDetailsModel();
        $result = $studentDetailsModel->update_entrance_exam_result($totalstudent, $formData, $session_year_id);

        if ($result > 0) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data updated successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request method.'
            ]);
        }
        
        // echo "<pre>"; print_r($totalstudent); 
        // echo "<pre>"; print_r($formData); 
        // die();
    }

    function entrance_exam_eligible_student_list()
    {
        $data['title'] = "Entrance Exam Eligible Student List";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $configurationModel = new ConfigurationModel();

        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();
        $data['admission_reg_fee'] = $configurationModel->get_configuration_by_key('admission_registration_fee');

        $data['f_name'] = $this->session->get('f_name');
        $data['user_id'] = $this->session->get('user_id');

        echo view('admin/student/entrance-exam-eligible-student-list', $data);  

        echo view('admin/common/footer', $data);
    }

    function ajax_request_eligible_exam_student_list()
    {
        $studentModel = new StudentModel();
        $classModel = new ClassModel();

        $class_id = $this->request->getPost('class_id');
        if( !isset($class_id) || $class_id == '' ) {
            return $this->response->setJSON(['student_list' => [], 'class_list' => []]);
        }

        if( isset($class_id) && $class_id == 'all' ) {
            $class_id = '';
        }

        $get_session_year_id = $this->session->get('session_year_id');

        $student_list = $studentModel->ent_exam_student_list($class_id, $get_session_year_id, '3');
        $class_list = $classModel->orderBy('id', 'ASC')->findAll();

        return $this->response->setJSON(['student_list' => $student_list, 'class_list' => $class_list]);
    }

    function entrance_exam_eligible_for_admission_student_list()
    {
        $data['title'] = "Entrance Exam Student List";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $configurationModel = new ConfigurationModel();

        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();
        $data['admission_reg_fee'] = $configurationModel->get_configuration_by_key('admission_registration_fee');

        $data['f_name'] = $this->session->get('f_name');
        $data['user_id'] = $this->session->get('user_id');

        echo view('admin/student/eligible-for-admission-student-list', $data);  

        echo view('admin/common/footer', $data);
    }

    function ajax_request_ent_exam_eli_student_list()
    {
        $studentModel = new StudentModel();
        $classModel = new ClassModel();

        $class_id = $this->request->getPost('class_id');
        $form_no = $this->request->getPost('student_form_no');
        $is_admission_done = $this->request->getPost('is_admission_done');
        if( !isset($class_id) || $class_id == '' ) {
            return $this->response->setJSON(['student_list' => [], 'class_list' => []]);
        }

        if( isset($class_id) && $class_id == 'all' ) {
            $class_id = '';
        }

        $get_session_year_id = $this->session->get('session_year_id');

        $student_list = $studentModel->ent_exam_student_list($class_id, $get_session_year_id, '1', $form_no, $is_admission_done);
        $class_list = $classModel->orderBy('id', 'ASC')->findAll();

        return $this->response->setJSON(['student_list' => $student_list, 'class_list' => $class_list]);
    }

    function collect_admission_fee($student_id)
    {
        $studentDetailsModel = new StudentDetailsModel();
        $studentDetailsFormNo = $studentDetailsModel->select('form_no')->where('id', (int)$student_id)->first();
        // echo "<pre>"; print_r($this->session->get()); die();

        $data['title'] = "Admission Fees Collect";
        $data['form_no'] = $form_no = $studentDetailsFormNo['form_no'] ?? '';
        $data['dept_id'] = $this->session->get('dept_id');
        $data['session_year_id'] = $this->session->get('session_year_id');
        $get_session_year_id = $this->session->get('session_year_id');

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $stoppageMasterModel = new StoppageMasterModel();
        
        $busToStoppageModel = new BusToStoppageModel();
        $itemMasterModel = new ItemMasterModel();
        $sectionModel = new SectionModel();
        $sessionYearModel = new SessionYearModel();
        $tblcMasterModel = new TblcMasterModel();

        $data['form_details'] = $studentDetailsModel->get_reg_details($form_no, $get_session_year_id);
        if(isset($data['form_details']['admission']) && $data['form_details']['admission'] == 1){
            return redirect()->to(base_url('dashboard'));
        }

        $class_id = '';
        $stoppage_id = '';
        /*echo "<pre>"; print_r($data['form_details']); 
        echo "<pre>"; print_r($data['form_details']); 
        die();*/

        if(!empty($data['form_details'])){
            $class_id = $data['form_details']['class_id'] ?? '';
            $stoppage_id = $data['form_details']['stoppage'] ?? '';
            
            $data['stoppage_list'] = $stoppageMasterModel->get_stoppages();
            $data['bus_list'] = $busToStoppageModel->get_bus_list_by_stoppage($stoppage_id);
            $data['stationary_total_price'] = $itemMasterModel->get_total_price_stn_by_class($class_id, $get_session_year_id);
            $data['section_list'] = $sectionModel->get_section_class_id($class_id, $get_session_year_id);
            $data['current'] = $sessionYearModel->getCurrentSessionId();
            $data['stoppage_fare'] = $stoppage_id ? stoppage_fee_by_id($stoppage_id) : 0;

            $sec_lang = "Bengali";
            $data['tblc_list'] = $tblcMasterModel
                ->where('class_id', $class_id)
                ->where('sec_lang', $sec_lang)
                ->where('session_year_id', $get_session_year_id)
                ->where('status', 1)
                ->findAll();

            $data['stationary_item_list'] = $itemMasterModel
                ->where('class_id', $class_id)
                ->where('sec_lang', $sec_lang)
                ->where('session_year_id', $get_session_year_id)
                ->where('status', 1)
                ->findAll();
        }
        // echo "<pre>"; print_r($data); die();
 
        echo view('admin/student/admission-fees-collect', $data);  
        echo view('admin/common/footer', $data);
    }
    
    function edit_student($student_id)
    {
        $data['title'] = "Edit Student";
        $data['student_id'] = $student_id;

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $classModel = new ClassModel();
        $stoppageMasterModel = new StoppageMasterModel();
        $religionModel = new ReligionModel();
        $sessionYearModel = new SessionYearModel();

        $data['class'] = $classModel->orderBy('id', 'ASC')->findAll();
        $data['stoppage_list'] = $stoppageMasterModel->where('status', 1)->orderBy('stoppage_name', 'ASC')->findAll();
        $data['religion_list'] = $religionModel->orderBy('id', 'ASC')->findAll();
        $data['session_year'] = $sessionYearModel->orderBy('id', 'ASC')->findAll();
        
        $studentModel = new StudentModel();
        $student_details = $studentModel->get_student_details_by_id($student_id);
        if (empty($student_details)) {
            return redirect()->to('admin/student/student-list');
        }

        $data['student_details'] = $student_details;
        $student_code = $student_details['code'] ?? '';

        $studentFeeStructureModel = new StudentFeeStructureModel();
        $result = $studentFeeStructureModel
            ->where('session_year_id', $this->session->get('session_year_id'))
            ->where('student_code', $student_code)
            ->where('month_id', 4)
            ->where('ad_payment_status', 1)
            ->first();
        $monthFourPaymentDate = $result['created_date'] ?? '';
        $data['created_date'] = $monthFourPaymentDate;

        // pr($data);
        // echo"<pre>";print_r($data);exit;
        echo view('admin/student/edit-student', $data);  

        echo view('admin/common/footer', $data);
    }

    function update_student($student_id)
    {
        $studentDetailsModel = new StudentDetailsModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();

        $get_session_year_id = $this->session->get('session_year_id');
        $get_user_id = $this->session->get('user_id');
        $student_code = $this->request->getPost('student_code') ?? '';

        $validationRules = [
            'first_name' => 'required',
            'gender' => 'required',
            'd_o_b' => 'required',
            'class_id' => 'required',
            'father_name' => 'required',
            'lkg_onw_sec_lang' => 'required',
            'father_mobile' => 'required',
            'mother_name' => 'required',
            'mother_mobile' => 'required',
            'permanent_address' => 'required',
            'shift' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $lastestFormNo = $this->request->getPost('form_no');

        if( $this->request->getPost('academic_status') == "Free") {
            $getFirstMonthFee = $studentFeeStructureModel->getFirstMonthFee($student_code);
            

            if( isset($getFirstMonthFee['ad_payment_status']) && $getFirstMonthFee['ad_payment_status'] == 1 ) {
                // print_r("expression"); die();
                return redirect()->back()->with('error', "You cannot change the student academic status to 'Free' because their first month payment has already been completed.");
            } else {
                // print_r("noe"); die();
            }
        }

        // === STUDENT DETAILS TABLE ===
        $studentDetailsTableData = [
            'bs_id' => $this->request->getPost('bs_id') ?? '',
            'class_id' => $this->request->getPost('class_id') ?? 0,
            'first_name' => $this->request->getPost('first_name') ?? '',
            'd_o_b' => $this->request->getPost('d_o_b') ?? '',
            'gender' => $this->request->getPost('gender') ?? '',
            'blood_grp' => $this->request->getPost('blood_grp') ?? '',
            'caste' => $this->request->getPost('caste') ?? '',
            'aadhaar_no' => $this->request->getPost('aadhaar_no') ?? '',
            'academic_status' => $this->request->getPost('academic_status') ?? 'Bonafide',
            'tc_required' => $this->request->getPost('tc_required') ?? '',
            'tc_no' => $this->request->getPost('pre_school_tc_no') ?? '',
            'pen_no' => $this->request->getPost('pen_no') ?? '',
            'appar_id' => $this->request->getPost('appar_id') ?? '',
            'shift' => $this->request->getPost('shift') ?? '',
            'admission_number' => $this->request->getPost('admission_number') ?? '',
            'updated_by' => $get_user_id,
            'updated_date' => date('Y-m-d'),
            'session_year_id' => $get_session_year_id,
            'session_result_status' => $this->request->getPost('session_result_status') ?? 0,
        ];

        if( $this->request->getPost('academic_status') == "Free") {
            $studentDetailsTableData['academic_status_free_updated_by'] = $get_user_id;
            $studentDetailsTableData['academic_status_free_updated_at'] = date('Y-m-d h:i:s');
        }

        $tcDate = $this->request->getPost('pre_school_tc_date');
        if (null !== $tcDate && $tcDate !== '') {
            $studentDetailsTableData['tc_date'] = $tcDate;
        }

        $imagePath = null;
        if ($this->request->getFile('userfile') && $this->request->getFile('userfile')->isValid()) {
            $imagePath = $this->getUploadedFilePath('userfile', $lastestFormNo);
        }
        if ($imagePath) {
            $studentDetailsTableData['image'] = $imagePath;
        }

        $studentPersonalDetailsData = [
            'mother_language' => $this->request->getPost('mother_tongue') ?? '',
            'second_language' => $this->request->getPost('lkg_onw_sec_lang') ?? '',
            'medical_condition' => $this->request->getPost('medical_condition') ?? '',
            'immunization' => $this->request->getPost('immunization') ?? '',
            'only_child' => $this->request->getPost('only_child') ?? '',
            'religion' => $this->request->getPost('religion') ?? 0,
            'nationality' => $this->request->getPost('nationality') ?? '',
            'bpl' => $this->request->getPost('bpl') ?? 0,
            'bpl_number' => $this->request->getPost('bpl_number') ?? '',
            'lkg_onw_sec_lang' => $this->request->getPost('lkg_onw_sec_lang') ?? '',
            'std_three_sec_lang' => $this->request->getPost('std_three_sec_lang') ?? '',
            'telephone_resi' => $this->request->getPost('telephone_resi') ?? '',
            'pincode' => $this->request->getPost('pincode') ?? '',
            'permanent_address' => $this->request->getPost('permanent_address') ?? '',
            'email' => $this->request->getPost('email') ?? '',
        ];

        $studentParentsGuardiansData = [
            // 'father_id' => $this->getUploadedFilePath('father_id', $lastestFormNo) ?? '',
            // 'mother_id' => $this->getUploadedFilePath('mother_id', $lastestFormNo) ?? '',
            'father_name' => $this->request->getPost('father_name') ?? '',
            'father_occupation' => $this->request->getPost('father_occupation') ?? '',
            'father_mobile' => $this->request->getPost('father_mobile') ?? null,
            'father_annual_income' => $this->request->getPost('father_annual_income') ?? '',
            'father_aadhaar_no' => $this->request->getPost('father_aadhaar_no') ?? '',         
            'mother_name' => $this->request->getPost('mother_name') ?? '',
            'mother_occupation' => $this->request->getPost('mother_occupation') ?? '',
            'mother_mobile' => $this->request->getPost('mother_mobile') ?? null,
            'mother_annual_income' => $this->request->getPost('mother_annual_income') ?? '',
            'mother_aadhaar_no' => $this->request->getPost('mother_aadhaar_no') ?? '',
            'local_guar_name' => $this->request->getPost('local_guar_name') ?? '',
            'local_guar_occupation' => $this->request->getPost('local_guar_occupation') ?? '',
            'local_guar_stu_relation' => $this->request->getPost('local_guar_stu_relation') ?? '',
            'local_guar_gender' => $this->request->getPost('local_guar_gender') ?? '',
            'local_guar_annual_income' => $this->request->getPost('local_guar_annual_income') ?? '',
            'local_guar_aadhaar_no' => $this->request->getPost('local_guar_aadhaar_no') ?? '',
            'local_guar_phone' => $this->request->getPost('local_guar_phone') ?? '',
            'local_guar_address' => $this->request->getPost('local_guar_address') ?? '',
            'family_earn_memb' => $this->request->getPost('family_earn_memb') ?? '',
            'dependent' => $this->request->getPost('dependent') ?? '',
        ];

        $studentElectiveSubjectsData = [
            'student_code' => $this->request->getPost('student_code') ?? '',
            'first_elective_sub' => $this->request->getPost('first_elective_sub') ?? '',
            'second_elective_sub' => $this->request->getPost('second_elective_sub') ?? '',
            'third_elective_sub' => $this->request->getPost('third_elective_sub') ?? '',
            'fourth_elective_sub' => $this->request->getPost('fourth_elective_sub') ?? '',
            'fifth_elective_sub' => $this->request->getPost('fifth_elective_sub') ?? '',
            'sixth_elective_sub' => $this->request->getPost('sixth_elective_sub') ?? '',

            // 'last_year_marksheet' => $this->getUploadedFilePath('sixth_elective_sub', $lastestFormNo) ?? '',
            // 'student_birth_certificate' => $this->getUploadedFilePath('student_id', $lastestFormNo) ?? '', // For birth certificate
            // 'student_admit' => $this->getUploadedFilePath('student_admit', $lastestFormNo) ?? '',
            // 'father_id' => $this->getUploadedFilePath('father_id', $lastestFormNo) ?? '', // Father's Id Proof
            // 'mother_id' => $this->getUploadedFilePath('mother_id', $lastestFormNo) ?? '', // Mother's Id Proof
            // 'cast_certificate' => $this->getUploadedFilePath('cast_certificate', $lastestFormNo) ?? '', // Cast Certificate (Student / Father)
        ];

        $fatherIdPath = null;
        $motherIdPath = null;
        // Father ID
        if ($this->request->getFile('father_id') && $this->request->getFile('father_id')->isValid()) {
            $fatherIdPath = $this->getUploadedFilePath('father_id', $lastestFormNo);
        }

        // Mother ID
        if ($this->request->getFile('mother_id') && $this->request->getFile('mother_id')->isValid()) {
            $motherIdPath = $this->getUploadedFilePath('mother_id', $lastestFormNo);
        }

        if ($fatherIdPath) {
            $studentParentsGuardiansData['father_id'] = $fatherIdPath;
            $studentElectiveSubjectsData['father_id'] = $fatherIdPath;
        }

        if ($motherIdPath) {
            $studentParentsGuardiansData['mother_id'] = $motherIdPath;
            $studentElectiveSubjectsData['mother_id'] = $motherIdPath;
        }


        // Last year marksheet
        if ($this->request->getFile('last_year_marksheet') && 
            $this->request->getFile('last_year_marksheet')->isValid()) {
            $studentElectiveSubjectsData['last_year_marksheet'] =
                $this->getUploadedFilePath('last_year_marksheet', $lastestFormNo);
        }

        // Birth certificate
        if ($this->request->getFile('student_birth_certificate') && 
            $this->request->getFile('student_birth_certificate')->isValid()) {
            $studentElectiveSubjectsData['student_birth_certificate'] =
                $this->getUploadedFilePath('student_birth_certificate', $lastestFormNo);
        }

        // Student admit
        if ($this->request->getFile('student_admit') && 
            $this->request->getFile('student_admit')->isValid()) {
            $studentElectiveSubjectsData['student_admit'] =
                $this->getUploadedFilePath('student_admit', $lastestFormNo);
        }

        // Caste certificate
        if ($this->request->getFile('cast_certificate') && 
            $this->request->getFile('cast_certificate')->isValid()) {
            $studentElectiveSubjectsData['cast_certificate'] =
                $this->getUploadedFilePath('cast_certificate', $lastestFormNo);
        }

        /*$studentDocumentsData = [
            'signature'     => $this->getUploadedFilePath('p_signature', $lastestFormNo), // parent signature 
            'f_image'       => $this->getUploadedFilePath('f_image', $lastestFormNo),
            'm_image'       => $this->getUploadedFilePath('m_image', $lastestFormNo),
            'f_signature'   => $this->getUploadedFilePath('f_signature', $lastestFormNo),
            'm_signature'   => $this->getUploadedFilePath('m_signature', $lastestFormNo),
            'g_image'       => $this->getUploadedFilePath('g_image', $lastestFormNo),
            'g_signature'   => $this->getUploadedFilePath('g_signature', $lastestFormNo),
            'stu_signature' => $this->getUploadedFilePath('s_signature', $lastestFormNo),
            'cast_certificate' => $this->getUploadedFilePath('cast_certificate', $lastestFormNo),
            'application' => $this->getUploadedFilePath('application_pre', $lastestFormNo),
            'trans_cert' => $this->getUploadedFilePath('trans_cert', $lastestFormNo),
            'migration_cert' => $this->getUploadedFilePath('migration_cert', $lastestFormNo),
            'any_special_cert' => $this->getUploadedFilePath('any_special_cert', $lastestFormNo),
        ];*/

        $studentDocumentsData = [];
        $documentFields = [
            'signature'         => 'p_signature',     // Parent signature
            'f_image'           => 'f_image',
            'm_image'           => 'm_image',
            'f_signature'       => 'f_signature',
            'm_signature'       => 'm_signature',
            'g_image'           => 'g_image',
            'g_signature'       => 'g_signature',
            'stu_signature'     => 's_signature',
            'cast_certificate'  => 'cast_certificate',
            'application'       => 'application_pre',
            'trans_cert'        => 'trans_cert',
            'migration_cert'    => 'migration_cert',
            'any_special_cert'  => 'any_special_cert',
        ];

        foreach ($documentFields as $dbField => $inputField) {

            $file = $this->request->getFile($inputField);

            if ($file && $file->isValid()) {
                $studentDocumentsData[$dbField] =
                    $this->getUploadedFilePath($inputField, $lastestFormNo);
            }
        }

        $studentTransportBankData = [
            'stoppage' => $this->request->getPost('stoppage') ?? 0,
        ];

        $studentAcademicHistoryData = [
            'last_ac_certificate' => $this->request->getPost('last_ac_certificate') ?? '',
            'last_ac_exam_passed' => $this->request->getPost('last_ac_exam_passed') ?? '',
            'last_ac_year' => $this->request->getPost('last_ac_year') ?? '',
            'last_ac_board' => $this->request->getPost('last_ac_board') ?? '',
            'last_ac_school_name' => $this->request->getPost('last_ac_school_name') ?? '',
            'last_ac_roll_no' => $this->request->getPost('last_ac_roll_no') ?? '',
            'last_ac_max_mark' => $this->request->getPost('last_ac_max_mark') ?? '',
            'last_ac_marks' => $this->request->getPost('last_ac_marks') ?? '',
            'last_school_detail' => $this->request->getPost('last_school_detail') ?? '',

            // 'transfer_certificate' => $this->request->getPost('transfer_certificate') ?? '',
            // 'marksheet' => $this->request->getPost('marksheet') ?? '',
            // 'last_year_marksheet' => $this->request->getPost('last_year_marksheet') ?? '',
            'tc_required' => $this->request->getPost('tc_required') ?? '',
            // 'pre_school_tc_date' => $this->request->getPost('pre_school_tc_date') ?? 0,
            'migration_required' => $this->request->getPost('migration_required') ?? 0,
            // 'migration_date' => $this->request->getPost('migration_date') ?? NULL,
        ];

        $migrationDate = $this->request->getPost('migration_date');
        if (null !== $migrationDate && $migrationDate !== '') {
            $studentAcademicHistoryData['migration_date'] = $migrationDate;
        }

        if (null !== $tcDate && $tcDate !== '') {
            $studentAcademicHistoryData['pre_school_tc_date'] = $tcDate;
        }

        // Student admit
        if ($this->request->getFile('last_year_marksheet') && 
            $this->request->getFile('last_year_marksheet')->isValid()) {
            $studentAcademicHistoryData['last_year_marksheet'] =
                $this->getUploadedFilePath('last_year_marksheet', $lastestFormNo);
        }

        // pr($studentElectiveSubjectsData);
        $result = $studentDetailsModel
            ->where('student_id', $student_id)
            ->set($studentDetailsTableData)
            ->update();

        if ($result) {
            // Updated tuition fee set to zero
            if( $this->request->getPost('academic_status') == "Free") {
                $studentFeeStructureDetails = $studentFeeStructureModel->getStudentFeeStructure($student_code, $get_session_year_id);
                if( isset($studentFeeStructureDetails) && !empty($studentFeeStructureDetails) ) {
                    foreach ($studentFeeStructureDetails as $feeDetails) {
                        $getFeeId = $feeDetails['id'] ?? '';
                        if( isset($getFeeId) && $getFeeId != '' ) {
                            $studentFeeStructureModel->update($getFeeId, [
                                'tuition_fee' => 0
                            ]);
                        }
                    }
                }
            }

            $studentPersonalDetailsModel = new StudentPersonalDetailsModel();
            if (!empty($studentPersonalDetailsData)) {
                $updatePersonalDetails = $studentPersonalDetailsModel->where('student_id', $student_id)->set($studentPersonalDetailsData)->update();
            }

            $studentParentsGuardiansModel = new StudentParentsGuardiansModel();
            if (!empty($studentParentsGuardiansData)) {
                $updateParentsGuardians = $studentParentsGuardiansModel->where('student_id', $student_id)->set($studentParentsGuardiansData)->update();
            }

            $studentElectiveSubjectsModel = new StudentElectiveSubjectsModel();
            if (!empty($studentElectiveSubjectsData)) {
                $updateElectiveSubjects = $studentElectiveSubjectsModel->where('student_id', $student_id)->set($studentElectiveSubjectsData)->update();
            }

            $studentDocumentsModel = new StudentDocumentsModel();
            if (!empty($studentDocumentsData)) {
                $updateDocuments = $studentDocumentsModel->where('student_id', $student_id)->set($studentDocumentsData)->update();
            }

            // Off this code for bus stopage assign, created extra section
            // $studentTransportFinancialModel = new StudentTransportFinancialModel();
            // if (!empty($studentTransportBankData)) {
            //     $updateTransport = $studentTransportFinancialModel->where('student_id', $student_id)->set($studentTransportBankData)->update();
            // }

            $studentAcademicHistoryModel = new StudentAcademicHistoryModel();
            if (!empty($studentAcademicHistoryData)) {
                // $updateTransport = $studentTransportFinancialModel->where('student_id', $student_id)->set($studentAcademicHistoryData)->update();
                $existing = $studentAcademicHistoryModel
                    ->where('student_id', $student_id)
                    ->first();

                if ($existing) {
                    // UPDATE
                    $studentAcademicHistoryModel
                        ->where('student_id', $student_id)
                        ->set($studentAcademicHistoryData)
                        ->update();
                } else {
                    // INSERT
                    $studentAcademicHistoryData['student_id'] = $student_id;
                    $studentAcademicHistoryData['student_code'] = $student_code;

                    $studentAcademicHistoryModel->insert($studentAcademicHistoryData);
                }

            }

            return redirect()->back()->with('success', 'Student updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Update failed.');
        }
    }

    function ajax_request_assign_bus_to_student()
    {
        $studentDetailsModel = new StudentDetailsModel();
        $studentTransportFinancialModel = new StudentTransportFinancialModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();
        $stoppageFareMasterModel = new StoppageFareMasterModel();

        $stoppage = $this->request->getPost('stoppage');
        $bus_id = $this->request->getPost('bus_id');
        $form_no = $this->request->getPost('form_no');
        $get_student_id = $this->request->getPost('student_id') ?? '';
        $stu_previous_stoppage = $this->request->getPost('stuPreviousStoppage');

        if( isset($get_student_id) && $get_student_id != '' ) {
            $student_id = $get_student_id;
        } else {
            if ($form_no != '') {
                $student_id = $studentDetailsModel->where('form_no', $form_no)->select('student_id')->first()['student_id'];
            } else {
                return $this->response->setJSON(0);
            }
        }

        $session_year_id = $this->session->get('session_year_id');
        $student_code = !empty($student_id) ? student_code_by_id($student_id) : '';

        if( isset($student_code) && empty($student_code) ) {
            return $this->response->setJSON(-1);
        }

        $feesDetails = $studentFeeStructureModel
            ->select('id')
            ->asArray()
            ->where([
                'session_year_id' => $session_year_id,
                'student_code' => $student_code,
            ])
            ->findAll();

        // $getFeeId = $feesDetails['id'] ?? '';

        $stoppage_fee_details = $stoppageFareMasterModel->session_stoppage_fee_by_id($stoppage, $session_year_id);
        $stoppage_fare = $stoppage_fee_details['stoppage_fare'] ?? 0;

        $updata = [
            'stoppage'        => $stoppage,
            'bus_id'          => $bus_id,
            'bus_alloted_date'=> date('Y-m-d')
        ];

        if (!$student_id) {
            return $this->response->setJSON(0);
        }

        $updated = $studentTransportFinancialModel->where('student_id', $student_id)->set($updata)->update();

        // Return numeric response
        if ($updated) {
            if( isset($feesDetails) && !empty($feesDetails) ) {
                foreach ($feesDetails as $feesId) {
                    $getFeeId = $feesId['id'] ?? '';
                    $updatedBusFees = [
                        'bus_services' => $stoppage_fare
                    ];
                    if( $getFeeId != '' ) {
                        $studentFeeStructureModel->update($getFeeId, $updatedBusFees);
                    }
                }
            }

            return $this->response->setJSON(1);
        } else {
            return $this->response->setJSON(0);
        }
    }

    public function ajax_request_unassign_bus_to_student()
    {
        $studentDetailsModel = new StudentDetailsModel();
        $studentTransportFinancialModel = new StudentTransportFinancialModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();
        $stoppageFareMasterModel = new StoppageFareMasterModel();

        $stoppage = $this->request->getPost('stoppage');
        $bus_id = $this->request->getPost('bus_id');
        $form_no = $this->request->getPost('form_no');
        // $get_student_id = $this->request->getPost('student_id') ?? '';
        $stu_previous_stoppage = $this->request->getPost('stuPreviousStoppage');

        $get_student_id = !empty($this->request->getPost('student_id')) ? $this->request->getPost('student_id') : (!empty($form_no) ? student_student_id_by_form_no($form_no) : '');

        if($get_student_id != ''){
            $updata = [
                'stoppage'        => 0,
                'bus_id'          => 0,
                'bus_alloted_date'=> NULL
            ];

            $updated = $studentTransportFinancialModel->where('student_id', $get_student_id)->set($updata)->update();
        } else {
            return $this->response->setJSON(-1); // Student ID not found
        }

        $session_year_id = $this->session->get('session_year_id');
        $student_code = !empty($get_student_id) ? student_code_by_id($get_student_id) : '';

        if( isset($student_code) && empty($student_code) ) {
            return $this->response->setJSON(-2); // Student Code Empty
        }

        $feesDetails = $studentFeeStructureModel
            ->where([
                'session_year_id' => $session_year_id,
                'student_code' => $student_code,
                'month_id'     => 4,
            ])
            ->first();
        $getFeeId = $feesDetails['id'] ?? '';

        $updatedBusFees = [
            'bus_services' => 0
        ];
        $busfareUpdate = $studentFeeStructureModel->update($getFeeId, $updatedBusFees);

        // Return numeric response
        if ($busfareUpdate) {
            return $this->response->setJSON(1);
        } else {
            return $this->response->setJSON(0);
        }
    }

    function ajax_add_admission_payment()
    {
        // echo "<pre>"; print_r($this->request->getPost());
        // die();

        $data = []; 
        // $updata = [];
        $upStuData = [];
        // $studentData = [];
        $student_details = [];
        $add_month_fee= [];

        $getCurrentMonthName = strtolower(date("F"));

        $configurationModel = new ConfigurationModel();
        $pay_due_date = $configurationModel->get_configuration_by_key($getCurrentMonthName.'_payment_due_date');

        $data = $this->request->getPost();

        $studentDetailsModel = new StudentDetailsModel();
        $student_details = $studentDetailsModel->where('form_no', $data['form_no'])->first();

        $getStudentId = $student_details['student_id'] ?? '';
        $getStudentDetailsId = $student_details['id'] ?? '';
        $getClassId = $student_details['class_id'] ?? '';
        $getSectionId = $student_details['section_id'] ?? '';
        $getFirstName = $student_details['first_name'] ?? '';
        $getAcademicStatus = $student_details['academic_status'] ?? '';

        $classModel = new ClassModel();
        $id_range = $classModel->getClassIdRange($getClassId);

        $studentModel = new StudentModel();
        $no_of_admtd_student = $studentModel->getAdmittedStudentCount($getClassId);

        $studentCode =  date('y', strtotime($this->session->get('session_start_date'))).'-'.sprintf("%04s",$id_range+$no_of_admtd_student);

        $update_academic_status = '';
        if( $getAcademicStatus == "Not Admitted" ) {
            $update_academic_status = 'Bonafide';
        } else {
            $update_academic_status = $getAcademicStatus;
        }

        $upStuData = array(
            'code' => $studentCode,
            // 'session_year_id' => $this->session->get('session_year_id'),
            'admission' => 1,
            'admission_date' => date('Y-m-d')
        );

        if( $update_academic_status != "" ) {
            $upStuData['academic_status'] = $update_academic_status;
        }

        $student_status = $studentModel->where('id', $getStudentId)->set(['code' => $studentCode])->update();
        $student_details_status = $studentDetailsModel->where('form_no', $data['form_no'])->set($upStuData)->update();

        // insert student_transaction table
        $studentTransactionModel = new StudentTransactionModel();
        $studentTranData = array(
            'student_code' => $studentCode,
            'due_amount' => 0,
            'advanced_amount' => 0,
            'session_year_id' => $this->session->get('session_year_id')
        );
        $student_tran_id = $studentTransactionModel->insert($studentTranData);


        //insert student_fee_structure table
        $startDate = new DateTime($this->session->get('session_start_date')); //'2019-04-15'
        $endDate = new DateTime($this->session->get('session_end_date')); //'2020-03-30'
        $periodInt = new DateInterval( "P1M" ); // 1 month interval


        $sessionDate = date('Y-m',strtotime($this->session->get('session_start_date')));    //2019-04-01
        $currentMonthYear = date('Y-m');
        $first_date = new DateTime($sessionDate);
        $second_date = new DateTime($currentMonthYear);
        $interval = $first_date->diff($second_date);
        
        $result = $interval->format("%R%m");
        
        $sesionMonthYear = date('Y-m',strtotime($this->session->get('session_start_date')));
        
        $studentFeeStructureModel = new StudentFeeStructureModel();
        $period = new DatePeriod( $startDate, $periodInt, $endDate );

        foreach ($period as $key => $value) {

            if($value->format('Y-m') == $sesionMonthYear){
                $stoppage_fee = $data['stoppage_fee'] ?? 0;
                $data['student_code'] = $studentCode;               
                $data['ad_payment_status'] = 1;
                $data['bus_payment_status'] = 0;                
                
                $data['academic_payment_amt']       = $data['payment_amount'] - $stoppage_fee;
                $data['bus_payment_amt']            = $stoppage_fee;
                $data['bus_payment_mode']           = $data['ad_payment_mode'];
                $data['bus_cheque_number']          = $data['payment_cheque_number'];
                $data['bus_pos_bank_name']          = $data['payment_pos_bank_name'];
                $data['bus_pos_reference_number']   = $data['payment_pos_reference_number'];
                
                // $data['bus_payee_name']             = $data['first_name'];
                // $data['bus_t_user_id']              = $this->session->get('user_id');
                // $data['bus_added_by']               = $this->session->get('f_name');
                // $data['bus_payment_date']           = date('Y-m-d h:m:s');   

                $data['payee_name']                 = $data['first_name'];
                $data['t_user_id']                  = $this->session->get('user_id');
                $data['added_by']                   = $this->session->get('f_name');
                $data['created_date']               = date('Y-m-d h:m:s');     

                $data['payment_due_date']           = $value->format('Y-m-'.$pay_due_date);
                $data['month_id']                   = $value->format('m');
                $data['session_year_id']            = $this->session->get('session_year_id');

                // $insert_id                          = $this->student_model->add_admission_payment($data);
                $insert_id = $studentFeeStructureModel->insert($data, true);
            } else {
                $add_month_fee = array(
                    'student_code'                  => $studentCode,
                    // 'created_date'                  => date('Y-m-d h:m:s'),
                    'form_no'                       => $data['form_no'],
                    'fine'                          => 0,
                    'admission_fee'                 => 0,
                    'development_fee'               => 0,
                    'exam_fee'                      => 0,
                    'festival_celebration_fee'      => 0,
                    'games_sports_fee'              => 0,
                    'audio_visual_lab_fee'          => 0,
                    'library_fee'                   => 0,
                    'electricity_maintenance_fee'   => 0,
                    'computer_fee'                  => 0,
                    'security_deposite'             => 0,
                    'tuition_fee'                   => $data['tuition_fee'],
                    'bus_services'                  => $stoppage_fee,
                    'month_id'                      => $value->format('m'),
                    'ad_payment_status'             => 0,
                    'bus_payment_status'            => 0,
                    'payment_due_date'              => $value->format('Y-m-'.$pay_due_date),
                    'session_year_id'               => $this->session->get('session_year_id')
                );
                    
                // $this->student_model->add_stu_fee_structure($add_month_fee);
                $feesResult = $studentFeeStructureModel->insert($add_month_fee, true);
                $add_month_fee= [];
            }
            
        }

        // Insert Fee Invoice
        $studentFeeInvoiceModel = new StudentFeeInvoiceModel();
        $feesInvoiceData = [
            'form_no' => $data['form_no'] ?? '',
            'session_year_id' => $this->session->get('session_year_id'),

            'admission_fee'             => $data['admission_fee'] ?? 0,
            'development_fee'           => $data['development_fee'] ?? 0,
            'exam_fee'                  => $data['exam_fee'] ?? 0,
            'festival_celebration_fee'  => $data['festival_celebration_fee'] ?? 0,
            'games_sports_fee'          => $data['games_sports_fee'] ?? 0,
            'audio_visual_lab_fee'      => $data['audio_visual_lab_fee'] ?? 0,
            'library_fee'               => $data['library_fee'] ?? 0,
            'electricity_maintenance_fee'=> $data['electricity_maintenance_fee'] ?? 0,
            'computer_fee'              => $data['computer_fee'] ?? 0,
            'security_deposite'         => $data['security_deposite'] ?? 0,
            'tuition_fee'               => $data['tuition_fee'] ?? 0,
            'stoppage_fee'              => $data['stoppage_fee'] ?? 0,

            'grand_total_fees'          => $data['grand_total_fees'] ?? 0,
            'payment_amount'            => $data['payment_amount'] ?? 0,

            'payment_cheque_number'     => $data['payment_cheque_number'] ?? null,
            'payment_pos_bank_name'     => $data['payment_pos_bank_name'] ?? null,
            'payment_pos_reference_number'=> $data['payment_pos_reference_number'] ?? null,

            'remarks'                   => $data['remarks'] ?? '',

            'stationary_items'          => json_encode($data['stationary_items'] ?? []),
            'stationary_total'          => $data['stationary_total'] ?? 0,

            'tblc_items'                => json_encode($data['tblc_items'] ?? []),
            'tblc_total'                => $data['tblc_total'] ?? 0,

            'created_at'                => date('Y-m-d H:i:s'),
            'created_by'                => $this->session->get('user_id'),
        ];

        $studentFeeInvoiceModel->insert($feesInvoiceData, true);


        // Insert Stationary Item
        $studentStationaryItemsModel = new StudentStationaryItemsModel();
        $stationary_items = $data['stationary_items'] ?? [];

        if( !empty($stationary_items) ) {
            $item_names = array_column($stationary_items, 'item_name');
            $item_ids   = array_column($stationary_items, 'item_id');
            $item_qtys  = array_column($stationary_items, 'qty');
            $item_price = array_column($stationary_items, 'price');

            // Convert to comma-separated string
            $item_names_str = implode(',', $item_names);
            $item_ids_str   = implode(',', $item_ids);
            $item_qtys_str  = implode(',', $item_qtys);
            $item_price_str = implode(',', $item_price);

            $stationaryData = array(
                'student_id'=> $getStudentId,
                'class_id'  => $getClassId,
                'class_code'=> $studentCode,
                'item_ids' => $item_ids_str,                       
                'item_qtys'=> $item_qtys_str,                      
                'item_price'=> $item_price_str,
                'price'     => $data['stationary_total'],
                'payment_status' => 1,
                'payment_date' => date('Y-m-d'),
                'session_year_id'=> $this->session->get('session_year_id'),
                'add_date'  => date('Y-m-d H:i:s'),
                'payment_mode' => $data['ad_payment_mode'],
                'cheque_number' => $data['payment_cheque_number'],
                'pos_bank_name' => $data['payment_pos_bank_name'],
                'pos_reference_number' => $data['payment_pos_reference_number'],
                't_user_id' => $this->session->get('user_id'),
                'added_by' => $this->session->get('f_name'),
                'remarks' => ''
            );
            
            $stationaryResultId = $studentStationaryItemsModel->insert($stationaryData, true);
        }
        // Insert TBLC Item
        $studentTblcItemsModel = new StudentTblcItemsModel();
        $tblc_items = $data['tblc_items'] ?? [];

        if( !empty($tblc_items) ) {
            $tblc_item_names = array_column($tblc_items, 'item_name');
            $tblc_item_ids   = array_column($tblc_items, 'item_id');
            $tblc_item_qtys  = array_column($tblc_items, 'qty');
            $tblc_item_price = array_column($tblc_items, 'price');

            // Convert to comma-separated string
            $tblc_item_names_str = implode(',', $tblc_item_names);
            $tblc_item_ids_str   = implode(',', $tblc_item_ids);
            $tblc_item_qtys_str  = implode(',', $tblc_item_qtys);
            $tblc_item_price_str = implode(',', $tblc_item_price);

            $tblcData = array(
                'student_id'=> $getStudentId,
                'class_id'  => $getClassId,
                'class_code'=> $studentCode,
                'item_ids' => $tblc_item_ids_str,                       
                'item_qtys'=> $tblc_item_qtys_str,                      
                'item_price'=> $tblc_item_price_str,
                'price'     => $data['tblc_total'],
                'payment_status' => 1,
                'payment_date' => date('Y-m-d'),
                'session_year_id'=> $this->session->get('session_year_id'),
                'add_date'  => date('Y-m-d H:i:s'),
                'payment_mode' => $data['ad_payment_mode'],
                'cheque_number' => $data['payment_cheque_number'],
                'pos_bank_name' => $data['payment_pos_bank_name'],
                'pos_reference_number' => $data['payment_pos_reference_number'],
                't_user_id' => $this->session->get('user_id'),
                'added_by' => $this->session->get('f_name'),
                'remarks' => ''
            );
            
            $tblcResultId = $studentTblcItemsModel->insert($tblcData, true);
        }

        if($insert_id > 0){
            // $this->load->helper('string');
            // $password = random_string('alnum',6);

            helper('text');
            $password = random_string('alnum', 6);
           
            
            $generated_student_code = [];
            $generated_student_code  = array('temp_studentCode' => $studentCode);
            // $this->session->set_userdata($generated_student_code);
            session()->set($generated_student_code);
            
            $userData = array(
                'first_name'=>  $student_details['first_name'],
                'code'      =>  $studentCode,
                //'email'       =>  $student_details['email'],
                'email'     =>  $studentCode,
                // 'password'  =>  md5($studentCode),
                'password'   => password_hash($studentCode, PASSWORD_DEFAULT),
                'dept_id' =>  3, // user_type
                'status'    =>  TRUE,
                'session_id' => $this->session->get('session_year_id')
            );

            $adminUserModel = new AdminUserModel();
            $checkStudent = $adminUserModel->chkStudent($studentCode); // returning num_rows
            if($checkStudent == 0){
                // $this->db->insert('admin_users', $user);
                $studentId = $adminUserModel->insert($userData, true);
            }

            $valid = $studentCode;
        } else {
            $valid = 0;
        }

        echo $valid;
        exit();
    }

    function ajax_add_admission_payment_test_old_20_01_2026()
    {
        // echo "<pre>"; print_r($this->request->getPost());
        // die();

        $data = []; 
        // $updata = [];
        $upStuData = [];
        // $studentData = [];
        $student_details = [];
        $add_month_fee= [];

        $getCurrentMonthName = strtolower(date("F"));

        $configurationModel = new ConfigurationModel();
        $pay_due_date = $configurationModel->get_configuration_by_key($getCurrentMonthName.'_payment_due_date');

        $data = $this->request->getPost();

        $studentDetailsModel = new StudentDetailsModel();
        $student_details = $studentDetailsModel->where('form_no', $data['form_no'])->first();

        $getStudentId = $student_details['student_id'] ?? '';
        $getStudentDetailsId = $student_details['id'] ?? '';
        $getClassId = $student_details['class_id'] ?? '';
        $getSectionId = $student_details['section_id'] ?? '';
        $getFirstName = $student_details['first_name'] ?? '';
        $getAcademicStatus = $student_details['academic_status'] ?? '';

        $classModel = new ClassModel();
        $id_range = $classModel->getClassIdRange($getClassId);

        $studentModel = new StudentModel();
        $no_of_admtd_student = $studentModel->getAdmittedStudentCount($getClassId);

        $studentCode =  date('y', strtotime($this->session->get('session_start_date'))).'-'.sprintf("%04s",$id_range+$no_of_admtd_student);

        $update_academic_status = '';
        if( $getAcademicStatus == "Not Admitted" ) {
            $update_academic_status = 'Bonafide';
        } else {
            $update_academic_status = $getAcademicStatus;
        }

        $upStuData = array(
            'code' => $studentCode,
            // 'session_year_id' => $this->session->get('session_year_id'),
            'admission' => 1,
            'admission_date' => date('Y-m-d')
        );

        if( $update_academic_status != "" ) {
            $upStuData['academic_status'] = $update_academic_status;
        }

        $student_status = $studentModel->where('id', $getStudentId)->set(['code' => $studentCode])->update();
        $student_details_status = $studentDetailsModel->where('form_no', $data['form_no'])->set($upStuData)->update();

        // insert student_transaction table
        $studentTransactionModel = new StudentTransactionModel();
        $studentTranData = array(
            'student_code' => $studentCode,
            'due_amount' => 0,
            'advanced_amount' => 0,
            'session_year_id' => $this->session->get('session_year_id')
        );

        $existingSTRecord = $studentTransactionModel->where('student_code', $studentCode)->where('session_year_id', $this->session->get('session_year_id'))->first();
        if (!$existingRecord) {
            $student_tran_id = $studentTransactionModel->insert($studentTranData);
        }


        //insert student_fee_structure table
        $startDate = new DateTime($this->session->get('session_start_date')); //'2019-04-15'
        $endDate = new DateTime($this->session->get('session_end_date')); //'2020-03-30'
        $periodInt = new DateInterval( "P1M" ); // 1 month interval


        $sessionDate = date('Y-m',strtotime($this->session->get('session_start_date')));    //2019-04-01
        $currentMonthYear = date('Y-m');
        $first_date = new DateTime($sessionDate);
        $second_date = new DateTime($currentMonthYear);
        $interval = $first_date->diff($second_date);
        
        $result = $interval->format("%R%m");
        
        $sesionMonthYear = date('Y-m',strtotime($this->session->get('session_start_date')));
        
        $studentFeeStructureModel = new StudentFeeStructureModel();
        $period = new DatePeriod( $startDate, $periodInt, $endDate );

        foreach ($period as $key => $value) {

            if($value->format('Y-m') == $sesionMonthYear){
                $stoppage_fee = $data['stoppage_fee'] ?? 0;
                $data['student_code'] = $studentCode;               
                $data['ad_payment_status'] = 1;
                $data['bus_payment_status'] = 0;                
                
                $data['academic_payment_amt']       = $data['payment_amount'] - $stoppage_fee;
                $data['bus_payment_amt']            = $stoppage_fee;
                $data['bus_payment_mode']           = $data['ad_payment_mode'];
                $data['bus_cheque_number']          = $data['payment_cheque_number'];
                $data['bus_pos_bank_name']          = $data['payment_pos_bank_name'];
                $data['bus_pos_reference_number']   = $data['payment_pos_reference_number'];
                
                // $data['bus_payee_name']             = $data['first_name'];
                // $data['bus_t_user_id']              = $this->session->get('user_id');
                // $data['bus_added_by']               = $this->session->get('f_name');
                // $data['bus_payment_date']           = date('Y-m-d h:m:s');   

                $data['payee_name']                 = $data['first_name'];
                $data['t_user_id']                  = $this->session->get('user_id');
                $data['added_by']                   = $this->session->get('f_name');
                $data['created_date']               = date('Y-m-d h:m:s');     

                $data['payment_due_date']           = $value->format('Y-m-'.$pay_due_date);
                $data['month_id']                   = $value->format('m');
                $data['session_year_id']            = $this->session->get('session_year_id');

                $feeExists = $studentFeeStructureModel->where('student_code', $studentCode)->where('session_year_id', $this->session->get('session_year_id'))->first();
                if (!$feeExists) {
                    $insert_id = $studentFeeStructureModel->insert($data, true);
                }
            } else {
                $add_month_fee = array(
                    'student_code'                  => $studentCode,
                    // 'created_date'                  => date('Y-m-d h:m:s'),
                    'form_no'                       => $data['form_no'],
                    'fine'                          => 0,
                    'admission_fee'                 => 0,
                    'development_fee'               => 0,
                    'exam_fee'                      => 0,
                    'festival_celebration_fee'      => 0,
                    'games_sports_fee'              => 0,
                    'audio_visual_lab_fee'          => 0,
                    'library_fee'                   => 0,
                    'electricity_maintenance_fee'   => 0,
                    'computer_fee'                  => 0,
                    'security_deposite'             => 0,
                    'tuition_fee'                   => $data['tuition_fee'],
                    'bus_services'                  => $stoppage_fee,
                    'month_id'                      => $value->format('m'),
                    'ad_payment_status'             => 0,
                    'bus_payment_status'            => 0,
                    'payment_due_date'              => $value->format('Y-m-'.$pay_due_date),
                    'session_year_id'               => $this->session->get('session_year_id')
                );
                    
                // $this->student_model->add_stu_fee_structure($add_month_fee);
                $feeExists = $studentFeeStructureModel->where('student_code', $studentCode)->where('session_year_id', $this->session->get('session_year_id'))->first();
                if (!$feeExists) {
                    $feesResult = $studentFeeStructureModel->insert($add_month_fee, true);
                }
                $add_month_fee= [];
            }
            
        }

        // Insert Fee Invoice
        $studentFeeInvoiceModel = new StudentFeeInvoiceModel();
        $feesInvoiceData = [
            'form_no' => $data['form_no'] ?? '',
            'session_year_id' => $this->session->get('session_year_id'),

            'admission_fee'             => $data['admission_fee'] ?? 0,
            'development_fee'           => $data['development_fee'] ?? 0,
            'exam_fee'                  => $data['exam_fee'] ?? 0,
            'festival_celebration_fee'  => $data['festival_celebration_fee'] ?? 0,
            'games_sports_fee'          => $data['games_sports_fee'] ?? 0,
            'audio_visual_lab_fee'      => $data['audio_visual_lab_fee'] ?? 0,
            'library_fee'               => $data['library_fee'] ?? 0,
            'electricity_maintenance_fee'=> $data['electricity_maintenance_fee'] ?? 0,
            'computer_fee'              => $data['computer_fee'] ?? 0,
            'security_deposite'         => $data['security_deposite'] ?? 0,
            'tuition_fee'               => $data['tuition_fee'] ?? 0,
            'stoppage_fee'              => $data['stoppage_fee'] ?? 0,

            'grand_total_fees'          => $data['grand_total_fees'] ?? 0,
            'payment_amount'            => $data['payment_amount'] ?? 0,

            'payment_cheque_number'     => $data['payment_cheque_number'] ?? null,
            'payment_pos_bank_name'     => $data['payment_pos_bank_name'] ?? null,
            'payment_pos_reference_number'=> $data['payment_pos_reference_number'] ?? null,

            'remarks'                   => $data['remarks'] ?? '',

            'stationary_items'          => json_encode($data['stationary_items'] ?? []),
            'stationary_total'          => $data['stationary_total'] ?? 0,

            'tblc_items'                => json_encode($data['tblc_items'] ?? []),
            'tblc_total'                => $data['tblc_total'] ?? 0,

            'created_at'                => date('Y-m-d H:i:s'),
            'created_by'                => $this->session->get('user_id'),
        ];

        $existingFeesInvoice = $studentFeeInvoiceModel->where('form_no', $data['form_no'])->where('session_year_id', $this->session->get('session_year_id'))->first();
        if (!$existingFeesInvoice) {
            $studentFeeInvoiceModel->insert($feesInvoiceData, true);
        }


        // Insert Stationary Item
        $studentStationaryItemsModel = new StudentStationaryItemsModel();
        $stationary_items = $data['stationary_items'] ?? [];

        if( !empty($stationary_items) ) {
            $item_names = array_column($stationary_items, 'item_name');
            $item_ids   = array_column($stationary_items, 'item_id');
            $item_qtys  = array_column($stationary_items, 'qty');
            $item_price = array_column($stationary_items, 'price');

            // Convert to comma-separated string
            $item_names_str = implode(',', $item_names);
            $item_ids_str   = implode(',', $item_ids);
            $item_qtys_str  = implode(',', $item_qtys);
            $item_price_str = implode(',', $item_price);

            $stationaryData = array(
                'student_id'=> $getStudentId,
                'class_id'  => $getClassId,
                'class_code'=> $studentCode,
                'item_ids' => $item_ids_str,                       
                'item_qtys'=> $item_qtys_str,                      
                'item_price'=> $item_price_str,
                'price'     => $data['stationary_total'],
                'payment_status' => 1,
                'payment_date' => date('Y-m-d'),
                'session_year_id'=> $this->session->get('session_year_id'),
                'add_date'  => date('Y-m-d H:i:s'),
                'payment_mode' => $data['ad_payment_mode'],
                'cheque_number' => $data['payment_cheque_number'],
                'pos_bank_name' => $data['payment_pos_bank_name'],
                'pos_reference_number' => $data['payment_pos_reference_number'],
                't_user_id' => $this->session->get('user_id'),
                'added_by' => $this->session->get('f_name'),
                'remarks' => ''
            );
            
            $existingStationaryItems = $studentStationaryItemsModel->where('student_id', $getStudentId)->where('session_year_id', $this->session->get('session_year_id'))->first();
            if (!$existingStationaryItems) {
                $stationaryResultId = $studentStationaryItemsModel->insert($stationaryData, true);
            }
        }
        // Insert TBLC Item
        $studentTblcItemsModel = new StudentTblcItemsModel();
        $tblc_items = $data['tblc_items'] ?? [];

        if( !empty($tblc_items) ) {
            $tblc_item_names = array_column($tblc_items, 'item_name');
            $tblc_item_ids   = array_column($tblc_items, 'item_id');
            $tblc_item_qtys  = array_column($tblc_items, 'qty');
            $tblc_item_price = array_column($tblc_items, 'price');

            // Convert to comma-separated string
            $tblc_item_names_str = implode(',', $tblc_item_names);
            $tblc_item_ids_str   = implode(',', $tblc_item_ids);
            $tblc_item_qtys_str  = implode(',', $tblc_item_qtys);
            $tblc_item_price_str = implode(',', $tblc_item_price);

            $tblcData = array(
                'student_id'=> $getStudentId,
                'class_id'  => $getClassId,
                'class_code'=> $studentCode,
                'item_ids' => $tblc_item_ids_str,                       
                'item_qtys'=> $tblc_item_qtys_str,                      
                'item_price'=> $tblc_item_price_str,
                'price'     => $data['tblc_total'],
                'payment_status' => 1,
                'payment_date' => date('Y-m-d'),
                'session_year_id'=> $this->session->get('session_year_id'),
                'add_date'  => date('Y-m-d H:i:s'),
                'payment_mode' => $data['ad_payment_mode'],
                'cheque_number' => $data['payment_cheque_number'],
                'pos_bank_name' => $data['payment_pos_bank_name'],
                'pos_reference_number' => $data['payment_pos_reference_number'],
                't_user_id' => $this->session->get('user_id'),
                'added_by' => $this->session->get('f_name'),
                'remarks' => ''
            );
            
            $existingTblcItems = $studentTblcItemsModel->where('student_id', $getStudentId)->where('session_year_id', $this->session->get('session_year_id'))->first();
            if (!$existingTblcItems) {
                $tblcResultId = $studentTblcItemsModel->insert($tblcData, true);
            }
        }

        if($insert_id > 0){
            // $this->load->helper('string');
            // $password = random_string('alnum',6);

            helper('text');
            $password = random_string('alnum', 6);
           
            
            $generated_student_code = [];
            $generated_student_code  = array('temp_studentCode' => $studentCode);
            // $this->session->set_userdata($generated_student_code);
            session()->set($generated_student_code);
            
            $userData = array(
                'first_name'=>  $student_details['first_name'],
                'code'      =>  $studentCode,
                //'email'       =>  $student_details['email'],
                'email'     =>  $studentCode,
                // 'password'  =>  md5($studentCode),
                'password'   => password_hash($studentCode, PASSWORD_DEFAULT),
                'dept_id' =>  3, // user_type
                'status'    =>  TRUE,
                'session_id' => $this->session->get('session_year_id')
            );

            $adminUserModel = new AdminUserModel();
            $checkStudent = $adminUserModel->chkStudent($studentCode); // returning num_rows
            if($checkStudent == 0){
                // $this->db->insert('admin_users', $user);
                $studentId = $adminUserModel->insert($userData, true);
            }

            $valid = $studentCode;
        } else {
            $valid = 0;
        }

        echo $valid;
        exit();
    }

    function student_list($studentCode = null)
    {
        $data['title'] = "Student List";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        $data['studentCode'] = $studentCode;
        echo view('admin/student/student-list', $data);  

        echo view('admin/common/footer', $data);
    }

    function ajax_request_assign_section_to_student()
    {
        $class_id = $this->request->getPost('class_id');
        $section_id = $this->request->getPost('section_id');
        $form_no = $this->request->getPost('form_no');
        
        $studentModel = new StudentModel();
        $sectionModel = new SectionModel();
        $studentDetailsModel = new StudentDetailsModel();

        $student_count = $studentModel->where('class_id', $class_id)->where('section_id', $section_id)->where('session_year_id', $this->session->get('session_year_id'))->countAllResults();
        $sectionData = $sectionModel->select('no_of_student')->where(['class_id' => $class_id, 'id' => $section_id])->first();
        $section_student_count = $sectionData['no_of_student'] ?? 0;   // return 0 if no record

        if($student_count < $section_student_count){
            $result = $studentDetailsModel->where('form_no', $form_no)->set(['section_id' => $section_id])->update();

            if( $result ) {
                $student = $studentDetailsModel->select('student_id')->where('form_no', $form_no)->first();

                if ($student) {
                    $student_id = $student['student_id'] ?? '';

                    if (!empty($student_id)) {
                        $studentModel->where('id', $student_id)->set(['section_id' => $section_id])->update();
                    }
                }
            }
        }else{
            $result = 0;
        }

        echo $result;
        exit();
    }

    function ajax_request_section()
    {
        $sectionModel = new SectionModel();

        $class_id = $this->request->getPost('class_id');
        $sessionYearId = $this->session->get('session_year_id');
        $section_list = $sectionModel->select('id, section_name')->where('class_id', $class_id)->where('session_year_id', $sessionYearId)->orderBy('section_name', 'ASC')->findAll();

        $html = '<option value="">Select Section</option>';
        foreach($section_list as $section){
           $html .= '<option value="'. $section['id'] .'">'. $section['section_name'] .'</option>';
        }
        $data['html'] = $html;
        $data['status'] = "success";

        return $this->response->setJSON($data);
    }

    function ajax_request_student_list()
    {
        $studentModel = new StudentModel();
        $classModel = new ClassModel();
        $studentDetailsModel = new StudentDetailsModel();

        $class_id = $this->request->getPost('class_id') ?? '';
        $student_code = $this->request->getPost('student_code') ?? '';
        $student_name = $this->request->getPost('student_name') ?? '';
        $section_id = $this->request->getPost('section_id') ?? '';
        $father_name = $this->request->getPost('father_name') ?? '';
        $mother_name = $this->request->getPost('mother_name') ?? '';

        if ( empty($class_id) && empty($student_code) && empty($student_name) && empty($section_id) && empty($father_name) && empty($mother_name) ) {
            return $this->response->setJSON(['student_list' => [], 'class_list' => []]);
        }

        $get_session_year_id = $this->session->get('session_year_id');

        $student_list = $studentDetailsModel->studentListForAjaxCall($class_id, $student_code, $student_name, $section_id, $father_name, $mother_name);
        $class_list = $classModel->orderBy('id', 'ASC')->findAll();

        return $this->response->setJSON(['student_list' => $student_list, 'class_list' => $class_list]);
    }

    function ajax_student_paid_fee_invoice()
    {
        $studentDetailsModel = new StudentDetailsModel();
        $studentModel = new StudentModel();
        $studentFeeInvoiceModel = new StudentFeeInvoiceModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();

        $feeId = $this->request->getPost('feeId');
        $formNo = $this->request->getPost('formNo') ?? '';
        $studentId = $this->request->getPost('studentId') ?? '';
        $student_code = $this->request->getPost('sCode');
        $session_year_id = $this->session->get('session_year_id');

        $student_details = [];
        if( isset($formNo) && !empty($formNo) ) {
            $student_details = $studentDetailsModel->get_student_details_against_form_no($formNo);
        } elseif( isset($studentId) && $studentId != '' ) {
            $student_details = $studentModel->get_student_details_by_id($studentId);
        }

        $feePaymentDetails = $studentFeeStructureModel
                ->where('id', $feeId)
                ->where('session_year_id', $session_year_id)
                ->first();

        // echo "<pre>"; print_r($feePaymentDetails); die();

        if( $formNo != '' ) {
            $invoiceDetails = $studentFeeInvoiceModel
                ->where('form_no', $formNo)
                ->where('session_year_id', $session_year_id)
                ->first();
        } else {
            $invoiceDetails = $studentFeeInvoiceModel
                ->where('student_id', $studentId)
                ->where('session_year_id', $session_year_id)
                ->first(); 
        }

        $html = '';

        $admission_fee = $invoiceDetails['admission_fee'] ?? 0;
        $security_deposite = $invoiceDetails['security_deposite'] ?? 0;
        $development_fee = $invoiceDetails['development_fee'] ?? 0;
        $exam_fee = $invoiceDetails['exam_fee'] ?? 0;
        $festival_celebration_fee = $invoiceDetails['festival_celebration_fee'] ?? 0;
        $games_sports_fee = $invoiceDetails['games_sports_fee'] ?? 0;
        $audio_visual_lab_fee = $invoiceDetails['audio_visual_lab_fee'] ?? 0;
        $library_fee = $invoiceDetails['library_fee'] ?? 0;
        $electricity_maintenance_fee = $invoiceDetails['electricity_maintenance_fee'] ?? 0;
        $computer_fee = $invoiceDetails['computer_fee'] ?? 0;
        $tuition_fee = $invoiceDetails['tuition_fee'] ?? 0;
        
        $stationaryItems = $invoiceDetails['stationary_items'] ?? [];
        if (is_string($stationaryItems)) {
            $stationary_items = json_decode($stationaryItems, true);
        }
        
        // pr($stationary_items);

        $stationary_total = $invoiceDetails['stationary_total'] ?? 0;

        $tblcItems = $invoiceDetails['tblc_items'] ?? [];
        if (is_string($tblcItems)) {
            $tblc_items = json_decode($tblcItems, true);
        }
        
        $tblc_total = $invoiceDetails['tblc_total'] ?? 0;

        $bus_services = $invoiceDetails['bus_services'] ?? 0; // Not Found


        $student_details_id = $student_details['student_details_id'] ?? '';
        $student_id = $student_details['student_id'] ?? '';
        $student_first_name = $student_details['first_name'] ?? '';
        $student_middle_name = $student_details['middle_name'] ?? '';
        $student_surname = $student_details['surname'] ?? '';
        $roll_num = $student_details['roll_num'] ?? '';
        $class_name = $student_details['class_name'] ?? '';
        $class_id = $student_details['class_id'] ?? '';
        $section_name = $student_details['section_name'] ?? '';
        $formatted_date = $feePaymentDetails['created_date'] ? date('d-m-Y', strtotime($feePaymentDetails['created_date'])) : '';
        // $formatted_date = $feePaymentDetails['month_id'] ? date("F", mktime(0, 0, 0, $feePaymentDetails['month_id'], 1)) : '';
        $ad_payment_mode = $feePaymentDetails['ad_payment_mode'] ? ucfirst($feePaymentDetails['ad_payment_mode']) : '';
        // $payment_created_date = $feePaymentDetails['created_date'] ? $feePaymentDetails['created_date'] : '';

        // $barcode =  $student_code.'/'.$class_id.'/'.$student_stationary->id;
        $barcode =  $student_code.'/'.$class_id.'/'.$student_id;

        $total_payment_amount = $invoiceDetails['payment_amount'] ?? 0;
        $grand_total_fees = $invoiceDetails['grand_total_fees'] ?? 0;

        // Need to check this 2
        // $totalCalamount = $total_payment_amount+$fine+$busFine+$stationary_total_price;
        // $totalCalamt = $total_payment_amount+$fine+$busFine;

        $totalCalamt = $total_payment_amount;


        $transaction_no = ''; // Came from student_fee_structure table
        if(isset($feePaymentDetails['transaction_no']) && $feePaymentDetails['transaction_no'] !=""){
            $db_transaction_no = $feePaymentDetails['transaction_no'];
            $transaction_no = substr($db_transaction_no, 0, 4) . '***' . substr($db_transaction_no,  -4);
        }else{
            if( isset($feePaymentDetails['pos_reference_number']) && $feePaymentDetails['pos_reference_number'] !="" ) {
                $transaction_no = 'APPR'.$feePaymentDetails['pos_reference_number'];
            } else {
                $transaction_no = 'APPR/'.$session_year_id.'/'.$feePaymentDetails['id'];
            }
        }

        $html = '<div style="font-size:12px !important;">
            <div style="width:100%;clear:both;min-height:70px;">
                <div style="width:15%;float:left;text-align:center">
                    <img width="50" src="'. base_url('public/img/Satish-Chandra-Memorial-School-Nadia-West-Bengal.png') .'">
                </div>
                <div style="width:45%;float:left;text-align:center">
                    <div style="width:100%;float:left;">
                        <span class="invoice-info-label">Bill No:</span>
                        <span class="red">' . $barcode .'</span>
                    </div>
                </div>
                <div style="width:40%;float:left;text-align:center">
                    <strong class="widget-title grey lighter">SATISH CHANDRA MEMORIAL SCHOOL<br>PUMLIA, CHOWRASTA, CHAKDAHA</strong>
                </div>
            </div>
            <div style="width:100%;clear:both;min-height:40px">
                <div style="width:35%;float:left;"><b>Name:</b> '. $student_first_name .' '. $student_middle_name .' '. $student_surname .'</div>
                <div style="width:35%;float:left;"><b>Student ID:</b> '. $student_code .'</div>
                <div style="width:35%;float:left;"><b>Class:</b> '. $class_name .'</div>
                <div style="width:35%;float:left;"><b>Section:</b> '. $section_name .'</div>
                <div style="width:30%;float:left;"><b>Roll No:</b> '. $roll_num .'</div>
                <div style="width:35%;float:left;"><b>Date:</b> '. $formatted_date .'</div>
                <div style="width:35%;float:left;"><b>Transaction No:</b> '. $transaction_no .'</div>
            </div>
        </div>

        <div class="">
            <div class="">                      
                <div>
                    <table class="table" style="font-size:12px !important;">
                        <tbody>
                            <tr><td></td><td>Rs. P.<br>------</td></tr>';
                            // <tr><td></td><td>Rs. P.<br>------</td></tr>
                            if($admission_fee > 0 ){ 
                                $html .= '<tr><td style="padding: 0px;">ADMISSION FEE</td><td style="padding: 0px;">'. $admission_fee .'</td></tr>';
                            } 
                            if($security_deposite > 0 ){ 
                                $html .= '<tr><td style="padding: 0px;">SECURITY DEPOSIT </td><td style="padding: 0px;">'. $security_deposite .'</td></tr>';
                            } 

                            if($development_fee > 0 ){ 
                                $html .= '<tr><td style="padding: 0px;">DEVELOPMENT FEE</td><td style="padding: 0px;">'. $development_fee .'</td></tr>';
                            } 
                            if($exam_fee >0 ){ 
                                $html .= '<tr><td style="padding: 0px;"> EXAM FEE</td><td style="padding: 0px;">'. $exam_fee .'</td></tr>';
                            } 
                            if($festival_celebration_fee >0 ){
                                $html .= '<tr><td style="padding: 0px;">FESTIVAL CELEBRATION FEE</td><td style="padding: 0px;">'. $festival_celebration_fee .'</td></tr>';
                            }
                            if($games_sports_fee >0 ){
                                $html .= '<tr><td style="padding: 0px;">GAMES SPORTS FEE</td><td style="padding: 0px;">'. $games_sports_fee .'</td></tr>';
                            }
                            if($audio_visual_lab_fee >0 ){
                                $html .= '<tr><td style="padding: 0px;">AUDIO VISUAL LAB FEE</td><td style="padding: 0px;">'. $audio_visual_lab_fee .'</td></tr>';
                            }
                            if($library_fee >0 ){
                                $html .= '<tr><td style="padding: 0px;">LIBRARY FEE</td><td style="padding: 0px;">'. $library_fee .'</td></tr>';
                            }
                            if($electricity_maintenance_fee >0 ){
                                $html .= '<tr><td style="padding: 0px;">ELECTRICITY MAINTENANCE FEE</td><td style="padding: 0px;">'. $electricity_maintenance_fee .'</td></tr>';
                            }
                            if($computer_fee >0 ){ 
                                $html .= '<tr><td style="padding: 0px;"> COMPUTER FEE</td><td style="padding: 0px;">'. $computer_fee .'</td></tr>';
                            }
                            if($tuition_fee >0 ){ 
                                $html .= '<tr><td style="padding: 0px;">TUTION FEE ('. $formatted_date .')</td><td style="padding: 0px;">'. $tuition_fee .'</td></tr>';
                            }

                            // Need to check
                            // if($init_bus_services >0 ){ 
                            //     $html .=       '<tr><td style="padding: 0px;">BUS FARE('. $fee->bus_payment_date .')('. $fee->bus_payment_mode .') </td><td style="padding: 0px;">'. $bus_services .'</td></tr>';
                            // }

                            // $html .= ' <tr><td style="text-align: right;">Total : </td><td>'.number_format($total,2) .' '.($fee->adv_bal_used == 1? '(Advanced Balance Used)':''). '</td></tr>';
                            // if($fine >0 ){ 
                            //     $html .= ' <tr><td style="text-align: right;">Fees Fine : </td><td>'.number_format($fine,2).'</td></tr>';
                            // }
                            
                            // if($busFine >0 ){ 
                            //     $html .= ' <tr><td style="text-align: right;">Bus Fine : </td><td>'.number_format($busFine,2).'</td></tr>';
                            // }


                            if($stationary_total >0 ){ 
                                // $html .= '<tr><td style="padding: 0px;">Stationary FEE</td><td style="padding: 0px;">'. $stationary_total .'</td></tr>';
                            }
                            if($tblc_total >0 ){ 
                                // $html .= '<tr><td style="padding: 0px;">TBLC FEE</td><td style="padding: 0px;">'. $tblc_total .'</td></tr>';
                            }

                            // Need to check
                            /*if($feePaymentDetails['ad_payment_status'] == 1 && $feePaymentDetails['month_id'] == 4 ){ 
                                $amt_wth_bus= $feePaymentDetails['academic_payment_amt']+$feePaymentDetails['bus_services'];
                                $html .= '<tr><td style="text-align: right;">Admission Fees Collected Amount : </td><td>'.number_format($totalCalamount,2).'</td></tr>';
                            }else{
                                $html .= '<tr><td style="text-align: right;"> Fees Collected Amount : </td><td>'.number_format($totalCalamt,2).'</td></tr>';
                            }*/

                            $html .= '<tr><td style="text-align: right;"> Fees Collected Amount : </td><td>'.number_format($grand_total_fees,2).' ('. ucwords(convert_number_to_words($grand_total_fees)) .')</td></tr>';

                        $html .= '</tbody>
                    </table>
                </div>';

                /*if($fee->ad_payment_status == 1   && $fee->month_id == 4 ){
                    $html .='<p>Admission Fees Collected Amount (in words): '. ucwords(convert_number_to_words($totalCalamount)) .'</br>Payment Mode :'. $fee->ad_payment_mode .'</p>                                               
                <p>';
                }else{
                    $html .='<p> Fees Collected Amount (in words): '. ucwords(convert_number_to_words($totalCalamt)) .'</br>Payment Mode :'. $fee->ad_payment_mode .'</p>                                               
                <p>';  
                }
                $html .='<span style="text-align:left">-------------------------</span><span style="float:right">-------------------------</span><br>
                
                <span style="text-align:left">Printed By :'. $this->session->userdata('f_name') .'</span>';
                
                if($fee->ad_payment_mode == 'Online'){
                    $html .= '<span style="float:right;text-align: center">Receipt through online<br>This is a system generated receipt,<br>signature & stamp not require</span>';
                }elseif($fee->ad_payment_mode == 'CCAvenue'){
                    $html .= '<span style="float:right;text-align: center">Receipt through online<br>This is a system generated receipt,<br>signature & stamp not require</span>';
                }else{
                    $html .= '<span style="float:right">Collected By :'. $fee->added_by .'</span>';
                }    
                $html .='                       </p>
                    <div class="hr hr8 hr-double hr-dotted">---------------------------------------------------
                    
                    </div>';*/


                $get_bus_services = $feePaymentDetails['bus_services'] ?? 0;
                $get_bus_fee_fine = $feePaymentDetails['bus_fee_fine'] ?? 0;
                $get_bus_payment_mode = $feePaymentDetails['bus_payment_mode'] ?? '';
                $get_bus_payment_amt = $feePaymentDetails['bus_payment_amt'] ?? 0;
                $get_bus_payment_status = $feePaymentDetails['bus_payment_status'] ?? 0;
                $get_bus_payment_date = !empty($feePaymentDetails['bus_payment_date']) ? date('j F, Y', strtotime($feePaymentDetails['bus_payment_date'])) : '';
                
                if( $get_bus_payment_status == 1 ) {
                    $html .='<div class="space"></div>
                    <div class="row" style="margin-top:5px !important;">
                        <div class="col-sm-12" >
                             <div style="width:100%;clear:both;min-height:40px">
                                <div style="width:100%;float:left;">BUS FARE: '.number_format($get_bus_payment_amt,2).' ( '. ucwords(convert_number_to_words($get_bus_payment_amt)) .' )</div>
                                <div style="width:50%;float:left;">Bus Payment Date: '.$get_bus_payment_date.'</div>
                                <div style="width:50%;float:left;">Bus Payment Mode: '.$get_bus_payment_mode.'</div>
                            </div>
                        </div>
                    </div>';
                }

                $getColSm = "col-sm-12";
                if( isset($stationary_items) && !empty($stationary_items) && isset($tblc_items) && !empty($tblc_items) ) {
                    $getColSm = "col-sm-6";
                }

                $html .='<div class="space"></div>
                <div class="row" style="margin-top:5px !important;">';
                if( isset($stationary_items) && !empty($stationary_items) ) {
                    $html .='<div class="'.$getColSm.'" style="float:left">
                        <div>
                            <p>Stationary Items</p>
                            <table class="table table-striped table-bordered" style="font-size:11px;">
                                <thead>
                                    <tr>
                                        <th class="center">Sl No.</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                $sti = 1;
                                foreach ($stationary_items as $stitems) {
                                    $totalPrice = $stitems['total'] ?? '';
                                    if( $totalPrice == '' ) {
                                        $totalPrice = (int)$stitems['qty'] * (int)$stitems['price'];
                                    }

                                    $html .= '<tr>
                                        <td style="padding:1px;" class="center">'.$sti.'</td>
                                        <td style="padding:1px;"><a>'.$stitems['item_name'].'</a></td>                                                                    
                                        <td style="padding:1px;"> '.$stitems['qty'].' </td>
                                        <td style="padding:1px;" align="right">'.number_format($stitems['price'],2).'</td>
                                        <td style="padding:1px;" align="right">'.number_format($totalPrice,2).'</td>
                                    </tr>';

                                    $sti++;
                                } 
                            $html .= '  </tbody>
                            </table>
                        </div>
                    
                        <p>Stationary. Items (in words): '. ucwords(convert_number_to_words($stationary_total)) .'</p>
                        <p>
                            <span>Stationary Items  : '.number_format($stationary_total,2).'</span><br>
                            <span style="text-align:left"><strong>Printed By: </strong>'.($this->session->get('dept_id') == 1 ? $this->session->get('f_name') : 'Cashier').'</span>
                            <span style="float:center"><strong>Collected By: </strong>'. $feePaymentDetails['added_by'] .'</span>
                        </p>
                    </div>';
                }

                if( isset($tblc_items) && !empty($tblc_items) ) {
                    $html .='<div class="'.$getColSm.'" style="float:left">
                        <div>
                            <p>TBLC Items</p>
                            <table class="table table-striped table-bordered" style="font-size:11px;">
                                <thead>
                                    <tr>
                                        <th class="center">Sl No.</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                $tbi = 1;
                                foreach ($tblc_items as $tbitem) {
                                    $html .= '<tr>
                                        <td style="padding:1px;" class="center">'.$tbi.'</td>
                                        <td style="padding:1px;"><a>'.$tbitem['item_name'].'</a></td>                                                                    
                                        <td style="padding:1px;"> '.$tbitem['qty'].' </td>
                                        <td style="padding:1px;" align="right">'.number_format($tbitem['price'],2).'</td>
                                        <td style="padding:1px;" align="right">'.number_format($tbitem['total'],2).'</td>
                                    </tr>';

                                    $tbi++;
                                } 
                            $html .= '  </tbody>
                            </table>
                        </div>
                        <p>TBLC. Items (in words): '. ucwords(convert_number_to_words($tblc_total)) .'</p>
                        <p>
                            <span>Miscellaneous Items  : '.number_format($tblc_total,2).'</span><br>
                            <span style="text-align:left"><strong>Printed By: </strong>'.($this->session->get('admin_logged_in') == true ? $this->session->get('f_name') : 'Cashier').'</span>
                            <span style="float:center"><strong>Collected By: </strong>'. $feePaymentDetails['added_by'] .'</span>
                        </p>
                    </div>';
                }

                $html .= '</div>

                <div class="row" style="margin-top:5px !important;">
                    <p class="pull-left">
                        Net Collected Amount (in words) :
                        <span class="red">'.ucwords(convert_number_to_words(($total_payment_amount),2)).' Only</span>
                    </p>
                    <p class="pull-right">
                        Net Collected Amount :
                        <span class="red"><strong>'.number_format(($total_payment_amount),2).'</strong></span>
                    </p>
                    <p class="pull-right">
                        Payment Mode :
                        <span class="red"><strong>'.$ad_payment_mode.'</strong></span>
                    </p>
                </div>

                <div>
                    <p>For Downloading app please scan this QR</p>
                    <img src="'. base_url() .'public/img/QR.png" alt="QR Code" width="90" height="110"></br>
                    <p>This is a system generated receipt. Signature & Stamp not require</p>
                
                </div>';

            $html .='</div>
        </div>';

        $data["html"]= $html;
        echo json_encode($data);
        exit();

        echo "<pre>"; print_r($html); 
        echo "<pre>"; print_r($invoiceDetails); 
        die();
    }

    function ajax_student_registration_fee_invoice()
    {
        $studentDetailsModel = new StudentDetailsModel();
        $registrationFeesModel = new RegistrationFeesModel();

        $form_no = $this->request->getPost('form_no');

        // Fetch single row
        $fees_details = $registrationFeesModel->where('form_no', $form_no)->first();
        $student_details = $studentDetailsModel->get_student_details_against_form_no($form_no);

        $student_details_id = $student_details['student_details_id'] ?? '';
        $student_id = $student_details['student_id'] ?? '';
        $student_first_name = $student_details['first_name'] ?? '';
        $student_middle_name = $student_details['middle_name'] ?? '';
        $student_surname = $student_details['surname'] ?? '';
        $roll_num = $student_details['roll_num'] ?? '';
        $class_name = $student_details['class_name'] ?? '';
        $class_id = $student_details['class_id'] ?? '';
        $section_name = $student_details['section_name'] ?? '';
        $formatted_date = $fees_details['payment_date'] ? date("jS F Y g A", strtotime($fees_details['payment_date'])) : '';

        $html = '';
        $html = '<div style="font-size:12px !important;">
            <div style="width:100%;clear:both;min-height:70px;">
                <div style="width:15%;float:left;text-align:center">
                    <img width="50" src="'. base_url('public/img/Satish-Chandra-Memorial-School-Nadia-West-Bengal.png') .'">
                </div>
                <div style="width:85%;float:left;text-align:center">
                    <strong class="widget-title grey lighter">SATISH CHANDRA MEMORIAL SCHOOL<br>PUMLIA, CHOWRASTA, CHAKDAHA</strong>
                </div>
            </div>
            <div style="width:100%;clear:both;min-height:40px">
                <div style="width:35%;float:left;"><b>Name:</b> '. $student_first_name .' '. $student_middle_name .' '. $student_surname .'</div>
                <div style="width:35%;float:left;"><b>Form No:</b> '. $form_no .'</div>
                <div style="width:35%;float:left;"><b>Class:</b> '. $class_name .'</div>
                <div style="width:35%;float:left;"><b>Section:</b> '. $section_name .'</div>
                <div style="width:30%;float:left;"><b>Roll No:</b> '. $roll_num .'</div>
                <div style="width:35%;float:left;"><b>Date:</b> '. $formatted_date .'</div>
            </div>
        </div>';

        $html .= '<div class="space"></div>
        <div class="" style="margin-top:5px !important;">';

            if (!empty($fees_details)) {
                $html .= '<div>
                    <div>
                        <table class="table table-striped table-bordered" style="font-size:11px;">
                            <thead>
                                <tr>
                                    <th class="center">Sl No.</th>
                                    <th>Payment Type</th>
                                    <th>Amount</th>
                                    <th>Payment Others Details</th>
                                    <th>Payee Name</th>
                                    <th>Payment Added By</th>
                                </tr>
                            </thead>
                            <tbody>';

                                // foreach ($fees_details as $fees) {
                                    $paymentOthersDetails = '';
                                    if( $fees_details['payment_type'] == "cheque" ) {
                                        $paymentOthersDetails = '<p><strong>Cheque Number: </strong>'.$fees_details['cheque_number'].'</p>';
                                    } elseif( $fees_details['payment_type'] == "pos" ) {
                                        $paymentOthersDetails = '<p><strong>Bank Name: </strong>'.$fees_details['pos_bank_name'].'</p><p><strong>Reference Number: </strong>'.$fees_details['pos_reference_number'].'</p>';
                                    }

                                    $html .= '<tr>
                                        <td class="center" style="padding:1px;">1</td>
                                        <td style="padding:1px;">'.ucfirst($fees_details['payment_type']).'</td>
                                        <td style="padding:1px;">'.$fees_details['payment_amount'].'</td>
                                        <td style="padding:1px;">'.$paymentOthersDetails.'</td>
                                        <td style="padding:1px;" align="right">'.$fees_details['payee_name'].'</td>
                                        <td style="padding:1px;" align="right">'.$fees_details['added_by'].'</td>
                                    </tr>';
                                // }

                            $html .= '</tbody>
                        </table>
                    </div>
                </div>';
            }

        $getCollectedBy = $fees_details['added_by'] ?? '';
        $html .= '<p>
            <span style="text-align:left"><strong>Printed By: </strong>'.($this->session->get('admin_logged_in') == true ? $this->session->get('f_name') : 'Cashier').'</span>
            <span style="float:center"><strong>Collected By: </strong>'.$getCollectedBy.'</span>
        </p>
        </div>';

        $data["html"]= $html;
        echo json_encode($data);
        exit();
    }

    public function view_fee_structure($studentCode)
    {
        $data['title'] = "View Fee Structure";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $studentFeeStructureModel = new StudentFeeStructureModel();
        $sessionYearModel = new SessionYearModel();
        $studentDetailsModel = new StudentDetailsModel();
        $studentTransactionModel = new StudentTransactionModel();
        $studentStationaryItemsModel = new StudentStationaryItemsModel();
        $studentTblcItemsModel = new StudentTblcItemsModel();




        $data['code'] = $studentCode;
        $data['form_details'] = $studentFeeStructureModel->getFirstMonthFee($studentCode);

        if (empty($data['form_details'])) {
            return redirect()->to('admin/student/student-list');
        }


        $session_year_id = $this->session->get('session_year_id');
        $data['session_year'] = $sessionYearModel->getSessionYearName($session_year_id);

        $data['fee_structure'] = $studentFeeStructureModel->getStudentFeeStructure($studentCode);
        // $data['student_details'] =  $studentDetailsModel->get_student_details($studentCode); over form_details class id and section id exit
        
        $transaction_details = $studentTransactionModel
            ->where('student_code', $studentCode)
            ->where('session_year_id', $session_year_id)
            ->first();
        $data['student_transaction_details'] = $transaction_details;

        $apr_mnth_payment = $studentFeeStructureModel
            ->where('student_code', $studentCode)
            ->where('month_id', 4)
            ->where('session_year_id', $session_year_id)
            ->first();
        // pr($studentFeeStructureModel->getLastQuery());

        $data['apr_mnth_payment'] = $apr_mnth_payment;
        // $data['class_id'] = $data['student_details']->class_id; //  over form_details class id 

        $student_stationary_price = $studentStationaryItemsModel
            ->where('class_code', $studentCode)
            ->where('session_year_id', $session_year_id)
            ->first();
        $data['student_stationary_price'] = $student_stationary_price;

        $student_tblc_price = $studentTblcItemsModel
            ->where('class_code', $studentCode)
            ->where('session_year_id', $session_year_id)
            ->first();
        $data['student_tblc_price'] = $student_tblc_price;
        // pr($data);
        echo view('admin/student/view-fee-structure', $data);
        echo view('admin/common/footer', $data);
    }

    function ajax_fee_amount_for_selected_month()
    {
        $configurationModel = new ConfigurationModel();
        $studentDetailsModel = new StudentDetailsModel();

        $session_year_id = $this->session->get('session_year_id');

        $pay_mnth_ids = [];
        $ids = [];
        $data = [];
        $dueMonths = [];
        $amount = 0;
        $fine = 0;
        $busFine = 0;
        
        $due_amount = 0;
        $adv_amount = 0;
        
        $totalamount=0;
        $bus_services=0;
        $tuition_fee=0;
        $security_deposite=0;
        $development_fee=0;
        $exam_fee=0;
        $festival_celebration_fee=0;
        $games_sports_fee=0;
        $audio_visual_lab_fee=0;
        $library_fee=0;
        $electricity_maintenance_fee=0;
        $computer_fee=0;        
        //$session_charges=0;
        $admission_fee=0;
        
        $tuition_fine_per_month = 0;
        $tuition_fine_per_month = $configurationModel->get_configuration_by_key('tuition_fee_fine_per_month');
        
        $bus_fine_per_month = 0;
        $bus_fine_per_month = $configurationModel->get_configuration_by_key('bus_fee_fine_per_month');
        
        $ids = $this->request->getPost('ids');
        $ids = array_unique($ids);
        
        $sCode = $this->request->getPost('sCode');
        $admsnBusDates = $studentDetailsModel->get_admsn_bus_date($sCode);
        
        $date = date('Y-m-d');
        $admsnDate = $admsnBusDates['admission_date'] ?? '';
        $busDate = $admsnBusDates['bus_alloted_date'] ?? '';

        // Need to add loop for ids
        foreach($ids as $id){
            $totalamount = 0; // ✅ RESET HERE
            $pay_mnth_ids[] = $id;

            $studentFeeStructureModel = new StudentFeeStructureModel();
            $get_student_fee_structure_details = $studentFeeStructureModel
                ->where('id', $id)
                ->where('session_year_id', $session_year_id)
                ->groupStart()
                    ->where('ad_payment_status', 0)
                    ->orWhere('bus_payment_status', 0)
                ->groupEnd()
                ->first();

            $cons_admission_fee = $get_student_fee_structure_details['cons_admission_fee'] ?? 0;   
            $cons_development_fee = $get_student_fee_structure_details['cons_development_fee'] ?? 0;
            $cons_exam_fee = $get_student_fee_structure_details['cons_exam_fee'] ?? 0;
            $cons_festival_celebration_fee = $get_student_fee_structure_details['cons_festival_celebration_fee'] ?? 0;
            $cons_games_sports_fee = $get_student_fee_structure_details['cons_games_sports_fee'] ?? 0;
            $cons_audio_visual_lab_fee = $get_student_fee_structure_details['cons_audio_visual_lab_fee'] ?? 0;
            $cons_library_fee = $get_student_fee_structure_details['cons_library_fee'] ?? 0;
            $cons_electricity_maintenance_fee = $get_student_fee_structure_details['cons_electricity_maintenance_fee'] ?? 0;
            $cons_computer_fee = $get_student_fee_structure_details['cons_computer_fee'] ?? 0;
            $cons_security_deposite = $get_student_fee_structure_details['cons_security_deposite'] ?? 0;
            $cons_tuition_fee = $get_student_fee_structure_details['cons_tuition_fee'] ?? 0;
            $cons_bus_services = $get_student_fee_structure_details['cons_bus_services'] ?? 0;

            $init_admission_fee = $get_student_fee_structure_details['admission_fee'] ?? 0;
            $init_development_fee = $get_student_fee_structure_details['development_fee'] ?? 0;
            $init_exam_fee = $get_student_fee_structure_details['exam_fee'] ?? 0;
            $init_festival_celebration_fee = $get_student_fee_structure_details['festival_celebration_fee'] ?? 0;
            $init_games_sports_fee = $get_student_fee_structure_details['games_sports_fee'] ?? 0;
            $init_audio_visual_lab_fee = $get_student_fee_structure_details['audio_visual_lab_fee'] ?? 0;
            $init_library_fee = $get_student_fee_structure_details['library_fee'] ?? 0;
            $init_electricity_maintenance_fee = $get_student_fee_structure_details['electricity_maintenance_fee'] ?? 0;
            $init_computer_fee = $get_student_fee_structure_details['computer_fee'] ?? 0;
            $init_security_deposite = $get_student_fee_structure_details['security_deposite'] ?? 0;
            $init_tuition_fee = $get_student_fee_structure_details['tuition_fee'] ?? 0;
            $init_bus_services = $get_student_fee_structure_details['bus_services'] ?? 0;

            //admission_charge
            $admission_fee = $init_admission_fee - $cons_admission_fee;

            //development_fee
            $development_fee = $init_development_fee - $cons_development_fee;

            //exam_fee
            $exam_fee = $init_exam_fee - $cons_exam_fee;

            //festival_celebration_fee
            $festival_celebration_fee = $init_festival_celebration_fee - $cons_festival_celebration_fee;

            //games_sports_fee
            $games_sports_fee = $init_games_sports_fee - $cons_games_sports_fee;

            //audio_visual_lab_fee
            $audio_visual_lab_fee = $init_audio_visual_lab_fee - $cons_audio_visual_lab_fee;

            //library_fee
            $library_fee = $init_library_fee - $cons_library_fee;

            //electricity_maintenance_fee
            $electricity_maintenance_fee = $init_electricity_maintenance_fee - $cons_electricity_maintenance_fee;

            //computer_fee
            $computer_fee = $init_computer_fee - $cons_computer_fee;

            //security_deposite
            $security_deposite = $init_security_deposite - $cons_security_deposite;

            //tution
            $tuition_fee = $init_tuition_fee - $cons_tuition_fee;

            //bus service
            $bus_services = $init_bus_services - $cons_bus_services;


            // $totalamount = $bus_services+$tuition_fee+$security_deposite+$development_fee+$exam_fee+$festival_celebration_fee+$games_sports_fee+$audio_visual_lab_fee+$library_fee+$electricity_maintenance_fee+$computer_fee+$admission_fee;


            // $dueAmount = $this->student_model->get_mnth_due_fee($id);
            $dueAmount = $studentFeeStructureModel
                ->select('
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
                    (fine + admission_fee + session_charges + security_deposite + tuition_fee) AS total
                ')
                ->where('id', $id)
                ->first();

            //$dueBusAmount = $this->student_model->get_due_bus_fee($id);

            // Admission related fees
            if (isset($dueAmount['ad_payment_status']) && $dueAmount['ad_payment_status'] == 0) {
                $totalamount += $tuition_fee+$security_deposite+$development_fee+$exam_fee+$festival_celebration_fee+$games_sports_fee+$audio_visual_lab_fee+$library_fee+$electricity_maintenance_fee+$computer_fee+$admission_fee;
            }

            // Bus fee
            if (isset($dueAmount['bus_payment_status']) && $dueAmount['bus_payment_status'] == 0) {
                $totalamount += $bus_services;
            }
    
            $payment_due_date = date('Y-m-d', strtotime($dueAmount['payment_due_date']));         
            $payment_due_date = $dueAmount['payment_due_date'];           
            
            $datetime1 = date_create($payment_due_date);
            $datetime2 = date_create($date);
            $interval = date_diff($datetime1, $datetime2);    
            $no_of_days = $interval->format("%R%a");
            
            $datetime3 = date('Y-m-d',strtotime($payment_due_date));
            $datetime4 = date('Y-m-d',strtotime($admsnDate));

            if($dueAmount['ad_payment_status'] == 0 && $datetime3 < $datetime4){
                $fine +=0;
            }elseif($dueAmount['ad_payment_status'] == 0 && $no_of_days>0){
                $fine += $no_of_days*$tuition_fine_per_month;   
            }else{
                $fine +=0;
            }

            $datetime5 = date('Y-m-d',strtotime($payment_due_date));
            $datetime6 = date('Y-m-d',strtotime($busDate));

            if($dueAmount['bus_payment_status'] == 0 && $admsnBusDates['stoppage'] != 0 && $datetime5 < $datetime6){
                $busFine +=0;
            }elseif($dueAmount['bus_payment_status'] == 0 && $admsnBusDates['stoppage'] != 0 && $no_of_days>0){             
                $busFine += $no_of_days*$bus_fine_per_month;    
            }else{
                $busFine +=0;
            }
            
            $amount += $totalamount;
            // $totalCalamount = (int)$amount+(int)$fine+(int)$busFine;
        }

        // ✅ AFTER LOOP
        $totalCalamount = (int)$amount + (int)$fine + (int)$busFine;

        $studentTransactionModel = new StudentTransactionModel();
        $stuTranDetails = $studentTransactionModel
                ->where('student_code', $sCode)
                ->where('session_year_id', $session_year_id)
                ->first();

        // $stuTranDetails = $studentTransactionModel->get_student_trans_details($sCode);
        
        if(isset($stuTranDetails['due_amount']) && $stuTranDetails['due_amount'] !=0){
            $due_amount = $stuTranDetails['due_amount'];      
        }else{
            $due_amount = 0;
        }
        
        if(isset($stuTranDetails['advanced_amount']) && $stuTranDetails['advanced_amount'] !=0){
            $adv_amount = $stuTranDetails['advanced_amount'];     
        }else{
            $adv_amount = 0;
        }
        
        $finalAmount = 0;
        $remainAdvAmount = 0;
        
        $finalAmount = $totalCalamount + $due_amount;
        
        if($adv_amount >= $finalAmount){
            $remainAdvAmount = $adv_amount-$finalAmount;
            $finalAmount = 0;
        }else{
            $finalAmount = $finalAmount-$adv_amount;
            $remainAdvAmount = 0;           
        }


        $session_pay_mnth_id = array(
            "session_pay_mnth_id"   => $pay_mnth_ids,
            "payment_amount"        => $finalAmount,
            "fine"                  => $fine,
            "bus_fee_fine"          => $busFine,    
            "due_amount"            => $due_amount,
            "adv_amount"            => $adv_amount,
            "final_adv_amount"      => $remainAdvAmount,
            "final_due_amount"      => 0
        );          
        session()->set($session_pay_mnth_id);
        
        $data['tuition_fine']       = $fine;
        $data['bus_fine']           = $busFine;     
        $data['totalCalamount']     = $finalAmount;     
        $data['due_amount']         = $due_amount;
        $data['adv_amount']         = $adv_amount;
        $data['final_adv_amount']   = $remainAdvAmount;
        $data['final_due_amount']   = 0;
        
        //pr($data);
        echo json_encode($data); exit();
    }

    /**
     * Handles AJAX admission payment update.
     *
     * This method processes admission and bus fee payments for selected fee rows.
     * It performs the following operations:
     *
     * 1. Retrieves session data and POST inputs (selected IDs, student code, form values).
     * 2. Loads student admission and bus allotment dates.
     * 3. Loads configuration settings such as tuition and bus fine per day.
     * 4. Processes advance payment usage (if any):
     *      - Marks advance usage in student record
     *      - Saves advance usage history (payment mode, cheque/pos/UPI details)
     * 5. Iterates over each selected fee structure ID:
     *      - Fetches student's fee structure record for the current session
     *      - Calculates remaining unpaid academic and bus charges
     *      - Calculates late fines based on due date, current date, admission date,
     *        and bus allotment date
     *      - Combines academic fee, bus fee, previous payment amount, and fines
     *      - Prepares and sets updated values including payment details and timestamps
     *      - Updates the fee structure row in the database
     * 6. Returns the result of the last update as an AJAX response.
     *
     * @since 1.0.0
     *
     * @return void Outputs the update result (0/1) and exits.
     */

    function ajax_update_admission_payment()
    {
        $session_year_id = $this->session->get('session_year_id');
        // pr($session_year_id);

        $selId = [];
        $advPayData = [];
        $selId = $this->request->getPost('selId');
        $sCode = $this->request->getPost('sCode');
        $result = 0;
        
        $tuition_fine_per_month = 0;
        $bus_fine_per_month = 0;
        $formData = [];
        $updata = [];       
        $formData = $this->request->getPost('value');
        foreach ($formData as $data) {
            $updata[$data['name']] =  $data['value'];           
        }
        
        $studentDetailsModel = new StudentDetailsModel();
        $admsnBusDates = $studentDetailsModel->get_admsn_bus_date($sCode);

        $date = date('Y-m-d');
        $admsnDate = $admsnBusDates['admission_date'] ?? '';
        $busDate = $admsnBusDates['bus_alloted_date'] ?? '';
        
        $updata_payment_amount = $updata['payment_amount'];
        unset($updata['payment_amount']);
        $adv_amount = $updata['adv_amount'];
        unset($updata['adv_amount']);

        $configurationModel = new ConfigurationModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();

        $tuition_fine_per_month = $configurationModel->get_configuration_by_key('tuition_fee_fine_per_month');
        $bus_fine_per_month = $configurationModel->get_configuration_by_key('bus_fee_fine_per_month');
        
        if($adv_amount > 0){
            $updata['adv_bal_used'] = 1;
            $advPayData['applied_date'] = date('Y-m-d h:m:s');
            $advPayData['s_code'] = $sCode;
            $advPayData['amount'] = $adv_amount;
            
            $advPayData['payment_mode'] = $updata['ad_payment_mode'];
            $advPayData['cheque_number'] = $updata['cheque_number'] ?? '';
            $advPayData['pos_bank_name'] = $updata['pos_bank_name'] ?? '';
            $advPayData['pos_reference_number'] = $updata['pos_reference_number'] ?? '';
            $advPayData['payee_name'] = $updata['payee_name'];
            $advPayData['t_user_id'] = $updata['t_user_id'];
            $advPayData['added_by'] = $updata['added_by'];
            
            // Insert Advance Payment History
            $advancePaymentUseHistoryModel = new AdvancePaymentUseHistoryModel();

            // echo "<pre>"; print_r("Advance Payment Data");
            // pr($advPayData);
            $advancePaymentInsertId = $advancePaymentUseHistoryModel->insert($advPayData);            
        }

        foreach($selId as $id){
            $fine = 0;
            $busFine = 0;

            $get_student_fee_structure_details = $studentFeeStructureModel
                ->where('id', $id)
                ->where('session_year_id', $session_year_id)
                ->groupStart()
                    ->where('ad_payment_status', 0)
                    ->orWhere('bus_payment_status', 0)
                ->groupEnd()
                ->first();

            // Calculated Academic and Bus Fee start 
            $cons_admission_fee = $get_student_fee_structure_details['cons_admission_fee'] ?? 0;   
            $cons_development_fee = $get_student_fee_structure_details['cons_development_fee'] ?? 0;
            $cons_exam_fee = $get_student_fee_structure_details['cons_exam_fee'] ?? 0;
            $cons_festival_celebration_fee = $get_student_fee_structure_details['cons_festival_celebration_fee'] ?? 0;
            $cons_games_sports_fee = $get_student_fee_structure_details['cons_games_sports_fee'] ?? 0;
            $cons_audio_visual_lab_fee = $get_student_fee_structure_details['cons_audio_visual_lab_fee'] ?? 0;
            $cons_library_fee = $get_student_fee_structure_details['cons_library_fee'] ?? 0;
            $cons_electricity_maintenance_fee = $get_student_fee_structure_details['cons_electricity_maintenance_fee'] ?? 0;
            $cons_computer_fee = $get_student_fee_structure_details['cons_computer_fee'] ?? 0;
            $cons_security_deposite = $get_student_fee_structure_details['cons_security_deposite'] ?? 0;
            $cons_tuition_fee = $get_student_fee_structure_details['cons_tuition_fee'] ?? 0;
            $cons_bus_services = $get_student_fee_structure_details['cons_bus_services'] ?? 0;

            $init_admission_fee = $get_student_fee_structure_details['admission_fee'] ?? 0;
            $init_development_fee = $get_student_fee_structure_details['development_fee'] ?? 0;
            $init_exam_fee = $get_student_fee_structure_details['exam_fee'] ?? 0;
            $init_festival_celebration_fee = $get_student_fee_structure_details['festival_celebration_fee'] ?? 0;
            $init_games_sports_fee = $get_student_fee_structure_details['games_sports_fee'] ?? 0;
            $init_audio_visual_lab_fee = $get_student_fee_structure_details['audio_visual_lab_fee'] ?? 0;
            $init_library_fee = $get_student_fee_structure_details['library_fee'] ?? 0;
            $init_electricity_maintenance_fee = $get_student_fee_structure_details['electricity_maintenance_fee'] ?? 0;
            $init_computer_fee = $get_student_fee_structure_details['computer_fee'] ?? 0;
            $init_security_deposite = $get_student_fee_structure_details['security_deposite'] ?? 0;
            $init_tuition_fee = $get_student_fee_structure_details['tuition_fee'] ?? 0;
            $init_bus_services = $get_student_fee_structure_details['bus_services'] ?? 0;

            $suncons = $cons_admission_fee+$cons_development_fee+$cons_exam_fee+$cons_festival_celebration_fee+$cons_games_sports_fee+$cons_audio_visual_lab_fee+$cons_library_fee+$cons_electricity_maintenance_fee+$cons_computer_fee+$cons_security_deposite+$cons_tuition_fee+$cons_bus_services;
            
            //admission_charge
            $admission_fee = $init_admission_fee-$cons_admission_fee;
            //development_fee
            $development_fee = $init_development_fee-$cons_development_fee;
            //exam_fee
            $exam_fee = $init_exam_fee-$cons_exam_fee;
            //festival_celebration_fee
            $festival_celebration_fee = $init_festival_celebration_fee-$cons_festival_celebration_fee;
            //games_sports_fee
            $games_sports_fee = $init_games_sports_fee-$cons_games_sports_fee;
            //audio_visual_lab_fee
            $audio_visual_lab_fee = $init_audio_visual_lab_fee-$cons_audio_visual_lab_fee;
            //library_fee
            $library_fee = $init_library_fee-$cons_library_fee;
            //electricity_maintenance_fee
            $electricity_maintenance_fee = $init_electricity_maintenance_fee-$cons_electricity_maintenance_fee;
            //computer_fee
            $computer_fee = $init_computer_fee-$cons_computer_fee;
            //security_deposite
            $security_deposite = $init_security_deposite-$cons_security_deposite;
            //tution
            $tuition_fee = $init_tuition_fee-$cons_tuition_fee;
            //bus service
            $bus_services = $init_bus_services-$cons_bus_services;
            
            // Calculated Academic and Bus Fee end
            
            $dueAmount = $studentFeeStructureModel
                ->select('
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
                    (fine + admission_fee + session_charges + security_deposite + tuition_fee) AS total
                ')
                ->where('id', $id)
                ->first();

            // $dueAmount = $this->student_model->get_mnth_due_fee($id);
            // $dueBusAmount = $this->student_model->get_due_bus_fee($id);

            // =========================
            // ✅ UPDATED: Conditional Fee Calculation
            // =========================
            $academicTotal = $tuition_fee+$security_deposite+$development_fee+$exam_fee+$festival_celebration_fee+$games_sports_fee+$audio_visual_lab_fee+$library_fee+$electricity_maintenance_fee+$computer_fee+$admission_fee;
            $busTotal = $bus_services;

            $totalamount = 0;
            if (isset($dueAmount['ad_payment_status']) && $dueAmount['ad_payment_status'] == 0) {
                $totalamount += $academicTotal;
            }

            if (isset($dueAmount['bus_payment_status']) && $dueAmount['bus_payment_status'] == 0) {
                $totalamount += $busTotal;
            }

            $payment_due_date = date('Y-m-d', strtotime($dueAmount['payment_due_date']));         
            $payment_due_date = $dueAmount['payment_due_date'];           
            
            $datetime1 = date_create($payment_due_date);
            $datetime2 = date_create($date);
            $interval = date_diff($datetime1, $datetime2);
    
            $no_of_days = $interval->format("%R%a");
            
            $datetime3 = date('Y-m-d',strtotime($payment_due_date));
            $datetime4 = date('Y-m-d',strtotime($admsnDate));


            if($dueAmount['ad_payment_status'] == 0 && $datetime3 < $datetime4){
                $fine +=0;
            }elseif($dueAmount['ad_payment_status'] == 0 && $no_of_days>0){
                $fine += $no_of_days*$tuition_fine_per_month;   
            }else{
                $fine +=0;
            }
            
            $datetime5 = date('Y-m-d',strtotime($payment_due_date));
            $datetime6 = date('Y-m-d',strtotime($busDate));

            if($dueAmount['bus_payment_status'] == 0 && $admsnBusDates['stoppage'] != 0 && $datetime5 < $datetime6){
                $busFine +=0;
            }elseif($dueAmount['bus_payment_status'] == 0 && $admsnBusDates['stoppage'] != 0 && $no_of_days>0){             
                $busFine += $no_of_days*$bus_fine_per_month;    
            }else{
                $busFine +=0;
            }
        
            
            $payment_amount = 0;
            $updata['payment_amount'] = 0;
            $payment_amount = $dueAmount['payment_amount'] ?? 0;
            $updata['payment_amount'] = $payment_amount+$totalamount+$fine+$busFine;
            
            if($totalamount > 0 && $dueAmount['ad_payment_status'] == 0){              
                $updata['academic_payment_amt'] = $totalamount;
                $updata['fine'] = $fine;           
                $updata['created_date'] = date('Y-m-d h:m:s');                  
            }
            
            $updata['bus_payment_status'] = 0;

            if($dueAmount['bus_payment_status'] == 0 && $bus_services > 0){
                $updata['bus_payment_status'] = 1;
                $updata['bus_payment_amt'] = $bus_services;
                $updata['bus_fee_fine'] = $busFine;
                $updata['bus_payment_mode'] = $updata['ad_payment_mode'];
                $updata['bus_cheque_number'] = $updata['cheque_number'] ?? '';
                $updata['bus_pos_bank_name'] = $updata['pos_bank_name'] ?? '';
                $updata['bus_pos_reference_number'] = $updata['pos_reference_number'] ?? '';
                $updata['bus_payee_name'] = $updata['payee_name'];
                $updata['bus_t_user_id'] = $updata['t_user_id'];
                $updata['bus_added_by'] = $updata['added_by'];
                $updata['bus_payment_date'] = date('Y-m-d h:m:s');
            }

            /**
             * If academic (admission) payment is already completed,
             * then this request is ONLY for bus fee payment.
             * So remove all academic-related fields to prevent overwriting
             * or re-processing admission payment data.
             * */
            if( isset($dueAmount['ad_payment_status']) && $dueAmount['ad_payment_status'] == 1) {
                unset($updata['fine']);
                unset($updata['payee_name']);
                unset($updata['ad_payment_mode']);
                unset($updata['ad_payment_status']);
                unset($updata['t_user_id']);
                unset($updata['added_by']);
            }
            
            // Update Payment Data
            // echo "<pre>"; print_r($id);
            // echo "<pre>"; print_r($updata);
            // pr($updata);
            $result = $studentFeeStructureModel->update_admission_payment($id, $updata);
        }
        
        echo $result; exit();
    }

    /**
     * Updates student transaction details via AJAX request.
     *
     * This method receives posted transaction values such as:
     * - Advanced amount
     * - Due amount
     * - Admission payment status
     * and updates the corresponding student transaction record.
     *
     * Workflow:
     * 1. Collect POST data (`adv_amount`, `due_amount`, `ad_payment_status`, `sCode`).
     * 2. Prepare an update array with transaction values.
     * 3. Call `updateStudentTransDetail()` on the StudentTransactionModel to save the changes.
     * 4. Redirect back to the student fee structure view page.
     *
     * @since 1.0.0
     *
     * @return void Redirects to the student fee structure page after update.
     */
    public function ajax_update_student_trans_detail(){
        $data['advanced_amount'] = $this->request->getPost('adv_amount');
        $data['due_amount'] = $this->request->getPost('due_amount');
        $data['ad_payment_status'] = $this->request->getPost('ad_payment_status');
        $sCode = $this->request->getPost('sCode');

        $studentTransactionModel = new StudentTransactionModel();
        $result = $studentTransactionModel->updateStudentTransDetail($sCode,$data);

        echo $result; exit();
        // redirect('admin/student/view-fee-structure/'.$sCode);
    }

    function ajax_student_monthly_paid_fee_invoice()
    {
        $html = '';

        $studentModel = new StudentModel();
        $studentDetailsModel = new StudentDetailsModel();
        $studentFeeInvoiceModel = new StudentFeeInvoiceModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();

        $feeId = $this->request->getPost('feeId');
        $formNo = $this->request->getPost('formNo');
        $student_code = $this->request->getPost('sCode');
        $studentId = $this->request->getPost('studentId');
        $session_year_id = $this->session->get('session_year_id');

        // $student_details = $studentDetailsModel->get_student_details_against_form_no($formNo);
        $student_details = [];
        if( isset($formNo) && !empty($formNo) ) {
            $student_details = $studentDetailsModel->get_student_details_against_form_no($formNo);
        } elseif( isset($studentId) && $studentId != '' ) {
            $student_details = $studentModel->get_student_details_by_id($studentId);
        }

        $feePaymentDetails = $studentFeeStructureModel
                ->where('id', $feeId)
                ->where('session_year_id', $session_year_id)
                ->first();

        $student_details_id = $student_details['student_details_id'] ?? '';
        $student_id = $student_details['student_id'] ?? '';
        $student_first_name = $student_details['first_name'] ?? '';
        $student_middle_name = $student_details['middle_name'] ?? '';
        $student_surname = $student_details['surname'] ?? '';
        $roll_num = $student_details['roll_num'] ?? '';
        $class_name = $student_details['class_name'] ?? '';
        $class_id = $student_details['class_id'] ?? '';
        $section_name = $student_details['section_name'] ?? '';

        // $formatted_date = $feePaymentDetails['month_id'] ? date("F", mktime(0, 0, 0, $feePaymentDetails['month_id'], 1)) : '';
        $formatted_date = $feePaymentDetails['created_date'] ? date('d-m-Y', strtotime($feePaymentDetails['created_date'])) : '';
        $payment_mode = $feePaymentDetails['ad_payment_mode'] ? ucfirst($feePaymentDetails['ad_payment_mode']) : '';
        $tuition_fee = $feePaymentDetails['tuition_fee'] ?? 0;

        $transaction_no = ''; // Came from student_fee_structure table
        if(isset($feePaymentDetails['transaction_no']) && $feePaymentDetails['transaction_no'] !=""){
            $db_transaction_no = $feePaymentDetails['transaction_no'];
            $transaction_no = substr($db_transaction_no, 0, 4) . '***' . substr($db_transaction_no,  -4);
        }else{
            if( isset($feePaymentDetails['pos_reference_number']) && $feePaymentDetails['pos_reference_number'] !="" ) {
                $transaction_no = 'APPR'.$feePaymentDetails['pos_reference_number'];
            } else {
                $transaction_no = 'APPR/'.$session_year_id.'/'.$feePaymentDetails['id'];
            }
        }

        $barcode =  $student_code.'/'.$class_id.'/'.$student_id;

        // pr($feePaymentDetails);
        
        $html = '<div style="font-size:12px !important;">
            <div style="width:100%;clear:both;min-height:70px;">
                <div style="width:15%;float:left;text-align:center">
                    <img width="50" src="'. base_url('public/img/Satish-Chandra-Memorial-School-Nadia-West-Bengal.png') .'">
                </div>
                <div style="width:45%;float:left;text-align:center">
                    <div style="width:100%;float:left;">
                        <span class="invoice-info-label">Bill No:</span>
                        <span class="red">' . $barcode .'</span>
                    </div>
                </div>
                <div style="width:40%;float:left;text-align:center">
                    <strong class="widget-title grey lighter">SATISH CHANDRA MEMORIAL SCHOOL<br>PUMLIA, CHOWRASTA, CHAKDAHA</strong>
                </div>
            </div>
            <div style="width:100%;clear:both;min-height:40px">
                <div style="width:35%;float:left;"><b>Name:</b> '. $student_first_name .' '. $student_middle_name .' '. $student_surname .'</div>
                <div style="width:35%;float:left;"><b>Student ID:</b> '. $student_code .'</div>
                <div style="width:35%;float:left;"><b>Class:</b> '. $class_name .'</div>
                <div style="width:35%;float:left;"><b>Section:</b> '. $section_name .'</div>
                <div style="width:30%;float:left;"><b>Roll No:</b> '. $roll_num .'</div>
                <div style="width:35%;float:left;"><b>Date:</b> '. $formatted_date .'</div>
                <div style="width:35%;float:left;"><b>Transaction No:</b> '. $transaction_no .'</div>
            </div>
        </div>

        <div class="">
            <div class="">                      
                <div>
                    <table class="table" style="font-size:12px !important;">
                        <tbody>
                            <tr><td></td><td>Rs. P.<br>------</td></tr>';
                            if($tuition_fee >0 ){ 
                                $html .= '<tr><td style="padding: 0px;">TUTION FEE ('. $formatted_date .')</td><td style="padding: 0px;">'. $tuition_fee .'</td></tr>';
                            }


                            $html .= '<tr><td style="text-align: right;"> Fees Collected Amount : </td><td>'.number_format($tuition_fee,2).' ('. ucwords(convert_number_to_words($tuition_fee)) .')</td></tr>';
                            $html .= '<tr><td style="text-align: right;"> Payment Mode : </td><td>'.$payment_mode.'</td></tr>';

                        $html .= '</tbody>
                    </table>
                </div>';


                $html .='<div class="space"></div>
                <div class="row" style="margin-top:5px !important;">
                    <div class="col-sm-6" style="float:left">
                        <span style="text-align:left">-------------------------</span><br />
                        <span style="text-align:left">Printed By :'. session()->get('f_name') .'</span>
                    </div>
                    <div class="col-sm-6" style="float:left">
                        <span style="float:right">-------------------------</span><br />';
                        if($feePaymentDetails['ad_payment_mode'] == 'Online'){
                            $html .= '<span style="float:right;text-align: center">Receipt through online<br>This is a system generated receipt,<br>signature & stamp not require</span>';
                        }elseif($feePaymentDetails['ad_payment_mode'] == 'CCAvenue'){
                            $html .= '<span style="float:right;text-align: center">Receipt through online<br>This is a system generated receipt,<br>signature & stamp not require</span>';
                        }else{
                            $html .= '<span style="float:right">Collected By :'. $feePaymentDetails['added_by'] .'</span>';
                        }
                    $html .='</div>';
                $html .= '</div>';

            $html .='</div>
        </div>';

        $data["html"]= $html;
        echo json_encode($data);
        exit();
    }

    function ajax_student_paid_bus_fee_invoice()
    {
        $studentDetailsModel = new StudentDetailsModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();

        $html = '';

        $formNo = $this->request->getPost('formNo') ?? '';
        $feeId = $this->request->getPost('feeId') ?? '';
        $student_code = $this->request->getPost('sCode') ?? '';

        $student_details = $studentDetailsModel->get_student_details_by_code($student_code);
        $getClassId = $student_details['class_id'] ?? '';
        $getSectionId = $student_details['section_id'] ?? '';
        $getRollNum = $student_details['roll_num'] ?? '';

        $student_name = ($student_code != '') ? student_name_by_code($student_code) : '';
        $class_name = ($getClassId != '') ? get_class_name_by_id($getClassId) : '';
        $section_name = ($getSectionId != '') ? section_name_by_id($getSectionId) : '';


        $feeDetails = $studentFeeStructureModel->asArray()->find($feeId);
        $get_created_date = !empty($feeDetails['created_date']) ? date('d-m-Y', strtotime($feeDetails['created_date'])) : '';
        $get_month_id = $feeDetails['month_id'] ?? '';
        $month_name = ($get_month_id != '') ? month_name($get_month_id) : '';
        $init_bus_services = $feeDetails['bus_services'] ?? 0;
        $cons_bus_services = $feeDetails['cons_bus_services'] ?? 0;
        $bus_payment_date = $feeDetails['bus_payment_date'] ?? '';
        $bus_payment_mode = $feeDetails['bus_payment_mode'] ?? '';
        $adv_bal_used = $feeDetails['adv_bal_used'] ?? 0;
        $bus_payment_amt = $feeDetails['bus_payment_amt'] ?? 0;

        $bus_services = $init_bus_services - $cons_bus_services;
        $total = $bus_payment_amt; // Need To add Bus Fine

        $busFine = $feeDetails['bus_fee_fine'] ?? 0;
        $ad_payment_status = $feeDetails['ad_payment_status'] ?? '';
        $bus_payment_status = $feeDetails['bus_payment_status'] ?? '';
        $bus_added_by = $feeDetails['bus_added_by'] ?? '';

        $totalCalamount = (int)$total + (int)$busFine;

        $barcode =  $class_name . '-'. $get_month_id .'-'. $feeId;
        $transaction_no = '';
        if( $feeDetails['transaction_no'] !=""){
            $db_transaction_no = $feeDetails['transaction_no'];
            $transaction_no = substr($db_transaction_no, 0, 4) . '***' . substr($db_transaction_no,  -4);
        }else{
            $transaction_no = 'APPR'.$feeDetails['bus_pos_reference_number'];   
        }

        // pr($feeDetails);

        $html = '<div style="font-size:12px !important;">
            <div style="width:100%;clear:both;min-height:70px;">
                <div style="width:15%;float:left;text-align:center">
                    <img width="50" src="'. base_url('public/img/Satish-Chandra-Memorial-School-Nadia-West-Bengal.png') .'">
                </div>
                <div style="width:45%;float:left;text-align:center">
                    <div style="width:100%;float:left;">
                        <span class="invoice-info-label">Bill No:</span><span class="red">'. $barcode .'</span>
                    </div>
                </div>                      
                <div style="width:40%;float:left;text-align:center"><Strong class="widget-title grey lighter">SATISH CHANDRA MEMORIAL SCHOOL<br>PUMLIA, CHOWRASTA, CHAKDAHA</Strong></div>
            </div>                  
            <div style="width:100%;clear:both;min-height:40px">
                <div style="width:100%;clear:both;">
                    <div style="width:35%;float:left;">
                        <b> Name : </b>'. $student_name .'
                    </div>
                    <div style="width:35%;float:left;">
                        <b>Student ID : </b>'. $student_code .'
                    </div>                          
                </div>                      
                <div style="width:100%;clear:both;">
                    <div style="width:35%;float:left;">
                        <b>Class : </b>'. $class_name .'
                    </div>
                    <div style="width:35%;float:left;">
                        <b>Section : </b>'. $section_name .'
                    </div>
                    <div style="width:30%;float:left;">
                        <b>Roll No : </b>'. $getRollNum .'
                    </div>
                </div>
                <div style="width:100%;clear:both;">
                    <div style="width:35%;float:left;">                         
                        <b>Date : </b>'. $get_created_date .'                            
                    </div>
                    <div style="width:35%;float:left;">                         
                        <b>Transaction No : </b>'. $transaction_no .'                            
                    </div>
                </div>
            </div>                  
        </div>
        <div class="">
            <div class="">                      
                <div>
                    <table class="table" style="font-size:12px !important;">
                        <tbody>
                            <tr><td></td><td>Rs. P.<br>------</td></tr>';
                    
                     
                            if($init_bus_services > 0 ){ 
                                $html .= '<tr><td style="padding: 0px;">BUS FARE('. $bus_payment_date .')('. $bus_payment_mode .') </td><td style="padding: 0px;">'. $bus_payment_amt .'</td></tr>';
                            }

                            $html .= ' <tr><td style="text-align: right;">Total : </td><td>'.number_format($bus_payment_amt,2) .' '.($adv_bal_used == 1? '(Advanced Balance Used)':''). '</td></tr>';
                    
                    
                            if( $busFine > 0 ){ 
                                $html .= ' <tr><td style="text-align: right;">Bus Fine : </td><td>'.number_format($busFine,2).'</td></tr>';
                            }
                    
                            $html .= ' <tr><td style="text-align: right;">Collected Amount : </td><td>'.number_format($totalCalamount,2).'</td></tr>';
                        $html .= '</tbody>
                    </table>
                </div>
                <p>Rupees (in words) : '. convert_number_to_words($totalCalamount) .'</br>Payment Mode : '. $bus_payment_mode .' <br />Payment Month : '.$month_name.'</p>  

                <div class="hr hr8 hr-double hr-dotted">-------------------------------------------------------------------------------------------------------------------------------------</div>                                           
                <p style="display:flex; justify-content:space-between; align-items:flex-start; font-size:12px;">
                    <span style="display:flex; gap:10px;">
                        <span><strong>Printed By :</strong> '. $this->session->get('f_name') .'</span>
                        <span><strong>Collected By :</strong> '. $bus_added_by .'</span>
                    </span>';
                        
                    if($bus_payment_mode == 'Online'){
                        $html .= '<span style="text-align: right">Receipt through online<br>This is a system generated receipt,signature & stamp not require</span>';
                    }elseif($bus_payment_mode == 'CCAvenue'){
                        $html .= '<span style="text-align: right">Receipt through online<br>This is a system generated receipt,signature & stamp not require</span>';
                    }
                    $html .= '<span style="text-align: right">Receipt through online<br>This is a system generated receipt,signature & stamp not require</span>';

                        
                $html .='</p>
                <div class="hr hr8 hr-double hr-dotted">-------------------------------------------------------------------------------------------------------------------------------------</div>
            </div>
        </div>';

        // pr($html);

        $data["html"]= $html;
        echo json_encode($data);
        exit();
    }

    function ajax_student_update_fees_payment_mode()
    {
        $fees_payment_id = $this->request->getPost('id');
        $payment_mode = $this->request->getPost('paymentMode');
        $isChecked = $this->request->getPost('isChecked');

        if (!$fees_payment_id) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid ID'
            ]);
        }

        if (!$payment_mode) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid Payment Mode'
            ]);
        }

        $update_data['ad_payment_mode'] = $payment_mode;

        $studentFeeStructureModel = new StudentFeeStructureModel();
        $update =  $studentFeeStructureModel->where('id', $fees_payment_id)->set($update_data)->update();

        if ($update) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Payment mode updated successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update payment mode.'
            ]);
        }
    }

    public function ajax_student_update_bus_payment_mode()
    {
        $fees_payment_id = $this->request->getPost('id');
        $payment_mode = $this->request->getPost('paymentMode');
        $isChecked = $this->request->getPost('isChecked');

        if (!$fees_payment_id) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid ID'
            ]);
        }

        if (!$payment_mode) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid Payment Mode'
            ]);
        }

        $update_data['bus_payment_mode'] = $payment_mode;

        $studentFeeStructureModel = new StudentFeeStructureModel();
        $update =  $studentFeeStructureModel->where('id', $fees_payment_id)->set($update_data)->update();

        if ($update) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Payment mode updated successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update payment mode.'
            ]);
        }
    }

    function student_section_upload()
    {
        $data['title'] = "Student Section Upload";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        echo view('admin/student/student-section-upload', $data);
        echo view('admin/common/footer', $data);
    }

    function ajax_upload_student_section()
    {
        // Validate CSRF token if enabled
        if ($this->request->getPost()) {
            // Check if file is uploaded
            if (!isset($_FILES['studentfile'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No file uploaded.'
                ]);
                return;
            }
            
            $file = $this->request->getFile('studentfile');
            
            // Validate file
            if (!$file->isValid()) {
                echo json_encode([
                    'status' => 'error',
                    'message' => $file->getErrorString()
                ]);
                return;
            }
            
            // Validate file extension
            if ($file->getClientExtension() !== 'csv') {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Only CSV files are allowed.'
                ]);
                return;
            }
            
            // Validate file size (max 5MB)
            if ($file->getSize() > 5242880) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'File size should not exceed 5MB.'
                ]);
                return;
            }
            
            // Move uploaded file
            $uploadPath = WRITEPATH . 'uploads/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $newName = $file->getRandomName();
            
            if ($file->move($uploadPath, $newName)) {
                // Process CSV file
                $filePath = $uploadPath . $newName;
                
                // Parse CSV and process data
                $processed = $this->processStudentSectionCSV($filePath);
                
                if ($processed) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Student section data uploaded successfully.',
                        'data' => $processed
                        // 'redirect' => base_url('students/list') // Optional redirect
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Failed to process CSV file.'
                    ]);
                }
                
                // Clean up uploaded file
                unlink($filePath);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to upload file.'
                ]);
            }
        }
    }

    private function processStudentSectionCSVOld($filePath)
    {
        try {
            $successCount = 0;
            $failedCount = 0;
            $errors = [];
            
            // Open and read the CSV file
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $row = 0;
                
                // Read CSV headers
                $headers = fgetcsv($handle, 1000, ",");
                
                // Validate CSV headers
                if (!in_array('Code', $headers) || !in_array('Section', $headers)) {
                    fclose($handle);
                    return [
                        'success' => false,
                        'message' => 'CSV file must contain "Code" and "Section" columns.',
                        'processed' => 0,
                        'failed' => 0
                    ];
                }
                
                // Get current session year (adjust based on your logic)
                $currentSessionId = $this->session->get('session_year_id');
                
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    echo "<pre>"; print_r($data);
                    $row++;
                    
                    // Skip empty rows
                    if (empty(array_filter($data))) {
                        continue;
                    }
                    
                    // Map CSV columns to data
                    $studentCode = trim($data[0]);
                    $sectionName = trim($data[1]);
                    
                    // Validate required fields
                    if (empty($studentCode) || empty($sectionName)) {
                        $errors[] = "Row {$row}: Student Code and Section are required";
                        $failedCount++;
                        continue;
                    }
                    
                    // 1. Check if student exists
                    $studentModel = new StudentModel();
                    $studentDetailsModel = new StudentDetailsModel();
                    $student = $studentModel
                        ->select('id, class_id, session_year_id')
                        ->where('code', $studentCode)
                        ->where('session_year_id', $currentSessionId)
                        ->get()
                        ->getRow();
                    
                    if (!$student) {
                        $errors[] = "Row {$row}: Student with code '{$studentCode}' not found";
                        $failedCount++;
                        continue;
                    }
                    
                    // 2. Get section ID based on section name, class_id, and session_year_id
                    $sectionModel = new SectionModel();
                    $section = $sectionModel
                        ->select('id')
                        ->where('section_name', $sectionName)
                        ->where('class_id', $student->class_id)
                        ->where('session_year_id', $student->session_year_id)
                        ->get()
                        ->getRow();
                    
                    if (!$section) {
                        // Option 1: Skip if section doesn't exist
                        $errors[] = "Row {$row}: Section '{$sectionName}' not found for Class ID {$student->class_id} and Session {$student->session_year_id}";
                        $failedCount++;
                        continue;
                    } else {
                        $sectionId = $section->id;
                    }
                    
                    // 3. Update student's section_id
                    $updateData = [
                        'section_id' => $sectionId
                    ];

                    // $updated = $studentModel
                    //     ->where('id', $student->id)
                    //     ->update($updateData);

                    $updated = $studentModel->where('id', $student->id)->update(['section_id' => $sectionId]);
                    
                    if ($updated) {
                        $detailsUpdated = $studentDetailsModel->where('student_id', $student->id)->update(['section_id' => $sectionId]);
                        
                        $successCount++;
                    } else {
                        $errors[] = "Row {$row}: Failed to update section for student '{$studentCode}'";
                        $failedCount++;
                    }
                }
                
                fclose($handle);
                echo "<pre>"; print_r($successCount);
                echo "<pre>"; print_r($failedCount);
                echo "<pre>"; print_r($errors);
                pr("Bubai 1");
                return [
                    'success' => true,
                    'message' => "CSV processing completed. Success: {$successCount}, Failed: {$failedCount}",
                    'processed' => $successCount,
                    'failed' => $failedCount,
                    'errors' => $errors
                ];
            }
            pr("Bubai 2");
            return [
                'success' => false,
                'message' => 'Failed to open CSV file',
                'processed' => 0,
                'failed' => 0
            ];
            
        } catch (\Exception $e) {
            log_message('error', 'CSV Processing Error: ' . $e->getMessage());

            echo "<pre>"; print_r('CSV Processing Error: ' . $e->getMessage());
            pr("Bubai 3");
            return [
                'success' => false,
                'message' => 'Error processing CSV: ' . $e->getMessage(),
                'processed' => 0,
                'failed' => 0
            ];
        }
    }

    private function processStudentSectionCSV($filePath)
    {
        $successCount = 0;
        $failedCount  = 0;
        $errors       = [];

        $studentModel = new StudentModel();
        $studentDetailsModel = new StudentDetailsModel();
        $sectionModel = new SectionModel();

        if (($handle = fopen($filePath, 'r')) === false) {
            return [
                'success'   => false,
                'message'   => 'Failed to open CSV file',
                'processed' => 0,
                'failed'    => 0,
            ];
        }

        // Read CSV headers
        $headers = fgetcsv($handle, 1000, ',');

        if (!$headers || !in_array('Student Code', $headers) || !in_array('Section', $headers)) {
            fclose($handle);
            return [
                'success'   => false,
                'message'   => 'CSV must contain "Student Code" and "Section" columns',
                'processed' => 0,
                'failed'    => 0,
            ];
        }

        // Safe header index mapping
        $codeIndex    = array_search('Student Code', $headers);
        $sectionIndex = array_search('Section', $headers);

        $currentSessionId = session()->get('session_year_id');


        while (($data = fgetcsv($handle, 1000, ',')) !== false) {

            if (empty(array_filter($data))) {
                continue;
            }

            $studentCode = trim($data[$codeIndex] ?? '');
            $sectionName = trim($data[$sectionIndex] ?? '');

            if ($studentCode === '' || $sectionName === '') {
                $failedCount++;
                $errors[] = 'Student Code or Section missing';
                continue;
            }

            // Fetch student
            $student = $studentModel
                ->select('id, class_id, session_year_id, section_id')
                ->where('code', $studentCode)
                ->where('session_year_id', $currentSessionId)
                ->get()
                ->getRow();

            if (!$student) {
                $failedCount++;
                $errors[] = "Student not found: {$studentCode}";
                continue;
            }

            // Fetch section
            $section = $sectionModel
                ->select('id')
                ->where('section_name', $sectionName)
                ->where('class_id', $student->class_id)
                ->where('session_year_id', $student->session_year_id)
                ->get()
                ->getRow();

            if (!$section) {
                $failedCount++;
                $errors[] = "Section '{$sectionName}' not found for {$studentCode}";
                continue;
            }

            // Check if student_details record exists
            $studentDetails = $studentDetailsModel->where('student_id', $student->id)->where('session_year_id', $currentSessionId)->first();
            
            // Skip if already same section
            if ((int)$student->section_id === (int)$section->id && (int)$studentDetails['section_id'] === (int)$section->id) {
                $successCount++;
                continue;
            }

            // pr($student->id);
            $result = $studentModel->update($student->id, ['section_id' => $section->id]);

            if ($studentDetails) {
                $resultDeatils = $studentDetailsModel->update(
                    $studentDetails['id'],  // Use primary key
                    ['section_id' => $section->id]
                );
            } else {
                // Handle case where student_details doesn't exist
                $failedCount++;
                $errors[] = "Student details not found for: {$studentCode}";
            }

            $successCount++;
        }
        
        fclose($handle);
        
        $result = [
            'success'   => true,
            'message'   => 'CSV processed successfully',
            'processed' => $successCount,
            'failed'    => $failedCount,
            'errors'    => $errors,
        ];
        
        return $result;
    }

    public function generate_class_id_card()
    {
        $data['title'] = "Generate Class ID Card";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        echo view('admin/student/generate-class-id-card', $data);
        echo view('admin/common/footer', $data);
    }

    public function ajax_generate_idcardOLD()
    {
        $class_id     = $this->request->getPost('class_id');
        $section_id   = $this->request->getPost('section_id');
        $student_code = $this->request->getPost('student_code');

        // 🔹 Fetch students from DB (example)
        $studentModel = new StudentModel();
        $students = $studentModel->getStudentsForIdCard($class_id, $section_id, $student_code);

        if (empty($students)) {
            return $this->response->setStatusCode(404);
        }

        $html = view('admin/student/idcard-pdf', [
            'students' => $students
        ]);

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => [86, 54], // ID card size (mm)
            'margin_left' => 2,
            'margin_right' => 2,
            'margin_top' => 2,
            'margin_bottom' => 2
        ]);

        $mpdf->WriteHTML($html);

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="student-id-card.pdf"')
            ->setBody($mpdf->Output('', 'S')); // IMPORTANT: return as string
    }

    public function ajax_generate_idcardIOLD() 
    {
        $class_id = $this->request->getPost('class_id');
        $section_id = $this->request->getPost('section_id');
        $student_code = $this->request->getPost('student_code');

        // Fetch students from DB
        $studentModel = new StudentModel();
        $students = $studentModel->getStudentsForIdCard($class_id, $section_id, $student_code);

        if (empty($students)) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'No students found']);
        }

        // Create HTML content
        $html = view('admin/student/idcard-pdf', [
            'students' => $students
        ]);

        // Create writable directory for mPDF if it doesn't exist
        $tempDir = FCPATH . 'mpdf_temp';
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        // Configure mPDF
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => [86, 54], // ID card size (mm)
            'margin_left' => 2,
            'margin_right' => 2,
            'margin_top' => 2,
            'margin_bottom' => 2,
            'tempDir' => $tempDir,
            'default_font' => 'dejavusans'
        ]);

        $mpdf->WriteHTML($html);
        
        // Get PDF content as string
        $pdfContent = $mpdf->Output('', 'S');
        
        // Return response
        return $this->response
            ->setContentType('application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="student-id-card.pdf"')
            ->setBody($pdfContent);
    }

    public function ajax_generate_idcard() 
    {
        $class_id = $this->request->getPost('class_id');
        $section_id = $this->request->getPost('section_id');
        $student_code = $this->request->getPost('student_code');

        // Fetch students from DB
        $studentModel = new StudentModel();
        $students = $studentModel->getStudentsForIdCard($class_id, $section_id, $student_code);

        if (empty($students)) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'No students found']);
        }

        // Create HTML content
        $html = view('admin/student/idcard-pdf', [
            'students' => $students
        ]);

        // Create writable directory for mPDF if it doesn't exist
        $tempDir = FCPATH . 'mpdf_temp';
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        // Configure mPDF - CRITICAL: Use 0 margins for ID card
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => [86, 54], // ID card size (mm) - width: 86mm, height: 54mm
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'tempDir' => $tempDir,
            'default_font' => 'dejavusans',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'useSubstitutions' => false,
            'img_dpi' => 300, // Higher quality for images
        ]);
        // pr($html);
        $mpdf->WriteHTML($html);
        
        // Get PDF content as string
        $pdfContent = $mpdf->Output('', 'S');
        
        // Return response
        return $this->response
            ->setContentType('application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="student-id-card.pdf"')
            ->setBody($pdfContent);
    }

    public function generateStudentIdcard($class_id, $section_id = null, $student_code = null)
    {
        // Normalize optional params
        $section_id   = ($section_id == 0) ? null : $section_id;
        $student_code = ($student_code == '0') ? null : $student_code;

        $studentModel = new StudentModel();
        $students = $studentModel->getStudentsForIdCard($class_id, $section_id, $student_code);

        

        $html = view('admin/student/idcard-pdf', [
            'students'   => $students,
            'session_id' => session('session_year_id')
        ]);

        pr($html);
    }

    /**
     * =============================================================================
     * Handle File Upload
     * =============================================================================
     * **/
    private function handleFileUpload($fieldName, $studentCode, $overwrite = false)
    {
        if (strpos($studentCode, '/') !== false) {
            $studentCode = str_replace('/', '_', $studentCode);
        }

        $file = $this->request->getFile($fieldName);
        
        // Check if file was uploaded and has no errors
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // ---------- FILE SIZE VALIDATION ----------
            $fileSize = $file->getSize(); // bytes

            $minSize = 20 * 1024;   // 20 KB
            $maxSize = 200 * 1024;  // 200 KB

            if ($fileSize < $minSize || $fileSize > $maxSize) {
                return [
                    'status' => 'error',
                    'message' => 'Image size must be between 20 KB and 200 KB'
                ];
            }

            // Build target path: writable/uploads/students/{studentCode}
            $basePath = FCPATH . 'uploads';
            $targetPath = $basePath . DIRECTORY_SEPARATOR . $studentCode;

            // Create directory if it doesn't exist
            if (!is_dir($targetPath)) {
                if (!mkdir($targetPath, 0775, true)) {
                    return [
                        'status' => 'error',
                        'message' => 'Failed to create destination folder.'
                    ];
                }
            }

            // Choose a safe filename (keep original, but avoid collisions)
            $originalName = $file->getClientName();
            $safeName = preg_replace('~[^A-Za-z0-9_.\-]~', '_', $originalName);
            $destination = $targetPath . DIRECTORY_SEPARATOR . $safeName;

            // Check if file exists and create unique name if needed
            if (file_exists($destination) && !$overwrite) {
                $nameNoExt = pathinfo($safeName, PATHINFO_FILENAME);
                $ext = $file->getExtension();
                $safeName = $nameNoExt . '_' . date('Ymd_His') . '.' . $ext;
                $destination = $targetPath . DIRECTORY_SEPARATOR . $safeName;
            }

            // Move the file
            try {
                $file->move($targetPath, $safeName, $overwrite);
                
                return [
                    'status' => 'success',
                    'filename' => $safeName,
                    'filepath' => $studentCode . DIRECTORY_SEPARATOR . $safeName,
                    'message' => 'File uploaded successfully'
                ];
                
            } catch (\Throwable $e) {
                return [
                    'status' => 'error',
                    'message' => 'Upload failed: ' . $e->getMessage()
                ];
            }
        }
        
        // Return if no file was uploaded or has errors
        return [
            'status' => 'error',
            'message' => 'No file uploaded or file has errors'
        ];
    }

    private function getUploadedFilePath($fieldName, $studentCode)
    {
        $result = $this->handleFileUpload($fieldName, $studentCode, false);
        return ($result['status'] === 'success') ? $result['filepath'] : '';
    }



    /**
     * =============================================================
     * This section for online payment test
     * =============================================================
     * */ 
    /*protected function setCookieSessionYearID()
    {
        $this->response->setCookie([
            'name'     => 'session_year_id',
            'value'    => session()->get('session_year_id'),
            'expire'   => 600,       // 10 minutes
            'path'     => '/',
            // 'secure'   => false,
            // 'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }

    protected function setCookieStudentCode($studentCode)
    {
        if( !isset($studentCode) || empty($studentCode) ) {
            return;
        }

        $this->response->setCookie([
            'name'     => 'student_code',
            'value'    => $studentCode,
            'expire'   => 600,       // 10 minutes
            'path'     => '/',
            // 'secure'   => false,
            // 'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }*/

    public function update_online_payment()
    {
        $getFeeIds = $this->request->getPost('selId');
        $getStudentCode = $this->request->getPost('sCode');
        $getValue = $this->request->getPost('value');

        // $this->setCookieSessionYearID();
        // $this->setCookieStudentCode($getStudentCode);
        echo "<pre>"; print_r($this->request->getPost());
        pr(session()->get());
        // pr( $this->request->getPost() );
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Cookies have been set',
            'received' => $this->request->getPost() // Debug info
        ]);
    }

    public function ccavenue_request(){
        // pr($this->request->getPost());
        
        $getStudentCode = $this->request->getPost('sCode');
        $getFeeIds = json_decode($this->request->getPost('selId'), true);
        $getValue = json_decode($this->request->getPost('value'), true);

        // Convert name-value pairs into key-value array
        $getAllData = array_column($getValue, 'value', 'name');
        // Get payment_amount safely
        $getPostPaymentAmount = $getAllData['payment_amount'] ?? '';
        $getPayeeName = $getAllData['payee_name'] ?? '';

        $getPayMnthId = session()->get('session_pay_mnth_id');
        $getPaymentAmount = session()->get('payment_amount');
        $getFineAmount = session()->get('fine');
        $getBusFeeFine = session()->get('bus_fee_fine');
        $getDueAmount = session()->get('due_amount');
        $getAdvAmount = session()->get('adv_amount');
        $getFinalAdvAmount = session()->get('final_adv_amount');
        $getFinalDueAmount = session()->get('final_due_amount');

        if( ((int)$getPostPaymentAmount !== (int)$getPaymentAmount) || $getPostPaymentAmount <= 0 || $getPaymentAmount <= 0 ) {
            return redirect()->to('admin/student/view-fee-structure/'.$getStudentCode)->with('error', 'Payment amount mismatch. Please try again.');
        }

        $paramdata['title'] = "Online Payment";

        echo view('admin/common/header', $paramdata);
        echo view('admin/common/topbar', $paramdata);
        echo view('admin/common/sidebar', $paramdata);

        $data = [];
        $merchant_id = '227678';
        $working_key = '80EE0DCADBEE34DC409A6F550B92630E';//Shared by CCAVENUES
        $data['access_code'] = 'AVCO86GH94AD42OCDA';//Shared by CCAVENUES
        
        //Live URL
        $redirect_url = base_url().'admin/online-payment/ccavenue-response-handler';
        $cancel_url = base_url().'admin/online-payment/ccavenue-response-handler';
        
        $merchant_data = $merchant_id;

        // $postData = $this->request->getPost();
        $postData = [];
        $postData["student_code"] = $getStudentCode;
        $postData["finalPayAmt"] = $getPaymentAmount;
        $postData["first_name"] = $getPayeeName;
        $postData["form_no"] = '';

        $postData["redirect_url"] = $redirect_url;
        $postData["cancel_url"] = $redirect_url;
        $postData["currency"] = "INR";
        $postData["language"] = "EN";
        $postData["amount"] = sprintf("%.2f", $getPaymentAmount);
        $postData["merchant_id"] = $merchant_id;
        $postData["order_id"] = 'ord-' . bin2hex(random_bytes(5));
        $student_code = $getStudentCode;
        $sessionKey = 'session_order_id_' . $student_code;
        session()->set($sessionKey, $postData["order_id"]);

        // user defined values, use as required
        $selId = $getPayMnthId;
        $selId = implode(',',$selId);

        $payee_user_id = student_id_by_code($student_code); // This will be student ID
        $payee_session_year_id = session()->get('session_year_id');
        
        $marge_user_year_sell_id = $payee_user_id.'#'.$payee_session_year_id.'#'.$selId.'#'.session()->get('user_id');
        
        $postData["merchant_param1"] = "";
        $postData["merchant_param2"] = $marge_user_year_sell_id;
        $postData["merchant_param3"] = sprintf("%.2f", $getPaymentAmount); // session()->get('finalPayAmt')
        $postData["merchant_param4"] = $getStudentCode;
        $postData["merchant_param5"] = $getPayeeName; // This will be student Name

        foreach ($postData as $key => $value) {
            $merchant_data .= $key . '=' . urlencode($value) . '&';
        }
        // pr($merchant_data);
        // $data['session_data']=$this->session->all_userdata();
        $data['encrypted_data'] = encrypt($merchant_data, $working_key); // Method for encrypting the data.
        $data["student_code"] = $getStudentCode;
        // pr($data);
        echo view('ccavenue_request', $data);
        echo view('admin/common/footer', $paramdata);
        exit();
    }

    public function ccavenue_request_readmission(){
        // pr($this->request->getPost());
        
        $getStudentCode = $this->request->getPost('sCode');
        $getFeeIds = json_decode($this->request->getPost('selId'), true);
        $getValue = json_decode($this->request->getPost('value'), true);
        $getPaymentData = json_decode($this->request->getPost('paymentData'), true);
        // echo '<pre>'; print_r($getFeeIds);
        // Convert name-value pairs into key-value array
        $getAllData = array_column($getValue, 'value', 'name');
        // $getAllPaymentData = array_column($getPaymentData, 'value', 'name');

        // Get payment_amount safely
        $getPostPaymentAmount = $getAllData['payment_amount'] ?? '';
        $getPayeeName = $getAllData['payee_name'] ?? '';

        // $getPayMnthId = [$getFeeIds];
        $getPayMnthId = $getFeeIds;
        $getPaymentAmount = $getPaymentData['payment_amount'] ?? '';

        if( ((int)$getPostPaymentAmount !== (int)$getPaymentAmount) || $getPostPaymentAmount <= 0 || $getPaymentAmount <= 0 ) {
            return redirect()->to('admin/student/view-fee-structure/'.$getStudentCode)->with('error', 'Payment amount mismatch. Please try again.');
        }

        $paramdata['title'] = "Online Payment";

        echo view('admin/common/header', $paramdata);
        echo view('admin/common/topbar', $paramdata);
        echo view('admin/common/sidebar', $paramdata);

        $data = [];
        $merchant_id = '227678';
        $working_key = '80EE0DCADBEE34DC409A6F550B92630E';//Shared by CCAVENUES
        $data['access_code'] = 'AVCO86GH94AD42OCDA';//Shared by CCAVENUES
        
        //Live URL
        $redirect_url = base_url().'admin/online-payment/ccavenue-response-handler-readmission';
        $cancel_url = base_url().'admin/online-payment/ccavenue-response-handler-readmission';
        
        $merchant_data = $merchant_id;

        // $postData = $this->request->getPost();
        $postData = [];
        $postData["student_code"] = $getStudentCode;
        $postData["finalPayAmt"] = $getPaymentAmount;
        $postData["first_name"] = $getPayeeName;
        $postData["form_no"] = '';

        $postData["redirect_url"] = $redirect_url;
        $postData["cancel_url"] = $redirect_url;
        $postData["currency"] = "INR";
        $postData["language"] = "EN";
        $postData["amount"] = sprintf("%.2f", $getPaymentAmount);
        $postData["merchant_id"] = $merchant_id;
        $postData["order_id"] = 'ord-' . bin2hex(random_bytes(5));
        $student_code = $getStudentCode;
        $sessionKey = 'session_order_id_' . $student_code;
        session()->set($sessionKey, $postData["order_id"]);

        // user defined values, use as required
        $selId = $getPayMnthId;
        $selId = implode(',',$selId);

        $payee_user_id = student_id_by_code($student_code); // This will be student ID
        $payee_session_year_id = session()->get('session_year_id');
        
        $marge_user_year_sell_id = $payee_user_id.'#'.$payee_session_year_id.'#'.$selId.'#'.session()->get('user_id');
        
        /*session()->set([
            "merchant_param1" => base64_encode(json_encode($getPaymentData))
        ]);*/

        $orderId = 'ORD' . time() . rand(100,999);
        $paymentOrderData = [
            'order_id' => $orderId,
            'student_id' => $payee_user_id,
            'session_year_id' => $payee_session_year_id,
            'payment_data' => json_encode($getPaymentData),
            'status' => 'PENDING',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $paymentOrderModel = new PaymentOrderModel();
        $insertOrderId = $paymentOrderModel->insert($paymentOrderData);

        $postData["merchant_param1"] = $insertOrderId;
        // $postData["merchant_param1"] = base64_encode(json_encode($getPaymentData));
        $postData["merchant_param2"] = $marge_user_year_sell_id;
        $postData["merchant_param3"] = sprintf("%.2f", $getPaymentAmount); // session()->get('finalPayAmt')
        $postData["merchant_param4"] = $getStudentCode;
        $postData["merchant_param5"] = $getPayeeName; // This will be student Name

        $merchant_data = http_build_query($postData);

        // foreach ($postData as $key => $value) {
        //     $merchant_data .= $key . '=' . urlencode($value) . '&';
        // }
        // pr($merchant_data);
        // $data['session_data']=$this->session->all_userdata();
        $data['encrypted_data'] = encrypt($merchant_data, $working_key); // Method for encrypting the data.
        $data["student_code"] = $getStudentCode;
        // pr($data);
        echo view('ccavenue_request_readmission', $data);
        echo view('admin/common/footer', $paramdata);
        exit();
    }

    public function ccavenue_request_test(){
        // echo "sd";
        // pr($this->session->userdata('session_pay_mnth_id'));
        // pr(session()->get());

        $getPayMnthId = session()->get('session_pay_mnth_id');
        $getPaymentAmount = session()->get('payment_amount');
        $getFineAmount = session()->get('fine');
        $getBusFeeFine = session()->get('bus_fee_fine');
        $getDueAmount = session()->get('due_amount');
        $getAdvAmount = session()->get('adv_amount');
        $getFinalAdvAmount = session()->get('final_adv_amount');
        $getFinalDueAmount = session()->get('final_due_amount');


        pr( $this->request->getPost() );

        $paramdata['title'] = "Online Payment";

        echo view('admin/common/header', $paramdata);
        echo view('admin/common/topbar', $paramdata);
        echo view('admin/common/sidebar', $paramdata);

        $data = [];
        $merchant_id = '227678';
        $working_key = '80EE0DCADBEE34DC409A6F550B92630E';//Shared by CCAVENUES
        $data['access_code'] = 'AVCO86GH94AD42OCDA';//Shared by CCAVENUES
        
        //Live URL
        // $redirect_url = 'https://www.scmemorialschool.com/test/ccavenue_response_handler';
        // $cancel_url = 'https://www.scmemorialschool.com/test/ccavenue_response_handler';

        $redirect_url = base_url().'admin/online-payment/ccavenue-response-handler';
        $cancel_url = base_url().'admin/online-payment/ccavenue-response-handler';
        
        $merchant_data = $merchant_id;

        $postData = $_POST;
        $postData["redirect_url"] = $redirect_url;
        $postData["cancel_url"] = $redirect_url;
        $postData["currency"] = "INR";
        $postData["language"] = "EN";
        $postData["amount"] = sprintf("%.2f", 1);
        $postData["merchant_id"] = $merchant_id;
        // $postData["order_id"] = "ord-" . generateRandomString(10);
        $postData["order_id"] = 'ord-' . bin2hex(random_bytes(5));

        // $this->session->set_userdata('session_order_id',$postData["order_id"]);
        $student_code = $this->request->getPost('student_code');
        $sessionKey = 'session_order_id_' . $student_code;
        session()->set($sessionKey, $postData["order_id"]);

        // user defined values, use as required
        // $selId = $this->session->userdata('session_pay_mnth_id');
        // $selId = implode(',',$selId);

        $selId = [7,8];
        $selId = implode(',',$selId);

        $payee_user_id = session()->get('user_id'); // This will be student ID
        $payee_session_year_id = session()->get('session_year_id');
        
        $marge_user_year_sell_id = $payee_user_id.'#'.$payee_session_year_id.'#'.$selId;
        
        $postData["merchant_param1"] = "";
        $postData["merchant_param2"] = $marge_user_year_sell_id;
        $postData["merchant_param3"] = sprintf("%.2f", 1); // session()->get('finalPayAmt')
        $postData["merchant_param4"] = $this->request->getPost('student_code');
        $postData["merchant_param5"] = session()->get('f_name'); // This will be student Name



        foreach ($postData as $key => $value) {
            $merchant_data .= $key . '=' . urlencode($value) . '&';
        }
        // $data['session_data']=$this->session->all_userdata();
        $data['encrypted_data'] = encrypt($merchant_data, $working_key); // Method for encrypting the data.

        echo view('ccavenue_request', $data);
        echo view('admin/common/footer', $paramdata);
        // return view('ccavenue_request', $data);
    }
    /**
     * =============================================================
     * End This section for online payment test
     * =============================================================
     * */ 


    public function generate_student_roll_no()
    {
        $data['title'] = "Generate student roll no";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        echo view('admin/student/generate-student-roll-no', $data);  

        echo view('admin/common/footer', $data);
    }

    public function ajax_request_get_lists_for_generate_student_roll()
    {
        $classId   = $this->request->getPost('class_id') ?? '';
        $sectionId = $this->request->getPost('section_id') ?? '';
        $isIndividual = $this->request->getPost('is_individual') ?? 'no';


        $studentModel = new StudentModel();
        $studentDetailsModel = new StudentDetailsModel();

        $student_list = $studentModel->promoted_student_list($classId,$sectionId);

        $count=0;
        $html = '';
        if(!empty($student_list)){
            $html .='<thead>
                <tr>
                    <th>Sl No </th>
                    <th>Student Code</th>
                    <th>Student Name</th>
                    <th>Image</th>
                    <th>Class </th>
                    <th>Section</th>
                    <th>Roll No</th>
                    <th>Date Of Birth</th>
                    <th>Father Name</th>
                    <th>Mother Name</th>
                </tr>
            </thead><tbody>';

            foreach($student_list as $student){
                $html .='<tr class="">
                    <td> '.++$count.'</td>
                    <td>'.$student['studentCode'].'<input type="hidden" name="s_code[]" value="'.$student['studentCode'].'"/></td>
                    <td>'.$student['first_name'].'</td>
                    <td><img src="'. base_url().'uploads/'. $student['image'].'" height="50" width="50"></td>
                    <td>'.$student['class_name'].'</td>
                    <td>'.$student['section_name'].'</td>';

                    // 👇 Roll number column
                    if($isIndividual == 'yes'){
                        $html .= '<td>
                            <input type="number" class="form-control roll-input" value="'.$student['roll_num'].'" data-student-id="'.$student['studentID'].'"placeholder="Enter roll">
                        </td>';
                    } else {
                        $html .= '<td>'.$student['roll_num'].'</td>';
                    }

                    $html .= '
                    <td>'.$student['d_o_b'].'</td>
                    <td>'.$student['father_name'].'</td>
                    <td>'.$student['mother_name'].'</td>
                </tr>';
            }
            $html .='</tbody>';
        } else {
            $html =' <tr><td colspan="6"><div class="alert alert-danger">No result found!</div></td></tr>';
        }

        return $this->response->setJSON([
            'no_of_student' => count($student_list),
            'html' => $html,
        ]);
    }

    public function ajax_update_individual_student_roll_no()
    {
        $student_id = $this->request->getPost('student_id') ?? '';
        $roll_num = $this->request->getPost('roll_num') ?? '';

        // Validation
        if (empty($student_id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Student ID is required'
            ]);
        }

        if (empty($roll_num)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Roll number cannot be blank'
            ]);
        }

        if (!ctype_digit($roll_num)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Roll number must be a valid integer'
            ]);
        }

        $studentDetailsModel = new StudentDetailsModel();
        $updated = $studentDetailsModel->where('student_id', $student_id)->set(['roll_num' => $roll_num])->update();

        // Check result
        if ($updated && $studentDetailsModel->db->affectedRows() > 0) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Roll number updated successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No changes made or update failed'
            ]);
        }
    }

    public function allot_students_roll_num()
    {
        $student_codes =[];
        $student_codes = $this->request->getPost('s_code');

        if (empty($student_codes)) {
            return redirect()
                ->back()
                ->with('error', 'No students selected. Please select at least one student.');
        }

        // initial roll no
        $roll = 0;
        
        for($i=0;$i<count($student_codes);$i++){
            $roll++;
            $studentDetailsModel = new StudentDetailsModel();
            $result = $studentDetailsModel->allot_student_roll($student_codes[$i], $roll);
            
        }

        if($result){
            return redirect()
                ->back()
                ->with('success', 'Roll No Added Successfully');
        }
    }

    public function re_admission()
    {
        $data['title'] = "Re Admission";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        echo view('admin/student/re-admission', $data);
        echo view('admin/common/footer', $data);
    }

    public function ajax_request_for_student_move_to_next_session() {      // Ajax request Call For Moving Data To Next Session Year
        $sessionYearModel = new SessionYearModel();

        $class_id = $this->request->getPost('class_id');
        $section_id = $this->request->getPost('section_id');
        $currentSessionYearId = session()->get('session_year_id');
        $next_session_id = ($row = $sessionYearModel->where('id >', $currentSessionYearId)->orderBy('id', 'ASC')->first()) ? $row['id'] : null;

        if( empty($class_id) || empty($section_id) ) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Please select both Class and Section',
                'no_of_student' => 0,
                'html' => '',
            ]);
        }

        $sessionYearModel = new SessionYearModel();
        $nextSessionYearId = ($row = $sessionYearModel
            ->where('id >', session()->get('session_year_id'))
            ->orderBy('id', 'ASC')
            ->first())
            ? $row['id']
            : null;

        if ($nextSessionYearId === null) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'The next academic session is currently not available.',
                'no_of_student' => 0,
                'html' => '',
            ]);
        }

        $studentModel = new StudentModel();
        $studentDetailsModel = new StudentDetailsModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();

        $student_list = $studentModel->readmission_student_list($class_id, $section_id);

        $student_list_mod = [];
        $student_list_mod1 = [];
        $student_list_final = [];

        foreach($student_list as $student){
            $sCount = $studentDetailsModel->where('code', $student['code'])
                               ->where('session_year_id', $nextSessionYearId)
                               ->countAllResults();

            if($sCount != 0){
                $firstMonthPayRe = $studentFeeStructureModel
                                        ->select('ad_payment_status, id AS fees_id, tuition_fee, bus_services')
                                        ->where('student_code', $student['code'])
                                        ->where('session_year_id', $nextSessionYearId)
                                        ->orderBy('id', 'ASC')
                                        ->first();


                // $this->student_model->re_student_first_month_payment($student->code,$next_id);
                if( isset($firstMonthPayRe['ad_payment_status']) && $firstMonthPayRe['ad_payment_status'] != 0){
                    continue;
                }
            }
            $student_list_mod[] = $student;
        }

        foreach($student_list_mod as $student){
            $dueMonthCount =  $studentFeeStructureModel
                                ->where('student_code', $student['code'])
                                ->where('session_year_id', $currentSessionYearId)
                                ->where('ad_payment_status', 0)
                                ->where('bus_payment_status', 0)
                                ->countAllResults();

            // $this->student_model->check_due_month_count($student->code);
            if($dueMonthCount != 0){                
                continue;
            }
            $student_list_mod1[] = $student;
        }

        foreach($student_list_mod1 as $student){
            // $dueLibMonthCount = $this->student_model->check_lib_due_count($student->code);
            // if($dueLibMonthCount != 0){
            //     continue;
            // }
            $student_list_final[] = $student;
            
        }

        $count = 0;
        $html = '';
        $allStudentUpgraded = true;

        if(!empty($student_list_final)){
            $html .='<thead>
                    <tr>
                        <th>Sl No </th>
                        <th>Student Code</th>
                        <th>Student Name</th>
                        <th>Image</th>
                        <th>Class </th>
                        <th>Section</th>
                        <th>Roll No</th>
                        <th>Date Of Birth</th>
                        <th>Result</th>
                        <th>Status</th>
                    </tr>
                </thead>
            <tbody>';
            foreach($student_list_final as $student){
                // Checking this student is upgraded to next session or not

                $isUpgraded = $studentDetailsModel->where('session_year_id', $next_session_id)->where('code', $student['code'])->first();
                if( !$isUpgraded ) {
                    $allStudentUpgraded = false;
                }
                if($student['session_result_status'] == 1) {
                    $allStudentUpgraded = false;
                }

                // if( $class_id == 5 && $section_id == 405 && $student['code'] == "22-0129" ) { // This is for test only
                    $html .='<tr class="">
                        <td> '.++$count.'</td>
                        <td>'.$student['code'] .'<input type="hidden" name="s_code[]" value="'.$student['code'].'"/></td>
                        <td>'.$student['first_name'].' '.$student['middle_name'].' '.$student['surname'].'</td>
                        <td></td>
                        <td>'.get_class_name_by_id($student['class_id']).'</td>
                        <td>'.section_name_by_id($student['section_id']).'</td>
                        <td>'.$student['roll_num'] .'</td>
                        <td>'.$student['d_o_b'] .'</td>
                        <td>'.($student['session_result_status'] == 1 ? '<span class="badge bg-success d-block">Pass</span>' : '<span class="badge bg-danger d-block">Fail</span>') . '</td>
                        <td>'.($student['session_result_status'] == 1 ? '<span class="badge bg-primary d-block">Ready To Promote <i class="bi bi-box-arrow-in-right"></i></span>' : '<span class="badge bg-warning d-block"><i class="bi bi-box-arrow-in-left"></i> Not Promoted</span>') .'</td>
                    </tr>';
                // }
            }
            $html .='</tbody>';
            $html .= '<script>
                $(document).ready(function() {
                    $(".table").dataTable( {
                        "pageLength": 50,
                        "destroy": true
                        
                    });
                } );
            </script>'; 
        } else {
            $html =' <tr><td colspan="6"><div class="alert alert-danger">No result found!</div></td></tr>';
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => '',
            'no_of_student' => count($student_list_final),
            'html' => $html,
            'allStudentUpgraded' => $allStudentUpgraded,
            'next_session_id' => $next_session_id,
        ]);
    }

    public function students_move_to_next_class()
    {
        $session_year_id = session()->get('session_year_id');
        $studentCode =[];

        $studentModel = new StudentModel();
        $studentDetailsModel = new StudentDetailsModel();
        $sessionYearModel = new SessionYearModel();
        $sectionModel = new SectionModel();
        $configurationModel = new ConfigurationModel();
        $feesStructureMasterModel = new FeesStructureMasterModel();
        $studentDocumentsModel = new StudentDocumentsModel();
        $studentElectiveSubjectsModel = new StudentElectiveSubjectsModel();
        $studentParentsGuardiansModel = new StudentParentsGuardiansModel();
        $studentPersonalDetailsModel = new StudentPersonalDetailsModel();
        $studentTransportFinancialModel = new StudentTransportFinancialModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();

        $next_id = ($row = $sessionYearModel->where('id >', session()->get('session_year_id'))->orderBy('id', 'ASC')->first()) ? $row['id'] : null;

        $data = [];     
        $add_month_fee= [];     
        $class_id = $this->request->getPost('class_id');
        $section_id = $this->request->getPost('section_id');
        $studentCode = $this->request->getPost('s_code');

        echo"<pre>";print_r($this->request->getPost());exit;

        $promoted_class = (int)$class_id + 1;

        $current_section = $sectionModel->where('id', $section_id)->where('session_year_id', $session_year_id)->first();

        $getSectionName = $current_section['section_name'] ?? '';
        $get_next_class_sections = $sectionModel->where('class_id', $promoted_class)->where('section_name', $getSectionName)->first();
        $next_session_start_end_dates = $sessionYearModel->where('id', $next_id)->first();
        $pay_due_date = $configurationModel->get_configuration_by_key('payment_due_date');   // fine date for every month 

        // insert student_fee_structure table
        $startDate = new DateTime($next_session_start_end_dates['start_date']); //'2019-04-15'
        $endDate = new DateTime($next_session_start_end_dates['end_date']); //'2020-03-30'
        $periodInt = new DateInterval( "P1M" ); // 1 month interval

        $period = new DatePeriod( $startDate, $periodInt, $endDate );
        $sesionMonthYear = date('Y-m',strtotime($next_session_start_end_dates['start_date']));

        // passed student will go to next class and failed student remain in same class for next session year.
        foreach($studentCode as $code){
            $student = $studentDetailsModel->get_student_details_by_code($code);
            $getStudentId = $student['id'] ?? ''; // 57542
            // $getStudentDetailsId = $student['student_details_id'] ?? '';

            // echo "<pre>"; print_r($next_id);
            // echo "<pre>"; print_r($code);
            // echo "<pre>"; print_r($student['id']);
            // echo "<br />";

            if( isset($student['session_result_status']) && $student['session_result_status'] == 1 ) {
                $studentModel->next_session_years_student_delete_by_class($next_id, $code);
                $student_details_data = $studentModel->get_student_to_be_promoted($class_id,$session_year_id,$code); 
                $getStudentDetailsId = $student_details_data['id'] ?? '';
                $fee_structure = $feesStructureMasterModel->where('session_year_id', $next_id)->where('class_id', $promoted_class)->first();
                
                if (empty($fee_structure)) {
                    return redirect()->to('admin/student/re-admission')->with('message', 'Re-admission cannot be completed because no fee structure is available for the selected session');
                }

                if(!empty($student_details_data)){
                    $new_sections = $sectionModel->where('session_year_id', $next_id)->where('class_id', $promoted_class)->where('section_name', trim($getSectionName))->first();
                    $newSectionId = $new_sections['id'] ?? '';

                    $new_student_id = $studentModel->copy_student_data((int)$getStudentId,(int)$promoted_class,(int)$newSectionId,(int)$next_id);
                    $new_student_details_id = $studentDetailsModel->copy_student_details((int)$getStudentDetailsId,(int)$new_student_id, (int)$promoted_class,(int)$newSectionId,(int)$next_id);
                    $newStudentDocumentsId = $studentDocumentsModel->copyStudentDocuments((int)$getStudentId,(int)$new_student_id);
                    $newStudentElectiveSubjectsId = $studentElectiveSubjectsModel->copyStudentElectiveSubjects((int)$getStudentId,(int)$new_student_id);
                    $newStudentParentsGuardiansId = $studentParentsGuardiansModel->copyStudentParentsGuardians((int)$getStudentId,(int)$new_student_id);
                    $newStudentPersonalDetailsId = $studentPersonalDetailsModel->copyStudentPersonalDetails((int)$getStudentId,(int)$new_student_id);
                    $newStudentTransportFinancialId = $studentTransportFinancialModel->copyStudentTransportFinancial((int)$getStudentId,(int)$new_student_id);

                    foreach ($period as $key => $value) {
                        $yearMonth = $value->format('Y-m');
                        $pay_due_date = NULL;
                        if (!empty($yearMonth)) {
                            $getCurrentMonthName = strtolower(
                                date('F', strtotime($yearMonth . '-01'))
                            );

                            if (!empty($getCurrentMonthName)) {
                                $pay_due_date = $configurationModel->get_configuration_by_key($getCurrentMonthName . '_payment_due_date');
                            }
                        }

                        if($value->format('Y-m') == $sesionMonthYear){
                            $add_month_fee = array(
                                'student_code' => $code,
                                'fine' => 0,
                                'admission_fee' => 0,
                                'development_fee' => $fee_structure['development_fee'] ?? 0,
                                'exam_fee' => $fee_structure['exam_fee'] ?? 0,
                                'festival_celebration_fee' => $fee_structure['festival_celebration_fee'] ?? 0,
                                'games_sports_fee' => $fee_structure['games_sports_fee'] ?? 0,
                                'audio_visual_lab_fee' => $fee_structure['audio_visual_lab_fee'] ?? 0,
                                'library_fee' => $fee_structure['library_fee'] ?? 0,
                                'electricity_maintenance_fee' => $fee_structure['electricity_maintenance_fee'] ?? 0,
                                'computer_fee' => $fee_structure['computer_fee'] ?? 0,
                                'security_deposite' => 0,
                                // 'tuition_fee' => ($student_details_data['academic_status'] == 'Free' ? 0 : $fee_structure['tuition_fee']),
                                'tuition_fee' => (isset($student_details_data['academic_status']) && $student_details_data['academic_status'] == 'Free' ? 0 : (isset($fee_structure['tuition_fee']) ? $fee_structure['tuition_fee'] : 0)),
                                'bus_services' => 0,
                                'month_id' => $value->format('m'),
                                'ad_payment_status' => 0,
                                'bus_payment_status' => 0,
                                'payment_due_date' =>  $value->format('Y-m-'.$pay_due_date),
                                'session_year_id' => $next_id
                            );
                            
                            $feeExists = $studentFeeStructureModel->where('student_code', $code)->where('session_year_id', $next_id)->where('month_id', $value->format('m'))->first();
                            if (!$feeExists) {
                                $feesResult = $studentFeeStructureModel->insert($add_month_fee, true);
                            }

                            $add_month_fee = [];
                        } else {
                            $add_month_fee = array(
                                'student_code' => $code,                        
                                'fine' => 0,
                                'admission_fee' => 0,
                                'development_fee' => 0,
                                'exam_fee' => 0,
                                'festival_celebration_fee' => 0,
                                'games_sports_fee' => 0,
                                'audio_visual_lab_fee' => 0,
                                'library_fee' => 0,
                                'electricity_maintenance_fee' => 0,
                                'computer_fee' => 0,
                                'security_deposite' => 0,
                                // 'tuition_fee' => ($student_details_data['academic_status'] == 'Free' ? 0 : $fee_structure['tuition_fee']),
                                'tuition_fee' => (isset($student_details_data['academic_status']) && $student_details_data['academic_status'] == 'Free' ? 0 : (isset($fee_structure['tuition_fee']) ? $fee_structure['tuition_fee'] : 0)),
                                'bus_services' => 0,
                                'month_id' => $value->format('m'),
                                'ad_payment_status' => 0,
                                'bus_payment_status' => 0,
                                'payment_due_date' =>  $value->format('Y-m-'.$pay_due_date),
                                'session_year_id' => $next_id
                            );

                            $feeExists = $studentFeeStructureModel->where('student_code', $code)->where('session_year_id', $next_id)->where('month_id', $value->format('m'))->first();
                            if (!$feeExists) {
                                $feesResult = $studentFeeStructureModel->insert($add_month_fee, true);
                            }
                            $add_month_fee= []; 
                        }
                    }

                    // $this->session->set_flashdata('success_msg', 'Data Moved To Next Session Please Go To Next Session.');
                }
            } else {
                // Fail hole update session with new ditails
                $studentModel->next_session_years_student_delete_by_class($next_id, $code);
                $student_details_data = $studentModel->get_student_to_be_promoted($class_id, $session_year_id, $code);
                $getStudentDetailsId = $student_details_data['id'] ?? '';
                $fee_structure = $feesStructureMasterModel->where('session_year_id', $session_year_id)->where('class_id', $class_id)->first(); 
                if (empty($fee_structure)) {
                    return redirect()->to('admin/student/re-admission')->with('message', 'Re-admission cannot be completed because no fee structure is available for the selected session');
                }

                if(!empty($student_details_data)){
                    $new_student_id = $studentModel->copy_student_data((int)$getStudentId, (int)$class_id, (int)$section_id, (int)$next_id);
                    $new_student_details_id = $studentDetailsModel->copy_student_details((int)$getStudentDetailsId, (int)$new_student_id, (int)$class_id, (int)$section_id, (int)$next_id);
                    $newStudentDocumentsId = $studentDocumentsModel->copyStudentDocuments((int)$getStudentId, (int)$new_student_id);
                    $newStudentElectiveSubjectsId = $studentElectiveSubjectsModel->copyStudentElectiveSubjects((int)$getStudentId, (int)$new_student_id);
                    $newStudentParentsGuardiansId = $studentParentsGuardiansModel->copyStudentParentsGuardians((int)$getStudentId, (int)$new_student_id);
                    $newStudentPersonalDetailsId = $studentPersonalDetailsModel->copyStudentPersonalDetails((int)$getStudentId, (int)$new_student_id);
                    $newStudentTransportFinancialId = $studentTransportFinancialModel->copyStudentTransportFinancial((int)$getStudentId, (int)$new_student_id);

                    foreach ($period as $key => $value) {
                        $yearMonth = $value->format('Y-m');
                        $pay_due_date = NULL;
                        if (!empty($yearMonth)) {
                            $getCurrentMonthName = strtolower(
                                date('F', strtotime($yearMonth . '-01'))
                            );

                            if (!empty($getCurrentMonthName)) {
                                $pay_due_date = $configurationModel->get_configuration_by_key($getCurrentMonthName . '_payment_due_date');
                            }
                        }

                        if($value->format('Y-m') == $sesionMonthYear){
                            $add_month_fee = array(
                                'student_code' => $code,
                                'fine' => 0,
                                'admission_fee' => 0,
                                'development_fee' => $fee_structure['development_fee'],
                                'exam_fee' => $fee_structure['exam_fee'],
                                'festival_celebration_fee' => $fee_structure['festival_celebration_fee'],
                                'games_sports_fee' => $fee_structure['games_sports_fee'],
                                'audio_visual_lab_fee' => $fee_structure['audio_visual_lab_fee'],
                                'library_fee' => $fee_structure['library_fee'],
                                'electricity_maintenance_fee' => $fee_structure['electricity_maintenance_fee'],
                                'computer_fee' => $fee_structure['computer_fee'],
                                'security_deposite' => 0,
                                'tuition_fee' => ($student_details_data['academic_status'] == 'Free' ? 0 : $fee_structure['tuition_fee']),
                                // 'bus_services' => session_stoppage_fee_by_id($student_details_data['stoppage'], $next_id),
                                'bus_services' => (!empty($student_details_data['stoppage'] ?? null) ? session_stoppage_fee_by_id($student_details_data['stoppage'], $next_id) : 0),
                                'month_id' => $value->format('m'),
                                'ad_payment_status' => 0,
                                'bus_payment_status' => 0,
                                'payment_due_date' =>  $value->format('Y-m-'.$pay_due_date),
                                'session_year_id' => $next_id
                            );
                            
                            $feeExists = $studentFeeStructureModel->where('student_code', $code)->where('session_year_id', $next_id)->where('month_id', $value->format('m'))->first();
                            if (!$feeExists) {
                                $feesResult = $studentFeeStructureModel->insert($add_month_fee, true);
                            }
                            $add_month_fee= [];
                        } else {    
                            $add_month_fee = array(
                                'student_code' => $code,                        
                                'fine' => 0,
                                'admission_fee' => 0,
                                'development_fee' => 0,
                                'exam_fee' => 0,
                                'festival_celebration_fee' => 0,
                                'games_sports_fee' => 0,
                                'audio_visual_lab_fee' => 0,
                                'library_fee' => 0,
                                'electricity_maintenance_fee' => 0,
                                'computer_fee' => 0,
                                'security_deposite' => 0,
                                'tuition_fee' => ($student_details_data['academic_status'] == 'Free' ? 0 : $fee_structure['tuition_fee']),
                                // 'bus_services' => session_stoppage_fee_by_id($student_details_data['stoppage'],$next_id),
                                'bus_services' => (!empty($student_details_data['stoppage'] ?? null) ? session_stoppage_fee_by_id($student_details_data['stoppage'], $next_id) : 0),
                                'month_id' => $value->format('m'),
                                'ad_payment_status' => 0,
                                'bus_payment_status' => 0,
                                'payment_due_date' =>  $value->format('Y-m-'.$pay_due_date),
                                'session_year_id' => $next_id
                            );
                            
                            $feeExists = $studentFeeStructureModel->where('student_code', $code)->where('session_year_id', $next_id)->where('month_id', $value->format('m'))->first();
                            if (!$feeExists) {
                                $feesResult = $studentFeeStructureModel->insert($add_month_fee, true);
                            }
                            $add_month_fee= [];             
                        }
                    }
                }
            }
        }

        // pr("Test");

        return redirect()->to('admin/student/re-admission')->with('message', 'Re-admission completed successfully. Data Moved To Next Session Please Go To Next Session.');

    }

    public function collect_re_admission_fee($code)
    {
        // pr();
        $data['title'] = "Collect Re Admission Fee";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $studentModel = new StudentModel();
        $studentDetailsModel = new StudentDetailsModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();
        $stoppageMasterModel = new StoppageMasterModel();
        $busToStoppageModel = new BusToStoppageModel();
        $itemMasterModel = new ItemMasterModel();
        $sectionModel = new SectionModel();
        $sessionYearModel = new SessionYearModel();
        $tblcMasterModel = new TblcMasterModel();
        $StoppageFareMasterModel = new StoppageFareMasterModel();


        $getFormDetails = $studentFeeStructureModel->getFirstMonthFee($code);

        if( !isset($getFormDetails) || empty($getFormDetails) ) {
            return redirect()->to(base_url('/admin/student/student-list'));
        }

        $session_id = $this->session->get('session_year_id');
        $class_id = $getFormDetails['class_id'] ?? '';
        $stoppage_id = $getFormDetails['stoppage'] ?? '';
        $sdetails = $studentDetailsModel->get_student_details_by_code($code);

        $data['form_details'] = $getFormDetails;
        $data['stationary_total_price'] = $itemMasterModel->get_total_price_stn_by_class($class_id, $session_id);
        // $data['stoppage_list'] = $stoppageMasterModel->orderBy('stoppage_id', 'ASC')->findAll();
        $data['stoppage_list'] = $stoppageMasterModel->get_stoppages();
        $data['bus_list'] = $busToStoppageModel->get_bus_list_by_stoppage($stoppage_id);
        
        $data['nclass'] = $sdetails['class_id'] ?? '';
        $data['nsection'] = $sdetails['section_id'] ?? '';
        $data['nbus'] = $sdetails['bus_id'] ?? '';
        $data['nstoppage'] = $sdetails['stoppage'] ?? '';
        $data['nfirst_name'] = $sdetails['first_name'] ?? '';
        $data['code'] = $code;
        $data['dept_id'] = $this->session->get('dept_id');

        $data['section_list'] = $sectionModel->get_section_class_id($class_id, $session_id);
        $data['current'] = $sessionYearModel->getCurrentSessionId();
        // $data['stoppage_fare'] = $stoppage_id ? stoppage_fee_by_id($stoppage_id) : 0;
        $data['stoppage_fare'] = $getFormDetails['bus_services'] ?? 0;
        
        $sec_lang = "Bengali";
        $data['tblc_list'] = $tblcMasterModel
            ->where('class_id', $class_id)
            ->where('sec_lang', $sec_lang)
            ->where('session_year_id', $session_id)
            ->where('status', 1)
            ->findAll();

        $data['stationary_item_list'] = $itemMasterModel
            ->where('class_id', $class_id)
            ->where('sec_lang', $sec_lang)
            ->where('session_year_id', $session_id)
            ->where('status', 1)
            ->findAll();

        // Fine Calculation Area
        $fine = 0;
        $busFine = 0;
        
        $data['fine'] = $fine;
        $data['bus_fee_fine'] = $busFine;
        $data['academic_status'] = $sdetails['academic_status'] ?? '';

        // pr($data);

        $is_student_logged_in = session()->get('student_logged_in');
        if( $is_student_logged_in ) {
            echo view('admin/student/re-admission-fees-collect-for-student', $data);
        } else {
            echo view('admin/student/re-admission-fees-collect', $data);
        }
        
        echo view('admin/common/footer', $data);
    }

    public function ajax_add_re_admission_payment()
    {
        $response = [
            'success' => false,
            'student_code' => '',
            'message' => ''
        ];

        $fees_id = ((int) $this->request->getPost('fees_id')) ?? '';

        $payment_amount = $this->request->getPost('payment_amount') ?? 0;
        $payee_name = $this->request->getPost('first_name') ?? '';
        $total_stationary_fee = $this->request->getPost('stationary_total') ?? 0;
        $bus_payment_amt = $this->request->getPost('stoppage_fee') ?? 0;
        $ad_payment_mode = $this->request->getPost('ad_payment_mode') ?? 'cash';
        $created_date = date("Y-m-d h:m:s");
        $t_user_id = session()->get('user_id');
        $added_by = session()->get('f_name');
        $academic_payment_amt = $this->request->getPost('grand_total_fees') ?? 0;
        $ad_payment_status = 1;
        
        $cheque_number = $this->request->getPost('cheque_number') ?? '';
        $pos_bank_name = $this->request->getPost('pos_bank_name') ?? '';
        $pos_reference_number = $this->request->getPost('pos_reference_number') ?? '';          

        $bus_payment_mode = '';
        $bus_payee_name = '';
        $bus_payment_date = null;
        $bus_cheque_number = '';
        $bus_pos_bank_name = '';
        $bus_pos_reference_number = '';

        $bus_t_user_id = 0;
        $bus_added_by = '';
        $bus_payment_status = 0;
        
        if( $bus_payment_amt > 0 ) {
            $bus_payment_mode = $ad_payment_mode;
            $bus_payee_name = $payee_name;
            $bus_payment_date = date("Y-m-d h:m:s");
            $bus_cheque_number = $cheque_number;
            $bus_pos_bank_name = $pos_bank_name;
            $bus_pos_reference_number = $pos_reference_number;

            $bus_t_user_id = session()->get('user_id');
            $bus_added_by = session()->get('f_name');
            $bus_payment_status = 1;
        }

        $stationary_items = $this->request->getPost('stationary_items') ?? [];
        $remarks = $this->request->getPost('remarks') ?? '';
        $student_id = $this->request->getPost('student_id') ?? '';
        $student_code = $this->request->getPost('student_code') ?? '';
        $class_id = $this->request->getPost('class_id') ?? '';

        // echo "<pre>"; print_r($student_id);
        // die();

        $updata['payment_amount'] = $payment_amount;
        $updata['payee_name'] = $payee_name;
        $updata['cheque_number'] = $cheque_number;
        $updata['bus_payment_amt'] = $bus_payment_amt;
        $updata['ad_payment_mode'] = $ad_payment_mode;
        $updata['ad_payment_mode'] = $ad_payment_mode;
        $updata['created_date'] = $created_date;
        $updata['t_user_id'] = $t_user_id;
        $updata['added_by'] = $added_by;

        $updata['bus_payment_date'] = $bus_payment_date;
        $updata['academic_payment_amt'] = $academic_payment_amt;
        $updata['bus_pos_bank_name'] = $bus_pos_bank_name;
        $updata['bus_payment_mode'] = $bus_payment_mode;
        $updata['bus_payee_name'] = $bus_payee_name;
        $updata['bus_pos_reference_number'] = $bus_pos_reference_number;
        $updata['bus_added_by'] = $bus_added_by;
        $updata['bus_t_user_id'] = $bus_t_user_id;
        $updata['bus_cheque_number'] = $bus_cheque_number;
        $updata['total_stationary_fee'] = $total_stationary_fee;
        $updata['bus_payment_status'] = $bus_payment_status;
        $updata['ad_payment_status'] = $ad_payment_status;

        $studentFeeStructureModel = new StudentFeeStructureModel();
        $result = $studentFeeStructureModel->update($fees_id, $updata);

        if( $result ) {
            // Insert Fee Invoice
            $studentFeeInvoiceModel = new StudentFeeInvoiceModel();
            $feesInvoiceData = [
                'form_no'                       => '',
                'student_id'                    => $student_id,
                'session_year_id'               => $this->session->get('session_year_id'),
                'admission_fee'                 => $this->request->getPost('admission_fee') ?? 0,
                'development_fee'               => $this->request->getPost('development_fee') ?? 0,
                'exam_fee'                      => $this->request->getPost('exam_fee') ?? 0,
                'festival_celebration_fee'      => $this->request->getPost('festival_celebration_fee') ?? 0,
                'games_sports_fee'              => $this->request->getPost('games_sports_fee') ?? 0,
                'audio_visual_lab_fee'          => $this->request->getPost('audio_visual_lab_fee') ?? 0,
                'library_fee'                   => $this->request->getPost('library_fee') ?? 0,
                'electricity_maintenance_fee'   => $this->request->getPost('electricity_maintenance_fee') ?? 0,
                'computer_fee'                  => $this->request->getPost('computer_fee') ?? 0,
                'security_deposite'             => $this->request->getPost('security_deposite') ?? 0,
                'tuition_fee'                   => $this->request->getPost('tuition_fee') ?? 0,
                'stoppage_fee'                  => $this->request->getPost('stoppage_fee') ?? 0,
                'grand_total_fees'              => $this->request->getPost('grand_total_fees') ?? 0,
                'payment_amount'                => $this->request->getPost('payment_amount') ?? 0,
                'payment_cheque_number'         => $this->request->getPost('payment_cheque_number') ?? null,
                'payment_pos_bank_name'         => $this->request->getPost('payment_pos_bank_name') ?? null,
                'payment_pos_reference_number'  => $this->request->getPost('payment_pos_reference_number') ?? null,
                'remarks'                       => $this->request->getPost('remarks') ?? '',
                'stationary_items'              => json_encode($this->request->getPost('stationary_items') ?? []),
                'stationary_total'              => $this->request->getPost('stationary_total') ?? 0,
                'tblc_items'                    => json_encode([]),
                'tblc_total'                    => 0,
                'created_at'                    => date('Y-m-d H:i:s'),
                'created_by'                    => $this->session->get('user_id'),
            ];
            // echo "<pre>"; print_r($feesInvoiceData);

            $studentFeeInvoiceModel->insert($feesInvoiceData, true);

            // Insert Stationary Item
            $studentStationaryItemsModel = new StudentStationaryItemsModel();
            if( !empty($stationary_items) ) {
                $item_names = array_column($stationary_items, 'item_name');
                $item_ids   = array_column($stationary_items, 'item_id');
                $item_qtys  = array_column($stationary_items, 'qty');
                $item_price = array_column($stationary_items, 'price');

                // Convert to comma-separated string
                $item_names_str = implode(',', $item_names);
                $item_ids_str   = implode(',', $item_ids);
                $item_qtys_str  = implode(',', $item_qtys);
                $item_price_str = implode(',', $item_price);

                $stationaryData = array(
                    'student_id'=> $student_id,
                    'class_id'  => $class_id, // class_id
                    'class_code'=> $student_code, // code
                    'item_ids' => $item_ids_str,                       
                    'item_qtys'=> $item_qtys_str,                      
                    'item_price'=> $item_price_str,
                    'price'     => $total_stationary_fee,
                    'payment_status' => 1,
                    'payment_date' => date('Y-m-d'),
                    'session_year_id'=> $this->session->get('session_year_id'),
                    'add_date'  => date('Y-m-d H:i:s'),
                    'payment_mode' => $ad_payment_mode,
                    'cheque_number' => $cheque_number,
                    'pos_bank_name' => $pos_bank_name,
                    'pos_reference_number' => $pos_reference_number,
                );
                // echo "<pre>"; print_r($stationaryData);
                
                $stationaryResultId = $studentStationaryItemsModel->insert($stationaryData, true);
            }

            // insert student_transaction table
            $studentTransactionModel = new StudentTransactionModel();
            $studentTranData = array(
                'student_code' => $student_code,
                'due_amount' => 0,
                'advanced_amount' => 0,
                'session_year_id' => $this->session->get('session_year_id')
            );
            $student_tran_id = $studentTransactionModel->insert($studentTranData);

            $response['success'] = true;
            $response['student_code'] = $student_code ?? '';
            $response['message'] = 'Re-admission payment added successfully.';
        } else {
            $response['message'] = 'Database insert failed.';
        }

        // pr($updata);
        return $this->response->setJSON($response);
    }

    public function assign_bus()
    {
        $data['title'] = "Assign Bus";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $stoppageMasterModel = new StoppageMasterModel();
        $busToStoppageModel = new BusToStoppageModel();


        // $getFormDetails = $studentFeeStructureModel->getFirstMonthFee($code);

        // if( !isset($getFormDetails) || empty($getFormDetails) ) {
        //     return redirect()->to(base_url('/admin/student/student-list'));
        // }

        $session_id = $this->session->get('session_year_id');
        // $stoppage_id = $getFormDetails['stoppage'] ?? '';
        $stoppage_id = '';
        
        // pr($data);

        $data['stoppage_list'] = $stoppageMasterModel->get_stoppages();
        $data['bus_list'] = $busToStoppageModel->get_bus_list_by_stoppage($stoppage_id);

        $is_student_logged_in = session()->get('student_logged_in');
        if( !$is_student_logged_in ) {
            echo view('admin/student/assign-bus', $data);
        }
        
        echo view('admin/common/footer', $data);
    }

    public function ajax_assign_bus_details()
    {
        $student_code = $this->request->getPost('student_code') ?? '';
        if( $student_code == '' ) {
            $response = [
                'status' => false,
                'message' => 'Please enter student code'
            ];

            return $this->response->setJSON($response);
        }

        $studentTransportFinancialModel = new StudentTransportFinancialModel();
        $busToStoppageModel = new BusToStoppageModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();

        $student_id = student_id_by_code($student_code) ?? '';
        if( $student_id == '' ) {
            $response = [
                'status' => false,
                'message' => 'Student details not found against this student code'
            ];

            return $this->response->setJSON($response);
        }

        $student_bus_details = $studentTransportFinancialModel->asArray()->where('student_id', $student_id)->first();

        $bus_id = $student_bus_details['bus_id'] ?? '';
        $stoppage = $student_bus_details['stoppage'] ?? '';
        $bus_list = $busToStoppageModel->get_bus_list_by_stoppage($stoppage);

        $session_year_id = $this->session->get('session_year_id');
        $student_fee = $studentFeeStructureModel
                        ->asArray()
                        ->where([
                            'student_code'     => $student_code,
                            'session_year_id'  => $session_year_id,
                            'month_id'         => 4
                        ])
                        ->first();
        $getBusPaymentStatus = $student_fee['bus_payment_status'] ?? 0;

        $response = [
            'status' => true,
            'message' => '',
            'student_id' => $student_id,
            'bus_id' => $bus_id,
            'stoppage_id' => $stoppage,
            'bus_list' => $bus_list,
            'bus_payment_status' => $getBusPaymentStatus,
        ];

        return $this->response->setJSON($response);
    }

    public function assign_section()
    {
        $data['title'] = "Assign Section";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $sectionModel = new SectionModel();

        $get_session_year_id = $this->session->get('session_year_id');
        $student_code = '';
        $student_id = '';
        $student_name = '';
        $section_id = '';
        $class_id = '';
        $section_list = [];

        if ($this->request->getMethod() === 'POST') {
            $student_code = $this->request->getPost('student_code');
            $student_id = ($student_code != '') ? student_id_by_code($student_code) : '';
            $student_name = ($student_code != '') ? student_name_by_code($student_code) : '';
            $class_id = ($student_code != '') ? class_id_by_student_code($student_code) : '';
            $section_id = ($student_code != '') ? student_section_by_student_code($student_code) : '';

            $section_list = $sectionModel->get_section_class_id($class_id, $get_session_year_id);
        }

        $data['student_id'] = $student_id;
        $data['student_code'] = $student_code;
        $data['student_name'] = $student_name;
        $data['class_id'] = $class_id;
        $data['section_id'] = $section_id;
        $data['section_list'] = $section_list;

        $is_student_logged_in = session()->get('student_logged_in');
        if( !$is_student_logged_in ) {
            echo view('admin/student/assign-section', $data);
        }
        
        echo view('admin/common/footer', $data);
    }

    public function assign_section_to_single_student()
    {
        $db = \Config\Database::connect();
        
        $student_code = $this->request->getPost('student_code');
        $student_id = $this->request->getPost('student_id');
        $section_id = $this->request->getPost('section_id');
        $class_id = $this->request->getPost('class_id');

        if( $student_id == '' ) {
            $response = [
                'status' => false,
                'message' => 'Student details not found'
            ];

            return $this->response->setJSON($response);
        }

        if( $section_id == '' ) {
            $response = [
                'status' => false,
                'message' => 'Section details not found'
            ];

            return $this->response->setJSON($response);
        }
        
        $studentModel = new StudentModel();
        $studentDetailsModel = new StudentDetailsModel();

        // ✅ START TRANSACTION
        $db->transStart();

        $updated = $studentModel->where('id', $student_id)->set(['section_id' => $section_id])->update();
        $detailsUpdated = $studentDetailsModel->where('student_id', $student_id)->set(['section_id' => $section_id])->update();

        // ✅ COMPLETE TRANSACTION
        $db->transComplete();

        // ✅ CHECK STATUS
        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Update failed, reverted automatically'
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Section assigned successfully'
        ]);
    }
    
    public function generate_individual_student_roll_no()
    {
        $data['title'] = "Generate individual student roll no";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        echo view('admin/student/generate-individual-student-roll-no', $data);  

        echo view('admin/common/footer', $data);
    }

    //import student details function
    public function ajax_import_student_details() {
        if ($this->request->getPost()) {
            // Check if file is uploaded
            if (!isset($_FILES['studentfile'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No file uploaded.'
                ]);
                return;
            }

            $file = $this->request->getFile('studentfile');

            // Validate file extension
            if ($file->getClientExtension() !== 'csv') {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Only CSV files are allowed.'
                ]);
                return;
            }

            // Validate file size (max 5MB)
            if ($file->getSize() > 5242880) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'File size should not exceed 5MB.'
                ]);
                return;
            }

            // Move uploaded file
            $uploadPath = WRITEPATH . 'uploads/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $newName = $file->getRandomName();

            if ($file->move($uploadPath, $newName)) {
                // Process CSV file
                $filePath = $uploadPath . $newName;

                //process start 
                $successCount = 0;
                $failedCount  = 0;
                $errors       = [];
                $studentModel = new StudentModel();
                $studentDetailsModel = new StudentDetailsModel();
                $studentElectiveSubModel = new StudentElectiveSubjectsModel();
                if (($handle = fopen($filePath, 'r')) === false) {
                    return [
                        'success'   => false,
                        'message'   => 'Failed to open CSV file',
                        'processed' => 0,
                        'failed'    => 0,
                    ];
                }
                // Read CSV headers
                $headers = fgetcsv($handle, 1000, ',');
                if (!$headers || !in_array('Student Code', $headers)) {
                    fclose($handle);
                    return [
                        'success'   => false,
                        'message'   => 'CSV must contain "Student Code" column',
                        'processed' => 0,
                        'failed'    => 0,
                    ];
                }

                // Safe header index mapping
                $codeIndex    = array_search('Student Code', $headers);
                $first_elective_subIndex = array_search('first_elective_sub', $headers);
                $second_elective_subIndex = array_search('second_elective_sub', $headers);
                $third_elective_subIndex = array_search('third_elective_sub', $headers);
                $fourth_elective_subIndex = array_search('fourth_elective_sub', $headers);
                $fifth_elective_subIndex = array_search('fifth_elective_sub', $headers);
                $sixth_elective_subIndex = array_search('sixth_elective_sub', $headers);
                $currentSessionId = session()->get('session_year_id');
                $data1 = array();
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    if (empty(array_filter($data))) {
                        continue;
                    }
                    $studentCode = trim($data[$codeIndex] ?? '');
                    if ($studentCode === '') {
                        $failedCount++;
                        $errors[] = 'Student Code is missing';
                        continue;
                    }
                    // Fetch student
                    $student = $studentModel
                            ->select('id, class_id, session_year_id, section_id')
                            ->where('code', $studentCode)
                            ->where('session_year_id', $currentSessionId)
                            ->get()
                            ->getRow();
                    if (!$student) {
                        $failedCount++;
                        $errors[] = "Student not found: {$studentCode}";
                        continue;
                    }
                    // Check if student_details record exists
                    $studentDetails = $studentDetailsModel->where('student_id', $student->id)->where('session_year_id', $currentSessionId)->first();
                    if (!$studentDetails) {
                        $failedCount++;
                        $errors[] = "Student details not found: {$studentCode}";
                        continue;
                    }

                    $classModel = new ClassModel(); 
                    $class_subjects = [];
                    $class_subjects = $classModel->get_class_subjects($student->class_id);
                    if (!$class_subjects) {
                        $failedCount++;
                        $errors[] = "Class subject details not found: {$studentCode}";
                        continue;
                    }
                    $exist_in_arrya = [];
                    $subject_list_1 = [];
                    $subject_list_2 = [];
                    $subject_list_3 = [];
                    $subject_list_4 = [];
                    $subject_list_5 = [];
                    $subject_list_6 = [];
                    if (!empty($class_subjects)) {
                        foreach ($class_subjects as $key => $value) {
                            $exist_in_arrya[] = $value['subject_name'];

                            $res = str_replace( '\"', '"', $value['sub_order']);
                            $allowedin = json_decode($res);

                            if($allowedin!='' && in_array("1",$allowedin))
                            $subject_list_1[] = $value['subject_name'];
                            if($allowedin!='' && in_array("2",$allowedin))
                            $subject_list_2[] = $value['subject_name'];
                            if($allowedin!='' && in_array("3",$allowedin))
                            $subject_list_3[] = $value['subject_name'];
                            if($allowedin!='' && in_array("4",$allowedin))
                            $subject_list_4[] = $value['subject_name'];
                            if($allowedin!='' && in_array("5",$allowedin))
                            $subject_list_5[] = $value['subject_name'];
                            if($allowedin!='' && in_array("6",$allowedin))
                            $subject_list_6[] = $value['subject_name'];
                        }
                    } else {
                        $failedCount++;
                        $errors[] = "Class subject details not found: {$studentCode}";
                        continue;
                    }
                    // Create map: normalized => original
                    $normalizedMap = [];
                    foreach ($exist_in_arrya as $subject) {
                        $normalizedMap[$this->normalize($subject)] = $subject;
                    }

                    
                    if (isset($normalizedMap[$this->normalize($data[$first_elective_subIndex])]) && in_array($normalizedMap[$this->normalize($data[$first_elective_subIndex])], $subject_list_1)) {
                        $data[$first_elective_subIndex] = $normalizedMap[$this->normalize($data[$first_elective_subIndex])];
                    } else {
                        $failedCount++;
                        $errors[] = "Subject 1 not found: {$studentCode} - {$data[$first_elective_subIndex]}";
                        continue;
                    }

                    if (isset($normalizedMap[$this->normalize($data[$second_elective_subIndex])]) && in_array($normalizedMap[$this->normalize($data[$second_elective_subIndex])], $subject_list_2)) {
                        $data[$second_elective_subIndex] = $normalizedMap[$this->normalize($data[$second_elective_subIndex])];
                    } else {
                        $failedCount++;
                        $errors[] = "Subject 2 not found: {$studentCode} - {$data[$second_elective_subIndex]}";
                        continue;
                    }

                    if (isset($normalizedMap[$this->normalize($data[$third_elective_subIndex])]) && in_array($normalizedMap[$this->normalize($data[$third_elective_subIndex])], $subject_list_3)) {
                        $data[$third_elective_subIndex] = $normalizedMap[$this->normalize($data[$third_elective_subIndex])];
                    } else {
                        $failedCount++;
                        $errors[] = "Subject 3 not found: {$studentCode} - {$data[$third_elective_subIndex]}";
                        continue;
                    }

                    if (isset($normalizedMap[$this->normalize($data[$fourth_elective_subIndex])]) && in_array($normalizedMap[$this->normalize($data[$fourth_elective_subIndex])], $subject_list_4)) {
                        $data[$fourth_elective_subIndex] = $normalizedMap[$this->normalize($data[$fourth_elective_subIndex])];
                    } else {
                        $failedCount++;
                        $errors[] = "Subject 4 not found: {$studentCode} - {$data[$fourth_elective_subIndex]}";
                        continue;
                    }

                    if (isset($normalizedMap[$this->normalize($data[$fifth_elective_subIndex])]) && in_array($normalizedMap[$this->normalize($data[$fifth_elective_subIndex])], $subject_list_5)) {
                        $data[$fifth_elective_subIndex] = $normalizedMap[$this->normalize($data[$fifth_elective_subIndex])];
                    } else {
                        $failedCount++;
                        $errors[] = "Subject 5 not found: {$studentCode} - {$data[$fifth_elective_subIndex]}";
                        continue;
                    }

                    if (isset($normalizedMap[$this->normalize($data[$sixth_elective_subIndex])]) && in_array($normalizedMap[$this->normalize($data[$sixth_elective_subIndex])], $subject_list_6)) {
                        $data[$sixth_elective_subIndex] = $normalizedMap[$this->normalize($data[$sixth_elective_subIndex])];
                    } else {
                        $failedCount++;
                        $errors[] = "Subject 6 not found: {$studentCode} - {$data[$sixth_elective_subIndex]}";
                        continue;
                    }

                    $studentElectiveSubjectsData = [
                        'first_elective_sub' => trim($data[$first_elective_subIndex] ?? ''),
                        'second_elective_sub' => trim($data[$second_elective_subIndex] ?? ''),
                        'third_elective_sub' => trim($data[$third_elective_subIndex] ?? ''),
                        'fourth_elective_sub' => trim($data[$fourth_elective_subIndex] ?? ''),
                        'fifth_elective_sub' => trim($data[$fifth_elective_subIndex] ?? ''),
                        'sixth_elective_sub' => trim($data[$sixth_elective_subIndex] ?? ''),
                    ];
                    $exist_elective_subject = [];
                    $exist_elective_subject = $studentElectiveSubModel->where('student_id', $student->id)->get()->getRow();
                    if (!empty($studentElectiveSubjectsData) && !empty($exist_elective_subject)) {
                        $studentElectiveSubjectsData['student_code'] = $studentCode;
                        $studentElectiveSubModel->where('student_id', $student->id)->set($studentElectiveSubjectsData)->update();
                        $successCount++;
                    } else {
                        $studentElectiveSubjectsData['student_id'] = $student->id;
                        $studentElectiveSubjectsData['student_code'] = $studentCode;
                        $studentElectiveSubModel->insert($studentElectiveSubjectsData, true);
                        $successCount++;
                    }
                    $data1['codes'][] = $studentCode;
                    $data1['paper'][] = $studentElectiveSubjectsData;
                    $data1['syud'][] = $student->id;
                    $data1['exist'][] = $exist_elective_subject;
                    
                }
                // print_r();exit;
                fclose($handle);


                $processed = [
                        'success'   => true,
                        'message'   => 'CSV processed successfully',
                        'processed' => $successCount,
                        'failed'    => $failedCount,
                        'errors'    => $errors,
                        'data1'    => $data1,
                    ];
                if ($processed) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Student data uploaded successfully.',
                        'data' => $processed
                        // 'redirect' => base_url('students/list') // Optional redirect
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Failed to process CSV file.',
                        'data' => $data1
                    ]);
                }
                
                // Clean up uploaded file
                unlink($filePath);
            }
        }
    }

    // Normalize function
    public function normalize($str) {
        return strtolower(trim(preg_replace('/\s+/', ' ', $str)));
    }
}