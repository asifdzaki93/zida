<?php
// memanggil library FPDF   
require('../fpdfnew/fpdf.php');
require_once 'data/koneksi.php'; // Menggunakan file koneksi yang sama
include "data/produksi2.php";

//fpdf setting
class Pdf extends FPDF
{
    function garis()
    {
        $this->SetLineWidth(0);
        $this->Line(10, 37, 138, 37);
    }
    function letak($gambar)
    {
        //memasukkan gambar untuk header
        //$this->Image($gambar, 10, 10, 20, 25);
        $this->Image($gambar, 69.2, 261.5, 28, 28);
        //menggeser posisi sekarang
    }
}

// intance object dan memberikan pengaturan halaman PDF
$pdf = new Pdf('P', 'mm', array(105, 149));
$pdf->SetMargins(5, 5, 10);
$pdf->SetAutoPageBreak(true, 10);

$no_invoices = explode(",", $_REQUEST['no_invoice'] ?? "");
foreach ($no_invoices as $no_invoice) {
    $output = getOrderData($mysqli, $no_invoice);
    if ($output["success"] != true) {
        continue;
    }
    $r = $output["orderDetails"];

    // membuat halaman baru
    $pdf->AddPage();

    // Insert a picture in the top-left corner at 300 dpi
    $pdf->Image('../img/resi.png', 0, 0, 105, 149);

    $pdf->Image($base_url . '/admin/qr_generator.php?code=' . $base_url . '/admin/cetak_resi.php?no_invoice=3-BDM07-P080523', 7, 107, 28, 28, 'png');
    // setting jenis font yang akan digunakan
    $pdf->SetFont('Arial', 'B', 10);
    // Memberikan space kebawah agar tidak terlalu rapat
    $pdf->Cell(10, 5, '', 0, 1);
    $pdf->SetFont('Arial', 'B', 10);
    // Memberikan space kebawah agar tidak terlalu rapat
    $pdf->Cell(10, 5, '', 0, 1);
    $pdf->SetFont('Arial', 'B', 10);

    //tittle
    $pdf->Cell(10, 5, '', 0, 1);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(95, 5, 'Nomor Pesanan : ' . $r["no_invoice"], 0, 0, 'C');
    $pdf->Cell(10, 2, '', 0, 1);
    //tittle


    //4
    $pdf->Cell(10, 5, '', 0, 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(17, 5, 'Pemesan ', 0, 0, 'L');
    $pdf->Cell(3, 5, ':', 0, 0, 'L');
    $pdf->Cell(38, 5, ucwords($r["customer_name"]) . ' - (' . ucwords($r["customer_telephone"]) . ')', 0, 0, 'L');



    $catatan = explode(", ", $r["note"]);
    //1
    $pdf->Cell(10, 4, '', 0, 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(17, 5, 'Pengiriman', 0, 0, 'L');
    $pdf->Cell(3, 5, ':', 0, 0, 'L');
    $pdf->Cell(38, 5, date('d F Y', strtotime($r["due_date"])) . ucwords(str_replace("Jenis Pengiriman : ", " | ", $catatan[1] ?? "")), 0, 0, 'L');

    $pdf->Cell(10, 4, '', 0, 1);
    //8
    $pdf->SetFont('Arial', 'BU', 8);
    // $pdf->Cell(75,5,'',0,0,'L');
    $pdf->Cell(17, 5, 'Alamat', 0, 0, 'L');
    $pdf->Cell(5, 5, '', 0, 0, 'L');
    $pdf->Cell(38, 5, '', 0, 0, 'R');
    //9
    $pdf->Cell(10, 5, '', 0, 1);
    $pdf->SetFont('Arial', 'I', 8);
    // $pdf->Cell(75,5,'',0,0,'L');
    $pdf->MultiCell(95, 3, ucwords($r["customer_address"]) . ' - (Catatan : ' . ucwords(str_replace("Catatan : ", "", $catatan[2] ?? "")) . ') - ', '', 'J', false);

    //tittle
    // $pdf->Cell(10, 3, '', 0, 1);
    // $pdf->SetFont('Arial', 'B', 8);
    // $pdf->Cell(95, 5, '- RINCIAN PESANAN -', 0, 0, 'C');
    //header 1

    $pdf->Cell(10, 3, '', 0, 1);
    //$pdf->SetFillColor(255, 198, 8);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 5, 'NO', 'TB', 0, 'C');
    $pdf->Cell(50, 5, 'Nama Product', 'TB', 0, 'C');
    $pdf->Cell(15, 5, 'JML', 'TB', 0, 'C');
    $pdf->Cell(20, 5, 'Sub Total', 'TB', 0, 'C');



    //isi struk
    $products = $output["products"];

    foreach ($products as $no => $product) {
        $pdf->Cell(10, 5, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 5, $no + 1, 'B', 0, 'C');
        $pdf->Cell(50, 5, $product['name_product'] . ' @ Rp. ' . number_format($product['price']), 'B', 0, 'L');
        $pdf->Cell(15, 5, $product['amount'], 'B', 0, 'C');
        $pdf->Cell(20, 5, 'Rp. ' . number_format($product["price"], 0, ',', '.'), 'B', 0, 'R');

        if ($product['packages'] == 'YES') {
            $pdf->Cell(10, 2, '', 0, 1);
            foreach ($product["childproduct"] as $p) {
                $pdf->Cell(10, 3, '', 0, 1);
                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(10, 5, '', 0, 0, 'C');
                $pdf->Cell(50, 5, ucwords(strtolower($p['name_product'])), 0, 0, 'L');
                $pdf->Cell(15, 5, floor($p['amount']), 0, 0, 'C');
                $pdf->Cell(20, 5, '', 0, 0, 'R');
            }
        }
    }
    $pdf->Cell(10, 5, '', 0, 1);
    $pdf->SetFillColor(226, 226, 226);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 5, '', 'T', 0, 'C');
    $pdf->Cell(50, 5, '', 'T', 0, 'C');
    $pdf->Cell(15, 5, 'Total', 'T', 0, 'L', true);
    $pdf->Cell(20, 5, 'Rp. ' . number_format($r["totalorder"]), 'T', 0, 'R', true);

    $pdf->Cell(10, 5, '', 0, 1);
    $pdf->SetFillColor(226, 226, 226);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 5, '', 0, 0, 'C');
    $pdf->Cell(50, 5, '', 0, 0, 'C');
    $pdf->Cell(15, 5, 'DP', 0, 0, 'L', true);
    $pdf->Cell(20, 5, 'Rp. ' . number_format($r["totalpay"]), 0, 0, 'R', true);

    $pdf->Cell(10, 5, '', 0, 1);
    $pdf->SetFillColor(226, 226, 226);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 5, '', 0, 0, 'C');
    $pdf->Cell(50, 5, '', 0, 0, 'C');
    $pdf->Cell(15, 5, 'Sisa', 0, 0, 'L', true);
    $selisih =   $r["totalorder"] - $r["totalpay"];
    $pdf->Cell(20, 5, 'Rp. ' . number_format($selisih), 0, 0, 'R', true);
}


$namafile =  "cetak-resi.pdf";

$pdf->Output('I', $namafile, true);
