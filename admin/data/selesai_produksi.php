<?php
require_once 'koneksi.php'; // Menggunakan file koneksi yang sama
function proses($mysqli){

    $no_invoices = explode(",",$_REQUEST['no_invoice']??"");
    foreach($no_invoices as $no_invoice){
        $updateSQL = $mysqli->query("UPDATE `sales_data` SET `status`='finish' where `no_invoice` = '".$mysqli->real_escape_string($no_invoice)."'");
    }
    echo "success";
    return;
}
proses($mysqli);
?>