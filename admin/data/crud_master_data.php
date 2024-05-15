<?php
/**
 * Created by PhpStorm.
 * User: ahmad
 * Date: 20/08/2019
 * Time: 11:48 AM
 */
header('Content-Type: application/json');

require_once 'koneksi.php';
include 'fungsi_thumb.php';

function proses($mysqli)
{
  $tanggal = gmdate('Y-m-d');

  $u = $mysqli->data_user;
  $m = $mysqli->data_master;
  $tipe = $_REQUEST['tipe'] ?? 'produk_read';

  $json = [
    'result' => 'error',
    'title' => 'Tidak tersedia',
  ];

  if (!$mysqli->is_auth) {
    $json = [
      'result' => 'error',
      'title' => 'Tidak diizinkan',
    ];
  } elseif ($tipe == 'produk_create' || $tipe == 'produk_update') {
    $id_product = $mysqli->real_escape_string($_POST['id_product'] ?? '');
    if ($tipe == 'produk_update') {
      $check = $mysqli->query("SELECT id_product FROM product WHERE id_product = '$id_product'");
      $checked = $check->fetch_array();
      if (!$checked) {
        return [
          'result' => 'error',
          'title' => 'Produk tidak ada',
        ];
      }
    }

    $packages = ($_POST['packages'] ?? '') == 'YES' ? 'YES' : 'NO';
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

    if ($kodebarang == '' or ($mp2['codeproduct'] ?? '') == '') {
      $kodebarangs = ($mp['id_product'] ?? '') . '-' . $dates;
    } else {
      $kodebarangs = $kodebarang;
    }

    if (!empty($lokasi_file)) {
      UploadImage($nama_file_unik);
    } else {
      $nama_file_unik = 'no_product.png';
      $folder = '';
    }

    if ($tipe == 'produk_update') {
      $gambarUpdate = $folder == '' ? '' : "folder='$folder', img='$nama_file_unik',";
      $mysqli->query(
        "UPDATE product set 
          name_product='$nama_barang',
          unit='$unit',
          id_category='$id_kategori',
          codeproduct='$kodebarang',
          tax='$tax',
          purchase_price='$hargabeli',
          selling_price='$hargajual',
          stock='$stok',
          minimalstock='$minimalstok',
          description='$deskripsi',
          $gambarUpdate
          online='$online',
          have_stock='$ada_stok',
          wholesale_price='$hargagrosir',
          minimum_purchase='$minimal_pembelian',
          alertstock='$alertstock'
          WHERE id_product = '$id_product'"
      );
    } else {
      $mysqli->query(
        "INSERT INTO product(packages,name_product,
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
                    VALUES('$packages','$nama_barang',
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

      $databarang = $mysqli->query("SELECT * FROM product WHERE session='$sesi' AND user='$m[phone_number]'");
      $b = $databarang->fetch_array();

      $datastok = $mysqli->query("SELECT * FROM stock WHERE session='$sesi' AND user='$m[phone_number]'");
      $s = $datastok->fetch_array();

      if ($ada_stok == 1) {
        $mysqli->query(
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

        $mysqli->query(
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
    }
    $json = [
      'result' => 'success',
      'title' => 'Success',
    ];
  } elseif ($tipe == 'produk_read') {
    $id = $mysqli->real_escape_string($_REQUEST['id_product'] ?? '');
    $query = $mysqli->query("SELECT * FROM product WHERE user='$u[master]' AND id_product = '$id'");
    $data = $query->fetch_assoc();
    if ($data != null) {
      $json = [
        'result' => 'success',
        'title' => 'Success',
        'data' => $data,
      ];
    }
  } elseif ($tipe == 'produk_delete') {
    $id = $mysqli->real_escape_string($_REQUEST['id_product'] ?? '');
    $mysqli->query("UPDATE product SET showing='1' where user='$u[master]' AND id_product = '$id'");
    $json = [
      'result' => 'success',
      'title' => 'Success',
    ];
  }
  return $json;
}
echo json_encode(proses($mysqli));
