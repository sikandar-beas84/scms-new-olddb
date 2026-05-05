<!-- Include DataTables CSS & JS -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css"> -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables 1.13 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<!-- First load jQuery -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

<!-- DataTables Buttons (compatible with DataTables 2.x) -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

<!-- <script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script> -->
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>

<!-- Export Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<!-- DataTables Buttons JS + dependencies -->
<!-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- Date range Picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<style>
	.item-details-grid {
	    display: grid;
	    grid-template-columns: 2fr 1fr 1fr 1fr;
	    border: 1px solid #dee2e6;
	    border-radius: 4px;
	    overflow: hidden;
	    font-size: 13px;
	}

	.grid-header, .grid-row {
	    display: contents;
	}

	.grid-header .grid-cell {
	    background-color: #f8f9fa;
	    font-weight: 600;
	    color: #495057;
	    border-bottom: 2px solid #dee2e6;
	}

	.grid-cell {
	    padding: 8px 10px;
	    border-bottom: 1px solid #e9ecef;
	    display: flex;
	    align-items: center;
	}

	.grid-row:last-child .grid-cell {
	    border-bottom: none;
	}

	.grid-row.total-row .grid-cell {
	    background-color: #e9ecef;
	    font-weight: 600;
	    border-top: 2px solid #dee2e6;
	}

	.text-center {
	    justify-content: center;
	    text-align: center;
	}

	.text-right {
	    justify-content: flex-end;
	    text-align: right;
	}

	/* Add hover effect for rows */
	.grid-row:hover .grid-cell {
	    background-color: #f8f9fa;
	}

	/* Ensure proper alignment */
	.grid-header .grid-cell {
	    padding: 10px 12px;
	}
</style>

<script>
	$(document).ready(function() {
	    var table = $('#tblcReport').DataTable({
	        pageLength: 25,
	        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
	        responsive: true,
	        scrollX: true,

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

	        order: [[0, 'desc']]
	    });

		$('#tblcReportSearch').on('click', function (e) {
		    e.preventDefault();

		    let dateValue = $('#get_filter_date').val();

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

		    let classIdValue = $('#class_id').val();

		    // ❌ Date not selected or invalid range
		    if (!classIdValue) {
		        Swal.fire({
		            icon: 'warning',
		            title: 'Class Required',
		            text: 'Please select class before searching.',
		            confirmButtonText: 'OK'
		        });
		        return false; // ⛔ stop ajax call
		    }

		    $("#tblcReportSearchForm").submit();
		});
	});

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
    })
</script>

<script>

	$(function () {

	    let input = $('#get_filter_date');
	    let existingVal = input.val();

	    input.daterangepicker({
	        autoUpdateInput: false,
	        locale: {
	            format: 'YYYY-MM-DD',
	            cancelLabel: 'Clear'
	        }
	    });

	    // 🔥 Proper restore logic
	    if (existingVal && existingVal.includes(' to ')) {
	        let dates = existingVal.split(' to ');

	        let start = moment(dates[0], 'YYYY-MM-DD');
	        let end   = moment(dates[1], 'YYYY-MM-DD');

	        if (start.isValid() && end.isValid()) {
	            let picker = input.data('daterangepicker');
	            picker.setStartDate(start);
	            picker.setEndDate(end);
	            input.val(existingVal);
	        }
	    }

	    input.on('apply.daterangepicker', function (ev, picker) {
	        $(this).val(
	            picker.startDate.format('YYYY-MM-DD') +
	            ' to ' +
	            picker.endDate.format('YYYY-MM-DD')
	        );
	    });

	    input.on('cancel.daterangepicker', function () {
	        $(this).val('');
	    });

	});
</script>

<script>
	$(document).ready(function() {
	    $('#student_code').on('input', function() {
	        let value = $(this).val().replace(/[^0-9]/g, ""); // keep only digits

	        if (value.length > 2) {
	            value = value.slice(0, 2) + "-" + value.slice(2, 6);
	        }

	        $(this).val(value);
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
			<form id="tblcReportSearchForm" method="post" action="<?= base_url('/admin/report/tblc-report/') ?>">
				<div class="row">
				
					<div class="col-lg-2">
						<div class="mb-3">
	                        <select class="form-select" name="class_id" id="class_id">
							    <option value="">Select Class</option>
							    <?php foreach ($class_list as $class): ?>
							        <option value="<?= $class['id']; ?>"
							            <?= ($filters['class_id'] == $class['id']) ? 'selected' : '' ?>>
							            <?= esc($class['class_name']); ?>
							        </option>
							    <?php endforeach; ?>
							</select>

	                    </div>
	                </div>
	                <div class="col-lg-3">
	                	<div class="mb-3">
							<input type="text" name="get_filter_date" id="get_filter_date" class="form-control" placeholder="Select Date Range" readonly value="<?= (!empty($filters['start_date']) && !empty($filters['end_date'])) ? $filters['start_date'].' to '.$filters['end_date'] : '' ?>">
						</div>
					</div>
					<div class="col-lg-2">
						<div class="mb-3">
	                        <select class="form-select" name="user_id" id="user_id">
							    <option value="">Select Payment Collected By</option>
							    <?php foreach ($user_lists as $user): ?>
							        <option value="<?= $user['id']; ?>"
							            <?= ($filters['user_id'] == $user['id']) ? 'selected' : '' ?>>
							            <?= esc($user['first_name'].' '.$user['last_name']); ?>
							        </option>
							    <?php endforeach; ?>
							</select>

	                    </div>
	                </div>
	                <div class="col-lg-2">
						<div class="mb-3">
	                        <select class="form-select" name="payment_mode" id="payment_mode">
							    <option value="">Select Payment Mode</option>
							    <option value="cash"   <?= ($filters['payment_mode']=='cash')?'selected':'' ?>>Cash</option>
							    <option value="cheque" <?= ($filters['payment_mode']=='cheque')?'selected':'' ?>>Cheque / QR / UPI</option>
							    <option value="pos"    <?= ($filters['payment_mode']=='pos')?'selected':'' ?>>POS / CARD</option>
							    <option value="online" <?= ($filters['payment_mode']=='online')?'selected':'' ?>>Online</option>
							</select>

	                    </div>
	                </div>

					<div class="col-lg-2">
						<div class="mb-3">
	                        <input class="form-control" type="text" name="student_code" id="student_code" value="<?= esc($filters['student_code'] ?? '') ?>" placeholder="Student code: Format must be: YY-XXXX (Example: 22-0129)" pattern="[0-9]{2}-[0-9]{4}" />
	                    </div>
	                </div>

	                <div class="col-lg-3">
	                    <div class="mb-3">
	                    	<button type="button" id="tblcReportSearch" class="btn btn-primary ms-3">Go <i class="ph-paper-plane-tilt ms-2"></i></button>
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
		    
		    if (!empty($collection_details)) {
		        foreach ($collection_details as $row) {
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

		    <table id="tblcReport" class="display responsive">
		        <thead>
		            <tr>
		                <th>ID</th>
		                <th>Payment Date</th>
		                <th>Student Code</th>
		                <th>Student Name</th>
		                <th>Class Name</th>
		                <th>Section</th>

		                <!-- Item ID headers -->
		                <?php /*foreach ($allItemIds as $itemId): ?>
		                    <th><?= esc(get_tblc_item_name_by_id($itemId)) ?> Qty</th>
		                <?php endforeach;*/ ?>

		                <?php foreach ($tblc_lists as $lists): ?>
		                    <th><?= $lists['item_name'] ?? '' ?> Qty</th>
		                    <th><?= $lists['item_name'] ?? '' ?> /Price</th>
		                <?php endforeach; ?>

		                <th>Payment Mode</th>
		                <th>Collected By</th>
		                <th>Total Collection</th>
		                <th>Remarks</th>
		            </tr>
		        </thead>
		        <tbody>
		            <?php if (!empty($collection_details)): ?>
		                <?php foreach ($collection_details as $row): ?>
		                    <tr>
		                        <td><?= $row['id'] ?></td>
		                        <td><?= date('Y-m-d', strtotime($row['payment_date'])) ?></td>
		                        <td><?= esc($row['class_code']) ?></td>
		                        <td><?= esc($row['first_name']) ?></td>
		                        <td><?= esc($row['class_name']) ?></td>
		                        <td><?= esc($row['section_name']) ?></td>

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
		                        /*foreach ($allItemIds as $itemId):
		                            echo '<td>' . esc($itemQtyMap[$itemId] ?? '-') . '</td>';
		                        endforeach;*/

		                        foreach ($tblc_lists as $lists):
		                        	if( in_array($lists['id'], $allItemIds) ):
		                        		echo '<td>' . esc($itemQtyMap[$lists['id']] ?? '-') . '</td>';
		                        		echo '<td>' . esc($itemPriceMap[$lists['id']] ?? '-') . '</td>';
		                        	endif;
		                        endforeach;
		                        ?>

		                        <td><?= ucfirst($row['ad_payment_mode']) ?></td>
		                        <td><?= trim(($row['added_by_first_name'] ?? '') . ' ' . ($row['added_by_last_name'] ?? '')) ?></td>
		                        <td><?= $row['price'] ?></td>
		                        <td><?= esc($row['remarks']) ?></td>
		                    </tr>
		                <?php endforeach; ?>
		            <?php endif; ?>
		        </tbody>

		        <!-- Footer for totals -->
		        <tfoot>
		            <tr>
		                <th colspan="<?= 6 + count($allItemIds) + 2 ?>">Total</th>
		                <th>₹ <?= number_format($totalCollection, 0, '.', ',') ?></th>
		                <th></th>
		            </tr>
		        </tfoot>
		    </table>
		</div>

	</div>
	<!-- /page length options -->
</div>
<!-- /content area -->
