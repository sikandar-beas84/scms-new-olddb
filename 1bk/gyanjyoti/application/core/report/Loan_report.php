<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    // * Auth: Suhrid Sarkar
    // * On: 31-04-2023
    // * For: Customer Master
    
class Loan_report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
		date_default_timezone_set('Asia/Kolkata');
    }

    public function index()
    {
        if (empty($this->session->userdata('user_id'))) {
            redirect(base_url());
        }
        $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
        $data['Customer'] = $this->Common_model->getAllData('sub_groups', '', '', ['group_id' => 7]);
        $data['de_dupe'] = $this->Common_model->getAllData('de_dupe_master', '', '', ['is_active' => 'Y']);
        $data['product']= $this->Common_model->getAllData('product_master_loan', '', '', ['is_active' => 'Y']);
        $data['user']= $this->Common_model->getAllData('customer_master', '', '', ['is_active' => 'Y']);
        $data['branch_master']= $this->Common_model->getAllData('branch_masters', '', '', ['is_active' => 'Y']);
        // $data['user']= $this->Common_model->getAllData('customer_master', '', '', '','','','de_dupe_mobile_number');
        $data['page_title'] = 'EMBARK | Loan Report';
        $data['user_details'] = $user_details;
        $this->load->view('include/head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/header');
		$this->load->view('report/loan_report');
        $this->load->view('include/footer');
        $this->load->view('include/end');
    }

    #=====================================
    # Load List data
    #=====================================
    public function data_list($statusdata='',$customerdata = '',$productsdata='',$branchdata='', $to_date = '', $form_date = '')
    {
        if($statusdata == 'null'){
            $statusdata = '';
        }
        if($customerdata == 'null'){
            $customerdata = '';
        }
        if($productsdata == 'null'){
            $productsdata = '';
        }
        if($branchdata == 'null'){
            $branchdata = '';
        }
        $testdata = $this->Common_model->callSP("CALL sp_report('".$statusdata."', '".$customerdata."', '".$productsdata."', '".$branchdata."', '".$to_date."', '".$form_date."')");
        // prx($this->db->last_query());
        $data = array();
        foreach ($testdata as $key => $fieldData) {
    
			if($fieldData['product_type']==11){
                $product= $this->Common_model->getAllData('product_master_loan', '', 1, ['id' => $fieldData['product_id']]);
                $product = $product->loan_main_product_name;
            }else{
                $product = $this->Common_model->getAllData('product_master_deposit', '', 1, ['id' => $fieldData['product_id']]);
                $product = $product->deposit_main_product_name;
            }

            if($fieldData['verify_statas'] == 'P'){
                $status = 'Pending';

            }elseif($fieldData['verify_statas'] == 'A'){
                $status = 'Approved';

            }elseif($fieldData['verify_statas'] == 'R'){
                $status = 'Rejected';
            }else{
                $status = 'Pending';
            }
            $customer_details = decrypt($fieldData['de_dupe_first_name']). ' ' . decrypt($fieldData['de_dupe_last_name']) . '(' . decrypt($fieldData['account_number']) . ')';
            $data[] = array(
                $key + 1,
                decrypt($product),
                $customer_details,
				decrypt($fieldData['account_number']),
				$status
            );
			
        }

        if (isset($_POST['draw']) && $_POST['draw']) {
            $draw = $_POST['draw'];
        } else {
            $draw = '';
        }

        $output = array(
            "draw" => $draw,
            // "recordsTotal" => $dttbl_model->countAll(),
            "recordsTotal" => $testdata[0]->recordsTotal,
            // "recordsFiltered" => $dttbl_model->countFiltered($_POST),
            "recordsFiltered" => $testdata[0]->recordsFiltered,
            "data" => $data,
            "status" => 'success',
			"csrf" => update_csrf_session()
        );

        # response
        echo json_encode($output);
        unset($dttbl_model);
    }
 
    #=====================================
    # Load modal
    #=====================================
    public function load_modal()
    {
        $id = post('id');

        $data['account_type'] = $this->Common_model->getAllData('account_type_master', '', '', ['is_active' => 'Y']);
        $data['de_dupe'] = $this->Common_model->getAllData('de_dupe_master', '', '', ['is_active' => 'Y']);
        // $d =  $data['customermaster'] = $this->Common_model->getAllData('customer_master', '', '', ['id' => '1']);
        // print_r($d); exit;
            if($id){
                $customermaster =  $data['customermaster'] = $this->Common_model->getAllData('customer_master', '', '', ['id' => $id]);
                // if($d[0]->account_type == 4){
                //     $data['salarymaster'] = $this->Common_model->getAllData('salary_account_master', '', '', ['customer_master_id' => $d[0]->account_number]);
                // }elseif($d[0]->account_type == 2){
                //     $data['currentmaster'] = $this->Common_model->getAllData('current_account_master', '', '', ['customer_master_id' => $d[0]->account_number]);
                // }
                $data['documentmaster'] = $this->Common_model->getAllData('document_masters', '', '', ['id' => $id]);
                if($customermaster[0]->product_type==11){
                    $data['product'] = $this->Common_model->getAllData('product_master_loan', '', '', ['id' => $customermaster[0]->product]);
                    $data['action'] = 1;
                }else{
                    $data['product'] = $this->Common_model->getAllData('product_master_deposit', '', '', ['id' => $customermaster[0]->product]);
                    $data['action'] = 0;

            }
            }
            $data['document'] = $this->Common_model->getAllData('sub_groups', '', '', ['group_id' => 7]);
           
        

        $html = $this->load->view('add_applicant/customer_master/component/customer_master_modal_body', $data, true);

        # response
        $result = array('html' => $html, 'status' => 'success');
        $obj = (object) array_merge((array) $result,update_csrf_session());
        echo json_encode($obj);
    }

    //ankit adhikary 05-06-23
    public function aadharcheck()
    {
        $aadhar = post('aadhar');
        $data['de_dupe'] = $this->Common_model->getAllData('de_dupe_master', '', '', ['is_active' => 'Y']);
        $customermaster = $data['customermaster'] = $this->Common_model->getAllData('customer_master', '', '', ['de_dupe_aadhar_number' => $aadhar]);
        $data['documentmaster'] = $this->Common_model->getAllData('document_masters', '', '', ['id' => $customermaster[0]->id]);
                if($customermaster[0]->product_type==11){
                    $data['product'] = $this->Common_model->getAllData('product_master_loan', '', '', ['id' => $customermaster[0]->product]);
                    $data['action'] = 1;
                }else{
                    $data['product'] = $this->Common_model->getAllData('product_master_deposit', '', '', ['id' => $customermaster[0]->product]);
                    $data['action'] = 0;

            }
        $html = $this->load->view('add_applicant/customer_master/component/customer_master_modal_body_part', $data, true);
        $result = array('html' => $html, 'status' => 'success');
        $obj = (object) array_merge((array) $result,update_csrf_session());
        echo json_encode($obj);
    }

    public function load_product()
    {
        $id =decrypt(post('id'));
        
        if($id == 11){

                $data['option'] = $this->Common_model->getAllData('product_master_loan', '', '', ['is_active' => 'Y']);
                $data['action'] = 1;
            // $data['option'] = $this->Common_model->get2WhereIn('product_master_loan', $id, 'id', 'Y','is_active');
            }else{
                $data['option'] = $this->Common_model->getAllData('product_master_deposit', '', '', ['is_active' => 'Y']);
                $data['action'] = 0;

            }

        $html = $this->load->view('add_applicant/customer_master/component/customer_product_option', $data, true);

        # response
        $result = array('html' => $html, 'status' => 'success');
        $obj = (object) array_merge((array) $result,update_csrf_session());
        echo json_encode($obj);
    }
	
	#=====================================
    # Save
    #=====================================
    public function save()
    { 
        $de_dupe = $this->Common_model->getAllData('de_dupe_master', '', '', ['is_active' => 'Y']);
        $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));

        # validate post data
		$this->form_validation->set_rules('account_type', 'Account Type', 'trim|required');
		$this->form_validation->set_rules('product', 'Product', 'trim|required');
		$this->form_validation->set_rules('product_type', 'Product Type', 'trim|required');
        if(post('applicant_type')=='new'){ 
        foreach($de_dupe as $key => $value){
            if($value->is_required == 'Y'){
                $this->form_validation->set_rules(decrypt($value->field_name_slug), decrypt($value->field_name), 'trim|required');
               
            }
        }
    }
        if ($this->form_validation->run() == FALSE) {
            $msg = $this->form_validation->error_array();
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            if (post('customer_id') == 0) {
                // Add

                foreach($de_dupe as $key => $value){
                    if(decrypt($value->field_type) == 'text'){
                        if(!empty($value->field_name_slug)){
                            if(post(decrypt($value->field_name_slug)) == ''){
                                $data[decrypt($value->field_name_slug)] = '';
                            }else{
                                $data[decrypt($value->field_name_slug)] = encrypt(post(decrypt($value->field_name_slug)));
                            }
                        }
                    }else
                    {
                        $data[decrypt($value->field_name_slug)] = post(decrypt($value->field_name_slug));
                    }
                }
            $data['account_type'] = post("account_type");
            $data['product'] = decrypt(post("product"));
            $data['product_type'] = decrypt(post("product_type"));
            $data['account_created_by'] = $user_details->id;
            $data['created_by'] = $user_details->id;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['is_active'] = 'Y';
            $data['applicant_type'] = post("applicant_type");
            $data['user_password'] = hash('md5', '1234');

            // echo "<pre>"; print_r($data);
            $de_dupe = $this->Common_model->getAllData('de_dupe_master', '', '', ['is_active' => 'Y']);
            $save = $this->Common_model->add('customer_master', $data);
            $id = $this->db->insert_id();

            if(decrypt(post("product_type")) == 11){
                $product = $this->Common_model->getAllData('product_master_loan', '', '', ['id' => decrypt(post("product"))]);
                $product_code = $product[0]->loan_main_product_code;
            }else{
                $product= $this->Common_model->getAllData('product_master_deposit', '', '', ['id' => decrypt(post("product"))]);
                $product_code = $product[0]->deposit_main_product_code;
            }

            $updatedata['account_number'] = encrypt(decrypt($product_code)."/".date("ymd")."/".$id);
            // prx($updatedata);
            $save = $this->Common_model->UpdateDB('customer_master', ['id'=>$id], $updatedata);
            }else{
                // Edit
                foreach($de_dupe as $key => $value){
                    if(decrypt($value->field_type) == 'text'){
                         if(post(decrypt($value->field_name_slug)) == ''){
                                $data[decrypt($value->field_name_slug)] = '';
                            }else{
                                $data[decrypt($value->field_name_slug)] = encrypt(post(decrypt($value->field_name_slug)));
                            }
                    }else
                    {
                    $data[decrypt($value->field_name_slug)] = post(decrypt($value->field_name_slug));
                    }
                }
                $data['account_type'] = post("account_type");
                $data['product'] = decrypt(post("product"));
                $data['product_type'] = decrypt(post("product_type"));
                $data['updated_by'] = $user_details->id;
                $data['updated_at'] = date('Y-m-d H:i:s');
            $save = $this->Common_model->UpdateDB('customer_master', ['id'=>post('customer_id')], $data);

            }
        }
        
            if ($save) {
                $array = array('status' => 'success', 'error' => '', 'message' => 'success_message');
            } else {
                $array = array('status' => 'fail', 'error' => $err, 'message' => '');
            }
        // }
        # Response
		$array = array_merge($array,update_csrf_session());
        echo json_encode($array);
    }
	#=====================================
    # Delete
    #=====================================
    public function delete(){
        $id = post('id');
        $save = $this->Common_model->UpdateDB('customer_master', ['id' => $id], ['is_active' => 'N']);
        if ($save) {
            $array = array('status' => 'success', 'error' => '', 'message' => 'success_message');
        } else {
            $array = array('status' => 'fail', 'error' => 'error_message', 'message' => '');
        }
        # Response
		$array = array_merge($array,update_csrf_session());
        echo json_encode($array);
    }
	#=====================================
    # Get verify from
    #=====================================
    public function load_verify_from(){
        $data['id'] = $id = post('id');
        $data['co_applicent'] = $co_applicent = post('co_applicent');
        $data['action'] = $action = post('action');
        $data['kyc_tab'] = $this->Common_model->getAllData('kyc_tab', '', '', ['is_active' => 'Y']);
        $customermaster = $this->Common_model->getAllData('customer_master', '', '1', ['id' => $id]);
        if($customermaster->product_type == 11){
            $product = $this->Common_model->getAllData('product_master_loan', '', '1', ['id' => $customermaster->product]);
        }else{
            $product = $this->Common_model->getAllData('product_master_deposit', '', '1', ['id' => $customermaster->product]);
        }
        $data['documentMasters'] = $this->Common_model->getAllData('document_masters', '', '', ['sub_group_id' => $customermaster->product_type, 'product_id' => $customermaster->product, 'is_active' => 'Y']);

        $html = $this->load->view('add_applicant/customer_master/component/verify_from', $data, true);
        # response
        $result = array('html' => $html, 'status' => 'success');
        $obj = (object) array_merge((array) $result,update_csrf_session());
        echo json_encode($obj);
    }
    
   
   
     public function apiVerify(){
        $details = $body = post('body');
        $body = json_decode($body, true);
        $id = post('id');
        $co_applicent = post('co_applicent');
        $action = post('action');
        // $id = 5;
        // $co_applicent = 2;
        // $action = 1;
        $document_id = post('document_id');
        $sub_tab_id = post('sub_tab_id');
        $err = "Something is wrong";
        $kyc_sub_tab = $this->Common_model->getAllData('kyc_sub_tab', '', '1', ['id' => $sub_tab_id]);
        if (array_key_exists("consent", $body)) {
            $body['consent'] = 'Y';
        }
        if (array_key_exists("additionalDetails", $body)) {
            $body['additionalDetails'] = true;
        }

        $headers = array(
			'Content-Type: application/json',
			'x-karza-key: wKlf5fVN4xaRYeul'
		);		//Added by Suhrid Sarkar || suhrid.developer@gmail.com on June 01, 2023
        $result = getApi($kyc_sub_tab->url, $body, $headers);  //CR by Suhrid Sarkar || suhrid.developer@gmail.com on June 01, 2023
        
        $data = json_decode($result, true);
        if($action == 0){
            $customermaster = $this->Common_model->getAllData('customer_master', '', '', ['id' => $id]);
            $customer_details = $this->Common_model->getAllData('customer_document_verification', '', '', ['details' => $details]);
            // $sql = $this->db->last_query();
            if($data['status-code'] == 101 || $data['statusCode'] == 101){
                if(strtoupper(decrypt($customermaster[0]->de_dupe_first_name)." ".decrypt($customermaster[0]->de_dupe_last_name)) == strtoupper($data['result']['name'])){   
                    if(empty($customer_details)){
                    $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
                    $data = array(
                        'customer_id' => $id,
                        'sub_tab_id' => $sub_tab_id,
                        'document_id' => $document_id,
                        'details' => $details,
                        'response_details' => $result,
                        'status' => 'Y',
                        'verify_by' => $user_details->id,
                    );
                    $save = $this->Common_model->add('customer_document_verification', $data);
                }else{
                    $err = "This document already exists.";
                }
            }
            }

            $documentMasters = $this->Common_model->getAllData('document_masters', '', '', ['sub_group_id' => $customermaster[0]->product_type, 'product_id' => $customermaster[0]->product, 'is_active' => 'Y']);
            foreach($documentMasters as $value){
                if($value->is_required == 'Y'){
                    $verifyDoc = $this->Common_model->getAllData('customer_document_verification', '', '', ['customer_id' => $id, 'sub_tab_id'=>$value->document]);
                    if(!empty($verifyDoc)){
                        $action=$action+1;
                    }
                }else{
                    $action=$action+1; 
                }
            }

            if($action == count($documentMasters)){
                $updatedata['verify_statas'] = 'A';
                $update = $this->Common_model->UpdateDB('customer_master', ['id'=>$id], $updatedata);
            }
    }else{
        if($data['status-code'] == 101 || $data['statusCode'] == 101){
            $co_applicant_data = $this->Common_model->getAllData('co_applicant_data', '', '', ['id' => $co_applicent]);
            $co_applicant_details = $this->Common_model->getAllData('co_applicant_document_verification', '', '', ['details' => $details]);
            // $sql = $this->db->last_query();
            if($data['status-code'] == 101 || $data['statusCode'] == 101){
                if(strtoupper(decrypt($co_applicant_data[0]->co_aplicant_name)) == strtoupper($data['result']['name'])){   
                    if(empty($co_applicant_details)){
                        $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
                        $data = array(
                            'co_applicant_id' => $co_applicent,
                            'sub_tab_id' => $sub_tab_id,
                            'document_id' => $document_id,
                            'details' => $details,
                            'response_details' => $result,
                            'status' => 'Y',
                            'verify_by' => $user_details->id,
                        );
                        $save = $this->Common_model->add('co_applicant_document_verification', $data);
                    }else{
                        $err = "This document already exists.";
                    }
                }
            }
        }

        $customermaster = $this->Common_model->getAllData('customer_master', '', '', ['id' => $id]);

        $documentMasters = $this->Common_model->getAllData('document_masters', '', '', ['sub_group_id' => $customermaster[0]->product_type, 'product_id' => $customermaster[0]->product, 'is_active' => 'Y']);
        foreach($documentMasters as $value){
           
            if($value->is_required == 'Y'){
                $verifyDoc = $this->Common_model->getAllData('co_applicant_document_verification', '', '', ['co_applicant_id' => $co_applicent, 'sub_tab_id'=>$value->document]);
                if(!empty($verifyDoc)){
                    $action=$action+1;
                }
            }else{
                $action=$action+1; 
            }
        }

        if($action == count($documentMasters)){
            $updatedata['verify_statas'] = 'A';
            $update = $this->Common_model->UpdateDB('co_applicant_data', ['id'=>$co_applicent], $updatedata);
        }
        
    }
        if ($save) {
            $array = array('status' => 'success', 'error' => '', 'message' => 'success_message');
        } else {
            $array = array('status' => 'fail', 'error' => $err, 'message' => '');
        }

        # Response
		$array = array_merge($array,update_csrf_session());
        echo json_encode($array);
    }
    
    #=====================================
    # Get Loan application from===========
    #=====================================
    public function load_loan_application_from(){
        // prx($this->db->list_fields('co_applicant_data'));
        $id = post('id');
        $data['loan_input_tab'] = $this->Common_model->getAllData('loan_tab_master', '', '', ['is_active'=>'Y']);
        $data['co_applicant_panel'] = $this->Common_model->getAllData('co_applicant_panel_master', '', '', ['is_active'=>'Y']);
        $data['sub_groups'] = $this->Common_model->getAllData('sub_groups', '', '1', ['id'=>20, 'is_active'=>'Y']);

        if($id){
            $data['fromData'] = $this->Common_model->getAllData('loan_form_data', '', '1', ['id'=>$id]);
            $data['co_applicant_data'] = $this->Common_model->getAllData('co_applicant_data', '', '', ['loan_id' => $id]);
            // prx($data['co_applicant_data']);
            $data['customer_master'] = $this->Common_model->getAllData('customer_master', '', '1', ['id'=>$data['fromData']->customer_id]);
            if($data['customer_master']->product_type==11){
                $product= $this->Common_model->getAllData('product_master_loan', '', '', ['id' => $data['customer_master']->product]);
                $data['product'] = $product[0]->loan_main_product_name;
            }else{
                $product = $this->Common_model->getAllData('product_master_deposit', '', '', ['id' => $data['customer_master']->product]);
                $data['product'] = $product[0]->deposit_main_product_name;
            }

        }
        $html = $this->load->view('add_applicant/customer_master/component/loan_application_from_modal_body', $data, true);
        # response
        $result = array('html' => $html, 'status' => 'success');
        $obj = (object) array_merge((array) $result,update_csrf_session());
        echo json_encode($obj);
    }
    #=====================================
    # Get View Loan application from =====
    #=====================================

    public function apply_loan($id){
        ob_start();
        if(empty($this->session->userdata('user_id'))) {
            redirect(base_url());
        }
        $data['id'] = $id;
        $data['co_applicant_panel'] = $this->Common_model->getAllData('co_applicant_panel_master', '', '', ['is_active'=>'Y']);
        $data['sub_groups'] = $this->Common_model->getAllData('sub_groups', '', '1', ['id'=>20, 'is_active'=>'Y']);
        $data['loan_input_tab'] = $this->Common_model->getAllData('loan_tab_master', '', '', ['is_active'=>'Y']);
        $data['customer_master'] = $this->Common_model->getAllData('customer_master', '', '1', ['id'=>$id]);
        $data['customer_document_verification'] = $this->Common_model->getAllData('customer_document_verification', '', '', ['customer_id'=>$id]);
        $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
        $data['user_details'] = $user_details;
        if($data['customer_master']->product_type==11){
            $product= $this->Common_model->getAllData('product_master_loan', '', '', ['id' => $data['customer_master']->product]);
            $data['product'] = $product[0]->loan_main_product_name;
        }else{
            $product = $this->Common_model->getAllData('product_master_deposit', '', '', ['id' => $data['customer_master']->product]);
            $data['product'] = $product[0]->deposit_main_product_name;
        }
        $data['page_title'] = 'EMBARK | Loan Application Form';
        $this->load->view('include/head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/header');
		$this->load->view('add_applicant/customer_master/loan_application_from');
        $this->load->view('include/footer');
        $this->load->view('include/end');
    }

    #=====================================
    #  Added by Ankit Adhikary on May 30, 2023 
    #  For multiple co applicant
    #=====================================
    public function add_co_applicant_tab(){
        $data['count'] = post('count');
        $tab = $this->load->view('add_applicant/customer_master/component/loan_co_applicant_tab', $data, true);
        $data['co_applicant_panel'] = $this->Common_model->getAllData('co_applicant_panel_master', '', '', ['is_active'=>'Y']);
		$tab_body = $this->load->view('add_applicant/customer_master/component/loan_co_applicant_tab_body', $data, true);

        # response
        $result = array('tab' => $tab,'tab_body'=> $tab_body, 'status' => 'success');
        $obj = (object) array_merge((array) $result,update_csrf_session());
        echo json_encode($obj);
    }


    #=====================================
    #  Loan Approve ===================
    #=====================================
    public function approved_loan()
    {
        $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
        $data['verify_statas'] = post('action');
        $data['verify_by'] = $user_details->id;
        $save = $this->Common_model->UpdateDB('loan_form_data', ['id'=>post('id')], $data);
        if ($save) {
            $array = array('status' => 'success', 'error' => '', 'message' => 'success_message');
        } else {
            $array = array('status' => 'fail', 'error' => 'error_message', 'message' => '');
        }
        $array = array_merge($array,update_csrf_session());
        echo json_encode($array);
    }
    #=====================================
    # Insert Loan Application=============
    #=====================================
    public function save_loan_application()
    { 
        $loan_input_master = $this->Common_model->getAllData('loan_input_master', '', '', ['is_active' => 'Y']);
        $co_applicant_master = $this->Common_model->getAllData('co_applicant_master', '', '', ['is_active' => 'Y']);
        $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));

        # validate post data
		// $this->form_validation->set_rules('account_type', 'Account Type', 'trim|required');
		// $this->form_validation->set_rules('product', 'Product', 'trim|required');
		// $this->form_validation->set_rules('product_type', 'Product Type', 'trim|required');
        if (post('from_id') == 0) {
            foreach($loan_input_master as $key => $value){
                if($value->is_required == 'Y'){
                    $this->form_validation->set_rules(decrypt($value->field_name_slug), decrypt($value->field_name), 'trim|required');
                }
            }
            foreach($co_applicant_master as $key => $value){
                if($value->is_required == 'Y'){
                    $this->form_validation->set_rules(decrypt($value->field_name_slug), decrypt($value->field_name), 'trim|required');
                }
            }
        // if ($this->form_validation->run() == FALSE) {
        //     $msg = $this->form_validation->error_array();
        //     $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        // } else {
            
                // Add

            foreach($loan_input_master as $key => $value){
                if(decrypt($value->field_type) == 'text'){
                    $data[decrypt($value->field_name_slug)] = encrypt(post(decrypt($value->field_name_slug)));
                }else
                {
                    $data[decrypt($value->field_name_slug)] = post(decrypt($value->field_name_slug));
                }
            }
            $data['customer_id'] = post("customer_id");
            $data['product_id'] = post("product_id");
            $data['product_type'] = post("product_type");
            $data['created_by'] = $user_details->id;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['is_active'] = 'Y';

            // $save = $this->Common_model->add_get_lstId('loan_form_data', $data);
            $id = $this->Common_model->add_get_lstId('loan_form_data', $data);

            foreach($co_applicant_master as $key => $value){
                
                foreach(post(decrypt($value->field_name_slug)) as $kk => $vv){
                    if(decrypt($value->field_type) == 'text'){
                        $co_applicant_data[$kk][decrypt($value->field_name_slug)] = encrypt(post(decrypt($value->field_name_slug))[$kk]);
                    }else{
                        $co_applicant_data[$kk][decrypt($value->field_name_slug)] = post(decrypt($value->field_name_slug))[$kk];
                    }
                    $co_applicant_data[$kk]['loan_id'] = $id;
                    $co_applicant_data[$kk]['created_by'] = $user_details->id;
                    $co_applicant_data[$kk]['created_at'] = date('Y-m-d H:i:s');
                    $co_applicant_data[$kk]['is_active'] = 'Y';
                    // $save = $this->Common_model->add('co_applicant_data', $co_applicant_data);
                }
            }
            // prx($co_applicant_data);
            foreach($co_applicant_data as $key => $value){
                $save = $this->Common_model->add('co_applicant_data', $value);
            }
            
            // $co_applicant_data['loan_id'] = $id;
            // $co_applicant_data['created_by'] = $user_details->id;
            // $co_applicant_data['created_at'] = date('Y-m-d H:i:s');
            // $co_applicant_data['is_active'] = 'Y';
            // print_r($co_applicant_data);die();
            // prx($co_applicant_data);
            // $save = $this->Common_model->add('co_applicant_data', $co_applicant_data);

            if ($save) {
                $array = array('status' => 'success', 'error' => '', 'message' => 'success_message');
            } else {
                $array = array('status' => 'fail', 'error' => 'error_message', 'message' => '');
            }
        // }
        }else{

            $data['verify_statas'] = post('action');
            $data['verify_by'] = $user_details->id;

            $save = $this->Common_model->UpdateDB('loan_form_data', ['id'=>post('from_id')], $data);
            if ($save) {
                $array = array('status' => 'success', 'error' => '', 'message' => 'success_message');
            } else {
                $array = array('status' => 'fail', 'error' => 'error_message', 'message' => '');
            }
        }
        
            
        // }
        # Response
		$array = array_merge($array,update_csrf_session());
        echo json_encode($array);
    }
    
    
    public function loadapiData(){
        $action = post('action');
        $id = post('id');
        $sub_tab_id = post('sub_tab_id');
        $co_applicent = post('co_applicent');
        if($action == 0){
            $data['verifyDocument'] = $this->Common_model->getAllData('customer_document_verification', '', '', ['sub_tab_id'=>$sub_tab_id,'customer_id' => $id]);
        }else{
            $data['verifyDocument'] = $this->Common_model->getAllData('co_applicant_document_verification', '', '', ['sub_tab_id'=>$sub_tab_id,'co_applicant_id' => $co_applicent]);
        }         
           
        

        $html = $this->load->view('add_applicant/customer_master/component/lodeapidata', $data, true);

        # response
        $result = array('html' => $html, 'status' => 'success');
        $obj = (object) array_merge((array) $result,update_csrf_session());
        echo json_encode($obj); 
    }
}
?>