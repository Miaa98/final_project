<?php
session_start();
include '../database/db.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    // Jika belum login, redirect ke halaman registrasi
    header("Location: register-user.php"); // Ganti dengan URL halaman registrasi Anda
    exit();
}

$user = $_SESSION['user']; // Ambil data pengguna dari sesi
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profil Pengguna</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    h1 {
        text-align: center;
        color: #333;
    }

    .profile-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    label {
        font-weight: bold;
        color: #555;
    }

    p {
        margin: 5px 0 15px;
        color: #666;
    }

    button {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #5cb85c;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #4cae4c;
    }
</style>

<body>
    <h1>Profil Pengguna</h1>
    <div>
        <label>Nama Pengguna:</label>
        <p><?php echo htmlspecialchars($user['username']); ?></p>

        <label>Email:</label>
        <p><?php echo htmlspecialchars($user['email']); ?></p>

        <label>Nomor Telepon:</label>
        <p><?php echo htmlspecialchars($user['phone']); ?></p>

        <label>Alamat:</label>
        <p><?php echo htmlspecialchars($user['address']); ?></p>
    </div>
    <button onclick="window.location.href='dashboard-user.php'">Kembali ke Beranda</button>
</body>

</html>