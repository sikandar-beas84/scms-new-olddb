<?php
namespace App\Controllers\Admin;;

use CodeIgniter\Controller;

// namespace App\Controllers\Admin;

// use App\Controllers\BaseController;

use App\Models\ClassModel;
use App\Models\StudentModel;
use App\Models\StudentDetailsModel;
use App\Models\ConfigurationModel;
use App\Models\StudentFeeStructureModel;
use App\Models\StudentFeeInvoiceModel;
use App\Models\SessionYearModel;
use App\Models\AdminUserModel;
use App\Models\LoginSessionModel;
use App\Models\StudentStationaryItemsModel;
use App\Models\StudentTransactionModel;
use App\Models\PaymentOrderModel;


class OnlinePayment extends Controller
{
	public function index()
	{
		$data['title'] = "Test Online Payment";

		echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        echo view('online-payment-test', $data);        
        echo view('admin/common/footer', $data);
	}

	/**
	 * Need to work on bus fine area and 4th Month Online Payment
	 * */ 
	public function ccavenue_response_handler()
	{

		$data = [];
		$merchant_id = '227678';
		$working_key = '80EE0DCADBEE34DC409A6F550B92630E';//Shared by CCAVENUES
		$data['access_code'] = 'AVCO86GH94AD42OCDA';//Shared by CCAVENUES

		$encResponse = $this->request->getPost('encResp');

		$rcvdString = decrypt($encResponse, $working_key);
		$decryptValues = explode('&', $rcvdString);
		$dataSize = sizeof($decryptValues);

		$order_id = "";
		$tracking_id = "";
		$bank_ref_no = "";
		$order_status = "";
		$track_info = "";
		$amount_info = "";
		$stu_code = "";
		$stu_name = "";
		$response_user_id = "";
		$response_year_id = "";
		$response_loggedin_user_id = "";
		$status_message = "";

		$data['html']  = '<div class="col-md-12">';
        $selId = array();

        $response_sell_id = '';
        for ($i = 0; $i < $dataSize; $i++) {
        	$information = explode('=', $decryptValues[$i]);
			if ($i == 0) $order_id = $information[1];
			if ($i == 1) $tracking_id = $information[1];
			if ($i == 2) $bank_ref_no = $information[1];
			if ($i == 3) $order_status = $information[1];			
			if ($i == 1) $track_info = $information[1];
			if ($i == 8) $status_message = $information[1];
			if ($i == 10) $amount_info = $information[1];
			if ($i == 29) $stu_code = $information[1];			
			if ($i == 30) $stu_name = $information[1];
			if ($i == 26) $response_sell_id = $information[1];
			if ($i == 27) $response_user_id = $information[1];
			
			if ($i == 27) {
			    $marge_user_year_sell_id = explode('#', $information[1]);
			    $response_user_id = $marge_user_year_sell_id[0]; // Student ID
			    $response_year_id = $marge_user_year_sell_id[1]; // Session Year ID
			    $response_sell_id = $marge_user_year_sell_id[2]; // Transction ID
			    $response_loggedin_user_id = $marge_user_year_sell_id[3]; // Logged In User ID
			}
        }

        if( $response_sell_id != "" ) {
		    $selId = explode(',', $response_sell_id);
		}
		// else{
        //    $selId[] = 4;
        // }

		// echo "<pre>"; print_r(session()->get());
		// echo "<pre>"; print_r($rcvdString);
		// echo "<pre>"; print_r($decryptValues);
		// echo "<pre>"; print_r($this->request->getPost());
		// pr($encResponse);

        $this->restoreLoggedInUserSessionAfterPayment($response_loggedin_user_id, $response_year_id); // Set Session
        $getCurrentUserFullname = '';
        if(isset($response_loggedin_user_id) && $response_loggedin_user_id != '') {
        	$getCurrentUserFullname = get_user_full_name_by_id($response_loggedin_user_id);
        }

        $configurationModel = new ConfigurationModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();
        $studentFeeInvoiceModel = new StudentFeeInvoiceModel();
        $studentDetailsModel = new StudentDetailsModel();
        $studentModel = new StudentModel();

        if (($order_status === "Success" || $order_status === "Shipped")) {
        	foreach($selId as $id){
				$fine = 0;
				$busFine = 0;

				// =====================================
				$tuition_fine_per_month = 0;
				$tuition_fine_per_month = $configurationModel->get_configuration_by_key('tuition_fee_fine_per_month');

				$bus_fine_per_month = 0;
				$bus_fine_per_month = $configurationModel->get_configuration_by_key('bus_fee_fine_per_month');

				$admsnBusDates = $studentDetailsModel->get_admsn_bus_date($stu_code);
        
		        $date = date('Y-m-d');
		        $admsnDate = $admsnBusDates['admission_date'] ?? '';
		        $busDate = $admsnBusDates['bus_alloted_date'] ?? '';

				$dueAmount = $studentFeeStructureModel
				->select('
				    bus_services,
				    ad_payment_status,
				    bus_payment_status,
				    created_date,
				    bus_payment_date,
				    payment_due_date,

				    COALESCE(fine,0) AS fine,
				    COALESCE(admission_fee,0) AS admission_fee,
				    COALESCE(session_charges,0) AS session_charges,
				    COALESCE(security_deposite,0) AS security_deposite,
				    COALESCE(tuition_fee,0) AS tuition_fee,

				    (
				        COALESCE(fine,0) +
				        COALESCE(admission_fee,0) +
				        COALESCE(session_charges,0) +
				        COALESCE(security_deposite,0) +
				        COALESCE(tuition_fee,0)
				    ) AS total,

				    (
				        (COALESCE(tuition_fee,0) - COALESCE(cons_tuition_fee,0)) +
				        (COALESCE(security_deposite,0) - COALESCE(cons_security_deposite,0)) +
				        (COALESCE(development_fee,0) - COALESCE(cons_development_fee,0)) +
				        (COALESCE(exam_fee,0) - COALESCE(cons_exam_fee,0)) +
				        (COALESCE(festival_celebration_fee,0) - COALESCE(cons_festival_celebration_fee,0)) +
				        (COALESCE(games_sports_fee,0) - COALESCE(cons_games_sports_fee,0)) +
				        (COALESCE(audio_visual_lab_fee,0) - COALESCE(cons_audio_visual_lab_fee,0)) +
				        (COALESCE(library_fee,0) - COALESCE(cons_library_fee,0)) +
				        (COALESCE(electricity_maintenance_fee,0) - COALESCE(cons_electricity_maintenance_fee,0)) +
				        (COALESCE(computer_fee,0) - COALESCE(cons_computer_fee,0)) +
				        (COALESCE(admission_fee,0) - COALESCE(cons_admission_fee,0))
				    ) AS academic_totalamount
				')
				->where('id', $id)
				->first();


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

	            $bus_services = ($dueAmount && $dueAmount['bus_payment_status'] == 0) ? $dueAmount['bus_services'] : 0;
	            $totalamount = (int) ($dueAmount['academic_totalamount'] ?? 0);
	            $tuition_fees_amount = (int) ($dueAmount['tuition_fee'] ?? 0);
	            // =====================================

				$updata['transaction_no'] 		= $order_id;
				
				if($bus_services > 0) {
				    $updata['bus_fee_fine']			= $fine;
				}
				
				$updata['payment_amount'] 		= $totalamount + $fine + $bus_services;
				$updata['remarks'] 				= "track_info#".$track_info;
				//pr($updata);
				
				if($totalamount > 0 || $dueAmount['ad_payment_status'] == 0){
					$updata['ad_payment_status']	= 1;
					$updata['ad_payment_mode']		= 'CCAvenue';
					$updata['t_user_id']			= $response_loggedin_user_id;
					$updata['added_by']				= $getCurrentUserFullname;
					$updata['payee_name']			= $stu_name;
					$updata['fine']					= $fine;
					$updata['academic_payment_amt'] = $totalamount;						
					$updata['created_date'] = date('Y-m-d');
				}
				
				$updata['bus_payment_status'] = 0;
				
				if($bus_services > 0 || $dueAmount['bus_payment_status'] == 0) {
					$updata['bus_payment_amt'] = $bus_services;
					$updata['bus_payment_mode'] = 'CCAvenue';					
					$updata['bus_payee_name'] = $stu_name;
					$updata['bus_t_user_id'] = $response_loggedin_user_id;
					$updata['bus_added_by'] = $getCurrentUserFullname;
					$updata['bus_payment_date']		= date('Y-m-d h:m:s');
					$updata['bus_payment_status']	= 1;
				}
				// echo 1;
				// pr($updata);
				$result = $studentFeeStructureModel->update($id,$updata);

				$data['html']  .="<br>Your Payment amount of ". urldecode($amount_info) ." is successful. Kindly note this transaction number ". urldecode($track_info) ." for future reference.";
			}
        } elseif ($order_status === "Aborted") {
			$data['html']  .="<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail.<br />".$status_message;
			
			$updataAborted['transaction_no'] 		= $order_id.'#'.$bank_ref_no .'#'. $order_status . '#' . $stu_code .'#'. $stu_name;
			// echo 2;
			// pr($updataAborted);
			foreach($selId as $id){
				$result = $studentFeeStructureModel->update($id, $updataAborted);
			}
		} else if ($order_status === "Failure") {
			$data['html']  .="<br><h3>Thank you for shopping with us.However,the transaction has been declined. If the amount is deducted from your account but the payment update is not showing then kindly send the transaction details to this number 7479036628 through WhatsApp with the Student ID</h3>";
			$updataFailure['transaction_no'] = $order_id .'#'.$bank_ref_no .'#'. $order_status . '#' . $stu_code .'#'. $stu_name;
			// echo 3;
			// pr($updataFailure);
			foreach($selId as $id){
				$result = $studentFeeStructureModel->update($id, $updataFailure);
			}
		} else {
			$data['html']  .="<br><h3>Security Error. Illegal access detected. If the amount is deducted from your account but the payment update is not showing then kindly send the transaction details to this number 7479036628 through WhatsApp with the Student ID</h3>";
			$updataElse['transaction_no'] = $order_id .'#'.$bank_ref_no .'#'. $order_status . '#' . $stu_code .'#'. $stu_name;
			// echo 4;
			// pr($updataElse);
			foreach($selId as $id){
				$result = $studentFeeStructureModel->update($id, $updataElse);
			}
		}

		$data['html']  .="<br><br>";
		
		
		$data['html']  .='<span style="color: red;">To See Payment Status Please </span><a href="'. base_url('admin/student/view-fee-structure/'.$stu_code) .'" class="btn btn-primary"> Click Here</a>';
		$data['html']  .="</div>";

		$data['title'] = "Generate Class ID Card";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        // echo view('admin/common/sidebar', $data);

        $data['stu_code']  = $stu_code;
        echo view('ccavenue_response', $data);
        echo view('admin/common/footer', $data);
	}

	protected function restoreLoggedInUserSessionAfterPayment($userId = null, $sessionYearId = null)
	{
		// check isset, null, and blank
	    if (
	        !isset($userId, $sessionYearId) ||
	        $userId === null || $userId === '' ||
	        $sessionYearId === null || $sessionYearId === ''
	    ) {
	        return;
	    }

		$userModel = new AdminUserModel();
        $sessionModel = new LoginSessionModel();
        $sessionYearModel = new SessionYearModel();

		$user = $userModel->where('id', $userId)->first();
		$getUserImage = $user['image'] ?? '';

		$sessionYearDetails = $sessionYearModel->where('id', $sessionYearId)->first();
		$existingSession = $sessionModel->where('user_id', $userId)->where('is_active', true)->first();

		// 🔐 Store session in CI session
		session()->set([
		    "session_year_id"       => $sessionYearId,
		    "session_year_name"     => $sessionYearDetails['session_name'],
		    "session_start_date"    => $sessionYearDetails['start_date'],
		    "session_end_date"      => $sessionYearDetails['end_date'],    

		    'user_id'               => $userId,
		    'dept_id'               => $user['dept_id'],
		    'code'                  => $user['code'],
		    'f_name'                => $user['first_name'],
		    'l_name'                => $user['last_name'],
		    'username'              => $user['email'],
		    'email'                 => $user['email'],
		    'userimage'             => $getUserImage,
		    'login_session_id'      => $existingSession['id'],
		    'isLoggedIn'            => true,
		    'lastActivity'          => time(),
		]);

		$currentLoginType = '';

		$deptLoginMap = [
		    1 => 'admin_logged_in',
		    2 => 'teacher_logged_in',
		    3 => 'student_logged_in',
		    4 => 'nonteaching_logged_in',
		    5 => 'groupd_logged_in',
		    6 => 'principal_logged_in',
		    7 => 'vendor_logged_in',
		    8 => 'specialadmin_logged_in',
		];

		if (isset($user['dept_id']) && array_key_exists($user['dept_id'], $deptLoginMap)) {
		    $currentLoginType = $deptLoginMap[$user['dept_id']];
		    session()->set([$currentLoginType => TRUE]);
		} else {
		    // Default (Super Admin / Unknown role)
		    $currentLoginType = 'superadmin_logged_in';
		    session()->set([$currentLoginType => TRUE]);
		}
	}

	public function ccavenue_response_handler_readmission()
	{

		$data = [];
		$merchant_id = '227678';
		$working_key = '80EE0DCADBEE34DC409A6F550B92630E';//Shared by CCAVENUES
		$data['access_code'] = 'AVCO86GH94AD42OCDA';//Shared by CCAVENUES

		$encResponse = $this->request->getPost('encResp');

		// $rcvdString = decrypt($encResponse, $working_key);
		// $decryptValues = explode('&', $rcvdString);
		// $dataSize = sizeof($decryptValues);

		$rcvdString = decrypt($encResponse, $working_key);
		parse_str($rcvdString, $decryptValues);
		$dataSize = sizeof($decryptValues);

		$order_id = "";
		$tracking_id = "";
		$bank_ref_no = "";
		$order_status = "";
		$track_info = "";
		$amount_info = "";
		$stu_code = "";
		$stu_name = "";
		$response_user_id = "";
		$response_year_id = "";
		$response_loggedin_user_id = "";
		$status_message = "";
		$response_sell_id = ''; // This is the student_fee_structure table ID's

		$data['html']  = '<div class="col-md-12">';

		$order_id = $decryptValues['order_id'] ?? '';
		$tracking_id = $decryptValues['tracking_id'] ?? '';
		$bank_ref_no = $decryptValues['bank_ref_no'] ?? '';
		$order_status = $decryptValues['order_status'] ?? '';
		$track_info = $decryptValues['tracking_id'] ?? '';
		$amount_info = (int) $decryptValues['amount'] ?? 0;
		$stu_code = $decryptValues['merchant_param4'] ?? '';
		$stu_name = $decryptValues['merchant_param5'] ?? '';

		$getUserYearSellDetails = $decryptValues['merchant_param2'] ?? '';
		if( $getUserYearSellDetails != '' ) {
			$marge_user_year_sell_id = explode('#', $getUserYearSellDetails);
			
			$response_user_id = $marge_user_year_sell_id[0]; // Student ID
		    $response_year_id = $marge_user_year_sell_id[1]; // Session Year ID
		    $response_sell_id = $marge_user_year_sell_id[2]; // Transction ID
		    $response_loggedin_user_id = $marge_user_year_sell_id[3]; // Logged In User ID
		}

		$selId = array();
		if( $response_sell_id != "" ) {
		    $selId = explode(',', $response_sell_id);
		}

		// $paymentData = json_decode(base64_decode($decryptValues['merchant_param1']), true);

		/*$paymentData = [];
		$encoded = session()->get('merchant_param1');
		if ($encoded) {
		    $paymentData = json_decode(base64_decode($encoded), true);
		}*/

		$getOrderId = $decryptValues['merchant_param1'] ?? '';
		$paymentOrderModel = new PaymentOrderModel();
		$paymentOrderData = $paymentOrderModel->where('id', $getOrderId)->first();
		$paymentData = json_decode($paymentOrderData['payment_data'], true);
		// pr($paymentData);
        
        $get_grand_total_fees = $paymentData['grand_total_fees'] ?? 0;
        $get_stoppage_fee = $paymentData['stoppage_fee'] ?? 0;
        $get_stationary_total = $paymentData['stationary_total'] ?? 0;
        $stationary_items = $paymentData['stationary_items'] ?? [];

        /*echo strlen($decryptValues['merchant_param1']);

        echo "<pre>"; print_r($decryptValues);
        echo "<pre>"; print_r("paymentData");
        echo "<pre>"; print_r( base64_decode($decryptValues['merchant_param1']) );
        echo "<pre>"; print_r( json_decode(base64_decode($decryptValues['merchant_param1']), true) );
        echo "<pre>"; print_r($paymentData);
        echo "<pre>"; print_r("paymentData");*/

        $getCurrentUserFullname = '';
        if(isset($response_loggedin_user_id) && $response_loggedin_user_id != '') {
        	$getCurrentUserFullname = get_user_full_name_by_id($response_loggedin_user_id);
        }

        $configurationModel = new ConfigurationModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();
        $studentFeeInvoiceModel = new StudentFeeInvoiceModel();
        $studentDetailsModel = new StudentDetailsModel();
        $studentModel = new StudentModel();

        if (($order_status === "Success" || $order_status === "Shipped")) {
        	foreach($selId as $id){
				$fine = 0;
				$busFine = 0;

				// =====================================
				$tuition_fine_per_month = 0;
				$tuition_fine_per_month = $configurationModel->get_configuration_by_key('tuition_fee_fine_per_month');

				$bus_fine_per_month = 0;
				$bus_fine_per_month = $configurationModel->get_configuration_by_key('bus_fee_fine_per_month');

				$admsnBusDates = $studentDetailsModel->get_admsn_bus_date($stu_code);
        
		        $date = date('Y-m-d');
		        $admsnDate = $admsnBusDates['admission_date'] ?? '';
		        $busDate = $admsnBusDates['bus_alloted_date'] ?? '';

				$dueAmount = $studentFeeStructureModel
				->select('
				    bus_services,
				    ad_payment_status,
				    bus_payment_status,
				    created_date,
				    bus_payment_date,
				    payment_due_date,

				    COALESCE(fine,0) AS fine,
				    COALESCE(admission_fee,0) AS admission_fee,
				    COALESCE(session_charges,0) AS session_charges,
				    COALESCE(security_deposite,0) AS security_deposite,
				    COALESCE(tuition_fee,0) AS tuition_fee,

				    (
				        COALESCE(fine,0) +
				        COALESCE(admission_fee,0) +
				        COALESCE(session_charges,0) +
				        COALESCE(security_deposite,0) +
				        COALESCE(tuition_fee,0)
				    ) AS total,

				    (
				        (COALESCE(tuition_fee,0) - COALESCE(cons_tuition_fee,0)) +
				        (COALESCE(security_deposite,0) - COALESCE(cons_security_deposite,0)) +
				        (COALESCE(development_fee,0) - COALESCE(cons_development_fee,0)) +
				        (COALESCE(exam_fee,0) - COALESCE(cons_exam_fee,0)) +
				        (COALESCE(festival_celebration_fee,0) - COALESCE(cons_festival_celebration_fee,0)) +
				        (COALESCE(games_sports_fee,0) - COALESCE(cons_games_sports_fee,0)) +
				        (COALESCE(audio_visual_lab_fee,0) - COALESCE(cons_audio_visual_lab_fee,0)) +
				        (COALESCE(library_fee,0) - COALESCE(cons_library_fee,0)) +
				        (COALESCE(electricity_maintenance_fee,0) - COALESCE(cons_electricity_maintenance_fee,0)) +
				        (COALESCE(computer_fee,0) - COALESCE(cons_computer_fee,0)) +
				        (COALESCE(admission_fee,0) - COALESCE(cons_admission_fee,0))
				    ) AS academic_totalamount
				')
				->where('id', $id)
				->first();


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

	            $bus_services = ($dueAmount && $dueAmount['bus_payment_status'] == 0) ? $dueAmount['bus_services'] : 0;
	            $totalamount = (int) ($dueAmount['academic_totalamount'] ?? 0);
	            $tuition_fees_amount = (int) ($dueAmount['tuition_fee'] ?? 0);

	            $get_payment_amount = $totalamount + $fine + $bus_services;
	            // =====================================

				$updata['transaction_no'] 		= $order_id;
				
				if($get_stoppage_fee > 0) {
				    $updata['bus_fee_fine']			= $fine;
				}
				

				// $updata['payment_amount'] 		= $amount_info;
				$updata['payment_amount'] 		= $get_payment_amount;
				$updata['total_stationary_fee'] = $get_stationary_total;
				$updata['remarks'] 				= "track_info#".$track_info;

				//pr($updata);
				
				if($totalamount > 0 || $dueAmount['ad_payment_status'] == 0){
					$updata['ad_payment_status']	= 1;
					$updata['ad_payment_mode']		= 'CCAvenue';
					$updata['t_user_id']			= $response_loggedin_user_id;
					$updata['added_by']				= $getCurrentUserFullname;
					$updata['payee_name']			= $stu_name;
					$updata['fine']					= $fine;

					$updata['admission_fee'] 				= $paymentData['admission_fee'] ?? 0;
					$updata['development_fee'] 				= $paymentData['development_fee'] ?? 0;
					$updata['exam_fee'] 					= $paymentData['exam_fee'] ?? 0;
					$updata['festival_celebration_fee'] 	= $paymentData['festival_celebration_fee'] ?? 0;
					$updata['games_sports_fee'] 			= $paymentData['games_sports_fee'] ?? 0;
					$updata['audio_visual_lab_fee'] 		= $paymentData['audio_visual_lab_fee'] ?? 0;
					$updata['library_fee'] 					= $paymentData['library_fee'] ?? 0;
					$updata['electricity_maintenance_fee']  = $paymentData['electricity_maintenance_fee'] ?? 0;
					$updata['computer_fee']  				= $paymentData['computer_fee'] ?? 0;
					$updata['security_deposite']  			= $paymentData['security_deposite'] ?? 0;
					$updata['tuition_fee']  				= $paymentData['tuition_fee'] ?? 0;
					$updata['stoppage_fee']  				= $paymentData['stoppage_fee'] ?? 0;
					$updata['total_stationary_fee']  		= $paymentData['stationary_total'] ?? 0;

					$updata['academic_payment_amt'] = $get_grand_total_fees;						
					$updata['created_date'] = date('Y-m-d');
				}
				
				$updata['bus_payment_status'] = 0;

				if($bus_services > 0 || $dueAmount['bus_payment_status'] == 0) {
					$updata['bus_payment_amt'] = $bus_services;
					$updata['bus_payment_mode'] = 'CCAvenue';					
					$updata['bus_payee_name'] = $stu_name;
					$updata['bus_t_user_id'] = $response_loggedin_user_id;
					$updata['bus_added_by'] = $getCurrentUserFullname;
					$updata['bus_payment_date']		= date('Y-m-d h:m:s');
					$updata['bus_payment_status']	= 1;
				}
				// echo 1;
				// pr($updata);
				$result = $studentFeeStructureModel->update($id,$updata);
				// $result = true;
				if( $result ) {
		            // Insert Fee Invoice
		            $studentFeeInvoiceModel = new StudentFeeInvoiceModel();
		            $feesInvoiceData = [
		                'form_no'                       => '',
		                'student_id'                    => $response_user_id,
		                'session_year_id'               => $response_year_id,
		                'admission_fee'                 => $paymentData['admission_fee'] ?? 0,
		                'development_fee'               => $paymentData['development_fee'] ?? 0,
		                'exam_fee'                      => $paymentData['exam_fee'] ?? 0,
		                'festival_celebration_fee'      => $paymentData['festival_celebration_fee'] ?? 0,
		                'games_sports_fee'              => $paymentData['games_sports_fee'] ?? 0,
		                'audio_visual_lab_fee'          => $paymentData['audio_visual_lab_fee'] ?? 0,
		                'library_fee'                   => $paymentData['library_fee'] ?? 0,
		                'electricity_maintenance_fee'   => $paymentData['electricity_maintenance_fee'] ?? 0,
		                'computer_fee'                  => $paymentData['computer_fee'] ?? 0,
		                'security_deposite'             => $paymentData['security_deposite'] ?? 0,
		                'tuition_fee'                   => $paymentData['tuition_fee'] ?? 0,
		                'stoppage_fee'                  => $paymentData['stoppage_fee'] ?? 0,
		                'grand_total_fees'              => $paymentData['grand_total_fees'] ?? 0,
		                'payment_amount'                => $paymentData['payment_amount'] ?? 0,
		                'payment_cheque_number'         => $paymentData['payment_cheque_number'] ?? null,
		                'payment_pos_bank_name'         => $paymentData['payment_pos_bank_name'] ?? null,
		                'payment_pos_reference_number'  => $paymentData['payment_pos_reference_number'] ?? null,
		                'remarks'                       => $paymentData['remarks'] ?? '',
		                'stationary_items'              => json_encode($paymentData['stationary_items'] ?? []),
		                'stationary_total'              => $paymentData['stationary_total'] ?? 0,
		                'tblc_items'                    => json_encode([]),
		                'tblc_total'                    => 0,
		                'created_at'                    => date('Y-m-d H:i:s'),
		                'created_by'                    => $response_loggedin_user_id,
		            ];
		            // echo "<pre>"; print_r($paymentData);
		            // echo "<pre>"; print_r($feesInvoiceData);

		            $studentFeeInvoiceModel->insert($feesInvoiceData, true);

		            // Insert Stationary Item
		            $studentStationaryItemsModel = new StudentStationaryItemsModel();
		            if( !empty($stationary_items) ) {
		                $item_names = array_column($stationary_items, 'item_name');
		                $item_ids   = array_column($stationary_items, 'id');
		                $item_qtys  = array_column($stationary_items, 'qty');
		                $item_price = array_column($stationary_items, 'price');

		                // Convert to comma-separated string
		                $item_names_str = implode(',', $item_names);
		                $item_ids_str   = implode(',', $item_ids);
		                $item_qtys_str  = implode(',', $item_qtys);
		                $item_price_str = implode(',', $item_price);

		                $stationaryData = array(
		                    'student_id'=> $response_user_id,
		                    'class_id'  => $paymentData['class_id'] ?? '', // class_id
		                    'class_code'=> $stu_code, // code
		                    'item_ids' => $item_ids_str,                       
		                    'item_qtys'=> $item_qtys_str,                      
		                    'item_price'=> $item_price_str,
		                    'price'     => $get_stationary_total,
		                    'payment_status' => 1,
		                    'payment_date' => date('Y-m-d'),
		                    'session_year_id'=> $response_year_id,
		                    'add_date'  => date('Y-m-d H:i:s'),
		                    'payment_mode' => 'CCAvenue',
		                    'cheque_number' => '',
		                    'pos_bank_name' => '',
		                    'pos_reference_number' => '',
		                    't_user_id' => $response_loggedin_user_id,
		                    'added_by' => $getCurrentUserFullname,
		                    'remarks' => ''
		                );
		                // echo "<pre>"; print_r($stationaryData);
		                
		                $stationaryResultId = $studentStationaryItemsModel->insert($stationaryData, true);
		            }

		            // insert student_transaction table
		            $studentTransactionModel = new StudentTransactionModel();
		            $studentTranData = array(
		                'student_code' => $stu_code,
		                'due_amount' => 0,
		                'advanced_amount' => 0,
		                'session_year_id' => $response_year_id
		            );
		            $student_tran_id = $studentTransactionModel->insert($studentTranData);
		        }

				$data['html']  .="<br>Your Payment amount of ". urldecode($amount_info) ." is successful. Kindly note this transaction number ". urldecode($track_info) ." for future reference.";
			}

			$paymentOrderModel->delete($getOrderId);
        } elseif ($order_status === "Aborted") {
			$data['html']  .="<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail.<br />".$status_message;
			
			$updataAborted['transaction_no'] 		= $order_id.'#'.$bank_ref_no .'#'. $order_status . '#' . $stu_code .'#'. $stu_name;
			// echo 2;
			// pr($updataAborted);
			foreach($selId as $id){
				$result = $studentFeeStructureModel->update($id, $updataAborted);
			}
		} else if ($order_status === "Failure") {
			$data['html']  .="<br><h3>Thank you for shopping with us.However,the transaction has been declined. If the amount is deducted from your account but the payment update is not showing then kindly send the transaction details to this number 7479036628 through WhatsApp with the Student ID</h3>";
			$updataFailure['transaction_no'] = $order_id .'#'.$bank_ref_no .'#'. $order_status . '#' . $stu_code .'#'. $stu_name;
			// echo 3;
			// pr($updataFailure);
			foreach($selId as $id){
				$result = $studentFeeStructureModel->update($id, $updataFailure);
			}
		} else {
			$data['html']  .="<br><h3>Security Error. Illegal access detected. If the amount is deducted from your account but the payment update is not showing then kindly send the transaction details to this number 7479036628 through WhatsApp with the Student ID</h3>";
			$updataElse['transaction_no'] = $order_id .'#'.$bank_ref_no .'#'. $order_status . '#' . $stu_code .'#'. $stu_name;
			// echo 4;
			// pr($updataElse);
			foreach($selId as $id){
				$result = $studentFeeStructureModel->update($id, $updataElse);
			}
		}

		$data['html']  .="<br><br>";
		
		
		$data['html']  .='<span style="color: red;">To See Payment Status Please </span><a href="'. base_url('admin/student/view-fee-structure/'.$stu_code) .'" class="btn btn-primary"> Click Here</a>';
		$data['html']  .="</div>";

		// session()->unset('merchant_param1');
		$this->restoreLoggedInUserSessionAfterPayment($response_loggedin_user_id, $response_year_id); // Set Session
        
        // pr("Sayan");
		$data['title'] = "Generate Class ID Card";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        // echo view('admin/common/sidebar', $data);

        $data['stu_code']  = $stu_code;
        echo view('ccavenue_response', $data);
        echo view('admin/common/footer', $data);
	}
}