<?php require_once 'includes/header.php'; ?>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-4">
            <h1 class="my-4">Income Categories</h1>
        </div>
        <div class="col-md-8 d-flex justify-content-end align-items-center">
            <!-- Button to open Add Income Category Modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addIncomeCategoryModal">Add Income Category</button>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Income Categories
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover" id="incomeCategoryTable">
                <thead>
                    <tr>
                        <th>#</th> <!-- Row counter column -->
                        <th>Name</th>
                        <th>Comment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th> <!-- Row counter column -->
                        <th>Name</th>
                        <th>Comment</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Add Income Category Modal -->
<div class="modal fade" id="addIncomeCategoryModal" tabindex="-1" aria-labelledby="addIncomeCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addIncomeCategoryForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addIncomeCategoryModalLabel">Add Income Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="incomeCategoryName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="incomeCategoryName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="incomeCategoryComment" class="form-label">Comment</label>
                        <textarea class="form-control" id="incomeCategoryComment" name="comment" rows="3"></textarea>
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

<!-- Edit Income Category Modal -->
<div class="modal fade" id="editIncomeCategoryModal" tabindex="-1" aria-labelledby="editIncomeCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editIncomeCategoryForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editIncomeCategoryModalLabel">Edit Income Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editIncomeCategoryId" name="id">
                    <div class="mb-3">
                        <label for="editIncomeCategoryName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editIncomeCategoryName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editIncomeCategoryComment" class="form-label">Comment</label>
                        <textarea class="form-control" id="editIncomeCategoryComment" name="comment" rows="3"></textarea>
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
<div id="toastContainer" aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
</div>

<?php require_once 'includes/footer.php'; ?>
