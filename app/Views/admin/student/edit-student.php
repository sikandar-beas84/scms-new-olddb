<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

<style>
	.required {
		color: red;
	}
	input[readonly] {
	    background-color: #f0f0f0; /* light gray background */
	    color: #555;              /* optional: change text color */
	    border: 1px solid #ccc;   /* optional: adjust border */
	    cursor: not-allowed;      /* optional: indicate readonly */
	}

	/*.p_signature_section {
	    text-align: center;
	}

	.p_signature_section img {
	    display: inline-block;
	    margin: 0 auto;
	    height: 75px;
	    width: 250px;
	}*/

	.p_signature_section {
	    display: flex;
	    flex-direction: column;
	    align-items: center;
	    justify-content: center;
	}

	.p_signature_section img {
	    max-width: 100%;        /* responsive */
	    height: auto;           /* maintain aspect ratio */
	}

	.preview_img {
		height: 100px;
		width: auto;
	}

</style>

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


<!-- Page header -->
<div class="page-header page-header-primary shadow">
	<div class="page-header-content d-lg-flex border-top">
		<div class="d-flex">
			<div class="breadcrumb py-2">
				<a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
				<a href="javascript:;" class="breadcrumb-item"><?= $title ?></a>
			</div>

			<a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
				<i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
			</a>
		</div>		
	</div>
</div>
<!-- /page header -->


<?php // pr($student_details); ?>
<!-- Content area -->
<div class="content">
	<!-- Custom styles -->
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0"><?= $title ?></h5>
				</div>
				
				<?php if(session()->has('success')): ?>
				    <div class="alert alert-success alert-dismissible fade show" role="alert">
				        <?= session('success') ?>
				        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				    </div>
				<?php endif; ?>

				<?php if(session()->has('error')): ?>
				    <div class="alert alert-danger alert-dismissible fade show" role="alert">
				        <?= session('error') ?>
				        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				    </div>
				<?php endif; ?>

				<?php if (session()->getFlashdata('errors')): ?>
				    <div class="alert alert-danger alert-dismissible fade show">
				        <ul>
				            <?php foreach (session()->getFlashdata('errors') as $error): ?>
				                <li><?= esc($error) ?></li>
				            <?php endforeach ?>
				        </ul>
				        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				    </div>
				<?php endif ?>

				<form method="post" class="needs-validation" action="<?= base_url() ?>admin/student/studentupdate/<?= $student_id ?>" novalidate id="studentUpdateForm" data-id="" enctype="multipart/form-data">
					<div class="card-body">
						<div id="showMsg"></div>


						<div class="row">
							<div class="col-sm-12 mb-3" style="display: none;">
							    <div class="mb-3">
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
							</div>
							
							<input type="hidden" name="form_no" id="form_no" value="<?= $student_details['form_no'] ?>" />
							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Student Code: </label>
							        <input type="text" name="student_code" id="student_code" class="form-control" placeholder="Student Code" value="<?= $student_details['code'] ?>" readonly />
							    </div>
							</div>
							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Name: <span class="required">*</span></label>
							        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter Name" value="<?= $student_details['first_name'] ?>" required />
							    </div>
							</div>





							<div class="col-lg-3">
								<h6 class="text-primary mb-2 mt-lg-2">Photo to be attached</h6>
								<div class="row">
									<div class="col-sm-6">
										<input type="file" class="form-control-file characterImage1 valid" id="userfile" name="userfile" data-validation="mime" data-validation-allowing="jpg, png, gif" data-validation-error-msg-required="No image selected">
										<br />
										<b>(Image under 20 to 200kb)</b>
									</div>									
									<div class="col-sm-6">
										<?php 
										$getImgUrl = $student_details['image'] ?? '';
										$fullImgUrl = ($getImgUrl != '') ? base_url('uploads/'.$getImgUrl) : '#';
										if( $getImgUrl != "") {
										?>
											<img src="<?= $fullImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
										<?php } ?>
										<div> 
											<img class="preview_img" src="#" id="profile-img-tag" alt="Image Preview">
									 	</div>
									    <span class="error"></span>
									</div>									
								</div>
								<div class="has-success">
								 	
								</div>
							</div>


							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Gender: <span class="required">*</span></label>
							        <div class="form-check-horizontal">
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="gender" value="Male" <?php if($student_details['gender'] == "Male") { echo 'checked'; }elseif($student_details['gender'] == ""){  echo 'checked'; } ?> />
							                <span class="form-check-label">Male</span>
							            </label>
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="gender" value="Female" <?php if($student_details['gender'] == "Female") { echo 'checked'; } ?> />
							                <span class="form-check-label">Female</span>
							            </label>
							        </div>
							    </div>
							</div>
							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Shift: <span class="required">*</span></label>
							        <div class="form-check-horizontal">
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="shift" value="Day" <?php if(isset($student_details['shift']) && $student_details['shift'] == "Day") { echo 'checked'; } ?> />
							                <span class="form-check-label">Day</span>
							            </label>
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="shift" value="Morning" <?php if(isset($student_details['shift']) && $student_details['shift'] == "Morning") { echo 'checked'; }elseif( !isset($student_details['shift']) ){  echo 'checked'; } ?> />
							                <span class="form-check-label">Morning</span>
							            </label>
							        </div>
							    </div>
							</div>
							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label" style="color: red;">Bangla Sikhsha ID: </label>
							        <input type="text" name="bs_id" id="bs_id" class="form-control" placeholder="Enter Bangla Sikhsha ID" value="<?= $student_details['bs_id'] ?>"  />
							    </div>
							</div>

							<div class="col-lg-3">
							    <!-- Empty column for spacing -->
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Aadhar No:</label>
							        <input type="text" name="aadhaar_no" id="aadhaar_no" class="form-control" placeholder="Aadhar No" value="<?= $student_details['aadhaar_no'] ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Date of Birth: <span class="required">*</span></label>
							        <input name="d_o_b" id="d_o_b" type="text" class="form-control datepicker-basic datepicker-input" value="<?= $student_details['d_o_b'] ?>" required autocomplete="off" readonly />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Class: <span class="required">*</span></label>
							        <select name="class_id" id="class_id" class="form-control" required="">
							            <option value=""> ----- Select ----- </option>
							            <?php if( isset($class) && !empty($class) ) {
							                foreach ($class as $class_value) {
							                	$selected = '';
							                	if($student_details['class_id'] == $class_value['id']) {
							                		$selected = 'selected';
							                	}
							                    echo '<option value="'.$class_value['id'].'" '.$selected.'>'.$class_value['class_name'].'</option>';
							                }
							            } ?>
							        </select>
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Religion: </label>
							        <select name="religion" id="religion" class="form-control">
							            <option value="">Select Religion</option>
							            <?php 
							            if( isset($religion_list) && !empty($religion_list) ) {
							                foreach($religion_list as $religion):
							                	$selected = '';
							                	if($student_details['religion'] == $religion['id']) {
							                		$selected = 'selected';
							                	} ?>                            
							                    <option value="<?= $religion['id'] ?>" <?= $selected ?>><?= $religion['name'] ?></option>
							                <?php endforeach; 
							            } ?>
							        </select>
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Nationality:</label>
							        <input type="text" name="nationality" id="nationality" class="form-control" placeholder="Nationality" value="<?= $student_details['nationality'] ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Category: (Photocopy required during admission)</label>
							        <div class="form-check-horizontal">
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="caste" value="SC" <?php if($student_details['caste'] == "SC") { echo 'checked'; } ?> />
							                <span class="form-check-label">SC</span>
							            </label>
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="caste" value="ST" <?php if($student_details['caste'] == "ST") { echo 'checked'; } ?> />
							                <span class="form-check-label">ST</span>
							            </label>
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="caste" value="OBC" <?php if($student_details['caste'] == "OBC") { echo 'checked'; } ?> />
							                <span class="form-check-label">OBC</span>
							            </label>
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="caste" value="GEN" <?php if($student_details['caste'] == "GEN") { echo 'checked'; }elseif($student_details['gender'] == "") { echo 'checked'; } ?> />
							                <span class="form-check-label">GEN</span>
							            </label>
							        </div>
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">BPL:</label>
							        <div class="form-check-horizontal">
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="bpl" value="1" <?php if($student_details['bpl'] == "1") { echo 'checked'; } ?> />
							                <span class="form-check-label">Yes</span>
							            </label>
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="bpl" value="0" <?php if($student_details['bpl'] == "0") { echo 'checked'; }elseif($student_details['bpl'] == "") { echo 'checked'; } ?> />
							                <span class="form-check-label">No</span>
							            </label>
							        </div>
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">BPL Number:</label>
							        <input name="bpl_number" id="bpl_number" type="text" class="form-control" placeholder="BPL Number" value="<?= $student_details['bpl_number'] ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">TC Required :</label>
							        <div class="form-check-horizontal">
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="tc_required" value="1" <?php if($student_details['tc_required'] == "1") { echo 'checked'; } ?> />
							                <span class="form-check-label">Yes</span>
							            </label>
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="tc_required" value="0" <?php if($student_details['tc_required'] == "0") { echo 'checked'; }elseif($student_details['tc_required'] == "") { echo 'checked'; } ?> />
							                <span class="form-check-label">No</span>
							            </label>
							        </div>
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">TC No:</label>
							        <input type="text" name="pre_school_tc_no" id="pre_school_tc_no" class="form-control" placeholder="TC No" value="<?= $student_details['tc_no'] ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">TC Submitted Date :</label>
							        <input name="pre_school_tc_date" id="pre_school_tc_date" type="text" class="form-control datepicker-basic datepicker-input" placeholder="" readonly value="<?= $student_details['tc_date'] ?>" />
							    </div>
							</div>
							<?php // pr($student_details); ?>
							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Migration Required :</label>
							        <div class="form-check-horizontal">
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="migration_required" value="1" <?php if(isset($student_details['migration_required']) && $student_details['migration_required'] == "1") { echo 'checked'; } ?> />
							                <span class="form-check-label">Yes</span>
							            </label>
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="migration_required" value="0" <?php if(isset($student_details['migration_required']) && $student_details['migration_required'] == "0") { echo 'checked'; }elseif(isset($student_details['migration_required']) && $student_details['migration_required'] == "") { echo 'checked'; } ?> />
							                <span class="form-check-label">No</span>
							            </label>
							        </div>
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Migration Submitted Date :</label>
							        <input name="migration_date" id="migration_date" type="text" class="form-control datepicker-basic datepicker-input" placeholder="" readonly value="<?= $student_details['migration_date'] ?? ''; ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Student Status :</label>
							        <div class="form-check-horizontal">
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="status" value="1" <?php if($student_details['student_status'] == "1") { echo 'checked'; }elseif($student_details['student_status'] == "") { echo 'checked'; } ?> />
							                <span class="form-check-label">Yes</span>
							            </label>
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="status" value="0" <?php if($student_details['student_status'] == "0") { echo 'checked'; } ?> />
							                <span class="form-check-label">No</span>
							            </label>
							        </div>
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Assign Academic Status :</label>
							        <div class="form-check-horizontal">
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="session_result_status" value="1" <?php if($student_details['session_result_status'] == "1") { echo 'checked'; }elseif($student_details['session_result_status'] == "") { echo 'checked'; } ?> />
							                <span class="form-check-label">Yes</span>
							            </label>
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="session_result_status" value="0" <?php if($student_details['session_result_status'] == "0") { echo 'checked'; } ?> />
							                <span class="form-check-label">No</span>
							            </label>
							        </div>
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label" style="color:red;">Damaged Product:</label>
							        <input name="dmg_prd" id="dmg_prd" type="text" class="form-control" placeholder="Damaged Product" value="<?= $student_details['dmg_prd'] ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label" style="color:red;">Damaged Product Price:</label>
							        <input name="dmg_prd_price" id="dmg_prd_price" type="text" class="form-control" placeholder="Damaged Product Price" value="<?= $student_details['dmg_prd_price'] ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label" style="color:red;">Security Amount:</label>
							        <input name="security_deposite" id="security_deposite" type="text" class="form-control" placeholder="Security Amount" value="<?= $student_details['security_deposite'] ?? ''; ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Mother tongue:</label>
							        <input name="mother_tongue" id="mother_tongue" type="text" class="form-control" placeholder="Mother tongue" value="<?= $student_details['mother_language'] ?? ''; ?>" />
							    </div>
							</div>

							<div class="col-lg-12">
							    <div class="mb-3">
							        <label class="form-label">Last Attended (If any): <span>(Original copy of TC, Report card, Migration certificate, Blood Group (Rh Factor) is required during admission)</span></label>
							        <input name="last_school_detail" id="last_school_detail" type="text" class="form-control" placeholder="Last Attended (If any)" value="<?= $student_details['last_school_detail'] ?? ''; ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Blood Group (RH Factor):</label>
							        <input name="blood_grp" id="blood_grp" type="text" class="form-control" placeholder="Blood Group (RH Factor)" value="<?= $student_details['blood_grp'] ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Immunization up to date (Please attached photocopy):</label>
							        <div class="form-check-horizontal">
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="immunization" value="Yes" <?php if($student_details['immunization'] == "Yes") { echo 'checked'; } ?> />
							                <span class="form-check-label">Yes</span>
							            </label>
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="immunization" value="No" <?php if($student_details['immunization'] == "No") { echo 'checked'; }elseif($student_details['immunization'] == "") { echo 'checked'; } ?> />
							                <span class="form-check-label">No</span>
							            </label>
							        </div>
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Academic Status: <span class="required">*</span></label>
							        <?php if($student_details['academic_status'] == "Free"){ ?>
							        	<span class="form-control"><?= $student_details['academic_status'] ?></span>
							        	<input type="hidden" name="academic_status" id="academic_status" class="form-control" value="<?= $student_details['academic_status'] ?>" required>
							        <?php }else { ?>
								        <select name="academic_status" id="academic_status" class="form-control" required >
								            <option value=""> ----- Select ----- </option>
								            <option value="TC" <?php if($student_details['academic_status'] == "TC") { echo 'selected'; } ?>>TC</option>
								            <option value="Bonafide" <?php if($student_details['academic_status'] == "Bonafide") { echo 'selected'; } ?>>Bonafide</option>
								            <option value="Left" <?php if($student_details['academic_status'] == "Left") { echo 'selected'; } ?>>Left</option>
								            <option value="Free" <?php if($student_details['academic_status'] == "Free") { echo 'selected'; } ?>>Free</option>
								            <option value="Not Admitted" <?php if($student_details['academic_status'] == "Not Admitted") { echo 'selected'; }elseif($student_details['academic_status'] == "") { echo 'selected'; } ?> >Not Admitted</option>
								        </select>
							        <?php } ?>
							    </div>
							</div>

							<div class="col-lg-3 gDate">
							    <div class="mb-3">
							        <label class="form-label">Generated Date:</label>
							        <input name="tc_date" id="tc_date" type="text" class="form-control datepicker-basic datepicker-input" placeholder="" readonly value="<?= $student_details['tc_date'] ?>" />
							    </div>
							</div>

							<div class="col-lg-3 gDate">
							    <div class="mb-3">
							        <label class="form-label">Medical condition:</label>
							        <textarea name="medical_condition" rows="3" cols="3" class="form-control" placeholder="Enter your Medical condition here"><?= $student_details['medical_condition'] ?></textarea>
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Only Child:</label>
							        <div class="form-check-horizontal">
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="only_child" value="Yes" <?php if($student_details['only_child'] == "Yes") { echo 'checked'; }elseif($student_details['only_child'] == "") { echo 'checked'; } ?> />
							                <span class="form-check-label">Yes</span>
							            </label>
							            <label class="form-check form-check-inline">
							                <input type="radio" class="form-check-input" name="only_child" value="No" <?php if($student_details['only_child'] == "No") { echo 'checked'; } ?> />
							                <span class="form-check-label">No</span>
							            </label>
							        </div>
							    </div>
							</div>

							

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">PEN No:</label>
							        <input type="text" name="pen_no" id="pen_no" class="form-control" placeholder="PEN No" value="<?= $student_details['pen_no'] ?? '' ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">APPAR ID:</label>
							        <input type="text" name="appar_id" id="appar_id" class="form-control" placeholder="APPAR ID" value="<?= $student_details['appar_id'] ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Admission Date:</label>
							        <input type="text" value="<?= (!empty($created_date)) ? date('jS M Y', strtotime($created_date)) : ''; ?>" class="form-control" placeholder="Office use only" disabled />
							        <!-- 4th Month Payment Date -->
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Student ID/Admission No:</label>
							        <input type="text" name="admission_number" id="admission_number" class="form-control" placeholder="Office use only"  value="<?= $student_details['admission_number'] ?>" />
							    </div>
							</div>







							<h2>PARENT'S DETAIL</h2>

							<div class="col-lg-6">
							    <div class="mb-3">
							        <label class="form-label">Mother's Image:</label>
							        <div class="row">
							            <div class="col-sm-8">
							                <input name="m_image" id="m_image" type="file" class="form-control" />
							                <div class="form-text text-muted">(Image under 20 to 200kb)</div>
							            </div>                            
							            <div class="col-sm-4">
                                        <?php 
                                        $getMotherImgUrl = $student_details['m_image'] ?? '';
                                        $fullMotherImgUrl = ($getMotherImgUrl != '') ? base_url('uploads/'.$getMotherImgUrl) : '#';
                                        if( $getMotherImgUrl != "") {
                                        ?>
                                            <img src="<?= $fullMotherImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
                                        <?php } ?>
							                <div> 
							                    <img class="preview_img" src="#" id="m_image_preview" alt="Image Preview" />
							                 </div>
							                <span class="error"></span>
							            </div>                            
							        </div>
							    </div>
							</div>

							<div class="col-lg-6">
							    <div class="mb-3">
							        <label class="form-label">Mother's Signature:</label>
							        <div class="row">
							            <div class="col-sm-8">
							                <input name="m_signature" id="m_signature" type="file" class="form-control" />
							                <div class="form-text text-muted">(Image width should be within 14x4 cm)</div>
							            </div>                            
							            <div class="col-sm-4">
							            	<?php 
	                                        $getMsignatureImgUrl = $student_details['m_signature'] ?? '';
	                                        $fullMsignatureImgUrl = ($getMsignatureImgUrl != '') ? base_url('uploads/'.$getMsignatureImgUrl) : '#';
	                                        if( $getMsignatureImgUrl != "") {
	                                        ?>
	                                            <img src="<?= $fullMsignatureImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
	                                        <?php } ?>
							                <div> 
							                    <img class="preview_img" src="#" id="m_signature_preview" alt="Image Preview" />
							                 </div>
							                <span class="error"></span>
							            </div>                            
							        </div>
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Mother's name: <span class="required">*</span></label>
							        <input name="mother_name" id="mother_name" type="text" class="form-control" placeholder="Mother's name" required value="<?= $student_details['mother_name'] ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">What's App/Mobile No.: <span class="required">*</span></label>
							        <input name="mother_mobile" id="mother_mobile" type="text" class="form-control" placeholder="What's App/Mobile No." required value="<?= $student_details['mother_mobile'] ?>" />
							    </div>
							</div>

							<div class="col-lg-2">
							    <div class="mb-3">
							        <label class="form-label">Aadhar No:</label>
							        <input type="text" name="mother_aadhaar_no" id="mother_aadhaar_no" class="form-control" placeholder="Aadhar No" value="<?= $student_details['mother_aadhaar_no'] ?>" />
							    </div>
							</div>

							<div class="col-lg-2">
							    <div class="mb-3">
							        <label class="form-label">Occupation:</label>
							        <input type="text" name="mother_occupation" id="mother_occupation" class="form-control" placeholder="Occupation" value="<?= $student_details['mother_occupation'] ?>" />
							    </div>
							</div>

							<div class="col-lg-2">
							    <div class="mb-3">
							        <label class="form-label">Annual Income:</label>
							        <input type="text" name="mother_annual_income" id="mother_annual_income" class="form-control" placeholder="Annual Income" value="<?= $student_details['mother_annual_income'] ?>" />
							    </div>
							</div>

							<div class="col-lg-6">
							    <div class="mb-3">
							        <label class="form-label">Father's Image:</label>
							        <div class="row">
							            <div class="col-sm-8">
							                <input name="f_image" id="f_image" type="file" class="form-control" />
							                <div class="form-text text-muted">(Image under 20 to 200kb)</div>
							            </div>                            
							            <div class="col-sm-4">
							            	<?php 
	                                        $getFatherImgUrl = $student_details['f_image'] ?? '';
	                                        $fullFatherImgUrl = ($getFatherImgUrl != '') ? base_url('uploads/'.$getFatherImgUrl) : '#';
	                                        if( $getFatherImgUrl != "") {
	                                        ?>
	                                            <img src="<?= $fullFatherImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
	                                        <?php } ?>
							                <div> 
							                    <img class="preview_img" src="#" id="f_image_preview" alt="Image Preview" />
							                 </div>
							                <span class="error"></span>
							            </div>                            
							        </div>
							    </div>
							</div>

							<div class="col-lg-6">
							    <div class="mb-3">
							        <label class="form-label">Father's Signature:</label>
							        <div class="row">
							            <div class="col-sm-8">
							                <input name="f_signature" id="f_signature" type="file" class="form-control" />
							                <div class="form-text text-muted">(Image width should be within 14x4 cm)</div>
							            </div>                            
							            <div class="col-sm-4">
							            	<?php 
	                                        $getFsignatureImgUrl = $student_details['f_signature'] ?? '';
	                                        $fullFsignatureImgUrl = ($getFsignatureImgUrl != '') ? base_url('uploads/'.$getFsignatureImgUrl) : '#';
	                                        if( $getFsignatureImgUrl != "") {
	                                        ?>
	                                            <img src="<?= $fullFsignatureImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
	                                        <?php } ?>
							                <div> 
							                    <img class="preview_img" src="#" id="f_signature_preview" alt="Image Preview" />
							                 </div>
							                <span class="error"></span>
							            </div>                            
							        </div>
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Father's name: <span class="required">*</span></label>
							        <input name="father_name" id="father_name" type="text" class="form-control" placeholder="Father's name" required value="<?= $student_details['father_name'] ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">What's App/Mobile No: <span class="required">*</span></label>
							        <input name="father_mobile" id="father_mobile" type="text" class="form-control" placeholder="What's App/Mobile No" required value="<?= $student_details['father_mobile'] ?>" />
							    </div>
							</div>

							<div class="col-lg-2">
							    <div class="mb-3">
							        <label class="form-label">Aadhar No:</label>
							        <input name="father_aadhaar_no" id="father_aadhaar_no" type="text" class="form-control" placeholder="Aadhar No" value="<?= $student_details['father_aadhaar_no'] ?>" />
							    </div>
							</div>

							<div class="col-lg-2">
							    <div class="mb-3">
							        <label class="form-label">Occupation:</label>
							        <input name="father_occupation" id="father_occupation" type="text" class="form-control" placeholder="Occupation" value="<?= $student_details['father_occupation'] ?>" />
							    </div>
							</div>

							<div class="col-lg-2">
							    <div class="mb-3">
							        <label class="form-label">Annual Income:</label>
							        <input name="father_annual_income" id="father_annual_income" type="text" class="form-control" placeholder="Annual Income" value="<?= $student_details['father_annual_income'] ?>" />
							    </div>
							</div>

							<div class="col-lg-12">
							    <div class="mb-3">
							        <label class="form-label">Address: <span class="required">*</span></label>
							        <textarea name="permanent_address" id="permanent_address" rows="3" cols="3" class="form-control" placeholder="Enter your message here" required><?= $student_details['permanent_address'] ?></textarea>
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Pincode:</label>
							        <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Pincode" value="<?= $student_details['pincode'] ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Whats App No:</label>
							        <input type="text" name="telephone_resi" id="telephone_resi" class="form-control" placeholder="Whats App No" value="<?= $student_details['telephone_resi'] ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <div class="mb-3">
							        <label class="form-label">Email:</label>
							        <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?= $student_details['email'] ?>" />
							    </div>
							</div>

							<div class="col-lg-3">
							    <!-- Empty column for spacing -->
							</div>

							<div class="col-lg-6">
							    <div class="mb-3">
							        <label class="form-label">Application</label>
							        <div class="row">
							            <div class="col-sm-8">
							                <input type="file" class="form-control characterImage5" id="application_pre" name="application_pre" data-validation="mime" data-validation-allowing="jpg, png, gif, pdf, doc, docx" data-validation-error-msg-required="No image selected" />
							            </div>                            
							            <div class="col-sm-4">
							            	<?php 
	                                        $getApplicationImgUrl = $student_details['application'] ?? '';
	                                        $fullApplicationImgUrl = ($getApplicationImgUrl != '') ? base_url('uploads/'.$getApplicationImgUrl) : '#';
	                                        if( $getApplicationImgUrl != "") {
	                                        ?>
	                                            <img src="<?= $fullApplicationImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
	                                        <?php } ?>
							                <div> 
							                    <img src="" id="lym-img-tag" width="100px" />
							                 </div>
							                <span class="error"></span>
							            </div>                            
							        </div>
							    </div>
							</div>

							<div class="col-lg-6">
							    <div class="mb-3">
							        <label class="form-label">Transfer Certificate</label>
							        <div class="row">
							            <div class="col-sm-8">
							                <input type="file" class="form-control characterImage5" id="trans_cert" name="trans_cert" data-validation="mime" data-validation-allowing="jpg, png, gif, pdf, doc, docx" data-validation-error-msg-required="No image selected" />
							            </div>                            
							            <div class="col-sm-4">
							            	<?php 
	                                        $getTransCertImgUrl = $student_details['trans_cert'] ?? '';
	                                        $fullTransCertImgUrl = ($getTransCertImgUrl != '') ? base_url('uploads/'.$getTransCertImgUrl) : '#';
	                                        if( $getTransCertImgUrl != "") {
	                                        ?>
	                                            <img src="<?= $fullTransCertImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
	                                        <?php } ?>
							                <div> 
							                    <img src="" id="lym-img-tag" width="100px" />
							                 </div>
							                <span class="error"></span>
							            </div>                            
							        </div>
							    </div>
							</div>

							<div class="col-lg-6">
							    <div class="mb-3">
							        <label class="form-label">Migration Certificate</label>
							        <div class="row">
							            <div class="col-sm-8">
							                <input type="file" class="form-control characterImage5" id="migration_cert" name="migration_cert" data-validation="mime" data-validation-allowing="jpg, png, gif, pdf, doc, docx" data-validation-error-msg-required="No image selected" />
							            </div>                            
							            <div class="col-sm-4">
							            	<?php 
	                                        $getMigrationCertImgUrl = $student_details['migration_cert'] ?? '';
	                                        $fullMigrationCertImgUrl = ($getMigrationCertImgUrl != '') ? base_url('uploads/'.$getMigrationCertImgUrl) : '#';
	                                        if( $getMigrationCertImgUrl != "") {
	                                        ?>
	                                            <img src="<?= $fullMigrationCertImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
	                                        <?php } ?>
							                <div> 
							                    <img src="" id="lym-img-tag" width="100px" />
							                 </div>
							                <span class="error"></span>
							            </div>                            
							        </div>
							    </div>
							</div>

							<div class="col-lg-6">
							    <div class="mb-3">
							        <label class="form-label">Any Special Certificate</label>
							        <div class="row">
							            <div class="col-sm-8">
							                <input type="file" class="form-control characterImage5" id="any_special_cert" name="any_special_cert" data-validation="mime" data-validation-allowing="jpg, png, gif, pdf, doc, docx" data-validation-error-msg-required="No image selected" />
							            </div>                            
							            <div class="col-sm-4">
							            	<?php 
	                                        $getSpecialCertImgUrl = $student_details['any_special_cert'] ?? '';
	                                        $fullSpecialCertImgUrl = ($getSpecialCertImgUrl != '') ? base_url('uploads/'.$getSpecialCertImgUrl) : '#';
	                                        if( $getSpecialCertImgUrl != "") {
	                                        ?>
	                                            <img src="<?= $fullSpecialCertImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
	                                        <?php } ?>
							                <div> 
							                    <img src="" id="lym-img-tag" width="100px" />
							                 </div>
							                <span class="error"></span>
							            </div>                            
							        </div>
							    </div>
							</div>

							<!-- <div class="col-lg-6">
							    <div class="mb-3">
							        <label class="form-label">I have Local Guardian:</label>
							        <label class="form-check">
							            <input type="checkbox" name="localGurdian" id="localGurdian" class="form-check-input" />
							            <span class="form-check-label">(Click this if student do not stay with parents)</span>
							        </label>
							    </div>
							</div> -->

						</div>

						<!-- GUARDIAN'S DETAIL -->
						<div id="localGurdianBlk" >
						    <div class="row">
						        <h2>GUARDIAN'S DETAIL</h2>
						        
						        <div class="col-lg-6">
						            <div class="mb-3">
						                <label class="form-label">Guardian Image:</label>
						                <div class="row">
						                    <div class="col-sm-8">
						                        <input name="g_image" id="g_image" type="file" class="form-control" />
						                        <div class="form-text text-muted">(Image under 20 to 200kb)</div>
						                    </div>                                            
						                    <div class="col-sm-4">
						                    	<?php 
		                                        $getGImgUrl = $student_details['g_image'] ?? '';
		                                        $fullGImgUrl = ($getGImgUrl != '') ? base_url('uploads/'.$getGImgUrl) : '#';
		                                        if( $getGImgUrl != "") {
		                                        ?>
		                                            <img src="<?= $fullGImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
		                                        <?php } ?>
						                        <div> 
						                            <img class="preview_img" src="#" id="g_image_preview" alt="Image Preview" />
						                         </div>
						                        <span class="error"></span>
						                    </div>                                            
						                </div>
						            </div>
						        </div>
						        
						        <div class="col-lg-6">
						            <div class="mb-3">
						                <label class="form-label">Guardian Signature:</label>
						                <div class="row">
						                    <div class="col-sm-8">
						                        <input name="g_signature" id="g_signature" type="file" class="form-control" />
						                        <div class="form-text text-muted">(Image width should be within 14x4 cm)</div>
						                    </div>                                            
						                    <div class="col-sm-4">
						                    	<?php 
		                                        $getGSignImgUrl = $student_details['g_signature'] ?? '';
		                                        $fullGSignImgUrl = ($getGSignImgUrl != '') ? base_url('uploads/'.$getGSignImgUrl) : '#';
		                                        if( $getGSignImgUrl != "") {
		                                        ?>
		                                            <img src="<?= $fullGSignImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
		                                        <?php } ?>
						                        <div> 
						                            <img class="preview_img" src="#" id="g_signature_preview" alt="Image Preview" />
						                         </div>
						                        <span class="error"></span>
						                    </div>                                            
						                </div>
						            </div>
						        </div>
						        
						        <div class="col-lg-3">
						            <div class="mb-3">
						                <label class="form-label">Name of Guardian: <span class="required">*</span></label>
						                <input name="local_guar_name" id="local_guar_name" type="text" class="form-control" placeholder="Name of Guardian" value="<?= $student_details['local_guar_name'] ?>" />
						            </div>
						        </div>
						        
						        <div class="col-lg-3">
						            <div class="mb-3">
						                <label class="form-label">Gender:</label>
						                <div class="form-check-horizontal">
						                    <label class="form-check form-check-inline">
						                        <input type="radio" class="form-check-input" name="local_guar_gender" value="Male" <?php if( $student_details['local_guar_gender'] == "Male" ) { echo 'checked'; }elseif( $student_details['local_guar_gender'] == "" ) { echo 'checked'; } ?> />
						                        <span class="form-check-label">Male</span>
						                    </label>
						                    <label class="form-check form-check-inline">
						                        <input type="radio" class="form-check-input" name="local_guar_gender" value="Female" <?php if( $student_details['local_guar_gender'] == "Female" ) { echo 'checked'; } ?> />
						                        <span class="form-check-label">Female</span>
						                    </label>
						                </div>
						            </div>
						        </div>
						        
						        <div class="col-lg-2">
						            <div class="mb-3">
						                <label class="form-label">Aadhar No: <span class="required">*</span></label>
						                <input name="local_guar_aadhaar_no" id="local_guar_aadhaar_no" type="text" class="form-control" placeholder="Aadhar No" value="<?= $student_details['local_guar_aadhaar_no'] ?>" />
						            </div>
						        </div>
						        
						        <div class="col-lg-4">
						            <div class="mb-3">
						                <label class="form-label">Correspondence address:</label>
						                <input name="local_guar_address" id="local_guar_address" type="text" class="form-control" placeholder="Correspondence address" value="<?= $student_details['local_guar_address'] ?>" />
						            </div>
						        </div>
						        
						        <div class="col-lg-3">
						            <div class="mb-3">
						                <label class="form-label">Mobile No:</label>
						                <input name="local_guar_phone" id="local_guar_phone" type="text" class="form-control" placeholder="Mobile No" value="<?= $student_details['local_guar_phone'] ?>" />
						            </div>
						        </div>
						        
						        <div class="col-lg-3">
						            <div class="mb-3">
						                <label class="form-label">Relationship with Student:</label>
						                <input name="local_guar_stu_relation" id="local_guar_stu_relation" type="text" class="form-control" placeholder="Relationship with Student" value="<?= $student_details['local_guar_stu_relation'] ?>" />
						            </div>
						        </div>
						        
						        <div class="col-lg-3">
						            <div class="mb-3">
						                <label class="form-label">Occupation:</label>
						                <input name="local_guar_occupation" id="local_guar_occupation" type="text" class="form-control" placeholder="Occupation" value="<?= $student_details['local_guar_occupation'] ?>" />
						            </div>
						        </div>
						        
						        <div class="col-lg-3">
						            <div class="mb-3">
						                <label class="form-label">Annual Income:</label>
						                <input name="local_guar_annual_income" id="local_guar_annual_income" type="text" class="form-control" placeholder="Annual Income" value="<?= $student_details['local_guar_annual_income'] ?>" />
						            </div>
						        </div>
						        
						        <div class="col-lg-3">
						            <div class="mb-3">
						                <label class="form-label">Earning member:</label>
						                <input name="family_earn_memb" id="family_earn_memb" type="text" class="form-control" placeholder="Earning member" value="<?= $student_details['family_earn_memb'] ?>" />
						            </div>
						        </div>
						        
						        <div class="col-lg-3">
						            <div class="mb-3">
						                <label class="form-label">Dependents:</label>
						                <input name="dependent" id="dependent" type="text" class="form-control" placeholder="Dependents" value="<?= $student_details['dependent'] ?>" />
						            </div>
						        </div>
						    </div>
						</div>

						<style>
						    /*.optional_sub {
						        display: none;
						    }*/
						</style>

						<!-- Subjects opted for -->
						<?php if( $student_details['class_id'] > 13) { ?>
							<div class="optional_sub">
							    <div class="row">
							        <h2>Subjects opted for</h2>
							        <hr style="margin-top: 10px; margin-bottom: 10px;" />
							        <h4 class="subjects-tex">Stream opt: Science / Humanities / Commerce</h4>
							        
							        <div class="col-lg-6">
							            <div class="mb-3">
							                <label class="form-label">1.</label>
							                <select name="first_elective_sub" class="form-control" id="first_elective_sub"></select>
							            </div>
							        </div>
							        
							        <div class="col-lg-6">
							            <div class="mb-3">
							                <label class="form-label">2.</label>
							                <select name="second_elective_sub" class="form-control" id="second_elective_sub"></select>
							            </div>
							        </div>
							        
							        <div class="col-lg-6">
							            <div class="mb-3">
							                <label class="form-label">3.</label>
							                <select name="third_elective_sub" class="form-control" id="third_elective_sub"></select>
							            </div>
							        </div>
							        
							        <div class="col-lg-6">
							            <div class="mb-3">
							                <label class="form-label">4.</label>
							                <select name="fourth_elective_sub" class="form-control" id="fourth_elective_sub"></select>
							            </div>
							        </div>
							        
							        <div class="col-lg-6">
							            <div class="mb-3">
							                <label class="form-label">5.</label>
							                <select name="fifth_elective_sub" class="form-control" id="fifth_elective_sub"></select>
							            </div>
							        </div>
							        
							        <div class="col-lg-6">
							            <div class="mb-3">
							                <label class="form-label">6.</label>
							                <select name="sixth_elective_sub" class="form-control" id="sixth_elective_sub"></select>
							            </div>
							        </div>
							        
							        <div class="col-lg-6">
							            <div class="mb-3">
							                <label class="form-label">Please attach class X pre board / Mock test marks Statement / Board final result <span class="required">*</span></label>
							                <div class="row">
							                    <div class="col-sm-8">
							                        <input type="file" class="form-control characterImage5" id="last_year_marksheet" name="last_year_marksheet" data-validation="mime" data-validation-allowing="jpg, png, gif, pdf, doc, docx" data-validation-error-msg-required="No image selected" />
							                    </div>                                            
							                    <div class="col-sm-4">
							                    	<?php 
			                                        $getLymImgUrl = $student_details['last_year_marksheet'] ?? '';
			                                        $fullLymImgUrl = ($getLymImgUrl != '') ? base_url('uploads/'.$getLymImgUrl) : '#';
			                                        if( $getLymImgUrl != "") {
			                                        ?>
			                                            <img src="<?= $fullLymImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
			                                        <?php } ?>
							                        <div> 
							                            <img src="" id="lym-img-tag" width="100px" />
							                         </div>
							                        <span class="error"></span>
							                    </div>                                            
							                </div>
							            </div>
							        </div>
							        
							        <div class="col-lg-6">
							            <div class="mb-3">
							                <label class="form-label">Student's Birth Certificate <span class="required">*</span></label>
							                <div class="row">
							                    <div class="col-sm-8">
							                        <input type="file" class="form-control characterImage5" id="student_birth_certificate" name="student_birth_certificate" data-validation="mime" data-validation-allowing="jpg, png, gif, pdf, doc, docx" data-validation-error-msg-required="No image selected" />
							                    </div>                                            
							                    <div class="col-sm-4">
							                    	<?php 
			                                        $getSbirthCrtImgUrl = $student_details['student_birth_certificate'] ?? '';
			                                        $fullSbirthCrtImgUrl = ($getSbirthCrtImgUrl != '') ? base_url('uploads/'.$getSbirthCrtImgUrl) : '#';
			                                        if( $getSbirthCrtImgUrl != "") {
			                                        ?>
			                                            <img src="<?= $fullSbirthCrtImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
			                                        <?php } ?>
							                        <div> 
							                            <img src="" id="lym-img-tag" width="100px" />
							                         </div>
							                        <span class="error"></span>
							                    </div>                                            
							                </div>
							            </div>
							        </div>
							        
							        <div class="col-lg-6">
							            <div class="mb-3">
							                <label class="form-label">Class X Admit <span class="required">*</span></label>
							                <div class="row">
							                    <div class="col-sm-8">
							                        <input type="file" class="form-control characterImage5" id="student_admit" name="student_admit" data-validation="mime" data-validation-allowing="jpg, png, gif, pdf, doc, docx" data-validation-error-msg-required="No image selected" />
							                    </div>                                            
							                    <div class="col-sm-4">
							                    	<?php 
			                                        $getAdmitImgUrl = $student_details['student_admit'] ?? '';
			                                        $fullAdmitImgUrl = ($getAdmitImgUrl != '') ? base_url('uploads/'.$getAdmitImgUrl) : '#';
			                                        if( $getAdmitImgUrl != "") {
			                                        ?>
			                                            <img src="<?= $fullAdmitImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
			                                        <?php } ?>
							                        <div> 
							                            <img src="" id="lym-img-tag" width="100px" />
							                         </div>
							                        <span class="error"></span>
							                    </div>                                            
							                </div>
							            </div>
							        </div>
							        
							        <div class="col-lg-6">
							            <div class="mb-3">
							                <label class="form-label">Father's Id Proof <span class="required">*</span></label>
							                <div class="row">
							                    <div class="col-sm-8">
							                        <input type="file" class="form-control characterImage5" id="father_id" name="father_id" data-validation="mime" data-validation-allowing="jpg, png, gif, pdf, doc, docx" data-validation-error-msg-required="No image selected" />
							                    </div>                                            
							                    <div class="col-sm-4">
							                    	<?php 
			                                        $getFatherIdImgUrl = $student_details['father_id'] ?? '';
			                                        $fullFatherIdImgUrl = ($getFatherIdImgUrl != '') ? base_url('uploads/'.$getFatherIdImgUrl) : '#';
			                                        if( $getFatherIdImgUrl != "") {
			                                        ?>
			                                            <img src="<?= $fullFatherIdImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
			                                        <?php } ?>
							                        <div> 
							                            <img src="" id="lym-img-tag" width="100px" />
							                         </div>
							                        <span class="error"></span>
							                    </div>                                            
							                </div>
							            </div>
							        </div>
							        
							        <div class="col-lg-6">
							            <div class="mb-3">
							                <label class="form-label">Mother's Id Proof <span class="required">*</span></label>                                        
							                <div class="row">
							                    <div class="col-sm-8">
							                        <input type="file" class="form-control characterImage5" id="mother_id" name="mother_id" data-validation="mime" data-validation-allowing="jpg, png, gif, pdf, doc, docx" data-validation-error-msg-required="No image selected" />
							                    </div>                                            
							                    <div class="col-sm-4">
							                    	<?php 
			                                        $getMotherIdImgUrl = $student_details['mother_id'] ?? '';
			                                        $fullMotherIdImgUrl = ($getMotherIdImgUrl != '') ? base_url('uploads/'.$getMotherIdImgUrl) : '#';
			                                        if( $getMotherIdImgUrl != "") {
			                                        ?>
			                                            <img src="<?= $fullMotherIdImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
			                                        <?php } ?>
							                        <div> 
							                            <img src="" id="lym-img-tag" width="100px" />
							                         </div>
							                        <span class="error"></span>
							                    </div>                                            
							                </div>
							            </div>
							        </div>
							        
							        <div class="col-lg-6">
							            <div class="mb-3">
							                <label class="form-label">Cast Certificate (Student / Father) <span class="required">*</span></label>                                        
							                <div class="row">
							                    <div class="col-sm-8">
							                        <input type="file" class="form-control characterImage5" id="cast_certificate" name="cast_certificate" data-validation="mime" data-validation-allowing="jpg, png, gif, pdf, doc, docx" data-validation-error-msg-required="No image selected" />
							                    </div>                                            
							                    <div class="col-sm-4">
							                    	<?php 
			                                        $getSCastCertImgUrl = $student_details['cast_certificate'] ?? '';
			                                        $fullSCastCertImgUrl = ($getSCastCertImgUrl != '') ? base_url('uploads/'.$getSCastCertImgUrl) : '#';
			                                        if( $getSCastCertImgUrl != "") {
			                                        ?>
			                                            <img src="<?= $fullSCastCertImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
			                                        <?php } ?>
							                        <div> 
							                            <img src="" id="lym-img-tag" width="100px" />
							                         </div>
							                        <span class="error"></span>
							                    </div>                                            
							                </div>
							            </div>
							        </div>
							    </div>
							</div>
						<?php } ?>



						<div class="row">
						    <h2>LAST ACADEMICS DETAILS</h2>
						    
						    <div class="col-lg-3">
						        <div class="mb-3">
						            <label class="form-label">Examination Passed / Class Studying:</label>
						            <input name="last_ac_exam_passed" id="last_ac_exam_passed" type="text" class="form-control" placeholder="Examination Passed / Class Studying" value="<?= $student_details['last_ac_exam_passed'] ?? '' ?>" />
						        </div>
						    </div>
						    
						    <div class="col-lg-3">
						        <div class="mb-3">
						            <label class="form-label">Year:</label>
						            <input name="last_ac_year" id="last_ac_year" type="text" class="form-control" placeholder="Year" value="<?= $student_details['last_ac_year'] ?? ''; ?>" />
						        </div>
						    </div>
						    
						    <div class="col-lg-3">
						        <div class="mb-3">
						            <label class="form-label">Name of Board:</label>
						            <input name="last_ac_board" id="last_ac_board" type="text" class="form-control" placeholder="Name of Board" value="<?= $student_details['last_ac_board'] ?? ''; ?>" />
						        </div>
						    </div>
						    
						    <div class="col-lg-3">
						        <div class="mb-3">
						            <label class="form-label">Name of School:</label>
						            <input name="last_ac_school_name" id="last_ac_school_name" type="text" class="form-control" placeholder="Name of School" value="<?= $student_details['last_ac_school_name'] ?? ''; ?>" />
						        </div>
						    </div>
						    
						    <div class="col-lg-4">
						        <div class="mb-3">
						            <label class="form-label">Roll No:</label>
						            <input name="last_ac_roll_no" id="last_ac_roll_no" type="text" class="form-control" placeholder="Roll No" value="<?= $student_details['last_ac_roll_no'] ?? ''; ?>" />
						        </div>
						    </div>
						    
						    <div class="col-lg-4">
						        <div class="mb-3">
						            <label class="form-label">Max. marks:</label>
						            <input name="last_ac_max_mark" id="last_ac_max_mark" type="text" class="form-control" placeholder="Max. marks" value="<?= $student_details['last_ac_max_mark'] ?? ''; ?>" />
						        </div>
						    </div>
						    
						    <div class="col-lg-4">
						        <div class="mb-3">
						            <label class="form-label">Mark obtained:</label>
						            <input name="last_ac_marks" id="last_ac_marks" type="text" class="form-control" placeholder="Mark obtained" value="<?= $student_details['last_ac_marks'] ?? ''; ?>" />
						        </div>
						    </div>
						    
						    <h2>Language Information</h2>
						    
						    <div class="col-lg-6">
						        <div class="mb-3">
						            <label class="form-label">Grade: LKG onwards (2nd Language): <span class="required">*</span></label>
						            <div class="form-check-horizontal">
						                <label class="form-check form-check-inline">
						                    <input type="radio" class="form-check-input" name="lkg_onw_sec_lang" value="Bengali" <?php if( $student_details['lkg_onw_sec_lang'] == "Bengali") { echo 'checked'; } ?> />
						                    <span class="form-check-label">Bengali</span>
						                </label>
						                <label class="form-check form-check-inline">
						                    <input type="radio" class="form-check-input" name="lkg_onw_sec_lang" value="Hindi" <?php if( $student_details['lkg_onw_sec_lang'] == "Hindi") { echo 'checked'; } ?> />
						                    <span class="form-check-label">Hindi</span>
						                </label>
						            </div>
						        </div>
						    </div>
						    
						    <div class="col-lg-6">
						        <div class="mb-3">
						            <label class="form-label">Grade: Std. III onwards (3rd Language):</label>
						            <div class="form-check-horizontal">
						                <label class="form-check form-check-inline">
						                    <input type="radio" class="form-check-input" name="std_three_sec_lang" value="Bengali" <?php if( $student_details['std_three_sec_lang'] == "Bengali") { echo 'checked'; }elseif( $student_details['std_three_sec_lang'] == "") { echo 'checked'; } ?> />
						                    <span class="form-check-label">Bengali</span>
						                </label>
						                <label class="form-check form-check-inline">
						                    <input type="radio" class="form-check-input" name="std_three_sec_lang" value="Hindi" <?php if( $student_details['std_three_sec_lang'] == "Hindi") { echo 'checked'; } ?> />
						                    <span class="form-check-label">Hindi</span>
						                </label>
						            </div>
						        </div>
						    </div>
						    
						    <!-- <div class="col-lg-6">
						        <div class="mb-3">
						            <label class="form-label">If school transport is required, choose stoppage:</label>
						            <select name="stoppage" id="stoppage" class="form-control">
						                <option value=""> ----- Select stoppage ----- </option>
						                <?php 
						                /*if( isset($stoppage_list) && !empty($stoppage_list) ) {
						                    foreach($stoppage_list as $stoppage):
						                    	$selected = '';
						                    	if($student_details['stoppage'] == $stoppage['stoppage_id']) {
						                    		$selected = 'selected';
						                    	} ?>                            
						                        <option value="<?php // echo $stoppage['stoppage_id'] ?>" <?php // echo $selected ?>><?php // echo $stoppage['stoppage_name'] ?></option>
						                    <?php endforeach; 
						                }*/ ?>
						            </select>
						        </div>
						    </div> -->
						    
						    <div class="col-lg-6">
						        <div class="mb-3">
						            <label class="form-label">I do hereby declare that the above information furnished by me is true to the best of my knowledge & belief:</label>
						            <div class="row">
						                <div class="col-sm-5">
						                    <input name="s_signature" id="s_signature" type="file" class="form-control" />
						                    <div class="form-text text-muted">(Image width should be within 14x4 cm)</div>
						                </div>                                            
						                <div class="col-sm-7">
						                	<?php 
	                                        $getStuSignatureImgUrl = $student_details['stu_signature'] ?? '';
	                                        $fullStuSignatureImgUrl = ($getStuSignatureImgUrl != '') ? base_url('uploads/'.$getStuSignatureImgUrl) : '#';
	                                        if( $getStuSignatureImgUrl != "") {
	                                        ?>
	                                            <img src="<?= $fullStuSignatureImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
	                                        <?php } ?>
						                    <div> 
						                        <img class="preview_img" src="#" id="s_signature_preview" alt="Image Preview" />
						                     </div>
						                    <span class="error"></span>
						                </div>                                            
						            </div>
						        </div>
						    </div>
						    
						    <div class="col-lg-3">
						        <div class="mb-3 text-center">
						            <span>----------------------------------------------------------</span>
						            <label class="form-label">Verified by:</label>
						        </div>
						    </div>
						    
						    <div class="col-lg-3">
						        <div class="mb-3 text-center">
						            <span>----------------------------------------------------------</span>
						            <br />
						            <label class="form-label">Date:</label>
						        </div>
						    </div>
						    
						    <div class="col-lg-3">
						        <div class="mb-3 text-center">
						            <div class="row p_signature_section">
						            	<?php 
                                        $getStuParentSignatureImgUrl = $student_details['signature'] ?? '';
                                        $fullStuParentSignatureImgUrl = ($getStuParentSignatureImgUrl != '') ? base_url('uploads/'.$getStuParentSignatureImgUrl) : '#';
                                        if( $getStuParentSignatureImgUrl != "") {
                                        ?>
                                            <img src="<?= $fullStuParentSignatureImgUrl ?>" alt="Image" style="height: 75px; width: 75px;">
                                        <?php } ?>
						                <img class="preview_img" src="#" id="p_signature_preview" alt="Image Preview" width="350px" />
						                <br />
						                <span>----------------------------------------------------------</span>
						                <label class="form-label">Signature of Parent:</label>
						                <input name="p_signature" id="p_signature" type="file" class="form-control" />
						                <div class="form-text text-muted">(Image width should be within 14x4 cm)</div>
						                <span class="error"></span>
						            </div>
						        </div>
						    </div>
						    
						    <div class="col-lg-3">
						        <div class="mb-3 text-center">
						            <span>----------------------------------------------------------</span>
						            <label class="form-label">Approved by:</label>
						        </div>
						    </div>
						    
						</div>














					</div>

					<div class="card-footer text-end">
						<button id="studentUpdateSubmit" type="submit" class="btn btn-primary">Update <i class="ph-paper-plane-tilt ms-2"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /custom styles -->
</div>
<!-- /content area -->

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

			validateImage("#userfile", "#profile-img-tag");
			validateImage("#f_signature", "#f_signature_preview"); // 14x4 cm
			validateImage("#f_image", "#f_image_preview");
			validateImage("#m_signature", "#m_signature_preview");
			validateImage("#m_image", "#m_image_preview");
			validateImage("#g_signature", "#g_signature_preview");
			validateImage("#g_image", "#g_image_preview");
			validateImage("#s_signature", "#s_signature_preview");
			validateImage("#p_signature", "#p_signature_preview");


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
							data: {classId : classId, studentData: <?= json_encode($student_details) ?>},
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
		function validateImageOld(inputSelector, previewSelector, maxWidthPx, maxHeightPx) {
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

		/**
		 * Validate and preview image upload (ONLY SIZE CHECK)
		 * @param {string} inputSelector - File input selector
		 * @param {string} previewSelector - Preview image selector
		 */
		function validateImage(inputSelector, previewSelector) {

		    const MIN_SIZE = 20 * 1024;   // 20 KB
		    const MAX_SIZE = 200 * 1024;  // 200 KB

		    $(inputSelector).on("change", function (e) {

		        const $input = $(this);
		        const $row = $input.closest(".row");
		        const $error = $row.find(".error");
		        const $preview = $row.find(previewSelector);

		        $error.text("");
		        $preview.hide();

		        const file = e.target.files[0];
		        if (!file) {
		            $error.text("No file chosen.");
		            return;
		        }

		        // Image type check
		        if (!file.type.match(/^image\/(jpeg|jpg|png)$/)) {
		            $error.text("Please select a valid image (JPG, JPEG, PNG).");
		            $input.val("");
		            return;
		        }

		        // ✅ SIZE CHECK ONLY
		        if (file.size < MIN_SIZE || file.size > MAX_SIZE) {
		            $error.text("Image size must be between 20 KB and 200 KB.");
		            $input.val("");
		            return;
		        }

		        // Preview image
		        const reader = new FileReader();
		        reader.onload = function (evt) {
		            $preview.attr("src", evt.target.result).show();
		        };
		        reader.readAsDataURL(file);
		    });
		}
		function fetchSujectList (classId) {
			//Get subject list
			if(classId > 13){
				$('.optional_sub').show();
				$.ajax({
					url:'<?= base_url('get-class-subjects') ?>',
					method: 'post',					
					data: {classId : classId, studentData: <?= json_encode($student_details) ?>},
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
			// Trigger on page load
			let class_id = $('#class_id').val();
			fetchSujectList(class_id);
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
            $("#studentUpdateForm").validate({
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
                 	aadhaar_no: {
		                aadhaarDigits: true   // validate only if value is entered
		            }

                    /*userfile: {
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
			        },*/
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
					aadhaar_no: {
		                aadhaarDigits: "Enter a valid Aadhaar number (12 digits)"
		            }

			        /*userfile: {
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
			        },*/

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