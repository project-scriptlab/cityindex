
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Withdraw</a></li>
                        <li class="breadcrumb-item active">History</li>
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
                    <h4 class="header-title"><?= $title; ?></h4><br>
                    <table id="" class=" basicDatatable table table-centered table-bordered dt-responsive nowrap w-100">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Member Id</th>
                                <th>Investment Id</th>
                                <th>Inv Name</th>
                                <th>Investment Amount</th>
                                <th>Withdrawl Amount <i class="fa-solid fa-circle-question" data-toggle="tooltip" title="Total withdrawl amount"></i></th>
                                <th>Updated Amount <i class="fa-solid fa-circle-question" data-toggle="tooltip" title="Updated investment amount"></i></th>
                                <th class="text-center" width="50px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($withdrawls)): $i = 1; ?>
                                <?php foreach ($withdrawls as $wDraw): ?>
                                    <tr class="details">
                                        <td><?= $i++; ?></td>
                                        <td><?= $wDraw['member_id']; ?></td>
                                        <td><?= $wDraw['investment_id']; ?></td>
                                        <td><?= $wDraw['investor_name']; ?></td>
                                        <td><i class="fa-solid fa-indian-rupee-sign"></i><?= $wDraw['actual_investment_amount'] ?></td>
                                        <td><i class="fa-solid fa-indian-rupee-sign"></i><?= $wDraw['total_withdrawl_amount']; ?></td>
                                        <td><i class="fa-solid fa-indian-rupee-sign"></i><?= $wDraw['updated_investment_amount']; ?></td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" data-visible="0" class="badge badge-info-lighten p-1 withdraw-details" data-id="<?= $wDraw['investment_id']; ?>">Details</a>
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


<!-- Withdrawl Details modal -->
<div class="modal fade" id="withdrawlDetailsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Withdrawal Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body detailsContainer">
                ...
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- end row-->



<?= $this->endSection() ?>