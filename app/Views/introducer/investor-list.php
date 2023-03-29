
<?= $this->extend('introducer/introducerLayOut'); ?>
<?= $this->section('body') ?>

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
					<h4 class="page-title"><?= $title; ?></h4>
				</div>
			</div>
		</div>
		<!-- end page title -->


		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">

						<table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
							<thead>
								<tr>
									<th width="35px">#</th>
									<th width="50px">Investor Id</th>
									<th width="40%">Name <i class=" text-dark fa-solid fa-circle-question" data-toggle="tooltip" title="Investor Name"></i></th>
									<th>Investment Amount</th>
									<th>Commission <i class=" text-dark fa-solid fa-circle-question" data-toggle="tooltip" title="Introducer Commission"></i></th>
									<th width="90px">Date <i class=" text-dark fa-solid fa-circle-question" data-toggle="tooltip" title="Investment Date"></i></th>						
								</tr>
							</thead>


							<tbody>
								<?php if (!empty($payments)): $i = 1?>
									<?php foreach ($payments as $payment): ?>
										<tr>
											<td><?= $i++; ?></td>
											<td><?= $payment->investor_member_id ?></td>
											<td><?= ucfirst($payment->investor_name) ?></td>
											<td><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format($payment->investment_amount) ?></td>
											<td><?= $payment->introducer_commission.' ' ?><i class="fa-solid fa-percent"></i></td>
											<td><?= date('M j, Y', $payment->created_at) ?></td>
										</tr>
									<?php endforeach ?>
								<?php endif ?>
							</tbody>
						</table>

					</div> <!-- end card body-->
				</div> <!-- end card -->
			</div><!-- end col-->
		</div>
	</div>
	<?= $this->endSection() ?>