<style type="text/css">
    .modal-backdrop.show {
        display: none;
    }
    table#listTable {
        display: table;
    }
    .alert.alert-danger {
    background: red;
}
</style>

<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

<div class="page-body">


    <!-- Container-fluid starts-->
   <!-- Container-fluid starts-->
   <div class="container-fluid crypto-dash">
        <div class="card">
            <div class="card-body">
            <!-- <form action="<?php echo base_url();?>roll/index/allot_students_roll_num" method="post">	 -->
            <form method="POST" action="#" id="mainForm" enctype="multipart/form-data" >
                <div class="filter row mb-2 pb-4">
                    
                   
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
            
                <table class="table no-footer dataTable" id="listTable">
                </table>
                <div class="col-xs-12 center"> 
                    <button type="submit" class="btn btn-info">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Generate Students Roll No (No of Student - <span id="count"></span>)
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    
    <script>
    var baseUrl = '<?= base_url(); ?>';
    var pageURL = 'roll/index/';
    var formId = 'mainForm';                         

    $('#class_id').change(function() {
        var class_id = $(this).val();
        $('#section_id').empty();

        if (class_id) {
            ajaxPostRequest(baseUrl + 'attendance/add_edit_attendance/get_sections_by_class_id', { classId: class_id }, function(data) {
                $.each(data, function(key, val) {
                    $('#section_id').append($('<option>').val(key).text(val));
                });
            });
        }
    });

    $('.filterButton').click(function() {
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
//    alert(class_id);
    if (class_id  && section_id != 0) {
        // AJAX call using ajaxPostRequest function
        ajaxPostRequest(baseUrl + pageURL + 'ajax_request_for_generate_student_roll', {
            class_id: class_id,
            section_id: section_id
        }, function(data) {
            // Directly use the parsed JSON data
            $('table').empty();
            $('table').append(data.html);
            $('#count').html(data.no_of_student);
        });
    } else {
        showToast('Select Class and Section first', 'error');
    }
});
$("#" + formId).submit(function(event) {
            event.preventDefault();
                ajaxFromSubmit(baseUrl + pageURL + 'allot_students_roll_num', this, function(data) {
                    if (data.status == 'success') {
                        
                        setTimeout(function() {
                            location.reload();
                        }, 2000); 

                    }
                });

        });


    </script>
</div>
