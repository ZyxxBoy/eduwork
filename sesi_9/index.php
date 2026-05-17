<?php
session_start();

require_once 'config/koneksi.php';

// Ambil filter kategori dari URL (GET)
$filter_kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';

// Query dengan filter kategori
if (!empty($filter_kategori)) {
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM produk WHERE kategori = ? ORDER BY id DESC");
    mysqli_stmt_bind_param($stmt, "s", $filter_kategori);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $result = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY id DESC");
}

// Ambil semua kategori unik
$result_kategori = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM produk ORDER BY kategori ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - Sesi 8</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/katalog.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">🛍️ EduShop</a>
        <div>
            <a href="keranjang.php" class="btn btn-outline-dark bg-white text-dark me-2 border-0 shadow-sm" style="border-radius:20px;">
                🛒 <span class="d-none d-sm-inline">Keranjang</span>
                <?php if (isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0): ?>
                    <span class="badge bg-danger rounded-pill"><?= array_sum($_SESSION['keranjang']) ?></span>
                <?php endif; ?>
            </a>
            <a href="admin/index.php" class="btn btn-add">Kelola Produk</a>
        </div>
    </div>
</nav>

<div class="container">

    <!-- Header -->
    <div class="page-header">
        <h1>Katalog Produk</h1>
        <p>Temukan produk yang Anda butuhkan</p>
    </div>

    <!-- Filter Kategori -->
    <div class="filter-section">
        <a href="index.php" class="filter-btn <?= empty($filter_kategori) ? 'active' : '' ?>">Semua</a>
        <?php while ($row_kat = mysqli_fetch_assoc($result_kategori)): ?>
            <a href="index.php?kategori=<?= urlencode($row_kat['kategori']) ?>"
               class="filter-btn <?= ($filter_kategori == $row_kat['kategori']) ? 'active' : '' ?>">
                <?= htmlspecialchars($row_kat['kategori']) ?>
            </a>
        <?php endwhile; ?>
    </div>

    <?php if (!empty($filter_kategori)): ?>
    <div class="text-center mb-4">
        <span class="text-muted" style="font-size:0.88rem;">
            Filter aktif: <strong><?= htmlspecialchars($filter_kategori) ?></strong>
            &nbsp;·&nbsp;
            <a href="index.php" class="text-decoration-none text-danger" style="font-size:0.85rem;">✕ Hapus</a>
        </span>
    </div>
    <?php endif; ?>

    <!-- Grid Produk -->
    <?php
    $ikon_kategori = [
        'Elektronik' => '💻',
        'Fashion'    => '👗',
        'Makanan'    => '🍱',
        'Olahraga'   => '⚽',
        'Lainnya'    => '📦',
    ];
    $warna_kategori = [
        'Elektronik' => 'bg-primary text-white',
        'Fashion'    => 'bg-danger text-white',
        'Makanan'    => 'bg-warning text-dark',
        'Olahraga'   => 'bg-success text-white',
        'Lainnya'    => 'bg-secondary text-white',
    ];

    $jumlah = 0;
    $produk_list = [];
    while ($produk = mysqli_fetch_assoc($result)) {
        $produk_list[] = $produk;
        $jumlah++;
    }
    ?>

    <div class="row g-3">
        <?php if ($jumlah === 0): ?>
        <div class="col-12">
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h5>Belum ada produk</h5>
                <p>Silakan tambahkan produk terlebih dahulu.</p>
                <a href="admin/index.php" class="btn btn-dark mt-2">+ Tambah Produk</a>
            </div>
        </div>
        <?php else: ?>
        <?php foreach ($produk_list as $produk):
            $ikon  = $ikon_kategori[$produk['kategori']] ?? '📦';
            $warna = $warna_kategori[$produk['kategori']] ?? 'bg-secondary text-white';
            $status = ($produk['harga_produk'] > 5000000) ? "Mewah" : "Standar";
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="product-card">
                <a href="detail.php?id=<?= $produk['id'] ?>" class="text-decoration-none text-dark position-relative d-block">
                    <?php if (isset($produk['jumlah']) && $produk['jumlah'] <= 0): ?>
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center" style="background: rgba(255,255,255,0.6); z-index: 10;">
                            <span class="badge bg-danger px-3 py-2 fs-6 shadow-sm">Stok Habis</span>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($produk['gambar'])): ?>
                        <img src="assets/img/<?= htmlspecialchars($produk['gambar']) ?>" class="card-img-top" alt="Gambar Produk" style="height: 180px; object-fit: cover; width: 100%;">
                    <?php else: ?>
                        <div class="card-img-top"><?= $ikon ?></div>
                    <?php endif; ?>
                </a>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="badge-kat <?= $warna ?>"><?= htmlspecialchars($produk['kategori']) ?></span>
                        <span class="badge-status ms-1"><?= $status ?></span>
                    </div>
                    <a href="detail.php?id=<?= $produk['id'] ?>" class="text-decoration-none text-dark">
                        <div class="product-name"><?= htmlspecialchars($produk['nama_produk']) ?></div>
                    </a>
                    <div class="product-price">Rp <?= number_format($produk['harga_produk'], 0, ',', '.') ?></div>
                    <!-- Deskripsi disembunyikan di katalog agar rapi, bisa dilihat di halaman detail -->
                </div>
                <div class="card-footer-custom">
                    <?php if (isset($produk['jumlah']) && $produk['jumlah'] <= 0): ?>
                        <button class="btn-beli d-block text-center w-100 border-0" style="background-color: #dee2e6; color: #6c757d; cursor: not-allowed;" disabled>Barang Kosong</button>
                    <?php else: ?>
                        <a href="detail.php?id=<?= $produk['id'] ?>" class="btn-beli text-decoration-none d-block text-center w-100">Lihat Detail</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Jumlah Produk -->
    <?php if ($jumlah > 0): ?>
    <div class="result-count"><?= $jumlah ?> produk ditemukan</div>
    <?php endif; ?>

</div>

<div style="height:50px;"></div>

<?php mysqli_close($koneksi); ?>
</body>
</html>
