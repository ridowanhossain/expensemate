<?php
session_start();
include 'includes/db.php'; // Include your database connection

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['name']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Admin Login</title>
</head>

<body class="wrapper expansion-alids-init">
    <div class="container h-100">
        <div class="logo text-center">
            <a href="/">
                <img style="width:120px; margin-bottom: 30px;" src="assets/img/logo.png" alt="Logo">
            </a>
        </div>
        <h1 class="text-center text-white mt-4 alto">Admin Login</h1>

        <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php echo $error; ?>
        </div>
        <?php endif; ?>

        <form class="form abdr text-center" method="POST" action="">
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" id="login-button" class="btn btn-primary">Login</button>
        </form>
    </div>

    <ul class="bg-bubbles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</body>

</html>
