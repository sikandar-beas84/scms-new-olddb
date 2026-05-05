<style type="text/css">
.modal-backdrop.show {
    display: none;
}

/* General table styling */
/* .table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
}


.table th {
    background-color: #f4f4f4;
    font-weight: bold;
}

.table tr:hover {
    background-color: #f1f1f1;
}

.table-responsive {
    overflow-x: auto;
} */

/* Coloring for Present, Absent, and Fail */
.green {
    color: green;
}

.red {
    color: red;
}

/* Icons for attendance */
.fa-check.green {
    color: green;
}

.fa-close.red {
    color: red;
}

/* Table inside each cell */
td table {
    width: 100%;
}

td table td {
    padding: 3px;
    border: none;
    /* font-size: 12px; */
}

table#attendance-date thead {
    background: #243448;
}
table#attendance-date th, .table td {
    padding: 10px;
    text-align: center;
    border: 1px solid #ddd;
}
table#attendance-date th {
    font-size: 15px;
}
 .page-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: auto;
 }
/* Make the layout responsive */
@media screen and (max-width: 768px) {

    .table th,
    .table td {
        /* font-size: 10px; */
        padding: 8px;
    }
}
</style>

<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

<div class="page-body">
   


    <!-- Container-fluid starts-->
    <div class="container-fluid crypto-dash">
        <div class="card">
            <div class="card-body">
            <form method="POST" action="#" id="mainForm" enctype="multipart/form-data" >
            <div class="filter row mb-2 pb-4">
                   
                   
                    
                    <div class="col-12  col-md-2 col-sm-2 col-lg-2">
                        <label for="classFilter" class="text-light">Class</label>
                        <select id="class_id" name="class_id" class="form-select">
                            <option value="">Select Class</option>
                            <?php foreach($class as $key=>$v): ?>
                            <option value="<?=$key;?>"><?=$v;?></option>
                            <?php endforeach; ?>
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                    <div class="col-12  col-md-2 col-sm-2 col-lg-2">
                        <label for="classFilter" class="text-light">Section</label>
                        <select id="section_id" class="form-select" name="section_id">
                            <option value="">Select Section</option>
                            
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                    <div class="col-8  col-md-4 col-sm-4 col-lg-4">
                        <label for="studentId" class="text-light">Student Id</label>
                        <input type="text" name="" id="studentId" class="form-select">
                    </div>
                   
                    

                    <div class="col-4 col-md-2 col-sm-2 col-lg-2">
                        <button type="button" class="btn btn-success mt-5 p-2 filterButton">Filter</button>
                    </div>
                </div>

                <div class="page-content">
					
                    <div class="msg"></div>
                    <br>
                

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="filter-info">
                                <div class="table-responsive">
                                    <table class="w-100" id="student_list"></table>	
                                                            
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div><!-- /.page-content -->
                <div class="col-xs-12 center"> 
                    <button type="submit" class="btn btn-info" >
                        <i class="ace-icon fa fa-check bigger-110"></i>
                         <span id="count"></span>Promote Student To Next Class
                    </button>
                </div>		 
            </div>
            </form>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
    var baseUrl = '<?= base_url(); ?>';
    var pageURL = 'student/Re_admission/';
    var tableId = 'listTable';
    var formId = 'mainForm';
    var modalId = 'actionModal';
    var modalBody = 'actionModalBody';


 // On class change, load sections dynamically
    $('#class_id').change(function() {
        var class_id = $(this).val();
        $('#section_id').empty();

        if (class_id) {
            ajaxPostRequest(baseUrl + 'attendance/add_edit_attendance/get_sections_by_class_id', { classId: class_id }, function(data) {
                $.each(data, function(key, val) {
                    $('#section_id').append($('<option>').val(0).text('Select Section'));
                    $('#section_id').append($('<option>').val(key).text(val));
                });
            });
        }
    });
    $('.filterButton').click(function() {
        var class_id = $('#class_id').val();
        var section_id = $('#section_id').val();
        var studentId = $('#studentId').val();


        if (class_id ) {
            $("#divLoading").show();

            // Use ajaxPostRequest for the AJAX call
            ajaxPostRequest(baseUrl + pageURL + 'ajax_re_admission_student_get', {
                classId: class_id,
                sectionId: section_id,
                studentId: studentId,
            }, function(data) {
                console.log(data);
                // No need to use JSON.parse since jQuery will already parse JSON
                $('#student_list').empty().append(data.html);
                $('.toggle').show();
                $("#divLoading").hide();
                $("#sidebar-collapse").click();
            });
        } else {
            showToast('Select  Class and Section first', 'error');
        }
    });
    $("#" + formId).submit(function(event) {
            event.preventDefault();
                ajaxFromSubmit(baseUrl + pageURL + 'promote_to_next_class', this, function(data) {
                    if (data.status == 'success') {
                        
                        setTimeout(function() {
                            location.reload();
                        }, 2000); 

                    }
                });

        });
    </script>


</div>