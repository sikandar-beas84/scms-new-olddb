<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<!-- Bootstrap Multiselect CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-multiselect@1.1.2/dist/css/bootstrap-multiselect.css">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Multiselect JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-multiselect@1.1.2/dist/js/bootstrap-multiselect.min.js"></script>

<script>
	function initDatePickers() {
	    $(".datepicker-basic").datepicker({
	        dateFormat: "yy-mm-dd", // yyyy-mm-dd
	        changeMonth: true,
	        changeYear: true
	    });
	}

	$(document).ready(function () {

		initDatePickers();

	    $('#stoppage_id').multiselect({
	        enableFiltering: true,
	        buttonWidth: '100%',
	        nonSelectedText: 'Select Stoppage',
	        maxHeight: 300
	    });
	});
</script>

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
				<h5 class="mb-0">Add Bus</h5>
					<div class="d-inline-flex ms-auto">
						<a class="btn btn-indigo" href="<?= base_url('admin/bus') ?>"><i class="ph-arrow-circle-left me-2"></i> Bus Lists</a>
					</div>
				</div>


				<?php if (session()->getFlashdata('success_msg')): ?>
					<div class="alert bg-success text-white alert-dismissible fade show">
						<?= session()->getFlashdata('success_msg'); ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					</div>
				<?php endif; ?>	

				<?php if (session()->getFlashdata('error_msg')): ?>
					<div class="alert bg-danger text-white alert-dismissible fade show">
						<?= session()->getFlashdata('error_msg'); ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					</div>
				<?php endif; ?>	

				<?php if (session()->get('errors')): ?>
				    <div class="alert bg-danger text-white alert-dismissible fade show">
				        <?php foreach (session('errors') as $error): ?>
				            <?= esc($error) ?><br />
				        <?php endforeach; ?>
				        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				    </div>
				<?php endif; ?>

				<form class="form-horizontal" method="post" role="form" action="<?= base_url() ?>admin/bus/save/" autocomplete="off"  enctype="multipart/form-data">
					<div class="card-body">
						<div id="showMsg"></div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Chose Vendor <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select class="form-control" name="vendor_id" id="vendor_id">
									<option value="">-- Select --</option>
									<?php foreach($vendor_list as $vendor): ?>
										<option value="<?= $vendor['id'] ?>" ><?php echo $vendor['first_name'] . ' ' . $vendor['last_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<div class="row mb-3" id="stoggle">
							<label class="col-form-label col-lg-4">Chose Stoppage <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select class="form-control" name="stoppage_id[]" id="stoppage_id" multiple="multiple">
									<?php foreach($stoppage_list as $stoppage): ?>
									<option value="<?= $stoppage['stoppage_id'] ?>" ><?= $stoppage['stoppage_name'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Serial No.</label>
							<div class="col-lg-8">
								<input type="text" name="bus_serial_no" class="form-control" value="">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Licence No <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input type="text" name="bus_licence_no" class="form-control" value="">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Seating Capacity <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input type="text" name="bus_seating_capacity"  class="form-control" value="">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Driver Name <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input type="text" name="bus_driver_name" class="form-control" value="">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Driver Picture </label>
							<div class="col-lg-5">
								<input type="file" id="form-field-1" class="form-control" name="bus_driver_image" value="">
								<input type="hidden" name="driver_image" value="" />
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Driver Driving License No </label>
							<div class="col-lg-8">
								<input type="text" name="bus_driver_driving_license_no" class="form-control" value="">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Driver Licence Expiery Date</label>
							<div class="col-lg-8">
								<input type="text" name="bus_driver_licence_expiery_date" class="form-control datepicker-basic datepicker-input" value="">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Driver Phone No</label>
							<div class="col-lg-8">
								<input type="text" name="bus_driver_phone" class="form-control" value="">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Attendent Name</label>
							<div class="col-lg-8">
								<input type="text" name="bus_attendent_name" class="form-control" value="">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Attendent Picture</label>
							<div class="col-lg-5">
								<input type="file" id="form-field-1" class="form-control" name="bus_attendent_image" value="">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Attendent Driving License No </label>
							<div class="col-lg-8">
								<input type="text" name="bus_attendent_driving_license_no" class="form-control" value="">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Attendent Licence Expiery Date</label>
							<div class="col-lg-8">
								<input type="text" name="bus_attendent_licence_expiery_date" class="form-control datepicker-basic datepicker-input" value="">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Attendent Phone No</label>
							<div class="col-lg-8">
								<input type="text" name="bus_attendent_phone" class="form-control" value="">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Status</label>
							<div class="col-lg-8">

								<select class="form-control" name="status" id="status">
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select>

								</div>	
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-lg-4"></div>
							<div class="col-lg-8">
								<button id="busFormSubmit" type="submit" class="btn btn-primary">Save <i class="ph-paper-plane-tilt ms-2"></i></button>
							</div>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>