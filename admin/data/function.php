<?php
// session_start();
// error_reporting(0);

// Include connection and session files
//include "sesi.php";     // Session management

/**
 * Calculate the total revenue for the current month.
 * 
 * @param mysqli $mysqli Database connection object
 * @return string Formatted revenue as a string with currency symbol
 */
function getOmset($mysqli)
{
    $bulan1 = date('Y-m-01');
    $bulan2 = date('Y-m-d');
    $query = $mysqli->query( "SELECT SUM(totalorder) as total FROM sales_data WHERE user='$mysqli->user_master' AND date BETWEEN '$bulan1' AND '$bulan2'");
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
 * @param mysqli $mysqli Database connection object
 * @param bool $isPreOrder Flag to filter for pre-orders
 * @return string Formatted count of sales
 */
function getSalesCount($mysqli, $isPreOrder = false)
{
    $bulan1 = date('Y-m-01');
    $bulan2 = date('Y-m-d');
    $dueDateCondition = $isPreOrder ? "!= ''" : "= ''";
    $query = $mysqli->query( "SELECT * FROM sales_data WHERE user='$mysqli->user_master' AND due_date $dueDateCondition AND date BETWEEN '$bulan1' AND '$bulan2'");
    $count = mysqli_num_rows($query);

    return number_format($count, 0, ',', '.');
}

/**
 * Get the total count of all sales records for the current month.
 * 
 * @param mysqli $mysqli Database connection object
 * @return string Formatted total sales count
 */
function getTotalSales($mysqli)
{
    $bulan1 = date('Y-m-01');
    $bulan2 = date('Y-m-d');
    $query = $mysqli->query( "SELECT * FROM sales_data WHERE user='$mysqli->user_master' AND date BETWEEN '$bulan1' AND '$bulan2'");
    $count = mysqli_num_rows($query);

    return number_format($count, 0, ',', '.');
}

/**
 * Get the total count of all sales records for the current month.
 * 
 * @param mysqli $mysqli Database connection object
 * @return string Formatted total sales count
 */
function getTotalSalesDay($mysqli)
{
    $query = $mysqli->query( "SELECT * FROM sales_data WHERE user='$mysqli->user_master' AND date = '".date('Y-m-d')."'");
    $count = mysqli_num_rows($query);

    return number_format($count, 0, ',', '.');
}

function getPercentageChange($mysqli)
{
    // Mendapatkan tanggal hari ini dan kemarin
    $today = date('Y-m-d');
    $yesterday = date('Y-m-d', strtotime('-1 day'));

    // Mendapatkan jumlah transaksi hari ini
    $query_today = $mysqli->query( "SELECT * FROM sales_data WHERE user='$mysqli->user_master' AND date = '$today'");
    $count_today = mysqli_num_rows($query_today);

    // Mendapatkan jumlah transaksi kemarin
    $query_yesterday = $mysqli->query( "SELECT * FROM sales_data WHERE user='$mysqli->user_master' AND date = '$yesterday'");
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

// Mendapatkan icon persentase kenaikan atau penurunan
function getPercentageChangeIcon($percentageChange){
    $arrowIcon = ($percentageChange < 0) ? 'mdi mdi-chevron-down' : 'mdi mdi-chevron-up';
    $color = ($percentageChange < 0) ? 'danger' : 'success';    
    return ["arrowIcon"=>$arrowIcon,"color"=>$color];
}


/**
 * Compare monthly revenue between this month and the previous month.
 * 
 * @param mysqli $mysqli Database connection object
 * @return string HTML content describing the percentage change
 */
function compareMonthlyOmset($mysqli)
{
    // Fetch data for the current month
    $currentMonthStart = date('Y-m-01');
    $currentMonthEnd = date('Y-m-d');
    $currentQuery = $mysqli->query( "SELECT SUM(totalorder) AS total FROM sales_data WHERE user='$mysqli->user_master' AND date BETWEEN '$currentMonthStart' AND '$currentMonthEnd'");
    $currentData = mysqli_fetch_array($currentQuery);
    $currentOmset = $currentData['total'] ? $currentData['total'] : 0;

    // Fetch data for the previous month
    $previousMonthStart = date('Y-m-01', strtotime('-1 month'));
    $previousMonthEnd = date('Y-m-t', strtotime('-1 month'));
    $previousQuery = $mysqli->query( "SELECT SUM(totalorder) AS total FROM sales_data WHERE user='$mysqli->user_master' AND date BETWEEN '$previousMonthStart' AND '$previousMonthEnd'");
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
 * @param mysqli $mysqli Database connection object
 * @return string Formatted count of packages
 */
function getCurrentPackages($mysqli)
{
    $query = $mysqli->query("SELECT * FROM product WHERE user='$mysqli->user_master' AND packages='YES'");
    $count = mysqli_num_rows($query);
    return number_format($count, 0, ',', '.');
}

/**
 * Get the count of products for the current user.
 * 
 * @param mysqli $mysqli Database connection object
 * @return string Formatted count of products
 */
function getCurrentProducts($mysqli)
{
    $query = $mysqli->query( "SELECT * FROM product WHERE user='$mysqli->user_master' AND packages='NO'");
    $count = mysqli_num_rows($query);
    return number_format($count, 0, ',', '.');
}

/**
 * Get the count of customers for the current user.
 * 
 * @param mysqli $mysqli Database connection object
 * @return string Formatted count of customers
 */
function getCurrentCustomers($mysqli)
{
    $query = $mysqli->query( "SELECT * FROM customer WHERE user='$mysqli->user_master'");
    $count = mysqli_num_rows($query);
    return number_format($count, 0, ',', '.');
}

/**
 * Get the count of staff members associated with the current user.
 * 
 * @param mysqli $mysqli Database connection object
 * @return string Formatted count of staff members
 */
function getCurrentStaff($mysqli)
{
    $query = $mysqli->query( "SELECT * FROM users WHERE master='$mysqli->user_master'");
    $count = mysqli_num_rows($query);
    return number_format($count, 0, ',', '.');
}



$bulan1 = date('Y-m-d');
$bulan2 = date('Y-m-d');
function getTotalBayar($mysqli, $bulan1, $bulan2)
{
    $namauser = $mysqli->user_master;
    $payorders = $mysqli->query( "SELECT SUM(totalpay) as totalpy FROM sales_data WHERE user='$namauser' AND due_date != '0000-00-00' AND status IN ('pre order', 'finish') AND `due_date` BETWEEN '$bulan1' AND '$bulan2'");
    $pay = mysqli_fetch_array($payorders);
    return $pay['totalpy']; // Mengembalikan jumlah total yang sudah dibayar
}

function getTotalPreOrderPengiriman($mysqli, $bulan1, $bulan2)
{
    $namauser = $mysqli->user_master;
    $preorders = $mysqli->query( "SELECT SUM(totalorder) as totalpo FROM sales_data WHERE user='$namauser' AND due_date != '0000-00-00' AND status IN ('pre order', 'finish') AND `due_date` BETWEEN '$bulan1' AND '$bulan2'");
    $po = mysqli_fetch_array($preorders);
    return $po['totalpo']; // Mengembalikan jumlah total pre order
}

function getTotalTransPengiriman($mysqli, $bulan1, $bulan2)
{
    $namauser = $mysqli->user_master;
    $orders = $mysqli->query( "SELECT SUM(totalorder) as totalpo FROM sales_data WHERE user='$namauser' AND `due_date` BETWEEN '$bulan1' AND '$bulan2'");
    $po = mysqli_fetch_array($orders);
    return $po['totalpo']; // Mengembalikan jumlah total pre order
}

function getTotalTransMinus($mysqli, $bulan1, $bulan2)
{
    $namauser = mysqli_real_escape_string($mysqli, $mysqli->user_master); // Sanitize input untuk mencegah SQL Injection
    $query = "SELECT SUM(totalorder - totalpay) as totalDeficit FROM sales_data WHERE user='$namauser' AND totalpay < totalorder AND status NOT IN ('cancel') AND `date` BETWEEN '$bulan1' AND '$bulan2'";
    $orders = $mysqli->query( $query);
    if (!$orders) {
        die('Error: ' . mysqli_error($mysqli)); // Menangani error jika query gagal
    }
    $po = mysqli_fetch_array($orders);
    return $po['totalDeficit'] ?: 0; // Mengembalikan 0 jika tidak ada hasil
}


function getTotalPreOrderMasuk($mysqli, $bulan1, $bulan2)
{
    $namauser = $mysqli->user_master;
    $preorders = $mysqli->query( "SELECT SUM(totalorder) as totalpo FROM sales_data WHERE user='$namauser' AND due_date != '0000-00-00' AND status IN ('pre order', 'finish') AND `date` BETWEEN '$bulan1' AND '$bulan2'");
    $po = mysqli_fetch_array($preorders);
    return $po['totalpo']; // Mengembalikan jumlah total pre order
}

function getTotalTransMasuk($mysqli, $bulan1, $bulan2)
{
    $namauser = $mysqli->user_master;
    $orders = $mysqli->query( "SELECT SUM(totalorder) as totalpo FROM sales_data WHERE user='$namauser' AND `date` BETWEEN '$bulan1' AND '$bulan2'");
    $po = mysqli_fetch_array($orders);
    return $po['totalpo']; // Mengembalikan jumlah total pre order
}

function getPercentage($totalPay, $totalPreOrder)
{
    return ($totalPay / $totalPreOrder) * 100; // Mengembalikan persentase
}

function getCountCash($mysqli, $bulan1, $bulan2)
{
    $namauser = $mysqli->user_master;
    // Query untuk menghitung jumlah transaksi
    $transactions = $mysqli->query( "SELECT COUNT(*) as transactionCount FROM sales_data WHERE user='$namauser' AND due_date = '0000-00-00' AND `date` BETWEEN '$bulan1' AND '$bulan2'");
    $result = mysqli_fetch_array($transactions);
    return $result['transactionCount']; // Mengembalikan jumlah transaksi
}

function getCountTransPengiriman($mysqli, $bulan1, $bulan2)
{
    $namauser = $mysqli->user_master;
    // Query untuk menghitung jumlah transaksi
    $transactions = $mysqli->query( "SELECT COUNT(*) as transactionCount FROM sales_data WHERE user='$namauser' AND due_date = '0000-00-00' AND `due_date` BETWEEN '$bulan1' AND '$bulan2'");
    $result = mysqli_fetch_array($transactions);
    return $result['transactionCount']; // Mengembalikan jumlah transaksi
}

function getCountPrePengiriman($mysqli, $bulan1, $bulan2)
{
    $namauser = $mysqli->user_master;
    // Query untuk menghitung jumlah transaksi
    $transactions = $mysqli->query( "SELECT COUNT(*) as transactionCount FROM sales_data WHERE user='$namauser' AND due_date != '0000-00-00' AND status IN ('pre order', 'finish') AND `due_date` BETWEEN '$bulan1' AND '$bulan2'");
    $result = mysqli_fetch_array($transactions);
    return $result['transactionCount']; // Mengembalikan jumlah transaksi
}

function getCountTransMasuk($mysqli, $bulan1, $bulan2)
{
    $namauser = $mysqli->user_master;
    // Query untuk menghitung jumlah transaksi
    $transactions = $mysqli->query( "SELECT COUNT(*) as transactionCount FROM sales_data WHERE user='$namauser' AND due_date = '0000-00-00' AND `date` BETWEEN '$bulan1' AND '$bulan2'");
    $result = mysqli_fetch_array($transactions);
    return $result['transactionCount']; // Mengembalikan jumlah transaksi
}

function getCountPreMasuk($mysqli, $bulan1, $bulan2)
{
    $namauser = $mysqli->user_master;
    // Query untuk menghitung jumlah transaksi
    $transactions = $mysqli->query( "SELECT COUNT(*) as transactionCount FROM sales_data WHERE user='$namauser' AND due_date != '0000-00-00' AND status IN ('pre order', 'finish') AND `date` BETWEEN '$bulan1' AND '$bulan2'");
    $result = mysqli_fetch_array($transactions);
    return $result['transactionCount']; // Mengembalikan jumlah transaksi
}

function getCountAllMasuk($mysqli, $bulan1, $bulan2)
{
    $namauser = $mysqli->user_master;
    // Query untuk menghitung jumlah transaksi
    $transactions = $mysqli->query( "SELECT COUNT(*) as transactionCount FROM sales_data WHERE user='$namauser' AND status NOT IN ('cancel') AND `date` BETWEEN '$bulan1' AND '$bulan2'");
    $result = mysqli_fetch_array($transactions);
    return $result['transactionCount']; // Mengembalikan jumlah transaksi
}

function getCountMinus($mysqli, $bulan1, $bulan2)
{
    $namauser = $mysqli->user_master;
    // Query untuk menghitung jumlah transaksi dimana total pembayaran kurang dari total pesanan
    $transactions = $mysqli->query( "SELECT COUNT(*) as transactionCount FROM sales_data WHERE user='$namauser' AND totalpay < totalorder AND due_date != '0000-00-00' AND status IN ('pre order', 'finish') AND due_date BETWEEN '$bulan1' AND '$bulan2'");
    $result = mysqli_fetch_array($transactions);
    return $result['transactionCount']; // Mengembalikan jumlah transaksi
}




// Display results
//echo getCurrentPackages($mysqli);
//echo getCurrentProducts($mysqli);
//echo getCurrentCustomers($mysqli);
//echo getCurrentStaff($mysqli);

//echo getOmset($mysqli);
//echo getSalesCount($mysqli);
//echo getSalesCount($mysqli, true);
//echo getTotalSales($mysqli);
//echo compareMonthlyOmset($mysqli);



?>