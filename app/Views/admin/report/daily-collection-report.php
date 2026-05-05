<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css">

<!-- First load jQuery -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

<script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>

<!-- DataTables Buttons JS + dependencies -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>



<script>
	$(document).ready(function() {
	    var table = $('#dailyCollectionReport').DataTable({
	    	pageLength: 25, // 👈 default number of rows per page
  			lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	        responsive: true,
	        dom:
			    "<'d-flex justify-content-between mb-2'<'left-col' B l><'right-col' f>>" +
			    "t" +
			    "<'d-flex justify-content-between mt-2'<'info'i><'pagination'p>>",
		    buttons: [
		        {
		            extend: 'excelHtml5',
		            text: '<i class="fa fa-file-excel-o"></i> Excel',
		            className: 'btn btn-success btn-sm',
		            titleAttr: 'Export to Excel',
		            exportOptions: {
		                columns: ':visible',
            			// footer: true
            			format: {
		                    footer: function (data, columnIdx) {
		                        return columnIdx === 4 ? $('#total_amount').html() : data;
		                    }
		                }
		            }
		        },
		        {
		            extend: 'csvHtml5',
		            text: '<i class="fa fa-file-text-o"></i> CSV',
		            className: 'btn btn-info btn-sm',
		            titleAttr: 'Export to CSV',
		            exportOptions: {
		                columns: ':visible',
            			// footer: true
            			format: {
		                    footer: function (data, columnIdx) {
		                        return columnIdx === 4 ? $('#total_amount').html() : data;
		                    }
		                }
		            }
		        },
		        {
		            extend: 'pdfHtml5',
		            text: '<i class="fa fa-file-pdf-o"></i> PDF',
		            className: 'btn btn-danger btn-sm',
		            titleAttr: 'Export to PDF',
		            orientation: 'landscape',
		            pageSize: 'A4',
		            exportOptions: {
		                columns: ':visible',
            			// footer: true
            			format: {
		                    footer: function (data, columnIdx) {
		                        return columnIdx === 4 ? $('#total_amount').html() : data;
		                    }
		                }

			            
		            }
		        },
		        {
		            extend: 'print',
		            text: '<i class="fa fa-print"></i> Print',
		            className: 'btn btn-primary btn-sm',
		            titleAttr: 'Print Table',
		            exportOptions: {
		                columns: ':visible',
            			// footer: true
            			format: {
		                    footer: function(data, columnIdx) {
		                        if (columnIdx === 4) {
		                            return $('#dailyCollectionReport tfoot th:eq(4)').text();
		                        }
		                        return data;
		                    }
		                }
		            }
		        }
		    ],
	        ajax: {
	         	url: "<?= base_url('admin/report/ajax_request_daily_collection_report') ?>",
	         	dataSrc: function(json) {
			        console.log(json); // 👈 check actual response

			        // save class_list in a global variable
            		/*class_list = json.class_list || [];

            		// ✅ Count total students and set to input
		            let totalStudents = 0;
		            if (json.student_list && Array.isArray(json.student_list)) {
		                totalStudents = json.student_list.length;
		            } else if (Array.isArray(json)) {
		                totalStudents = json.length;
		            }

		            // Set value inside input
		            $('#totalStudent').val(totalStudents);*/

			        console.log(json.collection_details);
			        return json.collection_details || json; // if "collection_details" key exists, return it, else raw
			    },
		        type: 'POST',
		        dataType: 'json',
		        data: function (d) {
		            d.get_filter_date = $('#get_filter_date').val(); // get date from dropdown or input
		            console.log(d.get_filter_date)
		        },
	        },
	        columns: [
				{ data: 'id', defaultContent: '' },
				{ 
		            data: 'form_no',
		            render: function (data, type, row, meta) {
		                return `
		                    <input type="text" name="form_no_${meta.row + 1}" value="${row.form_no}" style="display: none;">
		                    ${data}
		                `;
		            }
		        },
		        {
		            data: "payment_date",
		            render: function (data) {
		                if (!data) return "";
		                let d = new Date(data);
		                return d.toLocaleDateString() + " " + d.toLocaleTimeString();
		            }
		        },
				{ 
				    data: "payment_type",
				    render: function (data) {
				        if (!data) return "";
				        return data.charAt(0).toUpperCase() + data.slice(1);
				    }
				},
        		{ data: "payment_amount" },
        		{
				    data: null,
				    render: function (data, type, row) {
				        let first = row.added_by_first_name ?? "";
				        let last  = row.added_by_last_name ?? "";
				        return (first + " " + last).trim();
				    }
				},
				{ data: "payee_name" },
			],
	        columnDefs: [
	            { targets: 0, visible: false, searchable: false, orderable: true }
	        ],
	        order: [[0, 'desc']],
	        scrollX: true,
	        serverSide: false,  // 👈 this is key
		    processing: true,

		    footerCallback: function (row, data, start, end, display) {
			    let api = this.api();

			    // Convert to number
			    let intVal = function (i) {
			        return typeof i === "string"
			            ? parseFloat(i.replace(/[^0-9.-]+/g, "")) || 0
			            : typeof i === "number"
			            ? i
			            : 0;
			    };

			    // Total over all pages
			    let total = api
			        .column(4) // payment_amount column index
			        .data()
			        .reduce((a, b) => intVal(a) + intVal(b), 0);

			    // Total over THIS page only
			    let pageTotal = api
			        .column(4, { page: "current" })
			        .data()
			        .reduce((a, b) => intVal(a) + intVal(b), 0);

			    // Update footer
			    $(api.column(4).footer()).html(pageTotal.toFixed(2));
			},

	    });

	    $('#dailyCollectionReportSearch').on('click', function(e) {
	    	table.ajax.reload();
	    });

	});

	function initDatePickers() {
	    $(".datepicker-basic").datepicker({
	        dateFormat: "yy-mm-dd", // yyyy-mm-dd
	        changeMonth: true,
	        changeYear: true,
	        yearRange: "1990:2050"
	    });
	}

	$(document).ready(function(){
		// Datepicker
    	initDatePickers()

    })
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
				<!-- <div class="col-lg-3">
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
                </div> -->
                <div class="col-lg-3">
                	<div class="mb-3">
						<input name="get_filter_date" id="get_filter_date" type="text" class="form-control datepicker-basic datepicker-input" value="" autocomplete="off">
					</div>
				</div>
                <div class="col-lg-3">
                    <div class="mb-3">
                    	<button type="button" id="dailyCollectionReportSearch" class="btn btn-primary ms-3">Go <i class="ph-paper-plane-tilt ms-2"></i></button>
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
			<table id="dailyCollectionReport" class="display responsive">
		        <thead>
		            <tr>
						<th>ID</th>
			            <th>Form No</th>
			            <th>Payment Date & Time</th>
			            <th>Payment Type</th>
			            <th>Payment Amount</th>
			            <th>Added By</th>
			            <th>Payee Name</th>
		            </tr>
		        </thead>

		        <tfoot>
			        <tr>
			            <th colspan="4" style="text-align:right">TOTAL :</th>
			            <th id="total_amount">0</th>
			            <th colspan="2"></th>
			        </tr>
			    </tfoot>
		    </table>
		</div>
	</div>
	<!-- /page length options -->
</div>
<!-- /content area -->
