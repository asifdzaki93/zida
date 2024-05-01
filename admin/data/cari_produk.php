<?php
header('Content-type: application/json');
require_once 'koneksi.php'; // Menggunakan file koneksi yang sama
$q="SELECT
id_product,
name_product,
selling_price,
packages,
folder,
img
FROM product 
WHERE $mysqli->user_master_query AND name_product LIKE '%".$mysqli->real_escape_string($_GET["name_product"]??"")."%' ";
$packages = $_GET["packages"]??"";
if($packages!=""){
    $q.="AND packages = '".$mysqli->real_escape_string($packages)."' ";
}
$q.="ORDER BY name_product ASC LIMIT 10 ";
$query = $mysqli->query($q);
$products=[];
while ($product = $query->fetch_assoc()) {
    if ($product['img'] !== "" && $product['folder'] !== "") {
        $sumber = "https://zieda.id/pro/geten/images/" .$product['folder']."/". $product['img'];
    } else {
        $sumber = "https://zieda.id/pro/geten/images/no_image.jpg";
    }
    $product['img']=$sumber;
    array_push($products,$product);
}

$output = [
    "products"=>$products,
];

echo json_encode($output, JSON_PRETTY_PRINT);