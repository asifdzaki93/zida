<?php
header('Content-Type: application/json');

require_once 'koneksi.php';
$sql="SELECT name_product as text,id_product as id FROM product WHERE showing = '0' AND packages = 'NO' AND $mysqli->user_master_query AND name_product like '%".$mysqli->real_escape_string($_REQUEST["search"]??"")."%' limit 10";
$results = [["text"=>"Pilih Produk","id"=>""]];
$query=$mysqli->query($sql);
while($row=$query->fetch_assoc()){
    array_push($results,$row);
};
echo json_encode(["results"=>$results]);
?>