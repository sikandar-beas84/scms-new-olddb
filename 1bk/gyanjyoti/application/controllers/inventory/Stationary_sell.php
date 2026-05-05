<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Stationary_sell extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->library('eazypay');
        $this->load->model('LoginModel');
        $this->load->model('Report_model');
        $this->load->model('Student_model');
        $this->load->model('Common_model');
        $this->load->model('Inventory_model');
		date_default_timezone_set('Asia/Kolkata');
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }

	}
 
	public function index(){
	    $this->load->model('Student_model');
	    // $data['user_list'] = $this->report_model->get_admin_users();
	    // $data['purchase_list'] = $this->Group_model->gepurchaseitems();
		$data['item_list'] = $this->Inventory_model->getItemData();
		// echo  $this->db->last_query(); exit;
		$data['group_list'] = $this->Inventory_model->getStoreData();
		$r = $data['list'] = $this->Inventory_model->getStationaryData();
		// echo "<pre>"; prx($r);
		$data['title'] =  $data['page_title'] =  'Stationary Sell';
        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('inventory/stationary');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}
    public function getStudentData() {
        $code = $this->input->post('code', true); // Fetch and sanitize input
        
        if (empty($code)) {
            echo "Invalid student code.";
            return;
        }
    
        $student = $this->Student_model->get_students_full_details_by_code($code);
        if (!$student) {
            echo "Student not found.";
            return;
        }
    
        // $section = $this->Student_model->get_section_name_by_id($student->section_id);
        // $section_name = $section ? $section[0]->section_name : 'Unknown';
    // prx($student);
        // Sanitize output  
        $html = "<ul>
            <li><b>Name:</b> " . htmlspecialchars($student->student_name) . "</li>
            <li><b>Class:</b> " . htmlspecialchars($student->class_name) . "</li>
            <li><b>Section:</b> " . htmlspecialchars($student->section) . "</li>
            <li><b>Roll:</b> " . htmlspecialchars($student->roll) . "</li>
        </ul>";
        
        echo $html;
    }
    
	public function getStudentName(){
	    $code = $this->input->post('code');
	    $student = $this->Student_model->get_students_full_details_by_code($code);
	   // $section = $this->Student_model->get_section_name_by_id($student->section_id);
	   // $section_name = $section[0]->section_name;
	    echo  $student->student_name;
	}
    public function loadItem(){
		$item = $this->Inventory_model->get_item_by_store($this->input->post('group'));
        echo '<option value="" selected>Select Item </option>';
		foreach($item as $value){
		    echo ' <option value="'.$value->id.'">'.$value->item_name.'</option>';
		   }
			
	}
    public function getItemCurrentQty(){
		$item = $this->Inventory_model->get_item_by_item_id($this->input->post('id'));
        $qty = $item[0]->openning_stock;
    //     $html = "<ul>
	   // <li><b>Available Quantity:</b> $qty</li>
	   // </ul>";
	    echo $qty;
			
	}

    public function getSellingPrice(){
		$item = $this->Inventory_model->get_item_selling_price_by_item_id($this->input->post('id'));
        echo $item[0]->selling_price; 
	}
	public function stationary_print(){
	    $data['user_list'] = $this->Inventory_model->get_admin_users();
	    $data['purchase_list'] = $this->Inventory_model->gepurchaseitems();
		$data['item_list'] = $this->Inventory_model->getItemData();
		$data['group_list'] = $this->Inventory_model->getStoreData();
		$data['list'] = $this->Inventory_model->get_stationary_by_id($this->uri->segment(4));
        // prx($data['list']);
		$data['title'] =  $data['page_title'] = 'Stationary Print';
        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('inventory/stationary_print');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');	
	}
    
    public function savestationary() {
        $session_year_id = get_session('session');
        // echo "<pre>"; print_r($_POST); exit;
        $payment_type = $this->input->post('payment_type');
        $this->form_validation->set_rules('student_code', 'Student Code', 'trim|required');
        $this->form_validation->set_rules('totalAmount', 'Amount', 'trim|required');
        $this->form_validation->set_rules('payee_name', 'Payee Name', 'trim|required');
    
        // $payment_mode = $this->input->post('ad_payment_mode');
    
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error_msg', validation_errors());
            redirect(base_url('inventory/stationary_sell/'));
        } else {
            if (empty($this->input->post('edit_id'))) {
                // Generate billing number
                $sessionYear = $this->session->userdata('session_year_name');
                $autoGenerateId = $this->Inventory_model->getNextAutoId();
                $billingNumber = 'GPS/' . $sessionYear . '/' . $autoGenerateId;
    
                $data = array(
                    'student_code'  => $this->input->post('student_code'),
                    'amount'        => $this->input->post('totalAmount'),
                    'payment_mode'  => $payment_type,
                    'payee_name'    => $this->input->post('payee_name'),
                    // 'cheque_number' => $this->input->post('cheque_number'),
                    // 'pos_bank_name' => $this->input->post('pos_bank_name'),
                    // 'pos_reference_number' => $this->input->post('pos_reference_number'),
                    'billing_number' => $billingNumber,
                    'created_by'    => $this->session->userdata('user_id'),
                    'created_date'  => date('Y-m-d H:i:s'),
                    'payment_status'  => 'Pending',
                    'session_year_id'  => $session_year_id
                );
                $result = $this->Inventory_model->savestationary($data);
                $lastId = $this->db->insert_id();
                if (!empty($this->input->post('Item_name'))) {
                        foreach ($this->input->post('Item_name') as $k => $v) {
                            $item = $this->Inventory_model->get_item_by_item_id($this->input->post('Item_name')[$k])[0];
                            $data5 = array(
                                'openning_stock' => (int)$item->openning_stock - (int)$this->input->post('qty')[$k]
                            );
                            $R = $this->Inventory_model->update_item($data5, $item->id);
    
                            $datanew = array(
                                'order_id'  => $lastId,
                                'store'     => $this->input->post('group_name')[$k],
                                'item'      => $this->input->post('Item_name')[$k],
                                'quantity'  => $this->input->post('qty')[$k],
                                'amount'    => $this->input->post('total')[$k],
                            );
                            $result = $this->Inventory_model->savestationarypurchaseitem($datanew);
                        }
                    }
                if ($payment_type == '3') { // Assume '2' for EazyPay
                    // Prepare EazyPay payment request
                        $student = $this->Student_model->get_students_full_details_by_code($this->input->post('student_code'));
                         $params = [
                            'referenceNo' => 123,
                            'subMerchantId' => '45',
                            'amount' => post('totalAmount'),
                            'studentId' => $this->input->post('student_code'),
                            'studentName' => $student->student_name,
                            'class' => 'CLASS',
                            'section' => 'SECTION',
                            'roll' =>  1,
                            'monthId' => 1,
                            'upiVpa' => 'UPIVPA',
                            'mobile' => '9087654321',
                            'email' => 'test@gmail.com',
                            'returnUrl' => 'https://gyanjyotipublicschool.com/payment/success'
                        ];
                    // Get URLs
                     $plainUrl = $this->eazypay->generatePlainUrl($params);
                     $encryptedUrl = $this->eazypay->generateEncryptedUrl($params);
                     redirect($encryptedUrl);
                    
                } else {
                    // Save data and update stock for other payment modes
                    $updatestationary['payment_status'] = 'Success';
                    $result = $this->Inventory_model->updatestationary($lastId, $updatestationary);
                    $this->session->set_flashdata('success_msg', 'Item Successfully Inserted in database.!');
                    redirect(base_url('inventory/stationary_sell'));
                }
            }
        }
    }
    

    
    
    
}
?>
