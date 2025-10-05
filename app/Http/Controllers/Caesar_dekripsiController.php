<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Caesar_dekripsiController extends Controller
{
    private function getShiftFromKey($key)
    {
        $sum = 0;
        $key = strtoupper($key);

        for ($i = 0; $i < strlen($key); $i++) {
            $ch = $key[$i];
            if ($ch >= 'A' && $ch <= 'Z') {
                $sum += ord($ch) - 65; // A=0, B=1, ..., Z=25
            }
        }

        return $sum % 26;
    }

    private function caesarDecrypt($text, $key)
    {
        $shift = $this->getShiftFromKey($key);
        $result = '';

        for ($i = 0; $i < strlen($text); $i++) {
            $ch = $text[$i];

            if (ctype_upper($ch)) {
                $result .= chr(((ord($ch) - 65 - $shift + 26) % 26) + 65);
            } elseif (ctype_lower($ch)) {
                $result .= chr(((ord($ch) - 97 - $shift + 26) % 26) + 97);
            } else {
                $result .= $ch; // spasi & tanda baca tetap
            }
        }

        return $result;
    }

    public function index()
    {
        return view('dekripsi.caesar_dekripsi'); // halaman kosong
    }

    public function decrypt(Request $request)
    {
        // Validasi: ciphertext dan key wajib diisi
        $request->validate([
            'ciphertext' => 'required|string',
            'key' => 'required|string'
        ]);

        $ciphertext = $request->input('ciphertext');
        $key = $request->input('key');

        $plaintext = $this->caesarDecrypt($ciphertext, $key);

        return view('dekripsi.caesar_dekripsi', compact('ciphertext', 'key', 'plaintext'));
    }
}
