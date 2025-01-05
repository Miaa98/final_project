<?php
session_start(); // Pastikan session dimulai
// Masukkan koneksi database
include '../../database/db.php'; // Pastikan path ini benar

// Ambil ID reservasi dari query string
$reservasi_id = isset($_GET['reservasi_id']) ? $_GET['reservasi_id'] : '';

if ($reservasi_id) {
    // Query untuk mengambil detail reservasi beserta produk yang dipesan
    $query = "SELECT r.kode_reservasi, r.tanggal_reservasi, r.tanggal_mulai, r.tanggal_selesai, r.status,
                     p.nama
              FROM reservations r 
              LEFT JOIN reservation_products rp ON r.kode_reservasi = rp.kode_reservasi
              LEFT JOIN products p ON rp.product_id = p.product_id
              WHERE r.kode_reservasi = '$reservasi_id'";

    // Eksekusi query
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Ambil detail reservasi
        $row = mysqli_fetch_assoc($result);
        // Tampilkan detail reservasi
        echo "<h5>Detail Reservasi: " . htmlspecialchars($row['kode_reservasi']) . "</h5>";
        echo "<p>Tanggal Reservasi: " . date("d M Y", strtotime($row['tanggal_reservasi'])) . "</p>";
        echo "<p>Tanggal Mulai: " . date("d M Y", strtotime($row['tanggal_mulai'])) . "</p>";
        echo "<p>Tanggal Selesai: " . date("d M Y", strtotime($row['tanggal_selesai'])) . "</p>";
        echo "<p>Status: " . htmlspecialchars($row['status']) . "</p>";
        
        // Tampilkan produk yang dipesan
        echo "<h6>Produk yang Dipesan:</h6>";
        echo "<ul>";
        do {
            if ($row['nama']) {
                echo "<li>" . htmlspecialchars($row['nama']) . "</li>";
            }
        } while ($row = mysqli_fetch_assoc($result));
        echo "</ul>";
    } else {
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p>ID reservasi tidak tersedia.</p>";
}

// Menutup koneksi database (optional, karena sudah dilakukan di akhir skrip)
mysqli_close($conn);
?>
