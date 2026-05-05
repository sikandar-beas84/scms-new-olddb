<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="<?= base_url('public/admin/assets/js/vendor/forms/validation/validate.min.js') ?>"></script>

<script type="text/javascript">
	function initDatePickers() {
	    $(".datepicker-basic").datepicker({
	        dateFormat: "yy-mm-dd", // yyyy-mm-dd
	        changeMonth: true,
	        changeYear: true,
	        yearRange: "-50:+0"
	    });
	}

	function calculateAge(dob, current) {

	    if (!dob || !current) {
	        return {
	            error: true,
	            message: "Please select both dates."
	        };
	    }

	    let start = new Date(dob);
	    let end = new Date(current);

	    // Year diff
	    let years = end.getFullYear() - start.getFullYear();

	    // Month diff
	    let months = end.getMonth() - start.getMonth();

	    // Day diff
	    let days = end.getDate() - start.getDate();

	    // Adjust days
	    if (days < 0) {
	        months--;
	        let prevMonthDays = new Date(end.getFullYear(), end.getMonth(), 0).getDate();
	        days += prevMonthDays;
	    }

	    // Adjust months
	    if (months < 0) {
	        years--;
	        months += 12;
	    }

	    // Total Days
	    let totalDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24));

	    return {
	        years: years,
	        months: months,
	        days: days,
	        totalDays: totalDays,
	        text: `${years} Years, ${months} Months, ${days} Days`,
	        totalText: `${totalDays} Days`
	    };
	}

	$(document).ready(function(){
		// Datepicker
    	initDatePickers()

	    // Trigger validation + AJAX on button click
	    $("#your_dob").on("change", function () {

		    let dob = $(this).val();

		    if (dob === "") return;

		    $(".showYourAge").html('');
            $(".eligibleClass").html('');

		    $.ajax({
		        url: "<?= base_url('admin/age-calculator/calculate-age-class') ?>",
		        type: "POST",
		        data: { dob: dob },
		        dataType: "json",
		        success: function (response) {
		            $(".showYourAge").html(response.age_full_details.text);
		            $(".eligibleClass").html(response.getClass);
		        },
		        error: function () {
		            Swal.fire({
					    icon: "error",
					    title: "Error",
					    text: "Could not calculate age."
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
	<!-- Custom styles -->
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0"><?= $title ?></h5>
				</div>

				<form method="post" class="needs-validation" action="#" novalidate id="sessionForm" data-id="">
					<div class="card-body">
						<div id="showMsg"></div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Date of Birth <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input name="your_dob" id="your_dob" type="text" class="form-control datepicker-basic datepicker-input" value="" required autocomplete="off">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Your Current Age: <strong><span class="text-danger showYourAge"></span></strong></label>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Eligible class for admission: <strong><span class="text-danger eligibleClass"></span></strong></label>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
	<!-- /custom styles -->
</div>
<!-- /content area -->

