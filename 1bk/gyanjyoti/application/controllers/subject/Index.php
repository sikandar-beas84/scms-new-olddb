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
        
	
        $head['title'] = $data['page_title'] = 'subject';

        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('subject/index');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}


	
	public function list(){
		# include datatable model
        include_once('application/models/Datatable_model.php');
        # customize filter
        $order_by = array('subject.id ' => 'desc');
        $where_in = array();
		$where = array('subject.is_delete' => 'N');

        $join = array(
            array(
				'ontable'	=> 'session',
				'onParams'	=> 'session.id = subject.session_year',
				'type'		=> 'left'
			),
            array(
				'ontable'	=> 'class',
				'onParams'	=> 'class.id = subject.class',
				'type'		=> 'left'
			),
            array(
				'ontable'	=> 'staff',
				'onParams'	=> 'staff.id = subject.teacher',
				'type'		=> 'left'
			),
        );
 
        $queryAttachments = array(
            'select' => 'subject.*,session.start_year, session.end_year, class.class_name, staff.first_name, staff.last_name',
            'where' => $where,
            'where_in' => $where_in,
            'join' => $join,
            'group_by' => ''
        );

        $dttbl_model = new Datatable_model('subject', array(), array(), $order_by, $queryAttachments);
        
		$testdata = $dttbl_model->getRows($_POST);
        $data = array();
		$image = '';
        foreach ($testdata as $key => $fieldData) {

			

			if($fieldData->status == "Y"){$statusClass = "success";}else{$statusClass = "warning ";}
			
			
			$status = '<td>'
           . '<span class="badge badge-'.$statusClass.' rounded-pill d-inline">'.$fieldData->status .'</span>';

           
		$action = '<div class="_leads_action">'
		. '<a href="#"  data-id="'.$fieldData->id.'" class="btn btn-outline-info btn-xs viewProperty"  data-bs-toggle="modal" data-bs-target=".editPropertyModalXL"  onclick="action('.$fieldData->id.',1)"><i class="fa fa-eye" aria-hidden="true"></i></a>'
		. '<a href="#"  data-id="'.$fieldData->id.'" class="btn btn-outline-success btn-xs editProperty"  data-bs-toggle="modal" data-bs-target=".editPropertyModalXL"  onclick="action('.$fieldData->id.',2)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'
		. '<a href="javascript:" class="btn btn-outline-danger btn-xs" onclick="action('.$fieldData->id.',0)"><i class="fa fa-trash" aria-hidden="true"></i></a>'
		
		. '</div>';


            $data[] = array(
                $key + 1,
                $fieldData->start_year . ' - ' . $fieldData->end_year,
                $fieldData->class_name,
                $fieldData->subject,
                $fieldData->first_name . ' '. $fieldData->last_name,
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
        );

        # response
        echo json_encode($output);
        unset($dttbl_model);
	}


        public function action(){
            $data['table_name'] = $table_name = 'subject'; // Replace with your table name
            $fields = $this->Common_model->get_fields($table_name);
            $data['select'] = array(
                'status' => array(
                    'Y' => 'Active',
                    'N' => 'Inactive',
                ),
                
            );
                $data['select']['session_year'] = $this->Common_model->relational_dropdown(
                    'session',
                    'id',
                    'start_year, end_year',
                    ['status' => 'Y', 'is_delete !='=> 'Y'],
                    ' - '
                );
                
                $data['select']['class'] = $this->Common_model->relational_dropdown(
                    'class',
                    'id',
                    'class_name',
                    ['status' => 'Y', 'is_delete !='=> 'Y'],
                    ' - '
                );
                $data['select']['teacher'] = $this->Common_model->relational_dropdown(
                    'staff',
                    'id',
                    'first_name, last_name',
                    ['role_type' => 'staff', 'status' => 'Y', 'is_delete !='=> 'Y'],
                    '  '
                );
                
            // prx($data['select']);
            $data['textEditor'] = [];
            $data['fieldType'] = [];
            $data['size'] = ['subject' => '6'];
            
            $data['hidden'] = 
            [
            'id',
            'is_delete',
            
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'status',
            ];
            $data['file'] = array(
            
            );
            $data['fields'] = $fields;
    
            if(post('action') == 0){ 
                $fromData = [
                    'is_delete'=>'Y',
                    'status'=>'N'
                ];
                $res = $this->Generalmodel->getData('subject',post('id'),'id','','','update',$fromData);
                if($res):
                    $result = array('html' => '', 'message'=>'Subject Delete Successfully.', 'status' => 'success');
                else:
                    $result = array('html' => '', 'message'=>'Something went to wrong.', 'status' => 'error');
                endif;
            }elseif(post('action') == 2){
                $data['data'] = $this->Generalmodel->getData('subject',post('id'),'id','','','get','');
                $data['action'] = post('action');
                
                $html = $this->load->view('CRUDFrom',$data, TRUE);
                $result = array('html' => $html, 'status' => 'success');
            }elseif(post('action') == 1){
                $data['data'] = $this->Generalmodel->getData('subject',post('id'),'id','','','get','');
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
            echo json_encode($obj);
        }

        function save() {
            $table = 'subject'; 
        
            // Field configurations
            $data['select'] = array(
                'status' => array(
                    'Y' => 'Active',
                    'N' => 'Inactive',
                ),
                
            );
            $data['textEditor'] = ['description'];
            $data['fieldType'] = [];
            $data['hidden'] = [
                'id',
                'is_delete',
           
                'created_at',
                'created_by',
                'updated_at',
                'updated_by',
                'status',
            ];
            $data['file'] = array(
                
            );
        
            // Fetch table fields
            $fields = $this->Common_model->get_fields($table);
        
            // Validate fields
            foreach ($fields as $field) {
                if (!in_array($field, $data['hidden'])) { // Skip hidden fields
                    if (isset($data['select'][$field])) {
                        // Add validation rule for select fields
                        $this->form_validation->set_rules($field, ucfirst(str_replace('_', ' ', $field)), 'required|in_list[' . implode(',', array_keys($data['select'][$field])) . ']');
                    } elseif (in_array($field, $data['textEditor'])) {
                        // Add validation rule for text editor fields
                        $this->form_validation->set_rules($field, ucfirst(str_replace('_', ' ', $field)), 'required');
                    } else {
                        // Add general validation rule
                        $this->form_validation->set_rules($field, ucfirst(str_replace('_', ' ', $field)), 'required');
                    }
                }
            }
        
            if ($this->form_validation->run() == FALSE) {
                $result = array('html' => '', 'message' => validation_errors(), 'status' => 'error');
            } else {
                // Automatically build the $data array
                $formData = [];
                foreach ($fields as $field) {
                    if (!in_array($field, $data['hidden'])) {
                        if (isset($data['file'][$field])) {
                           
                        } else {
                            // For other fields, fetch post data
                            $formData[$field] = post($field);
                        }
                    }
                }
              
                // Add created_at or updated_at fields
                if (post('primary_key') == 0) {
                    $formData['created_by'] = $this->session->userdata('user_id');
                    $formData['created_at'] = date('Y-m-d H:i:s');
                    $action = $this->Generalmodel->getData($table, '', '', '', '', 'insert', $formData);
                    
                } else {
                    $formData['updated_by'] = $this->session->userdata('user_id');
                    $formData['updated_at'] = date('Y-m-d H:i:s');
                    $action = $this->Generalmodel->getData($table, post('primary_key'), 'id', '', '', 'update', $formData);
                }
        
                if ($action) {
                    $result = array('html' => '', 'message' => 'Record saved successfully.', 'status' => 'success');
                } else {
                    $result = array('html' => '', 'message' => 'Something Went Wrong Please Try Again.', 'status' => 'error');
                }
            }
        
            echo json_encode((object)$result);
        }
        
	
}
?>
