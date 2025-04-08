<?php require_once 'includes/header.php'; ?>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-4">
            <h1 class="my-4">Dashboard</h1>
        </div>
        <div class="col-md-8 d-flex justify-content-end align-items-center">

        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            <?php echo date("F"); ?> Income Statement
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Comment</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Comment</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</div>
<?php require_once 'includes/modal.php'; ?>
<?php require_once 'includes/footer.php'; ?>