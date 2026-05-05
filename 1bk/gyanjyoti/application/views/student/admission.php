<style type="text/css">

    .modal-backdrop.show {
        display: none;
    }
    
</style>

<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

<div class="page-body">




    <!-- Container-fluid starts-->
    <div class="container-fluid crypto-dash">
        <div class="card">
            <div class="card-body">
                <header style="max-width: 100%;">
       
                    <img src="<?=base_url(); ?>assets/uploads/LatterHead.png" alt="LatterHead" srcset="" style="max-width: 100%;">
                </header>
                <?php if($this->input->get('action') == 1 || $this->input->get('action') == 2 ) {?>
                    <span class="h2"><b>Application number:</b>  <?=$this->input->get('id');?></span>
                <?php } ?>
                <?=$html; ?>
                <footer style="max-width: 100%;">

                    <img src="<?=base_url(); ?>assets/uploads/LatterFooter.png" alt="LatterHead" srcset="" style="max-width: 100%;">
                </footer>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    
    <script>
  
    var showHideGuardianState = 1; // Renamed variable
    function showHideGuardian() {
        if (showHideGuardianState == 1) {
            $("#from_group_local_guardian_name").hide();
            $("#from_group_local_guardian_mobile_no").hide();
            $("#from_group_local_guardian_whatsapp_no").hide();
            $("#from_group_local_guardian_aadhar_no").hide();
            $("#from_group_local_guardian_occupation").hide();
            $("#from_group_local_guardian_annual_income").hide();
            $("#hr_local_guardian_name").hide();
            showHideGuardianState = 0;
        } else {
            showHideGuardianState = 1;
            $("#from_group_local_guardian_name").show();
            $("#from_group_local_guardian_mobile_no").show();
            $("#from_group_local_guardian_whatsapp_no").show();
            $("#from_group_local_guardian_aadhar_no").show();
            $("#from_group_local_guardian_occupation").show();
            $("#from_group_local_guardian_annual_income").show();
            $("#hr_local_guardian_name").show();
        }
    }

    showHideGuardian();

    </script>
</div>
