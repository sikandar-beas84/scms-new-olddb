<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

	public function ajax_student_list($classId='',$sectionId=''){
		$session_year_id = get_session('session');
		$this->db->select('*');
		$this->db->from('students_details');
		$this->db->where('students_details.class',$classId);
		if(!empty($sectionId)){
		$this->db->where('students_details.section',$sectionId);
		}
		$this->db->where('students_details.application_status','student');
		$this->db->where('students_details.session_id',$session_year_id);
		$this->db->where('students_details.status','Y');
		$this->db->where('students_details.is_delete','N');
		$this->db->order_by('students_details.admission_form_no','asc');
		$result	= $this->db->get();
		$result	= $result->result(); 		
		return $result;
	}
	public function get_students_details($id){
		$session_year_id = get_session('session');
		$this->db->select('*');		
		$this->db->from('students_details');		
		$this->db->where('students_details.session_id', $session_year_id);
		$this->db->where('students_details.id', $id);
		$query = $this->db->get();
		return $query->row();		
	}
	public function get_students_details_by_code($id=''){
		$session_year_id = get_session('session');
		$this->db->select('*');		
		$this->db->from('students_details');		
		$this->db->where('students_details.session_id', $session_year_id);
		$this->db->where('students_details.student_code', $id);
		$query = $this->db->get();
		return $query->row();		
	}
	public function get_students_full_details_by_code($id=''){
		$session_year_id = get_session('session');
		$this->db->select('*');		
		$this->db->select('students_details.*,class.*,section.section as section_name,students_details.id as s_id,students_details.student_id as s_code');
        $this->db->from('students_details');
	    $this->db->join('class', 'class.id = students_details.class','left');
	    $this->db->join('section', 'section.id = students_details.section','left');
		$this->db->where('students_details.session_id',$session_year_id);
		$this->db->where('students_details.student_code', $id);
		$query = $this->db->get();
		return $query->row();		
	}
	public function promoted_student_list($class_id,$section_id){
		$session_year_id = get_session('session');
		$this->db->select('students_details.*,class.*,section.section as section_name,students_details.id as s_id,students_details.student_id as s_code');
        $this->db->from('students_details');
	    $this->db->join('class', 'class.id = students_details.class','left');
	    $this->db->join('section', 'section.id = students_details.section','left');
		$this->db->where('students_details.class',$class_id);
		$this->db->where('students_details.section',$section_id);
		$this->db->where('students_details.application_status','student');
		$this->db->where('students_details.session_id',$session_year_id);
		$this->db->where('students_details.status','Y');
		$this->db->where('students_details.is_delete','N');
		$this->db->order_by('students_details.admission_form_no','asc');
		$result	= $this->db->get();
		$result	= $result->result();
		return $result;
    }
	public function allot_student_roll($id,$roll){
		$session_year_id = get_session('session');
		$this->db->set('roll', $roll);		
		$this->db->where('id', $id);		
		$this->db->where('session_id', $session_year_id);
		$result = $this->db->update('students_details'); 

		$this->db->set('roll', $roll);		
		$this->db->where('student', $id);		
		$this->db->where('session_id', $session_year_id);
		$result = $this->db->update('session_wish_student_data'); 
		return $result;	
	}
	public function re_admission_student($class_id,$section_id='', $studentId = ''){
		$session_year_id = get_session('session');
		$this->db->select('session_wish_student_data.*, students_details.*,class.*,students_details.id as s_id,students_details.student_id as s_code,  section.section as section_name');
        $this->db->from('session_wish_student_data');
		$this->db->join('students_details', 'students_details.id = session_wish_student_data.student','left');
	    $this->db->join('class', 'class.id = students_details.class','left');
		$this->db->join('section', 'section.id = students_details.section','left');
		$this->db->where('students_details.class', $class_id);
		if($section_id){
			$this->db->where('students_details.section', $section_id);
		}
		if($studentId){
			$this->db->where('students_details.student_code', $studentId);
		}
		$this->db->where('students_details.application_status','student');
		$this->db->where('session_wish_student_data.session_id',$session_year_id);
		$this->db->where('students_details.session_id',$session_year_id);
		$this->db->where('students_details.status','Y');
		$this->db->where('students_details.is_delete','N');
		$this->db->order_by('students_details.admission_form_no','asc');
		$result	= $this->db->get();
		$result	= $result->result();
		return $result;
    }
	public function get_next_session_year(){
		$session_year_id = get_session('session');
		$this->db->select('*');
		$this->db->from('session');		
		$this->db->where('id >', $session_year_id);
		$this->db->limit(1);
		$result	= $this->db->get();
		$result = $result->row();
		return $result;
	}
	public function check_already_admission($code,$session_year_id){		
		$this->db->select('*');
	    $this->db->from('students_details');
		$this->db->where('student_id',$code);
		$this->db->where('session_id',$session_year_id);
	    $result	= $this->db->get();
		return $result->num_rows();
	}
	public function re_student_first_month_payment($code,$session_year_id){
		
		$this->db->select('ad_payment_status,student_fee_structure.id as fees_id,tuition_fee,bus_services');		
		$this->db->from('student_fee_structure');
		$this->db->where('student_code', $code);
		$this->db->where('session_year_id', $session_year_id);
		$this->db->limit(1);
		$this->db->order_by('id','ASC');
		$query = $this->db->get();
		return $query->row();
	}
	
	public function genareteFeesPaymentData($id, $class, $session = ''){
		if($session){
			$session_year_id = $session;
		}else{
			$session_year_id = get_session('session');
		}
		$this->db->select('*');
		$this->db->from('fees');
		$this->db->where('session_year', $session_year_id);
		$this->db->where('class', $class);
		$this->db->where('is_delete !=', 'Y');

		$query = $this->db->get();
		$fees = $query->result();
		// $fromDataApril = [
		// 	'session_year' => $session_year_id,
		// 	'student_id' => $id,
		// 	'class' => $class,
		// 	'month' => 4, 
		// 	'payment_status' => 'Y', 
		// 	'utr' => $utr,
		// 	'payment_type' => $payment_type,
		// 	'session_fees' => $fees[0]->session_fees,
		// 	'academic_fees' => $fees[0]->academic_fees,
		// 	'tuition_fees' => $fees[0]->tuition_fees,
		// 	'monthly_fees' => $fees[0]->monthly_fees,
		// 	'sports_fees' => $fees[0]->sports_fees,
		// 	'library_fees' => $fees[0]->library_fees,
		// 	'lab_fees' => $fees[0]->lab_fees,
		// 	'other_curriculum_fees' => $fees[0]->other_curriculum_fees,
		// 	'created_by' => get_session('user_id'),
		// 	'created_at' => date('Y-m-d H:i:s'),
		// ];

		// $this->db->insert('student_payment_details', $fromDataApril);

		for ($month = 5; $month <= 12; $month++) {
			$fromDataOtherMonths = [
				'session_year' => $session_year_id,
				'student_id' => $id,
				'class' => $class,
				'month' => $month, 
				'payment_status' => 'N', 
				'utr' => '',
				'payment_type' => '',
				'tuition_fees' => $fees[0]->tuition_fees,
				'monthly_fees' => 0,
				'other_curriculum_fees' => 0,
				'session_fees' => 0,
    			'academic_fees' => 0,
    // 			'sports_fees' => 0,
    // 			'library_fees' => 0,
    // 			'lab_fees' => 0,
				'created_by' => get_session('user_id'),
				'created_at' => date('Y-m-d H:i:s'),
			];
			// Insert the data for the other months
			$this->db->insert('student_payment_details', $fromDataOtherMonths);
		}
		for ($month = 1; $month <= 3; $month++) {
			$fromDataOtherMonths = [
				'session_year' => $session_year_id,
				'student_id' => $id,
				'class' => $class,
				'month' => $month, 
				'payment_status' => 'N', 
				'utr' => '',
				'payment_type' => '',
				'tuition_fees' => $fees[0]->tuition_fees,
				'monthly_fees' => 0,
				'other_curriculum_fees' => 0,
				'session_fees' => 0,
    			'academic_fees' => 0,
    // 			'sports_fees' => 0,
    // 			'library_fees' => 0,
    // 			'lab_fees' => 0,
				'created_by' => get_session('user_id'),
				'created_at' => date('Y-m-d H:i:s'),
			];
			// Insert the data for the other months
			$this->db->insert('student_payment_details', $fromDataOtherMonths);
		}
	}
	public function get_students_full_details($id){
		$session_year_id = get_session('session');
		$this->db->select('students_details.*, students_details.id as s_id, class.*, class.id as c_id, section.*, section.id as section_id, section.section as section_name, session.id as session_id, session.*');		
		$this->db->from('session_wish_student_data');	
		$this->db->join('students_details', 'students_details.id = session_wish_student_data.student','left');
	    $this->db->join('class', 'class.id = students_details.class','left');
		$this->db->join('section', 'section.id = students_details.section','left');	
		$this->db->join('session', 'session.id = students_details.session_id','left');	
		$this->db->where('session_wish_student_data.session_id', $session_year_id);
		$this->db->where('session_wish_student_data.student', $id);
		$query = $this->db->get();
		return $query->row();		
	}
	public function total_working_days($id){
		$session_year_id = get_session('session');
		$this->db->select('count(*)');
		$this->db->from('student_attendance');
		$this->db->where('student_id',$id);
		$this->db->where('session_year_id',$session_year_id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		//die;
		$result = $query->row_array();
		return $count = $result['count(*)'];
	}
	public function total_present_days($id){
		$session_year_id = get_session('session');
		$this->db->select('count(*)');
		$this->db->from('student_attendance');
		$this->db->where('student_id',$student_code);
		$this->db->where('attendance','P');
		$this->db->where('session_year_id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
		 return $count = $result['count(*)'];
	}
	function get_section_name_by_id($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$result	= $this->db->get('section');
		$result	= $result->result();
		return $result;
	}
	
	public function getStudentPaymentDetails($paymentId)
    {
        // Load the database if not already loaded
        $this->load->database();
    
        // Use Query Builder to perform the JOIN
        $this->db->select('students_details.*, student_payment_details.*');
        $this->db->from('student_payment_details');
        $this->db->join('students_details', 'student_payment_details.student_id = students_details.id');
        $this->db->where('student_payment_details.id', $paymentId);
    
        // Execute the query and return the result
        $query = $this->db->get();
        return $query->row_array(); // Return a single row as an associative array
    }
    
    public function get_grade($marks, $maxMarks) {
        $this->db->select('grade');
        $this->db->from('grade_symbol'); // Replace with your table name
        $this->db->where('start_marks <=', $marks);
        $this->db->where('end_marks >=', $marks);
        $this->db->where('max_marks', $maxMarks);
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->grade;
        } else {
            return 'N/A'; // Return N/A if no grade is found
        }
    }
    
    public function getStudentAprilMonthPaymentDetails($student_id)
    {
        $session_year_id = get_session('session');
        $this->db->select('*');
        $this->db->from('student_payment_details');
        $this->db->where('student_id', $student_id);
        $this->db->where('month', 4);
        $this->db->where('session_year', $session_year_id);
        $query = $this->db->get();
        return $query->result(); 
    }

}
