<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center"> <!-- Corrected typo in "justify-content-center" -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>First Name<span class="text-danger">*</span></strong></label>
                            <input type="text" name="first_name" value="<?= !empty($user_profile) ? $user_profile->first_name : '' ?>" id="first_name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Last Name<span class="text-danger">*</span></strong></label>
                            <input type="text" name="last_name" value="<?= !empty($user_profile) ? $user_profile->last_name : '' ?>" id="last_name" class="form-control"> <!-- Corrected ID -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>User Name<span class="text-danger">*</span></strong></label>
                            <input type="text" name="username" value="<?= !empty($user_profile) ? $user_profile->username : '' ?>" id="user_name" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Email<span class="text-danger">*</span></strong></label>
                            <input type="email" name="email" value="<?= !empty($user_profile) ? $user_profile->email : '' ?>" id="email" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Mobile No<span class="text-danger">*</span></strong></label>
                            <input type="tel" name="mobile" value="<?= !empty($user_profile) ? $user_profile->phone : '' ?>" id="mobile" class="form-control" maxlength="10" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Profile Picture<span class="text-danger">*</span></strong></label>
                            <input type="file" name="image" id="profile_picture" class="form-control"> <!-- Added an ID -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
