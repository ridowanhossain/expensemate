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
    $result = $conn->query("SELECT expenses.id, 
                                   expenses.amount, 
                                   expenses.comment, 
                                   expenses.date, 
                                   expenses.category_id, -- Retrieve the category ID
                                   DATE_FORMAT(expenses.time, '%I:%i %p') AS formatted_time, 
                                   expenses.time AS raw_time, 
                                   expense_categories.name AS category_name
                            FROM expenses
                            LEFT JOIN expense_categories ON expenses.category_id = expense_categories.id
                            ORDER BY expenses.date DESC, 
                                     CASE 
                                         WHEN HOUR(raw_time) >= 12 THEN 1 
                                         ELSE 0 
                                     END DESC, 
                                     raw_time DESC");

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $category_id = $row['category_id'];

        // Format amount: Remove ".00" if it's a whole number
        if (fmod($row['amount'], 1) == 0) {
            $formattedAmount = number_format($row['amount'], 0);
        } else {
            $formattedAmount = number_format($row['amount'], 2, '.', '');
        }

        $data[] = [
            'DT_RowClass' => 'red', // Class for expenses
            'sl' => "",
            'category' => $row['category_name'],
            'comment' => $row['comment'],
            'date' => $row['date'],
            'time' => $row['formatted_time'],
            'amount' => $formattedAmount,
            'action' => "<button class='btn btn-primary btn-sm edit-btn mx-1' 
                            data-id='{$id}' 
                            data-type='expense' 
                            data-category-id='{$category_id}'
                            data-comment='{$row['comment']}' 
                            data-date='{$row['date']}' 
                            data-amount='{$row['amount']}'>
                            Edit
                         </button> 
                         <button class='btn btn-danger btn-sm delete-btn mx-1' 
                            data-id='{$id}' 
                            data-type='expense'>
                            Delete
                         </button>"
        ];
    }

    header('Content-Type: application/json');
    echo json_encode(['data' => $data]);
    exit;
}
?>
