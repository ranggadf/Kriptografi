<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RC4_dekripsiController extends Controller
{
    // === Algoritma RC4 (bisa dipakai untuk enkripsi & dekripsi) ===
    private function rc4($key, $data)
    {
        $keyLength = strlen($key);
        $S = range(0, 255);

        // KSA (Key Scheduling Algorithm)
        $j = 0;
        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $S[$i] + ord($key[$i % $keyLength])) % 256;
            [$S[$i], $S[$j]] = [$S[$j], $S[$i]];
        }

        // PRGA (Pseudo Random Generation Algorithm)
        $i = 0;
        $j = 0;
        $result = '';

        for ($y = 0; $y < strlen($data); $y++) {
            $i = ($i + 1) % 256;
            $j = ($j + $S[$i]) % 256;
            [$S[$i], $S[$j]] = [$S[$j], $S[$i]];

            $K = $S[($S[$i] + $S[$j]) % 256];
            $result .= chr(ord($data[$y]) ^ $K);
        }

        return $result;
    }

    // === Form RC4 dekripsi ===
    public function indexDecrypt()
    {
        return view('dekripsi.rc4_dekripsi');
    }

    // === Proses Dekripsi ===
    public function decrypt(Request $request)
    {
        $request->validate([
            'ciphertext' => 'required|string',
            'key' => 'required|string'
        ]);

        $ciphertext = $request->input('ciphertext');
        $key = $request->input('key');

        // decode base64 sebelum RC4
        $decoded = base64_decode($ciphertext);
        $plaintext = $this->rc4($key, $decoded);

        return view('dekripsi.rc4_dekripsi', compact('ciphertext', 'key', 'plaintext'));
    }
}
