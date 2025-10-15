<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Enkripsi Berlapis (Vigenère → Caesar → AES → RC4)</title>
  <style>
    body { 
      background:#0f172a; 
      font-family:Arial; 
      color:#e6eef8; 
      margin:0; 
      padding:40px; 
      display:flex; 
      justify-content:center; 
    }

    .container { 
      max-width:900px; 
      width:100%; 
      background:#0b1220; 
      padding:30px; 
      border-radius:12px; 
      box-shadow:0 4px 12px rgba(0,0,0,0.4); 
    }

    h1 { 
      text-align:center; 
      color:#34d399;  /* 💚 hijau utama */
      margin-bottom:20px; 
    }

    label { 
      display:block; 
      margin-top:15px; 
      font-weight:bold; 
    }

    input, textarea { 
      width:100%; 
      padding:10px; 
      margin-top:6px; 
      border:none; 
      border-radius:8px; 
      background:#1e293b; 
      color:#e6eef8; 
    }

    .btn { 
      margin-top:20px; 
      width:100%; 
      padding:12px; 
      border:none; 
      border-radius:8px; 
      background:#34d399;  /* 💚 hijau terang */
      color:#000; 
      font-weight:bold; 
      cursor:pointer; 
    }

    .btn:hover { 
      background:#22c55e;  /* 💚 efek hover */
    }

    .result { 
      background:#1e293b; 
      padding:15px; 
      border-radius:8px; 
      margin-top:20px; 
    }

    .step { 
      margin-top:15px; 
      background:#111827; 
      padding:10px; 
      border-radius:8px; 
      border-left:4px solid #34d399;  /* 💚 garis hijau di kiri */
    }

    .note { 
      background:#1e293b; 
      padding:12px; 
      border-left:4px solid #34d399;  /* 💚 garis hijau di kiri */
      border-radius:6px; 
      color:#a7f3d0;  /* 💚 teks hijau lembut */
      margin-bottom:20px; 
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Enkripsi Berlapis</h1>
    <div class="note">
      <strong>🧩 Catatan:</strong> Masukkan plaintext dan 1 kunci utama.<br>
      Sistem akan mengenkripsi secara berurutan: <b>Vigenère → Caesar → AES → RC4</b>.
    </div>

    @if ($errors->any())
      <div class="result" style="border-left:4px solid red;">
        <strong>⚠️ Terjadi kesalahan:</strong><br>
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('enkripsi.berlapis.proses') }}">
      @csrf
      <label for="plaintext">Plaintext</label>
      <textarea name="plaintext" rows="4" required>{{ old('plaintext', $plaintext ?? '') }}</textarea>

      <label for="key">Key Utama</label>
      <input type="text" name="key" value="{{ old('key', $key ?? '') }}" required>

      <button class="btn">Enkripsi Semua Tahap</button>
    </form>

    @isset($ciphertext)
      <div class="result">
        <div class="step"><strong>Vigenère →</strong><br>{{ $vigenere }}</div>
        <div class="step"><strong>Caesar →</strong><br>{{ $caesar }}</div>
        <div class="step"><strong>AES →</strong><br>{{ $aes }}</div>
        <div class="step"><strong>RC4 (Cipher Final) →</strong><br>{{ $ciphertext }}</div>
      </div>
    @endisset
  </div>
</body>
</html>
