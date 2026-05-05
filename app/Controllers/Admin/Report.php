<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\StudentModel;
use App\Models\SubjectMasterModel;
use App\Models\RegistrationFeesModel;
use App\Models\AdminUserModel;
use App\Models\ItemMasterModel;
use App\Models\StudentDetailsModel;
use App\Models\StudentTblcItemsModel;
use App\Models\TblcMasterModel;
use App\Models\StudentStationaryItemsModel;
use App\Models\StudentFeeStructureModel;


class Report extends BaseController
{
	public function index()
    {
        $data['title'] = "Report";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $data['class'] = $classModel->orderBy('id', 'ASC')->findAll();

        echo view('admin/report/index', $data);        
        echo view('admin/common/footer', $data);
    }
    function form_selling_report()
    {
        $data['title'] = "Form Selling Report";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        $adminUserModel = new AdminUserModel();
        $data['user_lists'] = $adminUserModel
                ->where('dept_id', 1)
                ->where('status', true)
                ->findAll();

        echo view('admin/report/form-selling-report', $data);        
        echo view('admin/common/footer', $data);
    }

    function ajax_request_form_selling_report()
    {
        $studentModel = new StudentModel();
        $classModel = new ClassModel();

        $class_id = $this->request->getPost('class_id') ?? '';
        $payment_mode = $this->request->getPost('payment_mode') ?? '';
        $user_id = $this->request->getPost('user_id') ?? '';
        $start_date = $this->request->getPost('start_date') ?? '';
        $end_date = $this->request->getPost('end_date') ?? '';



        /*if( !isset($class_id) || $class_id == '' ) {
            return $this->response->setJSON(['student_list' => [], 'class_list' => []]);
        }*/
        if( $start_date == '' || $end_date == '' ) {
            return $this->response->setJSON(['student_list' => [], 'class_list' => []]);
        }

        $get_session_year_id = $this->session->get('session_year_id');

        $student_list = $studentModel->form_selling_report($class_id, $payment_mode, $start_date, $end_date, $user_id, $get_session_year_id);
        // pr($student_list);
        $class_list = $classModel->orderBy('id', 'ASC')->findAll();

        return $this->response->setJSON(['student_list' => $student_list, 'class_list' => $class_list]);
    }

    function daily_collection_report()
    {
        $data['title'] = "Daily Collection Report";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        echo view('admin/report/daily-collection-report', $data);        
        echo view('admin/common/footer', $data);
    }

    function ajax_request_daily_collection_report()
    {
        $get_filter_date = $this->request->getPost('get_filter_date');
        if( !isset($get_filter_date) || $get_filter_date == '' ) {
            return $this->response->setJSON([ 'collection_details' => [] ]);
        }

        $registrationFeesModel = new RegistrationFeesModel();
        $collection_details = $registrationFeesModel->getPaymentsWithStudentFromDate($get_filter_date);

        return $this->response->setJSON(['collection_details' => $collection_details]);
    }

    function form_submission_report()
    {
        $data['title'] = "Form Submission Report";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        echo view('admin/report/form-submission-report', $data);        
        echo view('admin/common/footer', $data);
    }

    function not_admitted_report()
    {
        $data['title'] = "Not Admitted Report";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        echo view('admin/report/not-admitted-report', $data);        
        echo view('admin/common/footer', $data);
    }

    function ajax_request_form_submission_report()
    {
        $studentModel = new StudentModel();
        $studentDetailsModel = new StudentDetailsModel();
        $classModel = new ClassModel();

        $class_id = $this->request->getPost('class_id') ?? '';
        $ad_exam_qualified = $this->request->getPost('ad_exam_qualified') ?? '';
        $start_date = $this->request->getPost('start_date') ?? '';
        $end_date = $this->request->getPost('end_date') ?? '';

        $student_list = [];
        if( $class_id != '' || $ad_exam_qualified != '' || ($start_date != '' && $end_date !='') ) {
            $student_list = $studentDetailsModel->get_form_submission_report($class_id, $ad_exam_qualified, $start_date, $end_date);
        }
        
        $class_list = $classModel->orderBy('id', 'ASC')->findAll();

        return $this->response->setJSON(['student_list' => $student_list, 'class_list' => $class_list]);
    }

    function ajax_request_not_admitted_report()
    {
        // 'ad_exam_qualified' => 4,  // 0-Fail, 1-Pass, 2-Not Appeared, 3-Submitted, 4- Not Submitted, 5 - Reject
        // 0-1-2

        $studentModel = new StudentModel();
        $studentDetailsModel = new StudentDetailsModel();
        $classModel = new ClassModel();

        $class_id = $this->request->getPost('class_id') ?? '';
        $ad_exam_qualified = $this->request->getPost('ad_exam_qualified') ?? 1;
        $admitted_status = $this->request->getPost('admitted_status') ?? 0;
        $start_date = $this->request->getPost('start_date') ?? '';
        $end_date = $this->request->getPost('end_date') ?? '';

        $student_list = [];
        if( $class_id != '' ) {
            $student_list = $studentDetailsModel->get_form_not_admitted_report($class_id, $ad_exam_qualified, $start_date, $end_date, $admitted_status);
        }
        // pr($student_list);
        $class_list = $classModel->orderBy('id', 'ASC')->findAll();

        return $this->response->setJSON(['student_list' => $student_list, 'class_list' => $class_list]);
    }

    function daily_academic_fees_collection_report()
    {
        $data['title'] = "Daily Academic Fees Collection Report";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        $adminUserModel = new AdminUserModel();
        $data['user_lists'] = $adminUserModel
                ->where('dept_id', 1)
                ->where('status', true)
                ->findAll();

        echo view('admin/report/daily-academic-fees-collection-report', $data);        
        echo view('admin/common/footer', $data);
    }


    function ajax_request_daily_academic_fees_collection_report()
    {
        /*$get_filter_date = $this->request->getPost('get_filter_date');
        if( !isset($get_filter_date) || $get_filter_date == '' ) {
            return $this->response->setJSON([ 'collection_details' => [] ]);
        }*/

        $start_date = $this->request->getPost('start_date') ?? '';
        $end_date = $this->request->getPost('end_date') ?? '';

        $class_id = $this->request->getPost('class_id') ?? '';
        $user_id = $this->request->getPost('user_id') ?? '';
        $payment_mode = $this->request->getPost('payment_mode') ?? '';
        $payment_month = $this->request->getPost('payment_month') ?? '';
        $student_code = $this->request->getPost('student_code') ?? '';
        $bus_user_id = $this->request->getPost('bus_user_id') ?? '';
        $date_filter_used = $this->request->getPost('date_filter_used') ?? 1;

        $collection_details =  [];
        if( !empty($start_date) && !empty($end_date) ) {
            $registrationFeesModel = new RegistrationFeesModel();
            $collection_details = $registrationFeesModel->getAcademicPaymentsByDate($start_date, $end_date, $class_id, $user_id, $payment_mode, $payment_month, $student_code, $bus_user_id, $date_filter_used);
        }

        return $this->response->setJSON(['collection_details' => $collection_details]);
    }

    function admitted_report()
    {
        $data['title'] = "Admitted Report";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        echo view('admin/report/admitted-report', $data);        
        echo view('admin/common/footer', $data);
    }

    function ajax_request_admitted_report()
    {
        // 'ad_exam_qualified' => 4,  // 0-Fail, 1-Pass, 2-Not Appeared, 3-Submitted, 4- Not Submitted, 5 - Reject
        // 0-1-2

        $studentModel = new StudentModel();
        $studentDetailsModel = new StudentDetailsModel();
        $classModel = new ClassModel();

        $class_id = $this->request->getPost('class_id') ?? '';
        $ad_exam_qualified = $this->request->getPost('ad_exam_qualified') ?? 1;
        $start_date = $this->request->getPost('start_date') ?? '';
        $end_date = $this->request->getPost('end_date') ?? '';

        $student_list = [];
        if( $class_id != '' ) {
            // $student_list = $studentDetailsModel->get_form_admitted_report($class_id, $ad_exam_qualified, $start_date, $end_date); // Off 2026-03-24
            $student_list = $studentDetailsModel->get_student_admitted_report($class_id, $ad_exam_qualified, $start_date, $end_date);
        }
        // pr($student_list);
        $class_list = $classModel->orderBy('id', 'ASC')->findAll();

        return $this->response->setJSON(['student_list' => $student_list, 'class_list' => $class_list]);
    }

    function tblc_report()
    {
        $data['title'] = "TBLC Report";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        $adminUserModel = new AdminUserModel();
        $data['user_lists'] = $adminUserModel
                ->where('dept_id', 1)
                ->where('status', true)
                ->findAll();


        // 🔹 Read POST filters (safe for GET also)
        $get_filter_date = $this->request->getPost('get_filter_date') ?? '';

        $start_date = '';
        $end_date   = '';

        if (!empty($get_filter_date) && str_contains($get_filter_date, ' to ')) {
            [$start_date, $end_date] = array_map('trim', explode(' to ', $get_filter_date));
        }
        $class_id      = $this->request->getPost('class_id') ?? '';
        $user_id       = $this->request->getPost('user_id') ?? '';
        $payment_mode  = $this->request->getPost('payment_mode') ?? '';
        $payment_month = $this->request->getPost('payment_month') ?? '';
        $student_code  = $this->request->getPost('student_code') ?? '';


        $data['tblc_lists'] = [];

        if( $class_id != '' ) {
            $tblcMasterModel = new TblcMasterModel();
            $data['tblc_lists'] = $tblcMasterModel
                ->where('session_year_id', $this->session->get('session_year_id'))
                ->where('sec_lang', 'Bengali')
                ->where('class_id', $class_id)
                ->orderBy('id', 'DESC')
                ->findAll();
        }

        // 🔹 Default empty result
        $data['collection_details'] = [];

        // 🔹 Fetch data only when date range exists
        if (!empty($start_date) && !empty($end_date)) {

            $studentTblcItemsModel = new StudentTblcItemsModel();

            $data['collection_details'] = $studentTblcItemsModel->getAcademicTblcReports(
                $start_date,
                $end_date,
                $class_id,
                $user_id,
                $payment_mode,
                $payment_month,
                $student_code
            );
        }

        // 🔹 Keep filter values (important for UI retain)
        $data['filters'] = [
            'start_date'    => $start_date,
            'end_date'      => $end_date,
            'class_id'      => $class_id,
            'user_id'       => $user_id,
            'payment_mode'  => $payment_mode,
            'student_code'  => $student_code,
        ];

        echo view('admin/report/tblc-report', $data);        
        echo view('admin/common/footer', $data);
    }

    function ajax_request_tblc_report()
    {
        $start_date = $this->request->getPost('start_date') ?? '';
        $end_date = $this->request->getPost('end_date') ?? '';

        $class_id = $this->request->getPost('class_id') ?? '';
        $user_id = $this->request->getPost('user_id') ?? '';
        $payment_mode = $this->request->getPost('payment_mode') ?? '';
        $payment_month = $this->request->getPost('payment_month') ?? '';
        $student_code = $this->request->getPost('student_code') ?? '';

        $collection_details =  [];
        if( !empty($start_date) && !empty($end_date) ) {
            $studentTblcItemsModel = new StudentTblcItemsModel();
            $collection_details = $studentTblcItemsModel->getAcademicTblcReports($start_date, $end_date, $class_id, $user_id, $payment_mode, $payment_month, $student_code);
        }

        return $this->response->setJSON(['collection_details' => $collection_details]);
    }

    function pass_fail_report()
    {
        $data['title'] = "Pass, Fail, Not Appeared Report";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        echo view('admin/report/pass-fail', $data);        
        echo view('admin/common/footer', $data);
    }

    function ajax_request_pass_fail_report()
    {
        $studentModel = new StudentModel();
        $studentDetailsModel = new StudentDetailsModel();
        $classModel = new ClassModel();

        $class_id = $this->request->getPost('class_id') ?? '';
        $ad_exam_qualified = $this->request->getPost('ad_exam_qualified') ?? 1;

        $student_list = [];
        if( $class_id != '' ) {
            $student_list = $studentDetailsModel->get_form_pass_fail_report($class_id, $ad_exam_qualified);
        }
        // pr($student_list);
        $class_list = $classModel->orderBy('id', 'ASC')->findAll();

        return $this->response->setJSON(['student_list' => $student_list, 'class_list' => $class_list]);
    }

    public function dailyStationarySalesReport()
    {
        $data['title'] = "Daily Stationary Sales Report";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        $adminUserModel = new AdminUserModel();
        $data['user_lists'] = $adminUserModel->where('dept_id', 1)->where('status', true)->findAll();

        echo view('admin/report/daily-stationary-report', $data);        
        echo view('admin/common/footer', $data);
    }

    public function ajaxDailyStationarySalesReport()
    {
        // pr($this->request->getPost());
        $data['title'] = "Daily Stationary Sales Report";
        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        $adminUserModel = new AdminUserModel();
        $data['user_lists'] = $adminUserModel->where('dept_id', 1)->where('status', true)->findAll();

        $from_date = $this->request->getPost('get_from_date') ?? '';
        $to_date = $this->request->getPost('get_to_date') ?? '';

        $class_id = $this->request->getPost('class_id') ?? '';
        $lang = $this->request->getPost('lang') ?? '';
        $t_user_id = $this->request->getPost('t_user_id') ?? '';
        $payment_mode = $this->request->getPost('payment_mode') ?? '';
        $pos_bank_name = $this->request->getPost('pos_bank_name') ?? '';

        if( $payment_mode == '' ) {
            return $this->response->setJSON(['stationary_sales_details' => []]);
        }
        $data['stationary_lists'] = [];

        if( $class_id != '' ) {
            $item_master = new ItemMasterModel();
            $data['stationary_lists'] = $item_master
                ->where('session_year_id', $this->session->get('session_year_id'));
                if ($lang != '') {
                    $data['stationary_lists'] = $data['stationary_lists']->where('sec_lang', $lang);
                }
                
            $data['stationary_lists'] = $data['stationary_lists']->where('class_id', $class_id)
                ->where('status', 1)
                ->orderBy('id', 'ASC')
                ->findAll();
        }

        $stationary_sales_details =  [];

        // $data['stationary_lists'] = $studentStationaryItemsModel->dailyStationarySalesReport($class_id, $from_date, $to_date, $payment_mode, $t_user_id, $lang, $pos_bank_name);
        $studentStationaryItemsModel = new StudentStationaryItemsModel();
        $data['stationary_sales_details'] = $studentStationaryItemsModel->dailyStationarySalesReport($class_id, $from_date, $to_date, $payment_mode, $t_user_id, $lang, $pos_bank_name);
        // 🔹 Keep filter values (important for UI retain)
        $data['filters'] = [
            'from_date'    => $from_date,
            'to_date'      => $to_date,
            'class_id'      => $class_id,
            'lang'       => $lang,
            't_user_id'  => $t_user_id,
            'payment_mode'  => $payment_mode,
            'pos_bank_name'  => $pos_bank_name,
        ];
        // echo"<pre>"; print_r($data['stationary_lists']);exit;
        echo view('admin/report/daily-stationary-report', $data);        
        echo view('admin/common/footer', $data);
        // return $this->response->setJSON(['stationary_sales_details' => $data]);
    }

    public function dailyBusPaymentReport()
    {
        $data['title'] = "Daily Bus Payment Report";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $adminUserModel = new AdminUserModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();

        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();
        $data['user_lists'] = $adminUserModel->where('dept_id', 1)->where('status', true)->findAll();

        $bus_payment_details =  [];
        $from_date = '';
        $to_date = '';
        $class_id = '';
        $student_code = '';
        $t_user_id = '';
        $payment_mode = '';
        
        if ($this->request->getMethod() === 'POST') {
            $from_date = $this->request->getPost('from_date') ?? '';
            $to_date = $this->request->getPost('to_date') ?? '';

            $class_id = $this->request->getPost('class_id') ?? '';
            $student_code = $this->request->getPost('student_code') ?? '';
            $t_user_id = $this->request->getPost('t_user_id') ?? '';
            $payment_mode = $this->request->getPost('payment_mode') ?? '';

            $bus_payment_details = $studentFeeStructureModel->dailyBusPaymentReport($class_id, $from_date, $to_date, $payment_mode, $t_user_id, $student_code);
        }

        $data['bus_payment_details'] = $bus_payment_details;

        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['class_id'] = $class_id;
        $data['student_code'] = $student_code;
        $data['t_user_id'] = $t_user_id;
        $data['payment_mode'] = $payment_mode;

        echo view('admin/report/daily-bus-payment-report', $data);        
        echo view('admin/common/footer', $data);
    }

    public function busPaidReport()
    {
        $data['title'] = "Bus Paid Report";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $studentFeeStructureModel = new StudentFeeStructureModel();

        $bus_payment_details =  [];
        $from_date = '';
        $to_date = '';
        
        if ($this->request->getMethod() === 'POST') {
            $from_date = $this->request->getPost('from_date') ?? '';
            $to_date = $this->request->getPost('to_date') ?? '';

            $bus_payment_details = $studentFeeStructureModel->busPaidReport($from_date, $to_date);
        }

        $data['bus_payment_details'] = $bus_payment_details;

        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;

        echo view('admin/report/bus-paid-report', $data);        
        echo view('admin/common/footer', $data);
    }

    public function ajaxDailyBusPaymentReport()
    {
        $from_date = $this->request->getPost('from_date') ?? '';
        $to_date = $this->request->getPost('to_date') ?? '';

        $class_id = $this->request->getPost('class_id') ?? '';
        $student_code = $this->request->getPost('student_code') ?? '';
        $t_user_id = $this->request->getPost('t_user_id') ?? '';
        $payment_mode = $this->request->getPost('payment_mode') ?? '';

        if( $payment_mode == '' ) {
            return $this->response->setJSON(['bus_payment_details' => []]);
        }

        $bus_payment_details =  [];

        /*$studentFeeStructureModel = new StudentFeeStructureModel();
        $bus_payment_details = $studentFeeStructureModel->dailyBusPaymentReport($class_id, $from_date, $to_date, $payment_mode, $t_user_id, $student_code);*/

        return $this->response->setJSON(['bus_payment_details' => $bus_payment_details]);
    }

    public function daily_bus_payment_report()
    {
        $from_date = $this->request->getPost('from_date') ?? '';
        $to_date = $this->request->getPost('to_date') ?? '';

        $class_id = $this->request->getPost('class_id') ?? '';
        $student_code = $this->request->getPost('student_code') ?? '';
        $t_user_id = $this->request->getPost('t_user_id') ?? '';
        $payment_mode = $this->request->getPost('payment_mode') ?? '';

        if( $payment_mode == '' ) {
            return $this->response->setJSON(['bus_payment_details' => []]);
        }

        $bus_payment_details =  [];

        $studentFeeStructureModel = new StudentFeeStructureModel();
        $bus_payment_details = $studentFeeStructureModel->dailyBusPaymentReport($class_id, $from_date, $to_date, $payment_mode, $t_user_id, $student_code);

        return $bus_payment_details;

        // return $this->response->setJSON(['bus_payment_details' => $bus_payment_details]);
    }
}