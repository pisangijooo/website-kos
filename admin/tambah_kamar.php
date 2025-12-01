<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login_admin.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];
    $fasilitas = $_POST['fasilitas'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];

    $foto = "";

    if (!empty($_FILES['foto']['name'])) {
        $namaFile = time() . "_" . $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $namaFile);
        $foto = $namaFile;
    }

    $query = "INSERT INTO kamar (nama_kamar, harga, status, foto, fasilitas, lokasi, deskripsi)
              VALUES ('$nama', '$harga', '$status', '$foto', '$fasilitas', '$lokasi', '$deskripsi')";
    mysqli_query($koneksi, $query);

    header("Location: kamar.php?msg=added");
    exit;
}
?>
<html>
<head>
    <title>Tambah Kamar</title>
    <style>
        body {
            font-family: Arial;
            background: #f4fff4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background: #3fa564;
            padding: 15px;
            color: white;
        }
        .navbar a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            padding: 25px;
        }
        h2 {
            margin: 0;
            color: #2f5233;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 6px;
            width: 420px;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background: #3fa564;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        a.back {
            display: inline-block;
            margin-top: 15px;
            color: #3fa564;
            text-decoration: none;
            font-weight: bold;
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
    <a href="logout_admin.php">Logout</a>
</div>

<div class="container">
    <h2>Tambah Kamar</h2>

    <form method="POST" enctype="multipart/form-data">

        Nama kamar
        <input type="text" name="nama" required>

        Harga
        <input type="number" name="harga" required>

        Status
        <select name="status">
            <option value="kosong">Kosong</option>
            <option value="terisi">Terisi</option>
        </select>

        Foto kamar
        <input type="file" name="foto">

        Fasilitas
        <textarea name="fasilitas" rows="3" required></textarea>

        Lokasi
        <textarea name="lokasi" rows="2" required></textarea>

        Deskripsi
        <textarea name="deskripsi" rows="4" required></textarea>

        <button type="submit" name="simpan">Simpan</button>
    </form>

    <a href="kamar.php" class="back">Kembali</a>

</div>

</body>
</html>
