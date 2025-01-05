<?php
session_start();
include '../database/db.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan kode_reservasi diterima dengan aman
    if (isset($_POST['kode_reservasi'])) {
        $kode_reservasi = $_POST['kode_reservasi'];

        // Query untuk mengupdate status menjadi 'completed'
        $query = "UPDATE reservations SET status = 'completed' WHERE kode_reservasi = ?";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 's', $kode_reservasi);
            $execute = mysqli_stmt_execute($stmt);

            if ($execute && mysqli_stmt_affected_rows($stmt) > 0) {
                echo 'success'; // Berhasil mengupdate status
            } else {
                echo 'error'; // Gagal mengupdate status, mungkin karena kode_reservasi tidak ada
            }

            mysqli_stmt_close($stmt);
        } else {
            echo 'error'; // Gagal menyiapkan statement
        }
    } else {
        echo 'error'; // Jika kode_reservasi tidak dikirim
    }

    mysqli_close($conn);
} else {
    echo 'error'; // Jika request bukan POST
}
