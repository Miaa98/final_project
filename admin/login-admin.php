<?php
// Mulai sesi
session_start();

// Sertakan file koneksi
include '../database/db.php'; // Ganti dengan path ke file koneksi Anda

// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Siapkan dan bind
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Cek apakah username ada
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verifikasi password
        if (password_verify($password, $hashed_password)) {
            // Simpan informasi pengguna dalam sesi
            $_SESSION['username'] = $username; // Simpan username
            header("Location: home-admin.php"); // Ganti dengan halaman yang diinginkan
            exit();
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Username tidak ditemukan!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
</head>
<style>
    /* Mengimpor font dari Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    body {
        font-family: 'Roboto', sans-serif;
        background: linear-gradient(to right, #6a11cb, #2575fc);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    h2 {
        color: white;
        margin-bottom: 20px;
        text-align: center;
    }

    form {
        background: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        width: 300px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        transition: border-color 0.3s;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
        border-color: #6a11cb;
        outline: none;
    }

    input[type="submit"] {
        background-color: #6a11cb;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s, transform 0.3s;
    }

    input[type="submit"]:hover {
        background-color: #2575fc;
        transform: translateY(-2px);
    }

    /* Animasi untuk form */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    form {
        animation: fadeIn 0.5s ease-in-out;
    }

    .register-info {
        margin-top: 20px;
        color: white;
        /* Warna teks */
        font-size: 14px;
        /* Ukuran font */
    }

    .register-link {
        color: #6a11cb;
        /* Warna tautan */
        text-decoration: none;
        /* Menghilangkan garis bawah */
        font-weight: bold;
        /* Menebalkan teks */
    }

    .register-link:hover {
        text-decoration: underline;
        /* Garis bawah saat hover */
    }

    /* Gaya untuk tombol sosial media */
    .social-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
    }

    .social-button {
        background-color: #3b5998;
        /* Facebook */
        color: white;
        border: none;
        padding: 10px;
        border-radius: 4px;
        cursor: pointer;
        width: 48%;
        transition: background-color 0.3s;
    }

    .social-button:hover {
        background-color: #2d4373;
    }
</style>

<body>
    <h2>Login Pengguna</h2>
    <form method="post" action="">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
        <p>Belum punya akun? <a href="register-admin.php" style="color: #6a11cb; text-decoration: none;">Daftar di sini</a></p>
    </form>
    </div>
</body>

</html>