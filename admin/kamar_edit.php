<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login_admin.php");
    exit;
}

$id = $_GET['id'] ?? '';

// ambil data kamar
$data = mysqli_query($koneksi, "SELECT * FROM kamar WHERE id_kamar='$id'");
$k = mysqli_fetch_assoc($data);

// update data
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];
    $deskripsi = $_POST['deskripsi'];
    $fasilitas = $_POST['fasilitas'];

    // handle upload foto
    $foto = $k['foto'];
    if (isset($_FILES['foto']) && $_FILES['foto']['name'] != '') {
        $fileName = time() . '_' . $_FILES['foto']['name'];
        $fileTmp = $_FILES['foto']['tmp_name'];
        $uploadDir = '../uploads/';

        if (move_uploaded_file($fileTmp, $uploadDir.$fileName)) {
            $foto = $fileName;
        }
    }

    mysqli_query($koneksi, "UPDATE kamar SET 
        nama_kamar='$nama',
        harga='$harga',
        status='$status',
        deskripsi='$deskripsi',
        fasilitas='$fasilitas',
        foto='$foto'
        WHERE id_kamar='$id'
    ");

    header("Location: kamar.php?msg=updated");
    exit;
}
?>
<html>
<head>
<title>Edit Kamar</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
<style>
body {font-family:Poppins,sans-serif;margin:0;padding:20px;background:#f8f9fa;}
h2 {color:#065f46;margin-bottom:20px;text-align:center;}
form {background:white;padding:20px;border-radius:12px;max-width:500px;margin:auto;box-shadow:0 4px 15px rgba(0,0,0,0.08);}
label {font-weight:bold;margin-bottom:5px;display:block;}
input, textarea, select, button {width:100%;padding:10px;margin-bottom:15px;border-radius:5px;border:1px solid #aacbaa;font-size:14px;}
textarea {resize:none;height:80px;}
button {background:#3fa564;color:white;border:none;font-weight:bold;cursor:pointer;}
a {text-decoration:none;color:#065f46;display:block;text-align:center;margin-top:10px;}
img {max-width:100%;margin-bottom:10px;border-radius:8px;}
</style>
</head>
<body>

<h2>Edit Kamar</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Nama Kamar</label>
    <input type="text" name="nama" value="<?= htmlspecialchars($k['nama_kamar']); ?>" required>

    <label>Harga</label>
    <input type="number" name="harga" value="<?= $k['harga']; ?>" required>

    <label>Status</label>
    <select name="status" required>
        <option value="kosong" <?= $k['status']=="kosong" ? "selected" : ""; ?>>Kosong</option>
        <option value="terisi" <?= $k['status']=="terisi" ? "selected" : ""; ?>>Terisi</option>
    </select>

    <label>Deskripsi</label>
    <textarea name="deskripsi" required><?= htmlspecialchars($k['deskripsi']); ?></textarea>

    <label>Fasilitas (pisahkan dengan koma)</label>
    <textarea name="fasilitas" required><?= htmlspecialchars($k['fasilitas']); ?></textarea>

    <label>Foto</label>
    <?php if($k['foto']) { ?>
        <img src="../uploads/<?= $k['foto']; ?>" alt="Foto Kamar">
    <?php } ?>
    <input type="file" name="foto">

    <button type="submit" name="update">Update</button>
</form>

<a href="kamar.php">Kembali</a>

</body>
</html>
