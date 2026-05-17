<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['keranjang']) && !empty($_SESSION['keranjang'])) {
    $nama = isset($_POST['nama']) ? trim($_POST['nama']) : 'Pelanggan';
    $nohp = isset($_POST['nohp']) ? trim($_POST['nohp']) : '';
    $alamat = isset($_POST['alamat']) ? trim($_POST['alamat']) : '';
    $pembayaran = isset($_POST['pembayaran']) ? trim($_POST['pembayaran']) : '';
    $keranjang = $_SESSION['keranjang'];

    // 1. Hitung total harga
    $total_harga = 0;
    $ids = array_keys($keranjang);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $query_harga = "SELECT id, harga_produk FROM produk WHERE id IN ($placeholders)";
    $stmt_harga = mysqli_prepare($koneksi, $query_harga);
    $types = str_repeat('i', count($ids));
    mysqli_stmt_bind_param($stmt_harga, $types, ...$ids);
    mysqli_stmt_execute($stmt_harga);
    $result = mysqli_stmt_get_result($stmt_harga);
    $harga_produk_list = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $total_harga += $row['harga_produk'] * $keranjang[$row['id']];
        $harga_produk_list[$row['id']] = $row['harga_produk'];
    }
    mysqli_stmt_close($stmt_harga);

    // 2. Insert ke tabel orders
    $query_order = "INSERT INTO orders (nama_pelanggan, no_hp, alamat, metode_pembayaran, total_harga) VALUES (?, ?, ?, ?, ?)";
    $stmt_order = mysqli_prepare($koneksi, $query_order);
    mysqli_stmt_bind_param($stmt_order, "ssssi", $nama, $nohp, $alamat, $pembayaran, $total_harga);
    mysqli_stmt_execute($stmt_order);
    $order_id = mysqli_insert_id($koneksi);
    mysqli_stmt_close($stmt_order);

    // 3. Insert ke order_items & kurangi stok produk
    $query_item = "INSERT INTO order_items (order_id, produk_id, kuantitas, harga_satuan) VALUES (?, ?, ?, ?)";
    $stmt_item = mysqli_prepare($koneksi, $query_item);
    
    $query_stok = "UPDATE produk SET jumlah = jumlah - ? WHERE id = ?";
    $stmt_stok = mysqli_prepare($koneksi, $query_stok);

    foreach ($keranjang as $produk_id => $kuantitas) {
        $harga_satuan = $harga_produk_list[$produk_id];
        
        // Insert order_items
        mysqli_stmt_bind_param($stmt_item, "iiii", $order_id, $produk_id, $kuantitas, $harga_satuan);
        mysqli_stmt_execute($stmt_item);

        // Update stok di produk
        mysqli_stmt_bind_param($stmt_stok, "ii", $kuantitas, $produk_id);
        mysqli_stmt_execute($stmt_stok);
    }
    mysqli_stmt_close($stmt_item);
    mysqli_stmt_close($stmt_stok);
    mysqli_close($koneksi);
    
    // 4. Bersihkan session keranjang
    unset($_SESSION['keranjang']);
    
    // Simpan data pesanan terakhir untuk konfirmasi WA di halaman sukses
    $_SESSION['last_order'] = [
        'nama' => $nama,
        'pembayaran' => $pembayaran
    ];
    
    header("Location: sukses.php");
    exit;
}

header("Location: index.php");
