
<?= $this->extend('investors/investorLayOut'); ?>
<?= $this->section('body') ?>
<?php helper("custom"); ?>

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-light" id="dash-daterange">
                            <span class="input-group-text bg-primary border-primary text-white">
                                <i class="mdi mdi-calendar-range font-13"></i>
                            </span>
                        </div>
                        <a href="javascript: void(0);" class="btn btn-primary ms-2">
                            <i class="mdi mdi-autorenew"></i>
                        </a>
                        <a href="javascript: void(0);" class="btn btn-primary ms-1">
                            <i class="mdi mdi-filter-variant"></i>
                        </a>
                    </form>
                </div>
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-5 col-lg-6">

            <div class="row">
                <div class="col-lg-6">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Investment Amount</h5>
                            <h3 class="mt-3 mb-3"><i class="fa-solid fa-indian-rupee-sign"></i><?= number_format(totalInvestmentAmount(1)) ?></h3>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-lg-6">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <h5 class="text-muted fw-normal mt-0" title="Number of Orders">Total Interest</h5>
                            <h3 class="mt-3 mb-3"><i class="fa-solid fa-indian-rupee-sign"></i><?= number_format(totalInterestReceived()) ?></h3>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row -->
        </div> <!-- end col -->

        <div class="col-xl-7 col-lg-6">
            <div class="card card-h-100">
                <div class="card-body">

                </div> <!-- end card-body-->
            </div> <!-- end card-->

        </div> <!-- end col -->

        <div class="col-xl-5 col-lg-6">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Withdrawal Amount</h5>
                            <h3 class="mt-3 mb-3"><i class="fa-solid fa-indian-rupee-sign"></i><?= number_format(totalWithdrawalAmount()) ?></h3>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>
        </div>
    </div>
    <!-- end row -->

</div>
<!-- container -->

</div>
<!-- content -->

<!-- <script src="assets/js/vendor/apexcharts.min.js"></script>
<script src="assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>

<script src="assets/js/pages/introducer-dashboard.js"></script> -->
<?= $this->endSection() ?>