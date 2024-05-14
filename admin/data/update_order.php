<?php
require_once 'koneksi.php'; // Menggunakan file koneksi yang sama
function proses($mysqli)
{
  if (!$mysqli->is_auth) {
    echo 'Tidak diizinkan';
    return;
  }

  $no_invoice = $_POST['no_invoice'] ?? '';
  if ($no_invoice == '') {
    echo 'error input';
    return;
  }
  $sales_dataX = $mysqli->query(
    "select totalpay from sales_data where $mysqli->user_master_query and no_invoice = '" .
      $mysqli->real_escape_string($no_invoice) .
      "'"
  );
  $sales_data = null;
  while ($row = $sales_dataX->fetch_assoc()) {
    $sales_data = $row;
  }
  if ($sales_data == null) {
    echo 'error input sales data';
    return;
  }
  $salesX = $mysqli->query(
    "select totalprice,price,id_sales from sales where $mysqli->user_master_query and no_invoice = '" .
      $mysqli->real_escape_string($no_invoice) .
      "'"
  );
  $totalorder = 0;
  while ($row = $salesX->fetch_assoc()) {
    $sales = $row;
    $totalprice = $row['totalprice'];
    $amount = $_POST['product_' . $row['id_sales'] . '_amount'] ?? 0;
    if (isset($_POST['product_' . $row['id_sales'] . '_amount'])) {
      $totalprice = $row['price'] * $amount;
    }
    $totalorder += $totalprice;
    $mysqli->query(
      "UPDATE `sales` SET `amount`='$amount',`totalprice`='$totalprice' where `id_sales` = '" . $sales['id_sales'] . "'"
    );
  }

  $note = $mysqli->real_escape_string(
    'Jam Acara : ' .
      ($_POST['jam_acara'] ?? '') .
      ', Jenis Pengiriman : ' .
      ($_POST['jenis_pengiriman'] ?? '') .
      ', Catatan : ' .
      ($_POST['catatan'] ?? '') .
      ' (di edit admin pada ' .
      date('Y-m-d H:i:s') .
      ')'
  );
  $due_date = $mysqli->real_escape_string($_POST['due_date'] ?? date('H:i'));
  $updateSQL =
    "UPDATE `sales_data` SET `totalorder`='$totalorder', `note` = '$note', `due_date` = '$due_date' where `no_invoice` = '" .
    $no_invoice .
    "'";
  if ($mysqli->query($updateSQL) === true) {
    echo 'success';
    return;
  }
  echo 'error query';
}
proses($mysqli);
