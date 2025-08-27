<?php
include 'templates/header.php';
include 'config/koneksi.php';

// pastikan id balita diberikan dan valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  header('Location: data_monitoring.php');
  exit;
}

$id_balita = (int) $_GET['id'];

// ambil nama balita
$sqlBalita = "SELECT nama FROM balita WHERE id_balita = $id_balita LIMIT 1";
$resBalita = mysqli_query($conn, $sqlBalita);

if (!$resBalita || mysqli_num_rows($resBalita) === 0) {
  $balita_nama = "Tidak ditemukan";
} else {
  $balita_data = mysqli_fetch_assoc($resBalita);
  $balita_nama = $balita_data['nama'];
}

// ambil data monitoring
$sql = "SELECT tanggal, berat FROM monitoring WHERE id_balita = $id_balita ORDER BY tanggal ASC";
$query = mysqli_query($conn, $sql);

$tanggal = [];
$berat = [];

while ($data = mysqli_fetch_assoc($query)) {
  $tanggal[] = $data['tanggal'];
  $berat[] = isset($data['berat']) ? (float)$data['berat'] : null;
}
?>

<div class="container mt-4">
  <h3>Grafik Berat Badan: <?= htmlspecialchars($balita_nama) ?></h3>
  <canvas id="grafikBerat" height="100"></canvas>
  <a href="data_monitoring.php" class="btn btn-secondary mt-3">← Kembali</a>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = <?= json_encode($tanggal) ?>;
const dataBerat = <?= json_encode($berat) ?>;
const ctx = document.getElementById('grafikBerat').getContext('2d');

new Chart(ctx, {
  type: 'line',
  data: {
    labels: labels,
    datasets: [{
      label: 'Berat Badan (kg)',
      data: dataBerat,
      borderColor: 'rgb(75, 192, 192)',
      backgroundColor: 'rgba(75, 192, 192, 0.2)',
      tension: 0.3,
      fill: true,
      pointRadius: 5,
      pointHoverRadius: 7
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { position: 'top' },
      title: { display: true, text: 'Grafik Pertumbuhan Berat Badan' }
    },
    scales: {
      y: {
        beginAtZero: true,
        title: { display: true, text: 'Berat (kg)' }
      },
      x: {
        title: { display: true, text: 'Tanggal' }
      }
    }
  }
});
</script>

<?php include 'templates/footer.php'; ?>