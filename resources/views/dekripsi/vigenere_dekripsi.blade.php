<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dekripsi Vigenère Cipher (Tahap Akhir)</title>
  <style>
    body {
      background: #0f172a;
      font-family: Arial, sans-serif;
      color: #e6eef8;
      margin: 0;
      padding: 40px;
      display: flex;
      justify-content: center;
    }

    .container {
      max-width: 700px;
      width: 100%;
      background: #0b1220;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.4);
    }

    h1 {
      text-align: center;
      color: #34d399;
      margin-bottom: 10px;
    }

    p.subtitle {
      text-align: center;
      color: #94a3b8;
      font-size: 14px;
      margin-bottom: 25px;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      border: none;
      border-radius: 8px;
      background: #1e293b;
      color: #e6eef8;
    }

    .btn {
      margin-top: 20px;
      display: inline-block;
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background: #34d399;
      color: #000;
      font-weight: bold;
      text-decoration: none;
      cursor: pointer;
    }

    .btn:hover {
      background: #22c55e;
    }

    .result {
      margin-top: 25px;
      background: #1e293b;
      padding: 15px;
      border-radius: 8px;
      word-wrap: break-word;
    }

    .back-link {
      display: inline-block;
      margin-top: 15px;
      color: #94a3b8;
      text-decoration: none;
    }

    .back-link:hover {
      color: #34d399;
    }

    .nav-buttons {
      position: fixed;
      top: 20px;
      left: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .nav-btn {
      background: #1e293b;
      color: #34d399;
      border: 2px solid #34d399;
      padding: 8px 14px;
      border-radius: 8px;
      font-weight: bold;
      text-decoration: none;
      width: 180px;
      text-align: center;
    }

    .nav-btn:hover {
      background: #34d399;
      color: #0f172a;
    }

    .note-box {
      background: #1e293b;
      padding: 12px;
      border-left: 4px solid #34d399;
      border-radius: 6px;
      color: #a5b4fc;
      margin-bottom: 25px;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <div class="nav-buttons">
    <a href="{{ url('/dekripsi') }}" class="nav-btn">← Kembali ke Menu Dekripsi</a>
    <a href="{{ url('/') }}" class="nav-btn">🏠 Halaman Utama</a>
  </div>

  <div class="container">
    <h1>Dekripsi Vigenère Cipher</h1>
    <p class="subtitle">Tahap ke-4 (Terakhir) dari proses dekripsi berlapis</p>

    <div class="note-box">
      <strong>📘 Catatan:</strong> Tahap ini merupakan <b>tahap terakhir</b> setelah melalui
      proses dekripsi <b>RC4 → AES → Caesar Cipher</b>.  
      Pastikan teks yang dimasukkan berasal dari hasil tahap <b>Caesar Cipher</b>.
    </div>

    <form action="{{ route('vigenere.decrypt') }}" method="POST">
      @csrf
      <label for="ciphertext">Ciphertext</label>
      <textarea id="ciphertext" name="ciphertext" rows="4" required>{{ old('ciphertext', $ciphertext ?? '') }}</textarea>

      <label for="key">Key (Kata Kunci)</label>
      <input type="text" id="key" name="key" value="{{ old('key', $key ?? '') }}" required>

      <button type="submit" class="btn">Dekripsi Sekarang</button>
    </form>

    @isset($plaintext)
      <div class="result">
        <strong>🔓 Hasil Dekripsi Akhir:</strong><br>
        {{ $plaintext }}
      </div>
    @endisset

    <a href="{{ url('/') }}" class="back-link">← Kembali ke Halaman Utama</a>
  </div>

</body>
</html>
