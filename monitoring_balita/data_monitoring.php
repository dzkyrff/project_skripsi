<?php
include 'templates/header.php';
include 'config/koneksi.php';
include 'templates/sidebar.php';

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$query = mysqli_query($conn, "SELECT m.*, b.nama, b.jk, b.tgl_lahir, 
         TIMESTAMPDIFF(MONTH, b.tgl_lahir, CURDATE()) AS umur_bulan 
         FROM monitoring m 
         JOIN balita b ON m.id_balita = b.id_balita 
         ORDER BY m.tanggal DESC");
?>
<div class="container mt-4">
  <h3>Data Monitoring Berat Badan</h3>

  <!-- Form Cari -->
  <form method="GET" class="mb-3">
    <div class="input-group">
      <input type="text" name="cari" class="form-control" placeholder="Cari nama balita..." value="<?= $cari ?>">
      <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Cari</button>
    </div>
  </form>

  <!-- Tombol Tambah & Export -->
  <div class="d-flex justify-content-between mb-3">
    <a href="tambah_monitoring.php" class="btn btn-primary">Tambah Data</a>
    <a href="export_excel.php" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Export Excel</a>
  </div>

  <!-- Tabel Data -->
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>No</th>
          <th>Nama Balita</th>
          <th>Tanggal</th>
          <th>Berat (kg)</th>
          <th>Kategori</th>
          <th>Saran Gizi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) {
          $kategori = kategoriWHO($data['jk'], $data['umur_bulan'], $data['berat']);
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $data['nama'] ?></td>
          <td><?= $data['tanggal'] ?></td>
          <td><?= $data['berat'] ?></td>
          <td><?= $kategori['status'] ?></td>
          <td><?= $kategori['saran'] ?></td>
          <td>
            <a href="edit_monitoring.php?id=<?= $data['id_monitoring'] ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="hapus_monitoring.php?id=<?= $data['id_monitoring'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
            <a href="grafik_monitoring.php?id=<?= $data['id_balita'] ?>" class="btn btn-info btn-sm">Grafik</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'templates/footer.php'; ?> 

<?php 
// fungsi standar WHO sederhana
function kategoriWHO($jenis_kelamin, $usia_bulan, $berat) {
    if ($berat < 2.5) {
        return ["status"=>"Gizi Buruk", "saran"=>"Segera periksa ke posyandu/puskesmas"];
    } elseif ($berat < 3.5) {
        return ["status"=>"Gizi Kurang", "saran"=>"Tingkatkan asupan gizi"];
    } elseif ($berat <= 10) {
        return ["status"=>"Gizi Baik", "saran"=>"Pertahankan pola makan"];
    } else {
        return ["status"=>"Gizi Lebih", "saran"=>"Atur pola makan seimbang"];
    }
}
?>
