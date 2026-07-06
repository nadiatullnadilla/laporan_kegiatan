<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Laporan Excel</title>
    <style>
        table { border-collapse: collapse; }
        th, td { border: 1px solid #000000; padding: 6px; }
        th { background: #eeeeee; font-weight: bold; }
        .title { font-size: 16px; font-weight: bold; text-align: center; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="6" class="title">Rekap Laporan Kegiatan</td>
        </tr>
        <tr>
            <td colspan="2">Tahun</td>
            <td colspan="4">{{ $tahun }}</td>
        </tr>
        <tr>
            <td colspan="2">Bulan</td>
            <td colspan="4">
                @if ($bulan)
                    {{ $rekapBulanan[$bulan - 1]['bulan'] }}
                @else
                    Semua Bulan
                @endif
            </td>
        </tr>
    </table>

    <br>

    <table>
        <tr>
            <th colspan="3">Rekap Kegiatan Per Bulan</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Bulan</th>
            <th>Jumlah Kegiatan</th>
        </tr>
        @foreach ($rekapBulanan as $rekap)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $rekap['bulan'] }}</td>
                <td class="center">{{ $rekap['jumlah'] }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="2">Total Tahun {{ $tahun }}</th>
            <th>{{ $totalTahun }}</th>
        </tr>
    </table>

    <br>

    <table>
        <tr>
            <th colspan="6">Detail Laporan</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Kegiatan</th>
            <th>Deskripsi</th>
            <th>Tanggal</th>
            <th>Tempat</th>
            <th>Jam</th>
        </tr>
        @forelse ($laporan as $item)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $item->nama_kegiatan }}</td>
                <td>{{ $item->deskripsi_kegiatan ?: '-' }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->tempat }}</td>
                <td>{{ $item->jam }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="center">Tidak ada data laporan.</td>
            </tr>
        @endforelse
    </table>
</body>
</html>
