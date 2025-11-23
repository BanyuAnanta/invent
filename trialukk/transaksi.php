
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
  <style>
    body {
    margin: 0;
    padding: 20px;
    font-family: Arial, sans-serif;
    background: linear-gradient(to bottom right, #e0f3ff, #ffffff);
}

h2 {
    text-align: center;
    color: #0056b3;
    margin-bottom: 20px;
}

/* Tombol kembali */
a {
    text-decoration: none;
    background: #007bff;
    color: white;
    padding: 8px 14px;
    border-radius: 6px;
    transition: 0.3s;
}

a:hover {
    background: #0056b3;
}

/* ===== Tabel Transaksi ===== */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: #ffffff;
    box-shadow: 0 0 12px rgba(0,0,0,0.15);
}

th {
    background: linear-gradient(to right, #007bff, #00a6ff);
    color: white;
    padding: 12px;
    font-size: 14px;
    text-transform: uppercase;
}

td {
    padding: 10px;
    border-bottom: 1px solid #e5e5e5;
    font-size: 14px;
}

/* Warna baris (zebra effect) */
tr:nth-child(even) {
    background: #f5f9ff;
}

/* Jenis transaksi */
span {
    font-weight: bold;
}

/* Pinjam merah */
span[color="red"],
span.red {
    color: red;
}

/* Kembali hijau */
span[color="green"],
span.green {
    color: green;
}

  </style>
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
