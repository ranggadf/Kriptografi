<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VigenereController extends Controller
{
    // tampilkan form
    public function index()
    {
        return view('enkripsi.vigenere');
    }

    // proses enkripsi
    public function encrypt(Request $request)
    {
        $plaintext = strtoupper($request->input('plaintext'));
        $key = strtoupper($request->input('key'));

        // generate auto key
        $autoKey = $key;
        $i = 0;
        while (strlen($autoKey) < strlen($plaintext)) {
            $autoKey .= $plaintext[$i];
            $i++;
        }

        // enkripsi
        $ciphertext = '';
        for ($j = 0; $j < strlen($plaintext); $j++) {
            $p = $plaintext[$j];
            $k = $autoKey[$j];

            if (ctype_alpha($p)) {
                $c = chr(((ord($p) - 65 + ord($k) - 65) % 26) + 65);
                $ciphertext .= $c;
            } else {
                $ciphertext .= $p;
            }
        }

        return view('enkripsi.vigenere', [
            'plaintext' => $request->input('plaintext'),
            'key' => $request->input('key'),
            'autoKey' => $autoKey,
            'ciphertext' => $ciphertext
        ]);
    }
}
