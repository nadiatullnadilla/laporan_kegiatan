@extends('layouts.app')

@section('title', 'Input Laporan')
@section('page_title', 'Input Laporan')
@section('page_subtitle', 'Tambahkan laporan kegiatan baru.')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data">
            @csrf
            @include('laporan.form', ['laporan' => null])
            <div class="actions">
                <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                <a href="{{ route('dashboard') }}" class="btn btn-light">Batal / Kembali</a>
            </div>
        </form>
    </div>
@endsection
