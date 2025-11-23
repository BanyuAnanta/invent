
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
    width: 400px;
    box-shadow: 0 0 15px rgba(0,0,0,0.12);
}

h2 {
    text-align: center;
    color: #0056b3;
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    color: #003d7a;
}

/* Input & Textarea */
input[type="text"],
input[type="number"],
textarea {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #bcd8ff;
    background: #f7fbff;
    margin-top: 6px;
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

/* Tombol Simpan */
button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(to right, #007bff, #00a6ff);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 12px;
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
