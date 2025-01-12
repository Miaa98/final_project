<?php
include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi jika file image ada di upload
    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
        $foto = basename($_FILES["foto"]["name"]);
        $target_dir = "../img/uploads/";
        $target_file = $target_dir . $foto;

        // Validasi ekstensi file
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowed_types)) {
            echo "Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
            exit();
        }

        // Upload gambar
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Mendapatkan data dari form
            $kebaya_id = $_POST['kebaya_id'] ?? '';
            $nama = $_POST['nama'] ?? '';
            $ukuran = $_POST['ukuran'] ?? '';
            $jenis = $_POST['jenis'] ?? '';
            $jenis_lain = $_POST['jenis-lain'] ?? '';
            $deskripsi = $_POST['deskripsi'] ?? '';
            $harga = $_POST['harga'] ?? '';
            $stok = $_POST['stock'] ?? '';

            // Jika jenis lain dipilih, gunakan input dari 'jenis-lain'
            if ($jenis === 'lainnya') {
                $jenis = $jenis_lain;
            }

            // Validasi input
            if (empty($kebaya_id) || empty($nama) || empty($ukuran) || empty($jenis) || empty($deskripsi) || empty($harga) || empty($stok)) {
                echo "Semua field harus diisi.";
                exit();
            }

            // Debugging untuk memeriksa data POST
            echo "<pre>";
            print_r($_POST);
            echo "</pre>";

            // Query insert produk dengan kolom yang sesuai
            $query = "INSERT INTO products (kebaya_id, nama, ukuran, jenis, deskripsi, harga, stock, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            // Gunakan 'sssssdss' untuk bind_param (4 string, 1 double, 1 integer, 1 string)
            $stmt->bind_param("sssssdis", $kebaya_id, $nama, $ukuran, $jenis, $deskripsi, $harga, $stok, $foto);

            // Eksekusi query
            if ($stmt->execute()) {
                header("Location: ../admin/produk-admin.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Gagal mengupload gambar.";
        }
    } else {
        echo "File gambar tidak ada atau terjadi kesalahan pada pengunggahan file.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Tampilkan input untuk jenis lain jika "lainnya" dipilih
        function toggleOtherInput() {
            const jenisSelect = document.getElementById("jenis");
            const jenisLainInput = document.getElementById("jenis-lain");
            if (jenisSelect.value === "lainnya") {
                jenisLainInput.style.display = "block";
            } else {
                jenisLainInput.style.display = "none";
                jenisLainInput.value = ""; // Hapus nilai sebelumnya
            }
        }
    </script>
</head>

<body>
    <div class="container mt-4">
        <h2>Tambah Produk Kebaya</h2>
        <form action="addproduk.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="kebaya_id" class="form-label">ID Produk <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="kebaya_id" name="kebaya_id" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="ukuran" class="form-label">Ukuran <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="ukuran" name="ukuran" required>
            </div>
            <div class="mb-3">
                <label for="jenis" class="form-label">Jenis Produk <span class="text-danger">*</span></label>
                <select class="form-select" id="jenis" name="jenis" required onchange="toggleOtherInput()">
                    <option value="" disabled selected>Pilih Jenis Produk</option>
                    <option value="Kebaya">Kebaya</option>
                    <option value="Jas">Jas</option>
                    <option value="Aksesoris">Aksesoris</option>
                    <option value="lainnya">Lainnya</option>
                </select>
                <input type="text" class="form-control mt-2" id="jenis-lain" name="jenis-lain" placeholder="Sebutkan jenis lainnya..." style="display:none;">
            </div>
            <div class="mb-3">
    <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
    <input type="number" class="form-control" id="harga" name="harga" required min="0">
</div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="stock" name="stock" required min="0">
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Kebaya</label>
                <input type="file" class="form-control" id="foto" name="foto" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Produk</button>
        </form>
    </div>
</body>

</html>
