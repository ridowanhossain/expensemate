<?php
// Check if db.php exists and redirect to index
if (file_exists('includes/db.php')) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbHost = $_POST['db_host'];
    $dbName = $_POST['db_name'];
    $dbUser = $_POST['db_user'];
    $dbPassword = $_POST['db_password'];

    // Save database connection details directly to db.php
    $dbFile = 'includes/db.php';
    $dbContent = "<?php\n";
    $dbContent .= "\$host = '$dbHost';\n";
    $dbContent .= "\$database = '$dbName';\n";
    $dbContent .= "\$user = '$dbUser';\n";
    $dbContent .= "\$password = '$dbPassword';\n\n";
    $dbContent .= "\$conn = new mysqli(\$host, \$user, \$password, \$database);\n";
    $dbContent .= "if (\$conn->connect_error) {\n";
    $dbContent .= "  die(\"Connection failed: \" . \$conn->connect_error);\n";
    $dbContent .= "}\n";"},{"old_str":

    if (file_put_contents($dbFile, $dbContent)) {
        try {
            // Connect to the database
            $conn = new mysqli($dbHost, $dbUser, $dbPassword);

            // Check connection
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }

            // Create the database if not exists
            $conn->query("CREATE DATABASE IF NOT EXISTS $dbName");

            // Select the database
            $conn->select_db($dbName);

            // Create tables
            $createUsersTable = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                fullname VARCHAR(100) NOT NULL
            )";
            $conn->query($createUsersTable);

            // Insert a default admin user
            $defaultPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $conn->query("INSERT INTO users (username, password, fullname) 
                          VALUES ('admin', '$defaultPassword', 'Administrator')");

            echo json_encode(['success' => true, 'message' => 'Installation completed successfully!']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to write configuration file.']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Installation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">App Installation</h2>
    <form id="installForm" method="POST">
        <div class="mb-3">
            <label for="db_host" class="form-label">Database Host</label>
            <input type="text" class="form-control" id="db_host" name="db_host" placeholder="e.g., localhost" required>
        </div>
        <div class="mb-3">
            <label for="db_name" class="form-label">Database Name</label>
            <input type="text" class="form-control" id="db_name" name="db_name" required>
        </div>
        <div class="mb-3">
            <label for="db_user" class="form-label">Database User</label>
            <input type="text" class="form-control" id="db_user" name="db_user" required>
        </div>
        <div class="mb-3">
            <label for="db_password" class="form-label">Database Password</label>
            <input type="password" class="form-control" id="db_password" name="db_password">
        </div>
        <button type="submit" class="btn btn-primary">Install</button>
    </form>
    <div id="message" class="mt-3"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
    $('#installForm').on('submit', function (e) {
        e.preventDefault();
        $.post('install.php', $(this).serialize(), function (response) {
            const messageDiv = $('#message');
            if (response.success) {
                messageDiv.html(`<div class="alert alert-success">${response.message}</div>`);
            } else {
                messageDiv.html(`<div class="alert alert-danger">${response.message}</div>`);
            }
        }, 'json');
    });
</script>
</body>
</html>
