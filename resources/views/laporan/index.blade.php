
@extends('layouts.app')

@section('title', $role === 'verifikator' ? 'Verifikasi Laporan' : 'Kelola Laporan')
@section('page_title', $role === 'verifikator' ? 'Verifikasi Laporan' : 'Kelola Laporan')
@section('page_subtitle', $role === 'verifikator' ? 'Tinjau laporan dan tentukan status verifikasinya.' : 'Cari, edit, hapus, dan tinjau laporan kegiatan.')

@section('content')
    <div class="card manage-card">


        @if ($role === 'verifikator' && $totalMenunggu > 0)
            <div class="alert alert-warning compact-alert">
                Ada {{ $totalMenunggu }} laporan yang menunggu verifikasi.
            </div>
        @elseif ($role === 'admin' && $totalRevisi > 0)
            <div class="alert alert-warning compact-alert">
                Ada {{ $totalRevisi }} laporan yang perlu direvisi.
            </div>
        @endif

        <form method="GET" class="toolbar manage-toolbar">
            <input type="text" name="cari" class="search-input" placeholder="Cari nama kegiatan, tempat, tanggal, atau jam..." value="{{ $keyword }}">
            <button type="submit" class="btn btn-primary btn-compact">Cari</button>
            <a href="{{ route('laporan.index') }}" class="btn btn-danger btn-compact">Reset</a>
            @if ($role === 'admin')
                <a href="{{ route('laporan.create') }}" class="btn btn-success btn-compact">+ Tambah</a>
            @endif

        </form>

        <div class="table-wrap">
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
                                <span class="file-badge">Tidak ada file</span>
                            @endif
                        </td>
                        <td data-label="Status"><span class="badge {{ $item->status }}">{{ $item->status }}</span></td>
                        <td data-label="Catatan">{{ $item->catatan_verifikator ?: '-' }}</td>
                        <td data-label="Aksi" class="no-print action-cell">
                            <div class="actions table-actions {{ $role === 'verifikator' ? 'verification-actions' : '' }}">
                                @if ($role === 'admin')
                                    <a class="btn btn-success btn-compact" href="{{ route('laporan.edit', $item) }}">Edit</a>
                                    <form method="POST" action="{{ route('laporan.destroy', $item) }}" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-compact" type="submit">Hapus</button>
                                    </form>
                                @endif

                                @if ($role === 'verifikator')
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
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="empty">Data laporan tidak ditemukan</td></tr>
                @endforelse
            </table>
        </div>


    </div>
@endsection
