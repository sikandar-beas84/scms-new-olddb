<?php
namespace App\Controllers\Admin;
use DateTime;
use DatePeriod;
use DateInterval;

use App\Controllers\BaseController;

use App\Models\SectionModel;
use App\Models\ClassModel;
use App\Models\AdminUserModel;


class Section extends BaseController
{
	public function index()
    {
        $data['title'] = "Section";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $sectionModel = new SectionModel();
        $classModel = new ClassModel();
        $adminUserModel = new AdminUserModel();

        // $data['sections'] = $sectionModel->section_lists();
        $data['class_lists'] = $classModel->orderBy('id', 'DESC')->findAll();
        $data['teacher_lists'] = $adminUserModel->where('dept_id', 2)->orderBy('first_name', 'ASC')->findAll();

        echo view('admin/section/index', $data);  

        echo view('admin/common/footer', $data);
    }

    // Fetch all data for DataTables
    public function fetch()
    {
        $sectionModel = new SectionModel();
        $sections = $sectionModel->section_lists();

        return $this->response->setJSON(['sections' => $sections]);
    }

    public function get_section() {
        $id = $this->request->getPost('id');

        $sectionModel = new SectionModel();
        $sections = $sectionModel->where('id', $id)->first();

        return $this->response->setJSON(['status' => 'success', 'sections' => $sections]);
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

        $sectionModel = new SectionModel();

        $id = $this->request->getPost('id');
        $class_id = trim($this->request->getPost('class_id'));
        $section_name = trim($this->request->getPost('section_name'));
        $no_of_student = trim($this->request->getPost('no_of_student'));
        $teacher_id = trim($this->request->getPost('teacher_id'));

        // Basic validation
        if ($class_id === '' || $section_name === '' || $no_of_student === '' || $teacher_id === '') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'All fields are required.'
            ]);
        }

        $data = [
            'class_id' => $class_id,
            'section_name'   => $section_name,
            'no_of_student'     => $no_of_student,
            'teacher_id'     => $teacher_id,
            'session_year_id' => $this->session->get('session_year_id')
        ];
        
        if ($id) {
            // UPDATE
            if ($sectionModel->update($id, $data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Section updated successfully.'
                ]);
            }
        } else {
            // INSERT
            if ($sectionModel->insert($data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Section added successfully.'
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

        $sectionModel = new SectionModel();
     	$section = $sectionModel->find($id);
        if (!$section) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Section not found'
            ]);
        }

        $sectionModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }  
}