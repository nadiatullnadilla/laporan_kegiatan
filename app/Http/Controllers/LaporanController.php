<?php

namespace App\Http\Controllers;

use App\Models\FileLaporan;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('cari', '');
        $role = session('role');
        $totalRevisi = Laporan::where('status', 'revisi')->count();
        $totalMenunggu = Laporan::where('status', 'menunggu')->count();
        $laporan = Laporan::with('files')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('nama_kegiatan', 'like', "%{$keyword}%")
                        ->orWhere('tempat', 'like', "%{$keyword}%")
                        ->orWhere('tanggal', 'like', "%{$keyword}%")
                        ->orWhere('jam', 'like', "%{$keyword}%");
                });
            })
            ->when($role === 'verifikator', function ($query) {
                $query->orderByRaw("CASE WHEN status = 'menunggu' THEN 0 ELSE 1 END");
            })
            ->orderByDesc('id')
            ->get();

        return view('laporan.index', compact('laporan', 'keyword', 'role', 'totalRevisi', 'totalMenunggu'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function show(Laporan $laporan)
    {
        $laporan->load('files');

        return view('laporan.show', compact('laporan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'tempat' => ['required', 'string', 'max:255'],
            'jam' => ['required'],
            'dokumen.*' => ['nullable', 'file', 'mimes:pdf,png,jpg,mp4', 'max:512000'],
        ]);

        $laporan = Laporan::create([
            'nama_kegiatan' => $data['nama_kegiatan'],
            'tanggal' => $data['tanggal'],
            'tempat' => $data['tempat'],
            'jam' => $data['jam'],
            'dokumen' => '',
            'status' => 'menunggu',
        ]);

        $this->storeUploadedFiles($request, $laporan);
        return redirect()->route('laporan.index')->with('success', 'Data laporan berhasil disimpan.');
    }

    public function edit(Laporan $laporan)
    {
        $laporan->load('files');

        return view('laporan.edit', compact('laporan'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $data = $request->validate([
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'tempat' => ['required', 'string', 'max:255'],
            'jam' => ['required'],
            'dokumen.*' => ['nullable', 'file', 'mimes:pdf,png,jpg,mp4', 'max:512000'],
            'delete_files' => ['nullable', 'array'],
            'delete_files.*' => ['integer'],
        ]);

        $data['status'] = 'menunggu';
        $data['catatan_verifikator'] = null;

        if ($request->has('delete_files')) {
            $filesToDelete = $laporan->files()->whereIn('id', $request->input('delete_files'))->get();
            foreach ($filesToDelete as $file) {
                $file->delete();
            }
        }

        $laporan->update($data);
        $this->storeUploadedFiles($request, $laporan);
        return redirect()->route('laporan.index')->with('success', 'Data laporan berhasil diedit dan dikirim ulang untuk verifikasi.');
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->files()->delete();
        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Data laporan berhasil dihapus.');
    }

    private function storeUploadedFiles(Request $request, Laporan $laporan)
    {
        if (!$this->hasValidUploadedFiles($request)) {
            return;
        }

        foreach ($request->file('dokumen') as $index => $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }

            $name = time() . '_' . $index . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName());
            
            $mime = $file->getMimeType();
            $base64 = base64_encode(file_get_contents($file->getRealPath()));
            $fileContent = 'data:' . $mime . ';base64,' . $base64;

            FileLaporan::create([
                'laporan_id' => $laporan->id,
                'nama_file' => $name,
                'file_content' => $fileContent,
            ]);

            if (!$laporan->dokumen) {
                $laporan->update(['dokumen' => $name]);
            }
        }
    }

    private function hasValidUploadedFiles(Request $request)
    {
        if (!$request->hasFile('dokumen')) {
            return false;
        }

        foreach ((array) $request->file('dokumen') as $file) {
            if ($file && $file->isValid()) {
                return true;
            }
        }

        return false;
    }

    private function deleteUploadedFiles(Laporan $laporan)
    {
        $laporan->loadMissing('files');
        $laporan->files()->delete();
    }

}
