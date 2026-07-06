@extends('layouts.app')

@section('title', 'Lihat File')
@section('page_title', 'Lihat File')
@section('page_subtitle', $file)

@section('content')
    <div class="card" style="text-align:center;">
        <div class="actions" style="justify-content:center;">
            @if (session('role') === 'verifikator')
                <a href="{{ route('verifikasi.index') }}" class="btn btn-light">Kembali ke Verifikasi Laporan</a>
            @else
                <a href="{{ route('laporan.index') }}" class="btn btn-light">Kembali ke Kelola Laporan</a>
            @endif
            <a href="{{ route('files.download', ['file' => $file]) }}" class="btn btn-success">Download</a>
        </div>

        <p><strong>Nama File:</strong> {{ $file }}</p>
        <p><strong>Ekstensi:</strong> {{ $ext }}</p>

        @if (in_array($ext, ['jpg', 'png']))
            <img src="{{ asset('uploads/' . $file) }}" alt="Preview Gambar" style="max-width:100%; border-radius:12px;">
        @elseif ($ext === 'pdf')
            <iframe src="{{ asset('uploads/' . $file) }}" style="width:100%; height:650px; border:0; border-radius:12px;"></iframe>
        @elseif (in_array($ext, ['mp4']))
            <video controls preload="metadata" style="width:100%; max-height:650px; border-radius:12px; background:#000;">
                <source src="{{ asset('uploads/' . $file) }}">
                Browser tidak mendukung pemutar video. Silakan download file untuk melihat isinya.
            </video>
        @else
            <p>File ini tidak bisa dipreview. Silakan download file untuk melihat isinya.</p>
        @endif
    </div>
@endsection
