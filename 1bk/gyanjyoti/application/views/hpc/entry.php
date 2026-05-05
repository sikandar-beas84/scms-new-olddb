<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" />
<style>

.error {
  color: red;
}
</style>
<div class="main-content">
    <div class="main-content-inner">

        <div class="">

            <!-- Surojit Bera -->
            <div class="col-sm-12">
                <div class="alert alert-block alert-success" id="success" style="display:none;">
                    <i class="ace-icon fa fa-check green"></i>
                    <span></span>
                </div>
                <div class="alert alert-block alert-danger" id="danger" style="display:none;">
                    <i class="ace-icon fa fa-remove red"></i>
                    <span></span>
                </div>
                <form class="form-horizontal" role="form" action="javascript:;" id="getStudent">
	                <div class="filter row mb-2 pb-4">

	                        <div class="col-12  col-md-4 col-sm-4 col-lg-4">
	                            <label for="classFilter" class="text-light">Class</label>
	                            <select class="form-control bg-light" name="class" id="class" required
                                <?php if(isset($class_id) && $class_id != ''){ echo 'disabled'; }?>>
                                <option value="">-- Select --</option>
                                <!-- <option value="">Select Class</option> -->
                                <?php foreach($class as $key=>$v): ?>
	                                <option value="<?=$key;?>"><?=$v;?></option>
	                                <?php endforeach; ?>
	                            </select>
	                            <?php if(isset($class_id) && $class_id != ''){ echo '<input type="hidden" name="class" value="'.$class_id.'"/>'; }?>
                                
	                        </div>
	                        <div class="col-8  col-md-4 col-sm-4 col-lg-4">
                                <label for="classFilter" class="text-light">Student Code</label>
                                <input type="text" class="form-control student-mask-id" name="student_id" id="student_id"
	                                required
	                                value="<?= ($this->session->userdata('student_logged_in') == true ? $this->session->userdata('code'):'') ?>"
	                                <?php if(isset($class_id) && $class_id != ''){ echo 'disabled'; }?>>
	                            <?php if($this->session->userdata('student_logged_in') == true){ echo '<input type="hidden" name="student_id" value="'. $this->session->userdata('code') .'"/>'; }?>

	                        </div>
	                        <div class="col-4 col-md-2 col-sm-2 col-lg-2">
	                            <button type="submit" class="btn btn-success mt-5 p-2 filterButton"
	                                >Go</button>
	                        </div>
                            <div class="filter-info mt-15" id="student_detail">

	            </div>
                
                        </div>
                    </form>
                    <div class="Hpc-body"><div>        
                
            </div>

            <div class="clearfix"></div>
            <div class="filter-info mt-15" id="issue_detail" style="display:none;">
                <div id="field_wrapper">

                </div>
            </div>


       

        </div>
    </div>
</div><!-- /.main-content -->





<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
</div><!-- /.main-container -->


<script src="<?php echo base_url();?>assets/admin/js/jquery.validate.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!-- Include jQuery UI (Compatible with jQuery 3.6.0) -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.5.0/jQuery.print.min.js"></script>


<script>
function getStudent() {
    $.ajax({
        method: "POST",
        url: '<?php echo base_url('Hpc/entry/getHpc') ?>',
        data: $("#getStudent").serialize(),
    }).done(function(resp) {
        var resp = $.parseJSON(resp);
        console.log(resp.data);
        $(".Hpc-body").html(resp.data);
       
    });
}

</script>


<script type="text/javascript">
jQuery(function($) {
    $("#getStudent").validate({
        submitHandler: function(form) {
            // $("#divLoading").show();
            getStudent();
        }
    });
});
</script>
<!-- Include jQuery -->


