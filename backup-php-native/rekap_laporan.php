<?php
include 'session_login.php';
admin_atau_verifikator();
include 'koneksi.php';

$role = $_SESSION['role'];
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

$sql = "SELECT * FROM laporan";
if ($filter_status != '' && in_array($filter_status, ['menunggu', 'disetujui', 'revisi'])) {
    $sql .= " WHERE status = '$filter_status'";
}
$sql .= " ORDER BY tanggal DESC, id DESC";

$query = mysqli_query($conn, $sql);

$q_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM laporan");
$total = mysqli_fetch_assoc($q_total)['total'];

$q_menunggu = mysqli_query($conn, "SELECT COUNT(*) AS total FROM laporan WHERE status='menunggu'");
$total_menunggu = mysqli_fetch_assoc($q_menunggu)['total'];

$q_disetujui = mysqli_query($conn, "SELECT COUNT(*) AS total FROM laporan WHERE status='disetujui'");
$total_disetujui = mysqli_fetch_assoc($q_disetujui)['total'];

$q_revisi = mysqli_query($conn, "SELECT COUNT(*) AS total FROM laporan WHERE status='revisi'");
$total_revisi = mysqli_fetch_assoc($q_revisi)['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Laporan</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
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

        .menu-title {
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #dbeafe;
            margin: 4px 0 2px;
            padding-left: 8px;
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
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
        }

        .menu a.active {
            background: rgba(255,255,255,0.24);
        }

        .logout {
            margin-top: auto;
            text-decoration: none;
            background: #ef4444;
            color: white;
            padding: 12px 14px;
            border-radius: 12px;
            text-align: center;
            font-weight: 600;
        }

        .main {
            flex: 1;
            padding: 22px;
        }

        .topbar,
        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        }

        .topbar {
            padding: 16px 20px;
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 14px;
            flex-wrap: wrap;
        }

        .topbar h1 {
            margin: 0 0 4px;
            font-size: 22px;
        }

        .topbar p {
            margin: 0;
            font-size: 14px;
            color: #6b7280;
        }

        .user-badge {
            background: #eef4ff;
            color: #0d6efd;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }

        .card {
            padding: 18px;
            margin-bottom: 16px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
        }

        .stat-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 16px 18px;
        }

        .stat-box span {
            display: block;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .stat-box h3 {
            margin: 0;
            font-size: 22px;
            color: #111827;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 14px;
            flex-wrap: wrap;
        }

        .filter-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .filter-group label {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }

        .filter-group select {
            height: 42px;
            min-width: 220px;
            padding: 0 12px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            background: #f9fafb;
            font-size: 14px;
            outline: none;
        }

        .button-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .btn {
            height: 42px;
            padding: 0 16px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .btn-primary {
            background: #0d6efd;
            color: white;
        }

        .btn-light {
            background: #eef2f7;
            color: #111827;
        }

        .btn-print {
            background: #7c3aed;
            color: white;
        }

        .btn-word {
            background: #10b981;
            color: white;
        }

        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }

        .section-head h3 {
            margin: 0;
            font-size: 18px;
        }

        .section-head p {
            margin: 0;
            font-size: 14px;
            color: #6b7280;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            font-size: 14px;
            vertical-align: middle;
        }

        table th {
            background: #f9fafb;
            color: #374151;
            font-weight: 700;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
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

        .empty {
            text-align: center;
            padding: 20px;
            color: #6b7280;
        }

        @media print {
            .sidebar,
            .topbar,
            .toolbar {
                display: none !important;
            }

            .main {
                padding: 0;
            }

            .card {
                box-shadow: none;
                border: 1px solid #d1d5db;
            }

            body {
                background: white;
            }
        }

        @media (max-width: 768px) {
            .layout {
                display: block;
            }

            .sidebar {
                width: 100%;
            }

            .main {
                padding: 16px;
            }

            .toolbar {
                align-items: stretch;
            }

            .button-group {
                width: 100%;
            }

            .btn {
                width: 100%;
            }
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

            <div class="menu-title">Menu Utama</div>
            <div class="menu">
                <a href="dashboard.php">Dashboard</a>

                <?php if ($role == 'admin') { ?>
                    <a href="input_laporan.php">Input Laporan</a>
                    <a href="kelola_laporan.php">Kelola Laporan</a>
                    <a href="lihat_laporan.php">Lihat Laporan</a>
                    <a href="rekap_laporan.php" class="active">Rekap Laporan</a>
                <?php } ?>

                <?php if ($role == 'verifikator') { ?>
                    <a href="verifikasi_laporan.php">Verifikasi Laporan</a>
                    <a href="lihat_laporan.php">Lihat Laporan</a>
                    <a href="rekap_laporan.php" class="active">Rekap Laporan</a>
                    <a href="riwayat.php">Riwayat Aktivitas</a>
                <?php } ?>
            </div>

            <a class="logout" href="logout.php">Logout</a>
        </aside>

        <main class="main">
            <div class="topbar">
                <div>
                    <h1>Rekap Laporan</h1>
                    <p>Ringkasan laporan yang bisa difilter, dicetak, dan diexport.</p>
                </div>
                <div class="user-badge">
                    User: <?php echo htmlspecialchars($_SESSION['username']); ?> | Role: <?php echo htmlspecialchars($_SESSION['role']); ?>
                </div>
            </div>

            <div class="card">
                <div class="stats-grid">
                    <div class="stat-box">
                        <span>Total Laporan</span>
                        <h3><?php echo $total; ?></h3>
                    </div>
                    <div class="stat-box">
                        <span>Menunggu</span>
                        <h3><?php echo $total_menunggu; ?></h3>
                    </div>
                    <div class="stat-box">
                        <span>Disetujui</span>
                        <h3><?php echo $total_disetujui; ?></h3>
                    </div>
                    <div class="stat-box">
                        <span>Revisi</span>
                        <h3><?php echo $total_revisi; ?></h3>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="toolbar">
                    <form method="GET" class="filter-form">
                        <div class="filter-group">
                            <label>Filter Status</label>
                            <select name="status">
                                <option value="">Semua Status</option>
                                <option value="menunggu" <?php echo ($filter_status == 'menunggu') ? 'selected' : ''; ?>>Menunggu</option>
                                <option value="disetujui" <?php echo ($filter_status == 'disetujui') ? 'selected' : ''; ?>>Disetujui</option>
                                <option value="revisi" <?php echo ($filter_status == 'revisi') ? 'selected' : ''; ?>>Revisi</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Terapkan</button>
                        <a href="rekap_laporan.php" class="btn btn-light">Reset</a>
                    </form>

                    <div class="button-group">
                        <a href="dashboard.php" class="btn btn-light">Kembali</a>
                        <button onclick="window.print()" class="btn btn-print" type="button">Cetak / PDF</button>
                        <a href="export_word.php?status=<?php echo urlencode($filter_status); ?>" class="btn btn-word">Export Word</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="section-head">
                    <div>
                        <h3>Data Rekap</h3>
                        <p>
                            <?php if ($filter_status != "") { ?>
                                Menampilkan status: <b><?php echo htmlspecialchars($filter_status); ?></b>
                            <?php } else { ?>
                                Menampilkan semua data laporan.
                            <?php } ?>
                        </p>
                    </div>
                </div>

                <div class="table-wrap">
                    <table>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Kegiatan</th>
                            <th style="width: 130px;">Tanggal</th>
                            <th>Tempat</th>
                            <th style="width: 90px;">Jam</th>
                            <th style="width: 120px;">Status</th>
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
                                    <span class="badge <?php echo htmlspecialchars($row['status']); ?>">
                                        <?php echo htmlspecialchars($row['status']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="6" class="empty">Tidak ada data laporan.</td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>