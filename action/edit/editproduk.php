<?php
include '../../database/db.php';  // Pastikan koneksi database sudah benar

// Cek apakah ID produk ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data produk berdasarkan ID dari tabel products
    $query = "SELECT * FROM products WHERE kebaya_id = '$id'";
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
    // Pastikan semua field ada di POST
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : '';
    $ukuran = isset($_POST['ukuran']) ? $_POST['ukuran'] : '';
    $deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
    $harga = isset($_POST['harga']) ? $_POST['harga'] : '';
    $foto = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : '';  // Untuk mengganti gambar jika ada

    // Debugging: Pastikan kita menerima data dengan benar
    if (empty($jenis)) {
        echo "Jenis Produk tidak boleh kosong.";
        exit;
    }

    // Jika ada gambar baru yang diupload
    if ($foto) {
        move_uploaded_file($_FILES['foto']['tmp_name'], "../../img/uploads/" . $foto);
    } else {
        // Jika tidak ada gambar baru, pakai gambar lama
        $foto = $row['foto'];
    }

    // Validasi panjang data untuk 'jenis' (contoh: maksimal 50 karakter)
    if (strlen($jenis) > 50) {
        echo "Jenis Produk terlalu panjang. Maksimal 50 karakter.";
        exit;
    }

    // Update data di database
    $updateQuery = "UPDATE products SET 
                    nama = '$nama', 
                    jenis = '$jenis', 
                    ukuran = '$ukuran', 
                    deskripsi = '$deskripsi', 
                    harga = '$harga', 
                    foto = '$foto' 
                    WHERE kebaya_id = '$id'";

    if ($conn->query($updateQuery) === TRUE) {
        // Redirect ke halaman produk-admin.php setelah update berhasil
        header("Location: ../../admin/produk-admin.php");  // Pastikan path ini benar
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
                <label for="jenis" class="form-label">Jenis Produk</label>
                <select class="form-control" id="jenis" name="jenis" required>
                    <option value="" disabled selected>Pilih Jenis Produk</option>
                    <option value="Kebaya" <?php echo ($row['jenis'] == 'Kebaya') ? 'selected' : ''; ?>>Kebaya</option>
                    <option value="Jas" <?php echo ($row['jenis'] == 'Jas') ? 'selected' : ''; ?>>Jas</option>
                    <option value="Aksesoris" <?php echo ($row['jenis'] == 'Aksesoris') ? 'selected' : ''; ?>>Aksesoris</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="size" class="form-label">Ukuran Produk</label>
                <input type="text" class="form-control" id="ukuran" name="ukuran" value="<?php echo htmlspecialchars($row['ukuran']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi Produk</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" required><?php echo htmlspecialchars($row['deskripsi']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Harga Produk</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?php echo htmlspecialchars($row['harga']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Gambar Produk</label>
                <input type="file" class="form-control" id="foto" name="foto">
                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</body>

</html>