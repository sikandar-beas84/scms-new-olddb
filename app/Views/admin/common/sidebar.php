	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg" style="background-color: #7393B3 !important;"><!-- sidebar-dark -->

			<!-- Sidebar content -->
			<div class="sidebar-content">

				<!-- Sidebar header -->
				<div class="sidebar-section">
					<div class="sidebar-section-body d-flex justify-content-center">
						<h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigation</h5>

						<div>
							<button type="button" class="btn btn-light btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
								<i class="ph-arrows-left-right"></i>
							</button>

							<button type="button" class="btn btn-light btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
								<i class="ph-x"></i>
							</button>
						</div>
					</div>
				</div>
				<!-- /sidebar header -->


				<!-- Main navigation -->
				<div class="sidebar-section">
					<?php if( session()->get('student_logged_in') ) { ?>
						<?php 
						$uri = service('uri');

						$segment1 = $uri->getTotalSegments() >= 1 ? $uri->getSegment(1) : '';
						$segment2 = $uri->getTotalSegments() >= 2 ? $uri->getSegment(2) : '';
						$segment3 = $uri->getTotalSegments() >= 3 ? $uri->getSegment(3) : '';
						// echo "<pre>"; print_r($segment1);
						// echo "<pre>"; print_r($segment2);
						// echo "<pre>"; print_r(session()->get());
						?>
						<ul class="nav nav-sidebar" data-nav-type="accordion">
							<li class="nav-item">
								<a href="<?= base_url('dashboardstudent') ?>" class="nav-link  <?= ($segment1 == 'dashboardstudent') ? 'active' : ''; ?>"><i class="ph-house"></i><span>Dashboard</span></a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link"><i class="ph-note-pencil"></i><span>Library Book Details</span></a>
							</li>
							<li class="nav-item nav-item-submenu  <?= ($segment3 == 'view-fee-structure' || $segment3 == 'collect-re-admission-fee') ? 'nav-item-open' : ''; ?>">
								<a href="#" class="nav-link"><i class="ph-graduation-cap"></i><span>Fee Structure</span></a>
								<ul class="nav-group-sub collapse <?= ($segment3 == 'view-fee-structure' || $segment3 == 'collect-re-admission-fee') ? 'show' : ''; ?>">
									<li class="nav-item">
										<a href="<?= base_url('/admin/student/view-fee-structure/'.session()->get('student_code')) ?>" class="nav-link <?= ($segment3 == 'view-fee-structure') ? 'active' : ''; ?>"><span>Pay Monthly Fee</span></a>
									</li>
									<li class="nav-item">
										<a href="<?= base_url('/admin/student/collect-re-admission-fee/'.session()->get('student_code')) ?>" class="nav-link <?= ($segment3 == 'collect-re-admission-fee') ? 'active' : ''; ?>"><span>Re Enrollment / Re Admission</span></a>
									</li>
								</ul>
							</li>

							<!-- <li class="nav-item nav-item-submenu  <?= ($segment3 == '') ? 'nav-item-open' : ''; ?>">
								<a href="#" class="nav-link"><i class="ph-newspaper"></i><span>Student Result</span></a>
								<ul class="nav-group-sub collapse <?= ($segment3 == '') ? 'show' : ''; ?>">
									<li class="nav-item">
										<a href="#" class="nav-link <?= ($segment3 == '') ? 'active' : ''; ?>"><span>View Pre Term Marks</span></a>
									</li>
									<li class="nav-item">
										<a href="#" class="nav-link <?= ($segment3 == '') ? 'active' : ''; ?>"><span>View Post Term Marks</span></a>
									</li>
									<li class="nav-item">
										<a href="#" class="nav-link <?= ($segment3 == '') ? 'active' : ''; ?>"><span>View Monthly Evaluation</span></a>
									</li>
									<li class="nav-item">
										<a href="#" class="nav-link <?= ($segment3 == '') ? 'active' : ''; ?>"><span>View Annual & Holistic Report Card </span></a>
									</li>
									<li class="nav-item">
										<a href="#" class="nav-link <?= ($segment3 == '') ? 'active' : ''; ?>"><span>View Half Yearly & Holistic Report Card</span></a>
									</li>
								</ul>
							</li>
							<li class="nav-item nav-item-submenu  <?= ($segment3 == '') ? 'nav-item-open' : ''; ?>">
								<a href="#" class="nav-link"><i class="ph-calendar-check"></i><span>Event / L O C Registration</span></a>
								<ul class="nav-group-sub collapse <?= ($segment3 == '') ? 'show' : ''; ?>">
									<li class="nav-item">
										<a href="#" class="nav-link <?= ($segment3 == '') ? 'active' : ''; ?>"><span>My Events</span></a>
									</li>
									<li class="nav-item">
										<a href="#" class="nav-link <?= ($segment3 == '') ? 'active' : ''; ?>"><span>Event Registration</span></a>
									</li>
								</ul>
							</li>
							<li class="nav-item nav-item-submenu  <?= ($segment3 == '') ? 'nav-item-open' : ''; ?>">
								<a href="#" class="nav-link"><i class="ph-books"></i><span>Library Management </span></a>
								<ul class="nav-group-sub collapse <?= ($segment3 == '') ? 'show' : ''; ?>">
									<li class="nav-item">
										<a href="#" class="nav-link <?= ($segment3 == '') ? 'active' : ''; ?>"><span>View Books</span></a>
									</li>
								</ul>
							</li>
							<li class="nav-item nav-item-submenu  <?= ($segment3 == '') ? 'nav-item-open' : ''; ?>">
								<a href="#" class="nav-link"><i class="ph-notepad"></i><span>Assignment</span></a>
								<ul class="nav-group-sub collapse <?= ($segment3 == '') ? 'show' : ''; ?>">
									<li class="nav-item">
										<a href="#" class="nav-link <?= ($segment3 == '') ? 'active' : ''; ?>"><span>Classwork</span></a>
									</li>
									<li class="nav-item">
										<a href="#" class="nav-link <?= ($segment3 == '') ? 'active' : ''; ?>"><span>Homework</span></a>
									</li>
								</ul>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link"><i class="ph-hand-eye"></i><span>Raise Issue</span></a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link"><i class="ph-book-bookmark"></i><span>Online Study Material</span></a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link"><i class="ph-cloud-fog"></i><span>E Library</span></a>
							</li>
							<li class="nav-item nav-item-submenu  <?= ($segment3 == '') ? 'nav-item-open' : ''; ?>">
								<a href="#" class="nav-link"><i class="ph-exam"></i><span>Exam Canter</span></a>
								<ul class="nav-group-sub collapse <?= ($segment3 == '') ? 'show' : ''; ?>">
									<li class="nav-item">
										<a href="#" class="nav-link <?= ($segment3 == '') ? 'active' : ''; ?>"><span>Attempt Exam</span></a>
									</li>
								</ul>
							</li> -->

						</ul>
					<?php } else {
						renderMenu($sidebarMenu);
					} ?>
					
				</div>
				<!-- /main navigation -->

			</div>
			<!-- /sidebar content -->
			
		</div>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">