<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="<?= base_url('public/admin/assets/js/vendor/forms/validation/validate.min.js') ?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
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

	});
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
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0"><?= $title ?></h5>
				</div>

				<form method="post" class="needs-validation" action="#" novalidate id="menuForm" data-id="">
					<div class="card-body">
						<div id="showMsg"></div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Menu <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select class="form-control" name="menu_id" id="menu_id" required>
									<option value="">Select Menu</option>
									<?php
										if (isset($menus) && !empty($menus)) {
										    // Build an index for quick parent lookup
										    $menuIndex = [];
										    foreach ($menus as $m) {
										        $menuIndex[$m['id']] = $m['title'];
										    }

										    foreach ($menus as $menu) {
										        $title = $menu['title'];

										        // If parent exists, prepend parent title
										        if (!empty($menu['parent_id']) && isset($menuIndex[$menu['parent_id']])) {
										            $title = $menuIndex[$menu['parent_id']] . ' - ' . $title;
										        }

										        echo '<option value="'.$menu['id'].'">'.$title.'</option>';
										    }
										}
									?>
								</select>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-4">User ID <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select class="form-control" name="user_id" id="user_id" required>
									<option value="">Select User ID</option>
									<?php
									if( isset($users) && !empty($users) ) {
										foreach ($users as $user) {
											echo '<option value="'.$user['id'].'">'.$user['first_name'].' '.$user['last_name'].'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Can View </label>
							<div class="col-lg-8">
								<label class="form-check mb-2">
									<input name="can_view" id="can_view" type="checkbox" class="form-check-input form-check-input-success" >
								</label>
							</div>
						</div>

						<div style="display: none;">
							<div class="row mb-3">
								<label class="col-form-label col-lg-4">Can Add </label>
								<div class="col-lg-8">
									<label class="form-check mb-2">
										<input name="can_add" id="can_add" type="checkbox" class="form-check-input form-check-input-info" checked>
									</label>
								</div>
							</div>
							<div class="row mb-3">
								<label class="col-form-label col-lg-4">Can Edit </label>
								<div class="col-lg-8">
									<label class="form-check mb-2">
										<input name="can_edit" id="can_edit" type="checkbox" class="form-check-input form-check-input-info" checked>
									</label>
								</div>
							</div>
							<div class="row mb-3">
								<label class="col-form-label col-lg-4">Can Delete </label>
								<div class="col-lg-8">
									<label class="form-check mb-2">
										<input name="can_delete" id="can_delete" type="checkbox" class="form-check-input form-check-input-danger" checked>
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="card-footer text-end">
						<button id="menuFormReset" type="button" class="btn btn-light">Reset <i class="ph-paper-plane-tilt ms-2"></i></button>
						<button id="menuFormSubmit" type="button" class="btn btn-primary">Submit <i class="ph-paper-plane-tilt ms-2"></i></button>
					</div>
				</form>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Menu Permission Lists</h5>
				</div>

				<table id="menuPermissionLists" class="display">
				    <thead>
				        <tr>
				            <th>ID</th>
				            <th>User Name</th>
				            <th>Menu Title</th>
				            <th>Can View</th>
				            <th>Action</th>
				        </tr>
				    </thead>
				</table>
				

			</div>
		</div>
	</div>
	<!-- /custom styles -->
</div>
<!-- /content area -->

