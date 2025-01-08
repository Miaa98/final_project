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

    // Ambil data reservasi dari database
    $query = "SELECT r.kode_reservasi, 
                MAX(u.username) AS username, 
                MAX(r.tanggal_reservasi) AS tanggal_reservasi, 
                MAX(r.tanggal_mulai) AS tanggal_mulai, 
                MAX(r.tanggal_selesai) AS tanggal_selesai, 
                MAX(r.status) AS status,
                MAX(u.phone) AS no_telepon,
                MAX(r.quantity) AS quantity
        FROM reservations r
        JOIN users u ON r.user_id = u.user_id
        GROUP BY r.kode_reservasi"; // Mengelompokkan berdasarkan kode_reservasi

    $result = mysqli_query($conn, $query);

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

    <!-- Link Bootstrap Icons versi 1.11.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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

        button {
            padding: 5px 10px;
            margin: 2px;
            cursor: pointer;
        }

        button:hover {
            background-color: #007bff;
            color: white;
        }

        .action-btn {
            font-size: 1.5em;
            padding: 8px;
        }

        .whatsapp-btn {
            color: #524A4E !important;
            border-color: #524A4E !important;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <?php include 'navbar-admin.php'; ?>
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan data reservasi dari query
                $no = 1;

                if (isset($result) && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Format tanggal
                        $tanggal_reservasi = date("d M Y", strtotime($row['tanggal_reservasi']));
                        $tanggal_mulai = date("d M Y", strtotime($row['tanggal_mulai']));
                        $tanggal_selesai = date("Y-m-d", strtotime($row['tanggal_selesai'])); // Format Y-m-d untuk perbandingan
                        $no_telepon = htmlspecialchars($row['no_telepon']);
                    
                        // Tanggal hari ini
                        $today = date("Y-m-d"); // Format Y-m-d untuk perbandingan
                    
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['kode_reservasi']) . "</td>";
                        echo "<td>" . $tanggal_reservasi . "</td>";
                        echo "<td>" . $tanggal_mulai . "</td>";
                        echo "<td>" . date("d M Y", strtotime($row['tanggal_selesai'])) . "</td>"; // Menampilkan dalam format d M Y
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td>";
                    
                        // Tombol View selalu ada
                        echo "<button class='btn btn-info action-btn' onclick='lihatDetail(\"" . htmlspecialchars($row['kode_reservasi']) . "\")'>
                                <i class='bi bi-eye'></i>
                              </button>";
                    
                        // Jika status 'paid', tampilkan tombol ceklis
                        if (trim(strtolower($row['status'])) === 'paid') {
                            echo " <button class='btn btn-success action-btn' id='checkBtn_" . htmlspecialchars($row['kode_reservasi']) . "' onclick='updateStatus(\"" . htmlspecialchars($row['kode_reservasi']) . "\")'>
                                    <i class='bi bi-check-lg'></i>
                                  </button>";
                        }
                    
                       // Jika tanggal selesai <= hari ini dan status belum 'completed', tampilkan tombol WhatsApp
                       if (strtotime($tanggal_selesai) <= strtotime($today) && trim(strtolower($row['status'])) !== 'completed') {
                        echo " <a href='https://wa.me/" . $no_telepon . "?text=Halo,%20barang%20yang%20Anda%20sewa%20sudah%20harus%20dikembalikan.%20Harap%20menghubungi%20kami%20untuk%20pengembalian.%20Terima%20kasih.' target='_blank' class='btn btn-light action-btn whatsapp-btn'>
                                <i class='bi bi-whatsapp'></i>
                              </a>";
                        }
                        
                        echo "</td>";
                        echo "</tr>";
                    }                    
                } else {
                    echo "<tr><td colspan='8'>Tidak ada data reservasi.</td></tr>"; // Jika tidak ada data
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Fungsi untuk melihat detail reservasi berdasarkan kode reservasi
        function lihatDetail(kodeReservasi) {
            console.log("Kode Reservasi:", kodeReservasi); // Debugging
            if (kodeReservasi) {
                // Langsung arahkan pengguna ke halaman view_reservasi.php dengan query kode_reservasi
                window.location.href = '../action/view/view-reservasi.php?kode_reservasi=' + encodeURIComponent(kodeReservasi);
            } else {
                console.error("Kode reservasi tidak ditemukan.");
            }
        }

        // Fungsi untuk mengupdate status menjadi 'completed' saat tombol ceklis diklik
        // Fungsi untuk mengupdate status menjadi 'completed' saat tombol ceklis diklik
function updateStatus(kodeReservasi) {
    console.log("Mengupdate status untuk kode reservasi: " + kodeReservasi);

    fetch('update-status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'kode_reservasi=' + encodeURIComponent(kodeReservasi) // Kirim kode_reservasi
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(data => {
        console.log('Response:', data); // Debugging response
        if (data === 'success') {
            // Menonaktifkan tombol setelah status berhasil diubah
            const checkBtn = document.getElementById('checkBtn_' + kodeReservasi);
            checkBtn.disabled = true; // Disable tombol setelah di-klik
            checkBtn.classList.remove('btn-success'); // Hapus class btn-success
            checkBtn.classList.add('btn-secondary'); // Tambahkan class btn-secondary

            // Menampilkan pesan sukses
            alert('Status berhasil diubah menjadi completed.');
            
            // Memuat ulang halaman setelah status diubah
            location.reload();
        } else {
            alert('Gagal mengubah status. Respons server: ' + data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengubah status.');
    });
}


    </script>

    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQk0vnAjaZ0biI3jFyDi3kODNmf1Lf0u6RVwXgDtY5hxlOH2z8+rSkYmzZ9xCZaA" crossorigin="anonymous"></script>

</body>
</html>
