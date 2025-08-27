<?php
session_start();
include 'config/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Cek apakah user ada di database
$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
$data = mysqli_fetch_assoc($query);
$cek = mysqli_num_rows($query);

if ($cek > 0) {
  $_SESSION['username'] = $data['username'];
  $_SESSION['login'] = true;
  header("Location: dashboard.php");
} else {
  echo "<script>alert('Login gagal! Username atau Password salah.');window.location='index.php';</script>";
}
?>