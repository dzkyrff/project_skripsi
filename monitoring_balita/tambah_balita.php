<?php
include 'config/koneksi.php';
include 'templates/header.php';
include 'templates/sidebar.php';

if (isset($_POST['simpan'])) {
  $nama = $_POST['nama'];
  $tgl_lahir = $_POST['tgl_lahir'];
  $berat = $_POST['berat'];

  $query = mysqli_query($conn, "INSERT INTO balita (nama, tgl_lahir, berat) VALUES ('$nama', '$tgl_lahir', '$berat')");

  if ($query) {
    echo "<script>alert('Data berhasil disimpan!'); window.location='data_balita.php';</script>";
  } else {
    echo "<div class='alert alert-danger'>Gagal menyimpan data.</div>";
  }
}
?>

<h2>Tambah Data Balita</h2>
<form action="proses_tambah_balita.php" method="POST">
  <div class="mb-3">
    <label>Nama Balita</label>
    <input type="text" name="nama" class="form-control" required>
  </div>

  <div class="mb-3">
    <label>Tanggal Lahir</label>
    <input type="date" name="tanggal_lahir" class="form-control" required>
  </div>

  <div class="mb-3">
    <label>Jenis Kelamin</label>
    <select name="jk" class="form-control" required>
      <option value="">-- Pilih Jenis Kelamin --</option>
      <option value="Laki-laki">Laki-laki</option>
      <option value="Perempuan">Perempuan</option>
    </select>
  </div>

  <div class="mb-3">
    <label>Nama Orang Tua</label>
    <input type="text" name="ortu" class="form-control" required>
  </div>

  <button type="submit" class="btn btn-primary">Simpan</button>
</form>


<?php include 'templates/footer.php'; ?>