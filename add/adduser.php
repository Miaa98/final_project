<?php
// Sertakan file koneksi
include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form dan sanitasi input untuk menghindari SQL Injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
    $role = $_POST['role']; // Ambil role dari form, bisa admin atau user

    // Handle profile photo upload
    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
        $upload_dir = '../img/uploads/';
        $file_name = basename($_FILES['foto_profil']['name']);
        $new_file_name = uniqid() . '_' . $file_name; // Menggunakan nama file unik
        $foto_profil = $upload_dir . $new_file_name; // Menyimpan path relatif

        // Cek apakah file berhasil dipindahkan ke folder
        if (!move_uploaded_file($_FILES['foto_profil']['tmp_name'], $foto_profil)) {
            $foto_profil = null; // Jika upload gagal, set foto_profil ke null
        }
    } else {
        $foto_profil = null; // Jika tidak ada foto profil yang diupload
    }

    // Prepared statement untuk memasukkan data ke database
    $stmt = $conn->prepare("INSERT INTO users (username, email, phone, address, password, role, foto_profil) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $username, $email, $phone, $address, $password, $role, $new_file_name);

    // Eksekusi query
    if ($stmt->execute()) {
        header("Location:../admin/listuser-admin.php"); // Redirect ke halaman list user setelah registrasi berhasil
        exit; // Pastikan proses berhenti setelah redirect
    } else {
        echo "Error: " . $stmt->error; // Tampilkan error jika query gagal
    }

    // Tutup statement dan koneksi
    $stmt->close();
    mysqli_close($conn);
}
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
            <form action="" method="POST" enctype="multipart/form-data">
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

                <!-- Pilih role -->
                <label for="role">Role:</label>
                <select name="role">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select><br>

                <button type="submit">Daftar</button>
            </form>
        </div>
    </div>
</body>

</html>
