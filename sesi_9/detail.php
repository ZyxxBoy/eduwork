<?php
session_start();
require_once 'config/koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];
$query = "SELECT * FROM produk WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$produk = mysqli_fetch_assoc($result);

if (!$produk) {
    echo '<!DOCTYPE html><html lang="id"><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
          <body class="bg-light"><div class="container mt-5"><div class="alert alert-danger">Produk tidak ditemukan!</div>
          <a href="index.php" class="btn btn-secondary">Kembali ke Katalog</a></div></body></html>';
    exit;
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);

$ikon_kategori = [
    'Elektronik' => '💻',
    'Fashion'    => '👗',
    'Makanan'    => '🍱',
    'Olahraga'   => '⚽',
    'Lainnya'    => '📦',
];
$ikon  = $ikon_kategori[$produk['kategori']] ?? '📦';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - <?= htmlspecialchars($produk['nama_produk']) ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .detail-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.08);
        }
        .detail-image-wrapper {
            background-color: #f8f9fa;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 7rem;
        }
        .detail-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background-color: #f8f9fa;
            max-height: 500px;
        }
        .detail-info {
            padding: 40px;
        }
        .detail-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: #2c3e50;
        }
        .detail-price {
            font-size: 1.8rem;
            font-weight: 700;
            color: #e74c3c;
            margin-bottom: 25px;
        }
        .detail-description {
            font-size: 1.05rem;
            color: #555;
            line-height: 1.6;
            margin-bottom: 30px;
            white-space: pre-line;
        }
        .action-buttons {
            display: flex;
            gap: 15px;
        }
        .btn-beli {
            background-color: #0d6efd;
            color: #fff;
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn-beli:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
            color: #fff;
        }
        .btn-keranjang {
            border: 2px solid #198754;
            color: #198754;
            font-weight: bold;
            background: transparent;
            transition: all 0.3s;
        }
        .btn-keranjang:hover {
            background-color: #198754;
            color: #fff;
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand fw-bold text-primary mb-0" href="index.php">🛍️ EduShop</a>
        <div>
            <a href="keranjang.php" class="btn btn-outline-dark bg-light text-dark border-0 shadow-sm" style="border-radius:20px;">
                🛒 <span class="d-none d-sm-inline">Keranjang</span>
                <?php if (isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0): ?>
                    <span class="badge bg-danger rounded-pill"><?= array_sum($_SESSION['keranjang']) ?></span>
                <?php endif; ?>
            </a>
        </div>
    </div>
</nav>

<div class="container mt-5 mb-5">
    <div class="mb-4">
        <a href="index.php" class="text-decoration-none text-secondary fw-bold">🔙 Kembali ke Katalog</a>
    </div>

    <div class="detail-card">
        <div class="row g-0">
            <!-- Bagian Gambar -->
            <div class="col-md-5 border-end">
                <?php if (!empty($produk['gambar'])): ?>
                    <img src="assets/img/<?= htmlspecialchars($produk['gambar']) ?>" class="detail-image" alt="Gambar Produk">
                <?php else: ?>
                    <div class="detail-image-wrapper"><?= $ikon ?></div>
                <?php endif; ?>
            </div>
            
            <!-- Bagian Info -->
            <div class="col-md-7">
                <div class="detail-info">
                    <div class="mb-2">
                        <span class="badge bg-secondary px-3 py-2"><?= htmlspecialchars($produk['kategori']) ?></span>
                        <?php if ($produk['harga_produk'] > 5000000): ?>
                            <span class="badge bg-warning text-dark px-3 py-2 ms-1">Produk Mewah</span>
                        <?php endif; ?>
                        
                        <?php $stok = isset($produk['jumlah']) ? (int)$produk['jumlah'] : 0; ?>
                        <?php if ($stok <= 0): ?>
                            <span class="badge bg-danger px-3 py-2 ms-1">Stok Habis</span>
                        <?php else: ?>
                            <span class="badge bg-info text-dark px-3 py-2 ms-1">Stok: <?= $stok ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <h1 class="detail-title"><?= htmlspecialchars($produk['nama_produk']) ?></h1>
                    
                    <div class="detail-price">
                        Rp <?= number_format($produk['harga_produk'], 0, ',', '.') ?>
                    </div>
                    
                    <div class="detail-description">
                        <h5 class="fw-bold mb-3 border-bottom pb-2">Deskripsi Produk</h5>
                        <?= htmlspecialchars($produk['deskripsi_produk']) ?>
                    </div>
                    
                    <?php if ($stok <= 0): ?>
                        <div class="alert alert-danger mt-4 pt-3 text-center fw-bold">
                            ⚠️ Maaf, Stok Produk Habis
                        </div>
                    <?php else: ?>
                        <form action="actions/proses_keranjang.php" method="POST" class="action-buttons mt-4 pt-3 border-top w-100">
                            <input type="hidden" name="id" value="<?= $produk['id'] ?>">
                            <input type="hidden" name="action" id="actionType" value="keranjang">
                            
                            <button type="submit" class="btn btn-beli btn-lg flex-grow-1 shadow-sm" onclick="document.getElementById('actionType').value='beli'">
                                🛒 Beli Sekarang
                            </button>
                            <button type="submit" class="btn btn-keranjang btn-lg flex-grow-1 shadow-sm" onclick="document.getElementById('actionType').value='keranjang'">
                                ➕ Keranjang
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
