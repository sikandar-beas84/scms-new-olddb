<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('public/admin/assets/js/vendor/forms/validation/validate.min.js') ?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
		// Datatable ajax call
	    var table = $('#classLists').DataTable({
	        ajax: {
	         	url: "<?= base_url('admin/manage-class/fetch') ?>",
	         	dataSrc: 'class',
		        type: 'POST',
		        dataType: 'json',
	        },
	        columns: [
	            { data: 'id' },
	            { data: 'class_name' },
	            { data: 'id_range' },
	            { data: 'age' },
	            {
	                data: null,
	                render: function(data, type, row) {
	                    return `
	                        <span class="editBtn" data-id="${row.id}" title="Edit"><i class="ph-note-pencil"></i></span>
	                    `;
	                }
	            }
	        ],
	        columnDefs: [
	            { targets: 0, visible: false, searchable: false, orderable: true }
	        ],
	        order: [[0, 'desc']],
	    });	

	    $('#classLists tbody').on('click', '.editBtn', function(e) {
	        e.preventDefault();
	        const id = $(this).data('id');

	        $(".editClassDiv").hide()
	        $("#showMsg").html("")

	        $.ajax({
	            url: "<?= base_url('admin/manage-class/get-class') ?>",
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
	            	$(".editClassDiv").show()
	            	
	            	setTimeout(function() {
					    $("body .ph-arrow-up").trigger("click");
					}, 10);


	                $('#class_name').val(res.class.class_name);
	                $('#id_range').val(res.class.id_range);
	                $('#age').val(res.class.age);
	                $('#editClassForm').attr('data-id', id);
	            } else {
	            	let getMessage = '<div class="alert alert-primary border-0 alert-dismissible fade show">Session not found<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'
	            	$("#showMsg").html("letgetMessage")
	            }
	        })
	        .fail(function(xhr, status, err) {
	            console.error('AJAX failed', status, err, xhr.responseText);
	            console.log('Failed to fetch session. See console for details.');
	        });
	    });

	    // Initialize jQuery Validation
	    $("#editClassForm").validate({
	        rules: {
	            class_name: {
	                required: true
	            },
	            id_range: {
	                required: true,
	                digits: true   // ✅ only allows integers
	            },
	            age: {
	                required: true,
	                digits: true
	            }
	        },
	        messages: {
	            class_name: {
		            required: "Please enter class name"
		        },
		        id_range: {
		            required: "Please enter ID range",
		            digits: "Please enter a valid integer"
		        },
		        age: {
		            required: "Please enter age",
		            digits: "Please enter a valid integer"
		        }
	        },
	        submitHandler: function (form) {
	            // This runs only if form is valid
	            let id = $("#editClassForm").attr("data-id") || "";
	            $("#showMsg").html("")

	            $.ajax({
	                url: "<?= base_url('admin/manage-class/save-class') ?>",
	                type: "POST",
	                data: {
	                    id: id,
	                    class_name: $("#class_name").val(),
	                    id_range: $("#id_range").val(),
	                    age: $("#age").val(),
	                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
	                },
	                dataType: "json",
	                success: function (res) {
	                    if (res.status === "success") {
	                        let msgHtml = '<div class="alert alert-primary border-0 alert-dismissible fade show">'+res.message+'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'
	                        $("#showMsg").html(msgHtml)

	                        $("#editClassForm")[0].reset();
	                        $("#editClassForm").removeAttr("data-id");
	                        $(".editClassDiv").hide()
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
	    $(document).on("click", "#editClassFormSubmit", function () {
	        $("#editClassForm").submit();
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
	<!-- Edit area -->
	<div class="row editClassRowDiv" >
		<div class="col-lg-12 editClassDiv" style="display: none;">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Edit Class</h5>
				</div>

				<form method="post" class="needs-validation" action="#" novalidate id="editClassForm" data-id="">
					<div class="card-body">
						
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Name <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="class_name" id="class_name" type="text" class="form-control" required placeholder="Class Name (STD-XII-Science-BIO)">
								<div class="invalid-feedback">Invalid Class Name</div>
								<div class="valid-feedback">Valid Class Name</div>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">ID Range <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="id_range" id="id_range" type="number" class="form-control" required placeholder="ID Range (201)">
								<div class="invalid-feedback">Invalid ID Range Name</div>
								<div class="valid-feedback">Valid ID Range Name</div>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Age <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="age" id="age" type="number" class="form-control" required placeholder="Age (8)">
								<div class="invalid-feedback">Invalid Age</div>
								<div class="valid-feedback">Valid Age</div>
							</div>
						</div>

					</div>

					<div class="card-footer text-end">
						<button id="editClassFormSubmit" type="button" class="btn btn-primary">Update <i class="ph-paper-plane-tilt ms-2"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /Edit area -->

	<!-- Page length options -->
	<div class="card">
		<div class="card-header">
			<h5 class="mb-0">All <?= $title ?></h5>
		</div>
		
		<div id="showMsg"></div>

		<div class="card-body">
			<table id="classLists" class="hover">
			    <thead>
			        <tr>
			            <th>ID</th>
			            <th>Class Name</th>
			            <th>ID Range</th>
			            <th>Age Limit</th>
			            <th>Action</th>
			        </tr>
			    </thead>
			</table>
		</div>
	</div>
	<!-- /page length options -->
</div>
<!-- /content area -->

