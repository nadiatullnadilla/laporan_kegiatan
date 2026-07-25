<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileController extends Controller
{
    public function preview(Request $request)
    {
        $fileName = basename($request->get('file', ''));
        $fileModel = \App\Models\FileLaporan::where('nama_file', $fileName)->firstOrFail();

        return view('files.preview', [
            'file' => $fileModel->nama_file,
            'ext' => strtolower(pathinfo($fileModel->nama_file, PATHINFO_EXTENSION)),
            'fileModel' => $fileModel,
        ]);
    }

    public function download(Request $request)
    {
        $fileName = basename($request->get('file', ''));
        $fileModel = \App\Models\FileLaporan::where('nama_file', $fileName)->firstOrFail();

        $parts = explode(',', $fileModel->file_content);
        $base64Data = $parts[1] ?? '';
        $decoded = base64_decode($base64Data);

        $mime = 'application/octet-stream';
        if (preg_match('/^data:(.*?);base64/', $parts[0] ?? '', $matches)) {
            $mime = $matches[1];
        }

        return response($decoded)
            ->header('Content-Type', $mime)
            ->header('Content-Disposition', 'attachment; filename="' . $fileModel->nama_file . '"');
    }
}
