<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class collocation_report extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Report_model');
        $this->load->model('Common_model');
		date_default_timezone_set('Asia/Kolkata');
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }

	}
 
	public function index(){
        
	
        $head['title'] = $data['page_title'] = 'Collection report';
        $data['class'] = $this->Common_model->relational_dropdown(
            'class',
            'id',
            'class_name',
            ['status' => 'Y', 'is_delete !=' => 'Y'],
            ' - '
        );
        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('report/collocation_report');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}

    public function load_collocation_report_ajax() {      
        // Get parameters from POST request
        $class_id = $this->input->post('classId');
        $toDate = $this->input->post('toDate');
        $fromDate = $this->input->post('fromDate');
        $payment_type = $this->input->post('payment_methods');
    
        // Get application counts and student counts from the model
        $total_payment_received = $this->Report_model->get_total_payment_received($class_id, $fromDate, $toDate, $payment_type);
        $class_payment_summary = $this->Report_model->get_class_payment_summary($class_id, $fromDate, $toDate, $payment_type);
        // echo $this->db->last_query() ;
        $daily_payment_summary = $this->Report_model->get_daily_payment_summary($class_id, $fromDate, $toDate, $payment_type);

        // prx($total_payment_received);
        // pr($class_wish_data);
        // Generate the report HTML by loading the view
        $html = $this->load->view('report/collocation_report_ajax', array('total_payment_received' => $total_payment_received, 'class_payment_summary' => $class_payment_summary, 'daily_payment_summary' => $daily_payment_summary), TRUE);
    
        // Prepare the response data
        $data["html"] = $html;
        $data["total_payment_received"] = $total_payment_received;
    
        // Return the data as JSON
        echo json_encode($data);
    }
    public function load_collocation_list() {      
        // Get parameters from POST request
        $class_id = $this->input->post('classId');
        $toDate = $this->input->post('toDate');
        $fromDate = $this->input->post('fromDate');
        $payment_type = $this->input->post('payment_methods');
    
        // Get application counts and student counts from the model

        $daily_payment_summary = $this->Report_model->get_daily_payment_summary($class_id, $fromDate, $toDate, $payment_type);
        // echo $payment_type ;
        foreach ($daily_payment_summary as $key => $v) {
            $data[] = array(
                $key + 1,
                $v->payment_day,
                $v->total_payment_received,
            );
        }

        
        $output = array(
            "draw" => $draw,

            "data" => $data,
            "status" => 'success',
			// "csrf" => update_csrf_class()
        );

        # response
        echo json_encode($output);
        unset($dttbl_model);
    }
	
}
?>
