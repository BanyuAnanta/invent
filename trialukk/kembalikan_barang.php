
<?php
  session_start();
  if (!isset($_SESSION['login'])) {
      header("Location: login.php");
      exit;
  }

  include("koneksi.php");

  $id = $_GET['id'];

  $data = mysqli_query ($conn, "SELECT * FROM barang WHERE id=$id");
  $barang = mysqli_fetch_assoc ($data);

  if (!$barang) die("Barang tidak ditemukan");

  $dipinjam = $barang['jumlah'] - $barang['tersedia'];
  $error = "";

  if (isset($_POST['submit'])) {
    $peminjam = $_POST['peminjam'];
    $jumlah = $_POST['jumlah'];
    $catatan = $_POST['catatan'];

    if ($peminjam === "" || $jumlah <= 0) {
      $error = "Isi nama pengembali & jumlah yang benar";
    }
    elseif ($dipinjam <= 0){
      $error = "Tidak ada barang yang sedang dipinjam";
    }
    elseif ($jumlah > $dipinjam) {
      $error = "jumlah pengembalian melebihi barang yang dipinjam";
    }
    else {
      mysqli_query ($conn, "INSERT INTO transaksi (barang_id, peminjam, jenis, jumlah, catatan)
      VALUES ($id, '$peminjam', 'kembali', $jumlah, '$catatan')"
      );

      mysqli_query($conn, "UPDATE barang SET tersedia = LEAST(jumlah, tersedia + $jumlah) WHERE id = $id"
      );

      echo "<script>alert('Barang berhasil dikembalikan'); window.location='index.php';</script>";

    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kembali Barang | Inventaris</title>
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
    margin-bottom: 12px;
}

p b {
    color: #004a8d;
}

/* Label */
label {
    font-weight: bold;
    color: #003d7a;
}

/* Input dan Textarea */
input[type="text"],
input[type="number"],
textarea {
    width: 100%;
    padding: 12px;
    margin: 6px 0 14px;
    border-radius: 8px;
    border: 1px solid #bcd8ff;
    background: #f7fbff;
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

/* Tombol submit */
button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(to right, #007bff, #00a6ff);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 10px;
}

button:hover {
    background: linear-gradient(to right, #0066d6, #008fe0);
}

/* Tombol Kembali */
a {
    display: block;
    margin-top: 12px;
    text-align: center;
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
    <h2>Kembalikan Barang: <?= $barang['nama'] ?></h2>
    <p><b>Stok yang dipinjam saat ini: <?= $dipinjam ?></b></p>

    <form action="" method="POST">
      
      <label for="peminjam">Nama Pengembali:</label><br>
      <input type="text" name="peminjam" id="peminjam" required><br><br>

      <label for="jumlah">Jumlah yang Dikembalikan:</label><br>
      <input type="number" name="jumlah" value="1" min="1" max="<?= $dipinjam ?>" required><br><br>

      <label for="catatan">Catatan:</label><br>
      <textarea name="catatan" id="catatan" required></textarea><br><br>

      <button type="submit" name="submit">Kembalikan</button>
      <a href="index.php">Kembali</a>

    </form>
  </div>
</body>
</html>
