<?php
session_start();
require_once 'config/koneksi.php';

if (!isset($_SESSION['last_order_id'])) {
    header("Location: index.php");
    exit;
}

$order_id = (int)$_SESSION['last_order_id'];

// Ambil data order
$query_order = "SELECT * FROM orders WHERE id = ?";
$stmt_order = mysqli_prepare($koneksi, $query_order);
mysqli_stmt_bind_param($stmt_order, "i", $order_id);
mysqli_stmt_execute($stmt_order);
$result_order = mysqli_stmt_get_result($stmt_order);
$order = mysqli_fetch_assoc($result_order);

if (!$order) {
    header("Location: index.php");
    exit;
}
mysqli_stmt_close($stmt_order);

// Ambil item pesanan
$query_items = "SELECT oi.*, p.nama_produk FROM order_items oi JOIN produk p ON oi.produk_id = p.id WHERE oi.order_id = ?";
$stmt_items = mysqli_prepare($koneksi, $query_items);
mysqli_stmt_bind_param($stmt_items, "i", $order_id);
mysqli_stmt_execute($stmt_items);
$result_items = mysqli_stmt_get_result($stmt_items);
$items = [];
$items_text = "";
while ($row = mysqli_fetch_assoc($result_items)) {
    $items[] = $row;
    $items_text .= "- " . $row['nama_produk'] . " (" . $row['kuantitas'] . "x) = Rp" . number_format($row['kuantitas'] * $row['harga_satuan'], 0, ',', '.') . "%0A";
}
mysqli_stmt_close($stmt_items);
mysqli_close($koneksi);

// Siapkan pesan WA
$no_admin = "6281234567890"; // Ganti dengan nomor asli Admin Anda
$pesan_wa = "Halo Admin EduShop,%0A%0A" .
            "Saya ingin konfirmasi pembayaran untuk pesanan saya:%0A" .
            "*Order ID:* #" . str_pad($order['id'], 5, '0', STR_PAD_LEFT) . "%0A" .
            "*Nama:* " . $order['nama_pelanggan'] . "%0A" .
            "*Metode Pembayaran:* " . $order['metode_pembayaran'] . "%0A%0A" .
            "*Rincian Pesanan:*%0A" . $items_text . "%0A" .
            "*Total Tagihan:* *Rp" . number_format($order['total_harga'], 0, ',', '.') . "*%0A%0A" .
            "Mohon info selanjutnya untuk proses pembayaran. Terima kasih.";
            
$url_wa = "https://wa.me/" . $no_admin . "?text=" . $pesan_wa;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pesanan - EduShop</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .invoice-box {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border: 1px solid #eaeaea;
        }
        .invoice-header {
            border-bottom: 2px dashed #ddd;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
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
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <h1 style="font-size: 4.5rem; color: #198754;">✅</h1>
                <h2 class="fw-bold mt-2">Pesanan Berhasil!</h2>
                <p class="text-muted">Terima kasih telah berbelanja di EduShop.<br>Berikut adalah invoice detail pesanan Anda.</p>
            </div>
            
            <div class="invoice-box">
                <div class="d-flex justify-content-between invoice-header">
                    <div>
                        <h3 class="fw-bold mb-1 text-primary">INVOICE</h3>
                        <span class="text-muted fs-5">Order #<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></span>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-warning text-dark px-3 py-2 fs-6 mb-2"><?= htmlspecialchars($order['status']) ?></span><br>
                        <small class="text-muted fw-bold"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></small>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h6 class="text-muted text-uppercase fw-bold mb-2" style="font-size:0.8rem;">Ditagihkan Kepada:</h6>
                        <div class="fw-bold fs-5 mb-1"><?= htmlspecialchars($order['nama_pelanggan']) ?></div>
                        <div class="mb-2"><span class="badge bg-light text-dark border">📞 <?= htmlspecialchars($order['no_hp']) ?></span></div>
                        <div class="text-muted"><?= nl2br(htmlspecialchars($order['alamat'])) ?></div>
                    </div>
                    <div class="col-sm-6 text-sm-end mt-4 mt-sm-0">
                        <h6 class="text-muted text-uppercase fw-bold mb-2" style="font-size:0.8rem;">Metode Pembayaran:</h6>
                        <div class="fw-bold fs-6 p-2 bg-light d-inline-block border rounded">
                            💳 <?= htmlspecialchars($order['metode_pembayaran']) ?>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive mb-4">
                    <table class="table mb-0">
                        <thead class="table-light border-top border-bottom">
                            <tr>
                                <th class="py-3">Produk</th>
                                <th class="text-center py-3">Harga</th>
                                <th class="text-center py-3">Qty</th>
                                <th class="text-end py-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                            <tr>
                                <td class="py-3 fw-bold"><?= htmlspecialchars($item['nama_produk']) ?></td>
                                <td class="text-center py-3 text-muted">Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                                <td class="text-center py-3"><?= $item['kuantitas'] ?></td>
                                <td class="text-end py-3 fw-bold">Rp <?= number_format($item['kuantitas'] * $item['harga_satuan'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="border-top">
                                <td colspan="3" class="text-end py-3 fw-bold fs-6">Total Tagihan:</td>
                                <td class="text-end py-3 fw-bold fs-4 text-primary">Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="alert alert-info text-center mb-4">
                    Silakan klik tombol di bawah ini untuk mengonfirmasi pesanan Anda kepada Admin kami melalui WhatsApp.
                </div>

                <div class="d-grid gap-3 mt-2">
                    <a href="<?= $url_wa ?>" target="_blank" class="btn btn-success btn-lg fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2 py-3">
                        <span style="font-size: 1.5rem;">💬</span> Konfirmasi Pembayaran via WhatsApp
                    </a>
                    <a href="index.php" class="btn btn-outline-secondary fw-bold py-2">Kembali ke Katalog Utama</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
