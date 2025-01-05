<?php
session_start();
include '../database/db.php';

// Pastikan koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login-user.php"); // Jika tidak login, redirect ke halaman login
    exit();
}

// Ambil data dari form yang dikirimkan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $total_harga = $_POST['total_harga'];
    $keranjang_ids = explode(',', $_POST['keranjang_ids']); // Ambil ID keranjang yang dipilih

    // Query untuk memasukkan data ke tabel reservations
    $sql = "INSERT INTO reservations (user_id, total_harga, tanggal_reservasi, status) VALUES (?, ?, NOW(), 'Pending')";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $user_id, $total_harga);
        if ($stmt->execute()) {
            // Setelah berhasil menambahkan data ke reservations, hapus produk dari keranjang
            foreach ($keranjang_ids as $keranjang_id) {
                $delete_sql = "DELETE FROM charts WHERE keranjang_id = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->bind_param("i", $keranjang_id);
                $delete_stmt->execute();
            }
            echo "<script>alert('Booking berhasil!'); window.location.href='keranjang-user.php';</script>";
        } else {
            echo "<script>alert('Gagal melakukan booking.');</script>";
        }
    } else {
        echo "<script>alert('Gagal menyiapkan query.');</script>";
    }
}
?>
