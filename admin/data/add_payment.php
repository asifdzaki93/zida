<?php
require_once 'koneksi.php'; // Menggunakan file koneksi yang sama
function proses($mysqli)
{
  if (!$mysqli->is_auth) {
    echo 'Tidak diizinkan';
    return;
  }

  $status = 'dp';
  $no_invoice = $_POST['no_invoice'] ?? '';
  $nominal = $_POST['nominal'] ?? '0';
  $catatanX = $_POST['catatan'] ?? '';
  if ($status == '' || $no_invoice == '' || $nominal == '0') {
    echo 'error input';
    return;
  }
  $catatan = null;
  if ($catatanX != '') {
    $catatan = $mysqli->real_escape_string($catatanX);
  }
  $sales_dataX = $mysqli->query(
    "select status,date,totalorder,totalpay,id_customer,no_invoice from sales_data where $mysqli->user_master_query and no_invoice = '" .
      $mysqli->real_escape_string($no_invoice) .
      "'"
  );
  $sales_data = null;
  while ($row = $sales_dataX->fetch_assoc()) {
    $sales_data = $row;
  }
  if ($sales_data == null) {
    echo 'error no data';
    return;
  }

  //Total Pay
  $totalpay = $sales_data['totalpay'] + $nominal;

  //CEK STATUS
  $statusSD = $sales_data['status'];
  if ($sales_data['totalorder'] > $totalpay) {
    $status = 'debt';
    $ada = false;
    $customerdebthistoryX = $mysqli->query(
      "select no_invoice from customerdebthistory where $mysqli->user_master_query and no_invoice = '" .
        $mysqli->real_escape_string($no_invoice) .
        "'"
    );
    while ($row = $customerdebthistoryX->fetch_assoc()) {
      $ada = true;
    }
    if ($ada == false) {
      $sqlDP =
        "INSERT INTO `customerdebthistory`(
                `id_customer`, 
                `status`, 
                `user`, 
                `no_invoice`, 
                `nominal`, 
                `date`,
                `metode_pembayaran`,
                `catatan`
                ) VALUES (
                    '" .
        $sales_data['id_customer'] .
        "',
                    'dp',
                    '" .
        $mysqli->user_master .
        "',
                    '" .
        $sales_data['no_invoice'] .
        "',
                    '" .
        $sales_data['totalpay'] .
        "',
                    '" .
        $sales_data['date'] .
        "',
                    'internal',
                    'Diinput oleh sistem'
                    )";
      $mysqli->query($sqlDP);
    }
  } else {
    $status = 'paid off';
    $statusSD = $status;
  }

  $sql =
    "INSERT INTO `customerdebthistory`(
        `id_customer`, 
        `status`, 
        `user`, 
        `no_invoice`, 
        `nominal`, 
        `date`,
        `metode_pembayaran`,
        `catatan`
        ) VALUES (
            '" .
    $sales_data['id_customer'] .
    "',
            '$status',
            '" .
    $mysqli->user_master .
    "',
            '" .
    $sales_data['no_invoice'] .
    "',
            '" .
    $mysqli->real_escape_string($nominal) .
    "',
            '" .
    date('Y-m-d') .
    "',
            'internal',
            '" .
    $catatan .
    "'
            )";
  $sql2 =
    "UPDATE `sales_data` SET `status`='$statusSD',`totalpay`='$totalpay' where `no_invoice` = '" .
    $sales_data['no_invoice'] .
    "'";
  $sql3 = "UPDATE `sales` SET `status`='$statusSD' where `no_invoice` = '" . $sales_data['no_invoice'] . "'";
  if ($mysqli->query($sql) === true && $mysqli->query($sql2) === true && $mysqli->query($sql3) === true) {
    echo 'success';
    return;
  }
  echo 'error query';
}
proses($mysqli);
?>
