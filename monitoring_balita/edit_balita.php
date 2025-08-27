<?php
include 'config/koneksi.php';
include 'templates/header.php';
include 'templates/sidebar.php';

// validasi id di URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<script>alert('ID balita tidak valid'); window.location='data_balita.php';</script>";
  exit;
}
$id = (int) $_GET['id'];

// ambil data balita (prepared statement)
$stmt = mysqli_prepare($conn, "SELECT * FROM balita WHERE id_balita = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($res);

if (!$data) {
  echo "<script>alert('Data balita tidak ditemukan'); window.location='data_balita.php';</script>";
  exit;
}

// proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
  $nama = trim($_POST['nama'] ?? '');
  $tgl_lahir = $_POST['tgl_lahir'] ?? null;
  $jk = $_POST['jk'] ?? '';
  $ortu = trim($_POST['ortu'] ?? '');

  // simple validation minimal
  if ($nama === '' || $tgl_lahir === '' || $jk === '' || $ortu === '') {
    $msg_error = "Nama, Tanggal Lahir, Jenis Kelamin, dan Nama Orang Tua wajib diisi.";
  } else {
    $stmt2 = mysqli_prepare($conn, "UPDATE balita SET nama = ?, tgl_lahir = ?, jk = ?, ortu = ? WHERE id_balita = ?");
    mysqli_stmt_bind_param($stmt2, "ssssi", $nama, $tgl_lahir, $jk, $ortu, $id);
    $ok = mysqli_stmt_execute($stmt2);
    if ($ok) {
      echo "<script>alert('Data berhasil diupdate!'); window.location='data_balita.php';</script>";
      exit;
    } else {
      $msg_error = "Gagal update data: " . mysqli_error($conn);
    }
  }
}
?>

<div class="container mt-4">
  <h2>Edit Data Balita</h2>

  <?php if (!empty($msg_error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($msg_error) ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Nama Balita</label>
      <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($data['nama'] ?? ''); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Tanggal Lahir</label>
      <input type="date" name="tgl_lahir" class="form-control" value="<?php echo htmlspecialchars($data['tgl_lahir'] ?? ''); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Jenis Kelamin</label>
      <select name="jk" class="form-control" required>
        <option value="">-- Pilih --</option>
        <option value="L" <?php echo (isset($data['jk']) && ($data['jk'] === 'L' || strtolower($data['jk']) === 'l' || stripos($data['jk'], 'laki')!==false)) ? 'selected' : ''; ?>>Laki-laki</option>
        <option value="P" <?php echo (isset($data['jk']) && ($data['jk'] === 'P' || strtolower($data['jk']) === 'p' || stripos($data['jk'], 'perem')!==false)) ? 'selected' : ''; ?>>Perempuan</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Nama Orang Tua</label>
      <input type="text" name="ortu" class="form-control" value="<?php echo htmlspecialchars($data['ortu'] ?? ''); ?>" required>
    </div>

    <button type="submit" name="update" class="btn btn-success">Update</button>
    <a href="data_balita.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>

<?php include 'templates/footer.php'; ?>
