<!-- jQuery -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css"> -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables 1.13 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<!-- jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

<!-- DataTables -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.min.css"> -->

<!-- DataTables Buttons (compatible with DataTables 2.x) -->
<!-- <script src="https://cdn.datatables.net/2.3.3/js/dataTables.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script> -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.min.css"> -->
<!-- <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.min.js"></script> -->

<!-- Export Buttons -->
<!-- <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script> -->

<!-- Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

<!-- DataTables Buttons JS + dependencies -->
<!-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script> -->
<!-- Export -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
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
    
		var table = $('#dailyStationarySalesReportTable').DataTable({
	    	deferLoading: 0,
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
					className: 'btn btn-success btn-sm',
					titleAttr: 'Export to Excel',
					footer: true
				},
				{
					extend: 'csvHtml5',
					className: 'btn btn-info btn-sm',
					titleAttr: 'Export to CSV',
					footer: true
				},
				{
					extend: 'pdfHtml5',
					className: 'btn btn-danger btn-sm',
					orientation: 'landscape',
					pageSize: 'A4',
					titleAttr: 'Export to PDF',
					footer: true
				},
				{
					extend: 'print',
					className: 'btn btn-primary btn-sm',
					titleAttr: 'Print Table',
					footer: true
				}
			],
	        columnDefs: [
	            { targets: 0, visible: false, searchable: false }
	        ],
	        order: [[0, 'desc']],
	        scrollX: true,
	    });

		$('#dailyStationarySalesReport').on('click', function (e) {
		    e.preventDefault();

		    let from_date = $('#get_from_date').val();
		    let to_date = $('#get_to_date').val();
		    let class_id = $('#class_id').val();
		    let lang = $('#lang').val();
		    let t_user_id = $('#t_user_id').val();
		    let payment_mode = $('#payment_mode').val();
		    let pos_bank_name = $('#pos_bank_name').val();

		    if ( !payment_mode ) {
		        Swal.fire({
		            icon: 'warning',
		            title: 'Payment Mode Required',
		            text: 'Please select a valid payment mode.',
		            confirmButtonText: 'OK'
		        });
		        return false; // ⛔ stop ajax call
		    }
		    if ( !class_id ) {
		        Swal.fire({
		            icon: 'warning',
		            title: 'Class is Required',
		            text: 'Please select a valid Class.',
		            confirmButtonText: 'OK'
		        });
		        return false; // ⛔ stop ajax call
		    }
		    
			$("#dailyStationarySalesReportForm").submit();

		    // ✅ Date valid → reload table
		    // table.ajax.reload();
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
			<form id="dailyStationarySalesReportForm" method="post" action="<?= base_url('/admin/report/daily-stationary-report') ?>">
				<div class="row">
					<div class="col-lg-3">
						<div class="mb-3">
							<input type="text" name="get_from_date" id="get_from_date" value="<?= esc(@$filters['from_date']); ?>" class="form-control datepicker-basic" placeholder="Select From Date" readonly>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="mb-3">
							<input type="text" name="get_to_date" id="get_to_date" value="<?= esc(@$filters['to_date']); ?>" class="form-control datepicker-basic" placeholder="Select To Date" readonly>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="mb-3">
							<select class="form-select" name="class_id" id="class_id">
								<option value="">Select Class</option>
								<?php if(!empty($class_list)){
									foreach($class_list as $class){ ?>
										<option value="<?php echo $class['id']; ?>" <?= (@$filters['class_id'] == $class['id']) ? 'selected' : '' ?> ><?php echo $class['class_name']; ?></option>
									<?php }
								} ?>
							</select>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="mb-3">
							<select class="form-select" name="lang" id="lang">
								<option value="">Select language</option>
								<option value="Bengali" <?= (@$filters['lang'] == 'Bengali') ? 'selected' : '' ?>>Bengali</option>
								<option value="Hindi" <?= (@$filters['lang'] == 'Hindi') ? 'selected' : '' ?>>Hindi</option>
							</select>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="mb-3">
							<select class="form-select" name="t_user_id" id="t_user_id">
								<option value="">Select User</option>
								<?php if(!empty($user_lists)){
									foreach($user_lists as $user){ ?>
										<option value="<?php echo $user['id']; ?>" <?= (@$filters['t_user_id'] == $user['id']) ? 'selected' : '' ?>><?php echo $user['first_name'].' '.$user['last_name']; ?></option>
									<?php }
								} ?>
							</select>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="mb-3">
							<select class="form-select" name="payment_mode" id="payment_mode" required>
								<option value="">Select Payment Mode</option>
								<option value="cash" <?= (@$filters['payment_mode']=='cash')?'selected':'' ?>>Cash</option>
								<option value="cheque" <?= (@$filters['payment_mode']=='cheque')?'selected':'' ?>>Cheque / QR/UPI</option>
								<option value="pos" <?= (@$filters['payment_mode']=='pos')?'selected':'' ?>> POS / CARD</option>
								<option value="CCAvenue" <?= (@$filters['payment_mode']=='CCAvenue')?'selected':'' ?>>Online</option>
							</select>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="mb-3">
							<select class="form-select" name="pos_bank_name" id="pos_bank_name">
								<option value="">Select Bank Name</option>
								<option value="AXIS" <?= (@$filters['pos_bank_name']=='AXIS')?'selected':'' ?>>AXIS</option>
								<option value="BOB" <?= (@$filters['pos_bank_name']=='BOB')?'selected':'' ?>>BOB</option>
								<option value="SBI" <?= (@$filters['pos_bank_name']=='SBI')?'selected':'' ?>>SBI</option>
								<option value="HDFC" <?= (@$filters['pos_bank_name']=='HDFC')?'selected':'' ?>>HDFC</option>
							</select>
						</div>
					</div>
	
					<div class="col-lg-3">
						<div class="mb-3">
							<button type="button" id="dailyStationarySalesReport" class="btn btn-primary ms-3">Go <i class="ph-paper-plane-tilt ms-2"></i></button>
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
		<?php
		    // Collect all unique item IDs
		    $allItemIds = [];
		    $totalCollection = 0;
		    
		    if (!empty($stationary_sales_details)) {
		        foreach ($stationary_sales_details as $row) {
		            // Sum total collection
		            $totalCollection += $row['price'] ?? 0;
		            
		            // Get item IDs
		            $itemIdsString = $row['item_ids'] ?? '';
		            $itemIdsArray = array_map('trim', explode(',', $itemIdsString));
		            
		            // Add to all item IDs array
		            foreach ($itemIdsArray as $itemId) {
		                if ($itemId && !in_array($itemId, $allItemIds)) {
		                    $allItemIds[] = $itemId;
		                }
		            }
		        }
		    }
		    ?>
			<table id="dailyStationarySalesReportTable" class="display responsive">

			    <thead>
		            <tr>
						<th>ID</th>
			            <th>Student Code</th>
						<th>Student Name</th>
						<th>Second Language</th>
						<th>Payment Date</th>
						<th>Payment Mode</th>
						<th>Class</th>
						<th>Section</th>
						<th>Roll</th>
						<th>Collected By</th>
						<!-- <th width="20%">Item Name</th> -->
						<?php 
						if(isset($stationary_lists) && !empty($stationary_lists)) {
						foreach ($stationary_lists as $lists): 
							if( in_array($lists['id'], $allItemIds) ):
						?>

		                    <th><?= $lists['item_name'] ?? '' ?> Qty (<?= $lists['sec_lang'] ?? '' ?>)</th>
		                    <th><?= $lists['item_name'] ?? '' ?> /Price (<?= $lists['sec_lang'] ?? '' ?>)</th>
		                <?php endif; endforeach; }?>
						<th width="10%">Total</th>
		            </tr>
		        </thead>
				<tbody>
					<?php if (!empty($stationary_sales_details)): ?>
						<?php foreach ($stationary_sales_details as $row): ?>
							<tr>
								<td><?= $row['id'] ?></td>
								<td><?= esc($row['class_code']) ?></td>
								<td><?= esc($row['first_name']) ?></td>
								<td><?= esc($row['second_language']) ?></td>
								<td><?= esc($row['payment_date']) ?></td>
								<td><?= esc($row['payment_mode']) ?></td>
								<td><?= esc($row['class_name']) ?></td>
								<td><?= esc($row['section_name']) ?></td>
								<td><?= esc($row['roll_num']) ?></td>
								<td><?= esc($row['admin_full_name']) ?></td>
								<?php
									// Create arrays from item data
									$itemIdsArray = array_map('trim', explode(',', $row['item_ids'] ?? ''));
									$itemQtysArray = array_map('trim', explode(',', $row['item_qtys'] ?? ''));
									$itemPerPeiceArray = array_map('trim', explode(',', $row['item_price'] ?? ''));
									
									// Create associative array: item_id => quantity
									$itemQtyMap = [];
									$itemPriceMap = [];
									foreach ($itemIdsArray as $index => $itemId) {
										$qty = $itemQtysArray[$index] ?? '0';
										$itemQtyMap[$itemId] = $qty;
										$pricePer = $itemPerPeiceArray[$index] ?? '0';
										$itemPriceMap[$itemId] = $pricePer;
									}
									
									// Display quantities for each item ID
									// print_r($itemIdsArray);

									$key = 0;
									foreach ($stationary_lists as $lists):
										if(in_array($lists['id'], $allItemIds) ) {
											echo '<td>' . esc($itemQtyMap[$lists['id']] ?? '-') . '</td>';
											echo '<td>' . esc($itemPriceMap[$lists['id']] ?? '-') . '</td>';
											// $key++;
										}
										// else {
										// 	echo '<td> - </td>';
										// 	echo '<td> - </td>';
										// }
									endforeach;
		                        ?>
								<td><?= esc($row['price']) ?></td>
							</tr>
						<?php endforeach; ?>
		            <?php endif; ?>
				</tbody>

		        <tfoot>
				    <tr>
						<th colspan="<?= 6 + count($allItemIds) + 2 ?>" style="text-align:right">Grand Total:</th>
						<th>₹ <?= number_format($totalCollection, 0, '.', ',') ?></th>
					</tr>
				</tfoot>
		    </table>
		</div>
	</div>
	<!-- /page length options -->
</div>
<!-- /content area -->