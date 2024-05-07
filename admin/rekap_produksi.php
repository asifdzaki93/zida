<?php
// memanggil library FPDF
require('../fpdfnew/fpdf.php');
require_once 'data/koneksi.php'; // Menggunakan file koneksi yang sama
include "data/produksi_all.php";
$output = getOrderData($mysqli, true);

if (isset($_GET['tglkirim'])) {
    $tglkirim = $_GET['tglkirim'];
}
$due_date = $_GET["due_date"] ?? date("Y-m-d");
$waktu = $_GET["waktu"] ?? "Pagi";
//fpdf setting
class Pdf extends FPDF
{
    //Page header
    function Header()
    {
        $due_date = $_GET["due_date"] ?? date("Y-m-d");
        // Insert a picture in the top-left corner at 300 dpi
        $this->Image('../img/pdf.png', 0, 0, 210, 297);
        // setting jenis font yang akan digunakan
        $this->SetFont('Arial', 'B', 10);
        // Memberikan space kebawah agar tidak terlalu rapat
        $this->Cell(10, 5, '', 0, 1);
        $this->SetFont('Arial', 'B', 10);
        // Memberikan space kebawah agar tidak terlalu rapat
        $this->Cell(10, 5, '', 0, 1);
        $this->SetFont('Arial', 'B', 10);
        // Memberikan space kebawah agar tidak terlalu rapat
        $this->Cell(10, 5, '', 0, 1);
        $this->SetFont('Arial', 'B', 10);
        //tittle
        $hrn = date('d M Y', strtotime($due_date));
        $this->Cell(10, 5, '', 0, 1);
        $this->SetFillColor(255, 198, 13);
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(190, 0, '-- Tugas Produksi ' . $hrn . ' --', 0, 0, 'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $this->Cell(10, 5, '', 0, 1);
        $this->SetFont('Arial', 'B', 10);
    }


    //Page footer
    function Footer()
    {
        //Arial italic 9
        $this->SetFont('Arial', 'I', 9);
        //nomor halaman
        //$this->Cell(0, 20, 'Halaman ' . $this->PageNo() . ' dari {nb}', 0, 0, 'C');
    }
    function garis()
    {
        $this->SetLineWidth(0);
        $this->Line(10, 37, 138, 37);
    }
    function letak($gambar)
    {
        //memasukkan gambar untuk header
        //$this->Image($gambar, 10, 10, 20, 25);
        $this->Image($gambar, 69.2, 261.5, 30, 30);
        //menggeser posisi sekarang
    }
}


// intance object dan memberikan pengaturan halaman PDF
$pdf = new Pdf('P', 'mm', 'A4');
$pdf->SetMargins(5, 20, 10);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AliasNbPages();
// membuat halaman baru
$pdf->AddPage();

$ini = date('y-m-d');
// logic pagi

$orderData = $output["orderDetails"];
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 5, 'Rekap Shift ' . $waktu, 0, 0, 'C');
$pdf->Cell(10, 5, '', 0, 1);
$pdf->SetFillColor(235, 225, 225);
$pdf->Cell(10, 5, '', 0, 1);
$pdf->SetFillColor(235, 225, 225);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(40, 5, 'No Invoice ', 0, 0, 'C', true);
$pdf->Cell(60, 5, 'Nama Kostumer ', 0, 0, 'C', true);
$pdf->Cell(30, 5, 'Order', 0, 0, 'R', true);
$pdf->Cell(30, 5, 'Dibayar', 0, 0, 'R', true);
$pdf->Cell(40, 5, 'Sisa', 0, 0, 'R', true);
$operator = [];
$current_operator = "";
foreach ($orderData as $rc) {
    if ($current_operator != $rc["operator"]) {
        $operator[$rc["operator"]] = [
            "totalorder" => 0,
            "totalpay" => 0,
        ];
        $current_operator = $rc["operator"];
    }
    $operator[$rc["operator"]]["totalorder"] = $operator[$rc["operator"]]["totalorder"] + $rc['totalorder'];
    $operator[$rc["operator"]]["totalpay"] = $operator[$rc["operator"]]["totalpay"] + $rc['totalpay'];
}
$current_operator = "";
foreach ($orderData as $rc) {
    //operator
    if ($current_operator != $rc["operator"]) {
        $pdf->Cell(10, 5, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $jm1 = number_format(floor($operator[$rc["operator"]]['totalorder']), 0, ',', '.');
        $jm11 = number_format(floor($operator[$rc["operator"]]['totalpay']), 0, ',', '.');
        $jm12 = number_format(floor($operator[$rc["operator"]]['totalorder'] - $operator[$rc["operator"]]['totalpay']), 0, ',', '.');
        if ($operator[$rc["operator"]]['totalpay'] >= $operator[$rc["operator"]]['totalorder']) {
            $jm12 = "Lunas";
        }
        $pdf->Cell(100, 5, "# " . $rc['operator_name'], 'B', 0, 'L');
        $pdf->Cell(30, 5, $jm1, 'B', 0, 'R');
        $pdf->Cell(30, 5, $jm11, 'B', 0, 'R');
        $pdf->Cell(40, 5, $jm12, 'B', 0, 'R');
        $current_operator = $rc["operator"];
    }

    //by invoice
    $pdf->Cell(10, 5, '', 0, 1);
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(5, 5, '', 0, 0, 'C');
    $jm1 = number_format(floor($rc['totalorder']), 0, ',', '.');
    $jm11 = number_format(floor($rc['totalpay']), 0, ',', '.');
    $jm12 = number_format(floor($rc['totalorder'] - $rc['totalpay']), 0, ',', '.');
    if ($rc['totalpay'] >= $rc['totalorder']) {
        $jm12 = "Lunas";
    }
    $pdf->Cell(40, 5, "* " . $rc['no_invoice'], 'B', 0, 'R');
    // Misalkan Anda ingin mengganti titik dengan titik spasi dan juga mengganti tanda koma dengan koma spasi
    $search = array('.', ',', '/');
    $replace = array('. ', ', ', ' / ');
    $subject = $rc['name_customer'] ?? "";

    // Melakukan penggantian
    $result = str_replace($search, $replace, $subject);

    // Menggunakan ucwords dan strtolower kemudian memasukkannya ke dalam sel PDF
    $pdf->Cell(55, 5, ucwords(strtolower($result)), 'B', 0, 'L');

    //$pdf->Cell(55, 5, ucwords(strtolower(str_replace(".", ". ", $rc['name_customer'] ?? ""))), 'B', 0, 'L');
    $pdf->Cell(30, 5, $jm1, 'B', 0, 'R');
    $pdf->Cell(30, 5, $jm11, 'B', 0, 'R');
    $pdf->Cell(40, 5, $jm12, 'B', 0, 'R');
}

$pdf->AddPage();
$products = $output["products"];
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 5, "Produk Diproses", 0, 0, 'C');
$pdf->Cell(10, 5, '', 0, 1);
$pdf->SetFillColor(235, 225, 225);
$pdf->Cell(10, 5, '', 0, 1);
$pdf->SetFillColor(235, 225, 225);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(10, 5, '# ', 0, 0, 'R', true);
$pdf->Cell(150, 5, 'Nama Product ', 0, 0, 'L', true);
$pdf->Cell(20, 5, 'Jumlah', 0, 0, 'R', true);
$pdf->Cell(20, 5, 'Check', 0, 0, 'R', true);

function productsSort($a, $b)
{
    return ($a["amount"] > $b["amount"]) ? -1 : 1;
}

usort($products, "productsSort");

foreach ($products as $k => $rc) {
    //by invoice
    $pdf->Cell(10, 5, '', 0, 1);
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(10, 5, $k + 1, 'B', 0, 'R');
    $pdf->Cell(150, 5, ucwords(strtolower($rc['name_product'])), 'B', 0, 'L');
    $pdf->Cell(20, 5, $rc['amount'], 'B', 0, 'R');
    $pdf->Cell(20, 5, '', 'B', 0, 'R');
}


//$pdf->AddPage();
//$pdf->Content();
$namafile =  "produksi-" . $due_date . ".pdf";
$pdf->Output('I', $namafile, true);