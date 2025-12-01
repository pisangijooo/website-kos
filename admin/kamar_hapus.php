<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login_admin.php");
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: kamar.php?msg=invalid");
    exit;
}

$stmt = $koneksi->prepare("DELETE FROM kamar WHERE id_kamar = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: kamar.php?msg=deleted");
} else {
    header("Location: kamar.php?msg=notfound");
}

$stmt->close();
exit;
?>
