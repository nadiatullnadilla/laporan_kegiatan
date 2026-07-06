<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$cari = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : "";

$query = "SELECT * FROM laporan";
if (!empty($cari)) {
    $query .= " WHERE nama_kegiatan LIKE '%$cari%' 
                OR tempat LIKE '%$cari%' 
                OR tanggal LIKE '%$cari%' 
                OR jam LIKE '%$cari%'";
}
$query .= " ORDER BY id DESC";
$data = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Laporan</title>
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
            max-width: 1200px;
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
            color: #111827;
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
            padding: 10px 16px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 13px;
        }

        .container {
            max-width: 1200px;
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

        .search-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            margin-bottom: 22px;
        }

        .search-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .search-form input[type="text"] {
            flex: 1;
            min-width: 220px;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            background: #f9fafb;
            font-size: 13px;
            outline: none;
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            border: none;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 12px;
            line-height: 1.2;
            transition: 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d6efd, #0056b3);
            color: white;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-edit {
            background: #10b981;
            color: white;
        }

        .btn-hapus {
            background: #ef4444;
            color: white;
        }

        .table-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 22px;
            padding: 18px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        th, td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #eef2f7;
            vertical-align: top;
            font-size: 14px;
        }

        th {
            background: #f8fbff;
            color: #374151;
        }

        tr:hover {
            background: #f9fbff;
        }

        .file-badge {
            display: inline-block;
            background: #eef4ff;
            color: #0d6efd;
            padding: 6px 10px;
            border-radius: 10px;
            font-size: 11px;
            margin: 4px 6px 0 0;
            word-break: break-word;
        }

        .aksi {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .kosong {
            text-align: center;
            padding: 24px;
            color: #6b7280;
        }

        @media (max-width: 768px) {
            .btn-back {
                width: 100%;
                text-align: center;
            }

            .aksi {
                flex-direction: column;
            }

            .search-form {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>
<body>

    <div class="topbar">
        <div class="topbar-inner">
            <div class="brand">
                <img src="assets/logo-gresik.png" alt="Logo Kabupaten Gresik">
                <div class="brand-text">
                    <h2>Kelola Laporan</h2>
                    <p>Kecamatan Bungah - Kabupaten Gresik</p>
                </div>
            </div>
            <a class="btn-back" href="dashboard.php">Kembali ke Dashboard</a>
        </div>
    </div>

    <div class="container">
        <div class="hero">
            <span>Manajemen Data</span>
            <h1>Kelola data laporan kegiatan</h1>
            <p>
                Cari, edit, hapus, dan tinjau laporan kegiatan dengan tampilan yang lebih ringkas,
                rapi, dan nyaman digunakan.
            </p>
        </div>

        <div class="search-card">
            <form method="GET" class="search-form">
                <input type="text" name="cari" placeholder="Cari nama kegiatan, tempat, tanggal, atau jam..." value="<?php echo htmlspecialchars($cari); ?>">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="kelola_laporan.php" class="btn btn-danger">Reset</a>
            </form>
        </div>

        <div class="table-card">
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Kegiatan</th>
                    <th>Tanggal</th>
                    <th>Tempat</th>
                    <th>Jam</th>
                    <th>Dokumen</th>
                    <th>Aksi</th>
                </tr>

                <?php
                if (mysqli_num_rows($data) > 0) {
                    $no = 1;
                    while ($d = mysqli_fetch_assoc($data)) {
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($d['nama_kegiatan']); ?></td>
                    <td><?php echo htmlspecialchars($d['tanggal']); ?></td>
                    <td><?php echo htmlspecialchars($d['tempat']); ?></td>
                    <td><?php echo htmlspecialchars($d['jam']); ?></td>
                    <td>
                        <?php
                        $id_laporan = $d['id'];
                        $file_query = mysqli_query($conn, "SELECT * FROM file_laporan WHERE laporan_id='$id_laporan'");
                        if (mysqli_num_rows($file_query) > 0) {
                            while ($file = mysqli_fetch_assoc($file_query)) {
                                echo "<span class='file-badge'>" . htmlspecialchars($file['nama_file']) . "</span>";
                            }
                        } else {
                            echo "<span class='file-badge'>Tidak ada file</span>";
                        }
                        ?>
                    </td>
                    <td>
                        <div class="aksi">
                            <a class="btn btn-edit" href="edit_laporan.php?id=<?php echo $d['id']; ?>">Edit</a>
                            <a class="btn btn-hapus" href="hapus_laporan.php?id=<?php echo $d['id']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </div>
                    </td>
                </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='7' class='kosong'>Data laporan tidak ditemukan</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

</body>
</html>