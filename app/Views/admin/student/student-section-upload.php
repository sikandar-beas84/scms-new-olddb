<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

<script>
	$(document).ready(function() {
	    // Form validation
	    (function() {
	        'use strict'
	        
	        var forms = document.querySelectorAll('.needs-validation')
	        
	        Array.prototype.slice.call(forms).forEach(function(form) {
	            form.addEventListener('submit', function(event) {
	                if (!form.checkValidity()) {
	                    event.preventDefault()
	                    event.stopPropagation()
	                }
	                
	                form.classList.add('was-validated')
	            }, false)
	        })
	    })()

	    // File input change event for preview/validation
	    $('#file_path').on('change', function() {
	        var fileInput = $(this)[0];
	        var file = fileInput.files[0];
	        
	        if (file) {
	            // Validate file extension
	            var fileName = file.name;
	            var fileExt = fileName.split('.').pop().toLowerCase();
	            
	            if (fileExt !== 'csv') {
	                showMessage('Please upload a CSV file only.', 'danger');
	                $(this).val('');
	                return false;
	            }
	            
	            // Validate file size (max 5MB)
	            var maxSize = 5 * 1024 * 1024; // 5MB
	            if (file.size > maxSize) {
	                showMessage('File size should not exceed 5MB.', 'danger');
	                $(this).val('');
	                return false;
	            }
	        }
	    });

	    // Submit button click event
	    $('#studentSectionCSVSubmit').on('click', function(e) {
	        e.preventDefault();
	        
	        var form = $('#studentSectionCSVForm')[0];
	        var formData = new FormData();
	        console.log(form)
	        console.log(formData)
	        // Validate form
	        if (!form.checkValidity()) {
	            form.classList.add('was-validated');
	            return false;
	        }
	        
	        // Get the file
	        var fileInput = $('#file_path')[0];
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
	        
	        // AJAX call
	        $.ajax({
	            url: '<?= base_url("admin/student/upload-student-section") ?>', // Update with your actual endpoint
	            type: 'POST',
	            data: formData,
	            processData: false,
	            contentType: false,
	            dataType: 'json',
				success: function(response) {
					let html = '';

				    if (response.status === 'success') {
				        var message = response.message;
				        
				        // Create detailed success message
				        /*var successMsg = `
				            <div class="alert alert-success alert-dismissible fade show">
				                <i class="ph ph-check-circle me-2"></i>
				                <strong>Upload Successful!</strong><br>
				                ${message}
				                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				            </div>
				        `;*/

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
				        
				        $('#showMsg').html(html);
				        
				        // Reset form
				        form.reset();
				        form.classList.remove('was-validated');
				        
				        // Show summary
				        if (response.data) {
				            console.log(`Processed: ${response.data.processed}, Failed: ${response.data.failed}`);
				        }
				        
				    } else {
				        var errorMsg = `
				            <div class="alert alert-danger alert-dismissible fade show">
				                <i class="ph ph-x-circle me-2"></i>
				                <strong>Upload Failed!</strong><br>
				                ${response.message}
				                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				            </div>
				        `;
				        
				        $('#showMsg').html(errorMsg);
				    }
				},
	            /*success: function(response) {
	                if (response.status === 'success') {
	                    showMessage(response.message, 'success');
	                    
	                    // Reset form
	                    form.reset();
	                    form.classList.remove('was-validated');
	                    
	                    // Optional: Reload or update data
	                    if (response.redirect) {
	                        setTimeout(function() {
	                            window.location.href = response.redirect;
	                        }, 1500);
	                    }
	                } else {
	                    showMessage(response.message || 'Upload failed. Please try again.', 'danger');
	                }
	            },*/
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

	    // Function to show messages
	    function showMessage(message, type = 'info') {
	        var alertClass = 'alert-' + type;
	        var iconClass = type === 'success' ? 'ph-check-circle' : 
	                       type === 'danger' ? 'ph-x-circle' : 
	                       type === 'warning' ? 'ph-warning-circle' : 'ph-info';
	        
	        var alertHtml = `
	            <div class="alert ${alertClass} alert-dismissible fade show">
	                <i class="ph ${iconClass} me-2"></i>
	                ${message}
	                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
	            </div>
	        `;
	        
	        $('#showMsg').html(alertHtml);
	        
	        // Auto-dismiss after 5 seconds
	        setTimeout(function() {
	            $('#showMsg .alert').alert('close');
	        }, 5000);
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


<!-- Content area -->
<div class="content">
	<!-- Custom styles -->
	<div class="row">
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0"><?= $title ?></h5>
				</div>

				<form method="post" class="needs-validation" action="#" novalidate id="studentSectionCSVForm" data-id="">
					<div class="card-body">
						<div id="showMsg"></div>
						<h2>Sample Template Layout <a target="_blank" href="<?= base_url('uploads/studentsectioncsv.csv') ?>" download>(Download)</a></h2>

						<div class="row mb-3">
							<label class="col-form-label col-lg-4">Student Section CSV <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input type="file" id="file_path" name="studentfile" class="form-control" accept=".csv" required="">
							</div>
						</div>
					</div>

					<div class="card-footer text-end">
						<button id="studentSectionCSVSubmit" type="button" class="btn btn-primary">Submit <i class="ph-paper-plane-tilt ms-2"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /custom styles -->
</div>
<!-- /content area -->

