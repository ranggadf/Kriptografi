<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Dekripsi Bertahap</title>

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
          padding: 40px;
          box-shadow: 0 20px 45px rgba(0,0,0,0.35);
      }

      .step-box {
          background: rgba(255,255,255,0.08);
          padding: 15px 18px;
          border-left: 4px solid #22d3ee;
          border-radius: 12px;
          margin-top: 15px;
          word-break: break-all;
      }

      .btn-glow {
          box-shadow: 0 0 12px rgba(34,211,238,0.5);
      }

      textarea, input {
          background: rgba(255,255,255,0.07) !important;
          color: #e6eef8 !important;
          border: 1px solid rgba(255,255,255,0.15) !important;
      }

      .note-box {
          background: rgba(255,255,255,0.08);
          border-left: 4px solid #22d3ee;
          padding: 15px;
          border-radius: 12px;
      }

  </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark navbar-expand-lg px-4" 
     style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px);">
  <a class="navbar-brand fw-bold" href="/">
    <i class="bi bi-shield-lock"></i> EnkripsiApp
  </a>
</nav>


<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <div class="glass-card">

        <!-- JUDUL -->
        <h2 class="fw-bold mb-3 text-center">
          🔑 Dekripsi Bertahap
        </h2>

        <p class="text-center mb-4">
          Proses berurutan: <strong>RC4 → AES → Caesar → Vigenère</strong>
        </p>

        <!-- NOTE -->
        <div class="note-box mb-4">
          Masukkan ciphertext dan 1 key utama untuk mendekripsi semua tahap secara otomatis.
        </div>

        <!-- ERROR -->
        @if ($errors->any())
        <div class="alert alert-danger">
          ⚠️ {{ $errors->first() }}
        </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('dekripsibertahap.decrypt') }}">
          @csrf

          <label class="fw-semibold mt-2">Ciphertext</label>
          <textarea name="ciphertext" rows="4" class="form-control" required>{{ old('ciphertext', $ciphertext ?? '') }}</textarea>


          <label class="fw-semibold mt-3">Key Utama</label>
          <input type="text" name="key" class="form-control" 
                 value="{{ old('key', $key ?? '') }}" required>

          <button class="btn btn-info w-100 mt-4 fw-semibold btn-glow">
            <i class="bi bi-unlock"></i> Dekripsi Semua Tahap
          </button>
        </form>


        <!-- HASIL -->
        @isset($finalPlaintext)
        <hr class="my-4">

        <h4 class="fw-bold text-center mb-3">Hasil Dekripsi</h4>

        <div class="step-box">
          <strong>Setelah RC4:</strong><br> {{ $afterRC4 }}
        </div>

        <div class="step-box">
          <strong>Setelah AES:</strong><br> {{ $afterAES }}
        </div>

        <div class="step-box">
          <strong>Setelah Caesar:</strong><br> {{ $afterCaesar }}
        </div>

        <div class="step-box">
          <strong>Setelah Vigenère (Final):</strong><br> {{ $finalPlaintext }}
        </div>

        <a href="/enkripsibertahap" 
           class="btn btn-outline-light w-100 mt-4 fw-semibold">
          🔐 Kembali ke Enkripsi Bertahap
        </a>

        @endisset

      </div>

    </div>
  </div>
</div>

</body>
</html>
