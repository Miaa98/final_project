<?php
session_start(); // Mulai sesi
include '../database/db.php'; // Sertakan file koneksi database

// Ambil data dari database
$query = "SELECT * FROM gallerys"; // Query untuk mengambil data dari tabel gallerys
$result = mysqli_query($conn, $query); // Eksekusi query
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gallery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Feather Icon -->
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding-top: 60px;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 50px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .gallery-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            display: block;
            transition: transform 0.3s;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-item h3 {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>

<!-- navbar -->
<?php include 'navbar-user.php'; ?>
<!-- navbar -->

    <div class="container">
        <h1>Gallery</h1>
        <div class="gallery">
            <?php
            // Periksa jika ada data dari database
            if (mysqli_num_rows($result) > 0) {
                // Loop untuk menampilkan setiap item gallery
                while ($row = mysqli_fetch_assoc($result)) {
                    $image = $row['image']; // Ambil path gambar dari database
                    $nama = $row['nama']; // Ambil nama gambar dari database
            ?>
            <div class="gallery-item">
                <!-- Perbaiki path gambar dengan menambahkan "/" setelah "uploads" -->
                <img src="../img/uploads/<?php echo $image; ?>" alt="<?php echo $nama; ?>" />
                <h3><?php echo $nama; ?></h3>
            </div>
            <?php
                }
            } else {
                echo "<p>No images found in the gallery.</p>";
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        feather.replace();
    </script>
</body>

  <!-- Footer start -->
  <?php include '../companyprofile/footer.php'; ?>
  <!-- Footer end -->

</html>
