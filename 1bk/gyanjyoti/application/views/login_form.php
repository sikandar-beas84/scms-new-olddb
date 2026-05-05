<style>
    .page_loader {
      margin-top: -22%;
    }
	.position-relative {
		position: relative;
	}

	.password-toggle {
		position: absolute;
		right: 10px;
		top: 68%;
		transform: translateY(-50%);
		cursor: pointer;
		color: #939393;
	}

</style>
<body class=" " onload="createCaptcha()">

	<div class="page_loader" style="display:none;">
		<div class="d-flex page_loader_content justify-content-center">
			<img src="<?= base_url('assets/img/preloader.gif') ?>" style="width: 60px; padding-top: 210px;">
		</div>
	</div>

	<div class="page" style="
			background-position: center;
			background-size: cover;
			background-repeat: no-repeat;
			overflow: hidden;
			background-color:#ffffff;
		">
		<div class="page-single" 
		style="
    background-image: url('https://gyanjyotipublicschool.com/assets/font-end/images/LOGIN PAGE.jpg');
    background-repeat: no-repeat;
    background-size: cover;
  ">
			<div class="container" style="max-width: 100%!important;">
				<div class="row justify-content-center">
					<!--<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8 p-md-0">-->


					<!--	<img class="mt- " style="height: 100%; width: 100%;"  src="<?= base_url('assets/font-end/images/LOGIN PAGE.jpg') ?>">-->



					<!--</div>-->
					<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-md-0" style="padding: 21px !important;">
						<div class="card p-5">
							<div class="img-login">
                            <img class="card-img-top" src="<?= base_url('assets/font-end/images/logo.png') ?>" alt="Card image cap">
							</div>
							<!-- Defining CSRF Token in JS Format --> 
							<!--<input type="hidden" name="csrf_token_name" id="csrf_token_name" value="embarek_csrf_token"> 
							<input type="hidden" name="csrf_token_hash" id="csrf_token_hash" value="<?= $this->security->get_csrf_hash(); ?>">--> 

							<!--Admin Login -->
							
							<!-- First, move the forgot password form outside the login form but inside login-form div -->
                            <div class="login-form">
                                
                                <!-- Login Form -->
                                <form class="card-body pt-0" id="loginForm">
                                    <div class="p-2 pt-0 text-center">
                                    <h1 class="mb-2">Login</h1>
                                    <p class="text-muted">Sign In to your account</p>
                                </div>
                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
                                    <div class="alert alert-warning" role="alert"></div>
                                    
                                    <div class="form-group">
                                        <label class="form-label">Username <span class="text-red">*</span></label>
                                        <input class="form-control" placeholder="Username" type="text" value="" name="username">
                                    </div>
                                    <div class="form-group position-relative">
                                        <label class="form-label">Password <span class="text-red">*</span></label>
                                        <input class="form-control" placeholder="Password" type="password" name="password" id="password">
                                        <i class="fa fa-eye password-toggle" id="password-toggle"></i>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Session <span class="text-red">*</span></label>
                                        <select class="form-control" name="session">
                                            <option value="">Select Session</option>
                                            <?php 
                                            $current_session = current_session(); 
                                            foreach($session_year as $k=>$v): ?>
                                                <option <?=$current_session[0]['id'] == $k ? 'selected' : ''; ?>  value="<?=$k;?>"><?=$v?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                            
                                    <div class="form-group">
                                        <label class="custom-control form-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="remember" id="remember">
                                            <span class="custom-control-label">Remember me</span>
                                        </label>
                                    </div>
                            
                                    <div class="submit">
                                        <input class="btn btn-primary btn-block" type="submit" value="Login">
                                    </div>
                                    <div class="text-center mt-3">
                                        <p class="mb-0"><a href="#" id="showForgotPassword">Forgot Password?</a></p>
                                    </div>
                                </form>
                            
                                <!-- Forgot Password Form - Initially Hidden -->
                                <form class=" pt-0 hidden" id="forgotPasswordForm">
                                    <div class="p-2 pt-0 text-center">
                                        <h3 class="mb-2">Forgot Password</h3>
                                        <p class="text-muted">Enter your email to reset password</p>
                                    </div>
                                    <div class="alert" role="alert" style="display: none;"></div>
                                    <div class="form-group">
                                        <label class="form-label">Email Address <span class="text-red">*</span></label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                                    </div>
                                    <div class="text-center mt-3">
                                        <p class="mb-0"><a href="#" id="showLoginForm">Back to Login</a></p>
                                    </div>
                                </form>
                            </div>

							<!-- End Admin Login -->
							<div class="signup-form hidden">
								<div class="p-2 pt-0 text-center">
									<h1 class="mb-2">Create account</h1>
									<p class="text-muted">Create your account</p>
								</div>
								<!-- Signup Form -->
								<form class="card-body pt-0" id="signupForm">
									<input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">

									<div class="alert alert-warning" role="alert"></div>
									<div class="form-group">
										<label class="form-label">First Name <span class="text-red">*</span></label>
										<input class="form-control" placeholder="First Name" type="text" name="user_first_name">
									</div>
									<div class="form-group">
										<label class="form-label">Last Name <span class="text-red">*</span></label>
										<input class="form-control" placeholder="Last Name " type="text" name="user_last_name">
									</div>
									<div class="form-group">
										<label class="form-label">Username <span class="text-red">*</span></label>
										<input class="form-control" placeholder="Username" type="text" value="" name="username">
									</div>
									<div class="form-group">
										<label class="form-label">Email <span class="text-red">*</span></label>
										<input class="form-control" placeholder="Email" type="email" name="signup_email">
									</div>

									<div class="form-group">
										<label class="form-label">Password <span class="text-red">*</span></label>
										<input class="form-control" placeholder="Password" type="password" name="user_password">
									</div>
									<div class="form-group">
										<label class="form-label">Confirm Password <span class="text-red">*</span></label>
										<input class="form-control" placeholder="Confirm Password" type="password" name="confirm_password">
									</div>
									<div class="submit">
										<input class="btn btn-primary btn-block" type="submit" value="Sign Up">
									</div>
									<p>Already have an account? <a href="#" id="showLogin">Login</a></p>

								</form>
							</div>
							<!-- End Signup Form -->

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">
	var baseUrl = '<?= base_url() ?>';
    var pageURL = 'login/';
	$(document).ready(function() {
		var code;
		$('.alert').hide();
		$("#loginForm").on('submit', (function (e) {
            e.preventDefault();
			// if(validateCaptcha() == 1){
				ajaxFromSubmit(pageURL+'login_check', this, function (data) {
					if (data == 1) {
						window.location.replace('<?= base_url('dashboard') ?>');
					} else if(data == 2){
						$('.alert').removeClass('alert-success');
						$('.alert').addClass('alert-warning');
						$('.alert').show();
						$('.alert').text('You are already login to some other device');
					}
					else if(data == 4){
						$('.alert').removeClass('alert-success');
						$('.alert').addClass('alert-warning');
						$('.alert').show();
						$('.alert').text('All field are required.');
					}
					else {
						$('.alert').removeClass('alert-success');
						$('.alert').addClass('alert-warning');
						$('.alert').show();
						$('.alert').text('Wrong! User ID Password Wrong.');
					}
				});
			// } else{
			// 	$('.alert').show();
            //     $('.alert').text('Please enter a valid captcha');
			// }
            
        }));
		$("#signupForm").on('submit', (function (e) {
            e.preventDefault();
			// if(validateCaptcha() == 1){
				ajaxFromSubmit(pageURL+'singup_check', this, function (data) {
					
					if(data.status == 'success'){
						$('.alert').removeClass('alert-warning');
						$('.alert').addClass('alert-success');
						$('.alert').show();
						$('.alert').text('Successfully registered your account. Please login to your account.');
						// Show login form when "Login" link is clicked
						$(".signup-form").addClass("hidden");
						$(".login-form").removeClass("hidden");
					}else{
						$('.alert').removeClass('alert-success');
						$('.alert').addClass('alert-warning');
						$('.alert').show();
						$('.alert').text(data.error);
					}
					
				});
			// } else{
			// 	$('.alert').show();
            //     $('.alert').text('Please enter a valid captcha');
			// }
            
        }));
		$('#password-toggle').click(function() {
        var passwordField = $('#password');
        var toggleIcon = $(this);

        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            toggleIcon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            toggleIcon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
	});
</script>
<script>
$(document).ready(function() {
    // Show forgot password form
    $("#showForgotPassword").click(function(e) {
        e.preventDefault();
        $("#loginForm").addClass("hidden");
        $("#forgotPasswordForm").removeClass("hidden");
    });

    // Show login form
    $("#showLoginForm").click(function(e) {
        e.preventDefault();
        $("#forgotPasswordForm").addClass("hidden");
        $("#loginForm").removeClass("hidden");
    });

    // Handle forgot password form submission
    $("#forgotPasswordForm").on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const alert = form.find('.alert');
        
        $.ajax({
            url: baseUrl + pageURL+'forgot_password',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {
                form.find('button').prop('disabled', true);
                alert.hide();
            },
            success: function(response) {
                if (response.status === 'success') {
                    alert.removeClass('alert-danger').addClass('alert-success');
                    // Clear the form
                    form[0].reset();
                } else {
                    alert.removeClass('alert-success').addClass('alert-danger');
                }
                alert.text(response.message).show();
            },
            error: function() {
                alert.removeClass('alert-success')
                     .addClass('alert-danger')
                     .text('An error occurred. Please try again.')
                     .show();
            },
            complete: function() {
                form.find('button').prop('disabled', false);
            }
        });
    });
});
</script>

<script>
    $(document).ready(function() {
        // Show signup form when "Sign up" link is clicked
        $("#showSignup").click(function() {
            $(".login-form").addClass("hidden");
            $(".signup-form").removeClass("hidden");
        });

        // Show login form when "Login" link is clicked
        $("#showLogin").click(function() {
            $(".signup-form").addClass("hidden");
            $(".login-form").removeClass("hidden");
        });

        // Handle login form submission
        $("#loginForm").submit(function(event) {
            event.preventDefault();
            // Handle login form submission logic here
        });

        // Handle signup form submission
        $("#signupForm").submit(function(event) {
            event.preventDefault();
            // Handle signup form submission logic here
        });
    });
</script>