<?php
	/**
	* Created by PhpStorm.
	* User: ahmad
	* Date: 20/08/2019
	* Time: 11:48 AM
	*/

	require_once("../connection.php");
		$tanggal	= gmdate("Y-m-d");

	$key=mysqli_real_escape_string($connect, $_POST['key']);
	$hargabeli=mysqli_real_escape_string($connect, $_POST['purchase_price']);
	$hargajual=mysqli_real_escape_string($connect, $_POST['selling_price']);
	$stok=mysqli_real_escape_string($connect, $_POST['stock']);
	
	$nama_barang=mysqli_real_escape_string($connect, $_POST['name_product']);
	$unit=mysqli_real_escape_string($connect, $_POST['unit']);
	$id_kategori=mysqli_real_escape_string($connect, $_POST['id_category']);
	$kodebarang=mysqli_real_escape_string($connect, $_POST['codeproduct']);
	$minimalstok=mysqli_real_escape_string($connect, $_POST['minimalstock']);
	$deskripsi=mysqli_real_escape_string($connect, $_POST['description']);
	$online=mysqli_real_escape_string($connect, $_POST['online']);
	$ada_stok=mysqli_real_escape_string($connect, $_POST['have_stock']);
	$hargagrosir=mysqli_real_escape_string($connect, $_POST['wholesale_price']);
	$minimal_pembelian=mysqli_real_escape_string($connect, $_POST['minimum_purchase']);
	$tax=mysqli_real_escape_string($connect, $_POST['tax']);
	$alertstock=mysqli_real_escape_string($connect, $_POST['alertstock']);

	$getusers = mysqli_query($connect,"SELECT * FROM users WHERE id_session='$key' AND blokir = 'N'");
	$u	      = mysqli_fetch_array($getusers);
	$count   = mysqli_num_rows($getusers);
	
	$masterakun = mysqli_query($connect,"SELECT * FROM users WHERE phone_number='$u[master]'");
	$m=mysqli_fetch_array($masterakun);

	if ($count > 0){
	
  include "../fungsi_thumb.php";
  
  $folder = date("m-d-y-H");
  
  $lokasi_file 		= $_FILES['img']['tmp_name'];
  $tipe_file   		= $_FILES['img']['type'];
  $nama_file   		= $_FILES['img']['name'];
  $acak        		= rand(1,99);
  $nama_file_unik	= $acak.$nama_file; 
  
	$date = gmdate("dHi");	
	$sesi ="$m[id_store]$acak$date";
	
	$masterproduct = mysqli_query($connect,"SELECT * FROM product WHERE user='$u[master]' ORDER BY id_product DESC LIMIT 1");
	$mp=mysqli_fetch_array($masterproduct);
	
    $masterproduct2 = mysqli_query($connect,"SELECT * FROM product WHERE user='$u[master]' AND codeproduct = '$kodebarang'");
	$mp2=mysqli_fetch_array($masterproduct2);
	

	
	$dates		= gmdate("dis");
        
        if($kodebarang == '' OR $mp2['codeproduct'] == ''){
            $kodebarangs = "$mp[id_product]-$dates";
        }else{
            $kodebarangs = $kodebarang;
        }
        
  
  
    if (!empty($lokasi_file)){

	UploadImage($nama_file_unik);
	mysqli_query($connect,"INSERT INTO product(name_product,
								  unit,
								  id_category,
								  codeproduct,
								  tax,
								  purchase_price,
								  selling_price,
								  stock,
								  minimalstock,
								  description,
								  folder,
								  img,
								  online,
								  have_stock,
								  wholesale_price,
								  minimum_purchase,
								  session,
								  alertstock,
                                  user) 
                    VALUES('$nama_barang',
						   '$unit',
						   '$id_kategori',
						   '$kodebarang',
						   '$tax',
						   '$hargabeli',
						   '$hargajual',
						   '$stok',
						   '$minimalstok',
						   '$deskripsi',
						   '$folder',
						   '$nama_file_unik',
						   '$online',
						   '$ada_stok',
						   '$hargagrosir',
						   '$minimal_pembelian',
						   '$sesi',
						   '$alertstock',
                           '$m[phone_number]')");
						   
	}else{
	mysqli_query($connect,"INSERT INTO product(name_product,
								  id_category,
								  unit,
								  codeproduct,
								  tax,
								  purchase_price,
								  selling_price,
								  stock,
								  minimalstock,
								  description,
								  img,
								  online,
								  have_stock,
								  wholesale_price,
								  minimum_purchase,
								  session,
								  alertstock,
                                  user) 
                    VALUES('$nama_barang',
						   '$id_kategori',
						   '$unit',
						   '$kodebarang',
						   '$tax',
						   '$hargabeli',
						   '$hargajual',
						   '$stok',
						   '$minimalstok',
						   '$deskripsi',
						   'no_product.png',
						   '$online',
						   '$ada_stok',
						   '$hargagrosir',
						   '$minimal_pembelian',
						   '$sesi',
						   '$alertstock',
                           '$m[phone_number]')");
	}
  
  
  	$databarang = mysqli_query($connect,"SELECT * FROM product WHERE session='$sesi' AND user='$m[phone_number]'");
	$b=mysqli_fetch_array($databarang);
	
	$datastok = mysqli_query($connect,"SELECT * FROM stock WHERE session='$sesi' AND user='$m[phone_number]'");
	$s=mysqli_fetch_array($datastok);

	if($ada_stok == 1 ){
			 mysqli_query($connect,"INSERT INTO stock(id_product,
									       id_store,
										   stock,
										   session,
										   user) 
									VALUES('$b[id_product]',
										   '$m[id_store]',
										   '$stok',
										   '$sesi',
										   '$m[phone_number]')");
										   
										   
						   mysqli_query($connect,"INSERT INTO history_stock(id_product,
								  id_store,
								  stock,
								  detail,
								  status,
								  date,
                                  user) 
					VALUES('$b[id_product]',
						   '$m[id_store]',
						   '$stok',
						   'First Stock $sesi',
						   '0',
						   '$tanggal',
                           '$m[phone_number]')");
	}
	mysqli_query($connect,"INSERT INTO pricevariant(minimal,
								  nominal,
								  id_product,
                                  user) 
                    VALUES('1',
						   '$hargajual',
						   '$b[id_product]',
                           '$m[phone_number]')");

	$json = array(
    'status' 	=> 'true',
    'errCode' 	=> '01',
	'msg' 		=> 'Success'
   );

    echo json_encode($json);

	}else{
	
	
	$json = array(
    'status' 	=> 'true',
    'errCode' 	=> '00',
	'msg' 		=> 'You cannot use this feature'
   );

    echo json_encode($json);	
	}
?>