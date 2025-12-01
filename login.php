<?php
session_start();
include 'config/koneksi.php';

$error = "";

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {

        $query = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email' LIMIT 1");

        if (mysqli_num_rows($query) > 0) {

            $user = mysqli_fetch_assoc($query);

            if ($password === $user['password']) {

                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['nama_user'] = $user['nama'];
                $_SESSION['user_logged_in'] = true;

                header("Location: user/index_user.php");
                exit;

            } else {
                $error = "Email atau password salah";
            }

        } else {
            $error = "Email atau password salah";
        }

    } else {
        $error = "Form belum lengkap";
    }
}
?>
<html>
<head>
    <title>Login Pengguna</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {font-family:Poppins,sans-serif;margin:0;padding:0;background:#f8f9fa;}
        .container {max-width:430px;margin:70px auto;background:white;padding:28px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.1);}
        h2 {text-align:center;color:#065f46;font-weight:600;margin-bottom:25px;}
        label {font-size:14px;font-weight:500;color:#333;}
        input {width:100%;padding:10px;margin-top:6px;margin-bottom:16px;border-radius:8px;border:1px solid #d1d5db;font-size:14px;}
        button {width:100%;padding:12px;background:#059669;color:white;border:none;border-radius:8px;font-size:15px;font-weight:600;cursor:pointer;}
        button:hover {background:#047857;}
        .error {text-align:center;color:red;margin-bottom:12px;font-size:14px;}
        .register-link {text-align:center;margin-top:15px;font-size:14px;}
        .register-link a {color:#065f46;font-weight:600;text-decoration:none;}
    </style>
</head>
<body>
<div class="container">
    <h2>Masuk ke Akun</h2>
    <form method="POST">
        <?php if ($error != "") { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>

        <label>Email</label>
        <input type="text" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">Login</button>
    </form>
    <div class="register-link">Belum punya akun <a href="registrasi.php">Daftar</a></div>
</div>
</body>
</html>
