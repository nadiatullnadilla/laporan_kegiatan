<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FooterController extends Controller
{
    private const PATH = 'settings/footer.json';
    private const DEFAULT_TEXT = '✦ Developer by Nadiya';

    public function edit()
    {
        return view('cms.footer', [
            'footer_text' => $this->footerText(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'footer_text' => ['required', 'string', 'max:120'],
        ]);

        Storage::put(self::PATH, json_encode([
            'footer_text' => $data['footer_text'],
        ], JSON_PRETTY_PRINT));

        return redirect()->route('cms.footer.edit')->with('success', 'Footer berhasil diperbarui.');
    }

    private function footerText()
    {
        if (!Storage::exists(self::PATH)) {
            return self::DEFAULT_TEXT;
        }

        $data = json_decode(Storage::get(self::PATH), true);

        return $data['footer_text'] ?? self::DEFAULT_TEXT;
    }
}
