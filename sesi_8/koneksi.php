<?php

$host     = 'localhost';
$user     = 'root';
$password = '';
$database = 'ecommerce';

// Buat koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die('<div style="font-family:Arial;padding:20px;background:#f8d7da;color:#842029;border-radius:8px;">
        <strong>Koneksi Gagal!</strong><br>
        ' . mysqli_connect_error() . '
    </div>');
}

// Set charset UTF-8
mysqli_set_charset($koneksi, 'utf8');
?>
