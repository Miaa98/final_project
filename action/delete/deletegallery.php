<?php
// Memasukkan koneksi ke database
include '../../database/db.php';

// Cek apakah ID kebaya ada dalam URL
if (isset($_GET['id'])) {
    // Ambil ID kebaya dari URL
    $kebaya_id = $_GET['id'];

    // Debugging untuk memeriksa nilai ID (opsional, hapus jika sudah tidak diperlukan)
    // echo "ID yang diterima: " . htmlspecialchars($kebaya_id) . "<br>";

    // Query untuk menghapus data kebaya berdasarkan ID
    $query = "DELETE FROM gallerys WHERE kebaya_id = ?";

    // Siapkan statement untuk mencegah SQL injection
    if ($stmt = $conn->prepare($query)) {
        // Bind parameter (s = string)
        $stmt->bind_param("s", $kebaya_id);

        // Eksekusi query
        if ($stmt->execute()) {
            // Periksa apakah ada baris yang terpengaruh
            if ($stmt->affected_rows > 0) {
                // Redirect kembali ke halaman gallery-admin.php setelah penghapusan sukses
                header("Location: ../../admin/gallery-admin.php?message=Produk berhasil dihapus");
                exit();
            } else {
                echo "Produk dengan ID tersebut tidak ditemukan.";
            }
        } else {
            echo "Terjadi kesalahan saat mencoba menghapus produk: " . $stmt->error;
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo "Terjadi kesalahan dalam menyiapkan query: " . $conn->error;
    }
} else {
    // Jika ID tidak ditemukan di URL
    echo "ID produk tidak ditemukan di URL.";
}

// Tutup koneksi database
$conn->close();
?>
