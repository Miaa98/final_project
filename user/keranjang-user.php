<?php
session_start();  // Memulai sesi untuk mendapatkan data user_id
include '../database/db.php';

// Pastikan koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil user_id dari session
$user_id = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : '';

// Pastikan user_id ada sebelum melanjutkan
if (!$user_id) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href='login-user.php';</script>";
    exit();
}

// Query untuk mengambil data chart berdasarkan user_id
$sql = "
    SELECT c.keranjang_id, p.product_id, p.nama, p.harga, c.tanggal_mulai, c.tanggal_selesai, c.durasi, c.total_harga, c.tanggal_reservasi
    FROM charts c
    JOIN products p ON c.id_produk = p.product_id
    WHERE c.user_id = ?";  // Menambahkan filter berdasarkan user_id

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);  // Binding user_id ke parameter query
$stmt->execute();
$result = $stmt->get_result();  // Mendapatkan hasil query

// Cek apakah query berhasil dijalankan
if (!$result) {
    die("Query gagal: " . $conn->error);  // Menampilkan error query jika gagal
}

// Inisialisasi variabel untuk menghitung total harga
$totalHargaSemua = 0;

// Periksa apakah ada parameter untuk menghapus produk
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Query untuk menghapus chart berdasarkan ID
    $delete_sql = "DELETE FROM charts WHERE keranjang_id = ? AND user_id = ?";
    $stmt_delete = $conn->prepare($delete_sql);
    $stmt_delete->bind_param("ii", $delete_id, $user_id);

    if ($stmt_delete->execute()) {
        echo "<script>alert('Produk berhasil dihapus!'); window.location.href='keranjang-user.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus produk.');</script>";
    }
}
?>

<?php
if (isset($_POST['checkout'])) {
    // Generate kode_reservasi unik
    $kode_reservasi = 'R' . date('YmdHis') . $user_id;

    // Query untuk memindahkan data dari charts ke reservations dengan kode_reservasi
    $insert_sql = "
        INSERT INTO reservations (user_id, id_produk, tanggal_mulai, tanggal_selesai, durasi, total_harga, tanggal_reservasi, kode_reservasi)
        SELECT user_id, id_produk, tanggal_mulai, tanggal_selesai, durasi, total_harga, tanggal_reservasi, ? 
        FROM charts 
        WHERE user_id = ?";

    $stmt_insert = $conn->prepare($insert_sql);
    $stmt_insert->bind_param("si", $kode_reservasi, $user_id);  // Binding kode_reservasi dan user_id

    if ($stmt_insert->execute()) {
        // Hapus data dari charts setelah dipindahkan ke reservations
        $delete_sql = "DELETE FROM charts WHERE user_id = ?";
        $stmt_delete = $conn->prepare($delete_sql);
        $stmt_delete->bind_param("i", $user_id);

        if ($stmt_delete->execute()) {
            echo "<script>alert('Checkout berhasil! Kode Reservasi Anda: $kode_reservasi'); window.location.href='dashboard-user.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data dari keranjang.');</script>";
        }
    } else {
        echo "<script>alert('Gagal melakukan checkout.');</script>";
    }
}
?>


<!-- Tampilan HTML -->
<!DOCTYPE html> 
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Sewa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
    /* CSS untuk memastikan ikon dan teks berada berdekatan */
    .btn {
        margin-right: 10px !important; /* Memberikan jarak 10px */
    }

    .btn {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-primary,
    .btn-success {
        font-size: 16px;
        padding: 10px 20px;
    }

    .d-flex {
        margin-left: 3px !important;
        justify-content: left;
        width: 100%;
    }

    .btn+.btn {
        margin-left: 5px;
    }

    h1 {
        text-align: center;
        margin-bottom: 10px !important;
    }

    .harga-total {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .harga-total span.rp {
        margin-right: 8px;
    }
</style>

</head>

<body>

    <div class="container mt-2">
        <h1>Keranjang Sewa</h1>

        <!-- Keranjang Table -->
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Durasi (Hari)</th>
                    <th>Total Harga</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Hitung total harga berdasarkan harga produk dan durasi
        $total_harga = $row['harga'] * $row['durasi'];
        $totalHargaSemua += $total_harga; // Tambahkan ke total harga semua produk

        echo "<tr>
            <td>" . htmlspecialchars($row['nama']) . "</td>
            <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
            <td>" . htmlspecialchars($row['tanggal_mulai']) . "</td>
            <td>" . htmlspecialchars($row['tanggal_selesai']) . "</td>
            <td>" . htmlspecialchars($row['durasi']) . "</td>
            <td>Rp " . number_format($total_harga, 0, ',', '.') . "</td> <!-- Menampilkan total harga yang sudah dihitung -->
            <td>
                <a href='?delete_id=" . $row['keranjang_id'] . "' class='btn btn-danger btn-sm'>
                    <i class='fas fa-trash'></i>
                </a>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='7'>Tidak ada data chart.</td></tr>";
}
?>

            </tbody>
        </table>

        <!-- Footer dengan Total Harga -->
        <table class="table table-bordered">
            <tfoot>
                <tr>
                    <td colspan="6" class="text-end"><strong>Total Harga Semua Produk:</strong></td>
                    <td class="harga-total">
                        <span class="rp">Rp</span>
                        <span><strong><?php echo number_format($totalHargaSemua, 0, ',', '.'); ?></strong></span>
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Tombol untuk kembali ke dashboard dan menuju pembayaran -->
        <div class="d-flex">
            <a href="dashboard-user.php" class="btn btn-primary">
                <i class="fas fa-home"></i>
            </a>

            <form method="post">
                <button type="submit" name="checkout" class="btn btn-success">Checkout</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>
