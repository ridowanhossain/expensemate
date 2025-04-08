<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
// Suppress PHP warnings
error_reporting(0);
ini_set('display_errors', 0);
?>
<!-- Add Income Modal -->
<div class="modal fade" id="addIncomeModal" tabindex="-1" aria-labelledby="addIncomeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addIncomeModalLabel">Add Income</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="incomeForm">
                    <div class="mb-3">
                        <label for="incomeAmount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="incomeAmount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="incomeCategory" class="form-label">Category</label>
                        <select class="form-select" id="incomeCategory" name="category_id" required>
                            <option value="" disabled selected>Select a category</option>
                            <!-- Add category options dynamically -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="incomeComment" class="form-label">Comment</label>
                        <input type="text" class="form-control" id="incomeComment" name="comment" required>
                    </div>
                    <div class="mb-3">
                        <label for="incomeDate" class="form-label">Date</label>
                        <input type="text" class="form-control" id="incomeDate" name="date" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Income</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Expense Modal -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpenseModalLabel">Add Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="expenseForm">
                    <div class="mb-3">
                        <label for="expenseAmount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="expenseAmount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="expenseCategory" class="form-label">Category</label>
                        <select class="form-select" id="expenseCategory" name="category_id" required>
                            <option value="" disabled selected>Select a category</option>
                            <!-- Add category options dynamically -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="expenseComment" class="form-label">Comment</label>
                        <input type="text" class="form-control" id="expenseComment" name="comment" required>
                    </div>
                    <div class="mb-3">
                        <label for="expenseDate" class="form-label">Date</label>
                        <input type="text" class="form-control" id="expenseDate" name="date" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Expense</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editId" name="id">
                    <input type="hidden" id="editType" name="type">
                    <div class="mb-3">
                        <label for="editAmount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="editAmount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCategory" class="form-label">Category</label>
                        <select class="form-select" id="editCategory" name="category_id" required>
                            <option value="" disabled selected>Select a category</option>
                            <!-- Add category options dynamically -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editComment" class="form-label">Comment</label>
                        <input type="text" class="form-control" id="editComment" name="comment" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDate" class="form-label">Date</label>
                        <input type="text" class="form-control editDate" id="editDate" name="date" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="toastContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;"></div>
