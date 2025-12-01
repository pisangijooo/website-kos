<?php
session_start();
include '../config/koneksi.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $koneksi->query("SELECT * FROM admin WHERE username='$username' LIMIT 1");

    if ($query->num_rows > 0) {
        $data = $query->fetch_assoc();

        if ($password === $data['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $data['id'];
            $_SESSION['admin_nama'] = $data['nama'];

            header("Location: dashboard.php");
            exit;
        }
    }

    $error = "Username atau password salah";
}
?>

<html>
<head>
    <title>Login Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family:Poppins,sans-serif;
            background:#f3f4f6;
            margin:0;
            padding:0;
        }

        .container {
            max-width:380px;
            margin:80px auto;
            background:white;
            padding:28px;
            border-radius:12px;
            box-shadow:0 6px 18px rgba(0,0,0,0.08);
        }

        h2 {
            text-align:center;
            color:#065f46;
            margin-bottom:25px;
            font-weight:600;
        }

        label {
            font-size:14px;
            font-weight:500;
            margin-bottom:6px;
            display:block;
            color:#333;
        }

        input {
            width:100%;
            padding:10px;
            border-radius:8px;
            border:1px solid #d1d5db;
            margin-bottom:18px;
            font-size:14px;
        }

        button {
            width:100%;
            padding:12px;
            background:#059669;
            color:white;
            border:none;
            border-radius:8px;
            font-size:15px;
            font-weight:600;
            cursor:pointer;
        }

        button:hover { background:#047857; }

        .error {
            background:#fee2e2;
            color:#991b1b;
            padding:10px;
            border-radius:8px;
            font-size:14px;
            margin-bottom:15px;
            text-align:center;
        }

        .title-admin {
            text-align:center;
            color:#059669;
            font-weight:600;
            margin-bottom:18px;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="title-admin">Panel Admin Kos Pisang Ijo</div>

    <h2>Login Admin</h2>

    <?php if ($error != "") { ?>
        <div class="error"><?= $error ?></div>
    <?php } ?>

    <form method="POST">

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
