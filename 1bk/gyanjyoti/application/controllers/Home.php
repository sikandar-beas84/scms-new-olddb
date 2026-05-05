<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Report_model');
        $this->load->model('Common_model');
		date_default_timezone_set('Asia/Kolkata');
		if(empty($this->session->userdata('user_id'))){
            redirect(base_url('login'));
        }
		// Check if user is Admin 
        // if (!hasGroupPrivilege($this->session->userdata('user_id'), 'Dashboard')) {
		// 	$group_details = $this->Common_model->getAllData('groups', '', 1, ['group_name'=> 'Dashboard']);
		// 	redirect(base_url('no_permission?type=G&group_name=Dashboard&redirect_url='.$group_details->link));
        // }
        
    }

    public function index()
	{
        if(!empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }
        $data['page_title'] = 'Login';
        $this->load->view('include/head', $data);
		$this->load->view('login_form');
        $this->load->view('include/end');
	}

    public function dashboard(){
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url());
        }
        // $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
        // prx($user_details);

        $data['page_title'] = ' Dashboard';
        $data['total_students'] = $this->Report_model->get_total_students();
        $data['total_teachers'] = $this->Report_model->get_total_teachers();
        $data['total_admissions'] = $this->Report_model->get_total_admissions();
        $data['total_form_fill_up'] = $this->Report_model->total_form_fill_up();
        $data['total_form_fill_up'] = $this->Report_model->total_form_fill_up();
        $data['total_form_cash_fill_up'] = $this->Report_model->get_total_amount_by_date_type(date('Y-m-d'),1);
        // prx($data['total_form_cash_fill_up']);
        $data['total_form_qr_fill_up'] = $this->Report_model->get_total_amount_by_date_type(date('Y-m-d'),2);
        $data['student_enrollment_over_years'] = $this->Report_model->get_student_enrollment_over_years();
        $data['monthly_payment_data'] = $this->Report_model->get_monthly_payment_data();
        $data['admissionToggle'] = $this->Generalmodel->getData('sub_groups',2,'id','','','get','');
        $data['resultToggle'] = $this->Generalmodel->getData('sub_groups',59,'id','','','get','');
        $currentDate = date('Y-m-d');
                // Get application counts and student counts from the model
        $data['payment_collections'] = $this->Report_model->get_payment_collections($class_id, $currentDate, $currentDate, $payment_type, $teachers);
        $data['total_payment_received'] = $this->Report_model->get_total_payment_received($class_id, $currentDate, $currentDate, $payment_type, $teachers);
        // prx($data['monthly_payment_data']);
        $data['user_details'] = $user_details;
        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
		$this->load->view('dashboard');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
    }
  public function admissionToggle(){
    $data['data'] = $this->Generalmodel->getData('sub_groups',2,'id','','','update',['is_active'=>post('checked')]);
    if(post('checked') == 'Y'){
        $result = array('status' => 'success','message'=>'Admission is Enabled');
    }else{
        $result = array('status' => 'success','message'=>'Admission is Disabled');
    }
    $obj = (object) array_merge((array) $result);
            echo json_encode($obj);
  }
  public function resultToggle(){
    $data['data'] = $this->Generalmodel->getData('groups',35,'id','','','update',['is_active'=>post('checked')]);
    $data['data'] = $this->Generalmodel->getData('sub_groups',59,'id','','','update',['is_active'=>post('checked')]);
    $data['data'] = $this->Generalmodel->getData('sub_groups',86,'id','','','update',['is_active'=>post('checked')]);
    if(post('checked') == 'Y'){
        $result = array('status' => 'success','message'=>'Result View is Enabled');
    }else{
        $result = array('status' => 'success','message'=>'Result View is Disabled');
    }
    $obj = (object) array_merge((array) $result);
            echo json_encode($obj);
  }
}
?>
