<?php
session_start();
include "koneksi.php";  // Database connection
// Set user session
$_SESSION['namauser'] = '082322345757';
header('Content-Type: application/json');

$tanggal_awal = date('Y-m-01');
$tanggal_akhir = date('Y-m-t');
$user = mysqli_real_escape_string($connect, $_SESSION['namauser']);

$sql = "SELECT date, 
        SUM(IF(sales_data.totalpay <= sales_data.totalorder, sales_data.totalorder + sales_data.changepay, sales_data.totalpay - sales_data.changepay)) AS totalPemasukan,
        (SELECT SUM(totalnominal) FROM spending_data WHERE user = '$user' AND date = sales_data.date) AS totalPengeluaran,
        (SELECT SUM(totalorder) FROM purchasing_data WHERE user = '$user' AND date = sales_data.date) AS totalBelanjaProduk
        FROM sales_data
        WHERE user = '$user' AND status NOT IN ('cancel') AND date BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        GROUP BY date";

$result = mysqli_query($connect, $sql);
$data = ['labels' => [], 'pemasukan' => [], 'pengeluaran' => [], 'belanjaProduk' => []];

while ($row = mysqli_fetch_assoc($result)) {
    $data['labels'][] = $row['date'];
    $data['pemasukan'][] = $row['totalPemasukan'];
    $data['pengeluaran'][] = $row['totalPengeluaran'];
    $data['belanjaProduk'][] = $row['totalBelanjaProduk'];
}

echo json_encode($data);
?>
