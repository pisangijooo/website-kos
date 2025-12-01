<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login_admin.php");
    exit;
}

// Tambah pembayaran
if(isset($_POST['tambah_pembayaran'])){
    $penghuni_id = $_POST['penghuni_id'];
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];

    $koneksi->query("
        INSERT INTO pembayaran_bulanan (penghuni_id, bulan, tahun, status_lunas)
        VALUES ('$penghuni_id','$bulan','$tahun','belum')
    ");

    header("Location: pembayaran.php");
    exit;
}

// Approve pembayaran
if(isset($_GET['approve'])){
    $id = $_GET['approve'];

    $koneksi->query("
        UPDATE pembayaran_bulanan 
        SET status_lunas='lunas', tanggal_bayar=NOW()
        WHERE id='$id'
    ");

    header("Location: pembayaran.php");
    exit;
}

// Ambil data pembayaran
$data = $koneksi->query("
SELECT pb.id, u.nama AS nama_penghuni, k.nama_kamar, pb.bulan, pb.tahun,
pb.status_lunas, pb.tanggal_bayar, pb.bukti
FROM pembayaran_bulanan pb
LEFT JOIN penghuni pn ON pb.penghuni_id = pn.id
LEFT JOIN users u ON pn.user_id = u.id_user
LEFT JOIN kamar k ON pn.kamar_id = k.id_kamar
ORDER BY pb.id DESC
");

// List penghuni
$penghuniList = $koneksi->query("
SELECT pn.id, u.nama, k.nama_kamar
FROM penghuni pn
JOIN users u ON pn.user_id=u.id_user
JOIN kamar k ON pn.kamar_id=k.id_kamar
");
?>
<html>
<head>
<title>Pembayaran Bulanan - Admin</title>
<style>
body {font-family: Arial; background: #f5f5f5; margin:0; padding:20px;}
.container {background:white; padding:20px; border-radius:10px; width:95%; margin:auto; box-shadow:0 0 10px #ccc;}
h2 {color:#0f7d34; text-align:center; margin-bottom:20px;}
table {width:100%; border-collapse:collapse; margin-top:20px;}
th {background:#0f7d34; color:white; padding:10px;}
td {padding:10px; border-bottom:1px solid #ddd;}
tr:nth-child(even) {background:#f9fff9;}
.status-box {padding:5px 10px; border-radius:4px; font-weight:bold; font-size:13px; text-transform:capitalize;}
.lunas {background:#d4edda; color:#155724;}
.belum {background:#f8d7da; color:#721c24;}
.btn-back {display:inline-block; padding:8px 14px; background:#0f7d34; color:white; text-decoration:none; border-radius:5px;}
.btn-back:hover {background:#065f22;}
</style>
</head>
<body>

<div class="container">
<h2>Pembayaran Bulanan - Admin</h2>

<a class="btn-back" href="dashboard.php">Kembali ke Dashboard</a>

<form method="POST" style="margin-top:20px;">
<select name="penghuni_id" required>
    <option value="">Pilih Penghuni</option>
    <?php while($p = $penghuniList->fetch_assoc()){ ?>
        <option value="<?= $p['id'] ?>"><?= $p['nama'] ?> - <?= $p['nama_kamar'] ?></option>
    <?php } ?>
</select>

<input type="number" name="bulan" min="1" max="12" placeholder="Bulan" required>
<input type="number" name="tahun" min="2023" max="2100" placeholder="Tahun" required>
<button type="submit" name="tambah_pembayaran">Tambah</button>
</form>

<table>
<tr>
<th>No</th>
<th>Penghuni</th>
<th>Kamar</th>
<th>Bulan</th>
<th>Tahun</th>
<th>Status</th>
<th>Tanggal Bayar</th>
<th>Bukti</th>
<th>Aksi</th>
</tr>

<?php
$no=1;
while($d=$data->fetch_assoc()){
    $statusClass = $d['status_lunas']=="lunas"?"lunas":"belum";
?>
<tr>
<td><?= $no++ ?></td>
<td><?= $d['nama_penghuni'] ?></td>
<td><?= $d['nama_kamar'] ?></td>
<td><?= $d['bulan'] ?></td>
<td><?= $d['tahun'] ?></td>
<td><span class="status-box <?= $statusClass ?>"><?= $d['status_lunas'] ?></span></td>
<td><?= $d['tanggal_bayar'] ?: '-' ?></td>
<td>
<?php if($d['bukti']) { ?>
<a href="../uploads/<?= $d['bukti'] ?>" target="_blank">Lihat</a>
<?php } else { echo '-'; } ?>
</td>
<td>
<?php if($d['status_lunas']=="belum" && $d['bukti']){ ?>
<a href="?approve=<?= $d['id'] ?>">Approve</a>
<?php } else { echo '-'; } ?>
</td>
</tr>
<?php } ?>
</table>
</div>
</body>
</html>
