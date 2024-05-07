<?php
function getChildProducts($sessionId, $jml, $mysqli)
{
    $query = $mysqli->query("SELECT * FROM packagesproduct WHERE sesi = '$sessionId'");
    $all_amount = 0;
    while ($row = $query->fetch_assoc()) {
        $childProducts[] = [
            'id_product' => $row['id_product'],
            'name_product' => $row['name_product'],
            'amount' => $row['amount'] * $jml,
        ];
        $all_amount += $row['amount'] * $jml;
    }
    return $childProducts;
}

function invoiceMaker($invoice, $amount, $raw = false)
{
    if ($raw) {
        return $invoice . " (" . $amount . ")";
    }
    return "<a href='javascript:;' onclick=\"open_invoice('" . $invoice . "')\">" . $invoice . " (" . $amount . ")" . "</a>";
}

function getOrderData($mysqli, $raw = false)
{
    $products = [];
    // SQL Query
    $sql = "
    SELECT 
    sd.no_invoice,
    sd.totalorder,
    sd.totalpay,
    sd.img,
    sd.operator,
    c.name_customer, 
    c.telephone, 
    c.address, 
    o.full_name as operator_name
    FROM sales_data sd 
    LEFT JOIN customer c ON sd.id_customer = c.id_customer 
    LEFT JOIN users o ON o.phone_number = sd.operator 
    WHERE sd.$mysqli->user_master_query AND
    sd.due_date = '".$mysqli->real_escape_string($_GET["due_date"]??Date("Y-m-d"))."' 
    AND sd.note LIKE '%".$mysqli->real_escape_string($_GET["waktu"]??"")."%' 
    order by operator_name asc"; // Gunakan placeholder untuk prepared statement

    $result = $mysqli->query($sql);

    // Array untuk menyimpan hasil
    $orderDetails = [];

    $tombol = '<div class="d-flex align-items-center">
    <a target=_blank href="cetak_invoice.php?no_invoice=[id]" data-bs-toggle="tooltip" class="text-body print-record" data-bs-placement="top" title="Print Invoice">
        <i class="fa fa-print"></i>
    </a>
    <a href="javascript:;" onclick=\'loadPage("order_detail.php?no_invoice=[id]")\' class="text-body" data-bs-placement="top" title="Preview Invoice">
        <i class="mdi mdi-eye-outline mdi-20px mx-1"></i>
    </a>
    <div class="dropdown">
        <a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown">
            <i class="mdi mdi-dots-vertical mdi-20px"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
            <a href="javascript:;" class="dropdown-item">Download</a>
            <a href="app-invoice-edit.html" class="dropdown-item">Edit</a>
            <a href="javascript:;" class="dropdown-item">Duplicate</a>
        </div>
    </div>
    </div>';
    function buatTombol($t, $invoice)
    {
        return str_replace("[id]", $invoice, $t);
    }

    // Cek jika hasilnya ada
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        $orderDetail = [];
        if ($raw) {
            $orderDetail = $row;
        } else {
            $orderDetail = [
                'no' => $no,
                'no_invoice' => "<a href='javascript:;' onclick=\"open_invoice('" . $row['no_invoice'] . "')\">" . $row['no_invoice'] . "</a> ",
                'totalorder' => "Rp " . number_format($row["totalorder"], 0, ',', '.'),
                'status' => $row['totalpay'] >= $row['totalorder'] ? "Lunas" : "Rp " . number_format($row['totalpay'] - $row['totalorder'], 0, ',', '.'),
                'costumer' => $row['name_customer'] . "<br>" . $row['telephone'],
                'alamat' => $row['address'],
                'aksi' => buatTombol($tombol, $row['no_invoice'])
            ];
        }
        $no++;
        // Menyimpan produk yang dipesan
        // Menyimpan produk yang dipesan
        $query = $mysqli->query("SELECT
        s.id_product, 
        s.amount, 
        s.price, 
        s.totalprice,
        p.name_product, 
        p.packages,
        p.folder,
        p.img,
        p.session
        FROM sales s 
        LEFT JOIN product p ON s.id_product = p.id_product 
        WHERE no_invoice = '".$row["no_invoice"]."'");
        $productsX=[];
        while ($product = $query->fetch_assoc()) {
            $jml = $product['amount'];
            // Jika produk adalah paket, ambil daftar produk anak
            if ($product['packages'] === 'YES') {
                $childProducts = getChildProducts($product['session'], $jml, $mysqli); // Fungsi untuk mengambil produk anak
                $product['childproduct'] = $childProducts;
                foreach ($childProducts as $p) {
                    $id_product = $p["id_product"];
                    if (!isset($products[$id_product])) {
                        $products[$id_product] = [
                            "name_product" => $p["name_product"],
                            "id_product" => $p["id_product"],
                            "img" => "https://zieda.id/pro/geten/images/no_image.jpg",
                            "invoices" => invoiceMaker($row["no_invoice"], $p["amount"], $raw),
                            "packages" => "YES"
                        ];
                    } else {
                        $products[$id_product]["invoices"] = $products[$id_product]["invoices"] . ", " . invoiceMaker($row["no_invoice"], $p["amount"], $raw);
                    }
                    $products[$id_product]["amount"] = ($products[$id_product]["amount"] ?? 0) + $p["amount"];
                }
            } else {
                $id_product = $product["id_product"];
                if (!isset($products[$id_product])) {
                    $products[$id_product] = [
                        "name_product" => $product["name_product"],
                        "id_product" => $product["id_product"],
                        "invoices" => invoiceMaker($row["no_invoice"], $product["amount"], $raw),
                        "packages" => $product["packages"] ?? "YES"
                    ];
                    if ($product['img'] !== "" && $product['folder'] !== "") {
                        $sumber = "https://zieda.id/pro/geten/images/" .$product['folder']."/". $product['img'];
                    } else {
                        $sumber = "https://zieda.id/pro/geten/images/no_image.jpg";
                    }
                    $products[$id_product]['img'] = $sumber;
                } else {
                    $products[$id_product]["invoices"] = $products[$id_product]["invoices"] . ", " . invoiceMaker($row["no_invoice"], $product["amount"], $raw);
                }
                $products[$id_product]["amount"] = ($products[$id_product]["amount"] ?? 0) + $product["amount"];
            }
            array_push($productsX, $product);
        }
        $orderDetail["products"] = $productsX;
        array_push($orderDetails, $orderDetail);
    }
    // Membuat array untuk JSON output
    $output = [
        'orderDetails' => $orderDetails,
        'products' => array_values($products)
    ];
    // Mengembalikan JSON
    return $output;
}