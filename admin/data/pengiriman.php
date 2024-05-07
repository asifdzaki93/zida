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

$operatorquery = "1";
if(!empty($_GET["operator"])){
    $operatorquery = "operator = '".$mysqli->real_escape_string($_GET["operator"])."'";
}

$datequery = "STR_TO_DATE(due_date,'%Y-%m-%d') BETWEEN '".$mysqli->real_escape_string($due_date)."' AND '".$mysqli->real_escape_string($due_date_last)."'";
$sql="SELECT totalpay,totalorder,no_invoice,due_date,note FROM sales_data WHERE $mysqli->user_master_query";
$sql.="and $datequery and $operatorquery and ($filter_query)";
$result = [];
$query=$mysqli->query($sql);
$i = 1;
while($row=$query->fetch_assoc()){
    $jam = explode(", ",$row["note"]??"")[1]??"";
    $jam = explode(" : ",$jam??"")[1]??"";
    $jam = explode(" | ",$jam??"")[0]??"";
    $jam = $jam == "Sore" ? "14:00" : "07:00";
    $objDate = date("c",strtotime($row["due_date"] . " " . $jam));
    $calendar=$row["totalorder"]>$row["totalpay"]?"pre order":"paid off";

    array_push($result,[
        "id"=>$i,
        "url"=>"",
        "title"=>$row["no_invoice"],
        "start"=>$objDate,
        "end"=>$objDate,
        "allDay"=>false,
        "extendedProps"=> [
            "no_invoice"=> $row["no_invoice"],
            "calendar"=> $calendar
        ]
    ]);
    $i++;
};
echo json_encode(["result"=>$result]);
?>