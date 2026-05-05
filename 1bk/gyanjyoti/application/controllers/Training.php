<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Training extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
		date_default_timezone_set('Asia/Kolkata');
		
		// Check if user is Admin 
        if (!hasGroupPrivilege($this->session->userdata('user_id'), 'Dashboard')) {
			$group_details = $this->Common_model->getAllData('groups', '', 1, ['group_name'=> 'Dashboard']);
			redirect(base_url('no_permission?type=G&group_name=Dashboard&redirect_url='.$group_details->link));
        }
        
    }

    public function Training_video()
	{
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url());
        }
        $data['page_title'] = 'Palmhera Travel Group Training Video';
        $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));

        $data['user_details'] = $user_details;

        $this->load->view('include/head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/header');
		$this->load->view('training_video');
        $this->load->view('include/footer');
        $this->load->view('include/end');
	}

  
  
}
?>
