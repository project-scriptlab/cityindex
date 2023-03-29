
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
                    <h4 class="header-title">ADD Documents</h4><hr>
                    <form action="<?= site_url('users/upload-docs/') ?><?= $id ?>" id="formInvestorDocuments">
                        <?= csrf_field(); ?>
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <label class="form-label">Select Document</label>
                                <div class="input-group">
                                    <input class="form-control" type="file" name="documents[]">
                                    <input type="text" class="form-control document_title" name="document_title[]" placeholder="Enter document title">
                                    <a href="javascript:void(0)" class="btn btn-info btn-icon btn-sm add-more-file-input"><i class="fa-solid fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row text-right">
                        <div class="col-md-12 ">
                            <input type="submit" value="Upload" class="btn btn-dark upload-investor-docs">
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
                    <h4 class="header-title">Documents <span><?= !empty($documents)?'<a href="'.site_url('exporter/download-all-documents/').$id.'" class="btn btn-info btn-sm btn-icon" data-toggle="tooltip" title="Download All" ><i class="fa-solid fa-download"></i></a>':''; ?></span></h4><br>
                    <table id="" class=" table table-centered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th width="75px">#</th>
                                <th>Title</th>
                                <th class="text-center" width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($documents)): $i = 1; ?>
                                <?php foreach ($documents as $document): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $document->title; ?></td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-icon delete-doc" data-delete="<?= $document->id ?>" data-toggle="tooltip" title="Delete"><i class="uli uil-trash-alt"></i></a>
                                            <a href="<?= site_url('upload/documents/').$document->file; ?>" download class="btn btn-success btn-sm btn-icon" data-delete="<?= $document->id ?>" data-toggle="tooltip" title="Download"><i class="fa-solid fa-download"></i></a>
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


<script src="<?= site_url(); ?>assets/js/pages/investor-docs.js"></script>
<?= $this->endSection() ?>