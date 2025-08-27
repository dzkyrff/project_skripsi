<?php
include 'config/koneksi.php';

$id_balita = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil info balita
$balita = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM balita WHERE id_balita = $id_balita"));

// Ambil data monitoring
$query = mysqli_query($conn, "SELECT tanggal, berat FROM monitoring WHERE id_balita = $id_balita ORDER BY tanggal ASC");

$tanggal = [];
$berat = [];

while ($data = mysqli_fetch_assoc($query)) {
    $tanggal[] = $data['tanggal'];
    $berat[] = $data['berat'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Grafik Berat Badan</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">
  <div class="container">
    <div class="card shadow p-4">
      <h3 class="mb-3 text-center">Grafik Berat Badan: <?= htmlspecialchars($balita['nama']) ?></h3>
      <canvas id="grafikBerat" height="100"></canvas>
      <a href="data_monitoring.php" class="btn btn-secondary mt-4">← Kembali</a>
    </div>
  </div>

  <script>
    const ctx = document.getElementById('grafikBerat').getContext('2d');
    const chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?= json_encode($tanggal) ?>,
        datasets: [{
          label: 'Berat Badan (kg)',
          data: <?= json_encode($berat) ?>,
          borderColor: 'rgba(54, 162, 235, 1)',
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderWidth: 2,
          fill: true,
          tension: 0.4,
          pointBackgroundColor: 'blue',
          pointRadius: 4
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: true, position: 'bottom' }
        },
        scales: {
          x: {
            title: { display: true, text: 'Tanggal' }
          },
          y: {
            beginAtZero: true,
            title: { display: true, text: 'Berat Badan (kg)' }
          }
        }
      }
    });
  </script>
</body>
</html>