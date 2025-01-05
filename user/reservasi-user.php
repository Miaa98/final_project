<?php
session_start(); // Mulai sesi
include '../database/db.php'; // Sertakan file koneksi database

// Cek apakah metode request adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan data yang dibutuhkan ada dalam form
    if (!isset($_POST['id'], $_POST['user_id'], $_POST['tanggal_mulai'], $_POST['tanggal_selesai'], $_POST['durasi'], $_POST['total_harga'], $_POST['tanggal_reservasi'], $_POST['quantity'])) {
        die("Error: Semua field harus diisi.");
    }

    // Ambil data dari form
    $id_produk = $_POST['id'];
    $user_id = $_POST['user_id'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $durasi = $_POST['durasi'];
    $total_harga = $_POST['total_harga'];
    $tanggal_reservasi = $_POST['tanggal_reservasi'];
    $quantity = $_POST['quantity'];  // Menambahkan quantity

    // Validasi format tanggal (pastikan tanggal dalam format Y-m-d)
    $dateStart = DateTime::createFromFormat('Y-m-d', $tanggal_mulai);
    $dateEnd = DateTime::createFromFormat('Y-m-d', $tanggal_selesai);
    $dateReservasi = DateTime::createFromFormat('Y-m-d', $tanggal_reservasi);

    if (!$dateStart || !$dateEnd || !$dateReservasi) {
        die("Error: Format tanggal tidak valid.");
    }

    // Mengubah format tanggal menjadi Y-m-d untuk database
    $tanggal_mulai = $dateStart->format('Y-m-d');
    $tanggal_selesai = $dateEnd->format('Y-m-d');
    $tanggal_reservasi = $dateReservasi->format('Y-m-d');

    // Cek stok produk
    $sql_check_stock = "SELECT stock FROM products WHERE product_id = ?";
    $stmt_check_stock = $conn->prepare($sql_check_stock);
    $stmt_check_stock->bind_param("i", $id_produk);
    $stmt_check_stock->execute();
    $result_check_stock = $stmt_check_stock->get_result();
    $row_check_stock = $result_check_stock->fetch_assoc();

    if ($row_check_stock['stock'] >= $quantity) {  // Pastikan stok mencukupi
        // Kurangi stok produk
        $sql_update_stock = "UPDATE products SET stock = stock - ? WHERE product_id = ?";
        $stmt_update_stock = $conn->prepare($sql_update_stock);
        $stmt_update_stock->bind_param("ii", $quantity, $id_produk);
        if (!$stmt_update_stock->execute()) {
            die("Error: Gagal mengurangi stok produk.");
        }

        // Simpan data reservasi ke tabel charts
        $sql_insert_reservasi = "INSERT INTO charts (id_produk, user_id, tanggal_mulai, tanggal_selesai, durasi, total_harga, tanggal_reservasi, quantity) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert_reservasi = $conn->prepare($sql_insert_reservasi);
        $stmt_insert_reservasi->bind_param("iisssisi", $id_produk, $user_id, $tanggal_mulai, $tanggal_selesai, $durasi, $total_harga, $tanggal_reservasi, $quantity);

        if ($stmt_insert_reservasi->execute()) {
            // Redirect ke halaman sukses setelah data berhasil disimpan
            header("Location: keranjang-user.php?status=success");
            exit();
        } else {
            die("Error: Gagal menyimpan data ke tabel charts.");
        }
    } else {
        // Jika stok habis, redirect ke halaman error-stock.php
        header("Location: error-stock.php");
        exit();
    }
} else {
    // Jika bukan POST, tampilkan error
    die("Error: Metode request tidak valid.");
}
?>
