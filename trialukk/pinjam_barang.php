
<?php
  session_start();
  if (!isset($_SESSION['login'])) {
      header("Location: login.php");
      exit;
  }

  include("koneksi.php");

  $id = $_GET['id'];

  $barang = mysqli_query ($conn, "SELECT * FROM barang WHERE id=$id");
  $data = mysqli_fetch_assoc ($barang);

  if (!$barang) die("Barang tidak ditemukan");

  $error = "";

  if (isset($_POST['submit'])) {
    $peminjam = $_POST['peminjam'];
    $jumlah = $_POST['jumlah'];
    $catatan = $_POST['catatan'];

    if ($peminjam == "" || $jumlah <= 0) {
      $error = "Isi peminjam dan jumlah dengan benar";
    }
    elseif ($jumlah > $data['tersedia']) {
      $error = "Jumlah melebihi stok tersedia";
    }
    else {
      mysqli_query ($conn, "INSERT INTO transaksi (barang_id, peminjam, jenis, jumlah, catatan)
      VALUES ($id, '$peminjam', 'pinjam', $jumlah, '$catatan')");

      mysqli_query ($conn, "UPDATE barang SET tersedia = tersedia - $jumlah WHERE id=$id");

      echo "<script>alert('Barang berhasil dipinjam'); window.location='index.php';</script>";

    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pinjam Barang | Inventaris</title>
</head>
<body>
  <div class="container">
    <h2>pinjam Barang: <?= $data['nama'] ?></h2>
    <p>Stok Tersedia <b><?= $data['tersedia'] ?></b></p>

    <?php if ($error): ?>
      <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <form action="" method="post">
      <label for="nama">Nama Peminjam</label><br>
      <input type="text" name="peminjam" require><br><br>

      <label for="jumlah">Jumlah</label><br>
      <input type="number" name="jumlah" value="1" min="1" max="<?- $data['tersedia'] ?>" require><br><br>

      <label for="catatan">Catatan</label><br>
      <textarea name="catatan" id="catatan" require></textarea><br><br>

      <button type="submit" name="submit" value="Pinjam">Pinjam</button>
      <a href="index.php">Kembali</a>

    </form>
  </div>
</body>
</html>
