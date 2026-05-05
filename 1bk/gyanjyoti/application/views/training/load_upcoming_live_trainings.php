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
                            <label><strong>Title<span class="text-danger">*</span></strong></label>
                            <input type="text" name="title" value="<?= !empty($data) ? $data->title : '' ?>" id="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><strong>Sub Title<span class="text-danger">*</span></strong></label>
                            <input type="text" name="sub_title" value="<?= !empty($data) ? $data->sub_title : '' ?>" id="sub_title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><strong>Image<span class="text-danger">*</span></strong></label>
                            <input type="file" name="image" value="<?= !empty($data) ? $data->image : '' ?>" id="image" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><strong>Date<span class="text-danger">*</span></strong></label>
                            <input type="date" name="date" value="<?= !empty($data) ? $data->date : '' ?>" id="date" class="form-control">
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
