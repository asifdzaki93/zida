<?php
// memanggil library FPDF   
require('../fpdfnew/fpdf.php');
require_once 'data/koneksi.php'; // Menggunakan file koneksi yang sama
include "data/produksi2.php";
$output = getOrderData($mysqli, true);

if(isset($_GET['no_invoice'])){
    $no_invoice = $_GET['no_invoice'];
}

//fpdf setting
class Pdf extends FPDF{
    function garis(){
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

// logic 2
$r = $output["orderDetails"];


// intance object dan memberikan pengaturan halaman PDF
$pdf = new Pdf('P','mm',array(148,210));
$pdf->SetMargins(5,5,10);
$pdf->SetAutoPageBreak(true,10);
// membuat halaman baru
$pdf->AddPage();

// Insert a picture in the top-left corner at 300 dpi
$pdf->Image('../img/inv.png',0.5,0.5,-300);
// setting jenis font yang akan digunakan
$pdf->SetFont('Arial','B',10);
// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Arial','B',10);
// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Arial','B',10);
// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Arial','B',10);
// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Arial','B',10);
// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Arial','B',10);
// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Arial','B',10);
// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Arial','B',10);
//1
$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(75,5,'',0,0,'L');
$pdf->Cell(20,5,'Dikirim',0,0,'L');
$pdf->Cell(5,5,':',0,0,'L');
$pdf->Cell(38,5,date('d F Y', strtotime($r["due_date"])),0,0,'L');
//2
$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(75,5,'',0,0,'L');
$pdf->Cell(20,5,'Kode',0,0,'L');
$pdf->Cell(5,5,':',0,0,'L');
$pdf->Cell(38,5,$r["no_invoice"],0,0,'L');
//4
$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(75,5,'',0,0,'L');
$pdf->Cell(20,5,'Kepada Yth ',0,0,'L');
$pdf->Cell(5,5,':',0,0,'L');
$pdf->Cell(38,5,ucwords($r["customer_name"]),0,0,'L');
//5
$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(75,5,'',0,0,'L');
$pdf->Cell(20,5,'No. Telp ',0,0,'L');
$pdf->Cell(5,5,':',0,0,'L');
$pdf->Cell(38,5,ucwords($r["customer_telephone"]),0,0,'L');
//6 Catatan Pesanan
$catatan = explode(", ",$r["note"]);
$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(75,5,'',0,0,'L');
$pdf->Cell(20,5,'Jam Acara ',0,0,'L');
$pdf->Cell(5,5,':',0,0,'L');
$pdf->MultiCell(60,5,ucwords(str_replace("Jam Acara : ","",$catatan[0]??"")),'','J',false);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(75,5,'',0,0,'L');
$pdf->Cell(20,5,'Pengiriman ',0,0,'L');
$pdf->Cell(5,5,':',0,0,'L');
$pdf->MultiCell(60,5,ucwords(str_replace("Jenis Pengiriman : ","",$catatan[1]??"")),'','J',false);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(75,5,'',0,0,'L');
$pdf->Cell(20,5,'Catatan ',0,0,'L');
$pdf->Cell(5,5,':',0,0,'L');
$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Arial','I',10);
$pdf->Cell(75,5,'',0,0,'L');
$pdf->MultiCell(60,5,ucwords(str_replace("Catatan : ","",$catatan[2]??"")),'','J',false);

//7 NEW
$pdf->Cell(10,5,'',0,1);
$pdf->Cell(10,5,'',0,1);
//8
$pdf->SetFont('Arial','BU',10);
// $pdf->Cell(75,5,'',0,0,'L');
$pdf->Cell(20,5,'Alamat',0,0,'L');
$pdf->Cell(5,5,'',0,0,'L');
$pdf->Cell(38,5,'',0,0,'R');
//9
$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Arial','I',10);
// $pdf->Cell(75,5,'',0,0,'L');
$pdf->MultiCell(140,5,ucwords($r["customer_address"]),'','J',false);

//tittle
$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(138,5,'- RINCIAN PESANAN -',0,0,'C');
//header 1

$pdf->Cell(10,5,'',0,1);
$pdf->SetFillColor(255,198,10);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5,'NO',0,0,'C',true);
$pdf->Cell(75,5,'Nama Product',0,0,'C',true);
$pdf->Cell(15,5, 'JML' ,0,0,'C',true);
$pdf->Cell(38,5,'Sub Total',0,0,'C',true);



//isi struk
$products = $output["products"];

foreach($products as $no=>$product){
    $pdf->Cell(10,5,'',0,1);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(10,5,$no+1,'B',0,'C');
    $pdf->Cell(75,5,$product['name_product'].' @ Rp. '.number_format($product['price']),'B',0,'L');
    $pdf->Cell(15,5, $product['amount'] ,'B',0,'C');
    $pdf->Cell(38,5,'Rp. '.number_format($product["price"], 0, ',', '.'),'B',0,'R');

    if ($product['packages']=='YES') {
        $pdf->Cell(10,5,'',0,1);
        $pdf->SetFont('Arial','I',10);
        $pdf->Cell(10,5,'',0,0,'C');
        $pdf->Cell(55,5,'Isi Paket','B',0,'L');
        $pdf->Cell(15,5, '@' ,'B',0,'C');
        $pdf->Cell(38,5,'',0,0,'R');
        foreach ($product["childproduct"] as $p) {
            $pdf->Cell(10,5,'',0,1);
            $pdf->SetFont('Arial','I',10);
            $pdf->Cell(10,5,'',0,0,'C');
            $pdf->Cell(55,5,$p['name_product'],0,0,'L');
            $pdf->Cell(15,5, floor($p['amount']) ,0,0,'C');
            $pdf->Cell(38,5,'',0,0,'R');
        }
    }
}
$pdf->Cell(10,5,'',0,1);
$pdf->SetFillColor(226,226,226);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5,'','T',0,'C');
$pdf->Cell(65,5,'','T',0,'C');
$pdf->Cell(25,5, 'Total' ,'T',0,'L',true);
$pdf->Cell(38,5,'Rp. '.number_format($r["totalorder"]),'T',0,'R',true);
$pdf->Cell(10,5,'',0,1);
$pdf->SetFillColor(226,226,226);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5,'',0,0,'C');
$pdf->Cell(65,5,'',0,0,'C');
$pdf->Cell(25,5, 'Uang Muka' ,0,0,'L',true);
$pdf->Cell(38,5,'Rp. '.number_format($r["totalpay"]),0,0,'R',true);
$pdf->Cell(10,5,'',0,1);
$pdf->SetFillColor(226,226,226);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5,'',0,0,'C');
$pdf->Cell(65,5,'',0,0,'C');
$pdf->Cell(25,5, 'Sisa' ,0,0,'L',true);
$selisih=   $r["totalorder"]-$r["totalpay"];
$pdf->Cell(38,5,'Rp. '.number_format($selisih),0,0,'R',true);


// //logic gambar
// if ($product["img"]!=='') {
//     $pdf->letak("https://pro.kasir.vip/geten/images/order/".$product["img"]);  
// }

$namafile =  $no_invoice."-inv.pdf";

$pdf->Output('I',$namafile,true);
?>