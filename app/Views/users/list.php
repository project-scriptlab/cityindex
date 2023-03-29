
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
                    <h4 class="header-title"><?= $title.' list'; ?><span>&nbsp;&nbsp;&nbsp;<a class="btn btn-dark btn-sm" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalAddNewAdmin"><i class="uil-plus"></i> Add</a></span></h4><br>
                    <table id="" class=" basicDatatable table table-centered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th width="40%">Name</th>
                                <th>E-mail</th>
                                <th width="50px">Mobile</th>
                                <th width="50px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)): $i = 1; ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $user->name; ?></td>
                                        <td><?= $user->email; ?></td>
                                        <td><?= $user->mobile; ?></td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" data-id="<?= $user->id; ?>" class="btn btn-dark btn-sm btn-icon edit-admin" data-toggle="tooltip" title="Edit"><i class="uli uil-edit-alt"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-icon delete-user" data-delete="<?= $user->id ?>" data-toggle="tooltip" title="Delete"><i class="uli uil-trash-alt"></i></a>
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

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>

<!-- end row-->

<!-- modal for adding new ADMIN -->
<!-- Center modal -->
<div class="modal fade" id="modalAddNewAdmin" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Add Admin</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('users/add-admin') ?>" id="form-add-admin">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" placeholder="Enter name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">E-Mail</label>
                                <input type="text" name="email" placeholder="Enter mail id" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">User Name</label>
                                        <input type="text" name="username" placeholder="Enter user name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="mobile" placeholder="Enter phone number" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                       <label class="form-label">Password</label>
                                       <input type="text" class="form-control" name="password" placeholder="Enter password">
                                   </div>
                               </div>
                               <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <input type="text" class="form-control" name="confirm_pwd" placeholder="Enter confirm password">
                                        <?= csrf_field(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
             </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-dark btn-new-admin" value="Save">
            </div>
        </div>
    </div>
</div>

<!-- edit admin modal -->
<div class="modal fade" id="modalEditAdmin" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Update Admin</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form action="" id="form-edit-admin">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" id="name" name="name" placeholder="Enter name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">E-Mail</label>
                                <input type="text" id="email" name="email" placeholder="Enter mail id" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">User Name</label>
                                        <input type="text" id="username" name="username" placeholder="Enter user name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="text" id="mobile" name="mobile" placeholder="Enter phone number" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                       <label class="form-label">Password <span class="text-dark" data-toggle="tooltip" title="If you do not want to change password, leave this field blank."><i class="mdi mdi-comment-question"></i></span></label>
                                       <input id="password" type="text" class="form-control" name="password" placeholder="Enter password">
                                   </div>
                               </div>
                               <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password <span class="text-dark" data-toggle="tooltip" title="If you do not want to change password, leave this field blank."><i class="mdi mdi-comment-question"></i></span></label>
                                        <input id="confirm_password" type="text" class="form-control" name="confirm_pwd" placeholder="Enter confirm password">
                                        <?= csrf_field(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
             </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-dark btn-update-admin" value="Update">
            </div>
        </div>
    </div>
</div>




<?= $this->endSection() ?>