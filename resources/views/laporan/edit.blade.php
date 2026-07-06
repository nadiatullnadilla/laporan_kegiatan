@extends('layouts.app')

@section('title', 'Edit Laporan')
@section('page_title', 'Edit Laporan')
@section('page_subtitle', 'Ubah data laporan kegiatan sesuai kebutuhan.')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('laporan.update', $laporan) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('laporan.form', ['laporan' => $laporan])

            <div class="actions">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('laporan.index') }}" class="btn btn-light">Kembali</a>
            </div>
        </form>
    </div>
@endsection
