<?php
// file: api/get_monitoring.php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: GET");

// koneksi ke database
include '../config/koneksi.php';

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // ambil parameter id_balita kalau ada
    $id_balita = isset($_GET['id_balita']) ? $_GET['id_balita'] : null;

    if ($id_balita) {
        // query berdasarkan id_balita
        $query = "SELECT * FROM monitoring WHERE id_balita = '$id_balita' ORDER BY tanggal ASC";
    } else {
        // kalau ga ada param ambil semua data
        $query = "SELECT * FROM monitoring ORDER BY tanggal ASC";
    }

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        $response = [
            "status" => "success",
            "data" => $data
        ];
    } else {
        $response = [
            "status" => "error",
            "message" => "Data monitoring tidak ditemukan"
        ];
    }
} else {
    $response = [
        "status" => "error",
        "message" => "Metode request harus GET"
    ];
}

echo json_encode($response);
?>
