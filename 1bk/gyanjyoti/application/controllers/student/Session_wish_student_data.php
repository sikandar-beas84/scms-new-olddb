<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Session_wish_student_data extends CI_Controller {

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
            $head['title'] = $data['page_title'] =  'Session Wish Student Data';
 

        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
		$this->load->view('include/breadcrumb');
		$this->load->view('student/session_wish_student_data');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}

	
    public function list() {
        // Include Datatable model
        include_once('application/models/Datatable_model.php');

            // Define order and where conditions
            $order_by = array('session_wish_student_data.id' => 'desc');
            $where = array(
                'session_wish_student_data.is_delete' => 'N',
                'session_wish_student_data.session_id' => $this->session->userdata('session')
            );
        
            // Add additional conditions based on POST data
            if (post('class')) {
                $where['session_wish_student_data.class'] = post('class');
            }
        
            if (post('studentId')) {
                $where['students_details.student_code'] = post('studentId');
            }
        
            // if (post('application_status')) {
            //     $where['session_wish_student_data.application_status'] = post('application_status');
            // }
            $join = array(
                array(
                    'ontable'	=> 'session',
                    'onParams'	=> 'session.id = session_wish_student_data.session_id',
                    'type'		=> 'left'
                ),
                array(
                    'ontable'	=> 'class',
                    'onParams'	=> 'class.id = session_wish_student_data.class',
                    'type'		=> 'left'
                ),
                array(
                    'ontable'	=> 'section',
                    'onParams'	=> 'section.id = session_wish_student_data.section',
                    'type'		=> 'left'
                ),
                    array(
                    'ontable'	=> 'students_details',
                    'onParams'	=> 'students_details.id = session_wish_student_data.student',
                    'type'		=> 'left'
                ),
            );
                    // Initialize query attachments
                    $queryAttachments = array(
                        'select' => 'session_wish_student_data.*, section.section as section_name,class.class_name, students_details.student_code as student_code, students_details.student_name as student_name, students_details.dob as dob ',
                        'where' => $where,
                        'where_in' => array(),
                        'join' => $join,
                        'group_by' => ''
                    );
                
                    // Create Datatable model instance
                    $dttbl_model = new Datatable_model('session_wish_student_data', array(), array(), $order_by, $queryAttachments);
                    // prx($this->db->last_query());
        
  
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
          		$action = '<div class="_leads_action">'
		. '<a href="#"  data-id="'.$fieldData->id.'" class="btn btn-outline-info btn-xs viewProperty"  data-bs-toggle="modal" data-bs-target=".editPropertyModalXL"  onclick="action('.$fieldData->id.',1)"><i class="fa fa-eye" aria-hidden="true"></i></a>'
		. '<a href="#"  data-id="'.$fieldData->id.'" class="btn btn-outline-success btn-xs editProperty"  data-bs-toggle="modal" data-bs-target=".editPropertyModalXL"  onclick="action('.$fieldData->id.',2)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'
// 		. '<a href="javascript:" class="btn btn-outline-danger btn-xs" onclick="action('.$fieldData->id.',0)"><i class="fa fa-trash" aria-hidden="true"></i></a>'
		
		. '</div>';
    
            // Add processed data to the array
            $data[] = array(
                // $fieldData->student_id,
                $fieldData->student_code,
                $fieldData->student_name,
                $fieldData->class_name,
                $fieldData->section_name,

                $fieldData->dob,
                $fieldData->result_status ==  0? 'Fail' : 'Pass' ,
                
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
        public function action(){
            $data['table_name'] = $table_name = 'session_wish_student_data'; // Replace with your table name
            $fields = $this->Common_model->get_fields($table_name);
            $data['select'] = array(
                'result_status' => array(
                    '0' => 'Fail',
                    '1' => 'Pass',
                ),

            );
           
            
            $data['select']['class'] = $this->Common_model->relational_dropdown(
                'class',
                'id',
                'class_name',
                ['status' => 'Y', 'is_delete !='=> 'Y'],
                ' - '
            );
                
            // prx($data['select']);
            $data['textEditor'] = [];
            $data['fieldType'] = [
                
            ];
            $data['size'] = ['result_status'=>12];
            $data['dynamic_fields'] = [];
            $data['hidden'] = 
            [
            'id',
            'is_delete',
            'student',
            'is_delete',
            'created_at',
            'session_id',
            'updated_at',
            'class',
            'section',
            'roll',
            'student_code',
            'created_by',
            'updated_by',
            'status',
            // 'rating'
            ];
            $data['file'] = array(
                
            );
            $data['fields'] = $fields;
    
            if(post('action') == 0){ 
                $fromData = [
                    'is_delete'=>'Y',
                ];
                $res = $this->Generalmodel->getData('session_wish_student_data',post('id'),'id','','','update',$fromData);
                if($res):
                    $result = array('html' => '', 'message'=>'session_wish_student_data Delete Successfully.', 'status' => 'success');
                else:
                    $result = array('html' => '', 'message'=>'Something went to wrong.', 'status' => 'error');
                endif;
            }elseif(post('action') == 2){
                $data['data'] = $this->Generalmodel->getData('session_wish_student_data',post('id'),'id','','','get','');
                $data['action'] = post('action');
                
                $html = $this->load->view('CRUDFrom',$data, TRUE);
                $result = array('html' => $html, 'status' => 'success');
            }elseif(post('action') == 1){
                $data['data'] = $this->Generalmodel->getData('session_wish_student_data',post('id'),'id','','','get','');
                $data['action'] = post('action');
                $html = $this->load->view('CRUDFrom',$data, TRUE);
                $result = array('html' => $html, 'status' => 'success');
            }
            
            else{
                $data['action'] = post('action');
        
                
                $html = $this->load->view('CRUDFrom',$data, TRUE);
                $result = array('html' => $html, 'status' => 'success');
            }
            $obj = (object) array_merge((array) $result);
            // $obj = (object) array_merge((array) $result,update_csrf_session_wish_student_data());
            echo json_encode($obj);
        }
      
         function save() {
            $table = 'session_wish_student_data'; // Specify your table name here
        
            $data['select'] = array(
                'result_status' => array(
                    '0' => 'Fail',
                    '1' => 'Pass',
                ),

            );
           
            
            $data['select']['class'] = $this->Common_model->relational_dropdown(
                'class',
                'id',
                'class_name',
                ['status' => 'Y', 'is_delete !='=> 'Y'],
                ' - '
            );
                
            // prx($data['select']);
            $data['textEditor'] = [];
            $data['fieldType'] = [
                
            ];
            $data['size'] = ['result_status'=>12];
            $data['dynamic_fields'] = [];
            $data['hidden'] = 
            [
            'id',
            'is_delete',
            'student',
            'is_delete',
            'created_at',
            'session_id',
            'updated_at',
            'class',
            'section',
            'roll',
            'student_code',
            'created_by',
            'updated_by',
            'status',
            // 'rating'
            ];
            $data['file'] = array(
                
            );
        
            // Fetch table fields
            $fields = $this->Common_model->get_fields($table);
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
                            //    prx($uploadResult);
                                $formData[$field] = json_encode($uploadResult['file']);
                            } else {
                                // $formData[$field] = $data['file'][$field]['errorPath']; // Fallback to default
                            }
                        }elseif (array_key_exists($field, $data['dynamic_fields'])) {
                            
                            $formData[$field] = json_encode($this->input->post($field));
                        }  
                        else {
                            // if(array_key_exists($field, $data['fieldType'])) {
                            //     if($data['fieldType'][$field] == 'password'){
                            //         $formData[$field] = md5($this->input->post($field));
                            //     }
                            // }else{
                            // For other fields, fetch post data
                                $formData[$field] = $this->input->post($field);
                            // }
                        }
                    }
                }
                
                // Additional field transformations
                // if(empty($this->input->post('primary_key')) || $this->input->post('primary_key') == 0){
                // $formData['student_id'] =  'GPS/'.date("Y").'/'.generate_id('students_details');
                // }
                // $formData['end_year'] = date('Y', strtotime($this->input->post('end_date')));
                // prx($formData);
                // Add timestamps and handle insert/update
                if ($this->input->post('primary_key') == 0) {
                    $action = $this->Generalmodel->getData($table, '', '', '', '', 'insert', $formData);
                    $message = 'Saved Successfully';
                } else {
                    $action = $this->Generalmodel->getData($table, $this->input->post('primary_key'), 'id', '', '', 'update', $formData);
                    $message = 'Updated Successfully';
                }
                
                if ($action) {
                    $result = array('html' => '', 'message' => $message, 'status' => 'success');
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
        $student = $data['student'] = $this->Generalmodel->getDataWhere('session_wish_student_data',['id' => post('id'), 'session_id'=>$this->session->userdata('session')]);
        $session_wish_student_data = $data['session_wish_student_data'] = $this->Generalmodel->getDataWhere('session_wish_student_data',['class' => $student[0]->class, 'session_year'=>$this->session->userdata('session')]);
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
