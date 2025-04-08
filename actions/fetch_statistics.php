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

$currentMonth = date('m');
$currentYear = date('Y');
$lastMonth = ($currentMonth == 1) ? 12 : $currentMonth - 1;
$lastMonthYear = ($currentMonth == 1) ? $currentYear - 1 : $currentYear;

// Query current month's income
$resultIncome = $conn->query("SELECT SUM(amount) AS month_income FROM incomes WHERE MONTH(date) = $currentMonth AND YEAR(date) = $currentYear");
$income = $resultIncome->fetch_assoc();

// Query current month's expense
$resultExpense = $conn->query("SELECT SUM(amount) AS month_expense FROM expenses WHERE MONTH(date) = $currentMonth AND YEAR(date) = $currentYear");
$expense = $resultExpense->fetch_assoc();

// Query last month's income
$lastMonthIncomeQuery = $conn->query("SELECT SUM(amount) AS last_month_income FROM incomes WHERE MONTH(date) = $lastMonth AND YEAR(date) = $lastMonthYear");
$lastMonthIncome = $lastMonthIncomeQuery->fetch_assoc();

// Query last month's expense
$lastMonthExpenseQuery = $conn->query("SELECT SUM(amount) AS last_month_expense FROM expenses WHERE MONTH(date) = $lastMonth AND YEAR(date) = $lastMonthYear");
$lastMonthExpense = $lastMonthExpenseQuery->fetch_assoc();

// Query previous month's balance
$prevBalanceQuery = $conn->query("SELECT SUM(amount) AS prev_balance FROM incomes WHERE MONTH(date) = $lastMonth AND YEAR(date) = $lastMonthYear");
$prevBalance = $prevBalanceQuery->fetch_assoc();

// Query total income and expense
$totalIncomeQuery = $conn->query("SELECT SUM(amount) AS total_income FROM incomes");
$totalIncome = $totalIncomeQuery->fetch_assoc();

$totalExpenseQuery = $conn->query("SELECT SUM(amount) AS total_expense FROM expenses");
$totalExpense = $totalExpenseQuery->fetch_assoc();

// Calculate current month balance
$currentMonthBalance = $income['month_income'] - $expense['month_expense'];

// Calculate total balance
$totalBalance = $totalIncome['total_income'] - $totalExpense['total_expense'];

// Format amounts for proper display
function formatAmount($amount) {
    if (is_null($amount)) {
        return 0; // Handle null values as 0
    }
    // If the number is whole, show it without decimals; otherwise, show two decimals
    return (fmod($amount, 1) == 0) ? number_format($amount, 0) : number_format($amount, 2, '.', '');
}

// Return the data as JSON with formatted amounts
echo json_encode([
    'month_income' => formatAmount($income['month_income']),
    'month_expense' => formatAmount($expense['month_expense']),
    'month_balance' => formatAmount($currentMonthBalance),
    'prev_balance' => formatAmount($prevBalance['prev_balance']),
    'total_income' => formatAmount($totalIncome['total_income']),
    'total_expense' => formatAmount($totalExpense['total_expense']),
    'total_balance' => formatAmount($totalBalance),
    'last_month_income' => formatAmount($lastMonthIncome['last_month_income']),
    'last_month_expense' => formatAmount($lastMonthExpense['last_month_expense'])
]);
?>
