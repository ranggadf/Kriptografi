<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DekripsiBertahapController extends Controller
{
    private $aesCipher = 'AES-256-CBC';

    // ------------------
    // RC4
    // ------------------
    private function rc4($key, $data)
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

        for ($y = 0; $y < strlen($data); $y++) {
            $i = ($i + 1) % 256;
            $j = ($j + $S[$i]) % 256;
            [$S[$i], $S[$j]] = [$S[$j], $S[$i]];

            $K = $S[($S[$i] + $S[$j]) % 256];
            $result .= chr(ord($data[$y]) ^ $K);
        }

        return $result;
    }

    // ------------------
    // AES
    // ------------------
    private function aesDecrypt($ciphertextB64, $keyInput)
    {
        $decoded = base64_decode($ciphertextB64, true);
        if ($decoded === false) return false;

        $ivLen = openssl_cipher_iv_length($this->aesCipher);
        if (strlen($decoded) < $ivLen) return false;

        $iv = substr($decoded, 0, $ivLen);
        $encryptedData = substr($decoded, $ivLen);

        $key = hash('sha256', $keyInput, true);

        $plaintext = openssl_decrypt($encryptedData, $this->aesCipher, $key, OPENSSL_RAW_DATA, $iv);

        return $plaintext;
    }

    // ------------------
    // Caesar
    // ------------------
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

    private function caesarDecrypt($text, $key)
    {
        $shift = $this->getShiftFromKey($key);
        $result = '';

        for ($i = 0; $i < strlen($text); $i++) {
            $ch = $text[$i];
            if (ctype_upper($ch)) $result .= chr(((ord($ch) - 65 - $shift + 26) % 26) + 65);
            elseif (ctype_lower($ch)) $result .= chr(((ord($ch) - 97 - $shift + 26) % 26) + 97);
            else $result .= $ch;
        }

        return $result;
    }

    // ------------------
    // Vigenère Auto-Key
    // ------------------
 private function vigenereAutoDecrypt($ciphertext, $key)
{
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $key = strtoupper($this->convertNumericKey($key));

    $plaintext = '';
    $keyStream = $key;
    $j = 0;

    for ($i = 0; $i < strlen($ciphertext); $i++) {
        $ch = $ciphertext[$i];

        if (ctype_alpha($ch)) {
            $c = strtoupper($ch);
            $cIndex = strpos($alphabet, $c);

            $k = $keyStream[$j];
            $kIndex = strpos($alphabet, $k);

            $pIndex = ($cIndex - $kIndex + 26) % 26;
            $p = $alphabet[$pIndex];

            // Kembalikan case asli
            $plaintext .= ctype_lower($ch) ? strtolower($p) : $p;

            // tambahkan p ke keyStream
            $keyStream .= $p;

            $j++;
        } else {
            $plaintext .= $ch;
        }
    }

    return $plaintext;
}


    // ------------------
    // Halaman Form
    // ------------------
    public function index()
    {
        return view('dekripsi.dekripsibertahap');
    }

    // ------------------
    // Proses Dekripsi Bertahap RC4 → AES → Caesar → Vigenère
    // ------------------
    public function decrypt(Request $request)
    {
        $request->validate([
            'ciphertext' => 'required|string',
            'key' => 'required|string',
        ]);

        $ciphertext = $request->input('ciphertext');
        $key = $request->input('key');

        // Tahap 1: RC4 decrypt
        $decodedBase64 = base64_decode($ciphertext, true);
        $afterRC4 = $this->rc4($key, $decodedBase64);

        // Tahap 2: AES decrypt
        $afterAES = $this->aesDecrypt($afterRC4, $key);
        if ($afterAES === false) {
            return back()->withErrors(['ciphertext' => 'Dekripsi AES gagal'])->withInput();
        }

        // Tahap 3: Caesar decrypt
        $afterCaesar = $this->caesarDecrypt($afterAES, $key);

        // Tahap 4: Vigenère decrypt
        $finalPlaintext = $this->vigenereAutoDecrypt($afterCaesar, $key);

        return view('dekripsi.dekripsibertahap', compact(
            'ciphertext',
            'key',
            'afterRC4',
            'afterAES',
            'afterCaesar',
            'finalPlaintext'
        ));
    }
}
