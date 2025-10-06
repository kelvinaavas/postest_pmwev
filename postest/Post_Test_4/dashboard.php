<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Travel Mobil</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>Travel Mobil</h1>
    <p>Selamat datang, <strong><?php echo htmlspecialchars($username); ?></strong></p>
    <nav>
      <ul>
        <li><a href="#beranda">Beranda</a></li>
        <li><a href="#layanan">Tentang</a></li>
        <li><a href="#cara-pesan">Cara Pesan</a></li>
        <li><a href="#kontak">Kontak</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
    <button id="darkModeToggle" class="btn btn-primary">🌙 Dark Mode</button>
  </header>

  <main>
    <section id="beranda">
      <h2>Selamat datang di Trevel mobil kami</h2>
      <p>Solusi rental mobil harian, mingguan, dan bandara dengan supir atau lepas kunci.</p>
      <p><a href="#kontak" class="btn btn-primary">Pesan Sekarang</a></p>
    </section>

    <section id="layanan">
      <h3>Layanan Kami</h3>
      <h4>Sewa Harian</h4>
      <p>Sewa mobil untuk kebutuhan harian dengan pilihan armada lengkap.</p>

      <h4>Antar-Jemput Bandara</h4>
      <p>Layanan antar jemput tepat waktu menuju dan dari bandara.</p>

      <h4>Rental Jangka Panjang</h4>
      <p>Paket sewa mingguan atau bulanan untuk kebutuhan dinas dan perjalanan.</p>

      <h3>Armada Kami</h3>
      <ul>
        <li><strong>Toyota Avanza</strong><br><em>7-seater, cocok untuk keluarga.</em></li>
        <li><strong>Honda Brio</strong><br><em>Hemat bahan bakar, cocok untuk kota.</em></li>
        <li><strong>Suzuki Ertiga</strong><br><em>Nyaman untuk perjalanan jauh.</em></li>
      </ul>
    </section>

    <section id="cara-pesan">
      <h3>Cara Pesan</h3>
      <ol>
        <li>Hubungi kontak yang sudah tersedia</li>
        <li>Tanya ketersediaan mobil</li>
        <li>Lakukan pemesanan via chat</li>
        <li>Pesanan diterima</li>
      </ol>
    </section>

    <section id="kontak">
      <h3>Informasi Kontak</h3>
      <p>0888888888888</p>
    </section>
  </main>
  <script src="script.js"></script>
</body>
</html>
