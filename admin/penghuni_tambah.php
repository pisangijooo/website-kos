<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login_admin.php");
    exit;
}

$users = mysqli_query($koneksi, "SELECT * FROM users WHERE status_penghuni='belum_menempati'");
$kamar = mysqli_query($koneksi, "SELECT * FROM kamar WHERE status='Kosong'");

if (isset($_POST['simpan'])) {
    $user_id = $_POST['user_id'];
    $kamar_id = $_POST['kamar_id'];
    $tanggal_masuk = date("Y-m-d");

    mysqli_query($koneksi, "
        INSERT INTO penghuni (user_id, kamar_id, tanggal_masuk, status)
        VALUES ('$user_id', '$kamar_id', '$tanggal_masuk', 'aktif')
    ");

    mysqli_query($koneksi, "
        UPDATE kamar SET status='Terisi' WHERE id_kamar='$kamar_id'
    ");

    mysqli_query($koneksi, "
        UPDATE users SET status_penghuni='menempati' WHERE id_user='$user_id'
    ");

    header("Location: penghuni.php?msg=added");
    exit;
}
?>
<html>
<head>
<title>Tambah Penghuni</title>
<style>
    body {
        font-family: Arial;
        background: #f5f5f5;
        margin: 0;
        padding: 20px;
    }
    .container {
        width: 450px;
        padding: 20px;
        background: white;
        margin: auto;
        border-radius: 10px;
        box-shadow: 0 0 10px #ccc;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #0f7d34;
    }
    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        margin-top: 15px;
        color: #0f7d34;
    }
    select, input {
        width: 100%;
        padding: 10px;
        border: 1px solid #9ccc9b;
        border-radius: 5px;
        font-size: 15px;
        background: #f8fff8;
    }
    button {
        width: 100%;
        padding: 12px;
        margin-top: 20px;
        background: #0f7d34;
        border: none;
        color: white;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
        transition: 0.2s;
    }
    button:hover {
        background: #0c622a;
    }
    .back {
        display: block;
        margin-top: 15px;
        text-align: center;
        color: #0f7d34;
        text-decoration: none;
        font-weight: bold;
    }
    .back:hover {
        text-decoration: underline;
    }
</style>
</head>

<body>

<div class="container">
    <h2>Tambah Penghuni</h2>

    <form method="POST">

        <label>Pilih User</label>
        <select name="user_id" required>
            <?php while ($u = mysqli_fetch_assoc($users)) { ?>
                <option value="<?php echo $u['id_user']; ?>">
                    <?php echo $u['nama']; ?>
                </option>
            <?php } ?>
        </select>

        <label>Pilih Kamar</label>
        <select name="kamar_id" required>
            <?php while ($k = mysqli_fetch_assoc($kamar)) { ?>
                <option value="<?php echo $k['id_kamar']; ?>">
                    <?php echo $k['nama_kamar']; ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit" name="simpan">Simpan</button>
    </form>

    <a class="back" href="penghuni.php">Kembali</a>
</div>

</body>
</html>
