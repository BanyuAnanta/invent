
<?php
  session_start();

  if (!isset($_SESSION['login'])) {
      header("location: login.php");
      exit;
  }

  include("koneksi.php");

  $query = "SELECT transaksi.*, barang.nama AS nama_barang, barang.kode AS kode_barang FROM transaksi 
  JOIN barang ON transaksi.barang_id = barang_id ORDER BY transaksi.id DESC ";

  $result = mysqli_query ($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transaksi Barang | Inventaris</title>
</head>
<body>
  <h2>Riwayat Transaksi Barang</h2>
  <a href="index.php">Kembali ke Dashboard</a>
  <br><br>

  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>Tanggal dan Waktu</th>
      <th>Kode Barang</th>
      <th>Nama Barang</th>
      <th>peminjam / Pengembali</th>
      <th>jenis</th>
      <th>Jumlah</th>
      <th>Catatan</th>
    </tr>

    <?php while ($data = mysqli_fetch_assoc($result)): ?>
    
    <tr>
      <td><?= $data['tanggal'] ?></td>
      <td><?= $data['kode_barang'] ?></td>
      <td><?= $data['nama_barang'] ?></td>
      <td><?= $data['peminjam'] ?></td>
      <td>
        <?php if ($data['jenis'] == 'pinjam'): ?>
          <span style="color: red; font-weight: semibold">Pinjam</span>
        <?php else: ?>
          <span style="color: green; font-weight: semibold">Kembali</span>
        <?php endif; ?>
      </td>
      <td><?= $data['jumlah'] ?></td>
      <td><?= $data['catatan'] ?></td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
