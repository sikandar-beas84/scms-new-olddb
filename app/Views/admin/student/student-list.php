<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<?php
$segment4 = service('uri')->getSegment(4) ?? '';
?>


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
		<div class="card-header row">
			<div class="col-lg-6">
				<h5 class="mb-6">Search</h5>
			</div>
			<div class="col-lg-6">
				<button type="button" class="btn btn-primary mb-6" data-toggle="modal" data-target="#import_student_details_modal" onclick="importView()" style="float: right;">Import </button>
			</div>
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
	                	<?php if (session()->get('student_logged_in') === true): ?>
	                		<input type="text" class="form-control student-mask-id" name="student_code" value="<?= session()->get('code') ?>" id="student_code" placeholder="Student Code" disabled />
	                	<?php else: ?>
	                		<input type="text" class="form-control student-mask-id" name="student_code" value="<?= $segment4 ?>" id="student_code" placeholder="Student code: Format must be: YY-XXXX (Example: 22-0129)" pattern="[0-9]{2}-[0-9]{4}" />
	                	<?php endif; ?>
	                </div>
	            </div>
	            <div class="col-lg-3">
	                <div class="mb-3">
	                	<input type="text" class="form-control" name="student_name" id="student_name" value="" placeholder="Student Name" />
	                </div>
	            </div>
	            <div class="col-lg-3">
	                <div class="mb-3">
	                	<input type="text" class="form-control" name="father_name" id="father_name" value="" placeholder="Father's Name" />
	                </div>
	            </div>
	            <div class="col-lg-3">
	                <div class="mb-3">
	                	<input type="text" class="form-control" name="mother_name" id="mother_name" value="" placeholder="Mother's Name" />
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
		<div class="card-header">
			<h5 class="mb-0">All <?= $title ?></h5>
		</div>
		
		<div id="showMsg"></div>

		<div class="card-body">
			<table id="studentLists" class="display responsive nowrap">
		        <thead>
		            <tr>
						<th>Option</th>
						<th>Sl No </th>
						<th>Form No</th>
						<th>Student Code</th>
						<th>Student Name</th>
						<th>Academic Status</th>
						<th>Section</th>
						<th>Roll No</th>
						<th>Image</th>
						<th>Class </th>
						<th>Class Teacher </th>
						<th>Second Language </th>
						<th>Date Of Birth</th>
						
        				<?php if (session()->get('admin_logged_in') === true) { ?>
        				    <th>Transport Allowed</th>
        				    <th>Readmission Allowed</th>
        				<?php } ?>
						
						<th>Father Name</th>
						<th>Mother Name</th>
						<th>Father Mobile</th>
						<th>Mother Mobile</th>
						<th>Bus</th>
						<th>Stoppage</th>
						<th>Tuition Fee</th>
						<th>Bus Fee</th>							
						
		            </tr>
		        </thead>
		    </table>
		</div>
	</div>
	<!-- /page length options -->
</div>
<!-- /content area -->

<?php 
$session = session();
$admin   = $session->get('admin_logged_in');
$special = $session->get('specialadmin_logged_in');
$non     = $session->get('nonteaching_logged_in');
$student = $session->get('student_logged_in');
$teacher = $session->get('teacher_logged_in');
$userId  = $session->get('user_id');
?>
<script> const base_url = "<?= base_url(); ?>"; </script>

<script>
    const adminLoggedIn   = <?= $admin ? 'true' : 'false' ?>;
    const specialAdmin    = <?= $special ? 'true' : 'false' ?>;
    const nonTeaching     = <?= $non ? 'true' : 'false' ?>;
    const studentLoggedIn = <?= $student ? 'true' : 'false' ?>;
    const teacherLoggedIn = <?= $teacher ? 'true' : 'false' ?>;
    const sessionUserId   = <?= $userId ?>;

    const hasAccess = (adminLoggedIn || nonTeaching || specialAdmin);
	const notBlockedUser = ![7824, 7825, 7826].includes(sessionUserId);

</script>

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

		$("#studentListSearch").click(function (e) {
			let class_id = $("#class_id").val();
			let student_code = $("#student_code").val();
			let student_name = $("#student_name").val();
			let section_id = $("#p_section").val();
			let father_name = $("#father_name").val();
			let mother_name = $("#mother_name").val();

			if(class_id || student_code || student_name || section_id || father_name || mother_name){
				/*$.ajax({
					url:'<?=base_url()?>admin/student/ajax-student-list',
					method: 'post',					
					data: {
						class_id: class_id, 
						student_code : student_code, 
						student_name : student_name,
						father_name : father_name, 
						mother_name : mother_name, 
						section_id : section_id
					},
				  	// dataType: 'json',
					success: function(data){
                        
					},
					error: function (data) {
						$("#divLoading").hide();
					}
				})*/

				table.ajax.reload();
			} else {
				Swal.fire({
				    icon: 'warning',
				    title: 'No Criteria Selected',
				    text: 'You did not select any criteria!',
				    confirmButtonText: 'OK'
				});

				e.preventDefault();
			}
		});

		let table = $('#studentLists').DataTable({
		    pageLength: 25,
		    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
		    responsive: true,
		    ajax: {
		        url: "<?= base_url('admin/student/ajax-student-list') ?>",
		        type: 'POST',
		        dataType: 'json',
		        data: function(d) {
		            d.class_id = $('#class_id').val();
		            d.student_code = $('#student_code').val();
		            d.student_name = $('#student_name').val();
		            d.section_id = $('#section_id').val();
		            d.father_name = $('#father_name').val();
		            d.mother_name = $('#mother_name').val();
		        },
		        dataSrc: function(json) {
		            console.log(json); // check actual response
		            return json.student_list || json; // adjust key based on your response
		        }
		    },
		    columns: [
				{
		            data: null,
		            render: function(data, type, row) {
		                /*return `
		                    <div class="hidden-sm hidden-xs btn-group">
		                        <a class="btn btn-xs btn-info" href="javascript:void(0);" onclick="editStudent(${row.student_id});">
		                            <i class="bi bi-pencil-square"></i>
		                        </a>
		                        <a class="btn btn-xs btn-danger" href="javascript:void(0);" onclick="deleteStudent(${row.student_id});">
		                            <i class="bi bi-trash"></i>
		                        </a>
		                    </div>
		                `;*/

		                let html = `
				            <div class="hidden-sm hidden-xs btn-group">
				                <a class="btn btn-xs btn-info" href="${base_url}admin/student/edit/${row.s_id}" >
				                    <i class="bi bi-pencil-square"></i>
				                </a>
				                <a class="btn btn-xs btn-danger" href="javascript:void(0);" 
				                   onclick="deleteStudent(${row.s_id});">
				                    <i class="bi bi-trash"></i>
				                </a>
				        `;

				        // -------------------------------
				        // ADD YOUR CONDITION HERE
				        // SAME AS: if (!$studentLog)
				        // -------------------------------
				        /*if (!studentLoggedIn) {

				            html += `
				                <a class="btn btn-sm btn-primary"  
				                    title="Admission Payment Invoice"
				                    href="javascript:void(0);" 
				                    onclick="invoice_fee('${row.form_no}', ${row.fees_id}, '${row.code}')">
				                    <i class="bi bi-printer"></i>
				                </a>
				            `;
				        }*/

				        // 3. Re-Admission Fee or Invoice Print
				        if (row.ad_payment_status == 0 && hasAccess && notBlockedUser) {

				            if (row.allow_readmission == 1) {
				                html += `
				                    <a class="btn btn-sm btn-warning"
				                       href="${base_url}admin/student/collect-re-admission-fee/${row.code}">
				                       <i class="fa fa-money"></i> Collect Re Admission Fee
				                    </a>`;
				            }

				        } else {

				            // user groups allowed to see invoice section
				            if (adminLoggedIn || studentLoggedIn || nonTeaching || specialAdmin) {

				                // Only show invoice print if not a student login
				                if (!studentLoggedIn) {
				                    html += `
				                        <a title="Print Invoice Fee" class="btn btn-sm btn-primary"
				                           href="javascript:void(0);"
				                           onclick="invoice_fee('${row.form_no ?? ''}', '${row.fees_id}', '${row.code}', '${row.s_id}')">
				                           <i class="bi bi-printer"></i>
				                        </a>`;
				                }

				                // Show Monthly Fee or Collect Fee
				                if (row.allow_readmission == 1 && notBlockedUser) {
				                    html += `
				                        <a title="${studentLoggedIn ? 'Pay Monthly' : 'Collect'} Fee" class="btn btn-sm btn-warning"
				                           href="${base_url}admin/student/view-fee-structure/${row.code}">
				                           <i class="bi bi-cash"></i>
				                        </a>`;
				                }
				            }
				        }

				        return html;
		            }
		        },
		        { 
		            data: null,
		            render: function(data, type, row, meta) {
		                return meta.row + 1; // auto serial number
		            }
		        },
		        { data: 'form_no' },
		        { data: 'code' },
		        { data: 'first_name' },
		        { data: 'academic_status' },
		        { data: 'section_name' },
		        { data: 'roll_num' },
		        { 
		            data: null,
		            render: function(data, type, row) {
		                // return `<img src="<?= base_url('uploads/') ?>${row.form_no}/${row.image}" width="40" />`;
		                return row.image ? `<img src="<?= base_url('uploads/') ?>${row.image}" width="40" />` : '';
		            }
		        },

		        { data: 'class_name' },
		        {
				    data: null,
				    render: function(data, type, row) {
				        const firstName = row.teacher_first_name || '';
				        const lastName = row.teacher_last_name || '';
				        const fullName = (firstName + ' ' + lastName).trim();
				        return fullName || ''; // return empty string if both are null/empty
				    }
				},
		        { data: 'lkg_onw_sec_lang' },
		        { data: 'd_o_b' },
		        <?php if(session()->get('admin_logged_in') === true): ?> 
		            { data: 'allow_transport', render: function(d){ return d ? 'Yes' : 'No'; } },
		            { data: 'allow_readmission', render: function(d){ return d ? 'Yes' : 'No'; } },
		        <?php endif; ?>
		        { data: 'father_name' },
		        { data: 'mother_name' },
		        { data: 'father_mobile' },
		        { data: 'mother_mobile' },
		        { data: 'bus_licence_no' },
		        { data: 'stoppage_name' },
		        // { 
		        //     data: 'tuition_fee',
		        //     render: function(data, type, row) {
		        //         return parseFloat(data).toFixed(2);
		        //     }
		        // },
		        { data: 'tuition_fee' },
		        { data: 'bus_services' }
		        
		    ],
		    columnDefs: [
		        { targets: 0, visible: true, searchable: false, orderable: true }
		    ],
		    order: [[0, 'asc']],
		    scrollX: true,
		    serverSide: false,
		    processing: true
		});

		$("#fee_items").click(function(){
			$("#fee_data").print();
		});

		// Submit button click event
		$('#studentDetailsCSVSubmit').on('click', function(e) {
			e.preventDefault();
			var form = $('#studentDetailsCSVForm')[0];
			var formData = new FormData();
			console.log(form)
			console.log(formData)
			// Validate form
			var fileInput = $('#upload_csv')[0];
			if (fileInput.files.length === 0) {
				showMessage('Please select a CSV file to upload.', 'danger');
				return false;
			}
			var file = fileInput.files[0];

			// Validate file type
			if (!file.name.toLowerCase().endsWith('.csv')) {
				showMessage('Please upload a valid CSV file.', 'danger');
				return false;
			}
			// Add file to FormData
			formData.append('studentfile', file);
			// Add CSRF token if using CodeIgniter
			formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

			// Show loading state
			var submitBtn = $(this);
			var originalText = submitBtn.html();
			submitBtn.prop('disabled', true).html('<i class="ph-spinner ph-spinner-gap"></i> Processing...');

			$.ajax({
				url: '<?= base_url("admin/student/import-student-details") ?>', // Update with your actual endpoint
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function(response) {
					console.log(response);
					let html = '';
					if (response.status === 'success') {
						var message = response.message;
						// ✅ Main success message
						html += `
						<div class="alert alert-success alert-dismissible fade show">
							<i class="ph ph-check-circle me-2"></i>
							<strong>Upload Completed</strong><br>
							${response.message}
							<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
						</div>
						`;
						// ✅ Summary info
				        if (response.data) {
				            html += `
				                <div class="alert alert-info alert-dismissible fade show">
				                    <strong>Summary:</strong><br>
				                    Processed: ${response.data.processed}<br>
				                    Failed: ${response.data.failed}
				            		<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				                </div>
				            `;
				        }

						// ❌ SHOW ERRORS (even on success)
				        if (
				            response.data &&
				            response.data.errors &&
				            response.data.errors.length > 0
				        ) {
				            let errorList = response.data.errors
				                .map(err => `<li>${err}</li>`)
				                .join('');

				            html += `
				                <div class="alert alert-danger alert-dismissible fade show">
				                	<i class="ph ph-check-circle me-2"></i>
				                    <strong>Errors Found:</strong>
				                    <ul class="mb-0">${errorList}</ul>
				            		<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				                </div>
				            `;
				        }
						$('#showMsginmodal').html(html);
						// Reset form
				        form.reset();
					} else {
						var errorMsg = `
				            <div class="alert alert-danger alert-dismissible fade show">
				                <i class="ph ph-x-circle me-2"></i>
				                <strong>Upload Failed!</strong><br>
				                ${response.message}
				                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				            </div>
				        `;
				        
				        $('#showMsginmodal').html(errorMsg);
					}
				},
				error: function(xhr, status, error) {
					console.error('Upload error:', error);
					
					var errorMessage = 'An error occurred during upload.';
					if (xhr.responseJSON && xhr.responseJSON.message) {
						errorMessage = xhr.responseJSON.message;
					} else if (xhr.responseText) {
						errorMessage = xhr.responseText;
					}
					
					showMessage(errorMessage, 'danger');
				},
				complete: function() {
					// Reset button state
					submitBtn.prop('disabled', false).html(originalText);
				}
			});
		});
	});

	function invoice_fee(formNo, feeId, sCode, studentId){
		$.ajax({
			url: "<?= base_url('admin/student/ajax-student-paid-fee-invoice') ?>",
			method: "post",					
			data: {
				feeId:feeId,
				formNo:formNo,
				sCode:sCode,
				studentId:studentId
			},				  
			success: function(data){
				console.log(data)
				$("#feeInvModal").modal("show");					
				var json_obj = JSON.parse(data);						
				$("#fee_data").html(json_obj.html);							
			}
		 });								
	}

	function importView () {
		let html = '';
		$('#showMsginmodal').html(html);
		$("#import_student_details_modal").modal("show");
	}
	
</script>

<script>
	$(document).ready(function() {
	    $('#student_code').on('input', function() {
	        let value = $(this).val().replace(/[^0-9]/g, ""); // keep only digits

	        if (value.length > 2) {
	            value = value.slice(0, 2) + "-" + value.slice(2, 6);
	        }

	        $(this).val(value);
	    });
	});
</script>

<style>
	#feeInvModal .modal-content {
	    color: #000000 !important;
	}
	#feeInvModal table,
	#feeInvModal table tr,
	#feeInvModal table td,
	#feeInvModal table th {
	    color: #000; /* change this to any color */
	}

</style>
<div class="modal fade modal-lg" id="feeInvModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="">Student Fees Payment Invoice</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">	 
				<div class="row">
					<div class="col-xs-12">
						<div class="row">
							<div class="col-sm-12">
								<div class="widget-box transparent" id="fee_data"></div>
							</div>
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->		
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="fee_items">Print</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade modal-lg" id="import_student_details_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="">Import Student Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">	 
				<div class="row">
					<div class="col-xs-12">
						<form method="post" class="needs-validation" action="#" novalidate id="studentDetailsCSVForm" data-id="">
							<div class="row">
								<div class="col-sm-12">
									<div class="col-lg-3">
										<div class="mb-3">
											<label for="upload_csv">Upload CSV File</label>
											<input type="file" class="form-control" name="upload_csv" id="upload_csv" />
										</div>
									</div>
	
									<div class="col-lg-3">
										<div class="mb-3">
											<button type="button" id="studentDetailsCSVSubmit" class="btn btn-primary ms-3">Submit<i class="ph-paper-plane-tilt ms-2"></i></button>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<h2>Sample Template Layout <a target="_blank" href="<?= base_url('uploads/import-csv/student-details.csv') ?>" download>(Download)</a></h2>
								<div class="col-lg-12">
									<h4 style="color: red;">Note*</h4>
									<p style="color: red;">
										Please ensure that you do not modify the header columns in the sample Excel file while
										preparing your data. Enter only valid student codes exactly as they exist in the system 
										and provide the correct elective subject for each student, The subject spelling must be 
										correct and match the system records. Any row containing an invalid student code or an 
										unmatched/incorrect subject will be automatically skipped during processing.
									</p>
									<p style="color: red;">
										After uploading the file, the system will process all valid entries and ignore invalid ones. 
										Once the import is completed, a summary will be displayed on the screen showing the number of 
										successfully imported records along with details of any skipped rows and the reasons for their 
										failure, such as invalid student codes or subject mismatches.
									</p>
								</div>
								<div id="showMsginmodal"></div>
							</div>
						</form>
					</div><!-- /.col -->
				</div><!-- /.row -->		
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<!-- <button type="button" class="btn btn-primary" id="fee_items">Print</button> -->
			</div>
		</div>
	</div>
</div>