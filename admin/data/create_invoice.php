<?php
	/**
	* Created by PhpStorm.
	* User: ahmad
	* Date: 20/08/2019
	* Time: 11:48 AM
	*/

	require_once("../connection.php");
	include "../fungsi_thumb.php";
	
	$data=mysqli_real_escape_string($connect, $_POST['data']);
	
	$trimmed = str_replace("\\", "", $data);
    $decoded 	= json_decode($trimmed, true);

	$timestamp = new DateTime(null, new DateTImeZone('Asia/Jakarta'));
	$tanggal = $timestamp->format('Y-m-d');
	$time = $timestamp->format('H:i');

	$id_table							= $decoded["id_table"];
	$id_pelanggan						= $decoded["id_customer"];
	$operator							= $decoded["id"];
	$jatuh_tempo						= $decoded["due_date"];
	$total_order						= $decoded["total_order"];
	$key								= $decoded["key"];
	$tipe_pembayaran					= $decoded["payment_type"];
	$service_charge						= $decoded["service_charge"];
	$pajak								= $decoded["tax"];
	$id_diskon							= $decoded["id_discount"];
	$card								= $decoded["card"];
	$latitude							= $decoded["latitude"];
	$longitude							= $decoded["longitude"];
	$keterangan							= $decoded["note"];
	$jumlah_pembayaran					= $decoded["payment_amount"];
	$ongkir					= $decoded["ongkir"];
	$divisi					= $decoded["divisi"];

	$getusers	= mysqli_query($connect,"SELECT * FROM users WHERE id_session='$key' AND blokir = 'N'");
	$u	   		= mysqli_fetch_array($getusers);
	$jumlah   	= mysqli_num_rows($getusers);
	
	
	$masterakun = mysqli_query($connect,"SELECT * FROM users WHERE phone_number='$u[master]'");
	$m=mysqli_fetch_array($masterakun);
	
	 if($operator==""){
			$operatordata= $u['phone_number'];				   
	}else{
			$operatordata= "$operator";				   
	}
	
	$querydp = mysqli_query($connect,"SELECT id_sales_data FROM sales_data WHERE user='$m[phone_number]' ORDER BY id_sales_data DESC LIMIT 1");
	$dp=mysqli_fetch_array($querydp);
	
	$datatoko = mysqli_query($connect,"SELECT * FROM store WHERE id_store='$u[id_store]'");
	$dt=mysqli_fetch_array($datatoko);
	
	$datadiskon = mysqli_query($connect,"SELECT * FROM discount WHERE id_discount='$id_diskon'");
	$d=mysqli_fetch_array($datadiskon);
	
	if($d['type']=='prosentase'){
		$diskons=$total_order*$d['prosentase']/100;
		$diskon=$diskons;
	}else{
		$diskon=$d['nominal'];
	}
	
	$hargasetelahdiskon=$total_order-$diskon;
	
    $nominalscc=$hargasetelahdiskon*$dt['service_charge']/100;
    $nominalsc=$nominalscc;
	$total_service_charge=$hargasetelahdiskon+$nominalsc;
	
	$nominalpajaks=$total_service_charge*$dt['tax']/100;
	$nominalpajak=$nominalpajaks;
	$total_bayar=$total_service_charge+$nominalpajak+$ongkir;

	if ($jumlah > 0){
	
	$date		= gmdate("dis");
	
	$nama = $dt['name_store'];
	$arr = explode(' ', $nama);
	$singkatan = "";
	foreach($arr as $kata)
	{
	$singkatan .= substr($kata, 0, 1);
	}
	if(preg_match("/Zieda Bakery Pusat/i", $nama)){
	    $kode= "PS"; 
	}
	elseif(preg_match("/Zieda Banyu/i", $nama)){
	    $kode= "BP"; 
	}
	elseif(preg_match("/Zieda Bawang/i", $nama)){
	    $kode= "BW"; 
	}
	elseif(preg_match("/Zieda Bandar/i", $nama)){
	    $kode= "BD"; 
	}
	elseif(preg_match("/Zieda Weleri/i", $nama)){
	    $kode= "WL"; 
	}
	elseif(preg_match("/Zieda Sukorejo/i", $nama)){
	    $kode= "SR";
	}
	elseif(preg_match("/Zieda Pegandon/i", $nama)){
	    $kode= "PG"; 
	}
	elseif(preg_match("/Zieda Kendal/i", $nama)){
	    $kode= "KD"; 
	}
	elseif(preg_match("/Zieda Doro/i", $nama)){
	    $kode= "DR"; 
	}
	elseif(preg_match("/Zieda Kedung/i", $nama)){
	    $kode= "KW"; 
	}
	elseif(preg_match("/Zieda Kajen/i", $nama)){
	    $kode= "KJ"; 
	}
	elseif(preg_match("/Zieda Petarukan/i", $nama)){
	    $kode= "PR"; 
	}
	elseif(preg_match("/Zieda Agen Batang/i", $nama)){
	    $kode= "BT"; 
	}
	elseif(preg_match("/Zieda Agen Wonopring/i", $nama)){
	    $kode= "WP"; 
	}
	else{
		$kode= strtoupper($singkatan);
	}
		
    	$querynomor = mysqli_query($connect,"
    	SELECT count(id_sales_data) AS jml, DATE_FORMAT(CURRENT_DATE,'%d') AS tgl FROM sales_data WHERE id_store='$u[id_store]' AND date=CURRENT_DATE AND due_date !='0000-00-00'");
    	$pre=mysqli_fetch_array($querynomor);
	
	$nourut = $dp['id_sales_data']+1; // kode_barang dengan angka terbesar
	$serial_number = $nourut; // mencetak no urut dengan 4 angka, lihat bedanya jika hanya menggunakan echo $nourut;
	$sn = sprintf("%04s", $nourut) ; // mencetak no urut dengan 4 angka, lihat bedanya jika hanya menggunakan echo $nourut;
	$nourt=$pre['jml']+1;//nomor pesanan berisi jumlah preorder hari itu toko itu +1
	$tglkr=date("dmy", strtotime($jatuh_tempo));
	$no_invoice	= "$nourt-$kode"."M".date(d)."-P"."$tglkr";
	
	if($tipe_pembayaran==1){
	    if($dt['typestore']=="Culinary"){
		$status="billing";
	}else{
		$status="process";
	}
	    $dateproccess = $tanggal;
	    $kembalian	= 0;
	}else{
		$status="pre order";
	    $dateproccess = $jatuh_tempo;	
	    $kembalian	= $jumlah_pembayaran-$total_bayar;
	}
	
	for($x = 0; $x<count($decoded["product"]); $x++)
        {
	$id_barang			= $decoded["product"][$x]["id_product"];
	$jumlah_barang		= $decoded["product"][$x]["amount_product"];
	$catatan			= $decoded["product"][$x]["notes"];



	$barang = mysqli_query($connect,"SELECT * FROM product WHERE id_product='$id_barang'");
	$b=mysqli_fetch_array($barang);


	$totalharga	=$b['selling_price']*$jumlah_barang;
	$stok		=$b['stock']-$jumlah_barang;
    $stoknya		=$b['stock']-$jumlah_barang;

	mysqli_query($connect,"INSERT INTO sales(id_product, amount, id_customer, id_store, user, no_invoice, status, price, totalprice, date, due_date, note, rest_stock) 
                    VALUES('$id_barang', '$jumlah_barang', '$id_pelanggan', '$u[id_store]', '$m[phone_number]', '$no_invoice', '$status', '$b[selling_price]', '$totalharga', '$tanggal', '$jatuh_tempo', '$catatan', '$stoknya')");
  	
if($b['packages']=="YES"){
        
	$pack = mysqli_query($connect,"SELECT * FROM packagesproduct WHERE sesi='$b[session]'");
	$bp=mysqli_fetch_array($pack);
	
	$packb = mysqli_query($connect,"SELECT * FROM product WHERE id_product='$bp[id_product]'");
	$bps=mysqli_fetch_array($packb);
	
	$totalharga	=$bp['price']*$jumlah_barang*$bp['amount'];
	$stok		=$bp['stock']-$jumlah_barang*$bp['amount'];
	$datastosk = mysqli_query($connect,"SELECT * FROM stock WHERE id_product='$bp[id_product]' AND id_store='$u[id_store]'");
	$ss=mysqli_fetch_array($datastosk);
    $stoknya		=$ss['stock']-$jumlah_barang;
    
			if($bps['have_stock']=='1'){
			mysqli_query($connect,"UPDATE stock SET stock   = '$stoknya' WHERE id_product  = '$bp[id_product]' AND id_store='$u[id_store]'");
			
			
						
						   mysqli_query($connect,"INSERT INTO history_stock(id_product,
								  id_store,
								  stock,
								  detail,
								  status,
								  date,
                                  user) 
					VALUES('$bp[id_product]',
						   '$u[id_store]',
						   '$jumlah_barang',
						   'Transaction Packages  $no_invoice',
						   '1',
						   '$tanggal',
                           '$m[phone_number]')");
						   
			}
	
	
	
	}else{  	
  	
  		if($b['have_stock']=='1'){
		mysqli_query($connect,"UPDATE product SET stock   = '$stok' WHERE id_product  = '$id_barang' AND id_store='$u[id_store]' ");
		
						   mysqli_query($connect,"INSERT INTO history_stock(id_product,
								  id_store,
								  stock,
								  detail,
								  status,
								  date,
                                  user) 
					VALUES('$id_barang',
						   '$u[id_store]',
						   '$jumlah_barang',
						   'Transaction  $no_invoice',
						   '1',
						   '$tanggal',
                           '$m[phone_number]')");
		}
	}
	
	
	$datarecipe = "SELECT * FROM recipe WHERE id_product='$id_barang' AND active = '0'";
	$datahasil = mysqli_query($connect,$datarecipe);
	while($rc = mysqli_fetch_array($datahasil)){
	
		$datastockrc = mysqli_query($connect,"SELECT * FROM recipe WHERE id_raw_material  = '$rc[id_raw_material]' AND id_product='$id_barang'");
		$sc=mysqli_fetch_array($datastockrc);	
		
		$datastockraw = mysqli_query($connect,"SELECT * FROM raw_material WHERE id_raw_material  = '$rc[id_raw_material]' AND id_store='$u[id_store]'");
		$sr=mysqli_fetch_array($datastockraw);		
	
		$stockrw = $sr['stock']-$sc['stock']*$jumlah_barang;
		$opname = $sc['stock']*$jumlah_barang;
		$desc = "$b[name_product], $jumlah_barang x@$sc[stock] $sr[unit] Order id: $no_invoice";
	
	mysqli_query($connect,"UPDATE raw_material SET stock   = '$stockrw' WHERE id_raw_material  = '$rc[id_raw_material]' AND id_store='$u[id_store]'");	
	mysqli_query($connect,"INSERT INTO history_stock_raw_material(id_raw_material,
								  id_store,
								  stock,
								  detail,
								  status,
								  date,
                                  user) 
					VALUES('$rc[id_raw_material]',
						   '$u[id_store]',
						   '$opname',
						   '$desc',
						   '1',
						   '$dateproccess',
                           '$m[phone_number]')");	
	}
	
	$pesanannya='';
    $pesanannya .='* '.$b[name_product].'
    ';
		
		}

		
			mysqli_query($connect,"UPDATE db_table SET status   = '1' WHERE id_table  = '$id_table'");
			
			$folder = date("m-d-y-H");
  
  $lokasi_file 		= $_FILES['img']['tmp_name'];
  $tipe_file   		= $_FILES['img']['type'];
  $nama_file   		= $_FILES['img']['name'];
  $acak        		= rand(1,99);
  $nama_file_unik	= $acak.$nama_file; 


	if (!empty($lokasi_file)){
        UploadOrder($nama_file_unik);
        mysqli_query($connect,"INSERT INTO sales_data(id_customer,
								  no_invoice,
								  date,
								  id_store,
								  totalorder,
								  totalprice,
								  totalpay,
								  changepay,
								  status,
								  due_date,
								  operator,
								  tax,
								  discount,
								  service_charge,
								  id_table,
								  location,
								  note,
                                  user,
                                  ongkir,
                                  divisi,
                                  img) 
                    VALUES('$id_pelanggan',
						   '$no_invoice',
						   '$tanggal',
						   '$u[id_store]',
						   '$total_bayar',
						   '$total_order',
						   '$jumlah_pembayaran',
						   '$kembalian',
						   '$status',
						   '$jatuh_tempo',
						   '$operatordata',
						   '$nominalpajak',
						   '$diskon',
						   '$nominalsc',
						   '$id_table',
						   '$latitude, $longitude',
						   '$keterangan',
                           '$m[phone_number]',
                           '$ongkir',
						   '$divisi',
                           '$folder/$nama_file_unik')");
	}else{
		    
	mysqli_query($connect,"INSERT INTO sales_data(id_customer,
								  no_invoice,
								  date,
								  id_store,
								  totalorder,
								  totalprice,
								  totalpay,
								  changepay,
								  status,
								  due_date,
								  operator,
								  tax,
								  discount,
								  service_charge,
								  id_table,
								  location,
								  note,
								  ongkir,
								  divisi,
                                  user) 
                    VALUES('$id_pelanggan',
						   '$no_invoice',
						   '$tanggal',
						   '$u[id_store]',
						   '$total_bayar',
						   '$total_order',
						   '$jumlah_pembayaran',
						   '$kembalian',
						   '$status',
						   '$jatuh_tempo',
						   '$operatordata',
						   '$nominalpajak',
						   '$diskon',
						   '$nominalsc',
						   '$id_table',
						   '$latitude, $longitude',
						   '$keterangan',
						   '$ongkir',
						   '$divisi',
                           '$m[phone_number]')");	    
		    
		}
						   
						   if($operator==""){
							   
						   }else{
							   
	$oprt = mysqli_query($connect,"SELECT * FROM users WHERE phone_number='$operator'");
	$op=mysqli_fetch_array($oprt);




		mysqli_query($connect,"INSERT INTO history_job(no_invoice,
								  note,
								  operator,
								  status,
								  date,
                                  user) 
					VALUES('$no_invoice',
						   'Transaksi $no_invoice Ditugaskan Kepada $op[full_name]',
						   '$operator',
						   '$status',
						   '$tanggal $time',
                           '$m[phone_number]')");
						   }
						   

	$responses = array(
    'status' 	=> 'true',
    'errCode' 	=> '01',
	'msg' 		=> 'Success'
	);
	
  
	$responses["data"] = array(
	'invoice' 	=> $no_invoice
	);
  

	echo json_encode($responses);


	}else{
	
	
	$json = array(
    'status' 	=> 'true',
    'errCode' 	=> '00',
	'msg' 		=> 'User Not Found'
	);

    echo json_encode($json);	
	}


//-------------------------------------------------------------------------------------------------//
//Whatsapp Gateway
//-------------------------------------------------------------------------------------------------//
	function tanggal_indo($tanggal, $cetak_hari = false)
{
	$hari = array ( 1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);
			
	$bulan = array (1 =>   'Jan',
				'Feb',
				'Mar',
				'Apr',
				'Mei',
				'Jun',
				'Jul',
				'Ags',
				'Sep',
				'Okt',
				'Nov',
				'Des'
			);
	$split 	  = explode('-', $tanggal);
	$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	
	if ($cetak_hari) {
		$num = date('N', strtotime($tanggal));
		return $hari[$num] . ', ' . $tgl_indo;
	}
	return $tgl_indo;
}
//echo tanggal_indo ('2016-03-20'); // Hasil: 20 Maret 2016;
//echo tanggal_indo ('2016-03-20', true); // Hasil: Minggu, 20 Maret 2016
	
	
	


function gantiformat($nomorhp) {
	//Terlebih dahulu kita trim dl
	$nomorhp = trim($nomorhp);
   //bersihkan dari karakter yang tidak perlu
	$nomorhp = strip_tags($nomorhp);     
   // Berishkan dari spasi
   $nomorhp= str_replace(" ","",$nomorhp);
   // bersihkan dari bentuk seperti  (022) 66677788
	$nomorhp= str_replace("(","",$nomorhp);
   // bersihkan dari format yang ada titik seperti 0811.222.333.4
	$nomorhp= str_replace(".","",$nomorhp); 
   
//cek apakah mengandung karakter + dan 0-9
if(!preg_match('/[^+0-9]/',trim($nomorhp))){
	// cek apakah no hp karakter 1-3 adalah +62
	if(substr(trim($nomorhp), 0, 3)=='+62'){
		$nomorhp= trim($nomorhp);
	}
	// cek apakah no hp karakter 1 adalah 0
   elseif(substr($nomorhp, 0, 1)=='0'){
		$nomorhp= '62'.substr($nomorhp, 1);
	}
}
return $nomorhp;
}

$nomer          = gantiformat($op[phone_number]);
$pelanggane     = mysqli_query($connect,"SELECT * FROM customer WHERE id_customer='$id_pelanggan'");
$singpesen      = mysqli_fetch_array($pelanggane);
$wonge          = $singpesen[name_customer];
$alamate         = $singpesen[address];
//$nomer2         = gantiformat($u[master]);
$nomer2         = gantiformat($op[phone_number]);
$cekgateway     = mysqli_query($connect,"SELECT * FROM whatsapp WHERE user='$dt[user]' LIMIT 1");
$gw             = mysqli_fetch_array($cekgateway);
$defaultsender  = '628895134879';
$plgne          = gantiformat($singpesen[telephone]);

for($x = 0; $x<count($decoded["product"]); $x++)
	   {
   $id_barang			= $decoded["product"][$x]["id_product"];
   $jumlah_barang		= $decoded["product"][$x]["amount_product"];
   $catatan			= $decoded["product"][$x]["notes"];

   $barang = mysqli_query($connect,"SELECT * FROM product WHERE id_product='$id_barang'");
   $b=mysqli_fetch_array($barang);
   $totalharga	=$b['selling_price']*$jumlah_barang;

   if($b['packages']=='YES'){
	   $ddd  ='
   Isi Paket:';
   $isi = mysqli_query($connect,"SELECT * FROM packagesproduct WHERE sesi='$b[session]' AND user='$m[phone_number]'");
   while ($i=mysqli_fetch_array($isi)){
	   $ddd .='
   - _'.ucwords(strtolower($i[name_product])).'_ - _'.($jumlah_barang*$i[amount]).'_';}
   }else{
	  $ddd=''; 
   }

   $ccc='';
   $cccc .='* _*'.$b[name_product].'*_'. 
   $ddd.'
   *_('.$jumlah_barang.' × Rp. '.number_format($b[selling_price],0,",",".").' = Rp. '.number_format($totalharga,0,",",".").')_*
';
	   }

for($x = 0; $x<count($decoded["product"]); $x++)
	   {
   $id_barang			= $decoded["product"][$x]["id_product"];
   $jumlah_barang		= $decoded["product"][$x]["amount_product"];
   $catatan			= $decoded["product"][$x]["notes"];

   $barang = mysqli_query($connect,"SELECT * FROM product WHERE id_product='$id_barang'");
   $b=mysqli_fetch_array($barang);
   $totalharga	=$b['selling_price']*$jumlah_barang;

   if($b['packages']=='YES'){
	   $ggg  ='
   Isi Paket:';
   $isi = mysqli_query($connect,"SELECT * FROM packagesproduct WHERE sesi='$b[session]' AND user='$m[phone_number]'");
   while ($i=mysqli_fetch_array($isi)){
	   $ggg .='
   - __'.ucwords(strtolower($i[name_product])).'__ - __'.($jumlah_barang*$i[amount]).'__';}
   }else{
	  $ggg=''; 
   }

   $hhh='';
   $hhhh .='* __**'.$b[name_product].'**__'. 
   $ggg.'
   **__('.$jumlah_barang.' × Rp. '.number_format($b[selling_price],0,",",".").' = Rp. '.number_format($totalharga,0,",",".").')__**
';
	   }

for($x = 0; $x<count($decoded["product"]); $x++)
	   {
   $id_barang			= $decoded["product"][$x]["id_product"];
   $jumlah_barang		= $decoded["product"][$x]["amount_product"];
   $catatan			= $decoded["product"][$x]["notes"];

   $barang = mysqli_query($connect,"SELECT * FROM product WHERE id_product='$id_barang'");
   $b=mysqli_fetch_array($barang);
   $totalharga	=$b['selling_price']*$jumlah_barang;

   if($b['packages']=='YES'){
	   $fff  ='
   Isi Paket:';
   $isi2 = mysqli_query($connect,"SELECT * FROM packagesproduct WHERE sesi='$b[session]' AND user='$m[phone_number]'");
   while ($i=mysqli_fetch_array($isi2)){
	   $fff .='
   - '.ucwords(strtolower($i[name_product])).' - '.($jumlah_barang*$i[amount]).'';}
   }else{
	  $fff=''; 
   }

   $eee='';
   $eeee .='* '.$b[name_product].''. 
   $fff.'
   ('.$jumlah_barang.' × Rp. '.number_format($b[selling_price],0,",",".").' = Rp. '.number_format($totalharga,0,",",".").')
';
	   }


   if($gw['user'] == $dt['user']){
	   $sender     = $gw['phone_sender'];
   }else{
	   $sender     = $defaultsender;
   }


   if($status == 'pre order'){$jt = $jatuh_tempo;}else{$jt='Order Langsung';}
   $jatuh= $jt;
   if($dt[user] == '082322345757'){
	   $tipe = '1';
	   $zid = 'Invoice PDF';
	   $zida = 'https://pro.kasir.vip/pdf/invoice.php?no_invoice='.$no_invoice;
   }else{
	   $tipe = '';
	   $zid='';
	   $zida='';
   }
   $tpe= $tipe;
   $hyp= $zid;
   $link= $zida;
   $imgcstm= "https://pro.kasir.vip/geten/images/order/$folder/$nama_file_unik";
	   
    
    
    $catatannya=$keterangan;
    //$hasil = str_replace(['Jam Acara : ', ' Jenis Pengiriman : ', ' | ',' Catatan : ' ], ['#', '#', '#', '#'], $catatannya);
    $hasil = str_replace(['Event hours:','Jam acara : ', 'Jam Acara : ', ' Waktu Pengiriman : ',' Jenis Pengiriman : ', ' | ',' Catatan : ' ,'nn','nInput','nAdm','ninput','nadm'], ['#','#', '#', '#', '#', '#','#','
','
Input','
Adm',' 
Input','
Adm'], 
    $catatannya);  
    $starting_string =$hasil;
    $result_array = preg_split( "/#/", $starting_string );
    $jamkr=$result_array[1];
    $wktkr=$result_array[2];
    $destinasi=$result_array[3];
    $cttn=$result_array[4];

	   if(!empty($lokasi_file)){
$data3 = 
[
   'sender' => $sender,
   'to' => $nomer, //No. tujuan
   'text' => ' ⚠️ *Info Tugas*
_______________________
📝 *No. Nota* : _'. $no_invoice.'_ 
👩‍ *Kasir* : *'.$op[full_name].'*
🏭 *Div. Produksi* : '.$divisi.'
_______________________
🧕 *Customer* : *'.$wonge.'*
⏰️ *jam Acara* :'.$jamkr.'
📍 *Alamat* : '.$alamate.'
_______________________
🚚 *Tgl. Kirim* : '.tanggal_indo($jt, true).'
⛅ *Opsi Kirim* : '.$wktkr.' | '.$destinasi.'
✍ *Catatan* : '.$cttn.'

_______________________
📜 *Daftar Pesanan :* 📦
_______________________
'.
$cccc.'
*Ongkir* : Rp. '.number_format($ongkir,0,",",".").'
_______________________
*Total      :* Rp. '.number_format($total_bayar,0,",",".").'
*Dibayar :* Rp. '.number_format($jumlah_pembayaran,0,",",".").'
*Sisa       :* Rp. '.number_format($kembalian,0,",",".").'
_______________________', //Isi pesan

   'type' => 'nogrup', //Kirim ke grup gunakan 'grup', ke personal 'nogrup'
   'image' => $imgcstm.'', //URL gambar
   'tombol1_tipe' => '1', //Untuk link tulis 1, untuk balasan tulis 2
   'tombol2_tipe' => '1',
   'tombol3_tipe' => $tpe,
   'tombol1_teks' => 'Lihat Tugas', //Untuk teks yang muncul pada tombol
   'tombol2_teks' => 'Hubungi Customer',
   'tombol3_teks' => $hyp,
   'tombol1_link' => 'https://pro.kasir.vip/app/code-'.$no_invoice, //link tombol ketika di klik
   'tombol2_link' => 'https://wa.me/'.$plgne.'?text=%20%E2%9A%A0%EF%B8%8F%20Konfirmasi%20Pesanan%0A_________%0A%F0%9F%93%9D%20No.%20Nota%20%3A%20'.'*'.$no_invoice.'*'.'%20%0A%F0%9F%99%8C%20Customer%20%3A%20'.'*'.$wonge.'*'.'%0A%F0%9F%91%A9%E2%80%8D%20Petugas%20%3A%20'.$op[full_name].'%0A%F0%9F%9A%9A%20Pengiriman%20%3A%20'.tanggal_indo($jatuh_tempo,true).'%0A%E2%8F%B0%EF%B8%8F%20'.$keterangan.'%0A%E2%9B%BA%EF%B8%8F%20Alamat%20%3A%20'.$alamate.'%0A%0A
%F0%9F%93%9C%20Daftar%20Pesanan%20%3A%20%F0%9F%93%A6%0A_________%0A'.
$cccc.'_________%0ATotal%20%3A%20Rp.%20'.number_format($total_order,0,",",".").'%0ADibayar%20%3A%20Rp.%20'.number_format($jumlah_pembayaran,0,",",".").'%0ASisa%20%3A%20Rp.%20'.number_format($kembalian,0,",",".").'%0A_________',
   'tombol3_link' => $link, // untuk tombol yang bukan link, tulis seperti teks yang muncul pada tombol
   'footer'       => 'Request by '.$u[full_name], //Tulisan di bawah pesan
   'tombol'       => '3', //Jumlah tombol, maksimal 3
];

	   }else{

$data3 = 
[
   'sender' => $sender,
   'to' => $nomer, //No. tujuan
   'text' => ' ⚠️ *Info Tugas*
_______________________
📝 *No. Nota* : _'. $no_invoice.'_ 
👩‍ *Kasir* : *'.$op[full_name].'*
🏭 *Div. Produksi* : '.$divisi.'
_______________________
🧕 *Customer* : *'.$wonge.'*
⏰️ *jam Acara* :'.$jamkr.'
📍 *Alamat* : '.$alamate.'
_______________________
🚚 *Tgl. Kirim* : '.tanggal_indo($jt, true).'
⛅ *Opsi Kirim* : '.$wktkr.' | '.$destinasi.'
✍ *Catatan* : '.$cttn.'

_______________________
📜 *Daftar Pesanan :* 📦
_______________________
'.
$cccc.'
*Ongkir* : Rp. '.number_format($ongkir,0,",",".").'
_______________________
*Total      :* Rp. '.number_format($total_bayar,0,",",".").'
*Dibayar :* Rp. '.number_format($jumlah_pembayaran,0,",",".").'
*Sisa       :* Rp. '.number_format($kembalian,0,",",".").'
_______________________', //Isi pesan

   'type' => 'nogrup', //Kirim ke grup gunakan 'grup', ke personal 'nogrup'
   'tombol1_tipe' => '1', //Untuk link tulis 1, untuk balasan tulis 2
   'tombol2_tipe' => '1',
   'tombol3_tipe' => $tpe,
   'tombol1_teks' => 'Lihat Tugas', //Untuk teks yang muncul pada tombol
   'tombol2_teks' => 'Hubungi Customer',
   'tombol3_teks' => $hyp,
   'tombol1_link' => 'https://pro.kasir.vip/app/code-'.$no_invoice, //link tombol ketika di klik
   'tombol2_link' => 'https://wa.me/'.$plgne.'?text=%20%E2%9A%A0%EF%B8%8F%20Konfirmasi%20Pesanan%0A_________%0A%F0%9F%93%9D%20No.%20Nota%20%3A%20'.'*'.$no_invoice.'*'.'%20%0A%F0%9F%99%8C%20Customer%20%3A%20'.'*'.$wonge.'*'.'%0A%F0%9F%91%A9%E2%80%8D%20Petugas%20%3A%20'.$op[full_name].'%0A%F0%9F%9A%9A%20Pengiriman%20%3A%20'.tanggal_indo($jatuh_tempo,true).'%0A%E2%8F%B0%EF%B8%8F%20'.$keterangan.'%0A%E2%9B%BA%EF%B8%8F%20Alamat%20%3A%20'.$alamate.'%0A%0A
%F0%9F%93%9C%20Daftar%20Pesanan%20%3A%20%F0%9F%93%A6%0A_________%0A'.
$cccc.'_________%0ATotal%20%3A%20Rp.%20'.number_format($total_order,0,",",".").'%0ADibayar%20%3A%20Rp.%20'.number_format($jumlah_pembayaran,0,",",".").'%0ASisa%20%3A%20Rp.%20'.number_format($kembalian,0,",",".").'%0A_________',
   'tombol3_link' => $link, // untuk tombol yang bukan link, tulis seperti teks yang muncul pada tombol
   'footer'       => 'Request by '.$u[full_name], //Tulisan di bawah pesan
   'tombol'       => '3', //Jumlah tombol, maksimal 3
];

	   }

   
   
   $curl = curl_init();
   curl_setopt_array($curl, array(
   CURLOPT_URL => 'https://web.infinity-edumedia.com/meiwha/script/api2/sendbutton_new.php',
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_ENCODING => '',
   CURLOPT_MAXREDIRS => 10,
   CURLOPT_TIMEOUT => 0,
   CURLOPT_SSL_VERIFYHOST => false,
   CURLOPT_SSL_VERIFYPEER => false,
   CURLOPT_FOLLOWLOCATION => true,
   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
   CURLOPT_CUSTOMREQUEST => 'POST',
   CURLOPT_POSTFIELDS => http_build_query($data3),
   CURLOPT_HTTPHEADER => array(
   'multipart/form-data'
   )
   ));
   
   $response = curl_exec($curl);
   curl_close($curl);

//-------------------------------------------------------------------------------------------------//
//new duplicate produksi
//-------------------------------------------------------------------------------------------------//   

	   if(!empty($lokasi_file)){
$data4 = 
[
   'sender' => $sender,
   'to' => '6282324800133', //No. tujuan
   'text' => ' ⚠️ *Info Tugas*
_______________________
📝 *No. Nota* : _'. $no_invoice.'_ 
👩‍ *Kasir* : *'.$op[full_name].'*
🏭 *Div. Produksi* : '.$divisi.'
_______________________
🧕 *Customer* : *'.$wonge.'*
⏰️ *jam Acara* :'.$jamkr.'
📍 *Alamat* : '.$alamate.'
_______________________
🚚 *Tgl. Kirim* : '.tanggal_indo($jt, true).'
⛅ *Opsi Kirim* : '.$wktkr.' | '.$destinasi.'
✍ *Catatan* : '.$cttn.'

_______________________
📜 *Daftar Pesanan :* 📦
_______________________
'.
$cccc.'
*Ongkir* : Rp. '.number_format($ongkir,0,",",".").'
_______________________
*Total      :* Rp. '.number_format($total_bayar,0,",",".").'
*Dibayar :* Rp. '.number_format($jumlah_pembayaran,0,",",".").'
*Sisa       :* Rp. '.number_format($kembalian,0,",",".").'
_______________________', //Isi pesan

   'type' => 'nogrup', //Kirim ke grup gunakan 'grup', ke personal 'nogrup'
   'image' => $imgcstm.'', //URL gambar
   'tombol1_tipe' => '1', //Untuk link tulis 1, untuk balasan tulis 2
   'tombol2_tipe' => '1',
   'tombol3_tipe' => $tpe,
   'tombol1_teks' => 'Lihat Tugas', //Untuk teks yang muncul pada tombol
   'tombol2_teks' => 'Hubungi Customer',
   'tombol3_teks' => $hyp,
   'tombol1_link' => 'https://pro.kasir.vip/app/code-'.$no_invoice, //link tombol ketika di klik
   'tombol2_link' => 'https://wa.me/'.$plgne.'?text=%20%E2%9A%A0%EF%B8%8F%20Konfirmasi%20Pesanan%0A_________%0A%F0%9F%93%9D%20No.%20Nota%20%3A%20'.'*'.$no_invoice.'*'.'%20%0A%F0%9F%99%8C%20Customer%20%3A%20'.'*'.$wonge.'*'.'%0A%F0%9F%91%A9%E2%80%8D%20Petugas%20%3A%20'.$op[full_name].'%0A%F0%9F%9A%9A%20Pengiriman%20%3A%20'.tanggal_indo($jatuh_tempo,true).'%0A%E2%8F%B0%EF%B8%8F%20'.$keterangan.'%0A%E2%9B%BA%EF%B8%8F%20Alamat%20%3A%20'.$alamate.'%0A%0A
%F0%9F%93%9C%20Daftar%20Pesanan%20%3A%20%F0%9F%93%A6%0A_________%0A'.
$cccc.'_________%0ATotal%20%3A%20Rp.%20'.number_format($total_order,0,",",".").'%0ADibayar%20%3A%20Rp.%20'.number_format($jumlah_pembayaran,0,",",".").'%0ASisa%20%3A%20Rp.%20'.number_format($kembalian,0,",",".").'%0A_________',
   'tombol3_link' => $link, // untuk tombol yang bukan link, tulis seperti teks yang muncul pada tombol
   'footer'       => 'Request by '.$u[full_name], //Tulisan di bawah pesan
   'tombol'       => '3', //Jumlah tombol, maksimal 3
];

	   }else{

$data4 = 
[
   'sender' => $sender,
   'to' => '6282324800133', //No. tujuan
   'text' => ' ⚠️ *Info Tugas*
_______________________
📝 *No. Nota* : _'. $no_invoice.'_ 
👩‍ *Kasir* : *'.$op[full_name].'*
🏭 *Div. Produksi* : '.$divisi.'
_______________________
🧕 *Customer* : *'.$wonge.'*
⏰️ *jam Acara* :'.$jamkr.'
📍 *Alamat* : '.$alamate.'
_______________________
🚚 *Tgl. Kirim* : '.tanggal_indo($jt, true).'
⛅ *Opsi Kirim* : '.$wktkr.' | '.$destinasi.'
✍ *Catatan* : '.$cttn.'

_______________________
📜 *Daftar Pesanan :* 📦
_______________________
'.
$cccc.'
*Ongkir* : Rp. '.number_format($ongkir,0,",",".").'
_______________________
*Total      :* Rp. '.number_format($total_bayar,0,",",".").'
*Dibayar :* Rp. '.number_format($jumlah_pembayaran,0,",",".").'
*Sisa       :* Rp. '.number_format($kembalian,0,",",".").'
_______________________', //Isi pesan

   'type' => 'nogrup', //Kirim ke grup gunakan 'grup', ke personal 'nogrup'
   'tombol1_tipe' => '1', //Untuk link tulis 1, untuk balasan tulis 2
   'tombol2_tipe' => '1',
   'tombol3_tipe' => $tpe,
   'tombol1_teks' => 'Lihat Tugas', //Untuk teks yang muncul pada tombol
   'tombol2_teks' => 'Hubungi Customer',
   'tombol3_teks' => $hyp,
   'tombol1_link' => 'https://pro.kasir.vip/app/code-'.$no_invoice, //link tombol ketika di klik
   'tombol2_link' => 'https://wa.me/'.$plgne.'?text=%20%E2%9A%A0%EF%B8%8F%20Konfirmasi%20Pesanan%0A_________%0A%F0%9F%93%9D%20No.%20Nota%20%3A%20'.'*'.$no_invoice.'*'.'%20%0A%F0%9F%99%8C%20Customer%20%3A%20'.'*'.$wonge.'*'.'%0A%F0%9F%91%A9%E2%80%8D%20Petugas%20%3A%20'.$op[full_name].'%0A%F0%9F%9A%9A%20Pengiriman%20%3A%20'.tanggal_indo($jatuh_tempo,true).'%0A%E2%8F%B0%EF%B8%8F%20'.$keterangan.'%0A%E2%9B%BA%EF%B8%8F%20Alamat%20%3A%20'.$alamate.'%0A%0A
%F0%9F%93%9C%20Daftar%20Pesanan%20%3A%20%F0%9F%93%A6%0A_________%0A'.
$cccc.'_________%0ATotal%20%3A%20Rp.%20'.number_format($total_order,0,",",".").'%0ADibayar%20%3A%20Rp.%20'.number_format($jumlah_pembayaran,0,",",".").'%0ASisa%20%3A%20Rp.%20'.number_format($kembalian,0,",",".").'%0A_________',
   'tombol3_link' => $link, // untuk tombol yang bukan link, tulis seperti teks yang muncul pada tombol
   'footer'       => 'Request by '.$u[full_name], //Tulisan di bawah pesan
   'tombol'       => '3', //Jumlah tombol, maksimal 3
];

	   }

   
   
   $curl = curl_init();
   curl_setopt_array($curl, array(
   CURLOPT_URL => 'https://web.infinity-edumedia.com/meiwha/script/api2/sendbutton_new.php',
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_ENCODING => '',
   CURLOPT_MAXREDIRS => 10,
   CURLOPT_TIMEOUT => 0,
   CURLOPT_SSL_VERIFYHOST => false,
   CURLOPT_SSL_VERIFYPEER => false,
   CURLOPT_FOLLOWLOCATION => true,
   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
   CURLOPT_CUSTOMREQUEST => 'POST',
   CURLOPT_POSTFIELDS => http_build_query($data4),
   CURLOPT_HTTPHEADER => array(
   'multipart/form-data'
   )
   ));
   
   $response = curl_exec($curl);
   curl_close($curl);


//new
//--------------------------------------------------------------------------------------------------//
//Telegram notif
//-------------------------------------------------------------------------------------------------//

$isitele = '⚠️ Test TELEGRAM Info Tugas
_______________________
📝 No. Nota : '. $no_invoice.' 
🙌 Customer : '.$wonge.'
👩‍ Petugas : '.$op[full_name].'
🚚 Pengiriman : '.tanggal_indo($jt, true).'
⏰️ '.$keterangan.'
⛺️ Alamat : '.$alamate.'

Daftar Pesanan :
_______________________
'.
$eeee.'
_______________________
Total      : Rp. '.number_format($total_bayar,0,",",".").'
Disc.      : Rp. '.number_format(($total_bayar-$totalharga),0,",",".").'
Tagihan : Rp. '.number_format($totalharga,0,",",".").'
Dibayar : Rp. '.number_format($jumlah_pembayaran,0,",",".").'
Sisa       : Rp. '.number_format($kembalian,0,",",".").'
_______________________'.''; //Isi pesan

$token = "5716174253:AAH0U6xCuKY6FWpiw5-gUrT05BdXf7kwbe0"; // token bot

if(!empty($lokasi_file)){
$datakirim = [
    'photo' => $imgcstm,
    'caption' => $isitele,
    'chat_id' => '5389615275'  //contoh bot, group id -442697126 / 830806791 2047148935 5389615275 5830806791
];    
file_get_contents("https://api.telegram.org/bot$token/sendPhoto?" . http_build_query($datakirim) );
}else{
$datakirim = [
    'text' => $isitele,
    'chat_id' => '5389615275'  //contoh bot, group id -442697126 / 830806791 2047148935 5389615275 5830806791
];  
file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($datakirim) );
}
	

//-------------------------------------------------------------------------------------------------//
//End Telegram Notif
//-------------------------------------------------------------------------------------------------//
//SMS Notif Gateway
//-------------------------------------------------------------------------------------------------//

$isisms = 'Test SMS Info Tugas
_______________________
No. Nota : '. $no_invoice.' 
Customer : '.$wonge.'
Petugas : '.$op[full_name].'
Pengiriman : '.tanggal_indo($jt, true).'
'.$keterangan.'
Alamat : '.$alamate.'

Daftar Pesanan :
_______________________
'.
$eeee.'
_______________________
Total      : Rp. '.number_format($total_bayar,0,",",".").'
Disc.      : Rp. '.number_format(($total_bayar-$totalharga),0,",",".").'
Tagihan : Rp. '.number_format($totalharga,0,",",".").'
Dibayar : Rp. '.number_format($jumlah_pembayaran,0,",",".").'
Sisa       : Rp. '.number_format($kembalian,0,",",".").'
_______________________'; //Isi pesan
  $sms = urlencode($isisms);
  $url =  "https://kasir.vip/sms/api/sms.php?token=2804&no=6282324800133,$nomer&text=$sms" ;
  $ch = curl_init();      
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($ch);
  curl_close ($ch);
	

//-------------------------------------------------------------------------------------------------//
//End SMS Notif Gateway
//-------------------------------------------------------------------------------------------------//
	?>