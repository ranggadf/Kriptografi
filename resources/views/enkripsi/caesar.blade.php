<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Caesar Cipher</title>
  <style>
    body {
      background:#0f172a;
      font-family: Arial, sans-serif;
      color:#e6eef8;
      display:flex;
      justify-content:center;
      padding:40px;
    }

    .card {
      background:#0b1220;
      padding:30px;
      border-radius:12px;
      width:500px;
      position:relative;
    }

    h1 {
      text-align:center;
      color:#34d399;
      margin-bottom:20px;
    }

    label { 
      font-weight:bold; 
      margin-top:10px; 
      display:block; 
    }

    textarea, input {
      width:100%;
      padding:10px;
      margin-top:5px;
      border-radius:8px;
      border:none;
      background:#1e293b;
      color:#e6eef8;
    }

    input[readonly], textarea[readonly] {
      background:#334155;
      color:#94a3b8;
    }

    button {
      margin-top:15px;
      width:100%;
      padding:12px;
      border:none;
      border-radius:8px;
      background:#34d399;
      color:#000;
      font-weight:bold;
      cursor:pointer;
      transition:0.3s;
    }

    button:hover {
      background:#22c55e;
    }

    .btn-copy {
      margin-top:8px;
      background:#22c55e;
      font-size:14px;
      padding:6px 12px;
      border:none;
      border-radius:6px;
      cursor:pointer;
      width:auto;
    }

    .btn-copy:hover { background:#16a34a; }

    .btn-next {
      margin-top:12px;
      background:#3b82f6;
      color:#fff;
      font-weight:bold;
    }

    .btn-next:disabled {
      background:#475569;
      cursor:not-allowed;
    }

    .error {
      color:#f87171;
      margin-top:5px;
      font-size:14px;
    }

    .note {
      margin-top:12px;
      font-size:14px;
      color:#94a3b8;
      text-align:center;
      line-height:1.5;
    }

    /* 🔹 Tombol navigasi di pojok kiri atas */
    .nav-buttons {
      position:fixed;
      top:20px;
      left:20px;
      display:flex;
      flex-direction:column;
      gap:8px;
    }

    .nav-btn {
      background:#1e293b;
      color:#34d399;
      border:2px solid #34d399;
      padding:8px 14px;
      border-radius:8px;
      font-weight:bold;
      text-decoration:none;
      text-align:center;
      transition:0.3s;
    }

    .nav-btn:hover {
      background:#34d399;
      color:#0f172a;
    }
  </style>

  <script>
    function copyToClipboard() {
      var copyText = document.getElementById("ciphertext");
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");
      alert("✅ Hasil enkripsi Caesar berhasil disalin!");
      document.getElementById("nextBtn").disabled = false;
    }
  </script>
</head>
<body>

  <!-- 🔹 Tombol Navigasi -->
  <div class="nav-buttons">
    <a href="{{ url('/enkripsi') }}" class="nav-btn">← Halaman Enkripsi</a>
    <a href="{{ url('/dekripsi/caesar') }}" class="nav-btn">🔓 Dekripsi Caesar</a>
  </div>

  <div class="card">
    <h1>Caesar Cipher</h1>

    <form method="POST" action="{{ route('caesar.encrypt') }}">
      @csrf

      <label for="plaintext">Plaintext</label>
      <textarea name="plaintext" id="plaintext" rows="4">{{ old('plaintext') }}</textarea>
      @error('plaintext')
        <div class="error">{{ $message }}</div>
      @enderror

      <label for="key">Key</label>
      <input type="text" name="key" id="key" value="{{ old('key') }}">
      @error('key')
        <div class="error">{{ $message }}</div>
      @enderror

      <button type="submit">Encrypt</button>
    </form>

    @isset($ciphertext)
      <label for="ciphertext">Hasil Enkripsi</label>
      <input type="text" id="ciphertext" value="{{ $ciphertext }}" readonly>
      <button type="button" class="btn-copy" onclick="copyToClipboard()">Copy</button>

      <form action="{{ url('/aes') }}" method="GET">
        <button type="submit" id="nextBtn" class="btn-next" disabled>Lanjut ke AES</button>
      </form>

      <p class="note">
        Tahap kedua enkripsi dengan metode <strong>Caesar Cipher</strong> telah selesai.<br>
        Selanjutnya, teks ini akan dienkripsi kembali menggunakan <strong>AES</strong> sebagai tahap ketiga dari proses enkripsi berantai.
      </p>
      <p class="note">
        ⚡ <strong>Catatan:</strong> Salin hasil enkripsi untuk dijadikan plaintext pada tahap selanjutnya.
      </p>
    @endisset
  </div>

</body>
</html>
