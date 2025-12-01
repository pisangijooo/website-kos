<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['user_logged_in'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil user_id dari session
$id_user = $_SESSION['user_logged_in'];

// Ambil id kamar dari URL
if (!isset($_GET['id'])) {
    header("Location: index_user.php");
    exit;
}

$id_kamar = $_GET['id'];

// Ambil detail kamar yang dipilih
$q = $koneksi->query("SELECT * FROM kamar WHERE id_kamar='$id_kamar' LIMIT 1");
$kamar = $q->fetch_assoc();

if (!$kamar) {
    header("Location: index_user.php");
    exit;
}

$pesan = "";

// Proses booking
if (isset($_POST['booking'])) {

    $tanggal = date("Y-m-d");

    // Insert pengajuan sewa
    $koneksi->query("
        INSERT INTO pengajuan_sewa (user_id, kamar_id, status, tanggal_pengajuan)
        VALUES ('$id_user', '$id_kamar', 'pending', '$tanggal')
    ");

    // Cek apakah user sudah punya entry di penghuni
    $cekPenghuni = $koneksi->query("SELECT id FROM penghuni WHERE user_id='$id_user' LIMIT 1");

    if (mysqli_num_rows($cekPenghuni) == 0) {
        $koneksi->query("INSERT INTO penghuni (user_id, kamar_id) VALUES ('$id_user', '$id_kamar')");
        $penghuni_id = $koneksi->insert_id;
    } else {
        $p = mysqli_fetch_assoc($cekPenghuni);
        $penghuni_id = $p['id'];
    }

    // Tambah pembayaran bulan ini
    $bulan = date("m");
    $tahun = date("Y");

    $cekBayar = $koneksi->query("SELECT id FROM pembayaran_bulanan 
        WHERE penghuni_id='$penghuni_id' AND bulan='$bulan' AND tahun='$tahun' LIMIT 1");

    if (mysqli_num_rows($cekBayar) == 0) {
        $koneksi->query("
            INSERT INTO pembayaran_bulanan (penghuni_id, bulan, tahun, status_lunas)
            VALUES ('$penghuni_id', '$bulan', '$tahun', 'belum')
        ");
    }

    $pesan = "Pengajuan berhasil dikirim. Pembayaran bulan ini otomatis dibuat.";
}
?>

<html>
<head>
    <title>Booking Kamar</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {font-family:Poppins,sans-serif;margin:0;padding:0;background:#f8f9fa;}
        .navbar {background:#059669;padding:15px;color:white;display:flex;justify-content:space-between;align-items:center;}
        .navbar a {color:white;text-decoration:none;font-size:14px;margin-left:18px;}
        .navbar .brand {font-size:20px;font-weight:600;}
        .container {max-width:520px;margin:40px auto;padding:20px;}
        .card {background:white;padding:25px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.08);}
        h2 {text-align:center;color:#065f46;font-weight:600;margin-bottom:22px;}
        label {font-size:14px;font-weight:500;margin-bottom:6px;display:block;color:#333;}
        input {width:100%;padding:10px;border-radius:8px;border:1px solid #d1d5db;font-size:14px;margin-bottom:20px;}
        button {width:100%;padding:12px;background:#059669;color:white;border:none;border-radius:8px;font-size:15px;font-weight:600;cursor:pointer;}
        button:hover {background:#047857;}
        .msg {background:#d1fae5;color:#065f46;padding:12px;border-radius:8px;text-align:center;font-size:14px;margin-bottom:20px;}
        .back {display:block;margin-top:18px;text-align:center;color:#065f46;font-weight:500;text-decoration:none;}
        .foto-kamar {width:100%;height:200px;border-radius:10px;object-fit:cover;margin-bottom:15px;}
        .info {font-size:14px;margin-bottom:8px;color:#333;}
    </style>
</head>

<body>

<div class="navbar">
    <div class="brand">Kos Pisang Ijo</div>
    <div>
        <a href="index_user.php">Dashboard</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <div class="card">

        <h2>Booking Kamar</h2>

        <?php if ($pesan != "") { ?>
            <div class="msg"><?= $pesan ?></div>
        <?php } ?>

        <img src="../admin/uploads/<?= $kamar['foto']; ?>" class="foto-kamar">

        <div class="info"><b>Nama Kamar:</b> <?= $kamar['nama_kamar']; ?></div>
        <div class="info"><b>Harga:</b> Rp <?= number_format($kamar['harga']); ?></div>
        <div class="info"><b>Fasilitas:</b> <?= $kamar['fasilitas']; ?></div>
        <div class="info"><b>Deskripsi:</b> <?= $kamar['deskripsi']; ?></div>

        <form method="post">
            <input type="hidden" name="kamar" value="<?= $id_kamar; ?>">
            <button name="booking">Kirim Pengajuan</button>
        </form>

        <a class="back" href="index_user.php">Kembali ke Dashboard</a>

    </div>
</div>

</body>
</html>
