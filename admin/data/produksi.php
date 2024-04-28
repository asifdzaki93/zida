<?php
header('Content-Type: application/json');

require_once 'koneksi.php';
include 'fungsi_indotgl.php';

function gantiformat($nomorhp)
{
    $nomorhp = trim($nomorhp);
    $nomorhp = strip_tags($nomorhp);
    $nomorhp = str_replace(" ", "", $nomorhp);
    $nomorhp = str_replace("(", "", $nomorhp);
    $nomorhp = str_replace(".", "", $nomorhp);

    if (!preg_match('/[^+0-9]/', trim($nomorhp))) {
        if (substr(trim($nomorhp), 0, 3) == '+62') {
            $nomorhp = trim($nomorhp);
        } elseif (substr($nomorhp, 0, 1) == '0') {
            $nomorhp = '62' . substr($nomorhp, 1);
        }
    }
    return $nomorhp;
}

if ($_GET['action'] == "sales_data") {
    $usernya = $_GET['user'];
    $columns = array(
        0 => 'id_sales_data',
        1 => 'img',
        2 => 'operator',
        3 => 'totalorder',
        4 => 'note',
        5 => 'aksi',
    );

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
        $query = $mysqli->query("SELECT * FROM sales_data WHERE user = '$usernya' AND no_invoice LIKE '%$search%' or due_date LIKE '%$search%' order by $order $dir LIMIT $limit OFFSET $start");

        $querycount = $mysqli->query("SELECT count(id_sales_data) as jumlah FROM sales_data WHERE user = '$usernya' AND due_date LIKE '%$search%' or no_invoice LIKE '%$search%'");
        $datacount = $querycount->fetch_array();
        $totalFiltered = $datacount['jumlah'];
    }

    $data = array();
    if (!empty($query)) {
        $no = $start + 1;
        while ($r = $query->fetch_array()) {
            $catatannya = $r['note'];

            $patterns = [
                'Event hours:', 'Jam acara : ', 'Jam Acara : ', 'Waktu Pengiriman : ', 'Jenis Pengiriman : ',
                ' | ', 'Catatan : ', 'nn', 'nInput', 'nAdm', 'ninput', 'nadm'
            ];
            $replacements = array_fill(0, count($patterns), '#');
            $hasil = str_replace($patterns, $replacements, $catatannya);

            $hasil = preg_replace('/\s*#\s*/', '#', $hasil);

            $result_array = explode('#', $hasil);

            $jamkr = $result_array[1] ?? '';
            $wktkr = $result_array[2] ?? '';
            $destinasi = $result_array[3] ?? '';
            $cttn = $result_array[4] ?? '';

            $nestedData['no'] = $no;
            if ($r['img'] !== "") {
                $sumber = "https://zieda.id/pro/geten/images/order/" . $r['img'];
            } else {
                $sumber = "https://zieda.id/pro/geten/images/no_image.jpg";
            }
            $nestedData['image'] =
                "<div class='avatar avatar-md me-2'>
                    <a href='$sumber'><img class='rounded-circle' src='$sumber'/></a>
                </div>
                ";
            $cabang = mysqli_query($connect, "SELECT * FROM users WHERE phone_number='$r[operator]'");
            $cb = mysqli_fetch_array($cabang);
            $nestedData['no_invoice'] = "
                <div>
                <strong class='text-primary'>$r[no_invoice]</strong><br>
                <small>by </smal>" . ucwords($cb['full_name']) . "<br>" . $r['date'] . "
                </div>
                ";

            if ($r['totalpay'] < $r['totalorder']) {
                $ord =
                    "<div><small>(" .
                    number_format($r['totalorder'], 0, ',', '.') . " - " .
                    number_format($r['totalpay'], 0, ',', '.') . ")</small><br><b class='text-danger'><i> - Rp. " .
                    number_format(($r['totalorder'] - $r['totalpay']), 0, ',', '.') .
                    "<i></b></div>
                    ";
            } else {
                $ord = "<b class='text-success'>LUNAS</b><br> Rp. " . number_format($r['totalorder'], 0, ',', '.');
            }
            $nestedData['totalorder'] = $ord;

            $cus = mysqli_query($connect, "SELECT * FROM customer WHERE id_customer='$r[id_customer]'");
            $cu = mysqli_fetch_array($cus);

            if ($r['id_customer'] == "0") {
                $catatan =
                    "<div><i class='fas fa-user-circle'></i> 
                    Retail Customer <br><i class='fas fa-phone-square'></i> -
                </div>";
            } else {
                $catatan =
                    "
                <div><i class='fas fa-user-circle'></i> 
                    " . ucwords($cu['name_customer']) . " <br><i class='fas fa-phone-square'></i> <a href='https://api.whatsapp.com/send?phone=" . gantiformat($cu['telephone']) . "&text=Assalamualaikum%20_*" . ucwords($cu['name_customer']) . "*_..%0AKami%20dari%20*" . ucwords($cb['full_name']) . "*%2C%20%20%0A....%0A%0A' target='_blank'>" . ucwords($cu['telephone']) . "</a>
                </div>";
            }
            $nestedData['note'] = $catatan;

            if ($r['due_date'] !== "0000-00-00") {
                $isitgl =
                    "<div><i class='fas fa-arrow-alt-circle-down'></i> " .
                    tgl_indo($r['date']) . " <br><i class='fas fa-arrow-alt-circle-up'></i> " .
                    tgl_indo($r['due_date']) . "<br><i class='fas fa-clock'></i>&nbsp" . "Jam Acara: " . $jamkr . "<br><i class='fas fa-shipping-fast'></i>&nbsp" . $wktkr . " | " . $destinasi . "
                        </div>";
                $cattn = "<i class='fas fa-clipboard-check'></i>&nbsp Catatan: " . $cttn;
            } else {
                $isitgl =
                    "<div><i class='fas fa-check-circle'></i> " .
                    tgl_indo($r['date']) . "
                        </div>";
                $cattn = "";
            }

            $nestedData['due_date'] =
                "$isitgl" . "$cattn";

            if ($r['status'] == 'pre order') {
                $statusnya = '<span class="badge bg-label-warning">Belum Diproduksi
                    </span>';
            } elseif ($r['status'] == 'finish') {
                $statusnya = '<span class="badge bg-label-primary">Sudah Diproduksi
                    </span>';
            } elseif ($r['status'] == 'paid off') {
                $statusnya = '<span class="badge bg-label-success">Pesanan Selesai
                    </span>';
            } elseif ($r['status'] == 'cancel') {
                $statusnya = '<span class="badge bg-label-danger">Pesanan Batal
                    </span>';
            }
            $nestedData['status'] = $statusnya . "<br><small>by " . ucwords($cb['full_name']) . "</smal><br>";

            $nestedData['aksi'] = "
                <div class='mt-1 mb-1'>
                    <a href='https://pro.kasir.vip/app/code-" . $r['no_invoice'] . "'<small>" . $r['no_invoice'] . "</small></a> 
                </div>
                "
                .
                '<div class="d-flex align-items-center">
                    <a href="javascript:;" data-bs-toggle="tooltip" class="text-body delete-record" data-bs-placement="top" title="Delete Invoice">
                        <i class="mdi mdi-delete-outline mdi-20px mx-1"></i>
                    </a>
                    <a href="https://pro.kasir.vip/pdf/material.php?no_invoice=' . $r['no_invoice'] . '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Invoice">
                        <i class="mdi mdi-eye-outline mdi-20px mx-1"></i>
                    </a>
                    <div class="dropdown">
                        <a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown">
                            <i class="mdi mdi-dots-vertical mdi-20px"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="https://pro.kasir.vip/pdf/invoice.php?no_invoice=' . $r['no_invoice'] . '" class="dropdown-item">Download</a>
                            <a href="app-invoice-edit.html" class="dropdown-item">Edit</a>
                            <a href="javascript:;" class="dropdown-item">Duplicate</a>
                        </div>
                    </div>
                </div>';
            $data[] = $nestedData;
            $no++;
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
