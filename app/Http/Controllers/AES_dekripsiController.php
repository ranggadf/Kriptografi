<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AES_dekripsiController extends Controller
{
    private $cipher = 'AES-256-CBC';

    // Tampilkan form dekripsi
    public function indexDecrypt()
    {
        return view('dekripsi.aes_dekripsi');
    }

    // Proses dekripsi
    public function decrypt(Request $request)
    {
        $request->validate([
            'ciphertext' => 'required|string',
            'key' => 'required|string'
        ]);

        $ciphertextB64 = $request->input('ciphertext');
        $keyInput = $request->input('key');

        // decode base64 (gunakan second param true untuk validasi)
        $decoded = base64_decode($ciphertextB64, true);
        if ($decoded === false) {
            return redirect()->back()->withErrors(['ciphertext' => 'Ciphertext bukan Base64 yang valid.'])->withInput();
        }

        $ivLen = openssl_cipher_iv_length($this->cipher);
        if (strlen($decoded) < $ivLen) {
            return redirect()->back()->withErrors(['ciphertext' => 'Ciphertext terlalu pendek (tidak berisi IV).'])->withInput();
        }

        $iv = substr($decoded, 0, $ivLen);
        $encryptedData = substr($decoded, $ivLen);

        // buat key 32-byte
        $key = hash('sha256', $keyInput, true);

        $plaintext = openssl_decrypt($encryptedData, $this->cipher, $key, OPENSSL_RAW_DATA, $iv);

        if ($plaintext === false) {
            return redirect()->back()->withErrors(['ciphertext' => 'Dekripsi gagal — pastikan key dan ciphertext benar.'])->withInput();
        }

        // Tampilkan hasil sekali (flash). withInput() menjaga textarea ciphertext tetap terisi.
        return redirect()
            ->back()
            ->withInput()
            ->with('plaintext', $plaintext);
    }
}
