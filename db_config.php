<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'lazisnu';
$database2 = "lazisnu";
$con = mysqli_connect("localhost", "root", "", "lazisnu");
if (!$con) {
    die("Terjadi Kesalahan Saat Menyambungkan database");
}
// Connect to database1
$dbconfig = mysqli_connect($host, $username, $password, $database) or die("Terjadi Kesalahan Saat Menyambungkan database");
// Connect to database2
$conn = mysqli_connect($host, $username, $password, $database2) or die("Terjadi Kesalahan Saat Menyambungkan database");
// Konfigurasi Google Client
$clientID = '240758544095-76bg96dj5r71dksau2m2ltgvhdle2fb9.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/lazis/index.php';
$apiUri = 'http://localhost:8080/api/';


// Query untuk mengambil nama aplikasi dari database pengaturan
$query = "SELECT * FROM setting WHERE setting_name = 'nama_app'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Jika data ditemukan, ambil nilai nama aplikasi
    $row = mysqli_fetch_assoc($result);
    $namaapp = $row['value'];
} else {
    // Jika data tidak ditemukan, tetap gunakan nilai default
    $namaapp = "LazisNU APP";
}
// Query untuk mengambil nama aplikasi dari database pengaturan
$query2 = "SELECT * FROM setting WHERE setting_name = 'alamat'";
$result2 = mysqli_query($conn, $query2);

if (mysqli_num_rows($result2) > 0) {
    // Jika data ditemukan, ambil nilai nama aplikasi
    $row2 = mysqli_fetch_assoc($result2);
    $alamat = $row['value'];
} else {
    // Jika data tidak ditemukan, tetap gunakan nilai default
    $alamat = "alamat belum ada";
}
