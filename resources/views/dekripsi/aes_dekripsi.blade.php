<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>AES Cipher - Dekripsi</title>
  <style>
    body { background:#0f172a; font-family: Arial, sans-serif; color:#e6eef8; display:flex; justify-content:center; padding:40px; }
    .card { background:#0b1220; padding:30px; border-radius:12px; width:520px; }
    h1 { text-align:center; color:#34d399; margin-bottom:20px; }
    label { font-weight:bold; margin-top:10px; display:block; }
    textarea, input { width:100%; padding:10px; margin-top:5px; border-radius:8px; border:none; background:#1e293b; color:#e6eef8; }
    textarea[readonly], input[readonly] { background:#334155; color:#94a3b8; }
    button { margin-top:15px; width:100%; padding:12px; border:none; border-radius:8px; background:#34d399; color:#000; font-weight:bold; cursor:pointer; }
    .error { color:#f87171; margin-top:5px; font-size:14px; }
    .note { margin-top:15px; font-size:14px; line-height:1.6; color:#cbd5e1; background:#1e293b; padding:10px; border-radius:8px; }
    .nav-buttons { position:fixed; top:20px; left:20px; display:flex; flex-direction:column; gap:10px; }
    .nav-btn { background:#1e293b; color:#34d399; border:2px solid #34d399; padding:8px 14px; border-radius:8px; font-weight:bold; text-decoration:none; width:160px; text-align:center; }
    .nav-btn:hover { background:#34d399; color:#0f172a; }
  </style>
</head>
<body>

  <!-- Tombol navigasi (selalu muncul) -->
  <div class="nav-buttons">
    <a href="{{ url('/aes') }}" class="nav-btn">← Kembali ke Enkripsi AES</a>
    <a href="{{ url('/dekripsi') }}" class="nav-btn">🏠 Halaman Dekripsi</a>
  </div>

  <div class="card">
    <h1>AES Cipher - Dekripsi</h1>

    {{-- Tampilkan error validation (jika ada) --}}
    @if($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('aes.decrypt') }}">
      @csrf

      <label for="ciphertext">Ciphertext (Base64)</label>
      <textarea name="ciphertext" id="ciphertext" rows="4" required>{{ old('ciphertext') }}</textarea>

      <label for="key">Key</label>
      <input type="text" name="key" id="key" value="{{ old('key') }}" required>

      <button type="submit">Decrypt</button>
    </form>

    {{-- Tampilkan hasil dekripsi (flash) --}}
    @if(session('plaintext'))
      <label for="plaintext">Hasil Dekripsi</label>
      <textarea id="plaintext" readonly rows="4">{{ session('plaintext') }}</textarea>

      <p class="note">
        ✅ Dekripsi berhasil menggunakan <strong>AES-256-CBC</strong>.
      </p>
    @endif
  </div>
</body>
</html>
