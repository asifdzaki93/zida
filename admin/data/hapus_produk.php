<?php
require_once 'koneksi.php'; // Menggunakan file koneksi yang sama
function proses($mysqli){

    $id_sales=$_GET['id_sales']??"";
    $salesX = $mysqli->query("select totalprice,no_invoice from sales where $mysqli->user_master_query and id_sales = '".$mysqli->real_escape_string($id_sales)."'");
    $sales = null;
    while ($row = $salesX->fetch_assoc()) {
        $sales = $row;
    }
    if($sales==null){
        echo "error input";
        return;
    }
    $sales_dataX = $mysqli->query("select totalpay from sales_data where $mysqli->user_master_query and no_invoice = '".$mysqli->real_escape_string($sales["no_invoice"])."'");
    $sales_data = null;
    while ($row = $sales_dataX->fetch_assoc()) {
        $sales_data = $row;
    }
    if($sales_data==null){
        echo "error input sales data";
        return;
    }
    $totalpay=$sales_data["totalpay"]-$sales["totalprice"];
    $updateSQL = "UPDATE `sales_data` SET `totalpay`='$totalpay' where `id_customer` = '".$sales["no_invoice"]."'";
    $deleteSQL = "DELETE from `sales` WHERE id_sales = '".$mysqli->real_escape_string($id_sales)."'";
    if ($mysqli->query($updateSQL) === TRUE && $mysqli->query($deleteSQL) === TRUE ) {
        echo "success";
        return;
    }
    echo "error query";
}
proses($mysqli);
?>