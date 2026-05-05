<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\TblcMasterModel;


class Tblc extends BaseController
{
	public function index()
	{
		$data['title'] = "Tblc Items";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        echo view('admin/tblc/list', $data);  

        echo view('admin/common/footer', $data);	
	}

	function ajax_item_list()
	{
		$class_id = $this->request->getPost('class_id');
		$lang_name = $this->request->getPost('lang_name');

		$tblcMasterModel = new TblcMasterModel();
		$item_list = $tblcMasterModel->get_class_lang_items($class_id, $lang_name);

        return $this->response->setJSON(['item_list' => $item_list, 'class_id' => $class_id, 'lang_name' => $lang_name]);
	}

	function ajax_save_items()
	{
		try {
            // Read raw JSON input
            $json = $this->request->getJSON(true);

            if (!$json) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Invalid JSON data.'
                ]);
            }

            $class_id  = $json['class_id'] ?? null;
            $sec_lang  = $json['sec_lang'] ?? null;
            $items     = $json['items'] ?? [];
            $session_year_id = $this->session->get('session_year_id');

            // VALIDATION
			if (empty($class_id) || !is_numeric($class_id)) {
			    return $this->response->setJSON([
			        'status'  => 'error',
			        'message' => 'Class ID is required and must be numeric.',
			    ]);
			}

			if (empty($sec_lang)) {
			    return $this->response->setJSON([
			        'status'  => 'error',
			        'message' => 'Second language is required.',
			    ]);
			}

            // Basic validation
            if (!$class_id || !$sec_lang || empty($items)) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Class, Language and Items are required.'
                ]);
            }

            $model = new TblcMasterModel();

            // Insert new items
            $insertData = [];
            foreach ($items as $row) {
                $insertData[] = [
                    'class_id'         => $class_id,
                    'sec_lang'         => $sec_lang,
                    'item_name'        => $row['item_name'],
                    'qty'              => $row['qty'],
                    'price'            => $row['price'],
                    'total'            => $row['total'],
                    'status' 		   =>	1,
                    'add_date' 		   =>	date('Y-m-d H:i:s'),
                    'session_year_id'  => $session_year_id,
                    'created_by'  	   => $this->session->get('user_id'),
                    'created_date'     => date('Y-m-d H:i:s'),
                ];
            }

            if (!empty($insertData)) {
                $model->insertBatch($insertData);
            }

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Items saved successfully.'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
	}

	function ajax_delete_item()
	{
		$id = $this->request->getPost('id');

	    if (!$id) {
	        return $this->response->setJSON([
	            'status'  => 'error',
	            'message' => 'Invalid item ID'
	        ]);
	    }

	    $model = new TblcMasterModel();

	    $deleted = $model->delete($id);

	    if ($deleted) {
	        return $this->response->setJSON([
	            'status'  => 'success',
	            'message' => 'Item deleted successfully!'
	        ]);
	    } else {
	        return $this->response->setJSON([
	            'status'  => 'error',
	            'message' => 'Failed to delete the item'
	        ]);
	    }
	}

	function ajax_get_item_details()
	{
		$id = $this->request->getPost('id');

	    if (!$id) {
	        return $this->response->setJSON([
	            'status'  => 'error',
	            'message' => 'Invalid item ID'
	        ]);
	    }

	    $model = new TblcMasterModel();

	    $data = $model->where('id', $id)->first();

	    if ($data) {
	        return $this->response->setJSON([
	            'status' => 'success',
	            'data'   => $data
	        ]);
	    } else {
	        return $this->response->setJSON([
	            'status'  => 'error',
	            'message' => 'Record not found'
	        ]);
	    }
	}

	function ajax_update_tblc_item()
	{
		$data = $this->request->getPost();

		$id = $this->request->getPost('id');
		$item_name = $this->request->getPost('item_name');
		$qty = $this->request->getPost('qty');
		$price = $this->request->getPost('price');

		// VALIDATION
	    if (empty($item_name)) {
	        return $this->response->setJSON([
	            "status" => "error",
	            "message" => "Item Name is required"
	        ]);
	    }

	    if ($qty == "" || $qty <= 0) {
	        return $this->response->setJSON([
	            "status" => "error",
	            "message" => "Quantity must be greater than 0"
	        ]);
	    }

	    if ($price == "" || $price <= 0) {
	        return $this->response->setJSON([
	            "status" => "error",
	            "message" => "Price must be greater than 0"
	        ]);
	    }

		$total_price = $qty * $price;

		$model = new TblcMasterModel();

		$updateData = [
	        'item_name'     => $item_name,
	        'qty'           => $qty,
	        'price'         => $price,
	        'total'         => $total_price,
	        'updated_by'    => $this->session->get('user_id'),
	        'updated_date'  => date('Y-m-d H:i:s'),
	    ];

	    $model->update($id, $updateData);

	    return $this->response->setJSON([
	        "status" => "success",
	        "message" => "Item updated successfully!"
	    ]);
	}
}