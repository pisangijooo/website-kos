<?php
session_start();
include '../config/koneksi.php';

if(empty($_SESSION['user_logged_in'])) {
    header("Location: ../login.php");
    exit;
}

$nama_user = $_SESSION['nama_user'];

$kamar = mysqli_query($koneksi, "SELECT * FROM kamar WHERE status='kosong'");
?>

<html>
<head>
    <title>Dashboard User</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {font-family:Poppins,sans-serif;margin:0;padding:0;background:#f8f9fa;}
        .navbar {background:#059669;padding:15px;color:white;display:flex;justify-content:space-between;align-items:center;}
        .navbar .brand {font-size:20px;font-weight:600;}
        .navbar a {color:white;text-decoration:none;font-size:14px;margin-left:20px;}

        .container {max-width:1100px;margin:30px auto;padding:20px;}
        h2 {color:#065f46;font-weight:600;}
        h3 {margin-top:35px;color:#065f46;}

        .welcome-box, .menu-box {background:white;padding:18px;border-radius:12px;box-shadow:0 3px 10px rgba(0,0,0,0.08);margin-bottom:25px;}
        .menu-box a {display:block;font-size:14px;color:#065f46;font-weight:500;text-decoration:none;margin-bottom:10px;}

        .kamar-grid {display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px;margin-top:20px;}
        .card {background:white;border-radius:12px;box-shadow:0 3px 10px rgba(0,0,0,0.08);overflow:hidden;}
        .card img {width:100%;height:180px;object-fit:cover;}
        .card-body {padding:15px;}
        .title {font-size:16px;font-weight:600;color:#065f46;}
        .price {font-size:15px;margin:5px 0;color:#333;}
        .desc {font-size:13px;color:#555;margin-bottom:8px;}
        .fas {font-size:13px;color:#444;margin-bottom:12px;}

        .btn-book {padding:8px 14px;background:#059669;color:white;border-radius:6px;font-size:13px;text-decoration:none;}
        .btn-book:hover {background:#047857;}
    </style>
</head>

<body>

<div class="navbar">
    <div class="brand">Kos Pisang Ijo</div>
    <div>
        <span>Halo, <?= htmlspecialchars($nama_user) ?></span>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="container">

<div class="welcome-box">
    <h2>Dashboard User</h2>
    <p>Selamat datang di sistem pemesanan kamar</p>
</div>

<div class="menu-box">
    <a href="riwayat.php">Riwayat Booking</a>
    <a href="pembayaran.php">Pembayaran Bulanan</a>
</div>

<h3>Kamar Tersedia</h3>

<div class="kamar-grid">

<?php while ($k = mysqli_fetch_assoc($kamar)) { ?>

<div class="card">

    <img src="../admin/uploads/<?= htmlspecialchars($k['foto']); ?>" alt="Foto Kamar">

    <div class="card-body">
        <div class="title"><?= htmlspecialchars($k['nama_kamar']); ?></div>

        <div class="price">Rp <?= number_format($k['harga']); ?></div>

        <div class="fas"><b>Fasilitas:</b> <?= htmlspecialchars($k['fasilitas']); ?></div>

        <div class="desc"><?= htmlspecialchars($k['deskripsi']); ?></div>

        <a class="btn-book" href="booking.php?id=<?= $k['id_kamar']; ?>">Booking</a>
    </div>

</div>

<?php } ?>

</div>

</div>

</body>
</html>
