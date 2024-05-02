<?php
header('Content-type: application/json');
require_once 'koneksi.php'; // Menggunakan file koneksi yang sama
include "produksi_all.php";
$output = getOrderData($mysqli, true);
echo json_encode($output, JSON_PRETTY_PRINT);
