<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

$username = $_SESSION['username'];
$message = '';
$message_type = '';

// CREATE - Tambah Armada
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'tambah') {
    $nama_mobil = $koneksi->real_escape_string($_POST['nama_mobil']);
    $jenis = $koneksi->real_escape_string($_POST['jenis']);
    $kapasitas = (int)$_POST['kapasitas'];
    $harga_per_hari = (int)$_POST['harga_per_hari'];
    $deskripsi = $koneksi->real_escape_string($_POST['deskripsi']);

    $sql = "INSERT INTO armada (nama_mobil, jenis, kapasitas, harga_per_hari, deskripsi) 
            VALUES ('$nama_mobil', '$jenis', $kapasitas, $harga_per_hari, '$deskripsi')";

    if ($koneksi->query($sql) === TRUE) {
        $message = "Armada berhasil ditambahkan!";
        $message_type = "success";
    } else {
        $message = "Error: " . $koneksi->error;
        $message_type = "error";
    }
}

// UPDATE - Edit Armada
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id = (int)$_POST['id'];
    $nama_mobil = $koneksi->real_escape_string($_POST['nama_mobil']);
    $jenis = $koneksi->real_escape_string($_POST['jenis']);
    $kapasitas = (int)$_POST['kapasitas'];
    $harga_per_hari = (int)$_POST['harga_per_hari'];
    $deskripsi = $koneksi->real_escape_string($_POST['deskripsi']);
    $status = $koneksi->real_escape_string($_POST['status']);

    $sql = "UPDATE armada SET nama_mobil='$nama_mobil', jenis='$jenis', kapasitas=$kapasitas, 
            harga_per_hari=$harga_per_hari, deskripsi='$deskripsi', status='$status' WHERE id=$id";

    if ($koneksi->query($sql) === TRUE) {
        $message = "Armada berhasil diupdate!";
        $message_type = "success";
    } else {
        $message = "Error: " . $koneksi->error;
        $message_type = "error";
    }
}

// DELETE - Hapus Armada
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "DELETE FROM armada WHERE id=$id";

    if ($koneksi->query($sql) === TRUE) {
        $message = "Armada berhasil dihapus!";
        $message_type = "success";
    } else {
        $message = "Error: " . $koneksi->error;
        $message_type = "error";
    }
}

// READ - Ambil data armada
$result = $koneksi->query("SELECT * FROM armada ORDER BY created_at DESC");
$armada_list = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $armada_list[] = $row;
    }
}

// Get armada untuk edit
$edit_mode = false;
$edit_data = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $result = $koneksi->query("SELECT * FROM armada WHERE id=$id");
    if ($result->num_rows > 0) {
        $edit_data = $result->fetch_assoc();
        $edit_mode = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Travel Mobil</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .container { max-width: 1200px; margin: 0 auto; }
    .message { padding: 1rem; margin: 1rem 0; border-radius: 8px; }
    .message.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .message.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .form-group { margin: 1rem 0; }
    .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
    .form-group input, .form-group textarea, .form-group select { 
      width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; }
    .form-group textarea { min-height: 100px; font-family: Arial, sans-serif; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .btn { padding: 0.75rem 1.5rem; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
    .btn-primary { background: #099ff0; color: white; }
    .btn-primary:hover { background: #0080d0; }
    .btn-success { background: #28a745; color: white; }
    .btn-danger { background: #dc3545; color: white; }
    .btn-warning { background: #ffc107; color: black; }
    .btn-secondary { background: #6c757d; color: white; margin-right: 0.5rem; }
    .btn:hover { opacity: 0.9; }
    .table-container { overflow-x: auto; background: white; border-radius: 8px; padding: 1rem; margin-top: 2rem; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #f1f1f1; padding: 1rem; text-align: left; font-weight: bold; }
    td { padding: 1rem; border-bottom: 1px solid #ddd; }
    tr:hover { background: #f9f9f9; }
    .actions { display: flex; gap: 0.5rem; }
    .nav-header { background: #ADD8E6; color: white; padding: 1rem; display: flex; justify-content: space-between; align-items: center; }
    .nav-header a { color: white; text-decoration: none; font-weight: bold; }
    .nav-header a:hover { color: #ffd60a; }
    .form-card { background: white; padding: 2rem; border-radius: 8px; margin: 2rem 0; }
  </style>
</head>
<body>
  <div class="nav-header">
    <h1>Travel Mobil - Dashboard</h1>
    <div>
      <span style="margin-right: 1rem;">Selamat datang, <strong><?php echo htmlspecialchars($username); ?></strong></span>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="container">
    <?php if ($message): ?>
      <div class="message <?php echo $message_type; ?>"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Form Tambah/Edit Armada -->
    <div class="form-card">
      <h2><?php echo $edit_mode ? 'Edit Armada' : 'Tambah Armada Baru'; ?></h2>
      <form method="POST" action="">
        <input type="hidden" name="action" value="<?php echo $edit_mode ? 'edit' : 'tambah'; ?>">
        <?php if ($edit_mode): ?>
          <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
        <?php endif; ?>

        <div class="form-row">
          <div class="form-group">
            <label>Nama Mobil</label>
            <input type="text" name="nama_mobil" value="<?php echo $edit_mode ? htmlspecialchars($edit_data['nama_mobil']) : ''; ?>" required>
          </div>
          <div class="form-group">
            <label>Jenis Mobil</label>
            <input type="text" name="jenis" value="<?php echo $edit_mode ? htmlspecialchars($edit_data['jenis']) : ''; ?>" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Kapasitas (Penumpang)</label>
            <input type="number" name="kapasitas" value="<?php echo $edit_mode ? $edit_data['kapasitas'] : ''; ?>" required>
          </div>
          <div class="form-group">
            <label>Harga per Hari (Rp)</label>
            <input type="number" name="harga_per_hari" value="<?php echo $edit_mode ? $edit_data['harga_per_hari'] : ''; ?>" required>
          </div>
        </div>

        <div class="form-group">
          <label>Deskripsi</label>
          <textarea name="deskripsi" required><?php echo $edit_mode ? htmlspecialchars($edit_data['deskripsi']) : ''; ?></textarea>
        </div>

        <?php if ($edit_mode): ?>
          <div class="form-group">
            <label>Status</label>
            <select name="status" required>
              <option value="Tersedia" <?php echo $edit_data['status'] == 'Tersedia' ? 'selected' : ''; ?>>Tersedia</option>
              <option value="Tidak Tersedia" <?php echo $edit_data['status'] == 'Tidak Tersedia' ? 'selected' : ''; ?>>Tidak Tersedia</option>
            </select>
          </div>
        <?php endif; ?>

        <div>
          <button type="submit" class="btn btn-primary">
            <?php echo $edit_mode ? 'Update Armada' : 'Tambah Armada'; ?>
          </button>
          <?php if ($edit_mode): ?>
            <a href="dashboard.php" class="btn btn-secondary">Batal</a>
          <?php endif; ?>
        </div>
      </form>
    </div>

    <!-- Tabel Data Armada -->
    <div class="table-container">
      <h2>Daftar Armada</h2>
      <?php if (count($armada_list) > 0): ?>
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Mobil</th>
              <th>Jenis</th>
              <th>Kapasitas</th>
              <th>Harga/Hari</th>
              <th>Status</th>
              <th>Deskripsi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($armada_list as $index => $row): ?>
              <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo htmlspecialchars($row['nama_mobil']); ?></td>
                <td><?php echo htmlspecialchars($row['jenis']); ?></td>
                <td><?php echo $row['kapasitas']; ?> orang</td>
                <td>Rp <?php echo number_format($row['harga_per_hari'], 0, ',', '.'); ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo substr(htmlspecialchars($row['deskripsi']), 0, 50) . '...'; ?></td>
                <td class="actions">
                  <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-warning" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Edit</a>
                  <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?');" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Hapus</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p style="text-align: center; padding: 2rem;">Belum ada data armada. Silakan tambahkan armada baru.</p>
      <?php endif; ?>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>