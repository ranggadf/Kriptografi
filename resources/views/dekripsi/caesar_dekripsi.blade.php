<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Dekripsi Caesar Cipher</title>

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
    <i class="bi bi-unlock"></i> DekripsiApp
  </a>
</nav>

<!-- TOP BUTTONS -->
<div class="top-buttons d-flex gap-2 ms-4 mb-3">
    <a href="{{ url('/caesar') }}">← Enkripsi Caesar</a>
    <a href="{{ url('/dekripsi') }}">🏠 Halaman Dekripsi</a>
</div>

<div class="container mt-3 mb-5">
  <div class="row justify-content-center">
    <div class="col-lg-7">

      <div class="glass-card">

        <h2 class="fw-bold text-center mb-2">🔓 Dekripsi Caesar Cipher</h2>
        <p class="text-center mb-4 text-light">
          Masukkan ciphertext dan key untuk melakukan dekripsi.
        </p>

        <!-- FORM -->
        <form method="POST" action="{{ route('caesar.decrypt') }}">
          @csrf

          <label class="fw-bold mb-1">CIPHERTEXT</label>
          <textarea name="ciphertext" rows="3" class="form-control mb-3" required>{{ old('ciphertext', $ciphertext ?? '') }}</textarea>

          <label class="fw-bold mb-1">KEY (Huruf)</label>
          <input type="text" name="key" class="form-control mb-4" value="{{ old('key', $key ?? '') }}" required>

          <button class="btn-glow w-100" type="submit">Dekripsi</button>
        </form>

        @isset($plaintext)
        <div class="mt-4">

          <label class="fw-bold mb-1">HASIL DEKRIPSI</label>
          <textarea id="plaintext" rows="3" class="form-control" readonly>{{ $plaintext }}</textarea>

          <button id="copyBtn" class="copy-btn mt-2">Copy</button>

          <a href="{{ url('/dekripsi/vigenere') }}" id="nextBtn" class="btn btn-primary w-100 mt-3 disabled">
            Lanjut ke Dekripsi Vigenère →
          </a>

          <p class="text-center text-light mt-3 small">
            Silakan salin hasil dekripsi ini terlebih dahulu untuk melanjutkan ke tahap berikutnya.
          </p>
        </div>
        @endisset

      </div>

    </div>
  </div>
</div>

<script>
  const copyBtn = document.getElementById("copyBtn");
  const plaintextEl = document.getElementById("plaintext");
  const nextBtn = document.getElementById("nextBtn");

  if (copyBtn) {
    copyBtn.addEventListener("click", () => {
      navigator.clipboard.writeText(plaintextEl.value).then(() => {
        copyBtn.textContent = "Copied!";
        nextBtn.classList.remove("disabled");
        setTimeout(() => (copyBtn.textContent = "Copy"), 2000);
      });
    });
  }
</script>

</body>
</html>
