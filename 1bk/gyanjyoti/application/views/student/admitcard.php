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
        text-align: left;
        border: 1px solid #ddd;
        font-size: 10px;
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
     .downloadButton {
        margin-top: 28px !important;
    }
    /* Make the layout responsive */
    @media screen and (max-width: 768px) {

        .table th,
        .table td {
            /* font-size: 10px; */
            padding: 8px;
        }
    }
    .alert-danger {
        color: #fff;
        background-color: #f7284a !important;
        border-color: #f7284a !important;
    }
    form#mainForm select {
      height: 38px !important;
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
                        <label for="exam_type" class="text-light">Exam Type</label>
                        <select id="exam_type" name="exam_type" class="form-select">
                            <option value="">Select Exam Type</option>
                            <?php foreach($exam_type as $key=>$exam_value): ?>
                                <option value="<?= $exam_value->name; ?>"><?= $exam_value->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12  col-md-2 col-sm-2 col-lg-2">
                        <label for="classFilter" class="text-light">Class</label>
                        <select id="class_id" name="class_id" class="form-select">
                            <option value="">Select Class</option>
                            <?php foreach($class as $key=>$v): ?>
                                <option value="<?=$key;?>"><?=$v;?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12  col-md-2 col-sm-2 col-lg-2">
                        <label for="classFilter" class="text-light">Section</label>
                        <select id="section_id" class="form-select" name="section_id">
                            <option value="">Select Section</option>
                        </select>
                    </div>
                    <div class="col-12  col-md-2 col-sm-2 col-lg-2">
                        <label for="classFilter" class="text-light">Student id</label>
                        <input type="text" id="student_id" name="student_id" value="">
                    </div>
                    
                    <div class="col-4 col-md-3 col-sm-3 col-lg-3">
                        <button type="button" class="btn btn-success mt-5 p-2 filterButton">Generate Admission Card</button>
                    </div>
                    <div class="col-4 col-md-2 col-sm-2 col-lg-2">
                        <button type="button" class="btn btn-danger mt-5 p-2 downloadButton">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Download Id Card
                        </button>
                    </div>

                     <div id="loader" style="display: none; text-align: center; color: #fff;">
                        <p>Generating PDF, please wait...</p>
                        <div class="spinner"></div>
                    </div>
                </div>

                <div class="page-content">
					
                    <div class="msg"></div>
                    <br>
                

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="filter-info">
                                <div class="table-responsive">
                                    <div class="w-100" id="id_card_list">   

                                    </div>	
                                                            
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div><!-- /.page-content -->
                
            </div>
            </form>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    

    <style>
        .spinner {
            border: 5px solid #f3f3f3; /* Light grey */
            border-top: 5px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
    var baseUrl = '<?= base_url(); ?>';
    var pageURL = 'student/admitcard/';
    var tableId = 'listTable';
    var formId = 'mainForm';
    var modalId = 'actionModal';
    var modalBody = 'actionModalBody';

    $(".downloadButton").hide();

    // On class change, load sections dynamically
    $('#class_id').change(function() {
        var class_id = $(this).val();
        $('#section_id').empty();
        $('#section_id').append('<option value="">Select Section</option>');
        if (class_id) {
            ajaxPostRequest(baseUrl + 'attendance/add_edit_attendance/get_sections_by_class_id', { classId: class_id }, function(data) {
                $.each(data, function(key, val) {
                    $('#section_id').append($('<option>').val(key).text(val));
                });
            });
        }
    });

    $('.filterButton').click(function() {
        var exam_type = $('#exam_type').val();
        var class_id = $('#class_id').val();
        var section_id = $('#section_id').val();
        var student_id = $('#student_id').val();


        if (class_id && section_id ) {
            $("#divLoading").show();

            // Use ajaxPostRequest for the AJAX call
            ajaxPostRequest(baseUrl + pageURL + 'get_student_admitcard', {
                examType: exam_type,
                classId: class_id,
                sectionId: section_id,
                studentId: student_id,
            }, function(data) {
                // console.log(data);
                // No need to use JSON.parse since jQuery will already parse JSON
                $('#id_card_list').empty().append(data.html);
                $('.toggle').show();
                $("#divLoading").hide();
                $("#sidebar-collapse").click();
                $(".downloadButton").show();

            });
        } else {
            showToast('Select  Class and Section first', 'error');
        }
    });
   
    // document.addEventListener('DOMContentLoaded', function() {
    //     const downloadButton = document.querySelector('.downloadButton');
        
    //     downloadButton.addEventListener('click', function() {
    //         const element = document.getElementById('id_card_list');
    //         console.log(element)
    //         document.getElementById("loader").style.display = "block";

    //         // Configuration for PDF generation
    //         const opt = {
    //             margin: 10,
    //             filename: 'id_cards.pdf',
    //             image: { type: 'jpeg', quality: 1 },
    //             html2canvas: {  scale: 3, useCORS: true },
    //             jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    //         };

    //         // Generate and download PDF
    //         // html2pdf().from(element).set(opt).save();
    //         html2pdf().from(element)
    //         .set(opt)
    //         .toPdf()
    //         .get('pdf')
    //         .then(() => {
    //             console.log('PDF Generated');
    //         })
    //         .save()
    //         .then(() => {
    //             // Hide the loader after PDF is saved
    //             document.getElementById("loader").style.display = "none";
    //         })
    //         .catch(error => {
    //             console.error("Error generating PDF:", error);
    //             document.getElementById("loader").style.display = "none"; // Hide loader in case of an error
    //         });
    //     });

        

    // });

    document.addEventListener('DOMContentLoaded', function() {
        const downloadButton = document.querySelector('.downloadButton');
        
        downloadButton.addEventListener('click', function() {
            const element = document.getElementById('id_card_list');
            console.log(element);
            
            document.getElementById("loader").style.display = "block";

            // Allow rendering before PDF generation
            setTimeout(() => {
                // Configuration for PDF generation
                const opt = {
                    margin: 10,
                    filename: 'id_cards.pdf',
                    image: { type: 'jpeg', quality: 1 },
                    html2canvas: { 
                        scale: 2,   // Reduced to 2 for performance
                        dpi: 300,   // Higher DPI for better text clarity
                        letterRendering: true,
                        useCORS: true, 
                        allowTaint: true, 
                        logging: true
                    },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
                };

                html2pdf().from(element)
                    .set(opt)
                    .toPdf()
                    .get('pdf')
                    .then(() => {
                        console.log('PDF Generated');
                    })
                    .save()
                    .then(() => {
                        document.getElementById("loader").style.display = "none";
                    })
                    .catch(error => {
                        console.error("Error generating PDF:", error);
                        document.getElementById("loader").style.display = "none";
                    });

            }, 500); // Delay for smoother rendering
        });
    });

    </script>


</div>