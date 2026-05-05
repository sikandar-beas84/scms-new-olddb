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
                            <label><strong>Link<span class="text-danger">*</span></strong></label>
                            <input type="text" name="link" value="<?= !empty($data) ? $data->link : '' ?>" id="link" class="form-control">
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
