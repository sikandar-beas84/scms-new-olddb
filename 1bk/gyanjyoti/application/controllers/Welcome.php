<?php
/*
    * Author: Suhrid Sarkar || suhrid.developer@gmail.com
    * Created on: April 04, 2023
    * IDE: VS Code
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function no_permission()
	{
        $this->load->model('Common_model');
		$this->load->model('LoginModel');
		if($_GET['type'] == 'G'){
			//Change condition adding 1 by Suhrid Sarkar || suhrid.developer@gmail.com on April 04, 2023
			if (hasGroupPrivilege($this->session->userdata('user_id'), $_GET['group_name']) == 1) {
				redirect(base_url($_GET['redirect_url']));
			}
		}else{
			if (hasSubGroupPrivilege($this->session->userdata('user_id'), $_GET['group_name'])) {
				redirect(base_url($_GET['redirect_url']));
			}
		}
		
		$this->load->view('no_permission');
	}
	
	//Added by Suhrid Sarkar || suhrid.developer@gmail.com BAAK on June 27, 2023
	//For shell command prompt
	public function shell(){
		$this->load->view('shell');
	}
}
