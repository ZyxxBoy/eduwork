<?php

require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama      = trim($_POST['nama_produk']);
    $harga     = (int)$_POST['harga_produk'];
    $jumlah    = (int)$_POST['jumlah'];
    $kategori  = trim($_POST['kategori']);
    $deskripsi = trim($_POST['deskripsi_produk']);
    
    // Proses upload gambar
    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['gambar']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), $allowed)) {
            $new_filename = time() . '_' . basename($filename);
            move_uploaded_file($_FILES['gambar']['tmp_name'], "img/" . $new_filename);
            $gambar = $new_filename;
        }
    }

    // Validasi sisi server
    if (empty($nama) || empty($harga) || empty($kategori) || empty($deskripsi)) {
        echo '<!DOCTYPE html><html lang="id"><head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            </head><body class="bg-light"><div class="container mt-5">
            <div class="alert alert-danger">Gagal! Data tidak boleh ada yang kosong.</div>
            <a href="produk/input/input.php" class="btn btn-secondary">Kembali</a>
            </div></body></html>';
        exit;
    }

    // Logika status produk
    $status = ($harga > 5000000) ? "Produk Mewah" : "Produk Standar";

    // Simpan ke database
    $query = "INSERT INTO produk (nama_produk, harga_produk, jumlah, kategori, deskripsi_produk, gambar)
              VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "siisss", $nama, $harga, $jumlah, $kategori, $deskripsi, $gambar);
    $berhasil = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($koneksi);

    if ($berhasil) {
        header("Location: produk/input/input.php?status=sukses");
        exit;
    } else {
        echo '<!DOCTYPE html><html lang="id"><head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            </head><body class="bg-light"><div class="container mt-5">
            <div class="alert alert-danger">Gagal menyimpan ke database! Cek apakah tabel sudah dibuat.</div>
            <a href="produk/input/input.php" class="btn btn-secondary">Kembali</a>
            </div></body></html>';
    }
}
?>
