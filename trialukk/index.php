
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
  <style>
    /* ====== Global Style ====== */
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(to bottom right, #e0f2ff, #ffffff);
    margin: 0;
    padding: 20px;
}

/* Judul */
h2 {
    text-align: center;
    color: #004a8f;
    margin-bottom: 20px;
}

/* ====== Link Menu ====== */
a {
    text-decoration: none;
    color: #fff;
    background: #007bff;
    padding: 8px 14px;
    border-radius: 5px;
    margin-right: 10px;
    transition: 0.3s;
}

a:hover {
    background: #0056b3;
}

/* ====== Tabel ====== */
table {
    width: 100%;
    border-collapse: collapse;
    background: #ffffff;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
}

th {
    background: linear-gradient(to right, #007bff, #00a6ff);
    color: white;
    padding: 12px;
    text-transform: uppercase;
}

td {
    padding: 10px;
    text-align: center;
    border-bottom: 1px solid #e0e0e0;
}

/* Efek zebra */
tr:nth-child(even) {
    background: #f5f9ff;
}

/* Link aksi dalam tabel */
td a {
    background: none;
    color: #0056b3;
    padding: 0;
    margin: 0 5px;
}

td a:hover {
    text-decoration: underline;
}

/* Spasi menu atas */
body > a {
    display: inline-block;
    margin-bottom: 10px;
}

  </style>
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
