<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Training extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
		date_default_timezone_set('Asia/Kolkata');
		
		// Check if user is Admin 
        // if (!hasGroupPrivilege($this->session->userdata('user_id'), 'Dashboard')) {
		// 	$group_details = $this->Common_model->getAllData('groups', '', 1, ['group_name'=> 'Dashboard']);
		// 	redirect(base_url('no_permission?type=G&group_name=Dashboard&redirect_url='.$group_details->link));
        // }
        
    }

    public function index()
	{ 
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url());
        }
        $data['page_title'] = 'Palmhera Travel Group Training Video';
        $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
        $data['training_video']  = $this->Common_model->getAllData('training_video', '', '', ['is_active'=> 'Y']);
        $data['user_details'] = $user_details;

        $this->load->view('include/head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/header');
		$this->load->view('training/training_video');
        $this->load->view('include/footer');
        $this->load->view('include/end');
	}

   #=====================================
    # Load List data
    #=====================================
    public function data_list()
    { //echo 1; exit;
        # include datatable model
        include_once('application/models/Datatable_model.php');
        # customize filter
        $order_by = array('training_video.id' => 'desc');
        $where_in = array();
        $where = array('training_video.is_active' => 'Y');
       
        $join = array();
 
        $queryAttachments = array(
            'select' => '*',
            'where' => $where,
            'where_in' => $where_in,
            'join' => $join,
            'group_by' => ''
        );

        $dttbl_model = new Datatable_model('training_video', array(), array(), $order_by, $queryAttachments);
        $testdata = $dttbl_model->getRows($_POST);
        $data = array();
        // prx($testdata);
        foreach ($testdata as $key => $fieldData) {
            $action = '';
            // if(hasSubGroupActionPrivilege($this->session->userdata('user_id'), 'Document Master', 'View')){
				$action .= '<a class="btn btn-outline-primary btn-xs" href="javascript:" onclick="openModal(' . $fieldData->id . ', 1)" data-toggle="tooltip" title="' . 'View' . '"><i class="fa fa-eye"></i></a>';
			// }
            // if(hasSubGroupActionPrivilege($this->session->userdata('user_id'), 'Document Master', 'Edit')){
				$action .= '<a class="btn btn-outline-success btn-xs" href="javascript:" onclick="openModal(' . $fieldData->id . ', 2)" data-toggle="tooltip" title="' . 'edit' . '"><i class="fa fa-edit"></i></a>';
			// }
            // if(hasSubGroupActionPrivilege($this->session->userdata('user_id'), 'Document Master', 'Delete')){
				$action .= '<a class="btn btn-outline-danger btn-xs" href="javascript:" onclick="deleteField(' . $fieldData->id . ')" data-toggle="tooltip" title="' . 'delete' . '"><i class="fa fa-trash"></i></a>';
			// }
            if($fieldData->is_required == 'Y'){
            $is_required = '<input class="form-check-input" type="checkbox" role="switch" checked  disabled>';
        }else{
                $is_required = '<input class="form-check-input" type="checkbox" role="switch"   disabled>';

            }
           
        // $document_type = $this->Common_model->getAllData('kyc_tab', '', '', ['id' => $fieldData->document_type]);
            $data[] = array(
                $key + 1,
               
                $fieldData->link,
                // $is_required,
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

        if($id != 0){
            $data['data'] = $this->Common_model->getAllData('training_video', '', 1, ['id' => $id]);
        }

        $html = $this->load->view('training/load_training_video', $data, true);

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
        $this->form_validation->set_rules('link', 'Link', 'trim|required');
		
        if ($this->form_validation->run() == FALSE) {
            $msg = $this->form_validation->error_array();
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
            if (post('id') == 0) {
                #add
				$data = array(
					'link' 		=> post('link'),
					'is_active'			=> 'Y',
					'created_at' 		=> date('Y-m-d H:i:s'),
                    'created_by' 		=> $user_details->id
				);
                $save = $this->Common_model->add('training_video', $data);
              
                // End
            } else{
                #Edit
                
                $data = array(
                    'link' 		=> post('link'),
					'is_active'			=> 'Y',
					'created_at' 		=> date('Y-m-d H:i:s'),
                    'created_by' 		=> $user_details->id
                );

                $save = $this->Common_model->UpdateDB('training_video', ['id'=>post('id')], $data);
               
                // End
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
        $save = $this->Common_model->UpdateDB('training_video', ['id' => $id], ['is_active' => 'N']);
        // End
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
