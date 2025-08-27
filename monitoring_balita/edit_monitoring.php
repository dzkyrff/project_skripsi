<?php
include 'config/koneksi.php';
include 'templates/header.php';
include 'templates/sidebar.php';

$id = $_GET['id'];

// ambil data monitoring berdasarkan id_monitoring
$query = mysqli_query($conn, "SELECT m.*, b.nama 
                              FROM monitoring m 
                              JOIN balita b ON m.id_balita = b.id_balita 
                              WHERE m.id_monitoring='$id'");
$data = mysqli_fetch_assoc($query);

// cek kalau tombol update ditekan
if (isset($_POST['update'])) {
    $tanggal = $_POST['tanggal'];
    $berat   = $_POST['berat'];

    $update = mysqli_query($conn, "UPDATE monitoring 
                                   SET tanggal='$tanggal', berat='$berat' 
                                   WHERE id_monitoring='$id'");

    if ($update) {
        echo "<script>alert('Data monitoring berhasil diperbarui!'); window.location='data_monitoring.php';</script>";
    } else {
        echo "<script>alert('Gagal update data!');</script>";
    }
}
?>

<h2>Edit Data Monitoring</h2>

<form method="POST">
  <div class="mb-3">
    <label class="form-label">Nama Balita</label>
    <input type="text" class="form-control" value="<?= $data['nama'] ?>" readonly>
  </div>
  <div class="mb-3">
    <label class="form-label">Tanggal Monitoring</label>
    <input type="date" name="tanggal" class="form-control" value="<?= $data['tanggal'] ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Berat Badan (kg)</label>
    <input type="number" step="0.1" name="berat" class="form-control" value="<?= $data['berat'] ?>" required>
  </div>
  <button type="submit" name="update" class="btn btn-success">Update</button>
  <a href="data_monitoring.php" class="btn btn-secondary">Kembali</a>
</form>

<?php include 'templates/footer.php'; ?>
