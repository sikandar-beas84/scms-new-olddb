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

<!-- Date range Picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>



<script>
	$(document).ready(function() {
	    var table = $('#formSellingReport').DataTable({
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
		                columns: ':visible',
            			// footer: true
            			format: {
		                    footer: function (data, columnIdx) {
		                        return columnIdx === 4 ? $('#total_amount').html() : data;
		                    }
		                }
		            }
		        },
		        {
		            extend: 'csvHtml5',
		            text: '<i class="fa fa-file-text-o"></i> CSV',
		            className: 'btn btn-info btn-sm',
		            titleAttr: 'Export to CSV',
		            exportOptions: {
		                columns: ':visible',
            			// footer: true
            			format: {
		                    footer: function (data, columnIdx) {
		                        return columnIdx === 4 ? $('#total_amount').html() : data;
		                    }
		                }
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
            			// footer: true
            			format: {
		                    footer: function (data, columnIdx) {
		                        return columnIdx === 4 ? $('#total_amount').html() : data;
		                    }
		                }

			            
		            }
		        },
		        {
		            extend: 'print',
		            text: '<i class="fa fa-print"></i> Print',
		            className: 'btn btn-primary btn-sm',
		            titleAttr: 'Print Table',
		            exportOptions: {
		                columns: ':visible',
            			// footer: true
            			format: {
		                    footer: function(data, columnIdx) {
		                        if (columnIdx === 4) {
		                            return $('#dailyCollectionReport tfoot th:eq(4)').text();
		                        }
		                        return data;
		                    }
		                }
		            }
		        }
		    ],
	        ajax: {
	         	url: "<?= base_url('admin/report/ajax_request_form_selling_report') ?>",
	         	dataSrc: function(json) {
			        // console.log(json); // 👈 check actual response
			        // save class_list in a global variable
            		class_list = json.class_list || [];

			        return json.student_list || json; // if "student_list" key exists, return it, else raw
			    },
		        type: 'POST',
		        dataType: 'json',
		        data: function (d) {
		            d.class_id = $('#class_id').val(); // get class_id from dropdown or input
		            d.payment_mode = $('#payment_mode').val(); // get payment_mode from dropdown or input
		            d.user_id = $('#user_id').val();
		            let dateValue = $('#dateRange').val();
				    if (dateValue && dateValue.includes(' to ')) {
				        let dr = dateValue.split(' to ');
				        d.start_date = dr[0];
				        d.end_date = dr[1];
				    } else {
				        d.start_date = "";
				        d.end_date = "";
				    }
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
				{ 
		            data: 'form_no',
		            render: function (data, type, row, meta) {
		                return `
		                    <input type="text" name="form_no_${meta.row + 1}" value="${row.form_no}" style="display: none;">
		                    ${data}
		                `;
		            }
		        },
				{ data: 'first_name', defaultContent: '' },
				{ data: 'class_name', defaultContent: '' },

				{
		            data: "payment_date",
		            render: function (data) {
		                if (!data) return "";
		                let d = new Date(data);
		                return d.toLocaleDateString() + " " + d.toLocaleTimeString();
		            }
		        },
				{ 
				    data: "payment_type",
				    render: function (data) {
				        if (!data) return "";
				        return data.charAt(0).toUpperCase() + data.slice(1);
				    }
				},
				{ data: 'collected_by_full_name' },
				{ data: 'payment_amount' },
				{ data: 'added_by' },
			],
	        columnDefs: [
	            { targets: 0, visible: false, searchable: false, orderable: true }
	        ],
	        order: [[0, 'desc']],
	        scrollX: true,
	        serverSide: false,  // 👈 this is key
		    processing: true,

		    footerCallback: function (row, data, start, end, display) {
			    let api = this.api();
			    // console.log(data)
			    // Convert to number
			    let intVal = function (i) {
			        return typeof i === "string"
			            ? parseFloat(i.replace(/[^0-9.-]+/g, "")) || 0
			            : typeof i === "number"
			            ? i
			            : 0;
			    };

			    // Total over all pages
			    let total = api
			        .column(8) // payment_amount column index
			        .data()
			        .reduce((a, b) => intVal(a) + intVal(b), 0);

			    // Total over THIS page only
			    let pageTotal = api
			        .column(8, { page: "current" })
			        .data()
			        .reduce((a, b) => intVal(a) + intVal(b), 0);

			    // Update footer
			    $(api.column(8).footer()).html(pageTotal.toFixed(2));
			},
	    });

	    $('#formSellingReportSearch').on('click', function(e) {
			let dateValue = $('#dateRange').val();
			// ❌ Date not selected or invalid range
		    if (!dateValue || !dateValue.includes(' to ')) {
		        Swal.fire({
		            icon: 'warning',
		            title: 'Date Required',
		            text: 'Please select a valid date range before searching.',
		            confirmButtonText: 'OK'
		        });
		        return false; // ⛔ stop ajax call
		    }
	    	table.ajax.reload();
	    });

	    $('#formSellingReportReset').on('click', function () {

		    $('#class_id').val('all');           // reset class
		    $('#dateRange').val('');             // clear date range
		    $('#user_id').val('');               // clear user
		    $('#payment_mode').val('');          // clear payment mode

		    // If you are using DataTable with AJAX reload:
		    table.ajax.reload();
		});


	});

</script>

<script>
	$(function () {
	    $('#dateRange').daterangepicker({
	        autoUpdateInput: false,
	        locale: {
	            cancelLabel: 'Clear'
	        }
	    });

	    $('#dateRange').on('apply.daterangepicker', function (ev, picker) {
	        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
	    });

	    $('#dateRange').on('cancel.daterangepicker', function (ev, picker) {
	        $(this).val('');
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
                        <input type="text" id="dateRange" class="form-control" placeholder="Select Date Range" readonly>
                    </div>
                </div>
                <div class="col-lg-2">
					<div class="mb-3">
                        <select class="form-select" name="user_id" id="user_id">
							<option value="">Select Payment Collected By</option>
							<?php if(!empty($user_lists)){
								foreach($user_lists as $user){ ?>
									<option value="<?php echo $user['id']; ?>"><?php echo $user['first_name'].' '.$user['last_name']; ?></option>
								<?php }
							} ?>
						</select>
                    </div>
                </div>
                <div class="col-lg-2">
					<div class="mb-3">
                        <select class="form-select" name="payment_mode" id="payment_mode">
							<option value="">Select Payment Mode</option>
							<option value="cash">Cash</option>
							<option value="cheque">Cheque / QR/UPI</option>
							<option value="pos"> POS / CARD</option>
							<option value="online">Online</option>
						</select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="mb-3">
                    	<button type="button" id="formSellingReportReset" class="btn btn-btn btn-danger">Reset <i class="ph ph-arrows-clockwise ms-2"></i></button>
                    	<button type="button" id="formSellingReportSearch" class="btn btn-primary ms-3">Go <i class="ph-paper-plane-tilt ms-2"></i></button>
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
			<table id="formSellingReport" class="display responsive">
		        <thead>
		            <tr>
						<th>ID</th>
						<th>SL No.</th>
						<th>Form No.</th>
						<th>Student Name</th>
						<th>Class</th>
						<th>Payment Date</th>
						<th>Payment Mode</th>
						<th>Entry By</th>
						<th>Payment Amount</th>
						<th>Collected By</th>
		            </tr>
		        </thead>

		        <tfoot>
			        <tr>
			            <th colspan="8" style="text-align:right">PAGE TOTAL :</th>
			            <th id="total_amount">0</th>
			            <th colspan="1"></th>
			        </tr>
			        <!-- <tr>
			            <th colspan="8" style="text-align:right">GRAND TOTAL :</th>
			            <th id="totalPaymentAmount">0</th>
			            <th colspan="1"></th>
			        </tr> -->
			    </tfoot>
		    </table>

		    <!-- <div class="row">
		    	<div>GRAND TOTAL :</div>
		    	<div id="totalPaymentAmount">0</div>
		    </div> -->
		</div>
	</div>
	<!-- /page length options -->
</div>
<!-- /content area -->
