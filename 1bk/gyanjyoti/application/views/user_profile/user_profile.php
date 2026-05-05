<!--Page header-->

<div class="page-header d-xl-flex d-block">
    <div class="page-leftheader">
        <h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Profile</span></h4>
    </div>
</div>
<!--End Page header-->
<style>
.position-relative {
    position: relative;
}

.toggle-password {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    z-index: 2;
}

.toggle-password i {
    font-size: 1.2rem;
    color: #aaa;
}
</style>

<!-- Profile Page-->
<div class="row">
    <div class="col-xl-3 col-lg-4 col-md-12">
        <div class="card user-pro-list overflow-hidden">
            <div class="card-body">
                <div class="user-pic text-center">
                    <?php if(get_session('user_type') == 'staff' || get_session('user_type') == 'admin' || get_session('user_type') == 'super_admin'){ ?>
                        <?php if($user_details->image){ ?>
                            <span class="avatar avatar-xxl brround"
                                style="background-image: url(<?=base_url();?>assets/uploads/staff/<?=jd($user_details->image)[0]; ?>)">
                                <span class="avatar-status bg-green"></span>
                            </span>
                            <?php }else{ ?>
                            <span class="avatar avatar-xxl brround"
                                style="background-image: url(<?= base_url('assets/img/user-profile.png') ?>)">
                                <span class="avatar-status bg-green"></span>
                            </span>
                        <?php } ?>
                    <?php }else{ ?>
                        <?php if($user_details->student_photo){ ?>
                            <span class="avatar avatar-xxl brround"
                                style="background-image: url(<?=base_url();?>assets/uploads/student/<?=jd($user_details->student_photo)[0]; ?>)">
                                <span class="avatar-status bg-green"></span>
                            </span>
                            <?php }else{ ?>
                            <span class="avatar avatar-xxl brround"
                                style="background-image: url(<?= base_url('assets/img/user-profile.png') ?>)">
                                <span class="avatar-status bg-green"></span>
                            </span>
                        <?php } ?>
                    <?php } ?>
                    <div class="pro-user mt-3">
                         <?php if(get_session('user_type') == 'staff' || get_session('user_type') == 'admin' || get_session('user_type') == 'super_admin'){ ?>
                        <h5 class="pro-user-username text-dark mb-1 fs-16">
                            <?= $user_details->first_name . ' ' . $user_details->last_name ?>
                        </h5>
                        <h6 class="pro-user-desc text-muted fs-12"><?= $user_details->username ?></h6>
                        <?php }else{ ?>
                         <h5 class="pro-user-username text-dark mb-1 fs-16">
                            <?= $user_details->student_name ?>
                        </h5>
                        <h6 class="pro-user-desc text-muted fs-12"><?= $user_details->student_code ?></h6>
                        <?php } ?>
                        <div class="btn-list">

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-lg-8 col-md-12">
        <div class="card ">
            <div class="card-header border-0">
                <h4 class="card-title"> User Details</h4>
            </div>
            <div class="card-body">

                <div class="row">
                  

                </div>
                <form id="modaleditFormAdd" enctype="multipart/form-data">
                 
                    <div class="modal-body" id="user_profile_modal_body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <?php if(get_session('user_type') == 'staff' || get_session('user_type') == 'admin' || get_session('user_type') == 'super_admin'){ ?>
                                            <!-- Corrected typo in "justify-content-center" -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><strong>First Name<span
                                                                class="text-danger">*</span></strong></label>
                                                    <input type="text" name="first_name" value="<?= !empty($user_details) ? ($user_details->first_name) : '' ?>" id="first_name"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>Last Name<span
                                                                class="text-danger">*</span></strong></label>
                                                    <input type="text" name="last_name" value="<?= !empty($user_details) ? ($user_details->last_name) : '' ?>" id="last_name"
                                                        class="form-control"> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>User Name<span
                                                                class="text-danger">*</span></strong></label>
                                                    <input type="text" name="username" value="<?= !empty($user_details) ? $user_details->username : '' ?>" id="user_name"
                                                        class="form-control" disabled="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>Email<span
                                                                class="text-danger">*</span></strong></label>
                                                    <input type="email" name="email" value="<?= !empty($user_details) ? ($user_details->email) : '' ?>"
                                                        id="email" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>Mobile No<span
                                                                class="text-danger">*</span></strong></label>
                                                    <input type="tel" name="mobile" value="<?= !empty($user_details) ? ($user_details->phone) : '' ?>" id="mobile"
                                                        class="form-control" maxlength="10">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>Profile Picture<span
                                                                class="text-danger">*</span></strong></label>
                                                    <input type="file" name="image" id="profile_picture"
                                                        class="form-control"> <!-- Added an ID -->
                                                </div>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><strong>Full Name<span
                                                                class="text-danger">*</span></strong></label>
                                                    <input type="text" name="first_name" value="<?= !empty($user_details) ? ($user_details->student_name) : '' ?>" id="first_name"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>User Name<span
                                                                class="text-danger">*</span></strong></label>
                                                    <input type="text" name="username" value="<?= !empty($user_details) ? $user_details->student_code : '' ?>" id="user_name"
                                                        class="form-control" disabled="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>Email<span
                                                                class="text-danger">*</span></strong></label>
                                                    <input type="email" name="email" value="<?= !empty($user_details) ? ($user_details->email_id) : '' ?>"
                                                        id="email" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>Father Mobile No<span
                                                                class="text-danger">*</span></strong></label>
                                                    <input type="tel" name="mobile" value="<?= !empty($user_details) ? ($user_details->father_mobile_no) : '' ?>" id="mobile"
                                                        class="form-control" maxlength="10">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>Profile Picture<span
                                                                class="text-danger">*</span></strong></label>
                                                    <input type="file" name="image" id="profile_picture"
                                                        class="form-control"> <!-- Added an ID -->
                                                </div>
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="submit" class="btn btn-primary">Change</button>
                        <button type="reset" class="btn btn-danger">Clear</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-0">
                <h4 class="card-title">Change Password</h4>
            </div>
            <div class="card-body">
                <form id="changepassword">
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Current Password<span class="text-red">*</span></label>
                            </div>
                        </div>
                        <div class="col-sm-8 col-md-8">
                            <div class="form-group position-relative">
                                <input type="password" class="form-control" name="current_password"
                                    id="current_password">
                                <span class="toggle-password" onclick="togglePassword('current_password')">
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">New Password<span class="text-red">*</span></label>
                            </div>
                        </div>
                        <div class="col-sm-8 col-md-8">
                            <div class="form-group position-relative">
                                <input type="password" class="form-control" name="new_password" id="new_password">
                                <span class="toggle-password" onclick="togglePassword('new_password')">
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Retype Password<span class="text-red">*</span></label>
                            </div>
                        </div>
                        <div class="col-sm-8 col-md-8">
                            <div class="form-group position-relative">
                                <input type="password" class="form-control" name="retype_password" id="retype_password">
                                <span class="toggle-password" onclick="togglePassword('retype_password')">
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Change</button>&emsp;
                            <button type="reset" class="btn btn-danger">Clear</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
<!--End Profile Page-->

</div>
</div><!-- end app-content-->

<?php $this->load->view('user_profile/user_profile_modal'); ?>
<script type="text/javascript">
var baseUrl = '<?= base_url() ?>';
var pageURL = 'profile/';
var modalId = 'user_profile_modal';
var tableName = 'user_profile_table';
$(document).ready(function() {
    //servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');

    //Submit the modal form
    $("#changepassword").on('submit', (function(e) {
        e.preventDefault();
        ajaxFromSubmit(pageURL + 'save', this, function(data) {
            // closeModal(modalId); // calling function to close Modal
            successMsg('Data save success');
            //servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');
        });
    }));
});


</script>
<script type="text/javascript">
$(document).ready(function() {

    //Submit the modal form
    $("#modaleditFormAdd").on('submit', (function(e) {
        e.preventDefault();
        ajaxFromSubmit(pageURL + 'save_profile_data', this, function(data) {
            console.log(data);
            // successMsg('Data save success');
            $('#modalFormAdd .form-control').val('');
            closeModal('user_profile_modal');
            // location.reload();
        });
    }));
});
</script>
<script type="text/javascript">


function deletephoto(id = '') {
    warningMsg('Are You Sure', 'You won\'t be able to revert this!', 'warning', 'Delete it', function() {
        ajaxPostRequest(pageURL + 'deletephoto', {
            "id": id
        }, function(data) {
            successMsg('Item Deleted.'); // Success Message
            location.reload();
        });
    });

}


function togglePassword(id) {
    const passwordField = document.getElementById(id);
    const icon = passwordField.nextElementSibling.querySelector('i');

    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = "password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>