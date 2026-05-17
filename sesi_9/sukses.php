<?php
session_start();

$nama = isset($_SESSION['last_order']['nama']) ? $_SESSION['last_order']['nama'] : 'Kak';
$pembayaran = isset($_SESSION['last_order']['pembayaran']) ? $_SESSION['last_order']['pembayaran'] : '';

// Ganti dengan nomor WhatsApp Admin Anda (gunakan format 62...)
$no_admin = "6281234567890"; 
$pesan_wa = "Halo Admin EduShop, saya " . $nama . ". Saya baru saja membuat pesanan dengan metode pembayaran " . $pembayaran . ". Saya ingin melakukan konfirmasi pesanan saya.";
$url_wa = "https://wa.me/" . $no_admin . "?text=" . urlencode($pesan_wa);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - EduShop</title>
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

<div class="container mt-5 mb-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-5">
                <div class="mb-4">
                    <h1 style="font-size: 5rem; color: #198754;">✅</h1>
                </div>
                <h2 class="fw-bold mb-3">Pesanan Berhasil!</h2>
                <p class="text-muted mb-4">Terima kasih telah berbelanja di EduShop. Pesanan Anda sedang kami proses. Silakan lakukan konfirmasi pembayaran agar pesanan dapat segera dikirim.</p>
                <div class="d-grid gap-3">
                    <a href="<?= $url_wa ?>" target="_blank" class="btn btn-success btn-lg fw-bold">
                        💬 Konfirmasi via WhatsApp
                    </a>
                    <a href="index.php" class="btn btn-outline-primary btn-lg">Kembali Belanja</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
