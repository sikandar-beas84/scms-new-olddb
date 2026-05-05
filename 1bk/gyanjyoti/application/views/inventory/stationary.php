<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
.card {
    transition: transform 0.3s;
}

.card:hover {
    transform: translateY(-5px);
}

.stat-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.chart-container {
    height: 300px;
    margin-bottom: 20px;
}

.icon-bg {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

a {
    text-decoration: none;
}

@media print {
    /* Ensure Bootstrap is applied during printing */
    @import url('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');

    /* Ensure that the page uses the full width */
    .container {
        width: 100%;
        padding: 0;
    }

    /* Make sure the grid works in print */
    .row {
        display: block;
        width: 100%;
        padding: 0;
    }

    .col-12 {
        width: 100%;
        padding: 0;
    }

    /* Hide print button when printing */
    .btn {
        display: none;
    }

    /* Optional: Adjust the font sizes for better printing */
    h2 {
        font-size: 20px;
    }

    p,
    .content {
        font-size: 16px;
    }

    /* Optional: Adjust spacing for better print readability */
    body {
        margin: 0;
        padding: 10px;
    }
}

input,
select {
    height: 31px !important;
    width: max-content;
}
</style>
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

table#listTable td,
table#listTable th {
    text-align: center;
}

tr input {
    margin-left: 7px;
}

li.nav-item {
    background: #243448;
}
.nav-tabs .nav-link.active:hover {
    color: #000 !important;
}
</style>
<!-- Bootstrap CSS CDN -->
<!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-pzjw8f+ua7Kw1TIq0mTqjL1vcM5JSm9Wjc15+fXkRzjiAa9/4SOnjl92mye3sMMm" crossorigin="anonymous"> -->

<!-- Font Awesome for Print Button Icon -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<!-- Print.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.js"></script>
<div class="container-fluid py-4">
    <!-- Header -->



    <div id="filterData">

        <div class="main-content">
            <div class="main-content-inner">


                <div class="page-content">

                    <!-- Surojit Bera -->
                    <div class="col-sm-12" style="background: #eee;">
                        <div class="filter-info mt-15" id="add_itens_block">


                        <?php if ($this->session->flashdata('success_msg')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> <?= $this->session->flashdata('success_msg'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Error Alert -->
        <?php if ($this->session->flashdata('error_msg')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> <?= $this->session->flashdata('error_msg'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
                        <form id="orderForm" action="<?=base_url();?>inventory/stationary_sell/savestationary/" method="post">
                            <div class="container p-4 bg-light shadow-sm rounded">
                                <!-- Student ID Section -->
                                <div class="form-group mb-4">
                                    <label for="student_code" class="form-label">Student ID <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control student-mask-id" name="student_code" id="student_code" placeholder="Enter Student ID" onblur="getStudentData(this.value)">
                                    <small class="text-muted">Please provide a valid Student ID to fetch details.</small>
                                    <div class="stdInfo mt-2"></div>
                                </div>

                                <!-- Add Item Button -->
                                <div class="d-flex justify-content-end mb-3">
                                    <button type="button" class="btn btn-success btn-sm add_button"><i class="fas fa-plus"></i> Add Item</button>
                                </div>

                                <!-- Item Table -->
                                <table id="item-table" class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Store Name <span class="text-danger">*</span></th>
                                            <th>Item Name <span class="text-danger">*</span></th>
                                            <th>Available Quantity <span class="text-danger">*</span></th>
                                            <th>Selling Rate /Unit <span class="text-danger">*</span></th>
                                            <th>Quantity <span class="text-danger">*</span></th>
                                            <th>Total Amount <span class="text-danger">*</span></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="field_wrapper">
                                        <tr>
                                            <td>
                                                <select class="form-select " id="group_0"
                                                    style="pointer-events: none; background-color: #f5f5f5;"
                                                    aria-label="Default select example"
                                                    onchange="loadItem(this.value,0);" name="group_name[]">
                                                    <option>Select Store </option>
                                                    <?php  foreach($group_list as $value){ ?>
                                                    <option <?= $value->id == '24' ? 'selected' : ''; ?>
                                                        value="<?=$value->id; ?>"><?=$value->name; ?></option>
                                                    <?php  } ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select" id="item_row_0"
                                                    aria-label="Default select example"
                                                    onchange="getAvlQty(this.value, 0); getSellingPrice(this.value, 0)"
                                                    name="Item_name[]">
                                                    <option selected>Select Items </option>
                                                    <!--<?php  foreach($item_list as $value){ ?>-->
                                                    <!--    <option value="<?=$value->item_id; ?>"><?=$value->item_name; ?></option>-->
                                                    <!--  <?php  } ?>-->
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" readonly
                                                    id="available_quantity_0" name="available_quantity[]" value="">
                                            </td>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" readonly id="amount_row_0"
                                                    name="amount[]" value="">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="qty_row_0" name="qty[]"
                                                    value="" oninput="calculateTotal(0)">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" readonly id="total_row_0"
                                                    name="total[]" value="">
                                            </td>
                                            <td align="center">
                                                <a href="javascript:void(0);" class="remove_button"
                                                    data-toggle="tooltip" title="Remove"><button
                                                        class="btn btn-xs btn-primary"><i
                                                            class="ace-icon fa fa-minus"></i></button></a>
                                            </td>
                                        </tr>
                                        <tr id="net-bill-row">
                                            <td colspan="5" class="text-end fw-bold">Net Bill Amount</td>
                                            <td class="font-weight-bold text-center" id="totalAmount">0</td>
                                        </tr>

                                    </tbody>
                                    <!-- <tr>
                                            <td colspan="5" class="text-end fw-bold">Net Bill Amount</td>
                                            <td colspan="2" class="text-center fw-bold" id="totalAmount">0</td>
                                        </tr>
                                    </tfoot> -->
                                  
                                </table>

                                <!-- Payment Details -->
                                <div class="mb-4">
                                    <label for="payee_name" class="form-label">Payee Name</label>
                                    <input type="text" id="payee_name" name="payee_name" class="form-control" placeholder="Enter payee name">
                                </div>
                                <input type="hidden" name="payment_type" id="payment_type" value="1">
                                <input type="hidden" name="totalAmount" id="totalAmountField" value="0">
                                <!-- Payment Tabs -->
                                <ul class="nav nav-tabs" id="paymentTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="cash-tab" data-bs-toggle="tab" href="#cash" role="tab" aria-selected="true">Cash</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="qr-tab" data-bs-toggle="tab" href="#qr" role="tab" aria-selected="false">QR</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="online-tab" data-bs-toggle="tab" href="#online" role="tab" aria-selected="false">Online</a>
                                    </li>
                                </ul>

                                <div class="tab-content mt-3">
                                    <div class="tab-pane fade show active" id="cash" role="tabpanel">
                                        <p>Payment will be made by cash.</p>
                                    </div>
                                    <div class="tab-pane fade" id="qr" role="tabpanel">
                                        <div class="form-group">
                                            <label for="utrNumber" class="form-label">UTR Number</label>
                                            <input type="text" id="utrNumber" class="form-control" name="utr_number" placeholder="Enter UTR Number">
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center mt-4">
                                    <button type="submit" id="payFee" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Pay</button>
                                </div>
                            </div>
                        </form>




                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="filter-info mt-15">
                        <table class="table item_table table-striped table-bordered table-hover"
                            id="DataTables_Table_0">
                            <thead>
                                <tr class="table-dark">

                                    <th>Sl No.</th>
                                    <th>Billing Number</th>
                                    <th>Student id</th>
                                    <th>Name</th>
                                    <th>Class</th>

                                    <!-- <th>Section</th>
                                    <th>Roll</th> -->
                                    <!--<th>Store</th>-->
                                    <!--<th> Item</th>-->
                                    <!--<th>Quantity</th>-->
                                    <!--<th>Amount</th>-->
                                    <!-- <th>Total</th> -->
                                    <th>Payment Info</th>
                                    <th>Date</th>
                                    <th>Action</th>



                                </tr>
                            </thead>
                            <tbody class="">
                                <?php $i = 1; 
								  
								    foreach($list as $k=>$value){ 
								    $student = $this->Student_model->get_students_full_details_by_code($value->student_code);
								    // $section = $this->Student_model->get_section_name_by_id($student->section_id);
	                                // $section_name = $section[0]->section;
								    ?>
                                <tr>

                                    <td><?=$k+1; ?></td>
                                    <td><?=$value->billing_number; ?></td>
                                    <td><?=$value->student_code; ?></td>
                                    <td><?=$student->student_name; ?></td>
                                    <td><?=$student->class_name; ?></td>
                                    <!-- <td><?=$student->section; ?></td>
                                    <td><?=$student->roll; ?></td> -->

                                    <td>
                                        <ul>
                                            <?php if($value->payment_mode == 1){ ?>
                                            <li><b>Payment Mode: </b>Cash</li>
                                            <li><b>Payee Name: </b><?=$student->payee_name; ?></li>
                                            <?php } ?>
                                            <?php if($value->payment_mode == 2){ ?>
                                                <li><b>Payment Mode: </b>Cash</li>
                                                <li><b>Payee Name: </b><?=$value->payee_name; ?></li>
                                            <?php } ?>
                                            <?php if($value->payment_mode == 3){ ?>
                                            <li><b>Payee Name: </b><?=$value->payee_name; ?></li>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                    <td><?=$value->S_Date; ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a class="green"
                                                href="<?= base_url(); ?>inventory/stationary_sell/stationary_print/<?=$value->edit_id; ?>">
                                                <i class="ace-icon fa fa-print bigger-130"></i>
                                            </a>
                                            <?php if($this->session->userdata('user_id') == "3632"){?>
                                            <a class="red" onclick="stationary_delete(<?=$value->edit_id;  ?>)">
                                                <i class="ace-icon fa fa-trash bigger-130"></i>
                                            </a>
                                            <?php } ?>
                                        </div>
                                    </td>

                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <!--<div class="hr hr-double hr8"></div>-->





                </div><!-- /.page-content -->
            </div>
        </div><!-- /.main-content -->
    </div>



</div>

<script>
$(document).ready(function() {
    loadItem(24, 0);
    var maxField = 10; // Maximum input fields
    var addButton = $('.add_button'); // Add button selector
    var wrapper = $('.field_wrapper'); // Input field wrapper
    var rowCount = 1; // Initial field counter


    $("#payee_name").val('Cash');
    var fieldHTML = function(rowIndex) {
        return `<tr id="row_${rowIndex}">
                    <td>
                        <select class="form-select" id="group_${rowIndex}" style="pointer-events: none; background-color: #f5f5f5;"  aria-label="Default select example" onchange="loadItem(this.value, ${rowIndex});" name="group_name[]">
                            <option selected>Select Store</option>
                            <?php foreach($group_list as $value) { ?>
                                <option <?= $value->id == '24' ? 'selected' : ''; ?> value="<?=$value->id; ?>"><?=$value->name; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-select" id="item_row_${rowIndex}" aria-label="Default select example" onchange="getAvlQty(this.value, ${rowIndex}); getSellingPrice(this.value, ${rowIndex})" name="Item_name[]">
                            <option selected>Select Items</option>
                            <!--<?php foreach($item_list as $value) { ?>
                                <option value="<?=$value->item_id; ?>"><?=$value->item_name; ?></option>
                            <?php } ?>-->
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" readonly id="available_quantity_${rowIndex}" name="available_quantity[]" value="" oninput="calculateTotal(${rowIndex})">
                    </td>
                    <td>
                        <input type="text" class="form-control" readonly id="amount_row_${rowIndex}" name="amount[]" value="" oninput="calculateTotal(${rowIndex})">
                    </td>
                    <td>
                        <input type="text" class="form-control" id="qty_row_${rowIndex}" name="qty[]" value="" oninput="calculateTotal(${rowIndex})">
                    </td>
                    <td>
                        <input type="text" class="form-control" readonly id="total_row_${rowIndex}" name="total[]" value="">
                    </td>
                    <td align="center">
                        <a href="javascript:void(0);" class="remove_button" data-toggle="tooltip" title="Remove">
                            <button class="btn btn-xs btn-primary"><i class="ace-icon fa fa-minus"></i></button>
                        </a>
                    </td>
                </tr>`;
    };

    $(addButton).click(function() {
        if (rowCount < maxField) {
            rowCount++; // Increment field counter
            $(fieldHTML(rowCount)).insertBefore('#net-bill-row'); // Add field html
            loadItem(24, rowCount);

        }
    });

    $(wrapper).on('click', '.remove_button', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove(); // Remove field html
        rowCount--; // Decrement field counter
        calculateNetTotal(); // Recalculate net total
    });
});

function calculateTotal(rowIndex) {
    var amount = parseFloat($(`#amount_row_${rowIndex}`).val()) || 0;
    var qty = parseFloat($(`#qty_row_${rowIndex}`).val()) || 0;
    var total = amount * qty;
    $(`#total_row_${rowIndex}`).val(total.toFixed(2));
    calculateNetTotal();
}

function calculateNetTotal() {
    var netTotal = 0;
    $('input[name="total[]"]').each(function() {
        netTotal += parseFloat($(this).val()) || 0;
    });
    $('#totalAmount').text(netTotal.toFixed(2));
    $('#totalAmountField').val(netTotal.toFixed(2));
    // document.getElementById('totalamount').value = netTotal;
    $(".final_amount").val(netTotal);
    // alert(netTotal);
}


$(document).ready(function() {
    $('.item_table').DataTable({
        dom: 'Blfrtip',
        buttons: ['copy', 'csv', 'pdf', 'print'],

    });

});



function update_items(id, iid) {
    var Training_name = $("#Training_name_" + id).val();
    var Category = $("#Category_" + id).val();
    var Expenses = $("#Expenses_" + id).val();

    if (Training_name == "") {
        alert("Please insert Training name");
        return false;
    }
    if (Category == "") {
        alert("Please enter Category");
        return false;
    }
    if (Expenses == "") {
        alert("Please enter Expenses");
        return false;
    }


    $.ajax({
        url: "<?=base_url(); ?>Training/update_training",
        method: "post",
        data: {
            id: iid,
            Training_name: Training_name,
            Category: Category,
            Expenses: Expenses




        },
        success: function(data) {
            var json_obj = JSON.parse(data);
            $("#success_msg").html(json_obj.html);
            $("#item_" + id).find("td:eq(3)").html(name);
            // 	setTimeout(function(){ $("#itemModal"+iid).modal("hide"); }, 1500);
            setTimeout(function() {
                location.reload();;
            }, 1500);
        }
    });
}

function update_item(id) {
    $("#itemModal" + id).modal("show");
}

// function del_sta_item(id) {
//     Swal.fire({
//         title: "Are you sure?",
//         text: "Do you want to delete the item?",
//         icon: "warning",
//         showCancelButton: true,
//         confirmButtonText: "Yes, delete it!",
//         cancelButtonText: "No, keep it"
//     }).then((result) => {
//         if (result.isConfirmed) {
//             $.ajax({
//                 url: "<?= base_url(); ?>ItemRequisition/ajax_del_requisition/",
//                 method: "post",
//                 data: {
//                     id: id
//                 },
//                 success: function(data) {
//                     // Show success alert
//                     Swal.fire({
//                         title: "Success",
//                         text: "Item deleted successfully",
//                         icon: "success"
//                     });

//                     // Reload the page or perform other actions as needed
//                     location.reload();
//                 }
//             });
//         }
//     });
// }

// function reject_sta_item(id) {
//     Swal.fire({
//         title: "Are you sure?",
//         text: "Do you want to Reject it?",
//         icon: "warning",
//         showCancelButton: true,
//         confirmButtonText: "Yes, Reject it!",
//         cancelButtonText: "No, keep it"
//     }).then((result) => {
//         if (result.isConfirmed) {
//             $.ajax({
//                 url: "<?= base_url(); ?>ItemRequisition/rejectsaverequisition/",
//                 method: "post",
//                 data: {
//                     id: id
//                 },
//                 success: function(data) {
//                     Swal.fire({
//                         title: "Success",
//                         text: "Reject successfully",
//                         icon: "success"
//                     });
//                     // location.reload();
//                 }
//             });
//         }
//     });
// }
// 				
</script>
<script>
// $("#group").change(function() {
//     var selectedGroup = $(this).val();

//     // Make an AJAX request to fetch the HTML content based on the selected group
//     $.ajax({
//         url: '<?= base_url() ?>ItemRequisition/loadItem', // Replace with the actual URL for your AJAX request
//         method: 'POST',
//         data: {
//             group: selectedGroup
//         },
//         success: function(response) {
//             // Update the "Item" dropdown with the response HTML
//             $("#item").html(response);
//         },
//         error: function() {
//             Swal.fire({
//                 icon: 'error',
//                 title: 'AJAX Error',
//                 text: 'An error occurred while fetching data.',
//             });
//         }
//     });
// });

function loadItem(id, row) {
    // alert(id);
    // var row = $('#item-table').find('tbody tr'); // 'this' does not refer to the DOM element here
    $.ajax({
        url: "<?=base_url(); ?>inventory/stationary_sell/loadItem",
        method: "post",
        data: {
            group: id
        },
        success: function(data) {
            $("#item_row_" + row).html(data);
        }
    });
}

$(document).ready(function() {
    // Define a function to validate the form
    function validateForm() {
        var group = $("#group").val();
        var item = $("#item").val();
        var quantity = $("#quantity").val();
        var purpose = $("#purpose").val();
        var orderPlacedTo = $("#orderPlacedTo").val();
        var remarks = $("#remarks").val();

        // Perform validation checks (customize these checks based on your requirements)
        if (group === "") {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please select a Store.',
            });
            $("#group").focus();
            $("#group").addClass('border-danger');
            return false;
        }
        if (item === "") {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please select an item.',
            });
            $("#item").focus();
            $("#item").addClass('border-danger');
            return false;
        }
        if (quantity === "") {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please enter a quantity.',
            });
            $("#quantity").focus();
            $("#quantity").addClass('border-danger');
            return false;
        }
        if (purpose === "") {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please enter a purpose.',
            });
            $("#purpose").focus();
            $("#purpose").addClass('border-danger');
            return false;
        }
        if (orderPlacedTo === "") {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please select an order placed to option.',
            });
            $("#orderPlacedTo").focus();
            $("#orderPlacedTo").addClass('border-danger');
            return false;
        }
        if (remarks === "") {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please enter remarks.',
            });
            $("#remarks").focus();
            $("#remarks").addClass('border-danger');
            return false;
        }

        // If all checks pass, allow the form submission
        return true;
    }


    function validateForm2() {
        var approved_quantity = $("#approved_quantity").val();


        if (approved_quantity === "") {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please enter a quantity.',
            });
            $("#quantity").focus();
            $("#quantity").addClass('border-danger');
            return false;
        }

        // If all checks pass, allow the form submission
        return true;
    }

    // Attach the form validation function to the form's submit event
    $("#orderForm").submit(function(event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });

    $(".orderFormUpdate").submit(function(event) {
        if (!validateForm2()) {
            event.preventDefault();
        }
    });
});
</script>
<script>
$(document).ready(function() {
    $("#orderForm2").submit(function(event) {

        event.preventDefault(); // Prevent the form from submitting by default

        // Validate form fields
        const group = $("#group3").val();
        const item = $("#item3").val();
        const quantity = $("#quantity3").val();
        const purpose = $("#purpose3").val();
        const orderPlacedTo = $("#orderPlacedTo3").val();
        const remarks = $("#remarks3").val();
        //  alert(remarks);
        if (group === "") {
            Swal.fire({
                icon: 'error',
                title: 'Please select a Store',
            });
            return;
        }

        if (item === "") {
            Swal.fire({
                icon: 'error',
                title: 'Please select an Item',
            });
            return;
        }

        if (quantity === "") {
            Swal.fire({
                icon: 'error',
                title: 'Please enter a Quantity',
            });
            return;
        }

        if (purpose === "") {
            Swal.fire({
                icon: 'error',
                title: 'Please enter Purpose',
            });
            return;
        }

        if (orderPlacedTo === "") {
            Swal.fire({
                icon: 'error',
                title: 'Please Select Order Placed To',
            });
            return;
        }
        if (remarks === "") {
            Swal.fire({
                icon: 'error',
                title: 'Please Enter A Remarks',
            });
            return;
        }

        // Add more validation checks for other fields as needed

        // If all validations pass, submit the form
        this.submit();
    });
});

function getStudentData(val) {
    if (val != '' && val != '__-____') {
        $.ajax({
            url: "<?=base_url(); ?>inventory/stationary_sell/getStudentData",
            method: "post",
            data: {
                code: val
            },
            success: function(data) {
                $(".stdInfo").html(data);
            }
        });
        $.ajax({
            url: "<?=base_url(); ?>inventory/stationary_sell/getStudentName",
            method: "post",
            data: {
                code: val
            },
            success: function(data) {
                $("#payee_name").val(data);
            }
        });
    } else {
        $("#payee_name").val('Cash');

    }
}

function getAvlQty(val, row) {
    $.ajax({
        url: "<?=base_url(); ?>inventory/stationary_sell/getItemCurrentQty",
        method: "post",
        data: {
            id: val
        },
        success: function(data) {
            if (data == '0') {
                $("#qty_row_" + row).attr('readonly', 'true');
            } else {
                $("#qty_row_" + row).removeAttr('readonly');
            }
            $("#available_quantity_" + row).val(data);
        }
    });
}

function getSellingPrice(val, row) {
    $.ajax({
        url: "<?=base_url(); ?>inventory/stationary_sell/getSellingPrice",
        method: "post",
        data: {
            id: val
        },
        success: function(data) {
            $("#amount_row_" + row).val(data);
        }
    });
}
</script>


<style>
.mt-15 {
    margin-top: 15px;
}

#add_itens_block,
.update_success {
    display: block;
}
</style>

<script>
var paymentmodalId = 'paymentModal';

function stationary_delete(id) {
    var base_url = '<?php echo base_url() ?>';
    var r = confirm("Are You Sure to Delete The Item?");
    if (r == true) {
        window.location.href = base_url + 'ItemRequisition/stationary_delete/' + id;
    }
}

function payment() {
    holdModal(paymentmodalId);
}
$(document).ready(function() {
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
    var selectedID = [];
    var checkboxes = document.querySelectorAll('.fee-checkbox:checked');

    checkboxes.forEach(function(checkbox) {
        selectedID.push(checkbox.getAttribute('data-id'));
    });
    if (selectedID.length > 0) {
        var id = selectedID;
    } else {
        var id = $("#payment_id").val();

    }
    var payment_type = $("#payment_type").val();
    var class_id = $("#class").val();
    var utrNumber = $("#utrNumber").val();
    // Prepare the data object to be sent via AJAX
    var requestData = {
        id: id,
        class_id: class_id,
        payment_type: payment_type,
        utrNumber: utrNumber,

    };

    // Make the AJAX POST request
    ajaxPostRequest(baseUrl + pageURL + 'payment', requestData, function(data) {
        if (data.status == 'success') {
            if (selectedID.length > 0) {
                Swal.fire({
                    title: "Success!",
                    text: data.message,
                    icon: "success",
                }).then(() => {
                    // Reload specific sections after success
                    location.reload();
                });
            } else {
                $("#paymentModalBody").html(data
                .html); // Update the modal content with the server response
                $(".paymentSubitButton").hide(); // Hide the submit button after success
            }
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
</script>
