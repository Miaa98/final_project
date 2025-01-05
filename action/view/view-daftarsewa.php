<?php
session_start();
include '../../database/db.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-warning'>Anda belum login. Silakan <a href='login-user.php'>login</a>.</div>";
    exit;
}

// Dapatkan user_id dari parameter URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Query untuk mendapatkan daftar sewa pengguna beserta username
    $query = "SELECT r.kode_reservasi, p.nama, r.tanggal_reservasi, r.tanggal_mulai, r.tanggal_selesai, r.status, u.user_id, u.username
              FROM reservations r
              JOIN products p ON r.id_produk = p.product_id
              JOIN users u ON r.user_id = u.user_id
              WHERE r.user_id = ?";

    // Menyiapkan statement
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $user_id); // Bind user_id ke query
        $stmt->execute();
        $result = $stmt->get_result();

        // Ambil data pengguna (user_id dan username)
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $username = $row['username'];
        } else {
            $username = "Tidak ditemukan";
        }

        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Daftar Sewa</title>

            <!-- Link Bootstrap 5.3.3 CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <!-- Link Bootstrap Icons -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
            <style>
                /* CSS Global */
                body {
                    font-family: Arial, sans-serif;
                    margin: 10px;
                }

                .container {
                    max-width: 100%;
                    width: auto !important;
                    align-items: center;
                    padding: 0px !important;
                }

                .info {
                    margin-bottom: 10px;
                    padding: 10px;
                    border: 1px solid #ddd;
                    background-color: #f9f9f9;
                }

                h2 {
                    margin: 10px 10px;
                    text-align: center;
                }

                h3 {
                    margin: 0px;
                }

                table {
                    max-width: 100% !important;
                    border-collapse: collapse;
                    margin-top: 10px !important;
                }

                table th {
                    background-color: #524A4E !important;
                    color: #fff !important;
                }

                th, td {
                    padding: 10px;
                    text-align: left;
                }

                th {
                    background-color: #f4f4f4;
                }

                .alert {
                    margin-top: 10px;
                }

                .btn-container {
                    margin-bottom: 20px;
                }

                .btn-custom {
                    font-size: 1.1rem;
                    padding: 8px 16px;
                    margin-right: 10px;
                }
            </style>
        </head>
        <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <h2>Daftar Sewa untuk Pengguna ID: <?php echo htmlspecialchars($user_id); ?></h2>

        <div class="container">
            <!-- Bagian Info Pengguna -->
            <div class="info">
                <strong>User    ID:</strong> <?php echo htmlspecialchars($user_id); ?> <br>
                <strong>Username:</strong> <?php echo htmlspecialchars($username); ?>
            </div>

            <?php
            // Tampilkan tabel jika ada data
            if ($result->num_rows > 0) {
                echo "<table class='table'>
                        <thead>
                            <tr>
                                <th>Kode Reservasi</th>
                                <th>Nama Produk</th>
                                <th>Tanggal Reservasi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>";
                do {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['kode_reservasi']) . "</td>
                            <td>" . htmlspecialchars($row['nama']) . "</td>
                            <td>" . htmlspecialchars($row['tanggal_reservasi']) . "</td>
                            <td>" . htmlspecialchars($row['tanggal_mulai']) . "</td>
                            <td>" . htmlspecialchars($row['tanggal_selesai']) . "</td>
                            <td>" . htmlspecialchars($row['status']) . "</td>
                          </tr>";
                } while ($row = $result->fetch_assoc());
                echo "</tbody></table>";
            } else {
                echo "<div class='alert alert-info'>Tidak ada data sewa untuk pengguna ini.</div>";
            }
            ?>

            <!-- Tombol Kembali dengan Ikon -->
            <div class="btn-container">
                <a href="../../admin/listuser-admin.php" class="btn btn-custom btn-primary">
                    <i class="bi bi-arrow-return-left"></i>
                </a>
            </div>

        </div>

        </body>
        </html>
        <?php
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan dalam query.</div>";
    }
} else {
    echo "<div class='alert alert-warning'>User  ID tidak ditemukan.</div>";
}

$conn->close();
?>