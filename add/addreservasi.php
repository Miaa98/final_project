<?php
session_start(); // Mulai sesi
 include '../database/db.php'; ?>


<?php
// Ambil data dari URL query string
$id = isset($_GET['id']) ? $_GET['id'] : '';
$nama = isset($_GET['nama']) ? $_GET['nama'] : '';
$harga = isset($_GET['harga']) ? $_GET['harga'] : '';

$user_id = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : '';


// Jika data tidak ada, redirect ke halaman yang tepat (misalnya ke halaman produk)
if (!$id || !$nama || !$harga) {
    header("Location: dashboard-user.php");
    exit();
}

$sql = "INSERT INTO charts (id_produk, user_id, tanggal_mulai, tanggal_selesai, durasi, total_harga, tanggal_reservasi) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iississ", $id_produk, $user_id, $tanggal_mulai, $tanggal_selesai, $durasi, $total_harga, $tanggal_reservasi);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Reservasi</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            color: #524A4E;
            padding: 20px 0;
            text-align: center;
        }

        h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        h2 {
            margin: 0;
        }

        main {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2,
        h3 {
            color: #524A4E;
            text-align: center;
        }

        .product-info {
            margin-bottom: 0;
            padding: 10px;
            background-color: #ecf5ff;
            border-radius: 8px;
        }

        .product-info p {
            font-size: 1.2rem;
            margin: 10px 0;
        }

        form {
            display: grid;
            gap: 15px;
        }

        label {
            font-size: 1.1rem;
            color: #555;
        }

        input[type="date"],
        input[type="number"],
        button {
            padding: 10px;
            border: 2px solid #524A4E;
            border-radius: 4px;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            background-color: #524A4E;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #524A4E;
        }

        footer {
            background-color: #524A4E;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        .harga {
            font-weight: bold;
            font-size: 1.2rem;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        button {
            padding: 10px;
            border: 2px solid #524A4E;
            border-radius: 4px;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>

<body>

    <main>
        <section>
            <header>
                <h1>Form Reservasi</h1>
            </header>

            <!-- Menampilkan user_id pada halaman -->
<div class="container">
    <h3>User ID yang sedang login: <?php echo htmlspecialchars($user_id); ?></h3>
</div>


            <div class="product-info">
                <h2>Informasi Produk</h2>
                <p><strong>Nama Kebaya:</strong> <?php echo htmlspecialchars($nama); ?></p>
                <p><strong>Harga:</strong> <span class="harga">Rp <?php echo number_format($harga, 0, ',', '.'); ?></span></p>
            </div>


            <h3>Isi Form Reservasi</h3>
            <form action="../user/reservasi-user.php" method="POST">
    <!-- Data produk yang dikirim secara hidden -->
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>" />
    <input type="hidden" name="nama" value="<?php echo htmlspecialchars($nama); ?>" />
    <input type="hidden" name="harga" value="<?php echo htmlspecialchars($harga); ?>" />
    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" />

    <!-- Tanggal Mulai Sewa -->
    <label for="tanggal_mulai">Tanggal Mulai Sewa:</label>
    <input type="date" name="tanggal_mulai" id="tanggal_mulai" required />

    <!-- Tanggal Selesai Sewa -->
    <label for="tanggal_selesai">Tanggal Selesai Sewa:</label>
    <input type="date" name="tanggal_selesai" id="tanggal_selesai" required />

    <!-- Durasi Sewa -->
    <label for="durasi">Durasi Sewa (hari):</label>
    <input type="number" name="durasi" id="durasi" min="1" readonly />

    <!-- Quantity (Jumlah Produk yang Dipesan) -->
    <label for="quantity">Jumlah Produk (Qty):</label>
    <input type="number" name="quantity" id="quantity" min="1" required />

    <!-- Total Harga -->
    <label for="total_harga">Total Harga:</label>
    <input type="text" name="total_harga" id="total_harga" readonly class="harga" value="Rp 0" />

    <!-- Tanggal Reservasi (otomatis terisi dengan tanggal hari ini) -->
    <label for="tanggal_reservasi">Tanggal Reservasi:</label>
    <input type="date" name="tanggal_reservasi" id="tanggal_reservasi" readonly />

    <button type="submit">Kirim Reservasi</button>
</form>
        </section>
    </main>

    <script>
    // Ambil elemen input yang relevan
    const tanggalMulai = document.getElementById('tanggal_mulai');
    const tanggalSelesai = document.getElementById('tanggal_selesai');
    const durasi = document.getElementById('durasi');
    const totalHarga = document.getElementById('total_harga');
    const quantity = document.getElementById('quantity');
    const hargaProduk = <?php echo $harga; ?>; // Mengambil harga produk dari PHP
    const tanggalReservasi = document.getElementById('tanggal_reservasi');

    // Fungsi untuk menghitung durasi sewa dan total harga
    function hitungDurasiDanHarga() {
        const mulai = new Date(tanggalMulai.value);
        const selesai = new Date(tanggalSelesai.value);

        // Hitung selisih hari
        const diffTime = selesai - mulai;
        const diffDays = diffTime / (1000 * 3600 * 24);

        if (!isNaN(diffDays) && diffDays > 0) {
            durasi.value = diffDays; // Durasi dalam hari, jangan ditambah 1

            // Menghitung total harga berdasarkan durasi dan quantity
            let hargaTotal = hargaProduk * diffDays * quantity.value;
            // Format total harga dalam angka tanpa simbol 'Rp'
            totalHarga.value = hargaTotal.toLocaleString('id-ID'); 
        } else {
            durasi.value = 1; // Default durasi 1 hari jika ada kesalahan
            totalHarga.value = (hargaProduk * quantity.value).toLocaleString('id-ID'); // Total harga 1 hari
        }
    }

    // Set Tanggal Reservasi otomatis berdasarkan tanggal hari ini
    const today = new Date().toISOString().split('T')[0];
    tanggalReservasi.value = today;

    // Event listeners untuk menghitung durasi dan total harga saat tanggal mulai atau selesai diubah
    tanggalMulai.addEventListener('change', hitungDurasiDanHarga);
    tanggalSelesai.addEventListener('change', hitungDurasiDanHarga);
    quantity.addEventListener('input', hitungDurasiDanHarga);
</script>



</body>

</html>