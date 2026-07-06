<?php
include 'session_login.php';
hanya_verifikator();
include 'koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM laporan ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Laporan</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f8ff;
            color: #1f2937;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 230px;
            background: linear-gradient(180deg, #0d6efd, #0b57d0);
            color: white;
            padding: 22px 16px;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .brand {
            text-align: center;
            padding-bottom: 18px;
            border-bottom: 1px solid rgba(255,255,255,0.18);
        }

        .brand h2 {
            margin: 0;
            font-size: 18px;
        }

        .brand p {
            margin: 6px 0 0;
            font-size: 12px;
            color: #dbeafe;
            line-height: 1.5;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu a {
            text-decoration: none;
            color: white;
            background: rgba(255,255,255,0.10);
            padding: 12px 14px;
            border-radius: 14px;
            font-size: 14px;
            font-weight: bold;
        }

        .menu a.active {
            background: rgba(255,255,255,0.26);
        }

        .logout {
            margin-top: auto;
            text-decoration: none;
            background: #ef4444;
            color: white;
            padding: 12px 14px;
            border-radius: 14px;
            text-align: center;
            font-weight: bold;
        }

        .main {
            flex: 1;
            padding: 28px;
        }

        .topbar {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 18px 22px;
            margin-bottom: 22px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .topbar h1 {
            margin: 0 0 6px;
            font-size: 24px;
        }

        .topbar p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .table-box {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 20px;
            overflow-x: auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px 14px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            font-size: 14px;
            vertical-align: middle;
        }

        table th {
            background: #f9fafb;
            color: #374151;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            text-transform: capitalize;
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

        .aksi a {
            text-decoration: none;
            padding: 8px 10px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: bold;
            margin-right: 6px;
            display: inline-block;
        }

        .setujui {
            background: #16a34a;
            color: white;
        }

        .revisi-btn {
            background: #dc2626;
            color: white;
        }

        .dokumen-link {
            color: #0d6efd;
            text-decoration: none;
            font-weight: bold;
        }

        .kosong {
            text-align: center;
            color: #6b7280;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand">
                <h2>Sistem Laporan</h2>
                <p>Kecamatan Bungah<br>Kabupaten Gresik</p>
            </div>

            <div class="menu">
                <a href="dashboard.php">Dashboard</a>
                <a href="verifikasi_laporan.php" class="active">Verifikasi Laporan</a>
                <a href="lihat_laporan.php">Lihat Laporan</a>
                <a href="riwayat.php">Riwayat Aktivitas</a>
            </div>

            <a class="logout" href="logout.php">Logout</a>
        </aside>

        <main class="main">
            <div class="topbar">
                <h1>Verifikasi Laporan</h1>
                <p>Halaman untuk meninjau dan mengubah status laporan kegiatan.</p>
            </div>

            <div class="table-box">
                <table>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Tempat</th>
                        <th>Jam</th>
                        <th>Dokumen</th>
                        <th>Status</th>
                        <th>Aksi</th>
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
                                    <a class="dokumen-link" href="uploads/<?php echo htmlspecialchars($row['dokumen']); ?>" target="_blank">Lihat File</a>
                                <?php } else { ?>
                                    -
                                <?php } ?>
                            </td>
                            <td>
                                <span class="badge <?php echo htmlspecialchars($row['status']); ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </td>
                            <td class="aksi">
                                <a class="setujui" href="proses_verifikasi.php?id=<?php echo $row['id']; ?>&aksi=setujui" onclick="return confirm('Setujui laporan ini?')">Setujui</a>
                                <a class="revisi-btn" href="proses_verifikasi.php?id=<?php echo $row['id']; ?>&aksi=revisi" onclick="return confirm('Ubah status menjadi revisi?')">Revisi</a>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="8" class="kosong">Belum ada laporan yang tersedia.</td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </main>
    </div>
</body>
</html>