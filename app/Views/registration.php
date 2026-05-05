<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

<style>
	.required {
		color: red;
	}
</style>
<!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->


<script src="<?php // echo base_url('public/admin/assets/js/vendor/forms/validation/validate.min.js') ?>"></script>
<!-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script> -->

<!-- First load jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<!-- Then load jQuery Validation plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>


<script type="text/javascript">
	function initDatePickers() {
	    $(".datepicker-basic").datepicker({
	        dateFormat: "yy-mm-dd", // yyyy-mm-dd
	        changeMonth: true,
	        changeYear: true,
	        yearRange: "1990:2050"
	    });
	}
	$(document).ready(function(){
		// Datepicker
    	initDatePickers()

    })
</script>

	<div class="navbar navbar-expand-xl navbar-static shadow" style="background-color: lightsalmon;">
		<div class="container-fluid">
			<div class="navbar-brand flex-1">
				<a href="<?= base_url('dashboard') ?>" class="d-inline-flex align-items-center">
					<img src="<?= base_url('/public/admin/assets/images/siteicon.png') ?>" alt="">
					<img src="<?= base_url('/public/admin/assets/images/ssss.png') ?>" class="d-none d-sm-inline-block h-16px invert-dark ms-3" alt="">
				</a>
			</div>

			<div class="d-flex w-100 w-xl-auto overflow-auto overflow-xl-visible scrollbar-hidden border-top border-top-xl-0 order-1 order-xl-0 pt-2 pt-xl-0 mt-2 mt-xl-0">
				<ul class="nav gap-1 justify-content-center flex-nowrap flex-xl-wrap mx-auto">
					<li class="nav-item">
						<a href="<?= base_url('dashboard') ?>" class="navbar-nav-link rounded active">
							<i class="ph-house me-2"></i>
							Home
						</a>
					</li>

				</ul>
			</div>

			<ul class="nav gap-1 flex-xl-1 justify-content-end order-0 order-xl-1">
				
			</ul>
		</div>
	</div>

	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Page header -->
				<div class="page-header page-header-light shadow">
					<div class="page-header-content">
						<div class="">
							<h4 class="page-title mb-0" style="text-align: center;">
								ADMISSION FORM - <span class="fw-normal">PLEASE FILL IN THE FORM IN BLOCK LETTERS ONLY. (*) - Marks are mandatory</span>
							</h4>
						</div>
					</div>

					<div class="page-header-content d-lg-flex border-top" style="display:flex; justify-content:center; align-items:center;">
						<div class="d-flex">
							<div class="breadcrumb py-2" style="display:flex; justify-content:center; align-items:center; gap:15px;">
								<a href="javascript:;" class="breadcrumb-item"><i class="ph-phone-call"></i> <span class="breadcrumb-item">03473-245029 / 03473-246476</span></a>
								<a href="javascript:;" class="breadcrumb-item"><i class="ph-envelope"></i> <span class="breadcrumb-item">scmemorial@rediffmail.com</span></a>
								<a href="javascript:;" class="breadcrumb-item"><i class="ph-map-pin"></i> <span class="breadcrumb-item">Find us on map</span></a>
								<a href="javascript:;" class="breadcrumb-item"><i class="ph-user-focus"></i> <span class="breadcrumb-item">Form Entry By: <?= session()->get('f_name'); ?></span></a>
								<?php // pr(session()->get()); ?>
							</div>
						</div>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<?php if (session()->getFlashdata('success')): ?>
					    <div class="alert alert-success alert-dismissible fade show" role="alert">
					        <?= session()->getFlashdata('success') ?>
					        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					    </div>
					<?php endif; ?>

					<?php if (session()->getFlashdata('error')): ?>
					    <div class="alert alert-danger alert-dismissible fade show" role="alert">
					        <?= session()->getFlashdata('error') ?>
					        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					    </div>
					<?php endif; ?>

					<?php if (session()->getFlashdata('errors')): ?>
					    <div class="alert alert-danger">
					        <ul>
					            <?php foreach (session()->getFlashdata('errors') as $error): ?>
					                <li><?= esc($error) ?></li>
					            <?php endforeach; ?>
					        </ul>
					    </div>
					<?php endif; ?>



					<!-- Invoice template -->
					<div class="card">
						<form class="needs-validation" method="post" id="registrationForm" action="<?= base_url('save-registration') ?>" autocomplete="off" enctype="multipart/form-data">
							<!-- <div class="card-header d-flex align-items-center py-0">
								<h5 class="py-3 mb-0">Invoice template</h5>
								<div class="d-inline-flex ms-auto">
									<button type="button" class="btn btn-light"><i class="ph-file-arrow-down me-2"></i> Save</button>
									<button type="button" class="btn btn-light ms-3"><i class="ph-printer me-2"></i> Print</button>
					        	</div>
							</div> -->

							<div class="card-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="mb-4">
											<div class="d-inline-flex align-items-center mt-2 mb-3">
												<img src="https://scmschakdaha.in/public/admin/assets/images/logo_icon.png" class="h-24px" alt="Logo">
												<h4 class="d-none d-sm-inline-block text-body mb-0 ms-2">Satish Chandra Memorial School</h4>
											</div>

											<ul class="list list-unstyled mt-2 mb-0">
												<li>To</li>
												<li>The Principal</li>
												<li>Satish Chandra Memorial School</li>
												<li>Pumlia (Chowrasta), Chakdaha</li>
												<li>Nadia, West Bengal</li>
											</ul>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="text-sm-end mb-4">
											<h4 class="text-primary mb-2 mt-lg-2">Photo to be attached</h4>
											<div class="row">
												<div class="col-sm-6">
													<input type="file" class="form-control-file characterImage1 valid" id="userfile" name="userfile" data-validation="mime" data-validation-allowing="jpg, png, gif" data-validation-error-msg-required="No image selected">
													<br />
													<b>(Image width should be within 3.5x4.5 cm)</b>
												</div>									
												<div class="col-sm-6">
													<div> 
														<img src="#" id="profile-img-tag" alt="Image Preview">
												 	</div>
												    <span class="error"></span>
												</div>									
											</div>
											<div class="has-success">
											 	
											</div>
										</div>
									</div>

									<div class="col-sm-12">
										<p>Dear Madam / Sir,</p>
										<p>I request you favour for admitting my ward to your school. I accept the terms mentioned in your prospectus and I am furnishing the following particulars about my ward.</p>
									</div>
								</div>
							</div>



							<div class="card-body border-top">
								<div class="row">
									
									<div class="col-sm-12 mb-3" style="display: none;">
										<label class="form-label">Session: </label>
										<select name="session_year_id" id="session_year_id" class="form-control" required="">
											<option value=""> ----- Select ----- </option>
											<?php if( isset($session_year) && !empty($session_year) ) {
												foreach ($session_year as $sessionValue) {

													$selected = ($sessionValue['is_current'] == 't') ? 'selected' : '';

													echo '<option value="'.$sessionValue['id'].'" '.$selected.'>'.$sessionValue['session_name'].'</option>';
												}
											} ?>
										</select>
									</div>

									<div class="col-sm-6 mb-3">
										<label class="form-label">Name: <span class="required">*</span></label>
										<input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter Name" required>
									</div>
									
									<div class="col-sm-6 mb-3">
										<label class="form-label">Gender:  <span class="required">*</span></label>
										<div class="form-check-horizontal">
											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="gender" value="Male" checked="">
												<span class="form-check-label">Male</span>
											</label>

											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="gender" value="Female">
												<span class="form-check-label">Female</span>
											</label>
										</div>
									</div>

									<div class="col-sm-6 mb-3">
										<label class="form-label">Shift:  <span class="required">*</span></label>
										<div class="form-check-horizontal">
											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="shift" value="Day" >
												<span class="form-check-label">Day</span>
											</label>

											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="shift" value="Morning" checked="">
												<span class="form-check-label">Morning</span>
											</label>
										</div>
									</div>


									<div class="col-sm-6 mb-3">
										<label class="form-label" style="color: red;">Bangla Sikhsha ID: </label>
										<input type="text" name="bs_id" id="bs_id" class="form-control" placeholder="Enter Bangla Sikhsha ID" >
									</div>
									<div class="col-sm-6 mb-3"></div>

									<div class="col-sm-6 mb-3">
										<label class="form-label">Aadhar No:</label>
										<input type="text" name="aadhaar_no" id="aadhaar_no" class="form-control" placeholder="Aadhar No">
									</div>

									<div class="col-sm-6 mb-3">
										<label class="form-label">Date of Birth: <span class="required">*</span></label>
										<input name="d_o_b" id="d_o_b" type="text" class="form-control datepicker-basic datepicker-input" value="" required autocomplete="off" readonly>
									</div>

									<div class="col-sm-6 mb-3">
										<label class="form-label">Class: <span class="required">*</span></label>
										<select name="class_id" id="class_id" class="form-control" required="">
											<option value=""> ----- Select ----- </option>
											<?php if( isset($class) && !empty($class) ) {
												foreach ($class as $class_value) {
													echo '<option value="'.$class_value['id'].'">'.$class_value['class_name'].'</option>';
												}
											} ?>
										</select>
									</div>

									<div class="col-sm-6 mb-3">
										<label class="form-label">Religion: </label>
										<select name="religion" id="religion" class="form-control" >
											<option value="">Select Religion</option>
											<?php 
											if( isset($religion_list) && !empty($religion_list) ) {
												foreach($religion_list as $religion): ?>							
													<option value="<?= $religion['id'] ?>"><?= $religion['name'] ?></option>
												<?php endforeach; 
											} ?>
										</select>
									</div>

									<div class="col-sm-6 mb-3">
										<label class="form-label">Nationality:</label>
										<input type="text" name="nationality" id="nationality" class="form-control" placeholder="Nationality">
									</div>

									<div class="col-sm-6 mb-3">
										<label class="form-label">Category: (Photocopy required during admission)</label>
										<div class="form-check-horizontal">
											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="caste" value="SC">
												<span class="form-check-label">SC</span>
											</label>
											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="caste" value="ST">
												<span class="form-check-label">ST</span>
											</label>
											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="caste" value="OBC">
												<span class="form-check-label">OBC</span>
											</label>

											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="caste" value="GEN" checked="">
												<span class="form-check-label">GEN</span>
											</label>
										</div>

									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">BPL:</label>
										<div class="form-check-horizontal">
											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="bpl" value="1">
												<span class="form-check-label">Yes</span>
											</label>

											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="bpl" value="0" checked="">
												<span class="form-check-label">No</span>
											</label>
										</div>
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">BPL Number:</label>
										<input name="bpl_number" id="bpl_number" type="text" class="form-control" placeholder="BPL Number">
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">TC Required :</label>
										<div class="form-check-horizontal">
											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="tc_required" value="1">
												<span class="form-check-label">Yes</span>
											</label>

											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="tc_required" value="0" checked="">
												<span class="form-check-label">No</span>
											</label>
										</div>
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">TC No:</label>
										<input type="text" name="pre_school_tc_no" id="pre_school_tc_no" class="form-control" placeholder="TC No">
									</div>

									<div class="col-sm-6 mb-3">
										<label class="form-label">TC Submitted Date :</label>
										<input name="pre_school_tc_date" id="pre_school_tc_date" type="text" class="form-control datepicker-basic datepicker-input" placeholder="" readonly>
									</div>

									<div class="col-sm-6 mb-3">
										<label class="form-label">Migration Required :</label>
										<div class="form-check-horizontal">
											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="migration_required" value="1">
												<span class="form-check-label">Yes</span>
											</label>

											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="migration_required" value="0" checked="">
												<span class="form-check-label">No</span>
											</label>
										</div>
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Migration Submitted Date :</label>
										<input name="migration_date" id="migration_date" type="text" class="form-control datepicker-basic datepicker-input" placeholder="" readonly>
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Student Status :</label>
										<div class="form-check-horizontal">
											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="status" value="1" checked="">
												<span class="form-check-label">Yes</span>
											</label>

											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="status" value="0" >
												<span class="form-check-label">No</span>
											</label>
										</div>
									</div>

									<div class="col-sm-6 mb-3">
										<label class="form-label">Assign Academic Status :</label>
										<div class="form-check-horizontal">
											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="session_result_status" value="1" checked="">
												<span class="form-check-label">Yes</span>
											</label>

											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="session_result_status" value="0" >
												<span class="form-check-label">No</span>
											</label>
										</div>
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label" style="color:red;">Damaged Product:</label>
										<input name="dmg_prd" id="dmg_prd" type="text" class="form-control" placeholder="Damaged Product">
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label" style="color:red;">Damaged Product Price:</label>
										<input name="dmg_prd_price" id="dmg_prd_price" type="text" class="form-control" placeholder="Damaged Product Price">
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label" style="color:red;">Security Amount:</label>
										<input name="security_deposite" id="security_deposite" type="text" class="form-control" placeholder="Security Amount">
									</div>									


									<div class="col-sm-6 mb-3">
										<label class="form-label">Mother tongue:</label>
										<input name="mother_tongue" id="mother_tongue" type="text" class="form-control" placeholder="Mother tongue">
									</div>
									<div class="col-sm-12 mb-3">
										<label class="form-label">Last Attended (If any): <span>(Original copy of TC, Report card, Migration certificate,Blood Group (Rh Factor) is required during admission)</span></label>
										<input name="last_school_detail" id="last_school_detail" type="text" class="form-control" placeholder="Last Attended (If any)">
										
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Blood Group (RH Factor):</label>
										<input name="blood_grp" id="blood_grp" type="text" class="form-control" placeholder="Blood Group (RH Factor)">
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Immunization up to date (Please attached photocopy):</label>
										<div class="form-check-horizontal">
											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="immunization" value="Yes">
												<span class="form-check-label">Yes</span>
											</label>

											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="immunization" value="No" checked="">
												<span class="form-check-label">No</span>
											</label>
										</div>
									</div>

									<div class="col-sm-6 mb-3">
										<label class="form-label">Academic Status: <span class="required">*</span></label>
										<select name="academic_status" id="academic_status" class="form-control" required>
											<option value=""> ----- Select ----- </option>
											<option value="TC">TC</option>
											<option value="Bonafide">Bonafide</option>
											<option value="Left">Left</option>
											<option value="Free">Free</option>
											<option value="Not Admitted" selected>Not Admitted</option>
										</select>
									</div>
									<div class="col-sm-6 mb-3 gDate">
										<label class="form-label">Generated Date:</label>
										<input name="tc_date" id="tc_date" type="text" class="form-control datepicker-basic datepicker-input" placeholder="" readonly>
									</div>


									<div class="col-sm-6 mb-3">
										<label class="form-label">Only Child:</label>
										<div class="form-check-horizontal">
											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="only_child" value="Yes" checked="">
												<span class="form-check-label">Yes</span>
											</label>

											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="only_child" value="No">
												<span class="form-check-label">No</span>
											</label>
										</div>
									</div>
									<div class="col-sm-6 mb-3 gDate">
										<label class="form-label">Medical condition:</label>
										<textarea name="medical_condition" rows="3" cols="3" class="form-control" placeholder="Enter your Medical condition here"></textarea>
									</div>

									<div class="col-sm-6 mb-3">
										<label class="form-label">PEN No:</label>
										<input type="text" name="pen_no" id="pen_no" class="form-control" placeholder="PEN No" >
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">APPAR ID:</label>
										<input type="text" name="appar_id" id="appar_id" class="form-control" placeholder="APPAR ID" >
									</div>


									<div class="col-sm-6 mb-3">
										<label class="form-label">Admission No & Date:</label>
										<input type="text" class="form-control" placeholder="Office use only" disabled>
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Student ID:</label>
										<input type="text" class="form-control" placeholder="Office use only" disabled>
									</div>

									<h2>PARENT'S DETAIL</h2>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Mother's Image:</label>
										<div class="row">
											<div class="col-sm-8">
												<input name="m_image" id="m_image" type="file" class="form-control">
												<div class="form-text text-muted">(Image width should be within 3.5x4.5 cm)</div>
											</div>											
											<div class="col-sm-4">
												<div> 
													<img src="#" id="m_image_preview" alt="Image Preview">
											 	</div>
											    <span class="error"></span>
											</div>											
										</div>

										
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Mother's Signature:</label>
										<div class="row">
											<div class="col-sm-8">
												<input name="m_signature" id="m_signature" type="file" class="form-control">
												<div class="form-text text-muted">(Image width should be within 14x4 cm)</div>
											</div>											
											<div class="col-sm-4">
												<div> 
													<img src="#" id="m_signature_preview" alt="Image Preview">
											 	</div>
											    <span class="error"></span>
											</div>											
										</div>

										
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Mother's name: <span class="required">*</span></label>
										<input name="mother_name" id="mother_name" type="text" class="form-control" placeholder="Mother's name" required>
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">What's App/Mobile No.: <span class="required">*</span></label>
										<input name="mother_mobile" id="mother_mobile" type="text" class="form-control" placeholder="What's App/Mobile No." required>
									</div>
									<div class="col-sm-4 mb-3">
										<label class="form-label">Aadhar No:</label>
										<input type="text" name="mother_aadhaar_no" id="mother_aadhaar_no" class="form-control" placeholder="Aadhar No">
									</div>
									<div class="col-sm-4 mb-3">
										<label class="form-label">Occupation:</label>
										<input type="text" name="mother_occupation" id="mother_occupation" class="form-control" placeholder="Occupation">
									</div>
									<div class="col-sm-4 mb-3">
										<label class="form-label">Annual lncome:</label>
										<input type="text" name="mother_annual_income" id="mother_annual_income" class="form-control" placeholder="Annual lncome">
									</div>

									<div class="col-sm-6 mb-3">
										<label class="form-label">Father's Image:</label>
										<div class="row">
											<div class="col-sm-8">
												<input name="f_image" id="f_image" type="file" class="form-control">
												<div class="form-text text-muted">(Image width should be within 3.5x4.5 cm)</div>
											</div>											
											<div class="col-sm-4">
												<div> 
													<img src="#" id="f_image_preview" alt="Image Preview">
											 	</div>
											    <span class="error"></span>
											</div>											
										</div>
										
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Father's Signature:</label>
										<div class="row">
											<div class="col-sm-8">
												<input name="f_signature" id="f_signature" type="file" class="form-control">
												<div class="form-text text-muted">(Image width should be within 14x4 cm)</div>
											</div>											
											<div class="col-sm-4">
												<div> 
													<img src="#" id="f_signature_preview" alt="Image Preview">
											 	</div>
											    <span class="error"></span>
											</div>											
										</div>

										
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Father's name: <span class="required">*</span></label>
										<input name="father_name" id="father_name" type="text" class="form-control" placeholder="Father's name" required>
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">What's app/Mobile No: <span class="required">*</span></label>
										<input name="father_mobile" id="father_mobile" type="text" class="form-control" placeholder="What's app/Mobile No" required>
									</div>

									<div class="col-sm-4 mb-3">
										<label class="form-label">Aadhar No:</label>
										<input name="father_aadhaar_no" id="father_aadhaar_no" type="text" class="form-control" placeholder="Aadhar No">
									</div>
									<div class="col-sm-4 mb-3">
										<label class="form-label">Occupation:</label>
										<input name="father_occupation" id="father_occupation" type="text" class="form-control" placeholder="Occupation">
									</div>
									<div class="col-sm-4 mb-3">
										<label class="form-label">Annual lncome:</label>
										<input name="father_annual_income" id="father_annual_income" type="text" class="form-control" placeholder="Annual lncome">
									</div>

									<div class="col-sm-12 mb-3">
										<label class="form-label">Address : <span class="required">*</span></label>
										<textarea name="permanent_address" id="permanent_address" rows="3" cols="3" class="form-control" placeholder="Enter your message here" required></textarea>
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Pincode : </label>
										<input type="text" name="pincode" id="pincode" class="form-control" placeholder="Pincode" >
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Whats App No: </label>
										<input type="text" name="telephone_resi" id="telephone_resi" class="form-control" placeholder="Whats App No" >
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Email : </label>
										<input type="email" name="email" id="email" class="form-control" placeholder="Email" >
									</div>

									<div class="col-sm-6 mb-3">
										<label class="form-label">Application</label>
										
										<div class="row">
											<div class="col-sm-8">
												<input type="file"  class="form-control characterImage5" id="application_pre" name="application_pre" data-validation="mime "  data-validation-allowing="jpg, png, gif,pdf,doc,docx" data-validation-error-msg-required="No image selected" />
											</div>											
											<div class="col-sm-4">
												<div> 
													<img src="" id="lym-img-tag" width="100px" />
											 	</div>
											    <span class="error"></span>
											</div>											
										</div>

									</div>
									
									<div class="col-sm-6 mb-3">
										<label class="form-label">Transfer Certificate</label>
										
										<div class="row">
											<div class="col-sm-8">
												<input type="file"  class="form-control characterImage5" id="trans_cert" name="trans_cert" data-validation="mime "  data-validation-allowing="jpg, png, gif,pdf,doc,docx" data-validation-error-msg-required="No image selected" />
											</div>											
											<div class="col-sm-4">
												<div> 
													<img src="" id="lym-img-tag" width="100px" />
											 	</div>
											    <span class="error"></span>
											</div>											
										</div>

									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Migration Certificate</label>
										
										<div class="row">
											<div class="col-sm-8">
												<input type="file"  class="form-control characterImage5" id="migration_cert" name="migration_cert" data-validation="mime "  data-validation-allowing="jpg, png, gif,pdf,doc,docx" data-validation-error-msg-required="No image selected" />
											</div>											
											<div class="col-sm-4">
												<div> 
													<img src="" id="lym-img-tag" width="100px" />
											 	</div>
											    <span class="error"></span>
											</div>											
										</div>

									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Any Special Certificate</label>
										
										<div class="row">
											<div class="col-sm-8">
												<input type="file"  class="form-control characterImage5" id="any_special_cert" name="any_special_cert" data-validation="mime "  data-validation-allowing="jpg, png, gif,pdf,doc,docx" data-validation-error-msg-required="No image selected" />
											</div>											
											<div class="col-sm-4">
												<div> 
													<img src="" id="lym-img-tag" width="100px" />
											 	</div>
											    <span class="error"></span>
											</div>											
										</div>

									</div>


									<div class="col-sm-6 mb-3">
										<label class="form-label">I have Local Guardian :</label>
										<label class="form-check">
											<input type="checkbox" name="localGurdian" id="localGurdian" class="form-check-input" >
											<span class="form-check-label">(Click this if student do not stay with parents)</span>
										</label>
									</div>
								</div>

								<div id="localGurdianBlk" style="display: none;">
									<div class="row">
										<h2>GUARDIAN'S DETAIL</h2>

										<div class="col-sm-6 mb-3">
											<label class="form-label">Guardian Image:</label>
											<div class="row">
												<div class="col-sm-8">
													<input name="g_image" id="g_image" type="file" class="form-control">
													<div class="form-text text-muted">(Image width should be within 3.5x4.5 cm)</div>
												</div>											
												<div class="col-sm-4">
													<div> 
														<img src="#" id="g_image_preview" alt="Image Preview">
												 	</div>
												    <span class="error"></span>
												</div>											
											</div>

											
										</div>
										<div class="col-sm-6 mb-3">
											<label class="form-label">Guardian Signature:</label>
											<div class="row">
												<div class="col-sm-8">
													<input name="g_signature" id="g_signature" type="file" class="form-control">
													<div class="form-text text-muted">(Image width should be within 14x4 cm)</div>
												</div>											
												<div class="col-sm-4">
													<div> 
														<img src="#" id="g_signature_preview" alt="Image Preview">
												 	</div>
												    <span class="error"></span>
												</div>											
											</div>

											
										</div>
										<div class="col-sm-6 mb-3">
											<label class="form-label">Name of Guardian: <span class="required">*</span></label>
											<input name="local_guar_name" id="local_guar_name" type="text" class="form-control" placeholder="Name of Guardian" >
										</div>
										<div class="col-sm-6 mb-3">
											<label class="form-label">Gender:</label>
											<div class="form-check-horizontal">
												<label class="form-check form-check-inline">
													<input type="radio" class="form-check-input" name="local_guar_gender" value="Male" checked="">
													<span class="form-check-label">Male</span>
												</label>

												<label class="form-check form-check-inline">
													<input type="radio" class="form-check-input" name="local_guar_gender" value="Female" >
													<span class="form-check-label">Female</span>
												</label>
											</div>
										</div>

										<div class="col-sm-4 mb-3">
											<label class="form-label">Aadhar No: <span class="required">*</span></label>
											<input name="local_guar_aadhaar_no" id="local_guar_aadhaar_no" type="text" class="form-control" placeholder="Aadhar No">
										</div>
										<div class="col-sm-4 mb-3">
											<label class="form-label">Correspondence address:</label>
											<input name="local_guar_address" id="local_guar_address" type="text" class="form-control" placeholder="Correspondence address">
										</div>
										<div class="col-sm-4 mb-3">
											<label class="form-label">Mobile No:</label>
											<input name="local_guar_phone" id="local_guar_phone" type="text" class="form-control" placeholder="Mobile No">
										</div>

										<div class="col-sm-4 mb-3">
											<label class="form-label">Relationship with Student:</label>
											<input name="local_guar_stu_relation" id="local_guar_stu_relation" type="text" class="form-control" placeholder="Relationship with Student">
										</div>
										<div class="col-sm-4 mb-3">
											<label class="form-label">Occupation:</label>
											<input name="local_guar_occupation" id="local_guar_occupation" type="text" class="form-control" placeholder="Occupation">
										</div>
										<div class="col-sm-4 mb-3">
											<label class="form-label">Annual lncome:</label>
											<input name="local_guar_annual_income" id="local_guar_annual_income" type="text" class="form-control" placeholder="Annual lncome">
										</div>

										<div class="col-sm-6 mb-3">
											<label class="form-label">Earning member:</label>
											<input name="family_earn_memb" id="family_earn_memb" type="text" class="form-control" placeholder="Earning member">
										</div>
										<div class="col-sm-6 mb-3">
											<label class="form-label">Dependents:</label>
											<input name="dependent" id="dependent" type="text" class="form-control" placeholder="Dependents">
										</div>
									</div>
								</div>

								<style>
									.optional_sub {
										display: none;
									}
								</style>
								<!-- Subjects opted for  -->
								<div class="optional_sub">
									<div class="row ">
										<h2>Subjects opted for</h2>
										<hr style="margin-top: 10px; margin-bottom: 10px;">
										<h4 class="subjects-tex">Stream opt: Science / Humanities / Commerce</h4>

										<div class="col-sm-6 mb-3">
											<label class="form-label">1.</label>
											<select name="first_elective_sub" class="form-control" id="first_elective_sub">
																	
											</select>
										</div>
										<div class="col-sm-6 mb-3">
											<label class="form-label">2.</label>
											<select name="second_elective_sub" class="form-control" id="second_elective_sub">
												
											</select>
										</div>
										<div class="col-sm-6 mb-3">
											<label class="form-label">3.</label>
											<select name="third_elective_sub" class="form-control" id="third_elective_sub">
												
											</select>
										</div>
										<div class="col-sm-6 mb-3">
											<label class="form-label">4.</label>
											<select name="fourth_elective_sub" class="form-control" id="fourth_elective_sub">
												 
											</select>
										</div>
										<div class="col-sm-6 mb-3">
											<label class="form-label">5.</label>
											<select name="fifth_elective_sub" class="form-control" id="fifth_elective_sub">
												 
											</select>
										</div>
										<div class="col-sm-6 mb-3">
											<label class="form-label">6.</label>
											<select name="sixth_elective_sub" class="form-control" id="sixth_elective_sub">
												 
											</select>
										</div>


										<div class="col-sm-6 mb-3">
											<label class="form-label">Please atttach class X pre board / Mock test marks Statement / Board final result <span class="required">*</span></label>
											
											<div class="row">
												<div class="col-sm-8">
													<input type="file"  class="form-control characterImage5" id="last_year_marksheet" name="last_year_marksheet" data-validation="mime "  data-validation-allowing="jpg, png, gif,pdf,doc,docx" data-validation-error-msg-required="No image selected" />
												</div>											
												<div class="col-sm-4">
													<div> 
														<img src="" id="lym-img-tag" width="100px" />
												 	</div>
												    <span class="error"></span>
												</div>											
											</div>

										</div>
										<div class="col-sm-6 mb-3">
											<label class="form-label">Student's Birth Certificate <span class="required">*</span></label>
											<div class="row">
												<div class="col-sm-8">
													<input type="file" class="form-control characterImage5" id="student_id" name="student_id" data-validation="mime "  data-validation-allowing="jpg, png, gif,pdf,doc,docx" data-validation-error-msg-required="No image selected" />
												</div>											
												<div class="col-sm-4">
													<div> 
														<img src="" id="lym-img-tag" width="100px" />
												 	</div>
												    <span class="error"></span>
												</div>											
											</div>

										</div>
										<div class="col-sm-6 mb-3">
											<label class="form-label">Class X Admit <span class="required">*</span></label>
											<div class="row">
												<div class="col-sm-8">
													<input type="file"  class="form-control characterImage5" id="student_admit" name="student_admit" data-validation="mime "  data-validation-allowing="jpg, png, gif,pdf,doc,docx" data-validation-error-msg-required="No image selected" />
												</div>											
												<div class="col-sm-4">
													<div> 
														<img src="" id="lym-img-tag" width="100px" />
												 	</div>
												    <span class="error"></span>
												</div>											
											</div>
										</div>
										<div class="col-sm-6 mb-3">
											<label class="form-label">Father's Id Proof <span class="required">*</span></label>
											<div class="row">
												<div class="col-sm-8">
													<input type="file"  class="form-control characterImage5" id="father_id" name="father_id" data-validation="mime "  data-validation-allowing="jpg, png, gif,pdf,doc,docx" data-validation-error-msg-required="No image selected" />
												</div>											
												<div class="col-sm-4">
													<div> 
														<img src="" id="lym-img-tag" width="100px" />
												 	</div>
												    <span class="error"></span>
												</div>											
											</div>

										</div>
										<div class="col-sm-6 mb-3">
											<label class="form-label">Mother's Id Proof <span class="required">*</span></label>										
											<div class="row">
												<div class="col-sm-8">
													<input type="file"  class="form-control characterImage5" id="mother_id" name="mother_id" data-validation="mime "  data-validation-allowing="jpg, png, gif,pdf,doc,docx" data-validation-error-msg-required="No image selected" />
												</div>											
												<div class="col-sm-4">
													<div> 
														<img src="" id="lym-img-tag" width="100px" />
												 	</div>
												    <span class="error"></span>
												</div>											
											</div>

										</div>
										<div class="col-sm-6 mb-3">
											<label class="form-label">Cast Certificate (Student / Father) <span class="required">*</span></label>										
											<div class="row">
												<div class="col-sm-8">
													<input type="file" class="form-control characterImage5" id="cast_certificate" name="cast_certificate" data-validation="mime "  data-validation-allowing="jpg, png, gif,pdf,doc,docx" data-validation-error-msg-required="No image selected" />
												</div>											
												<div class="col-sm-4">
													<div> 
														<img src="" id="lym-img-tag" width="100px" />
												 	</div>
												    <span class="error"></span>
												</div>											
											</div>

										</div>
									</div>
								</div>


								<div class="row">
									<h2>LAST ACADEMICS DETAILS</h2>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Examination Passed / Class Studying :</label>
										<input name="last_ac_exam_passed" id="last_ac_exam_passed" type="text" class="form-control" placeholder="Examination Passed / Class Studying">
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Year:</label>
										<input name="last_ac_year" id="last_ac_year" type="text" class="form-control" placeholder="Year">
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Name of Board :</label>
										<input name="last_ac_board" id="last_ac_board" type="text" class="form-control" placeholder="Name of Board">
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Name of School:</label>
										<input name="last_ac_school_name" id="last_ac_school_name" type="text" class="form-control" placeholder="Name of School">
									</div>

									<div class="col-sm-4 mb-3">
										<label class="form-label">Roll No:</label>
										<input name="last_ac_roll_no" id="last_ac_roll_no" type="text" class="form-control" placeholder="Roll No">
									</div>
									<div class="col-sm-4 mb-3">
										<label class="form-label">Max. marks:</label>
										<input name="last_ac_max_mark" id="last_ac_max_mark" type="text" class="form-control" placeholder="Max. marks">
									</div>
									<div class="col-sm-4 mb-3">
										<label class="form-label">Mark obtained:</label>
										<input name="last_ac_marks" id="last_ac_marks" type="text" class="form-control" placeholder="Mark obtained">
									</div>

									<h2>Language Information</h2>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Grade: LKG onwards (2nd Language): <span class="required">*</span></label>
										<div class="form-check-horizontal">
											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="lkg_onw_sec_lang" value="Bengali" >
												<span class="form-check-label">Bengali</span>
											</label>

											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="lkg_onw_sec_lang" value="Hindi">
												<span class="form-check-label">Hindi</span>
											</label>
										</div>
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">Grade : Std.lll onwards (3rd Language):</label>
										<div class="form-check-horizontal">
											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input"  name="std_three_sec_lang" value="Bengali" checked="">
												<span class="form-check-label">Bengali</span>
											</label>

											<label class="form-check form-check-inline">
												<input type="radio" class="form-check-input"  name="std_three_sec_lang" value="Hindi">
												<span class="form-check-label">Hindi</span>
											</label>
										</div>
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">If school transport is required, choose stoppage:</label>
										<select name="stoppage" id="stoppage" class="form-control" >
											<option value=""> ----- Select stoppage ----- </option>
											<?php 
											if( isset($stoppage_list) && !empty($stoppage_list) ) {
												foreach($stoppage_list as $stoppage): ?>							
													<option value="<?= $stoppage['stoppage_id'] ?>"><?= $stoppage['stoppage_name'] ?></option>
												<?php endforeach; 
											} ?>
										</select>
									</div>
									<div class="col-sm-6 mb-3">
										<label class="form-label">I do here by declare that the above information furnished by me is true to the best of my knowledge & belief.:</label>
										<div class="row">
											<div class="col-sm-5">
												<input name="s_signature" id="s_signature" type="file" class="form-control">
												<div class="form-text text-muted">(Image width should be within 14x4 cm)</div>
											</div>											
											<div class="col-sm-7">
												<div> 
													<img src="#" id="s_signature_preview" alt="Image Preview">
											 	</div>
											    <span class="error"></span>
											</div>											
										</div>

										
									</div>



									<div class="col-sm-3 mb-3 text-center">
										<span>----------------------------------------------------------</span>
										<label class="form-label">Verified by:</label>
									</div>
									<div class="col-sm-3 mb-3 text-center">
										<span>----------------------------------------------------------</span>
										<br />
										<label class="form-label">        Date:</label>
									</div>
									<div class="col-sm-3 mb-3 text-center">
										<div class="row">
											<img src="#" id="p_signature_preview" alt="Image Preview" width="350px">
											<br />
											<span>----------------------------------------------------------</span>
											<label class="form-label">Signature of Parent :</label>
											<input name="p_signature" id="p_signature" type="file" class="form-control">
											<div class="form-text text-muted">(Image width should be within 14x4 cm)</div>
											<span class="error"></span>
										</div>
									</div>
									<div class="col-sm-3 mb-3 text-center">
										<span>----------------------------------------------------------</span>
										<label class="form-label">Approved by:</label>
									</div>



									<div class="text-center">
										<button type="submit" class="btn btn-primary">Submit form <i class="ph-paper-plane-tilt ms-2"></i></button>
									</div>
								
								</div>
							</div>
						</form>
		            </div>
				</div>
				<!-- /content area -->


				<!-- Footer -->
				<div class="navbar navbar-sm navbar-footer border-top">
					<div class="container-fluid">
						<span>© <?= date('Y') ?> </span>
					</div>
				</div>
				<!-- /footer -->

			</div>
			<!-- /inner content -->

			<div class="btn-to-top btn-to-top-visible" >
				<button class="btn btn-secondary btn-icon rounded-pill" type="button"><i class="ph-arrow-up"></i></button>
			</div>
		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


	<script> 
		$(document).ready(function () {

		    // Convert to uppercase while typing
		    $('input[type="text"]').on('input', function () {
		        this.value = this.value.toUpperCase();
		    });

		    // Ensure uppercase when user leaves the field
		    $('input[type="text"]').on('blur', function () {
		        this.value = this.value.toUpperCase();
		    });

			$('input[name="lkg_onw_sec_lang"]').on('change', function () {
			    let selected = $(this).val();

			    // Reverse selection
			    let reverse = (selected === 'Bengali') ? 'Hindi' : 'Bengali';

			    $('input[name="std_three_sec_lang"][value="' + reverse + '"]').prop('checked', true);
			});

		});

		$(document).ready(function(){ 
			$("#localGurdian").on("change", function(){ 
			    if($(this).is(":checked")){
			        $("#localGurdianBlk").show();
			    } else { 
			        $("#localGurdianBlk").hide();
			    } 
			});


			const maxWidthPx = 132; // 3.5 cm ≈ 132 px @96dpi 
			const maxHeightPx = 170; // 4.5 cm ≈ 170 px @96dpi 

			$("#profile-img-tag").hide(); 
			$("#f_signature_preview").hide(); 
			$("#f_image_preview").hide(); 
			$("#m_signature_preview").hide(); 
			$("#m_image_preview").hide(); 
			$("#g_image_preview").hide(); 
			$("#g_signature_preview").hide(); 
			$("#s_signature_preview").hide(); 
			$("#p_signature_preview").hide(); 

			validateImage("#userfile", "#profile-img-tag", maxWidthPx, maxHeightPx);
			validateImage("#f_signature", "#f_signature_preview", 529, 151); // 14x4 cm
			validateImage("#f_image", "#f_image_preview", maxWidthPx, maxHeightPx);
			validateImage("#m_signature", "#m_signature_preview", 529, 151);
			validateImage("#m_image", "#m_image_preview", maxWidthPx, maxHeightPx);
			validateImage("#g_signature", "#g_signature_preview", 529, 151);
			validateImage("#g_image", "#g_image_preview", maxWidthPx, maxHeightPx);
			validateImage("#s_signature", "#s_signature_preview", 529, 151);
			validateImage("#p_signature", "#p_signature_preview", 529, 151);






			/*$('#d_o_b').on('change', function() {
				$('#class_id').prop('selectedIndex',0);
			});*/
			
			$('#d_o_b').datepicker({
			  	dateFormat: 'yy-mm-dd',
			  	onSelect: function() {
			    	$('#class_id').prop('selectedIndex', 0);
		 	 	}
			});

			$('#class_id').on('change', function() {
				var classId = $(this).val();
				//var regDay = $('.reg_date').val();
				var className = $("#class_id option:selected").text();

				if(classId){
					var bDay = $('#d_o_b').val();
					
					if(bDay){
						dob = new Date(bDay);						
						var today = new Date();
						var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

						$.ajax({
							url:'<?= base_url('/get-age-limit') ?>',
							method: 'post',					
							data: {classId : classId, age : age, bDay : bDay},				  
							success: function(data){
								if(data > 0){
									alert('You are Eligible for '+className);
								} else {
									alert('Your are not eligible for admission');
									$('#class_id').prop('selectedIndex',0);
									$('#d_o_b').val('');
									$('.optional_sub').hide();
								}
							}
						})
						
						/*if(age>=3){
							$.ajax({
								url:'<?= base_url('/get-age-limit') ?>',
								method: 'post',					
								data: {classId : classId, age : age, bDay : bDay},				  
								success: function(data){
									if(data > 0){
										alert('You are Eligible for '+className);
									} else {
										alert('Your are not eligible for admission');
										$('#class_id').prop('selectedIndex',0);
										$('#d_o_b').val('');
										$('.optional_sub').hide();
									}
								}
							})
						} else {
							alert('Your are not eligible for '+className);
							$('#class_id').prop('selectedIndex',0);
							$('#d_o_b').val('');
							$('.optional_sub').hide();
						}*/
						
					} else {
						alert('Please select Date of Birth');
						$('#class_id').prop('selectedIndex',0);
						$('#d_o_b').val('');
						$('.optional_sub').hide();
					}
					
					//Get subject list
					if(classId > 13){
						$('.optional_sub').show();
						$.ajax({
							url:'<?= base_url('get-class-subjects') ?>',
							method: 'post',					
							data: {classId : classId},
							dataType:"json",//return type expected as json
							success: function(data){
							   	$('#first_elective_sub').html(data[0]);
								$('#second_elective_sub').html(data[1]);
								$('#third_elective_sub').html(data[2]);
								$('#fourth_elective_sub').html(data[3]);
								$('#fifth_elective_sub').html(data[4]);
								$('#sixth_elective_sub').html(data[5]);
						
							}
						})
					}
					//
					
				} else {
					alert('Please select class and Date of Birth');					
					$('#class_id').prop('selectedIndex',0);
					$('#d_o_b').val('');
				}
			});



		});


		/**
		 * Validate and preview image upload
		 * @param {string} inputSelector - File input selector (e.g. "#userfile")
		 * @param {string} previewSelector - Preview image selector (e.g. "#profile-img-tag")
		 * @param {string} errorSelector - Error message selector (e.g. ".error")
		 * @param {number} maxWidthPx - Max allowed width in px
		 * @param {number} maxHeightPx - Max allowed height in px
		 */
		function validateImage(inputSelector, previewSelector, maxWidthPx, maxHeightPx) {
			$(inputSelector).on("change", function(e){
				const $input = $(this);
				const $row = $input.closest(".row");      // find the parent row
				const $error = $row.find(".error");       // find error within the row
				const $preview = $row.find(previewSelector); // find preview within the row

				// const widthCm = pxToCm(maxWidthPx);
    			// const heightCm = pxToCm(maxHeightPx);

				$error.text(""); 
				$preview.hide();

				const file = e.target.files[0]; 
				if(!file){ 
				  	$error.text("No file chosen."); 
				  	return; 
				} 

				if(!file.type.match("image.*")){ 
				  	$error.text("Please select a valid image file."); 
				  	$input.val(""); 
				  	return; 
				} 

				const reader = new FileReader(); 
				reader.onload = function(evt){ 
				  	const img = new Image(); 
					img.onload = function(){ 
						if(img.width > maxWidthPx || img.height > maxHeightPx){ 
						  	$error.text(
						    	"Image should be within ("+maxWidthPx+"x"+maxHeightPx+"px)."
						  	);
						  	$input.val(""); 
						} else { 
						  	$preview.attr("src", evt.target.result).show(); 
						} 
					}; 
					img.src = evt.target.result; 
				}; 
				reader.readAsDataURL(file); 
			});
		}
	</script>

 	<script>
 		$('.gDate').hide();
		$('#academic_status').change(function(){
			var acStatus = $(this).val();
			if(acStatus == 'Left' || acStatus == 'TC'){
				$('.gDate').show();
				$("#tc_date").prop('disabled', false);
			} else {
				$('.gDate').hide();
				$("#tc_date").prop('disabled', true);
			}
		});

        $(document).ready(function() {
            // Custom validation method for contact number
            $.validator.addMethod("contactDigits", function(value, element) {
                return this.optional(element) || /^\d{10}$/.test(value);
            }, "Contact number must be exactly 10 numeric digits");
            
            // Custom validation method for Aadhaar number
            $.validator.addMethod("aadhaarDigits", function(value, element) {
                return this.optional(element) || /^\d{12}$/.test(value);
            }, "Aadhaar number must be exactly 12 numeric digits");
            
            // Custom validation method for annual income
            $.validator.addMethod("numericOnly", function(value, element) {
                return this.optional(element) || /^\d+$/.test(value);
            }, "Annual income must be a numeric value");
            
            // Custom validation method for photo size
            $.validator.addMethod("photoSize", function(value, element) {
                if (element.files.length === 0) {
                    return false;
                }
                const fileSize = element.files[0].size / 1024; // Convert to KB
                return fileSize <= 40;
            }, "Photo size must be less than 40 KB");
            
            // Initialize form validation
            $("#registrationForm").validate({
                rules: {
                	gender: {
					    required: true
					},
                	lkg_onw_sec_lang: {
					    required: true
					},
                	first_name: {
                        required: true,
                    },
                    d_o_b: {
                        required: true,
                    },
                    class_id: {
                        required: true,
                    },
                    father_name: {
                        required: true,
                    },
                    father_mobile: {
                        required: true,
                        contactDigits: true
                    },
                    mother_name: {
                        required: true,
                    },
                    mother_mobile: {
                        required: true,
                        contactDigits: true
                    },
                    permanent_address: {
                        required: true,
                    },

                    /*pincode: {
                        required: true,
                    },
                    telephone_resi: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    aadhaar_no: {
                        required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            aadhaarDigits: function(element) {
			                return $(element).val().trim() !== '';
			            }
                    },
                    father_aadhaar_no: {
                        required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            aadhaarDigits: function(element) {
			                return $(element).val().trim() !== '';
			            }
                    },
                    mother_aadhaar_no: {
                        required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            aadhaarDigits: function(element) {
			                return $(element).val().trim() !== '';
			            }
                    },
                    local_guar_aadhaar_no: {
                        required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            aadhaarDigits: function(element) {
			                return $(element).val().trim() !== '';
			            }
                    },
			        father_annual_income: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            numericOnly: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
			        mother_annual_income: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            numericOnly: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
                    local_guar_annual_income: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            numericOnly: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },*/

                    userfile: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            photoSize: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
			        f_image: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            photoSize: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
			        f_signature: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            photoSize: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
			        m_image: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            photoSize: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
			        m_signature: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            photoSize: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
			        g_image: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            photoSize: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
			        g_signature: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            photoSize: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
			        last_year_marksheet: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            photoSize: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
			        student_id: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            photoSize: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
			        student_admit: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            photoSize: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
			        father_id: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            photoSize: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
			        mother_id: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            photoSize: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
			        cast_certificate: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            photoSize: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
			        s_signature: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            photoSize: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
			        p_signature: {
			            required: function(element) {
			                return $(element).val().trim() !== '';
			            },
			            photoSize: function(element) {
			                return $(element).val().trim() !== '';
			            }
			        },
                },
                messages: {
                	gender: {
					    required: "Please select a gender"
					},
                	lkg_onw_sec_lang: {
					    required: "Please select a 2nd language"
					},
                    first_name: {
                        required: "Please enter your name"
                    },
                    d_o_b: {
                        required: "Please enter your DOB"
                    },
                    class_id: {
                        required: "Please select your class"
                    },
                    father_name: {
					    required: "Please enter father's name"
					},
					father_mobile: {
					    required: "Please enter father's mobile number",
					    contactDigits: "Please enter a valid mobile number"
					},
					mother_name: {
					    required: "Please enter mother's name"
					},
					mother_mobile: {
					    required: "Please enter mother's mobile number", 
					    contactDigits: "Please enter a valid mobile number"
					},
					permanent_address: {
					    required: "Please enter permanent address"
					},
					/*pincode: {
					    required: "Please enter pincode"
					},
					telephone_resi: {
					    required: "Please enter telephone number"
					},
					email: {
					    required: "Please enter email address"
					},
					aadhaar_no: {
			            required: "Please enter Aadhaar number",
			            aadhaarDigits: "Please enter a valid Aadhaar number"
			        },
			        father_aadhaar_no: {
			            required: "Please enter Aadhaar number",
			            aadhaarDigits: "Please enter a valid Aadhaar number"
			        },
			        mother_aadhaar_no: {
			            required: "Please enter Aadhaar number",
			            aadhaarDigits: "Please enter a valid Aadhaar number"
			        },
			        local_guar_aadhaar_no: {
			            required: "Please enter Aadhaar number",
			            aadhaarDigits: "Please enter a valid Aadhaar number"
			        },
			        father_annual_income: {
			            required: "Please enter income",
			            numericOnly: "Please enter valid income amount"
			        },
			        mother_annual_income: {
			            required: "Please enter income",
			            numericOnly: "Please enter valid income amount"
			        },
			        local_guar_annual_income: {
			            required: "Please enter income",
			            numericOnly: "Please enter valid income amount"
			        },*/
			        userfile: {
			            required: "Please select a photo",
			            photoSize: "Photo size should be appropriate"
			        },
			        f_image: {
			            required: "Please select a photo",
			            photoSize: "Photo size should be appropriate"
			        },
			        f_signature: {
			            required: "Please select a photo",
			            photoSize: "Photo size should be appropriate"
			        },
			        m_image: {
			            required: "Please select a photo",
			            photoSize: "Photo size should be appropriate"
			        },
			        m_signature: {
			            required: "Please select a photo",
			            photoSize: "Photo size should be appropriate"
			        },
			        g_image: {
			            required: "Please select a photo",
			            photoSize: "Photo size should be appropriate"
			        },
			        g_signature: {
			            required: "Please select a photo",
			            photoSize: "Photo size should be appropriate"
			        },
			        last_year_marksheet: {
			            required: "Please select a photo",
			            photoSize: "Photo size should be appropriate"
			        },
			        student_id: {
			            required: "Please select a photo",
			            photoSize: "Photo size should be appropriate"
			        },
			        student_admit: {
			            required: "Please select a photo",
			            photoSize: "Photo size should be appropriate"
			        },
			        father_id: {
			            required: "Please select a photo",
			            photoSize: "Photo size should be appropriate"
			        },
			        mother_id: {
			            required: "Please select a photo",
			            photoSize: "Photo size should be appropriate"
			        },
			        cast_certificate: {
			            required: "Please select a photo",
			            photoSize: "Photo size should be appropriate"
			        },
			        s_signature: {
			            required: "Please select a photo",
			            photoSize: "Photo size should be appropriate"
			        },
			        p_signature: {
			            required: "Please select a photo",
			            photoSize: "Photo size should be appropriate"
			        },

                },
                errorElement: "span",
                errorClass: "error",
                validClass: "valid",
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass(errorClass).removeClass(validClass);
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass(errorClass).addClass(validClass);
                },
                submitHandler: function(form) {
                    // alert("Form submitted successfully! All validations passed.");
                    // In a real application, you would submit the form here
                    form.submit();
                }
            });
            
            // Show file info when a file is selected
            $('#photo').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const fileSize = file.size / 1024; // Convert to KB
                    $('#fileInfo').text(`Selected file: ${file.name} (${fileSize.toFixed(2)} KB)`);
                } else {
                    $('#fileInfo').text('No file selected');
                }
            });
        });
    </script>	
</body>
</html>

