<?php
session_start();
require_once 'koneksi.php';

$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];

if (empty($keranjang)) {
    header("Location: keranjang.php");
    exit;
}

$total_belanja = 0;
// Hitung total belanja cepat
$ids = array_keys($keranjang);
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$query = "SELECT id, harga_produk FROM produk WHERE id IN ($placeholders)";
$stmt = mysqli_prepare($koneksi, $query);
$types = str_repeat('i', count($ids));
mysqli_stmt_bind_param($stmt, $types, ...$ids);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($result)) {
    $total_belanja += $row['harga_produk'] * $keranjang[$row['id']];
}
mysqli_stmt_close($stmt);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - EduShop</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="index.php">🛍️ EduShop</a>
    </div>
</nav>

<div class="container mt-5 mb-5">
    <h2 class="fw-bold mb-4">Proses Checkout</h2>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Informasi Pengiriman</h5>
                    <form action="proses_checkout.php" method="POST" id="checkoutForm">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required placeholder="Contoh: Budi Santoso">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor WhatsApp</label>
                            <input type="text" name="nohp" class="form-control" required placeholder="Contoh: 08123456789">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" required placeholder="Jalan, RT/RW, Kecamatan, Kota, Provinsi, Kode Pos"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Metode Pembayaran</label>
                            <select name="pembayaran" class="form-select" required>
                                <option value="Transfer Bank BCA">Transfer Bank BCA</option>
                                <option value="Transfer Bank Mandiri">Transfer Bank Mandiri</option>
                                <option value="E-Wallet (OVO/GoPay/Dana)">E-Wallet (OVO/GoPay/Dana)</option>
                                <option value="COD (Bayar di Tempat)">COD (Bayar di Tempat)</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Ringkasan Pembayaran</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Tagihan</span>
                        <span class="fw-bold fs-5 text-primary">Rp <?= number_format($total_belanja, 0, ',', '.') ?></span>
                    </div>
                    <p class="text-muted small">Pastikan alamat dan rincian pesanan Anda sudah benar sebelum melakukan pembayaran.</p>
                    <button type="submit" form="checkoutForm" class="btn btn-success w-100 btn-lg">Selesaikan Pesanan</button>
                    <a href="keranjang.php" class="btn btn-outline-secondary w-100 mt-2">Kembali ke Keranjang</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
