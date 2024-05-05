<?php
header('Content-Type: application/json');

require_once 'koneksi.php';
$sql="SELECT full_name as text,phone_number as id FROM users WHERE master = '$mysqli->user_master'
 and full_name like '%".$mysqli->real_escape_string($_REQUEST["search"]??"")."%' limit 10";
$results = [["text"=>"Semua Operator","id"=>""]];
$query=$mysqli->query($sql);
while($row=$query->fetch_assoc()){
    array_push($results,$row);
};
echo json_encode(["results"=>$results]);
?>