<!DOCTYPE html>

<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Satish Chandra Memorial School - <?= $title ?></title>

	<!-- Global stylesheets -->

	<link href="<?= base_url('public/admin/assets/fonts/inter/inter.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url('public/admin/assets/icons/phosphor/styles.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url('public/admin/assets/css/ltr/all.min.css') ?>" id="stylesheet" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
	<link rel="icon" href="<?= base_url('/public/admin/assets/images/site.png') ?>" type="image/png" sizes="16x16">

	<!-- Core JS files -->
	<script src="<?= base_url('public/admin/assets/demo/demo_configurator.js') ?>"></script>
	<script src="<?= base_url('public/admin/assets/js/bootstrap/bootstrap.bundle.min.js') ?>"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="<?= base_url('public/admin/assets/js/app.js') ?>"></script>
	<script src="<?= base_url('public/admin/assets/demo/pages/form_validation_styles.js') ?>"></script>
	<!-- /theme JS files -->

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<style>
		.show-password-area {
			border-radius: 0px 5px 5px 0px !important;
			background-color: #5f7077 !important;
			color: #fff !important;
		}
	</style>
</head>

<body>
	<!-- Page content -->
	<div class="page-content">
		<!-- Main content -->
		<div class="content-wrapper">
			<!-- Inner content -->
			<div class="content-inner">
				<!-- Content area -->
				<div class="content d-flex justify-content-center align-items-center" style="background: url(<?= base_url('public/img/SCMS-login-banner-snd.jpg') ?>); background-size: cover; position: relative;">
					<!-- Login card -->
					<form method="post" class="login-form needs-validation" action="<?= base_url('set-student-password') ?>" novalidate>
                        <?= csrf_field() ?>
                        <input type="hidden" name="student_user_id" id="student_user_id" value="<?= $student_user_id ?>">

						<div class="card mb-0">
							<div class="card-body">
								<?php if (session()->has('success')): ?>
		                            <div class="alert alert-success alert-dismissible fade show">
		                            	<?= session('success') ?>
		                            	<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		                            </div>
		                        <?php endif; ?>
		                        
		                        <?php if (session()->has('error')): ?>
		                            <div class="alert bg-danger alert-dismissible fade show">
										<?= session('error') ?>
										<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
								    </div>
		                        <?php endif; ?>
		                        
		                        <?php if (session()->has('message')): ?>
		                            <div class="alert alert-info alert-dismissible fade show">
		                            	<?= session('message') ?>
		                            	<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
	                            	</div>
		                        <?php endif; ?>

								<?php if ($errors = session()->getFlashdata('errors')): ?>
								    <div class="alert alert-danger alert-dismissible fade show">
								        <ul class="mb-0">
								            <?php foreach ($errors as $error): ?>
								                <li><?= esc($error) ?></li>
								            <?php endforeach; ?>
								        </ul>
								        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
								    </div>
								<?php endif; ?>
								
								<div class="text-center mb-3">
									<div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
										<img src="<?= base_url('public/admin/assets/images/logo_icon.png') ?>" class="h-48px" alt="">
									</div>
									<h5 class="mb-0"><?= $title ?></h5>
									<p></p>
								</div>
								<div class="mb-3">
									<label class="form-label">New Password</label>
									<div class="input-group form-control-feedback form-control-feedback-start">
										<input name="password" id="password" type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" placeholder="Enter new password" required >
										<button class="btn btn-outline-secondary togglePass show-password-area" type="button">Show</button>
										<?php if (isset($errors['password'])): ?>
		                                    <div class="invalid-feedback"><?= $errors['password'] ?></div>
		                                <?php endif; ?>
										<div class="form-control-feedback-icon">
											<i class="ph ph-password"></i>
										</div>

									</div>
									<!-- Rule message -->
    								<small id="passwordRuleMsg" class="d-block mt-1"></small>

    								<!-- Strength meter -->
								    <div class="mt-2">
								        <div class="progress" style="height:5px">
								            <div id="passwordStrengthBar" class="progress-bar" style="width:0%"></div>
								        </div>
								        <small id="passwordStrengthText"></small>
								    </div>
								</div>
								<div class="mb-3">
									<label class="form-label">Confirm Password</label>
									<div class="input-group form-control-feedback form-control-feedback-start">
										<input name="confirm_password" id="confirm_password" type="password" class="form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>" placeholder="Confirm new password" required >
										<button class="btn btn-outline-secondary togglePass show-password-area" type="button">Show</button>

										<?php if (isset($errors['confirm_password'])): ?>
		                                    <div class="invalid-feedback"><?= $errors['confirm_password'] ?></div>
		                                <?php endif; ?>
										<div class="form-control-feedback-icon">
											<i class="ph ph-password"></i>
										</div>
									</div>
									<small id="matchMsg"></small>
								</div>

								<div class="d-flex align-items-center mb-3">
									<a href="<?= base_url('login') ?>" class="ms-auto">Back to Login</a>
								</div>

								<div class="mb-3">
									<button type="submit" class="btn btn-primary w-100">Set Password</button>
								</div>
							</div>
						</div>
					</form>
					<!-- /login card -->
				</div>

				<!-- /content area -->

				<!-- Footer -->

				<div class="navbar navbar-sm navbar-footer border-top">
					<div class="container-fluid">
						<span>&copy; <?= date('Y') ?> <a href="#">Satish Chandra Memorial School</a></span>
					</div>
				</div>

				<!-- /footer -->
			</div>
		</div>
	</div>

	<script>
		document.addEventListener("DOMContentLoaded", function () {

		    // Show / Hide password
		    document.querySelectorAll(".togglePass").forEach(btn => {
		        btn.addEventListener("click", function () {
		            let input = this.previousElementSibling;
		            if (input.type === "password") {
		                input.type = "text";
		                this.textContent = "Hide";
		            } else {
		                input.type = "password";
		                this.textContent = "Show";
		            }
		        });
		    });

		    const passwordInput = document.getElementById("password");
		    const confirmInput  = document.getElementById("confirm_password");

		    const bar  = document.getElementById("passwordStrengthBar");
		    const text = document.getElementById("passwordStrengthText");
		    const rule = document.getElementById("passwordRuleMsg");
		    const match = document.getElementById("matchMsg");

		    const regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;

		    passwordInput.addEventListener("keyup", function () {
		        let pass = this.value;
		        let strength = 0;

		        if (pass.length >= 8) strength += 25;
		        if (/[A-Z]/.test(pass)) strength += 25;
		        if (/[a-z]/.test(pass)) strength += 15;
		        if (/\d/.test(pass)) strength += 20;
		        if (/[@$!%*?&]/.test(pass)) strength += 15;

		        bar.style.width = strength + "%";

		        let label = "", color = "";
		        if (strength <= 25) { label = "Very Weak"; color = "red"; }
		        else if (strength <= 50) { label = "Weak"; color = "orange"; }
		        else if (strength <= 75) { label = "Good"; color = "blue"; }
		        else { label = "Strong"; color = "green"; }

		        bar.style.background = color;
		        text.textContent = label;
		        text.style.color = color;

		        if (!regex.test(pass)) {
		            rule.textContent = "Password must be 8+ chars, include uppercase, lowercase, number & special character.";
		            rule.style.color = "red";
		        } else {
		            rule.textContent = "Password format valid ✓";
		            rule.style.color = "green";
		        }
		    });

		    // Confirm password match
		    confirmInput.addEventListener("keyup", function () {
		        if (this.value === passwordInput.value) {
		            match.textContent = "Passwords match ✓";
		            match.style.color = "green";
		        } else {
		            match.textContent = "Passwords do not match";
		            match.style.color = "red";
		        }
		    });

		});
	</script>

</body>

</html>

