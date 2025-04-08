<?php
require_once '../../includes/db.php';

// Enable error reporting for debugging (optional)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$name = $_POST['name'] ?? null;
$comment = $_POST['comment'] ?? null;

// Validate required fields
if (!$name || !$comment) {
    echo json_encode(['success' => false, 'message' => 'Name and Comment are required.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO expense_categories (name, comment) VALUES (?, ?)");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare the query: ' . $conn->error]);
    exit;
}

$stmt->bind_param('ss', $name, $comment);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'expense category added successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add expense category: ' . $stmt->error]);
}

$stmt->close();
?>
