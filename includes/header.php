<?php
session_start();

// Check if db.php exists, if not redirect to install.php
if (!file_exists(__DIR__ . '/db.php')) {
    header('Location: install.php');
    exit;
}

include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT fullname FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($fullname);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - ExpenseMate</title>
    <!-- Bootstrap CSS -->
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/r-3.0.3/datatables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet" />
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <div class="lnav">
            <a class="navbar-brand ps-3" href="index.php">ExpenseMate</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </div>
        <div class="rnav text-end"><a class="text-end" href="actions/logout.php">Logout</a></div>

    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>

                        <a class="nav-link" href="income.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Income
                        </a>
                        <a class="nav-link" href="expense.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Expense
                        </a>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Reports
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="this_month_statement.php"><?php echo date("F"); ?></a>
                                <a class="nav-link" href="last_month_statement.php"><?php echo date("F", strtotime('-1 month')); ?></a>
                                <a class="nav-link" href="income_statement.php">Income Statement</a>
                            </nav>
                        </div>
                        <a class="nav-link" href="income_category.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Income Categories
                        </a>
                        <a class="nav-link" href="expense_category.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Expense Categories
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <a class="ulink" href="user.php"><?php echo htmlspecialchars($fullname); ?></a>
                    <p>Version: 1.0.0</p>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>