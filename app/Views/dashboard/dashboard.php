
<?= $this->extend('layOut'); ?>
<?= $this->section('body') ?>
<?php helper('custom'); ?>

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
               
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
      
		<div class="col-lg-4">
			<div class="card widget-flat">
				<div class="card-body">
					
					<h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total No of Investors</h5>
					<h3 class="mt-3 mb-3"><?= usersCountByGroup(2) ?></h3>
					<p class="mb-0 text-muted">
						<!--      <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>-->
					</p>
				</div> <!-- end card-body-->
			</div> <!-- end card-->
		</div>
		<div class="col-lg-4">
			<div class="card widget-flat">
				<div class="card-body">
			
					<h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Investments Received</h5>
					<h3 class="mt-3 mb-3"><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format(totalInvestmentReceived(), 2) ?></h3>
					<p class="mb-0 text-muted">
						<!--      <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>-->
						<!-- <span class="text-nowrap">Since last month</span> -->
					</p>
				</div> <!-- end card-body-->
			</div> <!-- end card-->
		</div>
		
		<div class="col-lg-4">
			<div class="card widget-flat">
				<div class="card-body">
				
					<h5 class="text-muted fw-normal mt-0" title="Average Revenue">Total No of Introducers</h5>
					<h3 class="mt-3 mb-3"><?= usersCountByGroup(3) ?></h3>
					<p class="mb-0 text-muted">
						<!-- <span class="text-danger me-2"><i class="mdi mdi-arrow-down-bold"></i> 7.00%</span>-->
						
					</p>
				</div> <!-- end card-body-->
			</div> <!-- end card-->
		</div>
		<div class="col-lg-4">
			<div class="card widget-flat">
				<div class="card-body">
				
					<h5 class="text-muted fw-normal mt-0" title="Average Revenue">Investments Through Introducers</h5>
					<h3 class="mt-3 mb-3"><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format(totalInvestmentThroughIntroducers(), 2) ?></h3>
					<p class="mb-0 text-muted">
						<!-- <span class="text-danger me-2"><i class="mdi mdi-arrow-down-bold"></i> 7.00%</span>-->
					</p>
				</div> <!-- end card-body-->
			</div> <!-- end card-->
		</div>
		<div class="col-lg-4">
			<div class="card widget-flat">
				<div class="card-body">
					
					<h5 class="text-muted fw-normal mt-0" title="Average Revenue">Direct Investment Received</h5>
					<h3 class="mt-3 mb-3"><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format(totalDirectInvestment(), 2) ?></h3>
					<p class="mb-0 text-muted">
						<!-- <span class="text-danger me-2"><i class="mdi mdi-arrow-down-bold"></i> 7.00%</span>-->
					</p>
				</div> <!-- end card-body-->
			</div> <!-- end card-->
		</div>
            

    



</div>
<!-- container -->

</div>
<!-- content -->

<script src="assets/js/vendor/apexcharts.min.js"></script>
<script src="assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>

<script src="assets/js/pages/dashboard.js"></script>
<?= $this->endSection() ?>