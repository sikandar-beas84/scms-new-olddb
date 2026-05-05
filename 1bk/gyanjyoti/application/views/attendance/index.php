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
            <div class="filter row mb-2 pb-4">
                   
                   
                    <div class="col-12  col-md-2 col-sm-2 col-lg-2">
                        <label for="classFilter" class="text-light">Month</label>
                     
                        <select class="form-select" name="month_id" id="month_id">
                            <option value="">Select Month</option>
                            <?php foreach($month as $key => $value){ ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-12  col-md-2 col-sm-2 col-lg-2">
                        <label for="classFilter" class="text-light">Year</label>
                     
                        <select class="form-select" name="year_id" id="year_id">
                            <option value="">Select Year</option>
                            <?php foreach($year as $key => $value){ ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php if(get_session('user_type') != 'student'): ?>
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
                    <div class="col-12  col-md-2 col-sm-2 col-lg-2">
                        <label for="classFilter" class="text-light">Student id</label>
                        <input type="text" id="student_id" name="student_id" value="">
                    </div>
                    <?php else: ?>
                        <input type="hidden" id="student_id" name="student_id" value="<?= get_session('user_id') ?>">
                    <?php endif; ?>

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
										<div id="student_list"></div>	
                                        									
									</div>
								</div>
							</div>
						</div>
						
						<div class="row toggle">
							<div class="col-sm-4 pull-right">
								<div class="custom-row">
									<div class="alert alert-success col-sm-6">
										<strong>H for</strong> Half Day<br>
										<strong>F for </strong> Full Day
									</div>
									<div class="alert alert-info col-sm-6">
										<strong>P for</strong> Present<br>
										<strong>A for </strong> Absent
									</div>
								</div>
							</div>
						</div>
					</div><!-- /.page-content -->
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

    $(document).ready(function() {
        ajaxDataTable(tableId, 10, baseUrl + pageURL + 'list');
    });
 // On class change, load sections dynamically
    $('#class_id').change(function() {
        var class_id = $(this).val();
        $('#section_id').empty();

        if (class_id) {
            ajaxPostRequest(baseUrl + 'attendance/add_edit_attendance/get_sections_by_class_id', { classId: class_id }, function(data) {
                $('#section_id').append('<option value="0" disabled="" selected="">Select section</option>');
                $.each(data, function(key, val) {
                    $('#section_id').append($('<option>').val(key).text(val));
                });
            });
        }
    });
    $('.filterButton').click(function() {
        var class_id = $('#class_id').val();
        var section_id = $('#section_id').val();
        var month_id = $('#month_id').val();
        var year_id = $('#year_id').val();
        var student_id = $('#student_id').val();

        if (class_id && month_id) {
            $("#divLoading").show();

            // Use ajaxPostRequest for the AJAX call
            ajaxPostRequest(baseUrl + pageURL + 'ajax_get_students_attendance', {
                classId: class_id,
                sectionId: section_id,
                month: month_id,
                year: year_id,
                student_id: student_id
            }, function(data) {
                console.log(data);
                // No need to use JSON.parse since jQuery will already parse JSON
                $('#student_list').empty().append(data.html);
                $('.toggle').show();
                $("#divLoading").hide();
                $("#sidebar-collapse").click();
            });
        } else {
            showToast('Select Month and Class', 'error');
        }
    });

    </script>


</div>