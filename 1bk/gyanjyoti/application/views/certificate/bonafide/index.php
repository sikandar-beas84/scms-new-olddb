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
                    <div class="certificate-body"><div>
                <!-- <form class="form-horizontal" role="form" action="javascript:;" id="getStudent">
                    <div class="filter row mb-2 pb-4">
                        <div class="col-8  col-md-4 col-sm-4 col-lg-4">
                            <label for="classFilter" class="text-light">Student Code</label>
                            <input type="text" class="form-control student-mask-id" name="student_id" id="student_id"
                                required
                                value="<?= ($this->session->userdata('student_logged_in') == true ? $this->session->userdata('code'):'') ?>"
                                <?php if(isset($class_id) && $class_id != ''){ echo 'disabled'; }?>>
                            <?php if($this->session->userdata('student_logged_in') == true){ echo '<input type="hidden" name="student_id" value="'. $this->session->userdata('code') .'"/>'; }?>

                        </div>
                        <div class="col-12  col-md-4 col-sm-4 col-lg-4">
                            <label for="classFilter" class="text-light">Admission in Class</label>
                            <select class="form-control bg-light" name="class" id="class" required
                                <?php if(isset($class_id) && $class_id != ''){ echo 'disabled'; }?>>
                                <option value="">-- Select --</option>
                                <?php foreach($class as $key=>$v): ?>
                                <option value="<?=$key;?>"><?=$v;?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <div class="col-12  col-md-4 col-sm-4 col-lg-4">
                            <label for="classFilter" class="text-light">Recent Class</label>
                            <select class="form-control bg-light" name="rec_class_id" id="rec_class_id" required
                                <?php if(isset($class_id) && $class_id != ''){ echo 'disabled'; }?>>
                                <option value="">-- Select --</option>
                                <?php foreach($class as $key=>$v): ?>
                                <option value="<?=$key;?>"><?=$v;?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <div class="col-8  col-md-4 col-sm-4 col-lg-4">
                            <label for="classFilter" class="text-light">First Name</label>
                            <input type="text" class="form-control student-mask-id" name="first_name" id="first_name"
                                required value="">
                        </div>
                        <div class="col-8  col-md-4 col-sm-4 col-lg-4">
                            <label for="classFilter" class="text-light">Last Name</label>
                            <input type="text" class="form-control student-mask-id" name="last_name" id="last_name"
                                required value="">
                        </div>
                        <div class="col-8  col-md-4 col-sm-4 col-lg-4">
                            <label for="classFilter" class="text-light">Residential Address</label>
                            <input type="text" class="form-control student-mask-id" name="residential_address" id="residential_address"
                                required value="">
                        </div>
                        <div class="col-8  col-md-4 col-sm-4 col-lg-4">
                            <label for="classFilter" class="text-light">Admission Date</label>
                            <input type="date" class="form-control student-mask-id bg-light" name="admission_date" id="admission_date"
                                required value="">
                        </div>
                        <div class="col-8  col-md-4 col-sm-4 col-lg-4">
                            <label for="classFilter" class="text-light">Date of Birth</label>
                            <input type="date" class="form-control student-mask-id bg-light" name="d_o_b" id="d_o_b"
                                required value="">
                        </div>
                        <div class="col-8  col-md-4 col-sm-4 col-lg-4">
                            <label for="classFilter" class="text-light">Admission Number</label>
                            <input type="date" class="form-control student-mask-id bg-light" name="admission_number" id="admission_number"
                                required value="">
                        </div>
                        <div class="col-8  col-md-4 col-sm-4 col-lg-4">
                            <label for="classFilter" class="text-light">Gender</label>
                            <select class="form-control bg-light" name="gender" required>
									<option value="">--Select--</option>
									<option value="Female"> Female</option>
									<option value="Male" >Male</option>
								</select>
                        </div>
                        <div class="col-4 col-md-2 col-sm-2 col-lg-2">
                            <button type="submit" class="btn btn-success mt-5 p-2 filterButton">Go</button>
                        </div>
                        
                    </div>







                    <div class="certificate-body">

















































                    </div>
                </form> -->

            
                
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
        url: '<?php echo base_url('certificate/bonafide/getCertificate') ?>',
        data: $("#getStudent").serialize(),
    }).done(function(resp) {
        var resp = $.parseJSON(resp);
        console.log(resp.data);
        $(".certificate-body").html(resp.data);
        // if (resp.status == 'Success') {
        //     // $("#divLoading").hide();

        //     $(".certificate").html(resp.data);
          
        //     // dataTable.draw();
        // } else {
        //     // $("#divLoading").hide();
        //     // $("#student_detail").html(resp.data);
        //     // $("#student_id_hidden").val("");
        //     // getIssueBook();
        //     // console.log('f');
        //     // $('html, body').animate({
        //     //     scrollTop: $("#getStudent").offset().top - 300
        //     // });
        // }
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


