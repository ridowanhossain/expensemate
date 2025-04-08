<?php
require_once '../../includes/db.php';

$id = $_POST['id'];
$name = $_POST['name'];
$comment = $_POST['comment'];

// Check if the required fields are provided
if (!$id || !$name || !$comment) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Fetch the current values of the category
$currentStmt = $conn->prepare("SELECT name, comment FROM income_categories WHERE id = ?");
$currentStmt->bind_param('i', $id);
$currentStmt->execute();
$currentResult = $currentStmt->get_result();
$currentCategory = $currentResult->fetch_assoc();
$currentStmt->close();

// Check if the values are different
if ($currentCategory['name'] === $name && $currentCategory['comment'] === $comment) {
    // If no changes, return a message indicating the entry is up-to-date
    echo json_encode(['success' => true, 'message' => 'No changes were made, but the entry is up-to-date.']);
    exit;
}

$stmt = $conn->prepare("UPDATE income_categories SET name = ?, comment = ? WHERE id = ?");
$stmt->bind_param('ssi', $name, $comment, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Income category updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update income category: ' . $stmt->error]);
}

$stmt->close();
?>
