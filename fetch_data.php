<?php
header('Content-Type: application/json');

include('admin/data/koneksi.php');
$date = "2023-05-15";  // Assuming you want to use the current year and month with 25th day

function fetchData($mysqli, $a, $b, $c, $table, $date, $whereClause = null)
{
    $query = "SELECT $a, $b, $c FROM $table WHERE date = ? " . ($whereClause ? " AND $whereClause" : "");
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        die('MySQL prepare error: ' . $mysqli->error);
    }
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    $totalJumlah = 0;

    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'no_invoice' => $row[$a],
            'jumlah' => $row[$b],
            'keterangan' => $c ? $row[$c] : '-'
        ];
        $totalJumlah += $row[$b];
    }

    $stmt->close();

    return [
        'transaksi' => $data,
        'total' => $totalJumlah
    ];
}

function calculateOverallTotal($categories)
{
    $overallTotal = 0;
    foreach ($categories as $category) {
        $overallTotal += $category['total'];
    }
    return $overallTotal;
}

$pemasukan = [
    'penerimaan dari penjualan tunai' => fetchData($mysqli, 'no_invoice', 'totalorder', 0, 'sales_data', $date, 'status="paid off"'),
    'penerimaan dari penjualan tempo / dp' => fetchData($mysqli, 'no_invoice', 'totalpay', 'note', 'sales_data', $date, 'due_date!="0000-00-00" AND totalpay > 0')
];

$pengeluaran = [
    'Bahan Bakar' => fetchData($mysqli, 'no_invoice', 'totalpay', 0, 'sales_data', $date, 'due_date!="0000-00-00"')
];

$totalPemasukan = calculateOverallTotal($pemasukan);
$totalPengeluaran = calculateOverallTotal($pengeluaran);

$data = [
    'pemasukan' => $pemasukan,
    'totalPemasukan' => $totalPemasukan,
    'pengeluaran' => $pengeluaran,
    'totalPengeluaran' => $totalPengeluaran
];

echo json_encode($data, JSON_PRETTY_PRINT);
