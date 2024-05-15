<?php
function getDeskripsiProduk($chatgpt_url, $chatgpt_key, $namaProduk, $linkGambar)
{
  $prompt = "Buat deskripsi produk yang menarik dan informatif untuk $namaProduk. Sebagai referensi deskripsi lihat gambar ini : $linkGambar agar deskripsi lebih mencerminkan produk yang diinginkan. Target audiens adalah customer toko roti modern yang mencari produk berkualitas tinggi untuk event maupun acara tertentu, dan beberapa juga pembeli eceran. Deskripsi harus mencakup manfaat utama dan keunggulan produk ini dan tidak terlalu panjang, max 20 kata.";
  $data = [
    'model' => 'gpt-4',
    'messages' => [
      [
        'role' => 'user',
        'content' => $prompt,
      ],
    ],
    'temperature' => 1,
    'max_tokens' => 256,
    'top_p' => 1,
    'frequency_penalty' => 0,
    'presence_penalty' => 0,
  ];

  $dataJson = json_encode($data);

  $ch = curl_init($chatgpt_url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: Bearer ' . $chatgpt_key]);

  $response = curl_exec($ch);
  if ($response === false) {
    throw new Exception('Request Error: ' . curl_error($ch));
  }

  curl_close($ch);

  $responseData = json_decode($response, true);
  return str_replace('"', '', $responseData['choices'][0]['message']['content'] ?? 'Tidak Tersedia');
}
