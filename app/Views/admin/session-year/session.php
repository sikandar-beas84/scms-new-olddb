<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

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
	    var table = $('#sessionYear').DataTable({
	        ajax: {
	         	url: "<?= base_url('admin/session/fetch') ?>",
	         	dataSrc: 'session_year',
		        type: 'POST',
		        dataType: 'json',
	        },
	        columns: [
	            { data: 'id' },
	            { data: 'session_name' },
	            { data: 'start_date' },
	            { data: 'end_date' },
	            {
		            data: 'is_current',
		            render: function(data, type, row) {
		                let checked = (data === 't' || data === true || data === 1 || data === '1' || data === 'true') ? 'checked' : '';
		                return `
		                <div class="form-check-horizontal">
							<label class="form-check form-switch mb-0">
								<input type="checkbox" class="current-session form-check-input" data-id="${row.id}" ${checked} ${checked ? 'disabled' : ''}/>
							</label>
						</div>

		                    
		                `;
	            	},
	        	},
	            {
	                data: null,
	                render: function(data, type, row) {
	                    // return `
	                    //     <button class="updateBtn" data-id="${row.id}">Update</button>
	                    //     <button class="deleteBtn" data-id="${row.id}">Delete</button>
	                    // `;
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

		$(document).on('change', '.current-session', function(){
		    let checkbox = $(this);
		    let id = checkbox.data('id');
		    let isChecked = checkbox.prop('checked');

		    if (isChecked) {
		        $.ajax({
		            url: "<?= base_url('admin/session/set-current') ?>",
		            type: "POST",
		            data: {
		                id: id,
		                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
		            },
		            success: function(res) {
		                // Reload DataTable to update toggles
		                table.ajax.reload(null, false);
		            },
		            error: function() {
		                console.log("Failed to update session");
		                checkbox.prop('checked', false)
		            }
		        });
		    } else {
		        // Prevent turning OFF manually
		       checkbox.prop('checked', true)
		    }
		});	
	    
		// Delegated event on tbody — reliable and efficient
	    $('#sessionYear tbody').on('click', '.editBtn', function(e) {
	        e.preventDefault();
	        const id = $(this).data('id');

	        $.ajax({
	            url: "<?= base_url('admin/session/get-session') ?>",
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
	                $('#session_name').val(res.session_year.session_name);
	                $('#start_date').val(res.session_year.start_date);
	                $('#end_date').val(res.session_year.end_date);
	                $('#sessionForm').attr('data-id', id);
	                $("#sessionFormSubmit").html('Update <i class="ph-paper-plane-tilt ms-2"></i>')
	                // Optional: scroll to form or open modal
	                // $('html, body').animate({ scrollTop: $('#sessionForm').offset().top - 80 }, 300);

	                initDatePickers()
	            } else {
	                console.log(res.message || 'Session not found');
	                $("#sessionFormSubmit").html('Submit <i class="ph-paper-plane-tilt ms-2"></i>')
	            }
	        })
	        .fail(function(xhr, status, err) {
	            console.error('AJAX failed', status, err, xhr.responseText);
	            console.log('Failed to fetch session. See console for details.');
	            $("#sessionFormSubmit").html('Submit <i class="ph-paper-plane-tilt ms-2"></i>')
	        });
	    });

	    // Initialize jQuery Validation
	    $("#sessionForm").validate({
	        rules: {
	            session_name: {
	                required: true
	            },
	            start_date: {
	                required: true,
	                dateISO: true // Enforces YYYY-MM-DD format
	            },
	            end_date: {
	                required: true,
	                dateISO: true
	            }
	        },
	        messages: {
	            session_name: "Please enter a session name.",
	            start_date: "Please enter a valid start date (YYYY-MM-DD).",
	            end_date: "Please enter a valid end date (YYYY-MM-DD)."
	        },
	        submitHandler: function (form) {
	            // This runs only if form is valid
	            let id = $("#sessionForm").attr("data-id") || "";
	            $("#showMsg").html("")

	            $.ajax({
	                url: "<?= base_url('admin/session/save') ?>",
	                type: "POST",
	                data: {
	                    id: id,
	                    session_name: $("#session_name").val(),
	                    start_date: $("#start_date").val(),
	                    end_date: $("#end_date").val(),
	                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
	                },
	                dataType: "json",
	                success: function (res) {
	                    if (res.status === "success") {
	                        let msgHtml = '<div class="alert alert-primary border-0 alert-dismissible fade show">'+res.message+'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'
	                        $("#showMsg").html(msgHtml)

	                        $("#sessionForm")[0].reset();
	                        $("#sessionForm").removeAttr("data-id");
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
	    $(document).on("click", "#sessionFormSubmit", function () {
	        $("#sessionForm").submit();
	    });

	    $(document).on("click", "#sessionFormReset", function () {
	        $("#sessionForm")[0].reset();
			$("#sessionForm").removeAttr("data-id");
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

				<form method="post" class="needs-validation" action="#" novalidate id="sessionForm" data-id="">
					<div class="card-body">
						<div id="showMsg"></div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Session Name <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="session_name" id="session_name" type="text" class="form-control" required placeholder="Session Name (2025-2026)">
								<div class="invalid-feedback">Invalid Session Name</div>
								<div class="valid-feedback">Valid Session Name</div>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Session Start Date <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="start_date" id="start_date" type="text" class="form-control datepicker-basic datepicker-input" value="" required autocomplete="off">
								<div class="invalid-feedback">Invalid Session Start Date</div>
								<div class="valid-feedback">Valid Session Start Date</div>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Session End Date <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="end_date" id="end_date" type="text" class="form-control datepicker-basic datepicker-input" value="" required autocomplete="off">
								<div class="invalid-feedback">Invalid Session End Date</div>
								<div class="valid-feedback">Valid Session End Date</div>
							</div>
						</div>

					</div>

					<div class="card-footer text-end">
						<button id="sessionFormReset" type="button" class="btn btn-light">Reset <i class="ph-paper-plane-tilt ms-2"></i></button>
						<button id="sessionFormSubmit" type="button" class="btn btn-primary">Submit <i class="ph-paper-plane-tilt ms-2"></i></button>
					</div>
				</form>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Session Year List</h5>
				</div>

				<table id="sessionYear" class="display">
				    <thead>
				        <tr>
				            <th>ID</th>
				            <th>Name</th>
				            <th>Start Date</th>
				            <th>End Date</th>
				            <th>Current</th>
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

