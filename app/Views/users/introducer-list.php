
<?= $this->extend('layOut'); ?>
<?= $this->section('body') ?>
<div class="container-fluid">
    <?= csrf_field(); ?>
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                        <li class="breadcrumb-item active">Admins</li>
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
                    <h4 class="header-title"><?= $title.' list'; ?><span>&nbsp;&nbsp;&nbsp;<a class="btn btn-dark btn-sm" href="<?= base_url('users/create-introducer') ?>"><i class="uil-plus"></i> Add</a> 
                        <?php if (!empty($users)): ?>
                            <a class="btn btn-primary btn-sm" href="<?= base_url('exporter/introducer') ?>"><i class="fa-solid fa-upload"></i> Export</a>
                        <?php endif ?>
                        </span></h4>
                    <br>
                    <div class="table-responsive">
                        <table id="" class=" basicDatatable table table-centered table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>M. Id <i class="uil-question-circle" data-toggle="tooltip" title="Membership ID"></i></th>
                                    <th>Name</th>
                                    <th>E-mail</th>
                                    <th>Mobile</th>
                                    <th class="text-center" width="50px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)): $i = 1; ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $user->member_id; ?></td>
                                            <td><?= $user->name; ?></td>
                                            <td><?= $user->email; ?></td>
                                            <td><?= $user->mobile; ?></td>
                                            <td class="text-center">
                                                <a href="<?= site_url('users/details/').$user->member_id ?>" class="btn btn-primary btn-sm btn-icon" data-toggle="tooltip" title="Profile Details"><i class="fa-regular fa-user"></i></a>
                                                <a href="<?= site_url('users/get-user-by-id/').$user->id ?>" class="btn btn-dark btn-sm btn-icon" data-toggle="tooltip" title="Edit"><i class="uli uil-edit-alt"></i></a>
                                                <?php if ($user->active == 1): ?>
                                                    <a href="<?= site_url('users/change-status/0/').$user->id; ?>" class="btn btn-success btn-sm btn-icon" data-toggle="tooltip" title="Click to inactive"><i class="uli  uil-toggle-on"></i></a>
                                                <?php else: ?>
                                                    <a href="<?= site_url('users/change-status/1/').$user->id; ?>" class="btn btn-secondary btn-sm btn-icon" data-toggle="tooltip" title="Click to active"><i class="uli uil-toggle-off"></i></a>
                                                <?php endif ?>
                                                 <a href="javascript:void(0)" data-delete="<?= $user->id; ?>" class="btn btn-secondary btn-sm btn-icon change-password" data-toggle="tooltip" title="Change Password"><i class="fa-solid fa-shield-blank"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table> 
                    </div>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>

<!-- end row-->



<?= $this->endSection() ?>