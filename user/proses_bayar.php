<?php
session_start();
include 'config/koneksi.php';

if (isset($_POST['upload'])) {
    $id = $_POST['id'];

    // upload file
    $nama_file = time() . '_' . $_FILES['bukti']['name'];
    $temp = $_FILES['bukti']['tmp_name'];

    move_uploaded_file($temp, "uploads/" . $nama_file);

    // update pembayaran
    $tanggal = date('Y-m-d');

    $koneksi->query("
        UPDATE pembayaran_bulanan 
        SET status_lunas='lunas', tanggal_bayar='$tanggal'
        WHERE id='$id'
    ");

    header("Location: pembayaran.php?msg=success");
    exit;
}
?>
