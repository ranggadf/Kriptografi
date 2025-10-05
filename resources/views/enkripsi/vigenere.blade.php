<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kriptografi - Vigenère</title>
  <style>
    body {
      background: #0f172a;
      font-family: Arial, sans-serif;
      color: #e6eef8;
      display: flex;
      justify-content: center;
      padding: 40px;
    }

    .card {
      background: #0b1220;
      padding: 30px;
      border-radius: 12px;
      width: 500px;
    }

    h1 {
      text-align: center;
      color: #34d399;
      margin-bottom: 20px;
    }

    label {
      font-weight: bold;
      margin-top: 10px;
      display: block;
    }

    textarea, input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 8px;
      border: none;
      background: #1e293b;
      color: #e6eef8;
    }

    input[readonly], textarea[readonly] {
      background: #334155;
      color: #94a3b8;
    }

    button {
      margin-top: 15px;
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background: #34d399;
      color: #000;
      font-weight: bold;
      cursor: pointer;
    }

    .btn-copy {
      margin-top: 8px;
      background: #22c55e;
      font-size: 14px;
      padding: 6px 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .btn-copy:hover { background: #16a34a; }
    .btn-next { margin-top: 12px; background: #3b82f6; }

    .note {
      margin-top: 10px;
      font-size: 14px;
      color: #94a3b8;
      text-align: center;
    }

    .hidden { display: none; }

    /* Tombol navigasi pojok kiri atas */
    .top-buttons {
      position: fixed;
      top: 20px;
      left: 20px;
      display: flex;
      gap: 10px;
    }

    .nav-btn {
      background: #1e293b;
      color: #34d399;
      border: 2px solid #34d399;
      padding: 8px 14px;
      border-radius: 8px;
      font-weight: bold;
      text-decoration: none;
      transition: 0.3s;
    }

    .nav-btn:hover {
      background: #34d399;
      color: #0f172a;
    }
  </style>
</head>
<body>
  <!-- Tombol Navigasi -->
  <div class="top-buttons">
    <a href="{{ url('/enkripsi') }}" class="nav-btn">← Enkripsi</a>
    <a href="{{ url('/dekripsi/vigenere') }}" class="nav-btn">Dekripsi Vigenère</a>
  </div>

  <div class="card">
    <h1>KRIPTOGRAFI - VIGENÈRE</h1>

    <label for="plaintext">PLAINTEXT</label>
    <textarea id="plaintext" rows="3"></textarea>

    <label for="key">KEY</label>
    <input type="text" id="key">

    <button id="encryptBtn">Encrypt</button>

    <div id="resultBox" class="hidden">
      <label for="autoKey">KEY OTOMATIS</label>
      <input type="text" id="autoKey" readonly>

      <label for="ciphertext">HASIL ENKRIPSI</label>
      <textarea id="ciphertext" rows="3" readonly></textarea>
      <button id="copyBtn" class="btn-copy">Copy to Clipboard</button>

      <!-- Tombol lanjut ke Caesar Cipher -->
      <button id="nextBtn" class="btn-next">Lanjut ke Caesar Cipher</button>

      <!-- Penjelasan -->
      <p class="note">
        Anda telah menyelesaikan tahap pertama enkripsi dengan metode <strong>Vigenère Cipher</strong>.<br>
        Selanjutnya, teks terenkripsi ini akan diproses kembali menggunakan metode <strong>Caesar Cipher</strong> sebagai tahap kedua enkripsi berantai.
      </p>
      <p class="note">
        ⚡ Catatan: Copy Hasil Enkripsi untuk dijadikan Plaintext di tahap selanjutnya.
      </p>
    </div>
  </div>

  <script>
    const plaintextEl = document.getElementById("plaintext");
    const keyEl = document.getElementById("key");
    const autoKeyEl = document.getElementById("autoKey");
    const ciphertextEl = document.getElementById("ciphertext");
    const encryptBtn = document.getElementById("encryptBtn");
    const resultBox = document.getElementById("resultBox");
    const copyBtn = document.getElementById("copyBtn");
    const nextBtn = document.getElementById("nextBtn");

    function generateAutoKey(plaintext, key) {
      if (!plaintext || !key) return "";
      let autoK = key;
      let i = 0;
      while (autoK.length < plaintext.length) {
        autoK += plaintext[i];
        i++;
      }
      return autoK;
    }

    function vigenereEncrypt(plaintext, key) {
      let result = "";
      let j = 0;

      for (let i = 0; i < plaintext.length; i++) {
        const p = plaintext[i];

        if (/[A-Z]/i.test(p)) {
          const pCode = p.toUpperCase().charCodeAt(0) - 65;
          const kCode = key[j].toUpperCase().charCodeAt(0) - 65;
          const c = String.fromCharCode(((pCode + kCode) % 26) + 65);
          result += c;
          j++;
        } else {
          result += p;
        }
      }

      return result;
    }

    encryptBtn.addEventListener("click", () => {
      const plaintext = plaintextEl.value;
      const key = keyEl.value;

      if (plaintext && key) {
        const autoKey = generateAutoKey(plaintext, key);
        const ciphertext = vigenereEncrypt(plaintext, autoKey);

        autoKeyEl.value = autoKey;
        ciphertextEl.value = ciphertext;

        resultBox.classList.remove("hidden");
      } else {
        alert("Isi plaintext dan key terlebih dahulu!");
      }
    });

    copyBtn.addEventListener("click", () => {
      navigator.clipboard.writeText(ciphertextEl.value).then(() => {
        copyBtn.textContent = "Copied!";
        setTimeout(() => copyBtn.textContent = "Copy to Clipboard", 2000);
      });
    });

    nextBtn.addEventListener("click", () => {
      window.location.href = "/caesar";
    });
  </script>
</body>
</html>
