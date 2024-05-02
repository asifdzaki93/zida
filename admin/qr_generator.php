<?php
require_once('../assets/vendor/libs/phpqrcode/qrlib.php');

QRcode::png($_GET['code']);
