<?php require_once 'includes/header.php'; ?>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-4">
            <h1 class="my-4">Dashboard</h1>
        </div>
        <div class="col-md-8 d-flex justify-content-end align-items-center">
            <!-- Button to open Add Income Modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addIncomeModal">Income</button>
            <!-- Button to open Add Expense Modal -->
            <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#addExpenseModal">Expense</button>
        </div>
    </div>
    <div class="row statistics">
        <div class="col">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="a-cal">Income</div>
                            <div class="text-lg fw-bold" id="current_month_income">$0</div>
                        </div>
                        <img class="dicon" src="assets/img/icon.png" />
                    </div>
                </div>
                <div class="card-footer"><?php echo date("F"); ?></div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="a-cal">Expense</div>
                            <div class="text-lg fw-bold" id="current_month_expense">$0</div>
                        </div>
                        <img class="dicon" src="assets/img/icon.png" />
                    </div>
                </div>
                <div class="card-footer"><?php echo date("F"); ?></div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="a-cal">Balance</div>
                            <div class="text-lg fw-bold" id="current_month_balance">$0</div>
                        </div>
                        <img class="dicon" src="assets/img/icon.png" />
                    </div>
                </div>
                <div class="card-footer"><?php echo date("F"); ?></div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="a-cal">Income</div>
                            <div class="text-lg fw-bold" id="last_month_income">$0</div>
                        </div>
                        <img class="dicon" src="assets/img/icon.png" />
                    </div>
                </div>
                <div class="card-footer"><?php echo date("F", strtotime('-1 month')); ?></div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="a-cal">Expense</div>
                            <div class="text-lg fw-bold" id="last_month_expense">$0</div>
                        </div>
                        <img class="dicon" src="assets/img/icon.png" />
                    </div>
                </div>
                <div class="card-footer"><?php echo date("F", strtotime('-1 month')); ?></div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="a-cal">Balance</div>
                            <div class="text-lg fw-bold" id="previous_month_balance">$0</div>
                        </div>
                        <img class="dicon" src="assets/img/icon.png" />
                    </div>
                </div>
                <div class="card-footer"><?php echo date("F", strtotime('-1 month')); ?></div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="a-cal">Income</div>
                            <div class="text-lg fw-bold" id="total_income">$0</div>
                        </div>
                        <img class="dicon" src="assets/img/icon.png" />
                    </div>
                </div>
                <div class="card-footer">Total Income</div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="a-cal">Expense</div>
                            <div class="text-lg fw-bold" id="total_expense">$0</div>
                        </div>
                        <img class="dicon" src="assets/img/icon.png" />
                    </div>
                </div>
                <div class="card-footer">Total Expense</div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="a-cal">Balance</div>
                            <div class="text-lg fw-bold" id="total_balance">$0</div>
                        </div>
                        <img class="dicon" src="assets/img/icon.png" />
                    </div>
                </div>
                <div class="card-footer">Total Balance</div>
            </div>
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
<div id="toastContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;"></div>
<?php require_once 'includes/modal.php'; ?>
<?php require_once 'includes/footer.php'; ?>