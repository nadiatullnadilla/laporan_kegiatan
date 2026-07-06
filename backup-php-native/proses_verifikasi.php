<?php
include 'session_login.php';
hanya_verifikator();
include 'koneksi.php';

if (!isset($_GET['id']) || !isset($_GET['aksi'])) {
    header("Location: verifikasi_laporan.php");
    exit;
}

$id = (int) $_GET['id'];
$aksi = $_GET['aksi'];

if ($aksi == 'setujui') {
    $status = 'disetujui';
} elseif ($aksi == 'revisi') {
    $status = 'revisi';
} else {
    header("Location: verifikasi_laporan.php");
    exit;
}

mysqli_query($conn, "UPDATE laporan SET status='$status' WHERE id=$id");

header("Location: verifikasi_laporan.php");
exit;
?>