<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

use App\Models\StoppageMasterModel;
use App\Models\StoppageFareMasterModel;

class Stoppage extends BaseController
{
	public function index()
	{
		$data['title'] = "Stoppage List";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        
        // $data['stoppage_list'] =  $stoppageMasterModel->orderBy('stoppage_id', 'ASC')->findAll();
        // $data['stoppage'] = $stoppageMasterModel->get_stoppages();

        echo view('admin/stoppage/list', $data);  
        echo view('admin/common/footer', $data);

		// $data['stoppage_list'] =  $this->stoppage_model->get_all_stoppage();	
		// $data['session_year_lists'] =  $this->master_model->get_session_year_list();		
		// $data['current'] = $this->master_model->current_session_year();
		// $this->load->view('stoppage', $data);		
	}

	public function fetch()
	{
		$stoppageMasterModel = new StoppageMasterModel();
		$stoppage = $stoppageMasterModel->get_all_stoppage();

		return $this->response->setJSON(['stoppage' => $stoppage]);
	}

	public function get_stoppage()
	{
		$id = $this->request->getPost('id');

        $stoppageMasterModel = new StoppageMasterModel();
        $stoppage = $stoppageMasterModel->get_stoppage_details_by_id($id);

        return $this->response->setJSON(['status' => 'success', 'stoppage' => $stoppage]);
	}

	public function store()
	{
		if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request method.'
            ]);
        }

        $stoppageMasterModel = new StoppageMasterModel();
        $stoppageFareMasterModel = new StoppageFareMasterModel();

        $id           	= $this->request->getPost('id');
        $stoppage_name 	= trim($this->request->getPost('stoppage_name'));
        $stoppage_fare 	= trim($this->request->getPost('stoppage_fare'));
        $status 		= trim($this->request->getPost('status'));

        // Basic validation
        if ($stoppage_name === '' || $stoppage_fare === '' || $status === '') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'All fields are required.'
            ]);
        }

        $currentSessionYearId = session()->get('session_year_id');

        $data = [
            'area_id' => 17, // This means No area, Currently no data has been added against area
            'stoppage_name'	 	=> $stoppage_name,
            'stoppage_fare'   	=> $stoppage_fare,
            'session_year_id'   => 0,
            'status'     		=> $status
        ];

        $stoppageFareData = [
            'stoppage_fare'   	=> $stoppage_fare,
            'session_year_id'   => $currentSessionYearId
        ];

        if ($id) {
        	
            // UPDATE
            if ($stoppageMasterModel->update($id, $data)) {
            	$stoppageFareData['stoppage_id'] = $id;
            	// check existing record
				$existingFare = $stoppageFareMasterModel->where('stoppage_id', $id)->where('session_year_id', $currentSessionYearId)->first();
				if ($existingFare) {
				    $stoppageFareMasterModel->update($existingFare['sfm_id'], [
				        'stoppage_fare' => $stoppage_fare
				    ]);
				} else {
                    $stoppageFareMasterModel->insert([
                        'stoppage_id'     => $id,
                        'session_year_id' => $currentSessionYearId,
                        'stoppage_fare'   => $stoppage_fare
                    ]);
                }

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Stoppage updated successfully.'
                ]);
            }
        } else {
            // INSERT
            $stoppageId = $stoppageMasterModel->insert($data, true);
            if ($stoppageId) {
            	$stoppageFareMasterModel->insert([
			        'stoppage_id'     => $stoppageId,
			        'session_year_id' => $currentSessionYearId,
			        'stoppage_fare'   => $stoppage_fare
			    ]);

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Stoppage added successfully.'
                ]);
            }
        }

        // If failed
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Database operation failed.'
        ]);
	}

	// Delete area
    public function delete($id)
    {
        if( !isset($id) || $id ==""){
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid ID']);
        }

        $stoppageMasterModel = new StoppageMasterModel();
        $stoppageFareMasterModel = new StoppageFareMasterModel();

     	$stoppage = $stoppageMasterModel->find($id);
        if (!$stoppage) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Stoppage not found'
            ]);
        }

        $exists = $stoppageFareMasterModel->where('stoppage_id', $id)->countAllResults();

        if ($exists > 0) {
	        $stoppageFareMasterModel->where('stoppage_id', $id)->delete();
	        $stoppageMasterModel->delete($id);

	        return $this->response->setJSON(['status' => 'success']);
	    } else {
	    	return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Stoppage not found'
            ]);
	    }
    } 
}