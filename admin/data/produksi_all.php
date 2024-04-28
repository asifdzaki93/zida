<?php
function getChildProducts($sessionId, $jml, $mysqli)
{
    // Query untuk mengambil produk anak dari paket
    $sql = "SELECT * FROM packagesproduct WHERE sesi = ?";

    // Mempersiapkan prepared statement
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die('Query preparation failed: ' . $mysqli->error);
    }

    // Bind parameter session ke prepared statement
    $stmt->bind_param('s', $sessionId);

    // Menjalankan query
    $stmt->execute();

    // Mendapatkan hasil
    $result = $stmt->get_result();

    // Array untuk menyimpan produk anak
    $childProducts = [];

    // Output data of each row
    $all_amount = 0;
    while ($product = $result->fetch_assoc()) {    
        $childProducts[] = [
            'id_product' => $product['id_product'],
            'name_product' => $product['name_product'],
            'amount' => $product['amount'] * $jml,
        ];
    }

    // Menutup statement
    $stmt->close();

    return $childProducts;
}

function invoiceMaker($invoice,$amount,$raw=false){
    if($raw){
        return $invoice." (".$amount.")";
    }
    return "<a href='order_detail.php?no_invoice=".$invoice."'>".$invoice." (".$amount.")"."</a>";
}

function getOrderData($mysqli,$raw=false){
    $products = [];
    // SQL Query
    $sql = "
    SELECT 
    sd.no_invoice,
    sd.totalorder,
    sd.totalpay,
    sd.img,
    c.name_customer, 
    c.telephone, 
    c.address, 
    s.id_product, 
    s.amount, 
    s.price, 
    s.totalprice,
    p.name_product, 
    p.packages,
    p.session 
    FROM sales_data sd 
    LEFT JOIN sales s ON sd.no_invoice = s.no_invoice 
    LEFT JOIN customer c ON sd.id_customer = c.id_customer 
    LEFT JOIN product p ON s.id_product = p.id_product 
    WHERE
    sd.due_date = ? AND sd.note LIKE ?"; // Gunakan placeholder untuk prepared statement

    // Mempersiapkan prepared statement
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die('Query preparation failed: ' . $mysqli->error);
    }

    // Bind parameter no_invoice ke prepared statement
    $due_date = $_GET["due_date"];
    $jenis_pengiriman = "%Jenis Pengiriman : ".$_GET["jenis_pengiriman"]."%";
    $stmt->bind_param('ss', $due_date,$jenis_pengiriman); // 's' menunjukkan bahwa parameter adalah string

    // Menjalankan query
    $stmt->execute();

    // Mendapatkan hasil
    $result = $stmt->get_result();

    // Array untuk menyimpan hasil
    $orderDetails = [];

    $tombol = '<div class="d-flex align-items-center">
    <a href="javascript:;" data-bs-toggle="tooltip" class="text-body print-record" data-bs-placement="top" title="Print Invoice">
        <i class="fa fa-print"></i>
    </a>
    <a href="order_detail.php?no_invoice=[id]" class="text-body" data-bs-placement="top" title="Preview Invoice">
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
    function buatTombol($t,$invoice){
        return str_replace("[id]",$invoice,$t);
    }

    // Cek jika hasilnya ada
    $no = 1;
    if ($result->num_rows > 0) {
        $first = true;
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $orderDetail = [];
            if($raw){
                $orderDetail = $row;
            }else{
                $orderDetail = [
                    'no'=>$no,
                    'no_invoice' => $row['no_invoice'],
                    'totalorder' => "Rp " . number_format($row["totalorder"],0,',','.'),
                    'status' => $row['totalpay']>=$row['totalorder']?"Lunas":"Rp " . number_format($row['totalpay']-$row['totalorder'],0,',','.'),
                    'costumer' => $row['name_customer']."<br>".$row['address']."<br>".$row['telephone'],
                    'aksi' => buatTombol($tombol,$row['no_invoice'])
                ];
            }
            $no++;
            // Menyimpan produk yang dipesan
            $product = [
                'id_product' => $row['id_product'],
                'packages' => $row['packages'],
                'session' => $row['session'],
                'img' => $row['img'],
                'name_product' => $row['name_product'],
                'amount' => $row['amount'],
                'price' => $row['price'],
                'totalprice' => $row['totalprice']
            ];
            $jml = $row['amount'];
            // Jika produk adalah paket, ambil daftar produk anak
            if ($row['packages'] === 'YES') {
                $childProducts = getChildProducts($row['session'], $jml, $mysqli); // Fungsi untuk mengambil produk anak
                $product['childproduct'] = $childProducts;
                foreach($childProducts as $p){
                    $id_product=$p["id_product"];
                    if(!isset($products[$id_product])){
                        $products[$id_product]=[
                            "name_product"=>$p["name_product"],
                            "id_product"=>$p["id_product"],
                            "img"=>"https://zieda.id/pro/geten/images/no_image.jpg",
                            "invoices"=>invoiceMaker($orderDetail["no_invoice"],$p["amount"],$raw),
                            "packages"=>"YES"
                        ];
                    }else{
                        $products[$id_product]["invoices"] = $products[$id_product]["invoices"].", ".invoiceMaker($orderDetail["no_invoice"],$p["amount"],$raw);
                    }
                    $products[$id_product]["amount"]=($products[$id_product]["amount"]??0)+$p["amount"];        
                }
            }else{
                $id_product=$product["id_product"];
                if(!isset($products[$id_product])){
                    $products[$id_product]=[
                        "name_product"=>$product["name_product"],
                        "id_product"=>$product["id_product"],
                        "invoices"=>invoiceMaker($orderDetail["no_invoice"],$product["amount"],$raw),
                        "packages"=>$product["packages"]??"YES"
                    ];
                    if ($product['img'] !== "") {
                        $sumber = "https://zieda.id/pro/geten/images/" . $product['img'];
                    } else {
                        $sumber = "https://zieda.id/pro/geten/images/no_image.jpg";
                    }
                    $products[$id_product]['img'] = $sumber;
                }else{
                    $products[$id_product]["invoices"] = $products[$id_product]["invoices"].", ".invoiceMaker($orderDetail["no_invoice"],$product["amount"],$raw);
                }
                $products[$id_product]["amount"]=($products[$id_product]["amount"]??0)+$product["amount"];
            }
            $orderDetail["products"]=$product;
            array_push($orderDetails,$orderDetail);
        }
    } else {
        // echo "0 results";
    }
    // Menutup statement dan koneksi
    $stmt->close();
    $mysqli->close();

    // Membuat array untuk JSON output
    $output = [
        'orderDetails' => $orderDetails,
        'products' => array_values($products)
    ];
    // Mengembalikan JSON
    return $output;
}
?>