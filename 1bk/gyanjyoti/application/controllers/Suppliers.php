<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class suppliers extends CI_Controller {

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

    public function index($id = '')
	{ 
	        if(empty($this->session->userdata('user_id'))){
                redirect(base_url());
            }
            $data['page_title'] = 'Suppliers';
            $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
            $data['user_details'] = $user_details;
            
	    if(empty($this->input->get('id'))):
            // if($this->input->get('id'))?
            $data['suppliers']  = $this->Common_model->getAllData('suppliers', '', '', ['is_active'=> 'Y']);

            $this->load->view('include/head', $data);
    		$this->load->view('include/side-bar');
            $this->load->view('include/header');
    		$this->load->view('suppliers/suppliers');
            $this->load->view('include/footer');
            $this->load->view('include/end');
        else:
            $data['suppliers']  = $this->Common_model->getAllData('suppliers', '', '', ['id'=> $this->input->get('id'), 'is_active'=> 'Y']);
            $this->load->view('include/head', $data);
    		$this->load->view('include/side-bar');
            $this->load->view('include/header');
    		$this->load->view('suppliers/suppliersPage');
            $this->load->view('include/footer');
            $this->load->view('include/end');
        endif;
	}

    #=====================================
    # Load List data
    #=====================================
    public function data_list()
    { //echo 1; exit;
        # include datatable model
        include_once('application/models/Datatable_model.php');
        # customize filter
        $order_by = array('suppliers.id' => 'desc');
        $where_in = array();
        $where = array('suppliers.is_active' => 'Y');
       
        $join = array();
 
        $queryAttachments = array(
            'select' => '*',
            'where' => $where,
            'where_in' => $where_in,
            'join' => $join,
            'group_by' => ''
        );

        $dttbl_model = new Datatable_model('suppliers', array(), array(), $order_by, $queryAttachments);
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
            if($fieldData->image):
           $image = '<img style="width: auto; height: 100px;" src="'.base_url().'assets/uploads/suppliers/'.$fieldData->image.'">';
           else:
               
           $image = '<img style="width: auto; height: 100px;" src="'.base_url().'assets/noimgland.jpg">';
            endif;   
            $data[] = array(
                $key + 1,
               
                $fieldData->name,
                $fieldData->address,
                $fieldData->email,
                $fieldData->phone,
                $image,
                $fieldData->about,
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
            $data['data'] = $this->Common_model->getAllData('suppliers', '', 1, ['id' => $id]);
        }

        $html = $this->load->view('suppliers/load_suppliers', $data, true);

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
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('category_name', 'Category', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('commission_rates', 'Commission Rates', 'trim|required');
        $this->form_validation->set_rules('bdm_contact_info', 'BDM/Contact Info', 'trim|required');
        $this->form_validation->set_rules('booking_resources_text', 'Booking Resources', 'trim|required');
        $this->form_validation->set_rules('booking_resources_link', 'Booking Resources Link', 'trim|required');
        $this->form_validation->set_rules('education_text', 'Education', 'trim|required');
        $this->form_validation->set_rules('education_link', 'Education Link', 'trim|required');
        $this->form_validation->set_rules('how_to_register', 'How to Register', 'trim|required');
        $this->form_validation->set_rules('more_text', 'More', 'trim|required');
        $this->form_validation->set_rules('more_link', 'More Link', 'trim|required');
        // $this->form_validation->set_rules('image', 'Image', 'trim|required');
        // $this->form_validation->set_rules('date', 'Date', 'trim|required');
// 		prx($_POST);
        if ($this->form_validation->run() == FALSE) {
            $msg = $this->form_validation->error_array();
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
            if (post('id') == 0) {
                #add
                $upload_files = '';
                 $filetype = array('jpeg','jpg','png','PNG','JPEG','JPG');
                if($_FILES['image']['name'] != ''){
                    $upload_files = multiUpload('image', 'assets/uploads/suppliers/', $filetype, "single", '');
                    // print_r($upload_files); //exit;
                }
				$data = array(
					'name' 		        => post('name'),
					'address' 		    => post('address'),
					'email' 		    => post('email'),
					'phone' 		    => post('phone'),
					'about' 		    => post('about'),
					'category' 		    => post('category_name'),

					'commission_rates' 		    => post('commission_rates'),
					'bdm_contact_info' 		    => post('bdm_contact_info'),
					'booking_resources_text' 		    => post('booking_resources_text'),
					'booking_resources_link' 		    => post('booking_resources_link'),
					'education_text' 		    => post('education_text'),
					'education_link' 		    => post('education_link'),
					'how_to_register' 		    => post('how_to_register'),
					'more_text' 		    => post('more_text'),
					'more_link' 		    => post('more_link'),
					'image' 		    => $upload_files,
					'is_active'			=> 'Y',
					'created_at' 		=> date('Y-m-d H:i:s'),
                    'created_by' 		=> $user_details->id
				);
                $save = $this->Common_model->add('suppliers', $data);
              
                // End
            } else{
                #Edit
                $filetype = array('jpeg','jpg','png','PNG','JPEG','JPG');
                if($_FILES['image']['name'] != ''){
                    $upload_files = multiUpload('image', 'assets/uploads/suppliers/', $filetype, "single", '');
                    $data = array(
    					'name' 		        => post('name'),
    					'address' 		    => post('address'),
    					'email' 		    => post('email'),
    					'phone' 		    => post('phone'),
    					'about' 		    => post('about'),
    					'category' 		    => post('category_name'),

    					'commission_rates' 		    => post('commission_rates'),
    					'bdm_contact_info' 		    => post('bdm_contact_info'),
    					'booking_resources_text' 		    => post('booking_resources_text'),
    					'booking_resources_link' 		    => post('booking_resources_link'),
    					'education_text' 		    => post('education_text'),
    					'education_link' 		    => post('education_link'),
    					'how_to_register' 		    => post('how_to_register'),
    					'more_text' 		    => post('more_text'),
    					'more_link' 		    => post('more_link'),
    					'image' 		    => $upload_files,
    					'is_active'			=> 'Y',
    					'updated_at' 		=> date('Y-m-d H:i:s'),
                        'updated_by' 		=> $user_details->id
    				);
                }else{
                    $data = array(
    					'name' 		        => post('name'),
    					'address' 		    => post('address'),
    					'email' 		    => post('email'),
    					'phone' 		    => post('phone'),
    					'about' 		    => post('about'),
    					'category' 		    => post('category_name'),
    					'commission_rates' 		    => post('commission_rates'),
    					'bdm_contact_info' 		    => post('bdm_contact_info'),
    					'booking_resources_text' 		    => post('booking_resources_text'),
    					'booking_resources_link' 		    => post('booking_resources_link'),
    					'education_text' 		    => post('education_text'),
    					'education_link' 		    => post('education_link'),
    					'how_to_register' 		    => post('how_to_register'),
    					'more_text' 		    => post('more_text'),
    					'more_link' 		    => post('more_link'),
    					'is_active'			=> 'Y',
						'updated_at' 		=> date('Y-m-d H:i:s'),
                        'updated_by' 		=> $user_details->id
    				);
                }
				

                $save = $this->Common_model->UpdateDB('suppliers', ['id'=>post('id')], $data);
               
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
        $save = $this->Common_model->UpdateDB('suppliers', ['id' => $id], ['is_active' => 'N']);
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
