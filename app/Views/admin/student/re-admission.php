<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
	.studentReadmissionLists {
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
			<h5 class="mb-0">Search</h5>
		</div>

		<div class="card-body">
			<?php if (session()->getFlashdata('message')): ?>
			    <div class="alert alert-success">
			        <?= session()->getFlashdata('message'); ?>
			    </div>
			<?php endif; ?>

			<form action="<?php echo base_url(); ?>admin/student/students-move-to-next-class" method="post">	
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
		                	</select>
		                </div>
		            </div>
		            
	                <div class="col-lg-3">
	                    <div class="mb-3">
	                    	<button type="button" id="studentListSearch" class="btn btn-primary ms-3">Go <i class="ph-paper-plane-tilt ms-2"></i></button>
	                    </div>
					</div>
				</div>

				<div class="row studentReadmissionLists">
					<table class="table table-striped table-bordered table-hover"></table>
					<div class="col-lg-3"></div>
					<div class="col-lg-6" id="moveButtonArea">
						<button type="submit" class="btn btn-info" id="moveButton">
							<i class="ace-icon fa fa-check bigger-110"></i>
							Move Student To Next Session Class
						</button>
					</div>
					<div class="col-lg-3" id="showMessage"></div>
				</div>
			</form>

		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		$("#class_id").change(function (e) {
			var class_id = this.value;
			if (!class_id) {
				$('#section_id').html('');
			    return; // 🚫 stop AJAX
			}

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

		$("#studentListSearch").click(function (e) {
			var class_id = $("#class_id").val();
			var section_id = $("#section_id").val();
			$(".studentReadmissionLists").hide()

			$("#moveButtonArea").show()
			$("#showMessage").html("")

			if (!class_id || !section_id) {
			    Swal.fire({
			        icon: 'warning',
			        title: 'Required!',
			        text: 'Please select both Class and Section'
			    });
			    return; // 🚫 stop AJAX
			}

			$.ajax({
				url:'<?=base_url()?>admin/student/ajax-request-for-student-move-to-next-session',
				method: 'post',
				data: {
					class_id: class_id,
					section_id: section_id
				},
				dataType: 'json',
				success: function(data) {
					console.log(data)
					$(".studentReadmissionLists").show()
					$('table').empty();
					$('table').append(data.html);

					if( data.allStudentUpgraded ) {
						$("#moveButtonArea").hide()
						$("#showMessage").html('<p class="fw-bold text-danger fs-5">All students have been successfully promoted to the next session.</p>')
					} else {
						$("#moveButtonArea").show()
					}
				}
		 	})
		});
	});
</script>
<script>

	
    /****************************************** Ajax Code For Student List *********************************************/
	$("#filter").click(function () {
		$("#hide_Instruction").hide();
		var class_id = $("#pick").val();			
		var section_id = $("#p_section").val();
		$("#divLoading").show();
		$.ajax({
			url:'<?=base_url()?>student/ajax_request_for_student_move_to_next_session',
			method: 'post',
			data: {class_id: class_id,section_id:section_id},
		  // dataType: 'json',
			success: function(data){					
				var json_obj = JSON.parse(data);
				$('table').empty();
				$('table').append(json_obj.html);
				// $("#divLoading").hide();
			},
			error: function (data) {
				// $("#divLoading").hide();
			}
		})   
		
	});	
</script>