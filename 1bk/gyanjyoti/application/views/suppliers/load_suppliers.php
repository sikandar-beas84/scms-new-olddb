<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-conter">

                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" name="id" id="branch_id" value="<?= !empty($data) ? $data->id : 0?>">
                        </div>
                    </div>

					<div class="col-md-12">
                        <div class="form-group">
                            <label><strong>Name<span class="text-danger">*</span></strong></label>
                            <input type="text" name="name" value="<?= !empty($data) ? $data->name : '' ?>" id="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><strong>Category<span class="text-danger">*</span></strong></label>
                              <select class="form-control" name="category_name">
                                <option>Select Category</option>
                                <option <?= $data->category == 'Hotels/Resorts' ? 'selected' : ''; ?> value="Hotels/Resorts">Hotels/Resorts</option>
                                <option <?= $data->category == 'Air' ? 'selected' : ''; ?> value="Air">Air</option>
                                <option <?= $data->category == 'Car Transfers/Rentals' ? 'selected' : ''; ?> value="Car Transfers/Rentals">Car Transfers/Rentals</option>
                                <option <?= $data->category == 'Tour Operator/FIT' ? 'selected' : ''; ?> value="Tour Operator/FIT">Tour Operator/FIT</option>
                                <option <?= $data->category == 'Guided Tours' ? 'selected' : ''; ?> value="Guided Tours">Guided Tours</option>
                                <option <?= $data->category == 'Activities' ? 'selected' : ''; ?> value="Activities">Activities</option>
                                <option <?= $data->category == 'Cruise' ? 'selected' : ''; ?> value="Cruise">Cruise</option>
                                <option <?= $data->category == 'Insurance' ? 'selected' : ''; ?> value="Insurance">Insurance</option>
                                <option <?= $data->category == 'Rail' ? 'selected' : ''; ?> value="Rail">Rail</option>
                                <option <?= $data->category == 'Booking Tool' ? 'selected' : ''; ?> value="Booking Tool">Booking Tool</option>
                                <option <?= $data->category == 'Destination' ? 'selected' : ''; ?> value="Destination">Destination</option>
                                <option <?= $data->category == 'Travel Leaders' ? 'selected' : ''; ?> value="Travel Leaders">Travel Leaders</option>
                                </select>

                        </div>
                        <div class="form-group">
                            <label><strong>Image<span class="text-danger">*</span></strong></label>
                            <input type="file" name="image" value="<?= !empty($data) ? $data->image : '' ?>" id="image" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><strong>Address<span class="text-danger">*</span></strong></label>
                            <input type="text" name="address" value="<?= !empty($data) ? $data->address : '' ?>" id="address" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><strong>Phone<span class="text-danger">*</span></strong></label>
                            <input type="text" name="phone" value="<?= !empty($data) ? $data->phone : '' ?>" id="phone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><strong>Email<span class="text-danger">*</span></strong></label>
                            <input type="text" name="email" value="<?= !empty($data) ? $data->email : '' ?>" id="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><strong>About<span class="text-danger">*</span></strong></label>
                            <textarea  name="about"  id="about" class="form-control"><?= !empty($data) ? $data->about : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label><strong>Commission Rates<span class="text-danger">*</span></strong></label>
                            <textarea  name="commission_rates"  id="commission_rates" class="form-control"><?= !empty($data) ? $data->commission_rates : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label><strong>BDM/Contact Info<span class="text-danger">*</span></strong></label>
                            <textarea  name="bdm_contact_info"  id="bdm_contact_info" class="form-control"><?= !empty($data) ? $data->bdm_contact_info : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label><strong>Booking Resources<span class="text-danger">*</span></strong></label>
                            <textarea  name="booking_resources_text"  id="booking_resources_text" class="form-control"><?= !empty($data) ? $data->booking_resources_text : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label><strong>Booking Resources Link<span class="text-danger">*</span></strong></label>
                            <input type="text" name="booking_resources_link" value="<?= !empty($data) ? $data->booking_resources_link : '' ?>" id="booking_resources_link" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><strong>Education<span class="text-danger">*</span></strong></label>
                            <textarea  name="education_text"  id="education_text" class="form-control"><?= !empty($data) ? $data->education_text : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label><strong>Education Link<span class="text-danger">*</span></strong></label>
                            <input type="text" name="education_link" value="<?= !empty($data) ? $data->education_link : '' ?>" id="education_link" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><strong>How to Register<span class="text-danger">*</span></strong></label>
                            <textarea  name="how_to_register"  id="how_to_register" class="form-control"><?= !empty($data) ? $data->how_to_register : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label><strong>More<span class="text-danger">*</span></strong></label>
                            <textarea  name="more_text"  id="more_text" class="form-control"><?= !empty($data) ? $data->more_text : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label><strong>More Link<span class="text-danger">*</span></strong></label>
                            <input type="text" name="more_link" value="<?= !empty($data) ? $data->more_link : '' ?>" id="more_link" class="form-control">
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
