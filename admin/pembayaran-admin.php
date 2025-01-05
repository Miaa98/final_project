<?php
// Ambil data dari POST dan validasi
$kode_reservasi = isset($_POST['kode_reservasi']) ? trim($_POST['kode_reservasi']) : '';
$payment_method = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : '';
$total_harga = isset($_POST['total_harga']) ? floatval($_POST['total_harga']) : 0;

// Validasi data yang diterima
if (empty($kode_reservasi) || empty($payment_method) || $total_harga <= 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Data pembayaran tidak lengkap atau tidak valid.'
    ]);
    exit;
}

// Simpan data pembayaran dan update status reservasi
try {
    // Koneksi ke database
    include '../database/db.php';

    // Mulai transaksi
    $conn->begin_transaction();

    // Query untuk menyimpan data pembayaran dengan status 'success'
    $query_payment = "INSERT INTO payments (kode_reservasi, payment_method, total_harga, status) VALUES (?, ?, ?, 'success')";
    $stmt_payment = $conn->prepare($query_payment);
    $stmt_payment->bind_param("ssd", $kode_reservasi, $payment_method, $total_harga);
    
    if (!$stmt_payment->execute()) {
        throw new Exception('Gagal menyimpan data pembayaran.');
    }

    // Query untuk mengupdate status reservasi menjadi 'paid'
    $query_reservation = "UPDATE reservations SET status = 'paid' WHERE kode_reservasi = ?";
    $stmt_reservation = $conn->prepare($query_reservation);
    $stmt_reservation->bind_param("s", $kode_reservasi);
    
    if (!$stmt_reservation->execute()) {
        throw new Exception('Gagal mengubah status reservasi.');
    }

    // Commit transaksi
    $conn->commit();

    // Kirim response sukses
    echo json_encode([
        'status' => 'success',
        'message' => 'Pembayaran berhasil diproses dan status reservasi diubah menjadi "paid".'
    ]);
} catch (Exception $e) {
    // Rollback transaksi jika terjadi error
    $conn->rollback();

    // Kirim response error
    echo json_encode([
        'status' => 'error',
        'message' => 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage()
    ]);
} finally {
    // Tutup statement dan koneksi
    if (isset($stmt_payment)) $stmt_payment->close();
    if (isset($stmt_reservation)) $stmt_reservation->close();
    $conn->close();
}
?>
