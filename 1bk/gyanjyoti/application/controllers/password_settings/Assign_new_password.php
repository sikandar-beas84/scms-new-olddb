<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
    * Auth: Suhrid Sarkar || suhrid.developer@gmail.com
    * On: Febuary 16, 2023
    * For: Assign New Password
	* Modify: Fixed some issue on Febuary 21, 2023 by Suhrid Sarkar || suhrid.developer@gmail.com
*/

class Assign_new_password extends CI_Controller
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
        // if (empty($this->session->userdata('user_id'))) {
        //     redirect(base_url());
        // }
        $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
        
        $data['page_title'] = 'EMBARK | Assign New Password';
        $data['user_details'] = $user_details;
        $this->load->view('include/head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/header');
		$this->load->view('password_settings/assign_new_password/assign_new_password');
        $this->load->view('include/footer');
        $this->load->view('include/end');
    }

    #=====================================
    # Get User Details
    #=====================================
	public function get_user_details(){
		$user_code = post('user_code');
	  /*******************Devoloper Suhrid Start 30-03-2023 ***************************/
// 		$user_details = $this->Common_model->get2WhereIn('user_masters', 'Y','password_change','Y','is_active');
        $user_details = $this->Common_model->getAllData('user_masters', '', '', ['is_active' => 'Y']);  //CR by Suhrid Sarkar || suhrid.developer@gmail.com on June 20, 2023
         /*******************Devoloper Suhrid END 30-03-2023 ***************************/
        // prx($user_details);
		$user_name = '';
		$password_change = 'N';
		foreach($user_details as $key => $value){
			if($user_code == decrypt($value->user_code)){
			    $get_user = $this->Common_model->getAllData('user_masters', '', 1, ['user_name'=>$value->user_name]);
				$user_name = $get_user->user_name;
				$password_change = $value->password_change;  //CR by Suhrid Sarkar || suhrid.developer@gmail.com on June 20, 2023
				break;
			}
		}
		if($user_name != ''){
			$result = array('user_name'=>$user_name, 'has_user'=> 1, 'status' => 'success', 'password_change' => $password_change);
		} else{
			$result = array('user_name'=>'', 'has_user'=> 0, 'status' => 'success', 'password_change' => $password_change);
		}


		# response
        $obj = (object) array_merge((array) $result, update_csrf_session());
        echo json_encode($obj);
	}

	#=====================================
    # Save
    #=====================================
    public function save()
    {
        # validate post data
        $this->form_validation->set_rules('user_code', 'User Code', 'trim|required');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
		$this->form_validation->set_rules('retype_password', 'Retype Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $msg = $this->form_validation->error_array();
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
            if (post('username') == 0) {
                #add
				// prx(post('username'));
            } else{
                #Edit
                if(post('new_password') != post('retype_password')){
					$array = array('status' => 'fail', 'error' => 'Password and Retype Password are not same.', 'message' => '');
				} else{
					
					$data = array(
						'user_password' 	=> hash('md5', post('new_password')),
						'updated_at'    	=> date('Y-m-d H:i:s'),
						'updated_by'    	=> $user_details->id
					);
	
					$save = $this->Common_model->UpdateDB('user_masters', ['user_name'=>post('username')], $data);
                    $updateuser = $this->Common_model->getAllData('user_masters', '', '', ['user_name'=>post('username')]);
                    $passwordHistory = array(
                        'user_id' 	=> $updateuser[0]->id,
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
        }
        # Response
		$array = array_merge($array,update_csrf_session());
        echo json_encode($array);
    }
}
?>
