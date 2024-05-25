<?php
session_start();

// Inisialisasi array untuk menyimpan data barang
if (!isset($_SESSION['items'])) {
  $_SESSION['items'] = array();
}

// Fungsi untuk menambah data barang
function tambahBarang($nama, $harga, $jumlah) {
  $_SESSION['items'][] = array(
    'nama' => $nama,
    'harga' => $harga,
    'jumlah' => $jumlah,
    'total' => $harga * $jumlah
  );
}

// Fungsi untuk menghapus data barang berdasarkan indeks
function hapusBarang($index) {
  if (isset($_SESSION['items'][$index])) {
    unset($_SESSION['items'][$index]);
  }
}

// Fungsi untuk menghitung total harga dari barang-barang
function hitung() {
  $total = 0;
  foreach ($_SESSION['items'] as $item) {
    $total += $item['total'];
  }
  return $total;
}

// Menambahkan data barang baru jika tombol submit ditekan
if (isset($_POST['submit']) && isset($_POST['nama']) && isset($_POST['jumlah']) && isset($_POST['harga'])) {
  $nama = $_POST['nama'];
  $jumlah = (int)$_POST['jumlah'];
  $harga = (int)$_POST['harga'];
  tambahBarang($nama, $harga, $jumlah);
}

// Menghapus data barang berdasarkan indeks
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
  $index = (int)$_GET['hapus'];
  hapusBarang($index);
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kasir</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      width: 80%;
      background-color: white;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    form {
      margin-bottom: 20px;
    }
    input[type="text"], input[type="number"] {
      padding: 8px;
      margin: 5px 0;
    }
    button {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
    }
    button:hover {
      background-color: #45a049;
    }
    a {
      color: #d32f2f;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Kasir Toko</h1>
    <form method="POST">
      <label for="nama">Nama Barang:</label>
      <input type="text" id="nama" name="nama" required><br>
      <label for="harga">Harga:</label>
      <input type="number" id="harga" name="harga" required><br>
      <label for="jumlah">Jumlah:</label>
      <input type="number" id="jumlah" name="jumlah" required><br>
      <button type="submit" name="submit">Tambah Barang</button>
    </form>
    <h2>Daftar Barang</h2>
    <table>
      <tr>
        <th>Nama</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Total</th>
        <th>Aksi</th>
      </tr>
      <?php foreach ($_SESSION['items'] as $index => $item): ?>
      <tr>
        <td><?= htmlspecialchars($item['nama']) ?></td>
        <td><?= htmlspecialchars($item['harga']) ?></td>
        <td><?= htmlspecialchars($item['jumlah']) ?></td>
        <td><?= htmlspecialchars($item['total']) ?></td>
        <td><a href="?hapus=<?= $index ?>">Hapus</a></td>
      </tr>
      <?php endforeach; ?>
    </table>
    <h3>Total Harga: Rp<?= hitung() ?></h3>
  </div>
</body>
</html>
