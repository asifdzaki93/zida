<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "db_zieda";


// Koneksi dan memilih database di server
$connect = mysqli_connect($server, $username, $password, $database);
if (mysqli_connect_errno()) {
	echo "Database connection failed : " . mysqli_connect_error();
}

//Menggunakan objek mysqli untuk membuat koneksi dan menyimpan nya dalam variabel $mysqli 
$mysqli = new mysqli($server, $username, $password, $database);

$koneksi = mysqli_connect($server, $username, $password, $database);
