<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>

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
            <h5 class="mb-0"><?= $title ?> - <?= $student_name ?></h5>
        </div>
        <?php if (!session()->get('student_logged_in')) { ?>
	        <div class="card-body">
	            <p class="mb-4"></p>
	            <div class="mb-4">
	            	<div class="row">
	            		<div class="col-lg-12">
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
										<div class="row mt-3">
										    <div class="col-lg-11 text-end">
										        <strong>Stationary Total Fee:</strong>
										    </div>
										    <div class="col-lg-1">
										        <strong id="grandTotal">₹0</strong>
										    </div>
										</div>

										<?php if( isset($student_stationary_items) && !empty($student_stationary_items) ) { ?>
											<div class="row mt-3 justify-content-center">
											    <div class="col-lg-6">
											        <p class="text-center fw-bold alert alert-success">
											            Already Stationary Item Assigned to this Student
											        </p>
											    </div>
											</div>
										<?php } else { ?>
											<div class="row mt-3 justify-content-end">
												<div class="col-lg-3 ms-auto text-end">
													<button type="button" id="payStationaryItemBtn" class="btn btn-primary pull-right"><i class="white ace-icon fa fa-credit-card "></i>Make Payment</button>
												</div>
											</div>
										<?php } ?>
										
									</div>
								</div>
							</div>
						</div>
	            	</div>
	            </div>
	        </div>
	    <?php } ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myStationaryPaymentModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Collect Stationary Item Amount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs" id="modalTabs" role="tablist">
                	<?php if (!session()->get('student_logged_in')) { ?>
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
	                <?php } ?>

                    <?php /*if(get_config_value_by_key('online_payment_mode') != 0) { ?>
	                    <li class="nav-item" role="presentation">
	                        <button class="nav-link" id="online-tab" data-bs-toggle="tab" data-bs-target="#onlinePayment" type="button" role="tab" aria-controls="online" aria-selected="false">
	                            Online Payment
	                        </button>
	                    </li>
	                <?php }*/ ?>
                </ul>
                
                <!-- Tab Content -->
                <div class="tab-content modal-tab-content" id="modalTabsContent">
                	<?php if (!session()->get('student_logged_in')) { ?>
	                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
	                        <h4></h4>
	                        <form class="form-horizontal" role="form" id="cpay" autocomplete="off">
								<p class="cpay_msg"></p>
								
								<div class="row mb-3">
									<label class="col-md-2 col-form-label">Cash Amount</label>
									<div class="col-md-4">
										<input type="text" class="form-control payment_amount_m" placeholder="Cash Amount" value="" disabled />
										<input type="hidden" name="payment_amount" value="" />
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
                   <?php } ?>

                    <div class="tab-pane fade" id="onlinePayment" role="tabpanel" aria-labelledby="online-tab">
						<form class="form-horizontal" role="form" id="onlinepay" autocomplete="off" method="post" action="<?= base_url('admin/student/ccavenue-request-readmission') ?>">
							<p class="cpay_msg"></p>
							
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
							<input type="hidden" class="t_user_id" name="t_user_id" value="<?= session()->get('user_id') ?>"/>
							<input type="hidden" class="added_by" name="added_by" value="<?= session()->get('f_name')?>"/>
							<input type="hidden" class="sCode" name="sCode" value="<?php echo $student_code; ?>"/>
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

<script>
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

    document.getElementById('itemContainer').addEventListener('change', function(e) {
        if (e.target.classList.contains('item_check')) {
            calculateStationaryGrandTotal();
        }
    });

    // Initial calculation
    calculateStationaryGrandTotal();

	function getStationaryItemsFormData()
	{
		let formData = {};

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

	    // 4️⃣ Grand Totals
	    formData['stationary_total'] = $('#grandTotal').text().replace('₹', '').trim();
	    let student_id = '<?= $student_id ?? ''; ?>'
	    formData['student_id'] = student_id;
	    let class_id = '<?= $class_id ?? ''; ?>'
	    formData['class_id'] = class_id;
	    let student_code = '<?= $student_code ?? ''; ?>'
	    formData['student_code'] = student_code;
	    let fees_id = '<?= $april_month_fees_details['id'] ?? ''; ?>'
	    formData['fees_id'] = fees_id;
	    let student_name = '<?= $student_name ?? ''; ?>'
	    formData['student_name'] = student_name;
	    

	    return formData;
	}

	$(document).ready(function() {
		let baseUrl = '<?= base_url() ?>';

		$("#payStationaryItemBtn").click(function(){
			$('#myStationaryPaymentModal').modal('show');

		    let formData = getStationaryItemsFormData();
		    console.log("FORM DATA =====>", formData);

		    let paymentAmount = formData.stationary_total || 0;
		    let payeeName = formData.student_name || '';

		    $('input[name="payment_amount"]').val(paymentAmount);
		    $('input[name="payee_name"]').val(payeeName);
		    $('.payment_amount_m').val(paymentAmount);
		});


		/**
		 * =========================
		 * Payment Area
		 * =========================
		 * */ 

		// Cash Payment
		$('#sub_cpay').click(function (e) {
			stationaryItemPayment('cash')
		})

		// Cheque Payment
		$('#sub_chqpay').click(function (e) {
			stationaryItemPayment('cheque')
		})

		// POS Payment
		$('#sub_pospay').click(function (e) {
			stationaryItemPayment('pos')
		})

		// Online Payment
		/*$('#sub_onlinepay').click(function (e) {
			e.preventDefault();
			console.log( "onlinepayDataString" )
			var onlinepayDataString = $('#onlinepay').serializeArray();
			console.log( onlinepayDataString )

			let formData = getAdmissionPaymentFormData();
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
		})*/

		/*$('#assignStationaryItem').click(function () {
			let formData = getStationaryItemsFormData()
			// console.log(formData)
			// console.log(formData.student_code)
			// console.log(formData.student_id)
			// console.log(formData.fees_id)

			if(formData.student_code !== '' && formData.student_id !== '' && formData.fees_id !== ''){
				// $.ajax({
			    //     url: "<?= base_url('admin/stationary-items/ajax-assign-stationary-item-to-student') ?>",
			    //     type: "POST",
			    //     data: {
			    //         formData: formData
			    //     },
			    //     dataType: "json",
			    //     success: function(response) {
			    //         console.log(response);
			    //     },
			    //     error: function(xhr) {
			    //         console.log(xhr.responseText);
			    //         // alert('Something went wrong!');
			    //         Swal.fire({
				// 		    icon: 'warning',
				// 		    title: '',
				// 		    text: 'Something went wrong!',
				// 		    confirmButtonText: 'OK'
				// 		});
			    //     }
			    // });
			} else {
				Swal.fire({
				    icon: 'warning',
				    title: '',
				    text: 'Student details not found!',
				    confirmButtonText: 'OK'
				});

				e.preventDefault();
			}
		});*/



		function stationaryItemPayment(paymentMethod='')
		{
			if (paymentMethod === '') {
		        paymentMethod = 'cash';
		    }

			let getChequeNumber = $("#cheque_number").val()
			let getBankName = $("#pos_bank_name").val()
			let getPosReferenceNumber = $("#pos_reference_number").val()

			Swal.fire({
			    title: "Confirm?",
			    text: "",
			    icon: "warning",
			    showCancelButton: true,
			    confirmButtonText: "Yes",
			    cancelButtonText: "No, Cancel"
			}).then((result) => {
			    if (result.isConfirmed) {
			    	$('#myStationaryPaymentModal').modal('hide');

			    	let formData = getStationaryItemsFormData();
			    	formData['ad_payment_mode'] = paymentMethod;
			    	formData['cheque_number'] = getChequeNumber;
			    	formData['pos_bank_name'] = getBankName;
			    	formData['pos_reference_number'] = getPosReferenceNumber;
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
						url:'<?=base_url()?>admin/stationary-items/ajax-assign-stationary-item-to-student',
						method: 'post',					
						data: formData,	
						dataType: 'json',
						success: function(response){
							if (response.status) {	
								$('#myStationaryPaymentModal').modal('hide')

								Swal.fire({
								    icon: 'success',
								    title: 'Success!',
								    text: 'Your Transaction is Successfull.' + response.message,
								    confirmButtonText: 'OK'
								}).then(() => {
								    window.location.href = baseUrl + "admin/stationary-items/assign-stationary-items/" + response.student_code;
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