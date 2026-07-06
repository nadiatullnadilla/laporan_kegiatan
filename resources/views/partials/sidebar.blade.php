@php
    $role = session('role');
@endphp

<aside class="sidebar">
    <div class="brand">
        <img src="{{ asset('assets/logo-gresik.png') }}" alt="Logo Kabupaten Gresik">
        <h2>Sistem Laporan Kegiatan</h2>
        <p>Kecamatan Bungah<br>Kabupaten Gresik</p>
    </div>

    <div class="menu-title">Menu Utama</div>
    <div class="menu">
        @if ($role === 'admin')
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('laporan.create') }}" class="{{ request()->routeIs('laporan.create') ? 'active' : '' }}">Input Laporan</a>
            <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.index', 'laporan.edit') ? 'active' : '' }}">
                Kelola Laporan
                @if (($total_revisi_laporan ?? 0) > 0)
                    <span class="menu-badge">{{ $total_revisi_laporan }}</span>
                @endif
            </a>
            <a href="{{ route('rekap.index') }}" class="{{ request()->routeIs('rekap.index') ? 'active' : '' }}">Rekap Laporan</a>
        @endif

        @if ($role === 'verifikator')
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.index') ? 'active' : '' }}">
                Verifikasi Laporan
                @if (($total_menunggu_verifikasi ?? 0) > 0)
                    <span class="menu-badge">{{ $total_menunggu_verifikasi }}</span>
                @endif
            </a>
            <a href="{{ route('rekap.index') }}" class="{{ request()->routeIs('rekap.index') ? 'active' : '' }}">Rekap Laporan</a>
        @endif

    </div>

    <a class="logout" href="{{ route('logout') }}" onclick="return confirm('Yakin ingin logout?')">Logout</a>
</aside>
