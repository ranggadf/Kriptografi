<?php
// welcome.php
// Halaman Welcome untuk web Enkripsi & Dekripsi
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Selamat Datang — Web Enkripsi & Dekripsi KELOMPOK 3</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    :root{--bg1:#0f172a;--bg2:#0ea5a9;--card:#0b1220;--glass: rgba(255,255,255,0.06);--accent:#34d399}
    *{box-sizing:border-box}
    body{font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,'Helvetica Neue',Arial; margin:0;
         background:linear-gradient(135deg,var(--bg1) 0%, #062743 50%);
         color:#e6eef8; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:32px}
    .container{width:100%; max-width:980px}
    .hero{display:grid; grid-template-columns:1fr; gap:28px; align-items:center; text-align:center}
    .brand{background:linear-gradient(90deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01));
           padding:40px; border-radius:16px}
    h1{margin:0 0 12px 0; font-size:32px}
    p.lead{margin:0 0 18px 0; color:rgba(230,238,248,0.85); font-size:18px}
    .cta{display:flex; gap:12px; justify-content:center; margin-top:20px; flex-wrap:wrap}
    .btn{background:var(--accent); color:#022; padding:12px 20px; border-radius:10px; font-weight:600;
         border:none; cursor:pointer; box-shadow:0 6px 18px rgba(52,211,153,0.12); text-decoration:none;}
    .btn.secondary{background:transparent; border:1px solid rgba(255,255,255,0.08); color:inherit}
    footer{margin-top:28px; text-align:center; color:rgba(230,238,248,0.6); font-size:13px}
  </style>
</head>
<body>
  <div class="container">
    <div class="hero">
      <div class="brand">
        <h1>Selamat Datang di Web Enkripsi & Dekripsi</h1>
        <p class="lead">
          Urutan Enkripsi yang digunakan pada aplikasi ini adalah:<br>
          <strong>Vigenère Cipher → Caesar Cipher → AES → RC4</strong>
        </p>

        <div class="cta">
          <a href="enkripsi" class="btn">Enkripsi</a>
          <a href="dekripsi" class="btn secondary">Dekripsi</a>
        </div>
      </div>
    </div>
    <footer>© <?= date('Y') ?>  KELOMPOK 3<br> RANGGA<br>AJENG<br>VAVA<br>AMRO</footer>
  </div>
</body>
</html>
