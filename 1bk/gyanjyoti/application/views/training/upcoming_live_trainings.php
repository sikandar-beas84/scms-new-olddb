<!--Page header-->
<style>
    .st {
        background-color: #FFA500;
        border-color: #FFA500;
    }
   

</style>
<div class="page-header d-xl-flex d-block">
    <div class="page-leftheader">
        <h4 class="page-title"><span class="font-weight-normal text-muted ms-2">
                <?= $page_title; ?>
            </span></h4>
    </div>
    
    <div class="page-rightheader ms-md-auto">
        <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
            <div class="d-flex breadcrumb-res">
                <div class="header-datepicker me-3">
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="feather feather-calendar"></i>
                        </div>
                        <input class="form-control fc-datepicker pb-0 pt-0" value="<?= date('M d,Y') ?>" type="text"
                            disabled>
                    </div>
                </div>
                <div class="header-datepicker picker2 me-3">
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="feather feather-clock"></i>
                        </div><!-- input-group-text -->
                        <input id="tpBasic " type="text" placeholder="<?= date('h:i A') ?>"
                            class="form-control input-small pb-0 pt-0" disabled>
                    </div>
                </div><!-- wd-150 -->
            </div>
        </div>
    </div>
</div>
<!--End Page header-->

<!--Dashboard List-->
<div class="row">
    <?php if($this->session->userdata('user_type') == 'admin'): ?> 
        <div class="page-btn text-end">
        <?php //if(hasSubGroupActionPrivilege($this->session->userdata('user_id'), 'Branch Master', 'Add')): ?>
        <button type="button" class="btn btn-primary" onclick="openModal()">
            Add 
        </button> 
        <?php //endif; ?>
    </div>
        <div class="col-xl-12 col-md-12 col-lg-12">
        <div class="row">
            <?php if($this->session->userdata('user_type') == 'admin'): ?> 
                <table class="table table-sm" id="training_video">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Sub Title</th>
                                <th>Image</th>
                                <th>Date</th>
                                <th>Action</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                </table>  
                <!-- Modal -->
                <div class="modal fade" id="training_video_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-m" role="document">
                        <div class="modal-content">
                            <form id="modalFormAdd">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="training_video_modal_title">Modal title</h5>
                                    <button type="button" class="close" onclick="closeModal('training_video_modal')">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="training_video_modal_body">

                                </div>
                                <div class="modal-footer justify-content-end">
                                    <button type="submit" class="btn btn-success btn-sm save-btn">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script type="text/javascript">
                    var baseUrl = '<?= base_url() ?>';
                    var pageURL = 'training-video/upcoming_live_trainings/';
                    var tableName = 'training_video';
                    var modalId = 'training_video_modal';
                    $(document).ready(function() {
                        servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');
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
                            $('#'+modalId+'_title').text('Add Upcoming Video');
                            $(".save-btn").show();
                            holdModal(modalId);

                            if(type == 1){
                                $("#"+modalId+"_body .form-control").attr('disabled', 'disabled');
                                $(".save-btn").hide();
                                $("#"+modalId+"_title").text('View Upcoming Video');
                            } else if(type == 2){
                                $("#"+modalId+"_title").text('Edit Training Video');
                            }
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

            <?php else: ?>
            <?php foreach($training_video as $value){ ?>
            <div class="col-xl-6 col-md-6 col-lg-6">
                <iframe width="560" height="315" src="<?=$value->link; ?>"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            <?php } ?>
            
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
    <style>
         .card {
              position: relative;
              width: 200px;
              height: 250px;
              border-radius: 14px;
              z-index: 1111;
              overflow: hidden;
              display: flex;
              flex-direction: column;
              align-items: center;
              justify-content: center;
              box-shadow: 20px 20px 60px #bebebe, -20px -20px 60px #ffffff;
              ;
            }
            
            .bg {
              position: absolute;
              top: 5px;
              left: 5px;
              width: 190px;
              height: 240px;
              z-index: 2;
              background: rgba(255, 255, 255, .95);
              backdrop-filter: blur(24px);
              border-radius: 10px;
              overflow: hidden;
              outline: 2px solid white;
            }
            
            .blob {
              position: absolute;
              z-index: 1;
              top: 50%;
              left: 50%;
              width: 150px;
              height: 150px;
              border-radius: 50%;
              background-color: #3183fd;
              opacity: 1;
              filter: blur(12px);
              animation: blob-bounce 5s infinite ease;
            }
            
            @keyframes blob-bounce {
              0% {
                transform: translate(-100%, -100%) translate3d(0, 0, 0);
              }
            
              25% {
                transform: translate(-100%, -100%) translate3d(100%, 0, 0);
              }
            
              50% {
                transform: translate(-100%, -100%) translate3d(100%, 100%, 0);
              }
            
              75% {
                transform: translate(-100%, -100%) translate3d(0, 100%, 0);
              }
            
              100% {
                transform: translate(-100%, -100%) translate3d(0, 0, 0);
              }
            }
    </style>
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class='row'>
                <?php foreach($upcoming_live_trainings as $value){ ?>
                <div class="col-xl-3 col-md-3 col-lg-3">
                    <div class="card">
                      <div class="bg">
                          <?php if($value->image){ ?>
                           <img class="card-img-top" src="<?=base_url(); ?>assets/uploads/upcoming/<?=$value->image; ?>" alt="<?=$value->title; ?>">
                           <?php }else{ ?>
                           <img class="card-img-top" src="<?=base_url(); ?>assets/noimgland.jpg" alt="noimgland">
                           
                          <?php  } ?>
                          <div class="card-body">
                            <h5 class="card-title"><?=$value->title; ?></h5>
                            <p class="card-text"><?=$value->sub_title; ?></p>
                            <a href="#" class="btn btn-primary"><?= date('d M Y', strtotime($value->date)); ?></a>
                          </div>
                          
                      </div>
                      <div class="blob"></div>
                    </div>

                </div>
                
                <?php } ?>
            </div>
        </div>
    <?php endif; ?>
   
    <!--Dashboard List-->


</div>
</div><!-- end app-content-->