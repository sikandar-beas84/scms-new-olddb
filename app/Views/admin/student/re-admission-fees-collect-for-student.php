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
            <h5 class="mb-0">Collect Re Admission Fee <span style="font-weight: bold; font-size: 13px; color: #cc3030;">(<?= $form_details['first_name'].' - '.$form_details['student_code'] ?>)</span></h5>
        </div>
        <?php if(!empty($form_details)){ ?>
	        <div class="card-body">
	            <p class="mb-4"></p>

	            <div class="mb-4">
	                <div class="fw-bold border-bottom pb-2 mb-3"><i class="ph-money ms-2"></i> Admission Payment</div>
	                <form method="post" id="reAdmissionPaymentArea">

	                	<div class="row">
		                	<div class="col-lg-6">
								<div class="list-group list-group-sm list-group-borderless">
									<div class="row mb-2">
										<div class="col-lg-6"><i class="ph-file-text me-2"></i> Admission Fee(ONE Time)New Student Rs.</div>
										<div class="col-lg-6" id="admission_fee_level">₹<?= $form_details['admission_fee'] ?></div>
									</div>
									<div class="row mb-2">
										<div class="col-lg-6"><i class="ph-file-text me-2"></i> Development Fee (YEARLY) Rs.</div>
										<div class="col-lg-6" id="development_fee_level">₹<?= $form_details['development_fee'] ?></div>
									</div>
									<div class="row mb-2">
										<div class="col-lg-6"><i class="ph-file-text me-2"></i> Exam Fee (YEARLY) Rs.</div>
										<div class="col-lg-6" id="exam_fee_level">₹<?= $form_details['exam_fee'] ?></div>
									</div>
									<div class="row mb-2">
										<div class="col-lg-6"><i class="ph-file-text me-2"></i> Festival Celebration Fee (YEARLY) Rs.</div>
										<div class="col-lg-6" id="festival_celebration_fee_level">₹<?= $form_details['festival_celebration_fee'] ?></div>
									</div>
									<div class="row mb-2">
										<div class="col-lg-6"><i class="ph-file-text me-2"></i> Games Sports Fee (YEARLY) Rs.</div>
										<div class="col-lg-6" id="games_sports_fee_level">₹<?= $form_details['games_sports_fee'] ?></div>
									</div>
									<div class="row mb-2">
										<div class="col-lg-6"><i class="ph-file-text me-2"></i> Audio Visual Lab Fee (YEARLY) Rs.</div>
										<div class="col-lg-6" id="audio_visual_lab_fee_level">₹<?= $form_details['audio_visual_lab_fee'] ?></div>
									</div>
									<div class="row mb-2">
										<div class="col-lg-6"><i class="ph-file-text me-2"></i> Library Fee (YEARLY) Rs.</div>
										<div class="col-lg-6" id="library_fee_level">₹<?= $form_details['library_fee'] ?></div>
									</div>
									<div class="row mb-2">
										<div class="col-lg-6"><i class="ph-file-text me-2"></i> Electricity Maintenance Fee (YEARLY) Rs.</div>
										<div class="col-lg-6" id="electricity_maintenance_fee_level">₹<?= $form_details['electricity_maintenance_fee'] ?></div>
									</div>
									<div class="row mb-2">
										<div class="col-lg-6"><i class="ph-file-text me-2"></i> Computer Fee (YEARLY) Rs.</div>
										<div class="col-lg-6" id="computer_fee_level">₹<?= $form_details['computer_fee'] ?></div>
									</div>
									<div class="row mb-2">
										<div class="col-lg-6"><i class="ph-file-text me-2"></i> Security Deposit (REFUNDABLE) New Student Rs.</div>
										<div class="col-lg-6" id="security_deposite_level">₹<?= $form_details['security_deposite'] ?></div>
									</div>
									<div class="row mb-2">
										<?php 
										$get_tuition_fee = $form_details['tuition_fee'];
										if( isset($academic_status) && $academic_status == "Free" ) {
											$get_tuition_fee = 0;
										} ?>
										<div class="col-lg-6"><i class="ph-file-text me-2"></i> Tuition Fee (MONTHLY) Rs.</div>
										<div class="col-lg-6" id="tuition_fee_level">₹<?= $get_tuition_fee ?></div>
									</div>
									<div class="row mt-3">
									    <div class="col-lg-6 text-end">
									        <strong>Total Fees:</strong>
									    </div>
									    <div class="col-lg-6">
									    	<?php 
									    	$getTotalAcademicPaymentAmt = $form_details['academic_payment_amt'] ?? '';

									    	if( $getTotalAcademicPaymentAmt == '' ) {
									    		$getTotalAcademicPaymentAmt =
												    ($form_details['admission_fee'] ?? 0) +
												    ($form_details['development_fee'] ?? 0) +
												    ($form_details['exam_fee'] ?? 0) +
												    ($form_details['festival_celebration_fee'] ?? 0) +
												    ($form_details['games_sports_fee'] ?? 0) +
												    ($form_details['audio_visual_lab_fee'] ?? 0) +
												    ($form_details['library_fee'] ?? 0) +
												    ($form_details['electricity_maintenance_fee'] ?? 0) +
												    ($form_details['computer_fee'] ?? 0) +
												    ($form_details['security_deposite'] ?? 0) +
												    ((isset($academic_status) && $academic_status == "Free") ? 0 : ($form_details['tuition_fee'] ?? 0));
									    	}
									    	?>
									        <strong>₹<?= $getTotalAcademicPaymentAmt ?></strong>
									    </div>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="list-group list-group-sm list-group-borderless">
									<div class="row mb-2">
										<div class="col-12 col-md-12">
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
											</div>

											<div id="itemContainer">
											    <?php 
											    $get_total_stationary_fee = $form_details['total_stationary_fee'] ?? '';

											    $grand_total = 0;
											    if(isset($stationary_item_list) && !empty($stationary_item_list)) {
											        $i = 1;
											        foreach ($stationary_item_list as $row) {
											            $total = $row['qty'] * $row['price'];
											            $grand_total += $total;

											            $getChecked = 'checked';
											            if( $i > 8 ) {
											            	$getChecked = '';
											            }
											            ?>

											            <div class="item-row  item-row-stationary">
											                <div><?= $i ?></div>
											                <div class="item_name_text"><?= $row['item_name'] ?></div>

											                <input type="hidden" class="item_id" value="<?= $row['id'] ?>">

											                <div>
											                	<span class="item_qty"><?= $row['qty'] ?></span>
											                </div>

											                <div>
											                	<span class="item_price"><?= $row['price'] ?></span>
											                </div>

											                <div>
											                	<span class="item_total"><?= $total ?></span>
											                </div>
											            </div>

											            <?php
											            $i++;
											        }
											    }

											    if( $get_total_stationary_fee == '' ) {
											    	$get_total_stationary_fee = $grand_total;
											    }
											    ?>
											</div>
											<div class="row mt-3">
											    <div class="col-lg-11 text-end">
											        <strong>Stationary Total Fee:</strong>
											    </div>
											    <div class="col-lg-1">
											        <strong id="grandTotal">₹<?= $get_total_stationary_fee ?></strong>
											    </div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-12">
							<div class="list-group list-group-sm list-group-borderless">
								

								<?php if($form_details['stoppage'] > 0) { ?>
									<div class="row mb-2">
										<div class="col-lg-3">
											<i class="ph-file-text me-2"></i> Bus Services (<?= !empty($form_details['stoppage']) ? stoppage_name_by_id($form_details['stoppage']) : ''; ?>)
										</div>
										<div class="col-lg-3">
											<span class="form-control"><?= $stoppage_fare ?></span>
										</div>
										<div class="col-lg-3" id="tuition_fee_level"></div>
									</div>
								<?php } ?>

								<div class="row mb-2">
									<div class="col-lg-3">
										<i class="ph-file-text me-2"></i> Consideration Remarks
									</div>
									<div class="col-lg-6">
										<textarea  name="remarks" id="remarks" rows="3" cols="3" class="form-control" placeholder="Enter your consideration remarks"></textarea>
									</div>
								</div>

								<?php 
								$getAllPaymentAmount = $form_details['payment_amount'] ?? '';
								$tuition_fine = $fine ?? 0;
								$bus_fee_fine = $bus_fee_fine ?? 0;

								if( $getAllPaymentAmount == '' ) {
									$getAllPaymentAmount = (int)$getTotalAcademicPaymentAmt + (int)$get_total_stationary_fee + (int)$stoppage_fare + (int)$tuition_fine + (int)$bus_fee_fine;
								}
								?>
								<div class="row mb-2">
									<div class="col-lg-6"><strong>Total Amount: <span>₹<?= $getAllPaymentAmount ?></span></strong></div>
									
									<?php 
						            $ad_payment_status = $form_details['ad_payment_status'] ?? 0;
						            if( $ad_payment_status != 1 ) {
						            ?>
										<div class="col-lg-3">
											<button type="button" id="re_admission_fee_payment_btn" class="btn btn-warning pull-right"><i class="white ace-icon fa fa-credit-card "></i>Make Payment</button>
										</div>
									<?php } ?>
									<div class="col-lg-3">
										<input type="hidden" class="form-control" name="payment_amount" id="payment_amount" value="" />
										<input type="hidden" class="form-control" name="form_no" value="" />
										<input type="hidden" class="form-control" name="student_id" value="<?php echo $form_details['student_id']; ?>" />
										<input type="hidden" class="form-control" name="first_name" value="<?php echo $form_details['first_name']; ?>" />
									</div>
								</div>

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
<div class="modal fade" id="myReAdmissionPaymentModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Collect Re Admission Fees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs" id="modalTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="online-tab" data-bs-toggle="tab" data-bs-target="#onlinePayment" type="button" role="tab" aria-controls="online" aria-selected="true">
                            Online Payment
                        </button>
                    </li>
                </ul>
                
                <!-- Tab Content -->
                <div class="tab-content modal-tab-content" id="modalTabsContent">
                    <div class="tab-pane fade show active" id="onlinePayment" role="tabpanel" aria-labelledby="online-tab">
						<form class="form-horizontal" role="form" id="onlinepay" autocomplete="off" method="post" action="<?= base_url('admin/student/ccavenue-request-readmission') ?>">
							<p class="cpay_msg"></p>
							<div class="form-group row mb-2">
								<label  class="col-sm-4 control-label" for=""> Tution Fine Amount </label>
								<div class="col-sm-8">
									<input type="hidden" class="form-control" name="fine" value="<?= $fine; ?>"  />
									<input type="text" class="form-control fine_m" value="<?= $fine; ?>" disabled />
								</div>
							</div>
							<div class="form-group row mb-2">
								<label  class="col-sm-4 control-label" for=""> Bus Fine Amount </label>
								<div class="col-sm-8">
									<input type="hidden" class="form-control" name="bus_fee_fine" value="<?= $bus_fee_fine; ?>" />
									<input type="text" class="form-control bus_fee_fine_m" value="<?= $bus_fee_fine; ?>" disabled />
								</div>
							</div>
							<div class="form-group row mb-2">
								<label  class="col-sm-4 control-label" for=""> Advanced Amount </label>
								<div class="col-sm-8">
									<input type="text" class="form-control adv_amount"  placeholder="Advance Amount" value="0" disabled />
									<input type="hidden" class="adv_amount" name="adv_amount" value="0"/>
								</div>
							</div>
							<div class="form-group row mb-2">
								<label  class="col-sm-4 control-label" for=""> Due Amount </label>
								<div class="col-sm-8">
									<input type="text" class="form-control due_amount"  placeholder="Due Amount" value="0" disabled />
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
							<input type="hidden" class="paymentData" name="paymentData" id="paymentData" value=""/>

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
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php  

// $getAdmissionPaymentFormData = [];
$getAdmissionPaymentFormData = [
    'admission_fee' => $form_details['admission_fee'] ?? 0,
    'development_fee' => $form_details['development_fee'] ?? 0,
    'exam_fee' => $form_details['exam_fee'] ?? 0,
    'festival_celebration_fee' => $form_details['festival_celebration_fee'] ?? 0,
    'games_sports_fee' => $form_details['games_sports_fee'] ?? 0,
    'audio_visual_lab_fee' => $form_details['audio_visual_lab_fee'] ?? 0,
    'library_fee' => $form_details['library_fee'] ?? 0,
    'electricity_maintenance_fee' => $form_details['electricity_maintenance_fee'] ?? 0,
    'computer_fee' => $form_details['computer_fee'] ?? 0,
    'security_deposite' => $form_details['security_deposite'] ?? 0,
    'tuition_fee' => (isset($academic_status) && $academic_status == "Free") ? 0 : ($form_details['tuition_fee'] ?? 0),
    'stoppage_fee' => $form_details['bus_services'] ?? 0,
    'remarks' => $form_details['remarks'] ?? '',
    'payment_amount' => $getAllPaymentAmount ?? 0,
    'form_no' => '',
    'student_id' => $form_details['student_id'] ?? 0,
    'first_name' => $form_details['first_name'] ?? 0,
    'payment_cheque_number' => '',
    'payment_pos_bank_name' => '',
    'payment_pos_reference_number' => '',
    'stationary_items' => $stationary_item_list ?? [],
    'tblc_items' => [],
    'grand_total_fees' => $getTotalAcademicPaymentAmt ?? 0,
    'stationary_total' => $get_total_stationary_fee ?? 0,
    'tblc_total' => 0,
    'fees_id' => $form_details['fees_id'] ?? '',
    'class_id' => $form_details['class_id'] ?? '',
    'student_code' => $form_details['student_code'] ?? '',
];
?>
<script>
	$(document).ready(function() {
		let baseUrl = '<?=base_url()?>';

		$("#re_admission_fee_payment_btn").click(function(){
			$('#myReAdmissionPaymentModal').modal('show');

		    let paymentAmount = '<?= $getAllPaymentAmount ?? 0; ?>';
		    let payeeName = '<?= $form_details['first_name'] ?? 0; ?>';
		    let tuition_fine = '<?= $fine ?? 0; ?>';
		    let bus_fee_fine = '<?= $bus_fee_fine ?? 0; ?>';

		    $('input[name="fine"]').val(tuition_fine);
			$('input[name="bus_fee_fine"]').val(bus_fee_fine);
		    $('input[name="payment_amount"]').val(paymentAmount);
		    $('input[name="payee_name"]').val(payeeName);
		    $('.payment_amount_m').val(paymentAmount);
		});

		/**
		 * =========================
		 * Payment Area
		 * =========================
		 * */ 

		// Online Payment
		$('#sub_onlinepay').click(function (e) {
			e.preventDefault();
			console.log( "onlinepayDataString" )
			var onlinepayDataString = $('#onlinepay').serializeArray();
			console.log( onlinepayDataString )

			let formData = <?= json_encode($getAdmissionPaymentFormData); ?>;
			console.log(typeof formData);
		    console.log("FORM DATA =====>", formData);
		    console.log("formData.fees_id =====>", formData.fees_id);
		    let chkFeesMonthIdArray = [formData.fees_id];

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
		            $('#paymentData').val(JSON.stringify(formData));

	            	// Submit normal form (FULL PAGE)
            		$('#onlinepay').submit();
	            }
	        });
		})


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
			    	$('#myReAdmissionPaymentModal').modal('hide');

			    	let formData = getAdmissionPaymentFormData();
			    	formData['ad_payment_mode'] = paymentMethod;
			    	// console.log(formData)

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
						url:'<?=base_url()?>admin/student/add-re-admission-payment',
						method: 'post',					
						data: formData,	
						dataType: 'json',
						success: function(response){
							if (response.success) {	
								$('#myReAdmissionPaymentModal').modal('hide')

								Swal.fire({
								    icon: 'success',
								    title: 'Success!',
								    text: 'Your Transaction is Successfull.',
								    confirmButtonText: 'OK'
								}).then(() => {
								    window.location.href = baseUrl + "admin/student/student-list/" + response.student_code;
								});								
							} else {
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
</script>