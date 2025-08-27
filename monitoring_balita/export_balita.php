<?php
include 'config/koneksi.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data_balita.xls");

echo "<table border='1'>
<tr>
  <th>No</th>
  <th>Nama Balita</th>
  <th>Tanggal Lahir</th>
  <th>Jenis Kelamin</th>
  <th>Nama Orang Tua</th>
</tr>";

$query = mysqli_query($conn, "SELECT * FROM balita");
$no = 1;
while ($data = mysqli_fetch_assoc($query)) {
  echo "<tr>";
  echo "<td>" . $no++ . "</td>";
  echo "<td>" . $data['nama'] . "</td>";
  echo "<td>" . $data['tanggal_lahir'] . "</td>";
  echo "<td>" . $data['jenis_kelamin'] . "</td>";
  echo "<td>" . $data['nama_orangtua'] . "</td>";
  echo "</tr>";
}

echo "</table>";
?>
