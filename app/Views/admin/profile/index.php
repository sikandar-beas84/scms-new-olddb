<!-- First load jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<!-- Then load jQuery Validation plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>
    .disabled {
        background-color: #0000000d;
    }
</style>

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

<?php if (session()->getFlashdata('success')): ?>
    <p style="color:green"><?= session('success') ?></p>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <p style="color:red"><?= session('error') ?></p>
<?php endif; ?>

<!-- Validation Errors -->
<?php if (session('errors')): ?>
    <ul style="color:red">
        <?php foreach (session('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>


<?php // pr($user_details);
$fullName   = trim(($user_details['first_name'] ?? '') . ' ' . ($user_details['last_name'] ?? ''));
$email      = $user_details['email']      ?? '';
$code       = $user_details['code']       ?? '';
$sessionId  = $user_details['session_id'] ?? '';
$deptId     = $user_details['dept_id']    ?? '';
$mobile     = $user_details['mobile']    ?? '';
$gender     = $user_details['gender']    ?? '';
?>

<div class="content">
    <!-- Inner container -->
    <div class="d-lg-flex align-items-lg-start">

        <!-- Left sidebar component -->
        <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none me-lg-3">

            <!-- Sidebar content -->
            <div class="sidebar-content">

                <!-- Navigation -->
                <div class="card">
                    <div class="sidebar-section-body text-center">
                        <div class="card-img-actions d-inline-block mb-3">
                            <?php 
                            $getUserImgUrl = base_url('uploads/no-image.png');
                            if( $gender == "Female" ) {
                                $getUserImgUrl = base_url('uploads/no-image-girl.png');
                            }

                            if( session()->get('userimage') != "" ):
                                $getUserImgUrl = base_url().'uploads/profile/'.esc(session()->get('userimage'));
                            endif; ?>
                            <img class="img-fluid rounded-circle" src="<?= $getUserImgUrl ?>" width="150" height="150" alt="">
                            <!-- <div class="card-img-actions-overlay card-img rounded-circle">
                                <a href="#" class="btn btn-outline-white btn-icon rounded-pill">
                                    <i class="ph-pencil"></i>
                                </a>
                            </div> -->
                        </div>

                        <h6 class="mb-0"><?= $fullName ?></h6>
                        <span class="text-muted"><?= dept_name_by_id($deptId) ?></span>
                    </div>

                    <ul class="nav nav-sidebar" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#profile" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">
                                <i class="ph-user me-2"></i>
                                 My profile
                            </a>
                        </li>
                        <!-- <li class="nav-item" role="presentation">
                            <a href="#schedule" class="nav-link" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">
                                <i class="ph-calendar me-2"></i>
                                Schedule
                                <span class="fs-sm fw-normal text-muted ms-auto">02:56pm</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#inbox" class="nav-link" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">
                                <i class="ph-envelope me-2"></i>
                                Inbox
                                <span class="badge bg-secondary rounded-pill ms-auto">29</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#orders" class="nav-link" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">
                                <i class="ph-shopping-cart me-2"></i>
                                Orders
                                <span class="badge bg-secondary rounded-pill ms-auto">16</span>
                            </a>
                        </li> -->
                        <li class="nav-item-divider"></li>
                        <li class="nav-item" role="presentation">
                            <a href="<?= base_url('/logout') ?>" class="nav-link" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">
                                <i class="ph-sign-out me-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /navigation -->

            </div>
            <!-- /sidebar content -->

        </div>
        <!-- /left sidebar component -->


        <!-- Right content -->
        <div class="tab-content flex-fill">
            <div class="tab-pane fade active show" id="profile" role="tabpanel">

                <!-- Profile info -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Profile information</h5>
                    </div>

                    
                    <form method="post" class="needs-validation" action="#" novalidate id="studentUpdateForm" data-id="" enctype="multipart/form-data">
                        <div class="card-body">
                            <div id="showMsg"></div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <h6 class="text-primary mb-2">Profile Photo</h6>

                                        <div class="mb-2">
                                            <label>
                                                <input type="radio" name="photo_option" value="upload"> Upload Image
                                            </label>
                                            &nbsp;&nbsp;
                                            <label>
                                                <input type="radio" name="photo_option" value="camera"> Capture Image
                                            </label>
                                        </div>

                                        <div id="uploadSection" style="display:none;">
                                            <input type="file" id="fileInput" accept="image/*" class="form-control">
                                        </div>

                                        <div id="cameraSection" style="display:none;margin-top:10px;">
                                            <video id="video" width="300" autoplay playsinline></video><br>

                                            <button type="button" class="btn btn-success btn-sm" id="captureBtn">Capture</button>
                                            <button type="button" class="btn btn-warning btn-sm" id="retakeBtn" style="display:none;">Take Another</button>
                                            <button type="button" class="btn btn-danger btn-sm" id="closeCamera">Close</button>
                                        </div>

                                        <div class="mt-2">
                                            <img id="preview" style="display:none;border:1px solid #ccc;width:132px;height:170px;">
                                        </div>

                                        <canvas id="canvas" width="132" height="170" style="display:none;"></canvas>
                                        <input type="hidden" id="camera_image">
                                    </div>
                                </div>
                                <script>
                                    let stream = null;
                                    const MIN_SIZE = 20 * 1024;
                                    const MAX_SIZE = 200 * 1024;

                                    /* -------- OPTION SWITCH -------- */
                                    $("input[name='photo_option']").change(function () {
                                        const val = $(this).val();

                                        $("#preview").hide();
                                        $("#retakeBtn").hide();
                                        $("#fileInput").val('');
                                        $("#camera_image").val('');

                                        if (val === "upload") {
                                            stopCamera();
                                            $("#cameraSection").hide();
                                            $("#uploadSection").show();
                                        } else {
                                            $("#uploadSection").hide();
                                            $("#cameraSection").show();
                                            startCamera();
                                        }
                                    });

                                    /* -------- FILE UPLOAD AUTO AJAX -------- */
                                    $("#fileInput").on("change", function () {
                                        const file = this.files[0];
                                        if (!file) return;

                                        // ✅ SIZE VALIDATION
                                        if (file.size < MIN_SIZE || file.size > MAX_SIZE) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: 'Image size must be between 20 KB and 200 KB'
                                            });

                                            $(this).val('');
                                            $("#preview").hide();
                                            return;
                                        }

                                        const img = new Image();
                                        img.onload = function () {
                                            $("#preview").attr("src", img.src).show();

                                            let formData = new FormData();
                                            formData.append("photo", file);

                                            uploadImage(formData);
                                        };
                                        img.src = URL.createObjectURL(file);
                                    });

                                    /* -------- CAMERA START -------- */
                                    async function startCamera() {
                                        try {
                                            stream = await navigator.mediaDevices.getUserMedia({ video: true });
                                            $("#video")[0].srcObject = stream;
                                        } catch {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: 'Camera not available'
                                            });
                                        }
                                    }

                                    /* -------- CAPTURE & AUTO UPLOAD -------- */
                                    $("#captureBtn").click(function () {
                                        const canvas = $("#canvas")[0];
                                        const ctx = canvas.getContext("2d");

                                        ctx.drawImage($("#video")[0], 0, 0, 132, 170);
                                        const data = canvas.toDataURL("image/png");

                                        $("#preview").attr("src", data).show();
                                        $("#retakeBtn").show();

                                        $.ajax({
                                            url: "<?= site_url('admin/profile/upload-photo') ?>",
                                            type: "POST",
                                            data: { camera_image: data },
                                            dataType: "json",
                                            success: function (res) {
                                                Swal.fire({
                                                    icon: 'success',   // success | error | warning | info
                                                    title: 'Success',
                                                    text: res.message,
                                                    confirmButtonText: 'OK'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        location.reload();   // 🔄 Reload page
                                                    }
                                                });
                                            }
                                        });
                                    });

                                    /* -------- RETAKE -------- */
                                    $("#retakeBtn").click(function () {
                                        $("#preview").hide();
                                        $(this).hide();
                                    });

                                    /* -------- CLOSE CAMERA -------- */
                                    $("#closeCamera").click(function () {
                                        stopCamera();
                                        $("#cameraSection").hide();
                                    });

                                    /* -------- STOP CAMERA -------- */
                                    function stopCamera() {
                                        if (stream) {
                                            stream.getTracks().forEach(t => t.stop());
                                            stream = null;
                                        }
                                    }

                                    /* -------- COMMON UPLOAD FUNCTION -------- */
                                    function uploadImage(formData) {
                                        $.ajax({
                                            url: "<?= site_url('admin/profile/upload-photo') ?>",
                                            type: "POST",
                                            data: formData,
                                            contentType: false,
                                            processData: false,
                                            dataType: "json",
                                            success: function (res) {
                                                Swal.fire({
                                                    icon: 'success',   // success | error | warning | info
                                                    title: 'Success',
                                                    text: res.message,
                                                    confirmButtonText: 'OK'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        location.reload();   // 🔄 Reload page
                                                    }
                                                });
                                            }
                                        });
                                    }
                                </script>
                            </div>
                        </div>
                    </form>

                    <div class="card-body">
                        <form action="#">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name:</label>
                                        <span class="form-control disabled"><?= $fullName ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <span class="form-control disabled"><?= $email ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Session</label>
                                        <span class="form-control disabled"><?= session_name_by_id($sessionId) ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Mobile</label>
                                        <span class="form-control disabled"><?= $mobile ?></span>
                                    </div>
                                </div>
                            </div>


                            <div class="text-end">
                                <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /profile info -->
            </div>

        </div>
        <!-- /right content -->

    </div>
    <!-- /inner container -->
</div>