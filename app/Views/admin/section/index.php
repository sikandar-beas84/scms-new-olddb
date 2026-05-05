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
	function initDatePickers() {
	    $(".datepicker-basic").datepicker({
	        dateFormat: "yy-mm-dd", // yyyy-mm-dd
	        changeMonth: true,
	        changeYear: true
	    });
	}

	$(document).ready(function(){
		// Datepicker
    	initDatePickers()

		// Datatable ajax call
	    var table = $('#sectionListsTable').DataTable({
	    	pageLength: 25,
		    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
		    responsive: true,
	        ajax: {
	         	url: "<?= base_url('admin/section/fetch') ?>",
	         	// dataSrc: 'sections',
		        type: 'POST',
		        dataType: 'json',
		        dataSrc: function(json) {
		            // console.log("Full response:", json); // raw API response
		            // console.log("Designation data:", json.sections); // just the data array
		            return json.sections; // must return the array for DataTables
		        },
	        },
	        columns: [
	            { data: 'id' },
	            { data: 'section_name' },
	            { data: 'class_name' },
	            { data: 'full_name' },
	            { data: 'no_of_student' },
	            { data: 'session_name' },
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
	    
		// Delegated event on tbody — reliable and efficient
	    $('#sectionListsTable tbody').on('click', '.editBtn', function(e) {
	        e.preventDefault();
	        const id = $(this).data('id');

	        $.ajax({
	            url: "<?= base_url('admin/section/get-section') ?>",
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
	                $('#class_id').val(res.sections.class_id);
	                $('#teacher_id').val(res.sections.teacher_id);
	                $('#section_name').val(res.sections.section_name);
	                $('#no_of_student').val(res.sections.no_of_student);
	                $('#sectionForm').attr('data-id', id);
	                $("#sectionFormSubmit").html('Update <i class="ph-paper-plane-tilt ms-2"></i>')
	            } else {
	                console.log(res.message || 'Section not found');
	                $("#sectionFormSubmit").html('Submit <i class="ph-paper-plane-tilt ms-2"></i>')
	            }
	        })
	        .fail(function(xhr, status, err) {
	            console.error('AJAX failed', status, err, xhr.responseText);
	            console.log('Failed to fetch section. See console for details.');
	            $("#sectionFormSubmit").html('Submit <i class="ph-paper-plane-tilt ms-2"></i>')
	        });
	    });

	    // Initialize jQuery Validation
	    $("#sectionForm").validate({
	        rules: {
	            class_id: {
	                required: true
	            },
	            teacher_id: {
	                required: true
	            },
	            section_name: {
	                required: true
	            },
	            no_of_student: {
	                required: true,
	                digits: true,
					min: 1
	            }
	        },
	        messages: {
	            class_id: "Please select a class.",
	            teacher_id: "Please select a teacher.",
	            section_name: "Please enter section name.",
	            no_of_student: {
			        required: "Please enter number of students",
			        digits: "Only whole numbers are allowed",
			        min: "Value must be greater than 0"
			    }
	        },
	        submitHandler: function (form) {
	            // This runs only if form is valid
	            let id = $("#sectionForm").attr("data-id") || "";
	            $("#showMsg").html("")

	            $.ajax({
	                url: "<?= base_url('admin/section/save') ?>",
	                type: "POST",
	                data: {
	                    id: id,
	                    class_id: $("#class_id").val(),
	                    teacher_id: $("#teacher_id").val(),
	                    section_name: $("#section_name").val(),
	                    no_of_student: $("#no_of_student").val(),
	                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
	                },
	                dataType: "json",
	                success: function (res) {
	                    if (res.status === "success") {
	                        let msgHtml = '<div class="alert alert-primary border-0 alert-dismissible fade show">'+res.message+'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'
	                        $("#showMsg").html(msgHtml)

	                        $("#sectionForm")[0].reset();
	                        $("#sectionForm").removeAttr("data-id");
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
	    $(document).on("click", "#sectionFormSubmit", function () {
	        $("#sectionForm").submit();
	    });

	    $(document).on("click", "#sectionFormReset", function () {
	        $("#sectionForm")[0].reset();
			$("#sectionForm").removeAttr("data-id");
	    });
	    
	    // Delete
		$('#sectionListsTable').on('click', '.deleteBtn', function () {

		    var id = $(this).data('id');

		    Swal.fire({
		        title: 'Are you sure?',
		        text: 'This section will be permanently deleted!',
		        icon: 'warning',
		        showCancelButton: true,
		        confirmButtonColor: '#d33',
		        cancelButtonColor: '#3085d6',
		        confirmButtonText: 'Yes, delete it!',
		        cancelButtonText: 'Cancel'
		    }).then((result) => {
		        if (result.isConfirmed) {
		            $.get("<?= site_url('admin/section/delete/') ?>" + id, function (res) {
		                if (res.status === 'success') {
		                    Swal.fire(
		                        'Deleted!',
		                        'Section has been deleted.',
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
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0"><?= $title ?></h5>
				</div>

				<form method="post" class="needs-validation" action="#" novalidate id="sectionForm" data-id="">
					<div class="card-body">
						<div id="showMsg"></div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Class <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select class="form-select" name="class_id" id="class_id" required>
									<option value="">Select Class</option>
									<?php if( isset($class_lists) && !empty($class_lists) ) {
										foreach ($class_lists as $class) {
											echo '<option value="'.$class['id'].'">'.$class['class_name'].'</option>';
										}
									} ?>
								</select>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Teacher <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select class="form-select " name="teacher_id" id="teacher_id" required>
									<option value="">Select Teacher</option>
									<?php if( isset($teacher_lists) && !empty($teacher_lists) ) {
										foreach ($teacher_lists as $teacher) {
											echo '<option value="'.$teacher['id'].'">'.$teacher['first_name'].' '.$teacher['last_name'].'</option>';
										}
									} ?>
								</select>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Section Name <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="section_name" id="section_name" type="text" class="form-control" value="" required autocomplete="off">
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-4">No of Student <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="no_of_student" id="no_of_student" type="text" class="form-control" value="40" required autocomplete="off">
							</div>
						</div>

					</div>

					<div class="card-footer text-end">
						<button id="sectionFormReset" type="button" class="btn btn-light">Reset <i class="ph-paper-plane-tilt ms-2"></i></button>
						<button id="sectionFormSubmit" type="button" class="btn btn-primary">Submit <i class="ph-paper-plane-tilt ms-2"></i></button>
					</div>
				</form>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Section Lists</h5>
				</div>

				<table id="sectionListsTable" class="display">
				    <thead>
				        <tr>
				            <th>ID</th>
				            <th>Section Name</th>
				            <th>Class</th>
				            <th>Teacher</th>
				            <th>No of Student</th>
				            <th>Session</th>
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

