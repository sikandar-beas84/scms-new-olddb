<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Admission extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
		date_default_timezone_set('Asia/Kolkata');
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }

	}

	public function index(){
        
        // prx($_GET);
        $head['title'] = $data['page_title'] =' Admission';
        $data['table_name'] = $table_name = 'students_details'; // Replace with your table name
        $fields = $this->db->list_fields($table_name);
        $data['select'] = array(
            'status' => array(
                'Y' => 'Active',
                'N' => 'Inactive',
            ),
            'gender' => array(
                'Male' => 'Male',
                'Female' => 'Female',
            ),
            'only_child' => array(
                'Yes' => 'Yes',
                'No' => 'No',
            ),
            'bpl' => array(
                'Yes' => 'Yes',
                'No' => 'No',
            ),
            'academic_status_assigned' => array(
                'Pass' => 'Pass',
                'Fail' => 'Fail',
            ),
            'academic_status' => array('Active' => 'Active', 'Inactive' => 'Inactive'),
            'tc_require' => array('Yes' => 'Yes', 'No' => 'No'),
            'migration_require' => array('Yes' => 'Yes', 'No' => 'No'),
            
        );

        $data['dynamic_fields'] = [
            'student_subject_option' => array(
                'max_limit' => 6,
                'min_limit' => 1,
                'field' => array(
                    'student_subject_option' => 'text',
                    // This Is Field Group
                ),
            )
        ];
        $data['textEditor'] = ['present_address', 'permanent_address'];
        $data['unsetTextEditor'] = ['present_address'=>'2', 'permanent_address'=>'2'];
        $data['section'] = [
            'student_code'=>'Student Details: ', 
            'father_name'=>'Parents Details: <br><span class="subHeding">Fathers Details: </span>', 
            'mother_name'=> '<span class="subHeding">Mother Details: </span>',
            'local_guardian_name'=> '<input class="form-check-input showHidecheckbox" onchange="showHideGuardian()" type="checkbox" value="" id="flexCheckDefault">   <span class="subHeding">Local Guardian Details (If Available) : </span>',
            'student_subject_option'=> '',
            'father_photo'=>'Attachment: <br><span class="subHeding"> </span>', 
        ];
        $data['fieldType'] = [
            'student_name' => 'text',
            'bank_account_no' => 'int', 
            'student_aadhar' => 'int',
            'father_aadhar_no' => 'int',
            'email_id' => 'email', 
            'father_mobile_no' => 'tel',
            'father_whatsapp_no'=> 'tel',
            'father_aadhar_no'=>'int',
            'father_name'=>'text',
            'father_occupation'=>'text',
            'father_annual_income'=>'number',
            'mother_name'=>'text',
            'mother_mobile_no'=>'tel',
            'mother_whatsapp_no'=>'tel',
            'mother_aadhar_no'=>'int',
            'mother_occupation'=>'text',
            'mother_annual_income'=>'number',
            'local_guardian_name'=>'text',
            'local_guardian_mobile_no'=>'tel',
            'local_guardian_whatsapp_no'=>'tel',
            'local_guardian_aadhar_no'=>'int',
            'local_guardian_occupation'=>'text',
            'local_guardian_annual_income'=>'number',
        ];

        $data['size'] = [
          'pen' => 4,
          'gender' => 4, 
          'dob' => 4, 
          'class'=> 3,
          'section'=>3, 
          'religion'=> 6, 
          'category'=> 4, 
          'email_id'=> 4,
          'blood_group'=> 4,
          'only_child'=> 4,
          'medical_condition'=> 8,
          'attachments'=> 6,
          'student_code'=> 12,
        ];
        $data['select']['class'] = $this->Common_model->relational_dropdown(
            'class',
            'id',
            'class_name',
            ['status' => 'Y', 'is_delete !='=> 'Y'],
            ' - '
        );
        $data['select']['section'] = $this->Common_model->relational_dropdown(
            'section',
            'id',
            'section',
            ['status' => 'Y', 'is_delete !='=> 'Y'],
            ' - '
        );
        $data['hidden'] = 
        [
            'id',
            'is_delete',
            'student_id',
            'session_id',
            'student_table_id',
            'admission_form_no',
            'application_status',
            'roll',
            'admission_no',
            'admission_date',
            'created_at',
            'updated_at',
            'status',
            'application_action_at', 
            'application_action_by', 
            'reject_notes'
        ];
        $data['file'] = array(
            'student_photo' => array(
                'fieldType' => 'sigle',
                'accept' => '',
                'path' => base_url().'assets/uploads/student/',
                'errorPath' => base_url().'assets/noImageProfile.png'
            ),
            'father_photo' => array(
                'fieldType' => 'sigle',
                'accept' => '',
                'path' => base_url().'assets/uploads/student/father_photo/',
                'errorPath' => base_url().'assets/noImage.jpg'
            ),
            'mother_photo' => array(
                'fieldType' => 'sigle',
                'accept' => '',
                'path' => base_url().'assets/uploads/student/mother_photo/',
                'errorPath' => base_url().'assets/noImage.jpg'
            ),
            'local_guardian_photo' => array(
                'fieldType' => 'sigle',
                'accept' => '',
                'path' => base_url().'assets/uploads/student/local_guardian_photo/',
                'errorPath' => base_url().'assets/noImage.jpg'
            ),
            'attachments' => array(
                'fieldType' => 'multi',
                'accept' => '',
                'path' => base_url().'assets/uploads/student/attachments/',
                'errorPath' => base_url().'assets/noImage.jpg'
            ),
        );
        $data['fields'] = $fields;

        $data['action'] = get('action') ?? 3;
        if(get('id')){
        $data['data'] = $this->Generalmodel->getData('students_details',get('id'),'student_id','','','get','');
        }
        $data['admissionFromCharge'] = 500;
        // prx( $data['data']);
        $html = $this->load->view('student/admissionFrom',$data, TRUE);
        $data['html'] = $html;

        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('student/admission');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}


	
    public function list() {
        // Include Datatable model
        include_once('application/models/Datatable_model.php');
    
        // Define order and where conditions
        $order_by = array('students_details.id' => 'desc');
        $where = array('students_details.is_delete' => 'N');
        if(post('class')){
            $where = array('students_details.class' => post('class'));
        }
    
        if(post('studentId')){
            $where = array('students_details.student_id' => post('studentId'));
        }
        $where = array('students_details.session_id' => $this->session->userdata('session'));
        $where = array('students_details.application_status' => post('application_status'));
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
                    . '<a href="'.base_url().'student/admission?id='.$fieldData->student_id.'&action=2" data-id="' . $fieldData->student_id . '" class="btn btn-outline-success btn-xs editProperty" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'
                    // . '<a href="javascript:" class="btn btn-outline-danger btn-xs" onclick="action(' . $fieldData->student_id . ',0)"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                    . '</div>';
    
            // Add processed data to the array
            $data[] = array(
                $fieldData->student_id,
                // $fieldData->admission_form_no,
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
                $fieldData->fathers_name . '<br>' . $fieldData->fathers_mobile_no ,
                $fieldData->mothers_name . '<br>' . $fieldData->mothers_mobile_no ,
                $fieldData->local_guardian_name . '<br>' . $fieldData->local_guardian_mobile_no ,
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
            $data['table_name'] = $table_name = 'students_details'; // Replace with your table name
            $fields = $this->db->list_fields($table_name);
            $data['select'] = array(
                'status' => array(
                    'Y' => 'Active',
                    'N' => 'Inactive',
                ),
                
            );

            $data['textEditor'] = ['description'];
            $data['fieldType'] = [];
            $data['size'] = [];
            
            $data['hidden'] = 
            [
            'id',
            'is_delete',
            'start_year',
            'end_year',
            'session_year',
            'application_status',
            'created_at',
            'updated_at',
            'status',
            // 'rating'
            ];
            $data['file'] = array(
                // 'image' => array(
                //     'fieldType' => 'sigle',
                //     'accept' => '',
                //     'path' => base_url().'assets/uploads/session/',
                //     'errorPath' => base_url().'assets/uploads/noimage.png'
                // ),
            );
            $data['fields'] = $fields;
    
            if(post('action') == 0){ 
                $fromData = [
                    'is_delete'=>'Y',
                    'status'=>'Inactive'
                ];
                $res = $this->Generalmodel->getData('session',post('id'),'id','','','update',$fromData);
                if($res):
                    $result = array('html' => '', 'message'=>'Session Add successfully.', 'status' => 'success');
                else:
                    $result = array('html' => $this->db->last_query(), 'message'=>'Something went to wrong.', 'status' => 'error');
                endif;
            }elseif(post('action') == 2){
                $data['data'] = $this->Generalmodel->getData('session',post('id'),'id','','','get','');
                $data['action'] = post('action');
                
                $html = $this->load->view('CRUDFrom',$data, TRUE);
                $result = array('html' => $html, 'status' => 'success');
            }elseif(post('action') == 1){
                $data['data'] = $this->Generalmodel->getData('session',post('id'),'id','','','get','');
                $data['action'] = post('action');
                $html = $this->load->view('CRUDFrom',$data, TRUE);
                $result = array('html' => $html, 'status' => 'success');
            }
            
            else{
                $data['action'] = post('action');
        
                
                $html = $this->load->view('CRUDFrom',$data, TRUE);
                $result = array('html' => $html, 'status' => 'success');
            }
            $obj = (object) array_merge((array) $result,update_csrf_session());
            echo json_encode($obj);
        }

        function save() {
            $table = 'students_details'; // Specify your table name here
        
            // Define field configurations
            $data['select'] = array(
                'status' => array('Y' => 'Active', 'N' => 'Inactive'),
                'academic_status' => array('Active' => 'Active', 'Inactive' => 'Inactive'),
                'gender' => array('Male' => 'Male', 'Female' => 'Female'),
                'only_child' => array('Yes' => 'Yes', 'No' => 'No'),
                'bpl' => array('Yes' => 'Yes', 'No' => 'No'),
                'academic_status_assigned' => array('Pass' => 'Pass', 'Fail' => 'Fail'),
                'tc_require' => array('Yes' => 'Yes', 'No' => 'No'),
                'migration_require' => array('Yes' => 'Yes', 'No' => 'No'),
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
                'id', 'is_delete', 'session_id', 'student_id', 'student_table_id', 'admission_form_no', 'roll', 
                'admission_no', 'admission_date', 'created_at', 'updated_at', 'status','application_status','session_id','application_action_at', 'application_action_by', 'reject_notes'
            ];
        
            $data['file'] = array(
                'student_photo' => array(
                    'fieldType' => 'single',
                    'accept' => 'image/*',
                    'path' => 'assets/uploads/student/',
                    'errorPath' => base_url() . 'assets/noImageProfile.png'
                ),
                'father_photo' => array(
                    'fieldType' => 'single',
                    'accept' => 'image/*',
                    'path' =>'assets/uploads/student/father_photo/',
                    'errorPath' => base_url() . 'assets/noImage.jpg'
                ),
                'mother_photo' => array(
                    'fieldType' => 'single',
                    'accept' => 'image/*',
                    'path' => 'assets/uploads/student/mother_photo/',
                    'errorPath' => base_url() . 'assets/noImage.jpg'
                ),
                'local_guardian_photo' => array(
                    'fieldType' => 'single',
                    'accept' => 'image/*',
                    'path' => 'assets/uploads/student/local_guardian_photo/',
                    'errorPath' => 'assets/noImage.jpg'
                ),
                'attachments' => array(
                    'fieldType' => 'multi',
                    'accept' => 'image/*,application/pdf',
                    'path' =>'assets/uploads/student/attachments/',
                    'errorPath' => base_url() . 'assets/noImage.jpg'
                ),
            );
        
            $optionalField = [
                'student_photo',
                'father_photo',
                'mother_photo',
                'local_guardian_photo',
                'attachments[]',
                'status',
                'only_child',
                'bpl',
                'academic_status_assigned',
                'student_code',
                'tc_require',
                'migration_require',
                'student_subject_option',
                'present_address',
                // 'permanent_address',
                'bank_account_no',
                'student_aadhar',
                'father_aadhar_no',
                'email_id',
                'father_mobile_no',
                'father_whatsapp_no',
                // 'father_name',
                'father_occupation',
                'father_annual_income',
                // 'mother_name',
                'mother_mobile_no',
                'mother_whatsapp_no',
                'mother_aadhar_no',
                'mother_occupation',
                'mother_annual_income',
                'local_guardian_name',
                'local_guardian_mobile_no',
                'local_guardian_whatsapp_no',
                'local_guardian_aadhar_no',
                'local_guardian_occupation',
                'local_guardian_annual_income',
                'pen',
                'local_guardian_mobile_no',
                'local_guardian_mobile_no',
                'section',
                'religion',
                'category',
                'blood_group',
                'medical_condition',
                // 'student_name',
                'banglar_siksha_id',
                'pen',
                'section',
                'ifsc',
                'mother_language',
                'second_language',
                'third_language',
                'house',
                'nationality',
                'bpl',
                'bpl_no',
                'tc_require',
                'tc_submitted_date',
                'migration_require',
                'migration_submitted_date',
                'student_subject_option[]',
                'security_money',
                'security_money_return_details',
                

            ];
            // Fetch table fields
            $fields = $this->db->list_fields($table);
            // prx($fields);
            // Validate fields
            foreach ($fields as $field) {
                if (!in_array($field, $data['hidden'])) { // Skip hidden fields
                    if(!in_array($field, $optionalField)){
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
                        }elseif (array_key_exists($field, $data['dynamic_fields'])) {
                            
                            $formData[$field] = json_encode($this->input->post($field));
                        }  
                        else {
                            if(array_key_exists($field, $data['fieldType'])) {
                                if($data['fieldType'][$field] == 'password'){
                                    $formData[$field] = md5($this->input->post($field));
                                }else{

                                    $formData[$field] = $this->input->post($field);
                                }
                            }else{
                            // For other fields, fetch post data
                                $formData[$field] = $this->input->post($field);
                            }
                        }
                    }
                }
                
                // Additional field transformations
                if(empty($this->input->post('primary_key')) || $this->input->post('primary_key') == 0){
                    $formData['admission_form_no'] =  $formData['student_id'] =  'GPS/'.date("Y").'/'.generate_id('students_details');
                }
                $formData['admission_date'] = date("d-m-y");
                $formData['session_id'] = $this->session->userdata('session');
                // $formData['end_year'] = date('Y', strtotime($this->input->post('end_date')));
                // prx($_POST);
                // Add timestamps and handle insert/update
                if ($this->input->post('primary_key') == 0) {
                    $formData['created_at'] = date('Y-m-d H:i:s');
                    $action = $this->Generalmodel->getData($table, '', '', '', '', 'insert', $formData);
                    $last_insert_id = $this->db->insert_id();
                    $dataPayment = array(
                            'session_year' => $this->session->userdata('session'),
                            'student_id'=> $last_insert_id,
                            'utr'=> post('utr_number'),
                            'amount'=> 500,
                            'payment_type'=> post('payment_type'),
                            'payment_status'=> 'Y',
                            'payment_date'=> date('Y-m-d H:i:s'),
                            'transaction_id' => uniqid('GPS_', true),
                            'class' => post('class'),
                            'collected_by' => $this->session->userdata('user_id'),
                            
                        );
                    $action = $this->Generalmodel->getData('admission_from_payment_data', '', '', '', '', 'insert', $dataPayment);
                    $message = 'Saved Successfully';
                } else {
                    $formData['updated_at'] = date('Y-m-d H:i:s');
                    $action = $this->Generalmodel->getData($table, $this->input->post('primary_key'), 'id', '', '', 'update', $formData);
                    $message = 'Updated Successfully';
                }
                
                if ($action) {
                    $result = array('html' => '', 'message' => $message, 'status' => 'success', 'data'=> $formData['student_id']);
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
        
public function deleteImage() {
    $field = $this->input->post('field');
    $id = $this->input->post('id');
    $index = $this->input->post('index');
    $action = $this->input->post('action');

    if ($action == 'multy') {
        // Fetch the current data from the database
        $this->db->where('id', $id);
        $result = $this->db->get('students_details')->row();

        if ($result) {
            // Decode the multi-image field
            $images = json_decode($result->$field, true);
            if (isset($images[$index])) {
                // Remove the image from the array
                unset($images[$index]);
                // Reindex array and update the field in the database
                $images = array_values($images);

                $this->db->where('id', $id);
                if(empty($images)){
                    $this->db->update('students_details', [$field => NULL]);
                }else{
                    $this->db->update('students_details', [$field => json_encode($images)]);

                }

                // // Optionally, delete the physical file
                // $filePath = 'assets/uploads/student/attachments/' . $images[$index];
                // if (file_exists($filePath)) {
                //     unlink($filePath);
                // }

                $response = ['status' => 'success', 'message' => 'Image deleted successfully'];
            } else {
                $response = ['status' => 'error', 'message' => 'Image not found'];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Record not found'];
        }
    } else {
        // Handle single image deletion
        $this->db->where('id', $id);
        $result = $this->db->get('students_details')->row();
        
        if ($result) {
            // Get the file path from the field
            // $filePath = 'assets/uploads/student/' . $result->$field;
            
            // Delete the file from the database
            $this->db->where('id', $id);
            if(empty($images)){
                $this->db->update('students_details', [$field => NULL]);
            }else{
                $this->db->update('students_details', [$field => json_encode($images)]);

            }

            // Optionally, delete the physical file
            // if (file_exists($filePath)) {
            //     unlink($filePath);
            // }

            $response = ['status' => 'success', 'message' => 'Image deleted successfully'];
        } else {
            $response = ['status' => 'error', 'message' => 'Record not found'];
        }
    }

    echo json_encode($response);
}
	public function invoice(){
	    $studentId = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('students_details');
        $this->db->join('admission_from_payment_data', 'students_details.id = admission_from_payment_data.student_id');
        $this->db->where('students_details.admission_form_no', $studentId);
        $query = $this->db->get();
    
        $data['fromInvoice'] = $query->result_array();
        // prx($data['fromInvoice'][0]);
        $head['title'] = $data['page_title'] =  'Form Invoice';
        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
		$this->load->view('include/breadcrumb');
		$this->load->view('student/frominvoice', $data);
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}
}
?>
