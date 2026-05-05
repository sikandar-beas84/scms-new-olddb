<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="<?= base_url('public/admin/assets/js/vendor/forms/validation/validate.min.js') ?>"></script>

<script type="text/javascript">
	$(document).ready(function () {
	    $('#feeStructureLists').DataTable({
	        columnDefs: [
	            {
	                targets: 0,         // First column
	                visible: false,     // Hide column
	                searchable: false,  // Exclude from search
	                orderable: true     // Still used for ordering
	            }
	        ],
	        order: [[0, 'desc']], // Sort by hidden "ID" column descending
	        responsive: true,
	        pageLength: 10
	    });
	});

	/*$(document).ready(function(){
		// Datatable ajax call
	    var table = $('#menuPermissionLists').DataTable({
	        ajax: {
	         	url: "<?= base_url('admin/menu-permission/fetch') ?>",
	         	dataSrc: 'permissions',
		        type: 'POST',
		        dataType: 'json',
	        },
	        columns: [
	            { data: 'id' },
          	 	{ 
					data: null,
					render: function(data, type, row) {
					  	let fname = row.first_name ? row.first_name : '';
					  	let lname = row.last_name ? row.last_name : '';
					  	return fname + ' ' + lname;
					},
					defaultContent: ''
				},
	            { data: 'menu_title' },
	            {
		            data: 'can_view',
		            render: function(data, type, row) {
		                let checked = (data === 't' || data === true || data === 1 || data === '1' || data === 'true') ? 'checked' : '';
		                return `
		                <div class="form-check-horizontal">
							<label class="form-check form-switch mb-0">
								<input type="checkbox" class="menu-can-view form-check-input" data-id="${row.id}" ${checked} />
							</label>
						</div>		                    
		                `;
	            	},
	        	},
	            {
	                data: null,
	                render: function(data, type, row) {
	                    return `
	                        <span class="editBtn" data-id="${row.id}" title="Edit"><i class="ph-note-pencil"></i></span> | <span class="deleteBtn" data-id="${row.id}" title="Delete"><i class="ph-trash"></i></span>
	                    `;
	                }
	            }
	        ],

	        columnDefs: [
	            { targets: 0, visible: false, searchable: false, orderable: true }
	        ],
	        order: [[0, 'desc']],
	    });

		$(document).on('change', '.menu-can-view', function(){
		    let checkbox = $(this);
		    let id = checkbox.data('id');
		    let isChecked = checkbox.prop('checked') ? 1 : 0;

	        $.ajax({
	            url: "<?= base_url('admin/menu-permission/set-menu-view') ?>",
	            type: "POST",
	            data: {
	                id: id,
	                is_checked: isChecked,
	                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
	            },
	            success: function(res) {
	                // Reload DataTable to update toggles
	                table.ajax.reload(null, false);
	            },
	            error: function() {
	                console.log("Failed to update menu permission");
	                checkbox.prop('checked', false)
	            }
	        });
		});	
	    
		// Delegated event on tbody — reliable and efficient
	    $('#menuPermissionLists tbody').on('click', '.editBtn', function(e) {
	        e.preventDefault();
	        const id = $(this).data('id');

	        $.ajax({
	            url: "<?= base_url('admin/menu-permission/get-menu-permission') ?>",
	            type: "POST",
	            data: {
	                id: id,
	                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
	            },
	            dataType: "json"
	        })
	        .done(function(res) {
	            // console.log('AJAX response:', res); // <-- debug line

	            if (res.status === 'success') {
	                // $('#menu_id').val(res.menu_permissions.menu_id);
	                // $('#user_id').val(res.menu_permissions.user_id);
	                // $('#can_view').val(res.menu_permissions.can_view);


	                // ✅ Set select box selected option
					$('#menu_id').val(res.menu_permissions.menu_id).trigger('change'); 
					$('#user_id').val(res.menu_permissions.user_id).trigger('change'); 

					// ✅ Set checkbox based on value (1 = checked, 0 = unchecked)
					$('#can_view').prop('checked', res.menu_permissions.can_view == 1);

	                $('#menuForm').attr('data-id', id);
	                $("#menuFormSubmit").html('Update <i class="ph-paper-plane-tilt ms-2"></i>')
	            } else {
	                console.log(res.message || 'menu not found');
	                // $("#menuFormSubmit").html('Submit <i class="ph-paper-plane-tilt ms-2"></i>')
	            }
	        })
	        .fail(function(xhr, status, err) {
	            console.error('AJAX failed', status, err, xhr.responseText);
	            console.log('Failed to fetch session. See console for details.');
	            $("#menuFormSubmit").html('Submit <i class="ph-paper-plane-tilt ms-2"></i>')
	        });
	    });

	    // Initialize jQuery Validation
	    $("#menuForm").validate({
	        rules: {
	            menu_id: {
	                required: true
	            },
	            user_id: {
	                required: true,
	            }
	        },
	        messages: {
	            menu_id: "Please select a menu.",
	            user_id: "Please select a user.",
	        },
	        submitHandler: function (form) {
	            // This runs only if form is valid
	            let id = $("#menuForm").attr("data-id") || "";
	            $("#showMsg").html("")

	            $.ajax({
	                url: "<?= base_url('admin/menu-permission/save') ?>",
	                type: "POST",
	                data: {
	                    id: id,
	                    menu_id: $("#menu_id").val(),
	                    user_id: $("#user_id").val(),
	                    can_view: $('#can_view').is(':checked') ? 1 : 0,
					    can_add: $('#can_add').is(':checked') ? 1 : 0,
					    can_edit: $('#can_edit').is(':checked') ? 1 : 0,
					    can_delete: $('#can_delete').is(':checked') ? 1 : 0,
	                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
	                },
	                dataType: "json",
	                success: function (res) {
	                    if (res.status === "success") {
	                        let msgHtml = '<div class="alert alert-primary border-0 alert-dismissible fade show">'+res.message+'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'
	                        $("#showMsg").html(msgHtml)

	                        $("#menuForm")[0].reset();
	                        $("#menuForm").removeAttr("data-id");
	                        table.ajax.reload(null, false); // reload datatable
	                    } else {
	                        let msgHtml = '<div class="alert alert-primary border-0 alert-dismissible fade show">'+res.message+'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'
	                        $("#showMsg").html(msgHtml)
	                    }
	                }
	            });
	        }
	    });

	    // Trigger validation + AJAX on button click
	    $(document).on("click", "#menuFormSubmit", function () {
	        $("#menuForm").submit();
	    });

	    $(document).on("click", "#menuFormReset", function () {
	        $("#menuForm")[0].reset();
			$("#menuForm").removeAttr("data-id");
	    });
	    

	    // Delete
	    // $('#areaTable').on('click', '.deleteBtn', function(){
	    //     if(!confirm('Delete this area?')) return;
	    //     var id = $(this).data('id');
	    //     $.get("<?= site_url('areas/delete/') ?>" + id, function(res){
	    //         if(res.status === 'success'){
	    //             table.ajax.reload();
	    //         }
	    //     }, 'json');
	    // });

	});*/
</script>

<!-- Page header -->
<div class="page-header page-header-primary shadow">
	
	<div class="page-header-content d-lg-flex border-top">
		<div class="d-flex">
			<div class="breadcrumb py-2">
				<a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
				<a href="javascript:;" class="breadcrumb-item"><?= $title ?></a>
				<!-- <span class="breadcrumb-item active">Validation styles</span> -->
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

				<form method="post" class="needs-validation" action="<?= base_url() ?>admin/feestructure/update-fee/<?= $fee_id ?>" novalidate id="menuForm" data-id="">
					<div class="card-body">
						<div id="showMsg"></div>
						<?php if (session()->getFlashdata('error_msg')): ?>
						    <div class="alert alert-danger">
						        <?= session()->getFlashdata('error_msg'); ?>
						    </div>
						<?php endif; ?>

						<?php if (session()->getFlashdata('success_msg')): ?>
						    <div class="alert alert-success">
						        <?= session()->getFlashdata('success_msg'); ?>
						    </div>
						<?php endif; ?>


						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Session Year<span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select class="form-control" name="session_year_id" id="session_year_id">
									<?php if(isset($session_year_lists)){
										foreach($session_year_lists as $key => $session_year) { ?>													
											<option value="<?= $session_year['id'] ?>" <?= (($fees_details['session_year_id'] == $session_year['id']) ? 'selected' : '')?>><?= $session_year['session_name']; ?></option>
										<?php }													
									} ?> 
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Class <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select class="form-control" name="class_id">
									<option value="">-- Select Class--</option>
									<?php foreach($class_list as $class): ?>							
										<option value="<?= $class['id'] ?>" <?= (($fees_details['class_id'] == $class['id']) ? 'selected' : '')?>><?= $class['class_name'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Admission Fee (<i class="bi bi-currency-rupee"></i>) <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input type="text" name="admission_fee" class="form-control" placeholder="e.g - 10000" value="<?= $fees_details['admission_fee'] ?>">
							</div>
						</div>
						<div class="row mb-3">
						    <label class="col-form-label col-lg-4">
						        Development Fee (<i class="bi bi-currency-rupee"></i>) <span class="text-danger">*</span>
						    </label>
						    <div class="col-lg-8">
						        <input type="text" name="development_fee" class="form-control" placeholder="e.g - 1000" value="<?= $fees_details['development_fee'] ?>">
						    </div>
						</div>

						<div class="row mb-3">
						    <label class="col-form-label col-lg-4">
						        Exam Fee (<i class="bi bi-currency-rupee"></i>) <span class="text-danger">*</span>
						    </label>
						    <div class="col-lg-8">
						        <input type="text" name="exam_fee" class="form-control" placeholder="e.g - 1000" value="<?= $fees_details['exam_fee'] ?>">
						    </div>
						</div>

						<div class="row mb-3">
						    <label class="col-form-label col-lg-4">
						        Festival Celebration Fee (<i class="bi bi-currency-rupee"></i>) <span class="text-danger">*</span>
						    </label>
						    <div class="col-lg-8">
						        <input type="text" name="festival_celebration_fee" class="form-control" placeholder="e.g - 1000" value="<?= $fees_details['festival_celebration_fee'] ?>">
						    </div>
						</div>

						<div class="row mb-3">
						    <label class="col-form-label col-lg-4">
						        Games Sports Fee (<i class="bi bi-currency-rupee"></i>) <span class="text-danger">*</span>
						    </label>
						    <div class="col-lg-8">
						        <input type="text" name="games_sports_fee" class="form-control" placeholder="e.g - 1000" value="<?= $fees_details['games_sports_fee'] ?>">
						    </div>
						</div>

						<div class="row mb-3">
						    <label class="col-form-label col-lg-4">
						        Audio Visual Lab Fee (<i class="bi bi-currency-rupee"></i>) <span class="text-danger">*</span>
						    </label>
						    <div class="col-lg-8">
						        <input type="text" name="audio_visual_lab_fee" class="form-control" placeholder="e.g - 1000" value="<?= $fees_details['audio_visual_lab_fee'] ?>">
						    </div>
						</div>

						<div class="row mb-3">
						    <label class="col-form-label col-lg-4">
						        Library Fee (<i class="bi bi-currency-rupee"></i>) <span class="text-danger">*</span>
						    </label>
						    <div class="col-lg-8">
						        <input type="text" name="library_fee" class="form-control" placeholder="e.g - 1000" value="<?= $fees_details['library_fee'] ?>">
						    </div>
						</div>

						<div class="row mb-3">
						    <label class="col-form-label col-lg-4">
						        Electricity Maintenance Fee (<i class="bi bi-currency-rupee"></i>) <span class="text-danger">*</span>
						    </label>
						    <div class="col-lg-8">
						        <input type="text" name="electricity_maintenance_fee" class="form-control" placeholder="e.g - 1000" value="<?= $fees_details['electricity_maintenance_fee'] ?>">
						    </div>
						</div>

						<div class="row mb-3">
						    <label class="col-form-label col-lg-4">
						        Computer Fee (<i class="bi bi-currency-rupee"></i>) <span class="text-danger">*</span>
						    </label>
						    <div class="col-lg-8">
						        <input type="text" name="computer_fee" class="form-control" placeholder="e.g - 200" value="<?= $fees_details['computer_fee'] ?>">
						    </div>
						</div>

						<div class="row mb-3">
						    <label class="col-form-label col-lg-4">
						        Security Deposit (<i class="bi bi-currency-rupee"></i>) <span class="text-danger">*</span>
						    </label>
						    <div class="col-lg-8">
						        <input type="text" name="security_deposite" class="form-control" placeholder="e.g - 500" value="<?= $fees_details['security_deposite'] ?>">
						    </div>
						</div>

						<div class="row mb-3">
						    <label class="col-form-label col-lg-4">
						        Tuition Fee (<i class="bi bi-currency-rupee"></i>) <span class="text-danger">*</span>
						    </label>
						    <div class="col-lg-8">
						        <input type="text" name="tuition_fee" class="form-control" placeholder="e.g - 1000" value="<?= $fees_details['tuition_fee'] ?>">
						    </div>
						</div>

						<div class="row mb-3">
						    <label class="col-form-label col-lg-4">Status  <span class="text-danger">*</span></label>
						    <div class="col-lg-8">
						        <div class="form-check form-check-inline">
						            <input name="status" type="radio" class="form-check-input" value="1" <?= (($fees_details['status'] == 1) ? 'checked' : '')?>>
						            <span class="badge bg-success">Active</span>
						        </div>

						        <div class="form-check form-check-inline">
						            <input name="status" type="radio" class="form-check-input" value="0" <?= (($fees_details['status'] == 0) ? 'checked' : '')?>>
						            <span class="badge bg-danger">Inactive</span>
						        </div>
						    </div>
						</div>


					</div>

					<div class="card-footer text-end">
						<a href="<?= base_url() ?>admin/feestructure" class="btn btn-warning">Back <i class="ph ph-skip-back ms-2"></i></a>
						<button id="menuFormSubmit" type="submit" class="btn btn-primary">Update <i class="ph-paper-plane-tilt ms-2"></i></button>
					</div>
				</form>
			</div>
		</div>
		
	</div>
	<!-- /custom styles -->
</div>
<!-- /content area -->

