<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .item-row {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #ddd;
        padding: 8px 0;
        gap: 10px;
    }
    .item-row div {
        flex: 1;
    }
    .item-header {
        font-weight: bold;
        background: #f3f3f3;
        padding: 10px 0;
        border-bottom: 2px solid #ccc;
        display: flex;
        gap: 10px;
        text-align: center;
    }
    .item-header div {
        flex: 1;
    }
    input[type="number"], input[type="text"] {
        width: 100%;
        padding: 6px;
    }
</style>

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
    <!-- Input fields -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Collect Admission Fee</h5>
        </div>
        <?php if(!empty($form_details)){ ?>
	        <div class="card-body">
	            <p class="mb-4"></p>

	            <?php if(isset($dept_id) && $dept_id == 1 ) : ?>
	            	<div class="mb-4">
		                <div class="fw-bold border-bottom pb-2 mb-3"><i class="ph-bus ms-2"></i> Select Stoppage of transport required</div>
		                <form role="form" class="update_form" action="javascript:" id="stu_update" enctype="multipart/form-data" autocomplete="off">
			                <div class="row mb-3">
			                    <label class="col-form-label col-lg-3">Stoppage</label>
			                    <div class="col-lg-6">
			                        <select class="form-select" name="stoppage" id="stoppage">
			                        	<option value="0">--Select Stopage--</option>
			                        	<?php foreach($stoppage_list as $stoppage): ?>
			                        		<option value="<?= $stoppage['stoppage_id'] ?>" <?= ($form_details['stoppage'] == $stoppage['stoppage_id'] ? 'selected':'' ) ?>><?= $stoppage['stoppage_name'] ?> - &#8377; <?php echo stoppage_fee_by_id($stoppage['stoppage_id']) ?></option>
		                        		<?php endforeach; ?>
			                        </select>
			                    </div>
			                </div>
			                <div class="row mb-3">
			                    <label class="col-form-label col-lg-3">Choose Bus</label>
			                    <div class="col-lg-6">
			                        <select class="form-select" name="bus_id" id="bus_id">
			                        	<option value="0">--Select Bus--</option>
			                        	<?php foreach($bus_list as $bus): ?>
			                        		<option value="<?= $bus['bus_id'] ?>"  <?= ($form_details['bus_id'] == $bus['bus_id'] ? 'selected':'' ) ?>><?= $bus['bus_licence_no'] ?></option>
		                        		<?php endforeach; ?>
			                        </select>
			                    </div>
			                </div>
			                <div class="row mb-3">
			                	<div class="col-lg-3"></div>
			                	<div class="col-lg-6">
			                		<button id="stoppageFormSubmit" type="button" class="btn btn-primary">Update <i class="ph-paper-plane-tilt ms-2"></i></button>
			                		<?php if( isset($form_details['bus_id']) && $form_details['bus_id'] > 0 ) { ?>
			                			<button id="stoppageFormCancelSubmit" type="button" class="btn btn-danger">Cancel Bus Assignment <i class="ph-paper-plane-tilt ms-2"></i></button>
			                		<?php } ?>
			                	</div>
			                	<span class="msg"></span>
			                </div>
		               	</form>
	                </div>

	            	<div class="mb-4">
		                <div class="fw-bold border-bottom pb-2 mb-3"><i class="ph-tree-structure ms-2"></i> Assign Section to Student</div>
		                <form role="form" class="update_sec_form" action="javascript:" id="stu_sec_update" enctype="multipart/form-data" autocomplete="off">
			                <div class="row mb-3">
			                    <label class="col-form-label col-lg-3">Choose Section</label>
			                    <div class="col-lg-6">
			                        <select class="form-select" name="section_id" id="section_id">
			                        	<option value="0">--Select Section--</option>
			                        	<?php foreach($section_list as $section): ?>
			                        		<option value="<?= $section['id'] ?>" <?= ($form_details['section_id'] == $section['id'] ? 'selected':'' ) ?>><?= $section['section_name'] ?></option>
		                        		<?php endforeach; ?>
			                        </select>
			                    </div>
			                </div>
			                <div class="row mb-3">
			                	<div class="col-lg-3"></div>
			                	<div class="col-lg-6">
			                		<button type="button" class="btn btn-info" id="submit_section">Assign Section <i class="ph-paper-plane-tilt ms-2"></i></button>
			                	</div>
			                </div>
		               	</form>
	                </div>
	            <?php endif; ?>

	            <div class="mb-4">
	                <div class="fw-bold border-bottom pb-2 mb-3"><i class="ph-money ms-2"></i> Admission Payment</div>
	                
	                <form method="post" id="admissionPaymentArea">
	                	<?php 
	                	$allowedUsers = [9583, 9584, 9585];
						$readonly = in_array(session()->get('user_id'), $allowedUsers) ? '' : 'readonly';
	                	?>
		                <div class="col-lg-6">
							<div class="list-group list-group-sm list-group-borderless">
								<div class="row mb-2">
									<div class="col-lg-6"><i class="ph-file-text me-2"></i> Admission Fee(ONE Time)New Student Rs.</div>
									<div class="col-lg-3"><input type="number" min="0" class="form-control fees_area_js" name="admission_fee" id="admission_fee" value="<?= $form_details['admission_fee'] ?>" <?= $readonly ?> /></div>
									<div class="col-lg-3" id="admission_fee_level">₹<?= $form_details['admission_fee'] ?></div>
								</div>
								<div class="row mb-2">
									<div class="col-lg-6"><i class="ph-file-text me-2"></i> Development Fee (YEARLY) Rs.</div>
									<div class="col-lg-3"><input type="number" min="0" class="form-control fees_area_js" name="development_fee" id="development_fee" value="<?= $form_details['development_fee'] ?>" <?= $readonly ?> /></div>
									<div class="col-lg-3" id="development_fee_level">₹<?= $form_details['development_fee'] ?></div>
								</div>
								<div class="row mb-2">
									<div class="col-lg-6"><i class="ph-file-text me-2"></i> Exam Fee (YEARLY) Rs.</div>
									<div class="col-lg-3"><input type="number" min="0" class="form-control fees_area_js" name="exam_fee" id="exam_fee" value="<?= $form_details['exam_fee'] ?>" <?= $readonly ?> /></div>
									<div class="col-lg-3" id="exam_fee_level">₹<?= $form_details['exam_fee'] ?></div>
								</div>
								<div class="row mb-2">
									<div class="col-lg-6"><i class="ph-file-text me-2"></i> Festival Celebration Fee (YEARLY) Rs.</div>
									<div class="col-lg-3"><input type="number" min="0" class="form-control fees_area_js" name="festival_celebration_fee" id="festival_celebration_fee" value="<?= $form_details['festival_celebration_fee'] ?>" <?= $readonly ?> /></div>
									<div class="col-lg-3" id="festival_celebration_fee_level">₹<?= $form_details['festival_celebration_fee'] ?></div>
								</div>
								<div class="row mb-2">
									<div class="col-lg-6"><i class="ph-file-text me-2"></i> Games Sports Fee (YEARLY) Rs.</div>
									<div class="col-lg-3"><input type="number" min="0" class="form-control fees_area_js" name="games_sports_fee" id="games_sports_fee" value="<?= $form_details['games_sports_fee'] ?>" <?= $readonly ?> /></div>
									<div class="col-lg-3" id="games_sports_fee_level">₹<?= $form_details['games_sports_fee'] ?></div>
								</div>
								<div class="row mb-2">
									<div class="col-lg-6"><i class="ph-file-text me-2"></i> Audio Visual Lab Fee (YEARLY) Rs.</div>
									<div class="col-lg-3"><input type="number" min="0" class="form-control fees_area_js" name="audio_visual_lab_fee" id="audio_visual_lab_fee" value="<?= $form_details['audio_visual_lab_fee'] ?>" <?= $readonly ?> /></div>
									<div class="col-lg-3" id="audio_visual_lab_fee_level">₹<?= $form_details['audio_visual_lab_fee'] ?></div>
								</div>
								<div class="row mb-2">
									<div class="col-lg-6"><i class="ph-file-text me-2"></i> Library Fee (YEARLY) Rs.</div>
									<div class="col-lg-3"><input type="number" min="0" class="form-control fees_area_js" name="library_fee" id="library_fee" value="<?= $form_details['library_fee'] ?>" <?= $readonly ?> /></div>
									<div class="col-lg-3" id="library_fee_level">₹<?= $form_details['library_fee'] ?></div>
								</div>
								<div class="row mb-2">
									<div class="col-lg-6"><i class="ph-file-text me-2"></i> Electricity Maintenance Fee (YEARLY) Rs.</div>
									<div class="col-lg-3"><input type="number" min="0" class="form-control fees_area_js" name="electricity_maintenance_fee" id="electricity_maintenance_fee" value="<?= $form_details['electricity_maintenance_fee'] ?>" <?= $readonly ?> /></div>
									<div class="col-lg-3" id="electricity_maintenance_fee_level">₹<?= $form_details['electricity_maintenance_fee'] ?></div>
								</div>
								<div class="row mb-2">
									<div class="col-lg-6"><i class="ph-file-text me-2"></i> Computer Fee (YEARLY) Rs.</div>
									<div class="col-lg-3"><input type="number" min="0" class="form-control fees_area_js" name="computer_fee" id="computer_fee" value="<?= $form_details['computer_fee'] ?>" <?= $readonly ?> /></div>
									<div class="col-lg-3" id="computer_fee_level">₹<?= $form_details['computer_fee'] ?></div>
								</div>
								<div class="row mb-2">
									<div class="col-lg-6"><i class="ph-file-text me-2"></i> Security Deposit (REFUNDABLE) New Student Rs.</div>
									<div class="col-lg-3"><input type="number" min="0" class="form-control fees_area_js" name="security_deposite" id="security_deposite" value="<?= $form_details['security_deposite'] ?>" <?= $readonly ?> /></div>
									<div class="col-lg-3" id="security_deposite_level">₹<?= $form_details['security_deposite'] ?></div>
								</div>
								<div class="row mb-2">
									<div class="col-lg-6"><i class="ph-file-text me-2"></i> Tuition Fee (MONTHLY) Rs.</div>
									<div class="col-lg-3"><input type="number" min="0" class="form-control fees_area_js" name="tuition_fee" id="tuition_fee" value="<?= $form_details['tuition_fee'] ?>" <?= $readonly ?> /></div>
									<div class="col-lg-3" id="tuition_fee_level">₹<?= $form_details['tuition_fee'] ?></div>
								</div>
								<div class="row mt-3">
								    <div class="col-lg-9 text-end">
								        <strong>Total Fees:</strong>
								    </div>
								    <div class="col-lg-3">
								        <strong id="grand_total_amount">₹0</strong>
								    </div>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="list-group list-group-sm list-group-borderless">
								<div class="row mb-2">
									<!-- ===================================== -->
									<div class="col-12 col-md-6">
										<div class="row mb-2">
											<div class="col-lg-6"><h6>Total Stationary Fee Rs.</h6></div>
											<hr>
										</div>

										<div class="item-header">
										    <div>#</div>
										    <div>Name</div>
										    <div>Qty</div>
										    <div>Price</div>
										    <div>Total</div>
										    <div>Select</div>
										</div>

										<div id="itemContainer">
										    <?php 
										    if(isset($stationary_item_list) && !empty($stationary_item_list)) {
										        $i = 1;
										        foreach ($stationary_item_list as $row) {
										            $total = $row['qty'] * $row['price'];
										            $getChecked = 'checked';
										            if( $i > 7 ) {
										            	$getChecked = '';
										            }
										            ?>

										            <div class="item-row  item-row-stationary">
										                <div><?= $i ?></div>

										                <!-- Name as plain text -->
										                <div class="item_name_text"><?= $row['item_name'] ?></div>

										                <input type="hidden" class="item_id" value="<?= $row['id'] ?>">

										                <div>
										                    <input type="number" class="item_qty" value="<?= $row['qty'] ?>" min="1">
										                </div>

										                <div>
										                    <input type="number" class="item_price" value="<?= $row['price'] ?>" min="1">
										                </div>

										                <div>
										                    <input type="text" class="item_total" value="<?= $total ?>" readonly>
										                </div>

										                <div style="text-align:center;">
										                    <input type="checkbox" class="item_check" <?= $getChecked ?>>
										                </div>
										            </div>

										            <?php
										            $i++;
										        }
										    }
										    ?>
										</div>

										<!-- Grand Total -->
										<div class="row mt-3">
										    <div class="col-lg-9 text-end">
										        <strong>Stationary Total Fee:</strong>
										    </div>
										    <div class="col-lg-3">
										        <strong id="grandTotal">₹0</strong>
										    </div>
										</div>
									</div>
									<!-- ===================================== -->
									<!-- ===================================== -->
									<div class="col-12 col-md-6">
										<div class="row mb-2">
											<div class="col-lg-6"><h6>Total TBLC Fee Rs.</h6></div>
											<hr>
										</div>

										<div class="item-header">
										    <div>#</div>
										    <div>Name</div>
										    <div>Qty</div>
										    <div>Price</div>
										    <div>Total</div>
										    <div>Select</div>
										</div>

										<div id="tblcContainer">
										    <?php 
										    if(isset($tblc_list) && !empty($tblc_list)) {
										        $i = 1;
										        foreach ($tblc_list as $row) {
										            $total = $row['qty'] * $row['price'];
										            $getTblcChecked = 'checked';
										            if( $i > 6 ) {
										            	$getTblcChecked = '';
										            }
										            ?>

										            <div class="item-row  item-row-tblc">
										                <div><?= $i ?></div>

										                <div><?= $row['item_name'] ?></div>
									                 	<input type="hidden" class="item_id" value="<?= $row['id'] ?>">
										                <div>
										                    <input type="number" class="item_qty" value="<?= $row['qty'] ?>" min="1">
										                </div>

										                <div>
										                    <input type="number" class="item_price" value="<?= $row['price'] ?>" min="1">
										                </div>

										                <div>
										                    <input type="text" class="item_total" value="<?= $total ?>" readonly>
										                </div>

										                <div style="text-align:center;">
										                    <input type="checkbox" class="item_check" <?= $getTblcChecked ?>>
										                </div>
										            </div>

										            <?php
										            $i++;
										        }
										    }
										    ?>
										</div>

										<div class="row mt-3">
										    <div class="col-lg-9 text-end">
										        <strong>TBLC Total Fee:</strong>
										    </div>
										    <div class="col-lg-3">
										        <strong id="grandTotal2">₹0</strong>
										    </div>
										</div>
									</div>
									<!-- ===================================== -->
								</div>

								<?php if($form_details['stoppage_name']) { ?>
									<div class="row mb-2">
										<div class="col-lg-6">
											<i class="ph-file-text me-2"></i> Bus Services (<?= $form_details['stoppage_name'] ?>)
										</div>
										<div class="col-lg-3">
											<input type="number" class="form-control" name="stoppage_fee" id="stoppage_fee" value="<?= $stoppage_fare ?>" readonly />
										</div>
										<div class="col-lg-3" id="tuition_fee_level"></div>
									</div>
								<?php } ?>

								<div class="row mb-2">
									<div class="col-lg-6">
										<i class="ph-file-text me-2"></i> Consideration Remarks
									</div>
									<div class="col-lg-6">
										<textarea  name="remarks" id="remarks" rows="3" cols="3" class="form-control" placeholder="Enter your consideration remarks"></textarea>
									</div>
								</div>

								<div class="row mb-2">
									<div class="col-lg-6">Total Amount: <span id="grandTotalAmount"></span></div>
									<!-- admin_logged_in add condition -->
									<div class="col-lg-3">
										<button type="button" id="admission_fee_payment_btn" class="btn btn-warning pull-right"><i class="white ace-icon fa fa-credit-card "></i>Make Payment</button>
									</div>
									<div class="col-lg-3">
										<input type="hidden" class="form-control" name="payment_amount" id="payment_amount" value="" />
										<input type="hidden" class="form-control" name="form_no" value="<?php echo $form_details['form_no']; ?>" />
										<input type="hidden" class="form-control" name="first_name" value="<?php echo $form_details['first_name']; ?>" />
										<!-- <input type="button" class="btn btn-warning pull-right" value="Pay"></input> -->
									</div>
								</div>
								<?php // echo "<pre>"; print_r(session()->get()); ?>

								<?php 
								// $totalAmount = stoppage_fee_by_id($form_details->stoppage)+$form_details->admission_fee+$form_details->development_fee+$form_details->exam_fee+$form_details->festival_celebration_fee+$form_details->games_sports_fee+$form_details->audio_visual_lab_fee+$form_details->library_fee+$form_details->electricity_maintenance_fee+$form_details->computer_fee+$form_details->security_deposite+$form_details->tuition_fee+$stationary_total_price;
								?>

								<input type="hidden" name="payment_cheque_number" id="payment_cheque_number" value="" />
								<input type="hidden" name="payment_pos_bank_name" id="payment_pos_bank_name" value="" />
								<input type="hidden" name="payment_pos_reference_number" id="payment_pos_reference_number" value="" />
							</div>
						</div>
					</form>
	            </div>
	        </div>
       	<?php } else { ?>
       		<div class="card-body">
	            <p class="text-center mb-4">Admission Details Not Found</p>
	       	</div>
       	<?php } ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myAdmissionPaymentModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Collect Admission Fees</h5>
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
                            Cheque / QR/UPI
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">
                            POS / CARD
                        </button>
                    </li>
                </ul>
                
                <!-- Tab Content -->
                <div class="tab-content modal-tab-content" id="modalTabsContent">
                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                        <h4></h4>
                        <form class="form-horizontal" role="form" id="cpay" autocomplete="off">
							<p class="cpay_msg"></p>
							
							<div class="row mb-3">
								<label class="col-md-2 col-form-label">Cash Amount</label>
								<div class="col-md-4">
									<input type="text" class="form-control payment_amount_m" placeholder="Cash Amount" value="" disabled />
									<input type="hidden" name="payment_amount" value="" />
									<!-- <div class="form-text text-muted">Here goes your name</div> -->
								</div>
							</div>
							<div class="row mb-3">
								<label class="col-md-2 col-form-label">Payee Name</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="payee_name" value="" placeholder="Payee Name" readonly />
								</div>
							</div>

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
							<div class="row mb-3">
								<label class="col-md-2 col-form-label">Cheque Amount</label>
								<div class="col-md-4">
									<input type="text" class="form-control payment_amount_m" placeholder="Cheque Amount" value="" disabled />
									<input type="hidden" name="payment_amount" value="" />
								</div>
							</div>
							<div class="row mb-3">
								<label class="col-md-2 col-form-label">Payee Name</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="payee_name" value="" placeholder="Payee Name" readonly />
								</div>
							</div>
							<div class="row mb-3">
								<label class="col-md-2 col-form-label">Cheque No</label>
								<div class="col-md-4">
									<input type="text" name="cheque_number" id="cheque_number" class="form-control" placeholder="Cheque No" value="" />
								</div>
							</div>

							<button type="button" class="btn btn-primary" id="sub_chqpay">Save</button>
						</form>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <h4></h4>
                        <form class="form-horizontal" role="form" id="pospay" autocomplete="off">
							<p class="pospay_msg"></p>
							<div class="row mb-3">
								<label class="col-md-2 col-form-label">POS Bank Name</label>
								<div class="col-md-4">
									<select class="form-select" name="pos_bank_name" id="pos_bank_name">										
										<option value="AXIS">AXIS</option>
										<option value="BOB">BOB</option>
										<option value="SBI">SBI</option>
										<option value="HDFC" selected>HDFC</option>
									</select>	
								</div>
							</div>
							<div class="row mb-3">
								<label class="col-md-2 col-form-label">POS Amount</label>
								<div class="col-md-4">
									<input type="text" class="form-control payment_amount_m" placeholder="POS Amount" value="" disabled />
									<input type="hidden" name="payment_amount" value="" />
									<!-- <div class="form-text text-muted">Here goes your name</div> -->
								</div>
							</div>

							<div class="row mb-3">
								<label class="col-md-2 col-form-label">Reference Number</label>
								<div class="col-md-4">
									<input type="text" name="pos_reference_number" id="pos_reference_number" class="form-control" placeholder="POS Referance Number" value="" />
								</div>
							</div>

							<div class="row mb-3">
								<label class="col-md-2 col-form-label">Payee Name</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="payee_name" value="" placeholder="Payee Name" readonly />
								</div>
							</div>

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

<script>
	$(document).ready(function() {
		$('#stoppage').change(function(){
			var stoppage_id = $(this).find(':selected').val();
			$('#bus_id').empty();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('admin/bus/get-bus'); ?>", 
				data:{stoppage:stoppage_id},
				dataType:"json",//return type expected as json
				success: function(stoppage){
				   $.each(stoppage,function(key,val){
						var opt = $('<option/>'); 
						opt.val(key);
						opt.text(val);
						$('#bus_id').append(opt);
				   });
				},
			});
		});

		$('#stoppageFormSubmit').click(function () {				
			var stop = $('#stoppage').val();
			var bus = $('#bus_id').val();
			if(stop>0 && bus>0){
				Swal.fire({
				    title: "Are you sure?",
				    text: "Do you want to assign bus?",
				    icon: "warning",
				    showCancelButton: true,
				    confirmButtonText: "Yes, Assign",
				    cancelButtonText: "No, Cancel"
				}).then((result) => {
				    if (result.isConfirmed) {
				        // YES clicked
				        console.log("Bus assigned");

				        var code = '<?= ($form_details['form_no']) ?? '' ?>';
						var stu_previous_stoppage = '<?= ($form_details['stoppage']) ?? '' ?>';
						$.ajax({
							url:'<?= base_url() ?>admin/student/assign-bus-to-student',
							method: 'post',					
							data: {
								stoppage : stop, 
								bus_id : bus, 
								form_no : code, 
								stuPreviousStoppage : stu_previous_stoppage
							},
							//data: formdata,
							success: function(result){
								if (result == -1) {
								    $('.msg').html('<div class="mt-2 alert alert-danger">Invalid Student Code</div>');
								}
								else if(result > 0){							
									$('.msg').html('<div class="alert alert-block alert-success"><button data-dismiss="alert" class="close" type="button"><i class="ace-icon fa fa-times"></i></button><p><strong><i class="bi bi-check"></i>Well done!</strong>Student Details update successful</p></div>');
									setTimeout(function(){ location.reload(); }, 1500);
								} else {								
									$('.msg').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="bi bi-clipboard-x-fill"></i></button><strong><i class="ace-icon fa fa-times"></i> Failed! </strong>Their is an error for this transaction<br></div>');
								}  
							}
						}) 
				    } else {
				        // NO clicked
				        console.log("Cancelled");
				        e.preventDefault();
				    }
				});
			} else {
				alert('Please Select Stoppage & Bus');
			}			
		});

		$('#stoppageFormCancelSubmit').click(function () {				
			var stop = $('#stoppage').val();
			var bus = $('#bus_id').val();
			if(stop>0 && bus>0){
				Swal.fire({
				    title: "Are you sure?",
				    text: "Do you want to unassign bus?",
				    icon: "warning",
				    showCancelButton: true,
				    confirmButtonText: "Yes, Unassign",
				    cancelButtonText: "No, Cancel"
				}).then((result) => {
				    if (result.isConfirmed) {
				        // YES clicked
				        console.log("Bus unassign");

				        var code = '<?= ($form_details['form_no']) ?? '' ?>';
						var stu_previous_stoppage = '<?= ($form_details['stoppage']) ?? '' ?>';
						$.ajax({
							url:'<?= base_url() ?>admin/student/unassign-bus-to-student',
							method: 'post',					
							data: {
								stoppage : stop, 
								bus_id : bus, 
								form_no : code, 
								stuPreviousStoppage : stu_previous_stoppage
							},
							//data: formdata,
							success: function(result){
								console.log(result)
								if (result == -1) {
								    $('.msg').html('<div class="mt-2 alert alert-danger">Invalid Student ID Details</div>');
								}
								else if (result == -2) {
								    $('.msg').html('<div class="mt-2 alert alert-danger">Invalid Student Code</div>');
								}
								else if(result > 0){							
									$('.msg').html('<div class="alert alert-block alert-success"><button data-dismiss="alert" class="close" type="button"><i class="ace-icon fa fa-times"></i></button><p><strong><i class="bi bi-check"></i>Well done!</strong>Bus has been unassigned from the student</p></div>');
									setTimeout(function(){ location.reload(); }, 1500);
								} else {								
									$('.msg').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="bi bi-clipboard-x-fill"></i></button><strong><i class="ace-icon fa fa-times"></i> Failed! </strong>Their is an error for this transaction<br></div>');
								} 
							}
						}) 
				    } else {
				        // NO clicked
				        console.log("Cancelled");
				        e.preventDefault();
				    }
				});
			} else {
				alert('Please Select Stoppage & Bus');
			}			
		});

		$('#submit_section').click(function () {
			var section_id = $('#section_id').val();
			
			if(section_id > 0){
				
				var code = '<?= ($form_details['form_no']) ?? '' ?>';
				var class_id = '<?= ($form_details['class_id']) ?? '' ?>';
			
				$.ajax({
					url:'<?= base_url()?>admin/student/assign-section-to-student',
					method: 'post',					
					data: {
						class_id : class_id, 
						section_id : section_id, 
						form_no : code
					},
					success: function(result){
						if(result > 0) {
							Swal.fire({
							    icon: 'success',
							    title: 'Success!',
							    text: 'Section Assigned',
							    showConfirmButton: false,
							    timer: 1500
							}).then(() => {
							    location.reload();
							});
						} else {
							Swal.fire({
							    icon: 'error',
							    title: 'Failed!',
							    text: 'Student limit exceeded',
							    confirmButtonText: 'OK'
							});
						}  
					}
				}) 
				
			} else {
				Swal.fire({
				    icon: 'warning',
				    title: 'Required!',
				    text: 'Please select section',
				    confirmButtonText: 'OK'
				});
			}			
		});

		$("#admission_fee_payment_btn").click(function(){
			$('#myAdmissionPaymentModal').modal('show');

			/*let formData = {};

		    // 1️⃣ Collect basic inputs
		    $('#admissionPaymentArea').find('input, textarea, select').each(function () {
		        let name = $(this).attr('name');
		        let value = $(this).val();

		        if (name) {
		            formData[name] = value;
		        }
		    });

		    // 2️⃣ Collect Stationary Items (ONLY CHECKED)
		    formData['stationary_items'] = [];
		    $('#itemContainer .item-row-stationary').each(function () {

		        let isChecked = $(this).find('.item_check').is(':checked');

		        if (isChecked) {  // Only add checked rows
		            formData['stationary_items'].push({
		                item_name: $(this).find('.item_name_text').text().trim(),
		                qty: $(this).find('.item_qty').val(),
		                price: $(this).find('.item_price').val(),
		                total: $(this).find('.item_total').val()
		            });
		        }

		    });

		    // 3️⃣ Collect TBLC Items (ONLY CHECKED)
		    formData['tblc_items'] = [];
		    $('#tblcContainer .item-row-tblc').each(function () {

		        let isChecked = $(this).find('.item_check').is(':checked');

		        if (isChecked) { // Only add checked rows
		            formData['tblc_items'].push({
		                item_name: $(this).find('div:nth-child(2)').text().trim(),
		                qty: $(this).find('.item_qty').val(),
		                price: $(this).find('.item_price').val(),
		                total: $(this).find('.item_total').val()
		            });
		        }

		    });

		    // 4️⃣ Grand Totals
		    formData['grand_total_fees'] = $('#grand_total_amount').text().replace('₹', '').trim();
		    formData['stationary_total'] = $('#grandTotal').text().replace('₹', '').trim();
		    formData['tblc_total'] = $('#grandTotal2').text().replace('₹', '').trim();

		    // 5️⃣ Debug check (optional)
		    console.log("FORM DATA =====>", formData);*/

		    let formData = getAdmissionPaymentFormData();
		    console.log("FORM DATA =====>", formData);

		    let paymentAmount = formData.payment_amount || 0;
		    let payeeName = formData.first_name || '';

		    $('input[name="payment_amount"]').val(paymentAmount);
		    $('input[name="payee_name"]').val(payeeName);
		    $('.payment_amount_m').val(paymentAmount);

		    /*$('#myAdmissionPaymentModal').find('input[name="payment_amount"]').val(paymentAmount);
		    $('#myAdmissionPaymentModal').find('.payment_amount_m').each(function () {
		        $('#myAdmissionPaymentModal').text(paymentAmount);
		    });*/
		});

		// payment_cheque_number
		// cheque_number
		// pos_bank_name
		// pos_reference_number

		// sub_pospay
		// sub_chqpay
		// sub_cpay

		function getAdmissionPaymentFormData()
		{
			let formData = {};

		    // 1️⃣ Collect basic inputs
		    $('#admissionPaymentArea').find('input, textarea, select').each(function () {
		        let name = $(this).attr('name');
		        let value = $(this).val();

		        if (name) {
		            formData[name] = value;
		        }
		    });

		    // 2️⃣ Collect Stationary Items (ONLY CHECKED)
		    formData['stationary_items'] = [];
		    $('#itemContainer .item-row-stationary').each(function () {

		        let isChecked = $(this).find('.item_check').is(':checked');

		        if (isChecked) {  // Only add checked rows
		            formData['stationary_items'].push({
		                item_name: $(this).find('.item_name_text').text().trim(),
		                item_id: $(this).find('.item_id').val(),
		                qty: $(this).find('.item_qty').val(),
		                price: $(this).find('.item_price').val(),
		                total: $(this).find('.item_total').val()
		            });
		        }

		    });

		    // 3️⃣ Collect TBLC Items (ONLY CHECKED)
		    formData['tblc_items'] = [];
		    $('#tblcContainer .item-row-tblc').each(function () {

		        let isChecked = $(this).find('.item_check').is(':checked');

		        if (isChecked) { // Only add checked rows
		            formData['tblc_items'].push({
		                item_name: $(this).find('div:nth-child(2)').text().trim(),
		                item_id: $(this).find('.item_id').val(),
		                qty: $(this).find('.item_qty').val(),
		                price: $(this).find('.item_price').val(),
		                total: $(this).find('.item_total').val()
		            });
		        }

		    });

		    // 4️⃣ Grand Totals
		    formData['grand_total_fees'] = $('#grand_total_amount').text().replace('₹', '').trim();
		    formData['stationary_total'] = $('#grandTotal').text().replace('₹', '').trim();
		    formData['tblc_total'] = $('#grandTotal2').text().replace('₹', '').trim();

		    return formData;
		}

		/**
		 * Cash Payment
		 * */
		let baseUrl = '<?=base_url()?>';

		$('#sub_cpay').click(function (e) {
			admissionPayment('cash')
			/*let getChequeNumber = $("#cheque_number").val()
			let getBankName = $("#pos_bank_name").val()
			let getPosReferenceNumber = $("#pos_reference_number").val()

			$("#payment_cheque_number").val(getChequeNumber);
			$("#payment_pos_bank_name").val(getBankName);
			$("#payment_pos_reference_number").val(getPosReferenceNumber);


			Swal.fire({
			    title: "Confirm?",
			    text: "",
			    icon: "warning",
			    showCancelButton: true,
			    confirmButtonText: "Yes",
			    cancelButtonText: "No, Cancel"
			}).then((result) => {
			    if (result.isConfirmed) {
			    	let formData = getAdmissionPaymentFormData();
			    	formData['ad_payment_mode'] = "cash";

			    	$.ajax({
						url:'<?=base_url()?>admin/student/add-admission-payment',
						method: 'post',					
						data: formData,				  
						success: function(data){
							if(data != 0){	
								$('#myAdmissionPaymentModal').modal('hide')

								Swal.fire({
								    icon: 'success',
								    title: 'Success!',
								    text: 'Your Transaction is Successfull.',
								    confirmButtonText: 'OK'
								}).then(() => {
								    // window.location.href = baseUrl + "admin/student/view-fee-structure";
								    window.location.href = baseUrl + "admin/student/student-list";
								});

					
								// $('.cpay_msg').html('<div class="alert alert-block alert-success"><button data-dismiss="alert" class="close" type="button"><i class="ace-icon fa fa-times"></i></button><p><strong><i class="ace-icon fa fa-check"></i>Success</strong>Your Transaction is Successfull. </p></div>');
								
								// setTimeout(function(){
								// 	var t = confirm("Want to Assign TBLC items?");
								// 	if ( t == true ) {
								// 		$.ajax({
								// 			url:'<?=base_url()?>student/asign_tblc_item',
								// 			method: 'post',					
								// 			data: {code : data},
								// 			success: function(result){
								// 				window.location.href = base_url+'student/student_list/'+data;
								// 			}
								// 		})
								// 		window.location.href = base_url+'student/student_list/'+data;
								// 	} else {
								// 		window.location.href = base_url+'student/view_fee_structure/'+data;
								// 	}									
								// }, 1100);
								
							} else {								
								// $('.cpay_msg').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong><i class="ace-icon fa fa-times"></i> Failed! </strong>Their is an error for this transaction<br></div>');
								Swal.fire({
								    icon: 'error',
								    title: 'Error!',
								    text: 'Failed! Their is an error for this transaction'
								});

							}
						}
					}) 

			    } else {				
					e.preventDefault();
				}
			});	*/	
		});

		$('#sub_chqpay').click(function (e) {
			admissionPayment('cheque')
		});

		$('#sub_pospay').click(function (e) {
			admissionPayment('pos')
		});

		function admissionPayment(paymentMethod='')
		{
			if (paymentMethod === '') {
		        paymentMethod = 'cash';
		    }

			let getChequeNumber = $("#cheque_number").val()
			let getBankName = $("#pos_bank_name").val()
			let getPosReferenceNumber = $("#pos_reference_number").val()

			$("#payment_cheque_number").val(getChequeNumber);
			$("#payment_pos_bank_name").val(getBankName);
			$("#payment_pos_reference_number").val(getPosReferenceNumber);


			Swal.fire({
			    title: "Confirm?",
			    text: "",
			    icon: "warning",
			    showCancelButton: true,
			    confirmButtonText: "Yes",
			    cancelButtonText: "No, Cancel"
			}).then((result) => {
			    if (result.isConfirmed) {
			    	$('#myAdmissionPaymentModal').modal('hide');

			    	let formData = getAdmissionPaymentFormData();
			    	formData['ad_payment_mode'] = paymentMethod;
			    	console.log(formData)

			    	if( paymentMethod == "cheque" ) {
		    		 	if (getChequeNumber === '') {
					        Swal.fire({
					            icon: 'error',
					            title: 'Missing Cheque Number',
					            text: 'Please enter the Cheque Number before submitting.',
					        });
					        return;
					    }
			    	} else if( paymentMethod == "pos" ) {
			    		if (getBankName === '') {
					        Swal.fire({
					            icon: 'error',
					            title: 'Bank Name Required',
					            text: 'Please select a POS bank name!',
					        });
					        return;
					    }

					    if (getPosReferenceNumber === '') {
					        Swal.fire({
					            icon: 'error',
					            title: 'Reference Number Required',
					            text: 'Please enter the POS reference number!',
					        });
					        return;
					    }
			    	}

			    	$.ajax({
						url:'<?=base_url()?>admin/student/add-admission-payment',
						method: 'post',					
						data: formData,				  
						success: function(data){
							console.log(data);
							if(data != 0){	
								// $('#myAdmissionPaymentModal').modal('hide')

								Swal.fire({
								    icon: 'success',
								    title: 'Success!',
								    text: 'Your Transaction is Successfull.',
								    confirmButtonText: 'OK'
								}).then(() => {
								    // window.location.href = baseUrl + "admin/student/view-fee-structure";
								    // window.location.href = baseUrl + "admin/student/student-list/" + data;
								});

					
								// $('.cpay_msg').html('<div class="alert alert-block alert-success"><button data-dismiss="alert" class="close" type="button"><i class="ace-icon fa fa-times"></i></button><p><strong><i class="ace-icon fa fa-check"></i>Success</strong>Your Transaction is Successfull. </p></div>');
								
								// setTimeout(function(){
								// 	var t = confirm("Want to Assign TBLC items?");
								// 	if ( t == true ) {
								// 		$.ajax({
								// 			url:'<?=base_url()?>student/asign_tblc_item',
								// 			method: 'post',					
								// 			data: {code : data},
								// 			success: function(result){
								// 				window.location.href = base_url+'student/student_list/'+data;
								// 			}
								// 		})
								// 		window.location.href = base_url+'student/student_list/'+data;
								// 	} else {
								// 		window.location.href = base_url+'student/view_fee_structure/'+data;
								// 	}									
								// }, 1100);
								
							} else {								
								// $('.cpay_msg').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong><i class="ace-icon fa fa-times"></i> Failed! </strong>Their is an error for this transaction<br></div>');
								Swal.fire({
								    icon: 'error',
								    title: 'Error!',
								    text: 'Failed! Their is an error for this transaction'
								});

							}
						}
					}) 

			    } else {				
					e.preventDefault();
				}
			});
		}
	});

	/**
     * Admission All Fee Price Calculation
     * */ 
    function updateFeeValue(inputId, labelId) {
        let value = parseFloat(document.getElementById(inputId).value) || 0;
        document.getElementById(labelId).innerHTML = "₹" + value;
        calculateFeesGrandTotal();
        calculateFinalAdmissionTotal()
    }

	function calculateFeesGrandTotal() {
	    let total = 0;

	    document.querySelectorAll('.fees_area_js').forEach(function(input) {
	        total += parseFloat(input.value) || 0;
	    });

	    let grandTotalEl = document.getElementById("grand_total_amount");
	    if (grandTotalEl) {
	        grandTotalEl.innerHTML = "₹" + total;
	    }

	    return total;
	}


    // Attach listeners to all inputs
    document.querySelectorAll('.fees_area_js').forEach(function(input) {
        input.addEventListener('input', function () {
            let id = this.id;
            let labelId = id + "_level";
            updateFeeValue(id, labelId);
        });
    });

    // Initial total calculation
    calculateFeesGrandTotal();
    /**
     * End Admission All Fee Price Calculation
     * */ 

    /**
     * Stationary Price Calculation
     * */ 
    function calculateStationaryRowTotal(row) {
        let qty = parseFloat(row.querySelector('.item_qty').value) || 0;
        let price = parseFloat(row.querySelector('.item_price').value) || 0;
        row.querySelector('.item_total').value = (qty * price);
        calculateStationaryGrandTotal();
        calculateFinalAdmissionTotal()
    }

    function calculateStationaryGrandTotal() {
        let rows = document.querySelectorAll('.item-row-stationary');
        let total = 0;

        rows.forEach(row => {
            let checkbox = row.querySelector('.item_check');
            if (checkbox.checked) {
                total += parseFloat(row.querySelector('.item_total').value) || 0;
            }
        });

        document.getElementById('grandTotal').innerText = "₹" + total;
        
        return total;
    }

    document.getElementById('itemContainer').addEventListener('input', function(e) {
        if (e.target.classList.contains('item_qty') || e.target.classList.contains('item_price')) {
            calculateStationaryRowTotal(e.target.closest('.item-row-stationary'));
        }
    });

    document.getElementById('itemContainer').addEventListener('change', function(e) {
        if (e.target.classList.contains('item_check')) {
            calculateStationaryGrandTotal();
            calculateFinalAdmissionTotal();
        }
    });

    // Initial calculation
    calculateStationaryGrandTotal();
    /**
     * End Stationary Price Calculation
     * */ 

    /**
     * Tblc Price Calculation
     * */ 
    function calculateTblcRowTotal(row) {
        let qty = parseFloat(row.querySelector('.item_qty').value) || 0;
        let price = parseFloat(row.querySelector('.item_price').value) || 0;
        row.querySelector('.item_total').value = (qty * price);
        calculateTblcGrandTotal();
        calculateFinalAdmissionTotal();
    }

    function calculateTblcGrandTotal() {
        let rows = document.querySelectorAll('#tblcContainer .item-row-tblc');
        let total = 0;

        rows.forEach(row => {
            let check = row.querySelector('.item_check');

            if (check.checked) {
                total += parseFloat(row.querySelector('.item_total').value) || 0;
            }
        });

        document.getElementById('grandTotal2').innerText = "₹" + total;
        
        return total;
    }

    document.getElementById('tblcContainer').addEventListener('input', function(e) {
        if (e.target.classList.contains('item_qty') || e.target.classList.contains('item_price')) {
            calculateTblcRowTotal(e.target.closest('.item-row-tblc'));
        }
    });

    document.getElementById('tblcContainer').addEventListener('change', function(e) {
        if (e.target.classList.contains('item_check')) {
            calculateTblcGrandTotal();
            calculateFinalAdmissionTotal()
        }
    });

    calculateTblcGrandTotal();
    /**
     * End Tblc Price Calculation
     * */ 

    // let totalAdmissionAmount = calculateTblcGrandTotal() + calculateStationaryGrandTotal() + calculateFeesGrandTotal()
    
    // $("#grandTotalAmount").html("₹" + formatINR(totalAdmissionAmount))
    // $("#payment_amount").val(totalAdmissionAmount)

    // function formatINR(amount) {
	//     return amount.toLocaleString('en-IN');
	// }

	function calculateFinalAdmissionTotal() {
		let stoppageFee = $("#stoppage_fee").length ? (parseInt($("#stoppage_fee").val()) || 0) : 0;
	    let total = stoppageFee 
	    		  + calculateFeesGrandTotal()
	              + calculateStationaryGrandTotal()
	              + calculateTblcGrandTotal();

	    document.getElementById("grandTotalAmount").innerHTML = "₹" + total.toLocaleString('en-IN');
	    $("#payment_amount").val(total)

	    return total;
	}

	calculateFinalAdmissionTotal()
</script>