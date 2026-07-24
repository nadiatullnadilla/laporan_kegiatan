<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Laporan</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; }
        .kop-surat h3 { margin: 0; font-size: 14pt; font-weight: normal; }
        .kop-surat h2 { margin: 0; font-size: 16pt; font-weight: bold; }
        .kop-surat p { margin: 5px 0 0 0; font-size: 11pt; font-style: italic; }
        .kop-table { width: 100%; border-bottom: 3px solid black; padding-bottom: 10px; margin-bottom: 20px; border: none; }
        .kop-table td { border: none; vertical-align: middle; }
        .title { text-align: center; font-weight: bold; margin-bottom: 20px; text-decoration: underline; font-size: 14pt; }
        .info-text { margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 6px; font-size: 11pt; vertical-align: top; }
        th { background: #e0e0e0; font-weight: bold; text-align: center; }
        .center { text-align: center; }
        .ttd { width: 100%; border: none; margin-top: 30px; }
        .ttd td { border: none; padding: 0; }
    </style>
</head>
<body>
    @php
        $logoPath = public_path('assets/logo-gresik.png');
        $logoData = '';
        if (file_exists($logoPath)) {
            $logoData = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }
    @endphp
    <table class="kop-table">
        <tr>
            <td style="width: 15%; text-align: center;">
                @if($logoData)
                    <img src="{{ $logoData }}" style="width: 75px; height: auto;">
                @endif
            </td>
            <td style="width: 85%; text-align: center;" class="kop-surat">
                <h3>PEMERINTAH KABUPATEN GRESIK</h3>
                <h2>KECAMATAN BUNGAH</h2>
                <p>Sistem Informasi Laporan Kegiatan</p>
            </td>
        </tr>
    </table>

    <div class="title">REKAPITULASI LAPORAN KEGIATAN</div>

    <div class="info-text">
        <strong>Tahun :</strong> {{ $tahun }} <br>
        <strong>Bulan :</strong> 
        @if ($bulan)
            {{ $rekapBulanan[$bulan - 1]['bulan'] }}
        @else
            Semua Bulan
        @endif
    </div>

    <h4 style="margin-bottom: 5px;">A. REKAP KEGIATAN PER BULAN</h4>
    <table>
        <tr>
            <th style="width: 10%;">No</th>
            <th style="width: 45%;">Bulan</th>
            <th style="width: 45%;">Jumlah Kegiatan</th>
        </tr>
        @foreach ($rekapBulanan as $rekap)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $rekap['bulan'] }}</td>
                <td class="center">{{ $rekap['jumlah'] }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="2" style="text-align: right; padding-right: 15px;">TOTAL KESELURUHAN (TAHUN {{ $tahun }})</th>
            <th>{{ $totalTahun }}</th>
        </tr>
    </table>

    <h4 style="margin-bottom: 5px;">B. DETAIL LAPORAN KEGIATAN</h4>
    <table>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 30%;">Nama Kegiatan</th>
            <th style="width: 15%;">Tanggal</th>
            <th style="width: 15%;">Jam</th>
            <th style="width: 35%;">Tempat</th>
        </tr>
        @forelse ($laporan as $item)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $item->nama_kegiatan }}</td>
                <td class="center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                <td class="center">{{ $item->jam }}</td>
                <td>{{ $item->tempat }}</td>
            </tr>
        @empty
            <tr><td colspan="5" class="center"><i>Tidak ada data laporan.</i></td></tr>
        @endforelse
    </table>

    <table class="ttd">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%; text-align: center;">
                <p>Gresik, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p style="margin-bottom: 70px;">Mengetahui,<br><strong>Pimpinan / Camat Bungah</strong></p>
                <p><u>.......................................................</u><br>NIP. ........................................</p>
            </td>
        </tr>
    </table>
</body>
</html>
