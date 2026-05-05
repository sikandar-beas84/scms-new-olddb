<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday extends CI_Controller {

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
        
	
        $head['title'] = $data['page_title'] = 'Holiday';

        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('holiday/index');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}


	
	public function list(){
		# include datatable model
        include_once('application/models/Datatable_model.php');
        # customize filter
        $order_by = array('holiday_master.id ' => 'desc');
        $where_in = array();
		$where = array('holiday_master.is_delete' => 'N', 'holiday_master.session_year_id' =>get_session('session'));

        $join = array(
            array(
				'ontable'	=> 'session',
				'onParams'	=> 'session.id = holiday_master.session_year_id',
				'type'		=> 'left'
			),

        );
 
        $queryAttachments = array(
            'select' => 'holiday_master.*,session.start_year, session.end_year',
            'where' => $where,
            'where_in' => $where_in,
            'join' => $join,
            'group_by' => ''
        );

        $dttbl_model = new Datatable_model('holiday_master', array(), array(), $order_by, $queryAttachments);
        
		$testdata = $dttbl_model->getRows($_POST);
        $data = array();
		$image = '';
        foreach ($testdata as $key => $fieldData) {
		
			

			if($fieldData->status == "Active"){$statusClass = "success";}else{$statusClass = "warning ";}
			

			$status = '<td>'
           . '<span class="badge badge-'.$statusClass.' rounded-pill d-inline">'.$fieldData->status .'</span>';
 
           
		$action = '<div class="_leads_action">'
		. '<a href="#"  data-id="'.$fieldData->id.'" class="btn btn-outline-info btn-xs viewProperty"  data-bs-toggle="modal" data-bs-target=".editPropertyModalXL"  onclick="action('.$fieldData->id.',1)"><i class="fa fa-eye" aria-hidden="true"></i></a>'
		. '<a href="#"  data-id="'.$fieldData->id.'" class="btn btn-outline-success btn-xs editProperty"  data-bs-toggle="modal" data-bs-target=".editPropertyModalXL"  onclick="action('.$fieldData->id.',2)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'
		. '<a href="javascript:" class="btn btn-outline-danger btn-xs" onclick="action('.$fieldData->id.',0)"><i class="fa fa-trash" aria-hidden="true"></i></a>'
		
		. '</div>';


            $data[] = array(
                $key + 1,
                // $fieldData->start_year . ' - ' . $fieldData->end_year,
                $fieldData->name,
                $fieldData->date,
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
			// "csrf" => update_csrf_holiday_master()
        );

        # response
        echo json_encode($output);
        unset($dttbl_model);
	}


	// For Delete, Update and View From DataTable
		// For Delete, Update and View From DataTable
        public function action(){
            $data['table_name'] = $table_name = 'holiday_master'; // Replace with your table name
            $fields = $this->Common_model->get_fields($table_name);
            $data['select'] = array(
                'status' => array(
                    'Y' => 'Active',
                    'N' => 'Inactive',
                ),
                
            );
                // Example: Adding a relational dropdown for 'category_id' from the 'categories' table
                $data['select']['session_year_id'] = $this->Common_model->relational_dropdown(
                    'session',
                    'id',
                    'start_year, end_year',
                    ['status' => 'Y', 'is_delete !='=> 'Y'],
                    ' - '
                );
                
               
                
            // prx($data['select']);
            $data['textEditor'] = [];
            $data['fieldType'] = [];
            $data['size'] = ['holiday_master' => '6'];
            
            $data['hidden'] = 
            [
            'id',
            'is_delete',
            'created_at',
            'updated_at',
            'status',
            'session_year_id',
            'created_by',
            'updated_by',
            ];
            $data['file'] = array(
                // 'image' => array(
                //     'fieldType' => 'sigle',
                //     'accept' => '',
                //     'path' => base_url().'assets/uploads/holiday_master/',
                //     'errorPath' => base_url().'assets/uploads/noimage.png'
                // ),
            );
            $data['fields'] = $fields;
    
            if(post('action') == 0){ 
                $fromData = [
                    'is_delete'=>'Y',
                    'status'=>'Inactive'
                ];
                $res = $this->Generalmodel->getData('holiday_master',post('id'),'id','','','update',$fromData);
                if($res):
                    $result = array('html' => '', 'message'=>'holiday_master Add successfully.', 'status' => 'success');
                else:
                    $result = array('html' => '', 'message'=>'Something went to wrong.', 'status' => 'error');
                endif;
            }elseif(post('action') == 2){
                $data['data'] = $this->Generalmodel->getData('holiday_master',post('id'),'id','','','get','');
                $data['action'] = post('action');
                
                $html = $this->load->view('CRUDFrom',$data, TRUE);
                $result = array('html' => $html, 'status' => 'success');
            }elseif(post('action') == 1){
                $data['data'] = $this->Generalmodel->getData('holiday_master',post('id'),'id','','','get','');
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
            // $obj = (object) array_merge((array) $result,update_csrf_holiday_master());
            echo json_encode($obj);
        }

        function save() {
            $table = 'holiday_master'; // Specify your table name here
        
            // Field configurations
            $data['select'] = array(
                'status' => array(
                    'Y' => 'Active',
                    'N' => 'Inactive',
                ),
                
            );
            $data['textEditor'] = ['description'];
            $data['fieldType'] = [];
            // $data['size'] = ['description' => '12', 'cover_image' => '12', 'image' => '12', 'linkedin' => '12'];
            $data['hidden'] = [
                'id',
                'is_delete',
           
                'created_at',
                'updated_at',
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
              
                // prx($formData);
                // Add created_at or updated_at fields
                if (post('primary_key') == 0) {
                    $formData['created_at'] = date('Y-m-d H:i:s');
                    $formData['created_by'] = get_session('user_id');
                    $formData['session_year_id'] = get_session('session');
                    $action = $this->Generalmodel->getData($table, '', '', '', '', 'insert', $formData);
                    
                } else {
                    $formData['updated_at'] = date('Y-m-d H:i:s');
                    $formData['updated_by'] = get_session('user_id');
                    $formData['session_year_id'] = get_session('session');
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
        
	function deleteImage(){
		$data = array(
			'image' => '',
		);
		$action = $this->Generalmodel->getData('holiday_master',post('id'), 'id', '', '', 'update', $data);
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
