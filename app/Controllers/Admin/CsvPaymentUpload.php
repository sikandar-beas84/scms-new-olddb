<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

use App\Models\StudentModel;
use App\Models\ConfigurationModel;
use App\Models\StudentFeeStructureModel;
use App\Models\StudentTransactionModel;
use App\Models\StudentFeeInvoiceModel;
use App\Models\StudentStationaryItemsModel;
use App\Models\ItemMasterModel;

use DateTime;
use DateInterval;
use DatePeriod;

class CsvPaymentUpload extends BaseController
{

	public function student_detail_import()
	{
		$data['title'] = "Student Detail Import";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        echo view('admin/csv-payment-upload/student-detail-import', $data);  

        echo view('admin/common/footer', $data);
	}

	public function bankpayment_studentdata_save()
	{
		$file = $this->request->getFile('bankonlinefile');

        if (!$file->isValid()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid file upload'
            ]);
        }

        if ($file->getExtension() !== 'csv') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Only CSV files allowed'
            ]);
        }

        $logPath = WRITEPATH . 'csv_logs/';
		if (!is_dir($logPath)) {
		    mkdir($logPath, 0777, true);
		}

		$logFile = $logPath . 'bankpayment_upload_' . date('Y-m-d_H-i-s') . '.txt';

        $csv = fopen($file->getTempName(), 'r');

        $lineNo = 0;
        $errors = [];
        $studentWithAdv = [];
        $stuTuiPayInc = [];
        $stuBusPayInc = [];

        // helper('date');

        // $studentModel = new \App\Models\StudentModel();
        // $csvModel     = new \App\Models\CsvuploadModel();
        $configModel  = new ConfigurationModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();
	    $studentTransactionModel = new StudentTransactionModel();

        $tuition_fine_per_month = $configModel->get_configuration_by_key('tuition_fee_fine_per_month');
        $bus_fine_per_month     = $configModel->get_configuration_by_key('bus_fee_fine_per_month');

     	while (($line = fgetcsv($csv)) !== FALSE) {
     		$lineNo++;
            $row_error = 0;

            $created_date = '';
            $student_code = '';
            $payment_amount = 0;

            // ✅ Date validation
            if (!empty(trim($line[0]))) {
                if (substr_count(trim($line[0]), "-") == 2 || substr_count(trim($line[0]), "/") == 2) {
                    $created_date = date('Y-m-d H:i:s', strtotime(trim($line[0])));
                } else {
                    $errors[] = "Wrong Date format -- Row No -- {$lineNo}";
                    $row_error++;
                }
            } else {
                $errors[] = "Date should not be blank -- Row No -- {$lineNo}";
                $row_error++;
            }

            // ✅ Student code validation
            if (!empty(trim($line[1]))) {
                $student_str = trim($line[1]);
                $student_y_id = explode("-", $student_str);
                $student_y = substr($student_y_id[0], -2);
                $student_id = substr($student_y_id[1] ?? '', 0, 4);

                if ($student_id == '') {
                    $errors[] = "Student Code invalid -- Row No -- {$lineNo}";
                    $row_error++;
                }

                $student_code = $student_y . '-' . $student_id;
            } else {
                $errors[] = "Student Code should not be blank -- Row No -- {$lineNo}";
                $row_error++;
            }

            // ✅ Payment validation
            if (!empty(trim($line[2]))) {
                $payment_amount = (float) trim($line[2]);
            } else {
                $errors[] = "Payment amount should not be blank -- Row No -- {$lineNo}";
                $row_error++;
            }

            if ($row_error > 0) {
                continue;
            }

            $startDate = new DateTime(session()->get('session_start_date'));
			$endDate = new DateTime(session()->get('session_end_date'));
			$periodInt = new DateInterval("P1M");
			$period = new DatePeriod( $startDate, $periodInt, $endDate );

			$currentLoggedInUserId = session()->get('user_id');
			$currentLoggedInUserName = session()->get('f_name').' '.session()->get('l_name');
			$get_student_name = student_name_by_code($student_code);

			foreach ($period as $key => $value) {
				$pMonthId = $value->format('m');
				$endSessionMonth = date('m', strtotime(session()->get('session_end_date')));
				

				if($pMonthId == $endSessionMonth){
					//echo 'lastmonth';
					if($payment_amount != 0){
						//get this month fee structure
						$PayMonth = $studentFeeStructureModel->get_fee_row_by_april_month($pMonthId, $student_code);
				        $fee_structure_id = $PayMonth['id'] ?? '';

				        if (!$PayMonth) {
				            $errors[] = "Invalid Student Code -- Row $lineNo";
				            continue;
				        }

						//month fee calculation start								
						$cons_tuition_fee = $PayMonth['cons_tuition_fee'] ?? 0;
						$cons_bus_services = $PayMonth['cons_bus_services'] ?? 0;
						
						$init_tuition_fee = $PayMonth['tuition_fee'] ?? 0;
						$init_bus_services = $PayMonth['bus_services'] ?? 0;
						
						
						//tution
						$tuition_fee = $init_tuition_fee - $cons_tuition_fee;
						//bus service
						$bus_services = $init_bus_services - $cons_bus_services;
						
						$totalamount = $bus_services + $tuition_fee;
						if($totalamount > $payment_amount){
							// Advance case
				            $studentWithAdv[] = "Student Id $student_code Paid Advance amount of $payment_amount";
							
							$stuTranDetailsa = $studentTransactionModel->get_student_trans_details($student_code);
							$adv_amounta = $stuTranDetailsa['advanced_amount'] ?? 0;
							$advdata['advanced_amount'] = $payment_amount + $adv_amounta;
							
							$advdata['created_date'] = $created_date;

							$advresult = $studentTransactionModel->updateStudentTransDetail($student_code, $advdata);
							
							if(!$advresult){
								if($student_code == ''){									
									$error_msg = 'Student Code is Invalid';
									$errors[] = $error_msg .' -- Row No -- '. $lineNo;
								}
								
							}
						}elseif($payment_amount >= $totalamount){
							$student_data=[];
							$student_data['month_id'] = $pMonthId;
							$student_data['ad_payment_status'] = '1';
							$student_data['bus_payment_status'] = '1';
							$student_data['ad_payment_mode'] = 'Bank';											
							$student_data['payment_amount'] = $totalamount;
							$student_data['academic_payment_amt'] = $tuition_fee;
							$student_data['created_date'] = $created_date;
							$student_data['student_code'] = $student_code;
							$student_data['t_user_id'] = $currentLoggedInUserId;
							$student_data['added_by'] = $currentLoggedInUserName;
							$student_data['payee_name'] = $get_student_name;

							if($bus_services > 0){
								$student_data['bus_payment_date'] = $created_date;
								$student_data['bus_payment_amt'] = $bus_services;
								$student_data['bus_payment_mode'] = 'Bank';

								$student_data['bus_payee_name'] = $get_student_name;
								$student_data['bus_t_user_id'] = $currentLoggedInUserId;
								$student_data['bus_added_by'] = $currentLoggedInUserName;
							}	

							// $status = $this->Csvupload_model->studentdata_save($student_data);
							$status = $studentFeeStructureModel->update($fee_structure_id, $student_data);
							
							if($payment_amount > $totalamount){
								$finalRemain = $payment_amount - $totalamount;
								$advdata['advanced_amount'] = $finalRemain;
						
								if($finalRemain>0){
									$studentWithAdv[] = 'Student Id ' . $student_code . ' Paid Advance amount of ' . $finalRemain;
								}
								
								$stuTranDetailsa = $studentTransactionModel->get_student_trans_details($student_code);

								$adv_amounta = $stuTranDetailsa['advanced_amount'] ?? 0;
								$advdata['advanced_amount'] = $finalRemain + $adv_amounta;
								
								$sCode = $student_code;
								$advdata['created_date'] = $created_date;
								// $advresult = $this->student_model->update_student_trans_detail($student_code,$advdata);

								$advresult = $studentTransactionModel->updateStudentTransDetail($student_code, $advdata);
				
								if(!$advresult){
									if($student_code == ''){									
										$error_msg = 'Student Code is Invalid';
										$errors[] = $error_msg .' -- Row No -- '. $lineNo;
									}
								}
							}
							
						}
					}
				}else{
					//echo 'month';
					//get this month fee structure
					$PayMonth = $studentFeeStructureModel->get_fee_row_by_april_month($pMonthId, $student_code);
					$fee_structure_id = $PayMonth['id'] ?? '';
					//echo $this->db->last_query().'<br>';
					
					//month fee calculation start								
					$cons_tuition_fee = $PayMonth['cons_tuition_fee'] ?? 0;
					$cons_bus_services = $PayMonth['cons_bus_services'] ?? 0;
					
					$init_tuition_fee = $PayMonth['tuition_fee'] ?? 0;
					$init_bus_services = $PayMonth['bus_services'] ?? 0;
					
					
					//tution
					$tuition_fee = $init_tuition_fee-$cons_tuition_fee;
					//bus service
					$bus_services = $init_bus_services-$cons_bus_services;
					$totalamount = $bus_services + $tuition_fee;

					//tuition fee collect
					if($payment_amount != 0){ //50
						if(isset($PayMonth['ad_payment_status']) && $PayMonth['ad_payment_status'] !=1){
							if($payment_amount >= $tuition_fee){
								$ad_pay_amt = $payment_amount;
								$student_data=[];
								$student_data['month_id'] = $pMonthId;
								$student_data['ad_payment_status'] = '1';
								$student_data['created_date'] = $created_date;
								$student_data['ad_payment_mode'] = 'Bank';
								// $student_data['payment_amount'] = get_already_paid_amount($pMonthId,$student_code)+$tuition_fee;
								$student_data['payment_amount'] = $totalamount;
								$student_data['academic_payment_amt'] = $tuition_fee;
								$student_data['student_code'] = $student_code;
								$student_data['t_user_id'] = $currentLoggedInUserId;
								$student_data['added_by'] = $currentLoggedInUserName;
								$student_data['payee_name'] = $get_student_name;

								// $status = $this->Csvupload_model->studentdata_save($student_data);
								$status = $studentFeeStructureModel->update($fee_structure_id, $student_data);
								
								$payment_amount = $payment_amount-$tuition_fee;
								
								if($ad_pay_amt == $tuition_fee){
									$payment_amount = 0;
								}
							}elseif($tuition_fee>$payment_amount){ 
	
								$carry_amount = $tuition_fee-$payment_amount;
								$student_data=[];
								$student_data['month_id'] = $pMonthId;
								$student_data['ad_payment_status'] = '1';
								$student_data['created_date'] = $created_date;
								$student_data['ad_payment_mode'] = 'Bank';	
								$student_data['payment_amount'] = $totalamount;;
								$student_data['academic_payment_amt'] = $payment_amount;
								$student_data['tuition_fee'] = $payment_amount;
								$student_data['student_code'] = $student_code;
								$student_data['t_user_id'] = $currentLoggedInUserId;
								$student_data['added_by'] = $currentLoggedInUserName;
								$student_data['payee_name'] = $get_student_name;

								// $status = $this->Csvupload_model->studentdata_save($student_data);
								$status = $studentFeeStructureModel->update($fee_structure_id, $student_data);
								
								//carry_amount will add to next month tuition fee
								$carryMonth = date('m', strtotime($PayMonth['payment_due_date'] .'+1 month'));
								// $this->student_model->carry_next_mnth_tuition_fee($carryMonth,$student_code,$carry_amount);
								$studentFeeStructureModel->carryNextMonthTuitionFee($carryMonth, $student_code, $carry_amount);

								$stuTuiPayInc[] = 'Student Id ' . $student_code . ' carry forward tution amount of ' . $carry_amount;
								$payment_amount = 0;
							}
						}
					}
					
					//bus fee collect
					if($payment_amount != 0){
						if(isset($PayMonth['bus_payment_status']) &&  $PayMonth['bus_payment_status'] !=1){

							if($payment_amount >= $bus_services){
	
								$bus_pay_amt = $payment_amount;
								$student_data=[];
								$student_data['month_id'] = $pMonthId;												
								$student_data['bus_payment_status'] = '1';
								$student_data['payment_amount'] = $totalamount;
								$student_data['student_code'] = $student_code;
								$student_data['t_user_id'] = $currentLoggedInUserId;
								$student_data['added_by'] = $currentLoggedInUserName;
								$student_data['payee_name'] = $get_student_name;

								if($bus_services > 0){
									$student_data['bus_payment_date'] = $created_date;
									$student_data['bus_payment_amt'] = $bus_services;
									$student_data['bus_payment_mode'] = 'Bank';
									$student_data['bus_payee_name'] = $get_student_name;
									$student_data['bus_t_user_id'] = $currentLoggedInUserId;
									$student_data['bus_added_by'] = $currentLoggedInUserName;
								}											
								// $status = $this->Csvupload_model->studentdata_save($student_data);
								$status = $studentFeeStructureModel->update($fee_structure_id, $student_data);
								
								$payment_amount = $payment_amount-$bus_services;
								
								if($bus_pay_amt==$bus_services){
									$payment_amount = 0;
								}
							}elseif($bus_services > $payment_amount){
	
								$carry_bus_amount = $bus_services-$payment_amount;
								$student_data=[];
								$student_data['month_id'] = $pMonthId;
								$student_data['bus_payment_status'] = '1';
								$student_data['bus_payment_mode'] = 'Bank';
								$student_data['payment_amount'] = $totalamount;
								$student_data['bus_payment_amt'] = $payment_amount;
								$student_data['bus_services'] = $payment_amount;
								$student_data['bus_payment_date'] = $created_date;
								$student_data['student_code'] = $student_code;
								$student_data['bus_payee_name'] = $get_student_name;
								$student_data['bus_t_user_id'] = $currentLoggedInUserId;
								$student_data['bus_added_by'] = $currentLoggedInUserName;
								
								// $status = $this->Csvupload_model->studentdata_save($student_data);
								$status = $studentFeeStructureModel->update($fee_structure_id, $student_data);
								
								//carry_amount will add to next month bus fee
								$carryMonth = date('m', strtotime($PayMonth['payment_due_date'] .'+1 month'));
								// $this->student_model->carry_next_mnth_bus_fee($carryMonth,$student_code,$carry_bus_amount);
								$studentFeeStructureModel->carryNextMonthBusFee($carryMonth, $student_code, $carry_bus_amount);

								$stuBusPayInc[] = 'Student Id ' . $student_code . ' carry forward bus amount of ' . $carry_bus_amount;
								$payment_amount = 0;	
							}							
						}						
					}
				}
			}
     	}

     	fclose($csv);

        // ✅ If no issues
        if (empty($errors) && empty($studentWithAdv) && empty($stuTuiPayInc) && empty($stuBusPayInc)) {

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'You have successfully uploaded Student data.'
            ]);
        }

        // ✅ Prepare HTML response
        $html = '';

        foreach ($errors as $msg) {
            $html .= '<div class="alert alert-danger">'.$msg.'</div>';
        }

        foreach ($studentWithAdv as $msg) {
            $html .= '<div class="alert alert-warning">'.$msg.'</div>';
        }

        foreach ($stuTuiPayInc as $msg) {
            $html .= '<div class="alert alert-info">'.$msg.'</div>';
        }

        foreach ($stuBusPayInc as $msg) {
            $html .= '<div class="alert alert-primary">'.$msg.'</div>';
        }

        return $this->response->setJSON([
            'status' => 'error',
            'html'   => $html
        ]);
	}

	/**
	 * ===============================================
	 * created_date
	 * student_code
	 * tuition_fee
	 * tuition_fine
	 * bus_fee
	 * bus_fine
	 * payment_amount
	 * transaction_no
	 * month_id
	 * ===============================================
	 * */
	public function online_failed_payment_save()
	{
		$configurationModel = new ConfigurationModel();

	    $tuitionFinePerMonth = $configurationModel->get_configuration_by_key('tuition_fee_fine_per_month');
	    $busFinePerMonth = $configurationModel->get_configuration_by_key('bus_fee_fine_per_month');

	    $file = $this->request->getFile('failedonlinefile');

	    if (!$file || !$file->isValid()) {
	        return redirect()->back()->with('error_msg', 'Invalid file upload.');
	    }

	    if ($file->getClientExtension() !== 'csv') {
	        return redirect()->back()->with('error_msg', 'Only CSV file allowed.');
	    }

	    $logPath = WRITEPATH . 'csv_logs/';
		if (!is_dir($logPath)) {
		    mkdir($logPath, 0777, true);
		}

		$logFile = $logPath . 'online_failed_upload_' . date('Y-m-d_H-i-s') . '.txt';

	    $csv = fopen($file->getTempName(), 'r');

	    $lineNo = 0;
	    $errorData = 0;
	    $lineErrors = [];

	    while (($line = fgetcsv($csv)) !== false) {

	        $lineNo++;
	        $rowError = false;

	        // Skip header row
	        // if ($lineNo == 1) {
	        //     continue;
	        // }

	        if (count($line) < 9) {
	            $lineErrors[] = "Invalid column count -- Row $lineNo";
	            continue;
	        }

	        $createdDate     = trim($line[0]);
	        $studentCode     = trim($line[1]);
	        $tuitionFee      = trim($line[2]);
	        $fine            = trim($line[3]);
	        $busFee          = trim($line[4]);
	        $busFine         = trim($line[5]);
	        $paymentAmount   = trim($line[6]);
	        $transactionNo   = trim($line[7]);
	        $monthId         = trim($line[8]);

	        if (empty($createdDate) || substr_count($createdDate, '-') != 2) {
	            $lineErrors[] = "Wrong Date format -- Row $lineNo";
	            $rowError = true;
	        }

	        if (empty($studentCode)) {
	            $lineErrors[] = "Student Code blank -- Row $lineNo";
	            $rowError = true;
	        }


			/* ================= TUITION FEE ================= */
			if ($tuitionFee === '') {
			    $lineErrors[] = "Tuition Fee should not be blank -- Row $lineNo";
			    $rowError = true;
			} elseif (!is_numeric($tuitionFee) || $tuitionFee < 0) {
			    $lineErrors[] = "Invalid Tuition Fee -- Row $lineNo";
			    $rowError = true;
			}

			/* ================= TUITION FINE ================= */
			if ($fine === '') {
			    $lineErrors[] = "Tuition Fine should not be blank -- Row $lineNo";
			    $rowError = true;
			} elseif (!is_numeric($fine) || $fine < 0) {
			    $lineErrors[] = "Invalid Tuition Fine -- Row $lineNo";
			    $rowError = true;
			}

			/* ================= BUS FEE ================= */
			if ($busFee === '') {
			    $lineErrors[] = "Bus Fee should not be blank -- Row $lineNo";
			    $rowError = true;
			} elseif (!is_numeric($busFee) || $busFee < 0) {
			    $lineErrors[] = "Invalid Bus Fee -- Row $lineNo";
			    $rowError = true;
			}

			/* ================= BUS FINE ================= */
			if ($busFine === '') {
			    $lineErrors[] = "Bus Fine should not be blank -- Row $lineNo";
			    $rowError = true;
			} elseif (!is_numeric($busFine) || $busFine < 0) {
			    $lineErrors[] = "Invalid Bus Fine -- Row $lineNo";
			    $rowError = true;
			}

			/* ================= PAYMENT AMOUNT ================= */
			if ($paymentAmount === '') {
			    $lineErrors[] = "Payment Amount should not be blank -- Row $lineNo";
			    $rowError = true;
			} elseif (!is_numeric($paymentAmount) || $paymentAmount <= 0) {
			    $lineErrors[] = "Invalid Payment Amount -- Row $lineNo";
			    $rowError = true;
			}

			/* ================= TRANSACTION NUMBER ================= */
			if (empty($transactionNo)) {
			    $lineErrors[] = "Transaction No should not be blank -- Row $lineNo";
			    $rowError = true;
			}

			/* ================= MONTH ID ================= */
			if ($monthId === '') {
			    $lineErrors[] = "Month Id should not be blank -- Row $lineNo";
			    $rowError = true;
			} elseif (!ctype_digit($monthId)) {
			    $lineErrors[] = "Invalid Month Id (must be numeric) -- Row $lineNo";
			    $rowError = true;
			}


	        if ($rowError) {
	            $errorData++;
	            continue;
	        }

	        $currentLoggedInUserId = session()->get('user_id');
			$currentLoggedInUserName = session()->get('f_name').' '.session()->get('l_name');
			$student_name = student_name_by_code($studentCode);

	        $studentData = [
	            'month_id'              => $monthId,
	            'transaction_no'        => $transactionNo,
	            'ad_payment_status'     => 1,
	            'bus_payment_status'    => 1,
	            'ad_payment_mode'       => 'CCAvenue',
	            'payment_amount'        => $paymentAmount,
	            'academic_payment_amt'  => $tuitionFee,
	            'created_date'          => date('Y-m-d H:i:s', strtotime($createdDate)),
	            'student_code'          => $studentCode,
	            'fine'                  => $fine,
	            't_user_id'             => $currentLoggedInUserId,
	            'added_by'				=> $currentLoggedInUserName,
	            'payee_name'         	=> $student_name
	        ];

	        if ($busFee > 0) {
	            $studentData['bus_payment_date'] = date('Y-m-d H:i:s', strtotime($createdDate));
	            $studentData['bus_payment_amt']  = $busFee;
	            $studentData['bus_payment_mode'] = 'CCAvenue';
	            $studentData['bus_fee_fine']     = $busFine;

	            $studentData['bus_payee_name'] = $student_name;
				$studentData['bus_t_user_id'] = $currentLoggedInUserId;
				$studentData['bus_added_by'] = $currentLoggedInUserName;
	        }

	        $logData = $studentData;
	        $logData['uploaded_by'] = session()->get('user_id');
			file_put_contents($logFile, json_encode($logData) . PHP_EOL, FILE_APPEND);

	        // echo "<pre>"; print_r($studentData);
	        // model('CsvuploadModel')->studentdata_save($studentData);

	        $studentFeeStructureModel = new StudentFeeStructureModel();
	        $studentFeeStructureModel->studentdata_save($studentData);
	    }

	    fclose($csv);

	    if ($errorData > 0) {
	        return redirect()->back()->with('error_msg', implode('<br>', $lineErrors));
	    }

	    return redirect()->to(base_url('admin/csv-payment-upload/bank-online-transaction-import'))->with('success_msg', 'Student data uploaded successfully.');
	}

	/**
	 * ===============================================
	 * created_date
	 * student_code
	 * payment_amount
	 * transaction_no
	 * month
	 * ===============================================
	 * */ 
	public function online_failed_payment_april_save()
	{
		// pr("Test");
	    $file = $this->request->getFile('readmissionfile');

	    if (!$file || !$file->isValid()) {
	        return redirect()->back()->with('error_msg', 'Invalid file upload.');
	    }

	    if ($file->getClientExtension() !== 'csv') {
	        return redirect()->back()->with('error_msg', 'Only CSV file allowed.');
	    }

	    $logPath = WRITEPATH . 'csv_logs/';
		if (!is_dir($logPath)) {
		    mkdir($logPath, 0777, true);
		}

		$logFile = $logPath . 'april_upload_' . date('Y-m-d_H-i-s') . '.txt';

	    $csv = fopen($file->getTempName(), 'r');

	    $lineNo = 0;
	    $lineErrors = [];
	    $studentWithAdv = [];
	    $stuTuiPayInc = [];
	    $stuBusPayInc = [];

	    $sessionStart = session()->get('session_start_date');
	    $sessionEnd   = session()->get('session_end_date');

	    $configurationModel = new ConfigurationModel();
	    $studentFeeStructureModel = new StudentFeeStructureModel();
	    $studentTransactionModel = new StudentTransactionModel();

	    $adv_amount = 0;		
		$totalamount = 0;
		$bus_services = 0;
		$tuition_fee = 0;

		$tuition_fine_per_month = $configurationModel->get_configuration_by_key('tuition_fee_fine_per_month') ?? 0;	
		$bus_fine_per_month = $configurationModel->get_configuration_by_key('bus_fee_fine_per_month') ?? 0;
		$date = date('Y-m-d');
		$data = [];

		while (($line = fgetcsv($csv)) !== false) {
			$lineNo++;

			if (count($line) < 5) {
	            $lineErrors[] = "Invalid column count -- Row $lineNo";
	            continue;
	        }

	        $createdDate   = trim($line[0]);
	        $studentCode   = trim($line[1]);
	        $paymentAmount = trim($line[2]);
	        $transactionNo = trim($line[3]);
	        $monthId       = 4; // Fixed April

	        $rowError = false;

	        /* ================= VALIDATION ================= */
	        if (empty($createdDate)) {
	            $lineErrors[] = "Date blank -- Row $lineNo";
	            $rowError = true;
	        } else {
	            $d = \DateTime::createFromFormat('Y-m-d', $createdDate);
	            if (!$d || $d->format('Y-m-d') !== $createdDate) {
	                $lineErrors[] = "Wrong Date format (YYYY-MM-DD) -- Row $lineNo";
	                $rowError = true;
	            }
	        }

	        if (empty($studentCode)) {
	            $lineErrors[] = "Student Code blank -- Row $lineNo";
	            $rowError = true;
	        }

	        if ($paymentAmount === '' || !is_numeric($paymentAmount) || $paymentAmount <= 0) {
	            $lineErrors[] = "Invalid Payment Amount -- Row $lineNo";
	            $rowError = true;
	        }

	        if (empty($transactionNo)) {
	            $lineErrors[] = "Transaction No blank -- Row $lineNo";
	            $rowError = true;
	        }

	        if ($rowError) continue;

	        // Log CSV Data
	        $logData = [
			    'row_number'   => $lineNo,
			    'created_date' => $createdDate,
			    'student_code' => $studentCode,
			    'payment_amount' => $paymentAmount,
			    'transaction_no' => $transactionNo,
			    'uploaded_by' => session()->get('user_id')
			];
			file_put_contents($logFile, json_encode($logData) . PHP_EOL, FILE_APPEND);


			$createdDateTime = date('Y-m-d H:i:s', strtotime($createdDate));
	        $PayMonth = $studentFeeStructureModel->get_fee_row_by_april_month($monthId, $studentCode);
	        $fee_structure_id = $PayMonth['id'] ?? '';

	        if (!$PayMonth) {
	            $lineErrors[] = "Invalid Student Code -- Row $lineNo";
	            continue;
	        }

	        if ( $fee_structure_id == '' ) {
	            $lineErrors[] = "Invalid Student Fee Structure -- Row $lineNo";
	            continue;
	        }

	        $tuitionFee = 0;
			$busFee     = 0;

			$admission_fee = 0;
			$development_fee = 0;
			$exam_fee = 0;
			$festival_celebration_fee = 0;
			$games_sports_fee = 0;
			$audio_visual_lab_fee = 0;
			$library_fee = 0;
			$electricity_maintenance_fee = 0;
			$computer_fee = 0;
			$security_deposite = 0;
			
			// pr($PayMonth);

			$itemMasterModel = new ItemMasterModel();
			$get_session_year_id = session()->get('session_year_id');
			$class_id = class_id_by_student_code($studentCode);
			$getStudentId = student_id_by_code($studentCode);
			$second_language = second_language_by_student_id($getStudentId);

			$student_user_id = student_user_id_by_code($studentCode);
			$get_user_full_name = ($student_user_id != '' ) ? get_user_full_name_by_id($student_user_id) : '';

			$stationary_items = $itemMasterModel
                ->where('class_id', $class_id)
                ->where('sec_lang', $second_language)
                ->where('session_year_id', $get_session_year_id)
                ->where('status', 1)
                ->findAll();

			$total_academic_amount = 0;
			if (!empty($PayMonth)) {
			    $tuitionFee = (int)($PayMonth['tuition_fee'] ?? 0) - (int)($PayMonth['cons_tuition_fee'] ?? 0);
			    $busFee = (int)($PayMonth['bus_services'] ?? 0) - (int)($PayMonth['cons_bus_services'] ?? 0);


			    $admission_fee = (int)($PayMonth['admission_fee'] ?? 0) - (int)($PayMonth['cons_admission_fee'] ?? 0);
			    $development_fee = (int)($PayMonth['development_fee'] ?? 0) - (int)($PayMonth['cons_development_fee'] ?? 0);
			    $exam_fee = (int)($PayMonth['exam_fee'] ?? 0) - (int)($PayMonth['cons_exam_fee'] ?? 0);
			    $festival_celebration_fee = (int)($PayMonth['festival_celebration_fee'] ?? 0) - (int)($PayMonth['cons_festival_celebration_fee'] ?? 0);
			    $games_sports_fee = (int)($PayMonth['games_sports_fee'] ?? 0) - (int)($PayMonth['cons_games_sports_fee'] ?? 0);
			    $audio_visual_lab_fee = (int)($PayMonth['audio_visual_lab_fee'] ?? 0) - (int)($PayMonth['cons_audio_visual_lab_fee'] ?? 0);
			    $library_fee = (int)($PayMonth['library_fee'] ?? 0) - (int)($PayMonth['cons_library_fee'] ?? 0);
			    $electricity_maintenance_fee = (int)($PayMonth['electricity_maintenance_fee'] ?? 0) - (int)($PayMonth['cons_electricity_maintenance_fee'] ?? 0);
			    $computer_fee = (int)($PayMonth['computer_fee'] ?? 0) - (int)($PayMonth['cons_computer_fee'] ?? 0);
			    $security_deposite = (int)($PayMonth['security_deposite'] ?? 0) - (int)($PayMonth['cons_security_deposite'] ?? 0);
				
				$total_academic_amount = $tuitionFee + $admission_fee + $development_fee + $exam_fee + $festival_celebration_fee + $games_sports_fee + $audio_visual_lab_fee + $library_fee + $electricity_maintenance_fee + $computer_fee + $security_deposite;
			}

			$totalAmount = $tuitionFee + $busFee;
			$currentLoggedInUserId = session()->get('user_id');
			$currentLoggedInUserName = session()->get('f_name').' '.session()->get('l_name');

			if ($totalAmount > $paymentAmount) {
				// Advance case
	            $studentWithAdv[] = "Student Id $studentCode Paid Advance amount of $paymentAmount";
	            // model('StudentModel')->updateStudentAdvance($studentCode,$paymentAmount,$createdDateTime);
				
				$stuTranDetailsa = $studentTransactionModel->get_student_trans_details($studentCode);
				$adv_amounta = $stuTranDetailsa['advanced_amount'] ?? 0;
				$advdata['advanced_amount'] = $paymentAmount + $adv_amounta;
				
				$advdata['created_date'] = $createdDateTime;

				$advresult = $studentTransactionModel->updateStudentTransDetail($studentCode, $advdata);
				
				if(!$advresult){
					if($student_code == ''){									
						$error_msg = 'Student Code is Invalid';
						$lineErrors[] = $error_msg .' -- Row No -- '. $lineNo;
					}
					
				}
			}
			elseif($paymentAmount >= $totalAmount){
				$updateData = [
	                'month_id'             => 4,
	                'transaction_no'       => $transactionNo,
	                'ad_payment_status'    => 1,
	                'ad_payment_mode'      => 'CCAvenue',
	                'payment_amount'       => $paymentAmount,
	                'academic_payment_amt' => $tuitionFee,
	                'created_date'         => $createdDateTime,
	                'student_code'         => $studentCode,
	                't_user_id'         	=> $student_user_id,
	                'added_by'         		=> $get_user_full_name,
	                'payee_name'         	=> student_name_by_code($studentCode),
	            ];

	            if ($busFee > 0) {
	                $updateData['bus_payment_date'] = $createdDateTime;
	                $updateData['bus_payment_amt']  = $busFee;
	                $updateData['bus_payment_mode'] = 'CCAvenue';
	                $updateData['bus_payment_status'] = '1';
	                $updateData['bus_payee_name'] = student_name_by_code($studentCode);
					$updateData['bus_t_user_id'] = $currentLoggedInUserId;
					$updateData['bus_added_by'] = $currentLoggedInUserName;
	            }
	            
	            // $result = true;
				$result = $studentFeeStructureModel->update($fee_structure_id, $updateData);

				if( $result ) {
		            // Insert Stationary Item
		            $studentStationaryItemsModel = new StudentStationaryItemsModel();
		            $item_names = [];
					$item_ids   = [];
					$item_qtys  = [];
					$item_price = [];
					$totalStPrice = 0;

		            if( !empty($stationary_items) ) {
						foreach ($stationary_items as $row) {
						    $item_names[] = $row['item_name'];
						    $item_ids[]   = $row['id'];
						    $item_qtys[]  = $row['qty'];
						    $item_price[] = $row['price'];
						    // calculate total
							$totalStPrice += ($row['qty'] * $row['price']);
						}

						// Convert to comma-separated string
						$item_names_str = implode(',', $item_names);
						$item_ids_str   = implode(',', $item_ids);
						$item_qtys_str  = implode(',', $item_qtys);
						$item_price_str = implode(',', $item_price);

		                $stationaryData = array(
		                    'student_id'=> $getStudentId,
		                    'class_id'  => $class_id, // class_id
		                    'class_code'=> $studentCode, // code
		                    'item_ids' => $item_ids_str,                       
		                    'item_qtys'=> $item_qtys_str,                      
		                    'item_price'=> $item_price_str,
		                    'price'     => $totalStPrice,
		                    'payment_status' => 1,
		                    'payment_date' => date('Y-m-d'),
		                    'session_year_id'=> $get_session_year_id,
		                    'add_date'  => date('Y-m-d H:i:s'),
		                    'payment_mode' => 'CCAvenue',
		                    'cheque_number' => '',
		                    'pos_bank_name' => '',
		                    'pos_reference_number' => '',
		                    't_user_id' => $student_user_id,
		                    'added_by' => $get_user_full_name,
		                    'remarks' => ''
		                );
		                // echo "<pre>"; print_r($stationaryData);
		                
		                $stationaryResultId = $studentStationaryItemsModel->insert($stationaryData, true);
		            }

					// $get_student_code = $studentFeeStructureModel
	                //     ->where('id', $fee_structure_id)
	                //     ->select('student_code')
	                //     ->first()['student_code'] ?? '';
	                // $getStudentId = student_id_by_code($get_student_code);

					$studentFeeInvoiceModel = new StudentFeeInvoiceModel();
					$studentFeeInvoiceExisting = $studentFeeInvoiceModel->where('student_id', $getStudentId)->first();

					$feesInvoiceData = [
		                'form_no'                       => '',
		                'student_id'                    => $getStudentId,
		                'session_year_id'               => session()->get('session_year_id'),
		                'admission_fee'                 => $admission_fee ?? 0,
		                'development_fee'               => $development_fee ?? 0,
		                'exam_fee'                      => $exam_fee ?? 0,
		                'festival_celebration_fee'      => $festival_celebration_fee ?? 0,
		                'games_sports_fee'              => $games_sports_fee ?? 0,
		                'audio_visual_lab_fee'          => $audio_visual_lab_fee ?? 0,
		                'library_fee'                   => $library_fee ?? 0,
		                'electricity_maintenance_fee'   => $electricity_maintenance_fee ?? 0,
		                'computer_fee'                  => $computer_fee ?? 0,
		                'security_deposite'             => $security_deposite ?? 0,
		                'tuition_fee'                   => $tuitionFee ?? 0,
		                'stoppage_fee'                  => $busFee ?? 0,
		                'grand_total_fees'              => $total_academic_amount ?? 0,
		                'payment_amount'                => $paymentAmount ?? 0,
		                'payment_cheque_number'         => null,
		                'payment_pos_bank_name'         => null,
		                'payment_pos_reference_number'  => null,
		                'remarks'                       => '',
		                'stationary_items'              => json_encode($stationary_items),
		                'stationary_total'              => $totalStPrice,
		                'tblc_items'                    => json_encode([]),
		                'tblc_total'                    => 0,
		                'created_at'                    => date('Y-m-d H:i:s'),
		                'created_by'                    => $currentLoggedInUserId,
		            ];

					if( $studentFeeInvoiceExisting ) {
						$studentFeeInvoiceId = $studentFeeInvoiceExisting['id'] ?? '';
						$studentFeeInvoiceModel->update($studentFeeInvoiceId, $feesInvoiceData);
					} else {
						$studentFeeInvoiceModel->insert($feesInvoiceData, true);
					}
		            
		            // echo "<pre>"; print_r($updateData);
		            // echo "<pre>"; print_r($feesInvoiceData);

		            // insert student_transaction table
		            $studentTransactionModel = new StudentTransactionModel();
		            $studentTranData = array(
		                'student_code' => $studentCode,
		                'due_amount' => 0,
		                'advanced_amount' => 0,
		                'session_year_id' => $get_session_year_id
		            );
		            // echo "<pre>"; print_r($studentTranData);
		            $student_tran_id = $studentTransactionModel->insert($studentTranData);

	            }
			}

		}

	    fclose($csv);

     	if (empty($lineErrors) && empty($studentWithAdv)) {
	        return redirect()->to(base_url('admin/csv-payment-upload/bank-online-transaction-import'))->with('bt_success_msg', 'April failed payment uploaded successfully.');
	    }

	    return redirect()->to(base_url('admin/csv-payment-upload/bank-online-transaction-import'))->with('bt_errors', $lineErrors)->with('advance', $studentWithAdv);
	}

	public function student_transaction_import()
	{
		$data['title'] = "Student Transaction Import";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        echo view('admin/csv-payment-upload/student-transaction-import', $data);  

        echo view('admin/common/footer', $data);
	}

	public function bank_online_transaction_import()
	{
		$data['title'] = "Bank/Online CSV File";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        echo view('admin/csv-payment-upload/bank-online-transaction-import', $data);  

        echo view('admin/common/footer', $data);
	}

	public function security_money_update()
	{
		$data['title'] = "Security Money Update";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        echo view('admin/csv-payment-upload/security-money-update', $data);  

        echo view('admin/common/footer', $data);
	}
}