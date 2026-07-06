<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Laporan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2, p { text-align: center; margin: 0; }
        p { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; font-size: 12px; }
        th { background: #eeeeee; }
    </style>
</head>
<body>
    <h2>Rekap Laporan Kegiatan</h2>
    <p>Tahun: {{ $tahun }}</p>
    <p>Bulan:
        @if ($bulan)
            {{ $rekapBulanan[$bulan - 1]['bulan'] }}
        @else
            Semua Bulan
        @endif
    </p>

    <h3>Rekap Kegiatan Per Bulan</h3>
    <table>
        <tr>
            <th>No</th><th>Bulan</th><th>Jumlah Kegiatan</th>
        </tr>
        @foreach ($rekapBulanan as $rekap)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $rekap['bulan'] }}</td>
                <td>{{ $rekap['jumlah'] }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="2">Total Tahun {{ $tahun }}</th>
            <th>{{ $totalTahun }}</th>
        </tr>
    </table>

    <h3>Detail Laporan</h3>
    <table>
        <tr>
            <th>No</th><th>Nama Kegiatan</th><th>Tanggal</th><th>Tempat</th><th>Jam</th>
        </tr>
        @forelse ($laporan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_kegiatan }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->tempat }}</td>
                <td>{{ $item->jam }}</td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align:center;">Tidak ada data laporan.</td></tr>
        @endforelse
    </table>
</body>
</html>
