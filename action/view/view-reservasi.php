<?php
include '../../database/db.php';

// Ambil kode_reservasi dari URL jika ada
$kode_reservasi = isset($_GET['kode_reservasi']) ? $_GET['kode_reservasi'] : '';

// Jika kode_reservasi ada, maka kita ambil data reservasi berdasarkan kode tersebut
if (!empty($kode_reservasi)) {
    $query = "SELECT r.kode_reservasi, u.username, r.tanggal_reservasi, r.tanggal_mulai, r.tanggal_selesai, r.status
                FROM reservations r
                JOIN users u ON r.user_id = u.user_id
                WHERE r.kode_reservasi = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $kode_reservasi);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Ambil hasilnya
        $row = $result->fetch_assoc();
    } else {
        $error_message = "Reservasi dengan kode tersebut tidak ditemukan.";
    }

    $stmt->close();
} else {
    $error_message = "Kode reservasi tidak ditemukan. Silakan periksa URL.";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Reservasi</title>

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

        th,
        td {
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

    <h2>Detail Reservasi</h2>

    <div class="container">
        <div class="info">
            <?php
            // Menampilkan data jika ada
            if (isset($row)) {
                echo "<strong>Kode Reservasi:</strong> " . htmlspecialchars($row['kode_reservasi'] ?? '') . "<br>";
                echo "<strong>Nama Penyewa:</strong> " . htmlspecialchars($row['username'] ?? '') . "<br>";
                echo "<strong>Status:</strong> " . htmlspecialchars($row['status'] ?? '') . "<br>";
            } else {
                // Jika tidak ditemukan data atau kode_reservasi kosong
                echo "<div class='alert alert-warning'>" . ($error_message ?? 'Data tidak ditemukan.') . "</div>";
            }
            ?>
        </div>

        <!-- Tabel Produk yang Dipesan -->
        <h3>Produk yang Dipesan</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk ID</th>
                    <th>Nama Produk</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Durasi (Hari)</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Inisialisasi total harga
                $total_harga = 0;

                // Query untuk mengambil data produk terkait reservasi berdasarkan kode_reservasi
                if (isset($row)) {
                    $query_produk = "SELECT p.product_id, p.nama, p.harga, r.tanggal_mulai, r.tanggal_selesai, DATEDIFF(r.tanggal_selesai, r.tanggal_mulai) AS durasi 
                             FROM reservations r 
                             JOIN products p ON r.id_produk = p.product_id 
                             WHERE r.kode_reservasi = ?";
                    $stmt_produk = $conn->prepare($query_produk);
                    $stmt_produk->bind_param("s", $kode_reservasi);
                    $stmt_produk->execute();
                    $result_produk = $stmt_produk->get_result();

                    $no = 1;
                    if ($result_produk->num_rows > 0) {
                        while ($produk = $result_produk->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($produk['product_id'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($produk['nama'] ?? '') . "</td>";
                            echo "<td>" . date("d M Y", strtotime($produk['tanggal_mulai'])) . "</td>";
                            echo "<td>" . date("d M Y", strtotime($produk['tanggal_selesai'])) . "</td>";
                            echo "<td>" . htmlspecialchars($produk['durasi'] ?? '') . " hari</td>";
                            echo "<td>Rp " . number_format($produk['harga'], 0, ',', '.') . "</td>";
                            echo "</tr>";

                            // Tambahkan harga ke total
                            $total_harga += $produk['harga'];
                        }
                    } else {
                        echo "<tr><td colspan='7'>Tidak ada data produk terkait reservasi ini.</td></tr>";
                    }

                    $stmt_produk->close();
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align: right;"><strong>Total Harga :</strong></td>
                    <td><strong>Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></strong></td>
                </tr>
            </tfoot>
        </table>

        <!-- Modal untuk Pembayaran -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Pembayaran Reservasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Kode Reservasi:</strong> <span id="modalKodeReservasi"></span></p>
                        <p><strong>Nama Penyewa:</strong> <span id="modalUsername"></span></p>
                        <p><strong>Tanggal Mulai:</strong> <span id="modalTanggalMulai"></span></p>
                        <p><strong>Tanggal Selesai:</strong> <span id="modalTanggalSelesai"></span></p>
                        <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                        <p><strong>Produk yang Disewa:</strong></p>
                        <ul id="modalProdukList"></ul>
                        <p><strong>Total Harga:</strong> <span id="modalTotalHarga"></span></p>
                        <form id="paymentForm" action="../../admin/pembayaran-admin.php" method="POST">
                            <input type="hidden" name="kode_reservasi" id="hiddenKodeReservasi" value="<?php echo $row['kode_reservasi']; ?>">
                            <input type="hidden" name="total_harga" id="hiddenTotalHarga" value="<?php echo $total_harga; ?>">
                            <div class="mb-3">
                                <label for="paymentMethod" class="form-label">Metode Pembayaran</label>
                                <select class="form-select" id="paymentMethod" name="payment_method" required>
                                    <option value="" disabled selected>Pilih metode pembayaran</option>
                                    <option value="transfer_bank">Transfer Bank</option>
                                    <option value="qris">Qris</option>
                                    <option value="cash">Cash</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Bayar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Home dan Dolar di bawah tabel -->
        <div class="container btn-container">
            <a href="../../admin/reservasi-admin.php" class="btn btn-primary btn-custom">
                <i class="bi bi-house-door-fill"></i>
            </a>
            <button class="btn btn-success btn-custom" id="dollarBtn">
                <i class="bi bi-currency-dollar"></i>
            </button>
        </div>
    </div>

    <script>
    document.getElementById('dollarBtn').addEventListener('click', function() {
        // Ambil data dari halaman
        const kodeReservasi = "<?php echo htmlspecialchars($row['kode_reservasi'] ?? ''); ?>";
        const username = "<?php echo htmlspecialchars($row['username'] ?? ''); ?>";
        const tanggalMulai = "<?php echo isset($row['tanggal_mulai']) ? date('d M Y', strtotime($row['tanggal_mulai'])) : ''; ?>";
        const tanggalSelesai = "<?php echo isset($row['tanggal_selesai']) ? date('d M Y', strtotime($row['tanggal_selesai'])) : ''; ?>";
        const status = "<?php echo htmlspecialchars($row['status'] ?? ''); ?>";
        const totalHarga = "<?php echo number_format($total_harga, 0, ',', '.'); ?>";

        // Ambil produk yang disewa dari tabel
        const produkRows = Array.from(document.querySelectorAll("table tbody tr")).map(row => {
            const cells = row.querySelectorAll("td");
            return {
                namaProduk: cells[2]?.textContent || '',
                durasi: cells[5]?.textContent || '',
                harga: cells[6]?.textContent || ''
            };
        });

        // Jika status 'paid', arahkan ke halaman pembayaran
        if (status.toLowerCase() === 'paid') {
            window.location.href = 'view-detailpembayaran.php?kode_reservasi=' + kodeReservasi;
            return; // Stop the function execution here
        } else  if (status.toLowerCase() === 'completed') {
            window.location.href = 'view-detailpembayaran.php?kode_reservasi=' + kodeReservasi;
            return; // Stop the function execution here
        }

        // Isi data ke modal untuk status selain 'paid'
        document.getElementById('modalKodeReservasi').textContent = kodeReservasi;
        document.getElementById('modalTotalHarga').textContent = "Rp " + totalHarga;
        document.getElementById('modalUsername').textContent = username;
        document.getElementById('modalTanggalMulai').textContent = tanggalMulai;
        document.getElementById('modalTanggalSelesai').textContent = tanggalSelesai;
        document.getElementById('modalStatus').textContent = status;

        // Buat daftar produk di modal
        const produkList = document.getElementById('modalProdukList');
        produkList.innerHTML = ''; // Kosongkan terlebih dahulu
        produkRows.forEach((produk, index) => {
            const listItem = document.createElement('li');
            listItem.textContent = `${index + 1}. ${produk.namaProduk} (${produk.durasi}): ${produk.harga}`;
            produkList.appendChild(listItem);
        });

        // Tampilkan modal untuk pembayaran
        const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
        paymentModal.show();
    });

    // Tangani submit pembayaran dengan fetch
    document.getElementById('paymentForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form reload

        // Get data from the form and modal
        const kodeReservasi = document.getElementById('hiddenKodeReservasi').value;
        const paymentMethod = document.getElementById('paymentMethod').value;
        const totalHarga = document.getElementById('hiddenTotalHarga').value;
        const status = 'success'; // Payment status

        // Send the payment data to the server using Fetch API
        fetch('../../admin/pembayaran-admin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    kode_reservasi: document.getElementById('hiddenKodeReservasi').value,
                    payment_method: document.getElementById('paymentMethod').value,
                    total_harga: document.getElementById('hiddenTotalHarga').value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message); // Show success message
                    window.location.href = 'view-detailpembayaran.php?kode_reservasi=' + kodeReservasi;
                } else {
                    alert(data.message); // Show error message
                }
            })
            .catch(error => {
                console.error('Error:', error); // Handle error
                alert("Terjadi kesalahan saat memproses pembayaran.");
            });
    });
</script>

</body>

</html>