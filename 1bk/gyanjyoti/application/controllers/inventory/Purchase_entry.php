<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_entry extends CI_Controller {

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
        
	
        $head['title'] = $data['page_title'] = 'Purchase Entry';

        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('inventory/purchase_entry/index');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}


	
	public function list(){
		# include datatable model
        include_once('application/models/Datatable_model.php');
        # customize filter
        $order_by = array('purchase_entry.id ' => 'desc');
        $where_in = array();
		$where = array('purchase_entry.is_delete' => 'N');

        $join = array(
            
            array(
				'ontable'	=> 'store',
				'onParams'	=> 'store.id = purchase_entry.store',
				'type'		=> 'left'
			),
            array(
				'ontable'	=> 'stationary_item',
				'onParams'	=> 'stationary_item.id = purchase_entry.item',
				'type'		=> 'left'
			),
        );
 
        $queryAttachments = array(
            'select' => 'purchase_entry.*, store.name as store_name, stationary_item.*', // Fetch store name along with stationary item details
            'where' => $where,
            'where_in' => $where_in,
            'join' => $join,
            'group_by' => ''
        );
    

        $dttbl_model = new Datatable_model('purchase_entry', array(), array(), $order_by, $queryAttachments);
		$testdata = $dttbl_model->getRows($_POST);
        $data = array();
		$image = '';
        foreach ($testdata as $key => $fieldData) {
			
           
		$action = '<div class="_leads_action">'
		// . '<a href="#"  data-id="'.$fieldData->id.'" class="btn btn-outline-info btn-xs viewProperty"  data-bs-toggle="modal" data-bs-target=".editPropertyModalXL"  onclick="action('.$fieldData->id.',1)"><i class="fa fa-eye" aria-hidden="true"></i></a>'
		// . '<a href="#"  data-id="'.$fieldData->id.'" class="btn btn-outline-success btn-xs editProperty"  data-bs-toggle="modal" data-bs-target=".editPropertyModalXL"  onclick="action('.$fieldData->id.',2)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'
		. '<a href="javascript:" class="btn btn-outline-danger btn-xs" onclick="action('.$fieldData->id.',0)"><i class="fa fa-trash" aria-hidden="true"></i></a>'
		
		. '</div>';

 

            $data[] = array(
                $key + 1,
                $fieldData->vender_name,
                $fieldData->address,
                $fieldData->phone,
                $fieldData->bill_no,
                $fieldData->bill_date,
                $fieldData->store_name,
                $fieldData->item_name,
                $fieldData->quantity,
                $fieldData->price,
                $fieldData->selling_price,
                $fieldData->total_amount,
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
			// "csrf" => update_csrf_purchase_entry()
        );

        # response
        echo json_encode($output);
        unset($dttbl_model);
	}


		// For Delete, Update and View From DataTable
        public function action(){
            $data['table_name'] = $table_name = 'purchase_entry'; // Replace with your table name
            $fields = $this->db->list_fields($table_name);
            $data['select'] = array(
               
                
            );
            $data['select']['store'] = $this->Common_model->relational_dropdown(
                'store',
                'id',
                'name',
                [ 'is_delete !='=> 'Y'],
                ' '
            );
            $data['select']['item'] = $this->Common_model->relational_dropdown(
                'stationary_item',
                'id',
                'item_name',
                [ 'is_delete !='=> 'Y'],
                ' '
            );
            $data['textEditor'] = [];
            $data['fieldType'] = [];
            $data['size'] = [];
            
            $data['hidden'] = 
            [
            'id',
            'mapping_item',
            'verification',
            'mapping_item',
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
    
            if(post('action') == 0){ 
                $fromData = [
                    'is_delete'=>'Y',
                ];
                $res = $this->Generalmodel->getData('purchase_entry',post('id'),'id','','','update',$fromData);
                if($res):
                    $result = array('html' => '', 'message'=>'purchase_entry Delete Successfully.', 'status' => 'success');
                else:
                    $result = array('html' => $this->db->last_query(), 'message'=>'Something went to wrong.', 'status' => 'error');
                endif;
            }elseif(post('action') == 2){
                $data['data'] = $this->Generalmodel->getData('purchase_entry',post('id'),'id','','','get','');
                $data['action'] = post('action');
                
                $html = $this->load->view('inventory/purchase_entry/CRUDFrom',$data, TRUE);
                $result = array('html' => $html, 'status' => 'success');
            }elseif(post('action') == 1){
                $data['data'] = $this->Generalmodel->getData('purchase_entry',post('id'),'id','','','get','');
                $data['action'] = post('action');
                $html = $this->load->view('inventory/purchase_entry/CRUDFrom',$data, TRUE);
                $result = array('html' => $html, 'status' => 'success');
            }
            
            else{
                $data['action'] = post('action');
        
                
                $html = $this->load->view('inventory/purchase_entry/CRUDFrom',$data, TRUE);
                $result = array('html' => $html, 'status' => 'success');
            }
            $obj = (object) array_merge((array) $result);
            echo json_encode($obj);
        }

        function save() {
            $data['table_name'] = $table_name = 'purchase_entry'; // Replace with your table name
            $fields = $this->db->list_fields($table_name);
            $data['select'] = array(
               
                
            );

            $data['textEditor'] = [];
            $data['fieldType'] = [];
            $data['size'] = [];
            
            $data['hidden'] = 
            [
            'id',
            'mapping_item',
            'verification',
            'mapping_item',
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
        public function get_item_by_store(){
            $store = $this->input->post('store');
            
            // Initialize the sections array with a default option
            $sections = array();
            // $sections['0'] = 'Select Section';
        
            // Fetch the sections from the database using the relational_dropdown method
            $sections =  $this->Common_model->relational_dropdown(
                'stationary_item',
                'id',
                'item_name',
                [
                    'is_delete !=' => 'Y', 
                    'store' => $store
                ],
                ' - '
            );
            // prx($sections);
            // Output the sections as a JSON response
            echo json_encode($sections);
        }

}
?>
