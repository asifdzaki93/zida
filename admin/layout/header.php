<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template">

<?php
$protocol = !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) ? $_SERVER['HTTP_X_FORWARDED_PROTO'] : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
define('BASE_URL', $protocol . "://$_SERVER[HTTP_HOST]/zida/");

// Definisikan BASE_URL secara statis
$base_url = BASE_URL;

$nameapp = 'Zieda Bakery';
$id_kasirvip = '082322345757';
// Set user session
$_SESSION['namauser'] = '082322345757';
$user = $_SESSION['namauser'];
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= $nameapp; ?></title>

    <meta name="description" content="" />

    <?php
    include 'head.php';
    ?>

</head>

<body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php
            include 'sidebar.php';
            ?>

            <!-- Layout container -->
            <div class="layout-page">
                <?php
                include 'navbar.php';
                ?>


                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">