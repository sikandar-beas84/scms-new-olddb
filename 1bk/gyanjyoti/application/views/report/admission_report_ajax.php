<!-- Stats Cards -->
<div class="row g-4 mb-4">
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Applications</h6>
                                <h3 class="mb-0"><?=$count['total_applications']; ?></h3>
                            </div>
                            <div class="icon-bg bg-primary-subtle">
                                <i class="fas fa-file-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Approved</h6>
                                <h3 class="mb-0"><?=$count['approved_count']; ?></h3>
                            </div>
                            <div class="icon-bg bg-success-subtle">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Pending</h6>
                                <h3 class="mb-0"><?=$count['pending_count']; ?></h3>
                            </div>
                            <div class="icon-bg bg-warning-subtle">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card bg-danger text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Rejected</h6>
                                <h3 class="mb-0"><?=$count['rejected_count']; ?></h3>
                            </div>
                            <div class="icon-bg bg-danger-subtle">
                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card bg-info text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Re Admission Students</h6>
                                <h3 class="mb-0"><?=$studentCount['re_admission_students']; ?></h3>
                            </div>
                            <div class="icon-bg bg-info-subtle">
                                <i class="fas fa-users fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card bg-secondary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Students</h6>
                                <h3 class="mb-0"><?=$studentCount['student']; ?></h3>
                            </div>
                            <div class="icon-bg bg-info-subtle">
                                <i class="fas fa-users fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- Charts Row -->
<div class="6 mb-4">
    <div class="col-lg-6 col-md-12 mb-4">
        <div class=" h-100">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Class Wish Data</h5>
            </div>
            </div>
            <div class="cardbody">
                <canvas id="applicationsChart"  ></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 mb-4">
        <div class=" h-100">
            <div class="card">
            <div class="card-header">
                <h5 class="card-title">Admission Status Distribution</h5>
            </div>
            </div>
            <div class="cardbody">
                <canvas id="statusChart" ></canvas>
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
                    <table class="table table-hover" id="applicationsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student Name</th>
                                <th>Course</th>
                                <th>Application Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>001</td>
                                <td>John Doe</td>
                                <td>Computer Science</td>
                                <td>2024-03-15</td>
                                <td><span class="badge bg-success">Approved</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>002</td>
                                <td>Jane Smith</td>
                                <td>Business Administration</td>
                                <td>2024-03-14</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>003</td>
                                <td>Mike Johnson</td>
                                <td>Engineering</td>
                                <td>2024-03-13</td>
                                <td><span class="badge bg-danger">Rejected</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->

            
        <script>
    // Function to create the Bar chart
    function generateBarChart(classWishData) {
        // Check if the chart already exists and destroy it if it does
        if (window.applicationsChart && window.applicationsChart.destroy) {
            window.applicationsChart.destroy();
        }

        // Extract class names and student counts into separate arrays for the chart
        const classNames = classWishData.map(data => data.class_name);
        const studentCounts = classWishData.map(data => data.student_count);

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
        $('#applicationsTable').DataTable({
            pageLength: 5,
            lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]]
        });

        // Call the chart generation functions with dynamic data
        const classWishData = <?php echo json_encode($class_wish_data); ?>;
        generateBarChart(classWishData);

        const approvedCount = <?=$count['approved_count']; ?>;
        const pendingCount = <?=$count['pending_count']; ?>;
        const rejectedCount = <?=$count['rejected_count']; ?>;
        const reAdmissionCount = <?=$studentCount['re_admission_students']; ?>;
        const totalStudents = <?=$studentCount['student']; ?>;
        generatePieChart(approvedCount, pendingCount, rejectedCount, reAdmissionCount, totalStudents);
    });
</script>
