<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

use App\Models\ParentEventsModel;


class ParentEvent extends BaseController
{
	public function index()
	{
		$data['title'] = "Events";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $parentEventsModel = new ParentEventsModel();
        $data['events'] = $parentEventsModel->findAll();

        echo view('admin/event/index', $data);  

        echo view('admin/common/footer', $data);
	}

	public function save_events()
	{
		if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request method.'
            ]);
        }

        $parentEventsModel = new ParentEventsModel();

        $id           		= $this->request->getPost('id');
        $event_no 			= trim($this->request->getPost('event_no')) ?? '';
        $event_name   		= trim($this->request->getPost('event_name')) ?? '';
        $event_description 	= trim($this->request->getPost('event_description')) ?? '';
        $event_date			= trim($this->request->getPost('event_date')) ?? '';
        $event_fee     		= trim($this->request->getPost('event_fee')) ?? '';
        $status     		= (int) $this->request->getPost('status');

        // Basic validation
        if ($event_no === '' || $event_name === '' || $event_description === '' || $event_date === '' || $event_fee === '' || $status === '') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'All fields are required.'
            ]);
        }

        $data = [
            'event_no' => $event_no,
            'event_name'   => $event_name,
            'event_description'     => $event_description,
            'event_date'     => $event_date,
            'event_fee'     => $event_fee,
            'status'     => $status,
        ];

        if ($id) {
            // UPDATE
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = $this->session->get('user_id');

            if ($parentEventsModel->update($id, $data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Event updated successfully.'
                ]);
            }
        } else {
            // INSERT
            $data['add_by'] = $this->session->get('user_id');

            if ($parentEventsModel->insert($data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Event added successfully.'
                ]);
            }
        }

        // If failed
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Database operation failed.'
        ]);
	}

	public function fetch_events()
	{
		$parentEventsModel = new ParentEventsModel();
        $events = $parentEventsModel->orderBy('id', 'DESC')->findAll();

        return $this->response->setJSON(['events' => $events]);
	}

	public function status_update()
	{
		$id = $this->request->getPost('id');
		$value = $this->request->getPost('isChecked');
		$getStatus = ($value === true || $value === 'true' || $value == 1) ? 1 : 0;

        $parentEventsModel = new ParentEventsModel();
        $updated = $parentEventsModel->update($id, ['status' => $getStatus]);

        if ($updated) {
		    return $this->response->setJSON([
		        'status' => 'success',
		        'message' => 'Status updated successfully.'
		    ]);
		} else {
		    return $this->response->setJSON([
		        'status' => 'error',
		        'message' => 'Failed to update status.'
		    ]);
		}
	}

	public function get_event()
	{
		$id = $this->request->getPost('id');

        $parentEventsModel = new ParentEventsModel();
        $events = $parentEventsModel->where('id', $id)->first();

        return $this->response->setJSON(['status' => 'success', 'event_details' => $events]);
	}

	public function delete_event($id)
	{
		if( !isset($id) || $id ==""){
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid ID']);
        }

        $parentEventsModel = new ParentEventsModel();
     	$events = $parentEventsModel->find($id);
        if (!$events) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Event not found'
            ]);
        }

        $parentEventsModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
	}
}