<?php
session_start();
include '../config/koneksi.php';

if (empty($_SESSION['user_logged_in'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_logged_in'];

$query = "
    SELECT p.id, k.nama_kamar, k.harga, p.tanggal_pengajuan, p.status
    FROM pengajuan_sewa p
    JOIN kamar k ON p.kamar_id = k.id_kamar
    WHERE p.user_id = '$user_id'
    ORDER BY p.tanggal_pengajuan DESC
";
$result = mysqli_query($koneksi, $query);
?>
<html>
<head>
    <title>Riwayat Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {font-family:Poppins,sans-serif;margin:0;padding:0;background:#f8f9fa;}
        .navbar {background:#059669;padding:15px;color:white;display:flex;justify-content:space-between;align-items:center;}
        .navbar a {color:white;text-decoration:none;margin-left:18px;}
        .navbar .brand {font-size:20px;font-weight:600;}

        .container {max-width:900px;margin:40px auto;padding:20px;}
        h2 {text-align:center;color:#065f46;font-weight:600;margin-bottom:20px;}

        table {width:100%;border-collapse:collapse;background:white;box-shadow:0 4px 10px rgba(0,0,0,0.08);border-radius:8px;overflow:hidden;}
        th {background:#10b981;color:white;padding:12px;text-align:left;}
        td {padding:12px;border-bottom:1px solid #e5e7eb;}
        tr:last-child td {border-bottom:none;}
        tr:nth-child(even) {background:#f0fdf4;}

        .status-box {padding:5px 10px;border-radius:6px;font-weight:500;font-size:13px;text-transform:capitalize;display:inline-block;}
        .pending {background:#fff3cd;color:#856404;}
        .diterima {background:#d4edda;color:#155724;}
        .ditolak {background:#f8d7da;color:#721c24;}

        .back {display:inline-block;margin-top:20px;padding:10px 14px;background:#059669;color:white;text-decoration:none;border-radius:6px;}
        .back:hover {background:#047857;}
    </style>
</head>
<body>

<div class="navbar">
    <div class="brand">Kos Pisang Ijo</div>
    <div>
        <a href="index_user.php">Dashboard</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Riwayat Booking</h2>

    <table>
        <tr>
            <th>Kamar</th>
            <th>Harga</th>
            <th>Tanggal Pengajuan</th>
            <th>Status</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) { 
            $statusClass = "pending";
            if ($row['status'] == "diterima") $statusClass = "diterima";
            if ($row['status'] == "ditolak") $statusClass = "ditolak";
        ?>
        <tr>
            <td><?= htmlspecialchars($row['nama_kamar']); ?></td>
            <td>Rp <?= number_format($row['harga']); ?></td>
            <td><?= htmlspecialchars($row['tanggal_pengajuan']); ?></td>
            <td><span class="status-box <?= $statusClass ?>"><?= htmlspecialchars($row['status']); ?></span></td>
        </tr>
        <?php } ?>
    </table>

    <a class="back" href="index_user.php">Kembali ke Dashboard</a>
</div>

</body>
</html>
