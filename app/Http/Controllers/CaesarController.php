<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaesarController extends Controller
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

    private function caesarEncrypt($text, $key)
    {
        $shift = $this->getShiftFromKey($key);
        $result = '';

        for ($i = 0; $i < strlen($text); $i++) {
            $ch = $text[$i];

            if (ctype_upper($ch)) {
                $result .= chr(((ord($ch) - 65 + $shift) % 26) + 65);
            } elseif (ctype_lower($ch)) {
                $result .= chr(((ord($ch) - 97 + $shift) % 26) + 97);
            } else {
                $result .= $ch; // spasi & tanda baca tetap
            }
        }

        return $result;
    }

    public function index()
    {
        return view('enkripsi.caesar'); // halaman kosong
    }

    public function encrypt(Request $request)
    {
        // Validasi: plaintext dan key wajib diisi
        $request->validate([
            'plaintext' => 'required|string',
            'key' => 'required|string'
        ]);

        $plaintext = $request->input('plaintext');
        $key = $request->input('key');

        $ciphertext = $this->caesarEncrypt($plaintext, $key);

        return view('enkripsi.caesar', compact('plaintext', 'key', 'ciphertext'));
    }
}
