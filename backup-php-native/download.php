<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #eef4ff, #f8fbff);
            color: #1f2937;
        }

        .topbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e5e7eb;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand img {
            width: 56px;
            height: 56px;
            object-fit: contain;
            background: white;
            border-radius: 16px;
            padding: 8px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        .brand-text h2 {
            margin: 0;
            font-size: 22px;
            color: #111827;
        }

        .brand-text p {
            margin: 4px 0 0;
            color: #6b7280;
            font-size: 14px;
        }

        .logout {
            text-decoration: none;
            background: #ef4444;
            color: white;
            padding: 11px 18px;
            border-radius: 12px;
            font-weight: bold;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.18);
        }

        .logout:hover {
            background: #dc2626;
            transform: translateY(-2px);
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
            padding: 32px;
            box-shadow: 0 20px 40px rgba(13, 110, 253, 0.20);
            margin-bottom: 24px;
        }

        .hero .badge {
            display: inline-block;
            background: rgba(255,255,255,0.18);
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 13px;
            margin-bottom: 14px;
        }

        .hero h1 {
            margin: 0 0 10px;
            font-size: 32px;
            line-height: 1.2;
        }

        .hero p {
            margin: 0;
            max-width: 760px;
            color: #e8f1ff;
            line-height: 1.7;
            font-size: 15px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: rgba(255,255,255,0.9);
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 22px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        }

        .stat-card span {
            display: block;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .stat-card h3 {
            margin: 0;
            font-size: 22px;
            color: #111827;
        }

        .section-title {
            margin: 0 0 14px;
            font-size: 22px;
            color: #111827;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 18px;
        }

        .menu-card {
            text-decoration: none;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 22px;
            padding: 24px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            transition: 0.3s;
            color: #1f2937;
        }

        .menu-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 35px rgba(13, 110, 253, 0.12);
            border-color: #bfdbfe;
        }

        .menu-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #dbeafe, #eff6ff);
            color: #0d6efd;
            font-size: 22px;
            margin-bottom: 16px;
            font-weight: bold;
        }

        .menu-card h3 {
            margin: 0 0 8px;
            font-size: 18px;
            color: #111827;
        }

        .menu-card p {
            margin: 0;
            color: #6b7280;
            line-height: 1.6;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6b7280;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .hero {
                padding: 24px;
            }

            .hero h1 {
                font-size: 26px;
            }

            .brand-text h2 {
                font-size: 18px;
            }

            .brand img {
                width: 48px;
                height: 48px;
            }

            .logout {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <div class="topbar">
        <div class="brand">
            <img src="assets/logo-gresik.png" alt="Logo Kabupaten Gresik">
            <div class="brand-text">
                <h2>Dashboard Sistem Laporan Kegiatan</h2>
                <p>Kecamatan Bungah - Kabupaten Gresik</p>
            </div>
        </div>

        <a class="logout" href="logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?')">Logout</a>
    </div>

    <div class="container">
        <div class="hero">
            <div class="badge">Panel Administrasi</div>
            <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>
                Kelola data laporan kegiatan Kecamatan Bungah dengan tampilan yang lebih rapi,
                cepat, dan mudah digunakan untuk input, pengecekan, serta pemantauan aktivitas.
            </p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <span>User Login</span>
                <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
            </div>

            <div class="stat-card">
                <span>Tanggal Hari Ini</span>
                <h3><?php echo date('d-m-Y'); ?></h3>
            </div>

            <div class="stat-card">
                <span>Status Sistem</span>
                <h3>Aktif</h3>
            </div>
        </div>

        <h2 class="section-title">Menu Utama</h2>

        <div class="menu-grid">
            <a href="input_laporan.php" class="menu-card">
                <div class="menu-icon">+</div>
                <h3>Input Laporan</h3>
                <p>Tambah data laporan kegiatan baru beserta dokumen pendukung dengan cepat.</p>
            </a>

            <a href="kelola_laporan.php" class="menu-card">
                <div class="menu-icon">≡</div>
                <h3>Kelola Laporan</h3>
                <p>Lihat, edit, hapus, dan atur data laporan kegiatan yang sudah tersimpan.</p>
            </a>

            <a href="lihat_laporan.php" class="menu-card">
                <div class="menu-icon">◉</div>
                <h3>Lihat Laporan</h3>
                <p>Tinjau laporan dan dokumen lampiran untuk pemeriksaan dan pencarian data.</p>
            </a>

            <a href="riwayat.php" class="menu-card">
                <div class="menu-icon">↺</div>
                <h3>Riwayat Aktivitas</h3>
                <p>Pantau aktivitas pengguna dan perubahan data yang terjadi dalam sistem.</p>
            </a>
        </div>

        <div class="footer">
            <p>&copy; 2026 Sistem Penyimpanan Otomatis Laporan Kegiatan Kecamatan Bungah</p>
        </div>
    </div>

</body>
</html>