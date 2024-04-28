<?php
session_start();
error_reporting(0);

// Include connection and session files
include "koneksi.php";  // Database connection
include "sesi.php";     // Session management

// Set user session
$_SESSION['namauser'] = '082322345757';

/**
 * Calculate the total revenue for the current month.
 * 
 * @param mysqli $connect Database connection object
 * @return string Formatted revenue as a string with currency symbol
 */
function getOmset($connect)
{
    $bulan1 = date('Y-m-01');
    $bulan2 = date('Y-m-d');
    $query = mysqli_query($connect, "SELECT SUM(totalorder) as total FROM sales_data WHERE user='$_SESSION[namauser]' AND date BETWEEN '$bulan1' AND '$bulan2'");
    $data = mysqli_fetch_array($query);

    if (empty($data['total'])) {
        $omset = 0;
    } elseif ($data['total'] < 1000000) {
        $omset = number_format($data['total']);
    } else {
        $omset = number_format(($data['total'] / 1000000), 2, ',', '.') . ' Jt';
    }

    return 'Rp. ' . $omset;
}

/**
 * Retrieve the count of sales records, optionally filtering for pre-orders.
 * 
 * @param mysqli $connect Database connection object
 * @param bool $isPreOrder Flag to filter for pre-orders
 * @return string Formatted count of sales
 */
function getSalesCount($connect, $isPreOrder = false)
{
    $bulan1 = date('Y-m-01');
    $bulan2 = date('Y-m-d');
    $dueDateCondition = $isPreOrder ? "!= ''" : "= ''";
    $query = mysqli_query($connect, "SELECT * FROM sales_data WHERE user='$_SESSION[namauser]' AND due_date $dueDateCondition AND date BETWEEN '$bulan1' AND '$bulan2'");
    $count = mysqli_num_rows($query);

    return number_format($count, 0, ',', '.');
}

/**
 * Get the total count of all sales records for the current month.
 * 
 * @param mysqli $connect Database connection object
 * @return string Formatted total sales count
 */
function getTotalSales($connect)
{
    $bulan1 = date('Y-m-01');
    $bulan2 = date('Y-m-d');
    $query = mysqli_query($connect, "SELECT * FROM sales_data WHERE user='$_SESSION[namauser]' AND date BETWEEN '$bulan1' AND '$bulan2'");
    $count = mysqli_num_rows($query);

    return number_format($count, 0, ',', '.');
}

/**
 * Get the total count of all sales records for the current month.
 * 
 * @param mysqli $connect Database connection object
 * @return string Formatted total sales count
 */
function getTotalSalesDay($connect)
{
    $bulan1 = date('Y-m-01');
    $bulan2 = date('Y-m-d');
    $query = mysqli_query($connect, "SELECT * FROM sales_data WHERE user='$_SESSION[namauser]' AND date BETWEEN '$bulan2' AND '$bulan2'");
    $count = mysqli_num_rows($query);

    return number_format($count, 0, ',', '.');
}

function getPercentageChange($connect)
{
    // Mendapatkan tanggal hari ini dan kemarin
    $today = date('Y-m-d');
    $yesterday = date('Y-m-d', strtotime('-1 day'));

    // Mendapatkan jumlah transaksi hari ini
    $query_today = mysqli_query($connect, "SELECT * FROM sales_data WHERE user='$_SESSION[namauser]' AND date = '$today'");
    $count_today = mysqli_num_rows($query_today);

    // Mendapatkan jumlah transaksi kemarin
    $query_yesterday = mysqli_query($connect, "SELECT * FROM sales_data WHERE user='$_SESSION[namauser]' AND date = '$yesterday'");
    $count_yesterday = mysqli_num_rows($query_yesterday);

    // Menghitung persentase kenaikan atau penurunan
    if ($count_yesterday != 0) {
        $change = (($count_today - $count_yesterday) / $count_yesterday) * 100;
        return number_format($change, 2);
    } else {
        // Jika tidak ada transaksi kemarin, persentase dianggap 100%
        return 100;
    }
}

// Mendapatkan persentase kenaikan atau penurunan
$percentageChange = getPercentageChange($connect);
// Menentukan tanda panah berdasarkan nilai persentase
$arrowIcon = ($percentageChange < 0) ? 'mdi mdi-chevron-down' : 'mdi mdi-chevron-up';
$color = ($percentageChange < 0) ? 'danger' : 'success';


/**
 * Compare monthly revenue between this month and the previous month.
 * 
 * @param mysqli $connect Database connection object
 * @return string HTML content describing the percentage change
 */
function compareMonthlyOmset($connect)
{
    // Fetch data for the current month
    $currentMonthStart = date('Y-m-01');
    $currentMonthEnd = date('Y-m-d');
    $currentQuery = mysqli_query($connect, "SELECT SUM(totalorder) AS total FROM sales_data WHERE user='$_SESSION[namauser]' AND date BETWEEN '$currentMonthStart' AND '$currentMonthEnd'");
    $currentData = mysqli_fetch_array($currentQuery);
    $currentOmset = $currentData['total'] ? $currentData['total'] : 0;

    // Fetch data for the previous month
    $previousMonthStart = date('Y-m-01', strtotime('-1 month'));
    $previousMonthEnd = date('Y-m-t', strtotime('-1 month'));
    $previousQuery = mysqli_query($connect, "SELECT SUM(totalorder) AS total FROM sales_data WHERE user='$_SESSION[namauser]' AND date BETWEEN '$previousMonthStart' AND '$previousMonthEnd'");
    $previousData = mysqli_fetch_array($previousQuery);
    $previousOmset = $previousData['total'] ? $previousData['total'] : 0;

    // Calculate percentage change
    if ($previousOmset == 0) {
        return "Tidak ada data omset untuk bulan sebelumnya.";
    } else {
        $change = (($currentOmset - $previousOmset) / $previousOmset) * 100;
        $formattedChange = number_format($change, 2, ',', '.');
        if ($change > 0) {
            return "<div class='d-flex align-items-center text-success'><p class='mb-0'> $formattedChange% </p><i class='mdi mdi-chevron-up'></i></div>";
        } else if ($change < 0) {
            return "<div class='d-flex align-items-center text-danger'><p class='mb-0'> $formattedChange% </p><i class='mdi mdi-chevron-down'></i></div>";
        } else {
            return "<div class='d-flex align-items-center text-info'><p class='mb-0'> 0% </p><i class='mdi mdi-chevron-up'></i></div>";
        }
    }
}


/**
 * Get the count of packages for the current user.
 * 
 * @param mysqli $connect Database connection object
 * @return string Formatted count of packages
 */
function getCurrentPackages($connect)
{
    $query = mysqli_query($connect, "SELECT * FROM product WHERE user='$_SESSION[namauser]' AND packages='YES'");
    $count = mysqli_num_rows($query);
    return number_format($count, 0, ',', '.');
}

/**
 * Get the count of products for the current user.
 * 
 * @param mysqli $connect Database connection object
 * @return string Formatted count of products
 */
function getCurrentProducts($connect)
{
    $query = mysqli_query($connect, "SELECT * FROM product WHERE user='$_SESSION[namauser]' AND packages='NO'");
    $count = mysqli_num_rows($query);
    return number_format($count, 0, ',', '.');
}

/**
 * Get the count of customers for the current user.
 * 
 * @param mysqli $connect Database connection object
 * @return string Formatted count of customers
 */
function getCurrentCustomers($connect)
{
    $query = mysqli_query($connect, "SELECT * FROM customer WHERE user='$_SESSION[namauser]'");
    $count = mysqli_num_rows($query);
    return number_format($count, 0, ',', '.');
}

/**
 * Get the count of staff members associated with the current user.
 * 
 * @param mysqli $connect Database connection object
 * @return string Formatted count of staff members
 */
function getCurrentStaff($connect)
{
    $query = mysqli_query($connect, "SELECT * FROM users WHERE master='$_SESSION[namauser]'");
    $count = mysqli_num_rows($query);
    return number_format($count, 0, ',', '.');
}



$bulan1 = date('Y-m-d');
$bulan2 = date('Y-m-d');
function getTotalBayar($connect, $bulan1, $bulan2)
{
    $namauser = $_SESSION['namauser'];
    $payorders = mysqli_query($connect, "SELECT SUM(totalpay) as totalpy FROM sales_data WHERE user='$namauser' AND due_date != '0000-00-00' AND status IN ('pre order', 'finish') AND `due_date` BETWEEN '$bulan1' AND '$bulan2'");
    $pay = mysqli_fetch_array($payorders);
    return $pay['totalpy']; // Mengembalikan jumlah total yang sudah dibayar
}

function getTotalPreOrderPengiriman($connect, $bulan1, $bulan2)
{
    $namauser = $_SESSION['namauser'];
    $preorders = mysqli_query($connect, "SELECT SUM(totalorder) as totalpo FROM sales_data WHERE user='$namauser' AND due_date != '0000-00-00' AND status IN ('pre order', 'finish') AND `due_date` BETWEEN '$bulan1' AND '$bulan2'");
    $po = mysqli_fetch_array($preorders);
    return $po['totalpo']; // Mengembalikan jumlah total pre order
}

function getTotalTransPengiriman($connect, $bulan1, $bulan2)
{
    $namauser = $_SESSION['namauser'];
    $orders = mysqli_query($connect, "SELECT SUM(totalorder) as totalpo FROM sales_data WHERE user='$namauser' AND `due_date` BETWEEN '$bulan1' AND '$bulan2'");
    $po = mysqli_fetch_array($orders);
    return $po['totalpo']; // Mengembalikan jumlah total pre order
}

function getTotalTransMinus($connect, $bulan1, $bulan2)
{
    $namauser = mysqli_real_escape_string($connect, $_SESSION['namauser']); // Sanitize input untuk mencegah SQL Injection
    $query = "SELECT SUM(totalorder - totalpay) as totalDeficit FROM sales_data WHERE user='$namauser' AND totalpay < totalorder AND status NOT IN ('cancel') AND `date` BETWEEN '$bulan1' AND '$bulan2'";
    $orders = mysqli_query($connect, $query);
    if (!$orders) {
        die('Error: ' . mysqli_error($connect)); // Menangani error jika query gagal
    }
    $po = mysqli_fetch_array($orders);
    return $po['totalDeficit'] ?: 0; // Mengembalikan 0 jika tidak ada hasil
}


function getTotalPreOrderMasuk($connect, $bulan1, $bulan2)
{
    $namauser = $_SESSION['namauser'];
    $preorders = mysqli_query($connect, "SELECT SUM(totalorder) as totalpo FROM sales_data WHERE user='$namauser' AND due_date != '0000-00-00' AND status IN ('pre order', 'finish') AND `date` BETWEEN '$bulan1' AND '$bulan2'");
    $po = mysqli_fetch_array($preorders);
    return $po['totalpo']; // Mengembalikan jumlah total pre order
}

function getTotalTransMasuk($connect, $bulan1, $bulan2)
{
    $namauser = $_SESSION['namauser'];
    $orders = mysqli_query($connect, "SELECT SUM(totalorder) as totalpo FROM sales_data WHERE user='$namauser' AND `date` BETWEEN '$bulan1' AND '$bulan2'");
    $po = mysqli_fetch_array($orders);
    return $po['totalpo']; // Mengembalikan jumlah total pre order
}

function getPercentage($totalPay, $totalPreOrder)
{
    return ($totalPay / $totalPreOrder) * 100; // Mengembalikan persentase
}

function getCountCash($connect, $bulan1, $bulan2)
{
    $namauser = $_SESSION['namauser'];
    // Query untuk menghitung jumlah transaksi
    $transactions = mysqli_query($connect, "SELECT COUNT(*) as transactionCount FROM sales_data WHERE user='$namauser' AND due_date = '0000-00-00' AND `date` BETWEEN '$bulan1' AND '$bulan2'");
    $result = mysqli_fetch_array($transactions);
    return $result['transactionCount']; // Mengembalikan jumlah transaksi
}

function getCountTransPengiriman($connect, $bulan1, $bulan2)
{
    $namauser = $_SESSION['namauser'];
    // Query untuk menghitung jumlah transaksi
    $transactions = mysqli_query($connect, "SELECT COUNT(*) as transactionCount FROM sales_data WHERE user='$namauser' AND due_date = '0000-00-00' AND `due_date` BETWEEN '$bulan1' AND '$bulan2'");
    $result = mysqli_fetch_array($transactions);
    return $result['transactionCount']; // Mengembalikan jumlah transaksi
}

function getCountPrePengiriman($connect, $bulan1, $bulan2)
{
    $namauser = $_SESSION['namauser'];
    // Query untuk menghitung jumlah transaksi
    $transactions = mysqli_query($connect, "SELECT COUNT(*) as transactionCount FROM sales_data WHERE user='$namauser' AND due_date != '0000-00-00' AND status IN ('pre order', 'finish') AND `due_date` BETWEEN '$bulan1' AND '$bulan2'");
    $result = mysqli_fetch_array($transactions);
    return $result['transactionCount']; // Mengembalikan jumlah transaksi
}

function getCountTransMasuk($connect, $bulan1, $bulan2)
{
    $namauser = $_SESSION['namauser'];
    // Query untuk menghitung jumlah transaksi
    $transactions = mysqli_query($connect, "SELECT COUNT(*) as transactionCount FROM sales_data WHERE user='$namauser' AND due_date = '0000-00-00' AND `date` BETWEEN '$bulan1' AND '$bulan2'");
    $result = mysqli_fetch_array($transactions);
    return $result['transactionCount']; // Mengembalikan jumlah transaksi
}

function getCountPreMasuk($connect, $bulan1, $bulan2)
{
    $namauser = $_SESSION['namauser'];
    // Query untuk menghitung jumlah transaksi
    $transactions = mysqli_query($connect, "SELECT COUNT(*) as transactionCount FROM sales_data WHERE user='$namauser' AND due_date != '0000-00-00' AND status IN ('pre order', 'finish') AND `date` BETWEEN '$bulan1' AND '$bulan2'");
    $result = mysqli_fetch_array($transactions);
    return $result['transactionCount']; // Mengembalikan jumlah transaksi
}

function getCountAllMasuk($connect, $bulan1, $bulan2)
{
    $namauser = $_SESSION['namauser'];
    // Query untuk menghitung jumlah transaksi
    $transactions = mysqli_query($connect, "SELECT COUNT(*) as transactionCount FROM sales_data WHERE user='$namauser' AND status NOT IN ('cancel') AND `date` BETWEEN '$bulan1' AND '$bulan2'");
    $result = mysqli_fetch_array($transactions);
    return $result['transactionCount']; // Mengembalikan jumlah transaksi
}

function getCountMinus($connect, $bulan1, $bulan2)
{
    $namauser = $_SESSION['namauser'];
    // Query untuk menghitung jumlah transaksi dimana total pembayaran kurang dari total pesanan
    $transactions = mysqli_query($connect, "SELECT COUNT(*) as transactionCount FROM sales_data WHERE user='$namauser' AND totalpay < totalorder AND due_date != '0000-00-00' AND status IN ('pre order', 'finish') AND due_date BETWEEN '$bulan1' AND '$bulan2'");
    $result = mysqli_fetch_array($transactions);
    return $result['transactionCount']; // Mengembalikan jumlah transaksi
}




// Display results
//echo getCurrentPackages($connect);
//echo getCurrentProducts($connect);
//echo getCurrentCustomers($connect);
//echo getCurrentStaff($connect);

//echo getOmset($connect);
//echo getSalesCount($connect);
//echo getSalesCount($connect, true);
//echo getTotalSales($connect);
//echo compareMonthlyOmset($connect);



?>
            <?php
            $totalBayar     = getTotalBayar($connect, $bulan1, $bulan2);
            $totalPreOrderP = getTotalPreOrderPengiriman($connect, $bulan1, $bulan2);
            $totalPreOrderM = getTotalPreOrderMasuk($connect, $bulan1, $bulan2);
            $totalTransP    = getTotalTransPengiriman($connect, $bulan1, $bulan2);
            $totalTransM    = getTotalTransMasuk($connect, $bulan1, $bulan2);
            $totalTransMin  = getTotalTransMinus($connect, $bulan1, $bulan2);
            $countTransP    = getCountTransPengiriman($connect, $bulan1, $bulan2);
            $countPreOrderP = getCountPrePengiriman($connect, $bulan1, $bulan2);
            $countTransM    = getCountTransMasuk($connect, $bulan1, $bulan2);
            $countPreOrderM = getCountPreMasuk($connect, $bulan1, $bulan2);
            $countAllM      = getCountAllMasuk($connect, $bulan1, $bulan2);
            $countMinus     = getCountMinus($connect, $bulan1, $bulan2);

            $selisih        = $totalPreOrderP - $totalBayar;
            $lunas1         = ($selisih / $totalPreOrderP) * 100;
            $lunas2         = ($totalBayar / $totalPreOrderP) * 100;
            ?>