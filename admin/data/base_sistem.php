<?php
$protocol = !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) ? $_SERVER['HTTP_X_FORWARDED_PROTO'] : (isset($_SERVER['HTTPS'])
    && $_SERVER['HTTPS'] === 'on' ? "https" : "http");

// Definisikan BASE_URL secara statis
$base_url = $protocol . "://$_SERVER[HTTP_HOST]/zida/";

$nameapp = 'Zieda Bakery';
