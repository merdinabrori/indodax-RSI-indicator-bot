<?php
ini_set('display_errors', 1);
require "retrieveData.php";

$token = "TOKEN_BOT";       //token bot
$apiURL = "https://api.telegram.org/bot$token";
$update = json_decode(file_get_contents("php://input"), TRUE);

$chatID = $update["message"]["chat"]["id"];
$username = $update["message"]["chat"]["username"];
$message = $update["message"]["text"];

if (strpos($message, "/start") === 0) {             //command /start untuk menampilkan petunjuk awal
    $pesan = "\nBot ini berfungsi untuk menampilkan data dari marketplace Indodax.\n\nGunakan /pantau untuk menampilkan daftar aset yang sedang bernilai tinggi atau rendah.\n\nGunaka /rsi untuk menampilkan daftar aset dengan rsi yang bernilai tinggi atau rendah";
    $pesan = str_replace(" ", "%20", urlencode($pesan));
    file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=Halo $username. $pesan");
} elseif (strpos($message, "/halo") === 0) {        //command /halo untuk menyapa
    file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=Halo $username.");
} elseif ($message == "/rsi") {                     //command /rsi untuk menampilkan daftar aset dengan nilai RSI
    $daftar = getRSI();     // memanggil fungsi RSI pada file retrieveData.php
    $pesan = str_replace(" ", "%20", "Halo $username. " . urlencode("\nDaftar aset dengan nilai RSI lebih dari 70 : " . $daftar['high'] . "\n\nDaftar aset dengan nilai RSI kurang dari 30 : " . $daftar['low']));
    $hasil = file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=$pesan");

    if ($hasil == false) {
        file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=$message gagal. $hasil&parse_mode=HTML");
    }
} else {
    file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=Perintah tidak dikenali.&parse_mode=HTML");
}
