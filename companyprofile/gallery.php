<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gallery</title>

  <!--Fonts-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Great+Vibes&family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet">
  <!--Feather Icon-->
  <script src="https://unpkg.com/feather-icons"></script>

  <!--Style-->
  <link rel="stylesheet" href="../css/forsale.css" /> <!-- Link ke CSS untuk halaman For Sale -->
  <style>
    /* Reset default styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      line-height: 1.6;
      background-color: #f4f4f4;
      color: #333;
      font-size: small;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 100;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 300px;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    .gallery {
      padding: 50px 20px;
      text-align: center;
      background-color: #f4f4f4;
    }

    .gallery h1 {
      font-size: 2rem;
      margin-bottom: 20px;
      color: #333;
      padding: 50px 20px;
    }

    .gallery-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
      max-width: 1200px;
      margin: 0 auto;
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
  <!-- Navbar Start -->
  <?php include 'navbar.php'; ?>
  <!-- Navbar End -->

  <!-- Modal Login -->
  <div id="loginModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Login Sebagai</h2>
      < ```php
      <button onclick="location.href='login.php'">User </button>
      <button onclick="location.href='admin-login.php'">Admin</button>
    </div>
  </div>

  <div class="gallery">
    <h1>Gallery</h1>
    <div class="gallery-container">
      <?php
      include '../database/db.php';

      // Query untuk mengambil data gambar
      $sql = "SELECT * FROM gallerys";
      $result = $conn->query($sql);

      // Menampilkan gambar
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="gallery-item">';
            // Perbaikan di sini: memastikan path gambar dimulai dengan "img/uploads/"
            echo '<img src="../img/uploads/' . $row['image'] . '" alt="' . $row['nama'] . '">';
            echo '<h3>' . $row['nama'] . '</h3>';
            echo '</div>';
        }
    } else {
        echo "Tidak ada gambar yang ditemukan.";
    }
    
      // Menutup koneksi
      $conn->close();
      ?>
    </div>
  </div>

  <script>
    // Script untuk modal
    var modal = document.getElementById("loginModal");
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
      modal.style.display = "block";
    }

    span.onclick = function() {
      modal.style.display = "none";
    }

    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>
</body>
<?php include 'footer.php'; ?>
</html>