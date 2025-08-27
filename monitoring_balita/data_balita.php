<?php
include 'templates/header.php';
include 'config/koneksi.php';
include 'templates/sidebar.php';

$query = mysqli_query($conn, "SELECT * FROM balita ORDER BY nama ASC");
?>

<div class="container mt-4">
  <h3>Data Balita</h3>

  <div class="d-flex justify-content-between mb-3">
    <a href="tambah_balita.php" class="btn btn-primary">Tambah Balita</a>
    <a href="export_balita.php" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Export Excel</a>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Tanggal Lahir</th>
          <th>Jenis Kelamin</th>
          <th>Orang Tua</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) {
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $data['nama'] ?></td>
          <td><?= date('d M Y', strtotime($data['tgl_lahir'])) ?></td>
          <td><?= !empty($data['jk']) ? $data['jk'] : '<i>Belum diisi</i>' ?></td>
          <td><?= !empty($data['ortu']) ? $data['ortu'] : '<i>Belum diisi</i>' ?></td>
          <td>
            <a href="edit_balita.php?id=<?= $data['id_balita'] ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="detail.php?id=<?= $data['id_balita'] ?>" class="btn btn-info btn-sm">Detail</a>
            <a href="hapus_balita.php?id=<?= $data['id_balita'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'templates/footer.php'; ?>
