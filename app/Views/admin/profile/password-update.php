<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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


<!-- Content area -->
<div class="content">
	<!-- Custom styles -->
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0"><?= $title ?></h5>
				</div>

				<form method="post" id="updatePassword" novalidate>
				    <div class="card-body">

				        <!-- Current Password -->
				        <div class="mb-3 row">
				            <label class="col-lg-4 col-form-label">
				                Current Password <span class="text-danger">*</span>
				            </label>
				            <div class="col-lg-8">
				                <div class="input-group">
				                    <input type="password" name="current_password" id="current_password"
				                           class="form-control" required>
				                    <button class="btn btn-outline-secondary togglePass" type="button">
				                        Show
				                    </button>
				                </div>
				            </div>
				        </div>

				        <!-- New Password -->
				        <div class="mb-3 row">
				            <label class="col-lg-4 col-form-label">
				                New Password <span class="text-danger">*</span>
				            </label>
				            <div class="col-lg-8">
				                <div class="input-group">
				                    <input type="password" name="new_password" id="new_password"
				                           class="form-control" required>
				                    <button class="btn btn-outline-secondary togglePass" type="button">
				                        Show
				                    </button>
				                </div>

				                <!-- Strength meter -->
				                <small id="passwordRuleMsg" class="mt-1 d-block"></small>
				                <div class="mt-2">
				                    <div class="progress">
				                        <div id="passwordStrengthBar" class="progress-bar" style="width: 0%"></div>
				                    </div>
				                    <small id="passwordStrengthText" class="form-text"></small>
				                </div>
				            </div>
				        </div>

				        <!-- Confirm Password -->
				        <div class="mb-3 row">
				            <label class="col-lg-4 col-form-label">
				                Confirm Password <span class="text-danger">*</span>
				            </label>
				            <div class="col-lg-8">
				                <div class="input-group">
				                    <input type="password" name="confirm_password" id="confirm_password"
				                           class="form-control" required>
				                    <button class="btn btn-outline-secondary togglePass" type="button">
				                        Show
				                    </button>
				                </div>
				                <small id="matchMsg"></small>
				            </div>
				        </div>

				        <!-- Button -->
				        <div class="text-center">
				            <button id="updatePasswordBtn" type="button" class="btn btn-primary">
				                Update Password
				            </button>
				        </div>

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


	    // === Show/Hide Password ===
	    $(".togglePass").on("click", function () {
	        let input = $(this).prev("input");
	        if (input.attr("type") === "password") {
	            input.attr("type", "text");
	            $(this).text("Hide");
	        } else {
	            input.attr("type", "password");
	            $(this).text("Show");
	        }
	    });

	    // === Password Strength Checker ===
	    $("#new_password").on("keyup", function () {
	        let pass = $(this).val();

	        // Same regex as backend
	        let regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;

	        let strength = 0;

	        if (pass.length >= 8) strength += 25;
	        if (/[A-Z]/.test(pass)) strength += 25;
	        if (/[a-z]/.test(pass)) strength += 15;
	        if (/\d/.test(pass)) strength += 20;
	        if (/[@$!%*?&]/.test(pass)) strength += 15;

	        $("#passwordStrengthBar").css("width", strength + "%");

	        let text = "";
	        let color = "";

	        if (strength <= 25) { text = "Very Weak"; color = "red"; }
	        else if (strength <= 50) { text = "Weak"; color = "orange"; }
	        else if (strength <= 75) { text = "Good"; color = "blue"; }
	        else { text = "Strong"; color = "green"; }

	        $("#passwordStrengthBar").css("background", color);
	        $("#passwordStrengthText").text(text).css("color", color);

	        // Backend rule check
	        if (!regex.test(pass)) {
	            $("#passwordRuleMsg")
	                .text("Password must be 8+ chars, include uppercase, lowercase, number & special character.")
	                .css("color", "red");
	        } else {
	            $("#passwordRuleMsg").text("Password format valid ✓").css("color", "green");
	        }
	    });

	    // === Confirm Password Match ===
	    $("#confirm_password, #new_password").on("keyup", function () {
	        if ($("#confirm_password").val() === $("#new_password").val()) {
	            $("#matchMsg").text("Passwords match ✓").css("color", "green");
	        } else {
	            $("#matchMsg").text("Passwords do not match").css("color", "red");
	        }
	    });

	    // === AJAX Submit ===
	    $("#updatePasswordBtn").on("click", function () {

	        let current = $("#current_password").val();
	        let newPwd = $("#new_password").val();
	        let confirmPwd = $("#confirm_password").val();

	        // Frontend validation
	        if (!current || !newPwd || !confirmPwd) {
	            Swal.fire("Error", "All fields are required!", "error");
	            return;
	        }

	        if (newPwd !== confirmPwd) {
	            Swal.fire("Error", "Passwords do not match!", "error");
	            return;
	        }

	        let regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;

	        if (!regex.test(newPwd)) {
	            Swal.fire("Error", "Password format invalid!", "error");
	            return;
	        }

	        $.ajax({
	            url: "<?= base_url('admin/profile/update-profile-password') ?>",
	            type: "POST",
	            data: {
	                current_password: current,
	                new_password: newPwd,
	                confirm_password: confirmPwd
	            },
	            success: function (response) {

	                if (response.status === "success") {
	                    Swal.fire("Updated!", response.message, "success");
	                    $("#updatePassword")[0].reset();
	                    $("#passwordStrengthBar").css("width", "0%");
	                    $("#passwordStrengthText").text("");
	                    $("#passwordRuleMsg").text("");
	                    $("#matchMsg").text("");
	                } else {
	                    Swal.fire("Error", response.message, "error");
	                }
	            },
	            error: function () {
	                Swal.fire("Error", "Something went wrong", "error");
	            }
	        });
	    });

	});
</script>