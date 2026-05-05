<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

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
	    var table = $('#examDatesTable').DataTable({
	        ajax: {
	         	url: "<?= base_url('admin/class-wise-exam-date/fetch') ?>",
	         	dataSrc: 'exam_dates',
		        type: 'POST',
		        dataType: 'json',
	        },
	        columns: [
	            { data: 'id' },
	            { data: 'class_name' },
	            { data: 'phase' },
	            { data: 'exam_date' },
	            { data: 'exam_time' },
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
	        pageLength: 25,         // Default records per page
	        lengthMenu: [10, 25, 50, 100], // Dropdown options for records per page
	        order: [[0, 'desc']],   // Default order by ID descending
	        searching: true,        // Enable search box
	        paging: true,           // Enable pagination
	        responsive: true,       // Responsive table
	        info: true,
	    });	
	    
		// Delegated event on tbody — reliable and efficient
	    $('#examDatesTable tbody').on('click', '.editBtn', function(e) {
	        e.preventDefault();
	        const id = $(this).data('id');

	        $.ajax({
	            url: "<?= base_url('admin/class-wise-exam-date/get-exam-date') ?>",
	            type: "POST",
	            data: {
	                id: id,
	                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
	            },
	            dataType: "json"
	        })
	        .done(function(res) {
	            console.log('AJAX response:', res); // <-- debug line

	            if (res.status === 'success') {
	                $('#phase').val(res.exam_date_details.phase).trigger('change');
	                $('#exam_date').val(res.exam_date_details.exam_date);
	                $('#exam_time').val(res.exam_date_details.exam_time);
	                $('#class_id').val(res.exam_date_details.class_id).trigger('change');
	                $('#examDateForm').attr('data-id', id);
	                $("#examDateFormSubmit").html('Update <i class="ph-paper-plane-tilt ms-2"></i>')

	                initDatePickers()
	            } else {
	                console.log(res.message || 'Session not found');
	                $("#examDateFormSubmit").html('Submit <i class="ph-paper-plane-tilt ms-2"></i>')
	            }
	        })
	        .fail(function(xhr, status, err) {
	            console.error('AJAX failed', status, err, xhr.responseText);
	            console.log('Failed to fetch session. See console for details.');
	            $("#examDateFormSubmit").html('Submit <i class="ph-paper-plane-tilt ms-2"></i>')
	        });
	    });

	    // Initialize jQuery Validation
	    $("#examDateForm").validate({
	        rules: {
	            phase: {
	                required: true
	            },
	            exam_date: {
	                required: true,
	                dateISO: true // Enforces YYYY-MM-DD format
	            },
	            exam_time: {
	                required: true
	            },
	            class_id: {
	                required: true
	            }
	        },
	        messages: {
	            phase: "Please select a phase.",
	            exam_date: "Please enter a valid exam date (YYYY-MM-DD).",
	            exam_time: "Please select a exam time",
	            class_id: "Please select a class."
	        },
	        submitHandler: function (form) {
	            // This runs only if form is valid
	            let id = $("#examDateForm").attr("data-id") || "";
	            $("#showMsg").html("")

	            $.ajax({
	                url: "<?= base_url('admin/class-wise-exam-date/save') ?>",
	                type: "POST",
	                data: {
	                    id: id,
	                    phase: $("#phase").val(),
	                    exam_date: $("#exam_date").val(),
	                    exam_time: $("#exam_time").val(),
	                    class_id: $("#class_id").val(),
	                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
	                },
	                dataType: "json",
	                success: function (res) {
	                    if (res.status === "success") {
	                        let msgHtml = '<div class="alert alert-primary border-0 alert-dismissible fade show">'+res.message+'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'
	                        $("#showMsg").html(msgHtml)

	                        $("#examDateForm")[0].reset();
	                        $("#examDateForm").removeAttr("data-id");
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
	    $(document).on("click", "#examDateFormSubmit", function () {
	        $("#examDateForm").submit();
	    });

	    $(document).on("click", "#examDateFormReset", function () {
	        $("#examDateForm")[0].reset();
			$("#examDateForm").removeAttr("data-id");
	    });
	    

	    // Delete
	    $('#examDatesTable tbody').on('click', '.deleteBtn', function(e) {
			e.preventDefault();

	        let examDateId = $(this).data("id");
	        if (!examDateId || isNaN(examDateId)) {
	            Swal.fire("Error", "Invalid data.", "error");
	            return;
	        }

	        Swal.fire({
	            title: "Are you sure?",
	            text: "This data will be permanently deleted!",
	            icon: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#d33",
	            cancelButtonColor: "#3085d6",
	            confirmButtonText: "Yes, delete it!"
	        }).then((result) => {
	            if (result.isConfirmed) {

	                // ✅ CSRF token setup (CodeIgniter 4)
	                let csrfName = "<?= csrf_token() ?>"; 
	                let csrfHash = "<?= csrf_hash() ?>";

	                $.ajax({
	                    url: "<?= site_url('admin/class-wise-exam-date/delete/') ?>/" + examDateId,
	                    type: "DELETE",
	                    data: {
	                        [csrfName]: csrfHash
	                    },
	                    dataType: "json",
	                    success: function (response) {
	                        if (response.status === "success") {
	                            Swal.fire("Deleted!", response.message, "success");

	                            // remove row dynamically if inside a table
	                            $("span[data-id='" + examDateId + "']").closest("tr").fadeOut();
	                            table.ajax.reload(null, false);
	                        } else {
	                            Swal.fire("Error", response.message, "error");
	                        }
	                    },
	                    error: function () {
	                        Swal.fire("Error", "Something went wrong. Please try again.", "error");
	                    }
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
		<div class="col-lg-5">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0"><?= $title ?></h5>
				</div>

				<form method="post" class="needs-validation" action="#" novalidate id="examDateForm" data-id="">
					<div class="card-body">
						<div id="showMsg"></div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Phase <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select class="form-select" name="phase" id="phase" required>
									<option>Select Phase</option>
									<?php
									for ($i=1; $i < 11; $i++) { 
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
									?>
								</select>
								<div class="invalid-feedback">Invalid Phase</div>
								<div class="valid-feedback">Valid Phase</div>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Class List <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select class="form-select" name="class_id" id="class_id" required>
									<option>Select Class</option>
									<?php
									if( isset($class_list) && !empty($class_list) ) {
										foreach ($class_list as $class) {
											echo '<option value="'.$class['id'].'">'.$class['class_name'].'</option>';
										}
									}
									?>
								</select>
								<div class="invalid-feedback">Invalid Class</div>
								<div class="valid-feedback">Valid Class</div>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Exam Date <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="exam_date" id="exam_date" type="text" class="form-control datepicker-basic datepicker-input" value="" required autocomplete="off">
								<div class="invalid-feedback">Invalid Exam Date</div>
								<div class="valid-feedback">Valid Exam Date</div>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Exam Time <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input type="text" id="exam_time" name="exam_time" class="form-control" placeholder="Select time">
							</div>
						</div>

					</div>

					<div class="card-footer text-end">
						<button id="examDateFormReset" type="button" class="btn btn-light">Reset <i class="ph-paper-plane-tilt ms-2"></i></button>
						<button id="examDateFormSubmit" type="button" class="btn btn-primary">Submit <i class="ph-paper-plane-tilt ms-2"></i></button>
					</div>
				</form>
			</div>
		</div>
		<div class="col-lg-7">
			<div class="card">
				<div class="card-header mb-2">
					<h5 class="mb-0">Exam Dates List</h5>
				</div>

				<table id="examDatesTable" class="display">
				    <thead>
				        <tr>
				            <th>ID</th>
				            <th>Class</th>
				            <th>Phase</th>
				            <th>Exam Date</th>
				            <th>Exam Time</th>
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

<script>
	document.getElementById("exam_time").addEventListener("focus", function () {
	    this.type = "time";
	    this.removeAttribute("step"); // remove step (important fix)
	});

	document.getElementById("exam_time").addEventListener("blur", function () {
	    let value = this.value;  // "13:45"

	    if (value) {
	        let [h, m] = value.split(":");
	        let ampm = h >= 12 ? "PM" : "AM";
	        h = (h % 12) || 12;

	        this.type = "text";
	        this.value = `${h}:${m} ${ampm}`; // "1:45 PM"
	    } else {
	        this.type = "text";
	    }
	});
	
</script>