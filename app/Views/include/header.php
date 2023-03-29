<?php $this->session = \Config\Services::session(); ?>
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from coderthemes.com/hyper/saas/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 22 Nov 2021 01:36:51 GMT -->
<head>
	<meta charset="utf-8" />
	<title><?= $title.' || Invest' ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
	<meta content="Coderthemes" name="author" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="<?= site_url(); ?>assets/images/favicon.ico">

	<!-- third party css -->
	<link href="<?= site_url(); ?>assets/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<!-- third party css end -->
	<!-- third party css -->
	<link href="<?= site_url(); ?>assets/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
	<link href="<?= site_url(); ?>assets/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />
	<link href="<?= site_url(); ?>assets/css/vendor/buttons.bootstrap5.css" rel="stylesheet" type="text/css" />
	<link href="<?= site_url(); ?>assets/css/vendor/select.bootstrap5.css" rel="stylesheet" type="text/css" />
	<link href="<?= site_url(); ?>assets/css/select2.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"/>
	<!-- App css -->
	<link href="<?= site_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= site_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
	<link href="<?= site_url(); ?>assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />
	<link href="<?= site_url(); ?>assets/css/custom.css" rel="stylesheet" type="text/css" id="dark-style" />
	<link href="<?= site_url(); ?>assets/css/swall.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= site_url(); ?>assets/css/vendor/quill.bubble.css" rel="stylesheet" type="text/css" />
	<link href="<?= site_url(); ?>assets/css/vendor/quill.core.css" rel="stylesheet" type="text/css" />
	<link href="<?= site_url(); ?>assets/css/vendor/quill.snow.css" rel="stylesheet" type="text/css" />
	<link href="<?= site_url(); ?>assets/css/daterangepicker.css" rel="stylesheet" type="text/css" />

</head>

<body data-layout="topnav" data-layout-config='{"layoutBoxed":false,"darkMode":false,"showRightSidebarOnStart": true}'>


	<!-- Begin page -->
	<div class="wrapper">
		

		<div class="content-page">
			<div class="content">
				
				<div class="navbar-custom topnav-navbar">
					<div class="container-fluid">

						<!-- LOGO -->
						<a href="/" class="topnav-logo">
							<span class="topnav-logo-lg">
								<img style="width: 80px;height: auto;" src="/assets/images/logo-dark.png" alt="" height="16">
							</span>
							<span class="topnav-logo-sm">
								<img style="width: 80px;height: auto;" src="/assets/images/logo-dark.png" alt="" height="16">
							</span>
						</a>

						<ul class="list-unstyled topbar-menu float-end mb-0">

							<li class="dropdown notification-list d-xl-none">
								<a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
									<i class="dripicons-search noti-icon"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
									<form class="p-3">
										<input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
									</form>
								</div>
							</li>

							<li class="dropdown notification-list">
								<a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
								aria-expanded="false">
								<span>
									<span class="account-user-name"><?= $this->session->userData['name'] ?></span>
									<span class="account-position">Admin</span>
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop" style="">
								<!-- item-->
								<div class=" dropdown-header noti-title">
									<h6 class="text-overflow m-0">Welcome !</h6>
								</div>

								<a href="javascript:void(0);" class="dropdown-item notify-item change-password" data-delete="<?= $this->session->userData['id'] ?>">
									<i class="mdi mdi-lock-outline me-1"></i>
									<span>Update Password</span>
								</a>

								<a href="<?php echo base_url('/logout'); ?>" class="dropdown-item notify-item">
									<i class="mdi mdi-logout me-1"></i>
									<span>Logout</span>
								</a>

							</div>
						</li>

					</ul>
					<a class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
						<div class="lines">
							<span></span>
							<span></span>
							<span></span>
						</div>
					</a>
					<div class="app-search dropdown">
						<form>
							<div class="input-group">
								<input type="text" class="form-control search-member" placeholder="Search By Member Id" value="<?= !empty($search_id)?$search_id:''; ?>" >
								<span class="mdi mdi-magnify search-icon"></span>
								<button class="input-group-text btn-primary" id="search-member" type="submit">Search</button>
							</div>
						</form>



					</div>
				</div>
			</div>
			<div class="topnav">
				<div class="container-fluid active">
					<nav class="navbar navbar-dark navbar-expand-lg topnav-menu">

						<div class="collapse navbar-collapse active" id="topnav-menu-content">
							<ul class="navbar-nav">
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle arrow-none" href="/dashboard" id="topnav-dashboards" role="button" >
										<i class="uil-dashboard me-1"></i>Dashboards
									</a>

								</li>
								
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="uil-apps me-1"></i>Users
										<div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="topnav-apps">
										<a class="dropdown-item" href="<?php echo base_url(); ?>/users"  role="button" ><i class="fa-solid fa-user-secret m-1"></i> Admin</a>
										<a  class="dropdown-item" href="<?php echo base_url(); ?>/users/introducer"  role="button" >
											<i class="fa-solid fa-user-tie m-1"></i> Introducer</a>
											<a  class="dropdown-item" href="<?php echo base_url(); ?>/users/investor"  role="button" ><i class="fa-solid fa-user-secret m-1"></i> Investor</a>
										</div>
									</li>
									
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle arrow-none" href="<?php echo base_url(); ?>/users/investment-list"  role="button" ><i class="fa-solid fa-hand-holding-dollar"></i> Investment </a>
									</li>
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle arrow-none" href="<?php echo base_url(); ?>/users/relationship-manager-list"  role="button" >
											<i class="fa-solid fa-hands-praying"></i>  Relationship Manager 
										</a>
									</li>
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="uil-apps me-1"></i>Monthly Payout
											<div class="arrow-down"></div>
										</a>
										<div class="dropdown-menu" aria-labelledby="topnav-apps">
											<a href="<?php echo base_url(); ?>/payout/monthly-commission" class="dropdown-item"> Commission </a>
											<a href="<?php echo base_url(); ?>/payout/monthly-interest" class="dropdown-item"> Interest </a>
											<a href="<?php echo base_url(); ?>/payout" class="dropdown-item"> Generate Payout </a>
										</div>
									</li>
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="uil-apps me-1"></i>Withdrawal
											<div class="arrow-down"></div>
										</a>
										<div class="dropdown-menu" aria-labelledby="topnav-apps">
											<a class="dropdown-item" href="<?= site_url('payout/withdraw') ?>"> Withdraw </a>
											<a class="dropdown-item" href="<?= site_url('payout/withdrawal-history') ?>"> Withdrawal List </a>
										</div>
									</li>
								</ul>
							</div>
						</nav>
					</div>
				</div>
				<!-- change password modal -->
				<div id="change-password-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dark-header-modalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header modal-colored-header bg-dark">
								<h4 class="modal-title" id="dark-header-modalLabel">Change Password</h4>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
							</div>
							<div class="modal-body">
								<form action="" id="form-change-password">
									<div class="mb-3">
										<label for="">Password <span class="text-danger">*</span></label>
										<input type="text" name="password" placeholder=" Enter password" class="form-control">
									</div>
									<div class="mb-3">
										<label for="">Confirm Password <span class="text-danger">*</span></label>
										<input type="text" name="confirm_pwd" placeholder="Enter confirm password" class="form-control">
									</div>
									<?= csrf_field(); ?>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
								<button type="button" class="btn btn-dark btn-change-password">Save</button>
							</div>
						</div>
					</div>
				</div>