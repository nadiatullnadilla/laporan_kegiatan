@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Ringkasan utama laporan kegiatan.')

@section('content')
    @php
        $dashboardLaporan = $role === 'verifikator' ? $laporan_menunggu : $laporan_terbaru;
    @endphp

    <div class="dashboard-shell">
        <div class="metric-grid">
            <div class="metric-card">
                <div class="metric-head">
                    <span>{{ $role === 'verifikator' ? 'Menunggu Verifikasi' : 'Total Laporan' }}</span>
                    <div class="metric-chip">{{ $role === 'verifikator' ? 'MV' : 'TL' }}</div>
                </div>
                <h3>{{ $role === 'verifikator' ? $total_menunggu : $total_laporan }}</h3>
            </div>
            <div class="metric-card">
                <div class="metric-head">
                    <span>{{ $role === 'verifikator' ? 'Sudah Disetujui' : 'Total Dokumen' }}</span>
                    <div class="metric-chip">{{ $role === 'verifikator' ? 'SD' : 'DK' }}</div>
                </div>
                <h3>{{ $role === 'verifikator' ? $total_disetujui : $total_file }}</h3>
            </div>
            <div class="metric-card">
                <div class="metric-head">
                    <span>{{ $role === 'verifikator' ? 'Perlu Revisi' : 'Laporan Hari Ini' }}</span>
                    <div class="metric-chip">{{ $role === 'verifikator' ? 'RV' : 'HI' }}</div>
                </div>
                <h3>{{ $role === 'verifikator' ? $total_revisi : $total_hari_ini }}</h3>
            </div>
        </div>

        <div class="dashboard-table">
            <div class="card">
                <div class="dashboard-card-head">
                    <h3>{{ $role === 'verifikator' ? 'Menunggu Verifikasi' : 'Laporan Terbaru' }}</h3>
                    <span>{{ $role === 'verifikator' ? '5 antrean terbaru' : '5 data terakhir' }}</span>
                </div>
                <div class="table-wrap recent-table">
                    <table class="report-table">
                        <tr>
                            <th>No</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        @forelse ($dashboardLaporan as $item)
                            <tr>
                                <td data-label="No">{{ $loop->iteration }}</td>
                                <td data-label="Nama Kegiatan">
                                    <a class="table-link" href="{{ route('laporan.show', $item) }}">
                                        {{ $item->nama_kegiatan }}
                                    </a>
                                </td>
                                <td data-label="Tanggal">{{ $item->tanggal }}</td>
                                <td data-label="Status"><span class="badge {{ $item->status }}">{{ $item->status }}</span></td>
                                <td data-label="Aksi" class="dashboard-action-cell">
                                    <a class="btn btn-primary btn-compact dashboard-action-btn" href="{{ route('laporan.show', $item) }}">
                                        {{ $role === 'verifikator' ? 'Cek' : 'Lihat' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty">
                                    {{ $role === 'verifikator' ? 'Tidak ada laporan yang menunggu verifikasi.' : 'Belum ada laporan terbaru.' }}
                                </td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
