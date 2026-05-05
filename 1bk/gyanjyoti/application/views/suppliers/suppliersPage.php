<!--Page header-->
<style>
    .st {
        background-color: #FFA500;
        border-color: #FFA500;
    }
   .suppliersHeadder .logo, .category {
      text-align: center;
    }
    .supLogo {
      border-radius: 50%;
      border: 3px solid;
      width: 150px;
      height: 150px;
    }
    .about p {
      font-size: 17px;
    }
    
    .card {
     width: 100%;
     height: 254px;
     background-image: linear-gradient(163deg, #00ff75 0%, #3700ff 100%);
     border-radius: 20px;
     transition: all .3s;
     box-shadow: 0px 0px 30px 1px rgba(4, 4, 4, 0.3);
    }
    
    .card2 {
     width: 100%;
     height: 254px;
     background-color: #fff;
     border-radius:;
     transition: all .2s;
          border-radius: 20px;

    }
    
    .card2:hover {
     transform: scale(0.98);
     border-radius: 20px;
    }
    
    .card:hover {
     box-shadow: 0px 0px 30px 1px rgba(0, 255, 117, 0.30);
    }
    
    .heading {
      font-size: 20px;
      text-transform: capitalize;
      font-weight: 700;
    }
  .heading {
      padding: 10px 11px;
        padding-bottom: 10px;
      font-size: 22px;
      border-bottom: 3px solid #5b5b5b;
      padding-bottom: 2px;
    }
    .suppliersBody .text {
      margin: 10px 11px;
    }
    
    
    button {
  position: relative;
  width: 11em;
  height: 4em;
  outline: none;
  transition: 0.1s;
  background-color: transparent;
  border: none;
  font-size: 13px;
  font-weight: bold;
  color: #2869c3;
}

#clip {
  --color: #2761c3;
  position: absolute;
  top: 0;
  overflow: hidden;
  width: 100%;
  height: 100%;
  border: 5px double var(--color);
  box-shadow: inset 0px 0px 15px #195480;
  -webkit-clip-path: polygon(30% 0%, 70% 0%, 100% 30%, 100% 70%, 70% 100%, 30% 100%, 0% 70%, 0% 30%);
}

.arrow {
  position: absolute;
  transition: 0.2s;
  background-color: #2761c3;
  top: 35%;
  width: 11%;
  height: 30%;
}

#leftArrow {
  left: -13.5%;
  -webkit-clip-path: polygon(100% 0, 100% 100%, 0 50%);
}

#rightArrow {
  -webkit-clip-path: polygon(100% 49%, 0 0, 0 100%);
  left: 102%;
}

button:hover #rightArrow {
  background-color: #27c39f;
  left: -15%;
  animation: 0.6s ease-in-out both infinite alternate rightArrow8;
}

button:hover #leftArrow {
  background-color: #27c39f;
  left: 103%;
  animation: 0.6s ease-in-out both infinite alternate leftArrow8;
}

.corner {
  position: absolute;
  width: 4em;
  height: 4em;
  background-color: #2761c3;
  box-shadow: inset 1px 1px 8px #2781c3;
  transform: scale(1) rotate(45deg);
  transition: 0.2s;
}

#rightTop {
  top: -1.98em;
  left: 91%;
}

#leftTop {
  top: -1.96em;
  left: -3.0em;
}

#leftBottom {
  top: 2.10em;
  left: -2.15em;
}

#rightBottom {
  top: 45%;
  left: 88%;
}

button:hover #leftTop {
  animation: 0.1s ease-in-out 0.05s both changeColor8,
  0.2s linear 0.4s both lightEffect8;
}

button:hover #rightTop {
  animation: 0.1s ease-in-out 0.15s both changeColor8,
  0.2s linear 0.4s both lightEffect8;
}

button:hover #rightBottom {
  animation: 0.1s ease-in-out 0.25s both changeColor8,
  0.2s linear 0.4s both lightEffect8;
}

button:hover #leftBottom {
  animation: 0.1s ease-in-out 0.35s both changeColor8,
  0.2s linear 0.4s both lightEffect8;
}

button:hover .corner {
  transform: scale(1.25) rotate(45deg);
}

button:hover #clip {
  animation: 0.2s ease-in-out 0.55s both greenLight8;
  --color: #27c39f;
}

@keyframes changeColor8 {
  from {
    background-color: #2781c3;
  }

  to {
    background-color: #27c39f;
  }
}

@keyframes lightEffect8 {
  from {
    box-shadow: 1px 1px 5px #27c39f;
  }

  to {
    box-shadow: 0 0 2px #27c39f;
  }
}

@keyframes greenLight8 {
  from {
  }

  to {
    box-shadow: inset 0px 0px 32px #27c39f;
  }
}

@keyframes leftArrow8 {
  from {
    transform: translate(0px);
  }

  to {
    transform: translateX(10px);
  }
}

@keyframes rightArrow8 {
  from {
    transform: translate(0px);
  }

  to {
    transform: translateX(-10px);
  }
}
.suppliersName {
  font-size: 23px !important;
  font-weight: 700;
  margin-bottom: 0;
  border-bottom: 4px solid #565454;
}
.fixed-email {
  z-index: 1111111111111111111111111111111;
  background: red;
  border-radius: 50%;
  margin-left: 74% !important;
  margin-bottom: 2% !important;
}
.fixed-phone {
 background: green;
  margin-bottom: 6% !important;
}

.fixed-email a svg {
  color: #fff;
  width: 22px;
}
/**/
</style>
<div class="position-fixed bottom-0 right-0 p-3  fixed-email fixed-phone">
  <a href="tall:<?=$suppliers[0]->phone; ?>" id="phoneIcon" title="<?=$suppliers[0]->phone; ?>" data-toggle="tooltip" data-placement="top" title="Send Email">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-forward" viewBox="0 0 16 16">
      <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm10.762.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708"/>
    </svg>
    </a>
  </div>
<div class="position-fixed bottom-0 right-0 p-3 fixed-email">
  <a href="mailto:<?=$suppliers[0]->email; ?>" id="emailIcon" title="<?=$suppliers[0]->email; ?>" data-toggle="tooltip" data-placement="top" title="Send Email">
    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-envelope-at" viewBox="0 0 16 16">
      <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z"/>
      <path d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648m-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z"/>
    </svg>
  </a>
</div>
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
    
    <div class="col-xl-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-lg-12 suppliersHeadder">
                <div class="row">
                    <div class="col-xl-3 col-md-3 col-lg-3">
                        <div class="logo">
                            <?php if($suppliers[0]->image){ ?>
                               <img class="supLogo" src="<?=base_url(); ?>assets/uploads/suppliers/<?=$suppliers[0]->image; ?>" alt="<?=$suppliers[0]->name; ?>" style="height: 138px;">
                               <?php }else{ ?>
                               <img class="supLogo" src="<?=base_url(); ?>assets/noimgland.jpg" alt="noimgland">
                              <?php  } ?>
                        </div>
                        <p class="category"><?=$suppliers[0]->category; ?> </p>
                        <p class="category"><b>Address: </b><?=$suppliers[0]->address; ?> </p>
                    </div>
                    <div class="col-xl-9 col-md-9 col-lg-9">
                        <div class="about">
                            <p class="suppliersName"><?=$suppliers[0]->name; ?></p>
                           <p><?=$suppliers[0]->about; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12 col-lg-12 suppliersBody">
                <div class="row">
                    <div class="col-xl-4 col-md-4 col-lg-4 p-3">
                        <div class="card">
                          <div class="card2">
                              <p class="heading">
                                Commission Rates
                              </p>
                              <p class="text" style="height: 170px;overflow: scroll;">
                                <?=$suppliers[0]->commission_rates; ?>
                              </p>
                          </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 col-lg-4 p-3">
                        <div class="card">
                          <div class="card2">
                              <p class="heading">
                                BDM/Contact Info
                              </p>
                                  <p class="text" style="height: 170px;overflow: scroll;">
                                    <?=$suppliers[0]->bdm_contact_info; ?>
                                  </p>
                          </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 col-lg-4 p-3">
                        <div class="card">
                          <div class="card2">
                              <p class="heading">
                                Booking Resources
                              </p>
                              <a href="<?=$suppliers[0]->booking_resources_link ? $suppliers[0]->booking_resources_link : '#'; ?>" >
                                  <p class="text" style="height: 170px;overflow: scroll;">
                                    <?=$suppliers[0]->booking_resources_text; ?>
                                  </p>
                              </a>
                          </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 col-lg-4 p-3">
                        <div class="card">
                          <div class="card2">
                              <p class="heading">
                               Education
                              </p>
                              <a href="<?=$suppliers[0]->education_link ? $suppliers[0]->education_link : '#'; ?>" >
                                  <p class="text" style="height: 170px;overflow: scroll;">
                                    <?=$suppliers[0]->education_text; ?>
                                  </p>
                              </a>
                          </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 col-lg-4 p-3">
                        <div class="card">
                          <div class="card2">
                              <p class="heading">
                               How to Register
                              </p>
                                  <p class="text">
                                    <?=$suppliers[0]->how_to_register; ?>
                                  </p>
                                  <!--<a href="" class="btn btn-outline-danger">Login</a>-->
                                  <div class="button text-center">
                                      <a href="">
                                      <button>
                                        L O G I N
                                        <div id="clip">
                                            <div id="leftTop" class="corner"></div>
                                            <div id="rightBottom" class="corner"></div>
                                            <div id="rightTop" class="corner"></div>
                                            <div id="leftBottom" class="corner"></div>
                                        </div>
                                        <span id="rightArrow" class="arrow"></span>
                                        <span id="leftArrow" class="arrow"></span>
                                    </button>
                                    </a>
                                </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 col-lg-4 p-3">
                        <div class="card">
                          <div class="card2">
                              <p class="heading">
                               More
                              </p>
                               <a href="<?=$suppliers[0]->more_link ? $suppliers[0]->more_link : '#'; ?>" >
                                  <p class="text" style="height: 170px;overflow: scroll;">
                                    <?=$suppliers[0]->more_text; ?>
                                  </p>
                              </a>
                          </div>
                        </div>
                    </div>
                    
            </div>
        </div>
    </div>
    
   
    <!--Dashboard List-->


</div><!-- end app-content-->