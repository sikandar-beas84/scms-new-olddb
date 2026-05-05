<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .btn {
        gap: 6px;
    }
</style>


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

<div class="content">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Search</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="mb-3">
                        <select class="form-select" name="class_id" id="class_id">
                            <option value="">Select Class</option>
                            <!-- <option value="all">All Class</option> -->
                            <?php if(!empty($class_list)){
                                foreach($class_list as $class){ ?>
                                    <option value="<?php echo $class['id']; ?>"><?php echo $class['class_name']; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="mt-2">
                        <label for="sec_lang">Student: 2nd Language: </label>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" value="Bengali" name="sec_lang" id="sec_lang_bengali" checked="">
                            <label class="form-check-label" for="cr_l_i_s">Bengali</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" value="Hindi" name="sec_lang" id="sec_lang_hindi">
                            <label class="form-check-label" for="cr_l_i_s">Hindi</label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="mb-3">
                        <button type="button" id="stationaryListSearch" class="btn btn-primary ms-3">Go <i class="ph-paper-plane-tilt ms-2"></i></button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<div id="showStationaryItems" style="display: none;">
    <!-- Content area -->
    <div class="content">

        <!-- Page length options -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">All <?= $title ?></h5>
            </div>
            
            <div id="showMsg"></div>

            <div class="card-body">
                <table id="stationaryLists" class="display responsive nowrap">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Class Name</th>
                            <th>Language</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Price</th>                         
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- /page length options -->
    </div>
    <!-- /content area -->

    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-cart-plus"></i> Add Item Details</h5>
            </div>

            <form action="#" method="post" id="itemForm">
                <div class="card-body">
                    <table class="table table-bordered align-middle" id="itemTable">
                        <thead class="table-light">
                            <tr>
                                <th>Item Name</th>
                                <th style="width: 120px;">Quantity</th>
                                <th style="width: 120px;">Price</th>
                                <th style="width: 150px;">Total</th>
                                <th style="width: 80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="item_name[]" class="form-control" placeholder="Item name" required></td>
                                <td><input type="number" name="qty[]" class="form-control qty" value="1" min="1" required></td>
                                <td><input type="number" name="price[]" class="form-control price" value="0" step="1" required></td>
                                <td><input type="text" name="total[]" class="form-control total" value="0" readonly></td>
                                <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="bi bi-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <button type="button" class="btn btn-success btn-sm" id="addRow">
                            <i class="bi bi-plus-circle"></i> Add Item
                        </button>

                        <div class="fw-bold fs-5">
                            Grand Total: ₹ <span id="grandTotal">0.00</span>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="button" class="btn btn-primary" id="saveTblcItems">
                        <i class="bi bi-save"></i> Save Items
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="limitlessModal"  tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="editItemForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="itemModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="item_id" name="id">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Item Name</label>
                            <input type="text" class="form-control" name="item_name" id="item_name" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Qty</label>
                            <input type="number" class="form-control qty" name="qty" id="qty" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" step="1" class="form-control price" name="price" id="price" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Total Price</label>
                            <input type="number" step="1" class="form-control total" name="total_price" id="total_price" required readonly>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="updateStationaryData" class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tableBody = document.querySelector('#itemTable tbody');
        const addRowBtn = document.getElementById('addRow');
        const grandTotalEl = document.getElementById('grandTotal');

        function calculateRowTotal(row) {
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const price = parseFloat(row.querySelector('.price').value) || 0;
            const total = qty * price;
            row.querySelector('.total').value = total;
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('.total').forEach(t => {
                grandTotal += parseFloat(t.value) || 0;
            });
            grandTotalEl.textContent = grandTotal;
        }

        addRowBtn.addEventListener('click', function () {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
              <td><input type="text" name="item_name[]" class="form-control" placeholder="Item name" required></td>
              <td><input type="number" name="qty[]" class="form-control qty" value="1" min="1" required></td>
              <td><input type="number" name="price[]" class="form-control price" value="0" step="1" required></td>
              <td><input type="text" name="total[]" class="form-control total" value="0" readonly></td>
              <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="bi bi-trash"></i></button></td>
            `;
            tableBody.appendChild(newRow);
        });

        tableBody.addEventListener('input', function (e) {
            if (e.target.classList.contains('qty') || e.target.classList.contains('price')) {
                calculateRowTotal(e.target.closest('tr'));
            }
        });

        tableBody.addEventListener('click', function (e) {
            if (e.target.closest('.removeRow')) {
                e.target.closest('tr').remove();
                calculateGrandTotal();
            }
        });

        // AUTO CALCULATE TOTAL INSIDE MODAL
        function updateModalTotal() {
            let qty   = parseFloat($('#qty').val()) || 0;
            let price = parseFloat($('#price').val()) || 0;
            let total = qty * price;
            $('#total_price').val(total);
        }

        // ON TYPING IN QTY OR PRICE
        $(document).on('input', '#qty, #price', function() {
            updateModalTotal();
        });
    });

    var table;   // declare global
    var  base_url = "<?= base_url(); ?>";

    $(document).ready(function() {

        function resetItemForm() {
            // Clear table body
            const itemTableBody = $('#itemTable tbody');
            itemTableBody.empty();

            // Add one fresh row
            const newRow = `
                <tr>
                    <td><input type="text" name="item_name[]" class="form-control" placeholder="Item name" required></td>
                    <td><input type="number" name="qty[]" class="form-control qty" value="1" min="1" required></td>
                    <td><input type="number" name="price[]" class="form-control price" value="0" step="1" required></td>
                    <td><input type="text" name="total[]" class="form-control total" value="0" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="bi bi-trash"></i></button></td>
                </tr>
            `;

            itemTableBody.append(newRow);

            // Reset grand total
            $('#grandTotal').text("0.00");
        }

        $("#saveTblcItems").on("click", function(e) {
            let items = [];
            let isValid = true;

            $("#itemTable tbody tr").each(function() {

                let item_name = $(this).find('input[name="item_name[]"]').val().trim();
                let qty = $(this).find('input[name="qty[]"]').val();
                let price = $(this).find('input[name="price[]"]').val();
                let total = $(this).find('input[name="total[]"]').val();

                // Validate fields
                if (item_name === "") {
                    isValid = false;
                    $(this).find('input[name="item_name[]"]').addClass("is-invalid");
                } else {
                    $(this).find('input[name="item_name[]"]').removeClass("is-invalid");
                }

                if (qty === "" || qty <= 0) {
                    isValid = false;
                    $(this).find('input[name="qty[]"]').addClass("is-invalid");
                } else {
                    $(this).find('input[name="qty[]"]').removeClass("is-invalid");
                }

                if (price === "" || price <= 0) {
                    isValid = false;
                    $(this).find('input[name="price[]"]').addClass("is-invalid");
                } else {
                    $(this).find('input[name="price[]"]').removeClass("is-invalid");
                }

                items.push({
                    item_name: item_name,
                    qty: qty,
                    price: price,
                    total: total
                });
            });

            if (!isValid) {
                Swal.fire({
                    icon: "error",
                    title: "Required",
                    text: "All fields are required and must be valid."
                });
                return;
            }

            // Extra values
            let class_id = $("#class_id").val();
            let sec_lang = $("input[name='sec_lang']:checked").val();

            // AJAX
            $.ajax({
                url: "<?= base_url('admin/stationary-items/save-items') ?>",
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify({
                    class_id: class_id,
                    sec_lang: sec_lang,
                    items: items
                }),
                success: function(res) {
                    if (res.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Saved!",
                            text: res.message
                        });

                        if (typeof table !== "undefined") {
                            table.ajax.reload();
                        }
                        resetItemForm()
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: res.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "AJAX Error",
                        text: "Could not send request."
                    });
                }
            });

        });

        table = $('#stationaryLists').DataTable({
            pageLength: 25, // 👈 default number of rows per page
            lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            responsive: true,
            ajax: {
                url: "<?= base_url('admin/stationary-items/ajax-item-list') ?>",
                dataSrc: function(json) {
                    console.log(json); // 👈 check actual response
                    // save class_list in a global variable
                    class_id = json.class_id || '';
                    sec_lang = json.sec_lang || '';
                    return json.item_list || json; // if "item_list" key exists, return it, else raw
                },
                type: 'POST',
                dataType: 'json',
                data: function (d) {
                    d.class_id = $('#class_id').val();
                    d.lang_name = $("input[name='sec_lang']:checked").val();
                },
            },
            columns: [
                { 
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1; // auto-increment serial number
                    }
                },
                { data: 'class_name' },
                { data: 'sec_lang' },
                { data: 'item_name' },
                { data: 'qty' },
                { data: 'price' },
                { 
                    data: null,
                    render: function(data, type, row) {
                        return row.price * row.qty;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                            <div class="hidden-sm hidden-xs btn-group">
                                <a class="btn btn-xs btn-info" href="javascript:void(0);" 
                                   onclick="update_tblc_item(${row.id});">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <a class="btn btn-xs btn-danger" href="javascript:void(0);" 
                                   onclick="delete_tblc_item(${row.id});">
                                   <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        `;
                    }
                }
            ],
            columnDefs: [
                { targets: 0, visible: true, searchable: false, orderable: true }
            ],
            order: [[0, 'asc']],
            scrollX: true,
            serverSide: false,  // 👈 this is key
            processing: true,
        });

        // 🔥 SHOW / HIDE TABLE WRAPPER
        table.on('xhr.dt', function () {
            let data = table.ajax.json();

            // No data?
            // if (!data || (Array.isArray(data.item_list) && data.item_list.length === 0)) {
            //     $('#showStationaryItems').hide();
            // } else {
                $('#showStationaryItems').show();
            // }
        });

        $('#stationaryListSearch').on('click', function(e) {
            let class_id = $('#class_id').val();
            let lang_name = $("input[name='sec_lang']:checked").val();

            if(class_id==''){
                alert('Please select class name');
                return false;
            } else if(lang_name==''){
                alert('Please choose 2nd language');
                return false;
            }

            table.ajax.reload();
        });

        
        $("#updateStationaryData").on("click", function(e) {
            // Get field values
            let item_name = $("#item_name").val().trim();
            let qty = $("#qty").val().trim();
            let price = $("#price").val().trim();

            // SWEET ALERT VALIDATION
            if (item_name === "") {
                Swal.fire({
                    icon: "warning",
                    title: "Missing Field",
                    text: "Item Name is required"
                });
                $("#item_name").focus();
                return;
            }

            if (qty === "" || qty <= 0) {
                Swal.fire({
                    icon: "warning",
                    title: "Invalid Quantity",
                    text: "Quantity must be greater than 0"
                });
                $("#qty").focus();
                return;
            }

            if (price === "" || price <= 0) {
                Swal.fire({
                    icon: "warning",
                    title: "Invalid Price",
                    text: "Price must be greater than 0"
                });
                $("#price").focus();
                return;
            }

            // AJAX SUBMIT
            $.ajax({
                url: "<?= base_url('admin/stationary-items/update-stationary-item'); ?>",
                type: "POST",
                data: $("#editItemForm").serialize(),
                dataType: "json",

                success: function (res) {
                    if (res.status === "success") {

                        $('#limitlessModal').modal('hide');
                        table.ajax.reload();

                        Swal.fire({
                            icon: "success",
                            title: "Saved Successfully",
                            text: res.message
                        });

                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: res.message
                        });
                    }
                }
            });
        });
    });

    function delete_tblc_item(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to delete this item?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "admin/stationary-items/delete-item",
                    type: "POST",
                    data: { id: id },
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire("Deleted!", response.message, "success");
                            table.ajax.reload();
                        } else {
                            Swal.fire("Error!", response.message, "error");
                        }
                    },
                    error: function () {
                        Swal.fire("Error!", "Request failed!", "error");
                    }
                });
            }
        });
    }

    function update_tblc_item(id) {
        var myModal = document.getElementById('itemModal');
  
        // myModal.hide()

        $.ajax({
            url: base_url + "admin/stationary-items/get-item-details",
            type: "POST",
            data: { id: id },
            dataType: "json",
            success: function (response) {
                console.log(response)
                if (response.status == 'success') {
                    console.log("show modal")
                    let item = response.data;

                    // Set values in modal inputs
                    $("#item_id").val(item.id);
                    $("#item_name").val(item.item_name);
                    $("#qty").val(item.qty);
                    $("#price").val(item.price);

                    // Auto-calc total
                    $("#total_price").val(item.qty * item.price);

                    $('#limitlessModal').modal('show');

                    // myModal.modal('show')
                } else {
                    // myModal.modal('hide')
                }
            },
            error: function () {
                // myModal.modal('hide')
                Swal.fire("Error!", "Data not found!", "error");
            }
        });
    }
</script>