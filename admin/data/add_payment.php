<?php
require_once 'koneksi.php'; // Menggunakan file koneksi yang sama
function proses($mysqli){

    $status="dp";
    $no_invoice=$_POST['no_invoice']??"";
    $nominal=$_POST['nominal']??"0";
    $catatanX=$_POST['catatan']??"";
    if($status=="" || $no_invoice=="" || $nominal=="0"){
        echo "error input";
        return;
    }
    $catatan=null;
    if($catatanX!=""){
        $catatan=$mysqli->real_escape_string($catatanX);
    }
    $sales_dataX = $mysqli->query("select totalorder,totalpay,id_customer,no_invoice from sales_data where $mysqli->user_master_query and no_invoice = '".$mysqli->real_escape_string($no_invoice)."'");
    $sales_data = null;
    while ($row = $sales_dataX->fetch_assoc()) {
        $sales_data = $row;
    }
    if($sales_data==null){
        echo "error no data";
        return;
    }

    //Total Pay
    $totalpay = $sales_data["totalpay"]+$nominal;

    //CEK STATUS
    if($sales_data["totalorder"]>$totalpay){
        $status="dp";
        $customerdebthistoryX = $mysqli->query("select no_invoice from sales_data where $mysqli->user_master_query and no_invoice = '".$mysqli->real_escape_string($no_invoice)."'");
        while ($row = $customerdebthistoryX->fetch_assoc()) {
            $status="debt";
        }
    }else{
        $status="paid off";
    }

    $sql="INSERT INTO `customerdebthistory`(
        `id_customer`, 
        `status`, 
        `user`, 
        `no_invoice`, 
        `nominal`, 
        `date`,
        `metode_pembayaran`,
        `catatan`
        ) VALUES (
            '".$sales_data["id_customer"]."',
            '$status',
            '".$mysqli->user_master."',
            '".$sales_data["id_customer"]."',
            '".$mysqli->real_escape_string($no_invoice)."',
            '".date("Y-m-d")."',
            'internal',
            '".$catatan."'
            )";
    $sql2 = "UPDATE `sales_data` SET `totalpay`='$totalpay' where `no_invoice` = '".$sales_data["no_invoice"]."'";
    if ($mysqli->query($sql) === TRUE && $mysqli->query($sql2) === TRUE) {
        echo "success";
        return;
    }
    echo "error query";
}
proses($mysqli);
?>