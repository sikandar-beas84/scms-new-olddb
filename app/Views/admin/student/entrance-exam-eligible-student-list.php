<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>

<!-- DataTables Buttons JS + dependencies -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>
	.dt-buttons .btn {
	    padding: 4px 10px !important;
	    border-radius: 4px !important;
	    margin-right: 5px !important;
	    font-size: 14px !important;
	}

	.tooltip-wrapper {
		position: relative;
		display: inline-block;
		cursor: pointer;
	}

	.tooltip-wrapper .tooltip-content {
		display: none;
		position: absolute;
		left: 0;
		top: 100%;
		z-index: 999;
		background: #fff;
		color: #000;
		padding: 8px;
		border: 1px solid #ccc;
		width: max-content;
		min-width: 200px;
		box-shadow: 0 2px 6px rgba(0,0,0,0.2);
	}

	.tooltip-wrapper:hover .tooltip-content {
		display: block;
	}

</style>

<script>
	$(document).ready(function() {
	    var table = $('#studentLists').DataTable({
	    	pageLength: 25, // 👈 default number of rows per page
  			lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	        responsive: true,
		    // dom: 'Bfrtip', // 👈 enables export buttons
	     	dom:
		        "<'d-flex justify-content-between mb-2'<'left-col'B><'right-col'f>>" +
		        "t" +
		        "<'d-flex justify-content-between mt-2'<'info'i><'pagination'p>>",
		    buttons: [
		        {
		            extend: 'excelHtml5',
		            text: '<i class="fa fa-file-excel-o"></i> Excel',
		            className: 'btn btn-success btn-sm',
		            titleAttr: 'Export to Excel',
		            exportOptions: {
		                columns: ':visible',
            			footer: true
		            }
		        },
		        {
		            extend: 'csvHtml5',
		            text: '<i class="fa fa-file-text-o"></i> CSV',
		            className: 'btn btn-info btn-sm',
		            titleAttr: 'Export to CSV',
		            exportOptions: {
		                columns: ':visible',
            			footer: true
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
		                columns: ':visible',
            			footer: true
		            }
		        },
		        {
		            extend: 'print',
		            text: '<i class="fa fa-print"></i> Print',
		            className: 'btn btn-primary btn-sm',
		            titleAttr: 'Print Table',
		            exportOptions: {
		                columns: ':visible',
            			footer: true
		            }
		        }
		    ],
	        ajax: {
	         	url: "<?= base_url('admin/student/ajax_request_eligible_exam_student_list') ?>",
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
		            d.class_id = $('#class_id').val(); // get class_id from dropdown or input
		            console.log(d.class_id)
		            // you can send more values like:
		            // d.session_year_id = $('#session_year_id').val();
		        },
	        },
	        columns: [
				{ data: 'id', defaultContent: '' },
				{
			        data: null,      // important → no data from DB
			        render: function (data, type, row, meta) {
			            return meta.row + 1;   // SL NO.
			        }
			    },
				{ data: 'form_no', defaultContent: '' },
				{ data: 'first_name', defaultContent: '' },
				{ data: 'class_name', defaultContent: '' },
				{ data: 'second_language', defaultContent: '' },
				{ data: 'father_name', defaultContent: '' },
				{ data: 'mother_name', defaultContent: '' },
				{ data: 'd_o_b', defaultContent: '' },
			],
	        columnDefs: [
	            { targets: 0, visible: false, searchable: false, orderable: true }
	        ],
	        order: [[1, 'desc']],
	        scrollX: true,
	        serverSide: false,  // 👈 this is key
		    processing: true,
	    });

	    $('#studentListSearch').on('click', function(e) {
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
			<table id="studentLists" class="display  table table-striped">
		        <thead>
		            <tr>
						<th> ID </th>
						<th> SL No </th>
						<th>Form No</th>
						<th>Student Name</th>
						<th>Class</th>
						<th>2<sup>nd</sup> Language</th>
						<th>Father Name </th>
						<th>Mother Name </th>
						<th>DOB </th>
		            </tr>
		        </thead>
		    </table>
		</div>
	</div>
	<!-- /page length options -->
</div>
<!-- /content area -->

<!-- all_users -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Collect Registration Fees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs" id="modalTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">
                            Cash
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab" aria-controls="specs" aria-selected="false">
                            Cheque
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">
                            POS
                        </button>
                    </li>
                </ul>
                
                <!-- Tab Content -->
                <div class="tab-content modal-tab-content" id="modalTabsContent">
                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                        <h4></h4>
                        <form class="form-horizontal" role="form" id="cpay" autocomplete="off">
							<p class="cpay_msg"></p>
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> Cash Amount </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control" name="payment_amount" placeholder="Cash Amount" value="<?= $admission_reg_fee?>" readonly />
								</div>
							</div>
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> Payee Name </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control payee_name" name="payee_name" value="" placeholder="Payee Name" readonly />
								</div>
							</div>
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> Form No </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control form_no" value="" disabled />
								</div>
							</div>
							<input type="hidden" class="form_no" name="form_no" value=""/>
							<input type="hidden" class="payment_type" name="payment_type" value="cash"/>
							<input type="hidden" class="t_user_id" name="t_user_id" value="<?= $user_id ?>"/>
							<input type="hidden" class="added_by" name="added_by" value="<?= $f_name ?>"/>
							<p></p>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="button" class="btn btn-primary" id="sub_cpay">Save</button>
								</div>
							</div>
						</form>
                    </div>
                    <div class="tab-pane fade" id="specs" role="tabpanel" aria-labelledby="specs-tab">
                        <h4></h4>
                        <form class="form-horizontal" role="form" id="chqpay" autocomplete="off">
							<p class="chqpay_msg"></p>
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> Cash Amount </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control" name="payment_amount" placeholder="Cash Amount" value="<?= $admission_reg_fee?>" readonly/>
								</div>
							</div>
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> Payee Name </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control payee_name" name="payee_name" value="" placeholder="Payee Name" readonly />
								</div>
							</div>													
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> Cheque No. </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control" name="cheque_number" placeholder="Cheque No"/>
								</div>
							</div>
							<input type="hidden" class="form_no" name="form_no" value=""/>
							<input type="hidden" class="payment_type" name="payment_type" value="cheque"/>
							<input type="hidden" class="t_user_id" name="t_user_id" value="<?= $user_id ?>"/>
							<input type="hidden" class="added_by" name="added_by" value="<?= $f_name ?>"/>
							<p></p>
							<button type="button" class="btn btn-primary" id="sub_chqpay">Save</button>
						</form>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <h4></h4>
                        <form class="form-horizontal" role="form" id="pospay" autocomplete="off">
							<p class="pospay_msg"></p>
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> POS Bank Name </label>
								<div class="col-sm-9 mb-2 mb-2">
									<select class="form-select" name="pos_bank_name">										
										<option value="AXIS">AXIS</option>
										<option value="BOB">BOB</option>
										<option value="SBI">SBI</option>
										<option value="HDFC">HDFC</option>
									</select>																		
								</div>
							</div>
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> POS Amount </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control" name="payment_amount" placeholder="Cash Amount" value="<?= $admission_reg_fee?>" readonly/>
								</div>
							</div>													
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> Reference Number </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control" name="pos_reference_number" placeholder="POS Referance Number"/>
								</div>
							</div>
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> Payee Name </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control payee_name" name="payee_name"  value="" placeholder="Payee Name" readonly />
								</div>
							</div>
							<input type="hidden" class="form_no" name="form_no" value=""/>
							<input type="hidden" class="payment_type" name="payment_type" value="pos"/>
							<input type="hidden" class="t_user_id" name="t_user_id" value="<?= $user_id ?>"/>
							<input type="hidden" class="added_by" name="added_by" value="<?= $f_name ?>"/>
							<p></p>
							<button type="button" class="btn btn-primary" id="sub_pospay">Save</button>
						</form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
