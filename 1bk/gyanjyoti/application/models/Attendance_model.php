<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_Model {

    // Fetch attendance data from the database
    public function get_attendance($month, $year) {
        // Fetch attendance data based on month and year
        $this->db->select('roll_no, name, attendance_data');
        $this->db->where('month', $month);
        $this->db->where('year', $year);
        $query = $this->db->get('attendance');
        
        $result = $query->result_array();
        
        // Format data
        $attendance = [];
        foreach ($result as $row) {
            $attendance[] = [
                'roll_no' => $row['roll_no'],
                'name' => $row['name'],
                'attendance' => json_decode($row['attendance_data'], true) // Assuming this field contains JSON data
            ];
        }

        return $attendance;
    }

    public function update_students_attendance($data) {
        $session_year_id = get_session('session');
        $data['session_year_id'] = $session_year_id;			
        
        // Extract necessary values from the data array
        $code    = $data['student_id'];
        $date    = $data['date'];
        $present = $data['attendance'];
        $fday    = $data['fullday'];
        $comment = $data['comments'];
        
        // Use CodeIgniter's Active Record to check if the attendance record exists
        $this->db->where('student_id', $code);
        $this->db->where('date', $date);
        $this->db->where('session_year_id', $session_year_id);
        $query = $this->db->get('student_attendance');
        
        if ($query->num_rows() === 0) {
            // No record found, insert the new attendance data
            $this->db->insert('student_attendance', $data);
            return $this->db->insert_id(); // Return the new record ID
        } else {
            // Update the existing attendance record
            $this->db->set('attendance', $present);
            $this->db->set('fullday', $fday);
            $this->db->set('comments', $comment);
            $this->db->where('student_id', $code);
            $this->db->where('date', $date);
            $this->db->where('session_year_id', $session_year_id);
            return $this->db->update('student_attendance'); // Return true/false on success/failure
        }
    }
    
    public function ajax_student_attendance_view($class_id ='',$section_id='',$month='',$student_id=''){
        $session_year_id = get_session('session');
        // $where_in = array('Bonafide','Free');
        if($student_id != ''){
            $this->db->select('*');
            $this->db->from('students_details');
            $this->db->where('students_details.student_code',$student_id);
            $results = $this->db->get();
            $studentDtls = $results->result(); 	
            $sql="SELECT * FROM student_attendance WHERE Month(date) ='". $month ."' and student_id='". $studentDtls[0]->id ."' and session_year_id='". $session_year_id ."' order by date asc";
            $query = $this->db->query($sql);
            // echo $this->db->last_query();
            return $query->result();
        } else {
            //$this->db->select('student.*,students_details.roll_num');
            $this->db->select('*');
            $this->db->from('students_details');
            $this->db->where('students_details.class',$class_id);
            if(!empty($section_id)){
            $this->db->where('students_details.section',$section_id);
            }
            $this->db->where('students_details.application_status','student');
            $this->db->where('students_details.session_id',$session_year_id);
            $this->db->where('students_details.status','Y');
            $this->db->where('students_details.is_delete','N');
            $this->db->order_by('students_details.admission_form_no','asc');
            $results = $this->db->get();
            return $results->result(); 	
        }			
    }
}
