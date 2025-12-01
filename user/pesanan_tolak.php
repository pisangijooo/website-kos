<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login_admin.php");
    exit;
}

$id = $_GET['id'];

$koneksi->query("UPDATE pengajuan_sewa SET status='ditolak' WHERE id='$id'");

header("Location: pesanan.php");
exit;
