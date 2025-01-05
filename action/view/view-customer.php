<?php
include '../../database/db.php'; // Koneksi ke database

if (isset($_GET['reservasi_id'])) {
    $reservasi_id = $_GET['reservasi_id'];
    echo "Reservasi ID: " . htmlspecialchars($reservasi_id) . "<br>"; // Debugging

    // Query untuk mengambil data customer berdasarkan reservation_id
    $query = "SELECT u.username, u.email, u.telepon 
              FROM reservations r 
              JOIN users u ON r.user_id = u.user_id 
              WHERE r.reservation_id = :reservation_id"; // Pastikan ini sesuai dengan nama kolom di database
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([':reservation_id' => $reservasi_id]);
    $customer = $stmt->fetch();

    if ($customer) {
        echo "<p><strong>Username:</strong> " . htmlspecialchars($customer['username']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($customer['email']) . "</p>";
        echo "<p><strong>Telepon:</strong> " . htmlspecialchars($customer['telepon']) . "</p>";
    } else {
        echo "<p>Data customer tidak ditemukan.</p>";
    }
} else {
    echo "<p>Reservasi ID tidak valid.</p>";
}
?>