
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
                        <li class="breadcrumb-item active">Commission</li>
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
                        <div class="col-md-7">
                            <h4 class="header-title">Monthly commission of <?= $monthName.', '.$year; ?>&nbsp;&nbsp;&nbsp; <?php if (!empty($commissions)): ?>
                            <span><a class="btn btn-primary btn-sm" href="<?= base_url('exporter/monthly-commission/'.$monthNum.'/'.$year) ?>"><i class="fa-solid fa-upload"></i> Export</a></span>
                            <?php endif ?></h4>
                        </div>
                        <div class="col-md-5">
                            <form action="<?= site_url('payout/monthly-commission') ?>" method="post">
                                <?= csrf_field(); ?>
                                <div class="row">
                                    <div class="input-group">
                                        <select class="form-control" name="month">
                                            <option value="">Select Month</option>
                                            <?php
                                            for ($i = 1; $i <= 12; $i++) {
                                                $time = strtotime(sprintf('%d months', $i));
                                                $selected = '';
                                                if ($monthNum == date('n', $time)) {
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
                                                if ($year == $i) {
                                                    $selected = 'Selected';
                                                }
                                                echo '<option '.$selected.' value="'.$i.'">'.$i.'</option>'."\n";
                                            }
                                            ?>
                                        </select>
                                        <button class="btn btn-dark btn-sm btn-icon">GO</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <br>
                    <div class="table-responsive">
                        <table id="" class=" basicDatatable table table-centered table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Investment Id</th>
                                    <th>Introducer Name</th>
                                    <th>Investor Name</th>
                                    <th>Amount</th>
                                    <th>Comm % <i class="fa-solid fa-circle-question" data-toggle="tooltip" title="Commission Percentage"></i></th>
                                    <th>Commission/P <i class="fa-solid fa-circle-question" data-toggle="tooltip" title="Per Day Commission"></i></th>
                                    <th>Days <i class="fa-solid fa-circle-question" data-toggle="tooltip" title="Total Days"></i></th>
                                    <th>Total <i class="fa-solid fa-circle-question" data-toggle="tooltip" title="Total Commission"></i></th>
                                    <th data-visible="false">Month Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($commissions)): $i = 1; ?>
                                    <?php foreach ($commissions as $commission): $bank = unserialize($commission->bank_details); ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $commission->investment_id; ?></td>
                                            <td><?= $commission->intro_name; ?> <i class="fa-solid fa-circle-info" tabindex="0" data-bs-toggle="popover" title="Bank Details" data-bs-content="<?= !empty($bank)?$bank->bank_name.'<br />A/C No. : '.$bank->account_number.'<br />IFSC : '.$bank->ifsc_code:'NA'; ?>" data-bs-html="true"></i></td>
                                            <td><?= $commission->investor_name; ?></td>
                                            <td><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format($commission->investment_amount, 2); ?></td>
                                            <td><?= $commission->commission; ?> <i class="fa-solid fa-percent"></i></td>
                                            <td><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format($commission->per_day_commission, 2); ?></td>
                                            <td><?= $commission->total_days; ?></td>
                                            <td><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format($commission->total_commission, 2); ?></td>
                                            <td><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format($commission->month_amount, 2); ?></td>
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