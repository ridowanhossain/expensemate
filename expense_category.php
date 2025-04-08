<?php require_once 'includes/header.php'; ?>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-4">
            <h1 class="my-4">Expense Categories</h1>
        </div>
        <div class="col-md-8 d-flex justify-content-end align-items-center">
            <!-- Button to open Add Expense Category Modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addExpenseCategoryModal">Add Expense Category</button>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Expense Categories
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover" id="expenseCategoryTable">
                <thead>
                    <tr>
                        <th>#</th> <!-- Row counter column -->
                        <th>ID</th>
                        <th>Name</th>
                        <th>Comment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th> <!-- Row counter column -->
                        <th>ID</th>
                        <th>Name</th>
                        <th>Comment</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Add Expense Category Modal -->
<div class="modal fade" id="addExpenseCategoryModal" tabindex="-1" aria-labelledby="addExpenseCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addExpenseCategoryForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExpenseCategoryModalLabel">Add Expense Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="expenseCategoryName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="expenseCategoryName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="expenseCategoryComment" class="form-label">Comment</label>
                        <textarea class="form-control" id="expenseCategoryComment" name="comment" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Expense Category Modal -->
<div class="modal fade" id="editExpenseCategoryModal" tabindex="-1" aria-labelledby="editExpenseCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editExpenseCategoryForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editExpenseCategoryModalLabel">Edit Expense Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editExpenseCategoryId" name="id">
                    <div class="mb-3">
                        <label for="editExpenseCategoryName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editExpenseCategoryName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editExpenseCategoryComment" class="form-label">Comment</label>
                        <textarea class="form-control" id="editExpenseCategoryComment" name="comment" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="toastContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;"></div>
<?php require_once 'includes/footer.php'; ?>
