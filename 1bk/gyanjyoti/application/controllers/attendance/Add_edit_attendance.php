<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_edit_attendance extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
        $this->load->model('Student_model');
        $this->load->model('Attendance_model');
		date_default_timezone_set('Asia/Kolkata');
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }

	}

	public function index(){
        // prx($this->session->userdata());
        $data['class'] = $this->Common_model->relational_dropdown(
            'class',
            'id',
            'class_name',
            ['status' => 'Y', 'is_delete !=' => 'Y'],
            ' - '
        );
        $head['title'] = $data['page_title'] = 'Add / Edit Attendance';
        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('attendance/add_edit_attendance');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}

	//ajax section list
    public function get_sections_by_class_id(){
        $classId = $this->input->post('classId');
        
        // Initialize the sections array with a default option
        $sections = array();
        // $sections['0'] = 'Select Section';
    
        // Fetch the sections from the database using the relational_dropdown method
        $sections =  $this->Common_model->relational_dropdown(
            'section',
            'id',
            'section',
            [
                'status' => 'Y', 
                'is_delete !=' => 'Y', 
                'session_year' => get_session('session'), 
                'class' => $classId
            ],
            ' - '
        );
        // prx($sections);
        // Output the sections as a JSON response
        echo json_encode($sections);
    }
    
    public function ajax_get_students(){
        $session_year_id = get_session('session');
        
        $class_id = $this->input->post('classId');
        $section_id = $this->input->post('sectionId');
        $date = $this->input->post('date');
        $student_list = $this->Student_model->ajax_student_list($class_id, $section_id);
        
        $html = '';  // Initialize $html variable properly
        $i = 0;
        
        if(!empty($student_list)){
            $html .= '<table width="100%"> <thead>
                        <tr style="border-bottom:1px solid #d4d3d3;padding:5px;background: #243448;">
                            <th><center>Roll No</center></th>
                            <th><center>Student Name (Code)</center></th>
                            <th><center>Attendance</center></th>
                            <th><center>Full/Half Day</center></th>                        
                            <th><center>Comments</center></th>                        
                        </tr>
                    </thead><tbody>';
            
            foreach($student_list as $student){
                $sql = "SELECT * FROM student_attendance WHERE student_id = '". $student->code ."' AND date='". date('Y-m-d', strtotime($date)) ."' AND session_year_id='". $session_year_id ."'";
                $query = $this->db->query($sql);
                $result = $query->row();
                
                $html .= '<tr style="border-bottom:1px solid #d4d3d3">
                            <input type="hidden" name="student_id'.$i.'" value="'. $student->id .'">
                            <input type="hidden" name="roll'.$i.'" value="'. $student->roll .'">
                            <input type="hidden" name="class'.$i.'" value="'. $student->class .'">
                            <input type="hidden" name="section'.$i.'" value="'. $student->section .'">
                            <input type="hidden" name="date'.$i.'" value="'. date('Y-m-d', strtotime($date)) .'">
                            <td><center>'. $student->roll .'</center></td>
                            <td><center>'.$student->student_name .' (' . $student->student_id . ')</center></td>';
                
                if(!empty($result)){
                    $html .= '<td>
                                <center>P &nbsp;&nbsp;<input name="present'.$i.'" type="radio" '. ($result->present == 1 ? 'checked' : '') .' value="P"></center>
                                <center class="red"><b class="red">A</b> &nbsp;&nbsp;<input name="present'.$i.'" type="radio" '. ($result->present == 0 ? 'checked' : '') .' value="A"></center>
                            </td>
                            <td>
                                <center>F &nbsp;&nbsp;<input name="fullday'.$i.'" type="radio" '. ($result->fullday == 1 ? 'checked' : '') .' value="F"></center>
                                <center>H &nbsp;&nbsp;<input name="fullday'.$i.'" type="radio" '. ($result->fullday == 0 ? 'checked' : '') .' value="H"></center>
                            </td>';
                } else {
                    $html .= '<td>
                                <center>P &nbsp;&nbsp;<input name="present'.$i.'" type="radio" checked value="P"></center>
                                <center class="red"><b class="red">A</b> &nbsp;&nbsp;<input name="present'.$i.'" type="radio" value="A"></center>
                            </td>
                            <td>
                                <center>F &nbsp;&nbsp;<input name="fullday'.$i.'" type="radio" checked value="F"></center>
                                <center>H &nbsp;&nbsp;<input name="fullday'.$i.'" type="radio" value="H"></center>
                            </td>';
                }
                $html .= '<td><textarea style="margin: 5px 0px;" name="comments'.$i.'" class="autosize-transition form-control"></textarea></td></tr>';
                
                $i++;
            }
            
            $html .= '<input type="hidden" id="count" value="'.$i.'"/>';
            $html .= '</tbody></table><br><br>';
            $html .= '<div class="row">
                        <div class="col-sm-8">
                            <button class="btn btn-success" id="save">Save</button>
                        </div>
                    </div>';
            
            $html .= '<script>
                $("#save").click(function(){
                    var code = $("#add_attendance").serializeArray();
                    var count = $("#count").val();
                    $("#divLoading").show();
                    $.ajax({
                        type: "POST",
                        url: "'. base_url('attendance/add_edit_attendance/update_students_attendance') .'", 
                        data: { value: code, count: count },
                        success: function(result){
                            if(result > 0){
                                showToast("Attendance Updated", "success");
                                } else {
                                    showToast("There is a Problem", "error");
                            }
                        }
                    });
                });
            </script>';
            
        } else {
            $html = '<table><tr><td colspan="6"><div class="alert alert-danger">No result found!</div></td></tr></table>';
        }
        
        $data["html"] = $html;
        echo json_encode($data);  // Ensure this is valid JSON output
    }
    public function update_students_attendance(){
		$data=[];
		$update=[];
		$success = 0;
		$values=$this->input->post('value');
		$count=$this->input->post('count');
		
		foreach($values as $value){
			$data[$value['name']] = $value['value'];
		}

		for($i=0;$i<$count;$i++){
			$updata[$i]['student_id'] = $data['student_id'.$i];
			$updata[$i]['date'] = $data['date'.$i];
			$updata[$i]['roll'] = $data['roll'.$i];
			$updata[$i]['class'] = $data['class'.$i];
			$updata[$i]['section'] = $data['section'.$i];
			$updata[$i]['attendance'] = $data['present'.$i];
			$updata[$i]['fullday'] = $data['fullday'.$i];
			$updata[$i]['comments'] = $data['comments'.$i];
		}
		foreach($updata as $student){
			$result = $this->Attendance_model->update_students_attendance($student);
		}
		if($result>0){
			$success = 1;
		}else{
			$success= 0;
		}
		echo $success;
	}
	

}
?>
