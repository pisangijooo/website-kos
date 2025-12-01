<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login_admin.php");
    exit;
}

// Ambil data penghuni dengan join users dan kamar
$data = $koneksi->query("
SELECT 
    pn.id AS id_penghuni,
    pn.user_id,
    u.nama,
    u.no_hp,
    k.nama_kamar
FROM penghuni pn
INNER JOIN users u ON pn.user_id = u.id_user
LEFT JOIN kamar k ON pn.kamar_id = k.id_kamar
ORDER BY pn.id DESC
");
?>
<html>
<head>
    <title>Data Penghuni</title>
    <style>
        body { font-family: Arial; background: #f4fff4; margin: 0; padding: 0; }
        .navbar { background: #3fa564; padding: 15px; color: white; }
        .navbar a { color: white; margin-right: 15px; text-decoration: none; font-weight: bold; }
        .logout { color: #ffdddd !important; }
        .container { padding: 25px; }
        h2 { margin: 0; color: #2f5233; }
        .btn-add { padding: 8px 14px; background: #3fa564; color: white; text-decoration: none; border-radius: 4px; margin: 15px 0; display: inline-block; }
        table { width: 100%; border-collapse: collapse; background: white; margin-top: 10px; }
        th { background: #3fa564; color: white; padding: 10px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #dcdcdc; }
        .aksi a { color: #3fa564; text-decoration: none; margin-right: 6px; }
        .aksi a:hover { text-decoration: underline; }
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
    <a href="logout_admin.php" class="logout">Logout</a>
</div>

<div class="container">
    <h2>Data Penghuni</h2>

    <a href="penghuni_tambah.php" class="btn-add">Tambah Penghuni</a>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No HP</th>
            <th>Kamar</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while ($d = $data->fetch_assoc()) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($d['nama']); ?></td>
            <td><?= htmlspecialchars($d['no_hp']); ?></td>
            <td><?= htmlspecialchars($d['nama_kamar'] ?: '-'); ?></td>
            <td class="aksi">
                <a href="penghuni_edit.php?id=<?= $d['id_penghuni']; ?>">Edit</a>
                <a href="penghuni_hapus.php?id=<?= $d['id_penghuni']; ?>" onclick="return confirm('Hapus penghuni ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
