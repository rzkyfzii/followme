<?php
require 'function.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $cekdatabase = mysqli_query($conn, "SELECT * FROM login WHERE email='$email' AND password='$password'");
    $hitung = mysqli_num_rows($cekdatabase);

    if ($hitung > 0) {
        $_SESSION['log'] = true;
        header('Location: index.php');
        exit;
    } else {
        header('Location: login.php');
        exit;
    }
}

// Mengecek apakah sudah login, kalau iya redirect
if (isset($_SESSION['log'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="css/login.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="card">
            <div class="card-header">
                <h2>Login</h2>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" id="inputEmail" name="email" required placeholder="name@example.com">
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <input type="password" id="inputPassword" name="password" required placeholder="Password">
                    </div>
                    <button type="submit" name="login" class="btn">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
