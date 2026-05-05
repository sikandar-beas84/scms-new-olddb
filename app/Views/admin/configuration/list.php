<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
	.d-none {
		display: none;
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

<div class="content">
	<div class="card">
		<div class="card-header">
			<a href="<?= base_url('admin/configuration/edit') ?>" class="d-flex align-items-center text-body py-2">
				<i class="ph-pencil me-2"></i>
				Edit <?= $title ?>
			</a>
		</div>

		<div class="card-body">
			<?php if (session()->getFlashdata('success_msg')): ?>
			    <div class="alert alert-success">
			        <?= session()->getFlashdata('success_msg'); ?>
			    </div>
			<?php endif; ?>

			<?php if (session()->getFlashdata('error_msg')): ?>
			    <div class="alert alert-danger">
			        <?= session()->getFlashdata('error_msg'); ?>
			    </div>
			<?php endif; ?>
			<form action="#">
					<div class="input-group d-none">
						<button type="button" class="btn btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
							<i class="ph-minus ph-sm"></i>
						</button>
						<button type="button" class="btn btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
							<i class="ph-plus ph-sm"></i>
						</button>
						<input class="form-control form-control-number" min="1" and max="31" type="number" name="number" value="15" readonly>
					</div>

					<?php if( isset($all_configuration) && !empty($all_configuration) ) :
						foreach($all_configuration as $row): ?>	
							

							<div class="row mb-3 <?= (($row['configuration_key'] == 'super_therapist_id')? 'd-none':'') ?>">
								<label class="col-lg-3 col-form-label"><?= ucwords($row['configuration_level']) ?>: <i class="bi bi-info-square" data-bs-popup="tooltip" aria-describedby="tooltip569692" data-bs-original-title="<?= $row['configuration_key'] ?>"></i></label>
								<div class="col-lg-9">
									<span >
										<?= $row['configuration_value']; ?>
										<!-- <i class="bi bi-trash ms-2 <?php // echo (($row['configuration_key'] == 'superadmin_email')? 'd-none':'') ?>" onclick="del_config('<?php // echo $row['configuration_key'];?>');"></i> -->
									</span>
								</div>
							</div>
								
						<?php endforeach; 
					endif; ?>

				

			</form>
		</div>
	</div>
</div>

<script>
	function del_config($key) {
		var r = confirm( "Are you sure to delete Configuration?" );
		/*if ( r == true ) {
			var config_del_url = "<?php echo base_url().'configuration/delete_configuration/'?>"+$key;
			window.location.href = config_del_url;	
		} else {				
			e.preventDefault();
		}*/
	}
</script>