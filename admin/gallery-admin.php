<?php
session_start(); // Pastikan session dimulai
include '../database/db.php';  // Pastikan koneksi database sudah benar

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

// Query untuk mengambil semua data produk
$query = "SELECT * FROM gallerys";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Gallery Kebaya Hasogia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            margin-top: 10px;
            padding-right: 10px !important;
            padding-left: 10px !important;
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: auto !important;
        }

        .table {
            background-color: #fff;
            margin-top: 10px;
            max-width: 100% !important;
        }

        .table th {
            background-color: #524A4E !important;
            color: #fff !important;
        }

        .table th, .table td {
            text-align: left;
        }

        .table img {
            height: auto;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php include 'navbar-admin.php'; ?>
    <div class="container">
        <h2 style="color: black; border-bottom: 1px solid black; padding-bottom: 10px; text-align: left; font-size: 26px;">Gallery Kebaya Hasogia</h2>

        <a href="../add/addgallery.php" class="btn btn-success mb-10px">Tambah Foto</a>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Kebaya</th>
                    <th>Nama Kebaya</th>
                    <th>Model</th>
                    <th>Deskripsi</th>
                    <th>Foto</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mengecek apakah ada data
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $row['kebaya_id'] . "</td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td>" . $row['model'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td><img src='../img/uploads/" . $row['image'] . "' alt='Foto Kebaya' width='100'></td>";
                        echo "<td>
                                <a href='../action/edit/editgallery.php?id=" . $row['kebaya_id'] . "' class='btn btn-warning'>Edit</a>
                                <a href='../action/delete/deletegallery.php?id=" . $row['kebaya_id'] . "' class='btn btn-danger' onclick='return confirm(\"Anda yakin ingin menghapus foto ini?\")'>Hapus</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak ada produk kebaya.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php $conn->close(); ?>
