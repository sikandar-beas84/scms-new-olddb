<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\FeesStructureMasterModel;
use App\Models\SessionYearModel;

class Feestructure extends BaseController
{
	public function index(){
		$data['title'] = "Fees Structure List";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

		$classModel = new ClassModel();
		$feesStructureMasterModel = new FeesStructureMasterModel();
		$sessionYearModel = new SessionYearModel();

		$data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();
		$data['all_fees'] = $feesStructureMasterModel->get_all_fees();
		$data['session_year_lists'] = $sessionYearModel->orderBy('id', 'ASC')->findAll();
		$data['current'] = $sessionYearModel->getCurrentSessionId();	

		// echo "<pre>"; print_r($data); die();
		echo view('admin/fee-structure/list', $data);  

        echo view('admin/common/footer', $data);
	}

	function add_fee()
	{
	    $rules = [
	        'session_year_id' => [
	            'label'  => 'Session Year',
	            'rules'  => 'required|integer',
	            'errors' => [
	                'required' => 'Session year is required',
	                'integer'  => 'Session year must be a valid number'
	            ]
	        ],
	        'class_id' => [
	            'label'  => 'Class',
	            'rules'  => 'required|integer',
	            'errors' => [
	                'required' => 'Please select class',
	                'integer'  => 'Class ID must be numeric'
	            ]
	        ],

	        // Fees validation – all must be integer and >= 0
	        'admission_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	                'required' => 'Admission fee is required',
	                'is_natural' => 'Admission fee must be 0 or greater'
	            ]
	        ],
	        'development_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Development fee is required',
	                'is_natural' => 'Development fee must be 0 or greater'
	            ]
	        ],
	        'exam_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Exam fee is required',
	                'is_natural' => 'Exam fee must be 0 or greater'
	            ]
	        ],
	        'festival_celebration_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Festival Celebration fee is required',
	                'is_natural' => 'Festival Celebration fee must be 0 or greater'
	            ]
	        ],
	        'games_sports_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Games & sports fee is required',
	                'is_natural' => 'Games & sports fee must be 0 or greater'
	            ]
	        ],
	        'audio_visual_lab_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Audio Visual Lab fee is required',
	                'is_natural' => 'Audio Visual Lab fee must be 0 or greater'
	            ]
	        ],
	        'library_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Library fee is required',
	                'is_natural' => 'Library fee must be 0 or greater'
	            ]
	        ],
	        'electricity_maintenance_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Electricity maintenance fee is required',
	                'is_natural' => 'Electricity maintenance fee must be 0 or greater'
	            ]
	        ],
	        'computer_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Computer fee is required',
	                'is_natural' => 'Computer fee must be 0 or greater'
	            ]
	        ],
	        'security_deposite' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Security deposit is required',
	                'is_natural' => 'Security deposit must be 0 or greater'
	            ]
	        ],
	        'tuition_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Tuition fee is required',
	                'is_natural' => 'Tuition fee must be 0 or greater'
	            ]
	        ],
	    ];

	    if (! $this->validation->setRules($rules)->withRequest($this->request)->run()) {
	    	return redirect()->back()
	            ->with('error_msg', $this->validation->listErrors())
	            ->withInput();
	    }

	    $post = $this->request->getPost();

	    $development_fee             = (int) ($post['development_fee'] ?? 0);
	    $exam_fee                    = (int) ($post['exam_fee'] ?? 0);
	    $festival_celebration_fee    = (int) ($post['festival_celebration_fee'] ?? 0);
	    $games_sports_fee            = (int) ($post['games_sports_fee'] ?? 0);
	    $audio_visual_lab_fee        = (int) ($post['audio_visual_lab_fee'] ?? 0);
	    $library_fee                 = (int) ($post['library_fee'] ?? 0);
	    $electricity_maintenance_fee = (int) ($post['electricity_maintenance_fee'] ?? 0);
	    $computer_fee                = (int) ($post['computer_fee'] ?? 0);

	    // Calculate Session Charges
	    $session_charges = 
	        $development_fee +
	        $exam_fee +
	        $festival_celebration_fee +
	        $games_sports_fee +
	        $audio_visual_lab_fee +
	        $library_fee +
	        $electricity_maintenance_fee;

	    // Prepare Data Array for Insert
	    $data = [
	        'session_year_id'            => $post['session_year_id'],
	        'class_id'                   => $post['class_id'],
	        'admission_fee'              => $post['admission_fee'],
	        'tuition_fee'                => $post['tuition_fee'],
	        'security_deposite'          => $post['security_deposite'],
	        'development_fee'            => $development_fee,
	        'exam_fee'                   => $exam_fee,
	        'festival_celebration_fee'   => $festival_celebration_fee,
	        'games_sports_fee'           => $games_sports_fee,
	        'audio_visual_lab_fee'       => $audio_visual_lab_fee,
	        'library_fee'                => $library_fee,
	        'electricity_maintenance_fee'=> $electricity_maintenance_fee,
	        'computer_fee'               => $computer_fee,
	        'session_charges'            => $session_charges,
	        'status'                     => $post['status'] ?? 1,
	    ];

	    $feesStructureMasterModel = new FeesStructureMasterModel();
	    $insertID = $feesStructureMasterModel->insert($data);

		if ($insertID) {
	        return redirect()->to(base_url('admin/feestructure'))
	            ->with('success_msg', 'Fee Added Successfully!');
	    }

	    return redirect()->back()->with('error_msg', 'Something went wrong.');
	}

	function edit_fee($id='')
	{
		$data['title'] = "Edit Fees Structure";
		$data['fee_id'] = $id;

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

		$classModel = new ClassModel();
		$feesStructureMasterModel = new FeesStructureMasterModel();
		$sessionYearModel = new SessionYearModel();

		$data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();
		$data['fees_details'] = $feesStructureMasterModel->find($id);
		$data['session_year_lists'] = $sessionYearModel->orderBy('id', 'ASC')->findAll();
		$data['current'] = $sessionYearModel->getCurrentSessionId();	

		// echo "<pre>"; print_r($data); die();
		echo view('admin/fee-structure/edit', $data);  

        echo view('admin/common/footer', $data);
	}

	function update_fee($id='')
	{
		$rules = [
	        'session_year_id' => [
	            'label'  => 'Session Year',
	            'rules'  => 'required|integer',
	            'errors' => [
	                'required' => 'Session year is required',
	                'integer'  => 'Session year must be a valid number'
	            ]
	        ],
	        'class_id' => [
	            'label'  => 'Class',
	            'rules'  => 'required|integer',
	            'errors' => [
	                'required' => 'Please select class',
	                'integer'  => 'Class ID must be numeric'
	            ]
	        ],

	        // Fees validation – all must be integer and >= 0
	        'admission_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	                'required' => 'Admission fee is required',
	                'is_natural' => 'Admission fee must be 0 or greater'
	            ]
	        ],
	        'development_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Development fee is required',
	                'is_natural' => 'Development fee must be 0 or greater'
	            ]
	        ],
	        'exam_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Exam fee is required',
	                'is_natural' => 'Exam fee must be 0 or greater'
	            ]
	        ],
	        'festival_celebration_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Festival Celebration fee is required',
	                'is_natural' => 'Festival Celebration fee must be 0 or greater'
	            ]
	        ],
	        'games_sports_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Games & sports fee is required',
	                'is_natural' => 'Games & sports fee must be 0 or greater'
	            ]
	        ],
	        'audio_visual_lab_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Audio Visual Lab fee is required',
	                'is_natural' => 'Audio Visual Lab fee must be 0 or greater'
	            ]
	        ],
	        'library_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Library fee is required',
	                'is_natural' => 'Library fee must be 0 or greater'
	            ]
	        ],
	        'electricity_maintenance_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Electricity maintenance fee is required',
	                'is_natural' => 'Electricity maintenance fee must be 0 or greater'
	            ]
	        ],
	        'computer_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Computer fee is required',
	                'is_natural' => 'Computer fee must be 0 or greater'
	            ]
	        ],
	        'security_deposite' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Security deposit is required',
	                'is_natural' => 'Security deposit must be 0 or greater'
	            ]
	        ],
	        'tuition_fee' => [
	            'rules' => 'required|is_natural',
	            'errors' => [
	            	'required' => 'Tuition fee is required',
	                'is_natural' => 'Tuition fee must be 0 or greater'
	            ]
	        ],
	    ];

	    if (! $this->validation->setRules($rules)->withRequest($this->request)->run()) {
	    	return redirect()->back()
	            ->with('error_msg', $this->validation->listErrors())
	            ->withInput();
	    }

	    $post = $this->request->getPost();

	    $development_fee             = (int) ($post['development_fee'] ?? 0);
	    $exam_fee                    = (int) ($post['exam_fee'] ?? 0);
	    $festival_celebration_fee    = (int) ($post['festival_celebration_fee'] ?? 0);
	    $games_sports_fee            = (int) ($post['games_sports_fee'] ?? 0);
	    $audio_visual_lab_fee        = (int) ($post['audio_visual_lab_fee'] ?? 0);
	    $library_fee                 = (int) ($post['library_fee'] ?? 0);
	    $electricity_maintenance_fee = (int) ($post['electricity_maintenance_fee'] ?? 0);
	    $computer_fee                = (int) ($post['computer_fee'] ?? 0);

	    // Calculate Session Charges
	    $session_charges = 
	        $development_fee +
	        $exam_fee +
	        $festival_celebration_fee +
	        $games_sports_fee +
	        $audio_visual_lab_fee +
	        $library_fee +
	        $electricity_maintenance_fee;

	    // Prepare Data Array for Insert
	    $data = [
	        'session_year_id'            => $post['session_year_id'],
	        'class_id'                   => $post['class_id'],
	        'admission_fee'              => $post['admission_fee'],
	        'tuition_fee'                => $post['tuition_fee'],
	        'security_deposite'          => $post['security_deposite'],
	        'development_fee'            => $development_fee,
	        'exam_fee'                   => $exam_fee,
	        'festival_celebration_fee'   => $festival_celebration_fee,
	        'games_sports_fee'           => $games_sports_fee,
	        'audio_visual_lab_fee'       => $audio_visual_lab_fee,
	        'library_fee'                => $library_fee,
	        'electricity_maintenance_fee'=> $electricity_maintenance_fee,
	        'computer_fee'               => $computer_fee,
	        'session_charges'            => $session_charges,
	        'status'                     => $post['status'] ?? 1,
	    ];

	    $feesStructureMasterModel = new FeesStructureMasterModel();
	    $result = $feesStructureMasterModel->update($id, $data);

	    return redirect()
        ->to(base_url('admin/feestructure'))
        ->with('success_msg', 'Fee Updated Successfully!');
	}

	public function delete_fee($id)
	{
	    $model = new FeesStructureMasterModel();

	    $row = $model->find($id);

	    if (!$row) {
	        return $this->response->setJSON([
	            'status' => false,
	            'message' => 'Record not found'
	        ]);
	    }

	    if ($model->delete($id)) {
	        return $this->response->setJSON([
	            'status' => true,
	            'message' => 'Deleted successfully'
	        ]);
	    } else {
	        return $this->response->setJSON([
	            'status' => false,
	            'message' => 'Delete failed'
	        ]);
	    }
	}

}