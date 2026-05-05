<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Bonafide extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
        $this->load->model('Student_model');

		date_default_timezone_set('Asia/Kolkata');
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }

	}

	public function index(){
        
	
        $head['title'] = $data['page_title'] = 'Student Bonafide Certificate';
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
		$this->load->view('certificate/bonafide/index');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}
    public function getCertificate(){
        $student = $this->Student_model->get_students_full_details_by_code(post('student_id'));
        $data1['student'] = $this->Student_model->get_students_full_details($student->id);
        // pr($data);
		$html = $this->load->view('certificate/bonafide/certificate', $data1, TRUE);
        $data['data'] = $html;
        $data['status'] = 'Success';
        echo json_encode($data); 
	}
}
?>
