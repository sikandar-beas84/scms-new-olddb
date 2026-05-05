<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
        $this->load->model('Student_model');
		date_default_timezone_set('Asia/Kolkata');

        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }


	}

	public function index(){
        
	
        $head['title'] = $data['page_title'] = 'Upload Marks';
        $data['class'] = $this->Common_model->relational_dropdown(
            'class',
            'id',
            'class_name',
            ['status' => 'Y', 'is_delete !=' => 'Y'],
            ' - '
        );
        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('result/index');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}

    public function upload() {
        // prx($_POST);
        $classSelect = post('classSelect');
        $config['upload_path'] = './assets/uploads/marks_csv/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = 2048; // 2MB max-size
    
        // Load the upload library with the config
        $this->load->library('upload', $config);
    
        // Create directory if it doesn't exist
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }
        if($classSelect){
        // Handle file upload
        if (!$this->upload->do_upload('csvFile')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('result/index');
        } else {
            $file_data = $this->upload->data();
            $file_path = './assets/uploads/marks_csv/' . $file_data['file_name'];
    
            // Open the file for reading
            if (($handle = fopen($file_path, "r")) !== FALSE) {
                $row_count = 0;  // Initialize row counter
                $success_count = 0;
                $error_count = 0;
    
                // Read through the CSV file row by row
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $row_count++;
    
                    if(post('resultType') == 'Annually'){
                    // Skip the first two rows (headers)
                    if ($row_count <= 2) {
                        continue;
                    }
                        if($classSelect == 1 || $classSelect == 2 || $classSelect == 3 || $classSelect == 4 || $classSelect == 5 || $classSelect == 6 || $classSelect == 7){
                            // Create an array for each subject to insert multiple rows for each student
                            $subjects = [
                                [
                                    'subject' => 'ENGLISH',
                                    'pt1' => $data[5],
                                    'ma' => $data[6],
                                    'pf' => $data[7],
                                    'se' => $data[8],
                                    'he' => $data[9],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'LANGUAGE II',
                                    'pt1' => $data[10],
                                    'ma' => $data[11],
                                    'pf' => $data[12],
                                    'se' => $data[13],
                                    'he' => $data[14],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'MATHEMATICS',
                                    'pt1' => $data[15],
                                    'ma' => $data[16],
                                    'pf' => $data[17],
                                    'se' => $data[18],
                                    'he' => $data[19],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'ENVIRONMENTAL SCIENCE',
                                    'pt1' => $data[20],
                                    'ma' => $data[21],
                                    'pf' => $data[22],
                                    'se' => $data[23],
                                    'he' => $data[24],
                                    'max_marks' => 100
                                ],
                              
                                [
                                    'subject' => 'COMPUTER',
                                    'he' => $data[25],
                                    'max_marks' => 40,
                                ],
                                [
                                    'subject' => 'ART EDUCATION',
                                    'he' => $data[26],
                                    'max_marks' => 40,
                                ],
                                [
                                    'subject' => 'GENERAL KNOWLEDGE',
                                    'he' => $data[27],
                                    'max_marks' => 40,
                                ],
                                [
                                    'subject' => 'PHYSICAL EDUCATION',
                                    'he' => $data[28],
                                    'max_marks' => 40,
                                ]
                            ];
                            
                        }elseif($classSelect == 9 || $classSelect == 10 || $classSelect == 11){
                            // Create an array for each subject to insert multiple rows for each student
                            $subjects = [
                                [
                                    'subject' => 'ENGLISH',
                                    'pt1' => $data[5],
                                    'ma' => $data[6],
                                    'pf' => $data[7],
                                    'se' => $data[8],
                                    'he' => $data[9],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'LANGUAGE II',
                                    'pt1' => $data[10],
                                    'ma' => $data[11],
                                    'pf' => $data[12],
                                    'se' => $data[13],
                                    'he' => $data[14]
                                ],
                                [
                                    'subject' => 'MATHEMATICS',
                                    'pt1' => $data[15],
                                    'ma' => $data[16],
                                    'pf' => $data[17],
                                    'se' => $data[18],
                                    'he' => $data[19],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'SOCIAL SCIENCE',
                                    'pt1' => $data[20],
                                    'ma' => $data[21],
                                    'pf' => $data[22],
                                    'se' => $data[23],
                                    'he' => $data[24],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'SCIENCE',
                                    'pt1' => $data[25],
                                    'ma' => $data[26],
                                    'pf' => $data[27],
                                    'se' => $data[28],
                                    'he' => $data[29],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'COMPUTER',
                                    'he' => $data[30],
                                    'max_marks' => 40,
                                ],
                                [
                                    'subject' => 'ART EDUCATION',
                                    'he' => $data[31],
                                    'max_marks' => 40
                                ],
                                [
                                    'subject' => 'LANGUAGE 3',
                                    'he' => $data[32],
                                    'max_marks' => 40,
                                ]
                            ];
                            
                        }elseif($classSelect == 12){
                            $subjects = [
                                [
                                    'subject' => 'ENGLISH',
                                    'pt1' => $data[5],
                                    'ma' => $data[6],
                                    'pf' => $data[7],
                                    'se' => $data[8],
                                    'he' => $data[9],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'LANGUAGE II',
                                    'pt1' => $data[10],
                                    'ma' => $data[11],
                                    'pf' => $data[12],
                                    'se' => $data[13],
                                    'he' => $data[14],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'MATHEMATICS',
                                    'pt1' => $data[15],
                                    'ma' => $data[16],
                                    'pf' => $data[17],
                                    'se' => $data[18],
                                    'he' => $data[19],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'SOCIAL SCIENCE',
                                    'pt1' => $data[20],
                                    'ma' => $data[21],
                                    'pf' => $data[22],
                                    'se' => $data[23],
                                    'he' => $data[24],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'SCIENCE',
                                    'pt1' => $data[25],
                                    'ma' => $data[26],
                                    'pf' => $data[27],
                                    'se' => $data[28],
                                    'he' => $data[29],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'IT',
                                    'he' => $data[30],
                                    'max_marks' => 100
                                ]
                            ];
                        }elseif($classSelect == 8){
                            $subjects = [
                                [
                                    'subject' => 'ENGLISH',
                                    'pt1' => $data[5],
                                    'ma' => $data[6],
                                    'pf' => $data[7],
                                    'se' => $data[8],
                                    'he' => $data[9],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'LANGUAGE II',
                                    'pt1' => $data[10],
                                    'ma' => $data[11],
                                    'pf' => $data[12],
                                    'se' => $data[13],
                                    'he' => $data[14],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'LANGUAGE 3',
                                    'he' => $data[15],
                                    'max_marks' => 40,
                                ],
                                [
                                    'subject' => 'MATHEMATICS',
                                    'pt1' => $data[16],
                                    'ma' => $data[17],
                                    'pf' => $data[18],
                                    'se' => $data[19],
                                    'he' => $data[20],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'ENVIRONMENTAL SCIENCE',
                                    'pt1' => $data[21],
                                    'ma' => $data[22],
                                    'pf' => $data[23],
                                    'se' => $data[24],
                                    'he' => $data[25],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'COMPUTER',
                                    'he' => $data[26],
                                    'max_marks' => 40,
                                ],
                                [
                                    'subject' => 'ART EDUCATION',
                                    'he' => $data[27],
                                    'max_marks' => 40
                                ],
                                [
                                    'subject' => 'GENERAL KNOWLEDGE',
                                    'he' => $data[28],
                                    'max_marks' => 40,
                                ],
                                [
                                    'subject' => 'PHYSICAL EDUCATION',
                                    'he' => $data[29],
                                    'max_marks' => 40,
                                ]
                            ];
                        }elseif($classSelect == 14 || $classSelect == 15){
                            $subjects = [
                                [
                                    'subject' => 'ENGLISH(CORE)',
                                    'he' => $data[4],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'LANGUAGE 2',
                                    'he' => $data[5],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'CHEMISTRY',
                                    'he' => $data[6],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'PHYSICS',
                                    'he' => $data[7],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'MATH( CORE)',
                                    'he' => $data[8],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'Applied Math',
                                    'he' => $data[9],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'BIOLOGY',
                                    'he' => $data[10],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'COMPUTER SCI',
                                    'he' => $data[11],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'PHY. EDUCATION',
                                    'he' => $data[12],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'ECONOMICS',
                                    'he' => $data[13],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'PSYCHOLOGY',
                                    'he' => $data[14],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'POLITICAL SCIENCE',
                                    'he' => $data[15],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'HISTORY',
                                    'he' => $data[16],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'GEOGRAPHY',
                                    'he' => $data[17],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'General Studies',
                                    'he' => $data[18],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'Work Experience',
                                    'he' => $data[19],
                                    'max_marks' => 100
                                ],
                                [
                                    'subject' => 'Physical & Health Education',
                                    'he' => $data[20],
                                    'max_marks' => 100
                                ],
                                
                            ];
                        }
                    
                    
                        // Insert multiple rows for each subject
                        foreach ($subjects as $subject_data) {
                            // Calculate the total marks for the subject
                            $total = 0;
                            $total += isset($subject_data['pt1']) ? $subject_data['pt1'] : 0;
                            $total += isset($subject_data['ma']) ? $subject_data['ma'] : 0;
                            $total += isset($subject_data['pf']) ? $subject_data['pf'] : 0;
                            $total += isset($subject_data['se']) ? $subject_data['se'] : 0;
                            $total += isset($subject_data['he']) ? $subject_data['he'] : 0;
                        
                            // Get the grade based on the total
                            $grade = $this->Student_model->get_grade($total, $subject_data['max_marks']);
                        
                            // Prepare the grade data array
                            $grade_data = array(
                                'session_year_id' => get_session('session'),
                                'roll_num' => $data[0],
                                'class' => $classSelect,
                                'student_code' => $data[2],
                                'student_name' => $data[3],
                                'subject' => $subject_data['subject'],
                                'pt1' => isset($subject_data['pt1']) ? $subject_data['pt1'] : NULL,
                                'ma' => isset($subject_data['ma']) ? $subject_data['ma'] : NULL,
                                'pf' => isset($subject_data['pf']) ? $subject_data['pf'] : NULL,
                                'se' => isset($subject_data['se']) ? $subject_data['se'] : NULL,
                                'he' => isset($subject_data['he']) ? $subject_data['he'] : NULL,
                                'max_marks' => $subject_data['max_marks'],
                                'grade' => $grade,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => $this->session->userdata('user_id'),
                            );
                            $checkResult = $this->Generalmodel->getDataWhere('grades',['student_code'=>$data[0], 'subject'=>$subject_data['subject'], 'session_year_id' => get_session('session')],'id','desc');
                            if(empty($checkResult)){
                            // Uncomment and modify this to insert into your database
                                $result = $this->Generalmodel->getData('grades', '', '', '', '', 'insert', $grade_data);
                            }else{
                                $result = $this->Generalmodel->getData('grades', $checkResult[0]->id, 'id', '', '', 'update', $grade_data);
                                
                            }
                           
                            if ($result) {
                                $success_count++;
                            } else {
                                $error_count++;
                            }
                        }

                    
                    }else{
                        if ($row_count <= 1) {
                            continue;
                        }
                        if($classSelect == 15){
                            $engGrade = $this->Student_model->get_grade($data[5], 40);
                            $lan2Grade = $this->Student_model->get_grade($data[6], 40);
                            $polSciGrade = $this->Student_model->get_grade($data[7], 40);
                            $geoGrade = $this->Student_model->get_grade($data[8], 40);
                            $hisGrade = $this->Student_model->get_grade($data[9], 40);
                            $PhyEduGrade = $this->Student_model->get_grade($data[10], 40);
                            $AppMathGrade = $this->Student_model->get_grade($data[11], 40);
                            $EcoGrade = $this->Student_model->get_grade($data[12], 40);
                            $subjects = [
                                [
                                    'subject' => 'ENGLISH',
                                    'marks' => $data[5],
                                    'max_marks' => 40,
                                    'grade' => $engGrade
                                ],
                                [
                                    'subject' => 'LANGUAGE II',
                                    'marks' => $data[6],
                                    'max_marks' => 40,
                                    'grade' => $lan2Grade
                                ],
                                [
                                    'subject' => 'POL SCIENCE',
                                    'marks' => $data[7],
                                    'max_marks' => 40,
                                    'grade' => $polSciGrade
                                ],
                                [
                                    'subject' => 'GEOGRAPHY',
                                    'marks' => $data[8],
                                    'max_marks' => 40,
                                    'grade' => $geoGrade
                                ],
                                [
                                    'subject' => 'HISTORY',
                                    'marks' => $data[9],
                                    'max_marks' => 40,
                                    'grade' => $hisGrade
                                ],
                                [
                                    'subject' => 'PHY EDUCATION',
                                    'marks' => $data[10],
                                    'max_marks' => 40,
                                    'grade' => $PhyEduGrade
                                ],
                                [
                                    'subject' => 'APPLIED MATH',
                                    'marks' => $data[11],
                                    'max_marks' => 40,
                                    'grade' => $AppMathGrade
                                ],
                                [
                                    'subject' => 'ECONOMICS',
                                    'marks' => $data[12],
                                    'max_marks' => 40,
                                    'grade' => $EcoGrade
                                ],
                               
                            ];
                        }elseif($classSelect == 4 || $classSelect == 5){
                            $engGrade = $this->Student_model->get_grade($data[5], 40);
                            $lan2Grade = $this->Student_model->get_grade($data[6], 40);
                            $mathGrade = $this->Student_model->get_grade($data[7], 40);

                            $subjects = [
                                [
                                    'subject' => 'ENGLISH',
                                    'marks' => $data[5],
                                    'max_marks' => 40,
                                    'grade' => $engGrade
                                ],
                                [
                                    'subject' => 'LANGUAGE II',
                                    'marks' => $data[6],
                                    'max_marks' => 40,
                                    'grade' => $lan2Grade
                                ],
                                [
                                    'subject' => 'Math',
                                    'marks' => $data[7],
                                    'max_marks' => 40,
                                    'grade' => $mathGrade
                                ],
                               
                            ];
                        }elseif($classSelect == 14){
                            $engGrade = $this->Student_model->get_grade($data[5], 40);
                            $lan2Grade = $this->Student_model->get_grade($data[6], 40);
                            $cheGrade = $this->Student_model->get_grade($data[7], 40);
                            $phyGrade = $this->Student_model->get_grade($data[8], 40);
                            $mathGrade = $this->Student_model->get_grade($data[9], 40);
                            $appMonthGrade = $this->Student_model->get_grade($data[10], 40);
                            $bioGrade = $this->Student_model->get_grade($data[11], 40);
                            $compGrade = $this->Student_model->get_grade($data[12], 40);
                            $phyEduGrade = $this->Student_model->get_grade($data[13], 40); 
                            
                            $subjects = [
                                [
                                    'subject' => 'ENGLISH',
                                    'marks' => $data[5],
                                    'max_marks' => 40,
                                    'grade' => $engGrade
                                ],
                                [
                                    'subject' => 'LANGUAGE 2',
                                    'marks' => $data[6],
                                    'max_marks' => 40,
                                    'grade' => $lan2Grade
                                ],
                                [
                                    'subject' => 'CHEMISTRY',
                                    'marks' => $data[7],
                                    'max_marks' => 40,
                                    'grade' => $cheGrade
                                ],
                                [
                                    'subject' => 'PHYSICS',
                                    'marks' => $data[8],
                                    'max_marks' => 40,
                                    'grade' => $phyGrade
                                ],
                                [
                                    'subject' => 'MATH (CORE)',
                                    'marks' => $data[9],
                                    'max_marks' => 40,
                                    'grade' => $mathGrade
                                ],
                                [
                                    'subject' => 'APPLIED MATH',
                                    'marks' => $data[10],
                                    'max_marks' => 40,
                                    'grade' => $appMonthGrade
                                ],
                                [
                                    'subject' => 'BIOLOGY',
                                    'marks' => $data[11],
                                    'max_marks' => 40,
                                    'grade' => $bioGrade
                                ],
                                [
                                    'subject' => 'COMPUTER SCIENCE',
                                    'marks' => $data[12],
                                    'max_marks' => 40,
                                    'grade' => $compGrade
                                ],
                                [
                                    'subject' => 'PHY. EDUCATION',
                                    'marks' => $data[13],
                                    'max_marks' => 40,
                                    'grade' => $phyEduGrade
                                ]
                            ];

                        }
                    }
                    
                    // Insert multiple rows for each subject
                    // prx($data);
                        foreach ($subjects as $subject_data) {
                            $grade_data = array(
                                'session_year_id' =>get_session('session'),
                                'roll_num' => $data[4],
                                'class' => $classSelect,
                                'student_code' => $data[0],
                                'student_name' => $data[1],
                                'subject' => $subject_data['subject'],
                                'marks' => isset($subject_data['marks']) ? $subject_data['marks'] : NULL,
                                'max_marks' => isset($subject_data['max_marks']) ? $subject_data['max_marks'] : NULL,
                                'grade' => isset($subject_data['grade']) ? $subject_data['grade'] : NULL,
                                'created_at' => date('Y-m-d H:i:s'),
    						    'created_by' => $this->session->userdata('user_id'),
                            );
                            // prx($grade_data);
                            $checkResult = $this->Generalmodel->getDataWhere('premid_results',['student_code'=>$data[0], 'subject'=>$subject_data['subject'], 'session_year_id' => get_session('session')],'id','desc');
                            if(empty($checkResult)){
                            // Uncomment and modify this to insert into your database
                                $result = $this->Generalmodel->getData('premid_results', '', '', '', '', 'insert', $grade_data);
                            }else{
                                $result = $this->Generalmodel->getData('premid_results', $checkResult[0]->id, 'id', '', '', 'update', $grade_data);
                                
                            }
                            if ($result) {
                                $success_count++;
                            } else {
                                $error_count++;
                            }
                        }
                }
                fclose($handle);
    
                // Delete the file after processing
                unlink($file_path);
    
                // Set success or error message
                $message = "Successfully imported {$success_count} records.";
                if ($error_count > 0) {
                    $message .= " Failed to import {$error_count} records.";
                }
                $this->session->set_flashdata('success', $message);
            } else {
                // Handle file read error
                $this->session->set_flashdata('error', 'Unable to read the CSV file.');
            }
    
            // Redirect back to the upload form
            redirect('result/index');
        }
        
        }else{
            $this->session->set_flashdata('error', 'Select Class');
            redirect('result/index');
        }
    }
    
    
    
}
?>
