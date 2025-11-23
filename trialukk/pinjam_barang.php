
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
  <style>
    body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(to bottom right, #e0f3ff, #ffffff);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.container {
    background: #ffffffdd;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0,0,0,0.12);
    width: 380px;
}

h2 {
    text-align: center;
    color: #0056b3;
    margin-bottom: 10px;
}

p b {
    color: #004a8d;
}

/* Label */
label {
    font-weight: bold;
    color: #003d7a;
}

/* Input dan textarea */
input[type="text"],
input[type="number"],
textarea {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #bcd8ff;
    background: #f7fbff;
    margin-top: 5px;
    transition: 0.3s;
}

textarea {
    resize: vertical;
    height: 80px;
}

input:focus,
textarea:focus {
    border-color: #007bff;
    box-shadow: 0 0 6px rgba(0,123,255,0.4);
    outline: none;
}

/* Tombol Pinjam */
button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(to right, #007bff, #00a6ff);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 15px;
}

button:hover {
    background: linear-gradient(to right, #0066d6, #008fe0);
}

/* Tombol kembali */
a {
    display: block;
    text-align: center;
    margin-top: 12px;
    color: #0056b3;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}

  </style>
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
