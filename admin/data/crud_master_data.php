<?php
/**
 * Created by PhpStorm.
 * User: ahmad
 * Date: 20/08/2019
 * Time: 11:48 AM
 */

require_once 'koneksi.php';
include '../fungsi_thumb.php';
$tanggal = gmdate('Y-m-d');

$u = $mysqli->data_user;
$m = $mysqli->data_master;
$tipe = $_POST['tipe'] ?? 'produk';

$json = [
  'result' => 'error',
  'title' => 'Tidak ada fitur',
];

if (!$mysqli->is_auth) {
  $json = [
    'result' => 'error',
    'title' => 'Tidak diizinkan',
  ];
} elseif ($tipe == 'produk') {
  $hargabeli = $mysqli->real_escape_string($_POST['purchase_price'] ?? '');
  $hargajual = $mysqli->real_escape_string($_POST['selling_price'] ?? '');
  $stok = $mysqli->real_escape_string($_POST['stock'] ?? '0');
  $nama_barang = $mysqli->real_escape_string($_POST['name_product'] ?? '');
  $unit = $mysqli->real_escape_string($_POST['unit']);
  $id_kategori = $mysqli->real_escape_string($_POST['id_category'] ?? '');
  $kodebarang = $mysqli->real_escape_string($_POST['codeproduct'] ?? '');
  $minimalstok = $mysqli->real_escape_string($_POST['minimalstock'] ?? '');
  $deskripsi = $mysqli->real_escape_string($_POST['description'] ?? '');
  $online = $mysqli->real_escape_string($_POST['online'] ?? '');
  $ada_stok = $mysqli->real_escape_string($_POST['have_stock'] ?? '');
  $hargagrosir = $mysqli->real_escape_string($_POST['wholesale_price'] ?? '');
  $minimal_pembelian = $mysqli->real_escape_string($_POST['minimum_purchase'] ?? '');
  $tax = $mysqli->real_escape_string($_POST['tax'] ?? '');
  $alertstock = $mysqli->real_escape_string($_POST['alertstock'] ?? '');

  $folder = date('m-d-y-H');

  $lokasi_file = $_FILES['img']['tmp_name'];
  $tipe_file = $_FILES['img']['type'];
  $nama_file = $_FILES['img']['name'];
  $acak = rand(1, 99);
  $nama_file_unik = $acak . $nama_file;

  $date = gmdate('dHi');
  $sesi = "$m[id_store]$acak$date";

  $masterproduct = $mysqli->query("SELECT * FROM product WHERE user='$u[master]' ORDER BY id_product DESC LIMIT 1");
  $mp = $masterproduct->fetch_array();

  $masterproduct2 = $mysqli->query("SELECT * FROM product WHERE user='$u[master]' AND codeproduct = '$kodebarang'");
  $mp2 = $masterproduct2->fetch_array();

  $dates = gmdate('dis');

  if ($kodebarang == '' or $mp2['codeproduct'] == '') {
    $kodebarangs = "$mp[id_product]-$dates";
  } else {
    $kodebarangs = $kodebarang;
  }

  if (!empty($lokasi_file)) {
    UploadImage($nama_file_unik);
    mysqli_query(
      $connect,
      "INSERT INTO product(name_product,
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
                           '$m[phone_number]')"
    );
  } else {
    mysqli_query(
      $connect,
      "INSERT INTO product(name_product,
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
                           '$m[phone_number]')"
    );
  }

  $databarang = $mysqli->query("SELECT * FROM product WHERE session='$sesi' AND user='$m[phone_number]'");
  $b = $databarang->fetch_array();

  $datastok = $mysqli->query("SELECT * FROM stock WHERE session='$sesi' AND user='$m[phone_number]'");
  $s = $datastok->fetch_array();

  if ($ada_stok == 1) {
    mysqli_query(
      $connect,
      "INSERT INTO stock(id_product,
									       id_store,
										   stock,
										   session,
										   user) 
									VALUES('$b[id_product]',
										   '$m[id_store]',
										   '$stok',
										   '$sesi',
										   '$m[phone_number]')"
    );

    mysqli_query(
      $connect,
      "INSERT INTO history_stock(id_product,
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
                           '$m[phone_number]')"
    );
  }
  $mysqli->query(
    "INSERT INTO pricevariant(minimal,
								  nominal,
								  id_product,
                                  user) 
                    VALUES('1',
						   '$hargajual',
						   '$b[id_product]',
                           '$m[phone_number]')"
  );

  $json = [
    'result' => 'success',
    'title' => 'Success',
  ];

  echo json_encode($json);
} else {
}
echo json_encode($json);
