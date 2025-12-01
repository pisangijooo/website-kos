<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['user_logged_in'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$queryPenghuni = "
SELECT p.id AS penghuni_id, k.nama_kamar
FROM penghuni p
JOIN kamar k ON p.kamar_id = k.id_kamar
WHERE p.user_id = '$user_id'
LIMIT 1
";
$penghuni = mysqli_query($koneksi, $queryPenghuni);

if (mysqli_num_rows($penghuni) == 0) {
    $penghuni_id = null;
} else {
    $p = mysqli_fetch_assoc($penghuni);
    $penghuni_id = $p['penghuni_id'];
}

if (isset($_POST['upload_bukti']) && isset($_FILES['bukti'])) {

    $id = $_POST['pembayaran_id'];
    $fileName = time() . '_' . $_FILES['bukti']['name'];
    $fileTmp = $_FILES['bukti']['tmp_name'];
    $uploadDir = '../uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($fileTmp, $uploadDir . $fileName)) {
        mysqli_query($koneksi, "UPDATE pembayaran_bulanan SET bukti='$fileName' WHERE id='$id'");
        $msg = "Bukti berhasil diupload";
    } else {
        $msg = "Upload gagal";
    }
}

$dataPembayaran = mysqli_query($koneksi, "
SELECT *
FROM pembayaran_bulanan
WHERE penghuni_id = '$penghuni_id'
ORDER BY tahun DESC, bulan DESC
");
?>
<html>
<head>
<title>Pembayaran Bulanan</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
<style>
body {font-family:Poppins,sans-serif;margin:0;padding:0;background:#f8f9fa;}
.navbar {background:#059669;padding:15px;color:white;display:flex;justify-content:space-between;align-items:center;}
.navbar .brand {font-size:18px;font-weight:600;}
.navbar a {color:white;text-decoration:none;font-size:14px;margin-left:20px;}
.container {max-width:1050px;margin:30px auto;padding:20px;}
h2 {color:#065f46;margin-bottom:18px;}
.box {background:white;padding:20px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.08);}
table {width:100%;border-collapse:collapse;margin-top:18px;background:white;border-radius:12px;overflow:hidden;box-shadow:0 3px 12px rgba(0,0,0,0.08);}
th {background:#10b981;color:white;padding:12px;font-size:14px;text-align:left;}
td {padding:12px;font-size:14px;color:#333;border-bottom:1px solid #e5e7eb;}
tr:last-child td {border-bottom:none;}
.upload-form {display:flex;gap:8px;}
.msg {color:green;margin-bottom:10px;}
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
<div class="box">
<h2>Pembayaran Bulanan</h2>

<?php if (!empty($msg)) { echo "<div class='msg'>$msg</div>"; } ?>

<?php if (!$penghuni_id) { ?>
    Kamu belum terdaftar sebagai penghuni. Tidak ada data pembayaran.

    <a href="index_user.php" 
        style="
            display:inline-block;
            margin-top:20px;
            padding:10px 18px;
            background:#059669;
            color:white;
            border-radius:8px;
            text-decoration:none;
            font-size:14px;
            font-weight:500;
        ">
        Kembali ke Dashboard
    </a>

<?php } else { ?>

<table>
<tr>
    <th>Bulan</th>
    <th>Tahun</th>
    <th>Status</th>
    <th>Tanggal Bayar</th>
    <th>Bukti</th>
    <th>Aksi</th>
</tr>

<?php while ($d = mysqli_fetch_assoc($dataPembayaran)) { ?>
<tr>
    <td><?= $d['bulan'] ?></td>
    <td><?= $d['tahun'] ?></td>
    <td><?= ucfirst($d['status_lunas']) ?></td>
    <td><?= $d['tanggal_bayar'] ?: '-' ?></td>
    <td>
        <?php if($d['bukti']) { ?>
            <a href="../uploads/<?= $d['bukti'] ?>" target="_blank">Lihat</a>
        <?php } else { echo '-'; } ?>
    </td>
    <td>
        <?php if(!$d['bukti']) { ?>
            <form class="upload-form" action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="pembayaran_id" value="<?= $d['id'] ?>">
                <input type="file" name="bukti" required>
                <button type="submit" name="upload_bukti">Upload</button>
            </form>
        <?php } else { echo '-'; } ?>
    </td>
</tr>
<?php } ?>

</table>

<a href="index_user.php" 
   style="
        display:inline-block;
        margin-top:20px;
        padding:10px 18px;
        background:#059669;
        color:white;
        border-radius:8px;
        text-decoration:none;
        font-size:14px;
        font-weight:500;
   ">
   Kembali ke Dashboard
</a>

<?php } ?>
</div>
</div>

</body>
</html>
