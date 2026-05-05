<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Re_admission extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
        $this->load->model('Student_model');
        $this->load->model('Generalmodel');
		date_default_timezone_set('Asia/Kolkata');
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }

	}

	public function index(){
        $data['class'] = $this->Common_model->relational_dropdown(
            'class',
            'id',
            'class_name',
            ['status' => 'Y', 'is_delete !=' => 'Y'],
            ' - '
        );
        // prx($_GET);
        $head['title'] = $data['page_title'] ='Re Admission';
        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('student/re_admission');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}

    public function ajax_re_admission_student_get() {      
		$class_id=post('classId');
		$section_id=post('sectionId');
		$studentId=post('studentId');
		$student_list = $this->Student_model->re_admission_student($class_id,$section_id, $studentId);
        // prx( $this->db->last_query());
		$student_list_mod = [];
		$student_list_mod1 = [];
		$student_list_final = [];

		$next_session = $this->Student_model->get_next_session_year(); 		
		
		foreach($student_list as $student){
			$sCount =  $this->Student_model->check_already_admission($student->student_id, $next_session->id);
			if($sCount != 0){
				// $firstMonthPayRe = $this->Student_model->re_student_first_month_payment($student->student_id,$next_session->id);
				// if($firstMonthPayRe->ad_payment_status != 0){
				// 	continue;
				// }
			}
			$student_list_mod[] = $student;
			
		}
		// prx($student_list_mod);
		
		foreach($student_list_mod as $student){
			$dueMonthCount = $this->Generalmodel->getDataWhere('student_payment_details',['session_year' => get_session('session'), 'student_id' => $student->s_id, 'payment_status' => 'N']);
				if(!empty($dueMonthCount)){				
					continue;
				}
			$student_list_mod1[] = $student;
			
		}
		
		foreach($student_list_mod1 as $student){
			// $dueLibMonthCount =  $this->Student_model->check_lib_due_count($student->code);
			// 	if($dueLibMonthCount != 0){
			// 		continue;
			// 	}
			$student_list_final[] = $student;
			
		}
		
		$count = 0;
		if(!empty($student_list_final)){		
			
			 $html .='<thead>
						<tr  style="border-bottom:1px solid #d4d3d3;padding:5px;background: #243448;">
							<th>Sl No </th>
							<th>Student Code</th>
							<th>Student Name</th>
							<th>Image</th>
							<th>Class </th>
							<th>Section</th>
							<th>Roll No</th>
							<th>Date Of Birth</th>
							<th>Result</th>
							<th>Status</th>
						</tr>
					</thead><tbody>';
            foreach($student_list_final as $student){
				// prx($student);
				if($student->image){
					$src = base_url().'assets/uploads/student/'. $student->image;

				}else{
					$src = base_url().'assets/noImageProfile.png';
				}
				$html .='<tr class="">
						<td> '.++$count.'</td>
						<td>'.$student->student_code .'<input type="hidden" name="s_id[]" value="'.$student->s_id .'"/></td>
						<td>'.$student->student_name .' </td>
						<td><img src="'. $src.'" height="50" width="50"></td>
						<td>'.$student->class_name .'</td>
						<td>'.$student->section_name .'</td>
						<td>'.$student->roll.'</td>
						<td>'.$student->dob .'</td>
						<td>'.($student->result_status == 1 ? '<span class="label label-success arrowed-in arrowed-in-right">Pass</span>' : '<span class="label label-danger arrowed-in arrowed-in-right">Fail</span>') . '</td>
						<td>'.($student->result_status == 1 ? '<span class="label label-info arr   owed-right arrowed-in">Ready To Promote</span>' : '<span class="label label-warning arrowed arrowed-in-left">Not Promoted</span>') .'</td>
						</tr>';
            }
            $html .='</tbody>';
			$html .= '<script>
						$(document).ready(function() {
							
							$(".table").dataTable( {
                                "pageLength": 500
                            });
						} );
					</script>';	
		} else {
			$html =' <tr><td colspan="6"><div class="alert alert-danger">No result found!</div></td></tr>';
		}										
			$data["html"]= $html;
		echo json_encode($data);
	}
	function promote_to_next_class() {
		$student_ids = post('s_id');
		$session_year_id = get_session('session');
		$next_session = $this->Student_model->get_next_session_year();
		if (!empty($student_ids)) {
			foreach ($student_ids as $id) {
				$session_wish_student_data = $this->Generalmodel->getDataWhere('session_wish_student_data', [
					'student' => $id,
					'session_id' => $session_year_id
				]);
	
				if (!empty($session_wish_student_data) && $session_wish_student_data[0]->result_status == 1) {
					$oldSection = $this->Generalmodel->getDataWhere('section',['id' => $session_wish_student_data[0]->section]);
					$section = $this->Generalmodel->getDataWhere('section',['class' => $session_wish_student_data[0]->class + 1,'section' => $oldSection[0]->section, 'session_year'=>$next_session->id]);
					// prx($section);	
					// prx($this->db->last_query());
					$new_session_data = [
						'session_id' => $next_session->id,
						'student' => $session_wish_student_data[0]->student,
						'student_code' => $session_wish_student_data[0]->student_code,
						'class' => $session_wish_student_data[0]->class + 1,
						'section' => $section[0]->id,
						'created_at' => date('Y-m-d H:i:s'),
						'created_by' => $this->session->userdata('user_id'),
					];
	
					$this->Generalmodel->getData('session_wish_student_data', '', '', '', '', 'insert', $new_session_data);
	
					$student_update_data = [
						'class' => $session_wish_student_data[0]->class + 1,
						'section' => $section[0]->id,
						'session_id' => $next_session->id,
						// 'roll' => '',  
					];
					$this->Generalmodel->getData('students_details', $id, 'id', '', '', 'update', $student_update_data);
					$fees = $data['fees'] = $this->Generalmodel->getDataWhere('fees',['class' => $session_wish_student_data[0]->class + 1, 'session_year'=>$next_session->id]);
					$fromData = [
						'session_year'=>$next_session->id,
						'student_id'=> $id,
						'class'=> $session_wish_student_data[0]->class,
						'month'=> 4,
						'payment_status'=> 'Y',
						'utr'=>'',
						'payment_type'=>'cash',
						'session_fees' => $fees[0]->session_fees,
						'academic_fees' => $fees[0]->academic_fees,
						'tuition_fees' => $fees[0]->tuition_fees,
						'monthly_fees' => $fees[0]->monthly_fees,
						'sports_fees' => $fees[0]->sports_fees,
						'library_fees' => $fees[0]->library_fees,
						'lab_fees' => $fees[0]->lab_fees,
						'other_curriculum_fees' => $fees[0]->other_curriculum_fees,
						'created_by'=>$this->session->userdata('user_id'),
						'created_at'=>date('Y-m-d H:i:s'),
						'payment_date'=>date('Y-m-d H:i:s'),
					];
					$res = $this->Generalmodel->getData('student_payment_details',post('id'),'id','','','insert',$fromData);
					$res = $this->Student_model->genareteFeesPaymentData($id, $session_wish_student_data[0]->class, $next_session->id);
				}
			}
			$result = ['html' => '', 'message' => 'Promoted successfully.', 'status' => 'success'];
		} else {
			$result = ['html' => '', 'message' => 'No students found for promotion.', 'status' => 'error'];
		}
		echo json_encode($result);
	}
	

}
?>
