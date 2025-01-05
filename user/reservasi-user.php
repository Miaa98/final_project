<?php
session_start(); // Mulai sesi
include '../database/db.php'; // Sertakan file koneksi database

// Ambil data dari form
$id_produk = $_POST['id'];
$user_id = $_POST['user_id'];
$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];
$durasi = $_POST['durasi'];
$total_harga = $_POST['total_harga'];
$tanggal_reservasi = $_POST['tanggal_reservasi'];

// Cek stok produk
$sql_check_stock = "SELECT stock FROM products WHERE product_id = ?";
$stmt_check_stock = $conn->prepare($sql_check_stock);
$stmt_check_stock->bind_param("i", $id_produk);
$stmt_check_stock->execute();
$result_check_stock = $stmt_check_stock->get_result();
$row_check_stock = $result_check_stock->fetch_assoc();

if ($row_check_stock['stock'] > 0) {
    // Kurangi stok produk
    $sql_update_stock = "UPDATE products SET stock = stock - 1 WHERE product_id = ?";
    $stmt_update_stock = $conn->prepare($sql_update_stock);
    $stmt_update_stock->bind_param("i", $id_produk);
    $stmt_update_stock->execute();

    // Simpan data reservasi ke tabel charts
    $sql_insert_reservasi = "INSERT INTO charts (id_produk, user_id, tanggal_mulai, tanggal_selesai, durasi, total_harga, tanggal_reservasi) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert_reservasi = $conn->prepare($sql_insert_reservasi);
    $stmt_insert_reservasi->bind_param("iississ", $id_produk, $user_id, $tanggal_mulai, $tanggal_selesai, $durasi, $total_harga, $tanggal_reservasi);
    $stmt_insert_reservasi->execute();

    // Redirect ke halaman sukses
    header("Location: keranjang-user.php?status=success");
    exit();
} else {
    // Redirect ke halaman error jika stok habis
    header("Location: error-stock.php");
    exit();
}
?>