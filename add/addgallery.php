<?php
// Koneksi ke database
$servername = "localhost"; // Ganti dengan server database Anda, jika berbeda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "hsl_kebaya"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menangani upload file gambar
    $target_dir = "../img/uploads/"; 
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $upload_ok = 1;

    // Validasi file gambar
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "File yang diunggah bukan gambar.";
        $upload_ok = 0;
    }

    // Batasi jenis file gambar yang diterima
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_types)) {
        echo "Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
        $upload_ok = 0;
    }

    // Jika upload berhasil, simpan data
    if ($upload_ok && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $kebaya_id = $_POST['kebaya_id'] ?? '';
        $nama = $_POST['nama'] ?? '';
        $model = $_POST['model'] ?? '';
        $description = $_POST['description'] ?? '';

        // Validasi input untuk memastikan tidak ada yang kosong
        if (empty($kebaya_id) || empty($nama) || empty($model) || empty($description)) {
            echo "Semua field harus diisi.";
            exit();
        }

        // Query dengan prepared statement untuk keamanan
        $query = "INSERT INTO gallerys (kebaya_id, nama, model, description, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $kebaya_id, $nama, $model, $description, $image_name);

        // Eksekusi query dan pengecekan error
        if ($stmt->execute()) {
            // Redirect ke halaman gallery-admin.php setelah data berhasil ditambahkan
            header("Location: ../admin/gallery-admin.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Maaf, terjadi kesalahan saat mengunggah file.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tambah Produk Kebaya</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            margin-top: 10px;
            padding-right: 10px !important;
            padding-left: 10px !important;
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: auto !important;
        }

        .table {
            background-color: #fff;
            margin-top: 10px;
            max-width: 100% !important;
        }

        .table th {
            background-color: #524A4E;
            color: #fff;
        }

        .table th, .table td {
            text-align: left;
        }

        .table img {
            height: auto;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Tambah Produk Kebaya</h2>
        <form action="addgallery.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="kebaya_id" class="form-label">ID Kebaya</label>
                <input type="text" class="form-control" id="kebaya_id" name="kebaya_id" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Kebaya</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Foto Kebaya</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Produk</button>
        </form>
    </div>
</body>
</html>
