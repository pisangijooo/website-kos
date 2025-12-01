<?php
// ===============================
// FILE: register.php
// ===============================
session_start();
include 'config/koneksi.php';

$pesan = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $password = $_POST['password'];

    $sql = "SELECT id_user FROM users WHERE email='$email' LIMIT 1";
    $cek = $koneksi->query($sql);

    if ($cek && $cek->num_rows > 0) {
        $pesan = "Email sudah terdaftar.";
    } else {
        $insert = "INSERT INTO users (nama, email, password, no_hp, role, status_penghuni)
                   VALUES ('$nama', '$email', '$password', '$no_hp', 'user', 'belum_menempati')";

        if ($koneksi->query($insert)) {
            $pesan = "Registrasi berhasil. Silakan login.";
        } else {
            $pesan = "Gagal menyimpan data.";
        }
    }
}
?>

<html>
<head>
    <title>Registrasi Pengguna</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {font-family:Poppins,sans-serif;margin:0;padding:0;background:#f8f9fa;}
        .container {max-width:430px;margin:60px auto;background:white;padding:25px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.1);}
        h2 {text-align:center;color:#065f46;font-weight:600;margin-bottom:25px;}
        label {font-size:14px;font-weight:500;color:#333;}
        input {width:100%;padding:10px;margin-top:6px;margin-bottom:16px;border-radius:8px;border:1px solid #d1d5db;font-size:14px;}
        button {width:100%;padding:12px;background:#059669;color:white;border:none;border-radius:8px;font-size:15px;font-weight:600;cursor:pointer;}
        button:hover {background:#047857;}
        .pesan {text-align:center;color:#059669;margin-top:15px;font-size:14px;}
        .login-link {text-align:center;margin-top:12px;font-size:14px;}
        .login-link a {color:#065f46;font-weight:600;text-decoration:none;}
    </style>
</head>
<body>
<div class="container">
    <h2>Daftar Akun Baru</h2>
    <form method="POST">
        <label>Nama</label>
        <input type="text" name="nama" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>No HP</label>
        <input type="text" name="no_hp" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Daftar</button>
    </form>
    <div class="pesan"><?php echo $pesan; ?></div>
    <div class="login-link">Sudah punya akun <a href="login.php">Masuk</a></div>
</div>
</body>
</html>
