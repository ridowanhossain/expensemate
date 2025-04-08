<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $type = $_POST['type'] ?? null;
    $category_id = $_POST['category_id'] ?? null;
    $comment = $_POST['comment'] ?? null;
    $date = DateTime::createFromFormat('Y-m-d', $_POST['date'])->format('Y-m-d');
    $amount = $_POST['amount'] ?? null;

    // Validate required fields
    if (!$id || !$type || !$comment || !$date || !$amount) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
        exit;
    }

    // Determine the table based on the type
    $table = $type === 'income' ? 'incomes' : 'expenses';

    // Fetch current values from the database
    $stmt = $conn->prepare("SELECT category_id, comment, date, amount FROM $table WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Entry not found.']);
        exit;
    }

    $existingRow = $result->fetch_assoc();

    // Check if the new data is different from the existing data
    if (
        $existingRow['category_id'] == $category_id &&
        $existingRow['comment'] == $comment &&
        $existingRow['date'] == $date &&
        $existingRow['amount'] == $amount
    ) {
        // If no change in data, return the up-to-date message
        echo json_encode(['status' => 'success', 'message' => 'No changes were made, but the entry is up-to-date.']);
        exit;
    }

    // Proceed with the update as the data has changed
    $stmt = $conn->prepare("UPDATE $table SET category_id = ?, comment = ?, date = ?, amount = ?, time = CURRENT_TIMESTAMP WHERE id = ?");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare the query.']);
        exit;
    }

    $stmt->bind_param('issdi', $category_id, $comment, $date, $amount, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Entry updated successfully.']);
        } else {
            // In case of no rows affected but query executes
            echo json_encode(['status' => 'success', 'message' => 'No changes were made, but the entry is up-to-date.']);
        }
    } else {
        // Query failed
        echo json_encode(['status' => 'error', 'message' => 'Failed to update the entry: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
