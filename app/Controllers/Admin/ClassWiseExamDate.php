<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClassWiseExamDatesModel;
use App\Models\SessionYearModel;
use App\Models\ClassModel;
use App\Models\StudentModel;
use App\Models\AdmissionExamScheduleModel;

class ClassWiseExamDate extends BaseController
{
	public function index()
    {
        $data['title'] = "Exam Dates";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $sessionYearModel = new SessionYearModel();
        $data['session_year'] = $sessionYearModel->orderBy('id', 'DESC')->findAll();

        // $classWiseExamDatesModel = new ClassWiseExamDatesModel();
        // $data['exam_dates'] = $classWiseExamDatesModel->orderBy('id', 'DESC')->findAll();

        $admissionExamScheduleModel = new AdmissionExamScheduleModel();
        $data['exam_dates'] = $admissionExamScheduleModel->orderBy('id', 'DESC')->findAll();

        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        echo view('admin/class-wise-exam-date/index', $data);  

        echo view('admin/common/footer', $data);
    }

    // Fetch all data for DataTables
    public function fetch()
    {
        // $classWiseExamDatesModel = new ClassWiseExamDatesModel();
        // $exam_dates = $classWiseExamDatesModel->orderBy('id', 'DESC')->findAll();

        $admissionExamScheduleModel = new AdmissionExamScheduleModel();
        $exam_dates = $admissionExamScheduleModel
                        ->select('admission_exam_schedule.*, class.class_name')
                        ->join('class', 'class.id = admission_exam_schedule.class_id', 'left')
                        ->orderBy('admission_exam_schedule.id', 'DESC')
                        ->findAll();

        return $this->response->setJSON(['exam_dates' => $exam_dates]);
    }

    public function get_exam_date() {
        $id = $this->request->getPost('id');

        // $classWiseExamDatesModel = new ClassWiseExamDatesModel();
        // $exam_date_details = $classWiseExamDatesModel->where('id', $id)->first();

        $admissionExamScheduleModel = new AdmissionExamScheduleModel();
        $exam_date_details = $admissionExamScheduleModel->where('id', $id)->first();

        return $this->response->setJSON(['status' => 'success', 'exam_date_details' => $exam_date_details]);
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

        // $classWiseExamDatesModel = new ClassWiseExamDatesModel();
        $admissionExamScheduleModel = new AdmissionExamScheduleModel();

        $session_year_id = (int) $this->session->get('session_year_id');

        $id           = $this->request->getPost('id');
        $phase = trim($this->request->getPost('phase'));
        $class_id   = trim($this->request->getPost('class_id'));
        $exam_date     = trim($this->request->getPost('exam_date'));
        $exam_time     = trim($this->request->getPost('exam_time'));

        // Basic validation
        if ($phase === '' || $class_id === '' || $exam_date === '' || $exam_time === '') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'All fields are required.'
            ]);
        }

        $data = [
            'phase' => $phase,
            'class_id'   => $class_id,
            'exam_date'     => $exam_date,
            'exam_time'     => $exam_time,
            'session_year_id'     => $session_year_id,
        ];

        if ($id) {
            // UPDATE
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = $this->session->get('user_id');

            if ($admissionExamScheduleModel->update($id, $data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Data updated successfully.'
                ]);
            }
        } else {
            // INSERT
            $data['create_date'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->get('user_id');
            
            if ($admissionExamScheduleModel->insert($data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Data added successfully.'
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

        // $classWiseExamDatesModel = new ClassWiseExamDatesModel();
        $admissionExamScheduleModel = new AdmissionExamScheduleModel();
        $admissionExamScheduleModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }    
}