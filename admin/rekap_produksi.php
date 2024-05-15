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

// FPDF setting
class Pdf extends FPDF
{
    // Page header
    function Header()
    {
        $due_date = $_GET["due_date"] ?? date("Y-m-d");
        $this->Image('../img/pdf.png', 0, 0, 210, 297);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(10, 5, '', 0, 1);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(10, 5, '', 0, 1);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(10, 5, '', 0, 1);
        $this->SetFont('Arial', 'B', 10);
        $hrn = date('d M Y', strtotime($due_date));
        $this->Cell(10, 5, '', 0, 1);
        $this->SetFillColor(255, 198, 13);
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(190, 0, '-- Tugas Produksi ' . $hrn . ' --', 0, 0, 'C');
        $this->Cell(10, 5, '', 0, 1);
        $this->SetFont('Arial', 'B', 10);
    }

    // Page footer
    function Footer()
    {
        $this->SetFont('Arial', 'I', 9);
    }

    // Fungsi untuk menambahkan gambar berurutan dari kiri ke kanan, dan ke bawah setelah 5 gambar
    function AddImages($images, $names, $amounts, $perRow)
    {
        $xPos = 10;
        $yPos = $this->GetY();
        $imageWidth = 30;
        $imageHeight = 30;
        $spacing = 10;
        $defaultImage = 'https://zieda.id/pro/geten/images/no_image.jpg'; // URL gambar default
        $bottomMargin = 10; // Margin bawah

        foreach ($images as $index => $image) {
            $image = $this->encodeUrl($image); // Encode URL

            if ($index > 0 && $index % $perRow == 0) {
                $xPos = 10;
                $yPos += $imageHeight + 20; // Jarak tambahan untuk teks
            }

            // Jika posisi Y melebihi batas halaman, buat halaman baru dan reset posisi
            if ($yPos + $imageHeight + 20 > $this->h - $bottomMargin) {
                $this->AddPage();
                $xPos = 10;
                $yPos = $this->GetY(); // Reset posisi yPos setelah header
            }

            if (!$this->isValidImage($image)) {
                $image = $defaultImage; // Ganti dengan gambar default jika tidak valid
            }

            $this->Image($image, $xPos, $yPos, $imageWidth, $imageHeight);

            $name = ucwords(strtolower($names[$index]));
            if (strlen($name) > 20) {
                $name = substr($name, 0, 17) . '...';
            }

            $this->SetXY($xPos, $yPos + $imageHeight);
            $this->Cell($imageWidth, 5, $name, 0, 0, 'C');
            $this->SetXY($xPos, $yPos + $imageHeight + 5);
            $this->Cell($imageWidth, 5, 'Jumlah: ' . $amounts[$index], 0, 0, 'C');
            $xPos += $imageWidth + $spacing;
        }
    }

    function isValidImage($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);

        if ($httpCode == 200 && strpos($contentType, 'image/') !== false) {
            return true;
        }
        return false;
    }

    function encodeUrl($url)
    {
        return str_replace(' ', '%20', $url);
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


$pdf->AddPage();
// Menambahkan daftar gambar ke PDF
// Persiapkan data gambar, nama produk, dan jumlah
$products = $output["products"];
$hostedImages = [];
$productNames = [];
$productAmounts = [];
foreach ($products as $rc) {
    $hostedImages[] = $rc['img'];
    $productNames[] = $rc['name_product'];
    $productAmounts[] = $rc['amount'];
}

// Menambahkan daftar gambar ke PDF dengan nama produk dan jumlahnya
$pdf->AddImages($hostedImages, $productNames, $productAmounts, 5);


//$pdf->AddPage();
//$pdf->Content();
$namafile =  "produksi-" . $due_date . ".pdf";
$pdf->Output('I', $namafile, true);
