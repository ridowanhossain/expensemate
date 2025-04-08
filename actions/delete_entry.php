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


// Suppress PHP warnings
error_reporting(0);
ini_set('display_errors', 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $type = $_POST['type'];

    $table = $type === 'income' ? 'incomes' : 'expenses';
    $stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Entry deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete entry.']);
    }
    exit;
}
?>
