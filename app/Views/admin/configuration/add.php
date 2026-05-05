
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

<div class="content">
	<div class="card">

		<div class="card-body">
			<form method="post" action="<?= base_url('admin/configuration/add-configuration') ?>">
				<div class="row mb-3">
					<div class="col-sm-4">
						<label class="col-lg-12 col-form-label">Configuration Level *</label>
						<input type="text" class="form-control" name="configuration_level" id="configuration_level" value="" required />
					</div>
					<div class="col-sm-4">
						<label class="col-lg-12 col-form-label">Configuration Key *</label>
						<input type="text" class="form-control" name="configuration_key" id="configuration_key" value="" required />
					</div>
					<div class="col-sm-4">
						<label class="col-lg-12 col-form-label">Configuration Value *</label>
						<input type="text" class="form-control" name="configuration_value" id="configuration_value" value="" required />
					</div>
				</div>

				<p class="text-danger">* Marks are required field</p>					
				<input type="submit" name="submit" class="btn btn-primary mr-2" value="Save">    
			</form>
		</div>
	</div>
</div>