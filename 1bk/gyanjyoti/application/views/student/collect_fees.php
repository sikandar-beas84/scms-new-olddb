<style type="text/css">
    .modal-backdrop.show {
        display: none;
    }
    .swal2-styled {
    padding-top: 0px;
}
div#paymentModalBody .nav-tabs {
    background: #243448 !important;
}
.dt-buttons.btn-group.flex-wrap.btn-group-sm {
    margin-top: 14px;
}
table#listTable td, table#listTable th {
    text-align: center;
}
tr input {
    margin-left: 7px;
}
</style>

<!-- <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script> -->

<div class="page-body">


  
    <div class="customModal" id="actionModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-1" id="modalContent">
                <form method="POST" action="#" id="mainForm" enctype="multipart/form-data" >
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
                    <div class="modal-header mb-3">
                        <h4 class="modal-title">Action</h4>
                        <button type="button" class="close" id="closeModalBtn" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-5" id="actionModalBody">
                         <input type="hidden" id="student_id" value="">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-success w-100" id="approveButton" onclick="showNext(1)">Approve</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-danger w-100" id="rejectButton" onclick="showNext(2)">Reject</button>
                            </div>
                        </div>
                        <div id="rejectReasonBox" class="mb-3" style="display: none;">
                            <label for="rejectReason">Rejection Reason:</label>
                            <textarea id="rejectReason" class="form-control" name="reject_reason" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-danger actionCloseButton" data-dismiss="modal">Close</button> -->
                        <button type="button" class="btn btn-primary actionButton" onclick="submitReject()"  style="display: none;">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="customModal" id="paymentModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-1" id="modalContent">
                <form method="POST" action="#" id="mainForm" enctype="multipart/form-data">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
                    <div class="modal-header mb-3">
                        <h4 class="modal-title">Payment</h4>
                        <button type="button" class="close" id="paymentcloseModalBtn" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-5" id="paymentModalBody">
                        <input type="hidden" id="payment_id" value="">
                        <input type="hidden" id="payment_type" value="">
                        <input type="hidden" id="class" value="">
                        <p><b>Admission Fees: ₹</b> <span id="academic_fees"><span></p>
                        <p><b>Session Charge: ₹</b> <span id="session_fees"><span></p>
                        <p><b>Tuition Fees: ₹</b> <span id="tuition_fees"><span></p>
                        <p><b>Development Fees: ₹</b> <span id="development_fees"><span></p>
                        <p><b>Misc.Fees: ₹</b> <span id="other_curriculum_fees"><span></p>
                        
                        <p><b>Fine: ₹</b> <span id="fine"><span></p>
                        <p><b>Total: ₹</b> <span id="total_fees"><span></p>
                        <div class="form-group hideGroup">
                            <label for="customAmount">Enter Payment Amount:</label>
                            <input type="number" id="customAmount" class="form-control" placeholder="Enter amount to pay">
                        </div>
                        <p class="hideGroup"><b>Remaining Balance: ₹</b> <span id="remainingBalance">20000</span></p>
                        <p class="hideGroup"><b>Payment Count: </b> <span id="paymentCount">0</span> / 3</p>

                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs" id="paymentTabs" role="tablist">
                            <?php if(getUserType() != 'student'){ ?>
                            <li class="nav-item">
                                <a class="nav-link " id="cash-tab" data-toggle="tab" href="#cash" role="tab" aria-controls="cash" aria-selected="true">Cash</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="qr-tab" data-toggle="tab" href="#qr" role="tab" aria-controls="qr" aria-selected="false">QR</a>
                            </li>
                            <?php } ?>
                            <li class="nav-item">
                                <a class="nav-link" id="online-tab" data-toggle="tab" href="#online" role="tab" aria-controls="online" aria-selected="false">Online</a>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content mt-3" id="paymentTabContent">
                            <!-- Cash Tab -->
                            <div class="tab-pane fade show " id="cash" role="tabpanel" aria-labelledby="cash-tab">
                                <p>Payment will be made by cash.</p>
                                <!-- Additional fields for cash payment can go here if needed -->
                            </div>

                            <!-- QR Tab -->
                            <div class="tab-pane fade" id="qr" role="tabpanel" aria-labelledby="qr-tab">
                                <div class="form-group">
                                    <label for="utrNumber">UTR Number:</label>
                                    <input type="text" id="utrNumber" class="form-control" name="utr_number" placeholder="Enter UTR Number">
                                </div>
                            </div>

                            <!-- Online Tab -->
                            <div class="tab-pane fade" id="online" role="tabpanel" aria-labelledby="online-tab">
                                <p>Proceed with online payment.</p>
                                <!--<button type="button" class="btn btn-success" id="razorpayButton" onclick="initiateRazorpay()">Pay with Razorpay</button>-->
                                <button type="button" class="btn btn-success" onclick="initiateEazyPayPayment()">Pay with EazyPay</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-danger actionCloseButton" data-dismiss="modal">Close</button> -->
                            <button type="button" class="btn btn-primary paymentSubitButton" onclick=""  style="display: none;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Container-fluid starts-->
    <div class="container-fluid crypto-dash">
        <!-- Add this to your filter section -->
      

        <div class="card">
            <div class="card-body">
                    <p><b>Student Name:</b> <?=$student->student_name; ?></p>
                    <p><b>Student Code:</b> <?=$student->student_code; ?></p>
                <div class="text-end mb-3">
                    <!-- <button type="button" class="btn btn-primary buttonBg" data-toggle="modal" data-target="#actionModal" onclick="action(0,3)">
                        <i class="fa fa-plus-square" aria-hidden="true"></i> Add New
                    </button> -->
                    <!-- Pay Options Section (initially hidden) -->
<div id="payOptions" style="display:none;">
    <button class="btn btn-primary" onclick="paySelectedFees()">Pay Selected Fees</button>
</div>
                </div> 
                <table class="table table-striped table-bordered" id="listTable">
                    <thead class="bg-primary text-white">
                        <tr>
                             <th>
                                <input type="checkbox" id="selectAll" onclick="toggleCheckboxes(this)">
                            </th>
                            <th>Month</th>
                            <th>Admission Fee</th>
                            <th>Session Charge</th>
                            <th>Tuition Fees</th>
                            <th>Development Fees</th>
                            <th>Misc.Fees</th>
                            <th>Fine Amount</th>
                            <th>Total Amount</th>
                            <th>Paid Amount</th>
                            <th>Remaining Amount</th>
                            <th>Due Date</th>
                            <th>Payment Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($fees as $v):
                            $due = $this->Generalmodel->getDataWhere('month_wise_due_date',['month' => $v->month, 'session_year'=>get_session('session'), 'is_delete' => 'N']);

                        ?>
                        <tr>
                             <td>
                                <?php if($v->payment_status == 'Y'): ?>    
                                    <input type="checkbox" checked disabled>
                                <?php else: ?>    
                                    <input type="checkbox" class="fee-checkbox" data-id="<?= $v->id ?>" onclick="togglePayOptions()">
                                <?php endif; ?>  
                            </td> 
                            <td>
                                <?php
                                    $dateObj = DateTime::createFromFormat('!m', $v->month);
                                    echo $dateObj->format('F');
                                ?>
                            </td>
                            <td><?= $v->academic_fees ?></td>
                            <td><?= $v->session_fees ?></td>
                            <td><?= $v->tuition_fees ?></td>
                            <td><?= $v->monthly_fees ?></td>
                            <td><?= $v->other_curriculum_fees ?></td>
                            <td><?= $v->fine ?></td>
                            <td><?= $v->session_fees + $v->academic_fees + $v->tuition_fees + $v->monthly_fees + $v->sports_fees + $v->library_fees + $v->lab_fees + $v->other_curriculum_fees + $v->fine ?></td>
                            <td><?= $v->payment_amount_1st + $v->payment_amount_2nd + $v->payment_amount_3rd ?></td>
                            <td><?= ($v->session_fees + $v->academic_fees + $v->tuition_fees + $v->monthly_fees + $v->sports_fees + $v->library_fees + $v->lab_fees + $v->other_curriculum_fees + $v->fine) - ($v->payment_amount_1st + $v->payment_amount_2nd + $v->payment_amount_3rd) ?></td>
                            <td><?= !empty($due[0]->due_date) ? date('d-M-Y', strtotime($due[0]->due_date)) : '_ _ _'; ?></td>
                            <td><?= !empty($v->payment_date) ? date('d-M-Y h:i A', strtotime($v->payment_date)) : '_ _ _'; ?></td>
                            <td>
                                <?php if($v->payment_status == 'Y' || $v->payment_amount_1st != 0): ?>    
                                    <a href="javascript:" class="btn btn-outline-success btn-xs" onclick="getInvoice(<?= $v->id ?>)"><i class="fas fa-file-invoice"></i><i class="fa fa-file-text-o " aria-hidden="true"></i></a>
                                <?php else: ?>    
                                _ _ _
                                    <!--<a href="javascript:" class="btn btn-outline-danger btn-xs" onclick="action(<?= $v->id ?>)"><i class="fa fa-credit-card " aria-hidden="true"></i></a>-->
                                <?php endif; ?>  
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pay Options Section (initially hidden) -->
                <div id="payOptions" style="display:none;">
                    <button class="btn btn-primary" onclick="paySelectedFees()">Pay Selected Fees</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> -->
    
    <script>
    var baseUrl = '<?= base_url(); ?>';
var pageURL = 'student/fees/';
var tableId = 'listTable';
var formId = 'mainForm';
var modalId = 'actionModal';
var paymentmodalId = 'paymentModal';
var modalBody = 'actionModalBody';

// Add this after your existing document.ready function

function action(id) {
        $("#payment_id").val(id);
        var fromData = { id: id };
        ajaxPostRequest(baseUrl + pageURL + 'getFeesDataById', fromData, function(data) {
            if (data.status == 'success') {
                console.log(data);
                $("#session_fees").html(data.data[0].session_fees);
                $("#academic_fees").html(data.data[0].admission_fee);
                $("#tuition_fees").html(data.data[0].tuition_fees);
                $("#development_fees").html(data.data[0].development_fees);
                // $("#sports_fees").html(data.data[0].sports_fees);
                // $("#library_fees").html(data.data[0].library_fees);
                // $("#lab_fees").html(data.data[0].lab_fees);
                $("#other_curriculum_fees").html(data.data[0].misc_fees);
                $("#fine").html(data.data[0].fine);
                var total =  parseFloat(data.data[0].session_fees) + parseFloat(data.data[0].admission_fee) + parseFloat(data.data[0].development_fees) + parseFloat(data.data[0].misc_fees) + parseFloat(data.data[0].fine) + parseFloat(data.data[0].tuition_fees);
                $("#total_fees").html(total);
            //   const firstPayment = parseFloat(data.data[0].1st_payment_amount || 0);
            //     const secondPayment = parseFloat(data.data[0].2nd_payment_amount || 0);
            //     const thirdPayment = parseFloat(data.data[0].3rd_payment_amount || 0);
                
                // const remainingBalance = parseFloat(total) - (firstPayment + secondPayment + thirdPayment);
                
                $("#remainingBalance").html(total);
                $("#paymentCount").html(data.data[0].payment_count);
                $("#class").val(data.data[0].class);
                // Swal.fire(data.message, { icon: "success" });
                // ajaxDataTable(tableId, 10, baseUrl + pageURL + 'list');
            } else {
                Swal.fire(data.message, { icon: "error" });
            }
        });
        $("#"+paymentmodalId+" .modal-title").html('Payment');
        holdModal(paymentmodalId);

        
    }

    </script>


<script>
    $(document).ready(function () {
        // Automatically show the first tab when the page loads
        $('#paymentTabs a:first').tab('show');

        // Function to manually change tabs
        function showTab(tabId) {
            var target = $(tabId);
            if (target.length) {
                var tab = $('#paymentTabs a[href="' + tabId + '"]');
                tab.tab('show');
            }
        }

        // Example: Show the QR tab on some action
        $('#qr-tab').click(function() {
            showTab('#qr');
            $(".paymentSubitButton").show();
            $("#payment_type").val(2);
        });
        $('#online-tab').click(function() {
            showTab('#online');
            $(".paymentSubitButton").hide();
            $("#payment_type").val(3);

        });
        $('#cash-tab').click(function() {
            showTab('#cash');
            $(".paymentSubitButton").show();
            $("#payment_type").val(1);

        });
    });
    
// Modify the payment button click handler
$('.paymentSubitButton').click(function(event) {
    event.preventDefault();
    
    var selectedID = [];
    var checkboxes = document.querySelectorAll('.fee-checkbox:checked');
    
    checkboxes.forEach(function(checkbox) {
        selectedID.push(checkbox.getAttribute('data-id'));
    });
    
    var id = selectedID.length > 0 ? selectedID : $("#payment_id").val();
    var payment_type = $("#payment_type").val();
    var class_id = $("#class").val();
    var utrNumber = $("#utrNumber").val();
    var customAmount = parseFloat($("#customAmount").val());
    var paymentCount = parseInt($("#paymentCount").text()) || 0;
// alert(paymentCount);
    if (paymentCount >= 3) {
        Swal.fire({
            title: "Error!",
            text: "Maximum payment count (3) reached.",
            icon: "error"
        });
        return;
    }
    
    var requestData = {
        id: id,
        class_id: class_id,
        payment_type: payment_type,
        utrNumber: utrNumber,
        amount: customAmount,
        payment_count: paymentCount,
        is_first_payment: 'N'
    };

    ajaxPostRequest(baseUrl + pageURL + 'payment', requestData, function(data) {
        if (data.status == 'success') {
            Swal.fire({
                title: "Success!",
                text: data.message,
                icon: "success",
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: "Error!",
                text: data.message,
                icon: "error"
            });
        }
    });
});
function getInvoice(id){
     // Make the AJAX POST request
     ajaxPostRequest(baseUrl + pageURL + 'getInvoice', {id: id}, function(data) {
            if (data.status == 'success') {
                $("#"+paymentmodalId+" .modal-title").html('Invoice');
                holdModal(paymentmodalId);
                $("#paymentModalBody").html(data.html); // Update the modal content with the server response
                $(".paymentSubitButton").hide(); // Hide the submit button after success

                // Optionally, you can use SweetAlert for user feedback
                // Swal.fire({
                //     title: "Success!",
                //     text: data.message,
                //     icon: "success"
                // });

            } else {
                // Show error message using SweetAlert
                Swal.fire({
                    title: "Error!",
                    text: data.message,
                    icon: "error"
                });
            }
        });
}    // Close modal handlers
    $("#closeModalBtn").click(function() {
        closeModal(modalId);
        location.reload();
    });
    $("#paymentcloseModalBtn").click(function() {
        closeModal(paymentmodalId);
        location.reload();
    });

    $("button.btn.btn-danger.actionCloseButton").click(function() {
        closeModal(modalId);
        location.reload();
    });

    // Function to toggle checkboxes for all rows
function toggleCheckboxes(selectAllCheckbox) {
    var checkboxes = document.querySelectorAll('.fee-checkbox');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = selectAllCheckbox.checked;
    });
    togglePayOptions();
}

// Function to show or hide the pay options based on checkbox selection
function togglePayOptions() {
    var checkboxes = document.querySelectorAll('.fee-checkbox');
    var anySelected = false;
    
    // Check if at least one checkbox is selected
    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            anySelected = true;
        }
    });

    // Show/hide pay options based on selection
    var payOptionsDiv = document.getElementById('payOptions');
    payOptionsDiv.style.display = anySelected ? 'block' : 'none';
}

// Function to handle payment for selected fees
function paySelectedFees() {
    var selectedID = [];
    var checkboxes = document.querySelectorAll('.fee-checkbox:checked');
    
    checkboxes.forEach(function(checkbox) {
        selectedID.push(checkbox.getAttribute('data-id'));
    });
     $("#payment_id").val(selectedID);
    var fromData = { id: selectedID };
    ajaxPostRequest(baseUrl + pageURL + 'getMultiMonthFeesDataById', fromData, function(data) {
        console.log(data.data);
        if (data.status == 'success') {
            $("#session_fees").html(data.data.session_fees);
                $("#academic_fees").html(data.data.admission_fees);
                $("#tuition_fees").html(data.data.tuition_fees);
                $("#development_fees").html(data.data.development_fees);
                // $("#monthly_fees").html(data.data[0].monthly_fees);
                // $("#sports_fees").html(data.data[0].sports_fees);
                // $("#library_fees").html(data.data[0].library_fees);
                // $("#lab_fees").html(data.data[0].lab_fees);
                $("#other_curriculum_fees").html(data.data.misc_fees);
                $("#fine").html(data.data.fine);
                var total =  parseFloat(data.data.session_fees) + parseFloat(data.data.admission_fees) + parseFloat(data.data.development_fees) + parseFloat(data.data.misc_fees) + parseFloat(data.data.tuition_fees) + parseFloat(data.data.fine);
                $("#total_fees").html(total);
                var firstPayment = parseFloat(data.data.payment_amount_1st || 0);
                var secondPayment = parseFloat(data.data.payment_amount_2nd || 0);
                var thirdPayment = parseFloat(data.data.payment_amount_3rd || 0);
                
                var remainingBalance = parseFloat(total) - (firstPayment + secondPayment + thirdPayment);
                $("#customAmount").val(remainingBalance);
                $('#customAmount').attr('max', remainingBalance);
                $('#customAmount').attr('min', 0);
                $("#remainingBalance").html(remainingBalance);
                $("#paymentCount").html(data.data.payment_count);
                $("#class").val(data.data.class);
                if(data.data.payment_count >= 2){
                    $('#customAmount').css('cursor', 'pointer'); 
                }
                if(data.data.month == 4){
                    $(".hideGroup").show(); 
                }else{
                    $(".hideGroup").hide(); 
                    
                }
            
        } else {
            Swal.fire(data.message, { icon: "error" });
        }
    });
    $("#"+paymentmodalId+" .modal-title").html('Payment');
    holdModal(paymentmodalId);
    
    // if (selectedFees.length > 0) {
    //     // You can implement your payment logic here, for example:
    //     console.log('Selected Fees IDs:', selectedFees);
    //     alert('Proceeding to payment for selected months.');
    //     // Redirect or call payment API with selectedFee IDs
    // } else {
    //     alert('Please select at least one fee to proceed.');
    // }
}

function initiateEazyPayPayment() {
    // Collect payment data from your form
    const paymentData = {
        id: $('#payment_id').val(), // Payment ID
        payment_type: $('#payment_type').val(), // Payment type (e.g., full, partial)
        class_id: $('#class').val(), // Class ID for context
        amount: $('#customAmount').val(), // Total amount to be paid
        customer_name: "Dev", // Customer's name
        is_first_payment: 'N', // Customer's name
        customer_email: 'tes@gmail.com', // Customer's email
        customer_mobile: '8617504626' // Customer's mobile number
        // customer_name: $('#customer_name').val(), // Customer's name
        // customer_email: $('#customer_email').val(), // Customer's email
        // customer_mobile: $('#customer_mobile').val() // Customer's mobile number
    };

    // Validate mandatory fields
    if (!paymentData.amount || !paymentData.customer_name || !paymentData.customer_mobile) {
        Swal.fire({
            title: "Missing Information",
            text: "Please fill in all mandatory fields.",
            icon: "warning"
        });
        return;
    }

    // Send AJAX POST request to the backend
    ajaxPostRequest(baseUrl + 'EazyPayIntegration/processPayment', paymentData, function(response) {
        if (response.status === 'success') {
            // Redirect to EazyPay payment URL
            window.location.href = response.payment_url;
        } else {
            Swal.fire({
                title: "Error!",
                text: response.message,
                icon: "error"
            });
        }
    });
}
$(document).ready(function() {
    // Initialize custom amount handling
     $('#customAmount').on('input', function() {
        let customAmount = parseFloat($(this).val()) || 0;
        let totalFees = parseFloat($('#remainingBalance').text()) || 0;
        let remainingBalance = totalFees - customAmount;
        
        // Get current payment count
        let paymentCount = parseInt($('#paymentCount').text()) || 0;
        
        if (paymentCount >= 3) {
            $(this).addClass('is-invalid');
            $('.paymentSubitButton').prop('disabled', true);
            Swal.fire({
                title: "Error!",
                text: "Maximum payment count (3) reached for this fee.",
                icon: "error"
            });
            return;
        }
        
        // Update remaining balance display
        // $('#remainingBalance').text(remainingBalance.toFixed(2));
        
        // Validate amount
        if (customAmount <= 0 || customAmount > totalFees) {
            $(this).addClass('is-invalid');
            $('.paymentSubitButton').prop('disabled', true);
        } else {
            $(this).removeClass('is-invalid');
            $('.paymentSubitButton').prop('disabled', false);
        }
    });
});

</script>

</div>
