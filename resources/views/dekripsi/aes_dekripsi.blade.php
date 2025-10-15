<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>AES Cipher - Dekripsi</title>
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
      width: 520px;
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

    textarea[readonly], input[readonly] {
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

    /* Navigasi kiri */
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
      width: 200px;
      text-align: center;
      transition: all 0.2s;
    }

    .nav-btn:hover {
      background: #34d399;
      color: #0f172a;
    }

    /* Tombol bawah (ke Caesar) */
    .btn-next {
      margin-top: 15px;
      background: #3b82f6;
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      padding: 12px;
      width: 100%;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn-next:hover {
      background: #2563eb;
    }

    .btn-next:disabled {
      background: #475569;
      cursor: not-allowed;
    }
  </style>

  <script>
    function copyToClipboard() {
      const copyText = document.getElementById("plaintext");
      if (!copyText) return;

      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");

      // Aktifkan tombol lanjut ke Caesar
      const nextBtn = document.getElementById("nextBtn");
      if (nextBtn) {
        nextBtn.disabled = false;
      }

      alert("✅ Hasil dekripsi AES berhasil disalin!\nSekarang Anda bisa lanjut ke dekripsi Caesar Cipher.");
    }
  </script>
</head>
<body>

  <!-- Tombol navigasi -->
  <div class="nav-buttons">
    <a href="{{ url('/aes') }}" class="nav-btn">← Kembali ke Enkripsi AES</a>
    <a href="{{ url('/dekripsi') }}" class="nav-btn">🏠 Halaman Dekripsi</a>
  </div>

  <div class="card">
    <h1>AES Cipher - Dekripsi</h1>

    @if($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('aes.decrypt') }}">
      @csrf

      <label for="ciphertext">Ciphertext (Base64)</label>
      <textarea name="ciphertext" id="ciphertext" rows="4" required>{{ old('ciphertext') }}</textarea>

      <label for="key">Key</label>
      <input type="text" name="key" id="key" value="{{ old('key') }}" required>

      <button type="submit">🔓 Decrypt</button>
    </form>

    @if(session('plaintext'))
      <label for="plaintext">Hasil Dekripsi</label>
      <textarea id="plaintext" readonly rows="4">{{ session('plaintext') }}</textarea>

      <button type="button" class="btn-copy" onclick="copyToClipboard()">📋 Copy</button>

      <p class="note">
        ✅ Ini adalah hasil akhir dari <strong>dekripsi AES</strong>.<br>
        Silakan salin hasil ini terlebih dahulu sebelum melanjutkan ke tahap berikutnya:
        <strong>Caesar Cipher</strong>.
      </p>

      <!-- Tombol lanjut ke Caesar -->
      <form action="{{ url('/dekripsi/caesar') }}" method="GET">
        <button type="submit" id="nextBtn" class="btn-next" disabled>
          ➡️ Lanjut ke Dekripsi Caesar
        </button>
      </form>
    @endif
  </div>

</body>
</html>
