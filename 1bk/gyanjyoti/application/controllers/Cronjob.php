<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjob extends CI_Controller {

    public function __construct(){
        parent::__construct();

        // $this->load->model('LoginModel');
        // $this->load->model('Common_model');
		date_default_timezone_set('Asia/Kolkata');
		// if(empty($this->session->userdata('user_id'))){
        //     redirect(base_url('dashboard'));
        // }
	
        
    }
    public function fineCalculation()
{
    // Get the current month (1 = January, 12 = December)
    $currentMonth = date('n'); // Current month as a number (1–12)
    $startMonth = 4; // April (the starting point for your checks)

    // Check all months starting from April up to the current month
    if ($currentMonth >= $startMonth) {
        // Same year: Loop through months from April to the current month
        for ($month = $startMonth; $month <= $currentMonth; $month++) {
            $this->monthfineCalculation($month);
        }
    } else {
        // Year wrap-around: First check from April to December of the previous year
        for ($month = $startMonth; $month <= 12; $month++) {
            $this->monthfineCalculation($month);
        }
        // Then check from January to the current month of this year
        for ($month = 1; $month <= $currentMonth; $month++) {
            $this->monthfineCalculation($month);
        }
    }
}

   public function monthfineCalculation($month)
{
    $session = $this->Generalmodel->get_current_session();
    $fineAndDueDate = $this->Generalmodel->get_due_dates($session[0]['id'], $month);
    
    // Format due date
    $dueDate = strtotime($fineAndDueDate->due_date);
    $dueDay = date('d-m-Y', $dueDate);
    $currentDate = date('d-m-Y');
    
    $finePerCycle = $fineAndDueDate->fine_amount;
    $dueStudents = $this->Generalmodel->get_student_payment_details($session[0]['id'], $month, 'N');
    
    foreach ($dueStudents as $student) {
        try {
            // Create DateTime objects
            $dueDateObj = DateTime::createFromFormat('d-m-Y', $dueDay);
            $currentDateObj = DateTime::createFromFormat('d-m-Y', $currentDate);
            
            if (!$dueDateObj || !$currentDateObj) {
                // Log error if date creation fails
                error_log("Date creation failed for student_id: " . $student->student_id);
                continue;
            }
            
            // Ensure dates are at the start of the day for consistent comparison
            $dueDateObj->setTime(0, 0, 0);
            $currentDateObj->setTime(0, 0, 0);
            
            // Calculate days between dates
            if ($currentDateObj > $dueDateObj) {
                $interval = $currentDateObj->diff($dueDateObj);
                $daysSinceDue = $interval->days;
                
                // Debug information
                /*
                error_log("Student ID: " . $student->student_id);
                error_log("Due Date: " . $dueDateObj->format('d-m-Y'));
                error_log("Current Date: " . $currentDateObj->format('d-m-Y'));
                error_log("Days Since Due: " . $daysSinceDue);
                */
                
                if ($daysSinceDue > 0) {
                    $fineCycles = floor($daysSinceDue / 15);
                    $fineCycles = $fineCycles + 1;
                    $totalFine = $fineCycles * $finePerCycle;
                    
                    // Store fine calculation details
                    $fineData = [
                        'amount' => $totalFine,
                        'days_overdue' => $daysSinceDue,
                        'due_date' => $dueDateObj->format('Y-m-d'),
                        'calculation_date' => $currentDateObj->format('Y-m-d')
                    ];
                    
                    $this->Generalmodel->update_student_fine($student->id, $totalFine);
                }
            } else {
                // If current date is before or equal to due date, no fine
                continue;
            }
            
        } catch (Exception $e) {
            // Log any date handling errors
            error_log("Error processing fine for student_id: " . $student->student_id . " - " . $e->getMessage());
            continue;
        }
    }
}

// Helper function to validate date format
private function isValidDate($date, $format = 'd-m-Y')
{
    $dateObj = DateTime::createFromFormat($format, $date);
    return $dateObj && $dateObj->format($format) === $date;
}
  
}
?>
