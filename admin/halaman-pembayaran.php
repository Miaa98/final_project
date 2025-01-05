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

    // Ambil data pembayaran dari database
    $query = "SELECT r.kode_reservasi, 
                        u.username, 
                        r.tanggal_reservasi, 
                        r.tanggal_mulai, 
                        r.tanggal_selesai, 
                        r.status, 
                        MAX(p.total_harga) AS harga,
                        MAX(p.payment_date) AS tanggal_pembayaran
                    FROM reservations r
                    JOIN users u ON r.user_id = u.user_id
                    LEFT JOIN payments p ON r.kode_reservasi = p.kode_reservasi
                    GROUP BY r.kode_reservasi, u.username, r.tanggal_reservasi, r.tanggal_mulai, r.tanggal_selesai, r.status";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "<div class='alert alert-danger'>Terjadi kesalahan dalam mengambil data pembayaran.</div>";
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
    <title>Data Pembayaran</title>

    <!-- Link Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-mQ93u1c7UJg0p9WkLccmSx8s9PE1gzIkmKbpo4XfzPYP4/jdfQKh6xyNm7Z8gngA" crossorigin="anonymous">

    <!-- Link Bootstrap Icons versi 1.11.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Link ke file CSS terpisah -->
    <link href="styles.css" rel="stylesheet">
</head>

<style>
            .table th {
            background-color: #524A4E !important;
            color: #fff !important;
        }

</style>

<body>
    <!-- NAVBAR -->
    <?php include 'navbar-admin.php'; ?>
    <!-- NAVBAR -->
    <h2 style="color: black; border-bottom: 1px solid black !important; padding-bottom: 10px; margin: 10px; text-align: left; font-size: 26px;">Data Pembayaran</h2>

    <!-- Container untuk tabel -->
    <!-- Container untuk tabel -->
<div class="table-container" style="margin-left: 10px; margin-right: 10px;">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Kode Reservasi</th>
                <th>Tanggal Bayar</th> <!-- Kolom untuk tanggal pembayaran -->
                <th>Tanggal Reservasi</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Menampilkan data pembayaran dari query
            $no = 1;
            $kode_reservasi_tampil = []; // Array untuk menyimpan kode reservasi yang sudah ditampilkan

            if (isset($result) && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Jika kode reservasi belum ditampilkan
                    if (!in_array($row['kode_reservasi'], $kode_reservasi_tampil)) {
                        // Format tanggal dd mmm yyyy
                        $tanggal_reservasi = date("d M Y", strtotime($row['tanggal_reservasi']));
                        $tanggal_mulai = date("d M Y", strtotime($row['tanggal_mulai']));
                        $tanggal_selesai = date("d M Y", strtotime($row['tanggal_selesai']));
                        $tanggal_pembayaran = isset($row['tanggal_pembayaran']) ? date("d M Y", strtotime($row['tanggal_pembayaran'])) : "Belum Dibayar"; // Menampilkan tanggal pembayaran

                        // Ambil harga dari tabel payments (jika ada)
                        $harga = isset($row['harga']) ? "Rp " . number_format($row['harga'], 0, ',', '.') : "Belum Dibayar"; // Jika harga tidak ada, tampilkan "Belum Dibayar"

                        // Tampilkan baris tabel
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['kode_reservasi']) . "</td>";
                        echo "<td>" . $tanggal_pembayaran . "</td>";
                        echo "<td>" . $tanggal_reservasi . "</td>";
                        echo "<td>" . $tanggal_mulai . "</td>";
                        echo "<td>" . $tanggal_selesai . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td>" . $harga . "</td>";
                        echo "</tr>";

                        // Tandai kode reservasi sudah ditampilkan
                        $kode_reservasi_tampil[] = $row['kode_reservasi'];
                    }
                }
            } else {
                echo "<tr><td colspan='9'>Tidak ada data pembayaran.</td></tr>"; // Jika tidak ada data
            }
            ?>
        </tbody>
    </table>
</div>


    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQk0vnAjaZ0biI3jFyDi3kODNmf1Lf0u6RVwXgDtY5hxlOH2z8+rSkYmzZ9xCZaA" crossorigin="anonymous"></script>

</body>

</html>
