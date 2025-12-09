<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Caesar Cipher</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #09101c, #0e7490);
      min-height: 100vh;
      color: #e6eef8;
      padding-top: 80px;
    }

    .glass-card {
      background: rgba(255,255,255,0.05);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255,255,255,0.12);
      border-radius: 18px;
      padding: 35px;
      box-shadow: 0 20px 45px rgba(0,0,0,0.35);
    }

    label {
      font-weight: 600;
      margin-top: 10px;
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

    .btn-glow {
      background: #22d3ee;
      color: #000;
      font-weight: 600;
      border-radius: 10px;
      padding: 12px;
      width: 100%;
      box-shadow: 0 0 12px rgba(34,211,238,0.55);
      border: none;
    }

    .btn-glow:hover {
      background: #0ea5e9;
      color: #000;
    }

    .btn-copy {
      background: #0ea5e9;
      color: #fff;
      padding: 7px 14px;
      border-radius: 8px;
      border: none;
      margin-top: 8px;
    }

    .btn-copy:hover {
      background: #0284c7;
    }

    .btn-next {
      margin-top: 12px;
      background: #38bdf8;
      color: #000;
      font-weight: bold;
      border-radius: 10px;
      padding: 10px;
      width: 100%;
      border: none;
    }

    .btn-next:disabled {
      background:#475569;
      cursor:not-allowed;
      color: #cbd5e1;
    }

    .note {
      margin-top: 15px;
      color: #cbd5e1;
      font-size: 14px;
      text-align: center;
    }

    /* Tombol Navigasi */
    .nav-buttons {
      position: fixed;
      top: 20px;
      left: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      z-index: 999;
    }

    .nav-btn {
      background: rgba(255,255,255,0.08);
      border: 1px solid #22d3ee;
      color: #22d3ee;
      padding: 8px 14px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 600;
      backdrop-filter: blur(6px);
    }

    .nav-btn:hover {
      background: #22d3ee;
      color: #000;
    }
  </style>

  <script>
    function copyToClipboard() {
      var copyText = document.getElementById("ciphertext");
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");

      alert("✅ Hasil enkripsi Caesar berhasil disalin!");
      document.getElementById("nextBtn").disabled = false;
    }
  </script>

</head>
<body>

  <!-- NAVIGATION BUTTONS -->
  <div class="nav-buttons">
    <a href="{{ url('/enkripsi') }}" class="nav-btn">← Halaman Enkripsi</a>
    <a href="{{ url('/dekripsi/caesar') }}" class="nav-btn">🔓 Dekripsi Caesar</a>
  </div>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">

        <div class="glass-card">

          <h2 class="fw-bold text-center mb-3" style="color:#22d3ee;">
            🔐 Caesar Cipher
          </h2>

          <form method="POST" action="{{ route('caesar.encrypt') }}">
            @csrf

            <label for="plaintext">Plaintext</label>
            <textarea name="plaintext" id="plaintext" rows="4" class="form-control">{{ old('plaintext') }}</textarea>
            @error('plaintext')
              <div class="text-danger small">{{ $message }}</div>
            @enderror

            <label for="key">Key</label>
            <input type="text" name="key" id="key" class="form-control" value="{{ old('key') }}">
            @error('key')
              <div class="text-danger small">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn-glow mt-3">Encrypt</button>
          </form>

          @isset($ciphertext)
            <label for="ciphertext" class="mt-3">Hasil Enkripsi</label>
            <input type="text" id="ciphertext" class="form-control" value="{{ $ciphertext }}" readonly>

            <button type="button" class="btn-copy" onclick="copyToClipboard()">
              📋 Copy
            </button>

            <form action="{{ url('/aes') }}" method="GET">
              <button type="submit" id="nextBtn" class="btn-next" disabled>
                Lanjut ke AES →
              </button>
            </form>

            <p class="note mt-3">
              Tahap enkripsi Caesar selesai. Lanjutkan dengan AES untuk tahap berikutnya.
            </p>
          @endisset

        </div>

      </div>
    </div>
  </div>

</body>
</html>
