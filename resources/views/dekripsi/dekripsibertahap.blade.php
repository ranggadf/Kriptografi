<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dekripsi Bertahap (RC4 → AES → Caesar → Vigenère)</title>
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
      color:#34d399; 
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
      background:#34d399; 
      color:#000; 
      font-weight:bold; 
      cursor:pointer; 
    }

    .btn:hover { 
      background:#22c55e; 
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
      border-left:4px solid #34d399; 
      word-break: break-all;
    }

    .note { 
      background:#1e293b; 
      padding:12px; 
      border-left:4px solid #34d399; 
      border-radius:6px; 
      color:#a7f3d0; 
      margin-bottom:20px; 
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Dekripsi Bertahap</h1>
    <div class="note">
      <strong>🧩 Catatan:</strong> Masukkan ciphertext dan 1 kunci utama.<br>
      Sistem akan mendekripsi secara berurutan: <b>RC4 → AES → Caesar → Vigenère</b>.
    </div>

    @if ($errors->any())
      <div class="result" style="border-left:4px solid red;">
        <strong>⚠️ Terjadi kesalahan:</strong><br>
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('dekripsibertahap.decrypt') }}">
      @csrf
      <label for="ciphertext">Ciphertext</label>
      <textarea name="ciphertext" rows="4" required>{{ old('ciphertext', $ciphertext ?? '') }}</textarea>

      <label for="key">Key Utama</label>
      <input type="text" name="key" value="{{ old('key', $key ?? '') }}" required>

      <button class="btn">Dekripsi Semua Tahap</button>
    </form>

    @isset($finalPlaintext)
      <div class="result">
        <div class="step"><strong>RC4 →</strong><br>{{ $afterRC4 }}</div>
        <div class="step"><strong>AES →</strong><br>{{ $afterAES }}</div>
        <div class="step"><strong>Caesar →</strong><br>{{ $afterCaesar }}</div>
        <div class="step"><strong>Vigenère →</strong><br>{{ $finalPlaintext }}</div>
            <a href="/enkripsibertahap" class="btn" style="text-align:center; display:block; margin-top:15px;">
      🔑 LKembali ke enkripsi bertahap
    </a>

      </div>
    @endisset
  </div>
</body>
</html>
