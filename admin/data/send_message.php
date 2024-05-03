<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_number = $_POST['phone_number'];
    $message = $_POST['message'];
    $file = "http://localhost/zida/admin/cetak_invoice.php?no_invoice=3-DRM03-P040224";
    //media_type : image, video, audio, file
    $tipe = "file";
    $apikey = "f4fc3c06d7c09712af448b735421d8079db74a29";
    // Kirim pesan menggunakan kode yang telah Anda sediakan sebelumnya
    $body = array(
        "api_key" => $apikey,
        "receiver" => $phone_number,
        "data" => array(
            "url" => $file,
            "media_type" => $tipe,
            "caption" => $message
        )
    );

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://web.watchapp.my.id/api/send-media",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_HTTPHEADER => [
            "Accept: */*",
            "Content-Type: application/json",
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
}
