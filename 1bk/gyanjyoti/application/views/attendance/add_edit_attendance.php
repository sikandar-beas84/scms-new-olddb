

<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

<div class="page-body">
    

    <div class="customModal" id="actionModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-1" id="modalContent">
                <form method="POST" action="counties/save" id="mainForm" enctype="multipart/form-data">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>"
                        value="<?=$this->security->get_csrf_hash()?>">
                    <div class="modal-header mb-3">
                        <h4 class="modal-title"><?=$page_title;?></h4>
                        <button type="button" class="close" id="closeModalBtn" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0" id="actionModalBody"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger actionCloseButton"
                            data-dismiss="modal">Close</button>
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
                <div class="filter row mb-2 pb-4">
                    <div class="col-12  col-md-3 col-sm-3 col-lg-3">
                        <label for="classFilter" class="text-light">Select Date</label>
                        <input autocomplete="off" type="text" class="form-select datepicker" name="date" id="date"/>
                    </div>
                   
                    <div class="col-12  col-md-3 col-sm-3 col-lg-3">
                        <label for="classFilter" class="text-light">Class</label>
                        <select id="class_id" name="class_id" class="form-select">
                            <option value="">Select Class</option>
                            <?php foreach($class as $key=>$v): ?>
                            <option value="<?=$key;?>"><?=$v;?></option>
                            <?php endforeach; ?>
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                    <div class="col-12  col-md-3 col-sm-3 col-lg-3">
                        <label for="classFilter" class="text-light">Section</label>
                        <select id="section_id" class="form-select" name="section_id">
                            <option value="">Select Section</option>
                            
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                    <div class="col-4 col-md-2 col-sm-2 col-lg-2">
                        <button type="button" class="btn btn-success mt-5 p-2 filterButton">Filter</button>
                    </div>
                </div>
            
             

                <form class="form-horizontal" action="javascript:" role="form" id="add_attendance">
                    <div id="student_list"></div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
    var baseUrl = '<?= base_url(); ?>';
    var pageURL = 'attendance/student_attendance/';
    var tableId = 'listTable';
    var formId = 'mainForm';
    var modalId = 'actionModal';
    var modalBody = 'actionModalBody';

    </script>
	<script>
		var baseUrl = '<?= base_url(); ?>';
        var pageURL = 'attendance/add_edit_attendance/';
        var tableId = 'listTable';
        var formId = 'mainForm';
        var modalId = 'actionModal';
        var modalBody = 'actionModalBody';

        $(document).ready(function() {
            // Initialize DataTable for listing students

            // On class change, load sections dynamically
            $('#class_id').change(function() {
                var class_id = $(this).val();
                $('#section_id').empty();
                $('#section_id').append('<option value="0">Select Section</option>');

                if (class_id) {
                    ajaxPostRequest(baseUrl + pageURL + 'get_sections_by_class_id', { classId: class_id }, function(data) {
                        $.each(data, function(key, val) {
                            $('#section_id').append($('<option>').val(key).text(val));
                        });
                    });
                }
            });

            $('.filterButton').click(function() {
                var class_id = $('#class_id').val();
                var section_id = $('#section_id').val();
                var date = $('#date').val();

                if (class_id && date) {
                    $("#divLoading").show();

                    // AJAX request
                    ajaxPostRequest(baseUrl + pageURL + 'ajax_get_students', { classId: class_id, sectionId: section_id, date: date }, function(data) {
                        // No need to use JSON.parse since jQuery will already parse JSON
                        $('#student_list').empty().append(data.html);
                        $('.toggle').show();
                    });
                } else {
                    showToast('Please select Date and Class', 'error');
                }
            });

        });

	</script>

</div>