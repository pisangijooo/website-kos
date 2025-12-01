<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login_admin.php");
    exit;
}

$id = $_GET['id'];

// Ambil data pesanan
$p = $koneksi->query("SELECT * FROM pengajuan_sewa WHERE id='$id'")->fetch_assoc();
$user_id = $p['user_id'];
$kamar_id = $p['kamar_id'];
$tanggal_masuk = date("Y-m-d");

// Update pesanan
$koneksi->query("UPDATE pengajuan_sewa SET status='diterima' WHERE id='$id'");

// Masukkan ke tabel penghuni
$koneksi->query("
    INSERT INTO penghuni (user_id, kamar_id, tanggal_masuk) 
    VALUES ('$user_id', '$kamar_id', '$tanggal_masuk')
");

// Update kamar jadi terisi
$koneksi->query("UPDATE kamar SET status='terisi' WHERE id='$kamar_id'");

header("Location: pesanan.php");
exit;
