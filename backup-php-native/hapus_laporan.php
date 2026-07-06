<?php
include 'session_login.php';
hanya_admin();
include 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: lihat_laporan.php");
    exit;
}

$id = (int) $_GET['id'];

mysqli_query($conn, "DELETE FROM laporan WHERE id = $id");

header("Location: lihat_laporan.php");
exit;
?>