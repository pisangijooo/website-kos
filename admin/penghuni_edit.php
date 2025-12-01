<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login_admin.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: penghuni.php?msg=missing_id");
    exit;
}

$id_penghuni = $_GET['id'];

// Ambil data penghuni beserta user dan kamar
$data = mysqli_query($koneksi, "
    SELECT pn.id AS id_penghuni, pn.kamar_id, u.id_user, u.nama AS nama_user, u.no_hp, k.id_kamar, k.nama_kamar
    FROM penghuni pn
    LEFT JOIN users u ON pn.user_id = u.id_user
    LEFT JOIN kamar k ON pn.kamar_id = k.id_kamar
    WHERE pn.id='$id_penghuni'
");
$p = mysqli_fetch_assoc($data);

if (!$p) {
    echo "Data penghuni tidak ditemukan.";
    exit;
}

// Ambil daftar kamar
$kamar_list = mysqli_query($koneksi, "SELECT * FROM kamar");

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $nohp = mysqli_real_escape_string($koneksi, $_POST['nohp']);
    $kamar_baru = $_POST['kamar'];

    // Update tabel users
    mysqli_query($koneksi, "UPDATE users SET nama='$nama', no_hp='$nohp' WHERE id_user='".$p['id_user']."'");

    // Update kamar jika berbeda
    if ($kamar_baru != $p['kamar_id']) {
        // Kosongkan kamar lama
        mysqli_query($koneksi, "UPDATE kamar SET status='kosong' WHERE id_kamar='".$p['kamar_id']."'");
        // Set kamar baru jadi terisi
        mysqli_query($koneksi, "UPDATE kamar SET status='terisi' WHERE id_kamar='$kamar_baru'");
        // Update penghuni
        mysqli_query($koneksi, "UPDATE penghuni SET kamar_id='$kamar_baru' WHERE id='$id_penghuni'");
    }

    header("Location: penghuni.php?msg=updated");
    exit;
}
?>
<html>
<body>

<h2>Edit Penghuni</h2>

<form method="POST">
    Nama
    <input type="text" name="nama" value="<?php echo htmlspecialchars($p['nama_user']); ?>" required>

    No HP
    <input type="text" name="nohp" value="<?php echo htmlspecialchars($p['no_hp']); ?>" required>

    Pilih Kamar
    <select name="kamar" required>
        <?php while ($k = mysqli_fetch_assoc($kamar_list)) { ?>
            <option value="<?php echo $k['id_kamar']; ?>" <?php if ($k['id_kamar']==$p['kamar_id']) echo 'selected'; ?>>
                <?php echo $k['nama_kamar']; ?> (<?php echo $k['status']; ?>)
            </option>
        <?php } ?>
    </select>

    <br><br>
    <button type="submit" name="update">Update</button>
</form>

<a href="penghuni.php">Kembali</a>

</body>
</html>
