<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AESController extends Controller
{
    private $cipher = "AES-256-CBC";

    private function aesEncrypt($plaintext, $key)
    {
        // Buat key 32 byte dari input user
        $key = hash('sha256', $key, true);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));

        $ciphertext = openssl_encrypt($plaintext, $this->cipher, $key, OPENSSL_RAW_DATA, $iv);

        // Simpan IV + cipher (biar bisa didekripsi nanti)
        return base64_encode($iv . $ciphertext);
    }

    public function index()
    {
        return view('enkripsi.aes'); // halaman form AES
    }

    public function encrypt(Request $request)
    {
        $request->validate([
            'plaintext' => 'required|string',
            'key' => 'required|string'
        ]);

        $plaintext = $request->input('plaintext');
        $key = $request->input('key');

        $ciphertext = $this->aesEncrypt($plaintext, $key);

        return view('enkripsi.aes', compact('plaintext', 'key', 'ciphertext'));
    }
}
