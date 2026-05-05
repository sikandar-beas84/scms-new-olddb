<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>

<style>
	.tooltip-wrapper {
		position: relative;
		display: inline-block;
		cursor: pointer;
	}

	.tooltip-wrapper .tooltip-content {
		display: none;
		position: absolute;
		left: 0;
		top: 100%;
		z-index: 999;
		background: #fff;
		color: #000;
		padding: 8px;
		border: 1px solid #ccc;
		width: max-content;
		min-width: 200px;
		box-shadow: 0 2px 6px rgba(0,0,0,0.2);
	}

	.tooltip-wrapper:hover .tooltip-content {
		display: block;
	}

</style>
<script> const base_url = "<?= base_url(); ?>"; </script>
<script>
	$(document).ready(function() {
	    var table = $('#studentLists').DataTable({
	    	pageLength: 25, // 👈 default number of rows per page
  			lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	        responsive: true,
	        ajax: {
	         	url: "<?= base_url('admin/student/ajax_request_ent_exam_student_list') ?>",
	         	// dataSrc: 'student_list',
	         	dataSrc: function(json) {
			        console.log("json"); // 👈 check actual response
			        console.log(json); // 👈 check actual response
			        // save class_list in a global variable
            		class_list = json.class_list || [];

            		// ✅ Count total students and set to input
		            let totalStudents = 0;
		            if (json.student_list && Array.isArray(json.student_list)) {
		                totalStudents = json.student_list.length;
		            } else if (Array.isArray(json)) {
		                totalStudents = json.length;
		            }

		            // Set value inside input
		            $('#totalStudent').val(totalStudents);

			        return json.student_list || json; // if "student_list" key exists, return it, else raw
			    },
		        type: 'POST',
		        dataType: 'json',
		        data: function (d) {
		            d.class_id = $('#class_id').val(); // get class_id from dropdown or input 
		            d.ad_exam_qualified = $('#ad_exam_qualified').val(); // get ad_exam_qualified from dropdown 
		            
		            // you can send more values like:
		            // d.session_year_id = $('#session_year_id').val();
		        },
	        },
	        columns: [
				{ data: 'id', defaultContent: '' },
				// { data: 'form_no', defaultContent: '' },
				{ 
		            data: 'form_no',
		            render: function (data, type, row, meta) {
		                return `
		                    <input type="text" name="form_no_${meta.row + 1}" value="${row.form_no}" style="display: none;">
		                    ${data}
		                `;
		            }
		        },
				{ data: 'first_name', defaultContent: '' },
				{ data: 'class_name', defaultContent: '' },
				// { data: 'created_date', defaultContent: '' },
				{
				  	data: 'created_date',
				  	defaultContent: '',
				  	render: function (data, type, row) {
					    if (!data) return '';
					    const dateObj = new Date(data);
					    const options = { 
					      	year: 'numeric', month: 'long', day: 'numeric', 
					      	hour: '2-digit', minute: '2-digit', hour12: true 
					    };
					    return dateObj.toLocaleString('en-US', options);
				  	}
				},

				{ data: 'father_name', defaultContent: '' },
				{ data: 'mother_name', defaultContent: '' },
				// { data: '', defaultContent: '' },
				{
					data: 'reg_fee_id',
					defaultContent: '',
					render: function (data, type, row) {
					    if (data) {
					      	// Payment info available
					      	return `
				      		<span class="tooltip-wrapper btn btn-sm btn-success">
							  	<i class="bi bi-info-circle"></i> Paid
							  	<div class="tooltip-content">
								    <h4 class='m-0'>Payment Details</h4>
								    <table class='table text-left text-black mt-10 mb-0'>
								      <tr><td>Payment Mode</td><td>${row.payment_type}</td></tr>
								      <tr><td>Amount</td><td>${row.payment_amount}</td></tr>
								      <tr><td>Transaction No</td><td>#${row.reg_fee_id}</td></tr>
								      <tr><td>Payment Date</td><td>${new Date(row.payment_date).toLocaleString('en-US', {year:'numeric',month:'long',day:'numeric',hour:'2-digit',minute:'2-digit',hour12:true})}</td></tr>
								    </table>
							  	</div>
							</span>
				      		<span>
					      		<a href="javascript:;" onclick="invoice_registration_fee('${row.form_no}')"><i class="bi bi-printer"></i> Print</a>
				      		</span>`;
					    } else {
					      	// No payment yet
					      	return `<button formid="${row.form_no}" studentName="${row.first_name}" type="button" class="formid btn btn-sm btn-warning" data-toggle="modal" data-target="#myModal"><i class="fa fa-inr"></i> Due </button>`;
					    }
					}
				},

				// { data: '', defaultContent: '' },
				{
				  	data: null,
				  	defaultContent: '',
					render: function (data, type, row, meta) {
						// Show Pass/Fail/Not Appeared/Submitted
						// 0-Fail, 1-Pass, 2-Not Appeared, 3-Submitted, 4- Not Submitted, 5 - Reject

					    if( row.ad_exam_qualified == 4 ) {
					      	return `
					        <div class="radio">
					          	<label><input type="radio" name="result_${meta.row + 1}" value="4" ${row.ad_exam_qualified == 4 ? 'checked' : ''}> <span class="lbl btn btn-sm btn-inverse">Not Submitted</span></label>
					          	<label><input type="radio" name="result_${meta.row + 1}" value="3" ${row.ad_exam_qualified == 3 ? 'checked' : ''}> <span class="lbl btn btn-sm btn-warning">Submitted</span></label>
					        </div>
					      `;
					    } else if (row.reg_fee_id && (row.ad_exam_qualified == 3 || row.ad_exam_qualified == 0 || row.ad_exam_qualified == 1 || row.ad_exam_qualified == 2)) {
					      return `
					        <div class="radio">
					          	<label><input type="radio" name="result_${meta.row + 1}" value="1" ${row.ad_exam_qualified == 1 ? 'checked' : ''}> <span class="lbl btn btn-sm btn-primary">Pass</span></label>
					          	<label><input type="radio" name="result_${meta.row + 1}" value="0" ${row.ad_exam_qualified == 0 ? 'checked' : ''}> <span class="lbl btn btn-sm btn-danger">Fail</span></label>
					      		<label><input type="radio" name="result_${meta.row + 1}" value="2" ${row.ad_exam_qualified == 2 ? 'checked' : ''}> <span class="lbl btn btn-sm btn-inverse">Not Appeared</span></label>
					        </div>
					      `;
					    } else if (row.last_year_marksheet) {
					      // Show Approve/Reject + view links
					      return `
					        <div class="radio">
					          	<label><input type="radio" name="result_${meta.row + 1}" value="4" ${row.ad_exam_qualified == 4 ? 'checked' : ''}> <span class="lbl btn btn-sm btn-primary">Approve</span></label>
					        </div>
					        <div class="radio">
					          	<label><input type="radio" name="result_${meta.row + 1}" value="5" ${row.ad_exam_qualified == 5 ? 'checked' : ''}> <span class="lbl btn btn-sm btn-danger">Reject</span></label>
					        </div>
					        <a target="_blank" href="${base_url}front/registration/formView/${row.form_no}">View Form</a><br>
					        ${row.last_year_marksheet ? `<a target="_blank" href="${base_url}uploads/marksheet/${row.last_year_marksheet}">View Marksheet</a><br>` : ''}
					        ${row.father_id ? `<a target="_blank" href="${base_url}uploads/father_id/${row.father_id}">View Father Id</a><br>` : ''}
					        ${row.mother_id ? `<a target="_blank" href="${base_url}uploads/mother_id/${row.mother_id}">View Mother Id</a><br>` : ''}
					        ${row.student_birth_certificate ? `<a target="_blank" href="${base_url}uploads/student_id/${row.student_birth_certificate}">View Student Id</a><br>` : ''}
					        ${row.cast_certificate ? `<a target="_blank" href="${base_url}uploads/cast_certificate/${row.cast_certificate}">View Cast Certificate</a><br>` : ''}
					        ${row.student_admit ? `<a target="_blank" href="${base_url}uploads/student_admit/${row.student_admit}">View Student Admit</a>` : ''}
					      `;
					    } else {
					    	/*if( row.ad_exam_qualified == 4 ) {
						      	return `
						        <div class="radio">
						          	<label><input type="radio" name="result_${row.id}" value="2" ${row.ad_exam_qualified == 2 ? 'checked' : ''}> <span class="lbl btn btn-sm btn-inverse">Not Appeared</span></label>
						          	<label><input type="radio" name="result_${row.id}" value="3" ${row.ad_exam_qualified == 3 ? 'checked' : ''}> <span class="lbl btn btn-sm btn-warning">Submitted</span></label>
						        </div>
						      `;
						    } else {*/
					    	return `
					        <div class="radio">
					    		<label> <span class="lbl btn btn-sm btn-warning">DUE</span></label>
					        </div>
					      	`;
						    // }
					    }
					}
				},
				// { data: 'rejection_reason', defaultContent: '' },
				{
					data: 'rejection_reason',
					defaultContent: '',
				  	render: function (data, type, row, meta) {
					    // If rejection_reason is empty/null
					    if (!data || data.trim() === '') {
					      	// Then check if last_year_marksheet exists
					      	if (row.last_year_marksheet) {
					        	// You can return something meaningful, like a link
					        	return `<div class="rejection_reason">
						            <textarea id="reject_reason_${meta.row + 1}" 
						                      name="reject_reason_${meta.row + 1}" 
						                      class="form-control" 
						                      placeholder="Give Rejection Reason..."></textarea>
						          </div>`;
					      	} else {
					        	// Otherwise show default text
					        	return '';
					      	}
					    } else {
					      	// If rejection_reason has a value, show it normally
					      	return '';
					    }
				  	}
				},

				// { data: '', defaultContent: '' },
				{
		            data: null,
		            render: function(data, type, row, meta) {
		                if (!row.reg_fee_id) {
		                    return '';
		                }

		                let html = `<select class="form-select change-class" data-dob="${row.d_o_b}" data-old-class="${row.class_id}"  name="class_id_` + (meta.row + 1) + `">`;
		                html += '<option value="">--Select--</option>';

		                class_list.forEach(function(cls) {
		                    const selected = (cls.id == row.class_id) ? 'selected' : '';
		                    html += `<option value="${cls.id}" ${selected}>${cls.class_name}</option>`;
		                });

		                html += '</select>';
		                return html;
		            }
		        },
		        {
		            data: null,
		            render: function(data, type, row) {
		                let html = `
				            <div class="hidden-sm hidden-xs btn-group">
				                <a class="btn btn-xs btn-info" href="${base_url}admin/student/edit/${row.student_id}" >
				                    <i class="bi bi-pencil-square"></i>
				                </a>
		                	</div>
				        `;

				        return html;
		            }
		        }
			],
	        columnDefs: [
	            { targets: 0, visible: false, searchable: false, orderable: true }
	        ],
	        order: [[0, 'desc']],
	        scrollX: true,
	        serverSide: false,  // 👈 this is key
		    processing: true,
	    });

	    $('#studentListSearch').on('click', function(e) {
	    	let getClassId = $('#class_id').val();
	    	if (!getClassId || getClassId.trim() === '') {
		    	Swal.fire({
	                icon: 'info',
	                title: '',
	                text: 'Please select class'
	            });

	            return false;
	        }

	    	table.ajax.reload();
	    });

		$('#studentLists tbody').on('click', '.formid', function() {
		    var form_no = $(this).attr('formid'); // get the form id
		    var student_name = $(this).attr('studentName'); // get the form id

		    // Set the hidden input & modal display
		    $('#myModal').find('input.form_no').val(form_no);
		    $('#myModal').find('.form_no').val(form_no);

		    $('#myModal').find('input.payee_name').val(student_name);
		    $('#myModal').find('.payee_name').val(student_name);

		    $('#myModal').modal('show');
		});

		//cash payment
		$('#myModal').on('click', '#sub_cpay', function(e) {
			var r = confirm("Confirm?");
			if ( r == true ) {
				var dataString = $('#cpay').serialize();
				$.ajax({
					url:'<?=base_url() ?>admin/student/add_reg_payment',
					method: 'post',					
					data: dataString,				  
					success: function(data){
						if(data > 0){							
							$('.cpay_msg').html('<div class="alert alert-block alert-success"><p><strong><i class="ace-icon fa fa-check"></i>Success</strong>Your Transaction is Successfull . Transaction ID #'+ data +'</p></div>');
							setTimeout(function(){
								table.ajax.reload();
								$('#myModal').modal('hide');
							}, 1500);								
							
						} else {								
							$('.cpay_msg').html('<div class="alert alert-danger"><strong><i class="ace-icon fa fa-times"></i> Failed! </strong>Their is an error for this transaction<br></div>');
						}
					}
				}) 
			} else {				
				e.preventDefault();
			}				
		});	

		//cheque payment
		$('#myModal').on('click', '#sub_chqpay', function(e) {
			var r = confirm("Confirm?");
			if ( r == true ) {
				var dataString = $('#chqpay').serialize();
				$.ajax({
					url:'<?=base_url() ?>admin/student/add_reg_payment',
					method: 'post',					
					data: dataString,				  
					success: function(data){
						if(data > 0){							
							$('.chqpay_msg').html('<div class="alert alert-block alert-success"><p><strong><i class="ace-icon fa fa-check"></i>Success</strong>Your Transaction is Successfull . Transaction ID #'+ data +'</p></div>');
							setTimeout(function(){
								table.ajax.reload();
								$('#myModal').modal('hide');
							}, 1500);	
						} else {								
							$('.chqpay_msg').html('<div class="alert alert-danger"><strong><i class="ace-icon fa fa-times"></i> Failed! </strong>Their is an error for this transaction<br></div>');
						}
					}
				}) 
			} else {				
				e.preventDefault();
			}				
		});

		//pos payment
		$('#myModal').on('click', '#sub_pospay', function(e) {
			var r = confirm("Confirm?");
			if ( r == true ) {
				var dataString = $('#pospay').serialize();
				$.ajax({
					url:'<?=base_url() ?>admin/student/add_reg_payment',
					method: 'post',					
					data: dataString,				  
					success: function(data){
						if(data > 0){							
							$('.pospay_msg').html('<div class="alert alert-block alert-success"><p><strong><i class="ace-icon fa fa-check"></i>Success</strong>Your Transaction is Successfull . Transaction ID #'+ data +'</p></div>');
							setTimeout(function(){
								table.ajax.reload();
								$('#myModal').modal('hide');								
							}, 1500);	
						} else {								
							$('.pospay_msg').html('<div class="alert alert-danger"><strong><i class="ace-icon fa fa-times"></i> Failed! </strong>Their is an error for this transaction<br></div>');
						}
					}
				}) 
			} else {				
				e.preventDefault();
			}				
		});

		$("#fee_items").click(function(){
			$("#fee_data").print();
		});
	});

	$(document).ready(function() {
		$('#submitFormBtn').on('click', function(e) {
		  	e.preventDefault();

		  	var table = $('#studentLists').DataTable();
	  	 	
	  	 	// Move to last page
		    table.page('last').draw('page');

		    // Wait for draw to complete, then go back and collect data
		    table.one('draw', function () {
		        // Now you are on last page, collect all data
		        var allInputs = table.$('input, select, textarea').serializeArray();
		        console.log(allInputs);

		        // Optional: return to first page
		        table.page('first').draw('page');
		    });

		  	// Use DataTables API to get *all* inputs from all pages
		  	var formData = {};

		  	// Loop through every row (not only visible)
		  	table.$('input, textarea, select').each(function () {
			    var name = $(this).attr('name');
			    var value;

			    if ($(this).is(':radio')) {
			      	// For radio buttons — only take the checked one
			      	if ($(this).is(':checked')) {
			        	value = $(this).val();
			        	formData[name] = value;
			      	}
			    } else {
			      	// For other input types
			      	value = $(this).val();
			      	formData[name] = value;
			    }
		  	});

		  	var totalstudent = $("#totalStudent").val()

		  	console.log(totalstudent); // ✅ all your table inputs, from all pages
		  	console.log(formData); // ✅ all your table inputs, from all pages
		  	// return false;

			// Now send via AJAX
			$.ajax({
	            url: "<?= base_url('admin/student/save-admission') ?>",
	            type: "POST",
	            data: {
	                totalstudent: totalstudent,
	                formData: formData,
	                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
	            },
	            dataType: "json"
	        })
	        .done(function(res) {
	            console.log('AJAX response:', res); // <-- debug line
	            table.ajax.reload();
	            if (res.status === 'success') {
	                Swal.fire({
	                    icon: 'success',
	                    title: 'Success!',
	                    text: res.message,
	                    timer: 2000,
	                    showConfirmButton: false
	                });
	            } else {
	                console.log(res.message || 'Details not found');
	                Swal.fire({
	                    icon: 'info',
	                    title: 'No Changes',
	                    text: res.message,
	                    timer: 2000,
	                    showConfirmButton: false
	                });
	            }
	        })
	        .fail(function(xhr, status, err) {
	            console.error('AJAX failed', status, err, xhr.responseText);
	            console.log('Failed to fetch session. See console for details.');
	        });
		});
	});

	function invoice_registration_fee(form_no)
	{
		if (!form_no) {
	        Swal.fire({
	            icon: "warning",
	            title: "Missing Form Number",
	            text: "Form number cannot be blank!",
	            confirmButtonColor: "#3085d6"
	        });
	        return;
	    }

		$.ajax({
			url: "<?= base_url('admin/student/ajax-student-registration-fee-invoice') ?>",
			method: "post",					
			data: {
				form_no:form_no,
			},				  
			success: function(data){
				$("#feeInvModal").modal("show");					
				var json_obj = JSON.parse(data);						
				$("#fee_data").html(json_obj.html);							
			}
	 	});
	}

	$(document).on('change', '.change-class', function () {

		const selectedClassText = $(this).find('option:selected').text();
		const selectedClassId = $(this).val();
		const dob = $(this).data('dob');
		const oldClass = $(this).data('old-class');
		const $this = $(this);

		// console.log(selectedClassText);
		// console.log(selectedClassId);
		// console.log(dob);
		// console.log(oldClass);
		// console.log($this);
		if(dob){
			Bdob = new Date(dob);						
			var today = new Date();
			var age = Math.floor((today-Bdob) / (365.25 * 24 * 60 * 60 * 1000));
			// console.log(age);
			$.ajax({
				url:'<?= base_url('/get-age-limit') ?>',
				method: 'post',					
				data: {classId : selectedClassId, age : age, bDay : dob},				  
				success: function(data){
					if(data > 0){
						alert('You are Eligible for '+className);
					} else {
						alert(`Student not eligible for ${selectedClassText}. Age is ${age}`);
						$this.val(oldClass);
					}
				}
			})
		} else {
			alert('Date of Birth is not available');
		}

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
                        <select class="form-select" name="ad_exam_qualified" id="ad_exam_qualified">
							<option value="">Select Status</option>
							<option value="0">Fail</option>
							<option value="1">Pass</option>
							<option value="2">Not Appeared</option>
							<option value="3">Submitted</option>
							<option value="4" selected>Not Submitted</option>
							<option value="5">Rejected</option>
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
		<div class="card-header">
			<h5 class="mb-0">All <?= $title ?></h5>
		</div>
		
		<div id="showMsg"></div>

		<div class="card-body">
			<form role="form" class="form-horizontal" action="<?= base_url() ?>admin/student/entrance-exam-student-action" method="post" id="studentListsForm" autocomplete="off">
				<table id="studentLists" class="display responsive nowrap">
			        <thead>
			            <tr>
							<th> ID </th>
							<th>Registration No.</th>
							<th>Name</th>
							<th>Class</th>
							<th>Date</th>
							<th>Father Name </th>
							<th>Mother Name </th>
							<th>Registration Fee Payment Status</th>
							<th>Admission Exam Status</th>
							<th>Rejection Reason</th>
							<th>Change Class</th>
							<th>Action</th>
			            </tr>
			        </thead>
			    </table>
			    <input type="text" name="totalStudent" id="totalStudent" style="display: none;" />
			    <button type="button" id="submitFormBtn" class="btn btn-success">Submit</button>
			</form>
		</div>
	</div>
	<!-- /page length options -->
</div>
<!-- /content area -->

<!-- all_users -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Collect Registration Fees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs" id="modalTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">
                            Cash
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab" aria-controls="specs" aria-selected="false">
                            Cheque -> QR/UPI
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">
                            POS -> CARD
                        </button>
                    </li>
                </ul>
                
                <!-- Tab Content -->
                <div class="tab-content modal-tab-content" id="modalTabsContent">
                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                        <h4></h4>
                        <form class="form-horizontal" role="form" id="cpay" autocomplete="off">
							<p class="cpay_msg"></p>
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> Cash Amount </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control" name="payment_amount" placeholder="Cash Amount" value="<?= $admission_reg_fee?>" readonly />
								</div>
							</div>
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> Payee Name </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control payee_name" name="payee_name" value="" placeholder="Payee Name" readonly />
								</div>
							</div>
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> Form No </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control form_no" value="" disabled />
								</div>
							</div>
							<input type="hidden" class="form_no" name="form_no" value=""/>
							<input type="hidden" class="payment_type" name="payment_type" value="cash"/>
							<input type="hidden" class="t_user_id" name="t_user_id" value="<?= $user_id ?>"/>
							<input type="hidden" class="added_by" name="added_by" value="<?= $f_name ?>"/>
							<p></p>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="button" class="btn btn-primary" id="sub_cpay">Save</button>
								</div>
							</div>
						</form>
                    </div>
                    <div class="tab-pane fade" id="specs" role="tabpanel" aria-labelledby="specs-tab">
                        <h4></h4>
                        <form class="form-horizontal" role="form" id="chqpay" autocomplete="off">
							<p class="chqpay_msg"></p>
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> Cash Amount </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control" name="payment_amount" placeholder="Cash Amount" value="<?= $admission_reg_fee?>" readonly/>
								</div>
							</div>
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> Payee Name </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control payee_name" name="payee_name" value="" placeholder="Payee Name" readonly />
								</div>
							</div>													
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> Cheque No. </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control" name="cheque_number" placeholder="Cheque No"/>
								</div>
							</div>
							<input type="hidden" class="form_no" name="form_no" value=""/>
							<input type="hidden" class="payment_type" name="payment_type" value="cheque"/>
							<input type="hidden" class="t_user_id" name="t_user_id" value="<?= $user_id ?>"/>
							<input type="hidden" class="added_by" name="added_by" value="<?= $f_name ?>"/>
							<p></p>
							<button type="button" class="btn btn-primary" id="sub_chqpay">Save</button>
						</form>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <h4></h4>
                        <form class="form-horizontal" role="form" id="pospay" autocomplete="off">
							<p class="pospay_msg"></p>
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> POS Bank Name </label>
								<div class="col-sm-9 mb-2 mb-2">
									<select class="form-select" name="pos_bank_name">										
										<option value="AXIS">AXIS</option>
										<option value="BOB">BOB</option>
										<option value="SBI">SBI</option>
										<option value="HDFC">HDFC</option>
									</select>																		
								</div>
							</div>
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> POS Amount </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control" name="payment_amount" placeholder="Cash Amount" value="<?= $admission_reg_fee?>" readonly/>
								</div>
							</div>													
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> Reference Number </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control" name="pos_reference_number" placeholder="POS Referance Number"/>
								</div>
							</div>
							<div class="form-group">
								<label  class="col-sm-3 control-label" for=""> Payee Name </label>
								<div class="col-sm-9 mb-2">
									<input type="text" class="form-control payee_name" name="payee_name"  value="" placeholder="Payee Name" readonly />
								</div>
							</div>
							<input type="hidden" class="form_no" name="form_no" value=""/>
							<input type="hidden" class="payment_type" name="payment_type" value="pos"/>
							<input type="hidden" class="t_user_id" name="t_user_id" value="<?= $user_id ?>"/>
							<input type="hidden" class="added_by" name="added_by" value="<?= $f_name ?>"/>
							<p></p>
							<button type="button" class="btn btn-primary" id="sub_pospay">Save</button>
						</form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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
				<h5 class="modal-title" id="">Student Registration Fees Payment Invoice</h5>
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