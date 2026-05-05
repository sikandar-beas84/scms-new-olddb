<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    public function get_application_counts($class, $start_date, $end_date) {
        $session_year_id = get_session('session');
        // SUM(CASE WHEN application_status = 'student' THEN 1 ELSE 0 END) AS total_students
        $this->db->select("
            COUNT(*) AS total_applications,
            SUM(CASE WHEN application_status = 'pending' THEN 1 ELSE 0 END) AS pending_count,
            SUM(CASE WHEN application_status = 'approved' THEN 1 ELSE 0 END) AS approved_count,
            SUM(CASE WHEN application_status = 'reject' THEN 1 ELSE 0 END) AS rejected_count,
        ");
        $this->db->from('students_details');
        if(!empty($class)){
            $this->db->where('class', $class);
        }
        $this->db->where('session_id', $session_year_id);
        if(!empty($start_date) & !empty($end_date)){
            $this->db->where('created_at >=', $start_date);
            $this->db->where('created_at <=', $end_date);
        }
        $query = $this->db->get();
        return $query->row_array(); // Returns the result as an associative array
    }
    public function get_all_application($class, $start_date, $end_date) {
        $session_year_id = get_session('session');
        // SUM(CASE WHEN application_status = 'student' THEN 1 ELSE 0 END) AS total_students
        $this->db->select("class.*, students_details.*");
        $this->db->from('students_details');
        $this->db->join('class', 'class.id = students_details.class','left');
        if(!empty($class)){
            $this->db->where('students_details.class', $class);
        }
        $this->db->where('students_details.session_id', $session_year_id);
        if(!empty($start_date) & !empty($end_date)){
            $this->db->where('students_details.created_at >=', $start_date);
            $this->db->where('students_details.created_at <=', $end_date);
        }
        $query = $this->db->get();
        return $query->result(); // Returns the result as an associative array
    }

    public function getStudentCount($class, $start_date, $end_date) {
        $session_year_id = get_session('session');
            // Query to get the student count and re-admission count
        $this->db->select('COUNT(*) AS student');
        $this->db->select("SUM(
                CASE 
                    WHEN EXISTS (
                        SELECT 1 
                        FROM session_wish_student_data old 
                        WHERE old.student = current.student 
                          AND old.session_id != '3'
                    ) 
                    THEN 1 
                    ELSE 0 
                END
            ) AS re_admission_students", FALSE);
        $this->db->from('session_wish_student_data current');
        $this->db->where('current.session_id', $session_year_id);
        if(!empty($class)){
            $this->db->where('current.class', $class);
        }
        if(!empty($start_date) & !empty($end_date)){
            $this->db->where('created_at >=', $start_date);
            $this->db->where('created_at <=', $end_date);
        }

        $query = $this->db->get();
        return $query->row_array(); // Return the result as a row object
        
    }

    public function get_class_wish_data($class, $start_date, $end_date) {
        $session_year_id = get_session('session');
        // Prepare the query to select class name and student count
        $this->db->select('class.class_name, COUNT(*) AS student_count');
        $this->db->from('session_wish_student_data');
        $this->db->join('class', 'session_wish_student_data.class = class.id');
        // $this->db->where('session_wish_student_data.session_id', $session_id);
        $this->db->where('session_wish_student_data.session_id', $session_year_id);
        if(!empty($class)){
            $this->db->where('session_wish_student_data.class', $class);
        }
        if(!empty($start_date) & !empty($end_date)){
            $this->db->where('session_wish_student_data.created_at >=', $start_date);
            $this->db->where('session_wish_student_data.created_at <=', $end_date);
        }
        $this->db->group_by('class.class_name');
        
        // Execute the query and return the result
        $query = $this->db->get();
        
        // Check if the query returns results
        if ($query->num_rows() > 0) {
            return $query->result();  // Return results as an array of objects
        } else {
            return [];  // Return an empty array if no results
        }
    }

    public function get_total_students()
    {
        $session_year_id = get_session('session');
        // $session_year_id = get_session('session');
        $this->db->select('COUNT(*) as total_students');
        $this->db->from('students_details');
        $this->db->where('students_details.application_status', 'student');
        $this->db->where('students_details.session_id', $session_year_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->total_students;
        }
        return 0; // Return 0 if no rows found
    }
    public function get_total_amount_by_date_type($date, $type) {
        $session_year_id = get_session('session');
        $this->db->select('SUM(amount) AS total_amount');
        $this->db->from('admission_from_payment_data');
        $this->db->where('payment_status', 'Y'); // Include only successful payments
        $this->db->where('payment_type', $type); // Include only successful payments
        $this->db->where('DATE(payment_date)', $date); // Filter by specific date
        $this->db->where('session_year', $session_year_id);
        $query = $this->db->get();
        $result = $query->row_array();

        return $result['total_amount'] ?? 0; // Return total_amount or 0 if no records found
    }
    public function total_form_fill_up()
    {
        
        $session_year_id = get_session('session');
        $this->db->select('COUNT(*) as total_students');
        $this->db->from('students_details');
        $this->db->where('students_details.session_id', $session_year_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->total_students;
        }
        return 0; // Return 0 if no rows found
    }
    public function get_total_admissions()
    {
        $session_year_id = get_session('session');
        $this->db->select('COUNT(*) as total_students');
        $this->db->from('session_wish_student_data');
        $this->db->where('session_wish_student_data.session_id', $session_year_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->total_students;
        }
        return 0; // Return 0 if no rows found
    }
    public function get_total_teachers()
    {
        // $session_year_id = get_session('session');
        $this->db->select('COUNT(*) as total_teachers');
        $this->db->from('staff');
        $this->db->where('staff.status', 'Y');
        $this->db->where('staff.is_delete', 'N');
        // $this->db->where('session_id', $session_year_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->total_teachers;
        }
        return 0; // Return 0 if no rows found
    }

    public function get_student_enrollment_over_years()
    {
        $session_year_id = get_session('session');
        $this->db->select('YEAR(created_at) AS enrollment_year, COUNT(*) AS total_students');
        $this->db->from('session_wish_student_data');
        $this->db->group_by('YEAR(created_at)');
        $this->db->order_by('enrollment_year');
        $this->db->where('session_id', $session_year_id);
        $query = $this->db->get();

        return $query->result_array(); // Return result as an array of rows
    }

    // collocation_report

    private function apply_common_filters($class_id, $fromDate, $toDate, $payment_type, $teachers) {
        $session_year_id = get_session('session'); // Get current session year
        $this->db->where('spd.payment_amount_1st !=', '0'); // Only completed payments
        $this->db->where('spd.payment_amount_2nd !=', '0'); // Only completed payments
        $this->db->where('spd.payment_amount_3rd !=', '0'); // Only completed payments
        // $this->db->where('spd.payment_status', 'Y'); // Only completed payments
        $this->db->where('spd.session_year', $session_year_id); // Filter by session year

        if (!empty($class_id)) {
            $this->db->where('spd.class', $class_id); // Filter by class
        }

        if (!empty($payment_type)) {
            $this->db->where('spd.payment_type', $payment_type); // Filter by payment type
        }
        if (!empty($teachers)) {
            $this->db->where('spd.collected_by', $teachers); // Filter by payment type
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $this->db->where('spd.payment_date >=', $fromDate); // Start date
            $this->db->where('spd.payment_date <=', $toDate);   // End date
        }
    }

    /**
     * Get total payment received.
     */
    public function get_total_payment_received($class_id, $fromDate, $toDate, $payment_type, $teachers) {
        $session_year_id = get_session('session');
        // $this->db->select('
        //     SUM(COALESCE(spd.session_fees, 0)) +
        //     SUM(COALESCE(spd.academic_fees, 0)) +
        //     SUM(COALESCE(spd.tuition_fees, 0)) +
        //     SUM(COALESCE(spd.monthly_fees, 0)) +
        //     SUM(COALESCE(spd.sports_fees, 0)) +
        //     SUM(COALESCE(spd.library_fees, 0)) +
        //     SUM(COALESCE(spd.lab_fees, 0)) +
        //     SUM(COALESCE(spd.other_curriculum_fees, 0)) +
        //     SUM(COALESCE(spd.fine, 0)) AS total_payment_received
        // ');
        $this->db->select('
            SUM(COALESCE(spd.payment_amount_1st, 0)) +
            SUM(COALESCE(spd.payment_amount_2nd, 0)) +
            SUM(COALESCE(spd.payment_amount_3rd, 0)) 
             AS total_payment_received
        ');
        $this->db->from('student_payment_details spd');
        $this->apply_common_filters($class_id, $fromDate, $toDate, $payment_type, $teachers);
        $this->db->where('session_year', $session_year_id);
        $query = $this->db->get();
        return $query->row() ? $query->row()->total_payment_received : 0; // Handle null case
    }


public function get_payment_collections($class_id, $fromDate, $toDate, $payment_type, $teachers) {
    $session_year_id = get_session('session');
    $this->db->select("
        SUM(COALESCE(spd.payment_amount_1st, 0)) +
        SUM(COALESCE(spd.payment_amount_2nd, 0)) +
        SUM(COALESCE(spd.payment_amount_3rd, 0)) AS total_collected,
        
        SUM(CASE WHEN spd.payment_type = '1' THEN COALESCE(spd.payment_amount_1st, 0) ELSE 0 END) +
        SUM(CASE WHEN spd.payment_type_2nd = '1' THEN COALESCE(spd.payment_amount_2nd, 0) ELSE 0 END) +
        SUM(CASE WHEN spd.payment_type_3rd = '1' THEN COALESCE(spd.payment_amount_3rd, 0) ELSE 0 END) AS total_cash_collection,
        
        SUM(CASE WHEN spd.payment_type = '2' THEN COALESCE(spd.payment_amount_1st, 0) ELSE 0 END) +
        SUM(CASE WHEN spd.payment_type_2nd = '2' THEN COALESCE(spd.payment_amount_2nd, 0) ELSE 0 END) +
        SUM(CASE WHEN spd.payment_type_3rd = '2' THEN COALESCE(spd.payment_amount_3rd, 0) ELSE 0 END) AS total_qr_collection,
        
        SUM(CASE WHEN spd.payment_type = '3' THEN COALESCE(spd.payment_amount_1st, 0) ELSE 0 END) +
        SUM(CASE WHEN spd.payment_type_2nd = '3' THEN COALESCE(spd.payment_amount_2nd, 0) ELSE 0 END) +
        SUM(CASE WHEN spd.payment_type_3rd = '3' THEN COALESCE(spd.payment_amount_3rd, 0) ELSE 0 END) AS total_online_collection
    ");
    $this->db->from('student_payment_details spd');
    $this->apply_common_filters($class_id, $fromDate, $toDate, $payment_type, $teachers); // No specific payment type filter
    $this->db->where('session_year', $session_year_id);
    $query = $this->db->get();
    if ($query->row()) {
        return [
            'total_cash_collection' => $query->row()->total_cash_collection,
            'total_qr_collection' => $query->row()->total_qr_collection,
            'total_online_collection' => $query->row()->total_online_collection,
        ];
    }
    return [
        'total_cash_collection' => 0,
        'total_qr_collection' => 0,
        'total_online_collection' => 0,
    ];
}
public function get_form_payment_collections($class_id, $fromDate, $toDate, $payment_type, $teachers) {
    $session_year_id = get_session('session');
    $this->db->select("
        
        SUM(CASE WHEN spd.payment_type = '1' THEN COALESCE(spd.amount, 0) ELSE 0 END)  AS total_cash_collection,
        
        SUM(CASE WHEN spd.payment_type = '2' THEN COALESCE(spd.amount, 0) ELSE 0 END) AS total_qr_collection,
        
        SUM(CASE WHEN spd.payment_type = '3' THEN COALESCE(spd.amount, 0) ELSE 0 END) AS total_online_collection
    ");
    $this->db->from('admission_from_payment_data spd');

        if (!empty($class_id)) {
            $this->db->where('spd.class', $class_id); // Filter by class
        }

        if (!empty($payment_type)) {
            $this->db->where('spd.payment_type', $payment_type); // Filter by payment type
        }
        if (!empty($teachers)) {
            $this->db->where('spd.collected_by', $teachers); // Filter by payment type
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $this->db->where('spd.payment_date >=', $fromDate); // Start date
            $this->db->where('spd.payment_date <=', $toDate);   // End date
        }
    $this->db->where('session_year', $session_year_id);
    $query = $this->db->get();
    if ($query->row()) {
        return [
            'total_cash_collection' => $query->row()->total_cash_collection,
            'total_qr_collection' => $query->row()->total_qr_collection,
            'total_online_collection' => $query->row()->total_online_collection,
        ];
    }
    return [
        'total_cash_collection' => 0,
        'total_qr_collection' => 0,
        'total_online_collection' => 0,
    ];
}
    /**
     * Get class-wise payment summary.
     */
    public function get_class_payment_summary($class_id, $fromDate, $toDate, $payment_type, $teachers) {
        $session_year_id = get_session('session');
        // $this->db->select('
        //     c.class_name,
        //     SUM(COALESCE(spd.session_fees, 0)) +
        //     SUM(COALESCE(spd.academic_fees, 0)) +
        //     SUM(COALESCE(spd.tuition_fees, 0)) +
        //     SUM(COALESCE(spd.monthly_fees, 0)) +
        //     SUM(COALESCE(spd.sports_fees, 0)) +
        //     SUM(COALESCE(spd.library_fees, 0)) +
        //     SUM(COALESCE(spd.lab_fees, 0)) +
        //     SUM(COALESCE(spd.other_curriculum_fees, 0)) +
        //     SUM(COALESCE(spd.fine, 0)) AS total_payment_received
        // ');
        $this->db->select('
            c.class_name,
            SUM(COALESCE(spd.payment_amount_1st, 0)) +
            SUM(COALESCE(spd.payment_amount_2nd, 0)) +
            SUM(COALESCE(spd.payment_amount_3rd, 0)) 
             AS total_payment_received
        ');
        $this->db->from('student_payment_details spd');
        $this->db->join('class c', 'spd.class = c.id');
        $this->apply_common_filters($class_id, $fromDate, $toDate, $payment_type, $teachers);
        $this->db->where('spd.session_year', $session_year_id);
        $this->db->group_by('c.class_name');

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get daily payment summary.
     */
    public function get_daily_payment_summary($class_id, $fromDate, $toDate, $payment_type, $teachers) {
        $session_year_id = get_session('session');
        // $this->db->select('
        //     DATE(spd.payment_date) AS payment_day,
        //     SUM(COALESCE(spd.session_fees, 0)) +
        //     SUM(COALESCE(spd.academic_fees, 0)) +
        //     SUM(COALESCE(spd.tuition_fees, 0)) +
        //     SUM(COALESCE(spd.monthly_fees, 0)) +
        //     SUM(COALESCE(spd.sports_fees, 0)) +
        //     SUM(COALESCE(spd.library_fees, 0)) +
        //     SUM(COALESCE(spd.lab_fees, 0)) +
        //     SUM(COALESCE(spd.other_curriculum_fees, 0)) +
        //     SUM(COALESCE(spd.fine, 0)) AS total_payment_received
        // ');
        // $this->db->from('student_payment_details spd');
        // $this->apply_common_filters($class_id, $fromDate, $toDate, $payment_type, $teachers);
        // $this->db->group_by('DATE(spd.payment_date)');
        // $this->db->order_by('payment_day', 'ASC');
        $this->db->select('*');
        $this->db->from('student_payment_details spd');
        $this->apply_common_filters($class_id, $fromDate, $toDate, $payment_type, $teachers);
        $this->db->where('spd.session_year', $session_year_id);

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get monthly payment summary.
     */
   public function get_monthly_payment_data() {
       $session_year_id = get_session('session');
        // $this->db->select('
        //     YEAR(spd.payment_date) AS payment_year,
        //     MONTH(spd.payment_date) AS payment_month_number,
        //     MONTHNAME(spd.payment_date) AS payment_month,
        //     SUM(COALESCE(spd.session_fees, 0)) +
        //     SUM(COALESCE(spd.academic_fees, 0)) +
        //     SUM(COALESCE(spd.tuition_fees, 0)) +
        //     SUM(COALESCE(spd.monthly_fees, 0)) +
        //     SUM(COALESCE(spd.sports_fees, 0)) +
        //     SUM(COALESCE(spd.library_fees, 0)) +
        //     SUM(COALESCE(spd.lab_fees, 0)) +
        //     SUM(COALESCE(spd.other_curriculum_fees, 0)) +
        //     SUM(COALESCE(spd.fine, 0)) AS total_payment_received
        // ');
        
        $this->db->select('
            YEAR(spd.payment_date) AS payment_year,
            MONTH(spd.payment_date) AS payment_month_number,
            MONTHNAME(spd.payment_date) AS payment_month,
            SUM(COALESCE(spd.payment_amount_1st, 0)) +
            SUM(COALESCE(spd.payment_amount_2nd, 0)) +
            SUM(COALESCE(spd.payment_amount_3rd, 0)) 
             AS total_payment_received
        ');
        $this->db->from('student_payment_details spd');
        $this->db->where('spd.payment_status', 'Y'); // Completed payments only
        $this->db->where('spd.session_year', get_session('session')); // Current session year
        $this->db->group_by(['YEAR(spd.payment_date)', 'MONTH(spd.payment_date)', 'MONTHNAME(spd.payment_date)']);
        $this->db->order_by('payment_year', 'DESC');
        $this->db->order_by('payment_month_number', 'DESC');
    $this->db->where('spd.session_year', $session_year_id);
        $query = $this->db->get();
        return $query->result_array(); // Return as an array
    }


    // Due Report

    private function apply_due_common_filters($class_id, $payment_month) {
        $session_year_id = get_session('session'); // Get current session year
        $this->db->where('spd.payment_status', 'N'); // Only completed payments
        $this->db->where('spd.session_year', $session_year_id); // Filter by session year

        if (!empty($class_id)) {
            $this->db->where('spd.class', $class_id); // Filter by class
        }
        if (!empty($payment_month)) {
            $this->db->where('spd.month', $payment_month); // Filter by class
        }

       
    }

    public function get_total_due_payment($class_id, $payment_month) {
        $this->db->select('
            SUM(COALESCE(spd.session_fees, 0)) +
            SUM(COALESCE(spd.academic_fees, 0)) +
            SUM(COALESCE(spd.tuition_fees, 0)) +
            SUM(COALESCE(spd.monthly_fees, 0)) +
            SUM(COALESCE(spd.sports_fees, 0)) +
            SUM(COALESCE(spd.library_fees, 0)) +
            SUM(COALESCE(spd.lab_fees, 0)) +
            SUM(COALESCE(spd.other_curriculum_fees, 0)) +
            SUM(COALESCE(spd.fine, 0)) -  SUM(COALESCE(spd.payment_amount_1st, 0)) +
            SUM(COALESCE(spd.payment_amount_2nd, 0)) +
            SUM(COALESCE(spd.payment_amount_3rd, 0))  AS total_payment_received
        ');
        // $this->db->select('
        //     SUM(COALESCE(spd.payment_amount_1st, 0)) +
        //     SUM(COALESCE(spd.payment_amount_2nd, 0)) +
        //     SUM(COALESCE(spd.payment_amount_3rd, 0)) 
        //      AS total_payment_received
        // ');
        $this->db->from('student_payment_details spd');
        $this->apply_due_common_filters($class_id, $payment_month);

        $query = $this->db->get();
        return $query->row() ? $query->row()->total_payment_received : 0; // Handle null case
    }

    public function get_daily_payment_due_summary($class_id, $payment_month) {
       
        $this->db->select('*');
        $this->db->from('student_payment_details spd');
        $this->apply_due_common_filters($class_id, $payment_month);


        $query = $this->db->get();
        return $query->result();
    }


    public function get_total_stationary_sale_payment($teachers, $fromDate, $toDate) {
        $this->db->select('
           
            SUM(COALESCE(spd.amount, 0)) AS total_payment_received
        ');
        $this->db->from('stationary spd');
        if (!empty($teachers)) {
            $this->db->where('spd.created_by', $teachers); // Filter by payment type
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $this->db->where('spd.created_date >=', $fromDate); // Start date
            $this->db->where('spd.created_date <=', $toDate);   // End date
        }

        $query = $this->db->get();
        return $query->row() ? $query->row()->total_payment_received : 0; // Handle null case
    }
    public function get_all_stationary_sale($teachers, $fromDate, $toDate) {
        $this->db->select('*');
        $this->db->from('stationary spd');
        if (!empty($teachers)) {
            $this->db->where('spd.created_by', $teachers); // Filter by payment type
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $this->db->where('spd.created_date >=', $fromDate); // Start date
            $this->db->where('spd.created_date <=', $toDate);   // End date
        }

        $query = $this->db->get();
        return $query->result(); // Handle null case
    }
}
