<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Vigenere_dekripsiController extends Controller
{
    // fungsi dekripsi vigenere autokey
    private function vigenereAutoDecrypt($ciphertext, $key)
    {
        $ciphertext = strtoupper($ciphertext);
        $key = strtoupper($key);
        $plaintext = '';

        $keyStream = $key;
        $j = 0;

        for ($i = 0; $i < strlen($ciphertext); $i++) {
            $ch = $ciphertext[$i];

            if ($ch >= 'A' && $ch <= 'Z') {
                $shift = ord($keyStream[$j]) - 65;
                $plainChar = (ord($ch) - 65 - $shift + 26) % 26 + 65;
                $plainChar = chr($plainChar);

                $plaintext .= $plainChar;

                // auto-key: tambahkan huruf hasil dekripsi ke keyStream
                $keyStream .= $plainChar;

                $j++;
            } else {
                // karakter non-huruf langsung ditambahkan
                $plaintext .= $ch;
            }
        }

        return $plaintext;
    }

    public function indexDecrypt()
    {
        return view('dekripsi.vigenere_dekripsi');
    }

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
