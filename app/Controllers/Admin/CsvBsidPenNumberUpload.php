<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

use App\Models\StudentModel;
use App\Models\StudentDetailsModel;

use DateTime;
use DateInterval;
use DatePeriod;

class CsvBsidPenNumberUpload extends BaseController
{
	public function index()
	{
		$data['title'] = "Upload BS ID & PEN Data";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        echo view('admin/csv-busid-pen-upload/index', $data);  

        echo view('admin/common/footer', $data);
	}

	public function busid_pen_data_save()
	{
		$file = $this->request->getFile('bspenfile');

        if (!$file->isValid()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid file upload'
            ]);
        }

        if ($file->getExtension() !== 'csv') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Only CSV files allowed'
            ]);
        }

        $logPath = WRITEPATH . 'csv_logs/';
		if (!is_dir($logPath)) {
		    mkdir($logPath, 0777, true);
		}

		$logFile = $logPath . 'bspenfile_upload_' . date('Y-m-d_H-i-s') . '.txt';

        $csv = fopen($file->getTempName(), 'r');

        $lineNo = 0;
        $errors = [];
        

        $studentDetailsModel  = new StudentDetailsModel();
        $session_year_id = session()->get('session_year_id');

     	while (($line = fgetcsv($csv)) !== FALSE) {
     		$lineNo++;
            $row_error = 0;


            $student_code = '';
            $bs_id = '';
            $pen_no = '';

            // ✅ Student code validation
            if (!empty(trim($line[0]))) {
                $student_str = trim($line[0]);
                $student_y_id = explode("-", $student_str);
                $student_y = substr($student_y_id[0], -2);
                $student_id = substr($student_y_id[1] ?? '', 0, 4);

                if ($student_id == '') {
                    $errors[] = "Student Code invalid -- Row No -- {$lineNo}";
                    $row_error++;
                }

                $student_code = $student_y . '-' . $student_id;
            } else {
                $errors[] = "Student Code should not be blank -- Row No -- {$lineNo}";
                $row_error++;
            }

            // ✅ Bangla Sikhsha ID
            if (!empty(trim($line[1]))) {
                $bs_id = trim($line[1]);
            } else {
                // $errors[] = "Bangla Sikhsha ID should not be blank -- Row No -- {$lineNo}";
                // $row_error++;
            }

            // ✅ PEN No
            if (!empty(trim($line[2]))) {
                $pen_no = trim($line[2]);
            } else {
                // $errors[] = "PEN No should not be blank -- Row No -- {$lineNo}";
                // $row_error++;
            }

            $studentDetails = $studentDetailsModel->where('code', $student_code)->where('session_year_id', $session_year_id)->first();
            if (!$studentDetails) {
			    $errors[] = "Student details not found against this student Code -- {$student_code} -- Row No -- {$lineNo}";
                $row_error++;
			}

			if ($row_error > 0) {
                continue;
            }

            $studentDetailsId = $studentDetails['id'] ?? '';
            if( $studentDetailsId != '' ) {
            	$update = $studentDetailsModel->update($studentDetailsId, [
				    'pen_no' => $pen_no,
				    'bs_id' => $bs_id
				]);
            }
     	}

     	fclose($csv);

        // ✅ If no issues
        if ( empty($errors) ) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'You have successfully uploaded Student BS ID & PEN Data.'
            ]);
        }

        // ✅ Prepare HTML response
        $html = '';

        foreach ($errors as $msg) {
            $html .= '<div class="alert alert-danger">'.$msg.'</div>';
        }

        foreach ($studentWithAdv as $msg) {
            $html .= '<div class="alert alert-warning">'.$msg.'</div>';
        }

        foreach ($stuTuiPayInc as $msg) {
            $html .= '<div class="alert alert-info">'.$msg.'</div>';
        }

        foreach ($stuBusPayInc as $msg) {
            $html .= '<div class="alert alert-primary">'.$msg.'</div>';
        }

        return $this->response->setJSON([
            'status' => 'error',
            'html'   => $html
        ]);
	}
}