<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnkripsiBertahapController extends Controller
{
    private $aesCipher = "AES-256-CBC";

    // 🔹 Konversi angka ke huruf (1=B, 2=C, 0=A)
    private function convertNumericKey($key)
    {
        $converted = '';
        $key = strtoupper($key);

        for ($i = 0; $i < strlen($key); $i++) {
            $ch = $key[$i];
            if (ctype_digit($ch)) {
                $converted .= $ch === '0' ? 'A' : chr(64 + intval($ch) + 1);
            } else {
                $converted .= $ch;
            }
        }

        return $converted;
    }

    // 🔹 Shift Caesar
    private function getShiftFromKey($key)
    {
        if (ctype_digit($key)) return intval($key) % 26;

        $convertedKey = $this->convertNumericKey($key);
        $sum = 0;
        for ($i = 0; $i < strlen($convertedKey); $i++) {
            $ch = $convertedKey[$i];
            if ($ch >= 'A' && $ch <= 'Z') $sum += ord($ch) - 65;
        }

        return $sum % 26;
    }

    // 🔹 Enkripsi Caesar
    private function caesarEncrypt($text, $key)
    {
        $shift = $this->getShiftFromKey($key);
        $result = '';

        for ($i = 0; $i < strlen($text); $i++) {
            $ch = $text[$i];
            if (ctype_upper($ch)) $result .= chr(((ord($ch) - 65 + $shift) % 26) + 65);
            elseif (ctype_lower($ch)) $result .= chr(((ord($ch) - 97 + $shift) % 26) + 97);
            else $result .= $ch;
        }

        return $result;
    }

 // 🔹 Enkripsi Vigenère Auto-key
private function vigenereEncrypt($plaintext, $key)
{
    // Alphabet yang digunakan untuk enkripsi
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    // Ubah key menjadi uppercase, dan convert key jika berupa angka
    $key = strtoupper($this->convertNumericKey($key));

    // AutoKey diawali dari key asli
    $autoKey = $key;

    // Buang semua karakter non-huruf dari plaintext (misal spasi, angka, simbol)
    // lalu ubah ke uppercase untuk kebutuhan pembuatan auto-key
    $cleanPlain = strtoupper(preg_replace('/[^A-Za-z]/', '', $plaintext));

    // Inisialisasi index untuk menambah plaintext ke auto-key
    $i = 0;

    // Selama autoKey lebih pendek dari plaintext
    // tambahkan huruf plaintext ke autoKey (membentuk auto-key sequence)
    while (strlen($autoKey) < strlen($cleanPlain)) {
        $autoKey .= $cleanPlain[$i++];
    }

    // Variabel untuk menyimpan hasil cipher
    $ciphertext = '';

    // Index autoKey untuk dipakai karakter demi karakter
    $j = 0;

    // Loop untuk setiap karakter dalam plaintext asli
    for ($i = 0; $i < strlen($plaintext); $i++) {

        // Ambil 1 karakter plaintext
        $ch = $plaintext[$i];

        // Jika huruf alfabet (A-Z / a-z)
        if (ctype_alpha($ch)) {

            // Ambil huruf uppercase untuk perhitungan index
            $p = strtoupper($ch);

            // Cari posisi huruf plaintext dalam alphabet (0–25)
            $pIndex = strpos($alphabet, $p);

            // Ambil huruf auto-key sesuai index ke-j
            $k = $autoKey[$j++];

            // Cari posisi huruf key dalam alphabet (0–25)
            $kIndex = strpos($alphabet, $k);

            // Rumus enkripsi: (plaintextIndex + keyIndex) mod 26
            $cIndex = ($pIndex + $kIndex) % 26;

            // Ambil huruf hasil enkripsi
            $c = $alphabet[$cIndex];

            // Kembalikan huruf sesuai case aslinya (uppercase/lowercase)
            $ciphertext .= ctype_lower($ch) ? strtolower($c) : $c;

        } else {

            // Jika bukan huruf (angka, spasi, simbol): tidak dienkripsi
            $ciphertext .= $ch;
        }
    }

    // Return ciphertext, key asli after convert, dan autoKey penuh
    return [$ciphertext, $key, $autoKey];
}



    // 🔹 Enkripsi AES
    private function aesEncrypt($plaintext, $key)
    {
        $key = hash('sha256', $key, true);
        $ivLength = openssl_cipher_iv_length($this->aesCipher);
        $iv = openssl_random_pseudo_bytes($ivLength);
        $encrypted = openssl_encrypt($plaintext, $this->aesCipher, $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encrypted);
    }

    // 🔹 Enkripsi RC4
    private function rc4Encrypt($key, $data)
    {
        $keyLength = strlen($key);
        $S = range(0, 255);
        $j = 0;

        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $S[$i] + ord($key[$i % $keyLength])) % 256;
            [$S[$i], $S[$j]] = [$S[$j], $S[$i]];
        }

        $i = $j = 0;
        $result = '';
        // "
        $data = array_values(unpack('C*', $data));

        foreach ($data as $byte) {
            $i = ($i + 1) % 256;
            $j = ($j + $S[$i]) % 256;
            [$S[$i], $S[$j]] = [$S[$j], $S[$i]];
            $K = $S[($S[$i] + $S[$j]) % 256];
            $result .= chr($byte ^ $K);
        }

        return base64_encode($result);
    }

    // 🔹 Form utama
    public function index()
    {
        return view('enkripsi.enkripsibertahap');
    }

    // 🔹 Proses enkripsi bertahap: Vigenère → Caesar → AES → RC4
    public function encrypt(Request $request)
    {
        $request->validate([
            'plaintext' => 'required|string',
            'key' => 'required|string',
        ]);

        $plaintext = $request->input('plaintext');
        $key = $request->input('key');

        // Tahap 1: Vigenère
        [$vigenereCipher, $convertedKey, $autoKey] = $this->vigenereEncrypt($plaintext, $key);

        // Tahap 2: Caesar
        $caesarCipher = $this->caesarEncrypt($vigenereCipher, $key);

        // Tahap 3: AES
        $aesCipher = $this->aesEncrypt($caesarCipher, $key);

        // Tahap 4: RC4
        $finalCipher = $this->rc4Encrypt($key, $aesCipher);

        return view('enkripsi.enkripsibertahap', compact(
            'plaintext',
            'key',
            'convertedKey',
            'autoKey',
            'vigenereCipher',
            'caesarCipher',
            'aesCipher',
            'finalCipher'
        ));
    }
}
