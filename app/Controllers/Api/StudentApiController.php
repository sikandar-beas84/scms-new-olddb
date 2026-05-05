<?php

namespace App\Controllers\Api;

use App\Models\Api\StudentApiModel;
use App\Models\Api\ConfigurationApiModel;
use App\Models\Api\StudentFeeStructureApiModel;
use App\Models\Api\StudentTransactionAPiModel;
use App\Models\SessionYearModel;
use App\Models\Api\ParentEventsApiModel;

class StudentApiController extends BaseApiController
{
    public function student_details()
    {
        $model = new StudentApiModel();

        $user = $this->request->user;
        $student_id = $user->user_id;
        $code = $user->code;
        $dept_id = $user->dept_id;
        $session_year_id = $user->session_year_id;
        $session_year_name = $user->session_year_name;
        //print_r($user); die();

        $data = $model->get_student_details_by_id($code, $session_year_id);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Student list fetched',
            'data'    => $data
        ]);
    }

    public function student_session_year()
    {
        
        $sessionYearModel = new SessionYearModel();
        $session_year = $sessionYearModel->orderBy('id', 'DESC')->findAll();

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Student Session Year fetched',
            'data'    => $session_year
        ]);
    }

    public function parent_events()
    {
        
        $parentEventsApiModel = new ParentEventsApiModel();
        $session_year = $parentEventsApiModel->orderBy('id', 'DESC')->findAll();

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Student Parent Events fetched',
            'data'    => $session_year
        ]);
    }

    public function student_exam_date()
    {
        $model = new StudentApiModel();

        $user = $this->request->user;
        $code = $user->code;
        $session_year_id = $user->session_year_id;


        $student_details = $model->student_details_by_id($code, $session_year_id);
        $class_id = $student_details['class_id'];

        $student_exam_details = $model->get_student_exam_date($class_id, $session_year_id);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Student Exam list fetched',
            'data'    => $student_exam_details
        ]);
    }

    public function student_fee_structure()
    {
        $model = new StudentApiModel();

        $user = $this->request->user;
        $code = $user->code;
        $month_id = $this->request->getPost('month_id');

        $fee_structure = $model->get_students_fee_structure($code,$month_id);
        //print_r($month_id); die();


        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Student Fees Structure fetched',
            'data'    => $fee_structure
        ]);
    }

    public function student_fee_collection()
    {
        $model = new StudentApiModel();

        $user = $this->request->user;
        $code = $user->code;
        $session_year_id = $user->session_year_id;
        $student_details = $model->get_student_details_by_id($code, $session_year_id);
        
        $start_date = $this->request->getPost('start_date') ?? '';
        $end_date = $this->request->getPost('end_date') ?? '';

        $class_id = $student_details['class_id'];
        $user_id = $user->user_id ?? '';
        $payment_mode = $this->request->getPost('payment_mode') ?? '';
        $payment_month = $this->request->getPost('payment_month') ?? '';
        $student_code = $user->code ?? '';
        $bus_user_id = $this->request->getPost('bus_user_id') ?? '';
        $date_filter_used = $this->request->getPost('date_filter_used') ?? 1;

        // echo "start_date=".$start_date."<br>";
        // echo "end_date=".$end_date."<br>";
        // echo "class_id=".$class_id."<br>";
        // echo "user_id=".$user_id."<br>";
        // echo "payment_mode=".$payment_mode."<br>";
        // echo "payment_month=".$payment_month."<br>";
        // echo "student_code=".$student_code."<br>";
        // echo "bus_user_id=".$bus_user_id."<br>";
        // echo "date_filter_used=".$date_filter_used."<br>";
        // exit;

        $collection_details =  [];
        if( !empty($start_date) && !empty($end_date) ) {
            $registrationFeesModel = new StudentApiModel();
            $collection_details = $registrationFeesModel->getAcademicPaymentsByDate($session_year_id, $start_date, $end_date, $class_id, $user_id, $payment_mode, $payment_month, $student_code, $bus_user_id, $date_filter_used);
        }


        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Student Fees Colection fetched',
            'data'    => $collection_details
        ]);
    }

    public function student_invoice()
    {
        $studentModel = new StudentApiModel();
        $configurationModel = new ConfigurationApiModel();
        $studentFeeStructureModel = new StudentFeeStructureApiModel();
        $studentTransactionModel = new StudentTransactionAPiModel();

        $user = $this->request->user;
        $user_id = $user->user_id;
        $session_year_id = $user->session_year_id;
        $sCode = $user->code;
        //$session_year_id = $this->request->getPost('session_year_id');
        //$sCode = $this->request->getPost('code');
        //print_r($ids); die();

        $pay_mnth_ids = [];
        $ids = [];
        $data = [];
        $dueMonths = [];
        $amount = 0;
        $fine = 0;
        $busFine = 0;
        
        $due_amount = 0;
        $adv_amount = 0;
        
        $totalamount=0;
        $bus_services=0;
        $tuition_fee=0;
        $security_deposite=0;
        $development_fee=0;
        $exam_fee=0;
        $festival_celebration_fee=0;
        $games_sports_fee=0;
        $audio_visual_lab_fee=0;
        $library_fee=0;
        $electricity_maintenance_fee=0;
        $computer_fee=0;        
        //$session_charges=0;
        $admission_fee=0;
        
        $tuition_fine_per_month = 0;
        $tuition_fine_per_month = $configurationModel->get_configuration_by_key('tuition_fee_fine_per_month');
        
        $bus_fine_per_month = 0;
        $bus_fine_per_month = $configurationModel->get_configuration_by_key('bus_fee_fine_per_month');
        
        $ids = $this->request->getPost('ids');
        $ids = explode(',', $ids);
        $ids = array_unique($ids);
        
        //$sCode = $this->request->getPost('sCode');
        $admsnBusDates = $studentModel->get_admsn_bus_date($sCode, $session_year_id);
        
        $date = date('Y-m-d');
        $admsnDate = $admsnBusDates['admission_date'] ?? '';
        $busDate = $admsnBusDates['bus_alloted_date'] ?? '';

        
        // Need to add loop for ids
        foreach($ids as $id){
            $totalamount = 0; //  RESET HERE
            $pay_mnth_ids[] = $id;

            $get_student_fee_structure_details = $studentFeeStructureModel
                ->where('id', $id)
                ->where('session_year_id', $session_year_id)
                ->groupStart()
                    ->where('ad_payment_status', 0)
                    ->orWhere('bus_payment_status', 0)
                ->groupEnd()
                ->first();
            

            $cons_admission_fee = $get_student_fee_structure_details['cons_admission_fee'] ?? 0;   
            $cons_development_fee = $get_student_fee_structure_details['cons_development_fee'] ?? 0;
            $cons_exam_fee = $get_student_fee_structure_details['cons_exam_fee'] ?? 0;
            $cons_festival_celebration_fee = $get_student_fee_structure_details['cons_festival_celebration_fee'] ?? 0;
            $cons_games_sports_fee = $get_student_fee_structure_details['cons_games_sports_fee'] ?? 0;
            $cons_audio_visual_lab_fee = $get_student_fee_structure_details['cons_audio_visual_lab_fee'] ?? 0;
            $cons_library_fee = $get_student_fee_structure_details['cons_library_fee'] ?? 0;
            $cons_electricity_maintenance_fee = $get_student_fee_structure_details['cons_electricity_maintenance_fee'] ?? 0;
            $cons_computer_fee = $get_student_fee_structure_details['cons_computer_fee'] ?? 0;
            $cons_security_deposite = $get_student_fee_structure_details['cons_security_deposite'] ?? 0;
            $cons_tuition_fee = $get_student_fee_structure_details['cons_tuition_fee'] ?? 0;
            $cons_bus_services = $get_student_fee_structure_details['cons_bus_services'] ?? 0;

            $init_admission_fee = $get_student_fee_structure_details['admission_fee'] ?? 0;
            $init_development_fee = $get_student_fee_structure_details['development_fee'] ?? 0;
            $init_exam_fee = $get_student_fee_structure_details['exam_fee'] ?? 0;
            $init_festival_celebration_fee = $get_student_fee_structure_details['festival_celebration_fee'] ?? 0;
            $init_games_sports_fee = $get_student_fee_structure_details['games_sports_fee'] ?? 0;
            $init_audio_visual_lab_fee = $get_student_fee_structure_details['audio_visual_lab_fee'] ?? 0;
            $init_library_fee = $get_student_fee_structure_details['library_fee'] ?? 0;
            $init_electricity_maintenance_fee = $get_student_fee_structure_details['electricity_maintenance_fee'] ?? 0;
            $init_computer_fee = $get_student_fee_structure_details['computer_fee'] ?? 0;
            $init_security_deposite = $get_student_fee_structure_details['security_deposite'] ?? 0;
            $init_tuition_fee = $get_student_fee_structure_details['tuition_fee'] ?? 0;
            $init_bus_services = $get_student_fee_structure_details['bus_services'] ?? 0;

            //admission_charge
            $admission_fee = $init_admission_fee - $cons_admission_fee;

            //development_fee
            $development_fee = $init_development_fee - $cons_development_fee;

            //exam_fee
            $exam_fee = $init_exam_fee - $cons_exam_fee;

            //festival_celebration_fee
            $festival_celebration_fee = $init_festival_celebration_fee - $cons_festival_celebration_fee;

            //games_sports_fee
            $games_sports_fee = $init_games_sports_fee - $cons_games_sports_fee;

            //audio_visual_lab_fee
            $audio_visual_lab_fee = $init_audio_visual_lab_fee - $cons_audio_visual_lab_fee;

            //library_fee
            $library_fee = $init_library_fee - $cons_library_fee;

            //electricity_maintenance_fee
            $electricity_maintenance_fee = $init_electricity_maintenance_fee - $cons_electricity_maintenance_fee;

            //computer_fee
            $computer_fee = $init_computer_fee - $cons_computer_fee;

            //security_deposite
            $security_deposite = $init_security_deposite - $cons_security_deposite;

            //tution
            $tuition_fee = $init_tuition_fee - $cons_tuition_fee;

            //bus service
            $bus_services = $init_bus_services - $cons_bus_services;


            // $totalamount = $bus_services+$tuition_fee+$security_deposite+$development_fee+$exam_fee+$festival_celebration_fee+$games_sports_fee+$audio_visual_lab_fee+$library_fee+$electricity_maintenance_fee+$computer_fee+$admission_fee;


            // $dueAmount = $this->student_model->get_mnth_due_fee($id);
            $dueAmount = $studentFeeStructureModel
                ->select('
                    ad_payment_status,
                    bus_payment_status,
                    created_date,
                    bus_payment_date,
                    payment_due_date,
                    fine,
                    admission_fee,
                    session_charges,
                    security_deposite,
                    tuition_fee,
                    (fine + admission_fee + session_charges + security_deposite + tuition_fee) AS total
                ')
                ->where('id', $id)
                ->first();

            //$dueBusAmount = $this->student_model->get_due_bus_fee($id);

            // Admission related fees
            if (isset($dueAmount['ad_payment_status']) && $dueAmount['ad_payment_status'] == 0) {
                $totalamount += $tuition_fee+$security_deposite+$development_fee+$exam_fee+$festival_celebration_fee+$games_sports_fee+$audio_visual_lab_fee+$library_fee+$electricity_maintenance_fee+$computer_fee+$admission_fee;
            }

            // Bus fee
            if (isset($dueAmount['bus_payment_status']) && $dueAmount['bus_payment_status'] == 0) {
                $totalamount += $bus_services;
            }
    
            $payment_due_date = date('Y-m-d', strtotime($dueAmount['payment_due_date']));         
            $payment_due_date = $dueAmount['payment_due_date'];           
            
            $datetime1 = date_create($payment_due_date);
            $datetime2 = date_create($date);
            $interval = date_diff($datetime1, $datetime2);    
            $no_of_days = $interval->format("%R%a");
            
            $datetime3 = date('Y-m-d',strtotime($payment_due_date));
            $datetime4 = date('Y-m-d',strtotime($admsnDate));

            if($dueAmount['ad_payment_status'] == 0 && $datetime3 < $datetime4){
                $fine +=0;
            }elseif($dueAmount['ad_payment_status'] == 0 && $no_of_days>0){
                $fine += $no_of_days*$tuition_fine_per_month;   
            }else{
                $fine +=0;
            }

            $datetime5 = date('Y-m-d',strtotime($payment_due_date));
            $datetime6 = date('Y-m-d',strtotime($busDate));

            if($dueAmount['bus_payment_status'] == 0 && $admsnBusDates['stoppage'] != 0 && $datetime5 < $datetime6){
                $busFine +=0;
            }elseif($dueAmount['bus_payment_status'] == 0 && $admsnBusDates['stoppage'] != 0 && $no_of_days>0){             
                $busFine += $no_of_days*$bus_fine_per_month;    
            }else{
                $busFine +=0;
            }
            
            $amount += $totalamount;
            // $totalCalamount = (int)$amount+(int)$fine+(int)$busFine;
        }

        //  AFTER LOOP
        $totalCalamount = (int)$amount + (int)$fine + (int)$busFine;

        $stuTranDetails = $studentTransactionModel
                ->where('student_code', $sCode)
                ->where('session_year_id', $session_year_id)
                ->first();

        // $stuTranDetails = $studentTransactionModel->get_student_trans_details($sCode);
        
        if(isset($stuTranDetails['due_amount']) && $stuTranDetails['due_amount'] !=0){
            $due_amount = $stuTranDetails['due_amount'];      
        }else{
            $due_amount = 0;
        }
        
        if(isset($stuTranDetails['advanced_amount']) && $stuTranDetails['advanced_amount'] !=0){
            $adv_amount = $stuTranDetails['advanced_amount'];     
        }else{
            $adv_amount = 0;
        }
        
        $finalAmount = 0;
        $remainAdvAmount = 0;
        
        $finalAmount = $totalCalamount + $due_amount;
        
        if($adv_amount >= $finalAmount){
            $remainAdvAmount = $adv_amount-$finalAmount;
            $finalAmount = 0;
        }else{
            $finalAmount = $finalAmount-$adv_amount;
            $remainAdvAmount = 0;           
        }


        $session_pay_mnth_id = array(
            "session_pay_mnth_id"   => $pay_mnth_ids,
            "payment_amount"        => $finalAmount,
            "fine"                  => $fine,
            "bus_fee_fine"          => $busFine,    
            "due_amount"            => $due_amount,
            "adv_amount"            => $adv_amount,
            "final_adv_amount"      => $remainAdvAmount,
            "final_due_amount"      => 0
        );          
        
        $data['tuition_fine']       = $fine;
        $data['bus_fine']           = $busFine;     
        $data['totalCalamount']     = $finalAmount;     
        $data['due_amount']         = $due_amount;
        $data['adv_amount']         = $adv_amount;
        $data['final_adv_amount']   = $remainAdvAmount;
        $data['final_due_amount']   = 0;

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Student Invoice fetched',
            'data'    => $data
        ]);
    }
}