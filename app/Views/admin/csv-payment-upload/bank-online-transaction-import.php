<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Page header -->
<div class="page-header page-header-primary shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="javascript:;" class="breadcrumb-item"><?= $title ?></a>
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <!-- Custom styles -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0"><?= $title ?></h5>
                </div>

                <div class="container mt-4 mb-4">
                    <h4 class="text-primary">Upload Bank/Online CSV File</h4>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label">Upload File *</label>
                            <input type="file" name="bankonlinefile" id="bankonlinefile" class="form-control" accept=".csv" required>
                        </div>

                        <button id="bankonlinefileButton" type="button" class="btn btn-primary">
                            Import Data
                        </button>

                        <div id="resultArea"></div>
                    </form>

                    <div class="container">
                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <a href="<?= base_url('/public/admin/assets/images/sample_bank_payment_upload.csv') ?>">👉 Download Sample File</a>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Column Index</th>
                                                <th>Field Name</th>
                                                <th>Required</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>0</td>
                                                <td><code>created_date</code></td>
                                                <td><span class="badge bg-danger">Yes</span></td>
                                                <td>Payment date (YYYY-MM-DD format)</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td><code>student_code</code></td>
                                                <td><span class="badge bg-danger">Yes</span></td>
                                                <td>Student code (format like <strong>23-0001</strong>)</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td><code>payment_amount</code></td>
                                                <td><span class="badge bg-danger">Yes</span></td>
                                                <td>Total amount paid by student</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="container mt-4 mb-4">
                    <h4 class="text-danger">Upload Failed Online Payment File</h4>

                    <?php if (session()->getFlashdata('error_msg')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error_msg') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success_msg')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success_msg') ?></div>
                    <?php endif; ?>

                    <form class="form-horizontal" action="<?= base_url('admin/csv-payment-upload/online-failed-payment-save') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label">Upload File *</label>
                            <input type="file" name="failedonlinefile" id="failedonlinefile" class="form-control" accept=".csv" required>
                        </div>

                        <button id="failedonlinefileButton" type="submit" class="btn btn-primary">
                            Import Data
                        </button>
                    </form>

                    <div class="container">
                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <a href="<?= base_url('/public/admin/assets/images/sample_online_failed_payment_upload.csv') ?>">👉 Download Sample File</a>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Column Index</th>
                                                <th>Field Name</th>
                                                <th>Required</th>
                                                <th>Type</th>
                                                <th>Example</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>0</td>
                                                <td>created_date</td>
                                                <td><span class="badge bg-danger">Yes</span></td>
                                                <td>YYYY-MM-DD</td>
                                                <td>2025-04-01</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>student_code</td>
                                                <td><span class="badge bg-danger">Yes</span></td>
                                                <td>String</td>
                                                <td>Student code (format like 23-0001)</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>tuition_fee</td>
                                                <td><span class="badge bg-danger">Yes</span></td>
                                                <td>Numeric</td>
                                                <td>5000</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>tuition_fine</td>
                                                <td><span class="badge bg-danger">Yes</span></td>
                                                <td>Numeric</td>
                                                <td>100</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>bus_fee</td>
                                                <td><span class="badge bg-danger">Yes</span></td>
                                                <td>Numeric</td>
                                                <td>1000</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>bus_fine</td>
                                                <td><span class="badge bg-danger">Yes</span></td>
                                                <td>Numeric</td>
                                                <td>50</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>payment_amount</td>
                                                <td><span class="badge bg-danger">Yes</span></td>
                                                <td>Numeric (&gt; 0)</td>
                                                <td>6150</td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td>transaction_no</td>
                                                <td><span class="badge bg-danger">Yes</span></td>
                                                <td>String</td>
                                                <td>TXN123456</td>
                                            </tr>
                                            <tr>
                                                <td>8</td>
                                                <td>month_id</td>
                                                <td><span class="badge bg-danger">Yes</span></td>
                                                <td>Numeric</td>
                                                <td>4</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container mt-4 mb-4">
                    <h4 class="text-success">Admission/Readmission Failed Upload</h4>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('bt_success_msg')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('bt_success_msg') ?></div>
                    <?php endif; ?>

                    <?php $errors = session()->getFlashdata('bt_errors'); ?>
                    <?php $advance = session()->getFlashdata('advance'); ?>

                    <?php if (!empty($errors)) : ?>
                        <div class="alert alert-danger">
                            <h5>Error List:</h5>
                            <ul class="mb-0">
                                <?php foreach ($errors as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($advance)) : ?>
                        <div class="alert alert-warning">
                            <h5>Advance Payments:</h5>
                            <ul class="mb-0">
                                <?php foreach ($advance as $adv) : ?>
                                    <li><?= esc($adv) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form class="form-horizontal" action="<?= base_url('admin/csv-payment-upload/online-failed-payment-april-save') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label">Upload File *</label>
                            <input type="file" name="readmissionfile" id="readmissionfile" class="form-control" accept=".csv" required>
                        </div>

                        <button id="readmissionfileButton" type="submit" class="btn btn-primary">
                            Import Data
                        </button>
                    </form>

                    <div class="container">
                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <a href="<?= base_url('/public/admin/assets/images/sample_online_failed_payment_april_upload.csv') ?>">👉 Download Sample File</a>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                          <th>Column Index</th>
                                          <th>Field Name</th>
                                          <th>Required</th>
                                          <th>Type</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                          <td>0</td>
                                          <td>created_date</td>
                                          <td><span class="badge bg-danger">Yes</span></td>
                                          <td>YYYY-MM-DD</td>
                                        </tr>
                                        <tr>
                                          <td>1</td>
                                          <td>student_code</td>
                                          <td><span class="badge bg-danger">Yes</span></td>
                                          <td>String</td>
                                        </tr>
                                        <tr>
                                          <td>2</td>
                                          <td>payment_amount</td>
                                          <td><span class="badge bg-danger">Yes</span></td>
                                          <td>Numeric</td>
                                        </tr>
                                        <tr>
                                          <td>3</td>
                                          <td>transaction_no</td>
                                          <td><span class="badge bg-danger">Yes</span></td>
                                          <td>String</td>
                                        </tr>
                                        <tr>
                                          <td>4</td>
                                          <td>month</td>
                                          <td>Optional (fixed 4)</td>
                                          <td>Numeric</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#bankonlinefileButton').on('click', function() {
            
            var fileInput = $('#bankonlinefile')[0];
            var file = fileInput.files[0];

            // Basic validation
            if (!file) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No file selected',
                    text: 'Please select a CSV file.',
                    confirmButtonText: 'OK'
                });

                return;
            }

            if (file.type !== "text/csv" && !file.name.endsWith('.csv')) {
                $('#bankonlinefile').val('');

                Swal.fire({
                    icon: 'warning',
                    title: 'File Type',
                    text: 'Only CSV files are allowed.',
                    confirmButtonText: 'OK'
                });
                
                return;
            }

            var formData = new FormData();
            formData.append('bankonlinefile', file);

            $.ajax({
                url: "<?= base_url('admin/csv-payment-upload/bankpayment-studentdata-save') ?>",
                type: "POST",
                data: formData,
                headers: {
                    "X-CSRF-TOKEN": "<?= csrf_hash() ?>"
                },
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
                        location.reload();
                    } else {
                        $('#resultArea').html(data.html);
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Error!',
                        text: 'Something went wrong.',
                        confirmButtonText: 'OK'
                    });

                    console.error(error);
                }
            });
            
        });
    });
</script>
