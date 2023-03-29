
<?= $this->extend('layOut'); ?>
<?= $this->section('body') ?>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Payout</a></li>
                        <li class="breadcrumb-item active">Withdraw</li>
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
                            <h4 class="header-title">Withdraw amount from Investment</h4><hr>
                        </div>
                    </div>
                    <br>
                    <form action="<?= site_url('payout/proceed-withdraw') ?>" id="formWithdraw">
                        <div class="row"> 
                            <div class="col-md-6">
                                <label class="form-label" for="investment_id">Investment Id <span class="text-danger">*</span></label>
                                <div class="mb-3 position-relative input-group">
                                    <input type="text" min="0" class="form-control" name="investment_id" id="investment_id" placeholder="Enter  Investment ID">
                                    <input type="button" class="btn btn-dark btn-sm search-value" value="SERACH">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="investment_id">Investor Name </label>
                                <div class="mb-3 position-relative input-group">
                                    <input type="text" disabled class="form-control" id="investorName">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 position-relative ">
                                    <label class="form-label" for="date">Date <span class="text-danger">*</span></label>
                                    <input type="text"class="form-control" name="date" id="date" placeholder="Select Date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                   <label class="form-label">Available Investment Amount</label>
                                   <input type="number" min="0" class="form-control" name="total_amount" readonly>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 position-relative ">
                             <label class="form-label" for="Withdraw_amount">Withdraw Amount <span class="text-danger">*</span></label>
                             <input type="number" min="1" readonly class="form-control" name="withdraw_amount" id="withdraw_amount" placeholder="Enter withdraw amount">
                         </div>
                     </div>
                     <div class="col-md-6">
                        <div class="mb-3 position-relative ">
                            <label class="form-label">Remaining Amount</label>
                            <input type="number" class="form-control" name="remaining_amount" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 position-relative ">
                        <label for="" class="form-label">Reason <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control" placeholder="Enter reason of withdrawing." rows="3"></textarea>
                    </div>  
                </div>
                <?= csrf_field(); ?>
            </form>
            <div class="row">
                <div class="text-right">
                    <input type="submit" disabled value="Withdraw" class="btn btn-dark btnWithdraw">
                </div>
            </div>
        </div> <!-- end card body-->
    </div> <!-- end card -->
</div><!-- end col-->
</div>
</div>

<!-- end row-->


<script src="<?= site_url(); ?>assets/js/pages/withdraw.js"></script>

<?= $this->endSection() ?>