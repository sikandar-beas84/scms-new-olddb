<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                 <div class="row justify-content-conter">

         

				

					<div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Title<span class="text-danger">*</span></strong></label>
                            <input type="hidden" name="id" id="id" value="<?= !empty($passwordpolices) ? $passwordpolices[0]->id  : 0?>">
                            <input type="text" name="title" value="<?= decrypt($passwordpolices[0]->title); ?>"  id="title" class="form-control" >
                        </div>
                    </div>

					<div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Characters<span class="text-danger">*</span></strong></label>
                            <input type="text" name="characters" value="<?= decrypt($passwordpolices[0]->characters); ?>"  id="characters" class="form-control" >

                        </div>
                    </div>

					

                </div>
                


            </div>
        </div>
    </div>
</div>
