<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Dekripsi Caesar Cipher</title>

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

    textarea, input {
      background: rgba(255,255,255,0.1) !important;
      border: 1px solid rgba(255,255,255,0.2) !important;
      color: #e6eef8 !important;
    }

    textarea[readonly] {
      background: rgba(255,255,255,0.15) !important;
      color: #aab9d6 !important;
    }

    .btn-glow {
      background: #22d3ee;
      color: #000;
      border-radius: 10px;
      padding: 12px;
      font-weight: bold;
      box-shadow: 0 0 14px rgba(34,211,238,0.45);
      width: 100%;
      transition: .3s;
    }
    .btn-glow:hover { background:#0ea5e9; color:#000; }

    .btn-copy {
      background:#34d399;
      color:#000;
      border-radius:10px;
      font-weight:bold;
      padding:8px 14px;
      border:none;
      transition:0.3s;
    }
    .btn-copy:hover { background:#22c55e; }

    .note-box {
      background: rgba(255,255,255,0.12);
      padding: 14px;
      border-left: 4px solid #22d3ee;
      border-radius: 10px;
      color: #c7dfff;
      font-size: 14px;
    }

    .btn-next {
      background:#3b82f6;
      color:white;
      padding:12px;
      border-radius:10px;
      width:100%;
      font-weight:bold;
      border:none;
      margin-top:10px;
      transition:.3s;
    }
    .btn-next:hover { background:#2563eb; }
    .btn-next:disabled { background:#475569; cursor:not-allowed; }

    /* floating nav kiri */
    .nav-floating {
      position: fixed;
      top: 90px;
      left: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      z-index: 999;
    }

    .nav-btn {
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.2);
      padding: 10px 16px;
      border-radius: 12px;
      font-weight: 600;
      color: #22d3ee;
      text-decoration: none;
      backdrop-filter: blur(6px);
      transition: 0.3s;
      width: 200px;
      text-align: center;
    }
    .nav-btn:hover {
      background: rgba(255,255,255,0.25);
      color: #000;
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

<!-- NAV FLOATING -->
<div class="nav-floating">
    <a href="{{ url('/caesar') }}" class="nav-btn">← Kembali ke Enkripsi Caesar</a>
    <a href="{{ url('/dekripsi') }}" class="nav-btn">🏠 Menu Dekripsi</a>
</div>

<!-- MAIN CONTENT -->
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-lg-6">

      <div class="glass-card">

        <h2 class="fw-bold text-center mb-2">🔓 Dekripsi Caesar Cipher</h2>
        <p class="text-center mb-4 text-light">Tahap ketiga setelah AES</p>

        <!-- FORM -->
        <form action="{{ route('caesar.decrypt') }}" method="POST">
          @csrf

          <label class="fw-bold mb-1">Ciphertext</label>
          <textarea id="ciphertext" name="ciphertext" class="form-control mb-3" rows="4" required>{{ old('ciphertext', $ciphertext ?? '') }}</textarea>

          <label class="fw-bold mb-1">Key (huruf)</label>
          <input type="text" id="key" name="key" class="form-control mb-3" value="{{ old('key', $key ?? '') }}" required>

          <button type="submit" class="btn-glow">Dekripsi Sekarang</button>
        </form>

        @isset($plaintext)
        <label class="fw-bold mt-4">Hasil Dekripsi</label>
        <textarea readonly id="plaintext" class="form-control mt-1" rows="3">{{ $plaintext }}</textarea>

        <button type="button" class="btn-copy mt-2" onclick="copyToClipboard()">
          📋 Copy
        </button>

        <div class="note-box mt-3">
          Hasil dekripsi Caesar telah berhasil dibuat.
          Lanjutkan ke tahap terakhir: <strong>Vigenère Cipher</strong>.
        </div>

        <form action="{{ url('/dekripsi/vigenere') }}" method="GET">
          <button type="submit" id="nextBtn" class="btn-next" disabled>
            ➡️ Lanjut ke Dekripsi Vigenère
          </button>
        </form>
        @endisset

      </div>

    </div>
  </div>
</div>

<script>
function copyToClipboard() {
  const text = document.getElementById("plaintext");
  text.select();
  text.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(text.value);

  document.getElementById("nextBtn").disabled = false;

  alert("✅ Hasil Caesar berhasil disalin! Lanjutkan ke Vigenère.");
}
</script>

</body>
</html>
