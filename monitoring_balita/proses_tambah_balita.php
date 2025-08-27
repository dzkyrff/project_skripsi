<?php
include 'config/koneksi.php';

$nama = $_POST['nama'];
$tgl_lahir = $_POST['tgl_lahir'];
$jk = $_POST['jk'];
$ortu = $_POST['ortu'];

$query = mysqli_query($conn, "INSERT INTO balita (nama, tgl_lahir, jk, ortu) 
  VALUES ('$nama', '$tgl_lahir', '$jk', '$ortu')");

if ($query) {
  header("Location: data_balita.php");
} else {
  echo "Gagal menambahkan data!";
}
?>
