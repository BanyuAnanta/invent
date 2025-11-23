<?php
  session_start();
  include ('koneksi.php');

  if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password_input = $_POST['password'];

    $query = mysqli_query ($conn, "SELECT * FROM user WHERE username='$username'");
    $data = mysqli_fetch_assoc ($query);

    if ($data){

      if (password_verify($password_input, $data ['password'])){
        $_SESSION ['username'] = $data ['username'];
        $_SESSION ['fullname'] = $data ['fullname'];
        $_SESSION ['login'] = true;

        header ("location: index.php");
        exit;

      }else {
        $error = "Password salah";
      }
    }else {
      $error = "Username salah";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Inventaris</title>
  <style>
    /* Reset dasar */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: Arial, Helvetica, sans-serif;
}

/* Background gradiasi ungu → hitam */
body {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background: linear-gradient(135deg, #6a11cb, #000000);
}

/* Container form */
.container {
  background: rgba(255, 255, 255, 0.1);
  padding: 40px;
  width: 320px;
  border-radius: 12px;
  box-shadow: 0 0 20px rgba(0,0,0,0.4);
  backdrop-filter: blur(8px);
}

/* Judul */
.container h2 {
  text-align: center;
  color: #ffffff;
  margin-bottom: 20px;
}

/* Input */
.container input[type="text"],
.container input[type="password"] {
  width: 100%;
  padding: 12px;
  margin: 10px 0;
  border: none;
  border-radius: 8px;
  outline: none;
  font-size: 14px;
}

/* Tombol */
.container input[type="submit"] {
  width: 100%;
  background-color: #6a11cb;
  color: #fff;
  padding: 12px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
  margin-top: 10px;
  transition: 0.3s;
}

/* Hover tombol */
.container input[type="submit"]:hover {
  background-color: #4e0f96;
}

/* Error message */
.container p {
  text-align: center;
  color: #ff6060;
  margin-top: 10px;
}

  </style>
</head>
<body>
  <div class="container">
    <form method="post" action="">
        <h2>Login</h2>
        <input type="text" name="username" placeholder="Masukkan Username" require><br>
        <input type="password" name="password" placeholder="Masukkan Password" require><br>
        <input type="submit" name="login" value="LOGIN">
    </form>
    <?php if (isset($error))echo "<p style='color:red'>$error</p>"; ?>
</body>
</html>