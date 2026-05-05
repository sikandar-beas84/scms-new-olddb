<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
        $this->load->model('Student_model');
        $this->load->model('Generalmodel');
		date_default_timezone_set('Asia/Kolkata');
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }

	}

	public function index(){
        $data['class'] = $this->Common_model->relational_dropdown(
            'class',
            'id',
            'class_name',
            ['status' => 'Y', 'is_delete !=' => 'Y'],
            ' - '
        );
        // prx($_GET);
        $head['title'] = $data['page_title'] ='Id Card';
        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('student/card');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}

    public function get_student() {  
		$session_year_id = get_session('session');  
		$class_id=post('classId');
		// $section_id=post('sectionId');
		$student_id=post('studentId');
		$where['session_id'] = $session_year_id;
		if($student_id):
			$where['student_code'] = $student_id;
		endif;
		if($section_id):
			$where['section'] = $section_id;
		endif;
		if($class_id):
			$where['class'] = $class_id;
		endif;
		$data['student_list'] = $this->Generalmodel->getDataWhere('students_details', $where);
		// prx($data['student_list']);
		// $data['session_id'] = $session_id;
		$html = $this->load->view('student/id_card', $data, true);
		$result = ['html' => $html, 'message' => '', 'status' => 'success'];
		echo json_encode($result);
	}
	

}
?>
