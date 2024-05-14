<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template">

<?php
include 'data/base_sistem.php';
include 'data/koneksi.php';
$user_name = $mysqli->data_user['full_name'] ?? 'Admin';
$user_avatar = $mysqli->data_user_avatar;
$user_level = ucwords($mysqli->data_user['level'] ?? 'admin');
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= $nameapp ?></title>

    <meta name="description" content="" />

    <?php include 'head.php'; ?>

</head>

<body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include 'sidebar.php'; ?>

            <!-- Layout container -->
            <div class="layout-page">
                <?php include 'navbar.php'; ?>


                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">