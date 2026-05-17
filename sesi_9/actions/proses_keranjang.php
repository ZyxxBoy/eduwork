<?php
session_start();

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $action = $_POST['action'] ?? 'keranjang';

    // Tambah kuantitas jika sudah ada, atau set jadi 1
    if (isset($_SESSION['keranjang'][$id])) {
        $_SESSION['keranjang'][$id]++;
    } else {
        $_SESSION['keranjang'][$id] = 1;
    }

    // Redirect sesuai action
    if ($action === 'beli') {
        header("Location: ../checkout.php");
    } else {
        header("Location: ../keranjang.php");
    }
    exit;
}

// Untuk menghapus item dari keranjang
if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];
    if (isset($_SESSION['keranjang'][$id_hapus])) {
        unset($_SESSION['keranjang'][$id_hapus]);
    }
    header("Location: ../keranjang.php");
    exit;
}

header("Location: ../index.php");
