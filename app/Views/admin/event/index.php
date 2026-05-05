<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="<?= base_url('public/admin/assets/js/vendor/forms/validation/validate.min.js') ?>"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
	    var table = $('#events').DataTable({
	    	pageLength: 10,
		    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
		    responsive: true,
	        ajax: {
	         	url: "<?= base_url('admin/events/fetch') ?>",
	         	dataSrc: 'events',
		        type: 'POST',
		        dataType: 'json',
	        },
	        columns: [
	            { data: 'id' },
	            { data: 'event_no' },
	            { data: 'event_name' },
	            { data: 'event_description' },
	            { data: 'event_date' },
	            { data: 'event_fee' },
	            {
		            data: 'status',
		            render: function(data, type, row) {
		                let checked = (data === 't' || data === true || data === 1 || data === '1' || data === 'true') ? 'checked' : '';
		                return `
		                <div class="form-check-horizontal" style="cursor: pointer;">
							<label class="form-check form-switch mb-0">
								<input type="checkbox" class="events-status form-check-input" data-id="${row.id}" ${checked} ${checked ? '' : ''}/>
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
	        order: [[0, 'desc']]
	    });

		// Initialize jQuery Validation
	    $("#eventForm").validate({
	        rules: {
			    event_no: {
			        required: true
			    },
			    event_name: {
			        required: true
			    },
			    event_description: {
			        required: true
			    },
			    event_date: {
			        required: true,
			        dateISO: true // format: YYYY-MM-DD
			    },
			    event_fee: {
			        required: true,
			        number: true
			    },
			    status: {
			        required: true
			    }
			},
	        messages: {
			    event_no: "Please enter event number.",
			    event_name: "Please enter event name.",
			    event_description: "Please enter description.",
			    event_date: "Please enter a valid event date (YYYY-MM-DD).",
			    event_fee: {
			        required: "Please enter event fee.",
			        number: "Only numeric value allowed."
			    },
			    status: "Please select status."
			},
	        submitHandler: function (form) {
	            // This runs only if form is valid
	            let id = $("#eventForm").attr("data-id") || "";
	            $("#showMsg").html("")

	            $.ajax({
	                url: "<?= base_url('admin/events/save') ?>",
	                type: "POST",
	                data: {
	                    id: id,
	                    event_no: $("#event_no").val(),
					    event_name: $("#event_name").val(),
					    event_description: $("#event_description").val(),
					    event_date: $("#event_date").val(),
					    event_fee: $("#event_fee").val(),
					    status: $("#status").val(),
	                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
	                },
	                dataType: "json",
	                success: function (res) {
	                    if (res.status === "success") {
	                        let msgHtml = '<div class="alert alert-primary border-0 alert-dismissible fade show">'+res.message+'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'
	                        $("#showMsg").html(msgHtml)

	                        $("#eventForm")[0].reset();
	                        $("#eventForm").removeAttr("data-id");
	                        $("#eventFormSubmit").html('Submit <i class="ph-paper-plane-tilt ms-2"></i>')

	                        table.ajax.reload(null, false); // reload datatable
	                    } else {
	                        let msgHtml = '<div class="alert alert-primary border-0 alert-dismissible fade show">'+res.message+'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'
	                        $("#showMsg").html(msgHtml)
	                    }
	                }
	            });
	        }
	    });

	    // Delegated event on tbody — reliable and efficient
	    $('#events tbody').on('click', '.editBtn', function(e) {
	        e.preventDefault();
	        const id = $(this).data('id');

	        $.ajax({
	            url: "<?= base_url('admin/events/get-event') ?>",
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
	                $('#event_no').val(res.event_details.event_no);
	                $('#event_name').val(res.event_details.event_name);
	                $('#event_description').val(res.event_details.event_description);
	                $('#event_date').val(res.event_details.event_date);
	                $('#event_fee').val(res.event_details.event_fee);
	                $('#status').val(res.event_details.status);


	                $('#eventForm').attr('data-id', id);
	                $("#eventFormSubmit").html('Update <i class="ph-paper-plane-tilt ms-2"></i>')

	                initDatePickers()
	            } else {
	                console.log(res.message || 'Session not found');
	                $("#eventFormSubmit").html('Submit <i class="ph-paper-plane-tilt ms-2"></i>')
	            }
	        })
	        .fail(function(xhr, status, err) {
	            console.error('AJAX failed', status, err, xhr.responseText);
	            console.log('Failed to fetch session. See console for details.');
	            $("#eventFormSubmit").html('Submit <i class="ph-paper-plane-tilt ms-2"></i>')
	        });
	    });

	    // Trigger validation + AJAX on button click
	    $(document).on("click", "#eventFormSubmit", function () {
	        $("#eventForm").submit();
	    });

	    $(document).on("click", "#eventFormReset", function () {
	        $("#eventForm")[0].reset();
			$("#eventForm").removeAttr("data-id");
	    });

	    $(document).on('change', '.events-status', function(){
		    let checkbox = $(this);
		    let id = checkbox.data('id');
		    let isChecked = checkbox.prop('checked');

	        $.ajax({
	            url: "<?= base_url('admin/events/update-status') ?>",
	            type: "POST",
	            data: {
	                id: id,
	                isChecked: isChecked,
	                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
	            },
	            success: function(res) {
	            	if( res.status == "success" ) {
	            		Swal.fire({
						    icon: 'success',
						    title: '',
						    text: res.message,
						    confirmButtonText: 'OK'
						});
	            	} else if( res.status == "error" ) {
	            		Swal.fire({
						    icon: 'warning',
						    title: '',
						    text: res.message,
						    confirmButtonText: 'OK'
						});
	            	}

	                // Reload DataTable to update toggles
	                table.ajax.reload(null, false);
	            },
	            error: function() {
	                console.log("Failed to update status");
	                checkbox.prop('checked', !isChecked);
	            }
	        });
		});	

		// Delete
		$('#events').on('click', '.deleteBtn', function () {

		    var id = $(this).data('id');

		    Swal.fire({
		        title: 'Are you sure?',
		        text: 'This event will be permanently deleted!',
		        icon: 'warning',
		        showCancelButton: true,
		        confirmButtonColor: '#d33',
		        cancelButtonColor: '#3085d6',
		        confirmButtonText: 'Yes, delete it!',
		        cancelButtonText: 'Cancel'
		    }).then((result) => {
		        if (result.isConfirmed) {
		            $.get("<?= site_url('admin/events/delete/') ?>" + id, function (res) {
		                if (res.status === 'success') {
		                    Swal.fire(
		                        'Deleted!',
		                        'Event has been deleted.',
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

				<form method="post" class="needs-validation" action="#" novalidate id="eventForm" data-id="">
					<div class="card-body">
						<div id="showMsg"></div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Event No. <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="event_no" id="event_no" type="text" class="form-control" required placeholder="Event No">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Event Name <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="event_name" id="event_name" type="text" class="form-control" required placeholder="Event Name">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Description <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<textarea name="event_description" id="event_description" class="form-control" required ></textarea>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Event Date <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="event_date" id="event_date" type="text" class="form-control datepicker-basic datepicker-input" value="" required autocomplete="off">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Event Registration Fee <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="event_fee" id="event_fee" type="text" class="form-control" required placeholder="Event Registration Fee">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Status <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select name="status" id="status" class="form-select" required>
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
							</div>
						</div>

					</div>

					<div class="card-footer text-end">
						<button id="eventFormReset" type="button" class="btn btn-light">Reset <i class="ph-paper-plane-tilt ms-2"></i></button>
						<button id="eventFormSubmit" type="button" class="btn btn-primary">Submit <i class="ph-paper-plane-tilt ms-2"></i></button>
					</div>
				</form>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Event Lists</h5>
				</div>

				<table id="events" class="display">
				    <thead>
				        <tr>
				            <th>ID</th>
				            <th>Event No.</th>
				            <th>Event Name</th>
				            <th>Event Description</th>
				            <th>Event Date</th>
				            <th>Event Registration Fee</th>
				            <th>Event Status</th>
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

