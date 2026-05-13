<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Bootstrap Version</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card { border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .header-title { color: #0d6efd; font-weight: bold; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h2 class="text-center mb-4 header-title">Input Produk Baru</h2>
                
                <form id="productForm" action="proses.php" method="POST" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama" class="form-control" placeholder="Contoh: Laptop Asus">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Harga Produk (Rp)</label>
                        <input type="number" name="harga_produk" id="harga" class="form-control" placeholder="Contoh: 5000000">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Produk</label>
                        <textarea name="deskripsi_produk" id="deskripsi" class="form-control" rows="3" placeholder="Jelaskan spesifikasi produk..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Simpan Produk</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Simple JavaScript Validation -->
<script>
    document.getElementById('productForm').addEventListener('submit', function(event) {
        const nama = document.getElementById('nama').value;
        const harga = document.getElementById('harga').value;
        const deskripsi = document.getElementById('deskripsi').value;

        if (!nama || !harga || !deskripsi) {
            event.preventDefault(); // Menghentikan kirim form
            alert('Harap isi semua kolom sebelum mengirim!');
        }
    });
</script>

</body>
</html>