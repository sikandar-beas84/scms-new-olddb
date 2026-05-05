<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="<?= base_url('public/admin/assets/js/vendor/forms/validation/validate.min.js') ?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
		// Datatable ajax call
	    var table = $('#stoppageLists').DataTable({
	        ajax: {
	         	url: "<?= base_url('admin/stoppage/fetch') ?>",
	         	dataSrc: 'stoppage',
		        type: 'POST',
		        dataType: 'json',
	        },
	        columns: [
	            { data: 'stoppage_id' },
	            { data: 'stoppage_name' },
	            { data: 'stoppage_fare' },
	            {
				    data: 'status',
				    render: function (data, type, row) {
				        return data == 1 
				            ? '<span class="badge bg-success">Active</span>' 
				            : '<span class="badge bg-danger">Inactive</span>';
				    }
				},
	            {
	                data: null,
	                render: function(data, type, row) {
	                    return `
	                        <span class="editBtn" data-id="${row.stoppage_id}" title="Edit"><i class="ph-note-pencil"></i></span> | <span class="deleteBtn" data-id="${row.stoppage_id}" title="Delete"><i class="ph-trash"></i></span>
	                    `;
	                }
	            }
	        ],

	        
	        columnDefs: [
	            { targets: 0, visible: false, searchable: false, orderable: true }
	        ],
	        order: [[0, 'desc']],
	        searching: true,
	        paging: true,
	        info: true
	    });

	    
		// Delegated event on tbody — reliable and efficient
	    $('#stoppageLists tbody').on('click', '.editBtn', function(e) {
	        e.preventDefault();
	        const id = $(this).data('id');

	        $.ajax({
	            url: "<?= base_url('admin/stoppage/get-stoppage') ?>",
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
	                $('#stoppage_name').val(res.stoppage.stoppage_name);
	                $('#stoppage_fare').val(res.stoppage.stoppage_fare);
	                $('#status').val(res.stoppage.status);
	                $('#stoppageForm').attr('data-id', id);
	                $("#stoppageFormSubmit").html('Update <i class="ph-paper-plane-tilt ms-2"></i>')
	            } else {
	                console.log(res.message || 'stoppage not found');
	                $("#stoppageFormSubmit").html('Submit <i class="ph-paper-plane-tilt ms-2"></i>')
	            }
	        })
	        .fail(function(xhr, status, err) {
	            console.error('AJAX failed', status, err, xhr.responseText);
	            console.log('Failed to fetch stoppage. See console for details.');
	            $("#stoppageFormSubmit").html('Submit <i class="ph-paper-plane-tilt ms-2"></i>')
	        });
	    });

	    // Initialize jQuery Validation
	    $("#stoppageForm").validate({
	        rules: {
	            stoppage_name: {
	                required: true
	            },
	            stoppage_fare: {
	                required: true
	            },
	            status: {
	                required: true
	            }
	        },
	        messages: {
	            stoppage_name: "Please enter a stoppage name.",
	            stoppage_fare: "Please enter a stoppage fare.",
	            status: "Please select status."
	        },
	        submitHandler: function (form) {
	            // This runs only if form is valid
	            let id = $("#stoppageForm").attr("data-id") || "";
	            $("#showMsg").html("")

	            $.ajax({
	                url: "<?= base_url('admin/stoppage/save') ?>",
	                type: "POST",
	                data: {
	                    id: id,
	                    stoppage_name: $("#stoppage_name").val(),
	                    stoppage_fare: $("#stoppage_fare").val(),
	                    status: $("#status").val(),
	                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
	                },
	                dataType: "json",
	                success: function (res) {
	                    if (res.status === "success") {
	                        let msgHtml = '<div class="alert alert-primary border-0 alert-dismissible fade show">'+res.message+'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'
	                        $("#showMsg").html(msgHtml)

	                        $("#stoppageForm")[0].reset();
	                        $("#stoppageForm").removeAttr("data-id");
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
	    $(document).on("click", "#stoppageFormSubmit", function () {
	        $("#stoppageForm").submit();
	    });

	    $(document).on("click", "#stoppageFormReset", function () {
	        $("#stoppageForm")[0].reset();
			$("#stoppageForm").removeAttr("data-id");
	    });

	    // Delete
		$('#stoppageLists').on('click', '.deleteBtn', function () {

		    var id = $(this).data('id');

		    Swal.fire({
		        title: 'Are you sure?',
		        text: 'This stoppage will be permanently deleted!',
		        icon: 'warning',
		        showCancelButton: true,
		        confirmButtonColor: '#d33',
		        cancelButtonColor: '#3085d6',
		        confirmButtonText: 'Yes, delete it!',
		        cancelButtonText: 'Cancel'
		    }).then((result) => {
		        if (result.isConfirmed) {
		            $.get("<?= site_url('admin/stoppage/delete/') ?>" + id, function (res) {
		                if (res.status === 'success') {
		                    Swal.fire(
		                        'Deleted!',
		                        'Stoppage has been deleted.',
		                        'success'
		                    );

		                    table.ajax.reload(null, false); // keep pagination
		                } else {
		                    Swal.fire(
		                        'Error!',
		                        res.message ?? 'Delete failed.',
		                        'error'
		                    );
		                }

		            }, 'json').fail(function () {
		                Swal.fire(
		                    'Error!',
		                    'Server error occurred.',
		                    'error'
		                );
		            });
		        }
		    });
		})
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

				<form method="post" class="needs-validation" action="#" novalidate id="stoppageForm" data-id="">
					<div class="card-body">
						<div id="showMsg"></div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Stoppage Name <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="stoppage_name" id="stoppage_name" type="text" class="form-control" required placeholder="Stoppage Name">
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Stoppage Fare <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="stoppage_fare" id="stoppage_fare" type="text" class="form-control" value="" required autocomplete="off">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Status <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select name="status" id="status" class="form-control" required>
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select>
							</div>
						</div>

					</div>

					<div class="card-footer text-end">
						<button id="stoppageFormReset" type="button" class="btn btn-light">Reset <i class="ph-paper-plane-tilt ms-2"></i></button>
						<button id="stoppageFormSubmit" type="button" class="btn btn-primary">Submit <i class="ph-paper-plane-tilt ms-2"></i></button>
					</div>
				</form>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Stoppage Lists</h5>
				</div>

				<table id="stoppageLists" class="display">
				    <thead>
				        <tr>
				            <th>ID</th>
				            <th>Stoppage Name</th>
				            <th>Stoppage Fare</th>
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

