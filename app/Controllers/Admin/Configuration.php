<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConfigurationModel;

class Configuration extends BaseController
{
	public function index()
	{
		$data['title'] = "Configuration List";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $configurationModel = new ConfigurationModel();
        $data['all_configuration'] =  $configurationModel->orderBy('configuration_id', 'ASC')->findAll();	

        echo view('admin/configuration/list', $data);  
        echo view('admin/common/footer', $data);
	}

	function add()
	{
		$data['title'] = "Add Configuration";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        echo view('admin/configuration/add', $data);  
        echo view('admin/common/footer', $data);
	}

	function add_configuration()
	{
		$configuration_level = $this->request->getPost('configuration_level');
		$configuration_key = $this->request->getPost('configuration_key');
		$configuration_value = $this->request->getPost('configuration_value');

		$configurationModel = new ConfigurationModel();

		$data = [
			'configuration_level' => $configuration_level,
			'configuration_key' => $configuration_key,
			'configuration_value' => $configuration_value,
		];

		// Try insert
		$insertId = $configurationModel->insert($data);

		if ($insertId) {
			// SUCCESS
			session()->setFlashdata('success_msg', 'Record Inserted Successfully!');
		} else {
			// FAILED
			session()->setFlashdata('error_msg', 'Insert Failed: ' . implode(', ', $configurationModel->errors()));
		}

		return redirect()->to(base_url('admin/configuration'));
	}

	function edit()
	{
		$data['title'] = "Edit Configuration";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $configurationModel = new ConfigurationModel();
        $data['all_configuration'] =  $configurationModel->orderBy('configuration_id', 'ASC')->findAll();	

        echo view('admin/configuration/edit', $data);  
        echo view('admin/common/footer', $data);
	}

	function update_configuration()
	{
		$post_val = array();
		$post_val = $this->request->getPost();

		$configurationModel = new ConfigurationModel();

		foreach($post_val as $key => $value){
			$configurationModel->where('configuration_key', $key)
                    ->set(['configuration_value' => $value])
                    ->update();
		}

		session()->setFlashdata('success_msg', 'Record is Updated Successfully!');
		return redirect()->to(base_url('admin/configuration'));
	}
}