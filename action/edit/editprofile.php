<?php
// Koneksi ke database
// $conn = new mysqli("localhost", "root", "", "hsl_kebaya");

// // Cek koneksi
// if ($conn->connect_error) {
//     die("Koneksi gagal: " . $conn->connect_error);
// }

include '../../database/db.php';

// Ambil ID dari URL
$userId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data pengguna dari database
$sql = "SELECT * FROM users WHERE user_id = $userId";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Proses form untuk mengupdate data pengguna
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $foto_profil = $user['foto_profil']; // default image path

    // Cek apakah ada file foto profil yang di-upload
    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
        $fileTmpPath = $_FILES['foto_profil']['tmp_name'];
        $fileName = $_FILES['foto_profil']['name'];
        $fileSize = $_FILES['foto_profil']['size'];
        $fileType = $_FILES['foto_profil']['type'];

        // Tentukan path untuk menyimpan file
        $uploadDir = '../../img/uploads/';
        $newFileName = uniqid() . '_' . $fileName;
        $destPath = $uploadDir . $newFileName;

        // Validasi file (misal hanya gambar jpg/png)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/JPG'];
        if (in_array($fileType, $allowedTypes)) {
            // Pindahkan file ke folder upload
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Simpan hanya nama file ke database, bukan path lengkap
                $foto_profil = $newFileName;
            } else {
                echo "Error saat meng-upload file.";
            }
        } else {
            echo "Hanya file gambar (JPEG/PNG) yang diperbolehkan.";
        }
    }

    // Update data pengguna ke database
    $updateSql = "UPDATE users SET username='$username', email='$email', phone='$phone', address='$address', foto_profil='$foto_profil' WHERE user_id=$userId";
    if ($conn->query($updateSql) === TRUE) {
        // Redirect ke halaman list user setelah berhasil
        header('Location: ../../admin/listuser-admin.php');
        exit; // Pastikan skrip berhenti di sini setelah pengalihan
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 500px;
        }

        h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 30px;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, input[type="email"]:focus, textarea:focus {
            border-color: #4CAF50;
            outline: none;
        }

        input[type="file"] {
            padding: 12px;
            margin-bottom: 20px;
            width: 100%;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        textarea {
            resize: vertical;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            color: green;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Profil Pengguna</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            
            <label for="phone">No. Telp:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            
            <label for="address">Alamat:</label>
            <textarea name="address" required><?php echo htmlspecialchars($user['address']); ?></textarea>

            <!-- Input untuk foto profil -->
            <label for="foto_profil">Foto Profil:</label>
            <input type="file" name="foto_profil" accept="image/jpeg, image/png">
            
    <!-- Menampilkan foto profil saat ini -->
    <?php if (!empty($user['foto_profil'])): ?>
        <div style="text-align: center;">
            <img src="../../img/uploads/<?php echo htmlspecialchars($user['foto_profil']); ?>" alt="Foto Profil" width="100" height="100">
        </div>
    <?php endif; ?>
    
            
            <button type="submit">Simpan Perubahan</button>
        </form>
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
