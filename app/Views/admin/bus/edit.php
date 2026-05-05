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
				<div class="card-header">
					<h5 class="mb-0">Edit</h5>
				</div>

				<form class="form-horizontal" method="post" role="form" action="<?= base_url() ?>admin/bus/update/<?= $bus_id ?>" autocomplete="off"  enctype="multipart/form-data">
					<div class="card-body">
						<div id="showMsg"></div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Chose Vendor <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select class="form-control" name="vendor_id" id="vendor_id">
									<option value="">-- Select --</option>
									<?php foreach($vendor_list as $vendor): ?>
									<option value="<?= $vendor['id'] ?>" <?= ($vendor['id'] == $bus['vendor_id'] ? 'selected':'') ?>><?php echo $vendor['first_name'] . ' ' . $vendor['last_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<div class="row mb-3" id="stoggle">
							<label class="col-form-label col-lg-4">Chose Stoppage <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select class="form-control" name="stoppage_id[]" id="stoppage_id" multiple="multiple">
									<?php foreach($stoppage_list as $stoppage): ?>
									<option value="<?= $stoppage['stoppage_id'] ?>" <?= (in_array($stoppage['stoppage_id'],$old_stoppage) ? 'selected':'') ?>><?= $stoppage['stoppage_name'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Serial No.</label>
							<div class="col-lg-8">
								<input type="text" name="bus_serial_no" class="form-control" value="<?= $bus['bus_serial_no'] ?>">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Licence No <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input type="text" name="bus_licence_no" class="form-control" value="<?= $bus['bus_licence_no'] ?>">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Seating Capacity <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input type="text" name="bus_seating_capacity"  class="form-control" value="<?= $bus['bus_seating_capacity'] ?>">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Driver Name <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input type="text" name="bus_driver_name" class="form-control" value="<?= $bus['bus_driver_name'] ?>">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Driver Picture </label>
							<div class="col-lg-5">
								<input type="file" id="form-field-1" class="form-control" name="bus_driver_image" value="">
								<input type="hidden" name="driver_image" value="<?php if(isset($bus['bus_driver_image']) && $bus['bus_driver_image'] != ''){echo $bus['bus_driver_image']; } ?>" />
							</div>
							<div class="col-lg-3">
								<?php if(isset($bus['bus_driver_image']) && $bus['bus_driver_image'] != ''){echo '<img  src="'.base_url().'uploads/busdrivers/'.$bus['bus_driver_image'].'" width="100px"/>';} ?>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Driver Driving License No </label>
							<div class="col-lg-8">
								<input type="text" name="bus_driver_driving_license_no" class="form-control" value="<?= $bus['bus_driver_driving_license_no'] ?>">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Driver Licence Expiery Date</label>
							<div class="col-lg-8">
								<input type="text" name="bus_driver_licence_expiery_date" class="form-control datepicker-basic datepicker-input" value="<?= $bus['bus_driver_licence_expiery_date'] ?>">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Driver Phone No</label>
							<div class="col-lg-8">
								<input type="text" name="bus_driver_phone" class="form-control" value="<?= $bus['bus_driver_phone'] ?>">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Attendent Name</label>
							<div class="col-lg-8">
								<input type="text" name="bus_attendent_name" class="form-control" value="<?= $bus['bus_attendent_name'] ?>">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Attendent Picture</label>
							<div class="col-lg-5">
								<input type="file" id="form-field-1" class="form-control" name="bus_attendent_image" value="">
								<input type="hidden" name="attendent_image" value="<?php if(isset($bus['bus_attendent_image']) && $bus['bus_attendent_image'] != ''){echo $bus['bus_attendent_image']; } ?>" />
							</div>
							<div class="col-lg-5">
								<?php if(isset($bus['bus_attendent_image']) && $bus['bus_attendent_image'] != ''){echo '<img  src="'.base_url().'uploads/busdrivers/'.$bus['bus_attendent_image'].'" width="100px"/>';} ?>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Attendent Driving License No </label>
							<div class="col-lg-8">
								<input type="text" name="bus_attendent_driving_license_no" class="form-control" value="<?= $bus['bus_attendent_driving_license_no'] ?>">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Attendent Licence Expiery Date</label>
							<div class="col-lg-8">
								<input type="text" name="bus_attendent_licence_expiery_date" class="form-control datepicker-basic datepicker-input" value="<?= $bus['bus_attendent_licence_expiery_date'] ?>">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Bus Attendent Phone No</label>
							<div class="col-lg-8">
								<input type="text" name="bus_attendent_phone" class="form-control" value="<?= $bus['bus_attendent_phone'] ?>">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Status</label>
							<div class="col-lg-8">

								<select class="form-control" name="status" id="status">
									<option value="1" <?= ($bus['status'] == 1 ? 'selected':'') ?>>Active</option>
									<option value="0" <?= ($bus['status'] == 0 ? 'selected':'') ?>>Inactive</option>
								</select>

								</div>	
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-lg-4"></div>
							<div class="col-lg-8">
								<button id="busFormSubmit" type="submit" class="btn btn-primary">Update <i class="ph-paper-plane-tilt ms-2"></i></button>
							</div>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>