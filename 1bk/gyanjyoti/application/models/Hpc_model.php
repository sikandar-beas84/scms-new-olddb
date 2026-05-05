<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hpc_model extends CI_Model {


public function get_student_attendance($student_code) {
    $session_year_id = get_session('session');
    // Base array for months from April to March
    $months = [
        4 => ['month' => 4, 'total_days' => 0, 'total_present' => 0, 'total_full_day' => 0, 'total_with_comments' => 0],
        5 => ['month' => 5, 'total_days' => 0, 'total_present' => 0, 'total_full_day' => 0, 'total_with_comments' => 0],
        6 => ['month' => 6, 'total_days' => 0, 'total_present' => 0, 'total_full_day' => 0, 'total_with_comments' => 0],
        7 => ['month' => 7, 'total_days' => 0, 'total_present' => 0, 'total_full_day' => 0, 'total_with_comments' => 0],
        8 => ['month' => 8, 'total_days' => 0, 'total_present' => 0, 'total_full_day' => 0, 'total_with_comments' => 0],
        9 => ['month' => 9, 'total_days' => 0, 'total_present' => 0, 'total_full_day' => 0, 'total_with_comments' => 0],
        10 => ['month' => 10, 'total_days' => 0, 'total_present' => 0, 'total_full_day' => 0, 'total_with_comments' => 0],
        11 => ['month' => 11, 'total_days' => 0, 'total_present' => 0, 'total_full_day' => 0, 'total_with_comments' => 0],
        12 => ['month' => 12, 'total_days' => 0, 'total_present' => 0, 'total_full_day' => 0, 'total_with_comments' => 0],
        1 => ['month' => 1, 'total_days' => 0, 'total_present' => 0, 'total_full_day' => 0, 'total_with_comments' => 0],
        2 => ['month' => 2, 'total_days' => 0, 'total_present' => 0, 'total_full_day' => 0, 'total_with_comments' => 0],
        3 => ['month' => 3, 'total_days' => 0, 'total_present' => 0, 'total_full_day' => 0, 'total_with_comments' => 0],
    ];

    // Prepare the query
    $this->db->select('MONTH(date) AS month, 
                       COUNT(*) AS total_days, 
                       SUM(attendance) AS total_present, 
                       SUM(CASE WHEN fullday = 1 THEN 1 ELSE 0 END) AS total_full_day, 
                       SUM(CASE WHEN comments IS NOT NULL AND comments != "" THEN 1 ELSE 0 END) AS total_with_comments');
    $this->db->from('student_attendance');
    $this->db->where('student_id', $student_code);
    $this->db->where('session_year_id', $session_year_id);
    $this->db->group_by('MONTH(date)');
    $this->db->order_by('month');

    // Execute the query
    $query = $this->db->get();

    // Check if there are results
    if ($query->num_rows() > 0) {
        $attendance_records = $query->result();
        
        // Map results to month array
        foreach ($attendance_records as $record) {
            $month = (int)$record->month; // Get the month as an integer
            // Update the respective month's data
            if (array_key_exists($month, $months)) {
                $months[$month] = [
                    'month' => $record->month,
                    'total_days' => $record->total_days,
                    'total_present' => $record->total_present,
                    'total_full_day' => $record->total_full_day,
                    'total_with_comments' => $record->total_with_comments,
                ];
            }
        }
    }

    // Return the complete attendance data for all months from April to March
    return array_values($months); // Return as a numeric array
}
public function get_hpc($student_code, $class_id) {
    $session_year_id = get_session('session');
    // Build the query
    $this->db->select('*');
    $this->db->from('hpc');
    $this->db->where('student_code', $student_code);
    $this->db->where('class_id', $class_id);
    $this->db->where('session_year_id', $session_year_id);
    $this->db->order_by('id', 'DESC');
    
    // Execute the query and return the result
    $query = $this->db->get();
    return $query->result(); // Return result as an array of objects
}

}