<?php
header('Content-Type: application/json');

require_once 'koneksi.php'; // Pastikan file koneksi.php tersedia dan terhubung ke database
include 'fungsi_indotgl.php'; // Jika diperlukan

$searchProductQuery = '';
$searchPelangganQuery = '';
if (!empty($_POST['cari'])) {
  $like = "LIKE '%" . $mysqli->real_escape_string($_POST['cari']) . "%'";
  $searchProductQuery = " AND p.name_product $like";
  $searchPelangganQuery = " AND (telephone $like or name_customer $like or email $like)";
}

function truncateDescription($description, $maxLength = 50)
{
  // Strip tags to avoid breaking any HTML
  $string = strip_tags($description);

  // Check if the length of the string is greater than the maximum length
  if (strlen($string) > $maxLength) {
    $string = substr($string, 0, $maxLength);
    $string .= '...';
  }

  return $string;
}

function generateTombol($ada, $onclick, $id, $additional = '')
{
  $hapus_restore = $ada ? 'hapus' : 'restore';
  $hapus_restore_tooltip = ucwords($hapus_restore);
  $hapus_restore_icon = $ada ? 'mdi-delete-outline' : 'mdi-backup-restore';
  return '<div class="d-flex align-items-center">
      <a href="javascript:;" 
      onclick="' .
    $hapus_restore .
    '_' .
    $onclick .
    '(\'' .
    $id .
    '\')" 
      data-bs-toggle="tooltip" 
      class="text-body delete-record" 
      data-bs-placement="top" 
      title="' .
    $hapus_restore_tooltip .
    '">
      <i class="mdi ' .
    $hapus_restore_icon .
    ' mdi-20px mx-1"></i>
  </a>
  <a href="javascript:;" 
  onclick="lihat_' .
    $onclick .
    '(\'' .
    $id .
    '\')" 
data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Lihat">
      <i class="mdi mdi-eye-outline mdi-20px mx-1"></i>
  </a>
  <a href="javascript:;" 
  onclick="edit_' .
    $onclick .
    '(\'' .
    $id .
    '\')" 
    data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Edit">
      <i class="fa fa-edit mx-1"></i>
  </a>
  ' .
    $additional .
    '
</div>';
}

//default tipe adalah "hanya yang belum dihapus"
if (!empty($_POST['tipe'])) {
  if ($_POST['tipe'] == 'semua') {
  } else {
    $searchProductQuery .= " AND p.showing = '1'";
    $searchPelangganQuery .= " AND active = '1'";
  }
} else {
  $searchProductQuery .= " AND p.showing = '0'";
  $searchPelangganQuery .= " AND active = '0'";
}

if (!empty($_POST['online'])) {
  if ($_POST['online'] == '1') {
    $searchProductQuery .= " AND p.online = '1'";
  } else {
    $searchProductQuery .= " AND p.online = '0'";
  }
}


if (!$mysqli->is_auth) {
  $json_data = [
    'draw' => 0,
    'recordsTotal' => 0,
    'recordsFiltered' => 0,
    'data' => [],
  ];
  // Encode data ke dalam format JSON dan kirimkan
  echo json_encode($json_data);
} elseif (isset($_POST['action']) && $_POST['action'] == 'produk_data') {
  $usernya = $mysqli->user_master;

  // Kolom-kolom yang ingin ditampilkan dalam DataTable
  $columns = [
    0 => 'id_product',
    1 => 'id_category',
    2 => 'name_product',
    3 => 'selling_price',
    4 => 'stock',
    5 => 'aksi',
  ];

  // Batasan jumlah data yang ditampilkan
  $limit = $_POST['length'] ?? 10;
  $start = $_POST['start'] ?? 0;
  $orderIndex = $_POST['order']['0']['column'] ?? 0;
  $dir = $_POST['order']['0']['dir'] ?? 'desc';

  // Kolom-kolom yang bisa diurutkan
  $sortableColumns = ['id_product', 'id_category', 'name_product', 'selling_price', 'stock'];

  $orderColumn = $sortableColumns[$orderIndex] ?? 'id_product';
  $orderDirection = in_array(strtoupper($dir), ['ASC', 'DESC']) ? strtoupper($dir) : 'DESC';

  function rupiah($angka)
  {
    $hasil_rupiah = 'Rp ' . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
  }

  // Query utama untuk mengambil data produk
  $sql = "SELECT p.*, c.name_category
            FROM product p
            LEFT JOIN category c ON p.id_category = c.id_category
            WHERE p.user = '$usernya' AND p.packages = 'NO' $searchProductQuery
            ORDER BY $orderColumn $orderDirection
            LIMIT $start, $limit";

  // Eksekusi query
  $query = $mysqli->query($sql);

  // Inisialisasi array untuk menyimpan data
  $data = [];

  // Jika query berhasil dieksekusi
  if ($query) {
    $no = $start + 1;
    while ($row = $query->fetch_assoc()) {
      $sumber = '';
      if ($row['img'] !== '' && $row['folder'] !== '') {
        $sumber = 'https://zieda.id/pro/geten/images/' . $row['folder'] . '/' . $row['img'];
      } else {
        $sumber = 'https://zieda.id/pro/geten/images/no_image.jpg';
      }

      $checkbox='<input type="checkbox" onchange=\'select_product("'.$row["codeproduct"].'")\' value="'.$row["codeproduct"].
      '" class="dt-checkboxes me-1 checkbox_product form-check-input">';
      $no++;

      $produk =
        '<div class="d-flex justify-content-start align-items-center">
                    <div class="avatar-wrapper">
                        <div class="avatar avatar-sm me-2"><img src="' .
        $sumber .
        '" alt="' .
        truncateDescription(ucwords(strtolower($row['name_product'] ?? '-')), 5) .
        '"
                                class="rounded-circle"></div>
                    </div>
                    <div class="d-flex flex-column gap-1"><a href="pages-profile-user.html" class="text-truncate">
                            <h6 class="mb-0">' .
        truncateDescription(ucwords(strtolower(($row['name_product']))) ?? '-', 40) .
        '</h6>
                        </a><small class="text-truncate text-muted">' .
        truncateDescription(ucwords(strtolower($row['description'] ?? '-')), 40) .
        '</small></div>
                    </div>';

      // Data produk yang akan dimasukkan ke dalam DataTable
      $rowData = [
        'id_product' => $checkbox,
        'id_category' => ucwords(strtolower($row['name_category'] ?? 'Uncategorized')),
        'name_product' => $produk,
        'selling_price' => rupiah($row['selling_price']),
        'stock' => $row['stock'],
        'online' => $row['online']=='1'?"Online":"Offline",
        'aksi' => generateTombol($row['showing'] == '0', 'produk', $row['id_product']),
        // Jika Anda memiliki kolom aksi, Anda dapat menambahkannya di sini
      ];

      // Tambahkan data produk ke dalam array data
      $data[] = $rowData;
    }
  }

  // Hitung total data yang tersedia dalam tabel
  $totalRecordsQuery = $mysqli->query(
    "SELECT COUNT(id_product) as total FROM product p WHERE user = '$usernya' AND packages = 'NO' $searchProductQuery"
  );
  $totalRecords = $totalRecordsQuery->fetch_assoc()['total'] ?? 0;

  // Format data yang akan dikirimkan sebagai JSON
  $json_data = [
    'draw' => intval($_POST['draw'] ?? 0),
    'recordsTotal' => intval($totalRecords),
    'recordsFiltered' => intval($totalRecords),
    'data' => $data,
  ];

  // Encode data ke dalam format JSON dan kirimkan
  echo json_encode($json_data);
} elseif (isset($_POST['action']) && $_POST['action'] == 'pelanggan_data') {
  $usernya = $mysqli->user_master;

  // Kolom-kolom yang ingin ditampilkan dalam DataTable
  $columns = [
    0 => 'id_customer',
    1 => 'name_customer',
    2 => 'customercode',
    3 => 'address',
    4 => 'email',
    5 => 'telephone',
    6 => 'status',
    7 => 'point',
    8 => 'aksi',
  ];

  // Batasan jumlah data yang ditampilkan
  $limit = $_POST['length'] ?? 10;
  $start = $_POST['start'] ?? 0;
  $orderIndex = $_POST['order']['0']['column'] ?? 0;
  $dir = $_POST['order']['0']['dir'] ?? 'desc';

  // Kolom-kolom yang bisa diurutkan
  $sortableColumns = ['id_customer', 'name_customer', 'email', 'telephone', 'address'];

  $orderColumn = $sortableColumns[$orderIndex] ?? 'id_customer';
  $orderDirection = in_array(strtoupper($dir), ['ASC', 'DESC']) ? strtoupper($dir) : 'DESC';

  // Query utama untuk mengambil data pelanggan
  $sql = "SELECT *
            FROM customer
            WHERE user = '$usernya' $searchPelangganQuery
            ORDER BY $orderColumn $orderDirection
            LIMIT $start, $limit";

  // Eksekusi query
  $query = $mysqli->query($sql);

  // Inisialisasi array untuk menyimpan data
  $data = [];

  // Jika query berhasil dieksekusi
  if ($query) {
    $no = $start + 1;
    while ($row = $query->fetch_assoc()) {
      // Data pelanggan yang akan dimasukkan ke dalam DataTable
      $rowData = [
        'id_customer' => $no++,
        'name_customer' => $row['name_customer'],
        'telephone' => $row['telephone'],
        'email' => $row['email'],
        'address' => $row['address'],
        'aksi' => generateTombol($row['active'] == '0', 'customer', $row['id_customer']),
      ];

      // Tambahkan data pelanggan ke dalam array data
      $data[] = $rowData;
    }
  }

  // Hitung total data yang tersedia dalam tabel
  $totalRecordsQuery = $mysqli->query(
    "SELECT COUNT(id_customer) as total FROM customer WHERE user = '$usernya' $searchPelangganQuery"
  );
  $totalRecords = $totalRecordsQuery->fetch_assoc()['total'] ?? 0;

  // Format data yang akan dikirimkan sebagai JSON
  $json_data = [
    'draw' => intval($_POST['draw'] ?? 0),
    'recordsTotal' => intval($totalRecords),
    'recordsFiltered' => intval($totalRecords),
    'data' => $data,
  ];

  // Encode data ke dalam format JSON dan kirimkan
  echo json_encode($json_data);

  // Kode untuk mengambil data pelanggan
} elseif (isset($_POST['action']) && $_POST['action'] == 'paket_data') {
  $usernya = $mysqli->user_master;

  // Kolom-kolom yang ingin ditampilkan dalam DataTable
  $columns = [
    0 => 'id_product',
    1 => 'id_category',
    2 => 'name_product',
    3 => 'selling_price',
    4 => 'stock',
    5 => 'aksi',
  ];

  // Batasan jumlah data yang ditampilkan
  $limit = $_POST['length'] ?? 10;
  $start = $_POST['start'] ?? 0;
  $orderIndex = $_POST['order']['0']['column'] ?? 0;
  $dir = $_POST['order']['0']['dir'] ?? 'desc';

  // Kolom-kolom yang bisa diurutkan
  $sortableColumns = ['id_product', 'id_category', 'name_product', 'selling_price', 'stock'];

  $orderColumn = $sortableColumns[$orderIndex] ?? 'id_product';
  $orderDirection = in_array(strtoupper($dir), ['ASC', 'DESC']) ? strtoupper($dir) : 'DESC';

  function rupiah($angka)
  {
    $hasil_rupiah = 'Rp ' . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
  }
  // Query utama untuk mengambil data produk

  // Query utama untuk mengambil data produk dengan join ke tabel kategori
  $sql = "SELECT p.*, c.name_category
            FROM product p
            LEFT JOIN category c ON p.id_category = c.id_category
            WHERE p.user = '$usernya' AND p.packages = 'YES' $searchProductQuery
            ORDER BY $orderColumn $orderDirection
            LIMIT $start, $limit";

  // Eksekusi query
  $query = $mysqli->query($sql);

  // Inisialisasi array untuk menyimpan data
  $data = [];

  // Jika query berhasil dieksekusi
  if ($query) {
    $no = $start + 1;
    while ($row = $query->fetch_assoc()) {
      $sumber = '';
      if ($row['img'] !== '' && $row['folder'] !== '') {
        $sumber = 'https://zieda.id/pro/geten/images/' . $row['folder'] . '/' . $row['img'];
      } else {
        $sumber = 'https://zieda.id/pro/geten/images/no_image.jpg';
      }
      $checkbox='<input type="checkbox" onchange=\'select_packages("'.$row["codeproduct"].'")\' value="'.$row["codeproduct"].
      '" class="dt-checkboxes me-1 checkbox_packages form-check-input">';
      $no++;

      $produk =
        '<div class="d-flex justify-content-start align-items-center">
                    <div class="avatar-wrapper">
                        <div class="avatar avatar-sm me-2"><img src="' .
        $sumber .
        '" alt="' .
        truncateDescription(ucwords(strtolower($row['name_product'] ?? '-')), 5) .
        '"
                                class="rounded-circle"></div>
                    </div>
                    <div class="d-flex flex-column gap-1"><a href="pages-profile-user.html" class="text-truncate">
                            <h6 class="mb-0">' .
        truncateDescription(ucwords(strtolower(($row['name_product']))) ?? '-', 40) .
        '</h6>
                        </a><small class="text-truncate text-muted">' .
        truncateDescription(ucwords(strtolower($row['description'] ?? '-')), 40) .
        '</small></div>
                    </div>';

      // Data produk yang akan dimasukkan ke dalam DataTable
      $rowData = [
        'id_product' => $checkbox,
        'id_category' => ucwords(strtolower($row['name_category'] ?? 'Uncategorized')),
        'name_product' => $produk,
        'selling_price' => rupiah($row['selling_price']),
        'stock' => $row['stock'],
        'online' => $row['online']=='1'?"Online":"Offline",
        'aksi' => generateTombol($row['showing'] == '0', 'paket', $row['id_product']),
        // Jika Anda memiliki kolom aksi, Anda dapat menambahkannya di sini
      ];

      // Tambahkan data produk ke dalam array data
      $data[] = $rowData;
    }
  }

  // Hitung total data yang tersedia dalam tabel
  $totalRecordsQuery = $mysqli->query(
    "SELECT COUNT(id_product) as total FROM product p WHERE user = '$usernya' AND packages = 'YES' $searchProductQuery"
  );
  $totalRecords = $totalRecordsQuery->fetch_assoc()['total'] ?? 0;

  // Format data yang akan dikirimkan sebagai JSON
  $json_data = [
    'draw' => intval($_POST['draw'] ?? 0),
    'recordsTotal' => intval($totalRecords),
    'recordsFiltered' => intval($totalRecords),
    'data' => $data,
  ];

  // Encode data ke dalam format JSON dan kirimkan
  echo json_encode($json_data);

  // Kode untuk mengambil data paket produk
} else {
  // Jika action tidak didefinisikan atau tidak sesuai
  $json_data = [
    'error' => 'Invalid request. Action not defined.',
  ];

  // Encode data ke dalam format JSON dan kirimkan
  echo json_encode($json_data);
}
