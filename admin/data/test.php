<?php
require_once 'koneksi.php';

function gantiformat($nomorhp)
{
    $nomorhp = trim($nomorhp);
    $nomorhp = strip_tags($nomorhp);
    $nomorhp = str_replace(array(" ", "(", ".", ")"), "", $nomorhp);

    if (!preg_match('/[^+0-9]/', $nomorhp)) {
        if (substr($nomorhp, 0, 3) == '+62') {
            $nomorhp = $nomorhp;
        } elseif (substr($nomorhp, 0, 1) == '0') {
            $nomorhp = '62' . substr($nomorhp, 1);
        }
    }
    return $nomorhp;
}

if (isset($_GET['action']) && $_GET['action'] == "sales_data") {
    $usernya = isset($_GET['user']) ? $_GET['user'] : '';

    $columns = ['id_sales_data', 'img', 'operator', 'totalorder', 'note', 'aksi'];

    // Prepare the SQL statement to avoid SQL injection
    $stmt = $mysqli->prepare("SELECT COUNT(id_sales_data) AS jumlah FROM sales_data WHERE user=?");
    $stmt->bind_param("s", $usernya);
    $stmt->execute();
    $result = $stmt->get_result();
    $datacount = $result->fetch_assoc();

    $totalData = $datacount['jumlah'];
    $totalFiltered = $totalData;

    $limit = isset($_POST['length']) ? $_POST['length'] : 10;
    $start = isset($_POST['start']) ? $_POST['start'] : 0;
    $orderColumn = isset($_POST['order'][0]['column']) && isset($columns[$_POST['order'][0]['column']]) ? $columns[$_POST['order'][0]['column']] : 'id_sales_data';
    $dir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';

    if (empty($_POST['search']['value'])) {
        $stmt = $mysqli->prepare("SELECT * FROM sales_data WHERE user=? ORDER BY $orderColumn $dir LIMIT ? OFFSET ?");
        $stmt->bind_param("sii", $usernya, $limit, $start);
    } else {
        $search = $_POST['search']['value'];
        $likeSearch = "%$search%";
        $stmt = $mysqli->prepare("SELECT * FROM sales_data WHERE user=? AND (no_invoice LIKE ? OR due_date LIKE ?) ORDER BY $orderColumn $dir LIMIT ? OFFSET ?");
        $stmt->bind_param("sssii", $usernya, $likeSearch, $likeSearch, $limit, $start);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt = $mysqli->prepare("SELECT COUNT(id_sales_data) AS jumlah FROM sales_data WHERE user=? AND (no_invoice LIKE ? OR due_date LIKE ?)");
        $stmt->bind_param("sss", $usernya, $likeSearch, $likeSearch);
        $stmt->execute();
        $result = $stmt->get_result();
        $datacount = $result->fetch_assoc();
        $totalFiltered = $datacount['jumlah'];
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    $no = $start + 1;
    while ($r = $query->fetch_array()) {



        $catatannya = $r['note'];
        //$hasil = str_replace(['Jam Acara : ', ' Jenis Pengiriman : ', ' | ',' Catatan : ' ], ['#', '#', '#', '#'], $catatannya);
        $hasil = str_replace(
            ['Event hours:', 'Jam acara : ', 'Jam Acara : ', ' Waktu Pengiriman : ', ' Jenis Pengiriman : ', ' | ', ' Catatan : ', 'nn', 'nInput', 'nAdm', 'ninput', 'nadm'],
            ['#', '#', '#', '#', '#', '#', '#', '
', '
Input', '
Adm', ' 
Input', '
Adm'],
            $catatannya
        );
        $starting_string = $hasil;
        $result_array = preg_split("/#/", $starting_string);

        $jamkr = $result_array[1];
        $wktkr = $result_array[2];
        $destinasi = $result_array[3];
        $cttn = $result_array[4];


        $nestedData['no'] = $no;
        if ($r['img'] !== "") {
            $sumber = "https://zieda.id/pro/geten/images/order/" . $r['img'];
        } else {
            $sumber = "https://zieda.id/pro/geten/images/no_image.jpg";
        }
        $nestedData['image'] =
            "<div>
                <a href='$sumber'><img class='circular-image-s' src='$sumber'/></a>
            </div>
            ";
        $cabang = mysqli_query($koneksi, "SELECT * FROM users WHERE phone_number='$r[operator]'");
        $cb = mysqli_fetch_array($cabang);
        $nestedData['no_invoice'] = "
            <div>
            <strong class='text-primary'>$r[no_invoice]</strong><br>
            <small>by </smal>" . ucwords($cb[full_name]) . "<br>" . $r[date] . "
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

        $cus = mysqli_query($koneksi, "SELECT * FROM customer WHERE id_customer='$r[id_customer]'");
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
                " . ucwords($cu[name_customer]) . " <br><i class='fas fa-phone-square'></i> <a href='https://api.whatsapp.com/send?phone=" . gantiformat($cu[telephone]) . "&text=Assalamualaikum%20_*" . ucwords($cu[name_customer]) . "*_..%0AKami%20dari%20*" . ucwords($cb[full_name]) . "*%2C%20%20%0A....%0A%0A' target='_blank'>" . ucwords($cu[telephone]) . "</a>
            </div>";
        }
        /*$nestedData['note'] = "
            <div><i class='fas fa-user-circle'></i> 
                ".ucwords($cu[name_customer])." <br><i class='fas fa-phone-square'></i> ".ucwords($cu[telephone])."
            </div>";*/

        $nestedData['note'] = $catatan;

        /*$nestedData['due_date'] = 
            "<div>".
                tgl_indo($r[due_date])." <br>
                <small>".ucwords($cu[name_customer])." | ".ucwords($cu[telephone])."</small>
            </div>";*/

        if ($r['due_date'] !== "0000-00-00") {
            $isitgl =
                "<div><i class='fas fa-arrow-alt-circle-down'></i> " .
                tgl_indo($r[date]) . " <br><i class='fas fa-arrow-alt-circle-up'></i> " .
                tgl_indo($r[due_date]) . "<br><i class='fas fa-clock'></i>&nbsp" . "Jam Acara: " . $jamkr . "<br><i class='fas fa-shipping-fast'></i>&nbsp" . $wktkr . " | " . $destinasi . "
                    </div>";
            $cattn = "<i class='fas fa-clipboard-check'></i>&nbsp Catatan: " . $cttn;
        } else {
            $isitgl =
                "<div><i class='fas fa-check-circle'></i> " .
                tgl_indo($r[date]) . "
                    </div>";
            $cattn = "";
        }

        $nestedData['due_date'] =
            "$isitgl";



        if ($r['status'] == 'pre order') {
            $statusnya = '<span class="badge badge-warning">Belum Diproduksi
                </span>';
        } elseif ($r['status'] == 'finish') {
            $statusnya = '<span class="badge badge-primary">Sudah Diproduksi
                </span>';
        } elseif ($r['status'] == 'paid off') {
            $statusnya = '<span class="badge badge-success">Pesanan Selesai
                </span>';
        } elseif ($r['status'] == 'cancel') {
            $statusnya = '<span class="badge badge-danger">Pesanan Batal
                </span>';
        }
        $nestedData['status'] = $statusnya . "<br><small>by " . ucwords($cb[full_name]) . "</smal><br>" . $cattn;
        $nestedData['aksi'] = "
            <div class='mt-1 mb-1'>
                <a href='https://pro.kasir.vip/app/code-$r[no_invoice]' role='button' class='btn-warning btn-sm mb-1'><b>$r[no_invoice]</b></a> 
            </div>
            <div class='mt-1 mb-1'>
                <a href='https://pro.kasir.vip/pdf/invoice.php?no_invoice=$r[no_invoice]' role='button' class='btn-success btn-sm'><i class='fas fa-file-alt'></i></a>
                <a href='https://pro.kasir.vip/pdf/material.php?no_invoice=$r[no_invoice]' role='button' class='btn-primary btn-sm'><i class='fas fa-dolly'></i></a>&nbsp; 
            </div>
            ";
        $data[] = $nestedData;
        $no++;
    }


    $json_data = [
        "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    ];

    echo json_encode($json_data);
}
