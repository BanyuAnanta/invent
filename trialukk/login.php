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
    body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(to bottom right, #e0f3ff, #ffffff);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.container {
    background: #ffffffee;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    width: 320px;
    text-align: center;
}

h2 {
    margin-bottom: 20px;
    color: #005cbe;
    letter-spacing: 1px;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border-radius: 8px;
    border: 1px solid #bcd8ff;
    background: #f7fbff;
    transition: 0.3s;
}

input[type="text"]:focus,
input[type="password"]:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0,123,255,0.4);
    outline: none;
}

input[type="submit"] {
    width: 100%;
    padding: 12px;
    background: linear-gradient(to right, #007bff, #00a6ff);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    margin-top: 10px;
}

input[type="submit"]:hover {
    background: linear-gradient(to right, #0066d6, #008fe0);
}

p {
    margin-top: 15px;
    font-size: 14px;
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