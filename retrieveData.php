<?php
ini_set('display_errors', 1);
require 'konek.php';

function curl($url)     // fungsi curl
{
    $ch = curl_init();

    // set URL
    curl_setopt($ch, CURLOPT_URL, $url);
    // return as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $hasil = curl_exec($ch);

    curl_close($ch);
    return $hasil;
}

function getRSI()       // fungsi RSI
{
    $koin = getAllData('tbl_market');   //fungsi untuk mendapatkan data nama2 aset
    $list_high = "";
    $list_low = "";

    $api = curl("https://indodax.com/api/tickers");     //memanggil data dari API Indodax
    $hasil = json_decode($api, true);

    foreach ($hasil as $tickers) {
        foreach ($tickers as $aset => $a) {
            foreach ($koin as $key => $v) {
                if ($aset == $v['nama_market']) {
                    $prevLast = getPrevVal($v['id']);   //memanggil nilai terakhir
                    $change = $a['last'] - $prevLast['last'];
                    $gain = 0;
                    $loss = 0;

                    if ($change < 0) {
                        $loss = $change * (-1);
                    } elseif ($change > 0) {
                        $gain = $change;
                    }

                    $cb = getAllPrev($v['id']);        //memanggil 14 nilai terakhir

                    $jumlah = count($cb) + 1;           //mendapatkan jumlah data (14 + 1)
                    $t_gain = $gain;
                    $t_loss = $loss;
                    $rata_gain = 0;
                    $rata_loss = 0;
                    foreach ($cb as $k) {
                        $t_gain += $k['gain'];
                        $t_loss += $k['loss'];
                    }
                    $rata_gain = $t_gain / $jumlah;
                    $rata_loss = $t_loss / $jumlah;
                    if ($rata_loss == 0) {      // jika rata-rata loss = 0 maka diganti dengan angka mendekati 0
                        $rata_loss = 0.000000001;   // untuk kepentingan pencarian nilai RS
                    }

                    $rs = $rata_gain / $rata_loss;      // nilai RS
                    $rsi = 100 - (100 / (1 + $rs));     // nilai RSI

                    if ($rsi >= 70) {
                        $list_high = $list_high . "\n$aset = " . number_format($rsi, 5, ".", ".");
                    } elseif ($rsi <= 30) {
                        $list_low = $list_low . "\n$aset = " . number_format($rsi, 5, ".", ".");
                    }
                    break;
                }
            }
        }
    }
    $list = ["high" => $list_high, "low" => $list_low];     // daftar aset ditampung pada array
    return $list;
}
