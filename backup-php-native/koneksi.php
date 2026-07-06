<?php
$conn = mysqli_connect("localhost", "root", "", "laporan_kegiatan");

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>