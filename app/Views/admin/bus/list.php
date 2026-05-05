<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="<?= base_url('public/admin/assets/js/vendor/forms/validation/validate.min.js') ?>"></script>

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
<?php if (session()->getFlashdata('success_msg')): ?>
	<div class="alert bg-success text-white alert-dismissible fade show">
		<?= session()->getFlashdata('success_msg'); ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
	</div>
<?php endif; ?>	

<?php if (session()->getFlashdata('error_msg')): ?>
	<div class="alert bg-danger text-white alert-dismissible fade show">
		<?= session()->getFlashdata('error_msg'); ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
	</div>
<?php endif; ?>	


<!-- Content area -->
<div class="content">
	<!-- Custom styles -->
	<div class="row">
		<div class="card">
			<div class="card-header d-flex align-items-center">
				<h5 class="mb-0">Bus Lists</h5>
				<div class="d-inline-flex ms-auto">
					<a class="btn btn-indigo" href="<?= base_url('admin/bus/add') ?>"><i class="ph-plus-circle me-2"></i> Add Bus</a>
				</div>
			</div>
			
			<table id="busLists" class="display">
			    <thead>
			        <tr>
			            <th>ID</th>
			            <th>Vendor</th>
						<th>Serial No</th>
						<th>Lic No</th>
						<th>Seat Capacity</th>
						<th>Driver Name</th>
						<th>Driver Phone No</th>
						<th>Attendent Name</th>
						<th>Attendent Phone No</th>
						<th>Status</th>
						<th>Action</th>
			        </tr>
			    </thead>
			    <tbody>
			    	<?php if( isset($bus_list) && !empty($bus_list) ) {
			    		foreach($bus_list as $bus) : ?>
			    			<tr>
				    			<td><?php echo $bus['bus_id']; ?></td>
				    			<td><?php echo $bus['first_name'].' '.$bus['last_name']; ?></td>
								<td><?= $bus['bus_serial_no'] ?></td>
								<td><?= $bus['bus_licence_no'] ?></td>
								<td><?= $bus['bus_seating_capacity'] ?></td>
								<td><?= $bus['bus_driver_name'] ?></td>
								<td><?= $bus['bus_driver_phone'] ?></td>
								<td><?= $bus['bus_attendent_name'] ?></td>
								<td><?= $bus['bus_attendent_phone'] ?></td>
								<td><?= ($bus['status'] == 1 ? '<span class="badge bg-primary bg-opacity-10 text-primary">Active</span>' : '<span class="badge bg-danger bg-opacity-10 text-danger">Inactive</span>') ?></td>												
								<td>
									<div class="action-buttons">													
										<a class="editBtn" href="<?= base_url('admin/bus/edit-bus/'. $bus['bus_id']) ?>">
											<i class="ph-note-pencil"></i>
										</a>
										<a class="deleteBtn" data-id="<?= $bus['bus_id'] ?>" onclick="busdelete(<?= $bus['bus_id'] ?>)">
											<i class="ph-trash"></i>
										</a>
									</div>
								</td>
							</tr>
				    	<?php endforeach;
				    } ?>
			    </tbody>
			</table>
			

		</div>
	</div>
	<!-- /custom styles -->
</div>
<!-- /content area -->

<script>
	$(document).ready(function () {
	    $('#busLists').DataTable({
	        paging: true,
	        searching: true,
	        ordering: true,
	        order: [[0, 'DESC']], // order by ID
	        pageLength: 10,
	        columnDefs: [
		        {
		            targets: 0,      // first column
		            visible: false,  // hide it
		            searchable: false
		        }
		    ]
	    });


	    // Delete
		$('#busLists').on('click', '.deleteBtn', function () {

		    var id = $(this).data('id');

		    Swal.fire({
		        title: 'Are you sure?',
		        text: 'This bus will be permanently deleted!',
		        icon: 'warning',
		        showCancelButton: true,
		        confirmButtonColor: '#d33',
		        cancelButtonColor: '#3085d6',
		        confirmButtonText: 'Yes, delete it!',
		        cancelButtonText: 'Cancel'
		    }).then((result) => {
		        if (result.isConfirmed) {
		            $.get("<?= site_url('admin/bus/delete/') ?>" + id, function (res) {
		                if (res.status === 'success') {
		                    Swal.fire({
							    title: 'Deleted!',
							    text: 'Bus has been deleted.',
							    icon: 'success',
							    confirmButtonText: 'OK'
							}).then((result) => {
							    if (result.isConfirmed) {
							        location.reload();   // full page reload
							    }
							});
		                } else {
		                    Swal.fire(
		                        'Error!',
		                        res.message ?? 'Delete failed.',
		                        'error'
		                    );
		                }

		            }, 'json').fail(function () {
		                Swal.fire(
		                    'Error!',
		                    'Server error occurred.',
		                    'error'
		                );
		            });
		        }
		    });
		})

	});

</script>