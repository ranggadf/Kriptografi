<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Web Enkripsi & Dekripsi — Kelompok 3</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
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
          padding: 50px;
          box-shadow: 0 20px 45px rgba(0,0,0,0.35);
      }

      .feature-card {
          background: rgba(255,255,255,0.08);
          border-radius: 14px;
          padding: 25px;
          transition: 0.3s;
          height: 100%;
      }

      .feature-card:hover {
          transform: translateY(-6px);
          box-shadow: 0 10px 28px rgba(0,0,0,0.3);
      }

      footer {
          opacity: 0.75;
      }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-dark navbar-expand-lg px-4" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px);">
    <a class="navbar-brand fw-bold" href="#">
      <i class="bi bi-shield-lock"></i> EnkripsiApp
    </a>
  </nav>

  <div class="container my-5">
      <div class="row justify-content-center">
          <div class="col-lg-10">

              <!-- HERO / WELCOME -->
              <div class="glass-card text-center mb-5">

                  <h1 class="fw-bold mb-3">
                    Selamat Datang di Web Enkripsi & Dekripsi
                  </h1>

                  <p class="lead">
                    Sistem keamanan data dengan metode:
                    <br>
                    <strong>Vigenère → Caesar → AES → RC4</strong>
                  </p>

                  <div class="mt-4 d-flex justify-content-center gap-3">
                      <a href="enkripsi" class="btn btn-success px-4 py-2 fw-semibold">
                          <i class="bi bi-lock-fill"></i> Enkripsi
                      </a>

                      <a href="dekripsi" class="btn btn-outline-light px-4 py-2 fw-semibold">
                          <i class="bi bi-unlock-fill"></i> Dekripsi
                      </a>
                  </div>
              </div>

              <!-- PENJELASAN LAPISAN & METODE -->
<h4 class="text-center mb-4 fw-bold">Struktur Lapisan & Metode Sistem</h4>

<div class="row g-4">

    <!-- Urutan Lapisan -->
    <div class="col-md-6">
        <div class="feature-card p-4 h-100">
            <i class="bi bi-diagram-3-fill fs-1 text-info mb-3 d-block text-center"></i>
            <h5 class="fw-bold text-center mb-3">Urutan Lapisan Proses</h5>

            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-transparent text-light">
                    <strong>1. Vigenère</strong><br>
                    Enkripsi menggunakan kunci berulang untuk menghasilkan cipher awal.
                </li>
                <li class="list-group-item bg-transparent text-light">
                    <strong>2. Caesar</strong><br>
                    Pergeseran karakter untuk lapisan keamanan tambahan.
                </li>
                <li class="list-group-item bg-transparent text-light">
                    <strong>3. AES</strong><br>
                    Proses enkripsi blok yang sangat aman (Advanced Encryption Standard).
                </li>
                <li class="list-group-item bg-transparent text-light">
                    <strong>4. RC4</strong><br>
                    Stream cipher sebagai lapisan terakhir untuk fleksibilitas dan kecepatan.
                </li>
            </ul>
        </div>
    </div>

    <!-- Penjelasan Metode -->
    <div class="col-md-6">
        <div class="feature-card p-4 h-100">
            <i class="bi bi-journal-text fs-1 text-warning mb-3 d-block text-center"></i>
            <h5 class="fw-bold text-center mb-3">Penjelasan Metode Enkripsi</h5>

            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-transparent text-light">
                    <strong>Vigenère Cipher</strong>  
                    Menggunakan kata kunci untuk mengacak teks secara berulang.
                </li>

                <li class="list-group-item bg-transparent text-light">
                    <strong>Caesar Cipher</strong>  
                    Metode klasik dengan shifting huruf untuk lapisan kedua.
                </li>

                <li class="list-group-item bg-transparent text-light">
                    <strong>AES</strong>  
                    Algoritma enkripsi modern yang sangat kuat dan digunakan secara luas.
                </li>

                <li class="list-group-item bg-transparent text-light">
                    <strong>RC4</strong>  
                    Stream cipher cepat untuk proses enkripsi/dekripsi data dinamis.
                </li>
            </ul>
        </div>
    </div>

</div>

              <footer class="text-center mt-5">
                  © <?= date('Y') ?> KELOMPOK 3<br>RANGGA • AJENG • VAVA • AMRO
              </footer>

          </div>
      </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
