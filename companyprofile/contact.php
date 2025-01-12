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

  <!--Feather Icon-->
  <script src="https://unpkg.com/feather-icons"></script>

  <!--Style-->
  <link rel="stylesheet" href="../css/contact.css" />
  <style>
    /* Reset CSS */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      line-height: 1.6;
      font-family: 'Poppins', sans-serif;
      background-color: #f4f4f4;
      color: #333;
      font-size: small;
    }

    /* Style Khusus untuk Tombol Login */
    #login-button {
      background-color: #fff;
      /* Warna latar belakang tombol login */
      color: #333;
      /* Warna teks tombol login */
      padding: 10px 15px;
      /* Padding untuk tombol */
      border-radius: 4px;
      /* Sudut melengkung */
      border: 1px solid #ffff;
      /* Border dengan warna yang sama */
      transition: background-color 0.3s, color 0.3s;
      /* Transisi untuk efek hover */
    }

    #login-button:hover {
      background-color: #333;
      /* Ubah warna latar belakang saat hover */
      color: #ffff;
      /* Ubah warna teks saat hover */
    }


    /* Modal Styles */
    .modal {
      display: none;
      /* Sembunyikan modal secara default */
      position: fixed;
      /* Tetap di posisi tetap */
      z-index: 100;
      /* Di atas elemen lain */
      left: 0;
      top: 0;
      width: 100%;
      /* Lebar penuh */
      height: 100%;
      /* Tinggi penuh */
      overflow: auto;
      /* Tambahkan scroll jika diperlukan */
      background-color: rgba(0, 0, 0, 0.5);
      /* Latar belakang semi-transparan */
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      /* 15% dari atas dan tengah */
      padding: 20px;
      border: 1px solid #888;
      width: 300px;
      /* Lebar modal */
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

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin: 10px 0 5px;
    }

    input {
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      padding: 10px;
      background-color: #333;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background-color: #555;
    }


    /* Contact Section Styles */
    .contact {
      padding: 2rem;
      background: white;
      margin: 2rem;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .contact h2 {
      text-align: center;
      margin-bottom: 1rem;
      font-size: 2rem;
    }

    .contact h2 span {
      color: #608bc1;
      /* Highlight color */
    }

    .contact p {
      text-align: center;
      margin-bottom: 2rem;
      font-size: 1.2rem;
    }

    /* Row Styles */
    .row {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    .map {
      flex: 1;
      min-width: 300px;
      /* Minimum width for the map */
      border: none;
      border-radius: 8px;
      margin-right: 2rem;
    }

    /* Form Styles */
    form {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .input-group {
      position: relative;
      margin-bottom: 1rem;
    }

    .input-group i {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: #999;
    }

    .input-group input {
      width: 100%;
      padding: 0.5rem 2rem;
      /* Space for the icon */
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 1rem;
    }

    .input-group input:focus {
      border-color: #ffcc00;
      /* Highlight border on focus */
      outline: none;
    }

    .btn {
      background-color: #ffccea;
      /* Button color */
      color: #333;
      border: none;
      padding: 0.75rem;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .btn:hover {
      background-color: #608bc1;
      /* Lighter shade on hover */
    }

    .sosial a {
      color: #fff;
      margin: 0 0.5rem;
      transition: color 0.3s;
    }

    .sosial a:hover {
      color: #ffcc00;
      /* Highlight color on hover */
    }

    .links a {
      color: #fff;
      margin: 0 1rem;
      text-decoration: none;
      transition: color 0.3s;
    }

    .links a:hover {
      color: #ffcc00;
      /* Highlight color on hover */
    }
  </style>
</head>

<body>
  <!-- Navbar Start -->
  <?php include 'navbar.php'; ?>
  <!-- Navbar End -->

  <!--Contact Section start-->
  <section id="contact" class="contact">
    <h2><span>Kontak</span> Kami</h2>
    <p>
      Silahkan hubungi kami melalui kontak dibawah ini atau kunjungi toko kami langsung.
    </p>

    <div class="row">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.0242333203128!2d107.2776911!3d-6.260538100000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698300159200f7%3A0xbc8d3ac33f9fe9bb!2sHASOGI%20SHOW%20LOVE!5e0!3m2!1sid!2sid!4v1732329288012!5m2!1sid!2sid"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        class="map"></iframe>

      <form action="">
        <div class="input-group">
          <i data-feather="user"></i>
          <input type="text" placeholder="nama" />
        </div>
        <div class="input-group">
          <i data-feather="mail"></i>
          <input type="text" placeholder="email" />
        </div>
        <div class="input-group">
          <i data-feather="phone"></i>
          <input type="text" placeholder="no hp" />
        </div>
        <button type="submit" class="btn">Kirim pesan</button>
      </form>
    </div>
  </section>
  <!--Contact Section End-->

  <!-- Footer start -->
<?php include 'footer.php'; ?>
  <!-- Footer end -->

  <!--Feather Icon-->
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

    // Mendapatkan modal
    var modal = document.getElementById("login-modal");

    // Mendapatkan tombol yang membuka modal
    var btn = document.getElementById("login-button");

    // Mendapatkan elemen <span> yang menutup modal
    var span = document.getElementsByClassName("close")[0];

    // Ketika pengguna mengklik tombol, buka modal
    btn.onclick = function() {
      modal.style.display = "block";
    }

    // Ketika pengguna mengklik <span> (x), tutup modal
    span.onclick = function() {
      modal.style.display = "none";
    }

    // Ketika pengguna mengklik di luar modal, tutup modal
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

    // Menangani pengiriman form login
    document.getElementById("login-form").onsubmit = function(event) {
      event.preventDefault(); // Mencegah pengiriman form default
      // Ambil nilai username dan password
      const username = document.getElementById("username").value;
      const password = document.getElementById("password").value;

      // Lakukan proses login (misalnya, kirim ke server)
      console.log("Username:", username);
      console.log("Password:", password);

      // Tutup modal setelah login
      modal.style.display = "none";
    };

    // Toggle class active
    const navbarNav = document.querySelector(".navbar-nav");
    // Ketika hamburger menu di klik
    document.querySelector("#hamburger-menu").onclick = () => {
      navbarNav.classList.toggle("active");
    };

    // Klik di luar sidebar untuk menghilangkan nav
    const hamburger = document.querySelector("#hamburger-menu");

    document.addEventListener("click", function(e) {
      if (!hamburger.contains(e.target) && !navbarNav.contains(e.target)) {
        navbarNav.classList.remove("active");
      }
    });

    feather.replace();
  </script>

  <!--My Javascript-->
  <script src="../js/script.js"></script>
</body>

</html>