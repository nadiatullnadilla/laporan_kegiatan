<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        $totalMenunggu = Laporan::where('status', 'menunggu')->count();
        $laporan = Laporan::with('files')
            ->orderByRaw("CASE WHEN status = 'menunggu' THEN 0 ELSE 1 END")
            ->orderByDesc('id')
            ->get();

        return view('verifikasi.index', compact('laporan', 'totalMenunggu'));
    }

    public function update(Request $request, Laporan $laporan, string $aksi)
    {
        if (!in_array($aksi, ['setujui', 'revisi'], true)) {
            return redirect()->route('laporan.index');
        }

        $disetujui = $aksi === 'setujui';
        $data = [
            'status' => $disetujui ? 'disetujui' : 'revisi',
            'catatan_verifikator' => null,
        ];

        if (!$disetujui) {
            $validated = $request->validate([
                'catatan_verifikator' => ['required', 'string', 'max:1000'],
            ], [
                'catatan_verifikator.required' => 'Catatan revisi wajib diisi.',
                'catatan_verifikator.max' => 'Catatan revisi maksimal 1000 karakter.',
            ]);

            $data['catatan_verifikator'] = $validated['catatan_verifikator'];
        }

        $laporan->update([
            'status' => $data['status'],
            'catatan_verifikator' => $data['catatan_verifikator'],
        ]);

        return redirect()->route('laporan.index')->with('success', 'Status laporan berhasil diperbarui.');
    }
}
