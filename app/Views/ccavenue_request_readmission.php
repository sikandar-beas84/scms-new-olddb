
			<div class="main-content-inner">
				<div class="breadcrumbs ace-save-state" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="<?php echo base_url();?>login">Home</a>
						</li>
						<li class="active">CCAvenue Payment Gateway</li>
					</ul><!-- /.breadcrumb -->
				</div>
				<div class="page-content">
					<div id="divLoading"></div>
					<style>
					#divLoading {
						display: block;
						position: fixed;
						z-index: 100;
						background-image: url(<?php echo base_url('assets/img/load.gif') ?>);
						background-color: #fff;
						opacity: 0.9;
						background-repeat: no-repeat;
						background-position: center;
						left: 0;
						bottom: 0;
						right: 0;
						top: 0;
					}
					</style>
					<div class="col-sm-12">
						<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
							<input type="hidden" name="encRequest" value="<?= $encrypted_data ?>" />
							<input type="hidden" name="access_code" value="<?= $access_code ?>" />
							<input type="hidden" name="session_year_id" value="<?= session()->get('session_year_id');  ?>" />
							<input type="hidden" name="student_code" value="<?= $student_code; ?>" />
						</form>
					</div>					
				</div><!-- /.page-content -->
			</div>
		</div><!-- /.main-content -->

	<script language='javascript'>document.redirect.submit();</script>
		