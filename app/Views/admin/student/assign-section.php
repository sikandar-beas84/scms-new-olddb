<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
			<h5 class="mb-0">Search</h5>
		</div>
		<div class="card-body">
			<form method="post" action="<?= base_url('admin/student/assign-section') ?>">
				<div class="row">
		            <div class="col-lg-3">
		                <div class="mb-3">
	                		<input type="text" class="form-control student-mask-id" name="student_code" id="student_code" placeholder="Student code: Format must be: YY-XXXX (Example: 22-0129)" pattern="[0-9]{2}-[0-9]{4}" value="<?= $student_code ?>" />
		                </div>
		            </div>

	                <div class="col-lg-3">
	                    <div class="mb-3">
	                    	<button type="submit" id="studentSectionSearch" class="btn btn-primary ms-3">Go <i class="ph-paper-plane-tilt ms-2"></i></button>
	                    </div>
					</div>
				</div>
			</form>

			<div class="row">
				<p class="mb-4 text-danger" id="showMsg"></p>
	        	<div class="mb-4" id="assignSection">
	                <div class="fw-bold border-bottom pb-2 mb-3"><i class="ph-bus ms-2"></i> Assign Section to Student - <?= $student_name ?></div>
	                <form role="form" class="update_form" action="javascript:" id="stu_update" enctype="multipart/form-data" autocomplete="off">
	                	<input type="hidden" name="student_id" id="student_id" value="" />
		                <div class="row mb-3">
		                    <label class="col-form-label col-lg-3">Stoppage</label>
		                    <div class="col-lg-6">
		                        <select class="form-select" name="section_id" id="section_id">
		                        	<option value="0">--Select Section--</option>
		                        	<?php if( isset($section_list) && !empty($section_list) ):
		                        		foreach($section_list as $section): ?>
		                        			<option value="<?= $section['id'] ?>" <?= ($section_id == $section['id'] ? 'selected':'' ) ?>><?= $section['section_name'] ?></option>
		                        		<?php endforeach;
		                        	endif; ?>
		                        </select>
		                    </div>
		                </div>
		                <div class="row mb-3">
		                	<div class="col-lg-3"></div>
		                	<div class="col-lg-6">
		                		<button type="button" class="btn btn-info" id="submit_section">Update Section <i class="ph-paper-plane-tilt ms-2"></i></button>
		                	</div>
		                	<span class="msg"></span>
		                </div>
	               	</form>
	            </div>
			</div>
		</div>
	</div>
</div>
<!-- Content area -->

<script>
	$(document).ready(function() {
		let baseUrl = '<?=base_url()?>';

		/**
		 * Formats student code input with automatic hyphen insertion
		 * 
		 * This event handler listens for input changes on the student code field
		 * and automatically formats the entered number with a hyphen after the
		 * first 2 digits (e.g., "12-3456").
		 * 
		 * @event input
		 * @param {jQuery} $(this) - The student code input field
		 * @returns {void}
		 */
		$('#student_code').on('input', function() {
	        let value = $(this).val().replace(/[^0-9]/g, ""); // keep only digits

	        if (value.length > 2) {
	            value = value.slice(0, 2) + "-" + value.slice(2, 6);
	        }

	        $(this).val(value);
	    });

		$('#submit_section').click(function () {
			var section_id = $('#section_id').val();
			
			if(section_id > 0){
				
				let code = '<?= ($student_code) ?? '' ?>';
				let class_id = '<?= ($class_id) ?? '' ?>';
				let student_id = '<?= ($student_id) ?? '' ?>';
			
				$.ajax({
					url:'<?= base_url()?>admin/student/assign-section-to-single-student',
					method: 'post',		
					dataType: 'json',			
					data: {
						class_id : class_id, 
						student_id : student_id, 
						section_id : section_id, 
						student_code : code
					},
					success: function(result){
						if (result.status === true) {
				            Swal.fire({
				                icon: 'success',
				                title: 'Success!',
				                text: result.message,
				                showConfirmButton: false,
				                timer: 1500
				            }).then(() => {
				                location.reload();
				            });
				        } else {
				            Swal.fire({
				                icon: 'error',
				                title: 'Failed!',
				                text: result.message,
				                confirmButtonText: 'OK'
				            });
				        }

					}
				}) 
				
			} else {
				Swal.fire({
				    icon: 'warning',
				    title: 'Required!',
				    text: 'Please select section',
				    confirmButtonText: 'OK'
				});
			}			
		});
	});
</script>