
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
            
            p, .content {
                font-size: 16px;
            }
            
            /* Optional: Adjust spacing for better print readability */
            body {
                margin: 0;
                padding: 10px;
            }
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
     <div class="row mb-4">
         <div class="col-12">
             <h2 class="mb-4">
                 <button class="btn btn-primary float-end" onclick="printContent()">
                     <i class="fas fa-print me-2"></i>Print Report
                    </button>
                </h2>
            </div>
        </div>
        
        <div class="filter row mb-2 pb-4">
            <!-- Class Filter -->
            <div class="col-12 col-md-2 col-sm-6 col-lg-2">
                <label for="classFilter" class="text-light">Class</label>
                <select id="class_id" name="class_id" class="form-select">
                    <option value="">Select Class</option>
                    <?php foreach($class as $key=>$v): ?>
                        <option value="<?=$key;?>"><?=$v;?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Section Filter -->
                <!-- <div class="col-12 col-md-2 col-sm-6 col-lg-2">
                    <label for="sectionFilter" class="text-light">Section</label>
                    <select id="section_id" class="form-select" name="section_id">
                        <option value="">Select Section</option>
                    </select>
                </div> -->
                
                <!-- Student ID -->
                <!-- <div class="col-12 col-md-3 col-sm-6 col-lg-3">
                    <label for="studentId" class="text-light">Student ID</label>
                    <input type="text" id="studentId" name="student_id" class="form-control" placeholder="Enter Student ID">
                </div> -->
                
                <!-- From Date -->
                <div class="col-12 col-md-2 col-sm-6 col-lg-2">
                    <label for="fromDate" class="text-light">From Date</label>
                    <input type="date" id="fromDate" name="from_date" class="form-control">
                </div>
                
                <!-- To Date -->
                <div class="col-12 col-md-2 col-sm-6 col-lg-2">
                    <label for="toDate" class="text-light">To Date</label>
                    <input type="date" id="toDate" name="to_date" class="form-control">
                </div>
                <div class="col-12 col-md-2 col-sm-6 col-lg-2">
                    <label for="classFilter" class="text-light">Payment Methods</label>
                    <select id="payment_methods" name="payment_methods" class="form-select">
                        <option value="">Select Payment Methods</option>
                        <option value="1">Cash</option>
                        <option value="2">QR</option>
                        <option value="3">Online</option>
                    </select>
                </div>
                
                <!-- Filter Button -->
                <div class="col-12 col-md-1 col-sm-12 col-lg-1 d-flex align-items-end">
                    <button type="button" class="btn btn-success w-100 filterButton">Filter</button>
                </div>
            </div>
            <div id="filterData">
                
            </div>
                <div class="card listTableArea" >
                    <div class="card-body">
                        
                        <table class="table" id="listTable">
                            <thead class="bg-primary text-white table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                </tbody>
                            <tfoot>
                            <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    
                                    <th>Total Amount</th>
                                </tr>
                                </tfoot>
                                
                            </table>
                        </div>
                    </div>
                    
                    
                    
                </div>
                
                <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>-->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
                
                <script>
    var baseUrl = '<?= base_url(); ?>';
    var pageURL = 'report/collocation_report/';
    var tableId = 'listTable';
    $(".listTableArea").hide();
    // var formId = 'mainForm';
    // var modalId = 'actionModal';
    // var modalBody = 'actionModalBody';
    
    
    // On class change, load sections dynamically
    // $('#class_id').change(function() {
        //     var class_id = $(this).val();
        //     $('#section_id').empty();
        
        //     if (class_id) {
            //         ajaxPostRequest(baseUrl + 'attendance/add_edit_attendance/get_sections_by_class_id', { classId: class_id }, function(data) {
                //             $.each(data, function(key, val) {
                    //                 $('#section_id').append($('<option>').val(0).text('Select Section'));
                    //                 $('#section_id').append($('<option>').val(key).text(val));
                    //             });
                    //         });
                    //     }
                    // });
                    $('.filterButton').click(function() {
                        var class_id = $('#class_id').val();
                        var toDate = $('#toDate').val();
                        var fromDate = $('#fromDate').val();
                        var payment_methods = $('#payment_methods').val();
                        
                        
                        // if (class_id ) {
                            $("#divLoading").show();
                            if ($.fn.dataTable.isDataTable('#test')) {
                                console.log("11");
                                // Destroy the DataTable instance
                                $('#test').DataTable().clear().destroy();
                            }
                            // Use ajaxPostRequest for the AJAX call
                            ajaxPostRequest(baseUrl + pageURL + 'load_collocation_report_ajax', {
                                classId: class_id,
                                toDate: toDate,
                                fromDate: fromDate,
                                payment_methods: payment_methods,
                            }, function(data) {
                                // console.log(data);
                                // No need to use JSON.parse since jQuery will already parse JSON
                                if(data.total_payment_received){
                                    $(".listTableArea").show();
                                ajaxDataTable(tableId, 10, baseUrl + pageURL + 'load_collocation_list', '', {
                                        classId: class_id,
                                        toDate: toDate,
                                        fromDate: fromDate,
                                        payment_methods: payment_methods,
                                    });
                                }else{
                                    $(".listTableArea").hide();  
                                }
                                $('#filterData').empty().append(data.html);
                                $('.toggle').show();
                                $("#divLoading").hide();
                $("#sidebar-collapse").click();
            });
            // } else {
                //     showToast('Select  Class and Section first', 'error');
                // }
            });
            
            </script>
<script>
    function printContent() {
        printJS({
            printable: 'filterData', // ID of the content you want to print
            type: 'html',                  // Type of content
            header: 'Print Report',        // Optional: Header of the printed page
            style: 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css' // Include Bootstrap CDN
        });
    }
    </script>


