<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_produk'];
    $harga = (int)$_POST['harga_produk'];
    $deskripsi = $_POST['deskripsi_produk'];

    echo '<!DOCTYPE html>
    <html lang="id">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">';

    // Validasi Sisi Server (Tugas 3 pada image_5593e0.png)
    if (empty($nama) || empty($harga) || empty($deskripsi)) {
        echo '<div class="alert alert-danger">Gagal! Data tidak boleh ada yang kosong.</div>';
        echo '<a href="index.php" class="btn btn-secondary">Kembali</a>';
    } else {
        // Logika If-Else (Tugas 1)
        $status = ($harga > 5000000) ? "Produk Mewah" : "Produk Standar";

        echo '<div class="card p-4 shadow-sm text-start">';
        echo '<h3 class="text-success mb-3 text-center">Data Berhasil Disimpan</h3>';
        echo '<ul class="list-group list-group-flush">';
        echo '<li class="list-group-item"><strong>Nama:</strong> '.htmlspecialchars($nama).'</li>';
        echo '<li class="list-group-item"><strong>Harga:</strong> Rp '.number_format($harga, 0, ',', '.').'</li>';
        echo '<li class="list-group-item"><strong>Status:</strong> <span class="badge bg-info">'.$status.'</span></li>';
        echo '<li class="list-group-item"><strong>Deskripsi:</strong> '.htmlspecialchars($deskripsi).'</li>';
        echo '</ul>';
        echo '<div class="mt-4 text-center"><a href="index.php" class="btn btn-outline-primary">Tambah Lagi</a></div>';
        echo '</div>';
    }

    echo '</div></div></div></body></html>';
}
?>