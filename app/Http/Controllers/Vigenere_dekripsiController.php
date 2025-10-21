<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Vigenere_dekripsiController extends Controller
{
    // 🔐 Fungsi untuk konversi key (angka → huruf)
    private function convertKey($key)
    {
        $converted = '';
        foreach (str_split($key) as $char) {
            if (ctype_digit($char)) {
                // 0 = A, 1 = B, 2 = C, dst (sesuai urutan alfabet)
                $num = intval($char);
                $converted .= chr(($num % 26) + 65);
            } else {
                $converted .= strtoupper($char);
            }
        }
        return $converted;
    }

    // 🧩 Fungsi dekripsi Vigenere Auto-Key (gabungan huruf + angka)
    private function vigenereAutoDecrypt($ciphertext, $key)
    {
        $ciphertext = strtoupper($ciphertext);
        $key = $this->convertKey(strtoupper($key)); // konversi angka jadi huruf
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $mod = strlen($alphabet); // 26 huruf

        $plaintext = '';
        $keyStream = $key;
        $j = 0;

        for ($i = 0; $i < strlen($ciphertext); $i++) {
            $c = $ciphertext[$i];
            $cIndex = strpos($alphabet, $c);

            if ($cIndex !== false) {
                $kIndex = strpos($alphabet, $keyStream[$j]);
                if ($kIndex === false) $kIndex = 0;

                // Dekripsi: (C - K + 26) % 26
                $pIndex = ($cIndex - $kIndex + $mod) % $mod;
                $p = $alphabet[$pIndex];
                $plaintext .= $p;

                // auto-key → tambahkan hasil dekripsi ke keyStream
                $keyStream .= $p;
                $j++;
            } else {
                // karakter non-alfabet langsung disalin
                $plaintext .= $c;
            }
        }

        return $plaintext;
    }

    // 🔄 Tampilkan form dekripsi
    public function indexDecrypt()
    {
        return view('dekripsi.vigenere_dekripsi');
    }

    // 🧮 Proses dekripsi dari input user
    public function decrypt(Request $request)
    {
        $request->validate([
            'ciphertext' => 'required|string',
            'key' => 'required|string'
        ]);

        $ciphertext = $request->input('ciphertext');
        $key = $request->input('key');

        $plaintext = $this->vigenereAutoDecrypt($ciphertext, $key);

        return view('dekripsi.vigenere_dekripsi', compact('ciphertext', 'key', 'plaintext'));
    }
}
