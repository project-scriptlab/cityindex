<?= $this->extend('layOut'); ?>
<?= $this->section('body') ?>

<div class="container-fluid">

	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
						<li class="breadcrumb-item active">Add Introducer</li>
					</ol>
				</div>
				<h4 class="page-title"><?= $title; ?></h4>
			</div>
		</div>
	</div>     
	<!-- end page title --> 

	<form action="<?= site_url('users/save-introducer'); ?>" class="formSubmit">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Personal Details</h4><hr>
						<br>
						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label">Full Name</label>
								<input type="text" class="form-control" name="full_name" id="name" placeholder="Enter name">
							</div>

							<div class="col-md-6">
								<label class="form-label">Email</label>
								<input type="text" class="form-control" name="email" placeholder="Enter email">
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label">Username</label>
								<input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
							</div>

							<div class="col-md-6">
								<label class="form-label">Mobile</label>
								<input type="text" class="form-control" name="mobile" placeholder="Enter mobile">
							</div>
						</div>

						<div class="mb-3">
							<label class="form-label">Address</label>
							<textarea name="address" class="form-control" placeholder="Enter address" rows="3"></textarea>
						</div>

						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label">Password</label>
								<input type="text" class="form-control" name="password" id="password" placeholder="Enter password">
							</div>

							<div class="col-md-6">
								<label class="form-label">Confirm Password</label>
								<input type="text" class="form-control" name="confirm_pwd" id="confirm_pwd" placeholder="Enter confirm password">
							</div>
						</div>
					</div> <!-- end card body-->
				</div> <!-- end card -->
			</div><!-- end col-->
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Bank Details</h4><hr>
						<br>

						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label">Bank Name</label>
								<input type="text" class="form-control" name="bank_name" placeholder="Enter bank name">
							</div>

							<div class="col-md-6">
								<label class="form-label">Bank Branch</label>
								<input type="text" class="form-control" name="branch_name" placeholder="Enter branch name">
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label">Account Number</label>
								<input type="text" class="form-control" name="account_number" placeholder="Enter account number">
							</div>

							<div class="col-md-6">
								<label class="form-label">Confirm Account Number</label>
								<input type="text" class="form-control" name="confirm_account_number" placeholder="Enter confirm account number">
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label">IFSC Code</label>
								<input type="text" class="form-control" name="ifsc_code" placeholder="Enter IFSC code">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Relationship Manager Details</h4><hr>
						<br>

						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label">RM Name</label>
								<select class="js-example-basic-multiple form-control select2" name="rm_name">
									<option value=""></option>
									<?php if (!empty($rms)): ?>
										<?php foreach ($rms as $rm): ?>
											<option value="<?= $rm->name ?>"><?= $rm->name ?></option>
										<?php endforeach ?>
									<?php endif ?>
								</select>
							</div>

							<div class="col-md-6">
								<label class="form-label">Meeting Date</label>
								<input type="input" class="form-control singleDatePicker" name="rm_meeting_date" placeholder="Meeting Date">
							</div>

						</div>

						<div class="row mb-3">
							<div class="col-md-12">
								<label class="form-label">Discussion Points</label>
								<div id="bubble-editor" class="rm_discussion_points" style="height: 300px;">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 text-right">
								<?= csrf_field(); ?>
								<input type="submit" disabled class="submit btn btn-dark" value="Save">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</form>
</div>
<script src="<?= site_url(); ?>assets/js/pages/quill.bubble-editor.js"></script>
<script src="<?= site_url(); ?>assets/js/pages/users.js"></script>
<?= $this->endSection(); ?>