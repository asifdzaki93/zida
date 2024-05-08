<?php

require_once 'koneksi.php'; // Menggunakan file koneksi yang sama
function proses($mysqli){
	//Basic data
	$catatan = $_POST['catatan']??"";
	$id_customer = $_POST['id_customer']??"";
    $operator=$_POST['operator']??"";
	$date = date("y-m-d");
    $due_date=$_POST['due_date']??"";
	if($due_date==""){
		$due_date=$date;
	}
	$totalpay=$_POST['totalpay']??"0";

	//Mendapatkan nomor invoice dan id store
	$query = $mysqli->query("SELECT store.kode,store.name_store,store.id_store FROM store 
	left join users ON store.id_store = users.id_store 
	WHERE users.phone_number='".$mysqli->real_escape_string($operator)."'");
	$dt = null;
	while($row=$query->fetch_array()){
		$dt = $row;
		break;
	}
	if($dt==null){
		echo "Toko ".$operator." tidak ditemukan";
		return;
	}
	$query = $mysqli->query("SELECT id_sales_data FROM sales_data order by id_sales_data desc");
	$id_sales_data = "0";
	while($row=$query->fetch_array()){
		$id_sales_data = $row["id_sales_data"];
		break;
	}
	$kode = "";
	if(!empty($dt['kode'])){
		$kode = $dt['kode'];
	}
	else{
		$nama = $dt['name_store'];
		$arr = explode(' ', $nama);
		$singkatan = "";
		foreach($arr as $kata)
		{
		$singkatan .= substr($kata, 0, 1);
		}
		$kode= strtoupper($singkatan);
	}
	$tglkr = date("dmy",strtotime($due_date));
	$no_invoice	= "$id_sales_data-$kode"."M".date("d")."-P"."$tglkr";
	$id_store = $dt["id_store"];

	//buat Note
	$note = $mysqli->real_escape_string("Jam Acara : ".($_POST["jam_acara"]??"").
    ", Jenis Pengiriman : ".($_POST["jenis_pengiriman"]??"").
    ", Catatan : ".($_POST["catatan"]??"")." (di edit admin pada ".date("Y-m-d H:i:s").")");

	//Buat Invoice kosong
	$sql = "INSERT INTO `sales_data`(
		`user`, 
		`shift`, 
		`id_customer`, 
		`id_store`, 
		`no_invoice`, 
		`date`, 
		`payment`, 
		`note`, 
		`totalorder`, 
		`totalprice`, 
		`totalpay`, 
		`changepay`, 
		`status`, 
		`due_date`, 
		`tax`, 
		`discount`, 
		`service_charge`, 
		`operator`, 
		`location`, 
		`id_table`, 
		`img`, 
		`ongkir`, 
		`divisi`
		) VALUES (
			'$mysqli->user_master',
			'',
			'".$mysqli->real_escape_string($id_customer)."',
			'$id_store',
			'$no_invoice',
			'$date',
			'',
			'$note',
			'0',
			'0',
			'0',
			'0',
			'create',
			'".$mysqli->real_escape_string($due_date)."',
			'0',
			'0',
			'0',
			'".$mysqli->real_escape_string($operator)."',
			'',
			'0',
			'',
			'0',
			''
			)";
	if ($mysqli->query($sql) === TRUE ) {
	}else{
		echo "Error membuat invoice";
		return;
	}

	$totalorder = 0;
	$product_dibeli=explode(",",$_POST['product_dibeli']??"");
	$statusSD = "pre order";
	$status = "dp";
	foreach($product_dibeli as $product_dibeliX){
		$id_product=explode(":",$product_dibeliX)[0]??"";
		$amount=(int) explode(":",$product_dibeliX)[1]??"1";
		if($id_product=="" || $no_invoice==""){
			continue;
		}
		$productX = $mysqli->query("select selling_price from product where $mysqli->user_master_query and id_product = '".$mysqli->real_escape_string($id_product)."'");
		$product = [];
		while ($row = $productX->fetch_assoc()) {
			$product = $row;
		}
		if($product==null){
			continue;
		}
		$totalprice=$amount*$product["selling_price"];
		$sql = "INSERT INTO `sales`(
			`id_customer`, 
			`id_product`, 
			`id_store`, 
			`user`, 
			`no_invoice`, 
			`amount`, 
			`price`, 
			`totalprice`, 
			`totalcapital`, 
			`date`, 
			`due_date`, 
			`status`, 
			`note`, 
			`rest_stock`, 
			`ppob`
			) VALUES (
				'".$mysqli->real_escape_string($id_customer)."',
				'".$mysqli->real_escape_string($id_product)."',
				'".$mysqli->real_escape_string($id_store)."',
				'".$mysqli->user_master."',
				'".$mysqli->real_escape_string($no_invoice)."',
				'$amount',
				'".$product["selling_price"]."',
				'$totalprice',
				'0',
				'".$date."',
				'".$due_date."',
				'".$statusSD."',
				'Admin Edit',
				'0',
				'0'
				)";
		if ($mysqli->query($sql) === TRUE) {
			$totalorder+=$totalprice;
		}
	}

	//CEK STATUS
	$changepay = 0;
	if($totalorder<=$totalpay){
		$status="paid off";
		$statusSD=$status;
		$changepay=$totalpay-$totalorder;
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
			'".$mysqli->real_escape_string($id_customer)."',
			'$status',
			'".$mysqli->user_master."',
			'".$mysqli->real_escape_string($no_invoice)."',
			'".$mysqli->real_escape_string($totalpay)."',
			'".date("Y-m-d")."',
			'internal',
			'diinput oleh sistem'
			)";
	$sql2 = "UPDATE `sales_data` SET 
	`status`='$statusSD',
	`totalorder`='$totalorder',
	`totalpay`='".$mysqli->real_escape_string($totalpay)."', 
	`changepay`='".$mysqli->real_escape_string($changepay)."' 
	where `no_invoice` = '".$no_invoice."'";
	$sql3 = "UPDATE `sales` SET `status`='$statusSD' where `no_invoice` = '".$no_invoice."'";
	if ($mysqli->query($sql) === TRUE && $mysqli->query($sql2) === TRUE && $mysqli->query($sql3) === TRUE) {
		echo "success|".$no_invoice;
		return;
	}
	echo "error query";	
}
proses($mysqli);