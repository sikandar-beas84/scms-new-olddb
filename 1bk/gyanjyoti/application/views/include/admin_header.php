
<div class="app-content main-content">
	<div class="side-app">
		<!--app header-->
		<div class="app-header header header-main">
			<div class="container-fluid">
				<div class="d-flex">
					<a class="header-brand" href="<?=base_url(); ?>dashboard">


						<img src="<?=bs();?>assets/font-end/images/logo.png"
							class="header-brand-img dark-logo" alt="logo">



						<img src="<?=bs();?>assets/font-end/images/logo.png"
							class="header-brand-img desktop-lgo" alt="dark-logo">



						<img src="<?=bs();?>assets/font-end/images/logo.png"
							class="header-brand-img mobile-logo" alt="mobile-logo">



						<img src="<?=bs();?>assets/font-end/images/logo.png"
							class="header-brand-img darkmobile-logo" alt="mobile-dark-logo">

					</a>
				

					<div class="left-side-header col ps-0 d-none d-md-block ">
					
					</div>

					<div class="d-flex order-lg-2 my-auto ms-auto dropdown-container align-items-center">
						
						<div class="dropdown profile-dropdown">
							<a href="#" class="nav-link pe-1 ps-0 leading-none" data-bs-toggle="dropdown">
								<span>

									 <?php
									 $user_details = getUserData();
								// 	 prx($this->db->last_query());
									 if(get_session('user_type') == 'staff' || get_session('user_type') == 'admin' || get_session('user_type') == 'super_admin'){ 
									 if($user_details->image){ ?>
                                        <img src="<?=base_url();?>assets/uploads/staff/<?=jd($user_details->image)[0]; ?>"
                                            class="avatar avatar-md bradius rounded-circle" alt="default">
                                    <?php }else{ ?>
                                        <img src="<?=base_url();?>assets/uploads/profile/user-profile.png"
                                            class="avatar avatar-md bradius rounded-circle" alt="default">
                                    <?php } ?>
                                    <?php }else{ ?>
                                    <?php if($user_details->student_photo){ ?>
                                        <img src="<?=base_url();?>assets/uploads/student/<?=jd($user_details->student_photo)[0]; ?>"
                                            class="avatar avatar-md bradius rounded-circle" alt="default">
                                        <?php }else{ ?>
                                        <img src="<?=base_url();?>assets/uploads/profile/user-profile.png" class="avatar avatar-md bradius rounded-circle" alt="default">
                      
                                    <?php } ?>
                                    <?php } ?>

								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated">
								<div class="p-3 text-center border-bottom">
								     <?php if(get_session('user_type') == 'staff' || get_session('user_type') == 'admin'){ ?>
									<a href="#" class="text-center user pb-0 font-weight-bold"><?= ($user_details->first_name) . ' ' . ($user_details->last_name) ?></a>
									<?php }else{ ?>
									<a href="#" class="text-center user pb-0 font-weight-bold"><?= $user_details->student_name ?></a>
									<?php } ?>
									<p class="text-center user-semi-title">
									</p>
								</div>
								<a class="dropdown-item d-flex" href="<?= base_url('profile') ?>">
									<i class="fa fa-user me-3 fs-16 my-auto"></i>
									<div class="mt-1">Profile</div>
								</a>
								<a class="dropdown-item d-flex" href="<?= base_url('logout/').$this->session->userdata('user_login_history_id') ?>">
									<i class="fa fa-sign-out me-3 fs-16 my-auto"></i>
									<div class="mt-1">Log Out</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/app header-->
