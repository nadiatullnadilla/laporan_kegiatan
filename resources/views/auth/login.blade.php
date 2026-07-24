<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Laporan Kegiatan</title>
    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme-mode');
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.dataset.theme = savedTheme || (prefersDark ? 'night' : 'day');
        })();
    </script>
    <style>
        * { box-sizing: border-box; }
        :root {
            --primary: #0f766e;
            --accent: #f59e0b;
            --ink: #111827;
            --muted: #6b7280;
            --line: #dbe2ea;
            --input-bg: #f8fafc;
            --card: rgba(255,255,255,.96);
            --body-bg: radial-gradient(circle at top left, rgba(15,118,110,.14), transparent 30%), radial-gradient(circle at bottom right, rgba(245,158,11,.14), transparent 28%), linear-gradient(135deg, #f4fbf8, #fffaf0);
            --shadow: rgba(15,118,110,.16);
            color-scheme: light;
        }
        html[data-theme="night"] {
            --primary: #2dd4bf;
            --accent: #fbbf24;
            --ink: #e5edf4;
            --muted: #a7b5c5;
            --line: #31435a;
            --input-bg: #0f1b2d;
            --card: rgba(17,28,46,.96);
            --body-bg: radial-gradient(circle at top left, rgba(45,212,191,.18), transparent 30%), radial-gradient(circle at bottom right, rgba(251,191,36,.12), transparent 28%), linear-gradient(135deg, #07111f, #111827);
            --shadow: rgba(0,0,0,.34);
            color-scheme: dark;
        }
        body { margin: 0; font-family: Arial, sans-serif; min-height: 100vh; background: var(--body-bg); color: var(--ink); display: flex; align-items: center; justify-content: center; padding: 24px; transition: background .25s ease, color .25s ease; }
        .login-wrap { width: 100%; max-width: 800px; display: grid; grid-template-columns: 1fr 1fr; background: var(--card); border: 1px solid rgba(255,255,255,.45); border-radius: 24px; overflow: hidden; box-shadow: 0 30px 60px var(--shadow); position: relative; }
        .login-left { background: linear-gradient(160deg, #134e4a, #0f766e 58%, #115e59); color: white; padding: 36px 32px; display: flex; flex-direction: column; justify-content: center; }
        html[data-theme="night"] .login-left { background: linear-gradient(160deg, #07111f, #0f2f2c 58%, #115e59); }
        .logo-left-wrap { margin-bottom: 18px; display: flex; justify-content: center; }
        .logo-left { width: 100px; height: 100px; object-fit: contain; display: block; background: rgba(255,255,255,.96); border-radius: 18px; padding: 10px; box-shadow: 0 18px 34px rgba(2,8,23,.22); border: 1px solid rgba(255,255,255,.72); }
        .badge { display: inline-block; padding: 6px 12px; border-radius: 999px; background: rgba(245,158,11,.20); color: #fffbeb; font-size: 11px; margin-bottom: 14px; }
        h1 { margin: 0 0 12px; font-size: 26px; line-height: 1.2; }
        .login-left p { margin: 0 0 20px; font-size: 13px; line-height: 1.6; color: #d7fbf2; }
        .feature-item { background: rgba(255,255,255,.10); border-radius: 14px; padding: 10px 14px; font-size: 12px; line-height: 1.5; margin-top: 10px; }
        .login-right { padding: 36px 32px; display: flex; flex-direction: column; justify-content: center; }
        .login-right h2 { margin: 0 0 8px; font-size: 26px; color: var(--ink); text-align: center; }
        .subtitle { margin: 0 0 20px; font-size: 13px; color: var(--muted); text-align: center; line-height: 1.7; }
        .error-box { background: #fff1f2; color: #b91c1c; border: 1px solid #fecdd3; padding: 10px 12px; border-radius: 12px; font-size: 13px; margin-bottom: 16px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: bold; color: var(--ink); }
        input { width: 100%; padding: 12px 14px; border: 1px solid var(--line); border-radius: 14px; font-size: 13px; background: var(--input-bg); color: var(--ink); outline: none; }
        .btn-login { width: 100%; border: none; background: linear-gradient(135deg, #0f766e, #f59e0b); color: white; padding: 12px 14px; border-radius: 14px; font-size: 14px; font-weight: bold; cursor: pointer; box-shadow: 0 12px 24px rgba(15,118,110,.18); }
        .note { margin-top: 16px; font-size: 12px; color: var(--muted); line-height: 1.6; text-align: center; }
        .theme-toggle { position: absolute; top: 16px; right: 16px; width: 40px; height: 40px; border: 1px solid rgba(15,118,110,.20); border-radius: 12px; background: rgba(255,255,255,.88); color: #0f766e; font-size: 18px; cursor: pointer; box-shadow: 0 12px 24px rgba(15,23,42,.10); }
        .password-wrapper { position: relative; }
        .btn-toggle-password { position: absolute; right: 12px; bottom: 11px; background: none; border: none; cursor: pointer; color: var(--muted); padding: 0; font-size: 16px; outline: none; }
        html[data-theme="night"] .theme-toggle { background: #152236; color: #fbbf24; border-color: #31435a; }
        .theme-icon-night { display: none; }
        html[data-theme="night"] .theme-icon-day { display: none; }
        html[data-theme="night"] .theme-icon-night { display: inline; }
        html[data-theme="night"] .error-box { background: #4c1720; color: #fecdd3; border-color: #7f1d1d; }
        @media (max-width: 900px) {
            body { align-items: flex-start; padding: 18px; }
            .login-wrap { grid-template-columns: 1fr; border-radius: 24px; }
            .login-left, .login-right { padding: 30px 22px; }
            .logo-left { width: 112px; height: 112px; padding: 12px; }
            h1 { font-size: 28px; }
            .login-right h2 { font-size: 27px; }
        }
        @media (max-width: 520px) {
            body { padding: 12px; }
            .login-wrap { border-radius: 20px; }
            .login-left, .login-right { padding: 24px 18px; }
            .logo-left { width: 96px; height: 96px; border-radius: 18px; }
            h1 { font-size: 24px; }
            .login-left p, .feature-item, .subtitle { font-size: 13px; }
            .feature-item { padding: 12px 13px; }
            .login-right h2 { font-size: 24px; }
            input, .btn-login { border-radius: 13px; }
        }
    </style>
</head>
<body>
    <div class="login-wrap">
        <button type="button" class="theme-toggle" id="themeToggle" aria-label="Ganti ke mode malam" title="Mode siang/malam">
            <span class="theme-icon-day">☀</span>
            <span class="theme-icon-night">☾</span>
        </button>
        <div class="login-left">
            <div class="logo-left-wrap">
                <img src="{{ asset('assets/logo-gresik.png') }}" alt="Logo Kecamatan Bungah" class="logo-left">
            </div>
            <div class="badge">Sistem Laporan Kegiatan Kecamatan</div>
            <h1>Login Admin & Verifikator</h1>
            <p>Admin mengelola laporan, sedangkan verifikator meninjau dan menentukan status laporan kegiatan.</p>
            <div class="feature-item">Pengelolaan laporan harian yang lebih rapi dan terpusat.</div>
            <div class="feature-item">Proses verifikasi lebih jelas, cepat, dan mudah dipantau.</div>
            <div class="feature-item">Rekap laporan membantu monitoring kegiatan kecamatan.</div>
        </div>
        <div class="login-right">
            <h2>Masuk ke Akun</h2>
            <p class="subtitle">Gunakan username dan password yang sudah terdaftar.</p>
            @if ($errors->any())
                <div class="error-box">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('login.process') }}">
                @csrf
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan username">
                </div>
                <div class="form-group password-wrapper">
                    <label>Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" style="padding-right: 44px;">
                    <button type="button" id="togglePassword" class="btn-toggle-password" title="Tampilkan/Sembunyikan password">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg id="eye-slash-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
                <button type="submit" class="btn-login">Login</button>
            </form>
            <div class="note">Gunakan akun admin atau verifikator yang sudah terdaftar.</div>
        </div>
    </div>
    <script>
        const themeToggle = document.getElementById('themeToggle');
        function updateThemeToggle() {
            const isNight = document.documentElement.dataset.theme === 'night';
            themeToggle.setAttribute('aria-label', isNight ? 'Ganti ke mode siang' : 'Ganti ke mode malam');
            themeToggle.setAttribute('title', isNight ? 'Mode malam aktif' : 'Mode siang aktif');
        }
        themeToggle.addEventListener('click', function () {
            const nextTheme = document.documentElement.dataset.theme === 'night' ? 'day' : 'night';
            document.documentElement.dataset.theme = nextTheme;
            localStorage.setItem('theme-mode', nextTheme);
            updateThemeToggle();
        });
        updateThemeToggle();

        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        const eyeSlashIcon = document.getElementById('eye-slash-icon');
        
        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            if (isPassword) {
                // Switching to text -> eye is OPEN
                eyeIcon.style.display = 'block';
                eyeSlashIcon.style.display = 'none';
            } else {
                // Switching to password -> eye is CLOSED
                eyeIcon.style.display = 'none';
                eyeSlashIcon.style.display = 'block';
            }
        });
    </script>
</body>
</html>
