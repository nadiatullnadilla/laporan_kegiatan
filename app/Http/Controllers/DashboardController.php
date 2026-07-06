<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\FileLaporan;

class DashboardController extends Controller
{
    public function index()
    {
        $role = session('role');

        return view('dashboard', [
            'total_laporan' => Laporan::count(),
            'total_file' => FileLaporan::count(),
            'total_hari_ini' => Laporan::whereDate('tanggal', now()->toDateString())->count(),
            'total_menunggu' => Laporan::where('status', 'menunggu')->count(),
            'total_disetujui' => Laporan::where('status', 'disetujui')->count(),
            'total_revisi' => Laporan::where('status', 'revisi')->count(),
            'laporan_terbaru' => Laporan::orderByDesc('id')->limit(5)->get(),
            'laporan_menunggu' => Laporan::where('status', 'menunggu')->orderByDesc('id')->limit(5)->get(),
            'role' => $role,
            'username' => session('username'),
        ]);
    } 
}
