@extends('layouts.app')

@section('title', 'Verifikasi Laporan')
@section('page_title', 'Verifikasi Laporan')
@section('page_subtitle', 'Tinjau laporan dan tentukan status verifikasinya.')

@section('content')
    @if ($totalMenunggu > 0)
        <div class="alert alert-warning">
            Ada {{ $totalMenunggu }} laporan yang menunggu verifikasi.
        </div>
    @else
        <div class="alert alert-info">
            Tidak ada laporan yang menunggu verifikasi.
        </div>
    @endif

    <div class="card">
        <div class="actions no-print">
            <details class="export-menu">
                <summary class="btn btn-purple btn-compact" title="Pilih format cetak" aria-label="Pilih format cetak">
                    Cetak
                </summary>
                <div class="export-menu-list">
                    <button onclick="window.print()" class="export-menu-item" type="button">
                        <svg class="btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM14 2v6h6M9 15h6M9 18h4"/></svg>
                        PDF
                    </button>
                    <a href="{{ route('rekap.word') }}" class="export-menu-item">
                        <svg class="btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM14 2v6h6M7.5 12l1.6 6 1.9-4 1.9 4 1.6-6"/></svg>
                        Word
                    </a>
                    <a href="{{ route('rekap.excel') }}" class="export-menu-item">
                        <svg class="btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2-2V8zM14 2v6h6M8 12l6 6M14 12l-6 6"/></svg>
                        Excel
                    </a>
                </div>
            </details>
        </div>

        <div class="table-wrap activity-scroll">
            <table class="report-table">
                <tr>
                    <th>No</th><th>Nama Kegiatan</th><th>Tanggal</th><th>Tempat</th><th>Jam</th><th>Dokumen</th><th>Status</th><th>Catatan</th><th class="no-print">Aksi</th>
                </tr>
                @forelse ($laporan as $item)
                    <tr>
                        <td data-label="No">{{ $loop->iteration }}</td>
                        <td data-label="Nama Kegiatan">
                            <a class="table-link" href="{{ route('laporan.show', $item) }}">
                                {{ $item->nama_kegiatan }}
                            </a>
                        </td>
                        <td data-label="Tanggal">{{ $item->tanggal }}</td>
                        <td data-label="Tempat">{{ $item->tempat }}</td>
                        <td data-label="Jam">{{ $item->jam }}</td>
                        <td data-label="Dokumen">
                            @if ($item->files->count())
                                <button type="button" class="file-badge file-modal-trigger" data-modal-target="files-modal-{{ $item->id }}">
                                    Lihat {{ $item->files->count() > 1 ? $item->files->count() . ' File' : 'File' }}
                                </button>
                                <div class="modal-overlay" id="files-modal-{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="dialog" aria-modal="true" aria-labelledby="files-modal-title-{{ $item->id }}">
                                        <div class="modal-head">
                                            <div>
                                                <h3 id="files-modal-title-{{ $item->id }}">Dokumen Kegiatan</h3>
                                                <span>{{ $item->nama_kegiatan }}</span>
                                            </div>
                                            <button type="button" class="modal-close" data-modal-close aria-label="Tutup">x</button>
                                        </div>
                                        <div class="file-modal-list">
                                        @foreach ($item->files as $file)
                                            @php
                                                $ext = strtolower(pathinfo($file->nama_file, PATHINFO_EXTENSION));
                                                $fileType = in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'webm']) ? 'video' : (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']) ? 'image' : 'doc');
                                            @endphp
                                            <a class="file-menu-row" href="{{ route('files.preview', ['file' => $file->nama_file]) }}" target="_blank">
                                                <span class="file-type-icon {{ $fileType }}">{{ $fileType === 'video' ? 'VID' : ($fileType === 'image' ? 'IMG' : 'DOC') }}</span>
                                                <span class="file-row-name">{{ $file->nama_file }}</span>
                                                <span class="file-row-meta">Anda membuka - {{ $item->tanggal }}</span>
                                            </a>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                -
                            @endif
                        </td>
                        <td data-label="Status"><span class="badge {{ $item->status }}">{{ $item->status }}</span></td>
                        <td data-label="Catatan">{{ $item->catatan_verifikator ?: '-' }}</td>
                        <td data-label="Aksi" class="no-print action-cell">
                            <div class="actions table-actions verification-actions">
                                @if ($item->status !== 'disetujui')
                                    <form method="POST" action="{{ route('verifikasi.update', [$item, 'setujui']) }}" onsubmit="return confirm('Setujui laporan ini?')">
                                        @csrf
                                        <button class="btn btn-success btn-compact" type="submit">Setujui</button>
                                    </form>
                                @endif
                                @if ($item->status !== 'revisi')
                                    <form method="POST" action="{{ route('verifikasi.update', [$item, 'revisi']) }}" class="revision-prompt-form">
                                        @csrf
                                        <input type="hidden" name="catatan_verifikator" value="">
                                        <button class="btn btn-danger btn-compact" type="submit" data-revision-prompt>Revisi</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="empty">Belum ada laporan yang tersedia.</td></tr>
                @endforelse
            </table>
        </div>
    </div>
@endsection
