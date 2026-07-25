<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Laporan Kegiatan')</title>
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
            --primary-dark: #134e4a;
            --accent: #f59e0b;
            --ink: #172033;
            --muted: #64748b;
            --line: #dbe5e1;
            --line-strong: #b8c7c2;
            --page: #f4f8f6;
            --card: #ffffff;
            --soft-primary: #e9f7f4;
            --body-bg:
                radial-gradient(circle at top left, rgba(15,118,110,.12), transparent 28%),
                radial-gradient(circle at bottom right, rgba(245,158,11,.10), transparent 26%),
                linear-gradient(180deg, #fbfdfb 0%, var(--page) 42%, #eef6f2 100%);
            --surface: rgba(255,255,255,.94);
            --surface-solid: #ffffff;
            --surface-soft: #fbfdf9;
            --table-head: #f8fafc;
            --table-hover: #fbfdff;
            --input-bg: #ffffff;
            --input-border: #d5deea;
            --label: #374151;
            --shadow: rgba(15,23,42,.06);
            --focus-ring: rgba(15,118,110,.12);
            color-scheme: light;
        }
        html[data-theme="night"] {
            --primary: #2dd4bf;
            --primary-dark: #99f6e4;
            --accent: #fbbf24;
            --ink: #e5edf4;
            --muted: #a7b5c5;
            --line: #263848;
            --line-strong: #40566b;
            --page: #0f172a;
            --card: #111c2e;
            --soft-primary: #153c3a;
            --body-bg:
                radial-gradient(circle at top left, rgba(45,212,191,.18), transparent 30%),
                radial-gradient(circle at bottom right, rgba(251,191,36,.12), transparent 28%),
                linear-gradient(180deg, #07111f 0%, #0f172a 50%, #111827 100%);
            --surface: rgba(17,28,46,.94);
            --surface-solid: #111c2e;
            --surface-soft: #152236;
            --table-head: #17263a;
            --table-hover: #172337;
            --input-bg: #0f1b2d;
            --input-border: #31435a;
            --label: #d6e0ea;
            --shadow: rgba(0,0,0,.28);
            --focus-ring: rgba(45,212,191,.18);
            color-scheme: dark;
        }
        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--body-bg);
            color: var(--ink);
            transition: background .25s ease, color .25s ease;
        }
        a { color: inherit; }
        .layout { display: flex; min-height: 100vh; max-width: 100%; overflow-x: hidden; }
        .sidebar { position: sticky; top: 0; width: 248px; height: 100vh; height: 100svh; min-height: 100vh; min-height: 100dvh; flex: 0 0 248px; background: linear-gradient(180deg, #0f2f2c, #134e4a 54%, #0f766e); color: white; padding: 20px 14px 82px; display: flex; flex-direction: column; gap: 16px; transition: margin-left .25s ease, transform .25s ease; z-index: 20; box-shadow: 18px 0 40px rgba(15,23,42,.14); }
        body.sidebar-collapsed .sidebar { margin-left: -248px; }
        .brand { text-align: center; padding: 4px 8px 18px; border-bottom: 1px solid rgba(255,255,255,.14); }
        .brand img { width: 82px; height: 82px; object-fit: contain; display: block; margin: 0 auto 12px; background: white; border-radius: 18px; padding: 9px; box-shadow: 0 14px 28px rgba(2,8,23,.24); }
        .brand h2 { margin: 0; font-size: 17px; }
        .brand p { margin: 6px 0 0; font-size: 12px; color: #ccfbf1; line-height: 1.5; }
        .menu-title { font-size: 11px; letter-spacing: 1.1px; text-transform: uppercase; color: #ccfbf1; margin: 4px 0 2px; padding-left: 8px; font-weight: 700; }
        .menu { flex: 1 1 auto; display: flex; flex-direction: column; gap: 8px; min-height: 0; overflow-y: auto; overflow-x: hidden; }
        .menu a { text-decoration: none; color: white; background: rgba(255,255,255,.075); padding: 11px 13px; border-radius: 11px; font-size: 13px; font-weight: bold; border: 1px solid rgba(255,255,255,.08); transition: background .2s ease, transform .2s ease; }
        .menu a:hover { background: rgba(255,255,255,.16); transform: translateX(2px); }
        .menu a.active { background: #fffbeb; color: var(--primary-dark); box-shadow: 0 10px 20px rgba(2,8,23,.12); }
        .menu-badge { float: right; min-width: 22px; height: 22px; padding: 0 7px; border-radius: 999px; background: #f59e0b; color: #111827; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 900; }
        .logout { position: absolute; left: 23px; right: 23px; bottom: 20px; min-height: 34px; display: flex; align-items: center; justify-content: center; text-decoration: none; background: rgba(255,255,255,.11); color: #ffe4e6; padding: 8px 12px; border-radius: 12px; text-align: center; font-weight: bold; font-size: 12px; border: 1px solid rgba(255,228,230,.28); box-shadow: 0 8px 18px rgba(2,8,23,.10); transition: background .2s ease, color .2s ease, transform .2s ease; }
        .logout:hover { background: #e11d48; color: white; transform: translateY(-1px); }
        .main { flex: 1; min-width: 0; padding: 30px; }
        .topbar, .card, .stat-card, .mini-card, .panel { background: var(--surface); border: 1px solid var(--line-strong); border-radius: 18px; box-shadow: 0 14px 34px var(--shadow); }
        .topbar { padding: 18px 20px; display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; margin-bottom: 22px; backdrop-filter: blur(10px); position: sticky; top: 0; z-index: 10; }
        .topbar-title { display: flex; align-items: center; gap: 14px; min-width: 0; }
        .topbar-title > div { min-width: 0; }
        .sidebar-toggle, .theme-toggle { width: 44px; height: 44px; border: 1px solid #cce9e2; border-radius: 12px; background: var(--soft-primary); color: var(--primary); display: inline-flex; align-items: center; justify-content: center; cursor: pointer; flex: 0 0 auto; }
        .sidebar-toggle { flex-direction: column; gap: 5px; }
        .sidebar-toggle span { width: 20px; height: 2px; background: currentColor; border-radius: 999px; display: block; }
        .topbar-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .theme-toggle { font-size: 20px; transition: transform .2s ease, background .2s ease; }
        .theme-toggle:hover { transform: translateY(-1px); }
        .theme-icon-night { display: none; }
        html[data-theme="night"] .theme-icon-day { display: none; }
        html[data-theme="night"] .theme-icon-night { display: inline; }
        .topbar h1 { margin: 0; font-size: 25px; }
        .topbar-title > div::after { content: ""; display: block; width: min(360px, 100%); height: 1px; margin-top: 10px; background: var(--line-strong); }
        .topbar p { margin: 6px 0 0; color: var(--muted); font-size: 14px; }
        .user-badge { background: var(--soft-primary); color: var(--primary-dark); padding: 10px 14px; border-radius: 12px; font-weight: bold; font-size: 14px; border: 1px solid #cce9e2; overflow-wrap: anywhere; }
        .hero { background: linear-gradient(135deg, #0f766e, #134e4a); color: white; border-radius: 20px; padding: 26px; margin-bottom: 24px; box-shadow: 0 20px 44px rgba(15,118,110,.22); }
        .hero span { display: inline-block; background: rgba(255,255,255,.16); padding: 7px 12px; border-radius: 999px; font-size: 12px; margin-bottom: 12px; }
        .hero h2 { margin: 0 0 8px; font-size: 24px; }
        .hero p { margin: 0; font-size: 14px; color: #e8f1ff; line-height: 1.6; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 16px; margin-bottom: 22px; }
        .stat-card, .mini-card, .panel, .card { padding: 20px; }
        .stat-card, .mini-card { position: relative; overflow: hidden; }
        .stat-card::before, .mini-card::before { content: ""; position: absolute; inset: 0 auto 0 0; width: 4px; background: var(--accent); }
        .stat-card span, .mini-card span { display: block; color: var(--muted); font-size: 13px; margin-bottom: 10px; font-weight: 700; }
        .stat-card h3, .mini-card h3 { margin: 0; font-size: 28px; color: var(--ink); }
        .compact-stats { grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; margin-bottom: 22px; }
        .compact-stats .stat-card { min-height: 78px; padding: 14px 16px 14px 18px; border-radius: 16px; }
        .compact-stats .stat-card span { font-size: 12px; margin-bottom: 6px; }
        .compact-stats .stat-card h3 { font-size: 24px; line-height: 1; }
        .toolbar, .actions { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-bottom: 18px; }
        .toolbar { background: var(--surface-soft); border: 1px solid var(--line-strong); border-radius: 16px; padding: 12px; }
        .toolbar input, .toolbar select { width: auto; min-width: 160px; }
        .toolbar .search-input { flex: 1 1 430px; min-width: 430px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
        .full { grid-column: 1 / -1; }
        label { display: block; margin-bottom: 8px; font-size: 14px; font-weight: bold; color: var(--label); }
        .field-help { display: block; margin-top: 8px; color: var(--muted); font-size: 13px; line-height: 1.6; }
        input, select, textarea { width: 100%; min-height: 42px; padding: 11px 13px; border: 1px solid var(--input-border); border-radius: 12px; font-size: 14px; background: var(--input-bg); color: var(--ink); outline: none; transition: border .2s ease, box-shadow .2s ease; }
        textarea { font-family: inherit; resize: vertical; line-height: 1.45; }
        input:focus, select:focus, textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 4px var(--focus-ring); }
        .btn { display: inline-flex; align-items: center; justify-content: center; min-height: 42px; padding: 10px 14px; border: 1px solid transparent; border-radius: 12px; text-decoration: none; cursor: pointer; font-weight: bold; font-size: 13px; transition: transform .2s ease, box-shadow .2s ease, background .2s ease; }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary { background: var(--primary); color: white; box-shadow: 0 10px 20px rgba(15,118,110,.18); }
        .btn-light { background: var(--surface-solid); color: var(--ink); border-color: var(--line); }
        .btn-danger { background: #e11d48; color: white; box-shadow: 0 10px 20px rgba(225,29,72,.18); }
        .btn-success { background: #10b981; color: white; box-shadow: 0 10px 20px rgba(16,185,129,.18); }
        .btn-purple { background: var(--accent); color: #1f2937; box-shadow: 0 10px 20px rgba(245,158,11,.20); }
        .btn-word { background: #2563eb; color: white; box-shadow: 0 10px 20px rgba(37,99,235,.18); }
        .btn-excel { background: #15803d; color: white; box-shadow: 0 10px 20px rgba(21,128,61,.18); }
        .btn-icon { width: 17px; height: 17px; margin-right: 7px; fill: none; stroke: currentColor; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2; }
        .btn-icon-only { width: 42px; padding: 10px; }
        .btn-icon-only .btn-icon { margin-right: 0; }
        .btn-compact { min-height: 34px; padding: 7px 11px; border-radius: 10px; font-size: 12px; box-shadow: none; }
        .manage-toolbar { gap: 8px; padding: 10px; }
        .manage-toolbar .search-input { flex-basis: 520px; min-width: 520px; min-height: 38px; }
        .rekap-toolbar { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 18px; }
        .rekap-filter { margin-bottom: 10px; }
        .export-actions { gap: 8px; margin: 0 0 0 auto; justify-content: flex-end; }
        .export-menu { position: relative; display: inline-flex; }
        .export-menu summary { list-style: none; }
        .export-menu summary::-webkit-details-marker { display: none; }
        .export-menu-list { position: absolute; top: calc(100% + 8px); right: 0; z-index: 5; min-width: 148px; padding: 7px; border: 1px solid var(--line); border-radius: 12px; background: var(--surface-solid); box-shadow: 0 16px 34px var(--shadow); }
        .export-menu-item { width: 100%; min-height: 38px; display: flex; align-items: center; gap: 8px; padding: 9px 10px; border: 0; border-radius: 9px; background: transparent; color: var(--ink); text-decoration: none; font: inherit; font-size: 13px; font-weight: 800; cursor: pointer; }
        .export-menu-item:hover { background: var(--soft-primary); color: var(--primary-dark); }
        .export-menu-item .btn-icon { margin-right: 0; flex: 0 0 auto; }
        .action-cell { width: 118px; min-width: 118px; white-space: nowrap; }
        .table-actions { margin: 0; gap: 6px; flex-wrap: nowrap; align-items: center; }
        .table-actions form { margin: 0; }
        .verification-actions { display: flex; gap: 4px; min-width: 0; justify-content: center; }
        .verification-actions form,
        .verification-actions .btn { width: auto; }
        .verification-actions .btn { min-height: 28px; padding: 5px 8px; font-size: 11px; line-height: 1; border-radius: 7px; white-space: nowrap; }
        .revision-box { min-width: 190px; }
        .revision-box summary { list-style: none; }
        .revision-box summary::-webkit-details-marker { display: none; }
        .revision-box form { display: grid; gap: 7px; margin-top: 8px; }
        .revision-note { min-height: 76px; font-size: 12px; }
        .table-wrap { overflow-x: auto; border: 1px solid var(--line-strong); border-radius: 14px; background: var(--surface-solid); }
        .activity-scroll { max-height: min(54vh, 430px); overflow: auto; }
        .activity-scroll th { position: sticky; top: 0; z-index: 2; }
        table { width: 100%; border-collapse: collapse; min-width: 760px; border: 1px solid var(--line-strong); }
        th, td { padding: 14px 15px; text-align: left; border-right: 1px solid var(--line); border-bottom: 1px solid var(--line); vertical-align: top; font-size: 14px; }
        th { background: var(--table-head); color: var(--muted); font-size: 12px; letter-spacing: .4px; text-transform: uppercase; border-bottom-color: var(--line-strong); }
        th:last-child, td:last-child { border-right: 0; }
        tr:hover td { background: var(--table-hover); }
        tr:last-child td, tr:last-child th { border-bottom: 0; }
        .badge, .file-badge { display: inline-block; padding: 6px 10px; border-radius: 999px; font-size: 12px; font-weight: bold; }
        .file-badge { background: var(--soft-primary); color: var(--primary); margin: 3px 4px 3px 0; text-decoration: none; }
        .report-table th,
        .report-table td { padding: 9px 8px; font-size: 12px; line-height: 1.35; }
        .report-table th { font-size: 10.5px; letter-spacing: .25px; }
        .report-table th:first-child,
        .report-table td:first-child { width: 38px; text-align: center; }
        .report-table th:nth-child(3),
        .report-table td:nth-child(3) { width: 92px; text-align: center; }
        .report-table th:nth-child(5),
        .report-table td:nth-child(5) { width: 74px; text-align: center; }
        .report-table th:nth-child(7),
        .report-table td:nth-child(7) { width: 86px; text-align: center; }
        .report-table th:last-child,
        .report-table td:last-child { width: 112px; text-align: center; }
        .report-table .badge,
        .report-table .file-badge { padding: 4px 7px; font-size: 10.5px; border-radius: 7px; }
        .report-table .btn-compact { min-height: 26px; padding: 5px 7px; font-size: 10.5px; border-radius: 7px; }
        .report-table .action-cell { width: 112px; min-width: 112px; }
        button.file-badge { border: 0; cursor: pointer; font-family: inherit; }
        .current-files { margin-top: 10px; }
        .modal-overlay { position: fixed; inset: 0; z-index: 60; display: none; align-items: center; justify-content: center; padding: 18px; background: rgba(15,23,42,.46); }
        .modal-overlay.open { display: flex; }
        .modal-dialog { width: min(720px, 100%); max-height: min(78vh, 620px); overflow: hidden; border: 1px solid var(--line); border-radius: 16px; background: var(--surface-solid); box-shadow: 0 28px 70px rgba(15,23,42,.26); }
        .modal-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; padding: 16px 18px; border-bottom: 1px solid var(--line); }
        .modal-head h3 { margin: 0 0 5px; font-size: 18px; }
        .modal-head span { color: var(--muted); font-size: 13px; font-weight: 700; }
        .modal-close { width: 34px; height: 34px; border: 1px solid var(--line); border-radius: 10px; background: var(--surface-soft); color: var(--ink); cursor: pointer; font-weight: 900; }
        .file-modal-list { max-height: min(58vh, 460px); overflow: auto; }
        .file-menu-row { display: grid; grid-template-columns: 28px minmax(180px, 1fr) minmax(150px, auto); align-items: center; gap: 10px; min-height: 48px; padding: 9px 14px; border-bottom: 1px solid var(--line); color: var(--ink); text-decoration: none; font-size: 13px; }
        .file-menu-row:last-child { border-bottom: 0; }
        .file-menu-row:hover { background: var(--surface-soft); }
        .file-type-icon { width: 18px; height: 18px; border-radius: 3px; background: #ef4444; color: white; display: inline-flex; align-items: center; justify-content: center; font-size: 7px; font-weight: 900; letter-spacing: .2px; }
        .file-type-icon.image { background: #ef4444; }
        .file-type-icon.video { background: #dc2626; }
        .file-type-icon.doc { background: #2563eb; }
        .file-row-name { min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-weight: 800; }
        .file-row-meta { color: var(--muted); white-space: nowrap; text-align: right; }
        .table-link { color: var(--ink); text-decoration: none; font-weight: 800; }
        .table-link:hover { color: var(--primary); text-decoration: underline; }
        .menunggu { background: #fef3c7; color: #92400e; }
        .disetujui { background: #dcfce7; color: #166534; }
        .revisi { background: #fee2e2; color: #991b1b; }
        .section-title { margin: 6px 0 12px; padding-bottom: 10px; font-size: 18px; color: var(--ink); border-bottom: 1px solid var(--line-strong); }
        .detail-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
        .detail-item { background: var(--surface-soft); border: 1px solid var(--line); border-radius: 14px; padding: 14px; }
        .detail-item span { display: block; margin-bottom: 7px; color: var(--muted); font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: .35px; }
        .detail-item strong, .detail-item p { margin: 0; color: var(--ink); line-height: 1.55; }
        .detail-files { display: flex; flex-wrap: wrap; gap: 8px; }
        .detail-file-list { max-height: 320px; border: 1px solid var(--line); border-radius: 12px; background: var(--surface-solid); }
        .dashboard-shell { display: grid; gap: 18px; }
        .dashboard-hero-card { position: relative; overflow: hidden; min-height: 168px; display: flex; align-items: center; }
        .dashboard-hero-card::after { content: ""; position: absolute; width: 220px; height: 220px; right: -70px; top: -70px; border-radius: 50%; background: rgba(245,158,11,.18); }
        .dashboard-hero-card::before { content: ""; position: absolute; width: 140px; height: 140px; right: 90px; bottom: -70px; border-radius: 50%; background: rgba(255,255,255,.10); }
        .dashboard-hero-card > div { position: relative; z-index: 1; }
        .metric-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; }
        .metric-card { padding: 18px; border-radius: 18px; background: linear-gradient(180deg, var(--surface-solid), var(--surface-soft)); border: 1px solid var(--line-strong); box-shadow: 0 14px 30px var(--shadow); }
        .metric-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 18px; }
        .metric-head span { color: var(--muted); font-size: 12px; font-weight: 800; }
        .metric-card h3 { margin: 0; font-size: 30px; color: var(--ink); }
        .metric-chip { width: 40px; height: 40px; border-radius: 14px; background: #ecfdf5; color: var(--primary-dark); display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 900; border: 1px solid #bbf7d0; }
        .dashboard-grid { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(280px, .8fr); gap: 18px; align-items: start; }
        .dashboard-table { display: block; }
        .dashboard-card-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid var(--line-strong); }
        .dashboard-card-head h3 { margin: 0; font-size: 18px; }
        .dashboard-card-head span { color: var(--muted); font-size: 12px; font-weight: 700; }
        .status-list { display: grid; gap: 12px; }
        .status-row { display: flex; justify-content: space-between; align-items: center; gap: 12px; padding: 13px 14px; border: 1px solid var(--line); border-radius: 14px; background: linear-gradient(180deg, var(--surface-solid), var(--surface-soft)); }
        .status-row span { color: var(--muted); font-size: 13px; font-weight: 800; }
        .status-row strong { font-size: 24px; color: var(--ink); }
        .recent-table table { min-width: 0; table-layout: fixed; }
        .recent-table th, .recent-table td { font-size: 13px; padding: 12px 13px; vertical-align: middle; }
        .recent-table th:first-child,
        .recent-table td:first-child { width: 48px; text-align: center; }
        .recent-table th:nth-child(3),
        .recent-table td:nth-child(3) { width: 118px; text-align: center; }
        .recent-table th:nth-child(4),
        .recent-table td:nth-child(4) { width: 118px; text-align: center; }
        .recent-table th:nth-child(5),
        .recent-table td:nth-child(5) { width: 82px; text-align: center; }
        .dashboard-action-cell { white-space: nowrap; }
        .dashboard-action-btn { min-height: 28px; padding: 5px 10px; font-size: 11px; border-radius: 7px; }
        .dashboard-hero { display: grid; grid-template-columns: minmax(0, 1fr) auto; gap: 22px; align-items: end; }
        .hero-actions { display: flex; gap: 10px; flex-wrap: wrap; justify-content: flex-end; }
        .stat-top { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 12px; }
        .stat-icon { width: 42px; height: 42px; border-radius: 14px; background: #fffbeb; color: var(--primary-dark); display: inline-flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; border: 1px solid #fde68a; }
        .dashboard-grid { display: grid; grid-template-columns: minmax(0, 1.15fr) minmax(280px, .85fr); gap: 18px; align-items: start; }
        .quick-actions { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; }
        .quick-action { display: block; text-decoration: none; background: var(--surface-soft); border: 1px solid var(--line); border-radius: 14px; padding: 14px; transition: transform .2s ease, border .2s ease; }
        .quick-action:hover { transform: translateY(-2px); border-color: #99d7cd; }
        .quick-action strong { display: block; margin-bottom: 6px; font-size: 14px; color: var(--ink); }
        .quick-action span { display: block; color: var(--muted); font-size: 12px; line-height: 1.5; }
        .status-list { display: grid; gap: 12px; }
        .status-row { display: flex; justify-content: space-between; align-items: center; gap: 12px; padding: 12px 14px; border: 1px solid var(--line); border-radius: 14px; background: var(--surface-soft); }
        .status-row span { color: var(--muted); font-size: 13px; font-weight: 700; }
        .status-row strong { font-size: 22px; color: var(--ink); }
        .alert { padding: 13px 14px; border-radius: 14px; margin-bottom: 18px; }
        .compact-alert { padding: 10px 12px; border-radius: 12px; margin-bottom: 12px; font-size: 13px; font-weight: 700; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .alert-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .alert-info { background: var(--soft-primary); color: var(--primary-dark); border: 1px solid #cce9e2; }
        .empty { text-align: center; color: var(--muted); padding: 22px; }
        html[data-theme="night"] .topbar,
        html[data-theme="night"] .card,
        html[data-theme="night"] .stat-card,
        html[data-theme="night"] .mini-card,
        html[data-theme="night"] .panel { backdrop-filter: blur(10px); }
        html[data-theme="night"] .sidebar { background: linear-gradient(180deg, #07111f, #0f2f2c 58%, #115e59); }
        html[data-theme="night"] .brand img { background: #e5edf4; }
        html[data-theme="night"] .menu a.active { background: #fbbf24; color: #172033; }
        html[data-theme="night"] .btn-primary { color: #06241f; }
        html[data-theme="night"] .btn-light { background: #1b2d44; color: #e5edf4; border-color: #31435a; }
        html[data-theme="night"] .btn-success { color: #06241f; }
        html[data-theme="night"] .user-badge,
        html[data-theme="night"] .file-badge,
        html[data-theme="night"] .alert-info { color: #ccfbf1; border-color: #28665d; }
        html[data-theme="night"] .alert-warning { background: #4a3412; color: #fde68a; border-color: #7c5b16; }
        html[data-theme="night"] input::placeholder,
        html[data-theme="night"] textarea::placeholder { color: #94a3b8; }
        html[data-theme="night"] .hero { box-shadow: 0 20px 44px rgba(0,0,0,.24); }
        html[data-theme="night"] .metric-chip,
        html[data-theme="night"] .stat-icon { background: #1f3a34; color: #ccfbf1; border-color: #28665d; }
        html[data-theme="night"] .menunggu { background: #4a3412; color: #fde68a; }
        html[data-theme="night"] .disetujui { background: #123d2a; color: #bbf7d0; }
        html[data-theme="night"] .revisi { background: #4c1720; color: #fecdd3; }
        .footer { margin-top: 24px; padding: 16px 0 4px; text-align: center; color: var(--muted); font-size: 13px; font-weight: 700; }
        .print-only { display: none; }
        .sidebar-overlay { display: none; }
        @media (min-width: 1025px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                height: 100vh;
                min-height: 100vh;
            }
            .main { margin-left: 248px; }
            body.sidebar-collapsed .main { margin-left: 0; }
            body.sidebar-collapsed .logout { display: none; }
        }

        @media (max-width: 1200px) {
            .main { padding: 24px; }
            .dashboard-grid { grid-template-columns: 1fr; }
            .metric-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }

        @media (max-width: 1024px) {
            .layout { display: block; width: 100%; }
            .sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                height: 100vh;
                height: 100svh;
                min-height: 100vh;
                min-height: 100dvh;
                transform: translateX(-100%);
                margin-left: 0;
                overflow-y: auto;
            }
            body.sidebar-open .sidebar { transform: translateX(0); }
            body.sidebar-collapsed .sidebar { margin-left: 0; }
            .main { padding: 22px; }
            .topbar { position: sticky; top: 0; }
            .sidebar-overlay { position: fixed; inset: 0; background: rgba(15,23,42,.42); z-index: 15; }
            body.sidebar-open .sidebar-overlay { display: block; }
            .dashboard-grid, .dashboard-hero { grid-template-columns: 1fr; }
            .hero-actions { justify-content: flex-start; }
        }

        @media (max-width: 860px) {
            .metric-grid, .grid, .compact-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .form-grid { grid-template-columns: 1fr; }
            .rekap-toolbar { display: block; }
            .toolbar input, .toolbar select { width: 100%; }
            .toolbar .search-input { min-width: 100%; }
            .manage-toolbar .search-input { min-width: 100%; flex-basis: 100%; }
            .toolbar .btn { flex: 1 1 140px; }
            table { min-width: 680px; }
            .recent-table table { min-width: 560px; }
        }

        @media (max-width: 640px) {
            .main { width: 100%; max-width: 100%; padding: 12px; overflow-x: hidden; }
            .topbar { padding: 10px; border-radius: 12px; align-items: flex-start; gap: 10px; margin-bottom: 14px; }
            .topbar-title { width: 100%; align-items: flex-start; gap: 10px; }
            .topbar h1 { font-size: 18px; line-height: 1.15; }
            .topbar p { margin-top: 4px; font-size: 12px; line-height: 1.35; }
            .topbar-actions { width: 100%; display: grid; grid-template-columns: 40px minmax(0, 1fr); gap: 8px; }
            .sidebar-toggle, .theme-toggle { width: 40px; height: 40px; border-radius: 10px; }
            .user-badge { width: 100%; min-height: 40px; padding: 8px 10px; line-height: 1.35; font-size: 12px; display: flex; align-items: center; }
            .hero { padding: 16px; border-radius: 14px; margin-bottom: 16px; }
            .hero span { padding: 6px 10px; font-size: 11px; margin-bottom: 10px; }
            .hero h2 { font-size: 19px; line-height: 1.25; }
            .hero p { font-size: 12px; line-height: 1.5; }
            .dashboard-shell { gap: 14px; }
            .dashboard-hero-card { min-height: 132px; }
            .dashboard-hero-card::after { width: 140px; height: 140px; right: -54px; top: -48px; }
            .dashboard-hero-card::before { width: 96px; height: 96px; right: 42px; bottom: -52px; }
            .metric-grid, .grid, .compact-stats { grid-template-columns: 1fr; }
            .detail-grid { grid-template-columns: 1fr; gap: 10px; }
            .card, .panel, .stat-card, .mini-card, .metric-card { padding: 14px; border-radius: 13px; }
            .metric-grid { gap: 10px; }
            .metric-head { margin-bottom: 10px; }
            .metric-chip { width: 34px; height: 34px; border-radius: 11px; font-size: 11px; }
            .metric-card h3, .stat-card h3, .mini-card h3 { font-size: 22px; }
            .dashboard-card-head { align-items: flex-start; flex-direction: column; }
            .status-row strong { font-size: 20px; }
            .btn { width: 100%; min-height: 40px; }
            .export-menu { width: 100%; }
            .export-menu .btn-icon-only { width: 100%; }
            .export-menu-list { left: 0; right: 0; }
            .btn-compact { min-height: 38px; }
            .toolbar { padding: 10px; }
            .actions { align-items: stretch; }
            .actions form { width: 100%; }
            .table-actions { flex-wrap: nowrap; justify-content: flex-end; width: 100%; gap: 6px; }
            .table-actions form, .table-actions > .btn { width: auto; flex: 1; max-width: 140px; margin: 0; }
            .table-actions .btn { width: 100%; min-width: 0; }
            .table-wrap { width: 100%; max-width: 100%; border-radius: 12px; }
            .file-menu-row { grid-template-columns: 24px minmax(120px, 1fr); }
            .file-row-meta { grid-column: 2; text-align: left; white-space: normal; font-size: 11px; }
            .modal-overlay { padding: 10px; }
            .modal-head { padding: 14px; }
            .activity-scroll { max-height: 62vh; }
            th, td { padding: 11px 12px; font-size: 13px; }
            .footer { font-size: 12px; padding-bottom: 10px; }
            
            /* Responsive Table Cards */
            .report-table, .report-table tbody, .report-table tr, .report-table td { display: block; width: 100%; min-width: 0 !important; }
            .report-table th { display: none; }
            .report-table tr { margin-bottom: 14px; border: 1px solid var(--line-strong); border-radius: 12px; overflow: hidden; background: var(--surface-solid); }
            .report-table td { display: block; position: relative; padding: 12px 12px 12px 130px; border-bottom: 1px solid var(--line); text-align: right; min-height: 44px; word-wrap: break-word; }
            .report-table td:last-child { border-bottom: none; }
            .report-table td::before { content: attr(data-label); position: absolute; left: 12px; top: 12px; width: 110px; text-align: left; font-weight: 800; color: var(--muted); font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .report-table td.action-cell, .report-table td.dashboard-action-cell { display: flex; flex-direction: column; align-items: flex-end; gap: 8px; padding-left: 12px; position: static; }
            .report-table td.action-cell::before, .report-table td.dashboard-action-cell::before { position: static; width: auto; white-space: normal; }
            .table-wrap { background: transparent; border: none; overflow-x: auto; -webkit-overflow-scrolling: touch; }
            .table-wrap:has(.report-table) { overflow: visible; }
        }

        @media (max-width: 420px) {
            .main { padding: 8px; }
            .sidebar { width: 232px; }
            .brand img { width: 72px; height: 72px; }
            .brand h2 { font-size: 16px; }
            .menu a { font-size: 12px; padding: 10px 11px; }
            .topbar { margin-bottom: 12px; }
            .topbar h1 { font-size: 16px; }
            .topbar p { font-size: 11px; }
            .hero h2 { font-size: 17px; }
            .hero p { font-size: 12px; }
            .card, .panel, .stat-card, .mini-card, .metric-card { padding: 12px; }
            .dashboard-card-head h3 { font-size: 16px; }
            table { min-width: 620px; }
            .recent-table table { min-width: 0; }
        }

        @media print {
            @page { size: A4 portrait; margin: 12mm; }
            * { box-shadow: none !important; }
            body { background: white !important; color: #111827; }
            .sidebar,
            .topbar,
            .toolbar,
            .export-actions,
            .no-print,
            .footer,
            .compact-stats { display: none !important; }
            .layout { display: block; min-height: auto; }
            .main { width: 100%; margin-left: 0 !important; padding: 0; }
            .card { border: 0; border-radius: 0; padding: 0; background: white; }
            .print-only { display: block !important; }
            .print-report-head { margin: 0 0 14px; text-align: center; page-break-after: avoid; }
            .print-report-kop { display: grid !important; grid-template-columns: 72px 1fr 72px; align-items: center; gap: 10px; padding-bottom: 9px; margin-bottom: 12px; border-bottom: 2px solid #111827; }
            .print-report-logo { width: 58px; height: 58px; object-fit: contain; justify-self: center; }
            .print-report-agency { font-size: 14px; font-weight: 800; letter-spacing: .3px; }
            .print-report-unit { font-size: 18px; font-weight: 900; margin-top: 2px; }
            .print-report-address { font-size: 11px; margin-top: 4px; }
            .print-report-head h2 { margin: 10px 0 6px; font-size: 15px; letter-spacing: .4px; }
            .print-report-meta { display: flex !important; justify-content: center; gap: 22px; font-size: 11px; font-weight: 700; margin-bottom: 10px; }
            .section-title { font-size: 15px; margin: 0 0 8px; page-break-after: avoid; }
            .table-wrap { overflow: visible !important; border: 1px solid #9ca3af; border-radius: 0; margin-bottom: 14px !important; page-break-inside: avoid; }
            .activity-scroll { max-height: none !important; }
            .activity-scroll th { position: static; }
            table { min-width: 0 !important; width: 100% !important; table-layout: fixed; }
            th, td { padding: 7px 8px; font-size: 11.5px; line-height: 1.35; border-color: #cbd5e1; word-wrap: break-word; overflow-wrap: anywhere; }
            th { background: #e5e7eb !important; color: #111827; font-weight: 900; text-align: center; }
            td:first-child, th:first-child { width: 38px; text-align: center; }
            .report-table td:nth-child(3),
            .report-table td:nth-child(5) { text-align: center; }
            tr:hover td { background: transparent; }
            .badge { padding: 3px 6px; border-radius: 8px; }
            .file-badge { background: transparent !important; color: #111827 !important; padding: 0; }
            .print-signature { display: grid !important; grid-template-columns: 1fr 220px; margin-top: 110px; font-size: 12px; page-break-inside: avoid; }
            .print-signature p { margin: 0 0 10px; text-align: center; }
            .print-signature strong { display: block; margin-top: 52px; text-align: center; font-weight: 700; }
        }
        @media (max-width: 768px) {
            .dashboard-hero, .dashboard-grid, .metric-grid { grid-template-columns: 1fr; }
            .hero-actions { justify-content: stretch; }
        }
    </style>
</head>
<body>
    <div class="layout">
        @include('partials.sidebar')
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        <main class="main">
            <div class="topbar">
                <div class="topbar-title">
                    <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-label="Buka menu" aria-expanded="false">
                        <span></span><span></span><span></span>
                    </button>
                    <div>
                        <h1>@yield('page_title', 'Dashboard')</h1>
                        <p>@yield('page_subtitle', 'Panel utama pengelolaan laporan kegiatan.')</p>
                    </div>
                </div>
                <div class="topbar-actions">
                    <button type="button" class="theme-toggle" id="themeToggle" aria-label="Ganti ke mode malam" title="Mode siang/malam">
                        <span class="theme-icon-day">☀</span>
                        <span class="theme-icon-night">☾</span>
                    </button>
                    <div class="user-badge">User: {{ session('username') }} | Role: {{ session('role') }}</div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            @yield('content')

            @php
                $footerPath = storage_path('app/settings/footer.json');
                $footerData = file_exists($footerPath) ? json_decode(file_get_contents($footerPath), true) : [];
                $footerText = $footerData['footer_text'] ?? '✦ Developer by Nadiya';
            @endphp
            <footer class="footer">{{ $footerText }}</footer>
        </main>
    </div>
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const themeToggle = document.getElementById('themeToggle');
        const isMobileView = () => window.matchMedia('(max-width: 768px)').matches;
        function updateThemeToggle() {
            const isNight = document.documentElement.dataset.theme === 'night';
            themeToggle.setAttribute('aria-label', isNight ? 'Ganti ke mode siang' : 'Ganti ke mode malam');
            themeToggle.setAttribute('title', isNight ? 'Mode malam aktif' : 'Mode siang aktif');
        }
        function updateToggleState() {
            const isOpen = isMobileView() ? document.body.classList.contains('sidebar-open') : !document.body.classList.contains('sidebar-collapsed');
            sidebarToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            sidebarToggle.setAttribute('aria-label', isOpen ? 'Tutup menu' : 'Buka menu');
        }
        themeToggle.addEventListener('click', function () {
            const nextTheme = document.documentElement.dataset.theme === 'night' ? 'day' : 'night';
            document.documentElement.dataset.theme = nextTheme;
            localStorage.setItem('theme-mode', nextTheme);
            updateThemeToggle();
        });
        sidebarToggle.addEventListener('click', function () {
            document.body.classList.toggle(isMobileView() ? 'sidebar-open' : 'sidebar-collapsed');
            updateToggleState();
        });
        sidebarOverlay.addEventListener('click', function () {
            document.body.classList.remove('sidebar-open');
            updateToggleState();
        });
        document.querySelectorAll('[data-modal-target]').forEach(function (trigger) {
            trigger.addEventListener('click', function () {
                const modal = document.getElementById(trigger.dataset.modalTarget);
                if (!modal) return;
                modal.classList.add('open');
                modal.setAttribute('aria-hidden', 'false');
            });
        });
        document.addEventListener('click', function (event) {
            if (!event.target.matches('[data-modal-close]') && !event.target.classList.contains('modal-overlay')) {
                return;
            }

            const modal = event.target.closest('.modal-overlay') || event.target;
            modal.classList.remove('open');
            modal.setAttribute('aria-hidden', 'true');
        });
        document.addEventListener('keydown', function (event) {
            if (event.key !== 'Escape') return;

            document.querySelectorAll('.modal-overlay.open').forEach(function (modal) {
                modal.classList.remove('open');
                modal.setAttribute('aria-hidden', 'true');
            });
        });
        document.querySelectorAll('[data-revision-prompt]').forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                const form = button.closest('form');
                const noteInput = form.querySelector('input[name="catatan_verifikator"]');
                const note = window.prompt('Tulis catatan revisi untuk laporan ini:');

                if (note === null) return;

                const cleanNote = note.trim();
                if (!cleanNote) {
                    alert('Catatan revisi wajib diisi.');
                    return;
                }

                if (!confirm('Minta revisi laporan ini?')) return;

                noteInput.value = cleanNote;
                form.submit();
            });
        });
        window.addEventListener('resize', function () {
            if (!isMobileView()) document.body.classList.remove('sidebar-open');
            updateToggleState();
        });
        updateToggleState();
        updateThemeToggle();
    </script>
</body>
</html>
