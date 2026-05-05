<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
	$(document).ready(function() {
		var  base_url = "<?= base_url(); ?>";
	    var table = $('#studentLists').DataTable({
	    	pageLength: 25, // 👈 default number of rows per page
				lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	        responsive: true,
	        ajax: {
	         	url: "<?= base_url('admin/student/ajax_request_ent_exam_eli_student_list') ?>",
	         	// dataSrc: 'student_list',
	         	dataSrc: function(json) {
			        console.log(json); // 👈 check actual response
			        // save class_list in a global variable
	        		class_list = json.class_list || [];

	        		// ✅ Count total students and set to input
		            let totalStudents = 0;
		            if (json.student_list && Array.isArray(json.student_list)) {
		                totalStudents = json.student_list.length;
		            } else if (Array.isArray(json)) {
		                totalStudents = json.length;
		            }

		            // Set value inside input
		            $('#totalStudent').val(totalStudents);

			        return json.student_list || json; // if "student_list" key exists, return it, else raw
			    },
		        type: 'POST',
		        dataType: 'json',
		        data: function (d) {
		            d.class_id = $('#class_id').val(); 
		            d.student_form_no = $('#student_form_no').val(); 
		            d.is_admission_done = $('#is_admission_done').val(); 
		            console.log(d.class_id)
		            // you can send more values like:
		            // d.session_year_id = $('#session_year_id').val();
		        },
	        },
	        columns: [
				{ data: 'student_id', defaultContent: '' },
				{ data: 'form_no', defaultContent: '' },
				{ data: 'code', defaultContent: '' },
				{ data: 'first_name', defaultContent: '' },
				// { data: '', defaultContent: '' },
				{
				    data: 'image', // 👈 replace with your actual image field name
				    defaultContent: '',
				    render: function (data, type, row) {
				        if (!data) {
				            // Show placeholder if image not found
				            return '';
				        }
				        // Show actual image
				        return '<img src="' + base_url + 'uploads/' + data + '" alt="Student Image" width="50" height="50" class="rounded">';
				    }
				},
				{ data: 'class_name', defaultContent: '' },
				{ data: 'd_o_b', defaultContent: '' },
				{ data: 'father_name', defaultContent: '' },
				{ data: 'mother_name', defaultContent: '' },
				// { data: 'admission', defaultContent: '' },
				{
			        data: 'admission',
			        defaultContent: '',
			        render: function(data, type, row) {
			            if (data == 1) {
			                return `<span class="badge bg-success">Admission Done</span>`;
			            } else {
			                return `<a href="${base_url}admin/student/collect-admission-fee/${row.id}" 
			                           class="btn btn-sm btn-primary">
			                           <i class="white ace-icon fa fa-credit-card "></i> Collect Admission Fee
			                        </a>`;
			            }
			        }
			    },
				// { data: '', defaultContent: '' },
				{
			        data: null,
			        defaultContent: '',
			        render: function(data, type, row) {
			            return `<a href="${base_url}admin/student/edit/${row.student_id}" 
			                       class="btn btn-sm btn-warning">
			                       <i class="fa fa-edit"></i> Edit
			                    </a>`;
			        }
			    }
			],
	        columnDefs: [
	            { targets: 0, visible: false, searchable: false, orderable: true }
	        ],
	        order: [[0, 'desc']],
	        scrollX: true,
	        serverSide: false,  // 👈 this is key
		    processing: true,
	    });

	    $('#studentListSearch').on('click', function(e) {
    	 	e.preventDefault();

		    let classId = $('#class_id').val();

		    // ❌ No class selected
		    if (classId === '') {
		        Swal.fire({
		            icon: 'warning',
		            title: 'Class Required',
		            text: 'Please select a class or choose "All Class" to continue.',
		            confirmButtonText: 'OK'
		        });
		        return false; // ⛔ stop ajax reload
		    }

	    	table.ajax.reload();
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
			</div>

			<a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
				<i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
			</a>
		</div>		
	</div>
</div>
<!-- /page header -->

<div class="content">
	<div class="card">
		<div class="card-header">
			<h5 class="mb-0">Search</h5>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-lg-3">
					<div class="mb-3">
                        <select class="form-select" name="class_id" id="class_id">
							<option value="">Select Class</option>
							<option value="all">All Class</option>

							<?php if(!empty($class_list)){
								foreach($class_list as $class){ ?>
									<option value="<?php echo $class['id']; ?>"><?php echo $class['class_name']; ?></option>
								<?php }
							} ?>
						</select>

                    </div>

                </div>
                <div class="col-lg-3">
                    <div class="mb-3">
                    	<input type="text" class="form-control" name="student_form_no" id="student_form_no" placeholder="Student Form No: SCMS" />
                    </div>
				</div>

				<div class="col-lg-3">
                    <div class="mb-3">
                    	<select class="form-select" name="is_admission_done" id="is_admission_done">
							<option value="">Select Admission Fee Type</option>
							<option value="0">Collect Admission Fee</option>
							<option value="1">Admission Done</option>
						</select>
                    </div>
				</div>

                <div class="col-lg-3">
                    <div class="mb-3">
                    	<button type="button" id="studentListSearch" class="btn btn-primary ms-3">Go <i class="ph-paper-plane-tilt ms-2"></i></button>
                    </div>
				</div>

			</div>

		</div>
	</div>
</div>


<!-- Content area -->
<div class="content">

	<!-- Page length options -->
	<div class="card">
		<div class="card-header">
			<h5 class="mb-0">All <?= $title ?></h5>
		</div>
		
		<div id="showMsg"></div>

		<div class="card-body">
			<table id="studentLists" class="display responsive">
		        <thead>
		            <tr>
						<th>Sl No</th>
						<th>Form No </th>
						<th>Student Code</th>
						<th>Student Name</th>
						<th>Image</th>
						<th>Class </th>							
						<th>Date Of Birth</th>
						<th>Father Name</th>
						<th>Mother Name</th>
						<th>Admission fee</th>
						<th>Option</th>
		            </tr>
		        </thead>
		    </table>
		</div>
	</div>
	<!-- /page length options -->
</div>
<!-- /content area -->