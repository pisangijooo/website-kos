<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login_admin.php");
    exit;
}

$kamar = $koneksi->query("SELECT * FROM kamar ORDER BY id_kamar DESC");
?>
<html>
<head>
    <title>Data Kamar</title>
    <style>
        body { font-family: Arial; background: #f4fff4; margin: 0; padding: 0; }
        .navbar { background: #3fa564; padding: 15px; color: white; }
        .navbar a { color: white; margin-right: 15px; text-decoration: none; font-weight: bold; }
        .container { padding: 25px; }
        h2 { margin: 0; color: #2f5233; }
        .btn-add { padding: 8px 14px; background: #3fa564; color: white; text-decoration: none; border-radius: 4px; margin: 15px 0; display: inline-block; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th { background: #3fa564; color: white; padding: 10px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #dcdcdc; }
        .foto { width: 80px; height: 80px; object-fit: cover; border-radius: 5px; border: 1px solid #ccc; }
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
    <a href="logout_admin.php">Logout</a>
</div>

<div class="container">
    <h2>Data Kamar</h2>

    <a href="tambah_kamar.php" class="btn-add">Tambah Kamar</a>

    <table>
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Nama Kamar</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php 
        $no = 1;
        while ($d = $kamar->fetch_assoc()) { 
            
            // Path sesuai folder uploads berada di dalam folder admin
            $foto = "uploads/" . $d['foto'];

            if (!file_exists($foto) || empty($d['foto'])) {
                $foto = "uploads/noimage.png";
            }
        ?>
        <tr>
            <td><?php echo $no++; ?></td>

            <td><img src="<?php echo $foto; ?>" class="foto"></td>

            <td><?php echo $d['nama_kamar']; ?></td>
            <td><?php echo number_format($d['harga']); ?></td>
            <td><?php echo $d['status']; ?></td>

            <td>
                <a href="kamar_edit.php?id=<?php echo $d['id_kamar']; ?>">Edit</a>
                <a href="kamar_hapus.php?id=<?php echo $d['id_kamar']; ?>" onclick="return confirm('Hapus kamar ini')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
