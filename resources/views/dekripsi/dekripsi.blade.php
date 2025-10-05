<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Halaman Dekripsi</title>
  <style>
    body {
      background: #0f172a;
      font-family: Arial, sans-serif;
      color: #e6eef8;
      margin: 0;
      padding: 40px;
      display: flex;
      justify-content: center;
    }

    .container {
      max-width: 900px;
      width: 100%;
    }

    h1 {
      text-align: center;
      color: #34d399;
      margin-bottom: 10px;
    }

    p {
      text-align: center;
      color: #94a3b8;
      margin-bottom: 30px;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }

    .card {
      background: #0b1220;
      padding: 25px;
      border-radius: 12px;
      text-align: center;
      transition: 0.3s;
    }

    .card:hover {
      background: #1e293b;
      transform: translateY(-4px);
    }

    .card h2 {
      color: #34d399;
      margin-bottom: 10px;
    }

    .card p {
      font-size: 14px;
      color: #94a3b8;
      margin-bottom: 20px;
    }

    .btn {
      display: inline-block;
      padding: 10px 16px;
      border: none;
      border-radius: 8px;
      background: #34d399;
      color: #000;
      font-weight: bold;
      text-decoration: none;
      cursor: pointer;
    }

    .btn:hover {
      background: #22c55e;
    }

    /* Tombol kembali ke halaman utama */
    .back-btn {
      position: fixed;
      top: 20px;
      left: 20px;
      background: #1e293b;
      color: #34d399;
      border: 2px solid #34d399;
      padding: 8px 14px;
      border-radius: 8px;
      font-weight: bold;
      text-decoration: none;
      transition: 0.3s;
    }

    .back-btn:hover {
      background: #34d399;
      color: #0f172a;
    }
  </style>
</head>
<body>

  <!-- Tombol Kembali -->
  <a href="{{ url('/') }}" class="back-btn">← Kembali</a>

  <div class="container">
    <h1>Halaman Dekripsi</h1>
    <p>Pilih salah satu metode dekripsi berikut untuk memulai:</p>

    <div class="cards">
      <div class="card">
        <h2>RC4</h2>
        <p>Dekripsi hasil enkripsi RC4 kembali ke teks asli.</p>
        <a href="{{ route('rc4.indexDecrypt') }}" class="btn">Gunakan</a>
      </div>

      <div class="card">
        <h2>AES</h2>
        <p>Dekripsi hasil enkripsi AES kembali ke teks asli.</p>
        <a href="{{ url('/dekripsi/aes') }}" class="btn">Gunakan</a>
      </div>

      <div class="card">
        <h2>Caesar Cipher</h2>
        <p>Dekripsi teks dengan metode Caesar sederhana.</p>
        <a href="{{ url('/dekripsi/caesar') }}" class="btn">Gunakan</a>
      </div>

      <div class="card">
        <h2>Vigenère Cipher</h2>
        <p>Dekripsi teks dengan kata kunci menggunakan metode Vigenère.</p>
        <a href="{{ url('/dekripsi/vigenere') }}" class="btn">Gunakan</a>
      </div>
    </div>
  </div>
</body>
</html>
