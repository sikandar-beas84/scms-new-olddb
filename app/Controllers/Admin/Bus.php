<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\StudentModel;
use App\Models\StudentDetailsModel;
use App\Models\ConfigurationModel;
use App\Models\RegistrationFeesModel;
use App\Models\StoppageMasterModel;
use App\Models\BusMasterModel;
use App\Models\BusToStoppageModel;
use App\Models\ItemMasterModel;
use App\Models\SectionModel;
use App\Models\SessionYearModel;
use App\Models\StudentTransportFinancialModel;
use App\Models\AdminUserModel;

class Bus extends BaseController
{
	public function index(){
		$data['title'] = "Bus List";

		echo view('admin/common/header', $data);
		echo view('admin/common/topbar', $data);
		echo view('admin/common/sidebar', $data);

		$busMasterModel = new BusMasterModel();
		$stoppageMasterModel = new StoppageMasterModel();
		$adminUserModel = new AdminUserModel();

		$data['vendor_list'] = $adminUserModel->where('dept_id', 7)->findAll();
		$data['bus_list'] = $busMasterModel->get_all_bus_list();
		// $data['stoppage_list'] =  $stoppageMasterModel->get_all_stoppage_list();


		echo view('admin/bus/list', $data);  
		echo view('admin/common/footer', $data);
	}

	public function add()
	{
		$data['title'] = "Add Bus";

		echo view('admin/common/header', $data);
		echo view('admin/common/topbar', $data);
		echo view('admin/common/sidebar', $data);

		$busMasterModel = new BusMasterModel();
		$busToStoppageModel = new BusToStoppageModel();
		$stoppageMasterModel = new StoppageMasterModel();
		$adminUserModel = new AdminUserModel();

		$data['vendor_list'] = $adminUserModel->where('dept_id', 7)->findAll();
		$data['stoppage_list'] =  $stoppageMasterModel->select('stoppage_id, stoppage_name, stoppage_fare')->where('status', 1)->orderBy('stoppage_name', 'ASC')->findAll();
		
		echo view('admin/bus/add', $data);  
		echo view('admin/common/footer', $data);
	}

	public function save()
	{
		// pr($this->request->getPost());
		$validationRules = [
		    'vendor_id' => [
		        'label' => 'Vendor',
		        'rules' => 'required|integer',
		    ],

		    'stoppage_id' => [
		        'label' => 'Stoppage',
		        'rules' => 'required',
		    ],

		    'bus_licence_no' => [
		        'label' => 'Bus Licence Number',
		        'rules' => 'required|min_length[5]|max_length[20]',
		    ],

		    'bus_seating_capacity' => [
		        'label' => 'Bus Seating Capacity',
		        'rules' => 'required|integer|greater_than[0]',
		    ],

		    'bus_driver_name' => [
		        'label' => 'Bus Driver Name',
		        'rules' => 'required',
		    ],
		];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $stoppageIds = $this->request->getPost('stoppage_id');
        $vendor_id = $this->request->getPost('vendor_id');
        $bus_serial_no = $this->request->getPost('bus_serial_no');
        $bus_licence_no = $this->request->getPost('bus_licence_no');
        $bus_seating_capacity = $this->request->getPost('bus_seating_capacity');
        $bus_driver_name = $this->request->getPost('bus_driver_name');
        $bus_driver_phone = $this->request->getPost('bus_driver_phone');
        $bus_attendent_name = $this->request->getPost('bus_attendent_name');
        $bus_attendent_phone = $this->request->getPost('bus_attendent_phone');
        $bus_driver_driving_license_no = $this->request->getPost('bus_driver_driving_license_no');

        $bus_driver_licence_expiery_date = $this->request->getPost('bus_driver_licence_expiery_date');
        $bus_attendent_driving_license_no = $this->request->getPost('bus_attendent_driving_license_no');
        $bus_attendent_licence_expiery_date = $this->request->getPost('bus_attendent_licence_expiery_date');
        $status = $this->request->getPost('status');

        $data = array(
			'vendor_id'								=> $vendor_id,
			'area_id'								=> 0,
			'stoppage_id'							=> 0,
			'bus_serial_no'							=> $bus_serial_no,
			'bus_licence_no'						=> $bus_licence_no,
			'bus_seating_capacity'					=> $bus_seating_capacity,
			'bus_driver_name'						=> $bus_driver_name,
			'bus_driver_phone'						=> $bus_driver_phone,
			'bus_attendent_name'					=> $bus_attendent_name,
			'bus_attendent_phone'					=> $bus_attendent_phone,
			'bus_driver_driving_license_no'			=> $bus_driver_driving_license_no,
			'bus_driver_licence_expiery_date'		=> !empty($bus_driver_licence_expiery_date) ? date('Y-m-d', strtotime($bus_driver_licence_expiery_date)): '',
			'bus_attendent_driving_license_no'		=> $bus_attendent_driving_license_no,
			'bus_attendent_licence_expiery_date'	=> !empty($bus_attendent_licence_expiery_date) ? date('Y-m-d', strtotime($bus_attendent_licence_expiery_date)) : '',
			'status'								=> $status
		);

        $imageName = null;
        $file = $this->request->getFile('bus_driver_image');
     	if ($file && $file->isValid() && ! $file->hasMoved()) {
     		$imageName = time() . '_' . $file->getRandomName();
     		$basePath = FCPATH . 'uploads/busdrivers';
            $targetPath = $basePath;

     		$file->move($targetPath, $imageName);
     	}

     	// Only save image if uploaded
	    if ($imageName !== null) {
	        $data['bus_driver_image'] = $imageName;
	    }

	    $attendentImageName = null;
        $attendentFile = $this->request->getFile('bus_attendent_image');
     	if ($attendentFile && $attendentFile->isValid() && ! $attendentFile->hasMoved()) {
     		$attendentImageName = time() . '_' . $attendentFile->getRandomName();
     		$basePath = FCPATH . 'uploads/busdrivers';
            $targetPath = $basePath;

     		$attendentFile->move($targetPath, $attendentImageName);
     	}

     	// Only save image if uploaded
	    if ($attendentImageName !== null) {
	        $data['bus_attendent_image'] = $attendentImageName;
	    }

	    $busMasterModel = new BusMasterModel();
	    $busToStoppageModel = new BusToStoppageModel();
	    $bus_id = $busMasterModel->insert($data, true);

	    if($bus_id){
			foreach($stoppageIds as $stoppage){
				$stData = array('bus_id' =>$bus_id, 'area_id' => 0, 'stoppage_id'=>$stoppage);
				$insertId = $busToStoppageModel->insert($stData);
			}
			
			return redirect()->to(base_url('admin/bus'))->with('success_msg', 'New bus has been added successfully.');
		}

		return redirect()->to(base_url('admin/bus'))->with('error_msg', 'Unable to add the bus. Please check the details and try again.');
	}

	public function edit($bus_id)
	{
		$data['title'] = "Edit Bus";

		echo view('admin/common/header', $data);
		echo view('admin/common/topbar', $data);
		echo view('admin/common/sidebar', $data);

		$busMasterModel = new BusMasterModel();
		$busToStoppageModel = new BusToStoppageModel();
		$stoppageMasterModel = new StoppageMasterModel();
		$adminUserModel = new AdminUserModel();

		$data['vendor_list'] = $adminUserModel->where('dept_id', 7)->findAll();
		$data['stoppage_list'] =  $stoppageMasterModel->select('stoppage_id, stoppage_name, stoppage_fare')->where('status', 1)->orderBy('stoppage_name', 'ASC')->findAll();

		$pre_stoppage = $busToStoppageModel->get_bus_stoppage($bus_id);
		foreach($pre_stoppage as $prest){
			$olds[] = $prest['stoppage_id'];
		}
		
		$data['old_stoppage'] 	= $olds;
		$data['bus_id'] = $bus_id;
		$data['bus'] =  $busMasterModel->where('bus_id', $bus_id)->first();
		// pr($data);
		echo view('admin/bus/edit', $data);  
		echo view('admin/common/footer', $data);
	}

	public function update($bus_id)
	{
		$validationRules = [
		    'vendor_id' => [
		        'label' => 'Vendor',
		        'rules' => 'required|integer',
		    ],

		    'stoppage_id' => [
		        'label' => 'Stoppage',
		        'rules' => 'required',
		    ],

		    'bus_licence_no' => [
		        'label' => 'Bus Licence Number',
		        'rules' => 'required|min_length[5]|max_length[20]',
		    ],

		    'bus_seating_capacity' => [
		        'label' => 'Bus Seating Capacity',
		        'rules' => 'required|integer|greater_than[0]',
		    ],

		    'bus_driver_name' => [
		        'label' => 'Bus Driver Name',
		        'rules' => 'required',
		    ],
		];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $stoppageIds = $this->request->getPost('stoppage_id');
        $vendor_id = $this->request->getPost('vendor_id');
        $bus_serial_no = $this->request->getPost('bus_serial_no');
        $bus_licence_no = $this->request->getPost('bus_licence_no');
        $bus_seating_capacity = $this->request->getPost('bus_seating_capacity');
        $bus_driver_name = $this->request->getPost('bus_driver_name');
        $bus_driver_phone = $this->request->getPost('bus_driver_phone');
        $bus_attendent_name = $this->request->getPost('bus_attendent_name');
        $bus_attendent_phone = $this->request->getPost('bus_attendent_phone');
        $bus_driver_driving_license_no = $this->request->getPost('bus_driver_driving_license_no');

        $bus_driver_licence_expiery_date = $this->request->getPost('bus_driver_licence_expiery_date');
        $bus_attendent_driving_license_no = $this->request->getPost('bus_attendent_driving_license_no');
        $bus_attendent_licence_expiery_date = $this->request->getPost('bus_attendent_licence_expiery_date');
        $status = $this->request->getPost('status');

        $data = array(
			'vendor_id'								=> $vendor_id,
			'area_id'								=> 0,
			'stoppage_id'							=> 0,
			'bus_serial_no'							=> $bus_serial_no,
			'bus_licence_no'						=> $bus_licence_no,
			'bus_seating_capacity'					=> $bus_seating_capacity,
			'bus_driver_name'						=> $bus_driver_name,
			'bus_driver_phone'						=> $bus_driver_phone,
			'bus_attendent_name'					=> $bus_attendent_name,
			'bus_attendent_phone'					=> $bus_attendent_phone,
			'bus_driver_driving_license_no'			=> $bus_driver_driving_license_no,
			'bus_driver_licence_expiery_date'		=> !empty($bus_driver_licence_expiery_date) ? date('Y-m-d', strtotime($bus_driver_licence_expiery_date)): '',
			'bus_attendent_driving_license_no'		=> $bus_attendent_driving_license_no,
			'bus_attendent_licence_expiery_date'	=> !empty($bus_attendent_licence_expiery_date) ? date('Y-m-d', strtotime($bus_attendent_licence_expiery_date)) : '',	
			'status'								=> $status
		);

        $imageName = null;
        $file = $this->request->getFile('bus_driver_image');
     	if ($file && $file->isValid() && ! $file->hasMoved()) {
     		$imageName = time() . '_' . $file->getRandomName();
     		$basePath = FCPATH . 'uploads/busdrivers';
            $targetPath = $basePath;

     		$file->move($targetPath, $imageName);
     	}

     	// Only save image if uploaded
	    if ($imageName !== null) {
	        $data['bus_driver_image'] = $imageName;
	    }

	    $attendentImageName = null;
        $attendentFile = $this->request->getFile('bus_attendent_image');
     	if ($attendentFile && $attendentFile->isValid() && ! $attendentFile->hasMoved()) {
     		$attendentImageName = time() . '_' . $attendentFile->getRandomName();
     		$basePath = FCPATH . 'uploads/busdrivers';
            $targetPath = $basePath;

     		$attendentFile->move($targetPath, $attendentImageName);
     	}

     	// Only save image if uploaded
	    if ($attendentImageName !== null) {
	        $data['bus_attendent_image'] = $attendentImageName;
	    }

	    $busMasterModel = new BusMasterModel();
	    $busToStoppageModel = new BusToStoppageModel();
	    $result = $busMasterModel->update_bus($bus_id, $data);
	    if($result){
			$busToStoppageModel->del_bus_stoppage($bus_id);
			foreach($stoppageIds as $stoppage){
				$stData = array('bus_id' =>$bus_id, 'area_id' => 0, 'stoppage_id'=>$stoppage);
				$insertId = $busToStoppageModel->insert($stData);
			}
			
			return redirect()->to(base_url('admin/bus'))->with('success_msg', 'Bus Details Updated Successfully!');
		}

		return redirect()->to(base_url('admin/bus'))->with('error_msg', 'Failed to update bus details. Please try again.');
	}

	// Delete area
    public function delete($id)
    {
        if( !isset($id) || $id ==""){
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid ID']);
        }

        $busMasterModel = new BusMasterModel();
	    $busToStoppageModel = new BusToStoppageModel();

     	$bus = $busMasterModel->find($id);
        if (!$bus) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Bus not found'
            ]);
        }

        $exists = $busToStoppageModel->where('bus_id', $id)->countAllResults();

        if ($exists > 0) {
	        $busToStoppageModel->where('bus_id', $id)->delete();
	        $busMasterModel->delete($id);

	        return $this->response->setJSON(['status' => 'success']);
	    } else {
	    	return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Bus not found'
            ]);
	    }
    } 

	public function ajax_get_bus() {
        $stoppage_id = $this->request->getPost('stoppage');
        $buses = array();

        $busToStoppageModel = new BusToStoppageModel();
        $buses = $busToStoppageModel->get_bus($stoppage_id);		
		$data =[];
		$data[0] = '--Select--';
		foreach($buses as $bus){
			$data[$bus['bus_id']] = $bus['bus_licence_no'] . ' (' . $bus['bus_serial_no'] . ')';
		}		
        echo json_encode($data);
	}

	public function students_bus_csv()
	{
		$data['title'] = "Students Bus CSV";

		echo view('admin/common/header', $data);
		echo view('admin/common/topbar', $data);
		echo view('admin/common/sidebar', $data);

		echo view('admin/bus/students-bus-csv', $data);  
		echo view('admin/common/footer', $data);
	}

	public function studentsBusCsvSave()
	{
	    $session = session();
	    $file = $this->request->getFile('studentbusfile');

	    if (!$file || !$file->isValid()) {
	        $session->setFlashdata('error_msg', 'Invalid file upload.');
	        return redirect()->to(base_url('admin/bus/students-bus-csv'));
	    }

	    // Validate CSV mime
	    $allowedMime = [
	        'text/csv',
	        'text/plain',
	        'application/vnd.ms-excel',
	        'application/csv',
	        'text/x-csv'
	    ];

	    if (!in_array($file->getMimeType(), $allowedMime)) {
	        $session->setFlashdata('error_msg', 'Invalid file type. Only CSV allowed.');
	        return redirect()->to(base_url('admin/bus/students-bus-csv'));
	    }

	    $csvFile = fopen($file->getTempName(), 'r');

	    // Skip header
	    fgetcsv($csvFile);

	    $session_year_id = $session->get('session_year_id');

		$successCount = 0;
		$errorRows = [];
		$rowNumber = 0;

		while (($line = fgetcsv($csvFile)) !== false) {

		    $rowNumber++;

		    if (!empty($line[0]) && !empty($line[1])) {

		        $studentCode = trim($line[0]);
		        $busSerial   = trim($line[1]);

		        $busMasterModel = new BusMasterModel();
		        $bus = $busMasterModel->getBusBySerial($busSerial);
		        $bus_id = $bus['bus_id'] ?? '';

		        if ($bus) {
		            $student_id = student_id_by_code($studentCode);

		            if (!$student_id) {
		                $errorRows[] = "Row {$rowNumber}: Student Not Found ({$studentCode})";
		                continue;
		            }

		            $studentTransportFinancialModel = new StudentTransportFinancialModel();

		            $updata = [
		                'student_code'     => $studentCode,
		                'bus_id'           => $bus_id,
		                'bus_alloted_date' => date('Y-m-d')
		            ];

		            $updated = $studentTransportFinancialModel
		                            ->where('student_id', $student_id)
		                            ->set($updata)
		                            ->update();

		            if ($updated !== false) {
		                $successCount++;
		            } else {
		                $errorRows[] = "Row {$rowNumber}: Update Failed (Bus: {$busSerial}, Student: {$studentCode})";
		            }

		        } else {
		            $errorRows[] = "Row {$rowNumber}: Invalid Bus Serial ({$busSerial})  (Student: {$studentCode})";
		        }

		    } else {

		        // ✅ THIS IS YOUR REQUIRED ELSE PART
		        $studentCode = $line[0] ?? 'EMPTY';
		        $busSerial   = $line[1] ?? 'EMPTY';

		        $errorRows[] = "Row {$rowNumber}: Missing Data (Student: {$studentCode}, Bus: {$busSerial})";
		    }
		}

	    fclose($csvFile);

	    if (!empty($errorRows)) {
		    $session->setFlashdata('error_msg', implode('<br>', $errorRows));
		}

		if ($successCount > 0) {
		    $session->setFlashdata('success_msg', "{$successCount} students updated successfully.");
		}

	    return redirect()->to(base_url('admin/bus/students-bus-csv'));
	}

	public function studentsBusCsvSaveAjax()
	{
	    $session = session();
	    $file = $this->request->getFile('studentbusfile');

	    if (!$file || !$file->isValid()) {
	        return $this->response->setJSON([
	            'status' => 'error',
	            'message' => 'Invalid file upload.'
	        ]);
	    }

	    $allowedMime = [
	        'text/csv',
	        'text/plain',
	        'application/vnd.ms-excel',
	        'application/csv',
	        'text/x-csv'
	    ];

	    if (!in_array($file->getMimeType(), $allowedMime)) {
	        return $this->response->setJSON([
	            'status' => 'error',
	            'message' => 'Invalid file type. Only CSV allowed.'
	        ]);
	    }

	    $csvFile = fopen($file->getTempName(), 'r');

	    // fgetcsv($csvFile); // skip header

	    $session_year_id = $session->get('session_year_id');

	    $successCount = 0;
	    $errorRows = [];
	    $rowNumber = 0;

	    $busMasterModel = new BusMasterModel();
	    $studentTransportFinancialModel = new StudentTransportFinancialModel();

	    while (($line = fgetcsv($csvFile)) !== false) {

	        $rowNumber++;

	        if (!empty($line[0]) && !empty($line[1])) {

	            $studentCode = trim($line[0]);
	            $busSerial   = trim($line[1]);

	            $bus = $busMasterModel->getBusBySerial($busSerial);
	            $bus_id = $bus['bus_id'] ?? '';

	            if ($bus_id != '' && $studentCode != '') {

	                $student_id = student_id_by_code($studentCode);
	                
	                if ($student_id == '') {
	                    $errorRows[] = "Row {$rowNumber}: Student Not Found ({$studentCode})";
	                    continue;
	                }

	                $updateData = [
	                    'student_code'     => $studentCode,
	                    'bus_id'           => $bus_id,
	                    'bus_alloted_date' => date('Y-m-d')
	                ];

	                $updated = $studentTransportFinancialModel
	                                ->where('student_id', $student_id)
	                                ->set($updateData)
	                                ->update();

	                if ($updated !== false) {
	                    $successCount++;
	                } else {
	                    $errorRows[] = "Row {$rowNumber}: Update Failed (Bus: {$busSerial}, Student: {$studentCode})";
	                }

	            } else {
	                $errorRows[] = "Row {$rowNumber}: Invalid Bus Serial ({$busSerial}) (Student: {$studentCode})";
	            }

	        }
	    }

	    fclose($csvFile);

	    return $this->response->setJSON([
	        'status'  => 'success',
	        'successCount' => $successCount,
	        'errorCount'   => count($errorRows),
	        'errors'  => $errorRows,
	        'message' => "{$successCount} students updated. " . count($errorRows) . " errors found."
	    ]);
	}
}