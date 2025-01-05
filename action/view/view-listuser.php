<?php
session_start();
include '../../database/db.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];


    // Query untuk mendapatkan detail pengguna
    $sql = "SELECT username, email, phone, address, role, foto_profil FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
echo json_encode($user_id);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Mengembalikan data dalam format JSON
        header('Content-Type: application/json'); // Menambahkan header untuk JSON
        echo json_encode($user);
    } else {
        // Mengembalikan array kosong jika tidak ada pengguna
        header('Content-Type: application/json'); // Menambahkan header untuk JSON
        echo json_encode([]);
    }

    $stmt->close();
    $conn->close();
} else {
    // Mengembalikan array kosong jika ID tidak ada
    header('Content-Type: application/json'); // Menambahkan header untuk JSON
    echo json_encode([]);
}
?>