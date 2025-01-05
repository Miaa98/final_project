<?php
include '../../database/db.php';

// Periksa apakah parameter 'id' ada di URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Ambil id dari parameter URL
    $kebaya_id = $_GET['id'];

    // Pastikan id tidak mengandung karakter berbahaya untuk SQL injection
    // Contoh sanitasi: menggunakan real_escape_string atau parameterized queries
    $kebaya_id = $conn->real_escape_string($kebaya_id);

    // Query untuk menghapus produk berdasarkan ID (string atau alfanumerik)
    $query = "DELETE FROM products WHERE kebaya_id = ?";
    $stmt = $conn->prepare($query);

    // Mengikat parameter dan mengeksekusi query
    $stmt->bind_param('s', $kebaya_id); // 's' untuk string
    $stmt->execute();

    // Redirect setelah berhasil menghapus produk
    header("Location: ../../admin/produk-admin.php");
    exit;
} else {
    echo "ID produk tidak valid!";
    exit;
}
?>
