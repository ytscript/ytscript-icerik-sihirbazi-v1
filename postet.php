<?php

/**
 * Ytscript: İçerik Sihirbazı v2
 *
 * Bu dosya, Ytscript: İçerik Sihirbazı v2 için önemli işlevleri içerir.
 *
 * @package Ytscript: İçerik Sihirbazı v2
 */



// Değeri kaydetmek için
$domain = $_SERVER['SERVER_NAME']; 


$tags = array(1, 2); 

$data = array(
    'title' => 'Deneme Makale',
    'content' => 'Deneme yazı',
    'status' => 'publish',
    'categories' => array(1, 2),
    'tags' => $tags
);

$data_string = json_encode($data);

$ch = curl_init("https://$domain/wp-json/wp/v2/posts");


$headers = array(
    'Authorization: Basic ' . base64_encode('uparla:a1rE GmKx Au5u aKxj NWXk YeJK'),
    'Content-Type: application/json',
);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    $error = curl_error($ch);
    echo 'Error: ' . $error;
} else {
    $result = json_decode($response, true);
    print_r($result);
}

curl_close($ch);
