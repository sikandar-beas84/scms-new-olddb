<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('registration', 'Home::registration');
$routes->post('save-registration', 'Home::save_registration');
$routes->post('get-age-limit', 'Home::get_age_limit');
$routes->post('get-class-subjects', 'Home::get_class_subjects');

$routes->get('payRegFee/(:any)', 'Home::pay_registration_fee/$1');


// $routes->get('writable/uploads/(:segment)/(:any)', 'Files::file/$1/$2');



$routes->get('/login', 'Admin\Login::index');
$routes->post('auth', 'Admin\Login::auth');

$routes->get('forgot-password', 'Admin\AuthController::forgotPassword');
$routes->post('process-forgot-password', 'Admin\AuthController::processForgotPassword');
$routes->get('reset-password/(:any)', 'Admin\AuthController::resetPassword/$1');
$routes->post('process-reset-password', 'Admin\AuthController::processResetPassword');

$routes->get('student-set-password/(:any)', 'Admin\AuthController::studentSetPassword/$1');
$routes->post('set-student-password', 'Admin\AuthController::setStudentPassword');



$routes->group('', ['filter' => 'timeout'], function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index'); // Admin
    $routes->get('dashboardteacher', 'Admin\Dashboard::teacher_dashboard'); // Teacher
    $routes->get('dashboardstudent', 'Admin\Dashboard::student_dashboard'); // Student
    $routes->get('dashboardnonteaching', 'Admin\Dashboard::nonteaching_dashboard'); // Non Teaching
    $routes->get('dashboardgroupd', 'Admin\Dashboard::groupd_dashboard'); // Group D
    $routes->get('dashboardprincipal', 'Admin\Dashboard::principal_dashboard'); // Principal
    $routes->get('dashboardvendor', 'Admin\Dashboard::vendor_dashboard'); // Vendor

    $routes->get('generate-password', 'Admin\Dashboard::generate_password'); // Admin
    $routes->post('get-encrypt-password', 'Admin\Dashboard::get_encrypt_password');
    
});

$routes->get('/logout', 'Admin\Login::logout');
$routes->get('/student/response', 'Admin\Student::online_payment_response');


$routes->group('admin',  ['filter' => 'timeout'], function($routes) {
    $routes->group('designation', function ($routes) {
        $routes->get('/', 'Admin\Designation::index');
    });

	$routes->group('age-calculator', function ($routes) {
        $routes->get('/', 'Admin\AgeCalculator::index');
        $routes->post('calculate-age-class', 'Admin\AgeCalculator::ajax_calculate_age_class');
    });

    $routes->group('session', function ($routes) {
        $routes->get('/', 'Admin\SessionYear::index');
        $routes->post('fetch', 'Admin\SessionYear::fetch');
        $routes->post('set-current', 'Admin\SessionYear::setCurrentSession');
        $routes->post('get-session', 'Admin\SessionYear::get_session');
        $routes->post('save', 'Admin\SessionYear::store');
        $routes->post('change-session', 'Admin\SessionYear::change_current_session');
    });

    $routes->group('stoppage', function ($routes) {
        $routes->get('/', 'Admin\Stoppage::index');
        $routes->post('fetch', 'Admin\Stoppage::fetch');
        $routes->post('get-stoppage', 'Admin\Stoppage::get_stoppage');
        $routes->post('save', 'Admin\Stoppage::store');
        $routes->get('delete/(:num)', 'Admin\Stoppage::delete/$1');
    });

    $routes->group('bus', function ($routes) {
        $routes->get('/', 'Admin\Bus::index');
        $routes->get('add', 'Admin\Bus::add');
        $routes->post('save', 'Admin\Bus::save');
        $routes->get('edit-bus/(:num)', 'Admin\Bus::edit/$1');
        $routes->post('update/(:num)', 'Admin\Bus::update/$1');
        $routes->get('delete/(:num)', 'Admin\Bus::delete/$1');
        $routes->post('get-bus', 'Admin\Bus::ajax_get_bus');

        $routes->get('students-bus-csv', 'Admin\Bus::students_bus_csv');
        $routes->post('students-bus-csv-save', 'Admin\Bus::studentsBusCsvSaveAjax');
    });

    $routes->group('section', function ($routes) {
        $routes->get('/', 'Admin\Section::index');
        $routes->post('fetch', 'Admin\Section::fetch');
        $routes->post('get-section', 'Admin\Section::get_section');
        $routes->post('save', 'Admin\Section::store');
        $routes->get('delete/(:num)', 'Admin\Section::delete/$1');
    });

    $routes->group('staff-management', function ($routes) {
        $routes->get('designation', 'Admin\StaffManagement::index');
        $routes->post('fetch-designation', 'Admin\StaffManagement::fetch_designation');
        $routes->post('get-designation', 'Admin\StaffManagement::get_designation');
        $routes->post('save-designation', 'Admin\StaffManagement::save_designation');
        $routes->post('change-designation-status', 'Admin\StaffManagement::change_designation_status');
        
        $routes->get('admin-members', 'Admin\StaffManagement::admin_members');
        $routes->post('admin-members/fetch', 'Admin\StaffManagement::fetch_admin_members');
        $routes->get('admin-members/add', 'Admin\StaffManagement::add_admin_members');
        $routes->post('admin-members/store', 'Admin\StaffManagement::save_admin_members');
        $routes->post('admin-members/set-current-status', 'Admin\StaffManagement::setCurrentStatus');
        $routes->get('admin-members/edit/(:num)', 'Admin\StaffManagement::edit_admin_members/$1');
        $routes->post('admin-members/update/(:num)', 'Admin\StaffManagement::update_admin_member/$1');
        $routes->delete('admin-members/delete/(:num)', 'Admin\StaffManagement::delete_admin_member/$1');

        $routes->get('generate-staff-card', 'Admin\StaffManagement::generate_staff_card');
    });

    $routes->group('manage-class', function ($routes) {
        $routes->get('classes', 'Admin\Classes::index');
        $routes->post('fetch', 'Admin\Classes::fetch_classes');
        $routes->post('get-class', 'Admin\Classes::get_class');
        $routes->post('save-class', 'Admin\Classes::update_class');

        $routes->get('assign-sub-to-class', 'Admin\Classes::assign_sub_to_class');
        $routes->post('ajax-save-assign-sub-to-class', 'Admin\Classes::save_assign_sub_to_class');
    });

    $routes->group('menu-permission', function ($routes) {
        $routes->get('', 'Admin\MenuUserPermissions::index');
        $routes->post('fetch', 'Admin\MenuUserPermissions::fetch');
        $routes->post('save', 'Admin\MenuUserPermissions::store');
        $routes->post('get-menu-permission', 'Admin\MenuUserPermissions::get_menu_permissions');
        $routes->post('set-menu-view', 'Admin\MenuUserPermissions::setMenuView');

        $routes->get('newpermission', 'Admin\MenuUserPermissions::newpermission');
        $routes->post('get', 'Admin\MenuUserPermissions::getUserPermissions');
        $routes->post('new-save', 'Admin\MenuUserPermissions::save');
    });

    $routes->group('profile', function ($routes) {
        $routes->get('', 'Admin\Profile::index');
        $routes->post('update', 'Admin\Profile::update_profile');
        $routes->post('upload-photo', 'Admin\Profile::uploadPhoto');

        $routes->get('update-password', 'Admin\Profile::update_password');
        $routes->post('update-profile-password', 'Admin\Profile::ajax_update_profile_password');
    });

    $routes->group('student', function ($routes) {
        $routes->get('entrance-exam-student-list', 'Admin\Student::entrance_exam_student_list');

        $routes->post('ajax_request_ent_exam_student_list', 'Admin\Student::ajax_request_ent_exam_student_list');
        $routes->post('add_reg_payment', 'Admin\Student::ajax_request_add_reg_payment');
        $routes->post('entrance-exam-student-action', 'Admin\Student::entrance_exam_student_action');
        $routes->post('get-exam-date', 'Admin\Student::get_exam_date');
        $routes->post('save-admission', 'Admin\Student::ajax_save_admisssion_student_details');


        $routes->get('entrance-exam-eligible-student-list', 'Admin\Student::entrance_exam_eligible_student_list');
        $routes->post('ajax_request_eligible_exam_student_list', 'Admin\Student::ajax_request_eligible_exam_student_list');
        $routes->get('eligible-for-admission-student-list', 'Admin\Student::entrance_exam_eligible_for_admission_student_list');

        $routes->post('ajax_request_ent_exam_eli_student_list', 'Admin\Student::ajax_request_ent_exam_eli_student_list');
        $routes->get('collect-admission-fee/(:any)', 'Admin\Student::collect_admission_fee/$1');
        $routes->get('edit/(:any)', 'Admin\Student::edit_student/$1');
        $routes->post('studentupdate/(:any)', 'Admin\Student::update_student/$1');

        $routes->post('assign-bus-to-student', 'Admin\Student::ajax_request_assign_bus_to_student');
        $routes->post('unassign-bus-to-student', 'Admin\Student::ajax_request_unassign_bus_to_student');

        $routes->post('add-admission-payment', 'Admin\Student::ajax_add_admission_payment');
        $routes->post('add-re-admission-payment', 'Admin\Student::ajax_add_re_admission_payment');

        $routes->get('student-list', 'Admin\Student::student_list');
        $routes->get('student-list/(:any)', 'Admin\Student::student_list/$1');

        $routes->post('assign-section-to-student', 'Admin\Student::ajax_request_assign_section_to_student');
        $routes->post('request-section', 'Admin\Student::ajax_request_section');
        $routes->post('ajax-student-list', 'Admin\Student::ajax_request_student_list');
        $routes->post('ajax-student-paid-fee-invoice', 'Admin\Student::ajax_student_paid_fee_invoice');
        $routes->post('ajax-student-registration-fee-invoice', 'Admin\Student::ajax_student_registration_fee_invoice');

        $routes->get('view-fee-structure/(:any)', 'Admin\Student::view_fee_structure/$1');
        $routes->post('fee-amount-for-selected-month', 'Admin\Student::ajax_fee_amount_for_selected_month');

        $routes->post('update-admission-payment', 'Admin\Student::ajax_update_admission_payment');
        $routes->post('update-student-trans-detail', 'Admin\Student::ajax_update_student_trans_detail');

        // Print area
        $routes->post('student-paid-monthly-fee-invoice', 'Admin\Student::ajax_student_monthly_paid_fee_invoice');
        // $routes->post('student-paid-monthly-fee-invoice', 'Admin\Student::ajax_student_paid_fee_invoice');
        $routes->post('student-paid-bus-fee-invoice', 'Admin\Student::ajax_student_paid_bus_fee_invoice');

        $routes->post('update-fees-payment-mode', 'Admin\Student::ajax_student_update_fees_payment_mode');
        $routes->post('update-bus-payment-mode', 'Admin\Student::ajax_student_update_bus_payment_mode');

        $routes->get('student-section-upload', 'Admin\Student::student_section_upload');
        $routes->post('upload-student-section', 'Admin\Student::ajax_upload_student_section');
        $routes->post('import-student-details', 'Admin\Student::ajax_import_student_details');
        
        $routes->get('generate-class-id-card', 'Admin\Student::generate_class_id_card');
        $routes->post('generate-idcard', 'Admin\Student::ajax_generate_idcard');
        
        $routes->get(
            'generate-student-idcard/(:any)/(:any)/(:any)',
            'Admin\Student::generateStudentIdcard/$1/$2/$3'
        );

        // This section for online payment test
        $routes->post('update-online-payment', 'Admin\Student::update_online_payment');
        $routes->post('ccavenue-request-test', 'Admin\Student::ccavenue_request_test');
        $routes->post('ccavenue-request', 'Admin\Student::ccavenue_request');
        $routes->post('ccavenue-request-readmission', 'Admin\Student::ccavenue_request_readmission');

        // End This section for online payment test

        $routes->get('generate-student-roll-no', 'Admin\Student::generate_student_roll_no');
        $routes->post('get-lists-for-generate-student-roll', 'Admin\Student::ajax_request_get_lists_for_generate_student_roll');
        $routes->post('allot-students-roll-num', 'Admin\Student::allot_students_roll_num');
        $routes->get('generate-individual-student-roll-no', 'Admin\Student::generate_individual_student_roll_no');
        $routes->post('update-rollno', 'Admin\Student::ajax_update_individual_student_roll_no');

        
        // Readmission
        $routes->get('re-admission', 'Admin\Student::re_admission');
        $routes->post('ajax-request-for-student-move-to-next-session', 'Admin\Student::ajax_request_for_student_move_to_next_session');
        $routes->post('students-move-to-next-class', 'Admin\Student::students_move_to_next_class');
        $routes->get('collect-re-admission-fee/(:any)', 'Admin\Student::collect_re_admission_fee/$1');

        // 
        $routes->get('assign-bus', 'Admin\Student::assign_bus');
        $routes->post('get-assign-bus-details', 'Admin\Student::ajax_assign_bus_details');

        $routes->match(['get', 'post'], 'assign-section', 'Admin\Student::assign_section');
        $routes->post('assign-section-to-single-student', 'Admin\Student::assign_section_to_single_student');
    });

    $routes->group('class-wise-exam-date', function ($routes) {
        $routes->get('/', 'Admin\ClassWiseExamDate::index');
        $routes->post('fetch', 'Admin\ClassWiseExamDate::fetch');
        $routes->post('get-exam-date', 'Admin\ClassWiseExamDate::get_exam_date');
        $routes->post('save', 'Admin\ClassWiseExamDate::store');
        $routes->delete('delete/(:num)', 'Admin\ClassWiseExamDate::delete/$1');
    });

    $routes->group('tblc', function ($routes) {
        $routes->get('', 'Admin\Tblc::index');
        $routes->post('ajax-item-list', 'Admin\Tblc::ajax_item_list');
        $routes->post('save-items', 'Admin\Tblc::ajax_save_items');
        $routes->post('delete-item', 'Admin\Tblc::ajax_delete_item');
        $routes->post('get-item-details', 'Admin\Tblc::ajax_get_item_details');
        $routes->post('update-tblc-item', 'Admin\Tblc::ajax_update_tblc_item');
    });

    $routes->group('stationary-items', function ($routes) {
        $routes->get('', 'Admin\StationaryItems::index');

        $routes->post('ajax-item-list', 'Admin\StationaryItems::ajax_item_list');
        $routes->post('save-items', 'Admin\StationaryItems::ajax_save_items');
        $routes->post('delete-item', 'Admin\StationaryItems::ajax_delete_item');
        $routes->post('get-item-details', 'Admin\StationaryItems::ajax_get_item_details');
        $routes->post('update-stationary-item', 'Admin\StationaryItems::ajax_update_stationary_item');
        $routes->get('stationary-item-collection', 'Admin\StationaryItems::stationary_item_collection');
        $routes->post('ajax-stationary-item-collection-student-list', 'Admin\StationaryItems::stationary_item_collection_student_list');

        $routes->get('assign-stationary-items', 'Admin\StationaryItems::assign_stationary_items');
        $routes->get('assign-stationary-items/(:any)', 'Admin\StationaryItems::assign_stationary_items/$1');
        $routes->post('ajax-assign-stationary-item-collection-student-list', 'Admin\StationaryItems::assign_stationary_item_collection_student_list');
        $routes->get('assign-student-stationary-items/(:any)', 'Admin\StationaryItems::assign_student_stationary_items/$1');
        $routes->post('ajax-assign-stationary-item-to-student', 'Admin\StationaryItems::assign_stationary_item_to_student');
        $routes->post('ajax-stationary-invoice', 'Admin\StationaryItems::ajax_stationary_invoice');
        $routes->post('update-stationary-fees-payment-mode', 'Admin\StationaryItems::ajax_update_stationary_fees_payment_mode');
    });

    $routes->group('feestructure', function ($routes) {
        $routes->get('', 'Admin\Feestructure::index');
        $routes->post('add-fee', 'Admin\Feestructure::add_fee');
        $routes->get('edit-fee/(:any)', 'Admin\Feestructure::edit_fee/$1');
        $routes->post('update-fee/(:any)', 'Admin\Feestructure::update_fee/$1');
        $routes->post('delete/(:num)', 'Admin\Feestructure::delete_fee/$1');
    });
    
    $routes->group('configuration', function ($routes) {
        $routes->get('', 'Admin\Configuration::index');
        $routes->get('add', 'Admin\Configuration::add');
        $routes->get('edit', 'Admin\Configuration::edit');
        $routes->post('add-configuration', 'Admin\Configuration::add_configuration');
        $routes->post('update-configuration', 'Admin\Configuration::update_configuration');
    });

    $routes->group('report', function ($routes) {
        $routes->get('', 'Admin\Report::index');
        $routes->get('form-selling-report', 'Admin\Report::form_selling_report');
        $routes->get('daily-collection-report', 'Admin\Report::daily_collection_report');
        $routes->post('ajax_request_daily_collection_report', 'Admin\Report::ajax_request_daily_collection_report');
        $routes->post('ajax_request_form_selling_report', 'Admin\Report::ajax_request_form_selling_report');
        
        $routes->get('form-submission-report', 'Admin\Report::form_submission_report');
        $routes->get('not-admitted-report', 'Admin\Report::not_admitted_report');
        $routes->post('ajax-form-submission-report', 'Admin\Report::ajax_request_form_submission_report');
        $routes->post('ajax-not-admitted-report', 'Admin\Report::ajax_request_not_admitted_report');

        $routes->get('admitted-report', 'Admin\Report::admitted_report');
        $routes->post('ajax-admitted-report', 'Admin\Report::ajax_request_admitted_report');


        $routes->get('daily-academic-fees-collection-report', 'Admin\Report::daily_academic_fees_collection_report');
        $routes->post('ajax-request-daily-academic-fees-collection-report', 'Admin\Report::ajax_request_daily_academic_fees_collection_report');

        $routes->get('tblc-report', 'Admin\Report::tblc_report');
        $routes->post('tblc-report', 'Admin\Report::tblc_report');
        $routes->post('ajax-request-tblc-report', 'Admin\Report::ajax_request_tblc_report');
        
        $routes->get('pass-fail', 'Admin\Report::pass_fail_report');
        $routes->post('ajax-pass-fail-report', 'Admin\Report::ajax_request_pass_fail_report');

        $routes->get('daily-stationary-report', 'Admin\Report::dailyStationarySalesReport');
        $routes->post('daily-stationary-report', 'Admin\Report::ajaxDailyStationarySalesReport');
        $routes->post('ajax-request-daily-stationary-report', 'Admin\Report::ajaxDailyStationarySalesReport');
        
        $routes->get('daily-bus-payment-report', 'Admin\Report::dailyBusPaymentReport');
        $routes->post('daily-bus-payment-report', 'Admin\Report::dailyBusPaymentReport');
        $routes->match(['get', 'post'], 'bus-paid-report', 'Admin\Report::busPaidReport');
    });

    $routes->group('online-payment', function ($routes) {
        $routes->post('ccavenue-response-handler', 'Admin\OnlinePayment::ccavenue_response_handler');
        $routes->post('ccavenue-response-handler-readmission', 'Admin\OnlinePayment::ccavenue_response_handler_readmission');
    });

    $routes->group('csv-payment-upload', function ($routes) {
        $routes->get('student-detail-import', 'Admin\CsvPaymentUpload::student_detail_import');
        $routes->post('bankpayment-studentdata-save', 'Admin\CsvPaymentUpload::bankpayment_studentdata_save');
        $routes->post('online-failed-payment-save', 'Admin\CsvPaymentUpload::online_failed_payment_save');
        $routes->post('online-failed-payment-april-save', 'Admin\CsvPaymentUpload::online_failed_payment_april_save');


        $routes->get('student-transaction-import', 'Admin\CsvPaymentUpload::student_transaction_import');
        $routes->get('bank-online-transaction-import', 'Admin\CsvPaymentUpload::bank_online_transaction_import');
        $routes->get('security-money-update', 'Admin\CsvPaymentUpload::security_money_update');
    });

    $routes->group('advertisement', function ($routes) {
        $routes->get('/', 'Admin\Advertisement::index');
        $routes->post('advertisement-save', 'Admin\Advertisement::upload');
        $routes->post('advertisement-delete', 'Admin\Advertisement::delete');
    });
    
    $routes->group('events', function ($routes) {
        $routes->get('/', 'Admin\ParentEvent::index');
        $routes->post('save', 'Admin\ParentEvent::save_events');
        $routes->post('fetch', 'Admin\ParentEvent::fetch_events');
        $routes->post('update-status', 'Admin\ParentEvent::status_update');
        $routes->post('get-event', 'Admin\ParentEvent::get_event');
        $routes->get('delete/(:num)', 'Admin\ParentEvent::delete_event/$1');
    });

    // Upload BS ID & PEN Data
    $routes->group('csv-busid-pen-upload', function ($routes) {
        $routes->get('/', 'Admin\CsvBsidPenNumberUpload::index');
        $routes->post('busid-pen-data-save', 'Admin\CsvBsidPenNumberUpload::busid_pen_data_save');
    });




    $routes->get('import-students', 'Admin\ImportController::index');
    $routes->post('import-students', 'Admin\ImportController::importStudents');

    $routes->get('import-student-details', 'Admin\ImportController::import_student_details');
    $routes->post('import-student-details', 'Admin\ImportController::importStudentDetails');
});

/**
 * Cron Job
 * */
$routes->get('cronjob-birthday-mail', 'CronJob::birthday_mail');


//for Api

$routes->group('api', function($routes) {
    // Auth
    $routes->post('login', 'Api\Auth::login');
    //others
    $routes->get('student-session-year', 'Api\StudentApiController::student_session_year');
    $routes->get('parent-events', 'Api\StudentApiController::parent_events');
});
// Protected routes
$routes->group('api', ['filter' => 'jwt'], function($routes) {
    $routes->post('student-details', 'Api\StudentApiController::student_details');
    $routes->post('student-exam-date', 'Api\StudentApiController::student_exam_date');
    $routes->post('student-fee-structure', 'Api\StudentApiController::student_fee_structure');
    $routes->post('student-fee-collection', 'Api\StudentApiController::student_fee_collection');
    $routes->post('student-invoice', 'Api\StudentApiController::student_invoice');
});