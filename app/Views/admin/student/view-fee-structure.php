<!-- bootstrap icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>

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

<!-- <div class="content">
	<?php // if( isset($form_details['student_code']) && $form_details['student_code'] == '26-3001' ) { ?> 
		<h5>Test Payment Details</h5>
		<p style="color:red;">
			<b>*Important Note : Additional Bank Charge may be applicable while Pay through CREDIT CARD, NET BANKING & WALLET.</b> <br />
			<b class="red">**Do not close the browser or click back button after clicking "Proceed to pay".</b>
		</p>
		<form method="POST" name="customerData" action="<?php // echo base_url('admin/student/ccavenue-request-test') ?>">
			<input type="hidden" name="session_year_id" value="<?php // echo session()->get('session_year_id');  ?>" />
			<input type="hidden" name="student_code" value="<?php // echo $form_details['student_code']; ?>" />
			<input type="hidden" name="finalPayAmt" value="1" />

			<button type="submit" class="btn btn-primary"> Proceed to pay </button>
		</form>
	<?php // } ?>
</div> -->

<!-- Content area -->
<div class="content">

	<!-- Page length options -->
	<div class="card">
		<div class="card-header">
			<h5 class="mb-0">All <?= $title ?></h5>
		</div>

		<?php 
		$valid = 1;
		if( $form_details['allow_readmission'] == 0 || $form_details['status'] == 0 ){
		  	$valid = 0;
		}
		?>

		<!-- <div class="page-content"> -->
			<?php if($valid == 1){ ?>
				<div class="card-body">
					<div class="row">
						<h6>Student Name :  <?= $form_details['first_name'] ?> (ID :  <?= $code ?>)</h6>
					</div>

					<div class="row">
						<div class="col-sm-4">
							<span class="label label-xlg label-danger"><i class="ace-icon fa fa-exclamation-triangle bigger-120"></i>Due Amount : <i class="bi bi-currency-rupee"></i><?= $student_transaction_details['due_amount'] ?? 0; ?></span> 
						</div>

						<div class="col-sm-4">
							<span class="label label-xlg label-primary"><i class="ace-icon fa fa-check bigger-120"></i> Advanced Amount: <i class="bi bi-currency-rupee"></i><?= $student_transaction_details['advanced_amount'] ?? 0; ?></span>
						</div>
						<div class="col-sm-4">
							<?php 
							if(session()->get('specialadmin_logged_in') == true || session()->get('user_id') == 3632 ){
							    if( !empty($student_stationary_price) && $student_stationary_price['payment_status'] == 1 ){ ?>
									<span data-html="true" data-toggle="tooltip" rel="tooltip" title="Edit Stationary Payment Details" class="btn btn-sm btn-success label-success"><i class="fa fa-pencil-square-o fa-lg" onclick="editStationaryPayment('<?= $code ?>');">  Edit Stationary payment  </i></span>
								<?php }
							} ?>
						</div>
					</div>
				</div>
				
				<div class="clear-fix"></div>
				<div class="row">
					<div class="col-sm-12">
						<table class="table table-bordered" style="width:100%">
							<thead>
								<tr>
									<?php if($apr_mnth_payment['ad_payment_status'] == 1 && $apr_mnth_payment['bus_payment_status'] == 1) {?>
										<th><input id="check_all" type="checkbox" value="" class=""></th>
									<?php }else{ ?>
										<th></th>
									<?php } ?>
									<th>Month</th>								
									<th>Admission Fee</th>
									<th>Session Charges</th>
									<th>Security Deposit</th>
									<th>Tuition Fee (MONTHLY)</th>
									<th>Tuition Fine Amount</th>
									<th>Bus Services</th>
									<th>Bus Fine Amount</th>
									<th>Total Amount</th>
									<th>Status</th>
									<?php if( session()->get('user_id') == 9583 ): ?>
										<th>Change Payment Mode</th>
										<th>Change Bus Payment Mode</th>
									<?php endif; ?>
								</tr>
							</thead>
							<tbody>
								<?php $i=0; // pr($fee_structure); ?>
								<?php foreach ($fee_structure as $fee):  ?>							
									<tr>
										<td>
											<?php if($fee['month_id'] == 4 && $fee['ad_payment_status'] == 1 && $fee['bus_payment_status'] == 1){ ?>
												<input name="check[]" id="<?= $fee['fee_id'] ?>" class="<?= 'id'.$i ?>" value="<?= $fee['fee_id'] ?>" type="checkbox" checked disabled > 
											<?php } elseif($fee['month_id'] == 4 && $fee['ad_payment_status'] == 1 && $fee['bus_services'] == 0 ) { ?>
												<input name="check[]" class="fee_id selected <?= 'id'.$i ?>" value="<?= $fee['fee_id'] ?>" type="checkbox" id="<?= $fee['fee_id'] ?>" checked disabled >
									    	<?php }elseif($fee['ad_payment_status'] == 1 && $fee['bus_payment_status'] == 1){ ?> 
										    	<input name="check[]" id="<?= $fee['fee_id'] ?>" class="selected <?= 'id'.$i ?>" value="<?= $fee['fee_id'] ?>" type="checkbox"   checked disabled> 
										 	<?php } elseif($fee['ad_payment_status'] == 1 && $fee['bus_services'] == 0 ) { ?>
									    		<input name="check[]" class="fee_id selected <?= 'id'.$i ?>" value="<?= $fee['fee_id'] ?>" type="checkbox" id="<?= $fee['fee_id'] ?>" checked disabled>
											<?php  }else{ ?>
											    <input name="check[]" class="fee_id selected <?= 'id'.$i ?>" value="<?= $fee['fee_id'] ?>" type="checkbox" id="<?= $fee['fee_id'] ?>">
											<?php } ?>
										</td>
										<td>
											<?php
												$dateObj = DateTime::createFromFormat('!m', $fee['month_id']);
												echo $monthName = $dateObj->format('F');
											?>
										</td>							
										<td>
											<i class="bi bi-currency-rupee"></i><?= $fee['admission_fee'] ?>
										</td>
										<td>
											<i class="bi bi-currency-rupee"></i><?php echo $fee['development_fee'] + $fee['exam_fee'] + $fee['festival_celebration_fee'] + $fee['games_sports_fee'] + $fee['audio_visual_lab_fee'] + $fee['library_fee'] + $fee['electricity_maintenance_fee'] + $fee['computer_fee']; ?>
										</td>
										<td>
											<i class="bi bi-currency-rupee"></i><?= $fee['security_deposite'] ?>
										</td>
										<td>
											<i class="bi bi-currency-rupee"></i><?= $fee['tuition_fee'] ?>
										</td>
										<!-- 'tuition_fee' => ($student_details_data['academic_status'] == 'Free' ? 0 : $fee_structure['tuition_fee']), -->
										<td>
											<i class="bi bi-currency-rupee"></i><?= $fee['fine'] ?>
										</td>
									 	<td>
									 		<i class="bi bi-currency-rupee"></i> <?= $fee['bus_services'] ?>
									 	</td>
										 
										<td>
											<?php if($fee['bus_fee_fine']){ echo '<i class="bi bi-currency-rupee"></i>'.$fee['bus_fee_fine']; } else { echo '<i class="bi bi-currency-rupee"></i>0'; } ?>
										</td>
										<td>
								        	<i class="bi bi-currency-rupee"></i><?= $fee['bus_fee_fine']+ $fee['bus_services']+$fee['fine']+$fee['admission_fee']+$fee['development_fee']+$fee['exam_fee']+$fee['festival_celebration_fee']+$fee['games_sports_fee']+$fee['audio_visual_lab_fee']+$fee['library_fee']+$fee['electricity_maintenance_fee']+$fee['computer_fee']+$fee['security_deposite']+$fee['tuition_fee'] ?>
								        </td>

										<?php /*if($fee['ad_payment_status'] == 1 && $fee['bus_payment_status'] == 1 && $fee['bus_payment_date'] !='0000-00-00 00:00:00'){ ?>
									        <td>
									        	<i class="bi bi-currency-rupee"></i><?= $fee['bus_fee_fine']+ $fee['bus_services']+$fee['fine']+$fee['admission_fee']+$fee['development_fee']+$fee['exam_fee']+$fee['festival_celebration_fee']+$fee['games_sports_fee']+$fee['audio_visual_lab_fee']+$fee['library_fee']+$fee['electricity_maintenance_fee']+$fee['computer_fee']+$fee['security_deposite']+$fee['tuition_fee'] ?>
									        </td>
										<?php }else{ ?>        
										    <td>
										    	<i class="bi bi-currency-rupee"></i><?= $fee->bus_fee_fine+ $fee->bus_services + $fee->fine+$fee->admission_fee+$fee->development_fee+$fee->exam_fee+$fee->festival_celebration_fee+$fee->games_sports_fee+$fee->audio_visual_lab_fee+$fee->library_fee+$fee->electricity_maintenance_fee+$fee->computer_fee+$fee->security_deposite+$fee->tuition_fee ?>
										    </td>
										<?php }*/ ?>
										
									    <?php if($fee['ad_payment_status'] == 1 && $fee['bus_payment_status'] == 1 && $fee['bus_services'] != 0 ){ ?>
										    <td style="width: 14%;">
										    	<a title="Payment Details" class="btn btn-sm btn-info label-success mt-1" href="javascript:void(0);" >
								                    <i class="bi bi-info-circle"></i>
								                </a>
								                <?php if( $fee['month_id'] == 4 ) { ?>
									                <a title="Print Invoice Fee" class="btn btn-sm btn-info label-success mt-1" href="javascript:void(0);" onclick="four_month_invoice_fee('<?= $fee['form_no'] ?>', <?= $fee['fee_id'] ?>, '<?= $code ?>', '<?= $form_details['student_id'] ?? ''; ?>');">
									                    <i class="bi bi-printer-fill"></i>  &nbsp;Paid
									                </a>
								                <?php } else { ?>
								                	<a title="Print Invoice Fee" class="btn btn-sm btn-info label-success mt-1" href="javascript:void(0);" onclick="invoice_item('<?= $fee['form_no'] ?>', <?= $fee['fee_id'] ?>, '<?= $code ?>', '<?= $form_details['student_id'] ?? ''; ?>');">
									                    <i class="bi bi-printer-fill"></i>  &nbsp;Paid
									                </a>
								                <?php } ?>
								                <a title="Bus Payment Details" class="btn btn-sm btn-info label-success mt-1" href="javascript:void(0);" >
								                    <i class="bi bi-info-circle"></i>
								                </a>
								                <a title="Print Invoice Fee" class="btn btn-sm btn-info label-success mt-1" href="javascript:void(0);"onclick="invoice_bus_item('<?= $fee['form_no'] ?>', <?= $fee['fee_id'] ?>, '<?= $code ?>');">
								                    <i class="bi bi-printer-fill"></i>&nbsp;Bus Paid
								                </a>
												<?php if((session()->get('specialadmin_logged_in') == true) || (session()->get('user_id') ==3632 )){ ?>
													<span data-html="true" data-toggle="tooltip" rel="tooltip" title="Edit Payment Details" class="btn btn-sm btn-warning label-success"><i class="bi bi-pencil-square" onclick="editPayment(<?= $fee['fee_id'] ?>, '<?= $code ?>');"></i></span>
												<?php } ?>
											</td>
									    <?php } elseif($fee['ad_payment_status'] == 1 && $fee['bus_services'] == 0 ) { ?>
									    	<?php 
									    	$tooltip = '<strong>Payment Details</strong><br>';
											$tooltip .= 'Payment Mode : ' . ucfirst($fee['ad_payment_mode']) . '<br>';
											$tooltip .= 'Amount : ' . number_format($fee['payment_amount'], 2) . '<br>';
											if (!empty($fee['pos_reference_number'])) {
											    $tooltip .= 'POS Details : ' . esc($fee['pos_reference_number']) . '<br>';
											}
											$tooltip .= 'Payment Date : ' . date('F j, Y', strtotime($fee['created_date']));
									    	?>
										    <td style="width: 14%;">
										    	<a 
											    	title="Payment Details" 
											    	class="btn btn-sm btn-info label-success mt-1" 
											    	href="javascript:void(0);" 
											    	data-bs-toggle="tooltip"
												    data-bs-placement="left"
												    data-bs-html="true"
												    data-bs-title="<?= esc($tooltip) ?>"
											    >
								                    <i class="bi bi-info-circle"></i>
								                </a>
								                <?php if( $fee['month_id'] == 4 ) { ?>
									                <a title="Print Invoice Fee" class="btn btn-sm btn-info label-success mt-1" href="javascript:void(0);" onclick="four_month_invoice_fee('<?= $fee['form_no'] ?>', <?= $fee['fee_id'] ?>, '<?= $code ?>', '<?= $form_details['student_id'] ?? ''; ?>');">
									                    <i class="bi bi-printer-fill"></i>  &nbsp;Paid
									                </a>
								               <?php } else { ?>
								               		<a title="Print Invoice Fee" class="btn btn-sm btn-info label-success mt-1" href="javascript:void(0);" onclick="invoice_item('<?= $fee['form_no'] ?>', <?= $fee['fee_id'] ?>, '<?= $code ?>', '<?= $form_details['student_id'] ?? ''; ?>');">
									                    <i class="bi bi-printer-fill"></i>  &nbsp;Paid
									                </a>
								               	<?php } ?>

								               	<?php if( $fee['bus_services'] == 1 ) { ?>
									                <a title="Bus Payment Details" class="btn btn-sm btn-info label-success mt-1" href="javascript:void(0);" >
									                    <i class="bi bi-info-circle"></i>
									                </a>
									                <a title="Print Bus Invoice Fee" class="btn btn-sm btn-info label-success mt-1" href="javascript:void(0);"onclick="invoice_bus_item('<?= $fee['form_no'] ?>', <?= $fee['fee_id'] ?>, '<?= $code ?>');">
									                    <i class="bi bi-printer-fill"></i>&nbsp;Bus Paid
									                </a>
									            <?php } ?>

												
												<?php if((session()->get('specialadmin_logged_in') == true) || (session()->get('user_id') ==3632 )){ ?>
													<span data-html="true" data-toggle="tooltip" rel="tooltip" title="Edit Payment Details" class="btn btn-sm btn-warning label-success"><i class="fa fa-pencil" onclick="editPayment(<?= $fee['fee_id'] ?>, '<?= $code ?>');"></i></span>
												<?php } ?>
											</td>
									    <?php }else{ 
											if($fee['bus_services'] >0){
												if($fee['bus_payment_status'] == 0){
													$bus = 'Bus';
												}else{
													$bus = '';
												}										
											}else {
												$bus = '';
											}
											
											if($fee['ad_payment_status'] == 0){
												$tuition = 'Tuition';
											}else{
												$tuition = '';
											} ?>
		    								<td>
		    									<span class="btn-sm btn btn-danger test <?= $tuition ?> <?= $bus ?>"><?php echo $tuition .' '. ($fee['bus_services'] > 0 ? ' '.$bus : ''); ?> Fee Due</span>
		    								
			    								<?php if(session()->get('specialadmin_logged_in') == true){ ?>
			    									<span data-html="true" data-toggle="tooltip" rel="tooltip" title="Edit Payment Details" class="btn btn-sm btn-warning label-success"><i class="fa fa-pencil" onclick="editPayment(<?= $fee['fee_id'] ?>, '<?= $code ?>');"></i></span>
			    								<?php } ?>
											</td>
										<?php } ?>

										<?php if( session()->get('user_id') == 9583 ): // || session()->get('user_id') == 9584 -> This id is used by sayan for code test ?>
											<td>
												<?php if( $fee['ad_payment_status'] == 1 ): ?>
													<div class="form-check-horizontal">
														<label class="form-check form-switch mb-0">
															<?php 
															$checkedPaymentModeTextUpdated = '';
															if (isset($fee['ad_payment_mode']) && str_ends_with($fee['ad_payment_mode'], '.')) {
															    $checkedPaymentModeTextUpdated = 'checked';
															}
															?>
															<input type="checkbox" class="change-fees-payment-mode form-check-input" data-admission-payment-mode="<?= $fee['ad_payment_mode'] ?>" data-id="<?= $fee['id'] ?>" <?= $checkedPaymentModeTextUpdated ?> title="Change Fees Payment Mode" />
														</label>
													</div>
												<?php endif; ?>
											</td>
											<td>
												<?php if( $fee['bus_payment_status'] == 1 ): ?>
													<div class="form-check-horizontal">
														<label class="form-check form-switch mb-0">
															<?php 
															$checkedBusPaymentModeTextUpdated = '';
															if (isset($fee['bus_payment_mode']) && str_ends_with($fee['bus_payment_mode'], '.')) {
															    $checkedBusPaymentModeTextUpdated = 'checked';
															}
															?>
															<input type="checkbox" class="change-bus-payment-mode form-check-input" data-bus-payment-mode="<?= $fee['bus_payment_mode'] ?>" data-id="<?= $fee['id'] ?>" <?= $checkedBusPaymentModeTextUpdated ?> title="Change Bus Payment Mode" />
														</label>
													</div>
												<?php endif; ?>
											</td>
										<?php endif; ?>
									</tr>
									<?php $i++; ?>
								<?php endforeach; ?>
							</tbody>
						</table>
						<div style="margin: 30px;">
							<?php if(($fee_structure[0]['session_year_id'] == session()->get('session_year_id')) && ($fee_structure[0]['student_code'] == session()->get('code')) && ($fee_structure[0]['month_id'] == 4) && ($fee_structure[0]['ad_payment_status'] ==1)) {?>
								<button type="button" id="payFee" class="btn btn-primary mb-15" data-toggle="modal" data-target="#myModal">Pay</button>
					    	<?php }elseif(session()->get('admin_logged_in') == 1){ ?>
								<button type="button" id="payFee" class="btn btn-primary mb-15" data-toggle="modal" data-target="#myModal">Pay</button>
							<?php }else{
								$url = session()->get('student_logged_in') ? base_url('admin/student/collect-re-admission-fee/' . $fee_structure[0]['student_code']) : base_url('admin/student/collect-admission-fee/' . $fee_structure[0]['student_code']); ?>
								<a class="btn btn-danger" href="<?= $url ?>">Please Pay Re-enrolment Fees First</a>
							<?php } ?>

							<?php if(session()->get('student_logged_in') == false){ ?>
								<button type="button" class="btn btn-info mb-15" data-toggle="modal" data-target="#myModal1">Consideration </button>
							<?php } ?>
						</div>









						<div id="payFeesMyModal" class="modal fade show" tabindex="-1" aria-modal="true" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title"><?= (session()->get('student_logged_in') == true ? 'Pay':'Collect')?> Academic Fees</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
									</div>

									<div class="modal-body">
										<ul class="nav nav-tabs" id="modalTabs" role="tablist">
											<?php if(session()->get('student_logged_in') == true){ ?>
												<?php if(get_config_value_by_key('online_payment_mode') != 0) { ?>
													<li class="nav-item" role="presentation">
								                        <button class="nav-link" id="online-tab" data-bs-toggle="tab" data-bs-target="#onlinePayment" type="button" role="tab" aria-controls="online" aria-selected="false">
								                            Online Payment
								                        </button>
								                    </li>
												<?php } else { ?>
													<div class="alert alert-warning">
														<button type="button" class="close" data-dismiss="alert">
															<i class="ace-icon fa fa-times"></i>
														</button>
														<strong>Disabled!</strong>Online Payment mode is disabled.
														<br>
													</div>
												<?php } ?>
											<?php }else{ ?>
												<li class="nav-item" role="presentation">
							                        <button class="nav-link active" id="cash-tab" data-bs-toggle="tab" data-bs-target="#home4" type="button" role="tab" aria-controls="details" aria-selected="true">
							                            Cash
							                        </button>
							                    </li>
							                    <li class="nav-item" role="presentation">
							                        <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#profile4" type="button" role="tab" aria-controls="specs" aria-selected="false">
							                            Cheque / QR/UPI
							                        </button>
							                    </li>
							                    <li class="nav-item" role="presentation">
							                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#dropdown14" type="button" role="tab" aria-controls="reviews" aria-selected="false">
							                            POS / CARD
							                        </button>
							                    </li>
							                    <?php if(get_config_value_by_key('online_payment_mode') != 0) { ?>
								                    <li class="nav-item" role="presentation">
								                        <button class="nav-link" id="online-tab" data-bs-toggle="tab" data-bs-target="#onlinePayment" type="button" role="tab" aria-controls="online" aria-selected="false">
								                            Online Payment
								                        </button>
								                    </li>
								                <?php } ?>

											<?php } ?>
										</ul>

						                <!-- Tab Content -->
						                <div class="tab-content modal-tab-content" id="modalTabsContent">
						                	<?php if(session()->get('student_logged_in') == true){ ?>
												<?php if(get_config_value_by_key('online_payment_mode') !=0) { ?>
													<!--online payment start-->
													<div class="tab-pane fade show active" id="profile5" role="tabpanel" aria-labelledby="details-tab">
														<form class="form-horizontal" role="form" id="onlinepay" autocomplete="off" method="post" action="<?= base_url('admin/student/ccavenue-request') ?>">
															<p class="cpay_msg"></p>
															<div class="form-group row mb-2">
																<label  class="col-sm-4 control-label" for=""> Tution Fine Amount </label>
																<div class="col-sm-8">
																	<input type="hidden" class="form-control" name="fine" value=""  />
																	<input type="text" class="form-control fine_m" value="" disabled />
																</div>
															</div>
															<div class="form-group row mb-2">
																<label  class="col-sm-4 control-label" for=""> Bus Fine Amount </label>
																<div class="col-sm-8">
																	<input type="hidden" class="form-control" name="bus_fee_fine" value="" />
																	<input type="text" class="form-control bus_fee_fine_m" value="" disabled />
																</div>
															</div>
															<div class="form-group row mb-2">
																<label  class="col-sm-4 control-label" for=""> Advanced Amount </label>
																<div class="col-sm-8">
																	<input type="text" class="form-control adv_amount"  placeholder="Advance Amount" value="" disabled />
																	<input type="hidden" class="adv_amount" name="adv_amount" value=""/>
																</div>
															</div>
															<div class="form-group row mb-2">
																<label  class="col-sm-4 control-label" for=""> Due Amount </label>
																<div class="col-sm-8">
																	<input type="text" class="form-control due_amount"  placeholder="Due Amount" value="" disabled />
																</div>
															</div>
															<div class="form-group row mb-2">
																<label  class="col-sm-4 control-label" for=""> Cash Amount </label>
																<div class="col-sm-8">
																	<input type="hidden" class="form-control" name="payment_amount"  value="" />
																	<input type="text" class="form-control payment_amount_m"  placeholder="Cash Amount" value="" disabled />
																</div>
															</div>
															<div class="form-group row mb-2">
																<label  class="col-sm-4 control-label" for=""> Payee Name </label>
																<div class="col-sm-8">
																	<input data-validation="required" data-validation-error-msg-required="Enter payee name" type="text" class="form-control" name="payee_name" placeholder="Payee Name" value="<?= $form_details['first_name'] ?? '' ?>" />
																</div>
															</div>
															<input type="hidden" class="ad_payment_mode" name="ad_payment_mode" value="CCAvenue"/>
															<input type="hidden" class="ad_payment_status" name="ad_payment_status" value="1"/>
															<input type="hidden" class="bus_payment_status" name="bus_payment_status" value="1"/>
															<input type="hidden" class="t_user_id" name="t_user_id" value="<?= session()->get('user_id') ?>"/>
															<input type="hidden" class="bus_payment_date" name="bus_payment_date" value="<?= date('Y-m-d') ?>"/>
															<input type="hidden" class="added_by" name="added_by" value="<?= session()->get('f_name')?>"/>
															<input type="hidden" class="sCode" name="sCode" value="<?php echo $code; ?>"/>
															<input type="hidden" class="selId" name="selId" id="selId" value=""/>
															<input type="hidden" class="value" name="value" id="value" value=""/>

															<div class="form-group row mb-2">
																<p style="color:red;">
																	<b>*Important Note : Additional Bank Charge may be applicable while Pay through CREDIT CARD, NET BANKING &amp; WALLET.</b> <br>
																	<b class="red">**Do not close the browser or click back button after clicking "Proceed to pay".</b>
																</p>
															</div>

															<div class="form-group row mb-2">
																<div class="col-sm-offset-2 col-sm-10">
																	<button type="button" class="btn btn-primary" id="sub_onlinepay"> Proceed to pay </button>
																</div>
															</div>
														</form>
													</div>
													<!--online payment end-->
												<?php } else { ?>
													<div class="alert alert-warning">
														<button type="button" class="close" data-dismiss="alert">
															<i class="ace-icon fa fa-times"></i>
														</button>
														<strong></strong>Kindly contact to school.
														<br>
													</div>
												<?php } ?>
										
											<?php }else{ ?>
												<div class="tab-pane fade show active" id="home4" role="tabpanel" aria-labelledby="cash-tab">
													<!-- <div id="home4" class="tab-pane active col-md-12"> -->
													<form class="form-horizontal" role="form" id="cpay" autocomplete="off">
														<p class="cpay_msg"></p>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Tution Fine Amount </label>
															<div class="col-sm-8">
																<input type="hidden" class="form-control" name="fine" value=""  />
																<input type="text" class="form-control fine_m" value="" disabled />
															</div>
														</div>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Bus Fine Amount </label>
															<div class="col-sm-8">
																<input type="hidden" class="form-control" name="bus_fee_fine" value="" />
																<input type="text" class="form-control bus_fee_fine_m" value="" disabled />
															</div>
														</div>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Advanced Amount </label>
															<div class="col-sm-8">
																<input type="text" class="form-control adv_amount"  placeholder="Advance Amount" value="" disabled />
																<input type="hidden" class="adv_amount" name="adv_amount" value=""/>
															</div>
														</div>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Due Amount </label>
															<div class="col-sm-8">
																<input type="text" class="form-control due_amount"  placeholder="Due Amount" value="" disabled />
															</div>
														</div>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Cash Amount </label>
															<div class="col-sm-8">
																<input type="hidden" class="form-control" name="payment_amount"  value="" />
																<input type="text" class="form-control payment_amount_m"  placeholder="Cash Amount" value="" disabled />
															</div>
														</div>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Payee Name </label>
															<div class="col-sm-8">
																<input data-validation="required" data-validation-error-msg-required="Enter payee name" type="text" class="form-control" name="payee_name" placeholder="Payee Name" value="<?= $form_details['first_name'] ?? '' ?>" />
															</div>
														</div>
														<input type="hidden" class="ad_payment_mode" name="ad_payment_mode" value="cash"/>
														<input type="hidden" class="ad_payment_status" name="ad_payment_status" value="1"/>
														<input type="hidden" class="bus_payment_status" name="bus_payment_status" value="1"/>
														<input type="hidden" class="t_user_id" name="t_user_id" value="<?= session()->get('user_id') ?>"/>
														<input type="hidden" class="bus_payment_date" name="bus_payment_date" value="<?= date('Y-m-d') ?>"/>
														<input type="hidden" class="added_by" name="added_by" value="<?= session()->get('f_name')?>"/>
														<div class="form-group row mb-2">
															<div class="col-sm-offset-2 col-sm-10">
																<button type="button" class="btn btn-primary" id="sub_cpay">Save</button>
															</div>
														</div>
													</form>
												</div>

												<div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="specs-tab">
													<!-- <div id="profile4" class="tab-pane"> -->
													<form class="form-horizontal" role="form" id="chqpay" autocomplete="off">
														<p class="chqpay_msg"></p>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Tution Fine Amount </label>
															<div class="col-sm-8">
																<input type="hidden" class="form-control" name="fine" value=""  />
																<input type="text" class="form-control fine_m" value="" disabled />
															</div>
														</div>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Bus Fine Amount </label>
															<div class="col-sm-8">
																<input type="hidden" class="form-control" name="bus_fee_fine" value="" />
																<input type="text" class="form-control bus_fee_fine_m" value="" disabled />
															</div>
														</div>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Advanced Amount </label>
															<div class="col-sm-8">
																<input type="text" class="form-control adv_amount"  placeholder="Advance Amount" value="" disabled />
																<input type="hidden" class="adv_amount" name="adv_amount" value=""/>
															</div>
														</div>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Due Amount </label>
															<div class="col-sm-8">
																<input type="text" class="form-control due_amount"  placeholder="Due Amount" value="" disabled />
															</div>
														</div>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Cheque Amount </label>
															<div class="col-sm-8">
																<input type="hidden" class="form-control" name="payment_amount"  value="" />
																<input type="text" class="form-control payment_amount_m"  placeholder="Cheque Amount" value="" disabled />
															</div>
														</div>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Payee Name </label>
															<div class="col-sm-8">
																<input type="text" class="form-control" name="payee_name" placeholder="Payee Name" value="<?= $form_details['first_name'] ?? '' ?>" />
															</div>
														</div>													
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Cheque No. </label>
															<div class="col-sm-8">
																<input type="text" class="form-control" name="cheque_number" placeholder="Cheque No"/>
															</div>
														</div>
														<input type="hidden" class="ad_payment_mode" name="ad_payment_mode" value="cheque"/>
														<input type="hidden" class="ad_payment_status" name="ad_payment_status" value="1"/>
														<input type="hidden" class="bus_payment_status" name="bus_payment_status" value="1"/>
														<input type="hidden" class="t_user_id" name="t_user_id" value="<?= session()->get('user_id')?>"/>
														<input type="hidden" class="added_by" name="added_by" value="<?= session()->get('f_name')?>"/>
														<button type="button" class="btn btn-primary" id="sub_chqpay">Save</button>
													</form>
												</div>

												<div class="tab-pane fade" id="dropdown14" role="tabpanel" aria-labelledby="reviews-tab">
													<!-- <div id="dropdown14" class="tab-pane"> -->
													<form class="form-horizontal" role="form" id="pospay" autocomplete="off">
														<p class="pospay_msg"></p>
														<div class="form-group row mb-2">
															<label class="col-sm-4 control-label" for=""> POS Bank Name </label>
															<div class="col-sm-8">
																<select class="form-select" name="pos_bank_name">										
																	<option value="HDFC" selected>HDFC</option>
																	<option value="BOB">BOB</option>
																	<option value="SBI">SBI</option>
																	<option value="AXIS">AXIS</option>
																</select>																		
															</div>
														</div>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Tution Fine Amount </label>
															<div class="col-sm-8">
																<input type="hidden" class="form-control" name="fine" value=""  />
																<input type="text" class="form-control fine_m" value="" disabled />
															</div>
														</div>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Bus Fine Amount </label>
															<div class="col-sm-8">
																<input type="hidden" class="form-control" name="bus_fee_fine" value="" />
																<input type="text" class="form-control bus_fee_fine_m" value="" disabled />
															</div>
														</div>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Advanced Amount </label>
															<div class="col-sm-8">
																<input type="text" class="form-control adv_amount"  placeholder="Advance Amount" value="" disabled />
																<input type="hidden" class="adv_amount" name="adv_amount" value=""/>
															</div>
														</div>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Due Amount </label>
															<div class="col-sm-8">
																<input type="text" class="form-control due_amount"  placeholder="Due Amount" value="" disabled />
															</div>
														</div>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> POS Amount </label>
															<div class="col-sm-8">
																<input type="hidden" class="form-control" name="payment_amount"  value="" />
																<input type="text" class="form-control payment_amount_m"  placeholder="POS Amount" value="" disabled />
															</div>
														</div>													
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Reference Number </label>
															<div class="col-sm-8">
																<input type="text" class="form-control" name="pos_reference_number" placeholder="POS Referance Number"/>
															</div>
														</div>
														<div class="form-group row mb-2">
															<label  class="col-sm-4 control-label" for=""> Payee Name </label>
															<div class="col-sm-8">
																<input type="text" class="form-control" name="payee_name" placeholder="Payee Name" value="<?= $form_details['first_name'] ?? '' ?>" />
															</div>
														</div>
														<input type="hidden" class="ad_payment_status" name="ad_payment_status" value="1"/>
														<input type="hidden" class="bus_payment_status" name="bus_payment_status" value="1"/>
														<input type="hidden" class="t_user_id" name="t_user_id" value="<?= session()->get('user_id')?>"/>
														<input type="hidden" class="added_by" name="added_by" value="<?= session()->get('f_name')?>"/>
														<input type="hidden" class="ad_payment_mode" name="ad_payment_mode" value="pos"/>
														<button type="button" class="btn btn-primary" id="sub_pospay">Save</button>
													</form>
												</div>

												<div class="tab-pane fade" id="onlinePayment" role="tabpanel" aria-labelledby="online-tab">
													<?php // if( isset($form_details['student_code']) && $form_details['student_code'] == '26-3001' ) { // This is for test ?> 
														<form class="form-horizontal" role="form" id="onlinepay" autocomplete="off" method="post" action="<?= base_url('admin/student/ccavenue-request') ?>">
															<p class="cpay_msg"></p>
															<div class="form-group row mb-2">
																<label  class="col-sm-4 control-label" for=""> Tution Fine Amount </label>
																<div class="col-sm-8">
																	<input type="hidden" class="form-control" name="fine" value=""  />
																	<input type="text" class="form-control fine_m" value="" disabled />
																</div>
															</div>
															<div class="form-group row mb-2">
																<label  class="col-sm-4 control-label" for=""> Bus Fine Amount </label>
																<div class="col-sm-8">
																	<input type="hidden" class="form-control" name="bus_fee_fine" value="" />
																	<input type="text" class="form-control bus_fee_fine_m" value="" disabled />
																</div>
															</div>
															<div class="form-group row mb-2">
																<label  class="col-sm-4 control-label" for=""> Advanced Amount </label>
																<div class="col-sm-8">
																	<input type="text" class="form-control adv_amount"  placeholder="Advance Amount" value="" disabled />
																	<input type="hidden" class="adv_amount" name="adv_amount" value=""/>
																</div>
															</div>
															<div class="form-group row mb-2">
																<label  class="col-sm-4 control-label" for=""> Due Amount </label>
																<div class="col-sm-8">
																	<input type="text" class="form-control due_amount"  placeholder="Due Amount" value="" disabled />
																</div>
															</div>
															<div class="form-group row mb-2">
																<label  class="col-sm-4 control-label" for=""> Cash Amount </label>
																<div class="col-sm-8">
																	<input type="hidden" class="form-control" name="payment_amount"  value="" />
																	<input type="text" class="form-control payment_amount_m"  placeholder="Cash Amount" value="" disabled />
																</div>
															</div>
															<div class="form-group row mb-2">
																<label  class="col-sm-4 control-label" for=""> Payee Name </label>
																<div class="col-sm-8">
																	<input data-validation="required" data-validation-error-msg-required="Enter payee name" type="text" class="form-control" name="payee_name" placeholder="Payee Name" value="<?= $form_details['first_name'] ?? '' ?>" />
																</div>
															</div>
															<input type="hidden" class="ad_payment_mode" name="ad_payment_mode" value="CCAvenue"/>
															<input type="hidden" class="ad_payment_status" name="ad_payment_status" value="1"/>
															<input type="hidden" class="bus_payment_status" name="bus_payment_status" value="1"/>
															<input type="hidden" class="t_user_id" name="t_user_id" value="<?= session()->get('user_id') ?>"/>
															<input type="hidden" class="bus_payment_date" name="bus_payment_date" value="<?= date('Y-m-d') ?>"/>
															<input type="hidden" class="added_by" name="added_by" value="<?= session()->get('f_name')?>"/>
															<input type="hidden" class="sCode" name="sCode" value="<?php echo $code; ?>"/>
															<input type="hidden" class="selId" name="selId" id="selId" value=""/>
															<input type="hidden" class="value" name="value" id="value" value=""/>

															<div class="form-group row mb-2">
																<p style="color:red;">
																	<b>*Important Note : Additional Bank Charge may be applicable while Pay through CREDIT CARD, NET BANKING &amp; WALLET.</b> <br>
																	<b class="red">**Do not close the browser or click back button after clicking "Proceed to pay".</b>
																</p>
															</div>

															<div class="form-group row mb-2">
																<div class="col-sm-offset-2 col-sm-10">
																	<button type="button" class="btn btn-primary" id="sub_onlinepay"> Proceed to pay </button>
																</div>
															</div>
														</form>
													<?php // } ?>
												</div>
											<?php } ?>
						                    <!-- <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
						                        <h4></h4>
						                        <form class="form-horizontal" role="form" id="cpay" autocomplete="off">
													<p class="cpay_msg"></p>
													

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
													

													<button type="button" class="btn btn-primary" id="sub_chqpay">Save</button>
												</form>
						                    </div>
						                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
						                        <h4></h4>
						                        <form class="form-horizontal" role="form" id="pospay" autocomplete="off">
													<p class="pospay_msg"></p>
													

													<button type="button" class="btn btn-primary" id="sub_pospay">Save</button>
												</form>
						                    </div> -->
						                </div>
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>


						<!-- Print Paid Fee Modal -->
						<div id="itemInvModal" class="modal fade show" tabindex="-1" aria-modal="true" role="dialog">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Student Fees Payment invoice</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
									</div>

									<div class="modal-body">
										<div class="row">
											<div class="col-xs-12">
												<div class="row">
													<div class="col-sm-12 col-sm-offset-1">
														<div class="widget-box transparent" id="item_data"></div>
													</div>
												</div>
											</div><!-- /.col -->
										</div>
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" id="fee_items">Print</button>
									</div>
								</div>
							</div>
						</div>
						<!-- Print Paid Fee Modal end -->



					</div>
					<input type="hidden" name="final_adv_amount" class="final_adv_amount" value="" />
					<input type="hidden" name="final_due_amount" class="final_due_amount" value="" />
				</div>
			<?php } else { ?>
			    <div class="row">
    				<div class="alert alert-info">
    					<div class="text-center"><h3><u>Information</u></h3></div>
    					<p style="font-size: 15px;color: #DD5A43;font-weight: bold;" class="text-center">Contact to office</p>
    				</div>
				</div>
			<?php  }  ?>
		<!-- </div> -->

	</div>
</div>

<script>
	$(document).ready(function() {
	    $('#payFee').on('click', function() {
	    	var getSelectedMonth = [];

			$(".selected:checked:not(:disabled)").each(function () {
			    getSelectedMonth.push($(this).val());
			});

			if (getSelectedMonth.length === 0) {
				Swal.fire({
		            icon: 'warning',
		            title: '',
		            text: 'Please select at least one month',
		        });
			    return false;
			}

	        $('#payFeesMyModal').modal('show');
	    });

	    $("#fee_items").click(function(){
			$("#item_data").print();
		});

		// Global Selected Item checbox checked
	    var selectedArr = [];
		var ithElem = $('.id0').is(":checked");
		console.log("ithElem");
		console.log(ithElem);

		// If first month payment is not done then this ajax willbe called
		if(!ithElem) {
			selectedArr.push(parseInt($('.id0').val()));
			
			$('.id0').prop('checked', true);
			console.log("selectedArr");
			console.log(selectedArr);
			// admin/student/fee-amount-for-selected-month
			$.ajax({
				url:'<?=base_url()?>admin/student/fee-amount-for-selected-month',
				method: 'post',					
				data: {sCode : '<?php echo $code; ?>',ids : [$('.id0').val()]},
				success: function(data){
					var data =  $.parseJSON( data );
					console.log(data);
					if(data){								
						$('input[name="payment_amount"]').val(data.totalCalamount);
						$('input[name="fine"]').val(data.tuition_fine);
						$('input[name="bus_fee_fine"]').val(data.bus_fine);
						
						$('.payment_amount_m').val(data.totalCalamount);
						$('.fine_m').val(data.tuition_fine);
						$('.bus_fee_fine_m').val(data.bus_fine);
						
						$('.due_amount').val(data.due_amount);
						$('.adv_amount').val(data.adv_amount);
						$('.final_adv_amount').val(data.final_adv_amount);
						$('.final_due_amount').val(data.final_due_amount);
					} else {								
						Swal.fire({
				            icon: 'warning',
				            title: '',
				            text: 'No Amount Found',
				        });
					}
				}
			});
		}

	    // Checkbox check 
	    $(".selected").on("click", function(e){
	    	let selectedId = parseInt(this.id);
			let immePrevElemId = parseInt(this.id)-1;
			let isImmePrevElemChecked = $("#"+immePrevElemId).is(":checked");
			let isSelectedElemChecked = $("#"+selectedId).is(":checked");

			// console.log(selectedId)
			// console.log(immePrevElemId)
			// console.log(isImmePrevElemChecked)
			// console.log(isSelectedElemChecked)

			if (isSelectedElemChecked) {
			    if (!isImmePrevElemChecked) {
			        Swal.fire({
			            icon: 'warning',
			            title: 'Month Selection Error',
			            text: 'Select month in sequence',
			        });
			        e.preventDefault();
			    } else {
			        selectedArr.push(parseInt(this.id));
			    }
			} else {
			    let uncheckIndex = selectedArr.indexOf(selectedId);
			    selectedArrLength = selectedArr.length;

			    for (var i = uncheckIndex; i <= selectedArrLength; i++) {
			        $('#' + selectedArr[uncheckIndex]).prop('checked', isSelectedElemChecked);
			        selectedArr.splice(uncheckIndex, 1);
			    }

			    Swal.fire({
			        icon: 'error',
			        title: 'Invalid Action',
			        text: 'Cant skip month',
			    });
			}

			if(selectedArr.length > 0){
				// console.log(selectedArr)
				$('input[name="feeID"]').val(selectedArr); // Not understand why this is added, needs to check

				$.ajax({
					url:'<?=base_url()?>admin/student/fee-amount-for-selected-month',
					method: 'post',					
					data: {sCode : '<?php echo $code; ?>',ids : selectedArr},
					success: function(data){
						var data =  $.parseJSON( data );
						console.log(data);
						if(data){
							$('input[name="payment_amount"]').val(data.totalCalamount);
							$('input[name="fine"]').val(data.tuition_fine);
							$('input[name="bus_fee_fine"]').val(data.bus_fine);
							
							$('.payment_amount_m').val(data.totalCalamount);
							$('.fine_m').val(data.tuition_fine);
							$('.bus_fee_fine_m').val(data.bus_fine);
							
							$('.due_amount').val(data.due_amount);
							$('.adv_amount').val(data.adv_amount);
							$('.final_adv_amount').val(data.final_adv_amount);
							$('.final_due_amount').val(data.final_due_amount);
							
						} else {								
							Swal.fire({
							    title: "No Amount Found",
							    icon: "warning",
							    confirmButtonText: "OK"
							});
						}
					}
				});	

			} else {
				$('input[name="payment_amount"]').val("");					
				Swal.fire({
				    icon: 'warning',
				    title: 'No Month Selected',
				    text: 'Please at least check one of the checkbox',
				    confirmButtonText: 'OK'
				});			
			}

	    });

	    $('#check_all').click(function() {
			var isChecked = $(this).is(":checked");
		
			if(isChecked){
				$('.fee_id').each(function(){
					$('.fee_id').prop('checked', true);	
					selectedArr.push(parseInt($(this).val()));							
				});
				
				if(selectedArr.length > 0){
					$('input[name="feeID"]').val(selectedArr);					
					$.ajax({
						url:'<?=base_url()?>admin/student/fee-amount-for-selected-month',
						method: 'post',					
						data: {sCode : '<?php echo $code; ?>',ids : selectedArr},
						success: function(data){
							var data =  $.parseJSON( data );
							//console.log(data);
							if(data){
								//alert('Total Amount  '+ data.totalCalamount);
								$('input[name="payment_amount"]').val(data.totalCalamount);
								$('input[name="fine"]').val(data.tuition_fine);
								$('input[name="bus_fee_fine"]').val(data.bus_fine);
								
								$('.payment_amount_m').val(data.totalCalamount);
								$('.fine_m').val(data.tuition_fine);
								$('.bus_fee_fine_m').val(data.bus_fine);
								
								$('.due_amount').val(data.due_amount);
								$('.adv_amount').val(data.adv_amount);
								$('.final_adv_amount').val(data.final_adv_amount);
								$('.final_due_amount').val(data.final_due_amount);
								
							} else {								
								Swal.fire({
						            icon: 'warning',
						            title: '',
						            text: 'No Amount Found',
						        });
							}
						}
					});					
				} else {
					$('input[name="payment_amount"]').val("");					
					Swal.fire({
					    icon: 'warning',
					    title: 'No Month Selected',
					    text: 'Please at least check one of the checkbox',
					    confirmButtonText: 'OK'
					});				
				}			
			}else{
				location.reload();
			}
			
		}); 

		// Cash Payment
		$('#sub_cpay').click(function (e) {
		    e.preventDefault(); // Prevent normal submit

		    var amt = $('#cpay').find('[name="payment_amount"]').val();
		    var payee_name = $('#cpay').find('[name="payee_name"]').val();

		    var final_adv_amount = $('.final_adv_amount').val();
		    var final_due_amount = $('.final_due_amount').val();

		    if(final_adv_amount >= 0){
		        amt = 1;
		    }

		    if (amt > 0 && payee_name) {
		        var chkArray = [];
		        $(".fee_id:checked:not(:disabled)").each(function() {
		            chkArray.push($(this).val());
		        });

		        // 🔥 SweetAlert confirm box instead of confirm()
		        Swal.fire({
		            title: "Are you sure?",
		            text: "Do you want to confirm this payment?",
		            icon: "question",
		            showCancelButton: true,
		            confirmButtonColor: "#3085d6",
		            cancelButtonColor: "#d33",
		            confirmButtonText: "Yes, confirm",
		            cancelButtonText: "Cancel"
		        }).then((result) => {
		            if (result.isConfirmed) {
		                var dataString = $('#cpay').serializeArray();
		                console.log(dataString)
		                $.ajax({
		                    url: '<?= base_url() ?>admin/student/update-admission-payment',
		                    method: 'post',
		                    data: { selId: chkArray, value: dataString, sCode: '<?= $code ?>' },

		                    success: function(data) {
		                        console.log(data);

		                        if (data > 0) {
		                            $.ajax({
		                                url: '<?= base_url() ?>admin/student/update-student-trans-detail',
		                                method: 'post',
		                                data: { adv_amount: final_adv_amount, due_amount: final_due_amount, sCode: '<?= $code ?>', ad_payment_status: 1 },
		                                success: function(result){}
		                            });

		                            $('#payFeesMyModal').modal('hide');

		                            Swal.fire({
		                                title: "Success!",
		                                text: "Your transaction is successful. Transaction ID #" + data,
		                                icon: "success"
		                            }).then(() => {
									    location.reload();
									});
		                        } else {
		                            Swal.fire({
		                                title: "Failed!",
		                                text: "There was an error processing this transaction.",
		                                icon: "error"
		                            });
		                        }
		                    }
		                });
		            }
		        });
		    } else {
		        Swal.fire({
		            title: "Enter All Details",
		            text: "Payment amount and payee name cannot be empty.",
		            icon: "warning"
		        });

		        return false;
		    }
		});


		/*$('#sub_cpay').click(function () {
			var amt = $('#cpay').find('[name="payment_amount"]').val();
			var payee_name = $('#cpay').find('[name="payee_name"]').val();
			var final_adv_amount = $('.final_adv_amount').val();
			var final_due_amount = $('.final_due_amount').val();
			
			if( final_adv_amount >=0 ){
				amt = 1;
			}
			
			if(amt > 0 && payee_name){
				var chkArray = [];
				$(".fee_id:checked").each(function() {
					chkArray.push($(this).val());
				});
				var r = confirm("Confirm?");
				if ( r == true ) {
					var dataString = $('#cpay').serializeArray();
					$.ajax({
						url:'<?= base_url() ?>student/update_admission_payment',
						method: 'post',					
						data: {selId : chkArray,value : dataString,sCode : '<?php echo $code; ?>'},				  
						success: function(data){
							console.log(data);
							if(data > 0){							
								$.ajax({
									url:'<?=base_url()?>student/update_student_trans_detail',
									method: 'post',					
									data: {adv_amount : final_adv_amount, due_amount : final_due_amount, sCode : '<?php echo $code; ?>'},
									success: function(result){
									}
								})

								$('.cpay_msg').html('<div class="alert alert-block alert-success"><button data-dismiss="alert" class="close" type="button"><i class="ace-icon fa fa-times"></i></button><p><strong><i class="ace-icon fa fa-check"></i>Success</strong>Your Transaction is Successfull.Teansaction ID #'+data+'</p></div>');
								
								
							} else {								
								$('.cpay_msg').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong><i class="ace-icon fa fa-times"></i> Failed! </strong>Their is an error for this transaction<br></div>');
							}
						}
					}) 
				} else {				
					e.preventDefault();
				}
			} else {
				//e.preventDefault();
				alert('Enter All Details');
				return false;
			}
		});	*/

		//cheque payment
		$('#sub_chqpay').click(function (e) {
		    e.preventDefault(); // Prevent normal submit

			var amt = $('#chqpay').find('[name="payment_amount"]').val();
			var payee_name = $('#chqpay').find('[name="payee_name"]').val();
			var cheque_number = $('#chqpay').find('[name="cheque_number"]').val();
			
			var final_adv_amount = $('.final_adv_amount').val();
			var final_due_amount = $('.final_due_amount').val();
			
			if(final_adv_amount>0){
				amt = 1;
			}
			
			if(amt > 0 && payee_name && cheque_number){
				
				var chkArray = [];
				$(".fee_id:checked:not(:disabled)").each(function() {
					chkArray.push($(this).val());
				});

				// 🔥 SweetAlert confirm box instead of confirm()
		        Swal.fire({
		            title: "Are you sure?",
		            text: "Do you want to confirm this payment?",
		            icon: "question",
		            showCancelButton: true,
		            confirmButtonColor: "#3085d6",
		            cancelButtonColor: "#d33",
		            confirmButtonText: "Yes, confirm",
		            cancelButtonText: "Cancel"
		        }).then((result) => {
		            if (result.isConfirmed) {
		            	var dataString = $('#chqpay').serializeArray();
						$.ajax({
							url:'<?= base_url() ?>admin/student/update-admission-payment',
							method: 'post',					
							data: {selId : chkArray, value : dataString, sCode : '<?php echo $code; ?>'},				  
							success: function(data){
								console.log(data);
								if(data > 0){
									$.ajax({
										url:'<?=base_url()?>admin/student/update-student-trans-detail',
										method: 'post',					
										data: {adv_amount : final_adv_amount, due_amount : final_due_amount, sCode : '<?php echo $code; ?>', ad_payment_status: 1},
										success: function(result){}
									})
									
									$('#payFeesMyModal').modal('hide');

		                            Swal.fire({
		                                title: "Success!",
		                                text: "Your transaction is successful. Transaction ID #" + data,
		                                icon: "success"
		                            }).then(() => {
									    location.reload();
									});
								} else {								
									Swal.fire({
		                                title: "Failed!",
		                                text: "There was an error processing this transaction.",
		                                icon: "error"
		                            });
								}
							}
						}) 
		            }
		        });
				
				/*var r = confirm("Confirm?");
				if ( r == true ) {
					var dataString = $('#chqpay').serializeArray();
					$.ajax({
						url:'<?= base_url() ?>student/update_admission_payment',
						method: 'post',					
						data: {selId : chkArray,value : dataString,sCode : '<?php echo $code; ?>'},				  
						success: function(data){
							console.log(data);
							if(data > 0){
								$.ajax({
									url:'<?=base_url()?>student/update_student_trans_detail',
									method: 'post',					
									data: {adv_amount : final_adv_amount, due_amount : final_due_amount, sCode : '<?php echo $code; ?>'},
									success: function(result){
									}
								})
							
								$('.chqpay_msg').html('<div class="alert alert-block alert-success"><button data-dismiss="alert" class="close" type="button"><i class="ace-icon fa fa-times"></i></button><p><strong><i class="ace-icon fa fa-check"></i>Success</strong>Your Transaction is Successfull.Teansaction ID #'+data+'</p></div>');
								
							} else {								
								$('.chqpay_msg').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong><i class="ace-icon fa fa-times"></i> Failed! </strong>Their is an error for this transaction<br></div>');
							}
						}
					}) 
				} else {				
					e.preventDefault();
				}*/
			} else {
				Swal.fire({
		            title: "Enter All Details",
		            text: "Payment amount, payee name and cheque number cannot be empty.",
		            icon: "warning"
		        });

				return false;
			}
			
		});

		//pos payment
		$('#sub_pospay').click(function (e) {
		    e.preventDefault(); // Prevent normal submit
			
			var amt = $('#pospay').find('[name="payment_amount"]').val();
			var pos_reference_number = $('#pospay').find('[name="pos_reference_number"]').val();
			var payee_name = $('#pospay').find('[name="payee_name"]').val();
			
			var final_adv_amount = $('.final_adv_amount').val();
			var final_due_amount = $('.final_due_amount').val();
			
			if(final_adv_amount>0){
				amt = 1;
			}
			
			if(amt > 0 && pos_reference_number && payee_name){
				
				var chkArray = [];
				$(".fee_id:checked:not(:disabled)").each(function() {
					chkArray.push($(this).val());
				});

				// 🔥 SweetAlert confirm box instead of confirm()
		        Swal.fire({
		            title: "Are you sure?",
		            text: "Do you want to confirm this payment?",
		            icon: "question",
		            showCancelButton: true,
		            confirmButtonColor: "#3085d6",
		            cancelButtonColor: "#d33",
		            confirmButtonText: "Yes, confirm",
		            cancelButtonText: "Cancel"
		        }).then((result) => {
		            if (result.isConfirmed) {
		            	var dataString = $('#pospay').serializeArray();
						$.ajax({
							url:'<?= base_url() ?>admin/student/update-admission-payment',
							method: 'post',					
							data: {selId : chkArray, value : dataString, sCode : '<?php echo $code; ?>'},
							success: function(data){
								console.log(data);
								if(data > 0){
									$.ajax({
										url:'<?=base_url()?>admin/student/update-student-trans-detail',
										method: 'post',					
										data: {adv_amount : final_adv_amount, due_amount : final_due_amount, sCode : '<?php echo $code; ?>', ad_payment_status: 1},
										success: function(result){}
									})
									
									$('#payFeesMyModal').modal('hide');

		                            Swal.fire({
		                                title: "Success!",
		                                text: "Your transaction is successful. Transaction ID #" + data,
		                                icon: "success"
		                            }).then(() => {
									    location.reload();
									});								
								} else {								
									Swal.fire({
		                                title: "Failed!",
		                                text: "There was an error processing this transaction.",
		                                icon: "error"
		                            });
								}
							}
						}) 
		            }
		        });

				/*var r = confirm("Confirm?");
				if ( r == true ) {
					var dataString = $('#pospay').serializeArray();
					$.ajax({
						url:'<?= base_url() ?>student/update_admission_payment',
						method: 'post',					
						data: {selId : chkArray,value : dataString,sCode : '<?php echo $code; ?>'},
						success: function(data){
							console.log(data);
							if(data > 0){
								$.ajax({
									url:'<?=base_url()?>student/update_student_trans_detail',
									method: 'post',					
									data: {adv_amount : final_adv_amount, due_amount : final_due_amount, sCode : '<?php echo $code; ?>'},
									success: function(result){
									}
								})
							
								$('.pospay_msg').html('<div class="alert alert-block alert-success"><button data-dismiss="alert" class="close" type="button"><i class="ace-icon fa fa-times"></i></button><p><strong><i class="ace-icon fa fa-check"></i>Success</strong>Your Transaction is Successfull. Teansaction ID #'+data+'</p></div>');
								
							} else {								
								$('.pospay_msg').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong><i class="ace-icon fa fa-times"></i> Failed! </strong>Their is an error for this transaction<br></div>');
							}
						}
					}) 
				} else {				
					e.preventDefault();
				}*/
			} else {
				Swal.fire({
		            title: "Enter All Details",
		            text: "Payment amount, payee name and pos reference number cannot be empty.",
		            icon: "warning"
		        });

				return false;
			}

		});
		
		//online payment
		$('#sub_onlinepay').click(function (e) {
			e.preventDefault();
			console.log( "onlinepayDataString" )
			var onlinepayDataString = $('#onlinepay').serializeArray();
			console.log( onlinepayDataString )

			var chkFeesMonthIdArray = [];
			$(".fee_id:checked:not(:disabled)").each(function() {
			    chkFeesMonthIdArray.push($(this).val());
			});
			// console.log( chkFeesMonthIdArray )

			var getStudentCode = '<?php echo $code; ?>'
			// console.log( getStudentCode )

			Swal.fire({
	            title: "Are you sure?",
	            text: "Do you want to confirm this payment?",
	            icon: "question",
	            showCancelButton: true,
	            confirmButtonColor: "#3085d6",
	            cancelButtonColor: "#d33",
	            confirmButtonText: "Yes, confirm",
	            cancelButtonText: "Cancel"
	        }).then((result) => {
	            if (result.isConfirmed) {
            	 	// Put data into hidden form
		            $('#selId').val(JSON.stringify(chkFeesMonthIdArray));
		            $('#value').val(JSON.stringify(onlinepayDataString));

	            	// Submit normal form (FULL PAGE)
            		$('#onlinepay').submit();
	            }
	        });
			
		});


	});

	function invoice_item(formNo, feeId, sCode, studentId){
		$.ajax({
			url:'<?=base_url()?>admin/student/student-paid-monthly-fee-invoice',
			method: "post",					
			data: {
				formNo:formNo,
				feeId:feeId,
				sCode:sCode,
				studentId:studentId
			},				  
			success: function(data){
				$("#itemInvModal").modal("show");					
				var json_obj = JSON.parse(data);						
				$("#item_data").html(json_obj.html);						
			}
		});
	}

	function four_month_invoice_fee(formNo, feeId, sCode, studentId){
		$.ajax({
			url: "<?= base_url('admin/student/ajax-student-paid-fee-invoice') ?>",
			method: "post",					
			data: {
				feeId:feeId,
				formNo:formNo,
				sCode:sCode,
				studentId:studentId
			},				  
			success: function(data){
				$("#itemInvModal").modal("show");					
				var json_obj = JSON.parse(data);						
				$("#item_data").html(json_obj.html);							
			}
		 });								
	}
	
	function invoice_bus_item(formNo, feeId, sCode){
		$.ajax({
			url:'<?=base_url()?>admin/student/student-paid-bus-fee-invoice',
			method: "post",					
			data: {
				formNo:formNo,
				feeId:feeId,
				sCode:sCode
			},				  
			success: function(data){
				$("#itemInvModal").modal("show");					
				var json_obj = JSON.parse(data);						
				$("#item_data").html(json_obj.html);						
			}
		});
	}
</script>

<script>
	$(document).ready(function() {
		$(document).on('change', '.change-fees-payment-mode', function(){
		    let checkbox = $(this);
		    let id = checkbox.data('id');
		    let payment_mode = checkbox.data('admission-payment-mode');
		    let isChecked = checkbox.prop('checked');

		    if (isChecked) {
			    // If checked → ensure last character is "."
			    if (!payment_mode.endsWith(".")) {
			        payment_mode = payment_mode + ".";
			    }
			} else {
			    // If unchecked → remove the trailing dot
			    payment_mode = payment_mode.replace(/\.$/, "");
			}

		    console.log( payment_mode )

		    // if (isChecked) {
		        $.ajax({
		            url: "<?= base_url('admin/student/update-fees-payment-mode') ?>",
		            type: "POST",
		            data: {
		                id: id,
		                paymentMode: payment_mode,
		                isChecked: isChecked,
		                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
		            },
		            success: function(res) {
		                // Reload DataTable to update toggles
		                // table.ajax.reload(null, false);

		                if (res.status === 'success') {
				            Swal.fire('Success', res.message, 'success');
				        } else {
				            Swal.fire('Error', res.message, 'error');
				            checkbox.prop('checked', false);
				        }
		            },
		            error: function() {
		                // console.log("Failed to update payment mode");
		                Swal.fire('Error', 'Something went wrong!', 'error');
		                checkbox.prop('checked', false)
		            }
		        });
		    // }
		});	

		$(document).on('change', '.change-bus-payment-mode', function(){
		    let checkbox = $(this);
		    let id = checkbox.data('id');
		    let payment_mode = checkbox.data('bus-payment-mode');
		    let isChecked = checkbox.prop('checked');

		    if (isChecked) {
			    // If checked → ensure last character is "."
			    if (!payment_mode.endsWith(".")) {
			        payment_mode = payment_mode + ".";
			    }
			} else {
			    // If unchecked → remove the trailing dot
			    payment_mode = payment_mode.replace(/\.$/, "");
			}

		    console.log( payment_mode )

		    // if (isChecked) {
		        $.ajax({
		            url: "<?= base_url('admin/student/update-bus-payment-mode') ?>",
		            type: "POST",
		            data: {
		                id: id,
		                paymentMode: payment_mode,
		                isChecked: isChecked,
		                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
		            },
		            success: function(res) {
		                // Reload DataTable to update toggles
		                // table.ajax.reload(null, false);

		                if (res.status === 'success') {
				            Swal.fire('Success', res.message, 'success');
				        } else {
				            Swal.fire('Error', res.message, 'error');
				            checkbox.prop('checked', false);
				        }
		            },
		            error: function() {
		                // console.log("Failed to update payment mode");
		                Swal.fire('Error', 'Something went wrong!', 'error');
		                checkbox.prop('checked', false)
		            }
		        });
		    // }
		});
	});	
</script>
<!-- For Tooltip -->
<script>
	document.addEventListener('DOMContentLoaded', function () {
	    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
	    tooltipTriggerList.map(function (tooltipTriggerEl) {
	        return new bootstrap.Tooltip(tooltipTriggerEl);
	    });
	});
</script>
