<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RC4Controller extends Controller
{
    private function rc4($key, $data)
    {
        $keyLength = strlen($key);
        $S = range(0, 255);

        // KSA - Key Scheduling Algorithm
        $j = 0;
        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $S[$i] + ord($key[$i % $keyLength])) % 256;
            [$S[$i], $S[$j]] = [$S[$j], $S[$i]];
        }

        // PRGA - Pseudo Random Generation Algorithm
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

        // Encode ke Base64 biar aman ditampilkan
        return base64_encode($result);
    }

    public function index()
    {
        return view('enkripsi.rc4'); // tampilan RC4
    }

    public function encrypt(Request $request)
    {
        $request->validate([
            'plaintext' => 'required|string',
            'key' => 'required|string'
        ]);

        $plaintext = $request->input('plaintext');
        $key = $request->input('key');

        $ciphertext = $this->rc4($key, $plaintext);

        return view('enkripsi.rc4', compact('plaintext', 'key', 'ciphertext'));
    }
}
