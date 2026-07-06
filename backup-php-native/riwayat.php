<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM riwayat_aktivitas ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Aktivitas</title>
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
            max-width: 1150px;
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
            max-width: 1150px;
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
            min-width: 700px;
        }
        th, td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #eef2f7;
            font-size: 14px;
        }
        th {
            background: #f8fbff;
            color: #374151;
        }
        tr:hover {
            background: #f9fbff;
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
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="topbar-inner">
            <div class="brand">
                <img src="assets/logo-gresik.png" alt="Logo Kabupaten Gresik">
                <div class="brand-text">
                    <h2>Riwayat Aktivitas</h2>
                    <p>Kecamatan Bungah - Kabupaten Gresik</p>
                </div>
            </div>
            <a class="btn-back" href="dashboard.php">Kembali ke Dashboard</a>
        </div>
    </div>

    <div class="container">
        <div class="hero">
            <span>Log Aktivitas</span>
            <h1>Pantau aktivitas pengguna sistem</h1>
            <p>Riwayat aktivitas membantu memantau perubahan dan penggunaan sistem secara lebih tertib.</p>
        </div>

        <div class="table-card">
            <table>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Aktivitas</th>
                    <th>Waktu</th>
                </tr>

                <?php
                if (mysqli_num_rows($data) > 0) {
                    $no = 1;
                    while ($d = mysqli_fetch_assoc($data)) {
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($d['username']); ?></td>
                    <td><?php echo htmlspecialchars($d['aktivitas']); ?></td>
                    <td><?php echo htmlspecialchars($d['waktu']); ?></td>
                </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='4' class='kosong'>Belum ada riwayat aktivitas</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>