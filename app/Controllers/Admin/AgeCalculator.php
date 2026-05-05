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

class AgeCalculator extends BaseController
{
	public function index(){
        $data['title'] = "Age Calculator";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        echo view('admin/student/age-calculator', $data);  
        echo view('admin/common/footer', $data);
	}

    function ajax_calculate_age_class()
    {
        $dob = $this->request->getPost('dob');

        $configurationModel = new ConfigurationModel();
        $age_claculation_date = $configurationModel->get_configuration_by_key('age_claculation_date');
        $age_claculation_date_ymd = date('Y-m-d', strtotime($age_claculation_date));

        $myAge = age_round($dob, $age_claculation_date_ymd);
        $age_full_details = age_full_details($dob, $age_claculation_date_ymd);

        $classModel = new ClassModel();
        $classAgeDetails = $classModel
            ->where('age', $myAge)
            ->first();

        $getClass = $classAgeDetails['class_name'] ?? '';

        $data["dob"]= $dob;
        $data["age_full_details"]= $age_full_details;
        $data["getClass"]= $getClass;
        $data["myAge"]= $myAge;
        echo json_encode($data);
        exit();
    }

}