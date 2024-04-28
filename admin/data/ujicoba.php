<?php
require_once 'koneksi.php'; // Menggunakan file koneksi yang sama

function getProductsToProduceToday($mysqli)
{
    // Ambil tanggal hari ini
    $today = date('2023-m-d');

    // Query untuk mengambil nota dengan due_date hari ini
    $sql = "SELECT s.id_product, s.amount, p.packages, p.name_product FROM sales_data sd 
            LEFT JOIN sales s ON sd.no_invoice = s.no_invoice 
            LEFT JOIN product p ON s.id_product = p.id_product 
            WHERE sd.due_date = ?";

    // Membuat koneksi database

    // Memeriksa koneksi
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Mempersiapkan prepared statement
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die('Query preparation failed: ' . $mysqli->error);
    }

    // Bind parameter due_date ke prepared statement
    $stmt->bind_param('s', $today);

    // Menjalankan query
    $stmt->execute();

    // Mendapatkan hasil
    $result = $stmt->get_result();

    // Inisialisasi array untuk menyimpan jumlah produk yang harus diproduksi
    $productsToProduce = [];

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $name_product = $row['name_product'];
        $amount = $row['amount'];

        // Jika produk adalah produk non paket, langsung tambahkan jumlahnya
        if (isset($row['packages']) && $row['packages'] === 'NO') {
            if (isset($productsToProduce[$name_product])) {
                $productsToProduce[$name_product] += $amount;
            } else {
                $productsToProduce[$name_product] = $amount;
            }
        }
        // Jika produk adalah paket, ambil daftar produk anak dan tambahkan jumlahnya
        else if (isset($row['packages']) && $row['packages'] === 'YES' && isset($row['session'])) {
            $sessionId = $row['session'];
            $childProducts = getChildProducts($sessionId, $mysqli);
            foreach ($childProducts as $childProduct) {
                $productId = $childProduct['id_product'];
                $childProductName = getProductNames([$productId], $mysqli);
                $amount = $childProduct['amount'] * $row['amount']; // Jumlah produk anak dikalikan dengan jumlah paket yang dipesan
                if (isset($productsToProduce[$childProductName])) {
                    $productsToProduce[$childProductName] += $amount;
                } else {
                    $productsToProduce[$childProductName] = $amount;
                }
            }
        }
    }

    // Menutup statement
    $stmt->close();

    // Menutup koneksi
    $mysqli->close();

    return $productsToProduce;
}

// Fungsi untuk mengambil nama produk berdasarkan ID
function getProductNames($productIds, $mysqli)
{
    $productNames = [];

    // Membuat daftar placeholder untuk prepared statement
    $placeholders = implode(',', array_fill(0, count($productIds), '?'));

    // Query untuk mengambil nama produk berdasarkan ID
    $sql = "SELECT name_product FROM product WHERE id_product IN ($placeholders)";

    // Mempersiapkan prepared statement
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die('Query preparation failed: ' . $mysqli->error);
    }

    // Binding parameter
    $stmt->bind_param(str_repeat('i', count($productIds)), ...$productIds);

    // Menjalankan query
    $stmt->execute();

    // Mendapatkan hasil
    $result = $stmt->get_result();

    // Memasukkan nama produk ke dalam array
    while ($row = $result->fetch_assoc()) {
        $productNames[] = $row['name_product'];
    }

    // Menutup statement
    $stmt->close();

    return implode(', ', $productNames);
}

// Fungsi untuk mengambil produk anak dari paket
function getChildProducts($sessionId, $mysqli)
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
            'amount' => $row['amount'],
        ];
    }

    // Menutup statement
    $stmt->close();

    return $childProducts;
}

// Contoh pemanggilan fungsi
$productsToProduceToday = getProductsToProduceToday($mysqli);

// Mengonversi array menjadi format JSON
$jsonOutput = json_encode($productsToProduceToday, JSON_PRETTY_PRINT);

// Menampilkan JSON output
echo $jsonOutput;
