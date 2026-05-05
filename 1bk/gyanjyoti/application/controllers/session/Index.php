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
        
	
        $head['title'] = $data['page_title'] = 'Session';

        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('session/index');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}


	
	public function list(){
		# include datatable model
        include_once('application/models/Datatable_model.php');
        # customize filter
        $order_by = array('session.id ' => 'desc');
        $where_in = array();
		$where = array('session.is_delete' => 'N');

        $join = array();
 
        $queryAttachments = array(
            'select' => 'session.*',
            'where' => $where,
            'where_in' => $where_in,
            'join' => $join,
            'group_by' => ''
        );

        $dttbl_model = new Datatable_model('session', array(), array(), $order_by, $queryAttachments);
		$testdata = $dttbl_model->getRows($_POST);
        $data = array();
		$image = '';
        foreach ($testdata as $key => $fieldData) {
			// prx($fieldData->gallery);
			if($fieldData->image){
				$image = $fieldData->image;
			}else{
				$image = 'noimage.png';
			}
			

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
                $fieldData->start_date,
                $fieldData->end_date,
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
			// "csrf" => update_csrf_session()
        );

        # response
        echo json_encode($output);
        unset($dttbl_model);
	}


		// For Delete, Update and View From DataTable
        public function action(){
            $data['table_name'] = $table_name = 'session'; // Replace with your table name
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
            'created_at',
            'updated_at',
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
                $res = $this->Generalmodel->getData('session',post('id'),'id','','','update',$fromData);
                if($res):
                    $result = array('html' => '', 'message'=>'Session Delete Successfully.', 'status' => 'success');
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
            $table = 'session'; // Specify your table name here
        
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
                'start_year',
                'end_year',
                'created_at',
                'updated_at',
                'status',
            ];
            $data['file'] = array(
                
            );
        
            // Fetch table fields
            $fields = $this->db->list_fields($table);
        
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
                $formData['start_year'] = date('Y', strtotime(post('start_date')));
                $formData['end_year'] = date('Y', strtotime(post('end_date')));
                // prx($formData);
                // Add created_at or updated_at fields
                if($formData['start_year'] < $formData['end_year']){
                    if (post('primary_key') == 0) {
                        $formData['created_at'] = date('Y-m-d H:i:s');
                        $action = $this->Generalmodel->getData($table, '', '', '', '', 'insert', $formData);
                        
                    } else {
                        $formData['updated_at'] = date('Y-m-d H:i:s');
                        $action = $this->Generalmodel->getData($table, post('primary_key'), 'id', '', '', 'update', $formData);
                    }
            
                    if ($action) {
                        $result = array('html' => '', 'message' => 'Record saved successfully.', 'status' => 'success');
                    } else {
                        $result = array('html' => '', 'message' => 'Something Went Wrong Please Try Again.', 'status' => 'error');
                    }
                }else{
                    $result = array('html' => '', 'message' => 'Start date must be greater than the end date', 'status' => 'error');
                }
            }
        
            echo json_encode((object)$result);
        }
        

}
?>
