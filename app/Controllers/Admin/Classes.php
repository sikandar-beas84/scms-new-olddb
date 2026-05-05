<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\SubjectMasterModel;
use App\Models\SubjectToClassModel;

class Classes extends BaseController
{
	public function index()
    {
        $data['title'] = "Classes";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $data['class'] = $classModel->orderBy('id', 'DESC')->findAll();

        echo view('admin/manage-class/class-list', $data);        
        echo view('admin/common/footer', $data);
    }

    public function fetch_classes()
    {
        $classModel = new ClassModel();
        $class = $classModel->orderBy('id', 'DESC')->findAll();

        return $this->response->setJSON(['class' => $class]);
    }

    public function get_class()
    {
        $id = $this->request->getPost('id');

        $classModel = new ClassModel();
        $class = $classModel->where('id', $id)->first();

        return $this->response->setJSON(['status' => 'success', 'class' => $class]);
    }

    public function update_class()
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request method.'
            ]);
        }

        $classModel = new ClassModel();

        $id           = $this->request->getPost('id');
        $class_name = trim($this->request->getPost('class_name'));
        $id_range   = trim($this->request->getPost('id_range'));
        $age     = trim($this->request->getPost('age'));

        // Basic validation
        if ($class_name === '' || $id_range === '' || $age === '') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'All fields are required.'
            ]);
        }

        $data = [
            'class_name' => $class_name,
            'id_range'   => $id_range,
            'age'     => $age
        ];

        if ($id) {
            // UPDATE
            if ($classModel->update($id, $data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Class updated successfully.'
                ]);
            }
        }

        // If failed
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Database operation failed.'
        ]);
    }

    public function assign_sub_to_class()
    {
        $data['title'] = "Assign Subject to Classes";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $subjectMasterModel = new SubjectMasterModel();
        $data['class'] = $classModel->orderBy('id', 'DESC')->findAll();
        $data['subject'] = $subjectMasterModel->orderBy('id', 'DESC')->findAll();

        echo view('admin/manage-class/assign-sub-to-class', $data);        
        echo view('admin/common/footer', $data);
    }

    public function save_assign_sub_to_class() {
        $validationRules = [
            'class_id' => 'required',
            'subject_id' => 'required',
            'sub' => 'required',
        ];
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $SubjectToClassModel = new SubjectToClassModel();
        $class_id = $this->request->getPost('class_id');
        $subject_ids = $this->request->getPost('subject_id');
        $subs = $this->request->getPost('sub');
        $drop_sub = json_encode($subs);
        // return $this->response->setJSON([
        //     'status' => 'error',
        //     'message' => 'Invalid request method.',
        //     'data' => $subject_ids
        // ]);
        foreach($subject_ids as $subject){
            $data = [];
            $data = array(
                'class_id'=>$class_id,
                'subject_id'=>$subject,
                'sub_order'=>$drop_sub
            );
            $insert_id = $SubjectToClassModel->insert($data);
        }
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Assign subject to class successfully.',
            'data' => $subject_ids
        ]);
        return redirect()->back()->with('success', 'Assign subject to class successfully.');
    }
}