<?php
session_start();
include '../database/db.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reservasi_id = $_POST['reservasi_id'];
    $amount = $_POST['amount'];

    // Logika untuk memproses pembayaran
    $query = "INSERT INTO payments (reservasi_id, amount, payment_date) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sd", $reservasi_id, $amount);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Pembayaran berhasil dilakukan.</div>";
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan saat memproses pembayaran.</div>";
    }
} else {
    echo "<div class='alert alert-warning'>Metode permintaan tidak valid.</div>";
}
?>