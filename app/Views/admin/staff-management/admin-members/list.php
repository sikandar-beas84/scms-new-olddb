<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
	$(document).ready(function() {
	    var table = $('#memberLists').DataTable({
	        responsive: true,
	        ajax: {
	         	url: "<?= base_url('admin/staff-management/admin-members/fetch') ?>",
	         	// dataSrc: 'users',
	         	dataSrc: function(json) {
			        // console.log(json); // 👈 check actual response
			        return json.users || json; // if "users" key exists, return it, else raw
			    },
		        type: 'POST',
		        dataType: 'json',
	        },
	        columns: [
				{ data: 'id', defaultContent: '' },
				{ 
				data: 'image',
				render: function(data, type, row) {
				  if (data && data !== '' && data !== null && data !== 'null') {

				  	let imgUrl = '';
				  	if( row.dept_id == 1 || row.dept_id == 2  ) {
				  		imgUrl = "<?= base_url('uploads/') ?>profile/" + data;
				  	} else {
				  		imgUrl = "<?= base_url('uploads/') ?>" + row.code + '/' + data;
				  	}
				  	
				    return `
				      <a data-fancybox="gallery" href="${imgUrl}">
				        <img src="${imgUrl}" width="60px" class="rounded border"/>
				      </a>`;
				  } else {
				    return `<img src="<?= base_url('uploads/default.png') ?>" width="60px" class="rounded border"/>`;
				  }
				},
				defaultContent: ''
				},
				{ data: 'dept_name', defaultContent: '' },
				{ 
				data: null,
				render: function(data, type, row) {
				  let fname = row.first_name ? row.first_name : '';
				  let lname = row.last_name ? row.last_name : '';
				  return fname + ' ' + lname;
				},
				defaultContent: ''
				},
				{ data: 'code', defaultContent: '' },
				{ 
				data: 'status',
				render: function(data, type, row) {
				  let checked = (data === 't' || data === true  || data === 1 || data === '1' || data === 'true') ? 'checked' : '';
				  return `
				    <div class="form-check-horizontal">
				      <label class="form-check form-switch mb-0">
				        <input type="checkbox" class="current-status form-check-input" data-id="${row.id}" ${checked} />
				      </label>
				    </div>`;
				},
				defaultContent: ''
				},
				{ data: 'mobile', defaultContent: '' },
				{ data: 'address', defaultContent: '' },
				{ data: 'pancard_number', defaultContent: '' },
				{ data: 'aadhar_number', defaultContent: '' },
				{ data: 'bank_acc_number', defaultContent: '' },
				{ data: 'bank_ifsc_number', defaultContent: '' },
				{ data: 'pf_number', defaultContent: '' }, // 🟢 this column is PF, not UAN
				{
				data: null,
				render: function(data, type, row) {
				  let editUrl = "<?= base_url('admin/staff-management/admin-members/edit/') ?>";
				  return `
				    <span class="editBtn" data-id="${row.id}" title="Edit">
				      <a href="${editUrl}${row.id}"><i class="ph-note-pencil"></i></a>
				    </span>
				    <span class="deleteBtn" data-id="${row.id}" title="Delete">
				      <i class="ph-trash"></i>
				    </span>`;
				},
				defaultContent: ''
				}
			],
	        columnDefs: [
	            { targets: 0, visible: false, searchable: false, orderable: true }
	        ],
	        order: [[0, 'desc']],
	        scrollX: true,
	    });

	    $(document).on('change', '.current-status', function(){
		    let checkbox = $(this);
		    let id = checkbox.data('id');
		    let isChecked = checkbox.prop('checked');

		    $.ajax({
	            url: "<?= base_url('admin/staff-management/admin-members/set-current-status') ?>",
	            type: "POST",
	            data: {
	                id: id,
	                is_checked: isChecked,
	                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
	            },
	            success: function(res) {
	                // Reload DataTable to update toggles
	                table.ajax.reload(null, false);
	            },
	            error: function() {
	                console.log("Failed to update status");
	                checkbox.prop('checked', false)
	            }
	        });
		});

		$('#memberLists tbody').on('click', '.deleteBtn', function(e) {
			e.preventDefault();

	        let userId = $(this).data("id");
	        if (!userId || isNaN(userId)) {
	            Swal.fire("Error", "Invalid user ID.", "error");
	            return;
	        }

	        Swal.fire({
	            title: "Are you sure?",
	            text: "This user will be permanently deleted!",
	            icon: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#d33",
	            cancelButtonColor: "#3085d6",
	            confirmButtonText: "Yes, delete it!"
	        }).then((result) => {
	            if (result.isConfirmed) {

	                // ✅ CSRF token setup (CodeIgniter 4)
	                let csrfName = "<?= csrf_token() ?>"; 
	                let csrfHash = "<?= csrf_hash() ?>";

	                $.ajax({
	                    url: "<?= site_url('admin/staff-management/admin-members/delete/') ?>/" + userId,
	                    type: "DELETE",
	                    data: {
	                        [csrfName]: csrfHash
	                    },
	                    dataType: "json",
	                    success: function (response) {
	                        if (response.status === "success") {
	                            Swal.fire("Deleted!", response.message, "success");

	                            // remove row dynamically if inside a table
	                            $("span[data-id='" + userId + "']").closest("tr").fadeOut();
	                            table.ajax.reload(null, false);
	                        } else {
	                            Swal.fire("Error", response.message, "error");
	                        }
	                    },
	                    error: function () {
	                        Swal.fire("Error", "Something went wrong. Please try again.", "error");
	                    }
	                });
	            }
	        });
		});
	});
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

	<!-- Page length options -->
	<div class="card">
		<div class="card-header">
			<h5 class="mb-0">All <?= $title ?></h5>
		</div>
		
		<div id="showMsg"></div>

		<div class="card-body">
			<table id="memberLists" class="display responsive nowrap">
		        <thead>
		            <tr>
						<th> ID </th>
						<th> Profile pic </th>
						<th> User Type </th>
						<th> Name </th>
						<th> Employee Code  </th>
						<th> Status  </th>
						<th> Phone No </th>
						<th> Address </th>
						<th> PAN No </th>
						<th> Adhar No </th>
						<th> Bank Account </th>
						<th> IFSC </th>
						<th> UAN </th>
						<th> Action </th>
		            </tr>
		        </thead>
		        <!-- <tbody>
		            <tr>
		                <td>Tiger</td>
		                <td>Nixon</td>
		                <td>System Architect</td>
		                <td>Edinburgh</td>
		                <td>61</td>
		                <td>2011-04-25</td>
		                <td>$320,800</td>
		                <td>5421</td>
		                <td>t.nixon@datatables.net</td>
		                <td>61</td>
		                <td>2011-04-25</td>
		                <td>$320,800</td>
		                <td>5421</td>
		                <td>t.nixon@datatables.net</td>
		            </tr>
		            <tr>
		                <td>Garrett</td>
		                <td>Winters</td>
		                <td>Accountant</td>
		                <td>Tokyo</td>
		                <td>63</td>
		                <td>2011-07-25</td>
		                <td>$170,750</td>
		                <td>8422</td>
		                <td>g.winters@datatables.net</td>
		                <td>61</td>
		                <td>2011-04-25</td>
		                <td>$320,800</td>
		                <td>5421</td>
		                <td>t.nixon@datatables.net</td>
		            </tr>
		        </tbody> -->
		    </table>
		</div>
	</div>
	<!-- /page length options -->
</div>
<!-- /content area -->

<!-- all_users -->