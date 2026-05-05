<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

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
        
	
        $head['title'] = $data['page_title'] = 'Stock';

        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('library/stock/index');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}


	
	public function list(){
		# include datatable model
        include_once('application/models/Datatable_model.php');
        # customize filter
        $order_by = array('lib_stock.id ' => 'desc');
        $where_in = array();
		$where = array('lib_stock.is_delete' => 'N');

        $join = array();
 
        $queryAttachments = array(
            'select' => 'lib_stock.*',
            'where' => $where,
            'where_in' => $where_in,
            'join' => $join,
            'group_by' => ''
        );

        $dttbl_model = new Datatable_model('lib_stock', array(), array(), $order_by, $queryAttachments);
		$testdata = $dttbl_model->getRows($_POST);
        $data = array();
		$image = '';
        foreach ($testdata as $key => $fieldData) {
			
           
		$action = '<div class="_leads_action">'
		. '<a href="#"  data-id="'.$fieldData->id.'" class="btn btn-outline-info btn-xs viewProperty"  data-bs-toggle="modal" data-bs-target=".editPropertyModalXL"  onclick="action('.$fieldData->id.',1)"><i class="fa fa-eye" aria-hidden="true"></i></a>'
		. '<a href="#"  data-id="'.$fieldData->id.'" class="btn btn-outline-success btn-xs editProperty"  data-bs-toggle="modal" data-bs-target=".editPropertyModalXL"  onclick="action('.$fieldData->id.',2)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'
		. '<a href="javascript:" class="btn btn-outline-danger btn-xs" onclick="action('.$fieldData->id.',0)"><i class="fa fa-trash" aria-hidden="true"></i></a>'
		
		. '</div>';

 

            $data[] = array(
                $key + 1,
                $fieldData->book_edition,
                $fieldData->isbn,
                $fieldData->bill_no,
                $fieldData->book_name,
                $fieldData->price,
                $fieldData->language,
                $fieldData->subject,
                $fieldData->type,
                $fieldData->access_no,
                $fieldData->book_author,
                $fieldData->book_publisher,
                $fieldData->entry_date,
                $fieldData->price,
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
			// "csrf" => update_csrf_lib_stock()
        );

        # response
        echo json_encode($output);
        unset($dttbl_model);
	}


		// For Delete, Update and View From DataTable
        public function action(){
            $data['table_name'] = $table_name = 'lib_stock'; // Replace with your table name
            $fields = $this->db->list_fields($table_name);
            $data['select'] = array();
            $data['select']['class'] = $this->Common_model->relational_dropdown(
                'class',
                'id',
                'class_name',
                ['status' => 'Y', 'is_delete !='=> 'Y'],
                ' - '
            );
            $data['select']['book_category'] = $this->Common_model->relational_dropdown(
                'book_category',
                'id',
                'name',
                ['status' => '1', 'is_delete !='=> 'Y'],
                ' - '
            );

            $data['textEditor'] = [];
            $data['fieldType'] = [];
            $data['size'] = ['name'=>12];
            
            $data['hidden'] = 
            [
            'id',
            'lib_stock',
            'is_delete',
            'start_year',
            'end_year',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'status',
            'is_latest',
            // 'rating'
            ];
            $data['file'] = array(
           
            );
            $data['fields'] = $fields;
    
            if(post('action') == 0){ 
                $fromData = [
                    'is_delete'=>'Y',
                ];
                $res = $this->Generalmodel->getData('lib_stock',post('id'),'id','','','update',$fromData);
                if($res):
                    $result = array('html' => '', 'message'=>'lib_stock Delete Successfully.', 'status' => 'success');
                else:
                    $result = array('html' => $this->db->last_query(), 'message'=>'Something went to wrong.', 'status' => 'error');
                endif;
            }elseif(post('action') == 2){
                $data['data'] = $this->Generalmodel->getData('lib_stock',post('id'),'id','','','get','');
                $data['action'] = post('action');
                
                $html = $this->load->view('CRUDFrom',$data, TRUE);
                $result = array('html' => $html, 'status' => 'success');
            }elseif(post('action') == 1){
                $data['data'] = $this->Generalmodel->getData('lib_stock',post('id'),'id','','','get','');
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
            $data['table_name'] = $table_name = 'lib_stock'; // Replace with your table name
            $fields = $this->db->list_fields($table_name);
            $data['select'] = array(
               
                
            );

            $data['textEditor'] = [];
            $data['fieldType'] = [];
            $data['size'] = ['name'=>12];
            
            $data['hidden'] = 
            [
            'id',
            'lib_stock',
            'is_delete',
            'start_year',
            'end_year',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'status',
            // 'rating'
            ];
            $data['file'] = array(
           
            );
            $data['fields'] = $fields;
        
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
                    // prx($formData);
                        $action = $this->Generalmodel->getData($table_name, '', '', '', '', 'insert', $formData);
                        
                    } else {
                        $formData['updated_by'] = $this->session->userdata('user_id');
                        $formData['updated_at'] = date('Y-m-d H:i:s');
                        $action = $this->Generalmodel->getData($table_name, post('primary_key'), 'id', '', '', 'update', $formData);
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
