<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "db_zieda";
$user_master = "082322345757";
// Koneksi dan memilih database di server
$connect = mysqli_connect($server, $username, $password, $database);
if (mysqli_connect_errno()) {
	echo "Database connection failed : " . mysqli_connect_error();
}

//Menggunakan objek mysqli untuk membuat koneksi dan menyimpan nya dalam variabel $mysqli 
$mysqli = new mysqli($server, $username, $password, $database);

$koneksi = mysqli_connect($server, $username, $password, $database);

$mysqli->user_master = $user_master; 
$mysqli->user_master_query = "user = '$user_master'"; 