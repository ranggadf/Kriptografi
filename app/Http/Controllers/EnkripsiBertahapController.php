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
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $key = strtoupper($this->convertNumericKey($key));

    $autoKey = $key;
    $cleanPlain = strtoupper(preg_replace('/[^A-Za-z]/', '', $plaintext));

    $i = 0;
    while (strlen($autoKey) < strlen($cleanPlain)) {
        $autoKey .= $cleanPlain[$i++];
    }

    $ciphertext = '';
    $j = 0;

    for ($i = 0; $i < strlen($plaintext); $i++) {
        $ch = $plaintext[$i];

        if (ctype_alpha($ch)) {
            // Plain index
            $p = strtoupper($ch);
            $pIndex = strpos($alphabet, $p);

            // Key index
            $k = $autoKey[$j++];
            $kIndex = strpos($alphabet, $k);

            // Encrypt
            $cIndex = ($pIndex + $kIndex) % 26;
            $c = $alphabet[$cIndex];

            // Kembalikan case asli
            $ciphertext .= ctype_lower($ch) ? strtolower($c) : $c;
        } else {
            $ciphertext .= $ch; // simbol, angka, spasi tetap
        }
    }

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
