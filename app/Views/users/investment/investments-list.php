
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
                        <li class="breadcrumb-item active">Investments</li>
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
                        <div class="col-md-5 col-lg-5 col-sm-12">
                            <h4 class="header-title"><?= $title.' list'; ?>
                            <span>&nbsp;&nbsp;&nbsp;
                                <a class="btn btn-dark btn-sm" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#new-investment"><i class="uil-plus"></i> New</a> 
                                <?php if (!empty($investments)): ?>
                                    <a class="btn btn-primary btn-sm" href="<?= site_url('exporter/investments') ?><?= $filteId?'/'.$filteId:'/0' ?><?= ($monthNum && $year)?"/$monthNum/$year":'/0/0' ?>"><i class="fa-solid fa-upload"></i> Export</a>
                                <?php endif ?>
                                
                            </span>
                        </h4>
                    </div>
                    <div class="col-md-7 col-lg-7 col-sm-12">
                        <form action="<?= site_url('users/investment-list') ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="input-group input-group-sm">
                                <select class="form-control" name="month" aria-describedby="inputGroup-sizing-sm">
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
                                <select class="form-control" name="year" aria-describedby="inputGroup-sizing-sm">
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
                                <select class="form-control" id="select2InvestmentFilter" name="investor" aria-describedby="inputGroup-sizing-sm" style="width: 30%;">
                                    <option value="">Select Investor</option>
                                    <?php if (!empty($users)): ?>
                                        <?php foreach ($users as $user): ?>
                                            <option <?= ($filteId == $user->id)?'selected':''; ?> value="<?= $user->id ?>"><?= ucfirst(strtolower($user->name)).' ( '.$user->member_id.' )' ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                                <button class="btn btn-dark btn-sm btn-icon">GO</button>
                                <button class="btn btn-danger btn-sm btn-icon investmentReset">RESET</button>
                            </div>
                        </form>
                    </div>
                </div><br>
                <table id="" class=" basicDatatable table table-centered table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th width="35px">#</th>
                            <th width="50px">Investment Id</th>
                            <th width="20%">Investor Name</th>
                            <th width="20%">Introducer Name</th>
                            <th width="90px">Date <i class="fa-solid fa-circle-question" data-toggle="tooltip" title="Investment Date"></i></th>
                            <th width="200px">Inv Amount <i class="fa-solid fa-circle-question" data-toggle="tooltip" title="Investment Amount"></i></th>
                            <th width="200px">Curr Amount <i class="fa-solid fa-circle-question" data-toggle="tooltip" title="Current Amount"></i></th>
                            <th>TDS%</th>
                            <th>Other Charges</th>
                            <th>Interest</th>
                            <th>Commission <i class=" text-dark fa-solid fa-circle-question" data-toggle="tooltip" title="Introducer Commission"></i></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($investments)): $i = 1; ?>
                            <?php foreach ($investments as $investment): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $investment->id; ?></td>
                                    <td><?= $investment->investor_name.' ('.$investment->investorMemberId.')'; ?><?= $investment->status?'<i class="fa-solid fa-circle blink" style="color: #08ff08;" data-toggle="tooltip" title="Active"></i>':'<i class="fa-solid fa-circle blink" style="color: red;" data-toggle="tooltip" title="Inactive"></i>'; ?></td>
                                    <td><?= $investment->introducer_name?$investment->introducer_name.' ('.$investment->introMemberId.')':'NA'; ?></td>
                                    <td><?= date('M j, Y', $investment->created_at) ?></td>
                                    <td><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format($investment->investment_amount, 2); ?></td>
                                    <td><i class="fa-solid fa-indian-rupee-sign"></i> <?= number_format($investment->updated_investment_amount, 2); ?></td>
                                    <td><?= $investment->tds ?><i class="fa-solid fa-percent"></i></td>
                                    <td><i class="fa-solid fa-indian-rupee-sign"></i> <?= $investment->other_charges ?></td>
                                    <td><?= $investment->interest.' ' ?><i class="fa-solid fa-percent"></i></td>
                                    <td><?= $investment->introducer_commission.' ' ?><i class="fa-solid fa-percent"></i></td>
                                    <td>
                                        <?php if ($investment->status): ?>
                                            <a href="javascript:void(0)" class="badge badge-success-lighten p-1 withdraw-details activeInactive" data-val="0" data-id="<?= $investment->id; ?>" data-toggle="tooltip" title="Click to Inactive">Active</a>
                                        <?php else: ?>
                                            <a href="javascript:void(0)" class="badge badge-danger-lighten p-1 withdraw-details activeInactive" data-val="1" data-id="<?= $investment->id; ?>" data-toggle="tooltip" title="Click to Active">Inactive</a>
                                        <?php endif ?>
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

<!-- new investment modal -->

<div id="new-investment" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <a href="javascript:void(0)" class="text-success">
                        <span><img src="<?= site_url(); ?>assets/images/eqsis_logo.png" alt="" width="90"></span>
                    </a>
                </div>

                <form action="<?= site_url('users/add-new-investment/') ?><?= (!empty($filteId))?$filteId:'' ?>" id="form_investment">
                   <?php if (empty($filteId)): ?>
                     <div class="mb-3">
                        <label class="form-label">Select Investor.</label>
                        <select class="js-example-basic-multiple form-control" id="select2StartInvestment">
                            <option value=""></option>
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <option <?= ($filteId == $user->id)?'selected':''; ?> value="<?= $user->id ?>"><?= $user->name.' ( '.$user->id.' )' ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>                
                <?php endif ?>
                <input type="hidden" name="introducer" value="<?= (!empty($details))?$details->introducer_id:'' ?>">
                <div class="mb-3">
                    <label class="form-label">Investor's A/C No.</label>
                    <input class="form-control" type="number" min="0" readonly name="account_number" placeholder="Enter account number" value="<?= (!empty($details))?$details->account_number:'' ?>">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Introducer Commission <span class="text-dark">(%)</span></label>
                            <input class="form-control" type="number" min="0" value="0" name="commission" placeholder="Enter introducer commission" value="<?= (!empty($details))?number_format($details->introducer_commission):''; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Interest <span class="text-dark">(%)</span></label>
                            <input class="form-control" type="number" min="0" value="0" name="interest" placeholder="Enter interest">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Investment Amount</label>
                            <input class="form-control" type="number" min="0" name="investment_amount" placeholder="Enter amount" value="">
                        </div>
                    </div> 

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Investment Date</label>
                            <input class="form-control" type="text" id="investmentDatePicker" name="investment_date" placeholder="Select date of investment" value="">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">TDS <span class="text-dark">(%)</span></label>
                            <input class="form-control" type="number" min="0"  name="tds" placeholder="Enter tds percentage" value="0">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                     <div class="mb-3">
                        <label class="form-label">Other Charges <small>( In amount. )</small></label>
                        <input class="form-control" type="number" min="0"  name="other_charges" placeholder="Enter other charges" value="0">
                    </div>
                </div>
                <div class="col-md-6">
                 <div class="mb-3">
                    <label class="form-label">Reason</label>
                    <input class="form-control" type="text" name="reason_other_charges" placeholder="Enter reason of other charges" value="Other Charges">
                </div>
            </div>
        </div>
        <?= csrf_field(); ?>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-dark btn-add-investment">Add</button>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- end row-->


<script src="<?= site_url(); ?>assets/js/pages/investment.js"></script>
<?= $this->endSection() ?>