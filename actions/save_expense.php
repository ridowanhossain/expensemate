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

date_default_timezone_set("Asia/Dhaka");

// Fetch form inputs
$amount = $_POST['amount'];
$category_id = $_POST['category_id']; // New column
$comment = $_POST['comment'];
$date = DateTime::createFromFormat('Y-m-d', $_POST['date'])->format('Y-m-d');
$time = date("H:i:s");

// Set the correct timezone for MySQL
$conn->query("SET time_zone = '+06:00'");

// Prepare the SQL query with the new category_id field
$stmt = $conn->prepare("INSERT INTO expenses (amount, category_id, comment, date, time) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("disss", $amount, $category_id, $comment, $date, $time);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Expenses added successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add Expenses']);
}

$stmt->close();
$conn->close();
?>
