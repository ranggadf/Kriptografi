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

    textarea[readonly] {
      background:#334155;
      color:#94a3b8;
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
      transition: background 0.2s;
    }

    .btn:hover { background:#22c55e; }

    .btn-copy {
      margin-top:10px;
      background:#22c55e;
      font-size:14px;
      padding:8px 12px;
      border:none;
      border-radius:6px;
      cursor:pointer;
      width:auto;
      font-weight:bold;
    }

    .btn-copy:hover {
      background:#16a34a;
    }

    .btn-next {
      margin-top:20px;
      background:#3b82f6;
      color:#fff;
      font-weight:bold;
      border:none;
      border-radius:8px;
      padding:12px;
      width:100%;
      cursor:pointer;
      transition:0.3s;
    }

    .btn-next:hover { background:#2563eb; }

    .btn-next:disabled {
      background:#475569;
      cursor:not-allowed;
    }

    .note {
      margin-top:15px;
      font-size:14px;
      line-height:1.6;
      color:#cbd5e1;
      background:#1e293b;
      padding:10px;
      border-radius:8px;
    }

    .note strong { color:#34d399; }

    .nav-buttons {
      position:fixed;
      top:20px;
      left:20px;
      display:flex;
      flex-direction:column;
      gap:10px;
    }

    .nav-btn {
      background:#1e293b;
      color:#34d399;
      border:2px solid #34d399;
      padding:8px 14px;
      border-radius:8px;
      font-weight:bold;
      text-decoration:none;
      width:200px;
      text-align:center;
      transition:all 0.2s;
    }

    .nav-btn:hover { background:#34d399; color:#0f172a; }

  </style>

  <script>
    function copyToClipboard() {
      const copyText = document.getElementById("plaintext");
      if (!copyText) return;

      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");

      const nextBtn = document.getElementById("nextBtn");
      if (nextBtn) {
        nextBtn.disabled = false;
      }

      alert("✅ Hasil dekripsi Caesar berhasil disalin!\nSekarang Anda bisa lanjut ke dekripsi Vigenère.");
    }
  </script>
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

      <button type="submit" class="btn">🔓 Dekripsi</button>
    </form>

    @isset($plaintext)
      <label for="plaintext" style="margin-top:20px;">Hasil Dekripsi</label>
      <textarea id="plaintext" readonly rows="4">{{ $plaintext }}</textarea>

      <button type="button" class="btn-copy" onclick="copyToClipboard()">📋 Copy</button>

      <p class="note">
        ✅ Ini adalah hasil akhir dari <strong>Dekripsi Caesar Cipher</strong>.<br>
        Silakan salin hasil ini terlebih dahulu sebelum melanjutkan ke tahap terakhir:
        <strong>Vigenère Cipher</strong>.
      </p>

      <form action="{{ url('/dekripsi/vigenere') }}" method="GET">
        <button type="submit" id="nextBtn" class="btn-next" disabled>
          ➡️ Lanjut ke Dekripsi Vigenère
        </button>
      </form>
    @endisset
  </div>

</body>
</html>
