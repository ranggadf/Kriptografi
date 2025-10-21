<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaesarController extends Controller
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

    // 🔹 Fungsi Enkripsi Caesar
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

    // 🔹 Halaman form Caesar
    public function index()
    {
        return view('enkripsi.caesar');
    }

    // 🔹 Proses enkripsi
    public function encrypt(Request $request)
    {
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
