<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Suppress PHP warnings
error_reporting(0);
ini_set('display_errors', 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the current month and year
    $currentMonth = date('m');
    $currentYear = date('Y');

    $result = $conn->query("SELECT incomes.id, 
                                   incomes.amount, 
                                   incomes.comment, 
                                   incomes.date, 
                                   incomes.category_id, -- Retrieve category ID for incomes
                                   DATE_FORMAT(incomes.time, '%I:%i %p') AS formatted_time, 
                                   incomes.time AS raw_time, 
                                   income_categories.name AS category_name,
                                   'income' AS type 
                            FROM incomes
                            LEFT JOIN income_categories ON incomes.category_id = income_categories.id
                            WHERE MONTH(incomes.date) = '$currentMonth' AND YEAR(incomes.date) = '$currentYear'
                            UNION ALL
                            SELECT expenses.id, 
                                   expenses.amount, 
                                   expenses.comment, 
                                   expenses.date, 
                                   expenses.category_id, -- Retrieve category ID for expenses
                                   DATE_FORMAT(expenses.time, '%I:%i %p') AS formatted_time, 
                                   expenses.time AS raw_time, 
                                   expense_categories.name AS category_name,
                                   'expense' AS type
                            FROM expenses
                            LEFT JOIN expense_categories ON expenses.category_id = expense_categories.id
                            WHERE MONTH(expenses.date) = '$currentMonth' AND YEAR(expenses.date) = '$currentYear'
                            ORDER BY date DESC, 
                                     CASE 
                                         WHEN HOUR(raw_time) >= 12 THEN 1 
                                         ELSE 0 
                                     END DESC, 
                                     raw_time DESC");

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $color = $row['type'] == 'income' ? 'green' : 'red';
        $entryType = ucfirst($row['type']);
        $id = $row['id'];
        $category_id = $row['category_id']; // Assign the category ID

        // Format amount: Remove ".00" if it's a whole number; keep decimals otherwise
        if (fmod($row['amount'], 1) == 0) { 
            $formattedAmount = number_format($row['amount'], 0);
        } else {
            $formattedAmount = number_format($row['amount'], 2, '.', '');
        }

        $data[] = [
            'DT_RowClass' => $color,
            'sl' => "",
            'category' => $row['category_name'], // Category column
            'comment' => $row['comment'],
            'date' => $row['date'], // Separate Date column
            'time' => $row['formatted_time'], // Separate Time column
            'amount' => $formattedAmount,
            'type' => $entryType,
            'action' => "<button class='btn btn-primary btn-sm edit-btn mx-1' 
                            data-id='{$id}' 
                            data-type='{$row['type']}' 
                            data-category-id='{$category_id}'
                            data-comment='{$row['comment']}' 
                            data-date='{$row['date']}' 
                            data-amount='{$row['amount']}'>
                            Edit
                         </button> 
                         <button class='btn btn-danger btn-sm delete-btn mx-1' 
                            data-id='{$id}' 
                            data-type='{$row['type']}'>
                            Delete
                         </button>"
        ];
    }

    header('Content-Type: application/json');
    echo json_encode(['data' => $data]);
    exit;
}
?>
