<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $this->validYear($request->get('tahun', now()->year));
        $bulan = $this->validMonth($request->get('bulan', ''));
        $laporan = $this->query($tahun, $bulan)->get();
        $rekapBulanan = $this->monthlyRecap($tahun);

        return view('rekap.index', [
            'laporan' => $laporan,
            'filter_tahun' => $tahun,
            'filter_bulan' => $bulan,
            'pilihan_tahun' => $this->yearOptions(),
            'pilihan_bulan' => $this->monthOptions(),
            'rekap_bulanan' => $rekapBulanan,
            'total_tahun' => array_sum(array_column($rekapBulanan, 'jumlah')),
            'total' => Laporan::count(),
        ]);
    }

    public function exportWord(Request $request)
    {
        $tahun = $this->validYear($request->get('tahun', now()->year));
        $bulan = $this->validMonth($request->get('bulan', ''));
        $laporan = $this->query($tahun, $bulan)->get();
        $rekapBulanan = $this->monthlyRecap($tahun);
        $totalTahun = array_sum(array_column($rekapBulanan, 'jumlah'));

        return response()
            ->view('rekap.word', compact('laporan', 'tahun', 'bulan', 'rekapBulanan', 'totalTahun'))
            ->header('Content-Type', 'application/msword')
            ->header('Content-Disposition', 'attachment; filename=rekap_laporan.doc');
    }

    public function exportExcel(Request $request)
    {
        $tahun = $this->validYear($request->get('tahun', now()->year));
        $bulan = $this->validMonth($request->get('bulan', ''));
        $laporan = $this->query($tahun, $bulan)->get();
        $rekapBulanan = $this->monthlyRecap($tahun);
        $totalTahun = array_sum(array_column($rekapBulanan, 'jumlah'));
        $fileName = 'rekap_laporan_' . $tahun . ($bulan ? '_' . str_pad($bulan, 2, '0', STR_PAD_LEFT) : '') . '.xls';

        return response()
            ->view('rekap.excel', compact('laporan', 'tahun', 'bulan', 'rekapBulanan', 'totalTahun'))
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename=' . $fileName)
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    private function query($tahun, $bulan = '')
    {
        return Laporan::whereYear('tanggal', $tahun)
            ->when($bulan, fn ($query) => $query->whereMonth('tanggal', $bulan))
            ->orderByDesc('tanggal')
            ->orderByDesc('id');
    }

    private function monthlyRecap($tahun)
    {
        $counts = Laporan::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as jumlah')
            ->whereYear('tanggal', $tahun)
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->pluck('jumlah', 'bulan')
            ->toArray();

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $recap = [];
        foreach ($months as $number => $name) {
            $recap[] = [
                'bulan' => $name,
                'jumlah' => (int) ($counts[$number] ?? 0),
            ];
        }

        return $recap;
    }

    private function yearOptions()
    {
        $dataYears = Laporan::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun')
            ->filter()
            ->map(fn ($year) => (int) $year)
            ->toArray();

        $rangeYears = range(now()->year + 1, 2026);
        $years = array_unique(array_merge($rangeYears, array_filter($dataYears, fn ($year) => $year >= 2026)));
        rsort($years);

        return $years;
    }

    private function monthOptions()
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    }

    private function validYear($year)
    {
        $year = (int) $year;

        if ($year < 2026 || $year > 2100) {
            return now()->year;
        }

        return $year;
    }

    private function validMonth($month)
    {
        if ($month === '' || $month === null) {
            return '';
        }

        $month = (int) $month;

        return $month >= 1 && $month <= 12 ? $month : '';
    }

}
