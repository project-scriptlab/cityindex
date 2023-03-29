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
                        <li class="breadcrumb-item active">Interest</li>
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
                            <h4 class="header-title">Monthly interest of <?= $monthName.', '.$year; ?>
                            &nbsp;&nbsp;&nbsp; <?php if (!empty($interests)): ?>
                            <span><a class="btn btn-primary btn-sm" href="<?= base_url('exporter/monthly-interest/'.$monthNum.'/'.$year) ?>"><i class="fa-solid fa-upload"></i> Export</a></span>
                        <?php endif ?>
                    </h4>
                </div>
                <div class="col-md-5">
                    <form action="<?= site_url('payout/monthly-interest') ?>" method="post">
                        <?= csrf_field(); ?>
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
                            <th>Investor Name</th>
                            <th>Amount <i class="fa-solid fa-circle-question" data-toggle="tooltip" title="Investment Amount"></i></th>
                           
                            <th>Days <i class="fa-solid fa-circle-question" data-toggle="tooltip" title="Total Days"></i></th>
                            <th>Total <i class="fa-solid fa-circle-question" data-toggle="tooltip" title="Total Interest"></i></th>
                            <th>TDS% <i class="fa-solid fa-circle-question" data-toggle="tooltip" title="TDS Percentage"></i></th>
                            <th>TDS Charges</th>
                            <th data-visible="false">Month Amount</th>
							<th>Other Charges</th>
							<th>Int%
								<i class="fa-solid fa-circle-question" data-toggle="tooltip" title="Interest Percentage"></i></th>
							<th>Interest Per Day</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($interests)): $i = 1; ?>
                            <?php foreach ($interests as $interest): $bank = unserialize($interest->bank_details);?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $interest->investment_id; ?></td>
                                    <td><?= $interest->investor_name; ?> <i class="fa-solid fa-circle-info" tabindex="0" data-bs-toggle="popover" title="Bank Details" data-bs-content="<?= !empty($interest->bank_details)?$bank->bank_name.'<br />A/C No. : '.$bank->account_number.'<br />IFSC : '.$bank->ifsc_code:'NA'; ?>" data-bs-html="true"></i></td>
                                    <td><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format($interest->investment_amount, 2); ?></td>
                                   
                                    <td><?= $interest->total_days; ?></td>
                                    <td><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format($interest->payble_interest, 2) ?></td>
                                    <td><?= $interest->tds_percentage; ?> <i class="fa-solid fa-percent"></i></td>
                                    <td><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format($interest->tds, 2) ?></td>
                                    <td><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format($interest->month_amount, 2) ?></td>
									<td>
										<i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format($interest->other_charges, 2) ?></td>
									<td><?= $interest->interest; ?>
										<i class="fa-solid fa-percent"></i></td>

									<td>
										<i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format($interest->per_day_interest, 2) ?></td>
										
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