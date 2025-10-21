<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Caesar_dekripsiController extends Controller
{
    // 🔹 Konversi angka menjadi huruf sesuai pola 1=B, 2=C, ..., 9=J, 0=A
    private function convertNumericKey($key)
    {
        $converted = '';
        $key = strtoupper($key);

        for ($i = 0; $i < strlen($key); $i++) {
            $ch = $key[$i];

            if (ctype_digit($ch)) {
                // 0 → A, 1 → B, dst
                if ($ch === '0') {
                    $converted .= 'A';
                } else {
                    $converted .= chr(64 + intval($ch) + 1);
                }
            } else {
                $converted .= $ch; // huruf tetap
            }
        }

        return $converted;
    }

    // 🔹 Hitung total shift berdasarkan key (huruf + angka yang dikonversi)
    private function getShiftFromKey($key)
    {
        // Jika key hanya angka besar (contoh: 123456789012345)
        // langsung ubah menjadi int dan mod 26 agar efisien
        if (ctype_digit($key)) {
            return intval($key) % 26;
        }

        // Jika kombinasi huruf + angka, konversi angka dulu
        $convertedKey = $this->convertNumericKey($key);
        $sum = 0;
        $convertedKey = strtoupper($convertedKey);

        for ($i = 0; $i < strlen($convertedKey); $i++) {
            $ch = $convertedKey[$i];
            if ($ch >= 'A' && $ch <= 'Z') {
                $sum += ord($ch) - 65; // A=0, B=1, ..., Z=25
            }
        }

        return $sum % 26;
    }

    // 🔹 Fungsi Dekripsi Caesar
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

    // 🔹 Tampilkan halaman form dekripsi Caesar
    public function index()
    {
        return view('dekripsi.caesar_dekripsi');
    }

    // 🔹 Proses dekripsi Caesar
    public function decrypt(Request $request)
    {
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
