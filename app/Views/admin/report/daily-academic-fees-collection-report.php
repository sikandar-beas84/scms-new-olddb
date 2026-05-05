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

<!-- Date range Picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
	$(document).ready(function() {
	    var table = $('#dailyCollectionReport').DataTable({
	    	deferLoading: 0,
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
		                columns: ':visible'
		            },
		            footer: true
		        },
		        {
		            extend: 'csvHtml5',
		            text: '<i class="fa fa-file-text-o"></i> CSV',
		            className: 'btn btn-info btn-sm',
		            titleAttr: 'Export to CSV',
		            exportOptions: {
		                columns: ':visible'
		            },
		            footer: true
		        },
				{
				    extend: 'pdfHtml5',
				    text: '<i class="fa fa-file-pdf-o"></i> PDF',
				    className: 'btn btn-danger btn-sm',
				    orientation: 'landscape',
				    pageSize: 'A4',
				    footer: true,
				    exportOptions: {
				        columns: function (idx, data, node) {
					        return true; // 👈 export every column (visible + hidden)
					    },
				        modifier: {
				            page: 'all'    // 👈 ALL rows
				        }
				    },
				    customize: function (doc) {
				    	doc.defaultStyle.fontSize = 8;
				        doc.styles.tableHeader.fontSize = 9;

				        let footerRow = [];
				        $('#dailyCollectionReport tfoot th').each(function () {
				            footerRow.push({
				                text: $(this).text(),
				                bold: true
				            });
				        });

				        doc.content.push({
				            table: {
				                headerRows: 0,
				                widths: Array(footerRow.length).fill('*'),
				                body: [footerRow]
				            },
				            margin: [0, 10, 0, 0]
				        });
				    }
				},
				{
				    extend: 'print',
				    text: '<i class="fa fa-print"></i> Print',
				    className: 'btn btn-primary btn-sm',
				    footer: true,

				    action: function (e, dt, button, config) {

				        let oldPageLength = dt.page.len();

				        // Load ALL rows
				        dt.page.len(-1).draw();

				        // Wait for table redraw, then print
				        setTimeout(function () {

				            $.fn.dataTable.ext.buttons.print.action.call(
				                this, e, dt, button, config
				            );

				            // Restore old page length
				            dt.page.len(oldPageLength).draw();

				        }, 500);
				    },

				    exportOptions: {
				        columns: function () {
				            return true;   // ALL columns (even hidden)
				        }
				    }
				}

		        /*{
		            extend: 'pdfHtml5',
		            text: '<i class="fa fa-file-pdf-o"></i> PDF',
		            className: 'btn btn-danger btn-sm',
		            titleAttr: 'Export to PDF',
		            orientation: 'landscape',
		            pageSize: 'A4',
		            exportOptions: {
		                columns: ':visible'
		            }
		        },
		        {
		            extend: 'print',
		            text: '<i class="fa fa-print"></i> Print',
		            className: 'btn btn-primary btn-sm',
		            titleAttr: 'Print Table',
		            exportOptions: {
		                columns: ':visible'
		            },
		            footer: true
		        }*/
		    ],
	        ajax: {
	         	url: "<?= base_url('admin/report/ajax-request-daily-academic-fees-collection-report') ?>",
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

			        // console.log(json.collection_details);
			        return json.collection_details || json; // if "collection_details" key exists, return it, else raw
			    },
		        type: 'POST',
		        dataType: 'json',
		        data: function (d) {
		            // d.get_filter_date = $('#get_filter_date').val(); // get date from dropdown or input
		            let dateValue = $('#get_filter_date').val();
		            // console.log(dateValue)
				    if (dateValue && dateValue.includes(' to ')) {
				        let dr = dateValue.split(' to ');
				        d.start_date = dr[0];
				        d.end_date = dr[1];
				    } else {
				        d.start_date = "";
				        d.end_date = "";
				    }
		            // console.log(dateValue)

		            d.class_id = $('#class_id').val();
					d.user_id = $('#user_id').val();
					d.payment_mode = $('#payment_mode').val();
					d.payment_month = $('#payment_month').val();
					d.student_code = $('#student_code').val();
					d.bus_user_id = $('#bus_user_id').val();
					d.date_filter_used = $('#date_filter_used').val();
		        },
	        },
	        columns: [
				{ data: 'id', defaultContent: '' },
				{ data: 'student_code', defaultContent: '' },
				{ data: 'first_name', defaultContent: '' },
				{ data: 'class_name', defaultContent: '' },
				{ data: 'admission_fee', defaultContent: '' },

				// { data: 'session_charges', defaultContent: '' },
				{
				    data: null,
				    render: function (data, type, row) {

				        let development_fee               = parseFloat(row.development_fee) || 0;
				        let exam_fee                      = parseFloat(row.exam_fee) || 0;
				        let festival_celebration_fee      = parseFloat(row.festival_celebration_fee) || 0;
				        let games_sports_fee              = parseFloat(row.games_sports_fee) || 0;
				        let audio_visual_lab_fee          = parseFloat(row.audio_visual_lab_fee) || 0;
				        let library_fee                   = parseFloat(row.library_fee) || 0;
				        let electricity_maintenance_fee   = parseFloat(row.electricity_maintenance_fee) || 0;

				        let session_charges =
				            development_fee +
				            exam_fee +
				            festival_celebration_fee +
				            games_sports_fee +
				            audio_visual_lab_fee +
				            library_fee +
				            electricity_maintenance_fee;

				        // return session_charges.toFixed(2);
				        return Math.round(session_charges).toLocaleString('en-IN');
				    }
				},
				{ data: 'security_deposite', defaultContent: '' },
				{ data: 'tuition_fee', defaultContent: '' },
				{ data: 'fine', defaultContent: '' },
				// { data: 'academic_payment_amt', defaultContent: '' },
				{ 
				    data: null, 
				    // render: function(data, type, row, meta) {
				    //     let paymentAmount = parseFloat(data) || 0;
				        
				    //     // Check if month_id is "4"
				    //     if (row.month_id === "4") {
				    //         // Subtract tblc_price if it exists
				    //         if (row.tblc_price && !isNaN(parseFloat(row.tblc_price))) {
				    //             paymentAmount -= parseFloat(row.tblc_price);
				    //         }
				            
				    //         // Subtract stationary_price if it exists
				    //         if (row.stationary_price && !isNaN(parseFloat(row.stationary_price))) {
				    //             paymentAmount -= parseFloat(row.stationary_price);
				    //         }
				    //     }
				    //     // Subtract bus service if it exists
					// 	if (row.bus_services && !isNaN(parseFloat(row.bus_services))) {
					// 		paymentAmount -= parseFloat(row.bus_services);
					// 	}
				    //     // Subtract bus service fine if it exists
					// 	if (row.bus_fee_fine && !isNaN(parseFloat(row.bus_fee_fine))) {
					// 		paymentAmount -= parseFloat(row.bus_fee_fine);
					// 	}
				    //     // Return numeric value for all types (display, sort, filter)
				    //     return paymentAmount;
				    // }
					render: function (data, type, row) {

						let development_fee               = parseFloat(row.development_fee) || 0;
						let exam_fee                      = parseFloat(row.exam_fee) || 0;
						let festival_celebration_fee      = parseFloat(row.festival_celebration_fee) || 0;
						let games_sports_fee              = parseFloat(row.games_sports_fee) || 0;
						let audio_visual_lab_fee          = parseFloat(row.audio_visual_lab_fee) || 0;
						let library_fee                   = parseFloat(row.library_fee) || 0;
						let electricity_maintenance_fee   = parseFloat(row.electricity_maintenance_fee) || 0;

						let session_charges =
							development_fee +
							exam_fee +
							festival_celebration_fee +
							games_sports_fee +
							audio_visual_lab_fee +
							library_fee +
							electricity_maintenance_fee;

						// return session_charges.toFixed(2);
						let paymentAmount = parseFloat(data) || 0;
						let admission_fee               = parseFloat(row.admission_fee) || 0;
						let security_deposite                      = parseFloat(row.security_deposite) || 0;
						let tuition_fee      = parseFloat(row.tuition_fee) || 0;
						let fine              = parseFloat(row.fine) || 0;
						let final_accedmic =  session_charges + admission_fee + security_deposite + tuition_fee+ fine;
						return Math.round(final_accedmic).toLocaleString('en-IN');
					}
				},
				{ data: 'ad_payment_mode', defaultContent: '' },
				{ data: 'added_by', defaultContent: '' },
				{ data: 'month_name', defaultContent: '' },
				// { data: 'bus_added_by', defaultContent: '' },
				// { data: 'bus_payment_amt', defaultContent: '' },
				{
				    data: 'created_date',
				    render: function (data) {
				        if (!data) return '';
				        // const d = new Date(data);
				        // return d.toISOString().slice(0, 10);

				        return data.split(' ')[0];
				    }
				},
				// { data: 'payment_amount', defaultContent: '' },
				{ 
				    data: 'tblc_price', 
				    defaultContent: '',
				    render: function(data, type, row, meta) {
				        let tblcAmount = parseFloat(data) || 0;
				        
				        // Check if month_id is "4"
				        if (row.month_id === "4") {
				            return tblcAmount;
				        }
				        
				        // Return numeric value for all types (display, sort, filter)
				        return 0;
				    }
				},
				{ 
				    data: 'stationary_price', 
				    defaultContent: '',
				    render: function(data, type, row, meta) {
				        let stationaryAmount = parseFloat(data) || 0;
				        
				        // Check if month_id is "4"
				        if (row.month_id === "4") {
				            return stationaryAmount;
				        }
				        
				        // Return numeric value for all types (display, sort, filter)
				        return 0;
				    }
				},
				{ data: 'payment_amount', 
					defaultContent: '',
				    render: function(data, type, row, meta) {
				        let development_fee               = parseFloat(row.development_fee) || 0;
						let exam_fee                      = parseFloat(row.exam_fee) || 0;
						let festival_celebration_fee      = parseFloat(row.festival_celebration_fee) || 0;
						let games_sports_fee              = parseFloat(row.games_sports_fee) || 0;
						let audio_visual_lab_fee          = parseFloat(row.audio_visual_lab_fee) || 0;
						let library_fee                   = parseFloat(row.library_fee) || 0;
						let electricity_maintenance_fee   = parseFloat(row.electricity_maintenance_fee) || 0;

						let session_charges =
							development_fee +
							exam_fee +
							festival_celebration_fee +
							games_sports_fee +
							audio_visual_lab_fee +
							library_fee +
							electricity_maintenance_fee;

						// return session_charges.toFixed(2);
						let paymentAmount = parseFloat(data) || 0;
						let admission_fee               = parseFloat(row.admission_fee) || 0;
						let security_deposite                      = parseFloat(row.security_deposite) || 0;
						let tuition_fee      = parseFloat(row.tuition_fee) || 0;
						let fine              = parseFloat(row.fine) || 0;

						let tblc_price              = parseFloat(row.tblc_price) || 0;
						let stationary_price              = parseFloat(row.stationary_price) || 0;
						if (row.month_id === "4") {
							 tblc_price = tblc_price;
							 stationary_price = stationary_price;
						} else {
							 tblc_price = 0;
							 stationary_price = 0;
						}
						let final_accedmic =  session_charges + admission_fee + security_deposite + tuition_fee+ fine + tblc_price + stationary_price;
						return Math.round(final_accedmic).toLocaleString('en-IN');
				    } 
				},
				/*{ 
				    data: 'payment_amount', 
				    defaultContent: '',
				    render: function(data, type, row, meta) {
				        let paymentAmount = parseFloat(data) || 0;
				        
				        // Check if month_id is "4"
				        if (row.month_id === "4") {
				            // Subtract tblc_price if it exists
				            if (row.tblc_price && !isNaN(parseFloat(row.tblc_price))) {
				                paymentAmount -= parseFloat(row.tblc_price);
				            }
				            
				            // Subtract stationary_price if it exists
				            if (row.stationary_price && !isNaN(parseFloat(row.stationary_price))) {
				                paymentAmount -= parseFloat(row.stationary_price);
				            }
				        }
				        
				        // Return numeric value for all types (display, sort, filter)
				        return paymentAmount;
				    }
				},*/
				
				// { data: 'remarks', defaultContent: '' },
				{ 
					data: null, 
					render: function(data, type, row) {
						if (row.ad_payment_mode == 'online' || row.ad_payment_mode == 'online.' || row.ad_payment_mode == 'CCAvenue') {
							return row.transaction_no;
						} else {
							return '#'+row.id || 0;
						}
					} 
				},
		        
			],
	        columnDefs: [
	            { targets: 0, visible: false, searchable: false, orderable: true }
	        ],
	        order: [[0, 'desc']],
	        scrollX: true,
	        serverSide: false,  // 👈 this is key
		    processing: true,

		    /*footerCallback: function (row, data, start, end, display) {
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
			},*/

			/*footerCallback: function (row, data, start, end, display) {
			    let api = this.api();

			    // Convert to number safely
			    let intVal = function (i) {
			        return typeof i === "string"
			            ? parseFloat(i.replace(/[^0-9.-]+/g, "")) || 0
			            : typeof i === "number"
			            ? i
			            : 0;
			    };

			    // 🔹 Total over ALL pages
			    let total = api
			        .column(14) // Total Amount column
			        .data()
			        .reduce((a, b) => intVal(a) + intVal(b), 0);

			    // 🔹 Total over THIS page only
			    let pageTotal = api
			        .column(14, { page: "current" })
			        .data()
			        .reduce((a, b) => intVal(a) + intVal(b), 0);

			    // 🔹 Update footer (show page total)
			    $(api.column(14).footer()).html(pageTotal.toFixed(2));
			}*/

			/*footerCallback: function (row, data, start, end, display) {
		        let api = this.api();

		        // helper to convert formatted ₹ values to number
		        let intVal = function (i) {
		            return typeof i === 'string'
		                ? i.replace(/[₹,]/g, '') * 1
		                : typeof i === 'number'
		                ? i
		                : 0;
		        };

		        // Total over all pages
		        let total = api
		            .column(12) // Total Amount column index
		            .data()
		            .reduce(function (a, b) {
		                return intVal(a) + intVal(b);
		            }, 0);

		        // Update footer
		        $(api.column(12).footer()).html(
		            '₹ ' + Math.round(total).toLocaleString('en-IN')
		        );
		    }*/

			/*footerCallback: function (row, data, start, end, display) {
			    let api = this.api();
			    let total = 0;

			    // Calculate total from all data
			    api.rows().data().each(function(rowData) {
			        let amount = 0;
			        
			        // Get payment_amount value
			        if (rowData.payment_amount !== undefined) {
			            amount = parseFloat(rowData.payment_amount) || 0;
			            
			            // Apply month_id = 4 subtraction
			            if (rowData.month_id === "4") {
			                amount = amount - (parseFloat(rowData.tblc_price) || 0) - (parseFloat(rowData.stationary_price) || 0);
			            }
			        }
			        
			        total += amount;
			    });

			    // Update the footer cell directly (find the correct column index)
			    let paymentColumnIndex = 15; // Adjust this index
			    
			    // Try to find the column index by header
			    api.columns().every(function(index) {
			        let headerText = $(this.header()).text().toLowerCase();
			        if (headerText.includes('payment') || headerText.includes('amount')) {
			            paymentColumnIndex = index;
			            return false; // Break loop
			        }
			    });
			    
			    $(api.column(paymentColumnIndex).footer()).html(
			        '₹ ' + Math.round(total).toLocaleString('en-IN')
			    );
			}*/

			footerCallback: function (row, data, start, end, display) {
			    let api = this.api();

			    let tblcTotal = 0;
			    let busFeeTotal = 0;
			    let stationaryTotal = 0;
			    let paymentTotal = 0;
			    let fullPaymentTotal = 0;
			    
			    api.rows({ search: 'applied' }).data().each(function (rowData) {
			    	console.log(rowData)
			        let tblc = 0;
			        let stationary = 0;
			        let payment = parseFloat(rowData.payment_amount) || 0;
			        let busFee = parseFloat(rowData.bus_payment_amt) || 0;

			        // fullPaymentTotal += payment;

			        // Month 4 logic (if month_id is column index  ? )
			        let monthId = rowData.month_id;
			        if (monthId === "4") {
			        	tblc = parseFloat(rowData.tblc_price) || 0;
			        	stationary = parseFloat(rowData.stationary_price) || 0;
			            payment = payment - tblc - stationary;
			        }

					let accedimic_payment = 0;
					let admission_fee = parseFloat(rowData.admission_fee) || 0;
					let security_deposite = parseFloat(rowData.security_deposite) || 0;
					let tuition_fee = parseFloat(rowData.tuition_fee) || 0;
					let fine = parseFloat(rowData.fine) || 0;

					let development_fee               = parseFloat(rowData.development_fee) || 0;
					let exam_fee                      = parseFloat(rowData.exam_fee) || 0;
					let festival_celebration_fee      = parseFloat(rowData.festival_celebration_fee) || 0;
					let games_sports_fee              = parseFloat(rowData.games_sports_fee) || 0;
					let audio_visual_lab_fee          = parseFloat(rowData.audio_visual_lab_fee) || 0;
					let library_fee                   = parseFloat(rowData.library_fee) || 0;
					let electricity_maintenance_fee   = parseFloat(rowData.electricity_maintenance_fee) || 0;

					let session_charges =
						development_fee +
						exam_fee +
						festival_celebration_fee +
						games_sports_fee +
						audio_visual_lab_fee +
						library_fee +
						electricity_maintenance_fee;
					accedimic_payment = admission_fee+security_deposite+tuition_fee+fine+session_charges;
					// console.log(accedimic_payment);
					// console.log(session_charges);

			        tblcTotal += tblc;
			        stationaryTotal += stationary;
			        paymentTotal += accedimic_payment;
			        busFeeTotal += busFee;
			    });

			    $(api.column(9).footer()).html(paymentTotal);
			    // $(api.column(14).footer()).html(busFeeTotal);
			    $(api.column(14).footer()).html(tblcTotal);
			    $(api.column(15).footer()).html(stationaryTotal);
			    $(api.column(16).footer()).html(paymentTotal + tblcTotal + stationaryTotal);
			}


	    });

		$('#dailyCollectionReportSearch').on('click', function (e) {
		    e.preventDefault();

		    let dateValue = $('#get_filter_date').val();
		    let paymentMode = $('#payment_mode').val();

		    // ❌ Date not selected or invalid range
		    if (!dateValue || !dateValue.includes(' to ')) {
		        Swal.fire({
		            icon: 'warning',
		            title: 'Date Required',
		            text: 'Please select a valid date range before searching.',
		            confirmButtonText: 'OK'
		        });
		        return false; // ⛔ stop ajax call
		    }

		    if ( !paymentMode ) {
		        Swal.fire({
		            icon: 'warning',
		            title: 'Payment Mode Required',
		            text: 'Please select a valid payment mode.',
		            confirmButtonText: 'OK'
		        });
		        return false; // ⛔ stop ajax call
		    }

		    // ✅ Date valid → reload table
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

<script>
	$(function () {
	    $('#get_filter_date').daterangepicker({
	        autoUpdateInput: false,
	        locale: {
	            cancelLabel: 'Clear'
	        }
	    });

	    $('#get_filter_date').on('apply.daterangepicker', function (ev, picker) {
	        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
	    });

	    $('#get_filter_date').on('cancel.daterangepicker', function (ev, picker) {
	        $(this).val('');
	    });
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
				<div class="col-lg-2">
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
						<!-- <input name="get_filter_date" id="get_filter_date" type="text" class="form-control datepicker-basic datepicker-input" value="" autocomplete="off"> -->
						<input type="text" name="get_filter_date" id="get_filter_date" class="form-control" placeholder="Select Date Range" readonly>
					</div>
				</div>
				<!-- <div class="col-lg-2">
					<div class="mb-3">
                        <select class="form-select" name="date_filter_used" id="date_filter_used">
							<option value="1">Date Filter For Academic Payment</option>
							<option value="0">Date Filter For Bus Payment</option>
						</select>
                    </div>
                </div> -->
				<!-- <div class="col-lg-2">
					<div class="mb-3">
                        <select class="form-select" name="user_id" id="user_id">
							<option value="">Select Payment Collected By</option>
							<?php if(!empty($user_lists)){
								foreach($user_lists as $user){ ?>
									<option value="<?php echo $user['id']; ?>"><?php echo $user['first_name'].' '.$user['last_name']; ?></option>
								<?php }
							} ?>
						</select>
                    </div>
                </div> -->
                <!-- <div class="col-lg-2">
					<div class="mb-3">
                        <select class="form-select" name="bus_user_id" id="bus_user_id">
							<option value="">Select Bus Payment Collected By</option>
							<?php if(!empty($user_lists)){
								foreach($user_lists as $user){ ?>
									<option value="<?php echo $user['id']; ?>"><?php echo $user['first_name'].' '.$user['last_name']; ?></option>
								<?php }
							} ?>
						</select>
                    </div>
                </div> -->
                <div class="col-lg-2">
					<div class="mb-3">
                        <select class="form-select" name="payment_mode" id="payment_mode" required>
							<option value="">Select Payment Mode</option>
							<option value="cash">Cash</option>
							<option value="cheque">Cheque / QR/UPI</option>
							<option value="pos"> POS / CARD</option>
							<option value="CCAvenue">Online</option>
						</select>
                    </div>
                </div>

                <div class="col-lg-2">
					<div class="mb-3">
                        <select class="form-select" name="payment_month" id="payment_month">
							<option value="">Select Paid Month</option>
							<?php for ($i = 1; $i <= 12; $i++) {
							    $monthName = date("F", mktime(0, 0, 0, $i, 1));
							    echo '<option value="'.$i.'">'.$monthName.'</option>';
							} ?>
						</select>
                    </div>
                </div>

				<div class="col-lg-2">
					<div class="mb-3">
                        <input class="form-control" type="text" name="student_code" id="student_code" placeholder="Student code: Format must be: YY-XXXX (Example: 22-0129)" pattern="[0-9]{2}-[0-9]{4}" />
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
			            <th>Student Code</th>
			            <th>Student Name</th>
			            <th>Class Name</th>
			            <th>Admission Fee</th>
			            <th>Session Fee</th>
			            <th>Security Fee</th>
			            <th>Tuition Fee</th>

			            <th>TF Fine</th>
			            <th>Academic Fee</th>
			            <th>Payment Mode</th>
			            <th>Collected By</th>
			            <th>Payment Month</th>

			            <!-- <th>Bus Collected By</th>
			            <th>Bus Paid Amount</th> -->

			            <th>Payment Date</th>
			            <th>TBLC Amount</th>
			            <th>Stationary Amount</th>

			            <th>Total Amount (Included TBLC, Stationary)</th>
			            
			            <!-- <th>Remarks</th> -->
			            <th>Transaction No</th>
		            </tr>
		        </thead>

		        <tfoot>
				    <tr>
				    	<th></th>
			            <th></th>
			            <th></th>
			            <th></th>
			            <th></th>
			            <th></th>
			            <th></th>
			            <th></th>
				        <th style="text-align:right">Grand Total :</th>
				        <th></th> <!-- Academic Fee -->
				        <th></th>
				        <th></th>
				        <th></th><!-- Collected By -->
				        <!-- <th></th>
				        <th></th> -->

				        <th></th>
				        <th></th> <!-- TBLC -->
				        <th></th> <!-- Stationary -->
				        <th></th> <!-- Payment -->
				        <!-- <th></th> Remarks -->
				        <th></th>
				    </tr>
				</tfoot>

		    </table>
		</div>
	</div>
	<!-- /page length options -->
</div>
<!-- /content area -->
