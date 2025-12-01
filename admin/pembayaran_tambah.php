<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login_admin.php");
    exit;
}

// ambil penghuni
$penghuni = $koneksi->query("
    SELECT pn.id, u.nama, k.nama_kamar
    FROM penghuni pn
    LEFT JOIN users u ON pn.user_id = u.id_user
    LEFT JOIN kamar k ON pn.kamar_id = k.id_kamar
");

if (isset($_POST['simpan'])) {
    $penghuni_id = $_POST['penghuni_id'];
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $tanggal_bayar = date("Y-m-d");

    // Cek apakah sudah ada pembayaran untuk bulan dan tahun ini
    $cek = $koneksi->query("SELECT * FROM pembayaran_bulanan WHERE penghuni_id='$penghuni_id' AND bulan='$bulan' AND tahun='$tahun'");
    if ($cek->num_rows > 0) {
        $msg = "Pembayaran untuk bulan dan tahun ini sudah ada";
    } else {
        $query = "
            INSERT INTO pembayaran_bulanan 
            (penghuni_id, bulan, tahun, status_lunas, tanggal_bayar)
            VALUES ('$penghuni_id', '$bulan', '$tahun', 'lunas', '$tanggal_bayar')
        ";
        $koneksi->query($query);
        $msg = "Pembayaran berhasil ditambahkan";
    }
}
?>
<html>
<head>
    <title>Tambah Pembayaran</title>
    <style>
        body {font-family: Arial; background: #f4fff4; margin: 0;}
        .container {padding: 25px; background: white; width: 450px; margin: 40px auto; border-radius: 8px; border: 1px solid #cce0cc;}
        h2 {text-align: center; color: #2f5233; margin-bottom: 20px;}
        label {font-weight: bold; color: #2f5233;}
        select, input {width: 100%; padding: 9px; margin-top: 5px; margin-bottom: 15px; border: 1px solid #aacbaa; border-radius: 5px;}
        button {padding: 10px; width: 100%; border: none; background: #3fa564; color: white; font-weight: bold; border-radius: 5px; cursor: pointer;}
        a {display: block; text-align: center; margin-top: 15px; color: #2f5233; text-decoration: none;}
        .msg {color: green; margin-bottom: 15px; text-align: center;}
        table {width:100%; border-collapse: collapse; margin-top: 20px;}
        th, td {padding:8px; border:1px solid #ddd; text-align:left;}
        th {background:#3fa564; color:white;}
        td a {color:#0f7d34; text-decoration:none;}
    </style>
</head>
<body>

<div class="container">
    <h2>Tambah Pembayaran</h2>

    <?php if(!empty($msg)) { echo "<div class='msg'>$msg</div>"; } ?>

    <form method="POST">
        <label>Penghuni</label>
        <select name="penghuni_id" required>
            <?php while ($p = $penghuni->fetch_assoc()) { ?>
                <option value="<?= $p['id']; ?>">
                    <?= $p['nama']; ?> - <?= $p['nama_kamar']; ?>
                </option>
            <?php } ?>
        </select>

        <label>Bulan</label>
        <select name="bulan" required>
            <?php for($i=1;$i<=12;$i++) { 
                $namaBulan = date('F', mktime(0,0,0,$i,1)); ?>
                <option value="<?= $i ?>"><?= $namaBulan ?></option>
            <?php } ?>
        </select>

        <label>Tahun</label>
        <input type="number" name="tahun" value="<?= date('Y'); ?>" required>

        <button type="submit" name="simpan">Simpan</button>
    </form>

    <a href="pembayaran.php">Kembali</a>

    <h3>Pembayaran Terakhir</h3>
    <table>
        <tr>
            <th>Penghuni</th>
            <th>Bulan</th>
            <th>Tahun</th>
            <th>Status</th>
            <th>Bukti</th>
        </tr>
        <?php
        $pembayaran = $koneksi->query("
            SELECT pb.*, u.nama
            FROM pembayaran_bulanan pb
            LEFT JOIN penghuni pn ON pb.penghuni_id = pn.id
            LEFT JOIN users u ON pn.user_id = u.id_user
            ORDER BY pb.id DESC LIMIT 10
        ");
        while($row = $pembayaran->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['bulan'] ?></td>
                <td><?= $row['tahun'] ?></td>
                <td><?= $row['status_lunas'] ?></td>
                <td>
                    <?php if($row['bukti']) { ?>
                        <a href="../uploads/<?= $row['bukti'] ?>" target="_blank">Lihat Bukti</a>
                    <?php } else { echo '-'; } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
