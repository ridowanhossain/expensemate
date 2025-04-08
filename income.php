<?php require_once 'includes/header.php'; ?>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-4">
            <h1 class="my-4">Dashboard</h1>
        </div>
        <div class="col-md-8 d-flex justify-content-end align-items-center">
            <!-- Button to open Add Income Modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addIncomeModal">Income</button>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            <?php echo date("F"); ?> Income Statement
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="dateRangeFilter">Select Date for Filter:</label>
                <input type="text" id="dateRangeFilter" class="form-control" style="display:inline-block; width:240px;">
            </div>
            <table class="table table-bordered table-striped table-hover" id="incometablesSimple">
                <thead>
                    <tr>
                        <th>#</th> <!-- Row counter column -->
                        <th>Category</th> <!-- New column for category -->
                        <th>Comment</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th> <!-- Row counter column -->
                        <th>Category</th> <!-- New column for category -->
                        <th>Comment</th>
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

<div id="toastContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;"></div>
<?php require_once 'includes/modal.php'; ?>
<?php require_once 'includes/footer.php'; ?>
