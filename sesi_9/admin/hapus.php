<?php
require_once '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Siapkan query hapus
    $query = "DELETE FROM produk WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Jika berhasil dihapus, kembali ke index dengan status hapus_sukses
        header("Location: index.php?status=hapus_sukses");
    } else {
        // Jika gagal dihapus
        header("Location: index.php?status=hapus_gagal");
    }
    
    mysqli_stmt_close($stmt);
} else {
    // Jika tidak ada ID
    header("Location: index.php");
}

mysqli_close($koneksi);
exit;
