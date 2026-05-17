<?php
session_start();
require_once 'config/koneksi.php';

$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
$produk_list = [];
$total_belanja = 0;

if (!empty($keranjang)) {
    // Buat placeholder untuk query IN (?, ?, ?)
    $ids = array_keys($keranjang);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    
    $query = "SELECT * FROM produk WHERE id IN ($placeholders)";
    $stmt = mysqli_prepare($koneksi, $query);
    
    // Bind parameter dinamis
    $types = str_repeat('i', count($ids));
    mysqli_stmt_bind_param($stmt, $types, ...$ids);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $kuantitas = $keranjang[$id];
        $subtotal = $row['harga_produk'] * $kuantitas;
        $total_belanja += $subtotal;
        
        $row['kuantitas'] = $kuantitas;
        $row['subtotal'] = $subtotal;
        $produk_list[] = $row;
    }
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - EduShop</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cart-img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; }
    </style>
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="index.php">🛍️ EduShop</a>
    </div>
</nav>

<div class="container mt-5 mb-5">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h2 class="fw-bold">Keranjang Belanja</h2>
        <a href="index.php" class="btn btn-outline-secondary">Lanjut Belanja</a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    <?php if (empty($produk_list)): ?>
                        <div class="p-5 text-center">
                            <h1 style="font-size: 4rem;">🛒</h1>
                            <h4 class="mt-3">Keranjang Anda masih kosong</h4>
                            <p class="text-muted">Yuk, cari produk impianmu sekarang!</p>
                            <a href="index.php" class="btn btn-primary mt-2">Mulai Belanja</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Produk</th>
                                        <th>Harga</th>
                                        <th class="text-center">Kuantitas</th>
                                        <th>Subtotal</th>
                                        <th class="text-center pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produk_list as $item): ?>
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($item['gambar'])): ?>
                                                    <img src="assets/img/<?= htmlspecialchars($item['gambar']) ?>" class="cart-img me-3" alt="Produk">
                                                <?php else: ?>
                                                    <div class="cart-img me-3 bg-secondary d-flex justify-content-center align-items-center text-white fs-2">📦</div>
                                                <?php endif; ?>
                                                <div>
                                                    <h6 class="mb-1 fw-bold"><?= htmlspecialchars($item['nama_produk']) ?></h6>
                                                    <small class="text-muted"><?= htmlspecialchars($item['kategori']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp <?= number_format($item['harga_produk'], 0, ',', '.') ?></td>
                                        <td class="text-center fw-bold"><?= $item['kuantitas'] ?></td>
                                        <td class="fw-bold text-primary">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                        <td class="text-center pe-4">
                                            <a href="actions/proses_keranjang.php?hapus=<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus item ini dari keranjang?')">Hapus</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Harga (<?= count($keranjang) ?> Barang)</span>
                        <span class="fw-bold">Rp <?= number_format($total_belanja, 0, ',', '.') ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total Tagihan</span>
                        <span class="fw-bold fs-5 text-primary">Rp <?= number_format($total_belanja, 0, ',', '.') ?></span>
                    </div>
                    <a href="checkout.php" class="btn btn-primary w-100 btn-lg <?= empty($produk_list) ? 'disabled' : '' ?>">Beli Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
