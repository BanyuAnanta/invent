
<?php
  session_start();

  if (!isset($_SESSION['login'])){
    header ('location: login.php');
    exit;
  }

  include ('koneksi.php');

  $result = mysqli_query ($conn, "SELECT * FROM barang ORDER BY id DESC")

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barang | Inventaris</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Data Barang Inventaris</h2>
  <a href="tambah_barang.php">Tambah Barang</a>
  <a href="transaksi.php">Lihat Transaksi</a>
  <a href="logout.php">Logout</a>
  <br><br>
  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>Kode</th>
      <th>Nama</th>
      <th>Deskripsi</th>
      <th>Jumlah</th>
      <th>Tersedia</th>
      <th>Lokasi</th>
      <th>Aksi</th>
    </tr>

    <?php while ($data = mysqli_fetch_assoc($result)): ?>

    <tr>
      <td><?= $data['kode'] ?></td>
      <td><?= $data['nama'] ?></td>
      <td><?= $data['deskripsi'] ?></td>
      <td><?= $data['jumlah'] ?></td>
      <td><?= $data['tersedia'] ?></td>
      <td><?= $data['lokasi'] ?></td>
      <td>
            <a href="edit_barang.php?id=<?= $data['id'] ?>">Edit</a> |
            <a href="hapus_barang.php?id=<?= $data['id'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a> |
            <a href="pinjam_barang.php?id=<?= $data['id'] ?>">Pinjam</a> 
            <?php 
              $dipinjam = $data['jumlah'] - $data['tersedia'];
            ?>
            <?php if ($dipinjam > 0): ?>
              | <a href="kembalikan_barang.php?id=<?= $data['id'] ?>">Kembali</a>
            <?php endif; ?>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
