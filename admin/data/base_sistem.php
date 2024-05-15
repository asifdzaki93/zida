<?php
$protocol = !empty($_SERVER['HTTP_X_FORWARDED_PROTO'])
  ? $_SERVER['HTTP_X_FORWARDED_PROTO']
  : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
    ? 'https'
    : 'http');

// Definisikan BASE_URL secara statis
$base_url = $protocol . "://$_SERVER[HTTP_HOST]/zida/";

$nameapp = 'Zieda Bakery';
$chatgpt_key = 'api_key_here';
$chatgpt_url = 'https://api.openai.com/v1/chat/completions';
