<?php
include 'config/koneksi.php';

// Ambil data grafik (contoh pakai balita pertama)
$query = mysqli_query($conn, "SELECT m.tanggal, m.berat FROM monitoring m ORDER BY m.tanggal ASC LIMIT 10");
$tanggal = [];
$berat = [];
while ($row = mysqli_fetch_assoc($query)) {
  $tanggal[] = date('d M', strtotime($row['tanggal']));
  $berat[] = $row['berat'];
}
$tanggal_json = json_encode($tanggal);
$berat_json = json_encode($berat);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | Monitoring Balita</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    html, body {
      height: 100%;
      margin: 0;
      background-color: #f8f9fa;
    }
    .d-flex {
      min-height: 100vh;
    }
    .sidebar {
      width: 250px;
      background-color: #007bff;
      color: white;
      padding-top: 20px;
      flex-shrink: 0;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 10px 20px;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #0056b3;
    }
    .content {
      flex-grow: 1;
      padding: 20px;
      overflow-x: auto;
    }
    table {
      min-width: 600px;
    }
  </style>
</head>
<body>
<div class="d-flex">
  <div class="sidebar">
    <h4 class="p-3">👶 Monitoring Balita</h4>
    <a href="dashboard.php"><i class="bi bi-house-door"></i> Dashboard</a>
    <a href="data_balita.php"><i class="bi bi-people"></i> Data Balita</a>
    <a href="data_monitoring.php"><i class="bi bi-bar-chart-line"></i> Monitoring Berat</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>
  <div class="content">
    <h3 class="mb-4">Dashboard</h3>

    <!-- Riwayat Tabel -->
    <div class="card mb-4">
      <div class="card-header bg-primary text-white">
        <i class="bi bi-clock-history"></i> Riwayat Monitoring Terbaru
      </div>
      <div class="card-body table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Balita</th>
              <th>Tanggal</th>
              <th>Berat Badan (kg)</th>
            </tr>
          </thead>
          <tbody>
          <?php
          // disesuaikan: b.id → b.id_balita
          $query = mysqli_query($conn, "SELECT m.*, b.nama FROM monitoring m JOIN balita b ON m.id_balita = b.id_balita ORDER BY m.tanggal DESC LIMIT 5");
          $no = 1;
          while ($data = mysqli_fetch_assoc($query)) {
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . $data['nama'] . "</td>";
            echo "<td>" . date('d M Y', strtotime($data['tanggal'])) . "</td>";
            echo "<td>" . $data['berat'] . "</td>";
            echo "</tr>";
          }
          ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Grafik Berat Badan -->
    <div class="card">
      <div class="card-header bg-warning text-dark">
        <i class="bi bi-graph-up"></i> Grafik Berat Badan
      </div>
      <div class="card-body">
        <canvas id="grafikBerat" height="100"></canvas>
      </div>
    </div>

  </div> <!-- end content -->
</div> <!-- end d-flex -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('grafikBerat').getContext('2d');
  const grafikBerat = new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?= $tanggal_json; ?>,
      datasets: [{
        label: 'Berat Badan (kg)',
        data: <?= $berat_json; ?>,
        fill: true,
        backgroundColor: 'rgba(0, 123, 255, 0.2)',
        borderColor: 'rgba(0, 123, 255, 1)',
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: false
        }
      }
    }
  });
</script>
</body>
</html>
