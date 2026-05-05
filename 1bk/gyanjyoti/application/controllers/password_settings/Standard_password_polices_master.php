<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    // * Auth: Suhrid Sarkar
    // * On: 31-04-2023
    // * For: User Master
    // * For: Standard Password Polices Master
    
class Standard_password_polices_master extends CI_Controller
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
        $data['document'] = $this->Common_model->getAllData('sub_groups', '', '', ['group_id' => 7]);

        $data['page_title'] = 'EMBARK | Standard Password Polices Master';
        $data['user_details'] = $user_details;
        $this->load->view('include/head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/header');
		$this->load->view('password_settings/standard_password_polices/standard_password_polices');
        $this->load->view('include/footer');
        $this->load->view('include/end');
    }

    #=====================================
    # Load List data
    #=====================================
    public function data_list()
    {
        # include datatable model
        include_once('application/models/Datatable_model.php');
        # customize filter
        $order_by = array('standard_password_polices_master.id' => 'desc');
        $where_in = array();
        $where = array('standard_password_polices_master.is_active' => 'Y');
        $join = array();
 
        $queryAttachments = array(
            'select' => 'standard_password_polices_master.*',
            'where' => $where,
            'where_in' => $where_in,
            'join' => $join,
            'group_by' => ''
        );

        $dttbl_model = new Datatable_model('standard_password_polices_master', array(), array(), $order_by, $queryAttachments);
        $testdata = $dttbl_model->getRows($_POST);
        $data = array();
        // prx($testdata);
        foreach ($testdata as $key => $fieldData) {
            $action = '';
            if(hasSubGroupActionPrivilege($this->session->userdata('user_id'), 'Standard Password Polices Master', 'View')){
				$action .= '<a class="btn btn-outline-primary btn-xs" href="javascript:" onclick="openModal(' . $fieldData->id . ', 1)" data-toggle="tooltip" title="' . 'View' . '"><i class="fa fa-eye"></i></a>';
			}
            if(hasSubGroupActionPrivilege($this->session->userdata('user_id'), 'Standard Password Polices Master', 'Edit')){
				$action .= '<a class="btn btn-outline-success btn-xs" href="javascript:" onclick="openModal(' . $fieldData->id . ', 2)" data-toggle="tooltip" title="' . 'edit' . '"><i class="fa fa-edit"></i></a>';
			}
            if(hasSubGroupActionPrivilege($this->session->userdata('user_id'), 'Standard Password Polices Master', 'Delete')){
				$action .= '<a class="btn btn-outline-danger btn-xs" href="javascript:" onclick="deleteField(' . $fieldData->id . ')" data-toggle="tooltip" title="' . 'delete' . '"><i class="fa fa-trash"></i></a>';
			}
           
            
            $data[] = array(
                $key + 1,
                decrypt( $fieldData->title),
                decrypt( $fieldData->characters),
                $action
            );
        }

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

    #=====================================
    # Load modal
    #=====================================
    public function load_modal()
    {
        $id = post('id');

        if($id){
            $d =  $data['passwordpolices'] = $this->Common_model->getAllData('standard_password_polices_master', '', '', ['id' => $id]);

        }
    
        

        $html = $this->load->view('password_settings/standard_password_polices/component/standard_password_modal_body', $data, true);

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
        # validate post data
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('characters', 'Characters', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $msg = $this->form_validation->error_array();
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
            if (post('id') == 0) {
                #add
				$data = array(
					'title' 		=> encrypt(post('title')),
					'characters'	    => encrypt(post('characters')),
					'is_active'			=> 'Y',
					'created_at' 		=> date('Y-m-d H:i:s'),
                    'created_by' 		=> $user_details->id
				);
                $save = $this->Common_model->add('standard_password_polices_master', $data);
            }
            else{
                 #Edit
                
                 $data = array(
					'title' 		=> encrypt(post('title')),
					'characters'	    => encrypt(post('characters')),
					'is_active'			=> 'Y',
					'updated_at' 		=> date('Y-m-d H:i:s'),
                    'updated_by' 		=> $user_details->id
				);

                $save = $this->Common_model->UpdateDB('standard_password_polices_master', ['id'=>post('id')], $data);
            }

            if ($save) {
                $array = array('status' => 'success', 'error' => '', 'message' => 'success_message');
            } else {
                $array = array('status' => 'fail', 'error' => 'error_message', 'message' => '');
            }
        }
        # Response
		$array = array_merge($array,update_csrf_session());
        echo json_encode($array);
    }
	#=====================================
    # Delete
    #=====================================
    public function delete(){
        $id = post('id');
        $save = $this->Common_model->UpdateDB('standard_password_polices_master', ['id' => $id], ['is_active' => 'N']);
        if ($save) {
            $array = array('status' => 'success', 'error' => '', 'message' => 'success_message');
        } else {
            $array = array('status' => 'fail', 'error' => 'error_message', 'message' => '');
        }
        # Response
		$array = array_merge($array,update_csrf_session());
        echo json_encode($array);
    }
}
?>