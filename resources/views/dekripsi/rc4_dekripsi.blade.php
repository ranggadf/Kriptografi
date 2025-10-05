<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>RC4 Cipher - Dekripsi</title>
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
      position: relative;
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
      resize: none;
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
      transition: background 0.2s;
    }

    button:hover {
      background: #22c55e;
    }

    .btn-copy {
      margin-top: 8px;
      background: #22c55e;
      font-size: 14px;
      padding: 8px 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      width: auto;
      font-weight: bold;
    }

    .btn-copy:hover {
      background: #16a34a;
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

    /* Tombol Navigasi */
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
      transition: all 0.2s;
    }

    .nav-btn:hover {
      background: #34d399;
      color: #0f172a;
    }
  </style>

  <script>
    function copyToClipboard() {
      const copyText = document.getElementById("plaintext");
      if (!copyText) return;
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");
      alert("✅ Hasil dekripsi RC4 berhasil disalin ke clipboard!");
    }
  </script>
</head>
<body>
  <!-- Navigasi -->
  <div class="nav-buttons">
    <a href="{{ url('/rc4') }}" class="nav-btn">← Kembali ke Enkripsi RC4</a>
    <a href="{{ url('/dekripsi') }}" class="nav-btn">🏠 Halaman Dekripsi</a>
  </div>

  <!-- Card Utama -->
  <div class="card">
    <h1>RC4 Cipher - Dekripsi</h1>

    <form method="POST" action="{{ route('rc4.decrypt') }}">
      @csrf

      <label for="ciphertext">Ciphertext (Base64)</label>
      <textarea name="ciphertext" id="ciphertext" rows="4">{{ old('ciphertext') }}</textarea>
      @error('ciphertext')
        <div class="error">{{ $message }}</div>
      @enderror

      <label for="key">Key</label>
      <input type="text" name="key" id="key" value="{{ old('key') }}">
      @error('key')
        <div class="error">{{ $message }}</div>
      @enderror

      <button type="submit">🔓 Decrypt</button>
    </form>

    @isset($plaintext)
      <label for="plaintext">Hasil Dekripsi</label>
      <textarea id="plaintext" readonly rows="3">{{ $plaintext }}</textarea>
      <button type="button" class="btn-copy" onclick="copyToClipboard()">📋 Copy</button>

      <p class="note">
        ✅ Ini adalah hasil akhir dari <strong>dekripsi RC4</strong>.<br>
        Jika Anda melakukan dekripsi berantai, gunakan hasil ini untuk tahap sebelumnya:
        <strong>AES → Caesar → Vigenère</strong>.
      </p>
    @endisset
  </div>
</body>
</html>
