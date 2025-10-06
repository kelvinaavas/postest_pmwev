<?php

session_start();

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel Mobil - Beranda</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>Selamat datang di Travel Mobil Kami</h1>
    <p>Solusi rental mobil harian, mingguan, dan bandara dengan sopir atau lepas kunci.</p>
    <a href="login.php" class="btn">Masuk Sekarang</a>
  </header>

  <section>
    <h2>Layanan Kami</h2>
    <ul>
      <li>Sewa Harian</li>
      <li>Antar Jemput Bandara</li>
      <li>Rental Jangka Panjang</li>
    </ul>
  </section>

  <footer>
    <p>&copy; 2025 Travel Mobil. Semua Hak Dilindungi.</p>
  </footer>

  <script src="script.js"></script>
</body>
</html>
