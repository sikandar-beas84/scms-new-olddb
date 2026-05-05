<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Helper For print_r
function prx($var = '')
{
	echo "<pre>";
	print_r($var);
	echo "</pre>";
	die();
}

// Helper For print_r
function pr($var = '')
{
	echo "<pre>";
	print_r($var);
	echo "</pre>";
	// die();	
}

//Helper For base_url()
function bs($value = '')
{
	// public $url = ""
	echo base_url($value);
}

//Helper for $this->load->view()
function view($value = '', $data = array(), $output = false)
{
	$CI = &get_instance();
	$CI->load->view($value, $data, $output);
}

//Helper For thsi->input->post()
function post($value = '')
{
	$CI = &get_instance();
	return $CI->input->post($value);
}
//Helper For thsi->input->get()
function get($value = '')
{
	$CI = &get_instance();
	return $CI->input->get($value);
}

//Helper for encrypt data
//Added by Suhrid Sarkar || suhrid.developer@gmail.com on Febuary 16
function encrypt($value)
{
	$CI = &get_instance();
	return $CI->encryption->encrypt($value);
}

//Helper for decrypt data
//Added by Suhrid Sarkar || suhrid.developer@gmail.com on Febuary 16
function decrypt($value)
{
	$CI = &get_instance();
	return $CI->encryption->decrypt($value);
} 

//helper for var_dump
function dd($value = '')
{
	echo "<pre>";
	var_dump($value);
	echo "</pre>";
	die();
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on Febuary 21, 2023
//For getting the IP
function get_client_ip()
{
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	} else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_FORWARDED'])) {
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	} else if (isset($_SERVER['REMOTE_ADDR'])) {
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	} else {
		$ipaddress = 'UNKNOWN';
	}

	return $ipaddress;
}

//Added b Suhrid Sarkar || suhrid.developer@gmail.com on March 15, 2023
//For checking the permission of Group
function hasGroupPrivilege($user_id, $perm = ''){
	$CI = &get_instance();
	$group_details = $CI->Common_model->getAllData('groups', '', 1, ['group_name'=> $perm]);
	$user_details = $CI->LoginModel->get_user_data('user_masters', $user_id);
	$group_permission = $CI->Common_model->getAllData('user_action_permission', '', '', ['user_id'=> $user_details->id, 'group_id'=>$group_details->id, 'has_perm'=>'Y']);
	
	if(count($group_permission) > 0){
		return TRUE;
	}else{
		return FALSE;
	}
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on April 04, 2023
//For get the action permission
function hasGroupActionPrivilege($user_id='', $perm = '', $action=''){
	$CI = &get_instance();
	$group_details = $CI->Common_model->getAllData('groups', '', 1, ['group_name'=> $perm]);
	$user_details = $CI->LoginModel->get_user_data('user_masters', $user_id);
	$group_permission = $CI->Common_model->getAllData(
		'user_action_permission', 
		'', 
		'', 
		[
			'user_id'=> $user_details->id, 
			'group_id'=>$group_details->id, 
			'sub_group_id'=> 0,
			'has_perm'=>'Y',
			'show_on_menu' => '1'
		]
	);
	if(count($group_permission) > 0){
		$permission_action = $CI->Common_model->getAllData(
			'user_action_permission_action', 
			'', 
			'', 
			[
				'user_action_permission_id'=>$group_permission[0]->id, 
				'action_name'=>$action
			]
		);
		if(count($permission_action) > 0){
			if($permission_action[0]->has_perm == 'Y'){
				return TRUE;
			} else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}else{
		return FALSE;
	}
}

//Added b Suhrid Sarkar || suhrid.developer@gmail.com on March 15, 2023
//For checking the permission of Sub Group
function hasSubGroupPrivilege($user_id, $perm = ''){
	$CI = &get_instance();
	$sub_group_details = $CI->Common_model->getAllData('sub_groups', '', 1, ['sub_group_name'=> $perm]);
	$group_details = $CI->Common_model->getAllData('groups', '', 1, ['id'=> $sub_group_details->group_id]);
	$user_details = $CI->LoginModel->get_user_data('user_masters', $user_id);
	$group_permission = $CI->Common_model->getAllData(
		'user_action_permission', 
		'', 
		'', 
		[
			'user_id'=> $user_details->id, 
			'group_id'=>$group_details->id, 
			'sub_group_id'=> $sub_group_details->id,
			'has_perm'=>'Y',
			'show_on_menu' => '1'
		]
	);
	if(count($group_permission) > 0){
		return TRUE;
	}else{
		return FALSE;
	}
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on MArch 15, 2023
//For get the action permission
function hasSubGroupActionPrivilege($user_id='', $perm = '', $action=''){
	$CI = &get_instance();
	$sub_group_details = $CI->Common_model->getAllData('sub_groups', '', 1, ['sub_group_name'=> $perm]);
	$group_details = $CI->Common_model->getAllData('groups', '', 1, ['id'=> $sub_group_details->group_id]);
	$user_details = $CI->LoginModel->get_user_data('user_masters', $user_id);
	$group_permission = $CI->Common_model->getAllData(
		'user_action_permission', 
		'', 
		'', 
		[
			'user_id'=> $user_details->id, 
			'group_id'=>$group_details->id, 
			'sub_group_id'=> $sub_group_details->id,
			'has_perm'=>'Y',
			'show_on_menu' => '1'
		]
	);
	
	if(count($group_permission) > 0){
		$permission_action = $CI->Common_model->getAllData(
			'user_action_permission_action', 
			'', 
			'', 
			[
				'user_action_permission_id'=>$group_permission[0]->id, 
				'action_name'=>$action
			]
		);
		
		if(count($permission_action) > 0){
			if($permission_action[0]->has_perm == 'Y'){
				return TRUE;
			} else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}else{
		return FALSE;
	}
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 13, 2023
//For get the in between text from a perticular string
function get_string_between($string, $start, $end){
	$string = ' ' . $string;
	$ini = strpos($string, $start);
	if ($ini == 0)
	return '';
	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on September 07, 2023
//For slug the text
function slugify($text) {
    // Replace non-alphanumeric characters with dashes
    $text = preg_replace('~[^\pL\d]+~u', '_', $text);

    // Transliterate characters to ASCII
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // Remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // Convert to lowercase
    $text = strtolower($text);

    // Remove leading and trailing dashes
    $text = trim($text, '_');

    return $text;
}


function is_multi_dimensional_array($array) {
    if (is_array($array)) {
        foreach ($array as $element) {
            if (is_array($element)) {
                return true; // If any element is an array, it's multidimensional
            }
        }
    }
    return false; // If no element is an array, it's not multidimensional
}

if (!function_exists('jd')) {
    function jd($json) {
       

        return json_decode($json);
    }
}
if (!function_exists('je')) {
    function je($array) {
       

        return json_encode($array);
    }
}
if (!function_exists('generate_id')) {
    function generate_id($table) {
        // Get the CodeIgniter instance
        $CI =& get_instance();

        // Load the database
        $CI->load->database();

        // Fetch the last ID from the 'students_details' table
        $CI->db->select_max('id');
        $query = $CI->db->get($table);
        $result = $query->row();
        $last_id = $result->id;

        // Increment the ID by one
        $new_id = $last_id + 1;

        // Format the new student_id

        return $new_id;
    }
}

function current_session()
    {
        $CI =& get_instance(); // Get the CodeIgniter instance
        $CI->load->database(); // Load the database library

        $CI->db->select('*');
        $CI->db->from('session');
        $CI->db->where('CURDATE() BETWEEN start_date AND end_date', null, false); // Disable query escaping for raw SQL
        $query = $CI->db->get();

        return $query->result_array(); // Fetch all results as an array
    }
    
    function convertNumberToWords($number) {
    $hyphen = '-';
    $conjunction = ' and ';
    $separator = ', ';
    $negative = 'negative ';
    $decimal = ' point ';
    $dictionary = [
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'forty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
        100 => 'hundred',
        1000 => 'thousand',
        1000000 => 'million',
        1000000000 => 'billion',
        1000000000000 => 'trillion',
        1000000000000000 => 'quadrillion',
        1000000000000000000 => 'quintillion'
    ];

    if (!is_numeric($number)) {
        return false;
    }

    if ($number < 0) {
        return $negative . convertNumberToWords(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[(int) $hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convertNumberToWords($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convertNumberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convertNumberToWords($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = [];
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

?>
