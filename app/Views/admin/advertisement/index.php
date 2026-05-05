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

                    <div class="row">
                        <div class="col-lg-6">

                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <?= csrf_field() ?>

                                <div class="mb-3">
                                    <label class="form-label">Upload File *</label>
                                    <input type="file" name="advertisementfile" id="advertisementfile" class="form-control" accept=".jpg, .jpeg, .png, .gif, .webp" required>
                                </div>

                                <button id="advertisementfileButton" type="button" class="btn btn-primary">
                                    Upload
                                </button>
                            </form>

                        </div>
                        <div class="col-lg-6">
                            <?php 
                            $adImage = $advertisement['file_name'] ?? '';
                            if( $adImage != '' ) {
                            ?>
                                <img src="<?php echo base_url('uploads/advertisement/' . $adImage); ?>" alt="Uploaded Image" class="img-fluid" style="max-width: 100%;height: 200px;" />
                                <form id="deleteAdvertisement" class="form-horizontal" method="post" action="<?= base_url('admin/advertisement/advertisement-delete') ?>">
                                   <button type="button" id="deleteAdvertisementBtn" class="btn btn-danger mt-3">Delete</button>
                                </form>
                            <?php } ?>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#advertisementfileButton').on('click', function() {
            
            var fileInput = $('#advertisementfile')[0];
            var file = fileInput.files[0];

            // Basic validation
            if (!file) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No file selected',
                    text: 'Please select a image.',
                    confirmButtonText: 'OK'
                });

                return;
            }

            if (!file.type.startsWith("image/") && !file.name.match(/\.(jpg|jpeg|png|gif|webp)$/i)) {
                
                $('#advertisementfile').val('');

                Swal.fire({
                    icon: 'warning',
                    title: 'File Type',
                    text: 'Only image files are allowed.',
                    confirmButtonText: 'OK'
                });

                return;
            }

            var formData = new FormData();
            formData.append('advertisementfile', file);

            $.ajax({
                url: "<?= base_url('admin/advertisement/advertisement-save') ?>",
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
                        Swal.fire({
                            icon: 'warning',
                            title: 'Error!',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
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

        $('#deleteAdvertisementBtn').on('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won’t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, proceed!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Your action here
                    console.log('Confirmed');
                    $('#deleteAdvertisement').submit();
                }
            });
        });
        
    });
</script>
