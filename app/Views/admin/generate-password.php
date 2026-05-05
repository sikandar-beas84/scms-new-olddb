<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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

<div class="content">
	<div class="card">
		<div class="card-header">
			<h5 class="mb-0">Search</h5>
		</div>
		<div class="card-body">
			<div class="row">
	            <div class="col-lg-8">
	                <div class="input-group">
	                	<input type="text" name="new_password" id="new_password" class="form-control" required>
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

                <div class="col-lg-3">
                    <span id="showEncPassword"></span>
				</div>

			</div>

		</div>
	</div>
</div>
<!-- Content area -->
<script>
	$(document).ready(function () {
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
	        $("#showEncPassword").text('');

	        // Backend rule check
	        if (!regex.test(pass)) {
	            $("#passwordRuleMsg")
	                .text("Password must be 8+ chars, include uppercase, lowercase, number & special character.")
	                .css("color", "red");
	        } else {
	            $("#passwordRuleMsg").text("Password format valid ✓").css("color", "green");
	            $.ajax({
	                url: "<?= base_url('get-encrypt-password') ?>",
	                type: "POST",
	                data: { password: pass },
	                success: function(res) {
	                	if( res.status ) {
	                    	$("#showEncPassword").text(res.hash);
	                	}
	                }
	            });
	        }
	    });
    });
</script>