<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class View_premid extends CI_Controller {

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
        
        // prx($_SESSION);
        $head['title'] = $data['page_title'] = 'View Premid Result';

        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('result/view_premid');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}
    public function loadGreadCard(){
        $session_year_id = get_session('session');  
		$class_id=post('classId');
		$student_id=post('studentId');
		$where['session_id'] = $session_year_id;
		
		if($student_id):
		    if ($this->session->userdata('user_type') == 'students') {
			$where['id'] = $student_id;
		    }else{
		        
			$where['student_code'] = $student_id;
		    }
		endif;
		if($section_id):
			$where['section'] = $section_id;
		endif;
		if($class_id):
			$where['class'] = $class_id;
		endif;
		$data['student_list'] = $this->Generalmodel->getDataWhere('students_details', $where);
// 		prx($where);
		$data['session_id'] = $session_id;
		$html = $this->load->view('result/greadPremidCard', $data, true);
		$result = ['html' => $html, 'message' => '', 'status' => 'success'];
		echo json_encode($result);
    }
  
    
    
    
}
?>
