<?php
require_once 'koneksi.php'; // Menggunakan file koneksi yang sama
function proses($mysqli)
{
  if (!$mysqli->is_auth) {
    echo 'Tidak diizinkan';
    return;
  }

  $id_product = $_GET['id_product'] ?? '';
  $no_invoice = $_GET['no_invoice'] ?? '';
  if ($id_product == '' || $no_invoice == '') {
    echo 'error input';
    return;
  }
  $sales_dataX = $mysqli->query(
    "select id_store,date,due_date,status,id_customer,no_invoice from sales_data where $mysqli->user_master_query and no_invoice = '" .
      $mysqli->real_escape_string($no_invoice) .
      "'"
  );
  $sales_data = null;
  while ($row = $sales_dataX->fetch_assoc()) {
    $sales_data = $row;
  }
  $salesX = $mysqli->query(
    "select no_invoice from sales where $mysqli->user_master_query and id_product = '" .
      $mysqli->real_escape_string($id_product) .
      "' and no_invoice = '" .
      $mysqli->real_escape_string($no_invoice) .
      "'"
  );
  $sales = null;
  while ($row = $salesX->fetch_assoc()) {
    $sales = $row;
  }
  $productX = $mysqli->query(
    "select selling_price from product where $mysqli->user_master_query and id_product = '" .
      $mysqli->real_escape_string($id_product) .
      "'"
  );
  $product = [];
  while ($row = $productX->fetch_assoc()) {
    $product = $row;
  }
  if ($product == null || $sales_data == null || $sales != null) {
    echo 'error data exists';
    return;
  }
  $sql =
    "INSERT INTO `sales`(
        `id_customer`, 
        `id_product`, 
        `id_store`, 
        `user`, 
        `no_invoice`, 
        `amount`, 
        `price`, 
        `totalprice`, 
        `totalcapital`, 
        `date`, 
        `due_date`, 
        `status`, 
        `note`, 
        `rest_stock`, 
        `ppob`
        ) VALUES (
            '" .
    $sales_data['id_customer'] .
    "',
            '" .
    $mysqli->real_escape_string($id_product) .
    "',
            '" .
    $sales_data['id_store'] .
    "',
            '" .
    $mysqli->user_master .
    "',
            '" .
    $mysqli->real_escape_string($no_invoice) .
    "',
            '0',
            '" .
    $product['selling_price'] .
    "',
            '0',
            '0',
            '" .
    $sales_data['date'] .
    "',
            '" .
    $sales_data['due_date'] .
    "',
            '" .
    $sales_data['status'] .
    "',
            'Admin Edit',
            '0',
            '0'
            )";
  if ($mysqli->query($sql) === true) {
    echo 'success';
    return;
  }
  echo 'error query';
}
proses($mysqli);
?>
