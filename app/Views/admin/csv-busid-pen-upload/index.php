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
                            <input type="file" name="bspenfile" id="bspenfile" class="form-control" accept=".csv" required>
                        </div>

                        <button id="bspenfileButton" type="button" class="btn btn-primary">
                            Import Data
                        </button>

                        <div id="resultArea"></div>
                    </form>

                    <div class="container">
                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <a href="<?= base_url('/public/admin/assets/images/sample_bs_pen_upload.csv') ?>">👉 Download Sample File</a>
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
                                                <td><code>student_code</code></td>
                                                <td><span class="badge bg-danger">Yes</span></td>
                                                <td>Student code (format like <strong>23-0001</strong>)</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td><code>bs_id</code></td>
                                                <td><span class="badge bg-danger">Yes</span></td>
                                                <td>Bangla Sikhsha ID</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td><code>pen_no</code></td>
                                                <td><span class="badge bg-danger">Yes</span></td>
                                                <td>PEN No</td>
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
        $('#bspenfileButton').on('click', function() {
            
            var fileInput = $('#bspenfile')[0];
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
                $('#bspenfile').val('');

                Swal.fire({
                    icon: 'warning',
                    title: 'File Type',
                    text: 'Only CSV files are allowed.',
                    confirmButtonText: 'OK'
                });
                
                return;
            }

            var formData = new FormData();
            formData.append('bspenfile', file);

            $.ajax({
                url: "<?= base_url('admin/csv-busid-pen-upload/busid-pen-data-save') ?>",
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
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
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