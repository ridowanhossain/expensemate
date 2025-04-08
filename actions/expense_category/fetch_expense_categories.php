<?php
require_once '../../includes/db.php';

$result = $conn->query("SELECT * FROM expense_categories ORDER BY id DESC");
$data = [];

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $data[] = [
        'id' => $id,
        'name' => $row['name'],
        'comment' => $row['comment'],
        'action' => "
            <button class='btn btn-primary btn-sm edit-btn mx-1' data-id='{$id}'>Edit</button>
            <button class='btn btn-danger btn-sm delete-btn mx-1' data-id='{$id}'>Delete</button>
        ",
    ];
}

echo json_encode(['data' => $data]);
?>
