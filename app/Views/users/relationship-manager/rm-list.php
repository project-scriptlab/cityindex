
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
                    <h4 class="header-title"><?= $title.' list'; ?><span>&nbsp;&nbsp;&nbsp;<a class="btn btn-dark btn-sm" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalAddNewRm"><i class="uil-plus"></i> Add</a></span></h4><br>
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
                            <?php if (!empty($rms)){ $i = 1; ?>
                                <?php 
                                    foreach ($rms as $rm){ ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $rm->name; ?></td>
                                        <td><?= $rm->email; ?></td>
                                        <td><?= $rm->phone; ?></td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" data-id="<?= $rm->id; ?>" class="btn btn-dark btn-sm btn-icon edit-rm" data-toggle="tooltip" title="Edit"><i class="uli uil-edit-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
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
<div class="modal fade" id="modalAddNewRm" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Add Relationship Manager</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('users/add-relationship-manager') ?>" id="form-add-rm">
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
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="mobile" placeholder="Enter phone number" class="form-control">
                            </div>
                        </div>
                    </div>
                    <?= csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-dark btn-new-rm" value="Save">
            </div>
        </div>
    </div>
</div>

<!-- edit admin modal -->
<div class="modal fade" id="modalEditRm" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Update Relationship Manager</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form action="" id="form-edit-rm">
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
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" id="mobile" name="mobile" placeholder="Enter phone number" class="form-control">
                            </div>
                        </div>
                    </div>
                    <?= csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-dark btn-update-rm" value="Update">
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>