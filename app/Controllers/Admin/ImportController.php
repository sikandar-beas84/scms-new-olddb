<?php
namespace App\Controllers\Admin;
use Config\Database;
use DateTime;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\SubjectMasterModel;
use App\Models\StudentModel;

class ImportController extends BaseController
{
	public function index()
    {
    	$data['title'] = "Import Students";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        echo view('admin/import/students', $data);        
        echo view('admin/common/footer', $data);
    }

	public function importStudents()
	{
	    $file = $this->request->getFile('sql_file');

	    if (!$file || !$file->isValid()) {
	        return redirect()->back()->with('error', 'Invalid SQL file');
	    }

	    $sql = file_get_contents($file->getTempName());

	    preg_match_all(
	        "/INSERT INTO `student`.*?VALUES\s*(.+?);/is",
	        $sql,
	        $matches
	    );

	    if (empty($matches[1])) {
	        return redirect()->back()->with('error', 'No student data found');
	    }

	    $rows = [];

	    foreach ($matches[1] as $valueBlock) {
	        preg_match_all('/\((.*?)\)/', $valueBlock, $records);

	        foreach ($records[1] as $record) {
	            $values = str_getcsv($record, ',', "'");

	            $rows[] = [
	                'id'              => (int) $values[0],
	                'code'            => $values[2],
	                'class_id'        => (int) $values[3],
	                'section_id'      => $values[4] ?: null,
	                'status'          => (int) $values[5],
	                'session_year_id' => (int) $values[6],
	            ];
	        }
	    }

	    if (empty($rows)) {
	        return redirect()->back()->with('error', 'No valid rows to import');
	    }

	    // unset($rows[0]); // remove header row if exists
	    $rows = array_slice($rows, 30000);

	    $getFirst = array_chunk($rows, 500);
	    $studentModel = new StudentModel();

	    $db = db_connect();
	    $sqlValues = "INSERT INTO student (id, code, class_id, section_id, status, session_year_id) VALUES ";
	    foreach ($getFirst as $chunkIndex => $chunk) {
	    	
	    	// foreach ($chunk as $chrow) {
	    	// 	$studentModel->insert($chrow);
	    	// 	pr($chrow);
	    	// }

			foreach ($chunk as $chrow) {

			    $formattedValues = array_map(function ($value) {

			        // 🔥 Normalize NULL-like values
			        if (
			            $value === null ||
			            $value === '' ||
			            (is_string($value) && trim(strtoupper($value)) === 'NULL')
			        ) {
			            return 'NULL'; // SQL NULL (NO quotes)
			        }

			        // ✅ Quote strings safely
			        if (is_string($value)) {
			            return "'" . str_replace("'", "''", trim($value)) . "'";
			        }

			        // ✅ Numbers as-is
			        return $value;

			    }, $chrow);

			    $newRows[] = '(' . implode(', ', $formattedValues) . ')';
			}

			// Join all rows with a comma and a newline
			$sqlValues .= implode(",\n", $newRows) . ";";

			// try {
		    //     $db->query($sqlValues);
		    //     pr("Insert successful");
		    // } catch (\Throwable $e) {
		    //     pr($e->getMessage());
		    // }

			// pr($sqlValues);
	    }
	    echo count($getFirst);
	    pr($sqlValues);
	    pr($getFirst);


	    /*$studentModel = new StudentModel();
	    $db = $studentModel->db;

	    $successIds = [];
	    $failedRows = [];

	    foreach (array_chunk($rows, 500) as $chunkIndex => $chunk) {

	        foreach ($chunk as $row) {
	            try {
	                // SINGLE INSERT
	                $studentModel->insert($row);
	                $successIds[] = $row['id'];
	            } catch (\Throwable $e) {
	                $failedRows[] = [
	                    'id'    => $row['id'],
	                    'error' => $e->getMessage(),
	                ];
	            }
	        }

	        // 🔥 Sleep AFTER each 500 records
	        sleep(20);
	    }

	    return redirect()->back()
	        ->with('import_result', [
	            'successIds' => $successIds,
	            'failedRows' => $failedRows,
	            'total'      => count($rows),
	        ])
	        ->with(
	            empty($failedRows) ? 'success' : 'warning',
	            count($successIds) . ' students imported'
	        );*/
	}

	public function import_student_details()
    {
    	$data['title'] = "Import Student Details";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        $this->fetchStudentsPage();
        echo view('admin/import/student-details', $data); 
        

        echo view('admin/common/footer', $data);
    }

	public function importStudentDetailsOl()
	{
	    $file = $this->request->getFile('sql_file');

	    if (!$file || !$file->isValid()) {
	        return redirect()->back()->with('error', 'Invalid SQL file');
	    }

	    $sql = file_get_contents($file->getTempName());

	   preg_match_all(
		    '/INSERT\s+INTO\s+`student_detail`\s*\((?:[^()]|\([^)]*\))*\)\s*VALUES\s*(\(.+?\));/is',
		    $sql,
		    $matches
		);


	    if (empty($matches[1])) {
	        return redirect()->back()->with('error', 'No student data found');
	    }

	    $rows = [];
	    pr($matches[1]);
	    foreach ($matches[1] as $valueBlock) {
	        preg_match_all('/\((.*?)\)/', $valueBlock, $records);

	        foreach ($records[1] as $record) {
	            $values = str_getcsv($record, ',', "'");

	            
	        }
	    }

	    if (empty($rows)) {
	        return redirect()->back()->with('error', 'No valid rows to import');
	    }
	}

	public function importStudentDetails()
	{
		$file = $this->request->getFile('sql_file');

	    if (!$file || !$file->isValid()) {
	        return redirect()->back()->with('error', 'Invalid SQL file');
	    }

	    $insertSql = file_get_contents($file->getTempName());

	    if (!preg_match('/VALUES\s*(.+);/is', $insertSql, $m)) {
	        return [];
	    }

	    $records = preg_split('/\),\s*\(/', trim($m[1], '()'));
	    $rows    = [];

	    foreach ($records as $record) {

	        $values = str_getcsv($record, ',', "'", '\\');

	        // Safety check
	        if (count($values) < 7) {
	            continue;
	        }

	        $rows[] = [
	            'id'              => (int) $values[0],
	            'session_year_id' => (int) $values[6],
	        ];
	    }
	    pr($rows);
	    return $rows;
	}


	public function fetchStudentsPage()
	{
		// pr("Hello World!");
	    $url = 'https://scmschakdaha.in/public/uploads/student_fee_structure_nt8.sql';

	    // page number from request (default 1)
	    // $page  = max(1, (int) $this->request->getGet('page'));
	    $page  = 1;
	    $limit = 500;
	    $offset = ($page - 1) * $limit;

	    $handle = fopen($url, 'r');

	    if (!$handle) {
	        return $this->response->setJSON(['error' => 'Unable to open SQL file']);
	    }
	    echo "<br />";echo "<br />";echo "<br />";echo "<br />";
	    $buffer     = '';
	    $rows       = [];
	    $totalSeen  = 0;

		$stop = false;

		while (($line = fgets($handle)) !== false && !$stop) {

		    if (stripos($line, 'INSERT INTO `student_fee_structure`') !== false) {

		        $buffer = $line;

		        while (strpos($buffer, ';') === false && ($next = fgets($handle))) {
		            $buffer .= $next;
		        }
		        // pr($buffer);
		        $records = $this->parseStudentFeeStructureDataInsert($buffer);
		        // pr($records);
		        echo "\n"; print_r($records);
		        echo "\n";
		        echo "<br />";echo "<br />";echo "<br />";echo "<br />";

		        /*foreach ($records as $record) {

		            if ($totalSeen < $offset) {
		                $totalSeen++;
		                continue;
		            }

		            $rows[] = $record;
		            $totalSeen++;

		            if (count($rows) === $limit) {
		                $stop = true;
		                break;
		            }
		        }*/
		    }
		}

	    fclose($handle);

	    pr("Bubai");

	    $returData = [
	        'page'        => $page,
	        'limit'       => $limit,
	        'fetched'     => count($rows),
	        'next_page'   => count($rows) === $limit ? $page + 1 : null,
	        'data'        => $rows
	    ];
	    
	    return $this->response->setJSON([
	        'page'        => $page,
	        'limit'       => $limit,
	        'fetched'     => count($rows),
	        'next_page'   => count($rows) === $limit ? $page + 1 : null,
	        'data'        => $rows
	    ]);
	}


	/*private function parseStudentInsert(string $sql): array
	{
		// echo "<pre>"; print_r($sql);

	    if (!preg_match('/VALUES\s*(.+);/is', $sql, $m)) {
	        return [];
	    }

	    $records = preg_split('/\),\s*\(/', trim($m[1], '()'));
	    $studentDetailsrows    = [];

	    foreach ($records as $record) {

	        $values = str_getcsv($record, ',', "'", '\\');
			
			// pr($values);
	        // if (count($values) < 150) {
	        //     continue;
	        // }

	        $studentModel = new StudentModel();
	        $getStudentId = $studentModel
	        ->where('code', $values[1])
	        ->where('session_year_id', $values[129])
	        ->select('id')
	        ->first()['id'] ?? null;

	        $tcDate = (empty($values[120]) || $values[120] === '0000-00-00') ? null : $values[120];


	        $studentDetailsrows[] = [
				'id' => (int) $values[0],
				'student_id' => $getStudentId,
				'code' => $values[1],
				'form_no' => $values[2],
				'bs_id' => $values[3],
				'stream_id' => $values[7],
				'class_id' => $values[8],
				'section_id' => $values[9],
				'roll_num' => $values[10],
				'first_name' => $values[11],
				'middle_name' => $values[12],
				'surname' => $values[13],
				'd_o_b' => $values[14],
				'gender' => $values[42],
				'blood_grp' => $values[38],
				'caste' => $values[39],
				'image' => $values[41],
				'aadhaar_no' => $values[15],
				'admission_number' => $values[74],
				'admission_date' => $values[75],
				'school_house_id' => $values[76],
				'promotion' => $values[89],
				'academic_status' => $values[119],
				'tc_date' => $tcDate,
				'tc_no' => '',
				'pen_no' => '',
				'appar_id' => '',
				'tc_required' => $values[79],
				'admission' => $values[121],
				'status' => $values[103],
				'created_by' => $values[126],
				'created_date' => $values[127],
				'session_year_id' => $values[129],
				'session_result_status' => $values[128],
				'ad_exam_qualified' => $values[122],
				'rejection_reason' => $values[123],
				'fail_consideration' => $values[124],
				'fail_cons_remarks' => $values[125],
				'relative' => $values[92],
				'relative_name' => $values[93],
				'relative_code' => $values[94],
				'relationship' => $values[95],
				'comment' => $values[102],
				'student_admit' => $values[118],
				'ad_exam_qualified_submitted_date' => '',
				'ad_exam_qualified_pass_fail_date' => '',
				'ad_exam_qualified_submitted_by' => '',
				'ad_exam_qualified_pass_fail_submitted_by' => '',
				'updated_by' => '',
				'updated_date' => '',
				'shift' => '',
	        ];
	    }

	    // pr($studentDetailsrows);
	    return $studentDetailsrows;
	}*/

	private function parseStudentInsert(string $sql): string
	{
	    if (!preg_match('/VALUES\s*(.+);/is', $sql, $m)) {
	        return '';
	    }

	    $records = preg_split('/\),\s*\(/', trim($m[1], '()'));
	    $valueSets = [];

	    $studentModel = new StudentModel();

	    foreach ($records as $record) {

	        $values = str_getcsv($record, ',', "'", '\\');

	        // if( !isset($values[129]) ) {
	        // 	pr($values);
	        // }

	        // Fetch student_id
	        $studentId = $studentModel
	            ->select('id')
	            ->where('code', $values[1])
	            ->where('session_year_id', $values[129])
	            ->first()['id'] ?? null;

	        // tc_date handling
	        $tcDate = (empty($values[120]) || $values[120] === '0000-00-00')
	            ? 'NULL'
	            : "'" . addslashes($values[120]) . "'";

	        // Helper for safe string
	        // $s = fn($v) => isset($v) && $v !== '' ? "'" . addslashes($v) . "'" : "''";
	        // $d = fn($v) => ( !isset($v) || $v === '' || $v === '0000-00-00') ? "NULL" : "'" . addslashes($v) . "'";

	        $s = function ($v) {
			    if (!isset($v)) {
			        return "NULL";
			    }

			    $v = trim($v);

			    if ($v === '' || strtoupper($v) === 'NULL') {
			        return "NULL";
			    }

			    return "'" . addslashes($v) . "'";
			};
			$d = function ($v) {
			    if (!isset($v)) {
			        return "NULL";
			    }

			    $v = trim($v);

			    if ($v === '' || $v === '0000-00-00' || strtoupper($v) === 'NULL') {
			        return "NULL";
			    }

			    return "'" . addslashes($v) . "'";
			};

			$getDOB = !empty(trim($values[14])) ? $this->normalizeDob($values[14]) : null;


	        /*$row = [
	            (int)$values[0],                          // id
	            $studentId ? (int)$studentId : 'NULL',    // student_id
	            $s($values[1]),                           // code
	            $s($values[2]),                           // form_no
	            $s($values[3]),                           // bs_id
	            $s($values[7]),                           // stream_id
	            $s($values[8]),                           // class_id
	            $s($values[9]),                           // section_id
	            $s($values[10]),                          // roll_num
	            $s($values[11]),                          // first_name
	            $s($values[12]),                          // middle_name
	            $s($values[13]),                          // surname
	            $s($values[14]),                          // d_o_b
	            $s($values[42]),                          // gender
	            $s($values[38]),                          // blood_grp
	            $s($values[39]),                          // caste
	            $s($values[41]),                          // image
	            $s($values[15]),                          // aadhaar_no
	            $s($values[74]),                          // admission_number
	            $s($values[75]),                          // admission_date
	            $s($values[76]),                          // school_house_id
	            $s($values[89]),                          // promotion
	            $s($values[119]),                         // academic_status
	            $tcDate,                                  // tc_date
	            "''",                                     // tc_no
	            "''",                                     // pen_no
	            "''",                                     // appar_id
	            $s($values[79]),                          // tc_required
	            $s($values[121]),                         // admission
	            $s($values[103]),                         // status
	            $s($values[126]),                         // created_by
	            $s($values[127]),                         // created_date
	            $s($values[129]),                         // session_year_id
	            $s($values[128]),                         // session_result_status
	            $s($values[122]),                         // ad_exam_qualified
	            $s($values[123]),                         // rejection_reason
	            $s($values[124]),                         // fail_consideration
	            $s($values[125]),                         // fail_cons_remarks
	            $s($values[92]),                          // relative
	            $s($values[93]),                          // relative_name
	            $s($values[94]),                          // relative_code
	            $s($values[95]),                          // relationship
	            $s($values[102]),                         // comment
	            $s($values[118]),                         // student_admit
	            "''", "''", "''", "''",                   // exam dates/users
	            "''", "''",                               // updated_by / updated_date
	            "''"                                      // shift
	        ];*/

	        if( isset($studentId) && $studentId != "" ) {
				$row = [
				    (int)$values[0],                          // id
				    $studentId ? (int)$studentId : 'NULL',    // student_id
				    $s($values[1]),                           // code
				    $s($values[2]),                           // form_no
				    $s($values[3]),                           // bs_id
				    $s($values[7]),                           // stream_id
				    $s($values[8]),                           // class_id
				    $s($values[9]),                           // section_id
				    $s($values[10]),                          // roll_num
				    $s($values[11]),                          // first_name
				    $s($values[12]),                          // middle_name
				    $s($values[13]),                          // surname
				    $d($getDOB),                          	  // d_o_b ✅
				    $s($values[42]),                          // gender
				    $s($values[38]),                          // blood_grp
				    $s($values[39]),                          // caste
				    $s($values[41]),                          // image
				    $s($values[15]),                          // aadhaar_no
				    $s($values[74]),                          // admission_number
				    $d($values[75]),                          // admission_date ✅
				    $s($values[76]),                          // school_house_id
				    $s($values[89]),                          // promotion
				    $s($values[119]),                         // academic_status
				    $d($values[120]),                         // tc_date ✅
				    "''",                                     // tc_no
				    "''",                                     // pen_no
				    "''",                                     // appar_id
				    $s($values[79]),                          // tc_required
				    $s($values[121]),                         // admission
				    $s($values[103]),                         // status
				    $s($values[126]),                         // created_by
				    $d($values[127]),                         // created_date ✅
				    $s($values[129]),                         // session_year_id
				    $s($values[128]),                         // session_result_status
				    $s($values[122]),                         // ad_exam_qualified
				    $s($values[123]),                         // rejection_reason
				    $s($values[124]),                         // fail_consideration
				    $s($values[125]),                         // fail_cons_remarks
				    $s($values[92]),                          // relative
				    $s($values[93]),                          // relative_name
				    $s($values[94]),                          // relative_code
				    $s($values[95]),                          // relationship
				    $s($values[102]),                         // comment
				    $s($values[118]),                         // student_admit
				    "NULL",                                   // ad_exam_qualified_submitted_date
				    "NULL",                                   // ad_exam_qualified_pass_fail_date
				    "NULL",                                   // ad_exam_qualified_submitted_by
				    "NULL",                                   // ad_exam_qualified_pass_fail_submitted_by
				    "NULL",                                   // updated_by
				    "NULL",                                   // updated_date
				    "''"                                      // shift
				];

		        $valueSets[] = '(' . implode(',', $row) . ')';
	        }
	        /*else {
	        	$notInsertDetails = [];
	        }*/

	    }

	    $columns = "id, student_id, code, form_no, bs_id, stream_id, class_id, section_id, roll_num, first_name, middle_name, surname, d_o_b, gender, blood_grp, caste, image, aadhaar_no, admission_number, admission_date, school_house_id, promotion, academic_status, tc_date, tc_no, pen_no, appar_id, tc_required, admission, status, created_by, created_date, session_year_id, session_result_status, ad_exam_qualified, rejection_reason, fail_consideration, fail_cons_remarks, relative, relative_name, relative_code, relationship, comment, student_admit, ad_exam_qualified_submitted_date, ad_exam_qualified_pass_fail_date, ad_exam_qualified_submitted_by, ad_exam_qualified_pass_fail_submitted_by, updated_by, updated_date, shift";


	    return "INSERT INTO student_details (" . trim($columns) . ") VALUES\n"
	        . implode(",\n", $valueSets) . ";";
	}

	private function normalizeDob($dob)
	{
	    // Case 1: DD-MM-YY (e.g. 28-09-11)
	    if (preg_match('/^\d{2}-\d{2}-\d{2}$/', $dob)) {
	        $date = DateTime::createFromFormat('d-m-y', $dob);
	        return $date ? $date->format('Y-m-d') : null;
	    }

	    // Case 2: YYYY-MM-DD (e.g. 2003-04-21)
	    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
	        return $dob; // already correct
	    }

	    // Invalid format
	    return null;
	}

	private function parseStudentDocumentsDataInsert(string $sql): string
	{
	    if (!preg_match('/VALUES\s*(.+);/is', $sql, $m)) {
	        return '';
	    }

	    $records = preg_split('/\),\s*\(/', trim($m[1], '()'));
	    $valueSets = [];

	    $studentModel = new StudentModel();

	    foreach ($records as $record) {

	        $values = str_getcsv($record, ',', "'", '\\');

	        // if( !isset($values[129]) ) {
	        // 	pr($values);
	        // }

	        // Fetch student_id
	        $studentId = $studentModel
	            ->select('id')
	            ->where('code', $values[1])
	            ->where('session_year_id', $values[129])
	            ->first()['id'] ?? null;

	        // tc_date handling
	        $tcDate = (empty($values[120]) || $values[120] === '0000-00-00')
	            ? 'NULL'
	            : "'" . addslashes($values[120]) . "'";

	        // Helper for safe string
	        // $s = fn($v) => isset($v) && $v !== '' ? "'" . addslashes($v) . "'" : "''";
	        // $d = fn($v) => ( !isset($v) || $v === '' || $v === '0000-00-00') ? "NULL" : "'" . addslashes($v) . "'";

	        /*$s = function ($v) {
			    if (!isset($v)) {
			        return "NULL";
			    }

			    $v = trim($v);

			    if ($v === '' || strtoupper($v) === 'NULL') {
			        return "NULL";
			    }

			    return "'" . addslashes($v) . "'";
			};
			$d = function ($v) {
			    if (!isset($v)) {
			        return "NULL";
			    }

			    $v = trim($v);

			    if ($v === '' || $v === '0000-00-00' || strtoupper($v) === 'NULL') {
			        return "NULL";
			    }

			    return "'" . addslashes($v) . "'";
			};*/

			$s = function ($v, $prefix = '') { if (!isset($v)) return "NULL"; $v = trim($v); if ($v === '' || strtoupper($v) === 'NULL') return "NULL"; $v = $prefix . $v; return "'" . addslashes($v) . "'"; };


			$getDOB = !empty(trim($values[14])) ? $this->normalizeDob($values[14]) : null;


	        if( isset($studentId) && $studentId != "" ) {
	        	$getPrefixPath = $values[2].'/';
				$row = [
				    (int)$values[0],                          // id
				    $studentId ? (int)$studentId : 'NULL',    // student_id
				    $s($values[1]),                           // student_code

				    $s($values[104], $getPrefixPath),							// signature $values[2]
				    $s($values[105], $getPrefixPath),                           // f_image
				    $s($values[106], $getPrefixPath),                           // m_image
				    $s($values[107], $getPrefixPath),                           // f_signature
				    $s($values[108], $getPrefixPath),                           // m_signature
				    $s($values[109], $getPrefixPath),                          	// g_image
				    $s($values[110], $getPrefixPath),                          	// g_signature
				    $s($values[111], $getPrefixPath),                          	// stu_signature
				    $s($values[116], $getPrefixPath),                          	// cast_certificate
				    $s($values[40], $getPrefixPath),                          	// caste_photocopy
				    $s($values[117], $getPrefixPath),                          	// application
				    "''",                          				// trans_cert
				    "''",                          				// migration_cert
				    "''"                          				// any_special_cert
				];

		        $valueSets[] = '(' . implode(',', $row) . ')';
	        }
	        /*else {
	        	$notInsertDetails = [];
	        }*/

	    }

	    $columns = "id, student_id, student_code, signature, f_image, m_image, f_signature, m_signature, g_image, g_signature, stu_signature, cast_certificate, caste_photocopy, application, trans_cert, migration_cert, any_special_cert";
        

	    return "INSERT INTO student_documents (" . trim($columns) . ") VALUES\n"
	        . implode(",\n", $valueSets) . ";";
	}

	private function parseStudentElectiveSubjectsDataInsert(string $sql): string
	{
	    if (!preg_match('/VALUES\s*(.+);/is', $sql, $m)) {
	        return '';
	    }

	    $records = preg_split('/\),\s*\(/', trim($m[1], '()'));
	    $valueSets = [];

	    $studentModel = new StudentModel();

	    foreach ($records as $record) {

	        $values = str_getcsv($record, ',', "'", '\\');

	        // if( !isset($values[129]) ) {
	        // 	pr($values);
	        // }

	        // Fetch student_id
	        $studentId = $studentModel
	            ->select('id')
	            ->where('code', $values[1])
	            ->where('session_year_id', $values[129])
	            ->first()['id'] ?? null;

	        // tc_date handling
	        $tcDate = (empty($values[120]) || $values[120] === '0000-00-00')
	            ? 'NULL'
	            : "'" . addslashes($values[120]) . "'";

	        // Helper for safe string
	        // $s = fn($v) => isset($v) && $v !== '' ? "'" . addslashes($v) . "'" : "''";
	        // $d = fn($v) => ( !isset($v) || $v === '' || $v === '0000-00-00') ? "NULL" : "'" . addslashes($v) . "'";

	        /*$s = function ($v) {
			    if (!isset($v)) {
			        return "NULL";
			    }

			    $v = trim($v);

			    if ($v === '' || strtoupper($v) === 'NULL') {
			        return "NULL";
			    }

			    return "'" . addslashes($v) . "'";
			};
			$d = function ($v) {
			    if (!isset($v)) {
			        return "NULL";
			    }

			    $v = trim($v);

			    if ($v === '' || $v === '0000-00-00' || strtoupper($v) === 'NULL') {
			        return "NULL";
			    }

			    return "'" . addslashes($v) . "'";
			};*/

			$s = function ($v, $prefix = '') { if (!isset($v)) return "NULL"; $v = trim($v); if ($v === '' || strtoupper($v) === 'NULL') return "NULL"; $v = $prefix . $v; return "'" . addslashes($v) . "'"; };


			$getDOB = !empty(trim($values[14])) ? $this->normalizeDob($values[14]) : null;


	        if( isset($studentId) && $studentId != "" ) {
	        	$getPrefixPath = $values[2].'/';
				$row = [
				    (int)$values[0],                          	// id
				    $studentId ? (int)$studentId : 'NULL',    	// student_id
				    $s($values[1]),                           	// student_code

				    $s($values[96]),							// first_elective_sub
				    $s($values[97]),                           // second_elective_sub
				    $s($values[98]),                           // third_elective_sub
				    $s($values[99]),                           // fourth_elective_sub
				    $s($values[100]),                           // fifth_elective_sub
				    $s($values[101]),                          	// sixth_elective_sub

				    $s($values[112], $getPrefixPath),			// last_year_marksheet
				    "''",										// student_birth_certificate not found
				    $s($values[118], $getPrefixPath),			// student_admit
				    $s($values[113], $getPrefixPath),			// father_id
				    $s($values[114], $getPrefixPath),			// mother_id
				    $s($values[116], $getPrefixPath)			// cast_certificate
				];

		        $valueSets[] = '(' . implode(',', $row) . ')';
	        }
	        /*else {
	        	$notInsertDetails = [];
	        }*/

	    }

	    $columns = "id, student_id, student_code, first_elective_sub, second_elective_sub, third_elective_sub, fourth_elective_sub, fifth_elective_sub, sixth_elective_sub, last_year_marksheet, student_birth_certificate, student_admit, father_id, mother_id, cast_certificate";
        

	    return "INSERT INTO student_elective_subjects (" . trim($columns) . ") VALUES\n"
	        . implode(",\n", $valueSets) . ";";
	}

	private function parseStudentParentsGuardiansDataInsert(string $sql): string
	{
	    if (!preg_match('/VALUES\s*(.+);/is', $sql, $m)) {
	        return '';
	    }

	    $records = preg_split('/\),\s*\(/', trim($m[1], '()'));
	    $valueSets = [];

	    $studentModel = new StudentModel();

	    foreach ($records as $record) {

	        $values = str_getcsv($record, ',', "'", '\\');

	        // if( !isset($values[129]) ) {
	        // 	pr($values);
	        // }

	        // Fetch student_id
	        $studentId = $studentModel
	            ->select('id')
	            ->where('code', $values[1])
	            ->where('session_year_id', $values[129])
	            ->first()['id'] ?? null;

	        // tc_date handling
	        $tcDate = (empty($values[120]) || $values[120] === '0000-00-00')
	            ? 'NULL'
	            : "'" . addslashes($values[120]) . "'";

	        // Helper for safe string
	        // $s = fn($v) => isset($v) && $v !== '' ? "'" . addslashes($v) . "'" : "''";
	        // $d = fn($v) => ( !isset($v) || $v === '' || $v === '0000-00-00') ? "NULL" : "'" . addslashes($v) . "'";

			$s = function ($v, $prefix = '') { if (!isset($v)) return "NULL"; $v = trim($v); if ($v === '' || strtoupper($v) === 'NULL') return "NULL"; $v = $prefix . $v; return "'" . addslashes($v) . "'"; };


			$getDOB = !empty(trim($values[14])) ? $this->normalizeDob($values[14]) : null;


	        if( isset($studentId) && $studentId != "" ) {
	        	$getPrefixPath = $values[2].'/';
				$row = [
				    (int)$values[0],                          	// id
				    $studentId ? (int)$studentId : 'NULL',    	// student_id
				    $s($values[1]),                           	// student_code

				    $s($values[43]),							// father_name
				    $s($values[44]),							// father_occupation
				    $s($values[45]),							// father_designation
				    $s($values[46]),							// father_office_address

				    $s($values[47]),                            // father_office_phone
					$s($values[48]),                            // father_mobile
					$s($values[49]),                            // father_qualification
					$s($values[50]),                            // father_annual_income
					$s($values[20]),                            // father_aadhaar_no
					$s($values[113], $getPrefixPath), 			// father_id
					$s($values[51]),                            // mother_name
					$s($values[52]),                            // mother_occupation
					$s($values[53]),                            // mother_designation
					$s($values[54]),                            // mother_office_address
					$s($values[55]),                            // mother_office_phone
					$s($values[56]),                            // mother_mobile
					$s($values[59]),                            // mother_qualification
					$s($values[60]),                            // mother_annual_income
					$s($values[21]),                            // mother_aadhaar_no
					$s($values[114], $getPrefixPath), 			// mother_id
					$s($values[137]),                           // mothers_is_gurgent
					$s($values[61]),                            // local_guar_name
					$s($values[62]),                            // local_guar_occupation
					$s($values[63]),                            // local_guar_stu_relation
					$s($values[24]),                            // local_guar_gender
					$s($values[25]),                            // local_guar_annual_income
					$s($values[23]),                            // local_guar_aadhaar_no
					$s($values[64]),                            // local_guar_phone
					$s($values[65]),                            // local_guar_office_phone
					$s($values[66]),                            // local_guar_address
					$s($values[26]),                            // family_earn_memb
					$s($values[27])                             // dependent


				];

		        $valueSets[] = '(' . implode(',', $row) . ')';
	        }
	        /*else {
	        	$notInsertDetails = [];
	        }*/

	    }

	    $columns = "id, student_id, student_code, father_name, father_occupation, father_designation, father_office_address, father_office_phone, father_mobile, father_qualification, father_annual_income, father_aadhaar_no, father_id, mother_name, mother_occupation, mother_designation, mother_office_address, mother_office_phone, mother_mobile, mother_qualification, mother_annual_income, mother_aadhaar_no, mother_id, mothers_is_gurgent, local_guar_name, local_guar_occupation, local_guar_stu_relation, local_guar_gender, local_guar_annual_income, local_guar_aadhaar_no, local_guar_phone, local_guar_office_phone, local_guar_address, family_earn_memb, dependent";
        

	    return "INSERT INTO student_parents_guardians (" . trim($columns) . ") VALUES\n"
	        . implode(",\n", $valueSets) . ";";
	}

	private function parseStudentPersonalDetailsDataInsert(string $sql): string
	{
	    if (!preg_match('/VALUES\s*(.+);/is', $sql, $m)) {
	        return '';
	    }

	    $records = preg_split('/\),\s*\(/', trim($m[1], '()'));
	    $valueSets = [];

	    $studentModel = new StudentModel();

	    foreach ($records as $record) {

	        $values = str_getcsv($record, ',', "'", '\\');

	        // if( !isset($values[129]) ) {
	        // 	pr($values);
	        // }

	        // Fetch student_id
	        $studentId = $studentModel
	            ->select('id')
	            ->where('code', $values[1])
	            ->where('session_year_id', $values[129])
	            ->first()['id'] ?? null;

	        // tc_date handling
	        $tcDate = (empty($values[120]) || $values[120] === '0000-00-00')
	            ? 'NULL'
	            : "'" . addslashes($values[120]) . "'";

	        // Helper for safe string
	        // $s = fn($v) => isset($v) && $v !== '' ? "'" . addslashes($v) . "'" : "''";
	        // $d = fn($v) => ( !isset($v) || $v === '' || $v === '0000-00-00') ? "NULL" : "'" . addslashes($v) . "'";

			$s = function ($v, $prefix = '') { if (!isset($v)) return "NULL"; $v = trim($v); if ($v === '' || strtoupper($v) === 'NULL') return "NULL"; $v = $prefix . $v; return "'" . addslashes($v) . "'"; };


			$getDOB = !empty(trim($values[14])) ? $this->normalizeDob($values[14]) : null;


	        if( isset($studentId) && $studentId != "" ) {
	        	$getPrefixPath = $values[2].'/';
				$row = [
				    (int)$values[0],                          	// id
				    $studentId ? (int)$studentId : 'NULL',    	// student_id
				    $s($values[1]),                           	// student_code

				    $s($values[16]),							// mother_language
				    $s($values[4]),                             // second_language
					$s($values[17]),                            // immunization
					$s($values[18]),                            // medical_condition
					$s($values[19]),                            // only_child
					$s($values[72]),                            // religion
					$s($values[73]),                            // nationality
					$s($values[77]),                            // bpl
					$s($values[78]),                            // bpl_number
					$s($values[36]),                            // lkg_onw_sec_lang
					$s($values[37]),                            // std_three_sec_lang
					$s($values[22]),                            // telephone_resi
					$s($values[69]),                            // pincode
					$s($values[67]),                            // permanent_address
					$s($values[68]),                            // residential_address
					$s($values[70]),                            // residential_phone
					$s($values[71]),                            // residential_mobile
					$s($values[87]),                            // email
					$s($values[57]),                            // whatsapp_number_one
					$s($values[58])                             // whatsapp_number_two
				];

		        $valueSets[] = '(' . implode(',', $row) . ')';
	        }
	        /*else {
	        	$notInsertDetails = [];
	        }*/

	    }

	    $columns = "id, student_id, student_code, mother_language, second_language, immunization, medical_condition, only_child, religion, nationality, bpl, bpl_number, lkg_onw_sec_lang, std_three_sec_lang, telephone_resi, pincode, permanent_address, residential_address, residential_phone, residential_mobile, email, whatsapp_number_one, whatsapp_number_two";
        

	    return "INSERT INTO student_personal_details (" . trim($columns) . ") VALUES\n"
	        . implode(",\n", $valueSets) . ";";
	}

	private function parseStudentTransportFinancialDataInsert(string $sql): string
	{
	    if (!preg_match('/VALUES\s*(.+);/is', $sql, $m)) {
	        return '';
	    }

	    $records = preg_split('/\),\s*\(/', trim($m[1], '()'));
	    $valueSets = [];

	    $studentModel = new StudentModel();

	    foreach ($records as $record) {

	        $values = str_getcsv($record, ',', "'", '\\');

	        // if( !isset($values[129]) ) {
	        // 	pr($values);
	        // }

	        // Fetch student_id
	        $studentId = $studentModel
	            ->select('id')
	            ->where('code', $values[1])
	            ->where('session_year_id', $values[129])
	            ->first()['id'] ?? null;

	        // tc_date handling
	        $tcDate = (empty($values[120]) || $values[120] === '0000-00-00')
	            ? 'NULL'
	            : "'" . addslashes($values[120]) . "'";

	        // Helper for safe string
	        // $s = fn($v) => isset($v) && $v !== '' ? "'" . addslashes($v) . "'" : "''";
	        $d = fn($v) => ( !isset($v) || $v === '' || $v === '0000-00-00') ? "NULL" : "'" . addslashes($v) . "'";

			$s = function ($v, $prefix = '') { if (!isset($v)) return "NULL"; $v = trim($v); if ($v === '' || strtoupper($v) === 'NULL') return "NULL"; $v = $prefix . $v; return "'" . addslashes($v) . "'"; };


			$getDOB = !empty(trim($values[14])) ? $this->normalizeDob($values[14]) : null;


	        if( isset($studentId) && $studentId != "" ) {
	        	$getPrefixPath = $values[2].'/';
				$row = [
				    (int)$values[0],                          	// id
				    $studentId ? (int)$studentId : 'NULL',    	// student_id
				    $s($values[1]),                           	// student_code

				    $s($values[5]),                             // bank_acc_no
					$s($values[6]),                             // bank_ifsc_no
					$s($values[83]),                             // transport_required
					$s($values[84]),                             // stoppage
					$s($values[85]),                             // bus_id
					$d($values[86]),                            // bus_alloted_date
					$s($values[135]),                            // allow_transport
					$s($values[130]),                            // deposit_refund_status
					$d($values[131]),                            // refund_date
					$s($values[132]),                            // refund_message
					$s($values[133]),                            // sm_refund_amount
					$d($values[134]),                            // sm_refund_date
					$s($values[136]),                            // allow_readmission
					$s($values[138]),                            // dmg_prd
					$s($values[139]),                            // dmg_prd_price
					$s($values[140])                             // dmg_prd_img
				];

		        $valueSets[] = '(' . implode(',', $row) . ')';
	        }
	        /*else {
	        	$notInsertDetails = [];
	        }*/

	    }

	    $columns = "id, student_id, student_code, bank_acc_no, bank_ifsc_no, transport_required, stoppage, bus_id, bus_alloted_date, allow_transport, deposit_refund_status, refund_date, refund_message, sm_refund_amount, sm_refund_date, allow_readmission, dmg_prd, dmg_prd_price, dmg_prd_img";
        

	    return "INSERT INTO student_transport_financial (" . trim($columns) . ") VALUES\n"
	        . implode(",\n", $valueSets) . ";";
	}

	private function parseStudentFeeStructureDataInsert(string $sql): string
	{
	    if (!preg_match('/VALUES\s*(.+);/is', $sql, $m)) {
	        return '';
	    }

	    $records = preg_split('/\),\s*\(/', trim($m[1], '()'));
	    $valueSets = [];

	    $studentModel = new StudentModel();

	    foreach ($records as $record) {

	        $values = str_getcsv($record, ',', "'", '\\');
	        
	        // if( !isset($values[129]) ) {
	        // 	pr($values);
	        // }
			// pr($values);
	        // Fetch student_id
	        // $studentId = $studentModel
	        //     ->select('id')
	        //     ->where('code', $values[1])
	        //     ->where('session_year_id', $values[129])
	        //     ->first()['id'] ?? null;

	        // // tc_date handling
	        // $tcDate = (empty($values[120]) || $values[120] === '0000-00-00')
	        //     ? 'NULL'
	        //     : "'" . addslashes($values[120]) . "'";

	        // Helper for safe string
	        // $s = fn($v) => isset($v) && $v !== '' ? "'" . addslashes($v) . "'" : "''";
	        // $d = fn($v) => ( !isset($v) || $v === '' || $v === '0000-00-00') ? "NULL" : "'" . addslashes($v) . "'";

	        $d = fn($v) => (!isset($v) || trim($v) === '' || $v === '0000-00-00' || $v === '0000-00-00 00:00:00') ? "NULL" : "'" . addslashes($v) . "'";
			$s = function ($v, $prefix = '') { if (!isset($v)) return "NULL"; $v = trim($v); if ($v === '' || strtoupper($v) === 'NULL') return "NULL"; $v = $prefix . $v; return "'" . addslashes($v) . "'"; };


			$getDOB = !empty(trim($values[14])) ? $this->normalizeDob($values[14]) : null;


	        // if( isset($studentId) && $studentId != "" ) {
	        	
				$row = [
				    (int)$values[0],                           // id
					$s($values[1]),                            // student_code
					$s($values[2]),                            // form_no
					$s($values[3]),                            // month_id
					$s($values[4]),                            // fine
					$s($values[5]),                            // admission_fee
					$s($values[6]),                            // development_fee
					$s($values[7]),                            // exam_fee
					$s($values[8]),                            // festival_celebration_fee
					$s($values[9]),                            // games_sports_fee
					$s($values[10]),                           // audio_visual_lab_fee
					$s($values[11]),                           // library_fee
					$s($values[12]),                           // electricity_maintenance_fee
					$s($values[13]),                           // computer_fee
					$s($values[14]),                           // session_charges
					$s($values[15]),                           // security_deposite
					$s($values[16]),                           // tuition_fee
					$s($values[17]),                           // bus_services
					$s($values[18]),                           // bus_fee_fine
					$s($values[19]),                           // payment_amount
					$s($values[20]),                           // academic_payment_amt
					$s($values[21]),                           // bus_payment_amt
					$s($values[22]),                           // total_stationary_fee
					$s($values[23]),                           // ad_payment_status
					$s($values[24]),                           // bus_payment_status
					$d($values[25]),                           // payment_due_date
					$d($values[26]),                           // created_date
					$d($values[27]),                           // bus_payment_date
					$s($values[28]),                           // ad_payment_mode
					$s($values[29]),                           // bus_payment_mode
					$s($values[30]),                           // cheque_number
					$s($values[31]),                           // pos_bank_name
					$s($values[32]),                           // pos_reference_number
					$s($values[33]),                           // transaction_no
					$s($values[34]),                           // payee_name
					$s($values[35]),                           // t_user_id
					$s($values[36]),                           // added_by
					$s($values[37]),                           // bus_cheque_number
					$s($values[38]),                           // bus_pos_bank_name
					$s($values[39]),                           // bus_pos_reference_number
					$s($values[40]),                           // bus_payee_name
					$s($values[41]),                           // bus_t_user_id
					$s($values[42]),                           // bus_added_by
					$s($values[43]),                           // cons_admission_fee
					$s($values[44]),                           // cons_development_fee
					$s($values[45]),                           // cons_exam_fee
					$s($values[46]),                           // cons_festival_celebration_fee
					$s($values[47]),                           // cons_games_sports_fee
					$s($values[48]),                           // cons_audio_visual_lab_fee
					$s($values[49]),                           // cons_library_fee
					$s($values[50]),                           // cons_electricity_maintenance_fee
					$s($values[51]),                           // cons_computer_fee
					$s($values[52]),                           // cons_session_charges
					$s($values[53]),                           // cons_security_deposite
					$s($values[54]),                           // cons_tuition_fee
					$s($values[55]),                           // cons_bus_services
					$s($values[56]),                           // remarks
					$s($values[57]),                           // adv_bal_used
					$s($values[58]),                           // session_year_id
					$s($values[59]),                           // allow_bus_report
					$s($values[60])                            // allow_payment_report
				];

		        $valueSets[] = '(' . implode(',', $row) . ')';
	        // }
	        /*else {
	        	$notInsertDetails = [];
	        }*/

	    }
	    // pr($valueSets);
	    $columns = "id, student_code, form_no, month_id, fine, admission_fee, development_fee, exam_fee, festival_celebration_fee, games_sports_fee, audio_visual_lab_fee, library_fee, electricity_maintenance_fee, computer_fee, session_charges, security_deposite, tuition_fee, bus_services, bus_fee_fine, payment_amount, academic_payment_amt, bus_payment_amt, total_stationary_fee, ad_payment_status, bus_payment_status, payment_due_date, created_date, bus_payment_date, ad_payment_mode, bus_payment_mode, cheque_number, pos_bank_name, pos_reference_number, transaction_no, payee_name, t_user_id, added_by, bus_cheque_number, bus_pos_bank_name, bus_pos_reference_number, bus_payee_name, bus_t_user_id, bus_added_by, cons_admission_fee, cons_development_fee, cons_exam_fee, cons_festival_celebration_fee, cons_games_sports_fee, cons_audio_visual_lab_fee, cons_library_fee, cons_electricity_maintenance_fee, cons_computer_fee, cons_session_charges, cons_security_deposite, cons_tuition_fee, cons_bus_services, remarks, adv_bal_used, session_year_id, allow_bus_report, allow_payment_report";
        

	    return "INSERT INTO student_fee_structure (" . trim($columns) . ") VALUES\n"
	        . implode(",\n", $valueSets) . ";";
	}

	private function parseStudentTransactionDataInsert(string $sql): string
	{
	    if (!preg_match('/VALUES\s*(.+);/is', $sql, $m)) {
	        return '';
	    }

	    $records = preg_split('/\),\s*\(/', trim($m[1], '()'));
	    $valueSets = [];

	    $studentModel = new StudentModel();

	    foreach ($records as $record) {

	        $values = str_getcsv($record, ',', "'", '\\');
	        
	        $d = fn($v) => (!isset($v) || trim($v) === '' || $v === '0000-00-00' || $v === '0000-00-00 00:00:00') ? "NULL" : "'" . addslashes($v) . "'";
			$s = function ($v, $prefix = '') { if (!isset($v)) return "NULL"; $v = trim($v); if ($v === '' || strtoupper($v) === 'NULL') return "NULL"; $v = $prefix . $v; return "'" . addslashes($v) . "'"; };


			// $getDOB = !empty(trim($values[14])) ? $this->normalizeDob($values[14]) : null;


	        // if( isset($studentId) && $studentId != "" ) {
	        if($values[1] == '' || $values[1] == null) {
				$row = [
				    (int)$values[0],                           // st_id
					$s($values[1]),                            // student_code
					$s($values[2]),                            // due_amount
					$s($values[3]),                            // advanced_amount
					$s($values[4]),                            // ad_payment_status
					$s($values[5]),                            // session_year_id
					$s($values[6])                             // created_date
				];

		        $valueSets[] = '(' . implode(',', $row) . ')';
		    }
	        // }
	        /*else {
	        	$notInsertDetails = [];
	        }*/

	    }
	    // pr($valueSets);
	    $columns = "st_id, student_code, due_amount, advanced_amount, ad_payment_status, session_year_id, created_date";
        

	    return "INSERT INTO student_transaction (" . trim($columns) . ") VALUES\n"
	        . implode(",\n", $valueSets) . ";";
	}

	private function parseAdminStudentDataInsert(string $sql): string
	{
	    if (!preg_match('/VALUES\s*(.+);/is', $sql, $m)) {
	        return '';
	    }

	    $records = preg_split('/\),\s*\(/', trim($m[1], '()'));
	    $valueSets = [];

	    /*INSERT INTO `admin_users` (`id`, `first_name`, `last_name`, `code`, `email`, `password`, `mobile`, `user_type`, `designation_id`, `image`, `address`, `present_address`, `pancard_number`, `aadhar_number`, `phone_no_other`, `bank_name`, `bank_acc_number`, `bank_ifsc_number`, `esic_number`, `pf_number`, `spouse_name`, `joining_date`, `subject_tought`, `class_taken`, `city`, `state`, `pincode`, `country`, `qualification`, `extra_qualification`, `experience`, `date_of_birth`, `gender`, `oasis_id`, `emaill`, `session_id`, `status`, `created_date`) VALUES*/


	    $studentModel = new StudentModel();

	    foreach ($records as $record) {

	        $values = str_getcsv($record, ',', "'", '\\');
			// pr($values);

	        if( isset($values[7]) && $values[7] == 3 ) { // Only Student
		        $d = fn($v) => (!isset($v) || trim($v) === '' || $v === '0000-00-00' || $v === '0000-00-00 00:00:00') ? "NULL" : "'" . addslashes($v) . "'";
				$s = function ($v, $prefix = '') { if (!isset($v)) return "NULL"; $v = trim($v); if ($v === '' || strtoupper($v) === 'NULL') return "NULL"; $v = $prefix . $v; return "'" . addslashes($v) . "'"; };

				$ds = function ($v, $prefix = '') { if (!isset($v)) return "NULL"; $v = trim($v); if ($v === '' || strtoupper($v) === 'NULL' || $v === '0' || $v === 0) return "NULL"; $v = $prefix . $v; return "'" . addslashes($v) . "'"; };



				// $getDOB = !empty(trim($values[14])) ? $this->normalizeDob($values[14]) : null;

				$getPassword = "'".password_hash($values[3], PASSWORD_DEFAULT, ['cost' => 8])."'";

				$row = [
				    (int)$values[0], // st_id
					$s($values[1]),  // first_name
					$s($values[2]),  // last_name
					$s($values[4]),  // email
					$getPassword,    // password ------------------------
					$s($values[6]),  // mobile
					$s($values[3]),  // code
					$ds($values[8]),  // designation_id
					$s($values[7]),  // dept_id
					10,  // session_id
					$s($values[9]),  // image
					$s($values[10]),  // address
					$s($values[11]),  // present_address
					$s($values[12]),  // pancard_number
					$s($values[13]),  // aadhar_number
					$s($values[14]),  // phone_no_other
					$s($values[15]),  // bank_name
					$s($values[16]),  // bank_acc_number
					$s($values[17]),  // bank_ifsc_number
					$s($values[18]),  // esic_number
					$s($values[19]),  // pf_number
					$s($values[20]),  // spouse_name
					$s($values[21]),  // joining_date
					$s($values[22]),  // subject_tought
					$s($values[23]),  // class_taken
					$s($values[24]),  // city
					$s($values[25]),  // state
					$s($values[26]),  // pincode
					$s($values[27]),  // country
					$s($values[28]),  // qualification
					$s($values[29]),  // extra_qualification
					$s($values[30]),  // experience
					$s($values[31]),  // date_of_birth
					$s($values[32]), // gender
					$s($values[33]), // oasis_id
					$s($values[36]), // status
					$d($values[37]), // created_date

					$d(''), // updated_at
					$d(''), // deleted_at
					$d($values[34]), // useremaill
					$s('') // user_login_session
				];

		        $valueSets[] = '(' . implode(',', $row) . ')';

		    }

	    }
	    // pr($valueSets);
	    $columns = "id, first_name, last_name, email, password, mobile, code, designation_id, dept_id, session_id, image, address, present_address, pancard_number, aadhar_number, phone_no_other, bank_name, bank_acc_number, bank_ifsc_number, esic_number, pf_number, spouse_name, joining_date, subject_tought, class_taken, city, state, pincode, country, qualification, extra_qualification, experience, date_of_birth, gender, oasis_id, status, created_date, updated_at, deleted_at, useremaill, user_login_session";
        

	    return "INSERT INTO admin_users (" . trim($columns) . ") VALUES\n"
	        . implode(",\n", $valueSets) . ";";
	}
}