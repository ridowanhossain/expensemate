<?php
if (file_exists(__DIR__ . '/includes/db.php')) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['db_host'];
    $user = $_POST['db_user'];
    $password = $_POST['db_password'];
    $database = $_POST['db_name'];
    $adminUsername = $_POST['admin_username'];
    $adminPassword = $_POST['admin_password'];
    $adminFullname = $_POST['admin_fullname'];

    try {
        // Test the database connection
        $conn = new mysqli($host, $user, $password);
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Create the database if it does not exist
        if (!$conn->query("CREATE DATABASE IF NOT EXISTS `$database`")) {
            throw new Exception("Database creation failed: " . $conn->error);
        }

        // Select the database
        $conn->select_db($database);

        // Create tables
        $createUsersTable = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            fullname VARCHAR(100) NOT NULL
        )";

        $createIncomeCategoriesTable = "CREATE TABLE IF NOT EXISTS income_categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL UNIQUE,
            comment TEXT
        )";

        $createExpenseCategoriesTable = "CREATE TABLE IF NOT EXISTS expense_categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL UNIQUE,
            comment TEXT
        )";

        $createIncomesTable = "CREATE TABLE IF NOT EXISTS incomes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            amount DECIMAL(10, 2) NOT NULL,
            category_id INT NOT NULL,
            comment TEXT,
            date DATE NOT NULL,
            time TIME NOT NULL,
            FOREIGN KEY (category_id) REFERENCES income_categories(id)
        )";

        $createExpensesTable = "CREATE TABLE IF NOT EXISTS expenses (
            id INT AUTO_INCREMENT PRIMARY KEY,
            amount DECIMAL(10, 2) NOT NULL,
            category_id INT NOT NULL,
            comment TEXT,
            date DATE NOT NULL,
            time TIME NOT NULL,
            FOREIGN KEY (category_id) REFERENCES expense_categories(id)
        )";

        // New tables for comments without an ID
        $createIncomeCommentsTable = "CREATE TABLE IF NOT EXISTS income_comments (
            comments TEXT NOT NULL
        )";

        $createExpenseCommentsTable = "CREATE TABLE IF NOT EXISTS expense_comments (
            comments TEXT NOT NULL
        )";

        $tables = [
            $createUsersTable,
            $createIncomeCategoriesTable,
            $createExpenseCategoriesTable,
            $createIncomesTable,
            $createExpensesTable,
            $createIncomeCommentsTable,
            $createExpenseCommentsTable
        ];

        foreach ($tables as $tableQuery) {
            if (!$conn->query($tableQuery)) {
                throw new Exception("Table creation failed: " . $conn->error);
            }
        }

        // Hash the admin password and insert the initial admin user
        $hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);
        $conn->query("INSERT INTO users (username, password, fullname) 
                      VALUES ('$adminUsername', '$hashedPassword', '$adminFullname')")
            or throw new Exception("Failed to insert initial admin user: " . $conn->error);

        // Generate includes/db.php file
        $dbFilePath = __DIR__ . '/includes/db.php';
        $dbFileContent = "<?php\n";
        $dbFileContent .= "\$host = '$host';\n";
        $dbFileContent .= "\$user = '$user';\n";
        $dbFileContent .= "\$password = '$password';\n";
        $dbFileContent .= "\$database = '$database';\n\n";
        $dbFileContent .= "\$conn = new mysqli(\$host, \$user, \$password, \$database);\n";
        $dbFileContent .= "if (\$conn->connect_error) {\n";
        $dbFileContent .= "  die(\"Connection failed: \" . \$conn->connect_error);\n";
        $dbFileContent .= "}\n?>";

        if (!is_dir(__DIR__ . '/includes')) {
            mkdir(__DIR__ . '/includes', 0755, true);
        }

        if (!file_put_contents($dbFilePath, $dbFileContent)) {
            throw new Exception("Failed to write includes/db.php file.");
        }

        echo json_encode(['success' => true, 'message' => 'Installation completed successfully!']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
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
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .alert {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="text-center mb-4">
        <img src="assets/img/logo.png" alt="ExpenseMate Logo" class="img-fluid" style="max-width: 200px;">
    </div>
    <div class="form-container">
        <h2>App Installation</h2>
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
            <div class="mb-3">
                <label for="admin_username" class="form-label">Admin Username</label>
                <input type="text" class="form-control" id="admin_username" name="admin_username" required>
            </div>
            <div class="mb-3">
                <label for="admin_fullname" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="admin_fullname" name="admin_fullname" required>
            </div>
            <div class="mb-3">
                <label for="admin_password" class="form-label">Admin Password</label>
                <input type="password" class="form-control" id="admin_password" name="admin_password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Install</button>
        </form>
        <div id="message" class="mt-3"></div>
    </div>
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
