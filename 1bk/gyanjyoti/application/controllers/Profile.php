<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Profile extends CI_Controller
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
        $user_details = getUserData();
        // echo "<pre>"; print_r($user_details); exit;
        $data['page_title'] = 'User Profile';
        $data['user_details'] = $user_details;
		// $data['bank_details'] = $this->Common_model->getAllData('branch_masters', '', 1, ['id' => $user_details->user_branch]);
        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
		$this->load->view('user_profile/user_profile');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
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
             $user_details =  getUserData();;
             #Edit
             
             if(post('new_password') != post('retype_password')){
                 $array = array('status' => 'fail', 'error' => 'Password and Retype Password are not same.', 'message' => '');
             } else if($user_details->password != md5(post('current_password'))){
                 $array = array('status' => 'fail', 'error' => 'Current Password does not match.', 'message' => '');
             } else{
                 
                 $data = array(
                     'password' 	=> md5(post('new_password')),
                     'updated_at'    	=> date('Y-m-d H:i:s'),
                     'updated_by'    	=> $user_details->id
                 );
                 $user = $this->session->userdata('user_id');
 
                 $userType = getUserType();
                if(get_session('user_type') == 'super_admin'){ 
                    $save = $this->Common_model->UpdateDB('user_masters', ['id'=>$user], $data);
                }elseif($userType == 'staff' || $userType == 'admin'  ){
                    $save = $this->Common_model->UpdateDB('staff', ['id'=>$user], $data);
                }else{
                    $save = $this->Common_model->UpdateDB('students', ['id'=>$user], $data);
                }
 
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


	#=====================================
    # Save
    #=====================================
    public function save_profile_data()
    {
        if(get_session('user_type') == 'staff' || get_session('user_type') == 'admin' || get_session('user_type') == 'super_admin'){
         # validate post data
         $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
         $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
         $this->form_validation->set_rules('email', ' Email', 'trim|required');
         $this->form_validation->set_rules('mobile', 'mobile', 'trim|required');
         if ($this->form_validation->run() == FALSE) {
            $msg = $this->form_validation->error_array();
            // prx($msg);
            $msgUl = '<ul>';
            foreach($msg as $m){
                $msgUl .= '<li>' . $m . '</li>';
            }
            $msgUl .= '</ul>'; // Corrected line to append the closing tag
            
            $array = array('status' => 'error', 'error' => '', 'message' => $msgUl);

         } else {
                $user_details = getUserData();             #Edit
                 
    
                $filetype = array('jpeg','jpg','png','PNG','JPEG','JPG');
                if($_FILES['image']['name'] != ''){
               
    
    
                      
                            $upload_files = multiUpload('image', 'assets/uploads/staff/', $filetype, "single", '');
                            // prx($upload_files['file']);
    
                            $data = array(
                                'first_name' 	=> (post('first_name')),
                                'last_name' 	=> (post('last_name')),
                                'email' 	=> (post('email')),
                                'phone' 	=> (post('mobile')),
                                // 'otp_phone' 	    => 'N',
                                // 'otp_email' 	    => 'N',
                                'image' 	    => je($upload_files['file']),
                                'updated_at'    	=> date('Y-m-d H:i:s'),
                                'updated_by'    	=> $user_details->id
                            );
                            $user = $this->session->userdata('user_id');
                            $userType = getUserType();
                            if($userType == 'super_admin'){ 
                                $save = $this->Common_model->UpdateDB('user_masters', ['id'=>$user], $data);
                            }elseif($userType == 'staff' || get_session('user_type') == 'admin'){
                                $save = $this->Common_model->UpdateDB('staff', ['id'=>$user], $data);
                            }else{
                                $save = $this->Common_model->UpdateDB('students', ['id'=>$user], $data);
                            }
                            
                            if ($save) {
                                $array = array('status' => 'success', 'error' => '', 'message' => 'success_message');
                            } else {
                                $array = array('status' => 'fail', 'error' => 'error_message', 'message' => '');
                            }
                       
                        // echo  $this->db->last_query(); exit;
                    
                    }else{
                     $data = array(
                         'first_name' 	=> (post('first_name')),
                         'last_name' 	=> (post('last_name')),
                         'email' 	=> (post('email')),
                         'phone' 	=> (post('mobile')),
                        //  'otp_phone' 	    => 'N',
                        //  'otp_email' 	    => 'N',
                         'updated_at'    	=> date('Y-m-d H:i:s'),
                         'updated_by'    	=> $user_details->id
                     );
                     $user = $this->session->userdata('user_id');
                     $userType = getUserType();
                    if($userType == 'super_admin'){ 
                        $save = $this->Common_model->UpdateDB('user_masters', ['id'=>$user], $data);
                    }elseif($userType == 'staff' || $userType == 'admin'){
                        $save = $this->Common_model->UpdateDB('staff', ['id'=>$user], $data);
                    }else{
                        $save = $this->Common_model->UpdateDB('students', ['id'=>$user], $data);
                    }
                     
                     if ($save) {
                         $array = array('status' => 'success', 'error' => '', 'message' => 'success_message');
                     } else {
                         $array = array('status' => 'fail', 'error' => 'error_message', 'message' => '');
                     }
                    }
             }
        }else{
            # validate post data
         $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
         $this->form_validation->set_rules('email', ' Email', 'trim|required');
         $this->form_validation->set_rules('mobile', 'mobile', 'trim|required');
         if ($this->form_validation->run() == FALSE) {
             $msg = $this->form_validation->error_array();
             $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
         } else {
                $user_details = getUserData();             #Edit
                 
    
                $filetype = array('jpeg','jpg','png','PNG','JPEG','JPG');
                if($_FILES['image']['name'] != ''){
               
    
    
                      
                            // $upload_files = multiUpload('image', 'assets/uploads/student/', $filetype, "single", '');
                            
                            $filetype = array('jpeg', 'jpg', 'png', 'pdf'); // Allowed file types
                                $uploadResult = (multiUpload($field, 'assets/uploads/student/', $filetype, 'single', ''));
                            //    pr();
                                // $formData[$field] = json_encode($uploadResult['file']);
    
                            $data = array(
                                'student_name' 	=> (post('first_name')),
                                'email_id' 	=> (post('email')),
                                'father_mobile_no' 	=> (post('mobile')),
                                'student_photo' 	    => json_encode($uploadResult['file']),
                                'updated_at'    	=> date('Y-m-d H:i:s'),
                            );
                            $user = $this->session->userdata('user_id');
                            
                            $save = $this->Common_model->UpdateDB('students_details', ['id'=>$user_details->id], $data);

                            if ($save) {
                                $array = array('status' => 'success', 'error' => '', 'message' => 'success_message');
                            } else {
                                $array = array('status' => 'fail', 'error' => 'error_message', 'message' => '');
                            }
                       
                        
                    
                    }else{
                     $data = array(
                            'student_name' 	=> (post('first_name')),
                            'email_id' 	=> (post('email')),
                            'father_mobile_no' 	=> (post('mobile')),
                            'updated_at'    	=> date('Y-m-d H:i:s'),
                        );
                     $user = $this->session->userdata('user_id');
                     $userType = getUserType();
                     $save = $this->Common_model->UpdateDB('students_details', ['id'=>$user_details->id], $data);
                     
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
    #=====================================
    # Delete photo
    #=====================================
    public function deletephoto(){
        $id = post('id');
        $save = $this->Common_model->UpdateDB('user_masters', ['id' => $id], ['user_image' => '']);
        if ($save) {
            $array = array('status' => 'success', 'error' => '', 'message' => 'success_message');
        } else {
            $array = array('status' => 'fail', 'error' => 'error_message', 'message' => '');
        }
        # Response
		$array = array_merge($array,update_csrf_session());
        echo json_encode($array);
    }

}
?>