<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnkripsiBerlapisController extends Controller
{
    private $aesCipher = "AES-256-CBC";

    // === RC4 ===
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

    // === AES ===
    private function aesEncrypt($plaintext, $key)
    {
        $key = hash('sha256', $key, true);
        $ivLength = openssl_cipher_iv_length($this->aesCipher);
        $iv = openssl_random_pseudo_bytes($ivLength);
        $encrypted = openssl_encrypt($plaintext, $this->aesCipher, $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encrypted);
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

    private function caesarEncrypt($plaintext, $key)
    {
        $shift = $this->getShiftFromKey($key);
        $result = '';

        for ($i = 0; $i < strlen($plaintext); $i++) {
            $ch = $plaintext[$i];
            if (ctype_alpha($ch)) {
                $isUpper = ctype_upper($ch);
                $base = $isUpper ? ord('A') : ord('a');
                $result .= chr((ord($ch) - $base + $shift) % 26 + $base);
            } else {
                $result .= $ch;
            }
        }

        return $result;
    }

    // === Vigenère ===
  private function vigenereEncrypt($plaintext, $key)
{
    // =============================
    // 🔹 Langkah 1: Normalisasi key
    // =============================
    $key = strtolower($key);
    $convertedKey = '';

    // Cek apakah key mengandung angka
    if (preg_match('/[0-9]/', $key)) {
        foreach (str_split($key) as $ch) {
            if (ctype_alpha($ch)) {
                // Huruf tetap huruf
                $convertedKey .= $ch;
            } elseif (ctype_digit($ch)) {
                // Angka diubah ke huruf: 1->B, 2->C, ..., 25->Z, 0->A
                $num = intval($ch);
                // pastikan 0 = A
                $letter = chr((($num % 26)) + ord('A') - 1);
                if ($num == 0) $letter = 'A';
                $convertedKey .= strtolower($letter);
            }
        }
    } else {
        // Jika semua huruf, gunakan apa adanya
        $convertedKey = $key;
    }

    $key = strtoupper($convertedKey);
    $plaintext = strtoupper($plaintext);
    $ciphertext = '';
    $j = 0;

    // =============================
    // 🔹 Langkah 2: Proses enkripsi
    // =============================
    for ($i = 0; $i < strlen($plaintext); $i++) {
        $p = $plaintext[$i];
        if ($p >= 'A' && $p <= 'Z') {
            $k = $key[$j % strlen($key)];
            $c = chr(((ord($p) + ord($k) - 2 * ord('A')) % 26) + ord('A'));
            $ciphertext .= $c;
            $key .= $p; // auto-key
            $j++;
        } else {
            $ciphertext .= $p;
        }
    }

    return $ciphertext;
}


    // === Tampilkan form utama ===
    public function index()
    {
        return view('enkripsi.enkripsiberlapis');
    }

    // === Proses enkripsi berlapis ===
    public function encrypt(Request $request)
    {
        $request->validate([
            'plaintext' => 'required|string',
            'key' => 'required|string',
        ]);

        try {
            $key = $request->key;
            $plaintext = $request->plaintext;

            // Tahapan enkripsi berlapis
            $vigenere = $this->vigenereEncrypt($plaintext, $key);
            $caesar = $this->caesarEncrypt($vigenere, $key);
            $aes = $this->aesEncrypt($caesar, $key);
            $rc4 = $this->rc4Encrypt($key, $aes);

            return view('enkripsi.enkripsiberlapis', [
                'plaintext' => $plaintext,
                'key' => $key,
                'vigenere' => $vigenere,
                'caesar' => $caesar,
                'aes' => $aes,
                'ciphertext' => $rc4,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Enkripsi gagal: ' . $e->getMessage()]);
        }
    }
}
