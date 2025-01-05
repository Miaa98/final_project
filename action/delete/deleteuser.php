<?php
session_start();
include '../database/db.php';

// Cek apakah pengguna sudah login dan memiliki hak akses
if (isset($_SESSION['user_id']) && isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "hsl_kebaya");

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk menghapus pengguna
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Redirect kembali ke halaman list user dengan pesan sukses
        header("Location: ../../admin/listuser-admin.php?message=User  berhasil dihapus");
    } else {
        // Redirect kembali dengan pesan error
        header("Location: ../../admin/listuser-admin.php?message=Gagal menghapus user");
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect jika tidak ada ID atau tidak login
    header("Location: listuser-admin.php");
}
?>