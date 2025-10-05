<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>RC4 Cipher</title>
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
    .btn-back { background:#3b82f6; color:white; margin-top:20px; }
    .btn-decrypt { background:#f59e0b; color:black; margin-top:10px; }
    .error { color:#f87171; margin-top:5px; font-size:14px; }
    .note { margin-top:15px; font-size:14px; line-height:1.6; color:#cbd5e1; background:#1e293b; padding:10px; border-radius:8px; }
    .note strong { color:#34d399; }
  </style>
  <script>
    function copyToClipboard() {
      var copyText = document.getElementById("ciphertext");
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");
      alert("✅ Hasil RC4 berhasil disalin ke clipboard!");
    }
  </script>
</head>
<body>
  <div class="card">
    <h1>RC4 Cipher</h1>

    <form method="POST" action="{{ route('rc4.encrypt') }}">
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

      <p class="note">
        Tahap ini adalah <strong>tahap terakhir</strong> dari proses enkripsi berantai.<br>
        Anda telah berhasil melalui <strong>Vigenère</strong> → <strong>Caesar</strong> → <strong>AES</strong> → <strong>RC4</strong>.
      </p>
      <p class="note">
        ⚡ <strong>Catatan:</strong> Simpan atau salin hasil enkripsi ini jika ingin melanjutkan ke proses <strong>dekripsi berantai</strong>.
      </p>

      <!-- Tombol Navigasi -->
      <form action="{{ url('/enkripsi') }}" method="GET">
        <button type="submit" class="btn-back">⬅ Kembali ke Halaman enkripsi</button>
      </form>

      <form action="{{ url('/dekripsi/rc4_dekripsi') }}" method="GET">
        <button type="submit" class="btn-decrypt">🔐 Menuju Halaman Dekripsi RC4</button>
      </form>
    @endisset
  </div>
</body>
</html>
