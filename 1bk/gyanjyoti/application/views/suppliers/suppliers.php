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
                                <th>Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Image</th>
                                <th>About</th>
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
                    var pageURL = 'suppliers/';
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
                            $('#'+modalId+'_title').text('Add Suppliers');
                            $(".save-btn").show();
                            holdModal(modalId);

                            if(type == 1){
                                $("#"+modalId+"_body .form-control").attr('disabled', 'disabled');
                                $(".save-btn").hide();
                                $("#"+modalId+"_title").text('View Suppliers');
                            } else if(type == 2){
                                $("#"+modalId+"_title").text('Edit Suppliers');
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
         
          
           
            .navbar {
              /*position: fixed;*/
              top: 0;
              width: 100%;
            }
            .active-link {
              background-color: #007bff; /* Set your desired background color */
              color: #fff !important;
              border-radius: 35%;
              padding: auto;
              text-align: center;
              justify-content: center;

            }
            section {
              padding: 20px;
              margin-top: 50px; /* Adjust according to your navigation height */
            }
          .jumpNav {
              display: contents;
            }
            @media screen and (min-width: 480px) {
              .page-rightheader.ms-md-auto {
                  margin-left: 49%;
                  margin-top: -7%;
                }
            }
    </style>
        <div class="col-xl-12 col-md-12 col-lg-12">
            <form action="<?=base_url(); ?>suppliers" methord="get">
                <div class="row">
                        <div class="col-xl-6 col-md-6 col-lg-6 mb-2">
                            <div class="input-group w-100">
        							<span class="input-group-text" id="basic-addon1">
        								<i class="fa fa-search"></i>
        							</span>
        						<input class="form-control" type="text" name="keyword" value="<?= $this->input->get('keyword') ?>" placeholder="Search here.." aria-label="search" aria-describedby="basic-addon1">
        					</div>
                        </div>
                        <div class="col-xl-4 col-md-4 col-lg-4 mb-2">
                            <select class="form-select" name="category">
                               <option <?= $this->input->get('category') == 'Hotels/Resorts' ? 'selected' : ''; ?> value="Hotels/Resorts">Hotels/Resorts</option>
                                <option <?= $this->input->get('category') == 'Air' ? 'selected' : ''; ?> value="Air">Air</option>
                                <option <?= $this->input->get('category') == 'Car Transfers/Rentals' ? 'selected' : ''; ?> value="Car Transfers/Rentals">Car Transfers/Rentals</option>
                                <option <?= $this->input->get('category') == 'Tour Operator/FIT' ? 'selected' : ''; ?> value="Tour Operator/FIT">Tour Operator/FIT</option>
                                <option <?= $this->input->get('category') == 'Guided Tours' ? 'selected' : ''; ?> value="Guided Tours">Guided Tours</option>
                                <option <?= $this->input->get('category') == 'Activities' ? 'selected' : ''; ?> value="Activities">Activities</option>
                                <option <?= $this->input->get('category') == 'Cruise' ? 'selected' : ''; ?> value="Cruise">Cruise</option>
                                <option <?= $this->input->get('category') == 'Insurance' ? 'selected' : ''; ?> value="Insurance">Insurance</option>
                                <option <?= $this->input->get('category') == 'Rail' ? 'selected' : ''; ?> value="Rail">Rail</option>
                                <option <?= $this->input->get('category') == 'Booking Tool' ? 'selected' : ''; ?> value="Booking Tool">Booking Tool</option>
                                <option <?= $this->input->get('category') == 'Destination' ? 'selected' : ''; ?> value="Destination">Destination</option>
                                <option <?= $this->input->get('category') == 'Travel Leaders' ? 'selected' : ''; ?> value="Travel Leaders">Travel Leaders</option>
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-2 col-lg-2 mb-2">
                            <button type="submit" class="btn btn-outline-success w-100">Filter</button>
                        </div>
                </div>
            </form>
             <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                  <ul class="navbar-nav mr-auto text-center jumpNav">
                      <li class="nav-item">
                          <a class="nav-link">Jump to: </a>
                        </li>
                      <?php for ($i = 65; $i <= 90; $i++) { ?>
                        <li class="nav-item">
                          <a class="nav-link" href="#section-<?=chr($i); ?>"><?=chr($i); ?></a>
                        </li>
                      <?php } ?>
                    
                  </ul>
                </div>
              </nav>
              <!-- Sections -->
              <div class="container">
              <?php for ($i = 65; $i <= 90; $i++) { ?>
                    <section id="section-<?=chr($i); ?>">
                      <h2><?=chr($i); ?></h2>
                      <?php $suppliers = $this->Common_model->get_suppliers_with_name_starting(chr($i), $this->input->get('keyword'), $this->input->get('category')); 
                      ?>
                          <div class='row'>
                                <?php foreach($suppliers as $value){ ?>
                                <div class="col-xl-3 col-md-3 col-lg-3">
                                    <div class="card">
                                        <a href="<?=base_url(); ?>suppliers?id=<?=$value->id; ?>">
                                      <div class="bg">
                                          <?php if($value->image){ ?>
                                           <img class="card-img-top" src="<?=base_url(); ?>assets/uploads/suppliers/<?=$value->image; ?>" alt="<?=$value->name; ?>" style="height: 138px;">
                                           <?php }else{ ?>
                                           <img class="card-img-top" src="<?=base_url(); ?>assets/noimgland.jpg" alt="noimgland">
                                           
                                          <?php  } ?>
                                          <div class="card-body">
                                            <h5 class="card-title"><?=$value->name; ?></h5>
                                            <p class="card-text"><?=substr($value->about, 0, 15); ?>...</p>
                                          </div>
                                          
                                      </div>
                                      </a>
                                      <div class="blob"></div>
                                    </div>
                
                                </div>
                                
                                <?php } ?>
                            </div>
                    </section>
                <?php } ?>
               
              </div>
         <script>
            $(document).ready(function(){
              // Smooth Scroll to Anchor
              $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if( target.length ) {
                  event.preventDefault();
                  $('html, body').stop().animate({
                    scrollTop: target.offset().top
                  }, 1000);
                }
                // Toggle active class
                $('a[href^="#"]').removeClass('active-link');
                $(this).addClass('active-link');
              });
            });
          </script>
        
        </div>
    <?php endif; ?>
   
    <!--Dashboard List-->


</div>
</div><!-- end app-content-->