<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AdminUserModel;
use App\Models\ClassModel;

use App\Models\SessionYearModel;
use App\Models\StoppageMasterModel;
use App\Models\ReligionModel;
use App\Models\StudentModel;
use App\Models\StudentDetailsModel;
use App\Models\StudentDocumentsModel;
use App\Models\StudentElectiveSubjectsModel;
use App\Models\StudentParentsGuardiansModel;
use App\Models\StudentPersonalDetailsModel;
use App\Models\StudentTransportFinancialModel;
use App\Models\ConfigurationModel;

class Home extends Controller
{   
    protected $session;
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $adminModel = new AdminUserModel();

        // ✅ Get all admin users
        $data['admins'] = $adminModel->findAll();
        // echo "<pre>"; print_r($data); die();
        return view('home', $data);
    }

    public function registration()
    {
        if (!$this->session->get('isLoggedIn')) {
            // Redirect to login
            redirect()->to('/login')->send();
            exit;
        }

        $data['title'] = "Registration";
        // echo "<pre>"; print_r($data); die();

        echo view('admin/common/header', $data);
        // echo view('admin/common/topbar', $data);

        $classModel = new ClassModel();
        $stoppageMasterModel = new StoppageMasterModel();
        $religionModel = new ReligionModel();
        $sessionYearModel = new SessionYearModel();

        $data['class'] = $classModel->orderBy('id', 'ASC')->findAll();
        $data['stoppage_list'] = $stoppageMasterModel->where('status', 1)->orderBy('stoppage_name', 'ASC')->findAll();
        $data['religion_list'] = $religionModel->orderBy('id', 'ASC')->findAll();
        $data['session_year'] = $sessionYearModel->orderBy('id', 'ASC')->findAll();
        // echo "<pre>"; print_r($data); die();

        /*$data['current'] = $this->master_model->current_session_year();
        
        $data['stoppage_list'] = $this->master_model->get_all_stoppage();       
        $data['religion_list'] = $this->student_model->get_all_list('religion');
        $data['age_claculation_date'] = $this->configuration_model->get_configuration_by_key('age_claculation_date');
        $class_id = 14;     
        $data['subject_list'] = $this->student_model->get_class_subjects($class_id);*/

        echo view('registration', $data);
        // echo view('admin/common/footer', $data);
    }

    /**
     * Handle AJAX request to validate student age against class age limit.
     *
     * This method receives two POST parameters via AJAX:
     * - `classId`: The ID of the selected class.
     * - `age`: The student's age.
     *
     * It then:
     * 1. Loads the `ClassModel`.
     * 2. Retrieves the required minimum age for the given class using `getClassAgeLimit($classId)`.
     * 3. Compares the provided `age` with the class's `age_limit`.
     * 4. Returns:
     *    - `1` if the student's age is **greater than or equal** to the class limit.
     *    - `0` if the student's age is **below** the class limit.
     *
     * @return void  Echoes integer (1 or 0) — intended for AJAX response.
     *
     * Example AJAX Response:
     * ```
     * 1  // valid
     * 0  // invalid
     * ```
     *
     * Example jQuery AJAX call:
     * ```js
     * $.post('controller/get_age_limit', { classId: 5, age: 17 }, function(response) {
     *     if (response == 1) {
     *         alert('Age is valid for this class.');
     *     } else {
     *         alert('Age is below the class requirement.');
     *     }
     * });
     * ```
     */
    public function get_age_limit()
    {
        $valid = 0;
        $class_id = $this->request->getPost('classId');      
        $age = $this->request->getPost('age');
        $bDay = $this->request->getPost('bDay');

        $classModel = new ClassModel();
        $age_limit = $classModel->getClassAgeLimit($class_id);

        $configurationModel = new ConfigurationModel();
        $age_claculation_date = $configurationModel->get_configuration_by_key('age_claculation_date');
        $age_claculation_date_ymd = date('Y-m-d', strtotime($age_claculation_date));
        
        $getAgeRound = age_round($bDay, $age_claculation_date_ymd);

        if($getAgeRound >= $age_limit){
            $valid= 1;
        } else {
            $valid = 0;
        }

        echo $valid;
    }

    public function get_class_subjects(){
        $valid = 0;
        $class_id = $this->request->getPost('classId');
        $sub1 = '';
        $sub2 = '';
        $sub3 = '';
        $sub4 = '';
        $sub5 = '';
        $sub6 = ''; 
        if($this->request->getPost('studentData') != '')  {
            $sub1 = $this->request->getPost('studentData')['first_elective_sub'] ?? '';
            $sub2 = $this->request->getPost('studentData')['second_elective_sub'] ?? '';
            $sub3 = $this->request->getPost('studentData')['third_elective_sub'] ?? '';
            $sub4 = $this->request->getPost('studentData')['fourth_elective_sub'] ?? '';
            $sub5 = $this->request->getPost('studentData')['fifth_elective_sub'] ?? '';
            $sub6 = $this->request->getPost('studentData')['sixth_elective_sub'] ?? '';

        } 
        // echo json_encode($sub1);exit;
        $classModel = new ClassModel(); 
        $result = $classModel->get_class_subjects($class_id);

        $data =[];
        
        
        $option1 = '<option value="">--Select--</option>';
        $option2 = '<option value="">--Select--</option>';
        $option3 = '<option value="">--Select--</option>';
        $option4 = '<option value="">--Select--</option>';
        $option5 = '<option value="">--Select--</option>';
        $option6 = '<option value="">--Select--</option>';
        
        foreach($result as $subject){   
            // $allowedin = json_decode($subject['sub_order']);
            $res = str_replace( '\"', '"', $subject['sub_order']);
            $allowedin = json_decode($res);

            if(in_array("1",$allowedin) && $allowedin!='')
            $option1 .='<option value="'.$subject['subject_name'].'" '.(($subject['subject_name'] == $sub1) ? 'selected' : '').'>'.$subject['subject_name'].'</option>';
            
            if(in_array("2",$allowedin) && $allowedin!='')
            $option2 .='<option value="'.$subject['subject_name'].'" '.(($subject['subject_name'] == $sub2) ? 'selected' : '').'>'.$subject['subject_name'].'</option>';
            
            if(in_array("3",$allowedin) && $allowedin!='')
            $option3 .='<option value="'.$subject['subject_name'].'" '.(($subject['subject_name'] == $sub3) ? 'selected' : '').'>'.$subject['subject_name'].'</option>';
            
            if(in_array("4",$allowedin) && $allowedin!='')
            $option4 .='<option value="'.$subject['subject_name'].'" '.(($subject['subject_name'] == $sub4) ? 'selected' : '').'>'.$subject['subject_name'].'</option>';
            
            if(in_array("5",$allowedin) && $allowedin!='')
            $option5 .='<option value="'.$subject['subject_name'].'" '.(($subject['subject_name'] == $sub5) ? 'selected' : '').'>'.$subject['subject_name'].'</option>';
            
            if(in_array("6",$allowedin) && $allowedin!='')
            $option6 .='<option value="'.$subject['subject_name'].'" '.(($subject['subject_name'] == $sub6) ? 'selected' : '').'>'.$subject['subject_name'].'</option>';
        }
        
        $data[0] = $option1;
        $data[1] = $option2;
        $data[2] = $option3;
        $data[3] = $option4;
        $data[4] = $option5;
        $data[5] = $option6;
        
        echo json_encode($data);
    }

    private function handleFileUpload($fieldName, $studentCode, $overwrite = true)
    {
        if (strpos($studentCode, '/') !== false) {
            $studentCode = str_replace('/', '_', $studentCode);
        }

        $file = $this->request->getFile($fieldName);
        
        // Check if file was uploaded and has no errors
        if ($file && $file->isValid() && !$file->hasMoved()) {
            
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

    public function save_registration()
    {
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
            // 'telephone_resi' => 'required',
            // 'email' => 'required',
            // 'academic_status' => 'required',
        ];

        $localGurdian = $this->request->getPost('localGurdian');
        if ($localGurdian === 'on') {
            $validationRules['local_guar_name'] = 'required';
            $validationRules['local_guar_aadhaar_no'] = 'required';
        }

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $studentDetailsModel = new StudentDetailsModel();
        $formNo = $studentDetailsModel->lastestFormNo();

        $getSessionName = $this->session->get('session_year_name') ?? '2026-2027';

        $lastestFormNo = 'SCMS/'.$getSessionName.'/00001';
        if (!empty($formNo)) {
            // Split by last slash to get the numeric part
            $parts = explode('/', $formNo);
            
            // Increment the last numeric part
            $number = isset($parts[2]) ? (int)$parts[2] + 1 : 1;
            
            // Pad with leading zeros (5 digits)
            $numberPadded = sprintf("%05d", $number);
            
            // Generate the new form number with the same session
            $sessionPart = $getSessionName ?? ($parts[1] ?? ''); // fallback if session missing
            $lastestFormNo = 'SCMS/' . $sessionPart . '/' . $numberPadded;
        }

        /*$lastestFormNo = 'SCMS00001';
        if(!empty($formNo)){
            $fno = explode('SCMS', $formNo);
            $lastestFormNo = 'SCMS'.sprintf("%05s", $fno[1]+1);
        }*/

        $get_session_year_id = $this->session->get('session_year_id');
        $get_user_id = $this->session->get('user_id');

        /*echo "<pre>"; print_r($this->request->getPost());
        echo "<pre>"; print_r($this->request->getFiles());
        echo "<======================================================>";
        echo "<pre>"; print_r($_POST);
        echo "<pre>"; print_r($_FILES);
        die();*/
    
        $class_id = $this->request->getPost('class_id');
        $studentTableData = [
            'class_id' => $this->request->getPost('class_id'),
            'status' => 1,
            'session_year_id' => $get_session_year_id,
        ];

        $studentModel = new StudentModel();
        $student_id = $studentModel->insert($studentTableData);

        // === STUDENT DETAILS TABLE ===
        $studentDetailsTableData = [
            'student_id' => $student_id,
            'code' => null,
            'form_no' => $lastestFormNo,
            'bs_id' => $this->request->getPost('bs_id') ?? '',
            'stream_id' => 0,
            'class_id' => $this->request->getPost('class_id') ?? 0,
            'section_id' => null,
            'roll_num' => null,
            'first_name' => $this->request->getPost('first_name') ?? '',
            'middle_name' => '',
            'surname' => '',
            'd_o_b' => $this->request->getPost('d_o_b') ?? '',
            'gender' => $this->request->getPost('gender') ?? '',
            'blood_grp' => $this->request->getPost('blood_grp') ?? '',
            'caste' => $this->request->getPost('caste') ?? '',
            'image' => $this->getUploadedFilePath('userfile', $lastestFormNo),
            'aadhaar_no' => $this->request->getPost('aadhaar_no') ?? '',
            'admission_number' => null,
            'admission_date' => date('Y-m-d'),
            'school_house_id' => 0,
            'promotion' => null,
            'academic_status' => $this->request->getPost('academic_status') ?? 'Bonafide',
            'tc_required' => $this->request->getPost('tc_required') ?? '',
            'tc_date' => $this->request->getPost('pre_school_tc_date') ?? '',
            'tc_no' => $this->request->getPost('pre_school_tc_no') ?? '',
            'pen_no' => $this->request->getPost('pen_no') ?? '',
            'appar_id' => $this->request->getPost('appar_id') ?? '',
            'shift' => $this->request->getPost('shift') ?? '',
            'admission' => 0,
            'status' => 1,
            'created_by' => $get_user_id,
            'created_date' => date('Y-m-d h:i:s'),
            'session_year_id' => $get_session_year_id,
            'session_result_status' => 0,
            'ad_exam_qualified' => 4,  // 0-Fail, 1-Pass, 2-Not Appeared, 3-Submitted, 4- Not Submitted, 5 - Reject
            'rejection_reason' => null,
            'fail_consideration' => null,
            'fail_cons_remarks' => null,
            'relative' => null,
            'relative_name' => null,
            'relative_code' => null,
            'relationship' =>null,
            'comment' => null,
            'student_admit' => $this->getUploadedFilePath('student_admit', $lastestFormNo),
        ];

        $studentDocumentsData = [
            'student_id'    => $student_id,
            'student_code'  => null,
            'signature'     => $this->getUploadedFilePath('p_signature', $lastestFormNo), // parent signature 
            'f_image'       => $this->getUploadedFilePath('f_image', $lastestFormNo),
            'm_image'       => $this->getUploadedFilePath('m_image', $lastestFormNo),
            'f_signature'   => $this->getUploadedFilePath('f_signature', $lastestFormNo),
            'm_signature'   => $this->getUploadedFilePath('m_signature', $lastestFormNo),
            'g_image'       => $this->getUploadedFilePath('g_image', $lastestFormNo),
            'g_signature'   => $this->getUploadedFilePath('g_signature', $lastestFormNo),
            'stu_signature' => $this->getUploadedFilePath('s_signature', $lastestFormNo),
            'cast_certificate' => $this->getUploadedFilePath('cast_certificate', $lastestFormNo),
            'caste_photocopy' => null,
            'application' => $this->getUploadedFilePath('application_pre', $lastestFormNo),
            'trans_cert' => $this->getUploadedFilePath('trans_cert', $lastestFormNo),
            'migration_cert' => $this->getUploadedFilePath('migration_cert', $lastestFormNo),
            'any_special_cert' => $this->getUploadedFilePath('any_special_cert', $lastestFormNo),
        ];

        $studentElectiveSubjectsData = [
            'student_id' => $student_id,
            'student_code' => null,
            'first_elective_sub' => $this->request->getPost('first_elective_sub') ?? '',
            'second_elective_sub' => $this->request->getPost('second_elective_sub') ?? '',
            'third_elective_sub' => $this->request->getPost('third_elective_sub') ?? '',
            'fourth_elective_sub' => $this->request->getPost('fourth_elective_sub') ?? '',
            'fifth_elective_sub' => $this->request->getPost('fifth_elective_sub') ?? '',
            'sixth_elective_sub' => $this->request->getPost('sixth_elective_sub') ?? '',
            'last_year_marksheet' => $this->getUploadedFilePath('sixth_elective_sub', $lastestFormNo) ?? '',
            'student_birth_certificate' => $this->getUploadedFilePath('student_id', $lastestFormNo) ?? '', // For birth certificate
            'student_admit' => $this->getUploadedFilePath('student_admit', $lastestFormNo) ?? '',
            'father_id' => $this->getUploadedFilePath('father_id', $lastestFormNo) ?? '', // Father's Id Proof
            'mother_id' => $this->getUploadedFilePath('mother_id', $lastestFormNo) ?? '', // Mother's Id Proof
            'cast_certificate' => $this->getUploadedFilePath('cast_certificate', $lastestFormNo) ?? '', // Cast Certificate (Student / Father)
        ];

        $studentParentsGuardiansData = [
            'student_id' => $student_id,
            'student_code' => null,
            'father_designation' => null,
            'father_office_address' => null,
            'father_office_phone' => null,
            'father_qualification' => null,
            'mother_designation' => null,
            'mother_office_address' => null,
            'mother_office_phone' => null,
            'mother_qualification' => null,
            'mothers_is_gurgent' => null,

            'father_id' => $this->getUploadedFilePath('father_id', $lastestFormNo) ?? '',
            'mother_id' => $this->getUploadedFilePath('mother_id', $lastestFormNo) ?? '',

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
            'local_guar_office_phone' => '',
            'local_guar_address' => $this->request->getPost('local_guar_address') ?? '',
            'family_earn_memb' => $this->request->getPost('family_earn_memb') ?? '',
            'dependent' => $this->request->getPost('dependent') ?? '',
        ];

        $studentPersonalDetailsData = [
            'student_id' => $student_id,
            'student_code' => null,
            'second_language' => $this->request->getPost('lkg_onw_sec_lang') ?? '',
            'medical_condition' => $this->request->getPost('medical_condition') ?? '',
            'residential_address' => null,
            'residential_phone' => null,
            'residential_mobile' => null,
            'whatsapp_number_one' => null,
            'whatsapp_number_two' => null,

            'mother_language' => $this->request->getPost('mother_tongue') ?? '',
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

        $studentTransportBankData = [
            'student_id' => $student_id,
            'student_code' => null,
            'bank_acc_no' => null,
            'bank_ifsc_no' => null,
            'transport_required' => null,
            'stoppage' => $this->request->getPost('stoppage') ?? 0,
            'bus_id' => 0,
            'bus_alloted_date' => NULL,
            'allow_transport' => 1,
            'deposit_refund_status' => null,
            'refund_date' => NULL,
            'refund_message' => null,
            'sm_refund_amount' => 0,
            'sm_refund_date' => NULL,
            'allow_readmission' => 1,
            'dmg_prd' => null,
            'dmg_prd_price' => null,
            'dmg_prd_img' => null,
        ];

        $studentDocumentsModel = new StudentDocumentsModel();
        $studentElectiveSubjectsModel = new StudentElectiveSubjectsModel();
        $studentParentsGuardiansModel = new StudentParentsGuardiansModel();
        $studentPersonalDetailsModel = new StudentPersonalDetailsModel();
        $studentTransportFinancialModel = new StudentTransportFinancialModel();

        if( $student_id ) {
            $studentDetailsModel->insert($studentDetailsTableData);
            $studentDocumentsModel->insert($studentDocumentsData);
            $studentElectiveSubjectsModel->insert($studentElectiveSubjectsData);
            $studentParentsGuardiansModel->insert($studentParentsGuardiansData);
            $studentPersonalDetailsModel->insert($studentPersonalDetailsData);
            $studentTransportFinancialModel->insert($studentTransportBankData);

            return redirect()->to('/registration')->with('success', 'STUDENT REGISTRATION COMPLETED SUCCESSFULLY. FORM NO : <span style="font-size: x-large; font-weight: bold;">' .$lastestFormNo.'<span>');

            // return redirect()->to('/registration')->with('success', 'Registration successfully,and after 24 hours check admission status. Please Carefully copy the FORM NO --  <strong>' .$lastestFormNo.'</strong>     All documents, which are uploaded by the student during the online admission process, have to submit in original for verification at school office in scheduled date and time ( which will be announced after reopening the school ) Failing which admission will  be cancelled .');

            /*if($class_id != 14 && $class_id != 16 && $class_id != 18 ){
                $session = \Config\Services::session();
                $session->set( 'temp_form_no', $lastestFormNo );

                return redirect()->to('/payRegFee/' . $lastestFormNo)->with('success', 'Registration successfully done');
            } else {
                return redirect()->to('/registration')->with('success', 'Registration successfully,and after 24 hours check admission status. Please Carefully copy the FORM NO --  ' .$lastestFormNo.'     All documents, which are uploaded by the student during the online admission process, have to submit in original for verification at school office in scheduled date and time ( which will be announced after reopening the school ) Failing which admission will  be cancelled .');
            }*/
        }

        return redirect()->to('registration' . $lastestFormNo)->with('error', 'Registration not done');
    }

    public function pay_registration_fee($form_no)
    {
        $data['title'] = "Pay Registration Fee";

        $configurationModel = new ConfigurationModel();
        $data['ad_reg_fee'] = $configurationModel->get_configuration_by_key('admission_registration_fee');

        $temp_form_no = $form_no;
        $data['form_no'] = $form_no;

        $studentDetailsModel = new StudentDetailsModel();
        $data['formData'] = $studentDetailsModel->get_form_details($temp_form_no);

        echo view('admin/common/header', $data);
        echo view('pay-registration-fee', $data);
    }

}


