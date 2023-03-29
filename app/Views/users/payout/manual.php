
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Payout</a></li>
                        <li class="breadcrumb-item active">Manual</li>
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
                    <div class="row">
                        <div class="col-md-9">
                            <h4 class="header-title">Generate payout report manually</h4>
                        </div>
                    </div>
                    <br>
                    
                    <form action="<?= site_url('report/generate-manual-payout'); ?>" class="formPayout">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Investment Id <span class="text-danger">*</span></label>
                                                <input type="number" min="0" class="form-control" name="investment_id" placeholder="Investment ID">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Processing Month & Year <span class="text-danger">*</span></label>
                                                <select class="js-example-basic-multiple form-control target_date" name="target_date">
                                                    <option value=""></option>
                                                    <?php if (!empty($filter)): ?>
                                                        <?php foreach ($filter as $filt): 
                                                            $dateObj   = \DateTime::createFromFormat('!m', $filt->curr_month);
                                                            $monthName = $dateObj->format('M');
                                                            ?>
                                                            <option value="<?= $filt->curr_month.'-'.$filt->curr_year ?>"><?= $monthName.', '.$filt->curr_year ?></option>
                                                        <?php endforeach ?>
                                                    <?php endif ?>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <?= csrf_field(); ?>
                                                <input type="submit" class="manual-generate btn btn-dark" value="Generate">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>

<!-- end row-->



<?= $this->endSection() ?>