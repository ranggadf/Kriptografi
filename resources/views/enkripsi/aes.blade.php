<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>AES Cipher - Enkripsi</title>
  <style>
    body {
      background: #0f172a;
      font-family: Arial, sans-serif;
      color: #e6eef8;
      display: flex;
      justify-content: center;
      padding: 40px;
    }

    .card {
      background: #0b1220;
      padding: 30px;
      border-radius: 12px;
      width: 500px;
    }

    h1 {
      text-align: center;
      color: #34d399;
      margin-bottom: 20px;
    }

    label {
      font-weight: bold;
      margin-top: 10px;
      display: block;
    }

    textarea, input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 8px;
      border: none;
      background: #1e293b;
      color: #e6eef8;
    }

    input[readonly], textarea[readonly] {
      background: #334155;
      color: #94a3b8;
    }

    button {
      margin-top: 15px;
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background: #34d399;
      color: #000;
      font-weight: bold;
      cursor: pointer;
    }

    .btn-copy {
      margin-top: 8px;
      background: #22c55e;
      font-size: 14px;
      padding: 6px 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      width: auto;
    }

    .btn-copy:hover {
      background: #16a34a;
    }

    .btn-next {
      margin-top: 12px;
      background: #3b82f6;
      color: #fff;
      font-weight: bold;
    }

    .btn-next:disabled {
      background: #475569;
      cursor: not-allowed;
    }

    .error {
      color: #f87171;
      margin-top: 5px;
      font-size: 14px;
    }

    .note {
      margin-top: 15px;
      font-size: 14px;
      line-height: 1.6;
      color: #cbd5e1;
      background: #1e293b;
      padding: 10px;
      border-radius: 8px;
    }

    .note strong {
      color: #34d399;
    }

    /* Tombol navigasi pojok kiri */
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
      transition: 0.3s;
      text-align: center;
      width: 160px;
    }

    .nav-btn:hover {
      background: #34d399;
      color: #0f172a;
    }
  </style>

  <script>
    function copyToClipboard() {
      var copyText = document.getElementById("ciphertext");
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");
      alert("Hasil AES berhasil disalin!");
      document.getElementById("nextBtn").disabled = false;
    }
  </script>
</head>
<body>

  <!-- Tombol Navigasi -->
  <div class="nav-buttons">
    <a href="{{ url('/enkripsi') }}" class="nav-btn">← Halaman Enkripsi</a>
    <a href="{{ url('/dekripsi/aes') }}" class="nav-btn">🔓 Dekripsi AES</a>
  </div>

  <div class="card">
    <h1>AES Cipher - Enkripsi</h1>

    <form method="POST" action="{{ route('aes.encrypt') }}">
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
      <label for="ciphertext">Hasil Enkripsi (Base64)</label>
      <textarea id="ciphertext" readonly rows="3">{{ $ciphertext }}</textarea>
      <button type="button" class="btn-copy" onclick="copyToClipboard()">Copy</button>

      <form action="{{ url('/rc4') }}" method="GET">
        <button type="submit" id="nextBtn" class="btn-next" disabled>Lanjut ke RC4</button>
      </form>

      <p class="note">
        Tahap ketiga enkripsi dengan metode <strong>AES</strong> telah selesai.<br>
        Selanjutnya, teks ini akan dienkripsi kembali menggunakan <strong>RC4</strong>.
      </p>
      <p class="note">
        ⚡ <strong>Catatan:</strong> Copy hasil enkripsi untuk dijadikan plaintext pada tahap selanjutnya.
      </p>
    @endisset
  </div>
</body>
</html>
