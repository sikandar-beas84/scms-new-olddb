<!-- Stats Cards -->
<div class="row g-4 mb-4">
           <div class="col-md-4 col-lg-3">
                <div class="card stat-card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Amount Received</h6>
                                <h3 class="mb-0"><?=$total_payment_received ? $total_payment_received : 0; ?></h3>
                            </div>
                            <div class="icon-bg bg-success-subtle">
                                <i class="fas fa-file-alt fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card stat-card bg-info text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Cash Payment Received</h6>
                                <h3 class="mb-0"><?=($payment_collections['total_cash_collection'] + $from_payment_collections['total_cash_collection']) ? ($payment_collections['total_cash_collection'] + $from_payment_collections['total_cash_collection']) : 0; ?></h3>
                            </div>
                            <div class="icon-bg bg-info-subtle">
                                <i class="fas fa-money-bill-wave fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card stat-card bg-warning text-dark h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total QR Payment Received</h6>
                                <h3 class="mb-0"><?=($payment_collections['total_qr_collection'] + $from_payment_collections['total_qr_collection'] ) ? ($payment_collections['total_qr_collection'] + $from_payment_collections['total_qr_collection'] ) : 0; ?></h3>
                            </div>
                            <div class="icon-bg bg-warning-subtle">
                                <i class="fas fa-qrcode fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card stat-card bg-danger text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Online Payment Received</h6>
                                <h3 class="mb-0"><?=($payment_collections['total_online_collection'] + $from_payment_collections['total_online_collection']) ? ($payment_collections['total_online_collection'] + $from_payment_collections['total_online_collection']) : 0; ?></h3>
                            </div>
                            <div class="icon-bg bg-danger-subtle">
                                <i class="fas fa-globe fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title">Class Wish Data</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="applicationsChart"></canvas>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- Applications Table -->
        <!-- <div class="card">
            <div class="card-header">
                <h5 class="card-title">Recent Applications</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    
                    <table class="table table-hover " id="test">
                        <thead class="bg-primary text-white table-dark">
                        <tr>
                            <th>#</th>
                           
                            <th>Date</th>
                            <th>Total Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($daily_payment_summary as $k=>$v): ?>
                            <tr>
                                <td><?=$k+1;?></td>
                                <td><?=$v->payment_day;?></td>
                                <td><?=$v->total_payment_received;?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->

            
                   
        <script>
                  // Destroy the existing DataTable if it's already initialized
        // if ($.fn.dataTable.isDataTable('#test')) {
        //     alert("Df");
        //     $('#test').DataTable().clear().destroy();
        // }

        // // Now initialize the DataTable
        // $('#test').DataTable({
        //     pageLength: 5,
        //     lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
        //     dom: 'Bfrtip',  // Defines where the buttons appear (B - Buttons)
        //     buttons: [
        //         {
        //             extend: 'print',
        //             text: 'Print',
        //             className: 'btn btn-primary',  // Optional: Custom button class
        //         },
        //         {
        //             extend: 'csv',
        //             text: 'Export CSV',
        //             className: 'btn btn-success',  // Optional: Custom button class
        //         },
        //         {
        //             extend: 'pdf',
        //             text: 'Export PDF',
        //             className: 'btn btn-danger',  // Optional: Custom button class
        //         }
        //     ]
        // });

    // Function to create the Bar chart
    function generateBarChart(classWishData) {
        // Check if the chart already exists and destroy it if it does
        if (window.applicationsChart && window.applicationsChart.destroy) {
            window.applicationsChart.destroy();
        }

        // Extract class names and student counts into separate arrays for the chart
        const classNames = classWishData.map(data => data.class_name);
        const studentCounts = classWishData.map(data => data.total_payment_received);

        // Bar Chart
        const applicationsCtx = document.getElementById('applicationsChart').getContext('2d');
        window.applicationsChart = new Chart(applicationsCtx, {
            type: 'bar',
            data: {
                labels: classNames,
                datasets: [{
                    label: 'Applications',
                    data: studentCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Function to create the Pie chart
    function generatePieChart(approvedCount, pendingCount, rejectedCount, reAdmissionCount, totalStudents) {
        // Check if the chart already exists and destroy it if it does
        if (window.statusChart && window.statusChart.destroy) {
            window.statusChart.destroy();
        }

        // Pie Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        window.statusChart = new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: ['Approved', 'Pending', 'Rejected', 'Re Admission Students', 'Total Students'],
                datasets: [{
                    data: [approvedCount, pendingCount, rejectedCount, reAdmissionCount, totalStudents],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)',  // Green
                        'rgba(255, 193, 7, 0.8)',   // Yellow
                        'rgba(220, 53, 69, 0.8)',   // Red
                        'rgba(23, 162, 184, 0.8)',  // Teal
                        'rgba(0, 123, 255, 0.8)',   // Blue
                        'rgba(255, 82, 82, 0.8)',   // Light Red
                        'rgba(255, 159, 64, 0.8)',  // Orange
                        'rgba(255, 99, 132, 0.8)',  // Pink
                        'rgba(75, 192, 192, 0.8)',  // Light Green
                        'rgba(153, 102, 255, 0.8)', // Purple
                        'rgba(255, 159, 64, 0.8)'   // Light Orange (Duplicate for example)
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',    // Green
                        'rgba(255, 193, 7, 1)',     // Yellow
                        'rgba(220, 53, 69, 1)',     // Red
                        'rgba(23, 162, 184, 1)',    // Teal
                        'rgba(0, 123, 255, 1)',     // Blue
                        'rgba(255, 82, 82, 1)',     // Light Red
                        'rgba(255, 159, 64, 1)',    // Orange
                        'rgba(255, 99, 132, 1)',    // Pink
                        'rgba(75, 192, 192, 1)',    // Light Green
                        'rgba(153, 102, 255, 1)',   // Purple
                        'rgba(255, 159, 64, 1)'     // Light Orange (Duplicate for example)
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Initialize DataTable
    $(document).ready(function() {
        $('#test').DataTable({
            pageLength: 5,
            lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]]
        });

        // Call the chart generation functions with dynamic data
        const classWishData = <?php echo json_encode($class_payment_summary); ?>;
        // console.log(classWishData);
        generateBarChart(classWishData);

        // const approvedCount = <?=$count['approved_count']; ?>;
        // const pendingCount = <?=$count['pending_count']; ?>;
        // const rejectedCount = <?=$count['rejected_count']; ?>;
        // const reAdmissionCount = <?=$studentCount['re_admission_students']; ?>;
        // const totalStudents = <?=$studentCount['student']; ?>;
        // generatePieChart(approvedCount, pendingCount, rejectedCount, reAdmissionCount, totalStudents);
    });
</script>