<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login_admin.php");
    exit;
}

$id = $_GET['id'];

// Ambil kamar_id dari penghuni
$data = mysqli_query($koneksi, "SELECT kamar_id FROM penghuni WHERE id='$id'");
$k = mysqli_fetch_assoc($data);

// Hapus penghuni
mysqli_query($koneksi, "DELETE FROM penghuni WHERE id='$id'");

// Set status kamar menjadi kosong
mysqli_query($koneksi, "UPDATE kamar SET status='kosong' WHERE id_kamar='".$k['kamar_id']."'");

header("Location: penghuni.php?msg=deleted");
exit;
?>
