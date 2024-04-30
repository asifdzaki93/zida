<?php
header('Content-type: application/json');
require_once 'koneksi.php'; // Menggunakan file koneksi yang sama
include "produksi2.php";
$output = getOrderData($mysqli);
echo json_encode($output, JSON_PRETTY_PRINT);
?>