<?php
include 'config/koneksi.php';

$id = $_GET['id'];

$delete = mysqli_query($conn, "DELETE FROM balita WHERE id = '$id'");

if ($delete) {
  echo "<script>alert('Data berhasil dihapus!'); window.location='data_balita.php';</script>";
} else {
  echo "<script>alert('Gagal menghapus data.'); window.location='data_balita.php';</script>";
}
?>
