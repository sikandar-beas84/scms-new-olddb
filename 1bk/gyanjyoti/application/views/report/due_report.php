
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
         <!-- <div class="col-12">
             <h2 class="mb-4">
                 <button class="btn btn-primary float-end" onclick="printContent()">
                     <i class="fas fa-print me-2"></i>Print Report
                    </button>
                </h2>
            </div> -->
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
                
                <div class="col-12 col-md-2 col-sm-6 col-lg-2">
                    <label for="classFilter" class="text-light">Month </label>
                    <select id="payment_month" name="payment_month" class="form-select">
                        <option value="">Select Month</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                    </select>


                </div>
                
                <!-- Filter Button -->
                <div class="col-12 col-md-1 col-sm-12 col-lg-1 d-flex align-items-end">
                    <button type="button" class="btn btn-success w-100 filterButton">Filter</button>
                </div>
            </div>
            <div id="filterData">
                
            </div>
                <div class="card listTableArea  mt-2" >
                    <div class="card-body">
                        
                        <table class="table" id="listTable">
                            <thead class="bg-primary text-white table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Student Code</th>
                                    <th>Name</th>
                                    <th>Due Month</th>
                                    <th> Amount</th>
                                    <th> Contact No</th>
                                    <th> Occupation</th>
                                </tr>
                            </thead>
                            <tbody>
                                </tbody>
                            
                                
                            </table>
                        </div>
                    </div>
                    
                    
                    
                </div>
                
                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
                
                <script>
    var baseUrl = '<?= base_url(); ?>';
    var pageURL = 'report/due_report/';
    var tableId = 'listTable';
    $(".listTableArea").hide();

                    $('.filterButton').click(function() {
                        var class_id = $('#class_id').val();
                        var payment_month = $('#payment_month').val();
                     
                        
                        
                        // if (class_id ) {
                            $("#divLoading").show();
                            if ($.fn.dataTable.isDataTable('#test')) {
                                console.log("11");
                                // Destroy the DataTable instance
                                $('#test').DataTable().clear().destroy();
                            }
                            // Use ajaxPostRequest for the AJAX call
                            ajaxPostRequest(baseUrl + pageURL + 'load_due_report_ajax', {
                                classId: class_id,
                                payment_month: payment_month,
                               
                            }, function(data) {
                                // console.log(data);
                                // No need to use JSON.parse since jQuery will already parse JSON
                                if(data.total_payment_received){
                                    $(".listTableArea").show();
                                    ajaxDataTable(tableId, 10, baseUrl + pageURL + 'load_due_list', '', {
                                        classId: class_id,
                                        payment_month: payment_month,
                                    });
                                }else{
                                    $(".listTableArea").hide();  
                                }
                                $('#filterData').empty().append(data.html);
                                $('.toggle').show();
                                $("#divLoading").hide();
                                $("#sidebar-collapse").click();
            });
      
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


