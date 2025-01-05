<?php
session_start(); // Pastikan session dimulai
include '../database/db.php';

/// Cek apakah pengguna sudah login
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

// Ambil nilai pencarian dari input
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Query untuk mendapatkan data dari tabel users dengan filter pencarian berdasarkan username
$sql = "SELECT user_id, foto_profil, username, email, phone, address, role FROM users WHERE username LIKE '%$search%'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User</title>

    <!-- Link Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-mQ93u1c7UJg0p9WkLccmSx8s9PE1gzIkmKbpo4XfzPYP4/jdfQKh6xyNm7Z8gngA" crossorigin="anonymous">

    <!-- Link Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            text-align: left;
            font-size: 26px !important;
            margin: 10px 10px 10px 10px !important;
        }

        .table-container {
            width: 100%;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background-color: #524A4E !important;
            color: #fff !important;
        }

        th,
        td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }

        .action-btn {
            font-size: 1.5em;
            padding: 2px;
            margin: 2px 2px !important;
            /* Memberikan jarak antar ikon */
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <?php include 'navbar-admin.php'; ?>
    <!-- NAVBAR -->

    <h2 style="color: black; border-bottom: 1px solid black !important; padding-bottom: 10px;">Daftar Pengguna</h2>

    <!-- Form pencarian -->
    <form method="GET" action="" style="margin: 10px 10px 10px 10px;">
        <input type="text" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" placeholder="Cari berdasarkan username..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
    </form>

    <!-- Tombol Tambah Akun -->
    <div style="margin: 10px 10px 0px 10px; text-align: left;">
        <button class="btn btn-success" onclick="tambahAkun()">
            <i class="bi bi-plus"></i> Tambah Akun
        </button>
    </div>

    <!-- Container untuk tabel -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto Profil</th>
                    <th>Role</th>
                    <th>ID</th> <!-- Tambahkan kolom User ID -->
                    <th>Username</th>
                    <th>Email</th>
                    <th>No. telp</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $no = 1; // Nomor urut
                    while ($row = $result->fetch_assoc()) {
                        // Cek data dan tampilkan default jika null
                        $foto_profil = !empty($row['foto_profil']) ? '../img/uploads/' . htmlspecialchars($row['foto_profil']) : 'https://via.placeholder.com/50';
                        $username = isset($row['username']) ? htmlspecialchars($row['username']) : 'Tidak tersedia';
                        $email = isset($row['email']) ? htmlspecialchars($row['email']) : 'Tidak tersedia';
                        $phone = isset($row['phone']) ? htmlspecialchars($row['phone']) : 'Tidak tersedia';
                        $address = isset($row['address']) ? htmlspecialchars($row['address']) : 'Tidak tersedia';
                        $role = isset($row['role']) ? htmlspecialchars($row['role']) : 'Tidak tersedia';
                        $user_id = isset($row['user_id']) ? htmlspecialchars($row['user_id']) : 'Tidak tersedia'; // Tambahkan user_id

                        echo "<tr>
                            <td>" . $no++ . "</td>
                            <td><img src='" . $foto_profil . "' alt='Foto Profil'></td>
                            <td>" . $role . "</td>
                            <td>" . $user_id . "</td> <!-- Tambahkan User ID di sini -->
                            <td>" . $username . "</td>
                            <td>" . $email . "</td>
                            <td>" . $phone . "</td>
                            <td>" . $address . "</td>
                            <td>
                                <a href='../action/view/view-daftarsewa.php?user_id=" . $row['user_id'] . "' class='btn btn-primary action-btn'>
                                    <i class='bi bi-box'></i>
                                </a>
                                <button class='btn btn-danger action-btn' onclick='hapusUser(" . $row['user_id'] . ")'>
                                    <i class='bi bi-trash'></i>
                                </button>
                                <button class='btn btn-warning action-btn' onclick='editProfil(" . $row['user_id'] . ")'>
                                    <i class='bi bi-pencil'></i>
                                </button>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Tidak ada data pengguna yang ditemukan.</td></tr>"; // Perbarui colspan menjadi 9
                }

                $conn->close();
                ?>
            </tbody>

        </table>
    </div>

    <script>
        function editProfil(userId) {
            window.location.href = "../action/edit/editprofile.php?id=" + userId;
        }

        function hapusUser(userId) {
            if (confirm("Apakah Anda yakin ingin menghapus user dengan ID: " + userId + "?")) {
                // Mengarahkan ke file delete_user.php dengan ID pengguna
                window.location.href = "../action/delete/deleteuser.php?id=" + userId;
            }
        }

        function tambahAkun() {
            // Arahkan pengguna ke halaman register-admin.php
            window.location.href = "../add/adduser.php";
        }
    </script>

    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQk0vnAjaZ0biI3jFyDi3kODNmf1Lf0u6RVwXgDtY5hxlOH2z8+rSkYmzZ9xCZaA" crossorigin="anonymous"></script>

</body>

</html>
