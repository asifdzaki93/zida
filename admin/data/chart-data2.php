<?php
session_start();
include "koneksi.php";  // Include your database connection setup

header('Content-Type: application/json');
$_SESSION['namauser'] = '082322345757';
// Verify user session and dynamically set user session
$user = isset($_SESSION['namauser']) ? mysqli_real_escape_string($connect, $_SESSION['namauser']) : exit('User not authenticated.');

// Accept timeframe from user input; default to monthly if not specified
$timeframe = isset($_GET['timeframe']) ? $_GET['timeframe'] : 'monthly';

// Set date ranges and labels based on the timeframe
switch ($timeframe) {
    case 'weekly':
        $tanggal_awal = date('2023-m-d', strtotime('monday this week'));
        $tanggal_akhir = date('2023-m-d', strtotime('sunday this week'));
        $date_format = '%W';  // MySQL format for the weekday name
        break;
    case 'monthly':
        $tanggal_awal = date('2023-m-01');
        $tanggal_akhir = date('2023-m-d');
        $date_format = '%d';  // Day of the month
        break;
    case 'yearly':
        $tanggal_awal = date('2023-01-01');
        $tanggal_akhir = date('2023-m-d');
        $date_format = '%M';  // Month name
        break;
    default:
        exit('Invalid timeframe specified.');
}

// Define SQL query with dynamic date formatting and range
$sql = "
    SELECT DATE_FORMAT(s.date, '$date_format') AS formatted_date,
           SUM(IFNULL(s.totalpay, 0)) AS totalPemasukan,
           (SELECT SUM(IFNULL(sp.totalnominal, 0)) FROM spending_data sp WHERE sp.user = s.user AND sp.date = s.date) AS totalPengeluaran,
           (SELECT SUM(IFNULL(p.totalorder, 0)) FROM purchasing_data p WHERE p.user = s.user AND p.date = s.date) AS totalBelanjaProduk
    FROM sales_data s
    WHERE s.user = '$user' AND s.status NOT IN ('cancel') AND s.date BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    GROUP BY formatted_date
    ORDER BY s.date ASC;
";

$result = mysqli_query($connect, $sql);
$data = ['labels' => [], 'pemasukan' => [], 'pengeluaran' => [], 'belanjaProduk' => []];

while ($row = mysqli_fetch_assoc($result)) {
    $data['labels'][] = $row['formatted_date'];
    $data['pemasukan'][] = (int)$row['totalPemasukan'];
    $data['pengeluaran'][] = (int)$row['totalPengeluaran'];
    $data['belanjaProduk'][] = (int)$row['totalBelanjaProduk'];
}

echo json_encode($data);
