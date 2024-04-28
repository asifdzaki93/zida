<?php
// Include database connection setup
include "koneksi.php";

// Start session
session_start();
// Set user session
$_SESSION['namauser'] = '082322345757';

// Get user session
$user = isset($_SESSION['namauser']) ? mysqli_real_escape_string($connect, $_SESSION['namauser']) : exit('User not authenticated.');

// Accept timeframe from user input; default to monthly if not specified
$timeframe = isset($_GET['timeframe']) ? $_GET['timeframe'] : 'monthly';

// Set date ranges based on the timeframe
switch ($timeframe) {
    case 'weekly':
        $start_date = date('Y-m-d', strtotime('monday this week'));
        $end_date = date('Y-m-d', strtotime('sunday this week'));
        break;
    case 'monthly':
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-d');
        break;
    case 'yearly':
        $start_date = date('Y-01-01');
        $end_date = date('Y-m-d');
        break;
    default:
        exit('Invalid timeframe specified.');
}

// Define SQL query to fetch data for the current period
$sql_current = "SELECT SUM(totalpay) AS total FROM sales_data WHERE user = '$user' AND date BETWEEN '$start_date' AND '$end_date' AND status NOT IN ('cancel')";

// Define SQL query to fetch data for the previous period
//$sql_previous = "SELECT SUM(totalpay) AS total FROM sales_data WHERE user = '$user' AND date BETWEEN DATE_SUB('$start_date', INTERVAL 1 $timeframe) AND DATE_SUB('$end_date', INTERVAL 1 $timeframe) AND status NOT IN ('cancel')";
$sql_previous = "SELECT SUM(totalpay) AS total FROM sales_data WHERE user = '$user' AND date BETWEEN DATE_SUB('$start_date', INTERVAL 1 MONTH) AND DATE_SUB('$end_date', INTERVAL 1 MONTH) AND status NOT IN ('cancel')";


// Execute the SQL queries
$result_current = mysqli_query($connect, $sql_current);
$result_previous = mysqli_query($connect, $sql_previous);

// Check if the queries executed successfully
if (!$result_current || !$result_previous) {
    exit('Error fetching data from the database: ' . mysqli_error($connect));
}


// Fetch total sales for the current period
$row_current = mysqli_fetch_assoc($result_current);
$total_current = isset($row_current['total']) ? $row_current['total'] : 0;

// Fetch total sales for the previous period
$row_previous = mysqli_fetch_assoc($result_previous);
$total_previous = isset($row_previous['total']) ? $row_previous['total'] : 0;

// Calculate the performance
$performance = calculatePerformance($total_previous, $total_current);

// Return the data as JSON
echo json_encode(['performance' => $performance]);

// Function to calculate performance
function calculatePerformance($previous, $current) {
    if ($previous == 0) {
        return "100%"; // Handle division by zero
    }
    $change = (($current - $previous) / $previous) * 100;
    return number_format($change, 2) . '%';
}
?>
