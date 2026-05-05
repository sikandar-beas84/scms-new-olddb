<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    // * Auth: Suhrid Sarkar
    // * On: 09-06-2023
    // * For: Api report
    
class Api_report extends CI_Controller
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
        // $data['Customer'] = $this->Common_model->getAllData('sub_groups', '', '', ['group_id' => 7]);
        // $data['de_dupe'] = $this->Common_model->getAllData('de_dupe_master', '', '', ['is_active' => 'Y']);
        $data['product']= $this->Common_model->getAllData('product_master_loan', '', '', ['is_active' => 'Y']);
        $data['kyc_tab']= $this->Common_model->getAllData('kyc_tab', '', '', ['is_active' => 'Y']);
        // $data['user']= $this->Common_model->getAllData('customer_master', '', '', ['is_active' => 'Y']);
        // $data['branch_master']= $this->Common_model->getAllData('branch_masters', '', '', ['is_active' => 'Y']);
        // $data['user']= $this->Common_model->getAllData('customer_master', '', '', '','','','de_dupe_mobile_number');
        $data['page_title'] = 'EMBARK | API Cost Report';
        $data['user_details'] = $user_details;
        $this->load->view('include/head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/header');
		$this->load->view('report/api_report/api_report');
        $this->load->view('include/footer');
        $this->load->view('include/end');
    }

    #=====================================
    # Load List data
    #=====================================
    public function data_list($Customer_id = '',$product = '', $kyc_tab = '')
    {
        // prx($product.' '.$kyc_tab);
        # include datatable model
        include_once('application/models/Datatable_model.php');
        # customize filter
        $order_by = array('document_masters.id ' => 'desc');
        $where_in = array();
        
        if($product != 'null' && $product != ''){
            $where['document_masters.product_id'] = $product;
            
        }
        if($kyc_tab != 'null' && $kyc_tab != ''){
            $where['document_masters.document_type'] = $kyc_tab;
        }
       
        
        $join1 = array(
                'ontable' => 'kyc_sub_tab',
                'onParams' => 'kyc_sub_tab.id = document_masters.document',
                'type' => 'left'
        );
        
        $join2 = array(
                'ontable' => 'kyc_tab',
                'onParams' => 'kyc_tab.id = document_masters.document_type',
                'type' => 'left'
        );
        $join = array($join1, $join2);
        // $where = array();
        $queryAttachments = array(
            'select' => 'document_masters.*, kyc_sub_tab.name, kyc_sub_tab.url, kyc_sub_tab.cost, kyc_tab.name as kye_tab_name',
            'where' => $where,
            'where_in' => $where_in,
            'join' => $join,
            'group_by' => ''
        );

        $dttbl_model = new Datatable_model('document_masters', array(), array(), $order_by, $queryAttachments);
        $testdata = $dttbl_model->getRows($_POST);
        $data = array();
        // prx($testdata);
        $total_cost = 0;
        foreach ($testdata as $key => $fieldData) {
    
			if($fieldData->sub_group_id==11){
                $product= $this->Common_model->getAllData('product_master_loan', '', '', ['id' => $fieldData->product_id]);
                $product = $product[0]->loan_main_product_name;
            }else{
                $product = $this->Common_model->getAllData('product_master_deposit', '', '', ['id' => $fieldData->product_id]);
                $product = $product[0]->deposit_main_product_name;
            }
           
            $data[] = array(
                $key + 1,
                decrypt($product),
				$fieldData->kye_tab_name,
				$fieldData->name,
				$fieldData->url,
				$fieldData->cost,				
                
            );
            $total_cost += $fieldData->cost;
			
			
        }
        $data2[] = array(
            '',
            '',
            '',
            '',
            '<b>Total:</b>',
            '<b>'.$total_cost.'</b>'

        );
        $data = array_merge($data,$data2);
        // prx($data);

        if (isset($_POST['draw']) && $_POST['draw']) {
            $draw = $_POST['draw'];
        } else {
            $draw = '';
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $dttbl_model->countAll(),
            "recordsFiltered" => $dttbl_model->countFiltered($_POST),
            "data" => $data,
            "status" => 'success',
			"csrf" => update_csrf_session()
        );

        # response
        echo json_encode($output);
        unset($dttbl_model);
    }
 
    
}
?>