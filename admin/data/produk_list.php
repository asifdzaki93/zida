<?php
header('Content-Type: application/json');

require_once 'koneksi.php'; // Pastikan file koneksi.php tersedia dan terhubung ke database
include 'fungsi_indotgl.php'; // Jika diperlukan

if (isset($_POST['action']) && $_POST['action'] == "produk_data") {
    $usernya = $mysqli->user_master;

    // Kolom-kolom yang ingin ditampilkan dalam DataTable
    $columns = array(
        0 => 'id_product',
        1 => 'id_category',
        2 => 'name_product',
        3 => 'selling_price',
        4 => 'stock',
        5 => 'aksi',
    );

    // Batasan jumlah data yang ditampilkan
    $limit = $_POST['length'] ?? 10;
    $start = $_POST['start'] ?? 0;
    $orderIndex = $_POST['order']['0']['column'] ?? 0;
    $dir = $_POST['order']['0']['dir'] ?? 'desc';

    // Kolom-kolom yang bisa diurutkan
    $sortableColumns = [
        'id_product',
        'id_category',
        'name_product',
        'selling_price',
        'stock'
    ];

    $orderColumn = $sortableColumns[$orderIndex] ?? 'id_product';
    $orderDirection = in_array(strtoupper($dir), ['ASC', 'DESC']) ? strtoupper($dir) : 'DESC';

    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }

    // Query utama untuk mengambil data produk
    $sql = "SELECT p.*, c.name_category
            FROM product p
            LEFT JOIN category c ON p.id_category = c.id_category
            WHERE p.user = '$usernya' AND p.packages = 'NO'
            ORDER BY $orderColumn $orderDirection
            LIMIT $start, $limit";

    // Eksekusi query
    $query = $mysqli->query($sql);

    // Inisialisasi array untuk menyimpan data
    $data = array();

    // Jika query berhasil dieksekusi
    if ($query) {
        $no = $start + 1;
        while ($row = $query->fetch_assoc()) {

            $sumber = "";
            if ($row['img'] !== "" && $row['folder'] !== "") {
                $sumber = "https://zieda.id/pro/geten/images/" . $row['folder'] . "/" . $row['img'];
            } else {
                $sumber = "https://zieda.id/pro/geten/images/no_image.jpg";
            }

            $produk =
                '<div class="d-flex justify-content-start align-items-center">
                    <div class="avatar-wrapper">
                        <div class="avatar avatar-sm me-2"><img src="' . $sumber . '" alt="' . (ucwords(strtolower($row['name_product'])) ?? "-") . '"
                                class="rounded-circle"></div>
                    </div>
                    <div class="d-flex flex-column gap-1"><a href="pages-profile-user.html" class="text-truncate">
                            <h6 class="mb-0">' . (ucwords(strtolower($row['name_product'])) ?? "-") . '</h6>
                        </a><small class="text-truncate text-muted">' . $row['description'] . '</small></div>
                    </div>';

            // Data produk yang akan dimasukkan ke dalam DataTable
            $rowData = array(
                'id_product' => $no++,
                'id_category' => ((ucwords(strtolower($row['name_category'] ?? "Uncategorized")))),
                'name_product' => $produk,
                'selling_price' => rupiah($row['selling_price']),
                'stock' => $row['stock'],
                'aksi' => '',
                // Jika Anda memiliki kolom aksi, Anda dapat menambahkannya di sini
            );

            // Tambahkan data produk ke dalam array data
            $data[] = $rowData;
        }
    }

    // Hitung total data yang tersedia dalam tabel
    $totalRecordsQuery = $mysqli->query("SELECT COUNT(id_product) as total FROM product WHERE user = '$usernya' AND packages = 'NO'");
    $totalRecords = $totalRecordsQuery->fetch_assoc()['total'] ?? 0;

    // Format data yang akan dikirimkan sebagai JSON
    $json_data = array(
        "draw"            => intval($_POST['draw'] ?? 0),
        "recordsTotal"    => intval($totalRecords),
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data
    );

    // Encode data ke dalam format JSON dan kirimkan
    echo json_encode($json_data);
} elseif (isset($_POST['action']) && $_POST['action'] == "pelanggan_data") {
    $usernya = $mysqli->user_master;

    // Kolom-kolom yang ingin ditampilkan dalam DataTable
    $columns = array(
        0 => 'id_customer',
        1 => 'name_customer',
        2 => 'customercode',
        3 => 'address',
        4 => 'email',
        5 => 'telephone',
        6 => 'status',
        7 => 'point',
        8 => 'aksi',
    );

    // Batasan jumlah data yang ditampilkan
    $limit = $_POST['length'] ?? 10;
    $start = $_POST['start'] ?? 0;
    $orderIndex = $_POST['order']['0']['column'] ?? 0;
    $dir = $_POST['order']['0']['dir'] ?? 'desc';

    // Kolom-kolom yang bisa diurutkan
    $sortableColumns = [
        'id_customer',
        'name_customer',
        'email',
        'telephone',
        'address',
    ];

    $orderColumn = $sortableColumns[$orderIndex] ?? 'id_customer';
    $orderDirection = in_array(strtoupper($dir), ['ASC', 'DESC']) ? strtoupper($dir) : 'DESC';

    // Query utama untuk mengambil data pelanggan
    $sql = "SELECT *
            FROM customer
            WHERE user = '$usernya'
            ORDER BY $orderColumn $orderDirection
            LIMIT $start, $limit";

    // Eksekusi query
    $query = $mysqli->query($sql);

    // Inisialisasi array untuk menyimpan data
    $data = array();

    // Jika query berhasil dieksekusi
    if ($query) {
        $no = $start + 1;
        while ($row = $query->fetch_assoc()) {

            // Tombol aksi
            $tombol =
                '<div class="d-flex align-items-center">
                <a href="javascript:;" data-bs-toggle="tooltip" class="text-body delete-record" data-bs-placement="top" title="Delete Invoice">
                    <i class="mdi mdi-delete-outline mdi-20px mx-1"></i>
                </a>
                <a href="javascript:;" onclick=\'loadPage("order_detail.php?no_invoice='  . '")\' data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Invoice">
                    <i class="mdi mdi-eye-outline mdi-20px mx-1"></i>
                </a>
                <div class="dropdown">
                    <a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical mdi-20px"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a target=_blank href="cetak_invoice.php?no_invoice=' . '" class="dropdown-item">Download</a>
                        <a href="javascript:;" onclick=\'loadPage("order_detail.php?no_invoice='  . '&editing=true")\' class="dropdown-item">Edit</a>
                        <a href="javascript:;" class="dropdown-item">Duplicate</a>
                    </div>
                </div>
            </div>';

            // Data pelanggan yang akan dimasukkan ke dalam DataTable
            $rowData = array(
                'id_customer' => $no++,
                'name_customer' => $row['name_customer'],
                'telephone' => $row['telephone'],
                'email' => $row['email'],
                'address' => $row['address'],
                'aksi' => $tombol,
            );

            // Tambahkan data pelanggan ke dalam array data
            $data[] = $rowData;
        }
    }

    // Hitung total data yang tersedia dalam tabel
    $totalRecordsQuery = $mysqli->query("SELECT COUNT(id_customer) as total FROM customer WHERE user = '$usernya'");
    $totalRecords = $totalRecordsQuery->fetch_assoc()['total'] ?? 0;

    // Format data yang akan dikirimkan sebagai JSON
    $json_data = array(
        "draw"            => intval($_POST['draw'] ?? 0),
        "recordsTotal"    => intval($totalRecords),
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data
    );

    // Encode data ke dalam format JSON dan kirimkan
    echo json_encode($json_data);

    // Kode untuk mengambil data pelanggan
} elseif (isset($_POST['action']) && $_POST['action'] == "paket_data") {
    $usernya = $mysqli->user_master;

    // Kolom-kolom yang ingin ditampilkan dalam DataTable
    $columns = array(
        0 => 'id_product',
        1 => 'id_category',
        2 => 'name_product',
        3 => 'selling_price',
        4 => 'stock',
        5 => 'aksi',
    );

    // Batasan jumlah data yang ditampilkan
    $limit = $_POST['length'] ?? 10;
    $start = $_POST['start'] ?? 0;
    $orderIndex = $_POST['order']['0']['column'] ?? 0;
    $dir = $_POST['order']['0']['dir'] ?? 'desc';

    // Kolom-kolom yang bisa diurutkan
    $sortableColumns = [
        'id_product',
        'id_category',
        'name_product',
        'selling_price',
        'stock'
    ];

    $orderColumn = $sortableColumns[$orderIndex] ?? 'id_product';
    $orderDirection = in_array(strtoupper($dir), ['ASC', 'DESC']) ? strtoupper($dir) : 'DESC';

    function rupiah($angka)
    {

        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }

    function truncateDescription($description, $maxLength = 50)
    {
        // Strip tags to avoid breaking any HTML
        $string = strip_tags($description);

        // Check if the length of the string is greater than the maximum length
        if (strlen($string) > $maxLength) {
            // Truncate the string
            $stringCut = substr($string, 0, $maxLength);
            $endPoint = strrpos($stringCut, ' ');

            // If the string doesn't contain any space then it will cut without word basis
            $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= '...';
        }

        return $string;
    }


    // Query utama untuk mengambil data produk

    // Query utama untuk mengambil data produk dengan join ke tabel kategori
    $sql = "SELECT p.*, c.name_category
            FROM product p
            LEFT JOIN category c ON p.id_category = c.id_category
            WHERE p.user = '$usernya' AND p.packages = 'YES'
            ORDER BY $orderColumn $orderDirection
            LIMIT $start, $limit";

    // Eksekusi query
    $query = $mysqli->query($sql);

    // Inisialisasi array untuk menyimpan data
    $data = array();

    $tombol =
        '<div class="d-flex align-items-center">
        <a href="javascript:;" data-bs-toggle="tooltip" class="text-body delete-record" data-bs-placement="top" title="Delete Invoice">
            <i class="mdi mdi-delete-outline mdi-20px mx-1"></i>
        </a>
        <a href="javascript:;" onclick=\'loadPage("order_detail.php?no_invoice='  . '")\' data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Invoice">
            <i class="mdi mdi-eye-outline mdi-20px mx-1"></i>
        </a>
        <div class="dropdown">
            <a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown">
                <i class="mdi mdi-dots-vertical mdi-20px"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <a target=_blank href="cetak_invoice.php?no_invoice=' . '" class="dropdown-item">Download</a>
                <a href="javascript:;" onclick=\'loadPage("order_detail.php?no_invoice='  . '&editing=true")\' class="dropdown-item">Edit</a>
                <a href="javascript:;" class="dropdown-item">Duplicate</a>
            </div>
        </div>
    </div>';

    // Jika query berhasil dieksekusi
    if ($query) {
        $no = $start + 1;
        while ($row = $query->fetch_assoc()) {

            $sumber = "";
            if ($row['img'] !== "" && $row['folder'] !== "") {
                $sumber = "https://zieda.id/pro/geten/images/" . $row['folder'] . "/" . $row['img'];
            } else {
                $sumber = "https://zieda.id/pro/geten/images/no_image.jpg";
            }



            $produk =
                '<div class="d-flex justify-content-start align-items-center">
                    <div class="avatar-wrapper">
                        <div class="avatar avatar-sm me-2"><img src="' . $sumber . '" alt="' . truncateDescription((ucwords(strtolower($row['name_product'] ?? "-"))), 5) . '"
                                class="rounded-circle"></div>
                    </div>
                    <div class="d-flex flex-column gap-1"><a href="pages-profile-user.html" class="text-truncate">
                            <h6 class="mb-0">' . (ucwords(strtolower($row['name_product'])) ?? "-") . '</h6>
                        </a><small class="text-truncate text-muted">' . truncateDescription((ucwords(strtolower($row['description'] ?? "-")))) . '</small></div>
                    </div>';

            // Data produk yang akan dimasukkan ke dalam DataTable
            $rowData = array(
                'id_product' => $no++,
                'id_category' => ((ucwords(strtolower($row['name_category'] ?? "Uncategorized")))),
                'name_product' => $produk,
                'selling_price' => rupiah($row['selling_price']),
                'stock' => $row['stock'],
                'aksi' => $tombol,
                // Jika Anda memiliki kolom aksi, Anda dapat menambahkannya di sini
            );

            // Tambahkan data produk ke dalam array data
            $data[] = $rowData;
        }
    }

    // Hitung total data yang tersedia dalam tabel
    $totalRecordsQuery = $mysqli->query("SELECT COUNT(id_product) as total FROM product WHERE user = '$usernya' AND packages = 'YES'");
    $totalRecords = $totalRecordsQuery->fetch_assoc()['total'] ?? 0;

    // Format data yang akan dikirimkan sebagai JSON
    $json_data = array(
        "draw"            => intval($_POST['draw'] ?? 0),
        "recordsTotal"    => intval($totalRecords),
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data
    );

    // Encode data ke dalam format JSON dan kirimkan
    echo json_encode($json_data);

    // Kode untuk mengambil data paket produk
} else {
    // Jika action tidak didefinisikan atau tidak sesuai
    $json_data = array(
        "error" => "Invalid request. Action not defined."
    );

    // Encode data ke dalam format JSON dan kirimkan
    echo json_encode($json_data);
}
