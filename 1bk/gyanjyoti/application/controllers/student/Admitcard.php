<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Admitcard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
        $this->load->model('Student_model');
        $this->load->model('Generalmodel');
		date_default_timezone_set('Asia/Kolkata');
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }
	}
	
	public function index(){
        $data['class'] = $this->Common_model->relational_dropdown(
            'class',
            'id',
            'class_name',
            ['status' => 'Y', 'is_delete !=' => 'Y'],
            ' - '
        );
        $data['exam_type'] = $this->Common_model->select('exam_type_master');
        // prx($data);
        $head['title'] = $data['page_title'] ='Admit Card';
        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('student/admitcard');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}

    public function get_student_admitcard() {  
        $session_year_id = get_session('session');  
        $exam_type=post('examType');
        $class_id=post('classId');
        // $section_id=post('sectionId');
        $student_id=post('studentId');
        $where['session_id'] = $session_year_id;
        if($student_id):
            $where['student_code'] = $student_id;
        endif;
        if($section_id):
            $where['section'] = $section_id;
        endif;
        if($class_id):
            $where['class'] = $class_id;
        endif;
        $data['student_list'] = $this->Generalmodel->getDataWhere('students_details', $where);
        // prx($this->input->post());
        $data['exam_type'] = $exam_type;
        $html = $this->load->view('student/admit_card', $data, true);
        // prx($html);



        // ============================================================

            // ini_set('memory_limit', '512M');
            // $this->load->library('m_pdf');
            // $pdfFilePath = $class_id."-ID-Card.pdf";
            
            // //actually, you can pass mPDF parameter on this load() function
            // $pdf = $this->m_pdf->load();
            // $pdf->WriteHTML($html,2);
            // prx($pdf);
            // //offer it to user via browser download! (The PDF won't be saved on your server HDD)
            // $pdf->Output($pdfFilePath, "D");
            
            // exit();
        // ===========================================================




        $result = ['html' => $html, 'message' => '', 'status' => 'success'];
        echo json_encode($result);
    }
	
    public function generate_pdf() {
        // Load the library
        $this->load->library('Mpdf_lib');

        // HTML content for PDF
        $html = '<h1>Hello, this is a PDF</h1>';
        
        // Load the HTML into mPDF
        $this->mpdf_lib->loadHtml($html);

        // Output the PDF (I = inline, D = Download, F = Save to server)
        $this->mpdf_lib->output('sample.pdf', 'I');
    }
}