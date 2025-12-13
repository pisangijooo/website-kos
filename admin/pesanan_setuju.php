<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login_admin.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: pesanan.php");
    exit;
}

$id = $_GET['id'];

// ambil data pengajuan
$q = $koneksi->query("SELECT * FROM pengajuan_sewa WHERE id='$id' LIMIT 1");
$p = $q->fetch_assoc();

if (!$p) {
    header("Location: pesanan.php");
    exit;
}

$user_id  = $p['user_id'];
$kamar_id = $p['kamar_id'];

// update status pengajuan
$koneksi->query("
    UPDATE pengajuan_sewa 
    SET status='diterima' 
    WHERE id='$id'
");

// cek apakah sudah jadi penghuni
$cekPenghuni = $koneksi->query("
    SELECT id FROM penghuni WHERE user_id='$user_id' LIMIT 1
");

if ($cekPenghuni->num_rows == 0) {

    // buat data penghuni
    $koneksi->query("
        INSERT INTO penghuni (user_id, kamar_id, tanggal_masuk, status)
        VALUES ('$user_id', '$kamar_id', CURDATE(), 'aktif')
    ");

    $penghuni_id = $koneksi->insert_id;

} else {
    $ph = $cekPenghuni->fetch_assoc();
    $penghuni_id = $ph['id'];
}

// buat pembayaran bulan pertama
$bulan = date('m');
$tahun = date('Y');

$cekBayar = $koneksi->query("
    SELECT id FROM pembayaran_bulanan
    WHERE penghuni_id='$penghuni_id' AND bulan='$bulan' AND tahun='$tahun'
");

if ($cekBayar->num_rows == 0) {
    $koneksi->query("
        INSERT INTO pembayaran_bulanan (penghuni_id, bulan, tahun, status_lunas)
        VALUES ('$penghuni_id', '$bulan', '$tahun', 'belum')
    ");
}

// update kamar jadi terisi
$koneksi->query("
    UPDATE kamar 
    SET status='terisi' 
    WHERE id_kamar='$kamar_id'
");

header("Location: pesanan.php");
exit;
