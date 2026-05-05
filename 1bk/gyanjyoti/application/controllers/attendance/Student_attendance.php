<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_attendance extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
        $this->load->model('Attendance_model');
        $this->load->model('Student_model');
		date_default_timezone_set('Asia/Kolkata');
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }

	}

	public function index(){
        $head['title'] = $data['page_title'] = 'Student Attendance';
        $session_date = $this->Generalmodel->getDataWhere('session',['id'=>get_session('session')]);
        // prx($this->session->userdata());
        $startDate = new DateTime($session_date[0]->start_date);
		$endDate = new DateTime($session_date[0]->end_date);
		$periodInt = new DateInterval( "P1M" );
		$period = new DatePeriod( $startDate, $periodInt, $endDate );
		foreach ($period as $key => $value) {
			$dateObj	= DateTime::createFromFormat('!m', $value->format('m'));
			$month[$value->format('m')] = $dateObj->format('F');
			$year[$value->format('Y')] = $value->format('Y');
		}
		$data['month'] = $month;
		$data['year'] = $year;
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
		$this->load->view('attendance/index');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}


	


// ************************************************



        public function ajax_get_students_attendance() {
            // Get all holidays
            $holidays = $this->Common_model->get_holiday_list();
            $hdates = array_map('trim', array_filter(explode(',', $holidays->dates)));
        
            $class_id = $this->input->post('classId');
            $section_id = $this->input->post('sectionId');
            $month = $this->input->post('month');
            $year = $this->input->post('year');
            $student_id = $this->input->post('student_id');
        
            $workdays = [];
            $present = [];
            $type = CAL_GREGORIAN;
            $day_count = cal_days_in_month($type, $month, $year); // Get the number of days
        
            // Loop through all days
            for ($k = 1; $k <= $day_count; $k++) {
                $date = sprintf('%04d-%02d-%02d', $year, $month, $k);
                $day_name = date('D', strtotime($date)); // Get short weekday name
        
                // If not a weekend and not a holiday, add to workdays
                if ($day_name != 'Sun' && $day_name != 'Sat' && !in_array($date, $hdates)) { 
                    $workdays[] = $k;
                }
            }
        
            $workingDay = count($workdays);
            $monthName = DateTime::createFromFormat('!m', $month)->format('F');
        
            // Check if a specific student was requested
            if ($student_id != '') {
                $student_attendance = $this->Attendance_model->ajax_student_attendance_view($class_id, $section_id, $month, $student_id);
                
                $days = [];
        
                foreach ($student_attendance as $attendance) {
                    $day = explode('-', $attendance->date);
                    $days[$day[2]] = $attendance;
                }
        
                if (!empty($student_attendance)) {
                    $student_data = $this->Student_model->get_students_details_by_code(post('student_id'));
                    // prx($student_data);
                    $html = '<table id="simple-table" class="table table-bordered table-hover"> 
                        <thead style="background: #243448;">
                            <tr>
                                <th rowspan="2">Roll No</th>
                                <th rowspan="2">Name</th>
                                <th colspan="61">' . $monthName . '</th>
                            </tr>
                            <tr>';
        
                    for ($j = 1; $j <= $day_count; $j++) {
                        $date = sprintf('%04d-%02d-%02d', $year, $month, $j);
                        $day_name = date('D', strtotime($date));
        
                        $class = ($day_name == 'Sat' || $day_name == 'Sun' || in_array($date, $hdates)) ? 'red' : '';
                        $html .= '<th><center class="' . $class . '">' . $j . '<br>' . substr($day_name, 0, 1) . '</center></th>';
                    }
        
                    $html .= '</tr></thead><tbody>';
                    $html .= '<tr><td>' . $student_data->roll . '</td><td>' . ucwords($student_data->student_name) . '</td>';
        
                    for ($i = 1; $i <= $day_count; $i++) {
                        if (isset($days[sprintf("%02s", $i)])) {
                            $attendance = $days[sprintf("%02s", $i)];
                            $present[] = ($attendance->attendance == 'P') ? $i : null; // Count presents
        
                            $html .= '<td align="center">
                                <table>
                                    <tr>
                                        <td style="border-bottom: 1px solid #ddd;">' .
                                            ($attendance->attendance == 'P' ? '<i class="ace-icon fa fa-check green"></i><b class="green">P</b>' : '<i class="ace-icon fa fa-close red"></i><b class="red">A</b>') . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>' . ($attendance->fullday == 'F' ? '<i class="ace-icon fa fa-check"></i>F' : '<span title="' . $attendance->comments . '" data-html="true" data-toggle="tooltip" rel="tooltip"><i class="ace-icon fa fa-check"></i>H</span>') . '</td>
                                    </tr>
                                </table>
                            </td>';
                        } else {
                            $html .= '<td align="center"><table><tr><td style="border-bottom: 1px solid #ddd;"></td></tr><tr><td></td></tr></table></td>';
                        }
                    }
                    $html .= '</tr>';
                    $html .= '<tr>
                                <td colspan="' . ($day_count + 2) . '">
                                    <div class="alert alert-info">Total Present : ' . count(array_filter($present)) . '</div>
                                </td>
                            </tr>';
                    $html .= '</tbody></table>';
                } else {
                    $html = '<table><tr><td colspan="6"><div class="alert alert-danger">No result found!</div></td></tr></table>';
                }
            } else {
                $session_year_id = get_session('session');
                $results = $this->Attendance_model->ajax_student_attendance_view($class_id, $section_id, $month, $student_id);
                // prx($results);
                $html = '<table>
                            <tr>
                                <td colspan="6">
                                    <div class="alert alert-warning">No of Working Days : ' . $workingDay . '</div>
                                </td>				
                            </tr>
                        </table>';
                
                foreach ($results as $result) {
                    $student_data = $this->Student_model->get_students_details($result->id);
                    $student_attendance = $this->db->where('MONTH(date)', $month)
                                                    ->where('YEAR(date)', $year)
                                                    ->where('student_id', $result->id)
                                                    ->where('session_year_id', $session_year_id)
                                                    ->order_by('date', 'asc')
                                                    ->get('student_attendance')
                                                    ->result();
                                                    // prx($this->db->last_query());
        
                    $days = [];
                    foreach ($student_attendance as $attendance) {
                        $day = explode('-', $attendance->date);
                        $days[$day[2]] = $attendance;
                    }
        
                    $html .= '<table id="simple-table" class="table table-bordered table-hover"> 
                        <thead style="background: #243448;">
                            <tr >
                                <th rowspan="2">Roll No</th>
                                <th rowspan="2" width="200px">Name</th>
                                <th colspan="61">' . $monthName . '</th>
                            </tr>
                            <tr>';
        
                    for ($j = 1; $j <= $day_count; $j++) {
                        $date = sprintf('%04d-%02d-%02d', $year, $month, $j);
                        $day_name = date('D', strtotime($date));
                        $class = ($day_name == 'Sat' || $day_name == 'Sun' || in_array($date, $hdates)) ? 'red' : '';
                        $html .= '<th><center class="' . $class . '">' . $j . '<br>' . substr($day_name, 0, 1) . '</center></th>';
                    }
        
                    $html .= '</tr></thead><tbody>';
                    $html .= '<tr><td>' . $student_data->roll . '</td><td>' . ucwords($student_data->student_name) . '</td>';
        
                    for ($i = 1; $i <= $day_count; $i++) {
                        if (isset($days[sprintf("%02s", $i)])) {
                            $attendance = $days[sprintf("%02s", $i)];
                            $present[] = ($attendance->attendance == 'P') ? $i : null;
        
                            $html .= '<td align="center">
                                <table>
                                    <tr>
                                        <td style="border-bottom: 1px solid #ddd;">' .
                                            ($attendance->attendance == 'P' ? '<i class="ace-icon fa fa-check"></i>P' : '<i class="ace-icon fa fa-close red"></i><b class="red">A</b>') . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>' . ($attendance->fullday == 'F' ? '<i class="ace-icon fa fa-check"></i>F' : '<span title="' . $attendance->comments . '" data-html="true" data-toggle="tooltip" rel="tooltip"><i class="ace-icon fa fa-check"></i>H</span>') . '</td>
                                    </tr>
                                </table>
                            </td>';
                        } else {
                            $html .= '<td align="center"><table><tr><td style="border-bottom: 1px solid #ddd;"></td></tr><tr><td></td></tr></table></td>';
                        }
                    }
                    $html .= '</tr>';
                    $html .= '<tr>
                                <td colspan="' . ($day_count + 2) . '">
                                    <div class="alert alert-info">Total Present : ' . count(array_filter($present)) . '</div>
                                </td>
                            </tr>';
                    $html .= '</tbody></table>';
                }
            }
            $data["html"] = $html;
            echo json_encode($data); 
            // echo $html;
        }
        
}
?>