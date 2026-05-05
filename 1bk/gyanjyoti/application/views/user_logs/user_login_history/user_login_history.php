<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="page-title">
                <h4><?= $page_title ?></h4>
            </div>
            <div class="page-btn">
                <!---<button type="button" class="btn btn-primary" onclick="openModal()">
                    Add User Role
                </button> ---> 
            </div>
        </div>

        <?php
        if(!empty($branch)):
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
						<div class="form-group">
							<select class="form-controll" name="branch_id" id="branch_id" onchange="getDataList(this.value)">
								<option value="" selected disabled>Select Branch Name</option>
								<?php
								if(!empty($branch)):
									foreach($branch as $key => $value):
								?>
								<option value="<?= $value->id ?>"><?= decrypt($value->branch_code) ?></option>
								<?php
									endforeach;
								endif;
								?>
							</select>
						</div>
                        <div class="table-responsive">
                            <table class="table table-sm" id="user_role_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User Name</th>
										<th>Branch Code</th>
                                        <th>Login Location</th>
										<th>Login Postalcode</th>
										<th>IP Address</th>
										<th>Login Time</th>
										<th>Logout Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        else:
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
						<div class="form-group">
							<select class="form-controll" name="branch_id" id="branch_id" onchange="getDataList(this.value)">
								<option value="" selected disabled>Select User</option>
								<?php
								if(!empty($users)):
									foreach($users as $key => $value):
								?>
								<option value="<?= $value->id ?>"><?= decrypt($value->user_first_name). ' ' . decrypt($value->user_last_name) . '(' . decrypt($value->user_code) . ')' ?></option>
								<?php
									endforeach;
								endif;
								?>
							</select>
						</div>
                        <div class="table-responsive">
                            <table class="table table-sm" id="user_role_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User Name</th>
										<th>Old Branch Code</th>
                                        <th>Current Branch Code</th>
										<th>Changed At</th>
										<!--<th>Changed By</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        endif;
        ?>
    </div>
</div>

<?php //$this->load->view('master_settings/user_role_master/user_role_modal'); ?>

<script type="text/javascript">
    var baseUrl = '<?= base_url() ?>';
    var pageURL = 'user_logs/user_login_history/';
    // var modalId = 'user_role_modal';
    var tableName = 'user_role_table';
    $(document).ready(function() {
        servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');
        $('#branch_id').select2();
    });

	function getDataList(branch_id = 0){
		servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list/'+branch_id);
	}
</script>
