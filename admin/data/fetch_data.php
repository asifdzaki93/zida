<?php
header('Content-Type: application/json');

include('koneksi.php');
$date = "2023-05-15"; // Menggunakan tanggal spesifik

function fetchData($mysqli, $select, $table, $date, $whereClause = null)
{
    $query = "SELECT operator, SUM($select) as total, GROUP_CONCAT(CONCAT_WS('|', no_invoice, $select, note) SEPARATOR '||') as details
              FROM $table WHERE date = ? " . ($whereClause ? " AND ($whereClause)" : "") . " GROUP BY operator";
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        die('MySQL prepare error: ' . $mysqli->error);
    }
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $operators = [];

    while ($row = $result->fetch_assoc()) {
        $transactions = array_map(function ($detail) {
            $parts = explode('|', $detail);
            return ['no_invoice' => $parts[0] ?? '-', 'jumlah' => $parts[1] ?? '0', 'keterangan' => $parts[2] ?? '-'];
        }, explode('||', $row['details']));

        $operators[$row['operator']] = [
            'total' => $row['total'],
            'transaksi' => $transactions
        ];
    }

    $stmt->close();

    return $operators;
}




// Mengumpulkan data pemasukan
$pemasukan = [
    'penerimaan dari penjualan tunai' => fetchData($mysqli, 'totalorder', 'sales_data', $date, 'status="paid off"'),
    'penerimaan dari penjualan tempo / dp' => fetchData($mysqli, 'totalpay', 'sales_data', $date, 'due_date!="0000-00-00" AND totalpay > 0')
];

// Mengumpulkan data pengeluaran
$pengeluaran = [
    'Bahan Bakar' => fetchData($mysqli, 'totalpay', 'sales_data', $date, 'due_date!="0000-00-00"')
];

// Fungsi untuk mengkalkulasi total pemasukan dan pengeluaran
function calculateOverallTotal($data)
{
    $overallTotal = 0;
    foreach ($data as $category) {
        foreach ($category as $operatorDetails) {
            $overallTotal += $operatorDetails['total'];
        }
    }
    return $overallTotal;
}

// Menghitung total pemasukan dan pengeluaran
$totalPemasukan = calculateOverallTotal($pemasukan);
$totalPengeluaran = calculateOverallTotal($pengeluaran);

// Menyiapkan data untuk output JSON
$data = [
    'pemasukan' => $pemasukan,
    'totalPemasukan' => $totalPemasukan,
    'pengeluaran' => $pengeluaran,
    'totalPengeluaran' => $totalPengeluaran
];

echo json_encode($data, JSON_PRETTY_PRINT);
