<?php
session_start();
include "koneksi.php";  // Include your database connection setup

header('Content-Type: application/json');
$_SESSION['namauser'] = '082322345757';
$user = $_SESSION['namauser'];


// Set timezone to ensure correct date calculation
date_default_timezone_set('Asia/Jakarta');
$today = date('2023-m-d');

// 1. Calculate total income for today
$incomeQuery = "SELECT SUM(totalpay) AS totalIncome FROM sales_data WHERE `date` = '$today' AND user = $user";
$incomeResult = $connect->query($incomeQuery);
$incomeRow = $incomeResult->fetch_assoc();
$totalIncome = $incomeRow['totalIncome'] ?? 0;

// 2. Calculate total billing for today
$billingQuery = "SELECT SUM(totalorder - totalpay) AS totalBilling FROM sales_data WHERE due_date = '$today' AND user = $user";
$billingResult = $connect->query($billingQuery);
$billingRow = $billingResult->fetch_assoc();
$totalBilling = $billingRow['totalBilling'] ?? 0;

// 3. Sum of income and billing
$totalAmount = $totalIncome + $totalBilling;

// 4. Percentage of income from the total amount
$incomePercentage = ($totalAmount > 0) ? ($totalIncome / $totalAmount * 100) : 0;

// 5. Percentage of billing from the total amount
$billingPercentage = ($totalAmount > 0) ? ($totalBilling / $totalAmount * 100) : 0;

// Prepare data for JSON output
$response = [
    'totalIncome' => $totalIncome,
    'totalBilling' => $totalBilling,
    'totalAmount' => $totalAmount,
    'incomePercentage' => round($incomePercentage, 2),
    'billingPercentage' => round($billingPercentage, 2)
];

// Set header to output JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close the connection
$connect->close();
