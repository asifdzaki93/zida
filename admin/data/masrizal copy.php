<?php
header('Content-Type: application/json');

// Koneksi ke database
require_once 'koneksi.php';

// Fungsi untuk mengubah format nomor telepon
function gantiformat($nomorhp)
{
    $nomorhp = preg_replace('/[^0-9+]/', '', $nomorhp); // Hapus karakter selain angka dan +
    if (substr($nomorhp, 0, 3) == '+62') {
        $nomorhp = trim($nomorhp);
    } elseif (substr($nomorhp, 0, 1) == '0') {
        $nomorhp = '62' . substr($nomorhp, 1);
    }
    return $nomorhp;
}

if ($_GET['action'] == "sales_data") {
    $usernya = $_GET['user'];

    $querycount = $mysqli->query("SELECT count(id_sales_data) as jumlah FROM sales_data WHERE user='$usernya'");
    $datacount = $querycount->fetch_array();

    $totalData = $datacount['jumlah'];
    $totalFiltered = $totalData;

    $limit = $_POST['length'] ?? 10;
    $start = $_POST['start'] ?? 0;
    $orderIndex = $_POST['order']['0']['column'] ?? 0;
    $dir = $_POST['order']['0']['dir'] ?? 'desc';
    $columns = ['id_sales_data', 'img', 'operator', 'totalorder', 'note', 'aksi'];
    $order = $columns[$orderIndex];

    if (empty($_POST['search']['value'])) {
        $query = $mysqli->query("SELECT * FROM sales_data WHERE user='$usernya' order by $order $dir LIMIT $limit OFFSET $start");
    } else {
        $search = $_POST['search']['value'];
        $query = $mysqli->query("SELECT * FROM sales_data WHERE user = '$usernya' AND (no_invoice LIKE '%$search%' or due_date LIKE '%$search%') order by $order $dir LIMIT $limit OFFSET $start");

        $querycount = $mysqli->query("SELECT count(id_sales_data) as jumlah FROM sales_data WHERE user = '$usernya' AND (due_date LIKE '%$search%' or no_invoice LIKE '%$search%')");
        $datacount = $querycount->fetch_array();
        $totalFiltered = $datacount['jumlah'];
    }

    $data = array();
    if ($query) {
        $no = $start + 1;
        while ($r = $query->fetch_array()) {
            $nestedData = array();
            $nestedData['no'] = $no++;
            $nestedData['image'] = ""; // Tempatkan tag HTML untuk image jika diperlukan
            $nestedData['no_invoice'] = $r['no_invoice']; // Format atau tambahkan data invoice
            $nestedData['totalorder'] = $r['totalorder']; // Format atau tambahkan data total order
            $nestedData['note'] = $r['note']; // Format atau tambahkan data catatan
            $nestedData['due_date'] = ""; // Format atau tambahkan data tanggal jatuh tempo
            $nestedData['status'] = ""; // Format atau tambahkan data status
            $nestedData['aksi'] = ""; // Tempatkan link atau action yang dapat dilakukan

            $data[] = $nestedData;
        }
    }

    $json_data = array(
        "draw"            => intval($_POST['draw'] ?? 0),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $data
    );

    echo json_encode($json_data);
}
