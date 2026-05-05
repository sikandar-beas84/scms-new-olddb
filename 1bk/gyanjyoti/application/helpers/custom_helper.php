<?php

/*

	Custome helper
	Author: Suhrid Sarkar || suhrid.developer@gmail.com
	On: Febuary 14, 2023

    Employee Name     |   Version     |   Date Range      |   CR ID       |   Propose
	Suhrid Sarkar || suhrid.developer@gmail.com				1.0			  Febuary 15, 2023	    1			Add New Method to get the user role
	Suhrid Sarkar || suhrid.developer@gmail.com				1.0			  Febuary 20, 2023	    1			Add New Method to update the CSRF Token
    
*/

defined('BASEPATH') or exit('No direct script access allowed');

/* 
	* Single and MULTIPLE FILE upload by Suhrid Sarkar || suhrid.developer@gmail.com
*/
/*
	* Single and MULTIPLE FILE upload by Suhrid Sarkar || suhrid.developer@gmail.com
*/
if (!function_exists('multiUpload')) {
	function multiUpload($file_name = "", $uploadPath = "", $alow_types = "", $flag = "multi", $upload_name = '')
	{
		$CI = &get_instance();

		$files = [];
		$config["upload_path"] = './' . $uploadPath;
		$config["allowed_types"] = $alow_types;
		
		// Check if the directory exists, if not, create it
		if (!is_dir($config["upload_path"])) {
			mkdir($config["upload_path"], 0755, true);
		}

		$CI->load->library('upload', $config);
		$CI->upload->initialize($config);

		
        if ($flag == "multi") {
            for ($count = 0; $count < count($_FILES[$file_name]["name"]); $count++) {
                $_FILES["file"]["name"] = $upload_name == "" ? $_FILES[$file_name]["name"][$count] : $upload_name . "_" . $count . "." . pathinfo($_FILES[$file_name]["name"][$count], PATHINFO_EXTENSION);
                $_FILES["file"]["type"] = $_FILES[$file_name]["type"][$count];
                $_FILES["file"]["tmp_name"] = $_FILES[$file_name]["tmp_name"][$count];
                $_FILES["file"]["error"] = $_FILES[$file_name]["error"][$count];
                $_FILES["file"]["size"] = $_FILES[$file_name]["size"][$count];

                if ($CI->upload->do_upload('file')) {
                    $data = $CI->upload->data();
                    $result['file'][] = $data["file_name"];
                } else {
                    $result['error'] = $CI->upload->display_errors();
                    break;
                }
            }
        } else {
            $_FILES["file"]["name"] = $upload_name == "" ? $_FILES[$file_name]["name"] : $upload_name . "." . pathinfo($_FILES[$file_name]["name"], PATHINFO_EXTENSION);
            $_FILES["file"]["type"] = $_FILES[$file_name]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES[$file_name]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES[$file_name]["error"];
            $_FILES["file"]["size"] = $_FILES[$file_name]["size"];

            if ($CI->upload->do_upload('file')) {
                $data = $CI->upload->data();
                $result['file'][] = $data["file_name"];
            } else {
                $result['error'] = $CI->upload->display_errors();
            }
        }

        return $result;
    }
}


if (!function_exists('getUserRole')) {
	function getUserRole($role_id = 0){
		if($role_id != 0){
			$CI = &get_instance();
			$user_role = $CI->db->query("SELECT `role` FROM user_roles WHERE id=".$role_id)->row();
			return $user_role->role;
		} else{
			return 0;
		}
	}
}

//helper for Update csrf
//Added by Suhrid Sarkar || suhrid.developer@gmail.com on Febuary 20, 2023
function update_csrf_session()
{
	$CI = &get_instance();
	$csrf = array(
		'csrfName' => $CI->security->get_csrf_token_name(),
		'csrfHash' => $CI->security->get_csrf_hash()
	);
	return $csrf;
}


//helper for Auto Logout
//Added by Suhrid Sarkar 05-06-2023
function check_login_time()
{
    $CI = &get_instance();
	$user_details = $CI->LoginModel->get_user_data('user_masters', $CI->session->userdata('user_id'));
    // Check if user is logged in
	if ($CI->session->userdata('user_id')) {
        $last_activity = $CI->session->userdata('last_activity');

        // Check if the user's last activity time is older than 15 minutes
        if (time() - $last_activity > $user_details->auto_logout_after_second) { // 60 seconds = 1 minutes
            // Destroy the session and log the user out
            $CI->session->sess_destroy();
            redirect('login'); // Replace 'login' with your logout URL
        } else {
            // Update the user's last activity time
            $CI->session->set_userdata('last_activity', time());
        }
	}
}
//helper for Auto Screen Lock
function screen_lock()
{
    $CI = &get_instance();
	$user_details = $CI->LoginModel->get_user_data('user_masters', $CI->session->userdata('user_id'));
	// echo $user_details->screen_lock_after_second;
    // Check if user is logged in
    if ($CI->session->userdata('user_id')) {
        $last_activity = $CI->session->userdata('last_activity');

        // Check if the user's last activity time is older than 15 minutes
        if (time() - $last_activity > $user_details->screen_lock_after_second) { // 900 seconds = 15 minutes
            // Destroy the session and log the user out
            return "1";
        }else{
			$CI->session->set_userdata('last_activity', time());
			return "0";
		}
    }
}


// function check_last_active_time(){		
// 	#=====================================
// 	# Added By Suhrid Sarkar on 06-06-2023
// 	# Check Auto Logout
// 	#=====================================
// 	$CI = &get_instance();
// 	$user_details = $CI->LoginModel->get_user_data('user_masters', $CI->session->userdata('user_id'));
// 	if($user_details->auto_logout == 'Y'){
// 		check_login_time();
// 	}
	
// 	#=====================================
// 	# Check Auto Screen Lock
// 	#=====================================
// 	if($user_details->screen_lock == 'Y'){
// 		if(screen_lock() == '1'){
// 			redirect("lock_screen");
// 		}
// 	}
// 	// End

// }


function getUserType(){
	$CI = &get_instance();
	if($CI->session->userdata('user_type') == 'admin'){
		$show_field = 'admin';
	}elseif($CI->session->userdata('user_type') == 'super_admin'){
		$show_field = 'super_admin';
	}elseif($CI->session->userdata('user_type') == 'staff'){
		$show_field = 'staff';
	}else{
		$show_field = 'student';
	}
	return $show_field;
}


function getUserData() {
    $CI = &get_instance();
    $CI->load->database();

    // Check if the user is logged in and has a user type
    if (empty($CI->session->userdata('user_id'))) {
        return null; // Handle not logged in appropriately
    }

    // Determine the table based on the user type
    $user_id = $CI->session->userdata('user_id');
    $user_type = $CI->session->userdata('user_type');

    if (  $user_type == 'super_admin') {
        $table_name = 'user_masters';
        $CI->db->where('id', $user_id); // Adjust column name if needed
    } elseif ($user_type == 'staff' || $user_type == 'admin') {
        $table_name = 'staff';
        $CI->db->where('id', $user_id);
    } else {
        $table_name = 'students_details';
        $CI->db->where('id', $user_id);
    }

    // Query the database to get user data
    $query = $CI->db->get($table_name);

    // Check if the query has results
    if ($query->num_rows() > 0) {
        return $query->row();
    }

    // Return null if no data is found
    return null;
}

function get_session($key = 'session'){
	$CI = &get_instance();
	$data = $CI->session->userdata($key);
	return $data;
}


?>
