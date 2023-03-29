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

    <!-- App css -->
    <link href="<?= site_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="<?= site_url(); ?>assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />
    <link href="<?= site_url(); ?>assets/css/custom.css" rel="stylesheet" type="text/css" id="dark-style" />
    <link href="<?= site_url(); ?>assets/css/swall.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"/>
    


</head>

<body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- LOGO -->
            <a href="<?= site_url() ?>" class="logo text-center logo-light">
             <span class="logo-lg admin-logo-block">
              <img class="admin-logo" src="<?= site_url(); ?>assets/images/eqsis_logo.png" alt="" height="65">
          </span>
          <span class="logo-sm admin-logo-block">
              <img class="admin-logo" src="<?= site_url(); ?>assets/images/logo_sm.png" alt="" height="16">
          </span>
      </a>

      <!-- LOGO -->
      <a href="index.html" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="<?= site_url(); ?>assets/images/logo-dark.png" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="<?= site_url(); ?>assets/images/logo_sm_dark.png" alt="" height="16">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">

           <br>

           <li class="side-nav-item">
               <a  href="<?= site_url('introducers') ?>"  class="side-nav-link">
                <i class="uil-home-alt"></i>
                <span class="badge bg-success float-end"></span>
                <span> Dashboards </span>
            </a>

        </li>
        <li class="side-nav-item">
           <a  href="<?= site_url('introducers/investor-list') ?>"  class="side-nav-link">
            <i class="uil-user-circle"></i>
            <span class="badge bg-success float-end"></span>
            <span> Investors </span>
        </a>
    </li>
    <li class="side-nav-item">
       <a  href="<?= site_url('introducers/monthly-commission') ?>"  class="side-nav-link">
        <i class="fa-brands fa-cc-amazon-pay"></i>
        <span class="badge bg-success float-end"></span>
        <span> Monthly Commission </span>
    </a>
</li>
</ul>



<div class="clearfix"></div>

</div>


</div>

<div class="content-page">
    <div class="content">
        <!-- Topbar Start -->
        <div class="navbar-custom">
            <ul class="list-unstyled topbar-menu float-end mb-0">

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                    aria-expanded="false">
                    <span>
                        <span class="account-user-name"><?= $this->session->userData['name'] ?></span>
                        <span class="account-position">Introducer</span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <a href="<?= site_url('introducers/my-profile') ?>" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-circle me-1"></i>
                        <span>My Account</span>
                    </a>
                    <a href="<?php echo base_url('/logout'); ?>" class="dropdown-item notify-item">
                        <i class="mdi mdi-logout me-1"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </li>

        </ul>
    </div>
            <!-- end Topbar -->