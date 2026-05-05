<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>

<!-- DataTables Buttons JS + dependencies -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>


<!-- Data table -->
<script>
	$(document).ready(function() {
		var table = $('#tablePassFailReport').DataTable({
	    	pageLength: 25, // 👈 default number of rows per page
				lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	        responsive: true,
			dom:
			    "<'d-flex justify-content-between mb-2'<'left-col' B l><'right-col' f>>" +
			    "t" +
			    "<'d-flex justify-content-between mt-2'<'info'i><'pagination'p>>",
		    buttons: [
		        {
		            extend: 'excelHtml5',
		            text: '<i class="fa fa-file-excel-o"></i> Excel',
		            className: 'btn btn-success btn-sm',
		            titleAttr: 'Export to Excel',
		            exportOptions: {
		                columns: ':visible'
		            }
		        },
		        {
		            extend: 'csvHtml5',
		            text: '<i class="fa fa-file-text-o"></i> CSV',
		            className: 'btn btn-info btn-sm',
		            titleAttr: 'Export to CSV',
		            exportOptions: {
		                columns: ':visible'
		            }
		        },
		        {
		            extend: 'pdfHtml5',
		            text: '<i class="fa fa-file-pdf-o"></i> PDF',
		            className: 'btn btn-danger btn-sm',
		            titleAttr: 'Export to PDF',
		            orientation: 'landscape',
		            pageSize: 'A4',
		            exportOptions: {
		                columns: ':visible'
		            }
		        },
		        {
		            extend: 'print',
		            text: '<i class="fa fa-print"></i> Print',
		            className: 'btn btn-primary btn-sm',
		            titleAttr: 'Print Table',
		            exportOptions: {
		                columns: ':visible'
		            }
		        }
		    ],
	        ajax: {
	         	url: "<?= base_url('admin/report/ajax-pass-fail-report') ?>",
	         	dataSrc: function(json) {
	         		console.log(json)
	        		class_list = json.class_list || [];
			        return json.student_list || json;
			    },
		        type: 'POST',
		        dataType: 'json',
		        data: function (d) {
		            d.class_id = $('#class_id').val();
		            d.ad_exam_qualified = $('#ad_exam_qualified').val();
		        },
	        },
	        columns: [
				{ data: 'id', defaultContent: '' },
				{
		            data: null,
		            title: "SL No.",
		            render: function (data, type, row, meta) {
		                return meta.row + 1 + meta.settings._iDisplayStart; // auto serial number
		            }
		        },
		        // { data: 'code', defaultContent: '' },
		        { data: 'first_name', defaultContent: '' },
		        { data: 'class_name', defaultContent: '' },
		        { data: 'shift', defaultContent: '' },
				// { data: 'section_name', defaultContent: '' },
				// { data: 'roll_num', defaultContent: '' },
				{ data: 'father_name', defaultContent: '' }, // Father's name
				{ data: 'mother_name', defaultContent: '' }, // Mother's name
				{ data: 'd_o_b', defaultContent: '' },
				{ data: 'father_mobile', defaultContent: '' }, // Father's Contact no
				{ data: 'mother_mobile', defaultContent: '' }, // Mother's Contact no
				{ data: 'second_language', defaultContent: '' }, // 2nd language
				// { data: 'permanent_address', defaultContent: '' }, // Address
				{ data: 'pincode', defaultContent: '' }, // Pin code
				{ data: 'gender', defaultContent: '' },
				// { data: 'admission_date', defaultContent: '' },
			],
	        columnDefs: [
	            { targets: 0, visible: false, searchable: false, orderable: true }
	        ],
	        order: [[1, 'desc']],
	        scrollX: true,
	        serverSide: false,  // 👈 this is key
		    processing: true,
	    });

		// Reset search form
	    $('#formPassFailReset').on('click', function () {
		    $('#class_id').val('');
		    $('#ad_exam_qualified').val('');

		    table.ajax.reload();
		});

	    // Submit search form
		$('#formPassFailSearch').on('click', function (e) {
		    let class_id = $('#class_id').val();
		    let ad_exam_qualified = $('#ad_exam_qualified').val();

		    if (class_id === "" || class_id === null) {
		        Swal.fire({
		            icon: "error",
		            title: "Required Field Missing",
		            text: "Please Select Class!",
		        });
		        return false; // 🔥 Stop DataTable reload
		    }

		    if (ad_exam_qualified === "" || ad_exam_qualified === null) {
		        Swal.fire({
		            icon: "error",
		            title: "Required Field Missing",
		            text: "Please Select Status!",
		        });
		        return false; // 🔥 Stop DataTable reload
		    }

		    // If validation passed
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
				<div class="col-lg-2">
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
               
                <div class="col-lg-2">
					<div class="mb-3">
                        <select class="form-select" name="ad_exam_qualified" id="ad_exam_qualified">
							<option value="">Select Exam Qualified Status</option>
							<option value="1">Pass</option>
							<option value="0">Fail</option>
							<option value="2">Not Appeared</option>
						</select>
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="mb-3">
                    	<button type="button" id="formPassFailReset" class="btn btn-btn btn-danger">Reset <i class="ph ph-arrows-clockwise ms-2"></i></button>
                    	<button type="button" id="formPassFailSearch" class="btn btn-primary ms-3">Go <i class="ph-paper-plane-tilt ms-2"></i></button>
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
			<table id="tablePassFailReport" class="display responsive">
		        <thead>
		            <tr>
						<th>ID</th>
						<th>SL No.</th>
						<!-- <th>Student code</th> -->
						<th>Student Name</th>
						<th>Class</th>
						<th>Shift</th>
						<!-- <th>Section</th>
						<th>Roll No</th> -->
						<th>Father's name</th>
						<th>Mother's name</th>
						<th>DOB</th>
						<th>Father's Contact no</th>
						<th>Mother's Contact no</th>
						<th>2nd language</th>
						<!-- <th>Address</th> -->
						<th>Pin code</th>
						<th>Gender</th>
						<!-- <th>Admission date</th> -->
		            </tr>
		        </thead>
		    </table>
		</div>
	</div>
	<!-- /page length options -->
</div>
<!-- /content area -->
