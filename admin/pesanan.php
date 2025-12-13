<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login_admin.php");
    exit;
}

// Ambil data pengajuan sewa + ktp
$data = $koneksi->query("
    SELECT 
        p.id,
        p.tanggal_pengajuan,
        p.status,
        p.ktp,
        k.nama_kamar,
        u.nama AS nama_penghuni
    FROM pengajuan_sewa p
    LEFT JOIN kamar k ON p.kamar_id = k.id_kamar
    LEFT JOIN users u ON p.user_id = u.id_user
    ORDER BY p.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Pengajuan Sewa</title>
<style>
body {
    font-family: Arial;
    background: #f5f5f5;
    margin: 0;
    padding: 20px;
}
.container {
    background: white;
    padding: 20px;
    border-radius: 10px;
    width: 95%;
    margin: auto;
    box-shadow: 0 0 10px #ccc;
}
h2 {
    color: #0f7d34;
    text-align: center;
    margin-bottom: 20px;
}
.btn-back {
    text-decoration: none;
    padding: 10px 14px;
    background: #0f7d34;
    color: white;
    border-radius: 5px;
    font-size: 14px;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: white;
}
th {
    background: #0f7d34;
    color: white;
    padding: 10px;
    font-size: 14px;
}
td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    font-size: 14px;
}
tr:nth-child(even) {
    background: #f9fff9;
}
.aksi a {
    color: #0f7d34;
    text-decoration: none;
    margin-right: 8px;
    font-weight: bold;
}
.aksi a:hover {
    text-decoration: underline;
}
.status-box {
    padding: 5px 10px;
    border-radius: 4px;
    font-weight: bold;
    font-size: 13px;
    text-transform: capitalize;
}
.pending { background: #fff3cd; color: #856404; }
.diterima { background: #d4edda; color: #155724; }
.ditolak { background: #f8d7da; color: #721c24; }
.btn-ktp {
    padding: 6px 10px;
    background: #0f7d34;
    color: white;
    border-radius: 4px;
    text-decoration: none;
    font-size: 12px;
}
.btn-ktp:hover {
    background: #0c5e28;
}
</style>
</head>

<body>

<div class="container">

    <a href="dashboard.php" class="btn-back">Kembali ke Dashboard</a>

    <h2>Pengajuan Sewa</h2>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kamar</th>
            <th>Tanggal</th>
            <th>KTP</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while ($d = $data->fetch_assoc()) {
            $statusClass = "pending";
            if ($d['status'] == "diterima") $statusClass = "diterima";
            if ($d['status'] == "ditolak") $statusClass = "ditolak";
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($d['nama_penghuni']); ?></td>
            <td><?= htmlspecialchars($d['nama_kamar']); ?></td>
            <td><?= $d['tanggal_pengajuan']; ?></td>

            <td>
                <?php if (!empty($d['ktp'])) { ?>
                    <a class="btn-ktp" href="../uploads/ktp/<?= $d['ktp']; ?>" target="_blank">
                        Lihat KTP
                    </a>
                <?php } else { echo "-"; } ?>
            </td>

            <td>
                <span class="status-box <?= $statusClass; ?>">
                    <?= $d['status']; ?>
                </span>
            </td>

            <td class="aksi">
                <?php if($d['status'] == 'pending'){ ?>
                    <a href="pesanan_setuju.php?id=<?= $d['id']; ?>">Setujui</a>
                    <a href="pesanan_tolak.php?id=<?= $d['id']; ?>">Tolak</a>
                <?php } else { echo "-"; } ?>
            </td>
        </tr>
        <?php } ?>

    </table>

</div>

</body>
</html>
