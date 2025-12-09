<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Halaman Enkripsi</title>

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

      .menu-card {
          background: rgba(255,255,255,0.08);
          backdrop-filter: blur(6px);
          padding: 25px;
          border-radius: 14px;
          border: 1px solid rgba(255,255,255,0.1);
          transition: 0.3s;
          text-align: center;
      }

      .menu-card:hover {
          transform: translateY(-6px);
          background: rgba(255,255,255,0.15);
      }

      .menu-title {
          color: #22d3ee;
          font-weight: bold;
          margin-bottom: 8px;
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

  </style>
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

        <h2 class="fw-bold text-center mb-2">
          🔐 Halaman Enkripsi
        </h2>

        <p class="text-center mb-4 text-light">
          Pilih salah satu metode enkripsi untuk memulai proses.
        </p>

        <div class="row g-3">

          <!-- ENKRIPSI BERTAHAP -->
          <div class="col-md-6">
            <div class="menu-card">
              <h5 class="menu-title">Enkripsi Bertahap</h5>
              <p class="small text-light">Proses RC4 → AES → Caesar → Vigenère.</p>
              <a href="{{ url('/enkripsibertahap') }}" class="btn-glow">Gunakan</a>
            </div>
          </div>

          <!-- VIGENERE -->
          <div class="col-md-6">
            <div class="menu-card">
              <h5 class="menu-title">Vigenère Cipher</h5>
              <p class="small text-light">Enkripsi dengan kata kunci berulang.</p>
              <a href="{{ url('/vigenere') }}" class="btn-glow">Gunakan</a>
            </div>
          </div>

          <!-- CAESAR -->
          <div class="col-md-6">
            <div class="menu-card">
              <h5 class="menu-title">Caesar Cipher</h5>
              <p class="small text-light">Enkripsi klasik dengan pergeseran huruf.</p>
              <a href="{{ url('/caesar') }}" class="btn-glow">Gunakan</a>
            </div>
          </div>

          <!-- AES -->
          <div class="col-md-6">
            <div class="menu-card">
              <h5 class="menu-title">AES</h5>
              <p class="small text-light">Advanced Encryption Standard modern.</p>
              <a href="{{ url('/aes') }}" class="btn-glow">Gunakan</a>
            </div>
          </div>

          <!-- RC4 -->
          <div class="col-md-6">
            <div class="menu-card">
              <h5 class="menu-title">RC4</h5>
              <p class="small text-light">Stream cipher cepat dan ringan.</p>
              <a href="{{ url('/rc4') }}" class="btn-glow">Gunakan</a>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

</body>
</html>
