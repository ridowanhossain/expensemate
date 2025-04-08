<?php
require_once '../../includes/db.php';

$id = $_POST['id'];

$stmt = $conn->prepare("SELECT * FROM expense_categories WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['success' => true, 'data' => $row]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
?>
