<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Collection_report extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Report_model');
        $this->load->model('Common_model');
        $this->load->model('Student_model');
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
		$this->load->view('report/collection_report');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}

    public function load_collection_report_ajax() {      
        // Get parameters from POST request
        $class_id = $this->input->post('classId');
        $toDate = $this->input->post('toDate');
        $fromDate = $this->input->post('fromDate');
        $payment_type = $this->input->post('payment_methods');
        $teachers = $this->input->post('teachers');
    
        // Get application counts and student counts from the model
        $payment_collections = $this->Report_model->get_payment_collections($class_id, $fromDate, $toDate, $payment_type, $teachers);
        $from_payment_collections = $this->Report_model->get_form_payment_collections($class_id, $fromDate, $toDate, $payment_type, $teachers);
        // prx($from_payment_collections);
        $total_payment_received = $this->Report_model->get_total_payment_received($class_id, $fromDate, $toDate, $payment_type, $teachers);
        $class_payment_summary = $this->Report_model->get_class_payment_summary($class_id, $fromDate, $toDate, $payment_type, $teachers);
        // echo $this->db->last_query() ;
        $daily_payment_summary = $this->Report_model->get_daily_payment_summary($class_id, $fromDate, $toDate, $payment_type, $teachers);

        $total_payment_received += $from_payment_collections['total_cash_collection'] + $from_payment_collections['total_qr_collection'] + $from_payment_collections['total_online_collection'];
        // Generate the report HTML by loading the view
        $html = $this->load->view('report/collection_report_ajax', array('total_payment_received' => $total_payment_received, 'class_payment_summary' => $class_payment_summary, 'daily_payment_summary' => $daily_payment_summary, 'payment_collections' => $payment_collections, 'from_payment_collections'=> $from_payment_collections), TRUE);
    
        // Prepare the response data
        $data["html"] = $html;
        $data["total_payment_received"] = $total_payment_received;
    
        // Return the data as JSON
        echo json_encode($data);
    }
    public function load_collection_list() {      
        // Get parameters from POST request
        $class_id = $this->input->post('classId');
        $toDate = $this->input->post('toDate');
        $fromDate = $this->input->post('fromDate');
        $payment_type = $this->input->post('payment_methods');
        $teachers = $this->input->post('teachers');

        // Get application counts and student counts from the model

        $daily_payment_summary = $this->Report_model->get_daily_payment_summary($class_id, $fromDate, $toDate, $payment_type, $teachers);
        // echo $payment_type ;
        foreach ($daily_payment_summary as $key => $v) {
            $student = $this->Student_model->get_students_details($v->student_id);
            $timestamp = mktime(0, 0, 0, $v->month, 1, date("Y"));  // Creates a timestamp for the first day of the month
            $monthName = date('M', $timestamp);
            $collected_by = '';
            if($v->collected_by){
                $staff = $this->Generalmodel->getDataWhere('staff',['id'=>$v->collected_by]);
                $collected_by = $staff[0]->first_name.' '.$staff[0]->last_name;
            }
            $formatted_date = date("d-m-Y h:i A", strtotime($v->payment_date));
            $data[] = array(
                $key + 1,
                $student->student_code,
                $student->student_name,
                isset($v->tuition_fees) ? $v->tuition_fees : 0,
                isset($v->fine) ? $v->fine : 0,
                (
                    ($v->session_fees ?? 0) +
                    ($v->academic_fees ?? 0) +
                    ($v->tuition_fees ?? 0) +
                    ($v->monthly_fees ?? 0) +
                    ($v->sports_fees ?? 0) +
                    ($v->library_fees ?? 0) +
                    ($v->lab_fees ?? 0) +
                    ($v->other_curriculum_fees ?? 0) +
                    ($v->fine ?? 0)
                ),
                $monthName,
                $collected_by,
                $formatted_date,
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
