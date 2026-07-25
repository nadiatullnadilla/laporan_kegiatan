@extends('layouts.app')

@section('title', 'Rekap Laporan')
@section('page_title', 'Rekap Laporan')
@section('page_subtitle', 'Ringkasan laporan berdasarkan tahun dan bulan.')

@section('content')
    <div class="card">
        <div class="print-report-head print-only">
            <div class="print-report-kop">
                <img src="{{ asset('assets/logo-gresik.png') }}" alt="Logo Kabupaten Gresik" class="print-report-logo">
                <div>
                    <div class="print-report-agency">PEMERINTAH KABUPATEN GRESIK</div>
                    <div class="print-report-unit">KECAMATAN BUNGAH</div>
                    <div class="print-report-address">Rekap Laporan Kegiatan</div>
                </div>
                <div></div>
            </div>
            <h2>REKAP LAPORAN KEGIATAN</h2>
            <div class="print-report-meta">
                <span>Tahun: {{ $filter_tahun }}</span>
                <span>Bulan: {{ $filter_bulan ? $pilihan_bulan[$filter_bulan] : 'Semua Bulan' }}</span>
            </div>
        </div>

        <div class="rekap-toolbar">
            <form method="GET" class="toolbar rekap-filter">
                <select name="tahun">
                    @foreach ($pilihan_tahun as $tahun)
                        <option value="{{ $tahun }}" {{ $filter_tahun === $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
                <select name="bulan">
                    <option value="">Semua Bulan</option>
                    @foreach ($pilihan_bulan as $nomor_bulan => $nama_bulan)
                        <option value="{{ $nomor_bulan }}" {{ $filter_bulan === $nomor_bulan ? 'selected' : '' }}>{{ $nama_bulan }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Terapkan</button>
                <a href="{{ route('rekap.index') }}" class="btn btn-light">Reset</a>
            </form>

            <div class="actions export-actions">
                <details class="export-menu">
                    <summary class="btn btn-purple btn-icon-only" title="Pilih format export" aria-label="Pilih format export">
                        <svg class="btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9V3h12v6M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v7H6z"/></svg>
                    </summary>
                    <div class="export-menu-list">
                        <button onclick="window.print()" class="export-menu-item" type="button">
                            <svg class="btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM14 2v6h6M9 15h6M9 18h4"/></svg>
                            PDF
                        </button>
                        <a href="{{ route('rekap.word', ['tahun' => $filter_tahun, 'bulan' => $filter_bulan]) }}" class="export-menu-item">
                            <svg class="btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM14 2v6h6M7.5 12l1.6 6 1.9-4 1.9 4 1.6-6"/></svg>
                            Word
                        </a>
                        <a href="{{ route('rekap.excel', ['tahun' => $filter_tahun, 'bulan' => $filter_bulan]) }}" class="export-menu-item">
                            <svg class="btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM14 2v6h6M8 12l6 6M14 12l-6 6"/></svg>
                            Excel
                        </a>
                    </div>
                </details>
            </div>
        </div>

        <h3 class="section-title no-print">
            Detail Laporan {{ $filter_tahun }}
            @if ($filter_bulan)
                - {{ $pilihan_bulan[$filter_bulan] }}
            @endif
        </h3>
        <div class="table-wrap">
            <table>
                <tr>
                    <th>No</th><th>Nama Kegiatan</th><th>Tanggal</th><th>Tempat</th><th>Jam</th>
                </tr>
                @forelse ($laporan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a class="table-link" href="{{ route('laporan.show', $item) }}">
                                {{ $item->nama_kegiatan }}
                            </a>
                        </td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->tempat }}</td>
                        <td>{{ $item->jam }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="empty">Tidak ada data laporan.</td></tr>
                @endforelse
            </table>
        </div>

        <div class="print-signature print-only">
            <div></div>
            <div>
                <p>Bungah, {{ now()->format('d/m/Y') }}</p>
                <p>Verifikator</p>
                <strong>________________________</strong>
            </div>
        </div>
    </div>
@endsection
