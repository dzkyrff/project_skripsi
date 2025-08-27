<?php
include 'templates/header.php';
include 'config/koneksi.php';
include 'templates/sidebar.php';

if (isset($_POST['simpan'])) {
  $id_balita = $_POST['id_balita'] ?? '';
  $tanggal = $_POST['tanggal'] ?? '';
  $berat = $_POST['berat'] ?? '';

  if ($id_balita !== '' && $tanggal !== '' && $berat !== '') {
    $stmt = mysqli_prepare($conn, "INSERT INTO monitoring (id_balita, tanggal, berat) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isd", $id_balita, $tanggal, $berat);
    $insert = mysqli_stmt_execute($stmt);

    if ($insert) {
      echo "<script>alert('Data berhasil ditambahkan!'); window.location='data_monitoring.php';</script>";
      exit;
    } else {
      echo "<div class='alert alert-danger'>Gagal menambahkan data: " . mysqli_error($conn) . "</div>";
    }
  } else {
    echo "<div class='alert alert-warning'>Semua field wajib diisi.</div>";
  }
}
?>

<div class="container mt-4">
  <h3>Tambah Data Monitoring</h3>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Nama Balita</label>
      <select name="id_balita" class="form-control" required>
        <option value="">-- Pilih Balita --</option>
        <?php
        $balita = mysqli_query($conn, "SELECT * FROM balita ORDER BY nama ASC");
        while ($b = mysqli_fetch_assoc($balita)) {
          echo "<option value='{$b['id_balita']}'>{$b['nama']}</option>";
        }
        ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Tanggal</label>
      <input type="date" name="tanggal" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Berat Badan (kg)</label>
      <input type="number" name="berat" class="form-control" step="0.1" required>
    </div>

    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
    <a href="data_monitoring.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>

<?php include 'templates/footer.php'; ?>
