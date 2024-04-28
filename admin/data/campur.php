<?php
function fetchOrderDetails($noInvoice)
{
    require_once 'koneksi.php'; // Menggunakan file koneksi yang sama

    // SQL Query
    $sql = "
    SELECT 
    sd.*,
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
            $products[] = [
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
                $products[count($products) - 1]['childproduct'] = $childProducts;
            }
        }
    } else {
        echo "0 results";
    }

    // Menutup statement dan koneksi
    $stmt->close();
    $mysqli->close();

    // Membuat array untuk JSON output
    $output = [
        'orderDetails' => $orderDetails,
        'products' => $products
    ];

    // Mengembalikan JSON
    return json_encode($output, JSON_PRETTY_PRINT);
}

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
    while ($row = $result->fetch_assoc()) {
        $childProducts[] = [
            'id_product' => $row['id_product'],
            'name_product' => $row['name_product'],
            'amount' => $row['amount'] * $jml,
        ];
    }

    // Menutup statement
    $stmt->close();

    return $childProducts;
}

// Contoh pemanggilan fungsi
$invoiceNumber = '1-SRM-P051122'; // Contoh nomor invoice
$jsonOutput = fetchOrderDetails($invoiceNumber);
echo $jsonOutput;
