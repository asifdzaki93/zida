<?php
require __DIR__ . '/../vendor/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
// use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
// use Mike42\Escpos\CapabilityProfile;
header('Content-Type: application/json');
require('../fpdfnew/fpdf.php');
require_once 'data/koneksi.php'; // Menggunakan file koneksi yang sama
include "data/produksi2.php";

if($mysqli->is_auth){
    $connector = new FilePrintConnector("php://stdout");
    $printer = new Printer($connector);
    // $profile = CapabilityProfile::load("simple");
    // $connector = new WindowsPrintConnector("smb://computer/printer");
    // $printer = new Printer($connector, $profile);
    
    /* Text position */
    $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
    $printer->text("Text position\n");
    $printer->selectPrintMode();
    $hri = array (
        Printer::BARCODE_TEXT_NONE => "No text",
        Printer::BARCODE_TEXT_ABOVE => "Above",
        Printer::BARCODE_TEXT_BELOW => "Below",
        Printer::BARCODE_TEXT_ABOVE | Printer::BARCODE_TEXT_BELOW => "Both"
    );
    $tercetak = [];
    $kodebarangs = explode(",",$_REQUEST["kode_barang"]??"");
    foreach ($kodebarangs as $kodebarang) {
        if($kodebarang==""){
            continue;
        }
        $sql="SELECT name_product FROM product WHERE $mysqli->user_master_query 
        AND codeproduct = '".$mysqli->real_escape_string($kodebarang)."'";
        $query=$mysqli->query($sql);
        $data=$query->fetch_assoc();
        if(isset($data["name_product"])){
            echo $data["name_product"];
            $printer->text($data["name_product"] . "\n");
            $printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_ABOVE);
            $printer->barcode($kodebarang, Printer::BARCODE_CODE128);
            $printer->feed();
            array_push($tercetak,$kodebarang);                
        }
    }
    $tercetakResult = implode(", ", $tercetak);
    
    $printer->cut();
    $printer->close();
    echo json_encode(["result"=>"success","title"=>"Berhasil mencetak $tercetakResult"]);
}else{
    echo json_encode(["result"=>"error","title"=>"Gagal mencetak"]);
}