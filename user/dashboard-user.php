<?php
session_start(); // Mulai sesi
include '../database/db.php'; // Sertakan file koneksi database
// Cek apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login-user.php"); // Arahkan ke halaman login jika belum login
    exit();
}

//ambil user_id dari session
$user_id = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : '';

// Fetch kebaya data from the database
$query = "SELECT * FROM products WHERE jenis = 'kebaya'"; // Adjust the query as needed
$result = mysqli_query($conn, $query); // Execute the query

// Fetch data untuk produk Jas
$query_jas = "SELECT * FROM products WHERE jenis = 'jas'";
$result_jas = mysqli_query($conn, $query_jas);

// Fetch data untuk produk Aksesoris
$query_aksesoris = "SELECT * FROM products WHERE jenis = 'aksesoris'";
$result_aksesoris = mysqli_query($conn, $query_aksesoris);

// Check if the query was successful
if (!$result) {
    // Display error message
    die("Query Failed: " . mysqli_error($conn)); // Output the error message
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <!-- Link Bootstrap 5.3.3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-..." crossorigin="anonymous">
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Great+Vibes&family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet">
    <!-- Feather Icon -->
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding-top: 60px;
            margin: 0 20px;
        }

        .welcome-message {
            background-color: #f0f8ff;
            border: 1px solid #6a11cb;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin: 20px auto;
            width: 80%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .welcome-message h1 {
            color: #6a11cb;
        }

        .welcome-message p {
            color: #333;
        }

        .order-summary {
            position: absolute;
            /* Menggunakan posisi absolut */
            top: 60px;
            /* Jarak dari atas (di bawah navbar) */
            right: 20px;
            /* Jarak dari kanan */
            padding: 20px;
            /* Tambahkan padding di dalam keranjang */
            background-color: #fff;
            /* Warna latar belakang putih */
            border-radius: 8px;
            /* Sudut melengkung */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* Bayangan untuk efek kedalaman */
            display: none;
            /* Sembunyikan secara default */
            z-index: 100;
            /* Pastikan di atas elemen lain */
        }

        .order-summary h2 {
            margin-bottom: 20px;
            /* Jarak bawah untuk judul */
        }

        #order-list {
            list-style-type: none;
            /* Hapus bullet points */
            padding: 0;
            /* Hapus padding */
            margin-bottom: 20px;
            /* Jarak bawah untuk daftar */
        }

        #order-list li {
            display: flex;
            /* Menggunakan flexbox untuk menyelaraskan item */
            justify-content: space-between;
            /* Menyelaraskan item di antara */
            align-items: center;
            /* Menyelaraskan item secara vertikal */
            padding: 10px;
            /* Padding untuk item */
            border-bottom: 1px solid #ddd;
            /* Garis bawah untuk pemisahan */
        }

        button {
            background-color: #ffcc00;
            /* Warna latar belakang tombol */
            color: #333;
            /* Warna teks */
            border: none;
            /* Tanpa border */
            padding: 5px 10px;
            /* Padding untuk tombol */
            border-radius: 5px;
            /* Sudut melengkung */
            cursor: pointer;
            /* Kursor pointer saat hover */
            transition: background-color 0.3s;
            /* Transisi warna latar belakang */
        }

        button:hover {
            background-color: #ffd700;
            /* Warna saat hover */
        }

        .cancel-order-btn {
            display: block;
            /* Menampilkan tombol batalkan pesanan */
            margin-top: 10px;
            /* Jarak atas untuk tombol batalkan pesanan */
        }

        #confirmation-message {
            display: none;
            /* Sembunyikan secara default */
            background-color: #28a745;
            /* Warna latar belakang hijau */
            color: white;
            /* Warna teks putih */
            padding: 10px;
            /* Padding */
            position: fixed;
            /* Posisi tetap */
            top: 20px;
            /* Jarak dari atas */
            right: 20px;
            /* Jarak dari kanan */
            border-radius: 5px;
            /* Sudut melengkung */
            z-index: 1000;
            /* Pastikan di atas elemen lain */
        }


        /* Judul dan Pesan Selamat Datang */
        h1 {
            color: #524A4E;
        }

        .welcome-message {
            font-size: 1.5em;
            margin-bottom: 20px;
        }

        /* Menu Section Styles */
        .menu {
            padding: 10px;
            background-color: white;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .menu h2 {
            text-align: center;
            margin-bottom: 1rem;
            font-size: 2rem;
        }

        .menu h2 span {
            color: #608BC1;
            /* Highlight color */
        }

        .menu p {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1.2rem;
        }

        /* Menu Card Styles */
        .row {
            display: flex !important;
            flex-wrap: wrap !important;
            margin: 0px !important;
            justify-content: center !important;
        }

        .row>* {
            max-width: 19% !important;
            margin-bottom: 20px;
        }

        .menu-card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px !important;
            margin: 20px 10px 20px 10px;
            flex: 1 1 calc(30% - 2rem);
            /* 3 cards per row */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            display: flex;
            /* Menggunakan flexbox */
            flex-direction: column;
            /* Mengatur arah flex menjadi kolom */
            align-items: center;
            /* Memusatkan item secara horizontal */
            max-width: 250px !important;
            /* Adjust as necessary */
        }

        .menu-card p {
            font-size: 0.9rem;
        }

        .menu-card:hover .menu-card-img {
            transform: scale(1.05);
            /* Zoom in saat hover */
            opacity: 0.9;
            /* Ubah opacity saat hover */
        }

        .menu-card-img {
            width: 300px;
            /* Atur lebar gambar menjadi 100% dari kontainer */
            max-width: 100%;
            /* Atur ukuran maksimum gambar */
            height: 300px;
            /* Menjaga rasio aspek gambar */
            border-radius: 5px;
            margin: 0 0 10px 0;
            /* Memusatkan gambar */
            transition: transform 0.3s ease, opacity 0.3s ease;
            /* Transisi untuk transformasi dan opacity */
        }


        .menu-card-title {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .more-info-btn {
            background-color: #ffcc00;
            /* Button color */
            color: #333;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            margin: 0 auto;
            /* Center the button */
        }

        .more-info-btn:hover {
            background-color: #ffd700;
            /* Lighter shade on hover */
        }

        .add-to-cart-btn {
            background-color: #ffcc00;
            /* Latar belakang tombol */
            color: #333;
            /* Warna teks */
            border: none;
            /* Tanpa border */
            padding: 0.5rem 1rem;
            /* Padding untuk tombol */
            border-radius: 5px;
            /* Sudut melengkung */
            cursor: pointer;
            /* Kursor pointer saat hover */
            transition: background-color 0.3s;
            /* Transisi warna latar belakang */
            display: flex;
            /* Menggunakan flexbox untuk menyelaraskan teks dan harga */
            align-items: center;
            /* Menyelaraskan item di tengah */
        }

        .add-to-cart-btn:hover {
            background-color: #ffd700;
            /* Warna saat hover */
        }

        .price-info {
            margin-left: 5px;
            /* Jarak antara teks dan keterangan harga sewa */
            font-size: 0.8rem;
            /* Ukuran font untuk keterangan harga sewa */
            color: #333;
            /* Warna teks untuk keterangan harga sewa */
        }

      

        h2 {
            text-align: center !important;
            color: black !important;
        }


    </style>
</head>

<body>
    <!-- NAVBAR -->
    <?php include 'navbar-user.php'; ?>
    <!-- NAVBAR -->
    <div class="welcome-message">
        <h1>Selamat Datang di Hasogi Show Love</h1>
        <p>Semoga hari Anda menyenangkan.</p>
    </div>

    <!--Menu Section Start-->
    <!--Menu Section Start-->
    <section id="kebaya" class="menu">
        <h2><span>Daftar</span> Kebaya</h2>
        <p>
            Temukan berbagai jenis kebaya untuk acara spesial Anda.
        </p>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="menu-card">
                    <!-- Menampilkan gambar produk -->
                    <img src="<?php echo isset($row['foto']) && !empty($row['foto']) ? '../img/uploads/' . $row['foto'] : 'default-image.jpg'; ?>" alt="Kebaya" class="menu-card-img" />

                    <!-- Menampilkan nama produk -->
                    <h3 class="menu-card-title"><?php echo isset($row['nama']) ? $row['nama'] : 'Nama Tidak Tersedia'; ?></h3>

                    <!-- Menampilkan deskripsi produk -->
                    

                    <!-- Menampilkan harga produk -->
                    <span class="price-info">Rp <?php echo isset($row['harga']) ? number_format($row['harga'], 0, ',', '.') : '0'; ?></span>

                    <!-- Menampilkan kode produk -->
                    <span class="status-info" style="color: Blue; font-weight: bold; font-size: 0.9em;">
                        <?php
                        $kebaya_id = isset($row['kebaya_id']) ? $row['kebaya_id'] : 'Kode Tidak Tersedia';
                        $product_id = isset($row['product_id']) ? $row['product_id'] : 'Kode Tidak Tersedia';
                        echo $kebaya_id . ' - ' . $product_id;
                        ?>
                    </span>


                    <!-- Menampilkan status produk -->
                    <span class="status-info" style="color: green; font-weight: bold;"><?php echo 'Stock: ' . (isset($row['stock']) ? $row['stock'] : 'Tidak Tersedia'); ?></span>

                    <!-- Tombol untuk booking -->
                    <button class="booking-btn" style="margin-top: 10px;" onclick="window.location.href = '../add/addreservasi.php?id=<?php echo urlencode($row['product_id']); ?>&nama=<?php echo urlencode($row['nama']); ?>&harga=<?php echo urlencode($row['harga']); ?>&user_id=<?php echo urlencode($user_id); ?>';">
                        Booking
                    </button>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!--Menu Section End-->

    <!-- Jas Section -->
    <section id="jas" class="menu">
        <h2><span>Daftar</span> Jas</h2>
        <p>Temukan berbagai jenis jas untuk acara spesial Anda.</p>
        <div class="row">
            <?php while ($row_jas = mysqli_fetch_assoc($result_jas)): ?>
                <div class="menu-card">
                    <img src="<?php echo isset($row_jas['foto']) ? '../img/uploads/' . $row_jas['foto'] : 'default-image.jpg'; ?>" alt="Jas" class="menu-card-img" />
                    <h3 class="menu-card-title"><?php echo isset($row_jas['nama']) ? $row_jas['nama'] : 'Nama Tidak Tersedia'; ?></h3>
                    <p><?php echo isset($row_jas['deskripsi']) ? $row_jas['deskripsi'] : 'Deskripsi Tidak Tersedia'; ?></p>
                    <span class="price-info">Rp <?php echo isset($row_jas['harga']) ? number_format($row_jas['harga'], 0, ',', '.') : '0'; ?></span>
                    <span class="status-info" style="color: Blue; font-weight: bold; font-size: 0.9em;">
                        <?php
                        $kebaya_id = isset($row_jas['kebaya_id']) ? $row_jas['kebaya_id'] : 'Kode Tidak Tersedia';
                        $product_id = isset($row_jas['product_id']) ? $row_jas['product_id'] : 'Kode Tidak Tersedia';
                        echo $kebaya_id . ' - ' . $product_id;
                        ?>
                    </span>
                    <span class="status-info" style="color: green; font-weight: bold;"><?php echo 'Stock: ' . (isset($row_jas['stock']) ? $row_jas['stock'] : 'Tidak Tersedia'); ?></span>
                    <button class="booking-btn" style="margin-top: 10px;" onclick="window.location.href = '../add/addreservasi.php?id=<?php echo urlencode($row_jas['product_id']); ?>&nama=<?php echo urlencode($row_jas['nama']); ?>&harga=<?php echo urlencode($row_jas['harga']); ?>';">
                        Booking
                    </button>

                </div>
            <?php endwhile; ?>
        </div>
    </section>
    <!--Menu Section End for Jas-->

    <!-- Aksesoris Section -->
    <section id="aksesoris" class="menu">
        <h2><span>Daftar</span> Aksesoris</h2>
        <p>Temukan berbagai aksesoris untuk melengkapi penampilan Anda.</p>
        <div class="row">
            <?php while ($row_aksesoris = mysqli_fetch_assoc($result_aksesoris)): ?>
                <div class="menu-card">
                    <img src="<?php echo isset($row_aksesoris['foto']) ? '../img/uploads/' . $row_aksesoris['foto'] : 'default-image.jpg'; ?>" alt="Aksesoris" class="menu-card-img" />
                    <h3 class="menu-card-title"><?php echo isset($row_aksesoris['nama']) ? $row_aksesoris['nama'] : 'Nama Tidak Tersedia'; ?></h3>
                    <p><?php echo isset($row_aksesoris['deskripsi']) ? $row_aksesoris['deskripsi'] : 'Deskripsi Tidak Tersedia'; ?></p>
                    <span class="price-info">Rp <?php echo isset($row_aksesoris['harga']) ? number_format($row_aksesoris['harga'], 0, ',', '.') : '0'; ?></span>
                    <span class="status-info" style="color: Blue; font-weight: bold; font-size: 0.9em;">
                        <?php
                        $kebaya_id = isset($row_aksesoris['kebaya_id']) ? $row_aksesoris['kebaya_id'] : 'Kode Tidak Tersedia';
                        $product_id = isset($row_aksesoris['product_id']) ? $row_aksesoris['product_id'] : 'Kode Tidak Tersedia';
                        echo $kebaya_id . ' - ' . $product_id;
                        ?>
                    </span>
                    <span class="status-info" style="color: green; font-weight: bold;"><?php echo 'Stock: ' . (isset($row_aksesoris['stock']) ? $row_aksesoris['stock'] : 'Tidak Tersedia'); ?></span>
                    <button class="booking-btn" style="margin-top: 10px;" onclick="window.location.href = '../add/addreservasi.php?id=<?php echo urlencode($row_aksesoris['product_id']); ?>&nama=<?php echo urlencode($row_aksesoris['nama']); ?>&harga=<?php echo urlencode($row_aksesoris['harga']); ?>';">
                        Booking
                    </button>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <script>
        window.onload = function() {
            const navbarExtra = document.querySelector('.navbar-extra');
            if (navbarExtra) {
                navbarExtra.style.display = 'flex'; // Pastikan navbar ekstra selalu tampil
            }
        };


        feather.replace();
    </script>
</body>

<!-- Footer start -->
<?php include '../companyprofile/footer.php'; ?>
<!-- Footer end -->

</html>