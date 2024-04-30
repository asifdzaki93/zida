<?php
function getChildProducts($sessionId, $jml, $mysqli)
{
    // Query untuk mengambil produk anak dari paket
    $query = $mysqli->query("SELECT * FROM packagesproduct WHERE sesi = '$sessionId'");
    $all_amount = 0;
    while ($row = $query->fetch_array()) {
        $childProducts[] = [
            'id_product' => $row['id_product'],
            'name_product' => $row['name_product'],
            'amount' => $row['amount'] * $jml,
        ];
        $all_amount += $row['amount'] * $jml;
    }
    return $childProducts;
}

function getOrderData($mysqli)
{

    $noInvoice = $_GET["no_invoice"];
    // SQL Query
    $sql = "
    SELECT 
    sd.*,
    c.name_customer, 
    c.telephone, 
    c.address, 
    o.full_name as operator_name
    FROM sales_data sd 
    LEFT JOIN customer c ON sd.id_customer = c.id_customer 
    LEFT JOIN users o ON o.phone_number = sd.operator 
    WHERE
    sd.no_invoice = ?;"; // Gunakan placeholder untuk prepared statement

    // Mempersiapkan prepared statement
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die('Query preparation failed: ' . $mysqli->error);
    }

    // Bind parameter no_invoice ke prepared statement
    $stmt->bind_param('s', $noInvoice); // 's' menunjukkan bahwa parameter adalah string

    // Menjalankan query
    $stmt->execute();

    // Mendapatkan hasil
    $result = $stmt->get_result();

    // Array untuk menyimpan hasil
    $orderDetails = [];
    $products = [];

    // Cek jika hasilnya ada
    if ($result->num_rows > 0) {
        $first = true;
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            if ($first) {
                // Menyimpan detail pemesanan
                $orderDetails = [
                    'no_invoice' => $row['no_invoice'],
                    'date' => $row['date'],
                    'payment' => $row['payment'],
                    'note' => $row['note'],
                    'totalorder' => $row['totalorder'],
                    'totalprice' => $row['totalprice'],
                    'totalpay' => $row['totalpay'],
                    'changepay' => $row['changepay'],
                    'status' => $row['status'],
                    'due_date' => $row['due_date'],
                    'tax' => $row['tax'],
                    'discount' => $row['discount'],
                    'service_charge' => $row['service_charge'],
                    'operator' => $row['operator'],
                    'operator_name' => $row['operator_name'],
                    'location' => $row['location'],
                    'id_table' => $row['id_table'],
                    'ongkir' => $row['ongkir'],
                    'divisi' => $row['divisi'],
                    'customer_name' => $row['name_customer'],
                    'customer_address' => $row['address'],
                    'customer_telephone' => $row['telephone']
                ];
                $first = false; // Setelah menyimpan detail, tidak perlu menyimpan lagi
            }
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
            WHERE no_invoice = '" . $row["no_invoice"] . "'");
            while ($r = $query->fetch_array()) {
                $product = [
                    'id_product' => $r['id_product'],
                    'packages' => $r['packages'],
                    'session' => $r['session'],
                    'img' => '/' . $r['folder'] . '/' . $r['img'],
                    'name_product' => $r['name_product'],
                    'amount' => $r['amount'],
                    'price' => $r['price'],
                    'totalprice' => $r['totalprice']
                ];
                $jml = $r['amount'];
                // Jika produk adalah paket, ambil daftar produk anak
                if ($r['packages'] === 'YES') {
                    $childProducts = getChildProducts($r['session'], $jml, $mysqli); // Fungsi untuk mengambil produk anak
                    $product['childproduct'] = $childProducts;
                }
                array_push($products, $product);
            }
        }
    } else {
    }

    // Menutup statement dan koneksi
    $stmt->close();
    $mysqli->close();

    // Membuat array untuk JSON output
    $output = [
        'orderDetails' => $orderDetails,
        'products' => $products
    ];
    return $output;
}
