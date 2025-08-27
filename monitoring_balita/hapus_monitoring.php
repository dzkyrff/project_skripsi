<?php
include 'config/koneksi.php';

$id = $_GET['id'];

$hapus = mysqli_query($conn, "DELETE FROM monitoring WHERE id='$id'");

if ($hapus) {
  echo "<script>alert('Data berhasil dihapus!'); window.location='data_monitoring.php';</script>";
} else {
  echo "<script>alert('Gagal menghapus data.'); window.location='data_monitoring.php';</script>";
}
?>
