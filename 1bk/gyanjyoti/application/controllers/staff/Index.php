<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

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
        
	
        $head['title'] = $data['page_title'] = 'staff';

        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('staff/index');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}


	
	public function list(){
		# include datatable model
        include_once('application/models/Datatable_model.php');
        # customize filter
        $order_by = array('staff.id ' => 'desc');
        $where_in = array();
		$where = array('staff.is_delete' => 'N');

        $join = array(
            
        );
 
        $queryAttachments = array(
            'select' => 'staff.*',
            'where' => $where,
            'where_in' => $where_in,
            'join' => $join,
            'group_by' => ''
        );

        $dttbl_model = new Datatable_model('staff', array(), array(), $order_by, $queryAttachments);
        
		$testdata = $dttbl_model->getRows($_POST);
        $data = array();
		$image = '';
        foreach ($testdata as $key => $fieldData) {
		// prx($fieldData->gallery);
			if($fieldData->image){
				$image = jd($fieldData->image)[0];
			}else{
				$image = 'noImageProfile.png';
			}
			
						
			$image = '<div class="d-flex align-items-center">
                  <img
                      src="' . base_url() . 'assets/uploads/staff/'.$image.'"
                      alt=""
                      style="width: 45px; height: 45px"
                      class="rounded"
                      />
                </div>';

			if($fieldData->status == "Active"){$statusClass = "success";}else{$statusClass = "warning ";}


			$status = '<td>'
           . '<span class="badge badge-'.$statusClass.' rounded-pill d-inline">'.$fieldData->status .'</span>';

		$action = '<div class="_leads_action">'
		. '<a href="#"  data-id="'.$fieldData->id.'" class="btn btn-outline-info btn-xs viewProperty"  data-bs-toggle="modal" data-bs-target=".editPropertyModalXL"  onclick="action('.$fieldData->id.',1)"><i class="fa fa-eye" aria-hidden="true"></i></a>'
		. '<a href="#"  data-id="'.$fieldData->id.'" class="btn btn-outline-success btn-xs editProperty"  data-bs-toggle="modal" data-bs-target=".editPropertyModalXL"  onclick="action('.$fieldData->id.',2)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'
		// . '<a href="javascript:" class="btn btn-outline-danger btn-xs" onclick="action('.$fieldData->id.',0)"><i class="fa fa-trash" aria-hidden="true"></i></a>'
		
		. '</div>';


            $data[] = array(
                $key + 1,
                $fieldData->first_name . '  ' . $fieldData->last_name,
                $image,
                $fieldData->email ,
                $fieldData->phone,
                $fieldData->date_of_birth,
                $fieldData->gender,
				$status,
				$action
				
            );
			// prx($data);
        }


        if (isset($_POST['draw']) && $_POST['draw']) {
            $draw = $_POST['draw'];
        } else {
            $draw = '';
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $dttbl_model->countAll(),
            "recordsFiltered" => $dttbl_model->countFiltered($_POST),
            "data" => $data,
            "status" => 'success',
			// "csrf" => update_csrf_staff()
        );

        # response
        echo json_encode($output);
        unset($dttbl_model);
	}


	// For Delete, Update and View From DataTable
		// For Delete, Update and View From DataTable
        public function action(){
            $data['table_name'] = $table_name = 'staff'; // Replace with your table name
            $fields = $this->Common_model->get_fields($table_name);
            $data['select'] = array(
                'status' => array(
                    'Y' => 'Active',
                    'N' => 'Inactive',
                ),
                'role_type' => array(
                    'admin' => 'Admin',
                    'staff' => 'Teachers',
                ),
                'gender' => array('Male' => 'Male', 'Female' => 'Female'),

            );
               
                
            // prx($data['select']);
            $data['textEditor'] = [];
            $data['fieldType'] = [
                'password' => 'password',
                'email_id' => 'email', 
                'phone' => 'tel',
            ];
            $data['size'] = ['image' => '12', 'address' => 12, 'appointed_subject'=> 12];
            $data['dynamic_fields'] = [];
            $data['hidden'] = 
            [
            'id',
            'is_delete',
            'created_at',
            'updated_at',
            'password',
            'created_by',
            'updated_by',
            'status',
            // 'rating'
            ];
            $data['file'] = array(
                'image' => array(
                    'fieldType' => 'sigle',
                    'accept' => '',
                    'path' => base_url().'assets/uploads/staff/',
                    'errorPath' => base_url().'assets/noImageProfile.png'
                ),
            );
            $data['fields'] = $fields;
    
            if(post('action') == 0){ 
                $fromData = [
                    'is_delete'=>'Y',
                    'status'=>'Inactive'
                ];
                $res = $this->Generalmodel->getData('staff',post('id'),'id','','','update',$fromData);
                if($res):
                    $result = array('html' => '', 'message'=>'staff Add successfully.', 'status' => 'success');
                else:
                    $result = array('html' => '', 'message'=>'Something went to wrong.', 'status' => 'error');
                endif;
            }elseif(post('action') == 2){
                $data['data'] = $this->Generalmodel->getData('staff',post('id'),'id','','','get','');
                $data['action'] = post('action');
                
                $html = $this->load->view('CRUDFrom',$data, TRUE);
                $result = array('html' => $html, 'status' => 'success');
            }elseif(post('action') == 1){
                $data['data'] = $this->Generalmodel->getData('staff',post('id'),'id','','','get','');
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
            // $obj = (object) array_merge((array) $result,update_csrf_staff());
            echo json_encode($obj);
        }

        function save() {
            $table = 'staff'; // Specify your table name here
        
            // $fields = $this->Common_model->get_fields($table_name);
            $data['select'] = array(
                'status' => array(
                    'Y' => 'Active',
                    'N' => 'Inactive',
                ),
                'gender' => array('Male' => 'Male', 'Female' => 'Female'),

                
            );
               
                
            // prx($data['select']);
            $data['textEditor'] = [];
            $data['fieldType'] = [
                'password' => 'password',
                'email_id' => 'email', 
                'phone' => 'tel',
            ];
            $data['size'] = ['image' => '12'];
            $data['dynamic_fields'] = [];
            $data['hidden'] = 
            [
            'id',
            'is_delete',
            'created_at',
            'updated_at',
            'password',
            'created_by',
            'updated_by',
            'status',
            // 'rating'
            ];
            $data['file'] = array(
                'image' => array(
                    'fieldType' => 'sigle',
                    'accept' => '',
                    'path' => 'assets/uploads/staff/',
                    'errorPath' => base_url().'assets/noImageProfile.png'
                ),
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
                // $formData['admission_date'] = date("d-m-y");
                // $formData['end_year'] = date('Y', strtotime($this->input->post('end_date')));
                // prx($formData);
                // Add timestamps and handle insert/update
                if ($this->input->post('primary_key') == 0) {
                    $formData['created_at'] = date('Y-m-d H:i:s');
                    $formData['password'] = md5(12345);
                    $action = $this->Generalmodel->getData($table, '', '', '', '', 'insert', $formData);
                    $message = 'Saved Successfully';
                } else {
                    $formData['updated_at'] = date('Y-m-d H:i:s');
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
		$action = $this->Generalmodel->getData('staff',post('id'), 'id', '', '', 'update', $data);
		if($action){
			$result = array('html' => '', 'message'=>'Record Delete Successfully.', 'status' => 'success');
		}else{
			$result = array('html' => '', 'message'=>'Something Went Wrong Please Try Again.', 'status' => 'error');
		}
		$obj = (object) array_merge((array) $result);
        echo json_encode($obj);
	}
}
?>
