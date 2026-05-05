<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

<!-- First load jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/vu37vueaus3bjadoz2kzedxl24o82g1boyl9at627ordui7j/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
	tinymce.init({
	    selector: 'textarea',
	    plugins: [
			// Core editing features
			'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
			// Your account includes a free trial of TinyMCE premium features
			// Try the most popular premium features until Dec 6, 2025:
			'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'ai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
	    ],
	    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
	    tinycomments_mode: 'embedded',
	    tinycomments_author: 'Author name',
	    mergetags_list: [
			{ value: 'First.Name', title: 'First Name' },
			{ value: 'Email', title: 'Email' },
	    ],
	    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
	    uploadcare_public_key: 'e6e7d26a8c5b271f2eeb',
	});
</script>

<style>
	.d-none {
		display: none;
	}
	.ui-datepicker {
	    z-index: 999999 !important;
	}

	/* Additional styles for CKEditor fallback */
	.ckeditors {
	    min-height: 200px;
	    resize: vertical;
	}

	.ck-editor__editable {
	    min-height: 200px;
	}

	/* Loading state */
	.ckeditors.loading {
	    background: #f8f9fa url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" stroke="%23007bff" stroke-width="8" fill="none" stroke-dasharray="200 100"><animateTransform attributeName="transform" type="rotate" from="0 50 50" to="360 50 50" dur="1s" repeatCount="indefinite"/></circle></svg>') no-repeat center;
	    background-size: 50px 50px;
	}
</style>

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
			<a href="<?= base_url('admin/configuration/') ?>" class="d-flex align-items-center text-body py-2">
				<i class="ph ph-list me-2"></i>
				Lists
			</a>
		</div>

		<div class="card-body">
			<form method="post" action="<?= base_url('admin/configuration/update-configuration') ?>">
				<div class="input-group d-none">
					<button type="button" class="btn btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
						<i class="ph-minus ph-sm"></i>
					</button>
					<button type="button" class="btn btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
						<i class="ph-plus ph-sm"></i>
					</button>
					<input class="form-control form-control-number" min="1" and max="31" type="number" name="number" value="15" readonly>
				</div>

				<?php if( isset($all_configuration) && !empty($all_configuration) ) :
					foreach($all_configuration as $row): ?>	
						
						<div class="row mb-3 <?= (($row['configuration_key'] == 'super_therapist_id')? 'd-none':'') ?>">
							<label class="col-lg-3 col-form-label"><?= ucwords($row['configuration_level']) ?>: <i class="bi bi-info-square" data-bs-popup="tooltip" aria-describedby="tooltip569692" data-bs-original-title="<?= $row['configuration_key'] ?>"></i></label>
							<div class="col-lg-9">
								<?php if($row['configuration_key'] == 'site_notice') { ?>
									<textarea name="<?= $row['configuration_key'] ?>" class="form-control tinymce_editor" id="ckeditor_classic_empty" placeholder=""><?= $row['configuration_value'] ?></textarea>
								<?php } elseif($row['configuration_key'] == 'age_claculation_date') { ?>
									<input type="text" class="form-control datepicker-basic datepicker-input" name="<?= $row['configuration_key'] ?>" id="<?= $row['configuration_key'] ?>" value="<?= $row['configuration_value']; ?>" />
								<?php } else { ?>
									<input type="text" class="form-control" name="<?= $row['configuration_key'] ?>" id="<?= $row['configuration_key'] ?>" value="<?= $row['configuration_value']; ?>" />
								<?php } ?>
							</div>
						</div>
							
					<?php endforeach; 
				endif; ?>

				<p class="text-danger">* Marks are required field</p>					
				<input type="submit" name="submit" class="btn btn-success mr-2" value="Update">    
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
    function initDatePickers() {
        $(".datepicker-basic").datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "1990:2050"
        });
    }

    $(document).ready(function() {
        initDatePickers();
    });

	function del_config($key) {
		var r = confirm( "Are you sure to delete Configuration?" );
		/*if ( r == true ) {
			var config_del_url = "<?php echo base_url().'configuration/delete_configuration/'?>"+$key;
			window.location.href = config_del_url;	
		} else {				
			e.preventDefault();
		}*/
	}
</script>