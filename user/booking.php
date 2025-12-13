<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['user_logged_in'])) {
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: index_user.php");
    exit;
}

$id_kamar = $_GET['id'];

$q = $koneksi->query("SELECT * FROM kamar WHERE id_kamar='$id_kamar' LIMIT 1");
$kamar = $q->fetch_assoc();

if (!$kamar) {
    header("Location: index_user.php");
    exit;
}

$pesan = "";

if (isset($_POST['booking'])) {

    if (!isset($_FILES['ktp']) || $_FILES['ktp']['error'] != 0) {
        $pesan = "Upload KTP wajib.";
    } else {

        $ext = pathinfo($_FILES['ktp']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png'];

        if (!in_array(strtolower($ext), $allowed)) {
            $pesan = "Format KTP harus JPG atau PNG.";
        } else {

            $namaKtp = time().'_'.$id_user.'.'.$ext;
            $tujuan = "../uploads/ktp/".$namaKtp;

            move_uploaded_file($_FILES['ktp']['tmp_name'], $tujuan);

            $tanggal = date("Y-m-d");

            $koneksi->query("
                INSERT INTO pengajuan_sewa 
                (user_id, kamar_id, ktp, status, tanggal_pengajuan)
                VALUES 
                ('$id_user', '$id_kamar', '$namaKtp', 'pending', '$tanggal')
            ");

            $pesan = "Pengajuan berhasil. Menunggu persetujuan admin.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Booking Kamar</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
body {font-family:Poppins,sans-serif;background:#f8f9fa;margin:0;}
.navbar {background:#059669;padding:15px;color:white;display:flex;justify-content:space-between;}
.container {max-width:520px;margin:40px auto;}
.card {background:white;padding:25px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.08);}
h2 {text-align:center;color:#065f46;}
label {font-size:14px;font-weight:500;}
input {width:100%;padding:10px;margin-bottom:16px;border-radius:8px;border:1px solid #ccc;}
button {width:100%;padding:12px;background:#059669;color:white;border:none;border-radius:8px;font-weight:600;}
.msg {background:#d1fae5;color:#065f46;padding:12px;border-radius:8px;text-align:center;margin-bottom:15px;}
.foto {width:100%;height:200px;object-fit:cover;border-radius:10px;margin-bottom:15px;}
.info {font-size:14px;margin-bottom:8px;}
</style>
</head>
<body>

<div class="navbar">
    <div>Kos Pisang Ijo</div>
    <a href="index_user.php" style="color:white;text-decoration:none;">Dashboard</a>
</div>

<div class="container">
<div class="card">

<h2>Booking Kamar</h2>

<?php if ($pesan) { echo "<div class='msg'>$pesan</div>"; } ?>

<img src="../admin/uploads/<?= $kamar['foto']; ?>" class="foto">

<div class="info"><b>Kamar:</b> <?= $kamar['nama_kamar']; ?></div>
<div class="info"><b>Harga:</b> Rp <?= number_format($kamar['harga']); ?></div>
<div class="info"><b>Fasilitas:</b> <?= $kamar['fasilitas']; ?></div>

<form method="post" enctype="multipart/form-data">

    <label>Upload KTP</label>
    <input type="file" name="ktp" required>

    <button name="booking">Kirim Pengajuan</button>
</form>

</div>
</div>

</body>
</html>
