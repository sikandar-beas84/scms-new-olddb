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
					<?php // echo password_hash('Teacher@2026!', PASSWORD_DEFAULT); ?>
					<!-- Login card -->
					<form method="post" class="login-form needs-validation" action="<?= base_url('process-forgot-password') ?>" novalidate>
                            <?= csrf_field() ?>
						<div class="card mb-0">
							<div class="card-body">
								<?php if (session()->has('success')): ?>
		                            <div class="alert alert-success alert-dismissible fade show">
		                            	<?= session('success') ?>
		                            	<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		                            </div>
		                        <?php endif; ?>
		                        
								<?php if (session()->has('errors')): ?>
								    <div class="alert bg-danger text-white alert-dismissible fade show">
								        <ul class="mb-0">
								            <?php foreach (session('errors') as $error): ?>
								                <li><?= esc($error) ?></li>
								            <?php endforeach; ?>
								        </ul>
								        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
								    </div>
								<?php endif; ?>
								
		                        <?php if (session()->has('error')): ?>
		                            <div class="alert bg-danger text-white alert-dismissible fade show">
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


								<div class="text-center mb-3">
									<div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
										<img src="<?= base_url('public/admin/assets/images/logo_icon.png') ?>" class="h-48px" alt="">
									</div>
									<h5 class="mb-0"><?= $title ?></h5>
									<span class="d-block text-muted" id="fgtMsg">Enter your email address and we'll send you a link to reset your password.</span>
									<p></p>
								</div>
								<div class="mb-3">
									<label class="form-label">Account Type</label>
									<div class="form-control-feedback form-control-feedback-start">
										<select class="form-select" name="user_type" id="user_type" required>
											<option value="1" selected>Other</option>
											<option value="0">Student</option>
										</select>
									</div>
								</div>
								<div class="mb-3">
									<label class="form-label emailAddress">Email</label>
									<div class="form-control-feedback form-control-feedback-start">
										<input name="email" id="email" type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" placeholder="john@doe.com" required value="<?= old('email') ?>">
										<?php if (isset($errors['email'])): ?>
		                                    <div class="invalid-feedback"><?= $errors['email'] ?></div>
		                                <?php endif; ?>
										<div class="form-control-feedback-icon">
											<i class="ph ph-at text-muted"></i>
										</div>

									</div>
								</div>

								<div class="d-flex align-items-center mb-3">
									<a href="<?= base_url('login') ?>" class="ms-auto">Back to Login</a>
								</div>

								<div class="mb-3">
									<button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
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

	<script src="https://code.jquery.com/jquery-4.0.0.min.js"></script>
	<script>
		$(document).ready(function () {
		    function updateField(val) {

		        if (val == '0') {
		            // Student
		            $('.emailAddress').text('Email or Student Code');
		            $('#email').attr('placeholder', 'Enter email or student code');
		            $('#email').attr('type', 'text');

		        } else {
		            // Default
		            $('.emailAddress').text('Email');
		            $('#email').attr('placeholder', 'john@doe.com');
		            $('#email').attr('type', 'email');
		        }
		    }

		    $('#user_type').on('change', function () {
		        let val = $(this).val();

		        updateField(val);

		        if (val == '0') {
		            $('#fgtMsg').text("Enter your email address or student code and we'll send you a link to reset your password.");
		        } else {
		            $('#fgtMsg').text("Enter your email address and we'll send you a link to reset your password.");
		        }
		    });

		});
	</script>
</body>

</html>

