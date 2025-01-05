<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sewa Disini</title>

  <!--Fonts-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Great+Vibes&family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <!--Feather Icon-->
  <script src="https://unpkg.com/feather-icons"></script>

  <!--Style-->
  <link rel="stylesheet" href="../css/tentangkami.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      line-height: 1.6;
      background-color: #F3F3E0;
      color: #333;
      padding-top: 60px;
      /* Memberikan ruang di atas konten untuk navbar */
      font-size: small;
    }
    
    /* Servis Section Styles */
    .servis {
      background: #fff;
      padding: 2rem;
      margin: 2rem;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .servis h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      font-size: 2rem;
    }

    .servis-content {
      display: flex;
      flex-direction: column;
    }

    .servis-item {
      margin-bottom: 1.5rem;
      padding: 1rem;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .servis-item h3 {
      margin-bottom: 0.5rem;
      font-size: 1.5rem;
    }

    .servis-item p {
      margin-bottom: 0;
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

    /* About Section Styles */
    .about {
      background: white;
      padding: 2rem;
      margin: 2rem;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .about h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      font-size: 2rem;
    }

    .about h2 span {
      color: #608bc1;
      /* Highlight color */
    }

    .row {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 20px;
    }

    .about-img {
      flex: 1;
      max-width: 400px;
      margin-right: 2rem;
    }

    .about-img img {
      width: 70%;
      border-radius: 8px;
    }

    .content {
      flex: 2;
    }

    .content h3 {
      margin-bottom: 1rem;
      font-size: 1.5rem;
    }

    .content p {
      margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
      .row {
        flex-direction: column;
      }
    } 

      .about-img {
        margin-right: 0;
        margin-bottom: 1rem;
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
      <button id="userButton">User</button>
      <button id="adminButton">Admin</button>
    </div>
  </div>


  <!-- About section start -->
  <section id="about" class="about" data-aos="fade-up" data-aos-duration="1000">
    <h2><span>Tentang</span> Kami</h2>

    <div class="row">
      <div class="about-img" data-aos="zoom-in" data-aos-duration="1000">
        <img src="../logo/logo_hsl.jpeg" alt="tentang kami" />
      </div>
      <div class="content" data-aos="fade-right" data-aos-duration="1000">
        <h3>Selamat Datang di <span>Hasogi Show Love.</span></h3>
        <p>
          Hasogi adalah tempat penyewaan kebaya di Karawnag yang menyewakan kebaya & gaun untuk berbagai ukuran dan warna.
          Kami hadir untuk menjawab permintaan customer yang tinggi terhadap sewa kebaya di Karawang. Kami menyediakan berbagai jenis kebaya & gaun untuk menunjang
          kegiatan anda seperti pernikahan, wisuda, pesta, kondangan, dll.
        </p>
      </div>
    </div>
  </section>

  <!-- About section 2 -->
  <section id="about" class="about" data-aos="fade-up" data-aos-duration="1000">
    <div class="row">
      <div class="about-img" data-aos="zoom-in" data-aos-duration="1000">
        <img src="../logo/logo_hsl.jpeg" alt="tentang kami" />
      </div>
      <div class="content" data-aos="fade-right" data-aos-duration="1000">
        <h3>Cerita di Balik nama Hasogi</h3>
        <p>
          Hasogi adalah tempat penyewaan kebaya di Karawnag yang menyewakan kebaya & gaun untuk berbagai ukuran dan warna.
          Kami hadir untuk menjawab permintaan customer yang tinggi terhadap sewa kebaya di Karawang. Kami menyediakan berbagai jenis kebaya & gaun untuk menunjang
          kegiatan anda seperti pernikahan, wisuda, pesta, kondangan, dll.
        </p>
      </div>
    </div>
  </section>

  <!-- About section 3 -->
  <section id="about" class="about" data-aos="fade-up" data-aos-duration="1000">
    <div class="row">
      <div class="about-img" data-aos="zoom-in" data-aos-duration="1000">
        <img src="../logo/logo_hsl.jpeg" alt="tentang kami" />
      </div>
      <div class="content" data-aos="fade-right" data-aos-duration="1000">
        <h3>Cerita di Balik nama Hasogi</h3>
        <p>
          Hasogi adalah tempat penyewaan kebaya di Karawnag yang menyewakan kebaya & gaun untuk berbagai ukuran dan warna.
          Kami hadir untuk menjawab permintaan customer yang tinggi terhadap sewa kebaya di Karawang. Kami menyediakan berbagai jenis kebaya & gaun untuk menunjang
          kegiatan anda seperti pernikahan, wisuda, pesta, kondangan, dll.
        </p>
      </div>
    </div>
  </section>


  <!-- About section 4 -->
  <section id="about" class="about" data-aos="fade-up" data-aos-duration="1000">
    <div class="row">
      <div class="about-img" data-aos="zoom-in" data-aos-duration="1000">
        <img src="../logo/logo_hsl.jpeg" alt="tentang kami" />
      </div>
      <div class="content" data-aos="fade-right" data-aos-duration="1000">
        <h3>Cerita di Balik nama Hasogi</h3>
        <p>
          Hasogi adalah tempat penyewaan kebaya di Karawnag yang menyewakan kebaya & gaun untuk berbagai ukuran dan warna.
          Kami hadir untuk menjawab permintaan customer yang tinggi terhadap sewa kebaya di Karawang. Kami menyediakan berbagai jenis kebaya & gaun untuk menunjang
          kegiatan anda seperti pernikahan, wisuda, pesta, kondangan, dll.
        </p>
      </div>
    </div>
  </section>

  <!-- About section 5 -->
  <section id="about" class="about" data-aos="fade-up" data-aos-duration="1000">
    <div class="row">
      <div class="about-img" data-aos="zoom-in" data-aos-duration="1000">
        <img src="../logo/logo_hsl.jpeg" alt="tentang kami" />
      </div>
      <div class="content" data-aos="fade-right" data-aos-duration="1000">
        <h3>Cerita di Balik nama Hasogi</h3>
        <p>
          Hasogi adalah tempat penyewaan kebaya di Karawnag yang menyewakan kebaya & gaun untuk berbagai ukuran dan warna.
          Kami hadir untuk menjawab permintaan customer yang tinggi terhadap sewa kebaya di Karawang. Kami menyediakan berbagai jenis kebaya & gaun untuk menunjang
          kegiatan anda seperti pernikahan, wisuda, pesta, kondangan, dll.
        </p>
      </div>
    </div>
  </section>

  <!-- Footer start -->
<?php include 'footer.php'; ?>

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

    // Animasi Gambar //
    document.addEventListener("DOMContentLoaded", function() {
      const images = document.querySelectorAll('.categories img');
      images.forEach((img) => {
        img.classList.add('visible');
      });
    });

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

    // Ketika pengguna mengklik hamburger menu, toggle kelas 'active' pada navbar-nav
    document.getElementById("hamburger-menu").onclick = function() {
      const navbarNav = document.querySelector('.navbar-nav');
      navbarNav.classList.toggle('active');
    };


    feather.replace();
  </script>

  <!--My Javascript-->
  <script src="../js/script.js"></script>
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>

</html>