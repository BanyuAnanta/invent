
<?php
  session_start();

  if (!isset($_SESSION['login'])) {
      header("location: login.php");
      exit;
  }

  include("koneksi.php");

  if (isset($_POST['submit'])) {

    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $jumlah = $_POST['jumlah'];
    $tersedia = $_POST['tersedia'];
    $lokasi = $_POST['lokasi'];
    $kode = $_POST['kode'];

    $query = "INSERT INTO barang (nama, deskripsi, jumlah, tersedia, lokasi, kode)
    VALUES ('$nama', '$deskripsi', '$jumlah', '$tersedia', '$lokasi', '$kode')";

    mysqli_query ($conn, $query);
    
    echo "<script>alert('Barang berhasil ditambahkan'); window.location='index.php';</script>";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Barang | Inventaris</title>
</head>
<body>
  <div class="container">
    <h2>Tambah barang</h2>
    <form method="post" action="">

      <label for="nama">Nama Barang</label><br>
      <input type="text" name="nama" id="nama" required><br><br>

      <label for="kode">Kode Barang</label><br>
      <input type="text" name="kode" id="kode" required><br><br>

      <label for="deskripsi">Deskripsi</label><br>
      <textarea name="deskripsi" id="deskripsi" required></textarea><br><br>

      <label for="jumlah">Jumlah</label><br>
      <input type="number" name="jumlah" id="jumlah" value="1" min="1" required><br><br>

      <label for="tersedia">Tersedia</label><br>
      <input type="number" name="tersedia" id="tersedia" value="1" min="1" required><br><br>

      <label for="lokasi">Lokasi</label><br>
      <input type="text" name="lokasi" id="lokasi" required><br><br>

      <button type="submit" name="submit">Simpan</button>
      <a href="index.php">Kembali</a>

    </form>
  </div>
</body>
</html>
