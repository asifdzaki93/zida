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

            $nameLines = $this->WordWrap($names[$index], $imageWidth);
            $this->SetXY($xPos, $yPos + $imageHeight);
            foreach ($nameLines as $line) {
                $this->Cell($imageWidth, 5, $line, 0, 0, 'C');
                $this->Ln();
            }

            $this->SetXY($xPos, $this->GetY());
            $this->Cell($imageWidth, 5, 'Jumlah: ' . $amounts[$index], 0, 0, 'C');
            $xPos += $imageWidth + $spacing;
        }
    }

    // Fungsi untuk memotong teks yang panjang menjadi beberapa baris
    function WordWrap(&$text, $maxwidth)
    {
        $text = trim($text);
        if ($text === '')
            return [];

        $lines = [];
        $words = preg_split('/\s+/', $text);
        $currentLine = '';

        foreach ($words as $word) {
            $testLine = $currentLine . ($currentLine === '' ? '' : ' ') . $word;
            $testWidth = $this->GetStringWidth($testLine);

            if ($testWidth > $maxwidth) {
                if ($currentLine !== '') {
                    $lines[] = $currentLine;
                }
                $currentLine = $word;
            } else {
                $currentLine = $testLine;
            }
        }

        $lines[] = $currentLine;

        return $lines;
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
$pdf->AddPage();

$ini = date('y-m-d');

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

$namafile =  "produksi-" . $due_date . ".pdf";
$pdf->Output('I', $namafile, true);
