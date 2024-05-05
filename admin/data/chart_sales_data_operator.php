<?php
include "koneksi.php";  // Include your database connection setup

header('Content-Type: application/json');

$nomer = 1;
$skrg = $mysqli->tanggal_sekarang;
//date('Y-m-d');
$query = $mysqli->query(
"SELECT 
users.full_name AS penanggungjawab,
SUM(IF(sales_data.totalpay <= sales_data.totalorder,
    sales_data.totalorder+sales_data.changepay,
    sales_data.totalpay-sales_data.changepay)) AS jml FROM sales_data JOIN users ON
    sales_data.operator=users.phone_number WHERE sales_data.date='$skrg' AND
    sales_data.user='$mysqli->user_master' AND status NOT IN ('cancel') GROUP BY
    sales_data.operator ORDER BY jml DESC; "
);
$penanggungjawab = [];
$jml = [];
$data = [];
while($row = $query->fetch_assoc()){
    array_push($penanggungjawab,$row["penanggungjawab"]);
    array_push($jml,$row["jml"]);
    array_push($data,$row);
}

echo json_encode(compact("data","penanggungjawab","jml"));