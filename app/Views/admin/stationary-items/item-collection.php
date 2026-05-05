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
		<div class="card-header">
			<h5 class="mb-0">Search</h5>
		</div>
		<div class="card-body">
			<div class="row">
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
						<th>Sl No </th>
						<th>Student Code</th>
						<th>Student Name</th>
						<th>Student Status</th>
						<th>Total Price</th>
						<th>Item Collected Details</th>
						<th>Stationary Item Collection</th>
		            </tr>
		        </thead>
		        <tbody id="studentListsBody"></tbody>
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
	$(document).ready(function () {
		$("#studentListSearch").click(function (e) {
			let student_code = $("#student_code").val();

			if(student_code){
				// table.ajax.reload();
				$.ajax({
			        url: "<?= base_url('admin/stationary-items/ajax-stationary-item-collection-student-list') ?>",
			        type: "POST",
			        data: {
			            student_code: student_code
			        },
			        dataType: "json",
			        success: function(response) {
			            console.log(response);

			            $('#studentListsBody').html(response.html);
			        },
			        error: function(xhr) {
			            console.log(xhr.responseText);
			            // alert('Something went wrong!');
			            Swal.fire({
						    icon: 'warning',
						    title: '',
						    text: 'Something went wrong!',
						    confirmButtonText: 'OK'
						});
			        }
			    });
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

		$('#studentLists').DataTable({
	        pageLength: 25,
	        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
	        responsive: true,
	        scrollX: true,
	        processing: true,

	        columnDefs: [
	            { targets: 0, orderable: true, searchable: false } // serial no column
	        ],

	        order: [[0, 'asc']]
	    });

		/*let table = $('#studentLists').DataTable({
		    pageLength: 25,
		    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
		    responsive: true,
		    ajax: {
		        url: "<?= base_url('admin/stationary-items/ajax-stationary-item-collection-student-list') ?>",
		        type: 'POST',
		        dataType: 'json',
		        data: function(d) {
		            d.student_code = $('#student_code').val();
		        },
		        dataSrc: function(json) {
		            console.log(json); // check actual response
		            return json.student_list || json; // adjust key based on your response
		        }
		    },
		    columns: [
		        { 
		            data: null,
		            render: function(data, type, row, meta) {
		                return meta.row + 1; // auto serial number
		            }
		        },
		        { data: 'code' },
		        { data: 'first_name + middle_name + surname' },
		        { data: 'ad_payment_status if true then Admitted else Not Admitted' },
		        { data: 'total_price' },
		        { data: 'roll_num' },
		        { data: 'code' }
		    ],
		    columnDefs: [
		        { targets: 0, visible: true, searchable: false, orderable: true }
		    ],
		    order: [[0, 'asc']],
		    scrollX: true,
		    serverSide: false,
		    processing: true
		});

		// 🔴 STOP AJAX if student_code is blank
		$('#studentLists').on('preXhr.dt', function(e, settings, data) {
		    let studentCode = $('#student_code').val();

		    if (!studentCode) {
		        console.log('Please enter student code');
		        return false; // ❌ cancel ajax call
		    }
		});*/

	});
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