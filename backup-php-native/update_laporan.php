<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['update'])) {
    $id            = $_POST['id'];
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $tanggal       = $_POST['tanggal'];
    $tempat        = $_POST['tempat'];
    $jam           = $_POST['jam'];
    $username      = $_SESSION['username'];

    $query = mysqli_query($conn, "UPDATE laporan SET
                    nama_kegiatan='$nama_kegiatan',
                    tanggal='$tanggal',
                    tempat='$tempat',
                    jam='$jam'
                    WHERE id='$id'");

    $folder_upload = "uploads/";
    if (!is_dir($folder_upload)) {
        mkdir($folder_upload, 0777, true);
    }

    $izin = ['pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg'];

    if (!empty($_FILES['dokumen']['name'][0])) {
        foreach ($_FILES['dokumen']['name'] as $key => $nama_file) {
            if ($_FILES['dokumen']['error'][$key] === 0) {
                $tmp      = $_FILES['dokumen']['tmp_name'][$key];
                $size     = $_FILES['dokumen']['size'][$key];
                $ekstensi = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

                if (in_array($ekstensi, $izin) && $size <= 5000000) {
                    $nama_baru = time() . "_" . $key . "_" . basename($nama_file);

                    if (move_uploaded_file($tmp, $folder_upload . $nama_baru)) {
                        mysqli_query($conn, "INSERT INTO file_laporan (laporan_id, nama_file)
                                             VALUES ('$id', '$nama_baru')");
                    }
                }
            }
        }
    }

    if ($query) {
        mysqli_query($conn, "INSERT INTO riwayat_aktivitas (username, aktivitas) 
                             VALUES ('$username', 'Mengedit laporan kegiatan')");

        echo "<script>
                alert('Data berhasil diedit');
                window.location='kelola_laporan.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Data gagal diupdate');
                window.location='kelola_laporan.php';
              </script>";
        exit;
    }
}
?>