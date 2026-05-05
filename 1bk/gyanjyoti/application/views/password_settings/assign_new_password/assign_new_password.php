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

					<div id="assign_password_div">
						<div class="row">
							<div class="col-sm-6 col-md-6">
								<div class="form-group">
									<label class="form-label">User Code</label>
									<input type="text" class="form-control" name="user_code" id="user_code" onblur="getUserDetails(this.value)" value="">
								</div>
							</div>
							<div class="col-sm-6 col-md-6">
								<div class="form-group">
									<label class="form-label">User Name</label>
									<input type="text" class="form-control" name="username" id="username" readonly>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 col-md-6">
								<div class="form-group">
									<label class="form-label">New Password</label>
									<input type="password" class="form-control" name="new_password" id="new_password" value="" readonly>
								</div>
							</div>
							<div class="col-sm-6 col-md-6">
								<div class="form-group">
									<label class="form-label">Retype Password</label>
									<input type="password" class="form-control" name="retype_password" id="retype_password" value="" readonly>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12 col-md-12 d-flex justify-content-end">
								<button type="submit" class="btn btn-primary">Assign</button>&emsp;
								<button type="reset" class="btn btn-danger">Clear</button>
							</div>
						</div>

					</div>

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
    var pageURL = 'password_settings/assign_new_password/';
    
    $(document).ready(function() {
        
        //Submit the modal form
        $("#modalFormAdd").on('submit', (function (e) {
            e.preventDefault();
            ajaxFromSubmit(pageURL+'save', this, function (data) {
                successMsg('Data save success');
				$('#modalFormAdd .form-control').val('');
            });
        }));
    });

    function getUserDetails(userCode = ''){
		if(userCode != ''){
			ajaxPostRequest(pageURL+'get_user_details', {'user_code': userCode}, function (data){
			    if(data.password_change == 'N'){        //CR by Suhrid Sarkar || suhrid.developer@gmail.com for checking if user allow to change password o not on May 20, 2023
			        $('#username').val('');
			        errorMsg('User not allow to change password!');
			        $('#new_password').attr('readonly', true);
    				$('#retype_password').attr('readonly', true);
			    } else{
			        if(data.has_user == 1){
    					$('#username').val(data.user_name);
    					$('#new_password').attr('readonly', false);
    					$('#retype_password').attr('readonly', false);
    				} else{
    					$('#username').val('');
    					errorMsg('User details not found using this User Code.');
    					$('#new_password').attr('readonly', true);
    					$('#retype_password').attr('readonly', true);
    				}
			    }
				
			});
		} else{
			errorMsg('Please enter user code.');
			$('#username').val('');
		}
	}
</script>
