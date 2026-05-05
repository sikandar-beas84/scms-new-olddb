<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Fees extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Student_model');
        $this->load->model('Common_model');
		date_default_timezone_set('Asia/Kolkata');
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }

	}

	public function index(){
	   // prx(get_session('user_type'));
        $head['title'] = $data['page_title'] =  'Collect Fee';
        $fees = $data['fees'] = $this->Generalmodel->getDataWhere('student_payment_details',['student_id' => $this->uri->segment(4), 'session_year'=>get_session('session')], 'ASC', '12');
        $student = $data['student'] = $this->Student_model->get_students_full_details($this->uri->segment(4));
        // prx($student);
        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
		$this->load->view('include/breadcrumb');
		$this->load->view('student/collect_fees');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}
	public function studentfees(){
        $head['title'] = $data['page_title'] =  'Collect Fee';
        $fees = $data['fees'] = $this->Generalmodel->getDataWhere('student_payment_details',['student_id' => get_session('user_id'), 'session_year'=>get_session('session')]);
        // prx($fees);
        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
		$this->load->view('include/breadcrumb');
		$this->load->view('student/collect_fees');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}
    public function getFeesDataById(){
        $fees  = $this->Generalmodel->getDataWhere('student_payment_details',['id' => post('id')]);
        // prx($fees);
        if($fees):
            $result = array('data' =>$fees, 'message'=>post('action').' successfully.', 'status' => 'success');
        else:
            $result = array('data' =>$fees, 'message'=>'Something went to wrong.', 'status' => 'error');
        endif;
        $obj = (object) array_merge((array) $result,update_csrf_session());
        echo json_encode($obj);
    }
    public function getMultiMonthFeesDataById(){
                // prx(post('id'));
       $session_fees = 0;
        $academic_fees = 0;
        $tuition_fees = 0;
        $monthly_fees = 0;
        $sports_fees = 0;
        $library_fees = 0;
        $lab_fees = 0;
        $other_curriculum_fees = 0;
        $three = 0;
        $sec = 0;
        $first = 0;
        $fine = 0;
        $payment_count = 0;
        $month = 0;
        foreach(post('id') as $v){
            // pr($v);
            $fees  = $this->Generalmodel->getDataWhere('student_payment_details',['id' => $v]);
            $session_fees += $fees[0]->session_fees ?? 0;
            $academic_fees += $fees[0]->academic_fees ?? 0;
            $tuition_fees += $fees[0]->tuition_fees ?? 0;
            $monthly_fees += $fees[0]->monthly_fees ?? 0;
            $sports_fees += $fees[0]->sports_fees ?? 0;
            $library_fees += $fees[0]->library_fees ?? 0;
            $lab_fees += $fees[0]->lab_fees ?? 0;
            $other_curriculum_fees += $fees[0]->other_curriculum_fees ?? 0;
            $three += $fees[0]->payment_amount_3rd ?? 0;
            $sec += $fees[0]->payment_amount_2nd ?? 0;
            $first += $fees[0]->payment_amount_1st ?? 0;
            $payment_count += $fees[0]->payment_count ?? 0;
            $fine += $fees[0]->fine ?? 0;
            $month = $fees[0]->month ?? 0;
        }
    // Prepare data
    $data = [
        'session_fees' => $session_fees,
        'admission_fees' => $academic_fees,
        'tuition_fees' => $tuition_fees,
        'development_fees' => $monthly_fees,
        'misc_fees' => $other_curriculum_fees,
        'fine' => $fine,
        // 'sports_fees' => $sports_fees,
        // 'library_fees' => $library_fees,
        // 'lab_fees' => $lab_fees,
        'payment_amount_3rd' => $sec,
        'payment_amount_2nd' => $three,
        'payment_amount_1st' => $first,
        'payment_count' => $payment_count,
        'month' => $month,
    ];
        // prx($fees);
        if($fees):
            $result = array('data' =>$data, 'message'=>post('action').' successfully.', 'status' => 'success');
        else:
            $result = array('data' =>$data, 'message'=>'Something went to wrong.', 'status' => 'error');
        endif;
        $obj = (object) array_merge((array) $result,update_csrf_session());
        echo json_encode($obj);
    }

    public function payment() {
        $ids = post('id');
        if (!is_array($ids)) {
            $ids = [$ids]; 
            sort($ids);
        }
        // prx($ids);
        $utrNumber = post('utrNumber');
        $paymentType = post('payment_type');
        $amount = post('amount');
        $html = '';
        $message = '';
        $status = 'error';

        foreach ($ids as $id) {
            // echo $id;
            // echo "<br>";
            // Fetch fee details
            $fees = $this->Generalmodel->getDataWhere('student_payment_details', ['id' => $id]);
            if (empty($fees)) {
                $message = "Fee details not found for ID: $id.";
                continue;
            }

            $fees = $fees[0]; // Since `getDataWhere` returns an array, take the first result
            $student = $this->Generalmodel->getDataWhere('students_details', ['id' => $fees->student_id]);
            if (empty($student)) {
                $message = "Student details not found for ID: $fees->student_id.";
                continue;
            }

            $student = $student[0];
            $class = $this->Generalmodel->getDataWhere('class', ['id' => $student->class]);

            // Check for previous month payment
            if ($fees->month != 4) {
                $preMonthPayment = $this->Generalmodel->getDataWhere('student_payment_details', [
                    'student_id' => $fees->student_id,
                    'session_year' => $fees->session_year,
                    'month' => $fees->month - 1
                ]);
                // pr($fees->month);
                if (!empty($preMonthPayment) && $preMonthPayment[0]->payment_status == 'N') {
                    $message = $fees->month."Your previous month payment is due.".$id;
                    continue;
                }
            }
                // prx($preMonthPayment);
            $transactionId = 'GPS-TXN-' . date('Ymd-His') . '-' . rand(1000, 9999);
            // Update payment details
            // $updateData = [
            //     'payment_status' => 'Y',
            //     'utr' => $utrNumber,
            //     'payment_type' => $paymentType,
            //     'collected_by' => $this->session->userdata('user_id'),
            //     'payment_date' => date('Y-m-d H:i:s'),
            //     'transaction_id' => $transactionId ,
            //     'payment_count' => $fees[0]->payment_count + 1,
            // ];
                $updateData['payment_count'] =  $fees->payment_count + 1;
            if($fees->payment_count == 0){
                $updateData['payment_type'] =  $paymentType;
                $updateData['transaction_id'] =  $transactionId;
                $updateData['utr'] =  $utrNumber;
                $updateData['payment_amount_1st'] =  $amount;
                $updateData['payment_date'] =  date('Y-m-d H:i:s');
                $updateData['collected_by'] =  $this->session->userdata('user_id');
            }elseif($fees->payment_count == 1){
                $updateData['payment_type_2nd'] =  $paymentType;
                $updateData['transaction_id_2nd'] =  $transactionId;
                $updateData['payment_amount_2nd'] =  $amount;
                $updateData['utr_2nd'] =  $utrNumber;
                $updateData['payment_date_2nd'] =  date('Y-m-d H:i:s');
                $updateData['collected_by_2nd'] =  $this->session->userdata('user_id');
            }elseif($fees->payment_count == 2){
                $updateData['payment_type_3rd'] =  $paymentType;
                $updateData['transaction_id_3rd'] =  $transactionId;
                $updateData['payment_amount_3rd'] =  $amount;
                $updateData['utr_3rd'] =  $utrNumber;
                $updateData['payment_date_3rd'] =  date('Y-m-d H:i:s');
                $updateData['collected_by_3rd'] =  $this->session->userdata('user_id');
            }
            if ($fees->month != 4) {
                    $updateData['payment_status'] =  'Y';
            }else{
                if(($fees->session_fees+$fees->academic_fees+$fees->tuition_fees+$fees->monthly_fees+$fees->other_curriculum_fees+$fees->fine) == ($fees->payment_amount_1st + $fees->payment_amount_2nd +$fees->payment_amount_3rd + $amount)){
                    $updateData['payment_status'] =  'Y';
                }
            }
            $res = $this->Generalmodel->getData('student_payment_details', $id, 'id', '', '', 'update', $updateData);
            // pr($updateData);
            // pr($res);
            if(post('is_first_payment') == 'Y'){
                $student_payment_details = $this->Generalmodel->getData('student_payment_details',$id,'id','','','get','');
                $student = $data['student'] = $this->Generalmodel->getDataWhere('students_details',['id' => $student_payment_details[0]->student_id, 'session_id'=>$this->session->userdata('session')]);
                $studentId = str_pad($student[0]->id, 3, '0', STR_PAD_LEFT);
                $studentCode =  'GPS-'.$studentId;
                $studentsData = [
                    'username'=>$studentCode,
                    'password'=>md5($student[0]->father_mobile_no),
                    'first_name'=>$student[0]->student_name,
                    'last_name'=>'',
                    'email'=>$student[0]->email_id,
                    'phone'=>$student[0]->phone,
                    'date_of_birth'=>$student[0]->dob,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'created_by'=>$this->session->userdata('user_id'),
                ];
                $res = $this->Generalmodel->getData('students','','','','','insert',$studentsData);
                $fromData = [
                    'student_table_id'=>$this->db->insert_id(),
                    'application_status'=>'student',
                    'application_action_by'=>$this->session->userdata('user_id'),
                    'application_action_at'=>date('Y-m-d H:i:s'),
                ];
                $fromData['student_code'] =  $studentCode;
                $res = $this->Generalmodel->getData('students_details',$student[0]->id,'id','','','update',$fromData);
                $session_wish_student_data = [
                    'session_id'=> get_session('session'),
                    'student'=>$student[0]->id,
                    'student_code'=>$student[0]->admission_form_no,
                    'class'=>$student[0]->class,
                    'section'=>$student[0]->section,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'created_by'=>$this->session->userdata('user_id'),
                ];
                $session_wish_student_data_result = $this->Generalmodel->getData('session_wish_student_data','','','','','insert',$session_wish_student_data);
                
            }
            // prx($student);
                if ($res) {
                    if (!is_array(post('id'))) {
                        $fees = $this->Generalmodel->getDataWhere('student_payment_details', ['id' => $id]);
                    $html = $this->load->view('student/admissionInvoice', [
                        'fees' => $fees,
                        'student' => $student,
                        'class' => $class
                    ], TRUE);
                    }else{
                        $html = '';
                    }
                    $message = 'Payment successful.';
                    $status = 'success';
                } else {
                    $message = 'Failed to update payment.';
                }
            }
    
            // Return final response
            $result = [ 
                'html' => $html,
                'message' => $message,
                'status' => $status
            ];
    
            echo json_encode((object) array_merge($result, update_csrf_session()));
        }

    function getInvoice(){
        $data['session'] = $fees  = $this->Generalmodel->getDataWhere('session',['id' => get_session('session')]);
        $data['fees'] = $fees  = $this->Generalmodel->getDataWhere('student_payment_details',['id' => post('id')]);
        $student = $data['student'] = $this->Student_model->get_students_full_details($fees[0]->student_id);
        // prx($student);
        $data['class'] = $this->Generalmodel->getDataWhere('class',['id' => $student->class]);
        $html = $this->load->view('student/feesInvoice',$data, TRUE);
        if($html){
			$result = array('html' => $html, 'message'=>'Successfully.', 'status' => 'success');
		}else{
			$result = array( 'message'=>'Something Went Wrong Please Try Again.', 'status' => 'error');
		}
        $obj = (object) array_merge((array) $result);
        echo json_encode($obj);
    }
}
?>
