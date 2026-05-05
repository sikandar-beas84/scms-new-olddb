<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
        $this->load->model('Student_model');
		date_default_timezone_set('Asia/Kolkata');
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }

	}

	public function index(){
        
	
        $head['title'] = $data['page_title'] = 'Generate Roll Number';
        // prx($this->session->userdata());
        $data['class'] = $this->Common_model->relational_dropdown(
            'class',
            'id',
            'class_name',
            ['status' => 'Y', 'is_delete !=' => 'Y'],
            ' - '
        );
        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('roll/index');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}

    public function ajax_request_for_generate_student_roll() {  
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $student_list = $this->Student_model->promoted_student_list($class_id, $section_id);
        
        $count = 0;
        $html = ''; // Initialize $html as an empty string
        
        if (!empty($student_list)) {
            $html .= '<thead class="bg-primary text-white">
                        <tr>
                            <th>Sl No </th>
                            <th>Student Code</th>
                            <th>Student Name</th>
                            <th>Image</th>
                            <th>Class </th>
                            <th>Section</th>
                            <th>Roll No</th>
                            <th>Date Of Birth</th>
                            <th>Father Name</th>
                            <th>Mother Name</th>
                        </tr>
                      </thead><tbody>';
            foreach ($student_list as $student) {
                if($student->image){
                    $image =  base_url() . 'assets/uploads/student/' . $student->image;
                }else{
                    $image =  base_url() . 'assets/noImageProfile.png';
                }
                $html .= '<tr>
                            <td>' . ++$count . '</td>
                            <td>' . $student->s_code . '<input type="hidden" name="s_id[]" value="' . $student->s_id . '"/></td>
                            <td>' . $student->first_name . ' ' . $student->middle_name . ' ' . $student->student_name . '</td>
                            <td><img src="'.$image.'" height="50" width="50"></td>
                            <td>' . $student->class_name . '</td>
                            <td>' . $student->section_name . '</td>
                            <td>' . $student->roll . '</td>
                            <td>' . $student->dob . '</td>
                            <td>' . $student->father_name . '</td>
                            <td>' . $student->mother_name . '</td>
                          </tr>';
            }
            $html .= '</tbody>';
        } else {
            $html = '<tr><td colspan="10"><div class="alert alert-danger">No result found!</div></td></tr>';
        }
        
        $data["html"] = $html;
        $data["no_of_student"] = count($student_list);
        
        // Return proper JSON response
        echo json_encode($data);
    }
    
	public function allot_students_roll_num() {
        $student_ids = $this->input->post('s_id');
        
        // Initialize response
        $response = array('html' => '', 'message' => '', 'status' => 'error');
    
        if (empty($student_ids)) {
            // If no student codes provided
            $response['message'] = 'No students selected.';
            echo json_encode($response);
            return;
        }
    
        // Initial roll no
        $roll = 0;
        $valid_students = array();
        
        foreach ($student_ids as $id) {
            // Validate student existence
            $student = $this->Student_model->get_students_details($id);
            // prx($student);
            if (!$student) {
                // If student does not exist, add error and skip
                $response['message'] = 'Student with code ' . $student_code . ' does not exist.';
                echo json_encode($response);
                return;
            }
    
            // Check if the student already has a roll number assigned
            // if ($student->roll) {
            //     $response['message'] = 'Student with code ' . $student_code . ' already has a roll number.';
            //     echo json_encode($response);
            //     return;
            // }
    
            // If all validations pass, add student to the valid list
            $valid_students[] = $id;
        }
    
        // Now allot roll numbers to the valid students
        foreach ($valid_students as $student_code) {
            $roll++;
            $getResult = $this->Student_model->allot_student_roll($student_code, $roll);
        }
    
        if ($getResult) {
            $response['message'] = 'Roll No Added Successfully.';
            $response['status'] = 'success';
        } else {
            $response['message'] = 'Something Went Wrong Please Try Again.';
        }
    
        echo json_encode((object) $response);
    }
    
}
?>
