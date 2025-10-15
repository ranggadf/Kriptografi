<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DekripsiBerlapisController extends Controller
{
    private $aesCipher = "AES-256-CBC";

    // === RC4 ===
    private function rc4Decrypt($key, $data)
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
        $data = array_values(unpack('C*', base64_decode($data)));

        foreach ($data as $byte) {
            $i = ($i + 1) % 256;
            $j = ($j + $S[$i]) % 256;
            [$S[$i], $S[$j]] = [$S[$j], $S[$i]];
            $K = $S[($S[$i] + $S[$j]) % 256];
            $result .= chr($byte ^ $K);
        }

        return $result;
    }

    // === AES ===
    private function aesDecrypt($ciphertext, $key)
    {
        $ciphertext = base64_decode($ciphertext);
        $key = hash('sha256', $key, true);
        $ivLength = openssl_cipher_iv_length($this->aesCipher);
        $iv = substr($ciphertext, 0, $ivLength);
        $data = substr($ciphertext, $ivLength);

        return openssl_decrypt($data, $this->aesCipher, $key, OPENSSL_RAW_DATA, $iv);
    }

    // === Caesar ===
    private function getShiftFromKey($key)
    {
        $sum = 0;
        $key = strtoupper($key);
        for ($i = 0; $i < strlen($key); $i++) {
            $ch = $key[$i];
            if ($ch >= 'A' && $ch <= 'Z') {
                $sum += ord($ch) - 65;
            }
        }
        return $sum % 26;
    }

    private function caesarDecrypt($ciphertext, $key)
    {
        $shift = $this->getShiftFromKey($key);
        $result = '';

        for ($i = 0; $i < strlen($ciphertext); $i++) {
            $ch = $ciphertext[$i];
            if (ctype_alpha($ch)) {
                $isUpper = ctype_upper($ch);
                $base = $isUpper ? ord('A') : ord('a');
                $result .= chr((ord($ch) - $base - $shift + 26) % 26 + $base);
            } else {
                $result .= $ch;
            }
        }

        return $result;
    }

    // === Vigenère ===
    private function vigenereDecrypt($ciphertext, $key)
    {
        $ciphertext = strtoupper($ciphertext);
        $key = strtoupper($key);
        $plaintext = '';
        $j = 0;

        for ($i = 0; $i < strlen($ciphertext); $i++) {
            $c = $ciphertext[$i];
            if ($c >= 'A' && $c <= 'Z') {
                $p = (ord($c) - ord($key[$j]) + 26) % 26;
                $ch = chr($p + 65);
                $plaintext .= $ch;
                $key .= $ch; // auto-key
                $j++;
            } else {
                $plaintext .= $c;
            }
        }

        return $plaintext;
    }

    // === Tampilkan form utama ===
    public function index()
    {
        return view('dekripsi.dekripsiberlapis');
    }

    // === Proses dekripsi berlapis (1 key saja) ===
    public function decrypt(Request $request)
    {
        $request->validate([
            'ciphertext' => 'required|string',
            'key' => 'required|string',
        ]);

        try {
            $key = $request->key;

            // Tahap berlapis
            $rc4 = $this->rc4Decrypt($key, $request->ciphertext);
            $aes = $this->aesDecrypt($rc4, $key);
            $caesar = $this->caesarDecrypt($aes, $key);
            $vigenere = $this->vigenereDecrypt($caesar, $key);

            return view('dekripsi.dekripsiberlapis', [
                'ciphertext' => $request->ciphertext,
                'key' => $key,
                'rc4' => $rc4,
                'aes' => $aes,
                'caesar' => $caesar,
                'plaintext' => $vigenere,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Dekripsi gagal: ' . $e->getMessage()]);
        }
    }
}
