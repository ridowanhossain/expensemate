<?php
// Include database connection
include 'db.php';

// Fetch the statistics
$currentMonth = date('m');
$currentYear = date('Y');

// Query today's income
$resultIncome = $conn->query("SELECT SUM(amount) as month_income FROM incomes WHERE MONTH(date) = $currentMonth AND YEAR(date) = $currentYear");
$income = $resultIncome->fetch_assoc();

// Query today's expense
$resultExpense = $conn->query("SELECT SUM(amount) as month_expense FROM expenses WHERE MONTH(date) = $currentMonth AND YEAR(date) = $currentYear");
$expense = $resultExpense->fetch_assoc();

// Query previous month's balance (you can modify the query to match your business logic)
$prevBalanceQuery = $conn->query("SELECT SUM(amount) as prev_balance FROM incomes WHERE MONTH(date) = " . ($currentMonth - 1) . " AND YEAR(date) = $currentYear");
$prevBalance = $prevBalanceQuery->fetch_assoc();

// Query total income and expense
$totalIncomeQuery = $conn->query("SELECT SUM(amount) as total_income FROM incomes");
$totalIncome = $totalIncomeQuery->fetch_assoc();

$totalExpenseQuery = $conn->query("SELECT SUM(amount) as total_expense FROM expenses");
$totalExpense = $totalExpenseQuery->fetch_assoc();

// Calculate current month balance
$currentMonthBalance = $income['month_income'] - $expense['month_expense'];

// Calculate total balance
$totalBalance = $totalIncome['total_income'] - $totalExpense['total_expense'];

// Return the data as JSON
echo json_encode([
    'month_income' => $income['month_income'],
    'month_expense' => $expense['month_expense'],
    'month_balance' => $currentMonthBalance,
    'prev_balance' => $prevBalance['prev_balance'],
    'total_income' => $totalIncome['total_income'],
    'total_expense' => $totalExpense['total_expense'],
    'total_balance' => $totalBalance
]);
?>
