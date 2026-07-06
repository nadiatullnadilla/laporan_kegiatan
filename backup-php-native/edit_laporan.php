<?php
include 'session_login.php';
hanya_admin();
include 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: lihat_laporan.php");
    exit;
}

$id = (int) $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM laporan WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: lihat_laporan.php");
    exit;
}

$pesan = "";

if (isset($_POST['update'])) {
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $tempat = mysqli_real_escape_string($conn, $_POST['tempat']);
    $jam = mysqli_real_escape_string($conn, $_POST['jam']);
    $nama_kegiatan = mysqli_real_escape_string($conn, $_POST['nama_kegiatan']);

    $update = mysqli_query($conn, "
        UPDATE laporan 
        SET tanggal='$tanggal',
            tempat='$tempat',
            jam='$jam',
            nama_kegiatan='$nama_kegiatan'
        WHERE id=$id
    ");

    if ($update) {
        header("Location: lihat_laporan.php");
        exit;
    } else {
        $pesan = "Data gagal diperbarui.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laporan</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f8ff;
            color: #1f2937;
        }

        .container {
            max-width: 760px;
            margin: 40px auto;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        h1 {
            margin: 0 0 8px;
            font-size: 28px;
        }

        p {
            margin: 0 0 24px;
            color: #6b7280;
            font-size: 14px;
        }

        .error-box {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 14px;
            margin-bottom: 16px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
            color: #374151;
        }

        input[type="date"],
        input[type="time"],
        input[type="text"] {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #d1d5db;
            border-radius: 14px;
            font-size: 14px;
            background: #f9fafb;
            outline: none;
        }

        input:focus {
            border-color: #0d6efd;
            background: #fff;
        }

        .dokumen-box {
            background: #f9fafb;
            border: 1px dashed #d1d5db;
            padding: 14px;
            border-radius: 14px;
            font-size: 14px;
            color: #374151;
            margin-bottom: 18px;
        }

        .dokumen-box a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-area {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .btn {
            text-decoration: none;
            border: none;
            padding: 12px 18px;
            border-radius: 14px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-primary {
            background: #0d6efd;
            color: white;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Laporan</h1>
        <p>Ubah data laporan kegiatan sesuai kebutuhan.</p>

        <?php if ($pesan != "") { ?>
            <div class="error-box"><?php echo $pesan; ?></div>
        <?php } ?>

        <form method="POST">
            <div class="form-group">
                <label>Nama Kegiatan</label>
                <input type="text" name="nama_kegiatan" value="<?php echo htmlspecialchars($data['nama_kegiatan']); ?>" required>
            </div>

            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="<?php echo htmlspecialchars($data['tanggal']); ?>" required>
            </div>

            <div class="form-group">
                <label>Tempat</label>
                <input type="text" name="tempat" value="<?php echo htmlspecialchars($data['tempat']); ?>" required>
            </div>

            <div class="form-group">
                <label>Jam</label>
                <input type="time" name="jam" value="<?php echo htmlspecialchars($data['jam']); ?>" required>
            </div>

            <div class="dokumen-box">
                Dokumen saat ini:
                <?php if (!empty($data['dokumen'])) { ?>
                    <a href="uploads/<?php echo htmlspecialchars($data['dokumen']); ?>" target="_blank">
                        <?php echo htmlspecialchars($data['dokumen']); ?>
                    </a>
                <?php } else { ?>
                    Tidak ada dokumen.
                <?php } ?>
            </div>

            <div class="btn-area">
                <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                <a href="lihat_laporan.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>