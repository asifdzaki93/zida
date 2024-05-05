<?php
header('Content-Type: application/json');

require_once 'koneksi.php';
$due_date=$_GET["due_date"]??date("Y-m-d");
$due_date_last=$_GET["due_date_last"]??date("Y-m-d");
$filter_query = "0";
$filter=explode(",",$_GET["filter"]??"");
if(in_array("paid off",$filter)){
    $filter_query.=" or totalpay >= totalorder";
}
if(in_array("pre order",$filter)){
    $filter_query.=" or totalpay < totalorder";
}


$datequery = "STR_TO_DATE(due_date,'%Y-%m-%d') BETWEEN '".$mysqli->real_escape_string($due_date)."' AND '".$mysqli->real_escape_string($due_date_last)."'";
$sql="SELECT totalpay,totalorder,no_invoice,due_date,note FROM sales_data WHERE $mysqli->user_master_query";
$sql.="and $datequery and ($filter_query)";
$result = [];
$query=$mysqli->query($sql);
while($row=$query->fetch_assoc()){
    $row["filter"]=$row["totalorder"]>$row["totalpay"]?"pre order":"paid off";
    array_push($result,$row);
};
echo json_encode(["result"=>$result,"query"=>$sql]);
?>