<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>RC4 Cipher - Enkripsi</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
      body {
          background: linear-gradient(135deg, #09101c, #0e7490);
          min-height: 100vh;
          color: #e6eef8;
      }

      .glass-card {
          background: rgba(255,255,255,0.05);
          backdrop-filter: blur(10px);
          border: 1px solid rgba(255,255,255,0.1);
          border-radius: 18px;
          padding: 35px;
          box-shadow: 0 20px 45px rgba(0,0,0,0.35);
      }

      label {
          font-weight: bold;
          margin-top: 10px;
      }

      textarea, input {
          width: 100%;
          padding: 12px;
          margin-top: 6px;
          border-radius: 12px;
          border: none;
          background: rgba(255,255,255,0.08);
          backdrop-filter: blur(6px);
          color: #e6eef8;
      }

      textarea[readonly], input[readonly] {
          background: rgba(255,255,255,0.15);
          color: #cbd5e1;
      }

      .btn-glow {
          background: #22d3ee;
          color: #000;
          font-weight: 600;
          border-radius: 12px;
          padding: 10px 18px;
          box-shadow: 0 0 12px rgba(34,211,238,0.55);
          border: none;
          width: 100%;
      }

      .btn-glow:hover {
          background: #0ea5e9;
      }

      .btn-copy {
          margin-top: 10px;
          background: #22d3ee;
          color: #000;
          border: none;
          padding: 8px 14px;
          border-radius: 10px;
          font-weight: bold;
          box-shadow: 0 0 10px rgba(34,211,238,0.4);
      }

      .btn-copy:hover {
          background: #0ea5e9;
      }

      .btn-back,
      .btn-decrypt {
          width: 100%;
          border: none;
          padding: 12px;
          border-radius: 12px;
          font-weight: bold;
          margin-top: 12px;
      }

      .btn-back {
          background: #3b82f6;
          color: #fff;
      }

      .btn-back:hover {
          background: #2563eb;
      }

      .btn-decrypt {
          background: #fbbf24;
          color: #000;
      }

      .note {
          margin-top: 15px;
          color: #cbd5e1;
          background: rgba(255,255,255,0.08);
          padding: 12px;
          border-radius: 12px;
          font-size: 14px;
      }

      /* Tombol navigasi kecil */
      .nav-btn {
          background: rgba(255,255,255,0.08);
          border: 1px solid rgba(255,255,255,0.2);
          color: #22d3ee;
          padding: 8px 14px;
          border-radius: 8px;
          font-weight: bold;
          text-decoration: none;
          transition: 0.3s;
      }

      .nav-btn:hover {
          background: rgba(255,255,255,0.2);
          color: #0f172a;
      }
  </style>

  <script>
    function copyToClipboard() {
      var copyText = document.getElementById("ciphertext");
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");
      alert("✅ Hasil RC4 berhasil disalin!");
    }
  </script>

</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark px-4"
     style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px);">
  <a class="navbar-brand fw-bold" href="/">
    <i class="bi bi-shield-lock"></i> EnkripsiApp
  </a>
</nav>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <div class="glass-card">

        <a href="{{ url('/enkripsi') }}" class="nav-btn mb-3 d-inline-block">← Kembali</a>

        <h2 class="fw-bold text-center mb-3">🔐 RC4 Cipher - Enkripsi</h2>

        <form method="POST" action="{{ route('rc4.encrypt') }}">
          @csrf

          <label for="plaintext">Plaintext</label>
          <textarea name="plaintext" id="plaintext" rows="4">{{ old('plaintext') }}</textarea>
          @error('plaintext')
            <div class="text-danger small">{{ $message }}</div>
          @enderror

          <label for="key">Key</label>
          <input type="text" name="key" id="key" value="{{ old('key') }}">
          @error('key')
            <div class="text-danger small">{{ $message }}</div>
          @enderror

          <button type="submit" class="btn-glow mt-3">Encrypt</button>
        </form>

        @isset($ciphertext)
          <label class="mt-4">Hasil Enkripsi (Base64)</label>
          <textarea id="ciphertext" readonly rows="3">{{ $ciphertext }}</textarea>

          <button type="button" class="btn-copy" onclick="copyToClipboard()">Copy</button>

          <p class="note">
            Tahap ini adalah <strong>tahap terakhir</strong> dari proses enkripsi berantai.<br>
            Anda telah melalui urutan:<br>
            <b>Vigenère → Caesar → AES → RC4</b>.
          </p>

          <p class="note">
            ⚡ <strong>Catatan:</strong> Simpan hasil enkripsi ini untuk proses
            <strong>dekripsi berantai</strong>.
          </p>

          <form action="{{ url('/enkripsi') }}" method="GET">
            <button type="submit" class="btn-back">⬅ Kembali ke Halaman Enkripsi</button>
          </form>

          <form action="{{ url('/dekripsi/rc4_dekripsi') }}" method="GET">
            <button type="submit" class="btn-decrypt">🔐 Menuju Dekripsi RC4</button>
          </form>
        @endisset

      </div>

    </div>
  </div>
</div>

</body>
</html>
