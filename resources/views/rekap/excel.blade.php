<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Laporan Excel</title>
    <style>
        table { border-collapse: collapse; }
        th, td { border: 1px solid #000000; padding: 5px; vertical-align: top; }
        th { background: #d9d9d9; font-weight: bold; text-align: center; }
        .kop1 { font-size: 14pt; text-align: center; border: none; }
        .kop2 { font-size: 16pt; font-weight: bold; text-align: center; border: none; }
        .kop3 { font-size: 11pt; font-style: italic; text-align: center; border: none; }
        .title { font-size: 14pt; font-weight: bold; text-align: center; text-decoration: underline; border: none; }
        .center { text-align: center; }
        .no-border { border: none; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>
    <table>
        <tr><td colspan="6" class="kop1">PEMERINTAH KABUPATEN GRESIK</td></tr>
        <tr><td colspan="6" class="kop2">KECAMATAN BUNGAH</td></tr>
        <tr><td colspan="6" class="kop3">Sistem Informasi Laporan Kegiatan</td></tr>
        <tr><td colspan="6" class="no-border"></td></tr>
        <tr><td colspan="6" class="title">REKAPITULASI LAPORAN KEGIATAN</td></tr>
        <tr><td colspan="6" class="no-border"></td></tr>
        
        <tr>
            <td colspan="2" class="no-border bold">Tahun</td>
            <td colspan="4" class="no-border">: {{ $tahun }}</td>
        </tr>
        <tr>
            <td colspan="2" class="no-border bold">Bulan</td>
            <td colspan="4" class="no-border">: 
                @if ($bulan)
                    {{ $rekapBulanan[$bulan - 1]['bulan'] }}
                @else
                    Semua Bulan
                @endif
            </td>
        </tr>
        <tr><td colspan="6" class="no-border"></td></tr>
    </table>

    <table>
        <tr><td colspan="3" class="no-border bold">A. REKAP KEGIATAN PER BULAN</td></tr>
        <tr>
            <th style="width: 50px;">No</th>
            <th style="width: 150px;">Bulan</th>
            <th style="width: 150px;">Jumlah Kegiatan</th>
        </tr>
        @foreach ($rekapBulanan as $rekap)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $rekap['bulan'] }}</td>
                <td class="center">{{ $rekap['jumlah'] }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="2" style="text-align: right;">TOTAL KESELURUHAN (TAHUN {{ $tahun }})</th>
            <th>{{ $totalTahun }}</th>
        </tr>
    </table>

    <table>
        <tr><td colspan="6" class="no-border"></td></tr>
        <tr><td colspan="6" class="no-border bold">B. DETAIL LAPORAN KEGIATAN</td></tr>
        <tr>
            <th style="width: 50px;">No</th>
            <th style="width: 200px;">Nama Kegiatan</th>
            <th style="width: 250px;">Deskripsi</th>
            <th style="width: 100px;">Tanggal</th>
            <th style="width: 200px;">Tempat</th>
            <th style="width: 100px;">Jam</th>
        </tr>
        @forelse ($laporan as $item)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $item->nama_kegiatan }}</td>
                <td>{{ $item->deskripsi_kegiatan ?: '-' }}</td>
                <td class="center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $item->tempat }}</td>
                <td class="center">{{ $item->jam }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="center">Tidak ada data laporan.</td>
            </tr>
        @endforelse
    </table>

    <table>
        <tr><td colspan="6" class="no-border"></td></tr>
        <tr>
            <td colspan="4" class="no-border"></td>
            <td colspan="2" class="center no-border">Gresik, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td colspan="4" class="no-border"></td>
            <td colspan="2" class="center no-border">Mengetahui,</td>
        </tr>
        <tr>
            <td colspan="4" class="no-border"></td>
            <td colspan="2" class="center no-border bold">Pimpinan / Camat Bungah</td>
        </tr>
        <tr><td colspan="6" class="no-border"></td></tr>
        <tr><td colspan="6" class="no-border"></td></tr>
        <tr><td colspan="6" class="no-border"></td></tr>
        <tr>
            <td colspan="4" class="no-border"></td>
            <td colspan="2" class="center no-border"><u>.......................................................</u></td>
        </tr>
        <tr>
            <td colspan="4" class="no-border"></td>
            <td colspan="2" class="center no-border">NIP. ........................................</td>
        </tr>
    </table>
</body>
</html>
