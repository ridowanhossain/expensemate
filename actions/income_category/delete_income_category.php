<?php
require_once '../../includes/db.php';

$id = $_POST['id'] ?? null;

// Validate input
if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Invalid request. No ID provided.']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM income_categories WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Income category deleted successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete income category: ' . $stmt->error]);
}

$stmt->close();
?>
