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
	    var table = $('#designationLists').DataTable({
	        ajax: {
	         	url: "<?= base_url('admin/staff-management/fetch-designation') ?>",
	         	// dataSrc: 'designation',
         	 	dataSrc: function(json) {
		            console.log("Full response:", json); // raw API response
		            console.log("Designation data:", json.designation); // just the data array
		            return json.designation; // must return the array for DataTables
		        },
		        type: 'POST',
		        dataType: 'json',
	        },
	        columns: [
	            { data: 'id' },
	            { data: 'name' },
	            // { data: 'status' },
	            {
		            data: 'status',
		            render: function(data, type, row) {
		                let checked = (data === 't' || data === true || data === 1 || data === '1' || data === 'true') ? 'checked' : '';
		                let label = (data === 't' || data === true || data === 1 || data === '1' || data === 'true') ? '<span style="color: green;">Active</span>' : '<span style="color: red;">Inactive</span>';
		                return `
		                <div class="form-check-horizontal">
							<label class="form-check form-switch mb-0">
								<input type="checkbox" class="designation-status form-check-input" data-id="${row.id}" ${checked} />
								<span class="form-check-label">${label}</span>
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
	        searching: false,
	        paging: false,
	        info: false
	    });
	    
		$(document).on('change', '.designation-status', function(){
		    let checkbox = $(this);
		    let id = checkbox.data('id');
		    let isChecked = checkbox.prop('checked');

		    // if (isChecked) {
		        $.ajax({
		            url: "<?= base_url('admin/staff-management/change-designation-status') ?>",
		            type: "POST",
		            data: {
		                id: id,
		                status: isChecked,
		                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
		            },
		            success: function(res) {
		                // Reload DataTable to update toggles
		                table.ajax.reload(null, false);
		            },
		            error: function() {
		                console.log("Failed to update designation");
		                checkbox.prop('checked', false)
		            }
		        });
		    // } else {
		    //     // Prevent turning OFF manually
		    //    checkbox.prop('checked', true)
		    // }
		});	

		// Delegated event on tbody — reliable and efficient
	    $('#designationLists tbody').on('click', '.editBtn', function(e) {
	        e.preventDefault();
	        const id = $(this).data('id');
	        // admin/staff-management/fetch-designation
	        $.ajax({
	            url: "<?= base_url('admin/staff-management/get-designation') ?>",
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
	                $('#designation_name').val(res.designation.name);
	                let statusVal = res.designation.status === "t" ? "true" : "false";

	                $('#status').val(statusVal);

	                $('#designationForm').attr('data-id', id);
	                $("#designationFormSubmit").html('Update <i class="ph-paper-plane-tilt ms-2"></i>')
	                
	                console.log(res.message || 'Designation not found');
	                $("#designationFormSubmit").html('Submit <i class="ph-paper-plane-tilt ms-2"></i>')
	            }
	        })
	        .fail(function(xhr, status, err) {
	            console.error('AJAX failed', status, err, xhr.responseText);
	            console.log('Failed to fetch designation. See console for details.');
	            $("#designationFormSubmit").html('Submit <i class="ph-paper-plane-tilt ms-2"></i>')
	        });
	    });

	    // Initialize jQuery Validation
	    $("#designationForm").validate({
	        rules: {
	            designation_name: {
	                required: true
	            },
	            status: {
	                required: true,
	            }
	        },
	        messages: {
	            designation_name: "Please enter a designation name.",
	            status: "Please select status",
	        },
	        submitHandler: function (form) {
	            // This runs only if form is valid
	            let id = $("#designationForm").attr("data-id") || "";
	            $("#showMsg").html("")

	            $.ajax({
	                url: "<?= base_url('admin/staff-management/save-designation/') ?>",
	                type: "POST",
	                data: {
	                    id: id,
	                    name: $("#designation_name").val(),
	                    status: $("#status").val(),
	                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
	                },
	                dataType: "json",
	                success: function (res) {
	                    if (res.status === "success") {
	                        let msgHtml = '<div class="alert alert-primary border-0 alert-dismissible fade show">'+res.message+'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'
	                        $("#showMsg").html(msgHtml)

	                        $("#designationForm")[0].reset();
	                        $("#designationForm").removeAttr("data-id");
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
	    $(document).on("click", "#designationFormSubmit", function () {
	        $("#designationForm").submit();
	    });

	    $(document).on("click", "#designationFormReset", function () {
	        $("#designationForm")[0].reset();
			$("#designationForm").removeAttr("data-id");
	    });
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
		<div class="col-lg-5">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0"><?= $title ?></h5>
				</div>

				<form method="post" class="needs-validation" action="#" novalidate id="designationForm" data-id="">
					<div class="card-body">
						<div id="showMsg"></div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Name <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="designation_name" id="designation_name" type="text" class="form-control" required placeholder="">
								<div class="invalid-feedback">Invalid Designation Name</div>
								<div class="valid-feedback">Valid Designation Name</div>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Status<span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select  name="status" id="status"  class="form-control" required>
									<option value="">Select Status</option>
									<option value="true">Active</option>
									<option value="false">Inactive</option>
								</select>
								<div class="invalid-feedback">Invalid Status</div>
								<div class="valid-feedback">Valid Status</div>
							</div>
						</div>
						

					</div>

					<div class="card-footer text-end">
						<button id="designationFormReset" type="button" class="btn btn-light">Reset <i class="ph-paper-plane-tilt ms-2"></i></button>
						<button id="designationFormSubmit" type="button" class="btn btn-primary">Submit <i class="ph-paper-plane-tilt ms-2"></i></button>
					</div>
				</form>
			</div>
		</div>
		<div class="col-lg-7">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Designation List</h5>
				</div>

				<table id="designationLists" class="display">
				    <thead>
				        <tr>
				            <th>ID</th>
				            <th>Name</th>
				            <th>Status</th>
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

