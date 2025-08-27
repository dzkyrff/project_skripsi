<?php
include 'config/koneksi.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=monitoring_balita.xls");

echo "<table border='1'>
<tr>
  <th>No</th>
  <th>Nama Balita</th>
  <th>Tanggal</th>
  <th>Berat Badan (kg)</th>
</tr>";

$query = mysqli_query($conn, "SELECT m.*, b.nama FROM monitoring m JOIN balita b ON m.id_balita = b.id");
$no = 1;
while ($data = mysqli_fetch_assoc($query)) {
  echo "<tr>";
  echo "<td>" . $no++ . "</td>";
  echo "<td>" . $data['nama'] . "</td>";
  echo "<td>" . $data['tanggal'] . "</td>";
  echo "<td>" . $data['berat'] . "</td>";
  echo "</tr>";
}

echo "</table>";
?>
