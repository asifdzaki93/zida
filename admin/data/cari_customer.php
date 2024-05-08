<?php
header('Content-Type: application/json');

require_once 'koneksi.php';
$sql="SELECT name_customer as text,id_customer as id FROM customer WHERE name_customer like '%".$mysqli->real_escape_string($_REQUEST["search"]??"")."%' limit 10";
$results = [["text"=>"Pilih Kostumer","id"=>""]];
$query=$mysqli->query($sql);
while($row=$query->fetch_assoc()){
    array_push($results,$row);
};
echo json_encode(["results"=>$results]);
?>