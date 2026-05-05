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
			<div class="row">
	            <div class="col-lg-3">
	                <div class="mb-3">
                		<input type="text" class="form-control student-mask-id" name="student_code" value="" id="student_code" placeholder="Student code: Format must be: YY-XXXX (Example: 22-0129)" pattern="[0-9]{2}-[0-9]{4}" />
	                </div>
	            </div>

                <div class="col-lg-3">
                    <div class="mb-3">
                    	<button type="button" id="studentBusSearch" class="btn btn-primary ms-3">Go <i class="ph-paper-plane-tilt ms-2"></i></button>
                    </div>
				</div>
			</div>

			<div class="row">
				<p class="mb-4 text-danger" id="showMsg"></p>
	        	<div class="mb-4" id="assignStoppageBus" style="display: none;">
	                <div class="fw-bold border-bottom pb-2 mb-3"><i class="ph-bus ms-2"></i> Select Stoppage of transport required</div>
	                <form role="form" class="update_form" action="javascript:" id="stu_update" enctype="multipart/form-data" autocomplete="off">
	                	<input type="hidden" name="student_id" id="student_id" value="" />
		                <div class="row mb-3">
		                    <label class="col-form-label col-lg-3">Stoppage</label>
		                    <div class="col-lg-6">
		                        <select class="form-select" name="stoppage" id="stoppage">
		                        	<option value="0">--Select Stopage--</option>
		                        	<?php foreach($stoppage_list as $stoppage): ?>
		                        		<option value="<?= $stoppage['stoppage_id'] ?>" ><?= $stoppage['stoppage_name'] ?> - &#8377; <?php echo stoppage_fee_by_id($stoppage['stoppage_id']) ?></option>
	                        		<?php endforeach; ?>
		                        </select>
		                    </div>
		                </div>
		                <div class="row mb-3">
		                    <label class="col-form-label col-lg-3">Chose Bus</label>
		                    <div class="col-lg-6">
		                        <select class="form-select" name="bus_id" id="bus_id">
		                        	<option value="0">--Select Bus--</option>
		                        	<?php foreach($bus_list as $bus): ?>
		                        		<option value="<?= $bus['bus_id'] ?>"  ><?= $bus['bus_licence_no'] ?></option>
	                        		<?php endforeach; ?>
		                        </select>
		                    </div>
		                </div>
		                <div class="row mb-3">
		                	<div class="col-lg-3"></div>
		                	<div class="col-lg-6">
		                		<button id="stoppageFormSubmit" type="button" class="btn btn-primary">Update <i class="ph-paper-plane-tilt ms-2"></i></button>
		                		<button style="display: none;" id="stoppageFormCancelSubmit" type="button" class="btn btn-danger">Cancel Bus Assignment <i class="ph-paper-plane-tilt ms-2"></i></button>
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
		let selectedBusId = '';
		let selectedStoppageId = '';

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

		$('#studentBusSearch').click(function(){
			var student_code = $("#student_code").val();
			$("#showMsg").html("")
			$("#stoppageFormCancelSubmit").hide()
			selectedBusId = ''
			selectedStoppageId = ''

			if (student_code === '') {
		        Swal.fire({
		            icon: 'error',
		            title: 'Student Code Required',
		            text: 'Please enter student code!',
		        });

		        $("#assignStoppageBus").hide()
		        return;
		    }

		    $.ajax({
				type: "POST",
				url: "<?php echo base_url('admin/student/get-assign-bus-details'); ?>", 
				data:{student_code:student_code},
				dataType:"json",//return type expected as json
				success: function(result){
				   	if( result.status ) {
				   		$("#assignStoppageBus").show()
				   		$("#student_id").val(result.student_id)
				   		selectedBusId = result.bus_id; // store bus_id
				   		selectedStoppageId = result.stoppage_id; // store bus_id

				   		if (result.stoppage_id) {
				            $('#stoppage').val(result.stoppage_id).trigger('change');
				        }

				        if( result.bus_payment_status == 0 ) {
				        	$("#stoppageFormCancelSubmit").show()
				        }
				   	} else {
				   		selectedBusId = ''
				   		selectedStoppageId = ''
				   		$("#assignStoppageBus").hide()
				   		$("#showMsg").html(result.message)
				   	}
				},
			});
		});

		/**
		 * Fetches buses associated with the selected stoppage via AJAX
		 * 
		 * This event handler triggers when the stoppage dropdown selection changes.
		 * It sends the selected stoppage ID to the server and populates the bus
		 * dropdown with the returned bus options.
		 * 
		 * @event change
		 * @param {HTMLElement} stoppage - The stoppage dropdown element
		 * @param {number} stoppage_id - The ID of the selected stoppage
		 * 
		 * @fires AJAX POST request to admin/bus/get-bus
		 * @returns {void}
		 * 
		 * @example
		 * $('#stoppage').trigger('change');
		 * 
		 * @see {@link http://base_url/admin/bus/get-bus|Bus API Endpoint}
		 */
		$('#stoppage').change(function(){
			var stoppage_id = $(this).find(':selected').val();
			$('#bus_id').empty();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('admin/bus/get-bus'); ?>", 
				data:{stoppage:stoppage_id},
				dataType:"json",//return type expected as json
				success: function(stoppage){
				   	$.each(stoppage,function(key,val){
						var opt = $('<option/>'); 
						opt.val(key);
						opt.text(val);

						// ✅ check and set selected
					    if (key == selectedBusId) {
					        opt.attr('selected', 'selected');   // OR opt.prop('selected', true);
					    }

						$('#bus_id').append(opt);
				   	});
				},
			});
		});


		$('#stoppageFormSubmit').click(function () {				
			var stop = $('#stoppage').val();
			var bus = $('#bus_id').val();
			var student_id = $("#student_id").val();
			var stu_previous_stoppage = selectedStoppageId;

			if (student_id === '') {
				Swal.fire({
				    icon: 'error',
				    title: 'Failed!',
				    text: 'Student details not found',
				    confirmButtonText: 'OK'
				});

				return;
			}

			if(stop>0 && bus>0){
				Swal.fire({
				    title: "Are you sure?",
				    text: "Do you want to assign bus?",
				    icon: "warning",
				    showCancelButton: true,
				    confirmButtonText: "Yes, Assign",
				    cancelButtonText: "No, Cancel"
				}).then((result) => {
				    if (result.isConfirmed) {
				        // YES clicked
				        console.log("Bus assigned");

						$.ajax({
							url:'<?= base_url() ?>admin/student/assign-bus-to-student',
							method: 'post',					
							data: {
								stoppage : stop, 
								bus_id : bus, 
								form_no : '', 
								student_id : student_id,
								stuPreviousStoppage : stu_previous_stoppage
							},
							//data: formdata,
							success: function(result){
								console.log(result);
								if(result > 0){							
									$('.msg').html('<div class="alert alert-block alert-success"><button type="button" class="btn-close" data-bs-dismiss="alert"></button><p><strong><i class="bi bi-check"></i>Well done!</strong>Student Details update successful</p></div>');
									setTimeout(function(){ location.reload(); }, 1500);
								} else {								
									$('.msg').html('<div class="alert bg-danger text-white alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert"></button><strong><i class="ace-icon fa fa-times"></i> Failed! </strong>Their is an error to assign bus<br></div>');
								}  
							}
						}) 
				    } else {
				        // NO clicked
				        console.log("Cancelled");
				        e.preventDefault();
				    }
				});
			} else {
				Swal.fire({
				    icon: 'error',
				    title: 'Failed!',
				    text: 'Please Select Stoppage & Bus',
				    confirmButtonText: 'OK'
				});

				return;
			}			
		});

		$('#stoppageFormCancelSubmit').click(function () {				
			var stop = $('#stoppage').val();
			var bus = $('#bus_id').val();
			var student_id = $("#student_id").val();
			var stu_previous_stoppage = selectedStoppageId;

			if (student_id === '') {
				Swal.fire({
				    icon: 'error',
				    title: 'Failed!',
				    text: 'Student details not found',
				    confirmButtonText: 'OK'
				});

				return;
			}

			if(stop>0 && bus>0){
				Swal.fire({
				    title: "Are you sure?",
				    text: "Do you want to unassign bus?",
				    icon: "warning",
				    showCancelButton: true,
				    confirmButtonText: "Yes, Unassign",
				    cancelButtonText: "No, Cancel"
				}).then((result) => {
				    if (result.isConfirmed) {
				        // YES clicked
				        console.log("Bus unassign");

						$.ajax({
							url:'<?= base_url() ?>admin/student/unassign-bus-to-student',
							method: 'post',					
							data: {
								stoppage : stop, 
								bus_id : bus, 
								form_no : '', 
								student_id : student_id,
								stuPreviousStoppage : stu_previous_stoppage
							},
							//data: formdata,
							success: function(result){
								console.log(result)
								if (result == -1) {
								    $('.msg').html('<div class="mt-2 alert alert-danger">Invalid Student ID Details</div>');
								}
								else if (result == -2) {
								    $('.msg').html('<div class="mt-2 alert alert-danger">Invalid Student Code</div>');
								}
								else if(result > 0){							
									$('.msg').html('<div class="alert alert-block alert-success"><button data-dismiss="alert" class="close" type="button"><i class="ace-icon fa fa-times"></i></button><p><strong><i class="bi bi-check"></i>Well done!</strong>Bus has been unassigned from the student</p></div>');
									setTimeout(function(){ location.reload(); }, 1500);
								} else {								
									$('.msg').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="bi bi-clipboard-x-fill"></i></button><strong><i class="ace-icon fa fa-times"></i> Failed! </strong>Their is an error for this transaction<br></div>');
								} 
							}
						}) 
				    } else {
				        // NO clicked
				        console.log("Cancelled");
				        e.preventDefault();
				    }
				});
			} else {
				alert('Please Select Stoppage & Bus');
			}			
		});
	});
</script>