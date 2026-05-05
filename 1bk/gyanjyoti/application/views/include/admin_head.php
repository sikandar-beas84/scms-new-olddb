<!DOCTYPE html>
<html lang="english">

<head>
	<!-- Meta data -->
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>

	<!-- Title -->
	<title>
		<?= $page_title ?>
	</title>

	<!--Favicon -->
	<link rel="icon" href="<?=bs();?>assets/font-end/images/logo.png" type="image/x-icon" />

	<!-- Bootstrap css -->
	<link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" />

	<!-- Style css -->
	<link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet" />
	<link href="<?= base_url() ?>assets/css/updatestyles.css" rel="stylesheet" />
	<link href="<?= base_url() ?>assets/css/dark.css" rel="stylesheet" />
	<link href="<?= base_url() ?>assets/css/skin-modes.css" rel="stylesheet" />

	<!-- Animate css -->
	<link href="<?= base_url() ?>assets/css/animated.css" rel="stylesheet" />

	<!--Sidemenu css -->
	<link href="<?= base_url() ?>assets/css/sidemenu.css" rel="stylesheet" />

	<!-- P-scroll bar css-->
	<link href="<?= base_url() ?>assets/css/p-scrollbar.css" rel="stylesheet" />

	<!---Icons css-->
	<!-- <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet" /> -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/font-awesome.min.css">

	<!-- Select2 css -->
	<link href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css" rel="stylesheet" />

	<!--INTERNAL Toastr css -->
	<link href="<?= base_url() ?>assets/css/toastr.css" rel="stylesheet" />

	<!--INTERNAL Ratings css -->
	<link href="<?= base_url() ?>assets/css/jquerystarrating.css" rel="stylesheet" />


	<!-- INTERNAL Sweet-Alert css -->
	<link href="<?= base_url() ?>assets/css/sweetalert.css" rel="stylesheet" />

	<!-- DATATABLES css -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/dataTables.bootstrap4.min.css">

	<!-- ALERTIFY css -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/alertify/alertify.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/alertify/alertify.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/alertify/alertify.rtl.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/alertify/alertify.rtl.min.css">

	<!-- Jquery js-->
	<!--<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>-->
    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>

	<!-- Apex Chart -->
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

	<!-- Year Picker -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<!-- Moment Js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
	<script src="<?= base_url('assets/js/yearpicker.js') ?>"></script>
	<link rel="stylesheet" href="<?= base_url('assets/css/yearpicker.css') ?>">
	<!-- This For CRUD -->
	<script src="<?= base_url(); ?>assets/custom/helpers/helperNew.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="<?= base_url(); ?>assets/custom/helpers/helpers.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/crud.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="<?= base_url(); ?>assets/custom/helpers/imageUpload/jquery-3.2.1.js"></script>
	<link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/imageUpload/normalize.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/imageUpload/skeleton.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/imageUpload/pe-icon-7-stroke.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/imageUpload/drop_uploader.css">
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-HeyBYvJ6m/bhEBssY99sAQVjXQ/sqAbjp6+ptSOQ2W8Z5IF5J3/3mpo7FadLtrG+" crossorigin="anonymous"> -->
	<!-- End For CRUD -->  
	<!-- Color Changes -->
	<link href="https://fonts.googleapis.com/css2?family=Museo:wght@300;400;500;700&display=swap" rel="stylesheet">
		<!-- Add these in your head tag -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


	<style>
		:root {
			--primary: rgba(51, 102, 255, 1);
			--secondary: rgba(24, 71, 128, 1);
		}

		.app-sidebar {

			/* background: #FFA500 !important; */
			background: #ffffff !important;
		}

		.side-menu .slide a {
			color: #000000 !important;
		}

		.side-menu .sidemenu_icon {

			fill: #000000 !important;
		}

		.app-sidebar__user-name.text-muted {

			color: #000000 !important;

		}

		.page_loader{
			position: fixed;
			z-index: 99999;
			background: rgba(255,255,255,.5);
			width: 100%;
			height: 100%;
			overflow: hidden;
		}
		.table {
			background: #fff;
		}
		/* @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap'); */
		
		body, span {
			font-family: 'Museo', sans-serif;
		}

		h1, h2, h3, h4, h5, h6, p {
			font-family: 'Museo', sans-serif;
		}
		th.datepicker-switch {
			background: #243448 !important;
		}
        
        @media only screen and (max-width: 900px) {
            .page-title {
                margin-top: 65px;
            }
            .header-datepicker.me-3 {
                    display: inline-block !important;
                }
        }
	</style>


</head>
<?php 	#=====================================
        # Added By Suhrid Sarkar on 06-06-2023
        # Check Auto Logout & Auto Screen Lock
        #=====================================
        // check_last_active_time();
        
        #=====================================
        # Added By Suhrid Sarkar on 06-06-2023
        # Check Auto Logout
        #=====================================
        // $user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
        // if($user_details->auto_logout == 'Y'){
        //     check_login_time();
        // }
        
        #=====================================
        # Check Auto Screen Lock
        #=====================================
        // if($user_details->screen_lock == 'Y'){
        //     if(screen_lock() == '1'){
        //         redirect("lock_screen");
        //     }
        // }
     ?>
<body class="app sidebar-mini">

	<div class="page_loader" style="display:none;">
		<div class="d-flex page_loader_content justify-content-center">
			<img src="<?= base_url('assets/img/preloader.gif') ?>" style="width: 60px; padding-top: 210px;">
		</div>
	</div>

	<div class="page">
		<div class="page-main">
