<?php
session_start();
// Include database connection
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ledger Table</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Custom CSS -->
</head>

<body>
    <!-- Button to open Add Income Modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIncomeModal">
        Add Income
    </button>

    <!-- Button to open Add Expense Modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
        Add Expense
    </button>


    <div class="container mt-5">
        <!-- Statistics -->
        <div class="container mt-5">
            <!-- Statistics -->
            <h2>Ledger Table</h2>
            <div>
                <h3>Today's Income</h3>
                <p id="current_month_income">0</p>
            </div>

            <div>
                <h3>Today's Expense</h3>
                <p id="current_month_expense">0</p>
            </div>

            <div>
                <h3>This Month's Balance</h3>
                <p id="current_month_balance">0</p>
            </div>

            <div>
                <h3>Previous Month's Balance</h3>
                <p id="previous_month_balance">0</p>
            </div>

            <div>
                <h3>Total Income</h3>
                <p id="total_income">0</p>
            </div>

            <div>
                <h3>Total Expense</h3>
                <p id="total_expense">0</p>
            </div>

            <div>
                <h3>Total Balance</h3>
                <p id="total_balance">0</p>
            </div>


        </div>
        <h2>Ledger Table</h2>
        <table class="table table-bordered table-hover" id="datatablesSimple">
            <thead>
                <tr>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
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
                            <input type="number" class="form-control" id="incomeAmount" name="amount" required>
                        </div>
                        <div class="mb-3">
                            <label for="incomeComment" class="form-label">Comment</label>
                            <input type="text" class="form-control" id="incomeComment" name="comment" required>
                        </div>
                        <div class="mb-3">
                            <label for="incomeDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="incomeDate" name="date" required>
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
                            <input type="number" class="form-control" id="expenseAmount" name="amount" required>
                        </div>
                        <div class="mb-3">
                            <label for="expenseComment" class="form-label">Comment</label>
                            <input type="text" class="form-control" id="expenseComment" name="comment" required>
                        </div>
                        <div class="mb-3">
                            <label for="expenseDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="expenseDate" name="date" required>
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
                            <label for="editComment" class="form-label">Comment</label>
                            <input type="text" class="form-control" id="editComment" name="comment" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="editDate" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAmount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="editAmount" name="amount" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            const table = $('#datatablesSimple').DataTable({
                ajax: {
                    url: 'fetch_ledger.php', // This same PHP file for AJAX request
                    type: 'POST',
                    data: {
                        action: 'fetch_ledger'
                    },
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'comment'
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'type'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                paging: true,
                searching: true,
                order: [
                    [1, 'desc']
                ],
                responsive: true
            });


            // Open Edit Modal
            $('#datatablesSimple').on('click', '.edit-btn', function() {
                const data = $(this).data();
                $('#editId').val(data.id);
                $('#editType').val(data.type);
                $('#editComment').val(data.comment);
                $('#editDate').val(data.date);
                $('#editAmount').val(data.amount);
                $('#editModal').modal('show');
            });

            // Save Changes (for editing)
            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                $.post('fetch_ledger.php', {
                    action: 'update_entry',
                    id: $('#editId').val(),
                    type: $('#editType').val(),
                    comment: $('#editComment').val(),
                    date: $('#editDate').val(),
                    amount: $('#editAmount').val()
                }, function(response) {
                    if (response.status === 'success') {
                        $('#editModal').modal('hide');
                        alert(response.message);

                        // Reload the table and statistics
                        table.ajax.reload(); // Reload the DataTable
                        fetchStatistics(); // Reload the statistics

                    } else {
                        alert(response.message);
                    }
                }, 'json');
            });

            // Delete Entry
            $('#datatablesSimple').on('click', '.delete-btn', function() {
                if (confirm('Are you sure you want to delete this entry?')) {
                    const id = $(this).data('id');
                    const type = $(this).data('type');

                    $.post('fetch_ledger.php', {
                        action: 'delete_entry',
                        id: id,
                        type: type
                    }, function(response) {
                        if (response.status === 'success') {
                            alert(response.message);

                            // Reload the table and statistics
                            table.ajax.reload(); // Reload the DataTable
                            fetchStatistics(); // Reload the statistics

                        } else {
                            alert(response.message);
                        }
                    }, 'json');
                }
            });

            // Function to fetch statistics
            function fetchStatistics() {
                $.ajax({
                    url: 'fetch_statistics.php', // Ensure this is the correct path to your PHP file
                    type: 'GET', // Method type (GET or POST)
                    dataType: 'json', // Expected response type (JSON)
                    success: function(response) {
                        // Check if response contains the expected data
                        if (response) {
                            // Update the statistics on the page
                            $('#current_month_income').text(response.month_income);
                            $('#current_month_expense').text(response.month_expense);
                            $('#current_month_balance').text(response.month_balance);

                            $('#previous_month_balance').text(response.prev_balance);
                            $('#total_income').text(response.total_income);
                            $('#total_expense').text(response.total_expense);
                            $('#total_balance').text(response.total_balance);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error('AJAX Error:', error);
                    }
                });
            }

            // Call fetchStatistics on page load and refresh periodically
            fetchStatistics(); // Fetch statistics initially

            // You can set an interval to refresh the statistics every minute (or as needed)
            setInterval(fetchStatistics, 60000); // 60000ms = 1 minute



            // Function to set today's date in the modal date fields
            function setTodayDate() {
                const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
                $('#incomeDate').val(today); // Set today's date for the income date input
                $('#expenseDate').val(today); // Set today's date for the expense date input
            }

            // Open Add Income Modal and set today's date
            $('#addIncomeModal').on('show.bs.modal', function() {
                setTodayDate(); // Set today's date when the modal is opened
            });

            // Open Add Expense Modal and set today's date
            $('#addExpenseModal').on('show.bs.modal', function() {
                setTodayDate(); // Set today's date when the modal is opened
            });



            // Function to fetch statistics
            function fetchStatistics() {
                $.ajax({
                    url: 'fetch_statistics.php', // Ensure this is the correct path to your PHP file
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response) {
                            // Update the statistics on the page
                            $('#current_month_income').text(response.month_income);
                            $('#current_month_expense').text(response.month_expense);
                            $('#current_month_balance').text(response.month_balance);

                            $('#previous_month_balance').text(response.prev_balance);
                            $('#total_income').text(response.total_income);
                            $('#total_expense').text(response.total_expense);
                            $('#total_balance').text(response.total_balance);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }

            // Call fetchStatistics on page load
            fetchStatistics();

            // Handle Income Form Submission
            $('#incomeForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'save_income.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function() {
                        alert('Income Saved!');
                        $('#addIncomeModal').modal('hide');
                        table.ajax.reload(); // Reload the DataTable
                        fetchStatistics(); // Reload statistics
                    },
                    error: function() {
                        alert('Failed to save income. Please try again.');
                    }
                });
            });

            // Handle Expense Form Submission
            $('#expenseForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'save_expense.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function() {
                        alert('Expense Saved!');
                        $('#addExpenseModal').modal('hide');
                        table.ajax.reload(); // Reload the DataTable
                        fetchStatistics(); // Reload statistics
                    },
                    error: function() {
                        alert('Failed to save expense. Please try again.');
                    }
                });
            });




        });
    </script>
</body>

</html>