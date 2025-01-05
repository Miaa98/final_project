<?php
session_start(); // Mulai session
include '../database/db.php'; // Koneksi ke database

// Cek apakah request adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil kode_reservasi dari request
    $kode_reservasi = $_POST['kode_reservasi'];

    // Query untuk mengambil data reservasi (termasuk product_id dan quantity) - memastikan semua produk dalam reservasi
    $query = "SELECT id_produk, quantity FROM reservations WHERE kode_reservasi = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $kode_reservasi);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek jika ada produk dalam reservasi
    if ($result->num_rows > 0) {
        while ($reservation = $result->fetch_assoc()) {
            $product_id = $reservation['id_produk']; // Ambil product_id
            $quantity = $reservation['quantity']; // Ambil quantity

            // Query untuk mendapatkan stok produk saat ini
            $get_stock_query = "SELECT stock FROM products WHERE product_id = ?";
            $stmt = $conn->prepare($get_stock_query);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $stock_result = $stmt->get_result();
            $product = $stock_result->fetch_assoc();

            if ($product) {
                $current_stock = $product['stock']; // Stok saat ini

                // Update stok produk dengan menambahkannya kembali berdasarkan quantity
                $new_stock = $current_stock + $quantity;
                $update_stock_query = "UPDATE products SET stock = ? WHERE product_id = ?";
                $stmt = $conn->prepare($update_stock_query);
                $stmt->bind_param("ii", $new_stock, $product_id);
                $stmt->execute();

                // Cek apakah pengembalian stok berhasil
                if ($stmt->affected_rows <= 0) {
                    echo 'error: gagal mengupdate stok produk';
                    exit();
                }
            } else {
                // Jika produk tidak ditemukan
                echo 'error: produk tidak ditemukan';
                exit();
            }
        }

        // Setelah stok semua produk dikembalikan, update status reservasi menjadi 'completed'
        $update_status_query = "UPDATE reservations SET status = 'completed' WHERE kode_reservasi = ?";
        $stmt = $conn->prepare($update_status_query);
        $stmt->bind_param("s", $kode_reservasi);
        $stmt->execute();

        // Cek apakah status berhasil diperbarui
        if ($stmt->affected_rows > 0) {
            // Berikan respons 'success' jika berhasil
            echo 'success';
        } else {
            // Jika gagal update status
            echo 'error: gagal memperbarui status reservasi';
        }
    } else {
        // Jika data reservasi tidak ditemukan
        echo 'error: reservasi tidak ditemukan';
    }
} else {
    // Berikan respons 'invalid request' jika request bukan POST
    echo 'invalid request';
}
?>
