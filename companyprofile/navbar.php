<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        /* Navbar Styles */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #524A4E;
            padding: 10px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 10;
            transition: background-color 0.3s;
        }

        .navbar img {
            height: 50px;
            margin-right: 10px;
        }

        .navbar-nav {
            display: flex;
            font-family: 'Poppins', sans-serif;
            margin: auto;
            align-items: center;
            flex-direction: row;
        }

        .navbar-nav a {
            color: #ffff;
            text-decoration: none;
            margin: 0 5px;
            transition: color 0.3s;
            padding: 10px 15px;
            align-items: center;
            font-size: 14px;
        }

        .navbar-logo span {
    color: #F0A8D0;
    font-family: 'Great Vibes', cursive; /* Terapkan font Great Vibes */
    font-size: 24px; /* Sesuaikan ukuran font jika diperlukan */
}

        .navbar-logo span {
            color: #F0A8D0;
            font-family: 'Times New Roman', Times, serif;
        }

        .navbar-logo {
            color: #ffff;
            text-decoration: none;
            font-size: 24px;
            font-family: "great vibes";
        }

        .navbar-extra a {
            color: #fff;
            margin-left: 1rem;
            padding: 10px 15px;
            border: 1px solid transparent;
            border-radius: 4px;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .navbar-extra a:hover {
            background-color: #ffcc00;
            border-color: #ffcc00;
            color: #333;
        }

        #login-button {
            background-color: #fff;
            color: #333;
            padding: 10px 15px;
            border-radius: 3px;
            border: 0.5px solid #ffff;
            transition: background-color 0.3s, color 0.3s;
        }

        #login-button:hover {
            background-color: #333;
            color: #ffff;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .navbar-nav {
                display: flex;
                flex-direction: row;
                position: absolute;
                background-color: #333;
                width: 100%;
                top: 60px;
                left: 0;
                z-index: 10;
                align-items: center;
                justify-content: center;
                display: none;
            }

            .navbar {
                flex-direction: column;
            }

            .navbar-nav.active {
                display: flex;
            }

            .navbar-extra {
                display: flex;
            }

            .navbar-extra a {
                margin-left: 0.5rem;
            }
        }

        @media (min-width: 769px) {
            .navbar-extra {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar Start -->
    <nav class="navbar">
    <a href="#" class="navbar-logo"><span>Hasogi </span>Show Love.</a>

        <div class="me-0">
            <div class="navbar-nav">
                <a href="home.php">Home</a>
                <a href="tentangkami.php">Tentang Kami</a>
                <a href="produk.php">Produk</a>
                <a href="syaratdanketentuan.php">Syarat Dan Ketentuan</a>
                <a href="gallery.php">Gallery</a>
                <a href="contact.php">Contact Service</a>
                <a href="../user/login-user.php" id="login-button">Login</a>
            </div>
        </div>
        <div class="navbar-extra">
            <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
        </div>
    </nav>
    <!-- Navbar End -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        feather.replace();

        // Toggle navbar on hamburger click (mobile view)
        document.getElementById('hamburger-menu').addEventListener('click', function() {
            document.querySelector('.navbar-nav').classList.toggle('active');
        });
    </script>
</body>
</html>
