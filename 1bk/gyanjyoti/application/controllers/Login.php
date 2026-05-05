<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Name: Login Controller
	Author: Suhrid Sarkar || suhrid.developer@gmail.com
	Created ON: Febuary 13, 2023
*/
class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
		date_default_timezone_set('Asia/Kolkata');
    }

    public function index()
	{
	   // prx(current_session()[0]['id']);
        if(!empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }
		$data['session_year'] = $this->Common_model->relational_dropdown(
			'session',
			'id',
			'start_year, end_year',
			['status' => 'Y', 'is_delete !='=> 'Y'],
			' - '
		);
        $data['page_title'] = 'Login';
        $this->load->view('include/login_head', $data);
        $this->load->view('include/head', $data);
		$this->load->view('login_form');
        $this->load->view('include/login_end');
        $this->load->view('include/end');
	}

    public function login_check(){
// 		prx('fsd');
        if(post('session')){
		if(!empty(post('_token'))){
			redirect(base_url('login/welcome'));
		} else{
			$password = hash('md5', post('password'));
			// $user_type = post('user_type');
			$data = array(
				// 'user_type'     	=> post('user_type'),
				'username'     	=> post('username'),
				'user_password'  	=> $password
			);
			$user_details = $this->LoginModel->login_check_admin($data);
			// echo $this->db->last_query(); 
			if($user_details){
				$user_type =  $user_details->user_type;
			}
			if(empty($user_details)){
				$user_details = $this->LoginModel->login_check_staff($data);
				if($user_details){
					$user_type =  $user_details->role_type;
				}
			}
			if(empty($user_details)){
				$user_details = $this->LoginModel->login_check_students($data);
				if($user_details){
					$user_type =  'students';
				}
			}
			// echo $this->db->last_query();
			if(!empty($user_details)){
				// $user_details = $this->LoginModel->get_user_data('user_masters', post('username'));
				//Checking Multi device
				// $device = $this->Common_model->getAllData('user_login_histories', '', '', ['user_id'=>$user_details->id, 'user_logout_time'=> 'IS NULL']);
				// if(count($device) > 0){
				// 	echo 3;
				// }

				
				

				if(strpos($_SERVER['HTTP_REFERER'], 'https') === 0){
					// HTTPS referer detected
					$PublicIP = get_client_ip();
					$json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
					$json     = json_decode($json, true);
					$city     = $json['city'];
					$user_ip  = $json['ip'];
					$postal   = $json['postal'];
				} else {
					// HTTP referer detected or no referer
					$getloc   = json_decode(file_get_contents("http://ipinfo.io/"));
					$city     = $getloc->city;
					$user_ip  = $getloc->ip;
					$postal   = $getloc->postal;
				}
				

				$data = array(
					'user_id'			=> $user_details->id,
					'login_location'	=> $city,
					'login_postal_code'	=> $postal,
					'ip_address'		=> $user_ip,
					'user_login_time'	=> date('Y-m-d H:i:s'),
					'is_active'			=> 'Y',
					'created_at' 		=> date('Y-m-d H:i:s'),
                    'created_by' 		=> $user_details->id
				);
				$user_login_history_id = $this->Common_model->add_get_lstId('user_login_histories', $data);
		    	if($user_type == 'students'){
					$students_details = $this->Common_model->getAllData('students_details', '', '', ['student_table_id'=>$user_details->id]);
					$user_id = $students_details[0]->id;
			
				}else{
				    $user_id = $user_details->id;
				}
				$session_data = array(
					'session'   				=> post('session'),
					'user_id'   				=> $user_id,
					'user_login_history_id'		=> $user_login_history_id,
					'last_activity'				=> time(),
					'user_type'   				=> $user_type,
				);
			
				// prx($session_data);
				$this->session->set_userdata($session_data);
				echo 1;
			} else{
				echo 3;
			}
		}
        }else{
            echo 4;
        }
        
    }

	public function singup_check(){
				// 		 # validate post data
				$this->form_validation->set_rules('user_first_name', 'First Name', 'trim|required');
				$this->form_validation->set_rules('user_last_name', 'Last Name ', 'trim|required');
				$this->form_validation->set_rules('signup_email', 'Email ', 'trim|required');
				$this->form_validation->set_rules('username', 'User Name ', 'trim|required');
				$this->form_validation->set_rules('user_password', 'Password ', 'trim|required');
				$this->form_validation->set_rules('confirm_password', 'Confirm Password ', 'trim|required');
				
				if ($this->form_validation->run() == FALSE) {
					$msg = $this->form_validation->error_array();
					$array = array('status' => 'fail', 'error' => $msg, 'message' => '');
				} else {
					if(post('user_password') == post('confirm_password')){
						#add
						$data = array(
							'user_first_name' 		=> encrypt(post('user_first_name')),
							'user_last_name' 		=> encrypt(post('user_last_name')),
							'user_name' 		=> post('username'),
							'user_password' 		=> hash('md5',post('user_password')),
							'user_type' 		=> 'User',
							'otp_email_id' 		=> post('signup_email'),
							'is_active'			=> 'Y',
							'created_at' 		=> date('Y-m-d H:i:s'),
							'created_by' 		=> 0
						);
						$save = $this->Common_model->add('user_masters', $data);
					}else{
						$array = array('status' => 'fail', 'error' => 'Password and confirm password do not match', 'message' => '');
					}

					if ($save) {
						$array = array('status' => 'success', 'error' => '', 'message' => 'success_message');
					} else {
						$array = array('status' => 'fail', 'error' => 'error_message', 'message' => '');
					}
				}
				# Response
				$array = array_merge($array,update_csrf_session());
				echo json_encode($array);
			}
		

    public function logout($login_history_id){
		$data = array(
			'user_logout_time'	=> date('Y-m-d H:i:s'),
			'updated_at' 		=> date('Y-m-d H:i:s')
		);
		$this->Common_model->UpdateDB('user_login_histories', ['id' => $login_history_id], $data);
        $this->session->sess_destroy();  
        redirect(base_url());
    }
    
    
    
	// Added By Suhrid Sarka 06-06-2023
    // public function lock_screen(){
	// 	if(screen_lock() == "1"){
	// 		$data['page_title'] = 'Screen Lock';
	// 		$this->load->view('screen_lock');
	// 	}else{
	// 		redirect("dashboard");
	// 	}
    // }

	// Added By Suhrid Sarka 06-06-2023
	public function update_screen_lock(){
		$data['page_title'] = 'Update Screen Lock';	
		$password = hash('md5', post('password'));
		$data = array(
			'user_name'		 	=> $this->session->userdata('user_id'),
			'user_password'  	=> $password
		);
		$num = $this->LoginModel->login_check('user_masters', $data);
		if($num > 0){
			$session_data = array(
				'user_id'   				=> $this->session->userdata('user_id'),
				'user_login_history_id'		=> $this->session->userdata('user_login_history_id'),
				'last_activity'		=> time()
			);

			
			$this->session->set_userdata($session_data);
			$array = array('status' => 'success', 'error' => '', 'message' => 'success_message');
			
		}else{
			$array = array('status' => 'fail', 'error' => 'Password does not match', 'message' => '');
		}

		# Response
		$array = array_merge($array,update_csrf_session());
		echo json_encode($array);
    }
    
    
    
    public function forgot_password() {
    $this->load->library('form_validation');
    $this->load->library('email');
    
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    
    if ($this->form_validation->run() == FALSE) {
        $response = array('status' => 'error', 'message' => validation_errors());
    } else {
        $email = $this->input->post('email');
        
        // Check email in all tables
        $student = $this->db->get_where('students', array('email' => $email))->row();
        $staff = $this->db->get_where('staff', array('email' => $email))->row();
        $user_master = $this->db->get_where('user_masters', array('email' => $email))->row();
        
        // Determine which table the user belongs to
        $user_type = '';
        $user_table = '';
        $user_data = null;
        
        if ($student) {
            $user_type = 'student';
            $user_table = 'students';
            $user_data = $student;
        } elseif ($staff) {
            $user_type = 'staff';
            $user_table = 'staff';
            $user_data = $staff;
        } elseif ($user_master) {
            $user_type = 'admin';
            $user_table = 'user_masters';
            $user_data = $user_master;
        }
        
        if ($user_data) {
            // Generate reset token
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Save token in database
            $this->db->where('email', $email);
            $this->db->update($user_table, array(
                'reset_token' => $token,
                'reset_expires' => $expires
            ));
            
            // Configure email settings
            $config = array(
                'protocol'  => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => 465,
                'smtp_user' => 'your-email@gmail.com', // Replace with your email
                'smtp_pass' => 'your-app-password', // Replace with your app password
                'mailtype'  => 'html',
                'charset'   => 'utf-8',
                'newline'   => "\r\n"
            );
            
            $this->email->initialize($config);
            
            // Prepare email content
            $reset_link = base_url("login/reset_password/{$token}/{$user_type}");
            $email_template = $this->load->view('email/reset_password', array(
                'user_name' => $user_data->name ?? $user_data->first_name ?? 'User',
                'reset_link' => $reset_link,
                'expires' => date('F j, Y, g:i a', strtotime($expires))
            ), true);
            
            // Send email
            $this->email->from('susimsarkar111@gmail.com', 'GPS');
            $this->email->to($email);
            $this->email->subject('Password Reset Request - GPS');
            $this->email->message($email_template);
            // print_r($this->email->send());
            if ($this->email->send()) {
                $response = array(
                    'status' => 'success', 
                    'message' => 'Password reset instructions have been sent to your email. Please check your inbox.'
                );
            } else {
                log_message('error', 'Email sending failed: ' . $this->email->print_debugger());
                $response = array(
                    'status' => 'error', 
                    'message' => 'Failed to send reset email. Please try again or contact support.'
                );
            }
        } else {
            $response = array(
                'status' => 'error', 
                'message' => 'Email address not found in our records.'
            );
        }
    }
    
    echo json_encode($response);
}

// Add this method to handle password reset
public function reset_password($token, $user_type) {
    if (!$token || !$user_type) {
        redirect('login');
    }
    
    // Determine table based on user type
    $table = '';
    switch ($user_type) {
        case 'student':
            $table = 'students';
            break;
        case 'staff':
            $table = 'staff';
            break;
        case 'admin':
            $table = 'user_masters';
            break;
        default:
            redirect('login');
    }
    
    // Check token validity
    $user = $this->db->get_where($table, array(
        'reset_token' => $token,
        'reset_expires >=' => date('Y-m-d H:i:s')
    ))->row();
    
    if (!$user) {
        $this->session->set_flashdata('error', 'Invalid or expired reset link. Please request a new password reset.');
        redirect('login');
    }
    
    if ($_POST) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        
        if ($this->form_validation->run() == TRUE) {
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            
            $this->db->where('email', $user->email);
            $this->db->update($table, array(
                'password' => $password,
                'reset_token' => null,
                'reset_expires' => null
            ));
            
            $this->session->set_flashdata('success', 'Your password has been reset successfully. Please login with your new password.');
            redirect('login');
        }
    }
    
    $this->load->view('reset_password', array('token' => $token, 'user_type' => $user_type));
}


}
?>
