<!-- 
    * Auth: Suhrid Sarkar
    * On: 31-04-2023
    * For: User Master
    * For: Password Master -->


<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="page-title">
                <h4><?= $page_title ?></h4>
            </div>
            <div class="page-btn">
            <?php if(hasSubGroupActionPrivilege($this->session->userdata('user_id'), 'Standard Password Polices Master', 'Add')): ?>
                <button type="button" class="btn btn-primary" onclick="openModal()">
                    Add Password Polices
                </button> 
            <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                    
                        <div class="table-responsive">
                            <table class="table table-sm" id="standard_password_polices_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Characters</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('password_settings/standard_password_polices/standard_password_polices_modal'); ?>
<script type="text/javascript">
    var baseUrl = '<?= base_url() ?>';
    var pageURL = 'password_settings/standard_password_polices_master/';
    // var modalId = 'standard_password_polices_modal';
    var tableName = 'standard_password_polices_table';
    $(document).ready(function() {
        servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');

    });


</script>
<script type="text/javascript">


    
    var baseUrl = '<?= base_url() ?>';
    var pageURL = 'password_settings/standard_password_polices_master/';
    var modalId = 'standard_password_polices_modal';
    var tableName = 'standard_password_polices_table';
    $(document).ready(function() {
        // servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');
        
        //Submit the modal form
        $("#modalFormAdd").on('submit', (function (e) {
            e.preventDefault();
            ajaxFromSubmit(pageURL+'save', this, function (data) {
                closeModal(modalId); // calling function to close Modal
                successMsg('Data save success');
                servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');
            });
        }));
    });

    function openModal(id = 0, type = 0){
        ajaxPostRequest(pageURL+'load_modal',{'id': id}, function(data) {
            $('#'+modalId+'_body').html(data.html);
            $('#'+modalId+'_title').text('Add Password Polices');
            $(".save-btn").show();
            holdModal(modalId);

            if(type == 1){
                $("#"+modalId+"_body .form-control").attr('disabled', 'disabled');
                $("#"+modalId+"_body .form-select").attr('disabled', 'disabled');
                $("#"+modalId+"_body .form-check-input").attr('disabled', 'disabled');
                $(".save-btn").hide();
                $("#"+modalId+"_title").text('View Password Polices');
            } else if(type == 2){
                $("#"+modalId+"_title").text('Edit Password Polices');
            }
        });
    }
    function getProductDataList(id){
        ajaxPostRequest(pageURL+'load_product',{'id': id}, function(data) {
            $('#productfield').html(data.html);
        });
    }



	function deleteField(id = ''){
        warningMsg('Are You Sure', 'You won\'t be able to revert this!', 'warning', 'Delete it', function () {
            ajaxPostRequest(pageURL+'delete', {
                "id": id
            }, function (data) {
                successMsg('Item Deleted.'); // Success Message
                servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list'); //Refresh Datatable
            });
        });       
    }
</script>
