<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sewa Disini</title>

  <!--Fonts-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Great+Vibes&family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <!--Feather Icon-->
  <script src="https://unpkg.com/feather-icons"></script>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        line-height: 1.6;
        background-color: #D3F1DF;
        color: #333;
        padding-top: 60px;
        /* Memberikan ruang di atas konten untuk navbar */
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

    .categories li {
        flex: 1 0 100%;
        /* Menyelaraskan item kategori menjadi satu baris */
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    h2 {
        margin-top: 2rem;
        color: #444;
    }

    ul {
        margin-left: 20px;
    }

    ul li {
        margin-bottom: 0.5rem;
    }
</style>

<body>
    <!-- Navbar Start -->
    <?php include 'navbar.php'; ?>
    <!-- Navbar End -->

    <!-- Modal Login -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Login Sebagai</h2>
            <button id="userButton">User</button>
            <button id="adminButton">Admin</button>
        </div>
    </div>

    <div class="container">
        <h1>Persyaratan dan Ketentuan Penyewaan Kebaya dan Aksesoris</h1>
        <h2>1. Persyaratan Umum</h2>
        <ul>
            <li>Penyewa harus berusia minimal 18 tahun.</li>
            <li>Penyewa harus memiliki identitas yang sah (KTP/SIM).</li>
            <li>Penyewa harus memberikan informasi yang akurat dan lengkap.</li>
        </ul>

        <h2>2. Proses Penyewaan</h2>
        <ul>
            <li>Penyewa harus mengisi formulir penyewaan yang tersedia.</li>
            <li>Penyewa harus melakukan pembayaran uang muka untuk mengkonfirmasi penyewaan.</li>
            <li>Waktu penyewaan akan dimulai dari tanggal yang disepakati dalam kontrak.</li>
        </ul>

        <h2>3. Ketentuan Pengembalian</h2>
        <ul>
            <li>Barang yang disewa harus dikembalikan dalam kondisi baik.</li>
            <li>Jika terjadi kerusakan, penyewa bertanggung jawab untuk mengganti rugi sesuai dengan nilai barang.</li>
            <li>Pengembalian barang harus dilakukan pada tanggal yang telah disepakati.</li>
        </ul>

        <h2>4. Pembatalan Penyewaan</h2>
        <ul>
            <li>Penyewa dapat membatalkan penyewaan dengan pemberitahuan minimal 3 hari sebelum tanggal penyewaan.</li>
            <li>Uang muka yang telah dibayarkan akan dikembalikan setelah dikurangi biaya administrasi.</li>
        </ul>

        <h2>5. Ketentuan Lain</h2>
        <ul>
            <li>Perusahaan berhak untuk mengubah syarat dan ketentuan ini sewaktu-waktu.</li>
            <li>Dengan melakukan penyewaan, penyewa dianggap telah menyetujui syarat dan ketentuan yang berlaku.</li>
        </ul>
    </div>
    <script>    
        // Mengubah warna navbar saat menggulir
        window.onscroll = function() {
      const navbar = document.querySelector('.navbar');
      if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        navbar.style.backgroundColor = "#222"; // Warna saat menggulir
      } else {
        navbar.style.backgroundColor = "#333"; // Warna default
      }
    };
        // Get the modal
        var modal = document.getElementById("loginModal");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on the button, open the modal
        document.getElementById("login-button").onclick = function() {
            modal.style.display = "block";
        };

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        };

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };

        // Handle user and admin button clicks
        document.getElementById("userButton").onclick = function() {
            // Redirect to user login page
            window.location.href = "../user/login-user.php"; // Ganti dengan halaman user login yang sesuai
        };

        document.getElementById("adminButton").onclick = function() {
            // Redirect to admin login page
            window.location.href = "../admin/admin-login.php"; // Ganti dengan halaman admin login yang sesuai
        };

        feather.replace();
    </script>
</body>
<?php include 'footer.php'; ?>
</html>