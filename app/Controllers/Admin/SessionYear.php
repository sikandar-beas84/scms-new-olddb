<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SessionYearModel;

class SessionYear extends BaseController
{
	public function index()
    {
        $data['title'] = "Session Year";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $sessionYearModel = new SessionYearModel();
        $data['session_year'] = $sessionYearModel->orderBy('id', 'DESC')->findAll();
        echo view('admin/session-year/session', $data);  

        echo view('admin/common/footer', $data);
    }

    // Fetch all data for DataTables
    public function fetch()
    {
        $sessionYearModel = new SessionYearModel();
        $session_year = $sessionYearModel->orderBy('id', 'DESC')->findAll();

        return $this->response->setJSON(['session_year' => $session_year]);
    }

    public function setCurrentSession()
    {
        $id = $this->request->getPost('id');

        $sessionYearModel = new SessionYearModel();

        // First, set all to 'f'
        $sessionYearModel->where('is_current', true)->set(['is_current' => false])->update();

        // Then, set selected one to 't'
        $sessionYearModel->update($id, ['is_current' => TRUE]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function get_session() {
        $id = $this->request->getPost('id');

        $sessionYearModel = new SessionYearModel();
        $session_year = $sessionYearModel->where('id', $id)->first();

        return $this->response->setJSON(['status' => 'success', 'session_year' => $session_year]);
    }

    // Add new area
    public function store()
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request method.'
            ]);
        }

        $sessionYearModel = new SessionYearModel();

        $id           = $this->request->getPost('id');
        $session_name = trim($this->request->getPost('session_name'));
        $start_date   = trim($this->request->getPost('start_date'));
        $end_date     = trim($this->request->getPost('end_date'));

        // Basic validation
        if ($session_name === '' || $start_date === '' || $end_date === '') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'All fields are required.'
            ]);
        }

        if ($start_date > $end_date) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Start date cannot be after end date.'
            ]);
        }

        $data = [
            'session_name' => $session_name,
            'start_date'   => $start_date,
            'end_date'     => $end_date
        ];

        if ($id) {
            // UPDATE
            if ($sessionYearModel->update($id, $data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Session updated successfully.'
                ]);
            }
        } else {
            // INSERT
            if ($sessionYearModel->insert($data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Session added successfully.'
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
            return $this->response->setJSON(['status' => 'error']);
        }

        $sessionYearModel = new SessionYearModel();
        $sessionYearModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }   

    public function change_current_session()
    {
        $sessionYearId = $this->request->getPost('session_year_id');

        if (empty($sessionYearId)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid session'
            ]);
        }

        $model = new SessionYearModel();

        $sessionYearDetails = $model->find($sessionYearId);

        if (!$sessionYearDetails) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Session not found'
            ]);
        }

        // 🔹 Update CI session
        session()->set([
            "session_year_id"     => $sessionYearId,
            "session_year_name"   => $sessionYearDetails['session_name'],
            "session_start_date"  => $sessionYearDetails['start_date'],
            "session_end_date"    => $sessionYearDetails['end_date']
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Session updated successfully'
        ]);
    } 
}