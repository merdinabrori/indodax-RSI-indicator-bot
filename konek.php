<?php
ini_set('display_errors', 1);
ini_set('memory_limit', '1024M');

$hostname = 'localhost';
$username = 'root';
$password = '';
$db       = 'koin';

$conn = mysqli_connect($hostname, $username, $password, $db);

function getAllData($tabel, $limit = false, $clean = false)
{
    global $conn;
    $query1 = "SELECT * FROM $tabel";
    $query2 = "";
    $query3 = "";

    if ($clean != false) {
        $query2 = " WHERE $clean IS NOT NULL";
    }
    if ($limit != false) {
        $query3 = " LIMIT $limit";
    }

    $query = $query1 . $query2 . $query3;

    $hasil = mysqli_query($conn, $query);

    $rows = [];

    while ($row = mysqli_fetch_assoc($hasil)) {
        $rows[] = $row;
    }

    return $rows;
}

function getPrevVal($id_coin)
{
    global $conn;
    $query = "SELECT last FROM tbl_change WHERE id = (SELECT MAX(id) FROM tbl_change WHERE id_coin = '$id_coin')";
    $hasil = mysqli_query($conn, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($hasil)) {
        $rows[] = $row;
    }

    if ($rows == null) {

        $rows[] = ["last" => 13650];
    }

    return end($rows);
}

function getAllPrev($id_coin)
{
    global $conn;
    $query = "SELECT gain, loss FROM tbl_change WHERE id_coin = '$id_coin' ORDER BY id DESC LIMIT 0, 14";
    $hasil = mysqli_query($conn, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($hasil)) {
        $rows[] = $row;
    }

    return $rows;
}
