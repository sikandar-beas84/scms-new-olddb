<!-- Page header -->
<style>
    .st {
        background-color: #FFA500;
        border-color: #FFA500;
    }
    .welcomeText {
        font-size: 28px;
        font-weight: 600;
        color: #0d6efd;
    }
    .dashboard-title {
        font-size: 20px;
        font-weight: 500;
        color: #000;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 14px;
        width: 14px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #0d6efd;
    }

    input:checked + .slider:before {
        transform: translateX(20px);
    }
    
    .icon-bg {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex
;
    align-items: center;
    justify-content: center;
}
.bg-success-subtle {
    background-color: #d1e7dd !important;
}
h6.card-title, h3 {
    color: #fff;
}
h3.mb-0.mt-1.mb-2 {
    color: #000;
}
</style>
<?php if(get_session('user_type') != 'students'){ ?>
<div class="page-header d-xl-flex d-block">
    <div class="page-leftheader">
        <h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Dashboard</span></h4>
    </div>
    <div class="page-rightheader ms-md-auto">
        <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
            <div class="d-flex breadcrumb-res">
                <div class="header-datepicker me-3">
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="feather feather-calendar"></i>
                        </div>
                        <input class="form-control fc-datepicker pb-0 pt-0" value="<?= date('M d,Y') ?>" type="text" disabled>
                    </div>
                </div>
                <div class="header-datepicker picker2 me-3">
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="feather feather-clock"></i>
                        </div>
                        <input id="tpBasic" type="text" placeholder="<?= date('h:i A') ?>" class="form-control input-small pb-0 pt-0" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page header -->

<!-- Dashboard Welcome -->


<!-- Dashboard List -->
<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <div class="mt-0 text-start">
                            <span class="fs-14 font-weight-semibold">Total Students</span>
                            <h3 class="mb-0 mt-1 mb-2"><?= $total_students ?></h3>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="icon1 bg-primary brround my-auto float-end"> <i class="fa fa-users"></i> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <div class="mt-0 text-start">
                            <span class="fs-14 font-weight-semibold">Total Teachers</span>
                            <h3 class="mb-0 mt-1 mb-2"><?= $total_teachers ?></h3>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="icon1 bg-primary my-auto float-end"> <i class="fa fa-users"></i>  </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <div class="mt-0 text-start">
                            <span class="fs-14 font-weight-semibold">Total Admissions</span>
                            <h3 class="mb-0 mt-1 mb-2"><?= $total_admissions ?></h3>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="icon1 bg-primary my-auto float-end"> <i class="fa fa-user-plus"></i> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <div class="mt-0 text-start">
                            <span class="fs-14 font-weight-semibold">Total Form Fill Up</span>
                            <h3 class="mb-0 mt-1 mb-2"><?= $total_form_fill_up ?></h3>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="icon1 bg-primary my-auto float-end"> <i class="fa fa-user-plus"></i> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <div class="col-md-4 col-lg-3">
        <div class="card stat-card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Amount Received</h6>
                        <h3 class="mb-0"><?=((int)$total_payment_received + (int)$total_form_cash_fill_up + (int)$total_form_qr_fill_up) ? ((int)$total_payment_received + (int)$total_form_cash_fill_up + (int)$total_form_qr_fill_up) : 0; ?></h3>
                    </div>
                    <div class="icon-bg bg-success-subtle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16" style="color: #000 !important;">
                          <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                          <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                          <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                          <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                        </svg>
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
                        <h3 class="mb-0"><?=($payment_collections['total_cash_collection'] + $total_form_cash_fill_up) ? ($payment_collections['total_cash_collection'] + $total_form_cash_fill_up) : 0; ?></h3>
                    </div>
                    <div class="icon-bg bg-success-subtle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cash-stack" viewBox="0 0 16 16"  style="color: #000 !important;">
                          <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                          <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2z"/>
                        </svg>
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
                        <h3 class="mb-0"><?=($payment_collections['total_qr_collection'] + $total_form_qr_fill_up)  ? ($payment_collections['total_qr_collection'] + $total_form_qr_fill_up) : 0; ?></h3>
                    </div>
                    <div class="icon-bg bg-success-subtle">
                        <i class="fa fas fa-qrcode fa-2x " style="font-size: 26px !important;"></i>
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
                        <h3 class="mb-0"><?=$payment_collections['total_online_collection'] ? $payment_collections['total_online_collection'] : 0; ?></h3>
                    </div>
                    <div class="icon-bg bg-success-subtle">
                        <i class="fa fas fa-globe fa-2x text-dark" style="font-size: 26px !important;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Graphs Section -->
<div class="row">
    <div class="col-xl-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="dashboard-title">Student Admissions Over Time</h3>
            </div>
            <div class="card-body">
                <canvas id="enrollmentChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="dashboard-title">Teacher to Student Ratio</h3>
            </div>
            <div class="card-body">
                <canvas id="ratioChart"></canvas>
            </div>
        </div>
    </div>
	<div class="col-xl-12">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Month-wise Payment Data</h5>
				<canvas id="paymentChart"></canvas> <!-- Payment Chart -->
			</div>
		</div>
	</div>
</div>



<!-- Dashboard Section with Toggle -->
<div class="row">
    <!-- Admission Toggle Card -->
    <div class="col-xl-3 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="fs-14 font-weight-semibold">Admission From</span>
                    </div>
                    <div>
                        <label class="switch">
                        <input type="checkbox" id="admissionToggle" <?php echo isset($admissionToggle[0]->is_active) && $admissionToggle[0]->is_active == 'Y' ? 'checked' : ''; ?>>
                        <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <p class="mb-0 text-muted mt-2">Toggle to enable or disable one-off admission from.</p>
            </div>
        </div>
    </div>
    <!-- Admission Toggle Card -->
    <div class="col-xl-3 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="fs-14 font-weight-semibold">Result View</span>
                    </div>
                    <div>
                        <label class="switch">
                            <input type="checkbox" id="resultToggle"  <?php echo isset($resultToggle[0]->is_active) && $resultToggle[0]->is_active == 'Y' ? 'checked' : ''; ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <p class="mb-0 text-muted mt-2">Toggle to enable or disable one-off Result View.</p>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<!-- Toggle Button CSS -->
<style>
    
</style>

<!-- Toggle Button Script -->
<script>
     var baseUrl = '<?= base_url(); ?>';
     var pageURL = 'home/';
    document.getElementById('admissionToggle').addEventListener('change', function () {
        if (this.checked) {
            fromData = {checked: 'Y'};
        } else {
            fromData = {checked: 'N'};
        }

        ajaxPostRequest(baseUrl + pageURL + 'admissionToggle', fromData, function(data) {
            if (data.status == 'success') {
                Swal.fire(data.message, { icon: "success" });
            } else {
                Swal.fire(data.message, { icon: "error" });
            }
        });
    });

    document.getElementById('resultToggle').addEventListener('change', function () {
        if (this.checked) {
            fromData = {checked: 'Y'};
        } else {
            fromData = {checked: 'N'};
        }
        ajaxPostRequest(baseUrl + pageURL + 'resultToggle', fromData, function(data) {
            if (data.status == 'success') {
                Swal.fire(data.message, { icon: "success" });
            } else {
                Swal.fire(data.message, { icon: "error" });
            }
        });
    });
</script>


<div class="col-xl-12 col-md-12 col-lg-12 text-center">
    <p class="welcomeText">Welcome to the Gyanjyoti Public School</p>
</div>
<!-- Dashboard Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
<script>
    const student_enrollment_over_years = <?php echo json_encode($student_enrollment_over_years); ?>;
    const Years = student_enrollment_over_years.map(data => data.enrollment_year);
    const studentCounts = student_enrollment_over_years.map(data => data.total_students);
    var ctx1 = document.getElementById('enrollmentChart').getContext('2d');
    var enrollmentChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: Years,
            datasets: [{
                label: 'Admissions',
                data: studentCounts,
                borderColor: '#0d6efd',
                fill: false
            }]
        }
    });

    var ctx2 = document.getElementById('ratioChart').getContext('2d');
    var ratioChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Teachers', 'Students'],
            datasets: [{
                data: [<?= $total_teachers ?>, <?= $total_admissions ?>],
                backgroundColor: ['#FFA500', '#0d6efd']
            }]
        }
    });
</script>
<!-- Month-wise Payment Data Chart -->
<script>
     const monthly_payment_data = <?php echo json_encode($monthly_payment_data); ?>;
     const month = monthly_payment_data.map(data => data.payment_month);
     const total_payment_received = monthly_payment_data.map(data => data.total_payment_received);
    var ctx = document.getElementById('paymentChart').getContext('2d');
    var paymentChart = new Chart(ctx, {
        type: 'line', // You can change it to 'bar' if you prefer a bar chart
        data: {
            labels: month,
            datasets: [{
                label: 'Total Payments',
                data: total_payment_received, // Example payment data for each month
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: true
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
</script>