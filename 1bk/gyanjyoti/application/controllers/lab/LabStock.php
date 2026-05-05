<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class LabStock extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
        $this->load->model('Lab_model');
		date_default_timezone_set('Asia/Kolkata');
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }

	}

	public function index(){
        
	
        $head['title'] = $data['page_title'] = 'Lab Stock';

        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('lab/lab_stock/index');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}


	
	public function list(){
		# include datatable model
        include_once('application/models/Datatable_model.php');
        # customize filter
        $order_by = array('lab_stock.id ' => 'desc');
        $where_in = array();
		$where = array('lab_stock.is_delete' => 'N');

        $join = array(
            array(
				'ontable'	=> 'labitem_master',
				'onParams'	=> 'labitem_master.id = lab_stock.item',
				'type'		=> 'left'
			),
        );
 
        $queryAttachments = array(
            'select' => 'lab_stock.*, labitem_master.name as item_name',
            'where' => $where,
            'where_in' => $where_in,
            'join' => $join,
            'group_by' => ''
        );

        $dttbl_model = new Datatable_model('lab_stock', array(), array(), $order_by, $queryAttachments);
		$testdata = $dttbl_model->getRows($_POST);
        $data = array();
		$image = '';
        foreach ($testdata as $key => $fieldData) {
			
           
		$action = '<div class="_leads_action">'
		. '<a href="#"  data-id="'.$fieldData->id.'" class="btn btn-outline-info btn-xs viewProperty"  data-bs-toggle="modal" data-bs-target=".editPropertyModalXL"  onclick="action('.$fieldData->id.',1)"><i class="fa fa-eye" aria-hidden="true"></i></a>'
		// . '<a href="#"  data-id="'.$fieldData->id.'" class="btn btn-outline-success btn-xs editProperty"  data-bs-toggle="modal" data-bs-target=".editPropertyModalXL"  onclick="action('.$fieldData->id.',2)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'
		. '<a href="javascript:" class="btn btn-outline-danger btn-xs" onclick="action('.$fieldData->id.',0)"><i class="fa fa-trash" aria-hidden="true"></i></a>'
		
		. '</div>';

 

            $data[] = array(
                $key + 1,
                $fieldData->bill_no,
                $fieldData->item_name,
                $fieldData->qty,
                $fieldData->remarks,
                $fieldData->stock_date,
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
			// "csrf" => update_csrf_lab_stock()
        );

        # response
        echo json_encode($output);
        unset($dttbl_model);
	}


		// For Delete, Update and View From DataTable
        public function action(){
            $data['table_name'] = $table_name = 'lab_stock'; // Replace with your table name
            $fields = $this->db->list_fields($table_name);
            $data['select'] = array(
            );
            $data['select']['item'] = $this->Common_model->relational_dropdown(
                'labitem_master',
                'id',
                'name',
                ['is_delete !='=> 'Y'],
                ' - '
            );
            $data['select']['bill_no'] = $this->Common_model->relational_dropdown(
                'lab_requisition',
                'id',
                'requisition_num',
                ['is_delete !='=> 'Y'],
                ' - '
            );
            
            
           

            $data['textEditor'] = [];
            $data['fieldType'] = [];
            $data['size'] = ['remarks' => 12];
            
            $data['hidden'] = 
            [
            'id',
            'unit_of_measure',
            'name',
            'due_qty',
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
                ];
                $res = $this->Generalmodel->getData('lab_stock',post('id'),'id','','','update',$fromData);
                if($res):
                    $result = array('html' => '', 'message'=>'lab_stock Delete Successfully.', 'status' => 'success');
                else:
                    $result = array('html' => $this->db->last_query(), 'message'=>'Something went to wrong.', 'status' => 'error');
                endif;
            }elseif(post('action') == 2){
                $data['data'] = $this->Generalmodel->getData('lab_stock',post('id'),'id','','','get','');
                $data['action'] = post('action');
                
                $html = $this->load->view('lab/lab_stock/CRUDFrom',$data, TRUE);
                $result = array('html' => $html, 'status' => 'success');
            }elseif(post('action') == 1){
                $data['data'] = $this->Generalmodel->getData('lab_stock',post('id'),'id','','','get','');
                $data['action'] = post('action');
                $html = $this->load->view('lab/lab_stock/CRUDFrom',$data, TRUE);
                $result = array('html' => $html, 'status' => 'success');
            }
            
            else{
                $data['action'] = post('action');
        
                
                $html = $this->load->view('lab/lab_stock/CRUDFrom',$data, TRUE);
                $result = array('html' => $html, 'status' => 'success');
            }
            $obj = (object) array_merge((array) $result);
            echo json_encode($obj);
        }

        function save() {
            $data['table_name'] = $table_name = 'lab_stock'; // Replace with your table name
            $fields = $this->db->list_fields($table_name);
            $data['select'] = array(
            );
            $data['select']['item'] = $this->Common_model->relational_dropdown(
                'labitem_master',
                'id',
                'name',
                ['is_delete !='=> 'Y'],
                ' - '
            );
            
            
           

            $data['textEditor'] = [];
            $data['fieldType'] = [];
            $data['size'] = ['remarks' => 12];
            
            $data['hidden'] = 
            [
            'id',
            'requisition_num',
            'name',
            'due_qty',
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
                $item_qty = $this->input->post('qty');
				$bill_no = $this->input->post('bill_no');
				$item_id = $this->input->post('item');
                $req_deatils = $this->Lab_model->get_requisition_by_num($bill_no);	
				$item_prev_qty = $req_deatils->qty;
				$get_current_stock = $this->Lab_model->getStock($item_id);	
				if(($item_prev_qty-$item_qty)==0){
                    $data = array(
                        'name'				=> $req_deatils->name,
						'qty'			=> $get_current_stock+$this->input->post('qty'),						
						'remarks'			=> $this->input->post('remarks'),
						'unit_of_measure'	=> $req_deatils->unit_of_measure,
						'bill_no'			=> $req_deatils->requisition_num,
						'stock_date'		=> date('Y-m-d',strtotime(str_replace('/','-',$this->input->post('stock_date'))))
					);
					$updata = array(
						'due_qty'	=> $item_qty,
						'status'	=> 0
					);
                    
					$this->Lab_model->updatelabReq($updata,$bill_no);
                    
					$result = $this->Lab_model->updatelabStock($data,$item_id);				
					if($result){
                        $result = array('html' => '', 'message' => 'Stock Update Successfully!', 'status' => 'success');
					}
					
				} elseif($item_prev_qty>$item_qty){
                    $due_qty = $item_prev_qty-$item_qty;
					
					$data = array(
                        'name'				=> $req_deatils->name,
						'qty'			=> $get_current_stock+$this->input->post('qty'),						
						'remarks'			=> $this->input->post('remarks'),
						'unit_of_measure'	=> $req_deatils->unit_of_measure,
						'bill_no'			=> $req_deatils->requisition_num,
						'stock_date'		=> date('Y-m-d',strtotime(str_replace('/','-',$this->input->post('stock_date'))))
					);						
					$updata = array(
                        'due_qty' => $due_qty
					);
					
					$this->Lab_model->updatelabReq($updata,$bill_no);
					
					$result = $this->Lab_model->updatelabStock($data,$item_id);				
					if($result){
                        $result = array('html' => '', 'message' => 'Stock Update Successfully!', 'status' => 'success');
					}
				}
                
            }
            // prx($data);
        
            echo json_encode((object)$result);
        }

        public function getRequisitionData(){
            $data =[];
            $req_no = $this->input->post('bill_no');
            $req_deatils = $this->Lab_model->get_requisition_by_num($req_no);	
            // echo $this->db->last_query();
            $result = array('data' => $req_deatils, 'message' => 'Successfully.', 'status' => 'success');
            echo json_encode((object)$result);
        }

}
?>
