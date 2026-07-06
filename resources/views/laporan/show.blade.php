@extends('layouts.app')

@section('title', 'Detail Laporan')
@section('page_title', 'Detail Laporan')
@section('page_subtitle', $laporan->nama_kegiatan)

@section('content')
    <div class="hero">
        <span>Informasi Kegiatan</span>
        <h2>{{ $laporan->nama_kegiatan }}</h2>
        <p>Detail data kegiatan, status verifikasi, catatan, dan dokumen pendukung.</p>
    </div>

    <div class="card">
        <div class="actions">
            <a href="{{ route('dashboard') }}" class="btn btn-light">Kembali ke Dashboard</a>
            @if (session('role') === 'admin')
                <a href="{{ route('laporan.index') }}" class="btn btn-light">Kelola Laporan</a>
                <a href="{{ route('laporan.edit', $laporan) }}" class="btn btn-primary">Edit Laporan</a>
            @else
                <a href="{{ route('verifikasi.index') }}" class="btn btn-primary">Buka Verifikasi</a>
            @endif
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <span>Nama Kegiatan</span>
                <strong>{{ $laporan->nama_kegiatan }}</strong>
            </div>
            <div class="detail-item">
                <span>Status</span>
                <strong><span class="badge {{ $laporan->status }}">{{ $laporan->status }}</span></strong>
            </div>
            <div class="detail-item">
                <span>Tanggal</span>
                <strong>{{ $laporan->tanggal }}</strong>
            </div>
            <div class="detail-item">
                <span>Jam</span>
                <strong>{{ $laporan->jam }}</strong>
            </div>
            <div class="detail-item full">
                <span>Tempat</span>
                <p>{{ $laporan->tempat }}</p>
            </div>
            <div class="detail-item full">
                <span>Catatan Verifikator</span>
                <p>{{ $laporan->catatan_verifikator ?: '-' }}</p>
            </div>
            <div class="detail-item full">
                <span>Dokumen Pendukung</span>
                <div class="file-modal-list detail-file-list">
                    @forelse ($laporan->files as $file)
                        @php
                            $ext = strtolower(pathinfo($file->nama_file, PATHINFO_EXTENSION));
                            $fileType = in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'webm']) ? 'video' : (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']) ? 'image' : 'doc');
                        @endphp
                        <a class="file-menu-row" href="{{ route('files.preview', ['file' => $file->nama_file]) }}" target="_blank">
                            <span class="file-type-icon {{ $fileType }}">{{ $fileType === 'video' ? 'VID' : ($fileType === 'image' ? 'IMG' : 'DOC') }}</span>
                            <span class="file-row-name">{{ $file->nama_file }}</span>
                            <span class="file-row-meta">Anda membuka - {{ $laporan->tanggal }}</span>
                        </a>
                    @empty
                        <p>Tidak ada dokumen.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
