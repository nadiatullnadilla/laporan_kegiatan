<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$pesan_error = "";

if (isset($_POST['simpan'])) {
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $tanggal       = $_POST['tanggal'];
    $tempat        = $_POST['tempat'];
    $jam           = $_POST['jam'];
    $username      = $_SESSION['username'];

    $folder_upload = "uploads/";
    if (!is_dir($folder_upload)) {
        mkdir($folder_upload, 0777, true);
    }

    $izin = ['pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg'];
    $max_file_size = 10 * 1024 * 1024; // 10 MB

    $query_laporan = mysqli_query($conn, "INSERT INTO laporan (nama_kegiatan, tanggal, tempat, jam)
                                          VALUES ('$nama_kegiatan', '$tanggal', '$tempat', '$jam')");

    if ($query_laporan) {
        $laporan_id = mysqli_insert_id($conn);

        if (!empty($_FILES['dokumen']['name'][0])) {
            foreach ($_FILES['dokumen']['name'] as $key => $nama_file) {
                if ($_FILES['dokumen']['error'][$key] == 0) {
                    $tmp      = $_FILES['dokumen']['tmp_name'][$key];
                    $size     = $_FILES['dokumen']['size'][$key];
                    $ekstensi = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

                    if (!in_array($ekstensi, $izin)) {
                        $pesan_error .= "File <b>$nama_file</b> gagal diupload karena format tidak diizinkan.<br>";
                        continue;
                    }

                    if ($size > $max_file_size) {
                        $pesan_error .= "File <b>$nama_file</b> gagal diupload karena ukuran melebihi 10 MB.<br>";
                        continue;
                    }

                    $nama_baru = time() . "_" . $key . "_" . basename($nama_file);

                    if (move_uploaded_file($tmp, $folder_upload . $nama_baru)) {
                        mysqli_query($conn, "INSERT INTO file_laporan (laporan_id, nama_file)
                                             VALUES ('$laporan_id', '$nama_baru')");
                    } else {
                        $pesan_error .= "File <b>$nama_file</b> gagal dipindahkan ke folder upload.<br>";
                    }
                }
            }
        }

        mysqli_query($conn, "INSERT INTO riwayat_aktivitas (username, aktivitas)
                             VALUES ('$username', 'Menambahkan laporan kegiatan')");

        if ($pesan_error == "") {
            echo "<script>alert('Data laporan berhasil disimpan'); window.location='kelola_laporan.php';</script>";
        } else {
            echo "<script>alert('Data laporan tersimpan, tetapi ada beberapa file yang gagal diupload.');</script>";
        }
    } else {
        $pesan_error = "Data laporan gagal disimpan.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Laporan</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #eef4ff, #f8fbff);
            color: #1f2937;
        }

        .topbar {
            background: rgba(255,255,255,0.92);
            border-bottom: 1px solid #e5e7eb;
            padding: 16px 24px;
        }

        .topbar-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand img {
            width: 52px;
            height: 52px;
            object-fit: contain;
            background: #fff;
            border-radius: 16px;
            padding: 8px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        .brand-text h2 {
            margin: 0;
            font-size: 20px;
        }

        .brand-text p {
            margin: 4px 0 0;
            font-size: 14px;
            color: #6b7280;
        }

        .btn-back {
            text-decoration: none;
            background: #e5edff;
            color: #0d6efd;
            padding: 11px 18px;
            border-radius: 12px;
            font-weight: bold;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 28px 20px 40px;
        }

        .hero {
            background: linear-gradient(135deg, #0d6efd, #0b57d0);
            color: white;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(13,110,253,0.18);
            margin-bottom: 24px;
        }

        .hero span {
            display: inline-block;
            background: rgba(255,255,255,0.18);
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 13px;
            margin-bottom: 14px;
        }

        .hero h1 {
            margin: 0 0 10px;
            font-size: 30px;
        }

        .hero p {
            margin: 0;
            color: #e8f1ff;
            line-height: 1.7;
        }

        .alert-error {
            background: #fff1f2;
            color: #b42318;
            border: 1px solid #fecdd3;
            padding: 16px;
            border-radius: 16px;
            margin-bottom: 18px;
            line-height: 1.7;
        }

        .form-card {
            background: rgba(255,255,255,0.95);
            border: 1px solid #e5e7eb;
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 14px 32px rgba(0,0,0,0.06);
        }

        .form-header h3 {
            margin: 0 0 8px;
            font-size: 24px;
        }

        .form-header p {
            margin: 0 0 24px;
            color: #6b7280;
            font-size: 14px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 14px;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"],
        input[type="file"] {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid #d1d5db;
            border-radius: 14px;
            font-size: 14px;
            background: #f9fafb;
            outline: none;
        }

        .upload-box {
            border: 2px dashed #bfdbfe;
            background: #f8fbff;
            border-radius: 18px;
            padding: 18px;
        }

        .upload-box small {
            display: block;
            margin-top: 10px;
            color: #6b7280;
            line-height: 1.6;
        }

        .actions {
            margin-top: 24px;
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn-submit {
            background: linear-gradient(135deg, #0d6efd, #0056b3);
            color: white;
            border: none;
            padding: 14px 22px;
            border-radius: 14px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-secondary {
            text-decoration: none;
            background: #eef2f7;
            color: #374151;
            padding: 14px 22px;
            border-radius: 14px;
            font-size: 15px;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .form-grid { grid-template-columns: 1fr; }
            .actions { flex-direction: column; }
            .btn-submit, .btn-secondary, .btn-back { width: 100%; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="topbar-inner">
            <div class="brand">
                <img src="assets/logo-gresik.png" alt="Logo Kabupaten Gresik">
                <div class="brand-text">
                    <h2>Input Laporan Kegiatan</h2>
                    <p>Kecamatan Bungah - Kabupaten Gresik</p>
                </div>
            </div>
            <a href="dashboard.php" class="btn-back">Kembali ke Dashboard</a>
        </div>
    </div>

    <div class="container">
        <div class="hero">
            <span>Form Input Data</span>
            <h1>Tambahkan laporan kegiatan baru</h1>
            <p>Isi data kegiatan dengan lengkap dan unggah dokumen pendukung agar laporan tersimpan rapi.</p>
        </div>

        <?php if (!empty($pesan_error)) { ?>
            <div class="alert-error"><?php echo $pesan_error; ?></div>
        <?php } ?>

        <div class="form-card">
            <div class="form-header">
                <h3>Form Laporan</h3>
                <p>Pastikan semua data sudah benar sebelum disimpan.</p>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group full">
                        <label>Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" placeholder="Masukkan nama kegiatan" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" required>
                    </div>

                    <div class="form-group">
                        <label>Jam</label>
                        <input type="time" name="jam" required>
                    </div>

                    <div class="form-group full">
                        <label>Tempat</label>
                        <input type="text" name="tempat" placeholder="Masukkan tempat kegiatan" required>
                    </div>

                    <div class="form-group full">
                        <label>Upload Dokumen / Gambar</label>
                        <div class="upload-box">
                            <input type="file" name="dokumen[]" multiple accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                            <small>Format: PDF, DOC, DOCX, PNG, JPG, JPEG. Maksimal 10 MB per file dan bisa unggah lebih dari satu file.</small>
                        </div>
                    </div>
                </div>

                <div class="actions">
                    <button type="submit" name="simpan" class="btn-submit">Simpan Laporan</button>
                    <a href="dashboard.php" class="btn-secondary">Batal / Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>