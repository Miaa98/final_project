<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sewa Kebaya Karawang</title>

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Great+Vibes&family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet">

    <!--Feather Icon-->
    <script src="https://unpkg.com/feather-icons"></script>
    <link a href="stylesheet" rel="../css/home.css">
    <!--Aos-->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        line-height: 1.6;
        background-color: #524A4E;
        color: #fff;
        padding-top: 60px;
        /* Memberikan ruang di atas konten untuk navbar */
        font-size: small;
    }


    .categories {
        object-fit: cover;
        margin-top: 20px;
        /* Ruang di atas kategori */
    }

    .categories h2 {
        font-size: 2rem;
        /* Ukuran font untuk judul kategori */
        margin-bottom: 10px;
        /* Ruang di bawah judul */
        text-align: center;
        /* Menyelaraskan teks di tengah */
    }

    .categories ul {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;

        list-style-type: none;
        /* Menghapus bullet points */
        padding: 0;
        /* Menghapus padding */
        display: flex;
        /* Mengatur agar item ditampilkan dalam baris */
        flex-wrap: wrap;
        /* Membungkus item ke baris berikutnya jika diperlukan */
        justify-content: center;
        /* Menyelaraskan item di tengah */
    }

    .categories li {
        margin: 10px;
        /* Ruang di antara item kategori */
        text-align: center;
        /* Menyelaraskan teks di tengah */
        flex: 1 0 250px;
        /* Lebar minimal fleksibel 250px, maksimal tergantung ruang */
        max-width: 300px;
        /* Batas lebar maksimal */
        width: 100%;
        /* Agar menyesuaikan ruang di dalam flexbox */
        padding: 15px;
        /* Ruang di dalam item kategori */
        border: 1px solid #ddd;
        /* Border tipis untuk item kategori */
        border-radius: 15px;
        /* Sudut melengkung */
        background-color: #f9f9f9;
        /* Warna latar belakang item kategori */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Efek bayangan */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        /* Transisi untuk efek interaktif */
        font-size: 1.2rem;
        /* Ukuran font */
    }

    .categories li:hover {
        transform: scale(1.05);
        /* Sedikit memperbesar saat hover */
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        /* Bayangan lebih dalam saat hover */
    }

    .categories img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 225px;
        height: 300px;
        object-fit: cover;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
    }

    .categories a {
        color: #333;
        /* Warna teks link */
        text-decoration: none;
        /* Menghapus garis bawah */
        transition: color 0.9s;
        /* Transisi untuk efek hover */
        display: block;
        /* Mengatur link agar mengisi ruang yang ada */
        margin-top: 5px;
        /* Ruang di atas link */
    }

    .categories img.visible {
        opacity: 1;

    }

    .categories img:hover {
        transform: scale(1.02);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
    }

    .categories li {
        flex: 1 0 45%;
        /* Mengatur lebar item kategori */
        max-width: 250px;
        /* Mengatur lebar maksimum item */
        padding: 10px;
        border-radius: 15px;
        background-color: #f9f9f9;
        margin-bottom: 20px;
        font-size: 1.5rem;
        text-align: center;
    }

    .categories a:hover {
        color: #ffcc00;
        /* Warna saat hover */
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
        width: 250px;
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

    /* Hero Section Styles */
    .hero {
        text-align: center;
        padding: 100px 20px;
        /* Memberikan ruang di atas dan bawah */
        background-color: #FDEFF4;
        /* Warna latar belakang hero */
        font-size: small;
    }

    .hero h1 {
        font-size: 3.0rem;
        display: center;
        padding: 2px;
        letter-spacing: 1px;
        font-family: 'exo 2';
        color: #524A4E;
    }

    .hero h1 span {
        color: #524A4E;
        /* Warna khusus untuk teks 'Karawang' */
    }

    .hero p {
        margin: 20px 0;
        letter-spacing: 1px;
        height: 50px;
        width: 100%;
        font-size: 1.0rem;
        padding: 0.5px;
        color: #524A4E;
        font-family: "popins", sans-serif;
    }

    .cta {
        display: inline-block;
        padding: 10px 20px;
        background-color: #333;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.9s;
    }

    .cta:hover {
        background-color: #555;
        /* Warna latar belakang saat hover */
    }

    /* News Section Styles */
    .news {
        background-color: #FDEFF4;
        /* Warna latar belakang yang lembut */
        padding: 40px 20px;
        /* Padding atas dan bawah 40px, kiri dan kanan 20px */
        border-radius: 8px;
        /* Sudut yang membulat */
        margin: 20px 0;
        /* Margin atas dan bawah 20px */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        /* Bayangan halus */
    }

    .news h2 {
        text-align: center;
        /* Pusatkan judul */
        font-family: 'Poppins', sans-serif;
        /* Gunakan font Poppins */
        font-size: 2rem;
        /* Ukuran font judul */
        margin-bottom: 20px;
        /* Margin bawah judul */
        color: #333;
        /* Warna teks */
    }

    .news h2 span {
        color: #FF5C8D;
        /* Highlight color */
    }

    .news-item {
        background-color: #FFC0D3;
        /* Warna latar belakang item berita */
        padding: 20px;
        /* Padding di dalam item berita */
        margin: 15px 0;
        /* Margin atas dan bawah item berita */
        border-radius: 5px;
        /* Sudut yang membulat */
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        /* Bayangan halus untuk item berita */
    }

    .news-item h3 {
        font-size: 1.5rem;
        /* Ukuran font untuk judul berita */
        color: #524A4E;
        /* Warna teks judul berita */
        margin-bottom: 10px;
        /* Margin bawah judul berita */
    }

    .news-item p {
        font-size: 0.8rem;
        /* Ukuran font untuk deskripsi berita */
        color: #666;
        /* Warna teks deskripsi berita */
        line-height: 1.6;
        /* Jarak antar baris */
        font-family: "poppins";
    }
</style>

<body>
    <!-- NAVBAR -->
    <?php include 'navbar.php'; ?>
    <!-- NAVBAR -->


    <!-- Hero section start -->
    <section class="hero" id="home">
        <main class="content" data-aos="fade-up" data-aos-duration="2000">
            <h1>Sewa Kebaya dan Gaun <span>Karawang</span></h1>
            <p>
                Menyewakan beberapa jenis Kebaya & Gaun untuk acara Pernikahan,
                Wisuda, Brithday Party, dan Kondangan.
            </p>
        </main>
    </section>

    <!-- Kategori Section -->
    <div class="categories" data-aos="fade-right" data-aos-duration="2000">
        <h2>Kategori</h2>
        <ul>
            <li>
                <img src="../img/aksesoris.jpg" alt="Kebaya Pernikahan" />
                <a href="produk.php">Kebaya Pernikahan</a>
            </li>
            <li>
                <img src="../img/adat.jpg" alt="Kebaya Adat" />
                <a href="produk.php">Kebaya Adat</a>
            </li>
            <li>
                <img src="../img/gallery3.jpg" alt="Gaun Resepsi" />
                <a href="produk.php">Gaun Resepsi</a>
            </li>
        </ul>
    </div>
    </main>
    </section>
    <!-- Hero section end -->

    <!-- News section start -->
    <section id="news" class="news">
        <h2>Cara Mudah Sewa Kebaya Di <span>HASOGI</span></h2>
        <div class="news-item">
            <h3>Cara Pertama</h3>
            <p>
                Membuat akun dan masukkan data diri pada form pendaftaran.
                </br>Anda dapat memilih kebaya yang Anda inginkan.
                Setelah memilih kebaya, Anda dapat memilih tanggal dan waktu penyewaan dan melakukan checkout.

            </p>
        </div>
        <div class="news-item">
            <h3>Cara Kedua</h3>
            <p>
                Silahkan datang ke Gallery dI Jl. Tunggak Jati, Kab. Karawang untuk melakukan pembayaran dan pengambilan barang.
            </p>
        </div>
        <div class="news-item">
            <h3>Cara Ketiga</h3>
            <p>
                Setelah cara pertama dan kedua dilakukan, barang sudah dapat digunakan sesuai dengan durasi sewa.
                </br> Pastikan tidak ada kerusakan setelah Anda menyewa barang yang Anda sewa, jika terdapat kerusakan pada produk tersebut maka akan dikenakan biaya penggantian barang.
            </p>
        </div>
    </section>
    <!-- News section end -->

    <!-- Footer start -->
    <?php include 'footer.php'; ?>
    <!-- Footer end -->

    <!--Feather Icon-->
    <script>
        // Mengubah warna navbar saat menggulir
        window.onscroll = function() {
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                    navbar.style.backgroundColor = "#222"; // Warna saat menggulir
                } else {
                    navbar.style.backgroundColor = "#333"; // Warna default
                }
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
            window.location.href = "../admin/login-admin.php"; // Ganti dengan halaman admin login yang sesuai
        };

        feather.replace();
    </script>

    <!--My Javascript-->
    <script src="../js/home.js"></script>
    <!--Aos-->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>