<?= $this->extend('layOut'); ?>
<?= $this->section('body') ?>
<?php helper("custom"); ?>

<div class="container-fluid">

	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item">
							<a href="javascript: void(0);">Users</a></li>
							<li class="breadcrumb-item active"><?= $title; ?></li>
						</ol>
					</div>
					<h4 class="page-title"><?= $head_title; ?></h4>
				</div>
			</div>
		</div>
		<!-- end page title -->

		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-6">
						<div class="card">
							<div class="card-body">
								<h4 class="header-title text-center">Personal Details</h4><hr>

								<table class="table table-striped">
									<tr>
										<td>Membership Id</td>
										<td>:</td>
										<td><?= $details->member_id; ?></td>
									</tr>
									<tr>
										<td>Name</td>
										<td>:</td>
										<td><?= $details->name; ?></td>
									</tr>
									<tr>
										<td>User Name</td>
										<td>:</td>
										<td><?= $details->user_name; ?></td>
									</tr>
									<tr>
										<td>Mobile</td>
										<td>:</td>
										<td><a href="tel:<?= $details->mobile; ?>"><?= $details->mobile; ?></a></td>
									</tr>
									<tr>
										<td>E-Mail</td>
										<td>:</td>
										<td><a href="mailto:<?= $details->email; ?>"><?= $details->email; ?></a></td>
									</tr>
									<tr>
										<td>Address</td>
										<td>:</td>
										<td><?= $details->address; ?></td>
									</tr>
									<tr>
										<td>Investors <i class="fa-solid fa-circle-question" data-toggle="tooltip" title="Number of investor introduced."></i></td>
										<td>:</td>
										<td><?= totalInvestorIntroduced($details->id); ?></td>
									</tr>
									<tr>
										<td>Commision</td>
										<td>:</td>
										<td><?= number_format($details->introducer_commission); ?> <i class="fa-solid fa-percent"></i></td>
									</tr>
									<tr>
										<td>Amount Received <i class="fa-solid fa-circle-question" data-toggle="tooltip" title="Total amount received from investors."></i></td>
										<td>:</td>
										<td><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format(totalInvestmentAmount(2, $details->id)); ?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>

					<div class="col-6">
						<div class="card">
							<div class="card-body">
								<h4 class="header-title text-center">Bank Details</h4><hr>
								<table class="table table-striped">
									<tr>
										<td>Bank Name</td>
										<td>:</td>
										<td><?= $details->bank_name; ?></td>
									</tr>
									<tr>
										<td>Branch</td>
										<td>:</td>
										<td><?= $details->branch_name; ?></td>
									</tr>
									<tr>
										<td>A/C No</td>
										<td>:</td>
										<td><?= $details->account_number; ?></td>
									</tr>
									<tr>
										<td>IFSC Code</td>
										<td>:</td>
										<td><?= $details->ifsc_code; ?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>

					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<h4 class="header-title text-center">Relationship Manager Details</h4><hr>
								<table class="table table-striped">
									<tr>
										<td>Relationship Manager</td>
										<td>:</td>
										<td><?= $details->rm_name; ?></td>
									</tr>
									<tr>
										<td>Meeting Date</td>
										<td>:</td>
										<td><?= $details->rm_meeting_date?date('M j, Y', $details->rm_meeting_date):''; ?></td>
									</tr>
									<tr>
										<td>Discussion Points</td>
										<td>:</td>
										<td><?= $details->rm_discussion_points; ?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		
	</div>
	<?= $this->endSection() ?>