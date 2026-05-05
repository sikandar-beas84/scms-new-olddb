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
</style>

	<!-- DATATABLES css -->
	<link rel="stylesheet" href="https://gyanjyotipublicschool.com/assets/css/dataTables.bootstrap4.min.css">


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
        <div class="filter row mb-2 pb-4">
            <div class="col-12  col-md-4 col-sm-4 col-lg-4">
                <label for="classFilter" class="text-light">Class</label>
                <select id="classFilter" class="form-select">
                    <option value="">Select Class</option>
                    <?php foreach($class as $key=>$v): ?>
                    <option value="<?=$key;?>"><?=$v;?></option>
                    <?php endforeach; ?>
                    <!-- Options will be populated dynamically -->
                </select>
                
            </div>
            <div class="col-8  col-md-4 col-sm-4 col-lg-4">
                <label for="studentId" class="text-light"><?= $this->uri->segment(4) == 'student' ? 'Student Code' : 'Admission Form No';?></label>
                <input type="text" name="" id="studentId" class="form-select" placeholder="<?= $this->uri->segment(4) == 'student' ? 'Student Code' : 'Admission Form No';?>">
                
            </div>
            <div class="col-4 col-md-2 col-sm-2 col-lg-2">
                <button type="button" class="btn btn-success mt-5 p-2 filterButton" >Filter</button>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <!-- <div class="text-end mb-3">
                    <button type="button" class="btn btn-primary buttonBg" data-toggle="modal" data-target="#actionModal" onclick="action(0,3)">
                        <i class="fa fa-plus-square" aria-hidden="true"></i> Add New
                    </button>
                </div> -->
                <table class="table" id="listTable">
                    <thead class="bg-primary text-white">
                        <tr>
                            <!-- <th>Student ID</th> -->
                            <th>Admission Form No</th>
                            <th>Admission Code</th>
                            <th>Class</th>
                            <th>Section</th>
                            <!-- <th>Roll</th> -->
                            <th>Student Name</th>
                            <th>Banglar Siksha ID</th>
                            <th>PEN</th>
                            <th>Gender</th>
                            <th>DOB</th>
                            <th>Student AAdhar</th>
                            <!-- <th>Permanent Address</th>
                            <th>Present Address</th> -->
                            <!-- <th>Bank A/c No</th>
                            <th>IFSC</th> -->
                            <!-- <th>Religion</th>
                            <th>Category</th> -->
                            <th>Email Id</th>
                            <th>Mother Language</th>
                            <th>2nd Language</th>
                            <th>3rd Language</th>
                            <th>Blood Group</th>
                            <!-- <th>Only Child</th> -->
                            <th>Medical Condition</th>
                            <!-- <th>Academic Status</th> -->
                            <!-- <th>House</th> -->
                            <!-- <th>Nationality</th>
                            <th>Admission No</th> -->
                            <th>Admission Date</th>
                            <!-- <th>BPL</th>
                            <th>TC Require</th>
                            <th>TC Submitted Date</th>
                            <th>Migration Require</th>
                            <th>Migration Submitted Date</th> -->
                            <th>Fathers Details</th>
                            <th>Mothers Details</th>
                            <th>Local Guardian Details</th>
                            <!-- <th>Student Subject Option</th> -->
                            <!-- <th>Assign Academic Status</th>
                            <th>Security Money</th> -->
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                   
                </table>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> -->
    
    <script>
    var baseUrl = '<?= base_url(); ?>';
var pageURL = 'student/student/';
var tableId = 'listTable';
var formId = 'mainForm';
var modalId = 'actionModal';
var paymentmodalId = 'paymentModal';
var modalBody = 'actionModalBody';

$(document).ready(function() {
    // Initialize the DataTable
    // var table = ajaxDataTable(tableId, 10, baseUrl + pageURL + 'list');

    // Handle filter change
    $(".filterButton").click(function() {
        var selectedClass = $("#classFilter").val();  // Avoid using 'class' as a variable name
        var studentId = $("#studentId").val();  // Avoid using 'class' as a variable name
        // alert(selectedClass);
        
            ajaxDataTable(tableId, 10, baseUrl + pageURL + 'list', '', { class: selectedClass, studentId: studentId, application_status: "<?=$this->uri->segment('4'); ?>" });
        
    });


    // Handle form submission

    // Close modal handlers
    $("#closeModalBtn").click(function() {
        closeModal(modalId);
    });
    $("#paymentcloseModalBtn").click(function() {
        closeModal(paymentmodalId);
    });

    $("button.btn.btn-danger.actionCloseButton").click(function() {
        closeModal(modalId);
    });
});

function action(id, action) {
        $("#student_id").val(id);
        $("#payment_student_id").val(id);
        var fromData = { id: id, action: action };
        if (action == 0) {
            Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        ajaxPostRequest(baseUrl + pageURL + 'action', fromData, function(data) {
                            if (data.status == 'success') {
                                Swal.fire(data.message, { icon: "success" });
                                ajaxDataTable(tableId, 10, baseUrl + pageURL + 'list');
                            } else {
                                Swal.fire(data.message, { icon: "error" });
                            }
                        });
                    } else {
                        Swal.fire("Your data is safe!");
                    }
                });
        }else if(action == 4){
            idnew= [];
            idnew.push(id)
            var fromData = { id: idnew };
            ajaxPostRequest(baseUrl + 'student/fees/getMultiMonthFeesDataById', fromData, function(data) {
                if (data.status == 'success') {
                    // console.log(data.data[0]);
                    $("#session_fees").html(data.data.session_fees);
                    $("#payment_id").val(idnew);
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
                // $("#paymentCount").html(data.data.payment_count);
                $("#paymentCount").html(0);
                if(0 >= 2){
                    $('#customAmount').css('cursor', 'pointer'); 
                }
                if(true){
                    $(".hideGroup").show(); 
                }else{
                    $(".hideGroup").hide(); 
                    
                }
                    // Swal.fire(data.message, { icon: "success" });
                    // ajaxDataTable(tableId, 10, baseUrl + pageURL + 'list');
                } else {
                    Swal.fire(data.message, { icon: "error" });
                }
            });
            $("#"+paymentmodalId+" .modal-title").html('Payment');
            holdModal(paymentmodalId);

        }
        
        else {
            holdModal(modalId);
            // $(".actionButton").show();
            if (action == '1') {
                $(".actionButton").hide();
            } else if (action == '2') {
                $(".actionButton").html('Update');
            } else {
                $(".actionButton").html('Submit');
            }
            // ajaxPostRequest(baseUrl + pageURL + 'action', fromData, function(data) {
            //     $("#" + modalBody).html(data.html);
            // });
        }
    }
// Function to initialize DataTable with AJAX
function showNext(action) {
    if (action == 1) { // Approve action
        closeModal(modalId);
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to approve this action?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form or perform approval action
                // $('#mainForm').submit();
                // alert("Submit");
                var fromData = { id: $("#student_id").val(), action: 'approved' };
                ajaxPostRequest(baseUrl + pageURL + 'action', fromData, function(data) {
                    if (data.status == 'success') {
                        Swal.fire(data.message, { icon: "success" });
                        var selectedClass = $("#classFilter").val();  // Avoid using 'class' as a variable name
                        var studentId = $("#studentId").val();  // Avoid using 'class' as a variable name
                        // alert(selectedClass);
                        if (selectedClass || studentId) {
                            ajaxDataTable(tableId, 10, baseUrl + pageURL + 'list', '', { class: selectedClass, studentId: studentId, application_status: "<?=$this->uri->segment('4'); ?>" });
                        }
                    } else {
                        Swal.fire(data.message, { icon: "error" });
                    }
                });
            }
        });
        
        $("#rejectReasonBox").hide();
        $(".actionButton").hide(); // Hide update button as it's not needed for approval

    } else if (action == 2) { // Reject action
        $("#rejectReasonBox").show();
        $(".actionButton").show().html('Submit Rejection'); // Show submit button for rejection
    }
}
function submitReject(action) {
    if ($("#rejectReason").val()) {
       
    }else{
        showToast('Please enter a rejection reason.', 'error');
        return;
    }

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to reject this?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reject it!'
    }).then((result) => {
        if (result.isConfirmed) {
            if ($("#rejectReason").val().trim() !== '') {
                var formData = { id: $("#student_id").val(), action: 'reject', reject_notes: $("#rejectReason").val().trim() };
                ajaxPostRequest(baseUrl + pageURL + 'action', formData, function(data) {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Success',
                            text: data.message,
                            icon: "success"
                        });
                        var selectedClass = $("#classFilter").val();
                        var studentId = $("#studentId").val();
                        if (selectedClass || studentId) {
                            ajaxDataTable(tableId, 10, baseUrl + pageURL + 'list', '', { class: selectedClass, studentId: studentId, application_status: "<?=$this->uri->segment('4'); ?>" });
                        }
                        closeModal(modalId);
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message,
                            icon: "error"
                        });
                    }
                });
            } else {
                showToast('Enter Rejection', 'error');
            }
        }
    });

    // $("#rejectReasonBox").hide();
    // $(".actionButton").hide();
}


function ajaxDataTable(tableId, pageLength, ajaxUrl, fromData='') {
    return $('#' + tableId).DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: ajaxUrl,
            type: 'GET',
            data: function(d) {
                d.class = $('#classFilter').val(); // Include the selected filter value
            }
        },
        pageLength: pageLength,
        // Additional configuration if needed
    });
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
    $('.paymentSubitButton').click(function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get the necessary values from the form inputs
        // var studentId = $("#payment_student_id").val();
        // var payment_type = $("#payment_type").val();
        // var class_id = $("#class").val();
        // var utrNumber = $("#utrNumber").val();
        // var academic_fees = $("#academic_fees").html(); // Get the value from the HTML content
        // var session_fees = $("#session_fees").html(); // Get the value from the HTML content
    // var selectedID = [];

    // selectedID.push($("#payment_id").val());
  
    
    var id = $("#payment_id").val();
    var payment_type = $("#payment_type").val();
    var class_id = $("#class").val();
    var utrNumber = $("#utrNumber").val();
    var customAmount = parseFloat($("#customAmount").val());
    var paymentCount = parseInt($("#paymentCount").text()) || 0;
        // Prepare the data object to be sent via AJAX
        var requestData = {
            id: id,
            class_id: class_id,
            payment_type: payment_type,
            utrNumber: utrNumber,
            amount: customAmount,
            payment_count: paymentCount,
            is_first_payment: 'Y'
        };

        // Make the AJAX POST request
        ajaxPostRequest(baseUrl +  'student/fees/payment', requestData, function(data) {
            if (data.status == 'success') {
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
}

function initiateEazyPayPayment() {
    // Collect payment data from your form
    const paymentData = {
        id: $('#payment_id').val(), // Payment ID
        payment_type: 3, // Payment type (e.g., full, partial)
        is_first_payment: 'Y', // Payment type (e.g., full, partial)
        class_id: $('#class').val(), // Class ID for context
        amount: $('#customAmount').val(), // Total amount to be paid
        customer_name: "Dev", // Customer's name
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
