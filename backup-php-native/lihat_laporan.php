<?php
include 'session_login.php';
admin_atau_verifikator();
include 'koneksi.php';

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

$sql = "SELECT * FROM laporan";
if ($keyword != '') {
    $keyword_aman = mysqli_real_escape_string($conn, $keyword);
    $sql .= " WHERE nama_kegiatan LIKE '%$keyword_aman%' 
              OR tempat LIKE '%$keyword_aman%' 
              OR tanggal LIKE '%$keyword_aman%' 
              OR jam LIKE '%$keyword_aman%'
              OR status LIKE '%$keyword_aman%'";
}
$sql .= " ORDER BY id DESC";

$query = mysqli_query($conn, $sql);
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Laporan</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #edf2fb;
            color: #1f2937;
        }

        .top-header {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 22px 48px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .top-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logo-box {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: #fff8dc;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .logo-box img {
            width: 38px;
            height: 38px;
            object-fit: contain;
        }

        .title-wrap h1 {
            margin: 0;
            font-size: 20px;
            color: #111827;
        }

        .title-wrap p {
            margin: 4px 0 0;
            font-size: 14px;
            color: #6b7280;
        }

        .btn-dashboard {
            text-decoration: none;
            background: #eef4ff;
            color: #0d6efd;
            padding: 12px 16px;
            border-radius: 14px;
            font-weight: bold;
            font-size: 14px;
            display: inline-block;
        }

        .container {
            max-width: 1220px;
            margin: 28px auto;
            padding: 0 30px 32px;
        }

        .hero {
            background: linear-gradient(135deg, #1f7cff, #155ad6);
            border-radius: 24px;
            padding: 30px;
            color: white;
            margin-bottom: 24px;
            box-shadow: 0 14px 35px rgba(13, 110, 253, 0.24);
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.16);
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 13px;
            margin-bottom: 14px;
        }

        .hero h2 {
            margin: 0 0 10px;
            font-size: 24px;
        }

        .hero p {
            margin: 0;
            color: #e8f1ff;
            font-size: 15px;
            line-height: 1.7;
            max-width: 760px;
        }

        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 22px;
            padding: 16px;
            margin-bottom: 22px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.04);
        }

        .search-form {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-form input {
            flex: 1;
            min-width: 250px;
            height: 44px;
            border: 1px solid #d1d5db;
            border-radius: 14px;
            padding: 0 14px;
            font-size: 14px;
            outline: none;
            background: #f9fafb;
        }

        .btn {
            border: none;
            height: 44px;
            padding: 0 16px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-search {
            background: #0d6efd;
            color: white;
        }

        .btn-reset {
            background: #ef4444;
            color: white;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 14px 16px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            font-size: 14px;
            vertical-align: middle;
        }

        table th {
            background: #f9fafb;
            color: #374151;
            font-size: 15px;
        }

        .file-link {
            text-decoration: none;
            background: #eef2ff;
            color: #2563eb;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            display: inline-block;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            text-transform: lowercase;
        }

        .menunggu {
            background: #fef3c7;
            color: #92400e;
        }

        .disetujui {
            background: #dcfce7;
            color: #166534;
        }

        .revisi {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty {
            text-align: center;
            padding: 24px;
            color: #6b7280;
        }

        @media (max-width: 768px) {
            .top-header {
                padding: 20px;
            }

            .container {
                padding: 0 16px 24px;
            }

            .hero {
                padding: 22px;
            }

            .hero h2 {
                font-size: 22px;
            }

            .search-form {
                flex-direction: column;
                align-items: stretch;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="top-header">
        <div class="top-left">
            <div class="logo-box">
               <img src="assets/logo-gresik.png" alt="Logo Kecamatan">
            </div>
            <div class="title-wrap">
                <h1>Lihat Laporan</h1>
                <p>Kecamatan Bungah - Kabupaten Gresik</p>
            </div>
        </div>

        <a href="dashboard.php" class="btn-dashboard">Kembali ke Dashboard</a>
    </div>

    <div class="container">
        <div class="hero">
            <span class="hero-badge">Data Laporan</span>
            <h2>Lihat data laporan kegiatan</h2>
            <p>
                Tinjau seluruh laporan kegiatan yang sudah masuk dengan tampilan yang lebih ringkas,
                rapi, dan mudah dibaca.
            </p>
        </div>

        <div class="card">
            <form method="GET" class="search-form">
                <input type="text" name="keyword" placeholder="Cari nama kegiatan, tempat, tanggal, atau jam..." value="<?php echo htmlspecialchars($keyword); ?>">
                <button type="submit" class="btn btn-search">Cari</button>
                <a href="lihat_laporan.php" class="btn btn-reset">Reset</a>
            </form>
        </div>

        <div class="card">
            <div class="table-wrap">
                <table>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Tempat</th>
                        <th>Jam</th>
                        <th>Dokumen</th>
                        <th>Status</th>
                    </tr>

                    <?php if (mysqli_num_rows($query) > 0) { ?>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['nama_kegiatan']); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                            <td><?php echo htmlspecialchars($row['tempat']); ?></td>
                            <td><?php echo htmlspecialchars($row['jam']); ?></td>
                            <td>
                                <?php if (!empty($row['dokumen'])) { ?>
                                    <a class="file-link" href="uploads/<?php echo htmlspecialchars($row['dokumen']); ?>" target="_blank">
                                        <?php echo htmlspecialchars($row['dokumen']); ?>
                                    </a>
                                <?php } else { ?>
                                    -
                                <?php } ?>
                            </td>
                            <td>
                                <span class="badge <?php echo htmlspecialchars($row['status']); ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="7" class="empty">Tidak ada data laporan.</td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

</body>
</html>