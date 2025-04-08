<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

$userId = $_SESSION['user_id'];

// Get the POST data
$fullname = trim($_POST['fullname']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Validate input
if (empty($fullname) || empty($username)) {
    echo json_encode(['success' => false, 'message' => 'Full name and username are required.']);
    exit;
}

// Update query
if (!empty($password)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
    $query = $conn->prepare("UPDATE users SET fullname = ?, username = ?, password = ? WHERE id = ?");
    $query->bind_param('sssi', $fullname, $username, $hashedPassword, $userId);
} else {
    $query = $conn->prepare("UPDATE users SET fullname = ?, username = ? WHERE id = ?");
    $query->bind_param('ssi', $fullname, $username, $userId);
}

if ($query->execute()) {
    echo json_encode(['success' => true, 'message' => 'User updated successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update user.']);
}
?>
