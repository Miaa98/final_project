<?php 
session_start(); // Pastikan session dimulai
include '../database/db.php'; // Koneksi ke database

// Cek apakah pengguna sudah login
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];

    echo "<div class='alert alert-info'>"; // Menggunakan Bootstrap untuk styling
    echo "<strong>Selamat datang!</strong> User ID Anda: " . htmlspecialchars($user_id) . "<br>";
    echo "Role Anda: " . htmlspecialchars($role);
    echo "</div>";
} else {
    echo "<div class='alert alert-warning'>Anda belum login. Silakan <a href='login-user.php'>login</a>.</div>";
}

// Query untuk mengambil data dari tabel "products"
$query = "SELECT * FROM products";
$result = $conn->query($query);

if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding-top: 60px;
        }

        .container {
            padding-left: 10px !important;
            padding-right: 10px !important;
            max-width: 100% !important;
        }

        .table {
            margin-top: 10px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100% !important;
            border-collapse: collapse;
        }

        .table th {
            background-color: #524A4E !important;
            color: #fff !important;
        }

        .table th,
        .table td {
            text-align: left;
            vertical-align: top;
            border-left: none;
            border-right: none;
            border-bottom: 1px solid #ddd;
        }

        .table img {
            object-fit: cover;
            border-radius: 5px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        @media (max-width: 768px) {
            .table th,
            .table td {
                padding: 8px;
            }

            .table img {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>

<body>
    <?php
    include 'navbar-admin.php';
    ?>

    <div class="container">
        <h2 style="color: black; border-bottom: 1px solid black !important; padding-bottom: 10px; margin-top: 10px; font-size: 26px;">Daftar Produk</h2>
        <a href="../add/addproduk.php" class="btn btn-success">Tambah Produk</a>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>ID Kebaya</th>
                        <th>Jenis</th>
                        <th>Nama Kebaya</th>
                        <th>Ukuran</th>
                        <th>Deskripsi</th>
                        <th>Stock</th>
                        <th>Harga</th> <!-- Kolom Harga -->
                        <th>Foto</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Menampilkan data produk dari database
                    if ($result->num_rows > 0) {
                        $no = 1; // Nomor urut produk
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['kebaya_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['jenis']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['ukuran']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['deskripsi']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['stock']) . "</td>";
                            echo "<td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
                            echo "<td><img src='../img/uploads/" . htmlspecialchars($row['foto']) . "' alt='Foto Kebaya' style='width: 100px; height: 100px;'></td>";
                            echo "<td>
                                <a href='../action/edit/editproduk.php?id=" . htmlspecialchars($row['kebaya_id']) . "' class='btn btn-warning'>Edit</a>
                                <a href='../action/delete/deleteproduk.php?id=" . htmlspecialchars($row['kebaya_id']) . "' class='btn btn-danger' onclick='return confirm(\"Anda yakin ingin menghapus produk ini?\")'>Hapus</a>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Tidak ada produk ditemukan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
