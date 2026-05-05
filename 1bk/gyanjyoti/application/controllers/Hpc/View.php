<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class View extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
        $this->load->model('Student_model');
        $this->load->model('Hpc_model');
		date_default_timezone_set('Asia/Kolkata');
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }

	}

	public function index(){
        
	
        $head['title'] = $data['page_title'] = 'HPC';
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
		$this->load->view('hpc/View');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}
    public function getHpc(){
        $student = $this->Student_model->get_students_full_details_by_code(post('student_id'));
        $data1['student'] = $this->Student_model->get_students_full_details($student->id);
        // pr($data);
        $classId = $this->input->post("class");
        $studentCode = $this->input->post("student_id");
        $student = $data['student'] = $this->Student_model->get_students_full_details_by_code(post('student_id'));
        $attendance = $data['attendance'] = $this->Hpc_model->get_student_attendance( $student->id, $session_year_id);
        $hpc = $data['hpc'] = $this->Hpc_model->get_hpc($studentCode, $classId, $session_year_id);
        $data['class'] = $this->Common_model->relational_dropdown(
            'class',
            'id',
            'class_name',
            ['status' => 'Y', 'is_delete !=' => 'Y'],
            ' - '
        );
		$html = $this->load->view('hpc/hpc', $data, TRUE);
        $data['data'] = $html;
        $data['status'] = 'Success';
        echo json_encode($data); 
	}

    function save() {
        // prx($_POST);
        $student_code = $this->input->post('student_code');
        if($student_code){
      $table = 'hpc'; // Specify your table name here
      
      // Fetch table fields
      $fields = $this->db->list_fields($table);
  
      // Automatically build the $formData array
      $formData = [];
      foreach ($fields as $field) {
          if($field != 'id'){
              $formData[$field] = $this->input->post($field);
          }
      }
  
      // Additional data
      $formData['session_year_id'] = $this->session->userdata('session_year_id'); 
      $formData['created_at'] = date('Y-m-d H:i:s');
      $formData['created_by'] =  $this->session->userdata('user_id');
      //     echo "<pre>";
    //   print_r($formData); exit;
      // Define the unique criteria for checking the existence of the record
      $student_code = $this->input->post('student_code');
      $class_id = $this->input->post('class_id');
      $session_year_id = $this->session->userdata('session_year_id');
  
      // Check if the record already exists based on student_code and class_id
      $existingRecord = $this->db->get_where($table, [
          'student_code' => $student_code, 
          'class_id' => $class_id, 
          'session_year_id' => $session_year_id
      ])->row();
        // prx($_POST);
      if ($existingRecord) {
          // Record exists, so perform an update
          $this->db->where('id', $existingRecord->id); // Use the unique identifier (e.g., primary key) to update
          $action = $this->db->update($table, $formData);
          $message = 'Updated Successfully';
      } else {
          // Record does not exist, so perform an insert
          $action = $this->db->insert($table, $formData);
          $message = 'Saved Successfully';
      }
  
      // Set flashdata message in the session
           if ($action) {
              $this->session->set_flashdata('message', $message);
              $this->session->set_flashdata('status', 'success'); // 'success' or 'error' based on your needs
          } else {
              $this->session->set_flashdata('message', 'Something went wrong. Please try again.');
              $this->session->set_flashdata('status', 'error');
          }
      redirect('hpc/view/index');
        }else{
            $this->session->set_flashdata('message', 'Please Select Student and try again.');
              $this->session->set_flashdata('status', 'error');
      // Redirect to the desired page
      redirect('hpc/view/index');
        }
  }
}
?>
