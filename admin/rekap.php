<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login_admin.php");
    exit;
}

$data = $koneksi->query("
SELECT 
    pb.id,
    u.nama AS nama_penghuni,
    k.nama_kamar,
    k.harga AS nominal,
    pb.bulan,
    pb.tahun,
    pb.status_lunas AS status,
    pb.tanggal_bayar
FROM pembayaran_bulanan pb
LEFT JOIN penghuni pn ON pb.penghuni_id = pn.id
LEFT JOIN users u ON pn.user_id = u.id_user
LEFT JOIN kamar k ON pn.kamar_id = k.id_kamar
ORDER BY pb.id DESC
");
?>
<html>
<head>
<title>Rekap Pembayaran</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
<style>
body {font-family:Poppins,sans-serif;margin:0;padding:20px;background:#f8f9fa;}
h2 {color:#065f46;margin-bottom:18px;}
a {text-decoration:none;color:#065f46;margin-bottom:15px;display:inline-block;}
table {width:100%;border-collapse:collapse;background:white;border-radius:12px;overflow:hidden;box-shadow:0 3px 12px rgba(0,0,0,0.08);}
th {background:#10b981;color:white;padding:12px;font-size:14px;text-align:left;}
td {padding:12px;font-size:14px;color:#333;border-bottom:1px solid #e5e7eb;}
tr:nth-child(even) {background:#e6f4ea;}
.status-box {padding:5px 10px;border-radius:4px;font-weight:bold;font-size:13px;text-transform:capitalize;}
.lunas {background:#d4edda;color:#155724;}
.belum {background:#f8d7da;color:#721c24;}
</style>
</head>
<body>

<h2>Rekap Pembayaran</h2>
<a href="dashboard.php">Dashboard</a>
<br><br>

<table>
<tr>
    <th>No</th>
    <th>Penghuni</th>
    <th>Kamar</th>
    <th>Bulan</th>
    <th>Nominal</th>
    <th>Status</th>
</tr>

<?php
$no = 1;
while ($d = $data->fetch_assoc()) {
    $statusClass = $d['status'] == "lunas" ? "lunas" : "belum";
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= htmlspecialchars($d['nama_penghuni']); ?></td>
    <td><?= htmlspecialchars($d['nama_kamar']); ?></td>
    <td><?= $d['bulan']; ?>/<?= $d['tahun']; ?></td>
    <td><?= number_format($d['nominal']); ?></td>
    <td><span class="status-box <?= $statusClass; ?>"><?= ucfirst($d['status']); ?></span></td>
</tr>
<?php } ?>

</table>

</body>
</html>
