<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['user_logged_in'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_POST['pembayaran_id']) && isset($_FILES['bukti'])) {
    $id = $_POST['pembayaran_id'];
    $fileName = $_FILES['bukti']['name'];
    $fileTmp = $_FILES['bukti']['tmp_name'];
    $uploadDir = '../uploads/';

    if (move_uploaded_file($fileTmp, $uploadDir.$fileName)) {
        mysqli_query($koneksi, "UPDATE pembayaran_bulanan SET bukti='$fileName' WHERE id='$id'");
        header("Location: pembayaran.php");
    } else {
        echo "Upload gagal";
    }
}
?>
