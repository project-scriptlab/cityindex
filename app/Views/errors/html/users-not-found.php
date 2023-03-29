
<?= $this->extend('layOut'); ?>
<?= $this->section('body') ?>
<style>
    div .card-body {
            align-items: center;
            display: flex;
            flex-direction: column;
            height: 80vh;
            justify-content: center;
            text-align: center;
        }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center text-muted">
                    <h3>Users Not Found!</h3>
                    <a href="<?= site_url('dashboard') ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-arrow-left"></i> Back</a>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>
<?= $this->endSection() ?>