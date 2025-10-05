<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Vigenère Auto-Key Dekripsi</title>
  <style>
    body { background:#0f172a; font-family: Arial, sans-serif; color:#e6eef8; display:flex; justify-content:center; padding:40px; }
    .card { background:#0b1220; padding:30px; border-radius:12px; width:500px; }
    h1 { text-align:center; color:#34d399; margin-bottom:20px; }
    label { font-weight:bold; margin-top:10px; display:block; }
    textarea, input { width:100%; padding:10px; margin-top:5px; border-radius:8px; border:none; background:#1e293b; color:#e6eef8; }
    input[readonly], textarea[readonly] { background:#334155; color:#94a3b8; }
    button { margin-top:15px; width:100%; padding:12px; border:none; border-radius:8px; background:#34d399; color:#000; font-weight:bold; cursor:pointer; }
    .btn-copy { margin-top:8px; background:#22c55e; font-size:14px; padding:6px 12px; border:none; border-radius:6px; cursor:pointer; width:auto; }
    .btn-copy:hover { background:#16a34a; }
    .error { color:#f87171; margin-top:5px; font-size:14px; }
    .note { margin-top:15px; font-size:14px; line-height:1.6; color:#cbd5e1; background:#1e293b; padding:10px; border-radius:8px; }
    .note strong { color:#34d399; }
     .nav-buttons { position:fixed; top:20px; left:20px; display:flex; flex-direction:column; gap:10px; }
    .nav-btn { background:#1e293b; color:#34d399; border:2px solid #34d399; padding:8px 14px; border-radius:8px; font-weight:bold; text-decoration:none; width:160px; text-align:center; }
    .nav-btn:hover { background:#34d399; color:#0f172a; }
  </style>
  <script>
    function copyToClipboard() {
      var copyText = document.getElementById("plaintext");
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");
      alert("Hasil dekripsi berhasil disalin!");
    }
  </script>
</head>
<body>
    <div class="nav-buttons">
    <a href="{{ url('/viginere') }}" class="nav-btn">← Kembali ke Enkripsi Vigenere</a>
    <a href="{{ url('/dekripsi') }}" class="nav-btn">🏠 Halaman Dekripsi</a>
  </div>
  <div class="card">
    <h1>Dekripsi Vigenère Auto-Key</h1>

    <form method="POST" action="{{ route('vigenere.decrypt') }}">
      @csrf

      <label for="ciphertext">Ciphertext</label>
      <textarea name="ciphertext" id="ciphertext" rows="4">{{ old('ciphertext') }}</textarea>
      @error('ciphertext')
        <div class="error">{{ $message }}</div>
      @enderror

      <label for="key">Key</label>
      <input type="text" name="key" id="key" value="{{ old('key') }}">
      @error('key')
        <div class="error">{{ $message }}</div>
      @enderror

      <button type="submit">Decrypt</button>
    </form>

    @isset($plaintext)
      <label for="plaintext">Hasil Dekripsi</label>
      <textarea id="plaintext" readonly rows="3">{{ $plaintext }}</textarea>
      <button type="button" class="btn-copy" onclick="copyToClipboard()">Copy</button>

      <p class="note">
        ✅ Hasil ini adalah <strong>teks asli</strong> setelah dekripsi dengan metode <strong>Vigenère Auto-Key</strong>.
      </p>
    @endisset
  </div>
</body>
</html>
