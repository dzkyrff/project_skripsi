<?php
// file: api/insert_monitoring.php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST");

// koneksi ke database
include '../config/koneksi.php';

$response = [];

// pastikan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // cek apakah request dalam bentuk JSON
    $data = json_decode(file_get_contents("php://input"), true);

    // ambil data dari POST atau JSON
    $id_balita = $data['id_balita'] ?? ($_POST['id_balita'] ?? null);
    $berat     = $data['berat'] ?? ($_POST['berat'] ?? null);
    $tanggal   = date("Y-m-d"); // otomatis tanggal hari ini

    if ($id_balita && $berat) {
        // insert ke tabel monitoring
        $query = "INSERT INTO monitoring (id_balita, tanggal, berat) 
                  VALUES ('$id_balita', '$tanggal', '$berat')";
        $insert = mysqli_query($conn, $query);

        if ($insert) {
            $response = [
                "status" => "success",
                "message" => "Data monitoring berhasil disimpan"
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "Gagal menyimpan data"
            ];
        }
    } else {
        $response = [
            "status" => "error",
            "message" => "Parameter id_balita dan berat wajib diisi"
        ];
    }
} else {
    $response = [
        "status" => "error",
        "message" => "Metode request harus POST"
    ];
}

echo json_encode($response);
?>
