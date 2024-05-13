<?php
header('Content-type: application/json');
require_once 'koneksi.php'; // Menggunakan file koneksi yang sama
$q = "SELECT
id_product,
name_product,
description,
selling_price,
packages,
folder,
img
FROM product 
WHERE $mysqli->user_master_query AND showing = '0' AND name_product LIKE '%" . $mysqli->real_escape_string($_GET["name_product"] ?? "") . "%' ";
$packages = $_GET["packages"] ?? "NO";
if ($packages != "") {
    $q .= "AND packages = '" . $mysqli->real_escape_string($packages) . "' ";
}
$q .= "ORDER BY id_product DESC LIMIT 50 ";
$query = $mysqli->query($q);
$products = [];
while ($product = $query->fetch_assoc()) {
    if ($product['img'] !== "" && $product['folder'] !== "") {
        $sumber = "https://zieda.id/pro/geten/images/" . $product['folder'] . "/" . $product['img'];
    } else {
        $sumber = "https://zieda.id/pro/geten/images/no_image.jpg";
    }
    $product['img'] = $sumber;

    if ($product['description'] !== "") {
        $desk = $product['description'] = ucwords(strtolower($product['description']));
    } else {
        $desk = $product['description'] =  "Belum Ada Deskripsi Produk.";
    }
    $product['description'] = $desk;

    $product['name_product'] = ucwords(strtolower($product['name_product']));
    array_push($products, $product);
}

$output = [
    "products" => $products,
];

echo json_encode($output, JSON_PRETTY_PRINT);