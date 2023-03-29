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
						<li class="breadcrumb-item active">Add Investor</li>
					</ol>
				</div>
				<h4 class="page-title"><?= $title; ?></h4>
			</div>
		</div>
	</div>     
	<!-- end page title --> 

	<form action="<?= site_url('users/update-investor/'.$details->id); ?>" class="formSubmit">

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Personal Details</h4><hr>
						<br>
						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label">Full Name</label>
								<input type="text" class="form-control" name="full_name" placeholder="Enter name" value="<?= $details->name; ?>">
							</div>

							<div class="col-md-6">
								<label class="form-label">Email</label>
								<input type="text" class="form-control" name="email" placeholder="Enter email" value="<?= $details->email; ?>">
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label">Username</label>
								<input type="text" class="form-control" name="username" placeholder="Enter username" value="<?= $details->user_name; ?>">
							</div>

							<div class="col-md-6">
								<label class="form-label">Mobile</label>
								<input type="text" class="form-control" name="mobile" placeholder="Enter mobile" value="<?= $details->mobile; ?>">
							</div>
						</div>

						<div class="mb-3">
							<label class="form-label">Address</label>
							<textarea name="address" class="form-control" placeholder="Enter address" rows="3"><?= $details->address; ?></textarea>
						</div>

						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label">Password  <span class="text-dark" data-toggle="tooltip" title="If you do not want to change password, leave this field blank."><i class="mdi mdi-comment-question"></i></span></label>
								<input type="text" class="form-control" name="password" placeholder="Enter password">
							</div>

							<div class="col-md-6">
								<label class="form-label">Confirm Password  <span class="text-dark" data-toggle="tooltip" title="If you do not want to change password, leave this field blank."><i class="mdi mdi-comment-question"></i></span></label>
								<input type="text" class="form-control" name="confirm_pwd" placeholder="Enter confirm password">
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
								<input type="text" class="form-control" name="bank_name" placeholder="Enter bank name" value="<?= $details->bank_name; ?>">
							</div>

							<div class="col-md-6">
								<label class="form-label">Bank Branch</label>
								<input type="text" class="form-control" name="branch_name" placeholder="Enter branch name" value="<?= $details->branch_name; ?>">
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label">Account Number</label>
								<input type="number" min="0" class="form-control" name="account_number" placeholder="Enter account number" value="<?= $details->account_number; ?>">
							</div>

							<div class="col-md-6">
								<label class="form-label">Confirm Account Number</label>
								<input type="number" min="0" class="form-control" name="confirm_account_number" placeholder="Enter confirm account number" value="<?= $details->account_number; ?>">
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-md-12">
								<label class="form-label">IFSC Code</label>
								<input type="text" class="form-control" name="ifsc_code" placeholder="Enter IFSC code" value="<?= $details->ifsc_code ?>">
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
											<option <?= ($details->rm_name == $rm->name)?'selected':'' ?> value="<?= $rm->name ?>"><?= $rm->name ?></option>
										<?php endforeach ?>
									<?php endif ?>
								</select>
							</div>

							<div class="col-md-6">
								<label class="form-label">Meeting Date</label>
								<input type="input" class="form-control singleDatePicker" name="rm_meeting_date" placeholder="Meeting Date" value="<?= ($details->rm_meeting_date)?date('Y-m-d', $details->rm_meeting_date):'' ?>">
							</div>

						</div>

						<div class="row mb-3">
							<div class="col-md-12">
								<label class="form-label">Discussion Points</label>
								<div id="bubble-editor" class="rm_discussion_points" style="height: 300px;">
									<?= $details->rm_discussion_points ?>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 text-right">
								<?= csrf_field(); ?>
								<input type="submit" class="submit btn btn-dark" value="Update">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</form>
</div>
<script src="<?= site_url(); ?>assets/js/pages/quill.bubble-editor.js"></script>

<?= $this->endSection(); ?>