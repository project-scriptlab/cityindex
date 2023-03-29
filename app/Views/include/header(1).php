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
                 <a  href="<?= site_url('dashboard') ?>"  class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span class="badge bg-success float-end"></span>
                    <span> Dashboards </span>
                </a>
            </li>
            <li class="side-nav-title side-nav-item">Users</li>
            <li class="side-nav-item">
             <a  href="<?= site_url('users') ?>"  class="side-nav-link">
                <i class="fa-solid fa-user-secret"></i>
                <span class="badge bg-success float-end"></span>
                <span> Admin </span>
            </a>
        </li>

        <li class="side-nav-item">
         <a  href="<?= site_url('users/introducer') ?>"  class="side-nav-link">
            <i class="fa-solid fa-user-tie"></i>
            <span class="badge bg-success float-end"></span>
            <span> Introducer </span>
        </a>
    </li>

    <li class="side-nav-item">
       <a  href="<?= site_url('users/investor') ?>"  class="side-nav-link">
        <i class="fa-solid fa-user-astronaut"></i>
        <span class="badge bg-success float-end"></span>
        <span> Investor </span>
    </a>
</li>

<li class="side-nav-item">
 <a  href="<?= site_url('users/investment-list') ?>"  class="side-nav-link">
    <i class="fa-solid fa-hand-holding-dollar"></i>
    <span class="badge bg-success float-end"></span>
    <span> Investment </span>
</a>
</li> 

<li class="side-nav-item">
   <a  href="<?= site_url('users/relationship-manager-list') ?>"  class="side-nav-link">
    <i class="fa-solid fa-hands-praying"></i>
    <span class="badge bg-success float-end"></span>
    <span> Relationship Manager </span>
</a>
</li>

<li class="side-nav-title side-nav-item">Reports</li>

<li class="side-nav-item">
    <a data-bs-toggle="collapse" href="#sidebarForms" aria-expanded="false" aria-controls="sidebarForms" class="side-nav-link">
        <i class="fa-brands fa-cc-amazon-pay"></i>
        <span> Monthly Payout </span>
        <span class="menu-arrow"></span>
    </a>
    <div class="collapse" id="sidebarForms">
        <ul class="side-nav-second-level">
            <li>
                <a href="<?= site_url('payout/monthly-commission') ?>"> Commission </a>
            </li>
            <li>
                <a href="<?= site_url('payout/monthly-interest') ?>"> Interest </a>
            </li>
            <li>
                <a href="<?= site_url('payout') ?>"> Generate Payout </a>
            </li>
            <!-- <li>
                <a href="<?= site_url('payout/manual-generate') ?>"> Manually Generate </a>
            </li> -->
        </ul>
    </div>
</li>

<li class="side-nav-title side-nav-item">Disburse</li>
<li class="side-nav-item">
    <a data-bs-toggle="collapse" href="#sidebarWithdrawl" aria-expanded="false" aria-controls="sidebarWithdrawl" class="side-nav-link">
     <i class="fa-solid fa-coins"></i>
     <span> Withdrawal </span>
     <span class="menu-arrow"></span>
 </a>
 <div class="collapse" id="sidebarWithdrawl">
    <ul class="side-nav-second-level">
        <li>
            <a href="<?= site_url('payout/withdraw') ?>"> Withdraw </a>
        </li>

        <li>
            <a href="<?= site_url('payout/withdrawal-history') ?>"> Withdrawal List </a>
        </li>
    </ul>
</div>
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
                                <span class="account-position">Admin</span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                            <!-- item-->
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>

                            <!-- item-->
                            <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-circle me-1"></i>
                                <span>My Account</span>
                            </a> -->

                            <!-- item-->
                            <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-edit me-1"></i>
                                <span>Settings</span>
                            </a> -->

                            <a href="javascript:void(0);" class="dropdown-item notify-item change-password" data-delete="<?= $this->session->userData['id'] ?>">
                              <i class="mdi mdi-lock-outline me-1"></i>
                              <span>Update Password</span>
                          </a>

                          <!-- item-->
                          <a href="<?php echo base_url('/logout'); ?>" class="dropdown-item notify-item">
                            <i class="mdi mdi-logout me-1"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </li>

            </ul>
            <button class="button-menu-mobile open-left">
                <i class="mdi mdi-menu"></i>
            </button>
            <div class="app-search dropdown d-none d-lg-block">
                <form>
                    <div class="input-group">
                        <input type="text" class="form-control search-member" placeholder="Search By Member Id" value="<?= !empty($search_id)?$search_id:''; ?>" >
                        <span class="mdi mdi-magnify search-icon"></span>
                        <button class="input-group-text btn-primary" id="search-member" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- end Topbar -->


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