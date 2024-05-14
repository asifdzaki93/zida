<?php
include('admin/data/koneksi.php');

$id = $_POST['id'];
$query = "SELECT * FROM detail_pemasukan WHERE pemasukan_id = $id";
$result = $mysqli->query($query);
$details = '<ul>';

while ($row = $result->fetch_assoc()) {
    $details .= '<li>No Invoice: ' . $row["no_invoice"] . ', Jumlah: ' . $row["jumlah"] . ', Keterangan: ' . $row["keterangan"] . '</li>';
}

$details .= '</ul>';

echo $details;
