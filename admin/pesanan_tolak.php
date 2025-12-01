<?php
session_start();
include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($koneksi, "UPDATE pengajuan_sewa SET status='ditolak' WHERE id='$id'");
header("Location: pesanan.php");
exit;
