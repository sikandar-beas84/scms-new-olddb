<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.min.css">
<script src="https://cdn.datatables.net/2.3.3/js/dataTables.min.js"></script>

<!-- DataTables Buttons (compatible with DataTables 2.x) -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.min.js"></script>

<!-- Export Buttons -->
<script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>

<!-- Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- jQuery Print -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>


<script>
	function initDatePickers() {
	    $(".datepicker-basic").datepicker({
	        dateFormat: "yy-mm-dd", // yyyy-mm-dd
	        changeMonth: true,
	        changeYear: true,
	        yearRange: "1990:2050"
	    });
	}

	$(document).ready(function(){
		// Datepicker
    	initDatePickers()
    
		/**
		 * Formats student code input with automatic hyphen insertion
		 * 
		 * This event handler listens for input changes on the student code field
		 * and automatically formats the entered number with a hyphen after the
		 * first 2 digits (e.g., "12-3456").
		 * 
		 * @event input
		 * @param {jQuery} $(this) - The student code input field
		 * @returns {void}
		 */
		$('#student_code').on('input', function() {
	        let value = $(this).val().replace(/[^0-9]/g, ""); // keep only digits

	        if (value.length > 2) {
	            value = value.slice(0, 2) + "-" + value.slice(2, 6);
	        }

	        $(this).val(value);
	    });

	    var dailyBusPaymentReportTable = new DataTable('#dailyBusPaymentReportTable', {
		    pageLength: 25,
		    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
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
		            exportOptions: { columns: ':visible' },
		            footer: true
		        },
		        {
		            extend: 'csvHtml5',
		            text: '<i class="fa fa-file-text-o"></i> CSV',
		            className: 'btn btn-info btn-sm',
		            exportOptions: { columns: ':visible' },
		            footer: true
		        },
		        {
		            extend: 'pdfHtml5',
		            text: '<i class="fa fa-file-pdf-o"></i> PDF',
		            className: 'btn btn-danger btn-sm',
		            orientation: 'landscape',
		            pageSize: 'A4',
		            footer: true,
		            exportOptions: {
		                columns: ':visible'
		            },
		            customize: function (doc) {
		                doc.defaultStyle.fontSize = 8;
		                doc.styles.tableHeader.fontSize = 9;
		            }
		        }
		    ],

		    columnDefs: [
		        { targets: 0, visible: false, searchable: false, orderable: true }
		    ],

		    order: [[0, 'desc']],
		    scrollX: true,
		    processing: true
		});

		$('#dailyBusPaymentReport').on('click', function (e) {
		    e.preventDefault();

		    let from_date = $('#from_date').val();
		    let to_date = $('#to_date').val();
		    let class_id = $('#class_id').val();
		    let student_code = $('#student_code').val();
		    let t_user_id = $('#t_user_id').val();
		    let payment_mode = $('#payment_mode').val();

		    if ( !payment_mode ) {
		        Swal.fire({
		            icon: 'warning',
		            title: 'Payment Mode Required',
		            text: 'Please select a valid payment mode.',
		            confirmButtonText: 'OK'
		        });
		        return false; // ⛔ stop ajax call
		    }
		    
		    // ✅ Date valid → reload table
		    // table.ajax.reload();
		    $("#busPaymentReportForm").submit();
		});
	})
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
			<form id="busPaymentReportForm" method="post" action="<?= base_url('admin/report/daily-bus-payment-report') ?>">
				<div class="row">

					<div class="col-lg-3">
	                	<div class="mb-3">
							<input type="text" name="from_date" id="from_date" class="form-control datepicker-basic" placeholder="Select From Date" value="<?= $from_date ?>" readonly>
						</div>
					</div>
					<div class="col-lg-3">
	                	<div class="mb-3">
							<input type="text" name="to_date" id="to_date" class="form-control datepicker-basic" placeholder="Select To Date" value="<?= $to_date ?>" readonly>
						</div>
					</div>
					<div class="col-lg-3">
		                <div class="mb-3">
	                		<input type="text" class="form-control student-mask-id" name="student_code" value="" id="student_code" placeholder="Student code: Format must be: YY-XXXX (Example: 22-0129)" pattern="[0-9]{2}-[0-9]{4}" value="<?= $student_code ?>" />
		                </div>
		            </div>
					<div class="col-lg-3">
						<div class="mb-3">
	                        <select class="form-select" name="class_id" id="class_id">
								<option value="">Select Class</option>
								<?php if(!empty($class_list)){
									foreach($class_list as $class){
										$classSelected = ($class['id'] == $class_id) ? 'selected' : '';
										?>
										<option value="<?php echo $class['id']; ?>" <?= $classSelected ?>><?php echo $class['class_name']; ?></option>
									<?php }
								} ?>
							</select>
	                    </div>
	                </div>
					<div class="col-lg-3">
						<div class="mb-3">
	                        <select class="form-select" name="t_user_id" id="t_user_id">
								<option value="">Select User</option>
								<?php if(!empty($user_lists)){
									foreach($user_lists as $user){
										$userSelected = ($user['id'] == $t_user_id) ? 'selected' : ''; ?>
										<option value="<?php echo $user['id']; ?>" <?= $userSelected ?>><?php echo $user['first_name'].' '.$user['last_name']; ?></option>
									<?php }
								} ?>
							</select>
	                    </div>
	                </div>
	                <div class="col-lg-3">
						<div class="mb-3">
	                        <select class="form-select" name="payment_mode" id="payment_mode" required>
								<option value="">Select Payment Mode</option>
								<option value="cash" <?= ($payment_mode == "cash") ? 'selected' : ''; ?>>Cash</option>
								<option value="cheque" <?= ($payment_mode == "cheque") ? 'selected' : ''; ?>>Cheque / QR/UPI</option>
								<option value="pos" <?= ($payment_mode == "pos") ? 'selected' : ''; ?>> POS / CARD</option>
								<option value="CCAvenue" <?= ($payment_mode == "CCAvenue") ? 'selected' : ''; ?>>Online</option>
							</select>
	                    </div>
	                </div>

	                <div class="col-lg-3">
	                    <div class="mb-3">
	                    	<button type="submit" id="dailyBusPaymentReport" class="btn btn-primary ms-3">Go <i class="ph-paper-plane-tilt ms-2"></i></button>
	                    </div>
					</div>
				
				</div>
			</form>

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
			<table id="dailyBusPaymentReportTable" class="display responsive">

			    <thead>
		            <tr>
						<th>ID</th>
			            <th>Name</th>
						<th>Student Code</th>
						<th>Class</th>

						<th>Bus Fee </th>													
						<th>Bus Fee Fine</th>
						<th>Bus Payment Date</th>
						<th>Payment Month</th>

						<th>Bus Payment Mode</th>
						<th>Bus Collected By</th>
						<th>Bus Stoppage</th>
						<!-- <th>For Month</th> -->
						<!-- <th>Remarks</th> -->
						<th>Transaction No</th>
		            </tr>
		        </thead>
		        <tbody>
		        	<?php 
		        	$busPaymentTotalAmount = 0;
		        	$busFineTotalAmount = 0;
		        	if( isset($bus_payment_details) && !empty($bus_payment_details) ) {
		        		$i = 0;
		        		foreach ($bus_payment_details as $payment_details) {
		        			$busPaymentTotalAmount += $payment_details['bus_payment_amt'];
		        			$busFineTotalAmount += $payment_details['bus_fee_fine'];
		        			?>
		        			<tr>
		        				<td><?= $i ?></td>
		        				<td><?= $payment_details['full_name'] ?? '' ?></td>
		        				<td><?= $payment_details['student_code'] ?? '' ?></td>
		        				<td><?= (isset($payment_details['class_id']) && $payment_details['class_id'] != '') ? get_class_name_by_id($payment_details['class_id']) : '' ?></td>

		        				<td><?= $payment_details['bus_payment_amt'] ?? '' ?></td>
		        				<td><?= (int)$payment_details['bus_fee_fine'] ?? '' ?></td>
		        				<td><?= $payment_details['bus_payment_date'] ?? '' ?></td>
		        				<td><?= $payment_details['month_name'] ?? '' ?></td>

		        				<td><?= $payment_details['bus_payment_mode'] ?></td>
		        				<td><?= $payment_details['bus_added_by'] ?></td>
		        				<td><?= (isset($payment_details['stoppage']) && $payment_details['stoppage'] != '') ? stoppage_name_by_id($payment_details['stoppage']) : ''; ?></td>
		        				<!-- <td><?= (!empty($payment_details['month_id']) && is_numeric($payment_details['month_id'])) ? date('F', mktime(0, 0, 0, $payment_details['month_id'], 10)) : '' ?></td> -->
		        				<!-- <td><?= $payment_details['remarks'] ?></td> -->
		        				<td><?= $payment_details['transaction_no'] ?></td>
		        			</tr>
		        			<?php
		        			$i++;
		        		}
		        	} ?>
		        </tbody>

		        <tfoot>
			        <tr>
			            <th></th>
			            <th></th>
			            <th></th>
			            <th></th>
			            <th>Total : <?= $busPaymentTotalAmount ?></th>
			            <th>Fine Total : <?= $busFineTotalAmount ?></th>
			            <th></th>
			            <th></th>
			            <th></th>
			            <th></th>
			            <th></th>
			            <th></th>
			        </tr>
			    </tfoot>
		    </table>
		</div>
	</div>
	<!-- /page length options -->
</div>
<!-- /content area -->