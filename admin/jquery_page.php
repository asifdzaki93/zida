<?php
include 'data/base_sistem.php';
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
