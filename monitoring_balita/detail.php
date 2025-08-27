<?php
include 'config/koneksi.php';
include 'templates/header.php';
include 'templates/sidebar.php';

$id = $_GET['id'];

// ambil data balita
$query = mysqli_query($conn, "SELECT * FROM balita WHERE id_balita='$id'");
$data = mysqli_fetch_assoc($query);

// ambil data monitoring semua (untuk grafik)
$qMonitoring = mysqli_query($conn, "SELECT tanggal, berat FROM monitoring WHERE id_balita='$id' ORDER BY tanggal ASC");

$tanggal = [];
$berat = [];
while ($row = mysqli_fetch_assoc($qMonitoring)) {
    $tanggal[] = $row['tanggal'];
    $berat[] = $row['berat'];
}

// ambil data monitoring terakhir (untuk detail tabel)
$qLast = mysqli_query($conn, "SELECT * FROM monitoring WHERE id_balita='$id' ORDER BY tanggal DESC LIMIT 1");
$monitor = mysqli_fetch_assoc($qLast);
?>

<h2>Detail Data Balita</h2>
<table class="table table-bordered">
  <tr>
    <th>Nama Balita</th>
    <td><?= $data['nama'] ?></td>
  </tr>
  <tr>
    <th>Tanggal Lahir</th>
    <td><?= $data['tgl_lahir'] ?></td>
  </tr>
  <tr>
    <th>Berat Badan</th>
    <td>
      <?php if ($monitor) { ?>
        <?= $monitor['berat'] ?> kg (per <?= $monitor['tanggal'] ?>)
      <?php } else { ?>
        Belum ada data monitoring
      <?php } ?>
    </td>
  </tr>
  <tr>
    <th>Jenis Kelamin</th>
    <td><?= $data['jk'] ?></td>
  </tr>
  <tr>
    <th>Nama Orang Tua</th>
    <td><?= $data['ortu'] ?></td>
  </tr>
</table>

<!-- Grafik kecil -->
<h5 class="mt-4">Grafik Perkembangan Berat Badan</h5>
<canvas id="grafikBerat" height="80"></canvas>

<a href="data_balita.php" class="btn btn-primary btn-sm mt-3">Kembali</a>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('grafikBerat');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?= json_encode($tanggal) ?>,
      datasets: [{
        label: 'Berat Badan (kg)',
        data: <?= json_encode($berat) ?>,
        borderColor: 'blue',
        backgroundColor: 'rgba(0,123,255,0.2)',
        fill: true,
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true } }
    }
  });
</script>

<?php include 'templates/footer.php'; ?>
