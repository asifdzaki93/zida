<?php
$protocol = !empty($_SERVER['HTTP_X_FORWARDED_PROTO'])
  ? $_SERVER['HTTP_X_FORWARDED_PROTO']
  : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
    ? 'https'
    : 'http');
define('BASE_URL', $protocol . "://$_SERVER[HTTP_HOST]/zida");

// Definisikan BASE_URL secara statis
$base_url = BASE_URL;

$nameapp = 'Zieda Bakery';

$url = $_GET['page'] ?? 'home.php';

$allowed = [
  'home.php',
  'pdftes.php',
  'penjualan.php',
  'produksi.php',
  'order_detail.php',
  'wasetting.php',
  'master_data.php',
  'pengiriman.php',
  'packing.php',
  'create_invoice.php',
  'inv.php',
  'keuangan.php',
];

$page = explode('?', $url)[0];
if (!in_array($page, $allowed)) {
  $page = 'home.php';
}
include 'page/' . $page;
