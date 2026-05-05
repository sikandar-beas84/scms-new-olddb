<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Stationary_sale_report extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Report_model');
        $this->load->model('Student_model');
        $this->load->model('Inventory_model');
        $this->load->model('Common_model');
		date_default_timezone_set('Asia/Kolkata');
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }

	}

	public function index(){
        
	
        $head['title'] = $data['page_title'] = 'Stationary Sale report';
        // $data['class'] = $this->Common_model->relational_dropdown(
        //     'class',
        //     'id',
        //     'class_name',
        //     ['status' => 'Y', 'is_delete !=' => 'Y'],
        //     ' - '
        // );
        $data['staff'] = $this->Common_model->relational_dropdown(
            'staff',
            'id',
            'first_name, last_name',
            ['status' => 'Y', 'is_delete !=' => 'Y'],
            ' - '
        );
        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('report/stationary_sale_report');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}

    public function load_stationary_sale_report_ajax() {      
        // Get parameters from POST request
        $teachers = $this->input->post('teachers');
        $toDate = $this->input->post('toDate');
        $fromDate = $this->input->post('fromDate');
    
        // Get application counts and student counts from the model
        // $count = $this->Report_model->get_application_counts($class_id, $fromDate, $toDate);
        // $all_application = $this->Report_model->get_all_application($class_id, $fromDate, $toDate);
        // $StudentCount = $this->Report_model->getStudentCount($class_id, $fromDate, $toDate);
        // $class_wish_data = $this->Report_model->get_class_wish_data($class_id, $fromDate, $toDate);
        $total_payment_received = $this->Report_model->get_total_stationary_sale_payment($teachers, $fromDate, $toDate);
        $get_all_stationary_sale = $this->Report_model->get_all_stationary_sale($teachers, $fromDate, $toDate);
// prx($get_all_stationary_sale);
        // echo $this->db->last_query();
        // pr($count);
        // pr($class_wish_data);
        // Generate the report HTML by loading the view
        $html = $this->load->view('report/stationary_sale_report_ajax', array('total_payment_received' => $total_payment_received, 'all_stationary_sale' => $get_all_stationary_sale), TRUE);
    
        // Prepare the response data
        $data["html"] = $html;
    
        // Return the data as JSON
        echo json_encode($data);
    }
	
}
?>
