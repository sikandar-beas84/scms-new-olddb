<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


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
			<div class="row">
				<div class="col-lg-3">
					<div class="mb-3">
                        <select class="form-select" name="class_id" id="class_id">
							<option value="">Select Class</option>

							<?php if(!empty($class_list)){
								foreach($class_list as $class){ ?>
									<option value="<?php echo $class['id']; ?>"><?php echo $class['class_name']; ?></option>
								<?php }
							} ?>
						</select>

                    </div>

                </div>
                <div class="col-lg-3">
	                <div class="mb-3">
	                	<select class="form-select" id="section_id" name="section_id">
	                		<!--  -->
	                	</select>
	                </div>
	            </div>
	            <div class="col-lg-3">
	                <div class="mb-3">
	                	<?php if (session()->get('student_logged_in') === true): ?>
	                		<input type="text" class="form-control student-mask-id" name="student_code" value="<?= session()->get('code') ?>" id="student_code" placeholder="Student Code" disabled />
	                	<?php else: ?>
	                		<input type="text" class="form-control student-mask-id" name="student_code" value="" id="student_code" placeholder="Student code: Format must be: YY-XXXX (Example: 22-0129)" pattern="[0-9]{2}-[0-9]{4}" />
	                	<?php endif; ?>
	                </div>
	            </div>

                <div class="col-lg-3">
                    <div class="mb-3">
                    	<button type="button" id="generateIdCard" class="btn btn-primary ms-3">Generate ID Card <i class="ph-paper-plane-tilt ms-2"></i></button>
                    </div>
				</div>

			</div>

		</div>
	</div>
</div>



<script>
	$(document).ready(function () {
		$("#class_id").change(function (e) {
			var class_id = this.value;
			$.ajax({
				url:'<?=base_url()?>admin/student/request-section',
				method: 'post',
				data: {class_id: class_id},
				dataType: 'json',
				success: function(data) {
					if(data.status == "success"){
						$('#section_id').html(data.html);
					}
				}
		 	})
		});

		$('#student_code').on('input', function() {
	        let value = $(this).val().replace(/[^0-9]/g, ""); // keep only digits

	        if (value.length > 2) {
	            value = value.slice(0, 2) + "-" + value.slice(2, 6);
	        }

	        $(this).val(value);
	    });

	    $('#generateIdCard').on('click', function() {
	    	let class_id = $("#class_id").val()
	    	let section_id = $("#section_id").val()
	    	let student_code = $("#student_code").val()

	    	if (class_id === '') {
			    Swal.fire({
			        icon: 'warning',
			        title: 'Class Required',
			        text: 'Please select a class first!',
			        confirmButtonText: 'OK'
			    });
			    return false; // stop further execution
			}


			$.ajax({
		        url: "<?= base_url('admin/student/generate-idcard') ?>",
		        type: "POST",
		        data: {
		            class_id: class_id,
		            section_id: section_id,
		            student_code: student_code
		        },
		        xhrFields: {
		            responseType: 'blob' // IMPORTANT for PDF download
		        },
		        beforeSend: function () {
		            Swal.fire({
		                title: 'Generating ID Card...',
		                allowOutsideClick: false,
		                didOpen: () => Swal.showLoading()
		            });
		        },
		        success: function (response) {
		            Swal.close();

		            let blob = new Blob([response], { type: 'application/pdf' });
		            let url = window.URL.createObjectURL(blob);

		            let a = document.createElement('a');
		            a.href = url;
		            a.download = 'student-id-card.pdf';
		            document.body.appendChild(a);
		            a.click();
		            document.body.removeChild(a);
		            window.URL.revokeObjectURL(url);
		        },
		        error: function () {
		            Swal.fire('Error', 'Unable to generate ID card', 'error');
		        }
		    });
	    })
	});
</script>