<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$data = $koneksi->query("SELECT * FROM pembayaran_bulanan WHERE id='$id'")->fetch_assoc();
?>

<html>
<head>
<style>
body { font-family: Arial; background:#f4f4f4; margin:20px; }
.container { background:#fff; padding:20px; width:400px; border-radius:8px; box-shadow:0 0 10px #ccc; }
.btn { background:green; color:#fff; padding:10px 15px; border:none; border-radius:5px; cursor:pointer; }
</style>
</head>
<body>

<div class="container">
    <h3>Upload Bukti Pembayaran</h3>

    <form action="proses_bayar.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

        Bukti transfer
        <input type="file" name="bukti" required>

        <br><br>
        <button class="btn" type="submit" name="upload">Kirim Pembayaran</button>
    </form>

</div>

</body>
</html>
