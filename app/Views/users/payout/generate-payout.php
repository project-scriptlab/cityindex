
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
                        <li class="breadcrumb-item active">Monthly Payout</li>
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
                        <div class="col-md-12">
                            <h4 class="header-title">Generate monthly payout report</h4><hr>
                        </div>
                    </div>
                    <br>
                    
                    <form action="<?= site_url('report/generate-payout'); ?>" class="formMonthlyPayout">
                        <div class="row">
                            <div class="col-12">
                             <?= csrf_field(); ?>
                             <div class="row">
                                <div class="input-group">
                                    <select class="form-control" name="month">
                                        <option value="">Select Month</option>
                                        <?php
                                        $timestamp = strtotime('now');
                                        $curMonth = date('m', $timestamp) - 1;
                                        for ($i = 1; $i <= 12; $i++) {
                                            $time = strtotime(sprintf('%d months', $i));
                                            $selected = '';
                                            if ($i == $curMonth) {
                                                $selected = 'Selected';
                                            }
                                            echo '<option '.$selected.' value="'.date('n', $time).'">'.date('F', $time).'</option>'."\n";
                                        }
                                        ?>
                                    </select>
                                    <select class="form-control" name="year">
                                        <option value="">Select Year</option>
                                        <?php
                                        $timestamp = strtotime('now');
                                        $curyear = date('Y', $timestamp);
                                        for ($i = 2000; $i <= $curyear; $i++) {
                                            $selected = '';
                                            if ($curyear == $i) {
                                              $selected = 'Selected';  
                                          }
                                          echo '<option '.$selected.' value="'.$i.'">'.$i.'</option>'."\n";
                                      }
                                      ?>
                                  </select>
                                  <button class="btn btn-dark btn-sm btn-icon btnMonthlyPayout"> Generate </button>
                              </div>
                          </div>
                      </div>
                  </div>
              </form>

          </div> <!-- end card body-->
      </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row existingForm" style="display: none;" >
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="header-title custom-title"></h4><hr>
                    </div>
                </div>
                <br>
                <div class="row mb-3"><label for="">Total Commission : <span id="totsCommission"></span></label></div>
                <div class="row mb-3"><label for="">Total Interest : <span id="totsInterest"></span></label></div>
                <div class="row mb-3"><label for="">Total TDS Charges : <span id="totsTds"></span></label></div>
                <div class="row mb-3"><label for="">Total Other Charges : <span id="totsOther"></span></label></div>
                <div class="row mb-3"><label for="">Total Payble Interest : <span id="totsPaybleInterest"></span></label></div>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="javascript:void(0)" target="_blank" class="btn btn-dark" id="check_commission">Commission Details</a>
                    <a href="javascript:void(0)" target="_blank" class="btn btn-secondary" id="check_interest">Interest Details</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- end row-->



<?= $this->endSection() ?>