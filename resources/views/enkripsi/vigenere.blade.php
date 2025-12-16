<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Vigenère (Huruf + Angka)</title>

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

      .btn-glow {
          background: #22d3ee;
          color: #000;
          font-weight: 600;
          border-radius: 10px;
          padding: 10px 18px;
          box-shadow: 0 0 12px rgba(34,211,238,0.55);
          text-decoration: none;
      }

      .btn-glow:hover {
          background: #0ea5e9;
          color: #000;
      }

      .top-buttons a {
          background: rgba(255,255,255,0.1);
          backdrop-filter: blur(6px);
          padding: 8px 14px;
          border-radius: 10px;
          font-weight: 600;
          border: 1px solid rgba(255,255,255,0.2);
          color: #22d3ee;
          transition: 0.3s;
          text-decoration: none;
      }

      .top-buttons a:hover {
          background: rgba(255,255,255,0.25);
          color: #000;
      }

      textarea, input {
          background: rgba(255,255,255,0.08) !important;
          border: 1px solid rgba(255,255,255,0.15) !important;
          color: #e6eef8 !important;
      }
      textarea[readonly], input[readonly] {
          background: rgba(255,255,255,0.15) !important;
          color: #bcd0e6 !important;
      }

      .copy-btn {
          background: #22c55e;
          border: none;
          padding: 8px 12px;
          border-radius: 8px;
          color: #000;
          font-weight: bold;
      }
      .copy-btn:hover { background: #16a34a; }

  </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark px-4 mb-4"
     style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px);">
  <a class="navbar-brand fw-bold" href="/">
    <i class="bi bi-shield-lock"></i> EnkripsiApp
  </a>
</nav>

<!-- TOP BUTTONS (Tidak dihilangkan!) -->
<div class="top-buttons d-flex gap-2 ms-4 mb-3">
    <a href="{{ url('/vigenere') }}">← Enkripsi</a>
    <a href="{{ url('/dekripsi/vigenere') }}">Dekripsi Vigenère</a>
</div>

<div class="container mt-3 mb-5">
  <div class="row justify-content-center">
    <div class="col-lg-7">

      <div class="glass-card">

        <h2 class="fw-bold text-center mb-2">🔐 Vigenère Cipher (Huruf + Angka)</h2>
        <p class="text-center mb-4 text-light">
          Masukkan plaintext serta key untuk melakukan enkripsi.
        </p>

        <!-- FORM -->
        <form method="POST" action="{{ route('vigenere.encrypt') }}">
          @csrf

          <label class="fw-bold mb-1">PLAINTEXT</label>
          <textarea name="plaintext" id="plaintext" rows="3" class="form-control mb-3" required>{{ old('plaintext', $plaintext ?? '') }}</textarea>

          <label class="fw-bold mb-1">KEY (Huruf, Angka, atau Kombinasi)</label>
          <input type="text" name="key" id="key" class="form-control mb-4"
                 value="{{ old('key', $key ?? '') }}" required>

          <button class="btn-glow w-100" type="submit">Enkripsi</button>
        </form>

        <!-- HASIL -->
        @if(isset($ciphertext))
        <div class="mt-4">

          @if(isset($convertedKey))
          <label class="fw-bold mb-1">KEY KONVERSI (Angka → Huruf)</label>
          <input type="text" class="form-control mb-3" value="{{ $convertedKey }}" readonly>
          @endif

          <label class="fw-bold mb-1">KEY OTOMATIS</label>
          <input type="text" class="form-control mb-3" value="{{ $autoKey }}" readonly>

          <label class="fw-bold mb-1">HASIL ENKRIPSI</label>
          <textarea id="ciphertext" rows="3" class="form-control" readonly>{{ $ciphertext }}</textarea>

          <button id="copyBtn" class="copy-btn mt-2">Copy</button>

          <a href="/caesar" class="btn btn-primary w-100 mt-3">
            Lanjut ke Caesar Cipher →
          </a>

          <p class="text-center text-light mt-3 small">
            Anda telah menyelesaikan tahap pertama enkripsi menggunakan <strong>Vigenère Cipher</strong>.  
            Lanjutkan proses enkripsi berikutnya.
          </p>
        </div>
        @endif

      </div>

    </div>
  </div>
</div>

<script>
  const copyBtn = document.getElementById("copyBtn");
  const ciphertextEl = document.getElementById("ciphertext");

  if (copyBtn) {
    copyBtn.addEventListener("click", () => {
      navigator.clipboard.writeText(ciphertextEl.value).then(() => {
        copyBtn.textContent = "Copied!";
        setTimeout(() => copyBtn.textContent = "Copy", 2000);
      });
    });
  }

  const plaintextInput = document.getElementById("plaintext");
  const keyInput = document.getElementById("key");

  function limitKeyLength() {
    const len = plaintextInput.value.length;
    if (keyInput.value.length > len) {
      keyInput.value = keyInput.value.slice(0, len);
    }
  }

  plaintextInput.addEventListener("input", limitKeyLength);
  keyInput.addEventListener("input", limitKeyLength);
</script>

</body>
</html>
