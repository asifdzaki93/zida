<?php
// memanggil library FPDF
require('../fpdfnew/fpdf.php');

//buat koneksi ke database yang akan dimasukkan sebagai isi
include 'data/koneksi.php';
if(isset($_GET['tglkirim'])){
    $tglkirim = $_GET['tglkirim'];
}
$due_date = $_GET["due_date"]??date("Y-m-d");
$jenis_pengiriman = $_GET["jenis_pengiriman"]??"Pagi";
//fpdf setting
class Pdf extends FPDF{
	//Page header
	function Header()
	{
        $due_date = $_GET["due_date"]??date("Y-m-d");
        // Insert a picture in the top-left corner at 300 dpi
        $this->Image('../img/produksi.png',0,0,-295);
        // setting jenis font yang akan digunakan
        $this->SetFont('Arial','B',10);
        // Memberikan space kebawah agar tidak terlalu rapat
        $this->Cell(10,5,'',0,1);
        $this->SetFont('Arial','B',10);
        // Memberikan space kebawah agar tidak terlalu rapat
        $this->Cell(10,5,'',0,1);
        $this->SetFont('Arial','B',10);
        // Memberikan space kebawah agar tidak terlalu rapat
        $this->Cell(10,5,'',0,1);
        $this->SetFont('Arial','B',10);
        //tittle
        $hrn=date('d M Y',strtotime($due_date));
        $this->Cell(10,5,'',0,1);
        $this->SetFillColor(255,198,13);
        $this->SetFont('Arial','B',20);
        $this->Cell(190,0,'-- Permintaan Produksi '.$hrn.' --',0,0,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $this->Cell(10,5,'',0,1);
        $this->SetFont('Arial','B',10);
	}

 
	//Page footer
	function Footer()
	{
		//Arial italic 9
		$this->SetFont('Arial','I',9);
		//nomor halaman
		// $this->Cell(0,20,'Halaman '.$this->PageNo().' dari {nb}',0,0,'C');
	}    function garis(){
        $this->SetLineWidth(0);
        $this->Line(10, 37, 138, 37);
    }
    function letak($gambar){
        //memasukkan gambar untuk header
        //$this->Image($gambar, 10, 10, 20, 25);
        $this->Image($gambar, 69.2, 261.5, 30, 30);
        //menggeser posisi sekarang
    }
}




// intance object dan memberikan pengaturan halaman PDF
$pdf = new Pdf('P','mm',array(105,297));
$pdf->SetMargins(5,5,10);
$pdf->SetAutoPageBreak(true,10);
$pdf->AliasNbPages();
// membuat halaman baru
$pdf->AddPage();

$ini=date('y-m-d');


// intance object dan memberikan pengaturan halaman PDF
$pdf = new Pdf('P','mm','A4');
$pdf->SetMargins(5,20,10);
$pdf->SetAutoPageBreak(true,10);
$pdf->AliasNbPages();
// membuat halaman baru
$pdf->AddPage();

$ini=date('y-m-d');
// logic pagi

require_once 'data/koneksi.php'; // Menggunakan file koneksi yang sama
include "data/produksi_all.php";
$output = getOrderData($mysqli,true);

$orderData = $output["orderDetails"];
$pdf->SetFont('Arial','B',14);
$pdf->Cell(190,5,'Rekap Shift '.$jenis_pengiriman,0,0,'C');
$pdf->Cell(10,5,'',0,1);
$pdf->SetFillColor(235, 225, 225);
$pdf->Cell(10,5,'',0,1);
$pdf->SetFillColor(235, 225, 225);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(40,5,'No Invoice ',0,0,'C',true);
$pdf->Cell(60,5,'Nama Kostumer ',0,0,'C',true);
$pdf->Cell(30,5,'Order',0,0,'R',true);
$pdf->Cell(30,5,'Dibayar',0,0,'R',true);
$pdf->Cell(40,5,'Sisa',0,0,'R',true);
foreach($orderData as $rc){
    //by invoice
    $pdf->Cell(10,5,'',0,1);
    $pdf->SetFont('Arial','I',12);
    $pdf->SetTextColor(0,0,0);
    $kecil=strtolower($rc['no_invoice']);
    $bskc=ucwords($kecil);
    $jm1=number_format(floor($rc['totalorder']),0,',','.');
    $jm11=number_format(floor($rc['totalpay']),0,',','.');
    $jm12=number_format(floor($rc['totalorder']-$rc['totalpay']),0,',','.');
    if($rc['totalpay']>=$rc['totalorder']){
        $jm12="Lunas";
    }
    $pdf->Cell(40,5,$rc['no_invoice'],'B',0,'L');
    $pdf->Cell(60,5,$rc['name_customer'],'B',0,'L');
    $pdf->Cell(30,5,$jm1,'B',0,'R');
    $pdf->Cell(30,5,$jm11,'B',0,'R');
    $pdf->Cell(40,5,$jm12,'B',0,'R');
}

$pdf->AddPage();
$products = $output["products"];
$pdf->SetFont('Arial','B',14);
$pdf->Cell(190,5,"Produk Diproses",0,0,'C');
$pdf->Cell(10,5,'',0,1);
$pdf->SetFillColor(235, 225, 225);
$pdf->Cell(10,5,'',0,1);
$pdf->SetFillColor(235, 225, 225);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(140,5,'Nama Product ',0,0,'C',true);
$pdf->Cell(60,5,'Jumlah',0,0,'R',true);
foreach($products as $rc){
    //by invoice
    $pdf->Cell(10,5,'',0,1);
    $pdf->SetFont('Arial','I',12);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(160,5,strtoupper($rc['name_product']),'B',0,'L');
    $pdf->Cell(40,5,$rc['amount'],'B',0,'R');
}


//$pdf->AddPage();
//$pdf->Content();
$namafile =  "produksi-".$due_date.".pdf";
$pdf->Output('I',$namafile,true);
?>