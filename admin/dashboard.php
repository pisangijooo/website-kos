<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login_admin.php");
    exit;
}

$jumlah_user = $koneksi->query("SELECT COUNT(*) as jml FROM users")->fetch_assoc()['jml'];
$jumlah_penghuni = $koneksi->query("SELECT COUNT(*) as jml FROM penghuni")->fetch_assoc()['jml'];
$jumlah_kamar = $koneksi->query("SELECT COUNT(*) as jml FROM kamar")->fetch_assoc()['jml'];
$jumlah_pesanan = $koneksi->query("SELECT COUNT(*) as jml FROM pengajuan_sewa")->fetch_assoc()['jml'];
?>
<html>
<head>
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: Arial;
            background: #eef5ee;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: #2e7d32;
            padding: 15px 25px;
            color: white;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 7px 12px;
            border-radius: 4px;
            transition: 0.2s;
        }

        .navbar a:hover {
            background: #1b5e20;
        }

        .logout {
            margin-left: auto;
            background: #c62828 !important;
        }

        .container {
            padding: 40px;
            text-align: center;
        }

        h2 {
            color: #1b5e20;
            font-size: 30px;
            margin-bottom: 25px;
        }

        .cards {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
        }

        .card {
            background: white;
            width: 230px;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
            transition: 0.2s;
            border-top: 6px solid #2e7d32;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.18);
        }

        .card-title {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .card b {
            font-size: 32px;
            color: #2e7d32;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="dashboard.php">Dashboard</a>
    <a href="kamar.php">Data Kamar</a>
    <a href="penghuni.php">Penghuni</a>
    <a href="pesanan.php">Pengajuan Sewa</a>
    <a href="pembayaran.php">Pembayaran</a>
    <a href="rekap.php">Rekap Pembayaran</a>
    <a href="logout_admin.php" class="logout">Logout</a>

</div>

<div class="container">
    <h2>Dashboard Admin</h2>

    <div class="cards">

        <div class="card">
            <div class="card-title">Total User</div>
            <b><?php echo $jumlah_user; ?></b>
        </div>

        <div class="card">
            <div class="card-title">Penghuni</div>
            <b><?php echo $jumlah_penghuni; ?></b>
        </div>

        <div class="card">
            <div class="card-title">Kamar</div>
            <b><?php echo $jumlah_kamar; ?></b>
        </div>

        <div class="card">
            <div class="card-title">Pengajuan</div>
            <b><?php echo $jumlah_pesanan; ?></b>
        </div>

    </div>
</div>

</body>
</html>
