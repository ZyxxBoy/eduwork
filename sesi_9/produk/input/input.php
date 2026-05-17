<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Sesi 8</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/index.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h2 class="text-center mb-4 header-title">Input Produk Baru</h2>

                <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
                    <div class="alert alert-success">Produk berhasil ditambahkan ke database!</div>
                <?php endif; ?>

                <form id="productForm" action="../../proses.php" method="POST" enctype="multipart/form-data" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama" class="form-control" placeholder="Contoh: Laptop Asus">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga Produk (Rp)</label>
                        <input type="number" name="harga_produk" id="harga" class="form-control" placeholder="Contoh: 5000000">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stok / Jumlah (Pcs)</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Contoh: 50" min="0" value="0">
                    </div>

                    <!-- Field Kategori (Sesi 8) -->
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" id="kategori" class="form-select">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Olahraga">Olahraga</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Produk</label>
                        <textarea name="deskripsi_produk" id="deskripsi" class="form-control" rows="3" placeholder="Jelaskan spesifikasi produk..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar Produk</label>
                        <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan Produk</button>
                </form>

                <div class="mt-3 text-center">
                    <a href="../../index.php" class="btn btn-outline-success btn-sm">🛒 Lihat Katalog Produk</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Simple JavaScript Validation -->
<script>
    document.getElementById('productForm').addEventListener('submit', function(event) {
        const nama = document.getElementById('nama').value;
        const harga = document.getElementById('harga').value;
        const kategori = document.getElementById('kategori').value;
        const deskripsi = document.getElementById('deskripsi').value;
        const gambar = document.getElementById('gambar').value;
        const jumlah = document.getElementById('jumlah').value;

        if (!nama || !harga || !kategori || !deskripsi || !gambar || jumlah === '') {
            event.preventDefault();
            alert('Harap isi semua kolom termasuk stok dan gambar sebelum mengirim!');
        }
    });
</script>

</body>
</html>