<?php
session_start(); // Pastikan session dimulai
include '../database/db.php'; // Koneksi ke database

// Cek apakah pengguna sudah login
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];

    // Ambil data reservasi dari database berdasarkan user_id
    $query = "SELECT r.kode_reservasi, 
                 u.username, 
                 r.tanggal_reservasi, 
                 r.tanggal_mulai, 
                 r.tanggal_selesai, 
                 r.status
          FROM reservations r
          JOIN users u ON r.user_id = u.user_id
          WHERE r.user_id = ?"; // Filter berdasarkan user_id

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id); // Bind parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        echo "<div class='alert alert-danger'>Terjadi kesalahan dalam mengambil data reservasi.</div>";
    }
} else {
    echo "<div class='alert alert-warning'>Anda belum login. Silakan <a href='login-user.php'>login</a>.</div>";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Reservasi</title>

    <!-- Link Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-mQ93u1c7UJg0p9WkLccmSx8s9PE1gzIkmKbpo4XfzPYP4/jdfQKh6xyNm7Z8gngA" crossorigin="anonymous">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            margin-bottom: 0 !important;
        }

        .table-container {
            max-width: 100%;
            margin: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th {
            background-color: #524A4E !important;
            color: #fff !important;
        }

        th,
        td {
            padding: 10px !important;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <?php include 'navbar-user.php'; ?>
    <!-- NAVBAR -->
    <h2 style="color: black; border-bottom: 1px solid black !important; padding-bottom: 10px; margin: 10px; text-align: left; font-size: 26px;">Daftar Reservasi</h2>

    <!-- Container untuk tabel -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Kode Reservasi</th>
                    <th>Tanggal Reservasi</th>
                    <th>Tanggal Mulai Sewa</th>
                    <th>Tanggal Selesai Sewa</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan data reservasi dari query
                $no = 1;

                if (isset($result) && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Format tanggal dd mmm yyyy
                        $tanggal_reservasi = date("m d Y", strtotime($row['tanggal_reservasi']));
                        $tanggal_mulai = date("m d Y", strtotime($row['tanggal_mulai']));
                        $tanggal_selesai = date("m d Y", strtotime($row['tanggal_selesai']));

                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['kode_reservasi']) . "</td>";
                        echo "<td>" . $tanggal_reservasi . "</td>";
                        echo "<td>" . $tanggal_mulai . "</td>";
                        echo "<td>" . $tanggal_selesai . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak ada data reservasi.</td></tr>"; // Jika tidak ada data
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQk0vnAjaZ0biI3jFyDi3kODNmf1Lf0u6RVwXgDtY5hxlOH2z8+rSkYmzZ9xCZaA" crossorigin="anonymous"></script>

</body>

</html>