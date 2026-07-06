<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password']);

    if ($username == "" || $password == "") {
        $error = "Username dan password wajib diisi.";
    } else {
        $query = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' LIMIT 1");

        if ($query && mysqli_num_rows($query) == 1) {
            $data = mysqli_fetch_assoc($query);

            if ($password == $data['password']) {
                $_SESSION['username'] = $data['username'];
                $_SESSION['role'] = $data['role'];

                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "Username tidak ditemukan.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Laporan</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(13,110,253,0.14), transparent 30%),
                radial-gradient(circle at bottom right, rgba(59,130,246,0.14), transparent 28%),
                linear-gradient(135deg, #eef4ff, #f8fbff);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-wrap {
            width: 100%;
            max-width: 980px;
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            background: rgba(255,255,255,0.96);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 30px 60px rgba(13, 110, 253, 0.14);
            border: 1px solid rgba(255,255,255,0.7);
        }

        .login-left {
            position: relative;
            background: linear-gradient(160deg, #0d6efd, #0b57d0 55%, #0847ae);
            color: white;
            padding: 46px 38px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
        }

        .login-left::before,
        .login-left::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
        }

        .login-left::before {
            width: 180px;
            height: 180px;
            top: -45px;
            right: -45px;
        }

        .login-left::after {
            width: 150px;
            height: 150px;
            bottom: -40px;
            left: -40px;
        }

        .login-left-content {
            position: relative;
            z-index: 2;
        }

        .logo-left-wrap {
            margin-bottom: 22px;
            display: flex;
            justify-content: center;
        }

        .logo-left {
            width: 150px;
            height: 150px;
            object-fit: contain;
            display: block;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.18));
        }

        .badge {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.14);
            color: #eff6ff;
            font-size: 12px;
            letter-spacing: 0.4px;
            margin-bottom: 18px;
        }

        .login-left h1 {
            margin: 0 0 14px;
            font-size: 34px;
            line-height: 1.2;
        }

        .login-left p {
            margin: 0 0 24px;
            font-size: 14px;
            line-height: 1.8;
            color: #eaf2ff;
            max-width: 420px;
        }

        .feature-box {
            display: grid;
            gap: 12px;
            margin-top: 10px;
        }

        .feature-item {
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 16px;
            padding: 14px 16px;
            font-size: 13px;
            line-height: 1.6;
            color: #f8fbff;
        }

        .login-right {
            background: rgba(255,255,255,0.96);
            padding: 42px 36px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h2 {
            margin: 0 0 8px;
            font-size: 32px;
            color: #111827;
            text-align: center;
        }

        .login-right p.subtitle {
            margin: 0 0 24px;
            font-size: 14px;
            color: #6b7280;
            text-align: center;
            line-height: 1.7;
        }

        .error-box {
            background: #fff1f2;
            color: #b91c1c;
            border: 1px solid #fecdd3;
            padding: 12px 14px;
            border-radius: 14px;
            font-size: 14px;
            margin-bottom: 18px;
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

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #dbe2ea;
            border-radius: 16px;
            font-size: 14px;
            background: #f8fafc;
            outline: none;
            transition: all 0.25s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #0d6efd;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(13,110,253,0.12);
        }

        .btn-login {
            width: 100%;
            border: none;
            background: linear-gradient(135deg, #0d6efd, #0b57d0);
            color: white;
            padding: 14px 16px;
            border-radius: 16px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 6px;
            box-shadow: 0 14px 24px rgba(13,110,253,0.22);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 28px rgba(13,110,253,0.26);
        }

        .note {
            margin-top: 18px;
            font-size: 13px;
            color: #6b7280;
            line-height: 1.7;
            text-align: center;
        }

        @media (max-width: 900px) {
            .login-wrap {
                grid-template-columns: 1fr;
            }

            .login-left,
            .login-right {
                padding: 30px 22px;
            }

            .login-left h1 {
                font-size: 28px;
            }

            .login-right h2 {
                font-size: 28px;
            }

            .logo-left {
                width: 120px;
                height: 120px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrap">
        <div class="login-left">
            <div class="login-left-content">
                <div class="logo-left-wrap">
                    <img src="assets\logo-gresik.png" alt="Logo Kecamatan Bungah" class="logo-left">
                </div>

                <div class="badge">Sistem Laporan Kecamatan</div>
                <h1>Login Admin & Verifikator</h1>
                <p>
                    Admin bertugas menginput dan mengelola laporan, sedangkan verifikator
                    bertugas meninjau dan memverifikasi laporan kegiatan secara tertib dan terstruktur.
                </p>

                <div class="feature-box">
                    <div class="feature-item">Pengelolaan laporan harian yang lebih rapi dan terpusat.</div>
                    <div class="feature-item">Proses verifikasi lebih jelas, cepat, dan mudah dipantau.</div>
                    <div class="feature-item">Rekap laporan membantu monitoring kegiatan kecamatan.</div>
                </div>
            </div>
        </div>

        <div class="login-right">
            <h2>Masuk ke Akun</h2>
            <p class="subtitle">Gunakan username dan password yang sudah terdaftar.</p>

            <?php if ($error != "") { ?>
                <div class="error-box"><?php echo $error; ?></div>
            <?php } ?>

            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Masukkan username">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan password">
                </div>

                <button type="submit" name="login" class="btn-login">Login</button>
            </form>

            <div class="note">
                Role pengguna dibaca langsung dari tabel <b>user</b>.
            </div>
        </div>
    </div>
</body>
</html>
