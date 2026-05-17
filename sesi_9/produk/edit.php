<?php
require_once '../koneksi.php';

// Proses update data jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id        = (int)$_POST['id'];
    $nama      = trim($_POST['nama_produk']);
    $harga     = (int)$_POST['harga_produk'];
    $jumlah    = (int)$_POST['jumlah'];
    $kategori  = trim($_POST['kategori']);
    $deskripsi = trim($_POST['deskripsi_produk']);

    if (empty($nama) || empty($harga) || empty($kategori) || empty($deskripsi)) {
        $error = "Data tidak boleh ada yang kosong!";
    } else {
        $query_tambahan = "";
        $params = [$nama, $harga, $jumlah, $kategori, $deskripsi];
        $types = "siiss";
        
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $filename = $_FILES['gambar']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), $allowed)) {
                $new_filename = time() . '_' . basename($filename);
                move_uploaded_file($_FILES['gambar']['tmp_name'], "../img/" . $new_filename);
                $query_tambahan = ", gambar=?";
                $params[] = $new_filename;
                $types .= "s";
            }
        }
        
        $params[] = $id;
        $types .= "i";
        
        $query = "UPDATE produk SET nama_produk=?, harga_produk=?, jumlah=?, kategori=?, deskripsi_produk=? $query_tambahan WHERE id=?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($koneksi);
            header("Location: index.php?status=edit_sukses");
            exit;
        } else {
            $error = "Gagal memperbarui data di database!";
        }
        mysqli_stmt_close($stmt);
    }
}

// Ambil data untuk form edit
if (!isset($_GET['id']) && !isset($id)) {
    header("Location: index.php");
    exit;
}

$id_edit = isset($_GET['id']) ? (int)$_GET['id'] : $id;
$query = "SELECT * FROM produk WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $id_edit);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$produk = mysqli_fetch_assoc($result);

if (!$produk) {
    echo '<!DOCTYPE html><html lang="id"><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
          <body class="bg-light"><div class="container mt-5"><div class="alert alert-danger">Produk tidak ditemukan!</div>
          <a href="index.php" class="btn btn-secondary">Kembali</a></div></body></html>';
    exit;
}
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Path disesuaikan karena edit.php berada di sesi_9/produk -->
    <link rel="stylesheet" href="../css/katalog.css"> 
    <style>
        .header-title { font-weight: 700; color: #333; }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-0">
                <h2 class="text-center mb-4 header-title">Edit Produk</h2>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form id="productForm" action="edit.php?id=<?= $produk['id'] ?>" method="POST" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="id" value="<?= $produk['id'] ?>">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama" class="form-control" value="<?= htmlspecialchars($produk['nama_produk']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Harga Produk (Rp)</label>
                        <input type="number" name="harga_produk" id="harga" class="form-control" value="<?= $produk['harga_produk'] ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Stok / Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" value="<?= isset($produk['jumlah']) ? $produk['jumlah'] : 0 ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="kategori" id="kategori" class="form-select">
                            <option value="">-- Pilih Kategori --</option>
                            <?php
                            $kategori_list = ['Elektronik', 'Fashion', 'Makanan', 'Olahraga', 'Lainnya'];
                            foreach ($kategori_list as $kat) {
                                $selected = ($produk['kategori'] == $kat) ? 'selected' : '';
                                echo "<option value=\"$kat\" $selected>$kat</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi Produk</label>
                        <textarea name="deskripsi_produk" id="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($produk['deskripsi_produk']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar Produk</label><br>
                        <?php if (!empty($produk['gambar'])): ?>
                            <img src="../img/<?= htmlspecialchars($produk['gambar']) ?>" alt="Gambar Saat Ini" width="100" class="mb-2" style="border-radius:8px;">
                        <?php else: ?>
                            <span class="badge bg-secondary mb-2">Belum ada gambar</span>
                        <?php endif; ?>
                        <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                    </div>

                    <button type="submit" class="btn btn-warning w-100 fw-bold">Simpan Perubahan</button>
                </form>

                <div class="mt-3 text-center">
                    <a href="index.php" class="btn btn-outline-secondary btn-sm">Batal & Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('productForm').addEventListener('submit', function(event) {
        const nama = document.getElementById('nama').value;
        const harga = document.getElementById('harga').value;
        const kategori = document.getElementById('kategori').value;
        const deskripsi = document.getElementById('deskripsi').value;
        const jumlah = document.getElementById('jumlah').value;

        if (!nama || !harga || !kategori || !deskripsi || jumlah === '') {
            event.preventDefault();
            alert('Harap isi semua kolom termasuk stok sebelum menyimpan!');
        }
    });
</script>

</body>
</html>
