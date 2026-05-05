<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
		date_default_timezone_set('Asia/Kolkata');
		
		// Check if user is Admin 
        // if (!hasGroupPrivilege($this->session->userdata('user_id'), 'Dashboard')) {
		// 	$group_details = $this->Common_model->getAllData('groups', '', 1, ['group_name'=> 'Dashboard']);
		// 	redirect(base_url('no_permission?type=G&group_name=Dashboard&redirect_url='.$group_details->link));
        // }
        
    }

    public function home()
	{
        $data['banner'] = $this->Generalmodel->getDataWhere('banner',['status'=>'Y', 'is_delete'=>'N']);
         $this->db->order_by('id', 'DESC');  // Order by id DESC
        $this->db->limit(3);               // Limit to 3 records
        $query = $this->db->get('notice_board');  // Get data from notice_board table
        $data['notice_board'] = $query->result(); 
        $data['page_title'] = 'Home';
        $this->load->view('include/head', $data);
		$this->load->view('home', $data);
        $this->load->view('include/end');
	}
    public function about()
	{
       
        $data['page_title'] = 'About';
        $this->load->view('include/head', $data);
		$this->load->view('about');
        $this->load->view('include/end');
	}
    public function principalDesk()
	{
       
        $data['page_title'] = 'Principle Desk';
        $this->load->view('include/head', $data);
		$this->load->view('principalDesk');
        $this->load->view('include/end');
	}
    public function course()
	{
       
        $data['page_title'] = 'course';
        $this->load->view('include/head', $data);
		$this->load->view('course');
        $this->load->view('include/end');
	}
    public function contact()
	{
       
        $data['page_title'] = 'contact';
        $this->load->view('include/head', $data);
		$this->load->view('contact');
        $this->load->view('include/end');
	}
    public function submit_message() {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('message', 'Message', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['page_title'] = 'contact';
            $this->load->view('include/head', $data);
            $this->load->view('contact');
            $this->load->view('include/end');
        } else {
            $data['name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $data['message'] = $this->input->post('message');
            $this->db->insert('contact_us', $data);
            $this->session->set_flashdata('success', 'Your message has been sent successfully!');
            redirect('contact');
        }
    }
    public function notice_board()
	{
        $data['notice_board'] = $this->Generalmodel->getDataWhere('notice_board',['status'=>'Y', 'is_delete'=>'N'],'id','desc');
        $data['page_title'] = 'Notice Board';
        $this->load->view('include/head', $data);
		$this->load->view('notice_board', $data);
        $this->load->view('include/end');
	}

  
}
?>
