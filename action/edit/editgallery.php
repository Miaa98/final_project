<?php
include '../../database/db.php';  // Pastikan koneksi database sudah benar

// Cek apakah ID produk ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data produk berdasarkan ID
    $query = "SELECT * FROM gallerys WHERE kebaya_id = '$id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak ditemukan.";
    exit;
}

// Proses update data setelah form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $model = $_POST['model'];
    $description = $_POST['description'];
    
    // Cek apakah ada gambar yang di-upload
    $image = $_FILES['image']['name'];  // Untuk mengganti gambar jika ada

    // Jika ada gambar baru yang diupload
    if ($image) {
        // Tentukan lokasi penyimpanan gambar
        $targetDir = "../../img/uploads/";
        $targetFile = $targetDir . basename($image);

        // Cek apakah file sudah ada
        if (file_exists($targetFile)) {
            echo "File sudah ada.";
            exit;
        }

        // Pastikan gambar yang di-upload adalah file gambar yang valid
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($imageFileType, $allowedTypes)) {
            echo "Hanya file gambar JPG, JPEG, PNG & GIF yang diperbolehkan.";
            exit;
        }

        // Cek ukuran file (misalnya max 2MB)
        if ($_FILES['image']['size'] > 2000000) {
            echo "Ukuran file terlalu besar!";
            exit;
        }

        // Pindahkan file ke direktori yang telah ditentukan
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            echo "File " . basename($image) . " berhasil di-upload.";
        } else {
            echo "Terjadi kesalahan saat meng-upload file.";
            exit;
        }
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $image = $row['image'];
    }

    // Update data di database
    $updateQuery = "UPDATE gallerys SET 
                    nama = '$nama', 
                    model = '$model', 
                    description = '$description', 
                    image = '$image' 
                    WHERE kebaya_id = '$id'";

    if ($conn->query($updateQuery) === TRUE) {
        // Redirect ke halaman gallery-admin.php setelah update berhasil
        header("Location: ../../admin/gallery-admin.php");  // Pastikan path ini benar
        exit();  // Hentikan eksekusi script setelah redirect
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Kebaya</title>
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Kebaya</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Kebaya</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Model Kebaya</label>
                <input type="text" class="form-control" id="model" name="model" value="<?php echo $row['model']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi Kebaya</label>
                <textarea class="form-control" id="description" name="description" required><?php echo $row['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar Kebaya</label>
                <input type="file" class="form-control" id="image" name="image">
                <img src="../../img/uploads/<?php echo $row['image']; ?>" width="100" alt="Gambar Kebaya">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>

</html>

<?php $conn->close(); ?>
