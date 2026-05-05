<style type="text/css">
    .modal-backdrop.show {
        display: none;
    }
</style>

<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

<div class="page-body">

  
    <div class="customModal" id="actionModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-1" id="modalContent">
                <form method="POST" action="counties/save" id="mainForm" enctype="multipart/form-data" >
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
                    <div class="modal-header mb-3">
                        <h4 class="modal-title"><?=$page_title;?></h4>
                        <button type="button" class="close" id="closeModalBtn" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0" id="actionModalBody"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger actionCloseButton" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary actionButton">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid crypto-dash">
        <div class="card">
            <div class="card-body">
                <div class="text-end mb-3">
                    <button type="button" class="btn btn-primary buttonBg" data-toggle="modal" data-target="#actionModal" onclick="action(0,3)">
                        <i class="fa fa-plus-square" aria-hidden="true"></i> Add New
                    </button>
                </div>
                <table class="table" id="listTable">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>Book Edition</th>
                            <th>ISBN / ISS No</th>
                            <th>Bill No</th>
                            <th>Book Name</th>
                            <th>Price</th>
                            <th>Language</th>
                            <th>Subject</th>
                            <th>Type</th>
                            <th>Access Number</th>
                            <th>Book Author</th>
                            <th>Book Publisher</th>
                            <th>Entry Date</th>
                            <th>Remarks</th>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    
    <script>
    var baseUrl = '<?= base_url(); ?>';
    var pageURL = 'library/stock/';
    var tableId = 'listTable';
    var formId = 'mainForm';
    var modalId = 'actionModal';
    var modalBody = 'actionModalBody';

    $(document).ready(function() {
        ajaxDataTable(tableId, 10, baseUrl + pageURL + 'list');
    });

    function action(id, action) {
    var fromData = { id: id, action: action };
    if (action == 0) {
        Swal.fire({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this!",
            icon: "warning",
            showCancelButton: true, // Shows the cancel button
            confirmButtonText: "Delete", // Text for the confirm button
            cancelButtonText: "Cancel", // Text for the cancel button
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                ajaxPostRequest(baseUrl + pageURL + 'action', fromData, function(data) {
                    if (data.status == 'success') {
                        Swal.fire({
                            icon: "success",
                            text: data.message
                        });
                        ajaxDataTable(tableId, 10, baseUrl + pageURL + 'list');
                    } else {
                        Swal.fire({
                            icon: "error",
                            text: data.message
                        });
                    }
                });
            } else {
                Swal.fire("Your data is safe!");
            }
        });
    } else {
        holdModal(modalId);
        $(".actionButton").show();
        if (action == '1') {
            $(".actionButton").hide();
        } else if (action == '2') {
            $(".actionButton").html('Update');
        } else {
            $(".actionButton").html('Submit');
        }
        ajaxPostRequest(baseUrl + pageURL + 'action', fromData, function(data) {
            $("#" + modalBody).html(data.html);
        });
    }
}


    $(document).ready(function() {
        $("#" + formId).submit(function(event) {
            event.preventDefault();
            optionalField = [];
            if (formValidationById(formId, optionalField)) {
                ajaxFromSubmit(baseUrl + pageURL + 'save', this, function(data) {
                    if (data.status == 'success') {
                        closeModal(modalId);
                        // ajaxDataTable(tableId, 10, baseUrl + pageURL + 'list');
                        location.reload();

                    }
                });
            }
        });
    });

    var tfoot = $("#" + tableId + " tfoot").html();

    function refreshDataTable() {
        $("#" + tableId + " tfoot").html(tfoot);
        ajaxDataTable(tableId, 10, baseUrl + pageURL + 'list');
    }

    $("#closeModalBtn").click(function(){
        closeModal(modalId);
    });

    $("button.btn.btn-danger.actionCloseButton").click(function(){
        closeModal(modalId);
    });
    </script>
</div>
