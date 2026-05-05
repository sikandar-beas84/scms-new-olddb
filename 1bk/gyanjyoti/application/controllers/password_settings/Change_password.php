<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
    * Auth: Suhrid Sarkar || suhrid.developer@gmail.com
    * On: Febuary 21, 2023
    * For: Change Password
*/

class Change_password extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
		date_default_timezone_set('Asia/Kolkata');
				

        
    }

    public function index()
    {
        if (empty($this->session->userdata('user_id'))) {
            redirect(base_url());
        }
        $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
        
        $data['page_title'] = 'EMBARK | Change Password';
        $data['user_details'] = $user_details;
        $this->load->view('include/head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/header');
		$this->load->view('password_settings/change_password/change_password');
        $this->load->view('include/footer');
        $this->load->view('include/end');
    }

	#=====================================
    # Save
    #=====================================
    public function save()
    {
        # validate post data
        $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
		$this->form_validation->set_rules('retype_password', 'Retype Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $msg = $this->form_validation->error_array();
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
			#Edit
			
			if(post('new_password') != post('retype_password')){
				$array = array('status' => 'fail', 'error' => 'Password and Retype Password are not same.', 'message' => '');
			} else if($user_details->user_password != hash('md5', post('current_password'))){
				$array = array('status' => 'fail', 'error' => 'Current Password does not match.', 'message' => '');
			} else{
				
				$data = array(
					'user_password' 	=> hash('md5', post('new_password')),
					'updated_at'    	=> date('Y-m-d H:i:s'),
					'updated_by'    	=> $user_details->id
				);

				$save = $this->Common_model->UpdateDB('user_masters', ['user_name'=>post('username')], $data);
                $passwordHistory = array(
					'user_id' 	=> $user_details->id,
					'is_active' 	=> $user_details->is_active,
					'created_at'    	=> date('Y-m-d H:i:s'),
					'created_by'    	=> $this->session->userdata('user_id')
				);

				 $this->Common_model->add('user_password_change_histories', $passwordHistory);
                $passwordHistory = array(
					'user_id' 	=> $user_details->id,
					'is_active' 	=> $user_details->is_active,
					'created_at'    	=> date('Y-m-d H:i:s'),
					'created_by'    	=> $this->session->userdata('user_id')
				);

				 $this->Common_model->add('user_password_change_histories', $passwordHistory);

				if ($save) {
					$array = array('status' => 'success', 'error' => '', 'message' => 'success_message');
				} else {
					$array = array('status' => 'fail', 'error' => 'error_message', 'message' => '');
				}
			}
            
        }
        # Response
		$array = array_merge($array,update_csrf_session());
        echo json_encode($array);
    }
}
?>
