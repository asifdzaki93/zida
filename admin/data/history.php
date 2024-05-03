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

if ($_POST['action'] == "sales_data") {
    $usernya = $mysqli->user_master;
    $columns = array(
        0 => 'id_sales_data',
        1 => 'img',
        2 => 'operator',
        3 => 'totalorder',
        4 => 'note',
        5 => 'aksi',
    );

    $limit = $_POST['length'] ?? 10;
    $start = $_POST['start'] ?? 0;
    $orderIndex = $_POST['order']['0']['column'] ?? 0;
    $dir = $_POST['order']['0']['dir'] ?? 'desc';
    $columns = [
        'sd.id_sales_data',
        'sd.id_sales_data', 
        'sd.no_invoice', 
        'sd.due_date',
        'c.name_customer', 
        'sd.totalorder', 
        'sd.date', 
        'sd.totalpay', 
        'sd.id_sales_data'
    ];
    $order = $columns[$orderIndex];
    if($order=="aksi"){
        $order="id_sales_data";
    }

    $sqlBase = "SELECT c.name_customer, c.telephone, sd.status,sd.img, sd.no_invoice, sd.totalpay, sd.totalorder, sd.due_date, sd.date ";
    $sqlCount = "SELECT count(id_sales_data) as jumlah ";
    $sqlMid = "FROM sales_data sd LEFT JOIN customer c ON sd.id_customer = c.id_customer WHERE sd.user='$usernya' ";
    $sqlSearch = "";
    $sqlEnd = "order by $order $dir LIMIT $limit OFFSET $start";

    if (!empty($_POST['search']['value'])) {
        $search = $mysqli->real_escape_string($_POST['search']['value']??"");
        $sqlSearch = "AND sd.no_invoice LIKE '%$search%' or sd.due_date LIKE '%$search%' or c.name_customer LIKE '%$search%' or c.telephone LIKE '%$search%' ";
    }
    if (!empty($_POST['status'])) {
        $status = $mysqli->real_escape_string($_POST['status']??"");
        $sqlSearch .= "AND sd.status ='$status' ";
    }

    $query = $mysqli->query($sqlBase.$sqlMid.$sqlSearch.$sqlEnd);
    $querycount = $mysqli->query($sqlCount.$sqlMid);
    $datacount = $querycount->fetch_assoc();
    $totalData = $datacount['jumlah']??0;
    $querycountFiltered = $mysqli->query($sqlCount.$sqlMid.$sqlSearch);
    $datacountFiltered = $querycountFiltered->fetch_assoc();
    $totalFiltered = $datacountFiltered['jumlah']??0;

    $data = array();
    if (!empty($query)) {
        $no = $start + 1;
        while ($r = $query->fetch_assoc()) {
            $nestedData=[
                "date"=>$r["date"]
            ];
            $nestedData['checkbox']='<input type="checkbox" class="dt-checkboxes form-check-input">';
            $nestedData['total']="Rp " . number_format($r["totalorder"], 0, ',', '.');
            $nestedData['tagihan']='';
            $tagihan="Rp " . number_format($r["totalorder"]-$r["totalpay"], 0, ',', '.');
            if($r["totalorder"]>$r["totalpay"]){
                $nestedData['tagihan']=$tagihan;
            }else{
                $nestedData['tagihan']='<span class="badge rounded-pill bg-label-success" text-capitalized=""> Lunas </span>';
            }

            $nestedData['no_invoice']="<a href='javascript:;' onclick=\"loadPage('order_detail.php?no_invoice=" . $r['no_invoice'] . "')\"><small>" . $r['no_invoice'] . "</small></a> ";

            $status = $r["status"]??'-';
            $trendTitle = '<span>'.($r["status"]??'-').'<br> <strong>Balance:</strong> '.$tagihan.'<br> <strong>
            Due Date:</strong> '.($r['due_date']??"-").'</span>';
            $trendIcon = "mdi mdi-cash-clock";
            $trendColor = "warning";
            switch($status){
                case "paid off":
                    $trendIcon = "mdi mdi-check-decagram";
                    $trendColor = "success";
                    break;
                case "cancel":
                    $trendIcon = "mdi mdi-close-octagon-outline";
                    $trendColor = "danger";
                    break;
                case "finish":
                    $trendIcon = "mdi mdi-cookie-cog";
                    $trendColor = "info";
                    break;
            }

            $nestedData['trend']='<div class="d-inline-flex" data-bs-toggle="tooltip" data-bs-html="true" aria-label="'.$trendTitle.'" data-bs-original-title="'.$trendTitle.'"><span class="avatar avatar-sm"> <span class="avatar-initial rounded-circle bg-label-'.$trendColor.'"><i class="'.$trendIcon.'"></i></span></span></div>';

            $sumber="";
            if ($r['img'] !== "") {
                $sumber = "https://zieda.id/pro/geten/images/order/" . $r['img'];
            } else {
                $sumber = "https://zieda.id/pro/geten/images/no_image.jpg";
            }
            $nestedData['customer']='<div class="d-flex justify-content-start align-items-center">
                <div class="avatar-wrapper">
                    <div class="avatar avatar-sm me-2"><img src="'.$sumber.'" alt="'.($r['name_customer']??"-").'"
                            class="rounded-circle"></div>
                </div>
                <div class="d-flex flex-column gap-1"><a href="pages-profile-user.html" class="text-truncate">
                        <h6 class="mb-0">'.($r['name_customer']??"-").'</h6>
                    </a><small class="text-truncate text-muted">'.($r['telephone']??"-").'</small></div>
            </div>';

            $nestedData['aksi'] = 
                '<div class="d-flex align-items-center">
                    <a href="javascript:;" data-bs-toggle="tooltip" class="text-body delete-record" data-bs-placement="top" title="Delete Invoice">
                        <i class="mdi mdi-delete-outline mdi-20px mx-1"></i>
                    </a>
                    <a href="javascript:;" onclick=\'loadPage("order_detail.php?no_invoice=' . $r['no_invoice'] . '")\' data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Invoice">
                        <i class="mdi mdi-eye-outline mdi-20px mx-1"></i>
                    </a>
                    <div class="dropdown">
                        <a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown">
                            <i class="mdi mdi-dots-vertical mdi-20px"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a target=_blank href="cetak_invoice.php?no_invoice=' . $r['no_invoice'] . '" class="dropdown-item">Download</a>
                            <a href="javascript:;" onclick=\'loadPage("order_detail.php?no_invoice=' . $r['no_invoice'] . '&editing=true")\' class="dropdown-item">Edit</a>
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