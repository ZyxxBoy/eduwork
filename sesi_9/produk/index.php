<?php
// Pastikan file koneksi ada di satu tingkat folder sebelumnya
require_once '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 40px;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'edit_sukses'): ?>
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Berhasil!</strong> Data produk berhasil diperbarui.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($_GET['status'] == 'hapus_sukses'): ?>
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Berhasil!</strong> Produk berhasil dihapus dari database.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($_GET['status'] == 'hapus_gagal'): ?>
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>Gagal!</strong> Terjadi kesalahan saat menghapus produk.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Daftar Produk</h4>
            <div>
                <a href="../index.php" class="btn btn-secondary btn-sm fw-bold me-2">🔙 Katalog</a>
                <a href="input/input.php" class="btn btn-light btn-sm fw-bold">+ Tambah Produk</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabelProduk" class="table table-striped table-bordered table-hover" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center">Gambar</th>
                            <th>Nama Produk</th>
                            <th>Stok</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Ambil data produk
                        $query = "SELECT * FROM produk ORDER BY id DESC";
                        $result = mysqli_query($koneksi, $query);
                        
                        if ($result) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($row['gambar'])): ?>
                                            <img src="../img/<?= htmlspecialchars($row['gambar']) ?>" alt="Gambar" width="50" height="50" style="object-fit:cover; border-radius:4px;">
                                        <?php else: ?>
                                            <span class="badge bg-secondary">No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                                    <td><?= isset($row['jumlah']) ? $row['jumlah'] : 0 ?></td>
                                    <td>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($row['kategori']) ?></span>
                                    </td>
                                    <td>Rp <?= number_format($row['harga_produk'], 0, ',', '.') ?></td>
                                    <td><?= htmlspecialchars($row['deskripsi_produk']) ?></td>
                                    <td class="text-center">
                                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm mb-1">✏️ Edit</a>
                                        <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">🗑️ Hapus</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>Gagal mengambil data dari database.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- jQuery (wajib untuk DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Inisialisasi DataTables -->
<script>
    $(document).ready(function() {
        $('#tabelProduk').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });
    });
</script>

</body>
</html>
