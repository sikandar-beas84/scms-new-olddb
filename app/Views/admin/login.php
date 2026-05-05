<!DOCTYPE html>

<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Satish Chandra Memorial School - Login</title>

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
					<?php // echo password_hash('Scms@2026!', PASSWORD_DEFAULT); ?>
					<!-- Login card -->
					<form method="post" class="login-form needs-validation" action="<?= base_url('auth') ?>" novalidate>
						<div class="card mb-0">
							<div class="card-body">
								<?php if (session()->has('error')): ?>
								    <div class="alert bg-danger text-white alert-dismissible fade show">
										<?= session('error') ?>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
								    </div>
								<?php endif; ?>
								<?php if (session()->has('success')): ?>
		                            <div class="alert alert-success alert-dismissible fade show">
		                            	<?= session('success') ?>
		                            	<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		                            </div>
		                        <?php endif; ?>

								<div class="text-center mb-3">
									<div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
										<img src="<?= base_url('public/admin/assets/images/logo_icon.png') ?>" class="h-48px" alt="">
									</div>
									<h5 class="mb-0">Login to your account</h5>
									<span class="d-block text-muted">Enter your credentials below</span>
								</div>
								<div class="mb-3">
									<label class="form-label">Email/Username</label>
									<div class="form-control-feedback form-control-feedback-start">
										<input name="username" id="username" type="text" class="form-control" placeholder="john@doe.com" required>
										<div class="invalid-feedback">Enter your Email/Username</div>
										<div class="form-control-feedback-icon">
											<i class="ph-user-circle text-muted"></i>
										</div>
									</div>
								</div>

								<div class="mb-3">
									<label class="form-label">Password</label>
									<div class="form-control-feedback form-control-feedback-start">
										<input name="password" id="password" type="password" class="form-control" placeholder="•••••••••••" required>
										<div class="invalid-feedback">Enter your username</div>
										<div class="form-control-feedback-icon">
											<i class="ph-lock text-muted"></i>
										</div>
									</div>
									<div class="invalid-feedback">Enter your password</div>
								</div>

								<?php // echo password_hash('Sayan@2026!', PASSWORD_DEFAULT); ?>

								<div class="mb-3">
									<label class="form-label">Session</label>
									<div class="form-control-feedback form-control-feedback-start">
										<select name="session_year" id="session_year" class="form-control" required>
											<option value="">Select Session</option>
											<!-- <?php //if(isset($sessions) && !empty($sessions)) {
												//foreach ($sessions as $ses) {
													
													//$selected = ($ses['is_current'] == "t") ? 'selected' : '';
													//$selected = (isset($ses['is_current']) && $ses['is_current'] == "t") ? 'selected' : '';
													//echo '<option value="'.$ses['id'].'" '.$selected.'>'.$ses['session_name'].'</option>';
												//}
											//} ?> -->
											<?php 

											if (!empty($sessions)) {
												foreach ($sessions as $ses) {

													$id = $ses['session_year_id'] ?? '';
													$name = $ses['session_year_name'] ?? 'Unknown Session';
													$is_current = $ses['current'] ?? 0;

													if ($id === '') continue;

													$selected = ($is_current == 1) ? 'selected' : '';

													echo '<option value="'.$id.'" '.$selected.'>'.$name.'</option>';
												}
											}
											?>
										</select>
										<div class="form-control-feedback-icon">
											<i class="ph-clock text-muted"></i>
										</div>
									</div>
									<div class="invalid-feedback">Select your Session</div>
								</div>

								<div class="d-flex align-items-center mb-3">
									<?php
									// $password = "Test@2026!";
									// $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
									// echo $hashedPassword;
									// $2y$10$L24T.GFcZocjAG0W.eziD.1.NnC9A2Rujl0uCvSZ1J9Ee7TxpWFve
									?>
									<a href="<?= base_url('forgot-password') ?>" class="ms-auto">Forgot password?</a>
								</div>



								<div class="mb-3">
									<button type="submit" class="btn btn-primary w-100">Sign in</button>
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
</body>

</html>

