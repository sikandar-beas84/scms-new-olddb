<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
        $this->load->model('Student_model');
		date_default_timezone_set('Asia/Kolkata');
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }

	}

	public function index(){
        // $html = $this->load->view('student/admissionFrom',$data, TRUE);
        // $data['html'] = $html;
        $data['class'] = $this->Common_model->relational_dropdown(
            'class',
            'id',
            'class_name',
            ['status' => 'Y', 'is_delete !=' => 'Y'],
            ' - '
        );
        // prx($data['class']);
        if($this->uri->segment(4) == 'student'):
            $head['title'] = $data['page_title'] =  $this->uri->segment(4);
        else:
            $head['title'] = $data['page_title'] =  $this->uri->segment(4).' Admission';

        endif;

        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
		$this->load->view('include/breadcrumb');
		$this->load->view('student/student');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}
	public function csv(){

        // prx($data['class']);
        $head['title'] = $data['page_title'] = 'Student';

        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
		$this->load->view('student/student');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}


	
    public function list() {
        // Include Datatable model
        include_once('application/models/Datatable_model.php');
        if( post('application_status') != 'student'){

            // Define order and where conditions
            $order_by = array('students_details.id' => 'desc');
            $where = array(
                'students_details.is_delete' => 'N',
                'students_details.session_id' => $this->session->userdata('session')
            );
        
            // Add additional conditions based on POST data
            if (post('class')) {
                $where['students_details.class'] = post('class');
            }
        
            if (post('studentId')) {
                $where['students_details.student_id'] = post('studentId');
            }
        
            if (post('application_status')) {
                $where['students_details.application_status'] = post('application_status');
            }
            $join = array(
                array(
                    'ontable'	=> 'session',
                    'onParams'	=> 'session.id = students_details.session_id',
                    'type'		=> 'left'
                ),
                array(
                    'ontable'	=> 'class',
                    'onParams'	=> 'class.id = students_details.class',
                    'type'		=> 'left'
                ),
                array(
                    'ontable'	=> 'section',
                    'onParams'	=> 'section.id = students_details.section',
                    'type'		=> 'left'
                ),
            );
                    // Initialize query attachments
                    $queryAttachments = array(
                        'select' => 'students_details.*, section.section as section_name,class.class_name',
                        'where' => $where,
                        'where_in' => array(),
                        'join' => $join,
                        'group_by' => ''
                    );
                
                    // Create Datatable model instance
                    $dttbl_model = new Datatable_model('students_details', array(), array(), $order_by, $queryAttachments);
                    // prx($this->db->last_query());
        }else{
            $order_by = array('session_wish_student_data.id' => 'desc');
            $where = array(
                // 'session_wish_student_data.is_delete' => 'N',
                'session_wish_student_data.session_id' => $this->session->userdata('session')
            );
        
            // Add additional conditions based on POST data
            if (post('class')) {
                $where['session_wish_student_data.class'] = post('class');
            }
        
            if (post('studentId')) {
                $student = $this->Generalmodel->getDataWhere('students_details',['student_code' => post('studentId'), 'session_id'=>$this->session->userdata('session')]);
                $where['session_wish_student_data.student'] = $student[0]->id;
            }
        
            if (post('application_status')) {
                $where['students_details.application_status'] = post('application_status');
            }
            $join = array(
                array(
                    'ontable'	=> 'students_details',
                    'onParams'	=> 'students_details.id = session_wish_student_data.student',
                    'type'		=> 'left'
                ),
                array(
                    'ontable'	=> 'session',
                    'onParams'	=> 'session.id = students_details.session_id',
                    'type'		=> 'left'
                ),
                array(
                    'ontable'	=> 'class',
                    'onParams'	=> 'class.id = students_details.class',
                    'type'		=> 'left'
                ),
                array(
                    'ontable'	=> 'section',
                    'onParams'	=> 'section.id = students_details.section',
                    'type'		=> 'left'
                ),
            );
                    // Initialize query attachments
                    $queryAttachments = array(
                        'select' => 'students_details.*, section.section as section_name,class.class_name',
                        'where' => $where,
                        'where_in' => array(),
                        'join' => $join,
                        'group_by' => ''
                    );
                
                    // Create Datatable model instance
                    $dttbl_model = new Datatable_model('session_wish_student_data', array(), array(), $order_by, $queryAttachments);
                
        }
  
        // Get rows from the model
        $testdata = $dttbl_model->getRows($_POST);
        $data = array();
        // Process each record
        foreach ($testdata as $key => $fieldData) {
           
            // Determine status badge class
            $statusClass = ($fieldData->status == "Active") ? "success" : "warning";
    
            // Prepare status HTML
            $status = '<span class="badge badge-' . $statusClass . ' rounded-pill d-inline">' . $fieldData->status . '</span>';
    
            // Prepare action buttons HTML
            $action = '<div class="_leads_action">'
                    . '<a href="'.base_url().'student/admission?id='.$fieldData->student_id.'&action=1" data-id="' . $fieldData->student_id . '" class="btn btn-outline-info btn-xs viewProperty" ><i class="fa fa-eye" aria-hidden="true"></i></a>'
                    
                    ;
                    if($fieldData->application_status !='reject'){
                        $action .= '<a href="'.base_url().'student/admission?id='.$fieldData->student_id.'&action=2" data-id="' . $fieldData->student_id . '" class="btn btn-outline-success btn-xs editProperty" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                   
                     }
                    if($fieldData->application_status =='pending'){
                        $action .= '<a href="javascript:" class="btn btn-outline-danger btn-xs" onclick="action(' . $fieldData->id . ',3)"><i class="fa fa-cog" aria-hidden="true"></i></a>';
                   
                     }
                    if($fieldData->application_status =='approved'){
                        $payment = $this->Student_model->getStudentAprilMonthPaymentDetails($fieldData->id);
                        $action .= '<a href="javascript:" class="btn btn-outline-danger btn-xs" onclick="action(' . $payment[0]->id . ',4)"><i class="fa fa-credit-card " aria-hidden="true"></i></a>';
                    }
                    if($fieldData->application_status =='student'){
                        $action .= '<a href="'.base_url().'student/fees/index/'.$fieldData->id.'" class="btn btn-outline-info btn-xs" style="font-size: 14px;" ><i class="fa fa-credit-card " aria-hidden="true"></i> Collect Fee</a>';
                        // $action .= '<a href="javascript:" class="btn btn-outline-danger btn-xs" onclick="getInvoice(' . $fieldData->id . ')"><i class="fas fa-file-invoice"></i><i class="fa fa-file-text-o " aria-hidden="true"></i></a>';
                    }
                      // . '<a href="javascript:" class="btn btn-outline-danger btn-xs" onclick="action(' . $fieldData->student_id . ',0)"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                      $action .= '</div>';
    
            // Add processed data to the array
            $data[] = array(
                // $fieldData->student_id,
                $fieldData->admission_form_no,
                $fieldData->student_code,
                $fieldData->class_name,
                $fieldData->section_name,
                // $fieldData->roll,
                $fieldData->student_name,
                $fieldData->banglar_siksha_id,
                $fieldData->pen,
                $fieldData->gender,
                $fieldData->dob,
                $fieldData->student_aadhar,
                // $fieldData->permanent_address,
                // $fieldData->present_address,
                // $fieldData->bank_ac_no,
                // $fieldData->ifsc,
                // $fieldData->religion,
                // $fieldData->category,
                $fieldData->email_id,
                $fieldData->mother_language,
                $fieldData->second_language,
                $fieldData->third_language,
                $fieldData->blood_group,
                // $fieldData->only_child,
                $fieldData->medical_condition,
                // $fieldData->academic_status,
                // $fieldData->house,
                // $fieldData->nationality,
                // $fieldData->admission_no,
                $fieldData->admission_date,
                // $fieldData->bpl,
                // $fieldData->tc_require,
                // $fieldData->tc_submitted_date,
                // $fieldData->migration_require,
                // $fieldData->migration_submitted_date,
                $fieldData->father_name . ' || ' . $fieldData->father_mobile_no ,
                $fieldData->mother_name . ' || ' . $fieldData->mother_mobile_no ,
                $fieldData->local_guardian_name . ' || ' . $fieldData->local_guardian_mobile_no ,
                // $fieldData->student_subject_option,
                // $fieldData->assign_academic_status,
                // $fieldData->security_money_details,
                $status,
                $action
            );
        }
    
        // Prepare response
        $output = array(
            "draw" => isset($_POST['draw']) ? $_POST['draw'] : '',
            "recordsTotal" => $dttbl_model->countAll(),
            "recordsFiltered" => $dttbl_model->countFiltered($_POST),
            "data" => $data,
            "status" => 'success'
        );
    
        // Output JSON response
        echo json_encode($output);
    
        // Cleanup
        unset($dttbl_model);
    }
    


	// For Delete, Update and View From DataTable
		// For Delete, Update and View From DataTable
        public function action(){
            
    
            $fromData = [
                'application_status'=>post('action'),
                'reject_notes'=>post('reject_notes'),
                'application_action_by'=>$this->session->userdata('user_id'),
                'application_action_at'=>date('Y-m-d H:i:s'),
            ];
         
            if(post('action') == 'approved'){
                $student = $this->Generalmodel->getData('students_details',post('id'),'id','','','get','');
                $fees = $data['fees'] = $this->Generalmodel->getDataWhere('fees',['class' => $student[0]->class, 'session_year'=>$this->session->userdata('session')]);
                // $data['class'] = $this->Generalmodel->getDataWhere('class',['id' => $student[0]->class]);
                // prx($data);
                $paymentData = [
                    'session_year'=>$this->session->userdata('session'),
                    'student_id'=>post('id'),
                    'class'=>$student[0]->class,
                    'month'=> 4,
                    'payment_status'=> 'N',
                    'utr'=>'',
                    'payment_type'=> '',
                    'session_fees' => $fees[0]->session_fees,
                    'academic_fees' => $fees[0]->academic_fees,
                    'tuition_fees' => $fees[0]->tuition_fees,
                    'monthly_fees' => $fees[0]->monthly_fees,
                    'sports_fees' => $fees[0]->sports_fees,
                    'library_fees' => $fees[0]->library_fees,
                    'lab_fees' => $fees[0]->lab_fees,
                    'other_curriculum_fees' => $fees[0]->other_curriculum_fees,
                    'created_by'=>$this->session->userdata('user_id'),
                    'created_at'=>date('Y-m-d H:i:s'),
                    'payment_date'=>date('Y-m-d H:i:s'),
                ];
                $res = $this->Generalmodel->getData('student_payment_details',post('id'),'id','','','insert',$paymentData);
                $res1 = $this->Student_model->genareteFeesPaymentData(post('id'), $student[0]->class);
            }
           
            $res = $this->Generalmodel->getData('students_details',post('id'),'id','','','update',$fromData);
            if($res):
                $result = array('html' => '', 'message'=>strtoupper(post('action')).' Successfully.', 'status' => 'success');
            else:
                $result = array('html' => $this->db->last_query(), 'message'=>'Something went to wrong.', 'status' => 'error');
            endif;
            $obj = (object) array_merge((array) $result,update_csrf_session());
            echo json_encode($obj);
        }
        public function getFeesDataById(){
            $student = $this->Generalmodel->getDataWhere('students_details',['id' => post('student_id'), 'session_id'=>$this->session->userdata('session')]);
            // $fees = $this->Generalmodel->getDataWhere('fees',['class' => $student[0]->class, 'session_year'=>$this->session->userdata('session')]);
            $fees = $this->Generalmodel->getDataWhere('student_payment_details',['student_id' => post('student_id'), 'month'=> 4, 'session_year'=>$this->session->userdata('session')]);
            
            if($fees):
                $result = array('data' =>$fees, 'message'=>post('action').' successfully.', 'status' => 'success');
            else:
                $result = array('data' =>$fees, 'message'=>'Something went to wrong.', 'status' => 'error');
            endif;
            $obj = (object) array_merge((array) $result,update_csrf_session());
            echo json_encode($obj);
        }
        public function payment(){
            $student = $data['student'] = $this->Generalmodel->getDataWhere('students_details',['id' => post('studentId'), 'session_id'=>$this->session->userdata('session')]);
            // $fees = $data['fees'] = $this->Generalmodel->getDataWhere('fees',['class' => $student[0]->class, 'session_year'=>$this->session->userdata('session')]);
            // $data['class'] = $this->Generalmodel->getDataWhere('class',['id' => $student[0]->class]);
            // // prx($data);
            // $fromData = [
            //     'session_year'=>$this->session->userdata('session'),
            //     'student_id'=>post('studentId'),
            //     'class'=>post('class_id'),
            //     'month'=> 4,
            //     'payment_status'=> 'Y',
            //     'utr'=>post('utrNumber'),
            //     'payment_type'=>post('payment_type'),
            //     'session_fees' => $fees[0]->session_fees,
            //     'academic_fees' => $fees[0]->academic_fees,
            //     'tuition_fees' => $fees[0]->tuition_fees,
            //     'monthly_fees' => $fees[0]->monthly_fees,
            //     'sports_fees' => $fees[0]->sports_fees,
            //     'library_fees' => $fees[0]->library_fees,
            //     'lab_fees' => $fees[0]->lab_fees,
            //     'other_curriculum_fees' => $fees[0]->other_curriculum_fees,
            //     'created_by'=>$this->session->userdata('user_id'),
            //     'created_at'=>date('Y-m-d H:i:s'),
            //     'payment_date'=>date('Y-m-d H:i:s'),
            // ];
            // $res = $this->Generalmodel->getData('student_payment_details',post('id'),'id','','','insert',$fromData);
            // $res1 = $this->Student_model->genareteFeesPaymentData(post('studentId'), post('class_id'));

            $html = $this->load->view('student/admissionInvoice',$data, TRUE);
            if($res):
                $studentId = str_pad(post('studentId'), 3, '0', STR_PAD_LEFT);
                $studentCode =  'GPS'.$studentId;
                $studentsData = [
                    'username'=>$studentCode,
                    'password'=>md5($student[0]->father_mobile_no),
                    'first_name'=>$student[0]->student_name,
                    'last_name'=>'',
                    'email'=>$student[0]->email_id,
                    'phone'=>$student[0]->phone,
                    'date_of_birth'=>$student[0]->dob,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'created_by'=>$this->session->userdata('user_id'),
                ];
                $res = $this->Generalmodel->getData('students','','','','','insert',$studentsData);
                $fromData = [
                    'student_table_id'=>$this->db->insert_id(),
                    'application_status'=>'student',
                    'application_action_by'=>$this->session->userdata('user_id'),
                    'application_action_at'=>date('Y-m-d H:i:s'),
                ];
                $fromData['student_id'] =  $studentCode;
                $res = $this->Generalmodel->getData('students_details',post('studentId'),'id','','','update',$fromData);
                $session_wish_student_data = [
                    'session_id'=> get_session('session'),
                    'student'=>$student[0]->id,
                    'student_code'=>$student[0]->admission_form_no,
                    'class'=>$student[0]->class,
                    'section'=>$student[0]->section,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'created_by'=>$this->session->userdata('user_id'),
                ];
                $session_wish_student_data_result = $this->Generalmodel->getData('session_wish_student_data','','','','','insert',$session_wish_student_data);
                $result = array('html' => $html, 'message'=>post('action').' successfully.', 'status' => 'success');
            else:
                $result = array('html' => '', 'message'=>'Something went to wrong.', 'status' => 'error');
            endif;
            $obj = (object) array_merge((array) $result,update_csrf_session());
            echo json_encode($obj);
        }
        function save() {
            $table = 'students_details'; // Specify your table name here
        
            // Define field configurations
            $data['select'] = array(
                'status' => array('Y' => 'Active', 'N' => 'Inactive'),
                'gender' => array('Male' => 'Male', 'Female' => 'Female'),
                'only_child' => array('Yes' => 'Yes', 'No' => 'No'),
                'bpl' => array('Yes' => 'Yes', 'No' => 'No'),
                'academic_status_assigned' => array('Pass' => 'Pass', 'Fail' => 'Fail'),
            );
        
            $data['dynamic_fields'] = [
                'student_subject_option' => array(
                    'max_limit' => 6,
                    'min_limit' => 1,
                    'field' => array('student_subject_option' => 'text'),
                )
            ];
            
            $data['textEditor'] = ['present_address', 'permanent_address'];
            $data['unsetTextEditor'] = ['present_address' => '2', 'permanent_address' => '2'];
            
            $data['section'] = [
                'student_name' => 'Student Details:',
                'father_name' => 'Parents Details: <br><span class="subHeading">Father\'s Details: </span>',
                'mother_name' => '<span class="subHeading">Mother\'s Details: </span>',
                'local_guardian_name' => '<span class="subHeading">Local Guardian Details (If Available) : </span>',
                'student_subject_option' => '',
                'student_photo' => 'Attachment: <br><span class="subHeading"> </span>',
            ];
        
            $data['fieldType'] = [
                'student_name' => 'text',
                'bank_account_no' => 'int',
                'student_aadhar' => 'int',
                'father_aadhar_no' => 'int',
                'email_id' => 'email',
                'father_mobile_no' => 'tel',
                'father_whatsapp_no' => 'tel',
                'father_name' => 'text',
                'father_occupation' => 'text',
                'father_annual_income' => 'number',
                'mother_name' => 'text',
                'mother_mobile_no' => 'tel',
                'mother_whatsapp_no' => 'tel',
                'mother_aadhar_no' => 'int',
                'mother_occupation' => 'text',
                'mother_annual_income' => 'number',
                'local_guardian_name' => 'text',
                'local_guardian_mobile_no' => 'tel',
                'local_guardian_whatsapp_no' => 'tel',
                'local_guardian_aadhar_no' => 'int',
                'local_guardian_occupation' => 'text',
                'local_guardian_annual_income' => 'number',
            ];
        
            $data['size'] = [
                'pen' => 4,
                'gender' => 4,
                'dob' => 4,
                'class' => 3,
                'section' => 3,
                'religion' => 4,
                'category' => 4,
                'email_id' => 4,
                'blood_group' => 2,
                'only_child' => 2,
                'medical_condition' => 8,
                'attachments' => 12,
            ];
        
            // Load select options dynamically
            $data['select']['class'] = $this->Common_model->relational_dropdown(
                'class',
                'id',
                'class_name',
                ['status' => 'Y', 'is_delete !=' => 'Y'],
                ' - '
            );
            $data['select']['section'] = $this->Common_model->relational_dropdown(
                'section',
                'id',
                'section',
                ['status' => 'Y', 'is_delete !=' => 'Y'],
                ' - '
            );
        
            $data['hidden'] = [
                'id', 'is_delete', 'student_id', 'student_table_id', 'admission_form_no', 'roll', 
                'admission_no', 'admission_date', 'created_at', 'updated_at', 'status'
            ];
        
            $data['file'] = array(
                'student_photo' => array(
                    'fieldType' => 'single',
                    'accept' => 'image/*',
                    'path' => 'assets/uploads/student/',
                    'errorPath' => base_url() . 'assets/noImageProfile.png'
                ),
                'signature_father' => array(
                    'fieldType' => 'single',
                    'accept' => 'image/*',
                    'path' =>'assets/uploads/student/signature_father/',
                    'errorPath' => base_url() . 'assets/noImage.jpg'
                ),
                'signature_mother' => array(
                    'fieldType' => 'single',
                    'accept' => 'image/*',
                    'path' => 'assets/uploads/student/signature_mother/',
                    'errorPath' => base_url() . 'assets/noImage.jpg'
                ),
                'signature_local_guardian' => array(
                    'fieldType' => 'single',
                    'accept' => 'image/*',
                    'path' => 'assets/uploads/student/signature_local_guardian/',
                    'errorPath' => 'assets/noImage.jpg'
                ),
                'attachments' => array(
                    'fieldType' => 'multi',
                    'accept' => 'image/*,application/pdf',
                    'path' =>'assets/uploads/student/attachments/',
                    'errorPath' => base_url() . 'assets/noImage.jpg'
                ),
            );
        
            // Fetch table fields
            $fields = $this->db->list_fields($table);
            // prx($fields);
            // Validate fields
            foreach ($fields as $field) {
                if (!in_array($field, $data['hidden'])) { // Skip hidden fields
                    if (isset($data['select'][$field])) {
                        // Add validation rule for select fields
                        $this->form_validation->set_rules($field, ucfirst(str_replace('_', ' ', $field)), 'required|in_list[' . implode(',', array_keys($data['select'][$field])) . ']');
                    } elseif (in_array($field, $data['textEditor'])) {
                        // Add validation rule for text editor fields
                        $this->form_validation->set_rules($field, ucfirst(str_replace('_', ' ', $field)), 'required');
                    }
                    elseif (array_key_exists($field, $data['dynamic_fields'])) {
                        // Add validation rule for text editor fields
                        $this->form_validation->set_rules($field.'[]', ucfirst(str_replace('_', ' ', $field)), 'required');
                    }
                    elseif (isset($data['file'][$field])) {
                        // Add validation rule for file fields
                        $this->form_validation->set_rules($field, ucfirst(str_replace('_', ' ', $field)), 'callback_file_check');
                    }
                    else {
                        // Add general validation rule
                        $this->form_validation->set_rules($field, ucfirst(str_replace('_', ' ', $field)), 'required');
                    }
                }
            }
        
            if ($this->form_validation->run() == FALSE) {
                $result = array('html' => '', 'message' => validation_errors(), 'status' => 'error');
            } else {
                // Automatically build the $formData array
                $formData = [];
                foreach ($fields as $field) {
                    if (!in_array($field, $data['hidden'])) {
                        if (isset($data['file'][$field])) {
                            // Handle file uploads
                            if (!empty($_FILES[$field]['name'])) {
                                $filetype = array('jpeg', 'jpg', 'png', 'pdf'); // Allowed file types
                                $uploadResult = (multiUpload($field, $data['file'][$field]['path'], $filetype, $data['file'][$field]['fieldType'], ''));
                            //    pr();
                                $formData[$field] = json_encode($uploadResult['file']);
                            } else {
                                // $formData[$field] = $data['file'][$field]['errorPath']; // Fallback to default
                            }
                        } else {
                            // For other fields, fetch post data
                            $formData[$field] = $this->input->post($field);
                        }
                    }
                }
                
                // Additional field transformations
                $formData['student_id'] = random_int(0, 9999);
                // $formData['end_year'] = date('Y', strtotime($this->input->post('end_date')));
                // prx($formData);
                // Add timestamps and handle insert/update
                if ($this->input->post('primary_key') == 0) {
                    $formData['created_at'] = date('Y-m-d H:i:s');
                    $action = $this->Generalmodel->getData($table, '', '', '', '', 'insert', $formData);
                } else {
                    $formData['updated_at'] = date('Y-m-d H:i:s');
                    $action = $this->Generalmodel->getData($table, $this->input->post('primary_key'), 'id', '', '', 'update', $formData);
                }
        
                if ($action) {
                    $result = array('html' => '', 'message' => 'Record saved successfully.', 'status' => 'success');
                } else {
                    $result = array('html' => '', 'message' => 'Something went wrong. Please try again.', 'status' => 'error');
                }
            }
        // prx($result);
            echo json_encode((object)$result);
        }
        
// File validation callback function
public function file_check($str) {
    $file = $_FILES[$str];
    if ($file['error'] != UPLOAD_ERR_OK) {
        $this->form_validation->set_message('file_check', 'Error uploading the file.');
        return FALSE;
    }

    // Check file size and type
    if ($file['size'] > 2048 * 1024) { // Max size 2MB
        $this->form_validation->set_message('file_check', 'File size exceeds the maximum limit.');
        return FALSE;
    }

    // $allowed_types = array('jpg', 'jpeg', 'png', 'pdf'); // Add other allowed types as needed
    // $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    // if (!in_array($ext, $allowed_types)) {
    //     $this->form_validation->set_message('file_check', 'Invalid file type.');
    //     return FALSE;
    // }

    return TRUE;
}
        
	function deleteImage(){
		$data = array(
			'image' => '',
		);
		$action = $this->Generalmodel->getData('session',post('id'), 'id', '', '', 'update', $data);
		if($action){
			$result = array('html' => '', 'message'=>'Record Delete Successfully.', 'status' => 'success');
		}else{
			$result = array('html' => '', 'message'=>'Something Went Wrong Please Try Again.', 'status' => 'error');
		}
		$obj = (object) array_merge((array) $result);
        echo json_encode($obj);
	}

    function getInvoice(){
        $student = $data['student'] = $this->Generalmodel->getDataWhere('students_details',['id' => post('id'), 'session_id'=>$this->session->userdata('session')]);
        $fees = $data['fees'] = $this->Generalmodel->getDataWhere('fees',['class' => $student[0]->class, 'session_year'=>$this->session->userdata('session')]);
        $data['class'] = $this->Generalmodel->getDataWhere('class',['id' => $student[0]->class]);
        $html = $this->load->view('student/admissionInvoice',$data, TRUE);
        if($html){
			$result = array('html' => $html, 'message'=>'Successfully.', 'status' => 'success');
		}else{
			$result = array( 'message'=>'Something Went Wrong Please Try Again.', 'status' => 'error');
		}
        $obj = (object) array_merge((array) $result);
        echo json_encode($obj);
    }
}
?>
