<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileController extends Controller
{
    public function preview(Request $request)
    {
        $file = basename($request->get('file', ''));
        abort_if($file === '' || !File::exists(public_path('uploads/' . $file)), 404);

        return view('files.preview', [
            'file' => $file,
            'ext' => strtolower(pathinfo($file, PATHINFO_EXTENSION)),
        ]);
    }

    public function download(Request $request)
    {
        $file = basename($request->get('file', ''));
        $path = public_path('uploads/' . $file);
        abort_if($file === '' || !File::exists($path), 404);

        return response()->download($path);
    }
}
