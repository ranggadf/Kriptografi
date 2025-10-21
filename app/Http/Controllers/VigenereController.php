<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VigenereController extends Controller
{
    // Tampilkan form
    public function index()
    {
        return view('enkripsi.vigenere');
    }

    // Proses enkripsi (huruf + angka kombinasi)
    public function encrypt(Request $request)
    {
        $plaintext = strtoupper($request->input('plaintext'));
        $keyInput = strtoupper($request->input('key'));

        // Konversi angka dalam key ke huruf
        // Contoh: r28 → RCI
        $keyConverted = '';
        for ($i = 0; $i < strlen($keyInput); $i++) {
            $char = $keyInput[$i];
            if (ctype_digit($char)) {
                $digit = intval($char);
                $keyConverted .= chr(65 + $digit); // 1=B, 2=C, 8=I, dst
            } else {
                $keyConverted .= $char; // huruf tetap huruf
            }
        }

        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $mod = strlen($alphabet);

        // Buat auto key (hingga panjang = plaintext)
        $autoKey = $keyConverted;
        $i = 0;
        while (strlen($autoKey) < strlen($plaintext)) {
            $autoKey .= $plaintext[$i];
            $i++;
        }

        // Enkripsi
        $ciphertext = '';
        for ($j = 0; $j < strlen($plaintext); $j++) {
            $p = $plaintext[$j];
            $k = $autoKey[$j];

            $pIndex = strpos($alphabet, $p);
            $kIndex = strpos($alphabet, $k);

            if ($pIndex !== false && $kIndex !== false) {
                $cIndex = ($pIndex + $kIndex) % $mod;
                $ciphertext .= $alphabet[$cIndex];
            } else {
                // biarkan karakter non-huruf (spasi, tanda baca, dll)
                $ciphertext .= $p;
            }
        }

        return view('enkripsi.vigenere', [
            'plaintext' => $request->input('plaintext'),
            'key' => $request->input('key'),
            'convertedKey' => $keyConverted,
            'autoKey' => $autoKey,
            'ciphertext' => $ciphertext
        ]);
    }
}
