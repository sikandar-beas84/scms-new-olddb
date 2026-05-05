<!--Page header-->
<div class="page-header d-xl-flex d-block">
	<div class="page-leftheader">
		<h4 class="page-title"><span class="font-weight-normal text-muted ms-2"><?= $page_title ?></span></h4>
	</div>
</div>
<!--End Page header-->

<!-- Profile Page-->
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12">
		<div class="card user-pro-list overflow-hidden">
			<div class="card-body">


				<form id="modalFormAdd">

					<div class="row">
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Current Password</label>
								<input type="password" class="form-control" name="current_password" id="current_password" <?php if($user_details->password_change == 'N'){echo "disabled";} ?>>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label">New Password</label>
								<input type="password" class="form-control" name="new_password" id="new_password" <?php if($user_details->password_change == 'N'){echo "disabled";} ?>>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Retype Password</label>
								<input type="password" class="form-control" name="retype_password" id="retype_password" <?php if($user_details->password_change == 'N'){echo "disabled";} ?>>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Next Change Date</label>
								<input type="date" class="form-control" name="next_change_date" id="next_change_date" readonly <?php if($user_details->password_change == 'N'){echo "disabled";} ?>>
							</div>
						</div>
					</div>
                    <?php if($user_details->password_change == 'Y'){?>
					<div class="row">
						<div class="col-sm-12 col-md-12 d-flex justify-content-end">
							<button type="submit" class="btn btn-primary">Change</button>&emsp;
							<button type="reset" class="btn btn-danger">Clear</button>
						</div>
					</div>
					<?php } ?>

				</form>

			</div>
		</div>

	</div>

</div>
<!--End Profile Page-->

</div>
</div><!-- end app-content-->
<script type="text/javascript">
	var baseUrl = '<?= base_url() ?>';
	var pageURL = 'password_settings/change_password/';

	$(document).ready(function () {

		//Submit the modal form
		$("#modalFormAdd").on('submit', (function (e) {
			e.preventDefault();
			ajaxFromSubmit(pageURL + 'save', this, function (data) {
				successMsg('Data save success');
				$('#modalFormAdd .form-control').val('');
			});
		}));
	});
</script>
