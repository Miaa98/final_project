<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Great+Vibes&family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet">

    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f4f4;
        padding-top: 60px;
    }

    /* Navbar */
    .navbar {
        background-color: #524A4E;
    }

    .navbar-brand span:last-child {
        font-family: 'Great Vibes', cursive;
        color: white;
    }

    .navbar-brand span:first-child {
        color: #F0A8D0;
        font-family: 'Times New Roman', serif; /* Change font to Times New Roman */
    }

    .navbar-nav .nav-link {
        color: white;
        transition: color 0.3s;
    }

    .navbar-nav .nav-link:hover {
        color: #f8f9fa;
    }

    .navbar-toggler {
        border: none;
        color: white;
    }

    .dropdown-menu {
        background-color: #524A4E;
    }

    .dropdown-menu .dropdown-item {
        color: white; /* Change text color of dropdown items to white */
    }

    .dropdown-menu .dropdown-item:hover {
        background-color: #4f4447;
    }

    /* Offcanvas customization */
    .offcanvas-body {
        background-color: #524A4E;
    }

    .offcanvas-header {
        background-color: #524A4E;
        color: white;
    }

    /* Profile icon customization */
    .dropdown .nav-link {
        color: white; /* Set icon color to white */
        font-size: 24px; /* Set standard size for the profile icon */
    }

    /* Move the profile dropdown to the left by default */

    /* Media query to move the hamburger icon to the right only on smaller screens */
    @media (max-width: 992px) {
        /* On small screens, move the hamburger menu to the right */
        .navbar-toggler {
            order: 2; /* Moves the hamburger icon to the far right */
        }

        /* Ensure the profile icon stays on the left */
        .navbar-nav .nav-item:last-child {
            order: 1; /* Keeps profile icon on the left on small screens */
        }
    }

    @media (min-width: 250px) {
        #offcanvasNavbar {
            width: 250px;
        }
    }
</style>




</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand me-auto">
                <span>Hasogi</span> <span>Show Love.</span>
            </a>

            <!-- Navbar toggler for small screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Offcanvas Menu for Navbar Links -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link mx-lg-2" aria-current="page" href="home-admin.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="listuser-admin.php">List User</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="produk-admin.php">Produk</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="reservasi-admin.php">Reservasi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="halaman-pembayaran.php">Pembayaran</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="gallery-admin.php">Gallery</a>
            </li>
          </ul>
        </div>
      </div>

            <!-- Profile Dropdown -->
            <div class="dropdown">
                <a href="#" class="nav-link" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="../user/view-profile.php">View Profile</a></li>
                    <li><a class="dropdown-item" href="../companyprofile/home.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <!-- Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
