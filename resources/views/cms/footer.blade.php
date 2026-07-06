@extends('layouts.app')

@section('title', 'CMS Footer')
@section('page_title', 'CMS Footer')
@section('page_subtitle', 'Ubah teks footer yang tampil di aplikasi.')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('cms.footer.update') }}">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="full">
                    <label>Teks Footer</label>
                    <input type="text" name="footer_text" value="{{ old('footer_text', $footer_text) }}" maxlength="120" required>
                </div>
            </div>

            <div class="actions" style="margin-top: 18px;">
                <button type="submit" class="btn btn-primary">Simpan Footer</button>
                <a href="{{ route('dashboard') }}" class="btn btn-light">Kembali</a>
            </div>
        </form>
    </div>
@endsection
