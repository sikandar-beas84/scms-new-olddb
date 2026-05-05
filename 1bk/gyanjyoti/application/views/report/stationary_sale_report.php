
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
 <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-pzjw8f+ua7Kw1TIq0mTqjL1vcM5JSm9Wjc15+fXkRzjiAa9/4SOnjl92mye3sMMm" crossorigin="anonymous">
    
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
                    <button class="btn btn-primary float-end" onclick="exportToExcel()">
                        <i class="fas fa-file-excel me-2"></i>Export to Excel
                    </button>
                    <button class="btn btn-danger float-end" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf me-2"></i>Export to PDF
                    </button>
                </h2>
            </div>
        </div>

        <div class="filter row mb-2 pb-4">
            <!-- Class Filter -->
            <!-- <div class="col-12 col-md-2 col-sm-6 col-lg-2">
                <label for="classFilter" class="text-light">Class</label>
                <select id="class_id" name="class_id" class="form-select">
                    <option value="">Select Class</option>
                    <?php foreach($class as $key=>$v): ?>
                    <option value="<?=$key;?>"><?=$v;?></option>
                    <?php endforeach; ?>
                </select>
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
                    <label for="teachers" class="text-light">Collected By</label>
                    <select id="teachers" name="teachers" class="form-select">
                        <option value="">Select Collected By</option>
                        <?php foreach($staff as $key=>$v): ?>
                            <option value="<?=$key;?>"><?=$v;?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            <!-- Filter Button -->
            <div class="col-12 col-md-1 col-sm-12 col-lg-1 d-flex align-items-end">
                <button type="button" class="btn btn-success w-100 filterButton">Filter</button>
            </div>
        </div>
        <div id="filterData">
        </div>

        
        
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
 <!-- SheetJS for Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

    <script>
    var baseUrl = '<?= base_url(); ?>';
    var pageURL = 'report/stationary_sale_report/';
   
    $('.filterButton').click(function() {
        var teachers = $('#teachers').val();
        var toDate = $('#toDate').val();
        var fromDate = $('#fromDate').val();
        

        // if (class_id ) {
            $("#divLoading").show();

            // Use ajaxPostRequest for the AJAX call
            ajaxPostRequest(baseUrl + pageURL + 'load_stationary_sale_report_ajax', {
                teachers: teachers,
                toDate: toDate,
                fromDate: fromDate,
            }, function(data) {
                // console.log(data);
                // No need to use JSON.parse since jQuery will already parse JSON
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

function exportToPDF() {
    const element = document.getElementById('filterData'); // Your table ID

    const options = {
        margin: 1,
        filename: 'Admission_Report.pdf',
        html2canvas: { scale: 2 },
        jsPDF: { orientation: 'portrait' },
    };

    // Generate PDF
    html2pdf().set(options).from(element).save();
}


function exportToExcel() {
    // Get the table element
     var table = document.getElementById('listTableReport')

    // Convert the table to a worksheet using xlsx.utils.table_to_sheet
    var ws = XLSX.utils.table_to_sheet(table);

    // Create a new workbook
    var wb = XLSX.utils.book_new();
    
    // Append the worksheet to the workbook
    XLSX.utils.book_append_sheet(wb, ws, "Applications Data");

    // Write the workbook to a file and trigger the download
    XLSX.writeFile(wb, "applications_data.xlsx");
}


    </script>

