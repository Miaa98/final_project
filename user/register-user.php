<?php
// Sertakan file koneksi
include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
    $role = 'user'; // Default role is 'user'

    // Handle profile photo upload
    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
        $upload_dir = '../img/uploads/';

        // Ambil nama file asli dan beri nama unik agar tidak ada duplikasi
        $file_name = basename($_FILES['foto_profil']['name']);
        $new_file_name = uniqid() . '_' . $file_name; // Menambahkan ID unik pada nama file
        $foto_profil = $new_file_name;

        // Pindahkan file ke folder upload
        if (!move_uploaded_file($_FILES['foto_profil']['tmp_name'], $upload_dir . $new_file_name)) {
            $foto_profil = null; // Jika gagal upload, set foto_profil ke null
        }
    } else {
        $foto_profil = null; // No image uploaded
    }

    // Simpan data ke database
    $query = "INSERT INTO users (username, email, phone, address, password, role, foto_profil) 
              VALUES ('$username', '$email', '$phone', '$address', '$password', '$role', '$foto_profil')";
    if (mysqli_query($conn, $query)) {
        header("Location: login-user.php"); // Redirect ke halaman login setelah registrasi berhasil
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Tutup koneksi
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
</head>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: url("../img/35.png");
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        color: #fff;
    }

    .container {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        width: 400px;
        height: 600px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        color: #333;
        font-weight: 600;
    }

    label {
        display: block;
        margin-bottom: 5px;
        text-align: left;
        color: #333;
        font-weight: 500;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="file"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 2px solid #000;
        border-radius: 8px;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="file"]:focus {
        border-color: #000;
        outline: none;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #333;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #2575fc;
    }

    p {
        margin-top: 15px;
        color: #555;
    }

    a {
        color: #6a11cb;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }

    @media (max-width: 600px) {
        .container {
            width: 90%;
        }
    }
</style>

<body>
    <div class="container">
        <div class="box">
            <h2>Form Registrasi</h2>
            <form action="register-user.php" method="POST" enctype="multipart/form-data">
                <label for="username">Nama Pengguna:</label>
                <input type="text" name="username" required><br>

                <label for="email">Email:</label>
                <input type="email" name="email" required><br>

                <label for="phone">Nomor Telepon:</label>
                <input type="text" name="phone" required><br>

                <label for="address">Alamat:</label>
                <input type="text" name="address" required><br>

                <label for="password">Password:</label>
                <input type="password" name="password" required><br>

                <label for="foto_profil">Foto Profil:</label>
                <input type="file" name="foto_profil" accept="image/*"><br>

                <!-- Hidden input to set role -->
                <input type="hidden" name="role" value="user">

                <button type="submit">Daftar</button>
            </form>
        </div>
    </div>
</body>

</html>
