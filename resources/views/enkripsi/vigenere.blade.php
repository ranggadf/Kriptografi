<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kriptografi - Vigenère (Huruf + Angka)</title>
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
    h1 { text-align: center; color: #34d399; margin-bottom: 20px; }
    label { font-weight: bold; margin-top: 10px; display: block; }
    textarea, input {
      width: 100%; padding: 10px; margin-top: 5px;
      border-radius: 8px; border: none;
      background: #1e293b; color: #e6eef8;
    }
    input[readonly], textarea[readonly] { background: #334155; color: #94a3b8; }
    button {
      margin-top: 15px; width: 100%; padding: 12px;
      border: none; border-radius: 8px;
      background: #34d399; color: #000;
      font-weight: bold; cursor: pointer;
    }
    .btn-copy { margin-top: 8px; background: #22c55e; font-size: 14px; padding: 6px 12px; border: none; border-radius: 6px; cursor: pointer; }
    .btn-copy:hover { background: #16a34a; }
    .btn-next { margin-top: 12px; background: #3b82f6; }
    .note { margin-top: 10px; font-size: 14px; color: #94a3b8; text-align: center; }
    .top-buttons {
      position: fixed; top: 20px; left: 20px;
      display: flex; gap: 10px;
    }
    .nav-btn {
      background: #1e293b; color: #34d399; border: 2px solid #34d399;
      padding: 8px 14px; border-radius: 8px;
      font-weight: bold; text-decoration: none; transition: 0.3s;
    }
    .nav-btn:hover { background: #34d399; color: #0f172a; }
  </style>
</head>
<body>
  <!-- Tombol Navigasi -->
  <div class="top-buttons">
    <a href="{{ url('/vigenere') }}" class="nav-btn">← Enkripsi</a>
    <a href="{{ url('/dekripsi/vigenere') }}" class="nav-btn">Dekripsi Vigenère</a>
  </div>

  <div class="card">
    <h1>KRIPTOGRAFI - VIGENÈRE (Huruf + Angka)</h1>

    <form method="POST" action="{{ route('vigenere.encrypt') }}">
      @csrf
      <label for="plaintext">PLAINTEXT</label>
      <textarea name="plaintext" id="plaintext" rows="3" required>{{ old('plaintext', $plaintext ?? '') }}</textarea>

      <label for="key">KEY (Huruf, Angka, atau Kombinasi)</label>
      <input type="text" name="key" id="key" value="{{ old('key', $key ?? '') }}" required>

      <button type="submit">Encrypt</button>
    </form>

    @if(isset($ciphertext))
    <div id="resultBox">
      @if(isset($convertedKey))
      <label for="convertedKey">KEY KONVERSI (Angka → Huruf)</label>
      <input type="text" id="convertedKey" value="{{ $convertedKey }}" readonly>
      @endif

      <label for="autoKey">KEY OTOMATIS</label>
      <input type="text" id="autoKey" value="{{ $autoKey }}" readonly>

      <label for="ciphertext">HASIL ENKRIPSI</label>
      <textarea id="ciphertext" rows="3" readonly>{{ $ciphertext }}</textarea>
      <button id="copyBtn" class="btn-copy">Copy to Clipboard</button>

      <button id="nextBtn" class="btn-next">Lanjut ke Caesar Cipher</button>

      <p class="note">
        Anda telah menyelesaikan tahap pertama enkripsi dengan metode <strong>Vigenère Cipher (Huruf + Angka)</strong>.<br>
        Selanjutnya, teks ini bisa diproses lagi dengan Caesar Cipher.
      </p>
    </div>
    @endif
  </div>

  <script>
    const copyBtn = document.getElementById("copyBtn");
    const nextBtn = document.getElementById("nextBtn");
    const ciphertextEl = document.getElementById("ciphertext");

    if (copyBtn) {
      copyBtn.addEventListener("click", () => {
        navigator.clipboard.writeText(ciphertextEl.value).then(() => {
          copyBtn.textContent = "Copied!";
          setTimeout(() => copyBtn.textContent = "Copy to Clipboard", 2000);
        });
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener("click", () => {
        window.location.href = "/caesar";
      });
    }
  </script>
</body>
</html>
