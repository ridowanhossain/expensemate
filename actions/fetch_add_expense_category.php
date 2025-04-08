<?php
require_once '../includes/db.php';

// Set JSON response header
header('Content-Type: application/json');

// Check database connection
if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

// Fetch categories from the `expense_categories` table
$sql = "SELECT id, name FROM expense_categories ORDER BY name ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    echo json_encode(['status' => 'success', 'categories' => $categories]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No categories found.']);
}
?>
