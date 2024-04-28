<?php
include("function.php"); // Pastikan semua fungsi yang diperlukan sudah diinclude
include("koneksi.php"); // Pastikan semua fungsi yang diperlukan sudah diinclude

header('Content-Type: application/json');

$bulan1 = date('Y-m-01'); // Misalnya, tanggal awal bulan ini
$bulan2 = date('Y-m-t');  // Misalnya, tanggal akhir bulan ini
$hari = date('Y-m-d');  // Misalnya, tanggal sekarang

$data = [
    '' => getTotalSalesDay($connect),
    '' => getPercentageChange($connect),
    '' => getPercentageChange($connect),
    'arrowIcon'         => $arrowIcon,
    'currentPackages'   => getCurrentPackages($connect),
    'currentProducts'   => getCurrentProducts($connect),
    'currentCustomers'  => getCurrentCustomers($connect),
    'currentStaff'      => getCurrentStaff($connect),
    'omset'             => getOmset($connect),
    'salesCount'        => getSalesCount($connect),
    'salesCountToday'   => getSalesCount($connect, true),
    'totalSales'        => getTotalSales($connect),
    'monthlyOmsetComparison' => compareMonthlyOmset($connect),
    'totalBayar'        => getTotalBayar($connect, $bulan1, $bulan2),
    'totalPreOrderPengiriman' => getTotalPreOrderPengiriman($connect, $bulan1, $bulan2),
    'totalPreOrderMasuk' => getTotalPreOrderMasuk($connect, $bulan1, $bulan2),
    'totalTransPengiriman' => getTotalTransPengiriman($connect, $bulan1, $bulan2),
    'totalTransMasuk'   => getTotalTransMasuk($connect, $bulan1, $bulan2),
    'totalTransMinus'   => getTotalTransMinus($connect, $bulan1, $bulan2),
    'countTransPengiriman' => getCountTransPengiriman($connect, $bulan1, $bulan2),
    'countPrePengiriman' => getCountPrePengiriman($connect, $bulan1, $bulan2),
    'countTransMasuk'   => getCountTransMasuk($connect, $bulan1, $bulan2),
    'countPreMasuk'     => getCountPreMasuk($connect, $bulan1, $bulan2),
    'countAllMasuk'     => getCountAllMasuk($connect, $bulan1, $bulan2),
    'countMinus'        => getCountMinus($connect, $bulan1, $bulan2),
    'selisih'           => $selisih = $totalPreOrderP - $totalBayar,
    'lunas1'            => ($selisih / $totalPreOrderP) * 100,
    'lunas2'            => ($totalBayar / $totalPreOrderP) * 100
];

echo json_encode($data); // Encode data menjadi JSON dan kirim sebagai respons
