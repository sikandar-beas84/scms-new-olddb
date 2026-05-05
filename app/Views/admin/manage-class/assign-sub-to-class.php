<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('public/admin/assets/js/vendor/forms/validation/validate.min.js') ?>"></script>

<!-- Bootstrap Select CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/css/bootstrap-select.min.css">
<!-- Bootstrap Select JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/js/bootstrap-select.min.js"></script>


<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">

</script>

<!-- Page header -->
<div class="page-header page-header-primary shadow">
	<div class="page-header-content d-lg-flex border-top">
		<div class="d-flex">
			<div class="breadcrumb py-2">
				<a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
				<a href="javascript:;" class="breadcrumb-item"><?= $title ?></a>
				<!-- <span class="breadcrumb-item active">Validation styles</span> -->
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
	<!-- Edit area -->
	<div class="row editClassRowDiv" >
		<div class="col-lg-12 editClassDiv">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0"><?= $title ?></h5>
				</div>

				<form method="post" class="needs-validation" action="#" novalidate id="assignSubjectToClassesForm" data-id="">
					<div class="card-body">
						
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Select Class <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select name="class_id" id="class_id" class="form-control" required>
									<option value=""> ----- Select ----- </option>
									<?php if( isset($class) && !empty($class) ) {
										foreach ($class as $class_value) { ?>
											<option value="<?= $class_value['id'] ?>"><?= $class_value['class_name'] ?></option>
										<?php } 
									} ?>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Select Subject <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select name="subject_id[]" id="subject_id" class="selectpicker form-control" required  multiple data-live-search="true" >
									<option value=""> ----- Select ----- </option>
									<?php if( isset($subject) && !empty($subject) ) {
										foreach ($subject as $subject_value) { ?>
											<option value="<?= $subject_value['id'] ?>"><?= $subject_value['subject_name'] . '('. $subject_value['subject_code'] . ')' ?></option>
										<?php } 
									} ?>>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Select Dropdown <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select name="sub[]" id="sub" class="selectpicker form-control" required  multiple data-live-search="true" >
									<option value=""> ----- Select ----- </option>
									<?php for ($i=1; $i < 7; $i++) { 
										echo '<option value="'.$i.'">'.$i.'</option>';
									} ?>
								</select>
							</div>
						</div>


					</div>

					<div class="card-footer text-end">
						<button id="sessionFormReset" type="button" class="btn btn-light">Reset <i class="ph-paper-plane-tilt ms-2"></i></button>
						<button id="editClassFormSubmit" type="button" class="btn btn-primary">Add <i class="ph-paper-plane-tilt ms-2"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /Edit area -->

	<!-- Page length options -->
	<div class="card">
		<div class="card-header">
			<h5 class="mb-0">All <?= $title ?></h5>
		</div>
		
		<div id="showMsg"></div>

		<div class="card-body">
			<table id="classLists" class="hover">
			    <thead>
			        <tr>
			            <th>ID</th>
			            <th>Class Name</th>
			            <th>ID Range</th>
			            <th>Age Limit</th>
			            <th>Action</th>
			        </tr>
			    </thead>
			</table>
		</div>
	</div>
	<!-- /page length options -->
</div>
<!-- /content area -->




<!-- <form method="post" enctype="multipart/form-data" action="#">
    
    <input type="file" id="uploadImage" accept="image/*">

    
    <input type="hidden" name="croppedImage" id="croppedImage">

    
    <div>
        <img id="preview">
    </div>

    
    <div>
        <h4>Cropped Preview:</h4>
        <img id="croppedPreview">
    </div>

    <br>
    <button type="button" id="cropBtn">Crop</button>
    <button type="submit">Submit</button>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;
    const input = document.getElementById('uploadImage');
    const preview = document.getElementById('preview');
    const croppedPreview = document.getElementById('croppedPreview');
    const hiddenInput = document.getElementById('croppedImage');

    // Show selected image in cropper
    input.addEventListener('change', function(e) {
        let file = e.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                preview.style.display = "block";

                // Destroy old cropper instance if exists
                if (cropper) cropper.destroy();

                // Init cropper
                cropper = new Cropper(preview, {
                    aspectRatio: 1, // Square crop
                    viewMode: 2
                });
            }
            reader.readAsDataURL(file);
        }
    });

    // Crop button
    document.getElementById('cropBtn').addEventListener('click', function() {
        if (cropper) {
            let canvas = cropper.getCroppedCanvas({
                width: 300,
                height: 300
            });

            // Show cropped preview
            croppedPreview.src = canvas.toDataURL("image/jpeg");
            croppedPreview.style.display = "block";

            // Put cropped image in hidden input (base64)
            hiddenInput.value = canvas.toDataURL("image/jpeg");
        }
    });
</script> -->

<script>
	$(document).ready(function () {
		$('#editClassFormSubmit').on('click', function(e) {
			e.preventDefault();
			let class_id = $("#class_id").val();
            let subject_id = $("#subject_id").val();
            let sub = $("#sub").val();
			var form = $('#assignSubjectToClassesForm')[0];
			// console.log(class_id);
			// console.log(subject_id);
			// console.log(sub);

			// SWEET ALERT VALIDATION
            if (class_id === "") {
                Swal.fire({
                    icon: "warning",
                    title: "Missing Field",
                    text: "Class is required"
                });
                $("#class_id").focus();
                return;
            }
            if (subject_id === "" || subject_id.length == 0) {
                Swal.fire({
                    icon: "warning",
                    title: "Missing Field",
                    text: "Subject is required"
                });
                $("#subject_id").focus();
                return;
            }
            if (sub === "" || sub.length == 0) {
                Swal.fire({
                    icon: "warning",
                    title: "Missing Field",
                    text: "Subject Order is required"
                });
                $("#subject_id").focus();
                return;
            }
			

			// AJAX SUBMIT
            $.ajax({
                url: "<?= base_url('admin/manage-class/ajax-save-assign-sub-to-class') ?>",
                type: "POST",
                data: $("#assignSubjectToClassesForm").serialize(),
                dataType: "json",

                success: function (res) {
					console.log(res);
                    if (res.status === "success") {
						Swal.fire({
							icon: "success",
                            title: "Saved Successfully",
                            text: res.message
                        });
						// Reset form
				        form.reset();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: res.message
                        });
                    }
                }
            });
		});
	});
</script>