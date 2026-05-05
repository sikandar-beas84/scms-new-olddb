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
	                		<!-- <option value="">Select Section</option> -->
	                	</select>
	                </div>
	            </div>

                <div class="col-lg-3">
                    <div class="mb-3">
                    	<button type="button" id="studentListSearch" class="btn btn-primary ms-3">Go <i class="ph-paper-plane-tilt ms-2"></i></button>
                    </div>
				</div>

			</div>

		</div>
	</div>
</div>
<!-- Content area -->
<div class="content">

	<!-- Page length options -->
	<div class="card">		
		<?php if (session()->has('success')): ?>
		    <div class="alert alert-success alert-dismissible fade show" role="alert">
		        <?= session('success') ?>
		        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		    </div>
		<?php endif; ?>

		<?php if (session()->has('error')): ?>
		    <div class="alert alert-danger alert-dismissible fade show" role="alert">
		        <?= session('error') ?>
		        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		    </div>
		<?php endif; ?>

		<form method="post" action="<?php echo base_url();?>admin/student/allot-students-roll-num">
			<div class="card-header d-flex align-items-center">
				<div class="d-inline-flex ms-auto">
					<button type="submit" class="btn btn-indigo">
						<i class="ph-user-gear me-2"></i>
						Generate Students Roll No (No of Student - <span id="count"></span>)
					</button>
	        	</div>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table id="studentLists" class="table text-nowrap"></table>
				</div>
			    <!-- <table class="table table-striped table-bordered table-hover"></table> -->
			</div>
		</form>
	</div>
	<!-- /page length options -->
</div>
<!-- /content area -->

<script>
	$(document).ready(function () {
		/**
		 *  On Chnage Class Get Section
		 * */ 
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

		/**
		 *  Ajax Code For Student List
		 * */ 
		$("#studentListSearch").click(function () {
			// $('#count').text('');
			// $("#hide_Instruction").hide();
			var class_id = $("#class_id").val();			
			var section_id = $("#section_id").val();
			
			if (!class_id || !section_id) {
		        Swal.fire({
		            icon: 'warning',
		            title: 'Required',
		            text: 'Please select both Class and Section',
		            confirmButtonText: 'OK'
		        });
		        return false; // stop execution
		    }

		 	$.ajax({
				url:'<?=base_url()?>admin/student/get-lists-for-generate-student-roll',
				type: "POST",
				data: {
					class_id: class_id,
					section_id:section_id,					
					is_individual: 'no'
				},
			  	dataType: "json",
				success: function(response){
					$('#studentLists').empty();
					$('#studentLists').append(response.html);
					$('#count').append(response.no_of_student);
				}
		  	})   
			
		});
	});
</script>