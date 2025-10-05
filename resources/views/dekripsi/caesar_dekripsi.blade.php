<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dekripsi Caesar Cipher</title>
  <style>
    body {
      background:#0f172a;
      font-family: Arial, sans-serif;
      color:#e6eef8;
      margin:0;
      padding:40px;
      display:flex;
      justify-content:center;
    }
    .container {
      max-width:600px;
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
    label { display:block; margin-top:15px; font-weight:bold; }
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
      display:inline-block;
      width:100%;
      padding:12px;
      border:none;
      border-radius:8px;
      background:#34d399;
      color:#000;
      font-weight:bold;
      text-decoration:none;
      cursor:pointer;
    }
    .btn:hover { background:#22c55e; }
    .result {
      margin-top:25px;
      background:#1e293b;
      padding:15px;
      border-radius:8px;
      word-wrap:break-word;
    }
    .back-link {
      display:inline-block;
      margin-top:15px;
      color:#94a3b8;
      text-decoration:none;
    }
    .back-link:hover {
      color:#34d399;
    }
    .nav-buttons { position:fixed; top:20px; left:20px; display:flex; flex-direction:column; gap:10px; }
    .nav-btn { background:#1e293b; color:#34d399; border:2px solid #34d399; padding:8px 14px; border-radius:8px; font-weight:bold; text-decoration:none; width:160px; text-align:center; }
    .nav-btn:hover { background:#34d399; color:#0f172a; }
  </style>
</head>
<body>
    <div class="nav-buttons">
    <a href="{{ url('/caesar') }}" class="nav-btn">← Kembali ke Enkripsi Caesar</a>
    <a href="{{ url('/dekripsi') }}" class="nav-btn">🏠 Halaman Dekripsi</a>
  </div>
  <div class="container">
    <h1>Dekripsi Caesar Cipher</h1>
    <form action="{{ route('caesar.decrypt') }}" method="POST">
      @csrf
      <label for="ciphertext">Ciphertext</label>
      <textarea id="ciphertext" name="ciphertext" rows="4" required>{{ old('ciphertext', $ciphertext ?? '') }}</textarea>

      <label for="key">Key (huruf)</label>
      <input type="text" id="key" name="key" value="{{ old('key', $key ?? '') }}" required>

      <button type="submit" class="btn">Dekripsi</button>
    </form>

    @isset($plaintext)
      <div class="result">
        <strong>Hasil Dekripsi:</strong><br>
        {{ $plaintext }}
      </div>
    @endisset

    <a href="{{ url('/') }}" class="back-link">← Kembali ke Halaman Utama</a>
  </div>
</body>
</html>
