<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script src="<?= base_url('public/admin/assets/js/vendor/forms/validation/validate.min.js') ?>"></script>

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
    	$("#showMsg").html("")
	    $("#addMemberForm").validate({
	        rules: {
	            user_id: {
	                required: true
	            },
	            first_name: {
	                required: true,
	            },
	            last_name: {
	                required: true,
	            },
	            password: {
	                required: true,
	                minlength: 6
	            },
	            password_confirm: {
	                required: true,
	                equalTo: "#password" 
	            },
	            user_type: {
	                required: true,
	            },
	            code: {
	                required: true,
	            }
	        },
	        messages: {
	            user_id: "Please enter a User Id.",
	            first_name: "Please enter a First Name",
	            last_name: "Please enter a Last Name",
	            password: {
		            required: "Please enter a Password",
		            minlength: "Password must be at least 6 characters long"
		        },
		        password_confirm: {
		            required: "Please confirm your password",
		            equalTo: "Passwords do not match"
		        },
	            user_type: "Please select a Category (User Type)",
	            code: "Please enter a Employee Code",
	        },
	        submitHandler: function (form) {
	        	console.log("Hello")
	        	var formData = new FormData(form);

	        	$.ajax({
	                url: "<?= base_url('admin/staff-management/admin-members/store') ?>",
	                type: "POST",
		            data: formData,
		            processData: false,
		            contentType: false,
		            dataType: "json",
		            beforeSend: function() {
		                // optional: show loader
		                $("#addMemberFormSubmit").prop("disabled", true);
		            },
		            success: function(response) {
		            	console.log(response)
		            	console.log(response.status)
		            	// alert("❌ Error: " + JSON.stringify(response.message));
		                if (response.status === "success") {
		                    let msgHtml = '<div class="alert alert-primary border-0 alert-dismissible fade show">'+response.message+'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'
	                        $("#showMsg").html(msgHtml)

		                    $("#addMemberForm")[0].reset();
		                    $("#addMemberFormSubmit").prop("disabled", false);
		                } else {
		                    // alert("❌ Error: " + JSON.stringify(response.message));
		                    let msgHtml = '<div class="alert alert-danger border-0 alert-dismissible fade show">'+JSON.stringify(response.message)+'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'
	                        $("#showMsg").html(msgHtml)
		                }
		            },
		            error: function(xhr) {
		                console.log(xhr.responseText);
		                console.log("Something went wrong!");
		            },
		            complete: function() {
		                $("#addMemberFormSubmit").prop("disabled", false);
		            }
	            });

	        }
	    })

	    // Trigger validation + AJAX on button click
	    $(document).on("click", "#addMemberFormSubmit", function () {
	        $("#addMemberForm").submit();
	    });

	    $('#same_address').change(function() {
	    	if ($(this).is(':checked')) {
	    		// Copy values
            	$('#present_address').val($('#permanent_address').val());

            	// Keep them in sync
	            $('#present_address, #permanent_address').on('keyup change', function() {
	                if ($('#same_address').is(':checked')) {
	                    $('#present_address').val($('#permanent_address').val());
	                }
	            });
	    	}
	    });
	})
</script>

<!-- Page header -->
<div class="page-header page-header-primary shadow">
	<div class="page-header-content d-lg-flex border-top">
		<div class="d-flex">
			<div class="breadcrumb py-2">
				<a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
				<a href="javascript:;" class="breadcrumb-item"><?= $title ?></a>
				<!-- <span class="breadcrumb-item active">Validation styles</span> -->
			</div>

			<a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
				<i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
			</a>
		</div>		
	</div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
	<!-- Edit area -->
	<div class="row" >
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0"><?= $title ?></h5>
				</div>
				<div id="showMsg"></div>
				<form method="post" class="needs-validation" action="<?= base_url('admin/staff-management/admin-members/store') ?>" novalidate id="addMemberForm" data-id="" enctype="multipart/form-data">
					<div class="card-body">
						<div class="row mb-3">
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Profile Picture</label>
								<div class="col-lg-12">
									<input name="pro_image" id="pro_image" type="file" class="form-control" />
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">User Id <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<input name="user_id" id="user_id" type="text" class="form-control" required placeholder="User Id">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">First Name <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<input name="first_name" id="first_name" type="text" class="form-control" required placeholder="First Name">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Last Name <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<input name="last_name" id="last_name" type="text" class="form-control" required placeholder="Last Name">
								</div>
							</div>
							
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Password <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<input name="password" id="password" type="password" class="form-control" required placeholder="********">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Confirm Password <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<input name="password_confirm" id="password_confirm" type="password" class="form-control" required placeholder="********">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Employee Code <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<input name="code" id="code" type="text" class="form-control" required placeholder="Employee Code">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Category (User Type)  <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<select class="form-control" name="user_type" id="user_type" required>
										<option value="">-- Select --</option>
										<?php
											if(isset($dept_list) && !empty($dept_list)) {
												foreach ($dept_list as $dept) {
													echo '<option value="'.$dept["id"].'">'.$dept["name"].'</option>';
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Designation</label>
								<div class="col-lg-12">
									<select class="form-control" name="designation_id" id="designation_id" >
										<option value="">-- Select --</option>
										<?php
											if(isset($designation_list) && !empty($designation_list)) {
												foreach ($designation_list as $designation) {
													echo '<option value="'.$designation["id"].'">'.$designation["name"].'</option>';
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Pancard Number</label>
								<div class="col-lg-12">
									<input name="pancard_number" id="pancard_number" type="text" class="form-control" placeholder="Pancard Number">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Permanent Address</label>
								<div class="col-lg-12">
									<textarea class="form-control" name="address" id="permanent_address" rows="5" cols="40"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-12">Present Address <span style="color: red;"><input type="checkbox" id="same_address">(Same as Permanent Address)</span></label>
								<div class="col-lg-12">
									<textarea class="form-control" name="present_address" id="present_address" rows="5" cols="40"></textarea>
								</div>
							</div>
							
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Aadhar Number</label>
								<div class="col-lg-12">
									<input name="aadhar_number" id="aadhar_number" type="text" class="form-control" placeholder="Aadhar Number">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Whatsapp No</label>
								<div class="col-lg-12">
									<input name="phone_no_other" id="phone_no_other" type="text" class="form-control" placeholder="Whatsapp No">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Bank Name</label>
								<div class="col-lg-12">
									<input name="bank_name" id="bank_name" type="text" class="form-control" placeholder="Bank Name">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Bank Account Number</label>
								<div class="col-lg-12">
									<input name="bank_acc_number" id="bank_acc_number" type="text" class="form-control" placeholder="Bank Account Number">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Bank IFSC Number</label>
								<div class="col-lg-12">
									<input name="bank_ifsc_number" id="bank_ifsc_number" type="text" class="form-control" placeholder="Bank IFSC Number">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">ESIC Number</label>
								<div class="col-lg-12">
									<input name="esic_number" id="esic_number" type="text" class="form-control" placeholder="ESIC Number">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">PF/UAN Number</label>
								<div class="col-lg-12">
									<input name="pf_number" id="pf_number" type="text" class="form-control" placeholder="PF/UAN Number">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">OASIS ID</label>
								<div class="col-lg-12">
									<input name="oasis_id" id="oasis_id" type="text" class="form-control" placeholder="OASIS ID">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Spouse Name</label>
								<div class="col-lg-12">
									<input name="spouse_name" id="spouse_name" type="text" class="form-control" placeholder="Spouse Name">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Joining Date</label>
								<div class="col-lg-12">
									<input name="joining_date" id="joining_date" type="text" class="form-control datepicker-basic datepicker-input" placeholder="Joining Date">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Subject Taught</label>
								<div class="col-lg-12">
									<input name="subject_tought" id="subject_tought" type="text" class="form-control" placeholder="Subject Taught">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Class Taken</label>
								<div class="col-lg-12">
									<input name="class_taken" id="class_taken" type="text" class="form-control" placeholder="Class Taken">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">State / Province</label>
								<div class="col-lg-12">
									<input name="state" id="state" type="text" class="form-control" placeholder="State / Province">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Postal / Zip Code</label>
								<div class="col-lg-12">
									<input name="pincode" id="pincode" type="text" class="form-control" placeholder="Postal / Zip Code">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Country</label>
								<div class="col-lg-12">
									<select class="form-control" name="country" id="country">
									  	<option value="">-- Select --</option>
									  	<option value="India">India</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">City</label>
								<div class="col-lg-12">
									<input name="city" id="city" type="text" class="form-control" placeholder="City">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Qualification</label>
								<div class="col-lg-12">
									<input name="qualification" id="qualification" type="text" class="form-control" placeholder="Qualification">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Extra Qualification</label>
								<div class="col-lg-12">
									<input name="extra_qualification" id="extra_qualification" type="text" class="form-control" placeholder="Extra Qualification">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Experience</label>
								<div class="col-lg-12">
									<input name="experience" id="experience" type="text" class="form-control" placeholder="Experience">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Phone Number</label>
								<div class="col-lg-12">
									<input name="mobile" id="mobile" type="text" class="form-control" placeholder="Phone Number">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Email</label>
								<div class="col-lg-12">
									<input name="user_email" id="user_email" type="emaill" class="form-control" placeholder="Email">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Date of Birth</label>
								<div class="col-lg-12">
									<input name="date_of_birth" id="date_of_birth" type="text" class="form-control datepicker-basic datepicker-input" placeholder="Date of Birth">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Gender</label>
								<div class="col-lg-12">
									<input name="gender" id="genderMale" type="radio" class="form-check-input" value="Male" checked> Male
									<input name="gender" id="genderFemale" type="radio" class="form-check-input" value="Female"> Female
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-4">Status</label>
								<div class="col-lg-12">
									<input name="status" id="statusActive" type="radio" class="form-check-input" value="1" checked> Active
									<input name="status" id="statusInactive" type="radio" class="form-check-input" value="0"> Inactive
								</div>
							</div>

						</div>
					</div>

					<div class="card-footer text-end">
						<button id="addMemberFormSubmit" type="button" class="btn btn-primary">Add <i class="ph-paper-plane-tilt ms-2"></i></button>
					</div>
				</form>

			</div>
		</div>
	</div>
	<!-- /Add area -->
</div>
<!-- /content area -->