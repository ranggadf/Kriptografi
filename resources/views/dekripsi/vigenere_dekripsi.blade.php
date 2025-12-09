<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Dekripsi Vigenère Cipher (Tahap Akhir)</title>

  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
      body {
          background: linear-gradient(135deg, #09101c, #0e7490);
          min-height: 100vh;
          color: #e6eef8;
      }

      .glass-card {
          background: rgba(255,255,255,0.06);
          backdrop-filter: blur(12px);
          border: 1px solid rgba(255,255,255,0.15);
          border-radius: 18px;
          padding: 35px;
          box-shadow: 0 20px 45px rgba(0,0,0,0.35);
      }

.nav-floating {
    position: fixed;
    top: 90px; /* ⬅️ Biar tidak menutupi navbar */
    left: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    z-index: 999; /* opsional biar tetap muncul di atas */
}

      .nav-btn {
          background: rgba(255,255,255,0.08);
          border: 1px solid rgba(255,255,255,0.2);
          padding: 10px 16px;
          border-radius: 12px;
          color: #22d3ee;
          font-weight: 600;
          text-decoration: none;
          backdrop-filter: blur(6px);
          transition: 0.3s;
      }
      .nav-btn:hover {
          background: rgba(255,255,255,0.2);
          color: #000;
      }

      textarea, input {
          background: rgba(255,255,255,0.1) !important;
          border: 1px solid rgba(255,255,255,0.2) !important;
          color: #e6eef8 !important;
      }

      .btn-glow {
          background: #22d3ee;
          color: #000;
          border-radius: 10px;
          padding: 12px;
          font-weight: bold;
          box-shadow: 0 0 14px rgba(34,211,238,0.45);
          width: 100%;
      }
      .btn-glow:hover {
          background: #0ea5e9;
          color: #000;
      }

      .note-box {
          background: rgba(255,255,255,0.12);
          border-left: 4px solid #22d3ee;
          padding: 14px;
          border-radius: 10px;
          color: #c7dfff;
          font-size: 14px;
      }

      .result-box {
          background: rgba(255,255,255,0.12);
          padding: 16px;
          border-radius: 12px;
          font-size: 15px;
      }

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

<div class="nav-floating">
    <a href="{{ url('/dekripsi') }}" class="nav-btn">← Menu Dekripsi</a>
    <a href="{{ url('/') }}" class="nav-btn">🏠 Halaman Utama</a>
</div>

<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-lg-7">

      <div class="glass-card">

        <h2 class="fw-bold text-center mb-2">🔓 Dekripsi Vigenère Cipher</h2>
        <p class="text-center mb-4 text-light">Tahap ke-4 (Terakhir) dari proses dekripsi berlapis</p>

        <div class="note-box mb-4">
          <strong>📘 Catatan:</strong> Ini adalah tahap terakhir setelah dekripsi  
          <b>RC4 → AES → Caesar Cipher</b>.  
          Pastikan ciphertext berasal dari hasil *Caesar Cipher* sebelumnya.
        </div>

        <!-- FORM -->
        <form action="{{ route('vigenere.decrypt') }}" method="POST">
          @csrf

          <label class="fw-bold mb-1">Ciphertext</label>
          <textarea class="form-control mb-3" id="ciphertext" name="ciphertext"
                    rows="4" required>{{ old('ciphertext', $ciphertext ?? '') }}</textarea>

          <label class="fw-bold mb-1">Key</label>
          <input type="text" class="form-control mb-3" id="key" name="key"
                 value="{{ old('key', $key ?? '') }}" required>

          <button type="submit" class="btn-glow">Dekripsi Sekarang</button>
        </form>

        @isset($plaintext)
        <div class="result-box mt-4">
          <strong>🔓 Hasil Dekripsi Final:</strong><br>
          {{ $plaintext }}
        </div>
        @endisset

        <div class="text-center mt-3">
          <a href="{{ url('/') }}" class="text-light text-decoration-none">
            ← Kembali ke Halaman Utama
          </a>
        </div>

      </div>

    </div>
  </div>
</div>

<!-- LIMIT KEY LENGTH -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  const cipherInput = document.getElementById("ciphertext");
  const keyInput = document.getElementById("key");

  function limitKey() {
    const max = cipherInput.value.trim().length;
    if (keyInput.value.length > max) {
      keyInput.value = keyInput.value.slice(0, max);
    }
  }

  keyInput.addEventListener("input", limitKey);
  cipherInput.addEventListener("input", limitKey);
});
</script>

</body>
</html>
