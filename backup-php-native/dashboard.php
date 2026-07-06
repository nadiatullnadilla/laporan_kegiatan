<?php
include 'session_login.php';
admin_atau_verifikator();
include 'koneksi.php';

$role = $_SESSION['role'];
$boleh_lihat_riwayat = ($role == 'admin' || $role == 'verifikator');

$q_laporan = mysqli_query($conn, "SELECT COUNT(*) AS total FROM laporan");
$d_laporan = mysqli_fetch_assoc($q_laporan);
$total_laporan = $d_laporan['total'];

$q_file = mysqli_query($conn, "SELECT COUNT(*) AS total FROM laporan WHERE dokumen IS NOT NULL AND dokumen != ''");
$d_file = mysqli_fetch_assoc($q_file);
$total_file = $d_file['total'];

$q_hari_ini = mysqli_query($conn, "SELECT COUNT(*) AS total FROM laporan WHERE tanggal = CURDATE()");
$d_hari_ini = mysqli_fetch_assoc($q_hari_ini);
$total_hari_ini = $d_hari_ini['total'];

$q_menunggu = mysqli_query($conn, "SELECT COUNT(*) AS total FROM laporan WHERE status='menunggu'");
$d_menunggu = mysqli_fetch_assoc($q_menunggu);
$total_menunggu = $d_menunggu['total'];

$q_disetujui = mysqli_query($conn, "SELECT COUNT(*) AS total FROM laporan WHERE status='disetujui'");
$d_disetujui = mysqli_fetch_assoc($q_disetujui);
$total_disetujui = $d_disetujui['total'];

$q_revisi = mysqli_query($conn, "SELECT COUNT(*) AS total FROM laporan WHERE status='revisi'");
$d_revisi = mysqli_fetch_assoc($q_revisi);
$total_revisi = $d_revisi['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            transition: margin-left 0.25s ease, transform 0.25s ease;
            z-index: 20;
        }
        body.sidebar-collapsed .sidebar {
            margin-left: -230px;
        }
        .brand {
            text-align: center;
            padding-bottom: 18px;
            border-bottom: 1px solid rgba(255,255,255,0.18);
        }
        .brand img {
            width: 92px;
            height: 92px;
            object-fit: contain;
            display: block;
            margin: 0 auto 12px;
            background: white;
            border-radius: 18px;
            padding: 10px;
            box-shadow: 0 12px 24px rgba(0,0,0,0.14);
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
        .topbar, .stat-card, .mini-card, .panel {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        .topbar {
            padding: 18px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }
        .topbar-title {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .sidebar-toggle {
            width: 44px;
            height: 44px;
            border: none;
            border-radius: 14px;
            background: #eef4ff;
            color: #0d6efd;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            flex: 0 0 auto;
        }
        .sidebar-toggle span {
            width: 20px;
            height: 2px;
            background: currentColor;
            border-radius: 999px;
            display: block;
        }
        .topbar h1 {
            margin: 0;
            font-size: 24px;
        }
        .topbar p {
            margin: 6px 0 0;
            color: #6b7280;
            font-size: 14px;
        }
        .user-badge {
            background: #eef4ff;
            color: #0d6efd;
            padding: 10px 14px;
            border-radius: 14px;
            font-weight: bold;
            font-size: 14px;
        }
        .hero {
            background: linear-gradient(135deg, #0d6efd, #0b57d0);
            color: white;
            border-radius: 24px;
            padding: 24px;
            margin-bottom: 24px;
        }
        .hero span {
            display: inline-block;
            background: rgba(255,255,255,0.16);
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            margin-bottom: 12px;
        }
        .hero h2 {
            margin: 0 0 8px;
            font-size: 24px;
        }
        .hero p {
            margin: 0;
            font-size: 14px;
            color: #e8f1ff;
            line-height: 1.6;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }
        .stat-card {
            padding: 22px;
        }
        .stat-card span {
            display: block;
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 10px;
        }
        .stat-card h3 {
            margin: 0;
            font-size: 24px;
        }
        .rekap-status {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }
        .mini-card {
            padding: 20px;
        }
        .mini-card span {
            display: block;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 8px;
        }
        .mini-card h3 {
            margin: 0;
            font-size: 24px;
        }
        .panel {
            padding: 24px;
        }
        .panel h3 {
            margin: 0 0 10px;
            font-size: 22px;
        }
        .panel p {
            margin: 0;
            color: #6b7280;
            line-height: 1.7;
        }
        .sidebar-overlay {
            display: none;
        }
        @media (max-width: 768px) {
            .layout {
                display: block;
            }
            .sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                transform: translateX(-100%);
                margin-left: 0;
                overflow-y: auto;
            }
            body.sidebar-open .sidebar {
                transform: translateX(0);
            }
            body.sidebar-collapsed .sidebar {
                margin-left: 0;
            }
            .main {
                padding: 18px;
            }
            .topbar {
                padding: 14px;
                align-items: flex-start;
            }
            .topbar-title {
                width: 100%;
            }
            .user-badge {
                width: 100%;
                line-height: 1.5;
            }
            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(15,23,42,0.42);
                z-index: 15;
            }
            body.sidebar-open .sidebar-overlay {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand">
                <img src="assets/logo-gresik.png" alt="Logo Kabupaten Gresik">
                <h2>Sistem Laporan</h2>
                <p>Kecamatan Bungah<br>Kabupaten Gresik</p>
            </div>

            <div class="menu-title">Menu Utama</div>
            <div class="menu">
                <a href="dashboard.php" class="active">Dashboard</a>

                <?php if ($role == 'admin') { ?>
                    <a href="input_laporan.php">Input Laporan</a>
                    <a href="kelola_laporan.php">Kelola Laporan</a>
                    <a href="lihat_laporan.php">Lihat Laporan</a>
                    <a href="rekap_laporan.php">Rekap Laporan</a>
                <?php } ?>

                <?php if ($role == 'verifikator') { ?>
                    <a href="verifikasi_laporan.php">Verifikasi Laporan</a>
                    <a href="lihat_laporan.php">Lihat Laporan</a>
                    <a href="rekap_laporan.php">Rekap Laporan</a>
                <?php } ?>

                <?php if ($boleh_lihat_riwayat) { ?>
                    <a href="riwayat.php">Riwayat Aktivitas</a>
                <?php } ?>
            </div>

            <a class="logout" href="logout.php">Logout</a>
        </aside>
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <main class="main">
            <div class="topbar">
                <div class="topbar-title">
                    <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-label="Buka menu" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <div>
                        <h1>Dashboard</h1>
                        <p>Panel utama pengelolaan laporan kegiatan.</p>
                    </div>
                </div>
                <div class="user-badge">
                    User: <?php echo htmlspecialchars($_SESSION['username']); ?> |
                    Role: <?php echo htmlspecialchars($_SESSION['role']); ?>
                </div>
            </div>

            <div class="hero">
                <span><?php echo ($role == 'verifikator') ? 'Panel Verifikator' : 'Panel Admin'; ?></span>
                <h2>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
                <p>
                    <?php if ($role == 'admin') { ?>
                        Gunakan menu untuk menginput, mengelola, melihat, dan merekap laporan kegiatan.
                    <?php } else { ?>
                        Gunakan menu untuk memverifikasi, melihat, dan merekap laporan kegiatan.
                    <?php } ?>
                </p>
            </div>

            <div class="stats">
                <div class="stat-card">
                    <span>Total Laporan</span>
                    <h3><?php echo $total_laporan; ?></h3>
                </div>
                <div class="stat-card">
                    <span>Total Dokumen</span>
                    <h3><?php echo $total_file; ?></h3>
                </div>
                <div class="stat-card">
                    <span>Laporan Hari Ini</span>
                    <h3><?php echo $total_hari_ini; ?></h3>
                </div>
            </div>

            <div class="rekap-status">
                <div class="mini-card">
                    <span>Status Menunggu</span>
                    <h3><?php echo $total_menunggu; ?></h3>
                </div>
                <div class="mini-card">
                    <span>Status Disetujui</span>
                    <h3><?php echo $total_disetujui; ?></h3>
                </div>
                <div class="mini-card">
                    <span>Status Revisi</span>
                    <h3><?php echo $total_revisi; ?></h3>
                </div>
            </div>

            <div class="panel">
                <h3>Informasi</h3>
                <p>
                    Dashboard ini menampilkan ringkasan laporan dan status verifikasi.
                    Untuk melihat detail rekap, cetak PDF, atau export Word, gunakan menu
                    <b>Rekap Laporan</b> di sidebar.
                </p>
            </div>
        </main>
    </div>
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function isMobileView() {
            return window.matchMedia('(max-width: 768px)').matches;
        }

        function updateToggleState() {
            const isOpen = isMobileView()
                ? document.body.classList.contains('sidebar-open')
                : !document.body.classList.contains('sidebar-collapsed');

            sidebarToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            sidebarToggle.setAttribute('aria-label', isOpen ? 'Tutup menu' : 'Buka menu');
        }

        sidebarToggle.addEventListener('click', function () {
            if (isMobileView()) {
                document.body.classList.toggle('sidebar-open');
            } else {
                document.body.classList.toggle('sidebar-collapsed');
            }

            updateToggleState();
        });

        sidebarOverlay.addEventListener('click', function () {
            document.body.classList.remove('sidebar-open');
            updateToggleState();
        });

        window.addEventListener('resize', function () {
            if (!isMobileView()) {
                document.body.classList.remove('sidebar-open');
            }

            updateToggleState();
        });

        updateToggleState();
    </script>
</body>
</html>
