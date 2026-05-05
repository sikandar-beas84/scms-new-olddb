<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eazypay {
    private $CI;
    private $merchantId;
    private $aesKey;
    private $baseUrl;
    private $returnUrl;

    public function __construct() {
        $this->CI =& get_instance();
        
        // Initialize configuration
        $this->merchantId = '386858';  // Can be moved to config file
        $this->aesKey = '3824781168501000'; // Can be moved to config file
        $this->baseUrl = 'https://eazypay.icicibank.com/EazyPG';
        $this->returnUrl = 'https://gyanjyotipublicschool.com/payment/success';
    }

    /**
     * Set custom configuration
     */
    public function initialize($config = array()) {
        foreach ($config as $key => $val) {
            if (isset($this->$key)) {
                $this->$key = $val;
            }
        }
        return $this;
    }

    /**
     * Encrypt data using AES-128-ECB
     */
    private function encrypt($str) {
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

    /**
     * Generate payment request parameters
     */
    public function generatePaymentParams($params) {
        if (!isset($params['amount'], $params['student_details'])) {
            throw new Exception('Required parameters missing');
        }

        $student = $params['student_details'];
        
        return [
            'referenceNo' => 'REF' . time(),
            'subMerchantId' => $params['sub_merchant_id'] ?? '45',
            'amount' => $params['amount'],
            'studentId' => $student['student_code'] ?? '',
            'studentName' => $student['student_name'] ?? '',
            'class' => $student['class'] ?? 'CLASS',
            'section' => $student['section'] ?? 'SECTION',
            'roll' => $params['payment_ids'] ?? '',
            'monthId' => $student['month'] ?? '',
            'upiVpa' => $params['upi_vpa'] ?? 'UPIVPA',
            'mobile' => $params['mobile'] ?? '9087654321',
            'email' => $params['email'] ?? 'test@gmail.com'
        ];
    }

    /**
     * Generate plain URL for testing
     */
     public function generatePlainUrl($params)
    {
        return 'https://eazypay.icicibank.com/EazyPG?merchantid=' . $this->merchantId . '&mandatory fields=' . $params['referenceNo'] . '|' . $params['subMerchantId'] . '|' . $params['amount'] . '|' . $params['studentId'] . '|' . $params['studentName'] . '|' . $params['class'] . '|' . $params['section'] . '|' . $params['roll'] . '|' . $params['monthId'] . '|' . $params['upiVpa'] . '|' . $params['mobile'] . '|' . $params['email'] . '&optionalfields=&returnurl=https://gyanjyotipublicschool.com/payment/success&Reference No=' . $params['referenceNo'] . '&submerchantid=' . $params['subMerchantId'] . '&transaction amount=' . $params['amount'] . '&paymode=9';
    }
    /**
     * Generate encrypted URL for production
     */
    public function generateEncryptedUrl($params)
    {
        
                return 'https://eazypay.icicibank.com/EazyPG?merchantid=' . $this->merchantId . '&mandatory fields=' . $this->encrypt($params['referenceNo'] . '|' . $params['subMerchantId'] . '|' . $params['amount'] . '|' . $params['studentId'] . '|' . $params['studentName'] . '|' . $params['class'] . '|' . $params['section'] . '|' . $params['roll'] . '|' . $params['monthId'] . '|' . $params['upiVpa'] . '|' . $params['mobile'] . '|' . $params['email']) . '&optional fields=' . 
              '&returnurl=' . $this->encrypt('https://gyanjyotipublicschool.com/payment/success') . 
              '&Reference No=' . $this->encrypt($params['referenceNo']) . 
              '&submerchantid=' . $this->encrypt($params['subMerchantId']) . 
              '&transaction amount=' . $this->encrypt($params['amount']) . 
              '&paymode=' . $this->encrypt('9');;

    }
    /**
     * Process payment response
     */
    public function processResponse($response) {
        if (empty($response)) {
            return [
                'status' => 'error',
                'message' => 'Invalid payment response received'
            ];
        }

        // Extract response data
        $responseData = [
            'response_code' => $response['Response_Code'] ?? '',
            'unique_ref_number' => $response['Unique_Ref_Number'] ?? '',
            'transaction_amount' => $response['Transaction_Amount'] ?? '',
            'transaction_date' => $response['Transaction_Date'] ?? '',
            'payment_mode' => $response['Payment_Mode'] ?? '',
            'reference_no' => $response['ReferenceNo'] ?? '',
            'mandatory_fields' => $response['mandatory_fields'] ?? '',
            'optional_fields' => $response['optional_fields'] ?? ''
        ];

        // Parse mandatory fields
        $mandatoryValues = explode('|', $responseData['mandatory_fields']);
        $responseData['parsed_fields'] = [
            'reference_no' => $mandatoryValues[0] ?? null,
            'sub_merchant_id' => $mandatoryValues[1] ?? null,
            'transaction_amount' => $mandatoryValues[2] ?? null,
            'transaction_id' => $mandatoryValues[3] ?? null,
            'customer_name' => $mandatoryValues[4] ?? null,
            'class' => $mandatoryValues[5] ?? null,
            'section' => $mandatoryValues[6] ?? null,
            'payment_ids' => $mandatoryValues[7] ?? null,
            'month_id' => $mandatoryValues[8] ?? null,
            'payment_method' => $mandatoryValues[9] ?? null,
            'customer_phone' => $mandatoryValues[10] ?? null,
            'customer_email' => $mandatoryValues[11] ?? null
        ];

        $responseData['status'] = ($responseData['response_code'] === 'E000') ? 'success' : 'failed';
        
        return $responseData;
    }
}

