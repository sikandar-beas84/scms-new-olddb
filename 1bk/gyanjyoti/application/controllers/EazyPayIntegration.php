<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EazyPayIntegration extends CI_Controller
{
    // private $merchantId = '140758';
    // private $aesKey = '1400011107505020';
    private $merchantId = '386858';
    private $aesKey = '3824781168501000';
    private $baseUrl = 'https://eazypay.icicibank.com/EazyPG';

    private function encrypt($str)
    {
        //$plaintext = "message to be encrypted";
        $plaintext = $str;
        $cipher = "aes-128-ecb";
        $key = "3824781168501000";
        in_array($cipher, openssl_get_cipher_methods(true));
        $ivlen = openssl_cipher_iv_length($cipher);
        //echo "ivlen [". $ivlen . "]";
        $iv = openssl_random_pseudo_bytes(1);
        // echo "iv [". $iv . "]";
        $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, "");
        return $ciphertext;
    }

    private function generatePlainUrl($params)
    {
        return 'https://eazypay.icicibank.com/EazyPG?merchantid=' . $this->merchantId . '&mandatory fields=' . $params['referenceNo'] . '|' . $params['subMerchantId'] . '|' . $params['amount'] . '|' . $params['studentId'] . '|' . $params['studentName'] . '|' . $params['class'] . '|' . $params['section'] . '|' . $params['roll'] . '|' . $params['monthId'] . '|' . $params['upiVpa'] . '|' . $params['mobile'] . '|' . $params['email'] . '&optionalfields=&returnurl=https://gyanjyotipublicschool.com/payment/success&Reference No=' . $params['referenceNo'] . '&submerchantid=' . $params['subMerchantId'] . '&transaction amount=' . $params['amount'] . '&paymode=9';
    }

    private function generateEncryptedUrl($params)
    {
                return 'https://eazypay.icicibank.com/EazyPG?merchantid=' . $this->merchantId . '&mandatory fields=' . $this->encrypt($params['referenceNo'] . '|' . $params['subMerchantId'] . '|' . $params['amount'] . '|' . $params['studentId'] . '|' . $params['studentName'] . '|' . $params['class'] . '|' . $params['section'] . '|' . $params['roll'] . '|' . $params['monthId'] . '|' . $params['upiVpa'] . '|' . $params['mobile'] . '|' . $params['email']) . '&optional fields=' . 
              '&returnurl=' . $this->encrypt('https://gyanjyotipublicschool.com/payment/success') . 
              '&Reference No=' . $this->encrypt($params['referenceNo']) . 
              '&submerchantid=' . $this->encrypt($params['subMerchantId']) . 
              '&transaction amount=' . $this->encrypt($params['amount']) . 
              '&paymode=' . $this->encrypt('9');;
    }

    public function processPayment()
    {
        $this->load->model('Student_model');
        $paymentData = $this->input->post();
        if (empty($paymentData['amount']) || empty($paymentData['customer_name']) || empty($paymentData['customer_mobile'])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid payment data']);
            return;
        }
        $referenceNo = 'REF' . time();
        $idArray = explode(',', post('id'));
        foreach($idArray as $v){
            $fees = $this->Generalmodel->getDataWhere('student_payment_details', ['id' => $v]);
            // $updateData = [
            //     'utr' => $utrNumber,
            //     'payment_type' => 3,
            //     'collected_by' => get_session('user_id'),
                
            // ];
            $fees = $fees[0];
            $paymentType = 3;
            $amount = post('amount');
            $updateData['payment_count'] =  $fees->payment_count + 1;
            if($fees->payment_count == 0){
                $updateData['payment_type'] =  $paymentType;
                // $updateData['transaction_id'] =  $transactionId;
                // $updateData['utr'] =  $utrNumber;
                $updateData['payment_amount_1st'] =  $amount;
                $updateData['payment_date'] =  date('Y-m-d H:i:s');
                $updateData['collected_by'] =  $this->session->userdata('user_id');
            }elseif($fees->payment_count == 1){
                $updateData['payment_type_2nd'] =  $paymentType;
                // $updateData['transaction_id_2nd'] =  $transactionId;
                $updateData['payment_amount_2nd'] =  $amount;
                // $updateData['utr_2nd'] =  $utrNumber;
                $updateData['payment_date_2nd'] =  date('Y-m-d H:i:s');
                $updateData['collected_by_2nd'] =  $this->session->userdata('user_id');
            }elseif($fees->payment_count == 2){
                $updateData['payment_type_3rd'] =  $paymentType;
                // $updateData['transaction_id_3rd'] =  $transactionId;
                $updateData['payment_amount_3rd'] =  $amount;
                // $updateData['utr_3rd'] =  $utrNumber;
                $updateData['payment_date_3rd'] =  date('Y-m-d H:i:s');
                $updateData['collected_by_3rd'] =  $this->session->userdata('user_id');
            }

            $update = $this->Generalmodel->getData('student_payment_details',$v,'id','','','update',$updateData);
        }
        $studentPaymentData = $this->Student_model->getStudentPaymentDetails($idArray[0]);
        // prx($idArray);
        $params = [
            'referenceNo' => $referenceNo,
            'subMerchantId' => '45',
            'amount' => post('amount'),
            'studentId' => $studentPaymentData['student_code'],
            'studentName' => $studentPaymentData['student_name'],
            'class' => 'CLASS',
            'section' => post('is_first_payment'),
            'roll' =>  post('id'),
            'monthId' => $studentPaymentData['month'],
            'upiVpa' => 'UPIVPA',
            'mobile' => '9087654321',
            'email' => 'test@gmail.com',
            'returnUrl' => 'https://gyanjyotipublicschool.com/payment/success'
        ];

        // prx($params);
         $plainUrl = $this->generatePlainUrl($params);
        $encryptedUrl = $this->generateEncryptedUrl($params);

        echo json_encode([
            'status' => 'success',
            'plain_url' => $plainUrl,
            'payment_url' => $encryptedUrl
        ]);
    }

    // public function paymentSuccess()
    // {
    //     $response = $this->input->post();
    //     prx($response);
    //     if (!empty($response)) {
    //         log_message('info', 'Payment Response: ' . print_r($response, true));
    //         $this->load->view('payment_success', ['response' => $response]);
    //     } else {
    //         show_error('Invalid payment response received.');
    //     }
    // }
    
    
    
    public function paymentSuccess()
{
    $response = $this->input->post();

    if (!empty($response)) {
        // Log the payment response
        log_message('info', 'Payment Response: ' . print_r($response, true));

        // Extract important response data
        $responseCode = $response['Response_Code'] ?? '';
        $uniqueRefNumber = $response['Unique_Ref_Number'] ?? '';
        $transactionAmount = $response['Transaction_Amount'] ?? '';
        $transactionDate = $response['Transaction_Date'] ?? '';
        $paymentMode = $response['Payment_Mode'] ?? '';
        $referenceNo = $response['ReferenceNo'] ?? '';
        $mandatoryFields = $response['mandatory_fields'] ?? '';
        $optionalFields = $response['optional_fields'] ?? null;

        // Extract the mandatory fields
        $mandatoryFields = $response['mandatory_fields'] ?? '';
        $mandatoryValues = explode('|', $mandatoryFields);

        // Assign each mandatory field value to separate variables
        $referenceNo = $mandatoryValues[0] ?? null;      // Reference No
        $subMerchantId = $mandatoryValues[1] ?? null;    // SubMerchantId
        $transactionAmount = $mandatoryValues[2] ?? null; // Transaction Amount
        $transactionId = $mandatoryValues[3] ?? null;    // Transaction ID
        $customerName = $mandatoryValues[4] ?? null;     // Customer Name
        $class = $mandatoryValues[5] ?? null;            // Class
        $section = $mandatoryValues[6] ?? null;          // Section
        $id = $mandatoryValues[7] ?? null;           // Field 8
        $field9 = $mandatoryValues[8] ?? null;           // Field 9
        $paymentMethod = $mandatoryValues[9] ?? null;    // Payment Method
        $customerPhone = $mandatoryValues[10] ?? null;   // Customer Phone
        $customerEmail = $mandatoryValues[11] ?? null;   // Customer Email

        $idArray = explode(',', $id);
       
        // Example condition for successful payment
        if ($responseCode === 'E000') {
            // Payment was successful
            foreach($idArray as $v){
                $data = [
                    'payment_row_id' => $v,
                    'status' => 'success',
                    'response_code' => $responseCode,
                    'unique_ref_number' => $uniqueRefNumber,
                    'transaction_amount' => $transactionAmount,
                    'transaction_date' => $transactionDate,
                    'payment_mode' => $paymentMode,
                    'reference_no' => $referenceNo,
                    'mandatory_fields' => $mandatoryFields,
                    'optional_fields' => $optionalFields,
                ];
    
                // Save the payment details to the database
                $this->db->insert('payment_transactions', $data);
                $transactionId = 'GPS-TXN-' . date('Ymd-His') . '-' . rand(1000, 9999);
                $fees = $this->Generalmodel->getDataWhere('student_payment_details', ['id' => $v]);
                $fees = $fees[0];
                $amount = $transactionAmount;
                if($fees->payment_count == 0){
                    $updateData['transaction_id'] =  $transactionId;
                    $updateData['utr'] =  $uniqueRefNumber;
                    $updateData['payment_date'] =  date('Y-m-d H:i:s');
                }elseif($fees->payment_count == 1){
                    $updateData['transaction_id_2nd'] =  $transactionId;
                    $updateData['utr_2nd'] =  $uniqueRefNumber;
                    $updateData['payment_date_2nd'] =  date('Y-m-d H:i:s');
                }elseif($fees->payment_count == 2){
                    $updateData['transaction_id_3rd'] =  $transactionId;
                    $updateData['utr_3rd'] =  $uniqueRefNumber;
                    $updateData['payment_date_3rd'] =  date('Y-m-d H:i:s');
                }
                
                if(($fees->session_fees+$fees->academic_fees+$fees->tuition_fees+$fees->monthly_fees+$fees->other_curriculum_fees+$fees->fine) == ($fees->payment_amount_1st + $fees->payment_amount_2nd +$fees->payment_amount_3rd + $amount)){
                    $updateData['payment_status'] =  'Y';
                }
                $update = $this->Generalmodel->getData('student_payment_details',$v,'id','','','update',$updateData);
                if($section == "Y"){
                    $student_payment_details = $this->Generalmodel->getData('student_payment_details',$v,'id','','','get','');
                    $student = $data['student'] = $this->Generalmodel->getDataWhere('students_details',['id' => $student_payment_details[0]->student_id, 'session_id'=>$this->session->userdata('session')]);
                    $studentsData = [
                        'username'=>$student[0]->student_code,
                        'password'=>md5($student[0]->father_mobile_no),
                        'first_name'=>$student[0]->student_name,
                        'last_name'=>'',
                        'email'=>$student[0]->email_id,
                        'phone'=>$student[0]->phone,
                        'date_of_birth'=>$student[0]->dob,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'created_by'=>$fees->collected_by,
                    ];
                    $res = $this->Generalmodel->getData('students','','','','','insert',$studentsData);
                    $fromData = [
                        'student_table_id'=>$this->db->insert_id(),
                        'application_status'=>'student',
                        'application_action_by'=>$fees->collected_by,
                        'application_action_at'=>date('Y-m-d H:i:s'),
                    ];
                    $studentId = str_pad($student[0]->id, 3, '0', STR_PAD_LEFT);
                    $formData['student_id'] =  'GPS'.$studentId;
                    $res = $this->Generalmodel->getData('students_details',$student[0]->id,'id','','','update',$fromData);
                    $session_wish_student_data = [
                        'session_id'=> $fees->session_year,
                        'student'=>$student[0]->id,
                        'student_code'=>$student[0]->admission_form_no,
                        'class'=>$student[0]->class,
                        'section'=>$student[0]->section,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'created_by'=>$fees->session_year,
                    ];
                    $session_wish_student_data_result = $this->Generalmodel->getData('session_wish_student_data','','','','','insert',$session_wish_student_data);
                    
                }
            }
            // Load a success view with the payment details
            $this->load->view('payment_success', ['response' => $data]);
            
        } else {
            // Payment failed or invalid response
            log_message('error', 'Payment failed or invalid response code: ' . $responseCode);

            // Show an error view
            $this->load->view('payment_error', ['error_message' => 'Payment failed. Please try again.']);
        }
    } else {
        // No response received, show error
        show_error('Invalid payment response received.');
    }
}


    public function paymentFailure()
    {
        $this->load->view('payment_failure');
    }
}
