<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Example</title>

    <!-- Link ke Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Your CSS link here (optional) -->
    <style>
        /* Style untuk footer */
        .footer {
            background-color: #524A4E;
            color: white;
            padding: 40px 20px;
            font-family: 'Poppins', sans-serif;
            text-align: left;
            margin-top: 40px;
        }

        /* Container untuk semua elemen footer */
        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Kolom Footer */
        .footer-col {
            flex: 1;
            min-width: 250px;
            max-width: 280px;
            text-align: left;
            margin-bottom: 20px;
        }

        /* Logo dan Deskripsi */
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-logo-img {
            max-width: 50px;
        }

        .footer-description {
            font-size: 0.9rem;
            color: #ddd;
            margin-top: 10px;
        }

        /* Tautan Footer */
        .footer-col-6 h4 {
            font-size: 1.2rem;
            color: #FF5C8D;
            margin-bottom: 10px;
        }

        .footer-col-6 ul {
            list-style: none;
            padding: 0;
        }

        .footer-col-6 ul li {
            margin: 5px 0;
        }

        .footer-col-6 ul li a {
            text-decoration: none;
            color: white;
            transition: color 0.3s ease;
        }

        .footer-col-6 ul li a:hover {
            color: #FF5C8D;
        }

        /* Tautan Sosial Media */
        .social-icons {
            gap: 20px;
            justify-content: start;
        }

        .social-icons a {
            display: inline-block;
        }

        .social-icon {
            font-size: 30px;
            color: white;
            transition: transform 0.3s ease;
        }

        .social-icon:hover {
            transform: scale(1.1);
            color: #FF5C8D;
        }

        /* Footer Bottom */
        .footer-bottom {
            background-color: #3A3335;
            color: #ccc;
            padding: 10px;
            font-size: 0.8rem;
        }

        .footer-bottom p {
            margin: 0;
        }
    </style>
</head>

<body>
    <footer class="footer">
        <div class="footer-container">
            <!-- Kolom 1: Logo dan Deskripsi -->
            <div class="footer-col-6 col-lg-2 mb-3">
                <div class="footer-logo">
                    <div>
                        <h4>HASOGI SHOW LOVE</h4>
                        <p class="footer-description">Menampilkan Kebaya dan Gaun Berkualitas untuk Momen Istimewa Anda</p>
                    </div>
                </div>
            </div>

            <!-- Kolom 2: Links -->
            <div class="footer-col-6 col-lg-2 mb-3">
                <h4>Links</h4>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="tentangkami.php">Tentang Kami</a></li>
                    <li><a href="produk.php">Produk</a></li>
                    <li><a href="syaratdanketentuan.php">Syarat & Ketentuan</a></li>
                    <li><a href="contact.php">Hubungi Kami</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Sosial Media -->
            <div class="footer-col-6 col-lg-2 mb-3">
                <h4>Contact</h4>
                <ul>
                    <li><a href="mailto:contact@hasogi.com">contact@hasogi.com</a></li>
                    <li><a href="https://wa.me/6289509828209?text=Halo%20Hasogi%20Show%20Love" target="_blank">0895 0982 8209</a></li>
                    <li><a href="https://maps.app.goo.gl/HmXL2Kdkw9mL7nCc6">Alamat Kami</a></li>
                </ul>

            </div>

            <!-- Kolom 4: Contact -->
            <div class="footer-col-6 col-lg-2 mb-3">
                <div class="social-icons">
                    <h4>Follow Us</h4>
                    <a href="https://www.instagram.com/hsl_sewakebaya" target="_blank" aria-label="Instagram">
                        <i class="bi bi-instagram social-icon"></i>
                    </a>
                    <a href="https://www.tiktok.com/@hasogi.show.love" target="_blank" aria-label="TikTok">
                        <i class="bi bi-tiktok social-icon"></i>
                    </a>
                    <a href="https://shopee.co.id/hsl_sewakebaya" target="_blank" aria-label="Shopee">
                        <i class="bi bi-shop social-icon"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2024 Hasogi. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>