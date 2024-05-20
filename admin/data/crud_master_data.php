<?php
/**
 * Created by PhpStorm.
 * User: ahmad
 * Date: 20/08/2019
 * Time: 11:48 AM
 */
header('Content-Type: application/json');

require_once 'koneksi.php';
require_once 'base_sistem.php';
include 'fungsi_thumb.php';
include 'generate_deskripsi.php';

function getSumber($img, $folder)
{
  $sumber = '';
  if ($img !== '' && $folder !== '') {
    $sumber = 'https://zieda.id/pro/geten/images/' . $folder . '/' . $img;
  } else {
    $sumber = 'https://zieda.id/pro/geten/images/no_image.jpg';
  }
  return $sumber;
}
function proses($mysqli, $chatgpt_url, $chatgpt_key)
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
    $date = gmdate('dHi');
    $acak = rand(1, 99);
    $sesi = "$m[id_store]$acak$date";

    if ($tipe == 'produk_update') {
      $check = $mysqli->query("SELECT id_product,session FROM product WHERE id_product = '$id_product'");
      $checked = $check->fetch_array();
      if (!$checked) {
        return [
          'result' => 'error',
          'title' => 'Produk tidak ada',
        ];
      }
      $sesi = $checked["session"];
    }

    $packages = ($_POST['packages'] ?? '') == 'YES' ? 'YES' : 'NO';
    $hargabeli = $mysqli->real_escape_string($_POST['purchase_price'] ?? '0');
    $hargajual = $mysqli->real_escape_string($_POST['selling_price'] ?? '0');
    $stok = $mysqli->real_escape_string($_POST['stock'] ?? '0');
    $nama_barang = $mysqli->real_escape_string($_POST['name_product'] ?? '');
    $unit = $mysqli->real_escape_string($_POST['unit']??"Kg");
    $id_kategori = $mysqli->real_escape_string($_POST['id_category'] ?? '');
    $kodebarang = $mysqli->real_escape_string($_POST['codeproduct'] ?? '');
    $minimalstok = $mysqli->real_escape_string($_POST['minimalstock'] ?? '0');
    $deskripsi = $mysqli->real_escape_string($_POST['description'] ?? '');
    $online = $mysqli->real_escape_string($_POST['online'] ?? '0');
    $ada_stok = $mysqli->real_escape_string($_POST['have_stock'] ?? '1');
    $hargagrosir = $mysqli->real_escape_string($_POST['wholesale_price'] ?? '0');
    $minimal_pembelian = $mysqli->real_escape_string($_POST['minimum_purchase'] ?? '0');
    $tax = $mysqli->real_escape_string($_POST['tax'] ?? '0');
    $alertstock = $mysqli->real_escape_string($_POST['alertstock'] ?? '0');

    $folder = date('m-d-y-H');

    $lokasi_file = $_FILES['img']['tmp_name'];
    $tipe_file = $_FILES['img']['type'];
    $nama_file = $_FILES['img']['name'];
    $nama_file_unik = $acak . $nama_file;

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
      $id_product = $b["id_product"];
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
    if($packages == "YES") {
      $packages_product = explode(",",$_REQUEST["packages_product"]);
      $query_packages_product = $mysqli->query(
        "SELECT id_packagesproduct,id_product,name_product FROM packagesproduct 
        WHERE $mysqli->user_master_query and sesi = '$sesi'"
      );
      $db_packages_product = [];
      while ($row = $query_packages_product->fetch_assoc()) {
        $db_packages_product[$row["id_product"]] = [
          "id_packagesproduct"=>$row["id_packagesproduct"],
          "name_product"=>$row["name_product"]
        ];
      }
      $new_catatan = [];
      foreach($packages_product as $p){
        $pp_id_product = explode(":",$p)[0];
        $pp_amount = explode(":",$p)[1]??1;
        if (isset($db_packages_product[$pp_id_product])) {
          $id_packagesproduct = $db_packages_product[$pp_id_product]["id_packagesproduct"];
          $mysqli->query(
            "UPDATE packagesproduct set 
            amount = '$pp_amount'
            where user = '$m[phone_number]' and id_packagesproduct = '$id_packagesproduct'"
          );
          array_push($new_catatan,$db_packages_product[$pp_id_product]["name_product"]." (".$pp_amount.")");
          unset($db_packages_product[$pp_id_product]);
        } else {
          $product_query = $mysqli->query("SELECT name_product,selling_price from product 
          where $mysqli->user_master_query and id_product = '$pp_id_product' and packages = 'NO'");
          $product = $product_query->fetch_assoc();
          if($product){
            $name_product = $product['name_product'];
            $price = $product['selling_price'];
            $mysqli->query(
              "INSERT INTO packagesproduct(id_product, name_product, amount, id_store, user, sesi, price, date) 
                                    VALUES('$pp_id_product', '$name_product', '$pp_amount', '$m[id_store]', '$m[phone_number]', '$sesi', '$price', '$tanggal')"
            );
            array_push($new_catatan,$name_product." (".$pp_amount.")");
          }
        }
      }
      foreach(array_values($db_packages_product) as $p){
        $id_packagesproduct = $p["id_packagesproduct"];
        $mysqli->query("DELETE FROM packagesproduct where id_packagesproduct = '$id_packagesproduct'");
      }
      $description = implode(", ",$new_catatan);
      $mysqli->query("UPDATE product set description = '$description' where id_product = '$id_product'");
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
      $data['img'] = getSumber($data['img'], $data['folder']);
      $json = [
        'result' => 'success',
        'title' => 'Success',
        'data' => $data,
      ];
    }
  } elseif ($tipe == 'produk_generate_deskripsi') {
    $id = $mysqli->real_escape_string($_REQUEST['id_product'] ?? '');
    $query = $mysqli->query(
      "SELECT name_product,img,folder FROM product WHERE user='$u[master]' AND id_product = '$id'"
    );
    $data = $query->fetch_assoc();
    if ($data != null) {
      $data['img'] = getSumber($data['img'], $data['folder']);
      $deskripsiProduk = getDeskripsiProduk($chatgpt_url, $chatgpt_key, $data['name_product'], $data['img']);
      $json = [
        'result' => 'success',
        'title' => 'Success',
        'data' => $deskripsiProduk,
      ];
    }
  } elseif ($tipe == 'produk_delete') {
    $id = $mysqli->real_escape_string($_REQUEST['id_product'] ?? '');
    $mysqli->query("UPDATE product SET showing='1' where user='$u[master]' AND id_product = '$id'");
    $json = [
      'result' => 'success',
      'title' => 'Success',
    ];
  } elseif ($tipe == 'produk_restore') {
    $id = $mysqli->real_escape_string($_REQUEST['id_product'] ?? '');
    $mysqli->query("UPDATE product SET showing='0' where user='$u[master]' AND id_product = '$id'");
    $json = [
      'result' => 'success',
      'title' => 'Success',
    ];
  } elseif ($tipe == 'produk_online') {
    $codeproducts = explode(",",$_REQUEST['codeproduct']??"");
    foreach( $codeproducts as $codeproduct ) {
      if(empty( $codeproduct )) {
        continue;
      }
      $code = $mysqli->real_escape_string($codeproduct);
      $mysqli->query("UPDATE product SET online='1' where user='$u[master]' AND codeproduct = '$code'");
    }
    $json = [
      'result' => 'success',
      'title' => 'Success',
    ];
  } elseif ($tipe == 'produk_offline') {
    $codeproducts = explode(",",$_REQUEST['codeproduct']??"");
    foreach( $codeproducts as $codeproduct ) {
      if(empty( $codeproduct )) {
        continue;
      }
      $code = $mysqli->real_escape_string($codeproduct);
      $mysqli->query("UPDATE product SET online='0' where user='$u[master]' AND codeproduct = '$code'");
    }
    $json = [
      'result' => 'success',
      'title' => 'Success',
    ];
  } elseif ($tipe == 'customer_update' || $tipe == 'customer_create') {
    $id_customer = $mysqli->real_escape_string($_POST['id_customer'] ?? '');
    if ($tipe == 'customer_update') {
      $check = $mysqli->query("SELECT id_customer FROM customer WHERE id_customer = '$id_customer'");
      $checked = $check->fetch_array();
      if (!$checked) {
        return [
          'result' => 'error',
          'title' => 'Produk tidak ada',
        ];
      }
    }

    $email = $mysqli->real_escape_string($_POST['email']);
    $telephone = $mysqli->real_escape_string($_POST['telephone']);
    $name_customer = $mysqli->real_escape_string($_POST['name_customer']);
    $address = $mysqli->real_escape_string($_POST['address']);
    $user = $mysqli->user_master;
    if ($tipe == 'customer_create') {
      $mysqli->query("INSERT INTO customer(active,name_customer,email,telephone,address,img,user) 
      VALUES('1','$name_customer','$email','$telephone','$address','avatar.png','$user')");
    } else {
      $mysqli->query("UPDATE customer SET 
        name_customer = '$name_customer',
        address   = '$address',
        email   = '$email',
        telephone   = '$telephone'
        WHERE id_customer = '$id_customer' and user = '$user'");
    }
    $json = [
      'result' => 'success',
      'title' => 'Success',
    ];
  } elseif ($tipe == 'customer_read') {
    $id = $mysqli->real_escape_string($_REQUEST['id_customer'] ?? '');
    $query = $mysqli->query("SELECT * FROM customer WHERE user='$u[master]' AND id_customer = '$id'");
    $data = $query->fetch_assoc();
    if ($data != null) {
      $json = [
        'result' => 'success',
        'title' => 'Success',
        'data' => $data,
      ];
    }
  } elseif ($tipe == 'customer_delete') {
    $id = $mysqli->real_escape_string($_REQUEST['id_customer'] ?? '');
    $mysqli->query("UPDATE customer SET active='1' where user='$u[master]' AND id_customer = '$id'");
    $json = [
      'result' => 'success',
      'title' => 'Success',
    ];
  } elseif ($tipe == 'customer_restore') {
    $id = $mysqli->real_escape_string($_REQUEST['id_customer'] ?? '');
    $mysqli->query("UPDATE customer SET active='0' where user='$u[master]' AND id_customer = '$id'");
    $json = [
      'result' => 'success',
      'title' => 'Success',
    ];
  } elseif ($tipe == 'packages_read') {
    $id_product_parent = $mysqli->real_escape_string($_REQUEST['id_product_parent'] ?? '');
    $check = $mysqli->query("SELECT session FROM product WHERE id_product = '$id_product_parent'");
    $product_parent = $check->fetch_array();
    if (!$product_parent) {
      return [
        'result' => 'error',
        'title' => 'Produk tidak ada',
      ];
    }
    $sesi = $product_parent['session'];
    $query = $mysqli->query("SELECT * from packagesproduct where sesi = '$sesi'");
    $data = [];
    while ($row = $query->fetch_assoc()) {
      $data[] = $row;
    }
    $json = [
      'result' => 'success',
      'title' => 'Success',
      'data' => $data,
    ];
  }
  return $json;
}
echo json_encode(proses($mysqli, $chatgpt_url, $chatgpt_key));
