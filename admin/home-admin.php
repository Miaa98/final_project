<?php
session_start();
include '../database/db.php'; // Sertakan file koneksi

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login-user.php");
    exit();
}

$data = [];

// Query Total User
$query = "SELECT COUNT(*) AS total_user FROM users";
$result = $conn->query($query);
$data['total_user'] = $result->fetch_assoc()['total_user'] ?? 0;

// Query Total Kebaya
$query = "SELECT COUNT(*) AS total_kebaya FROM products WHERE jenis = 'kebaya'";
$result = $conn->query($query);
$data['total_kebaya'] = $result->fetch_assoc()['total_kebaya'] ?? 0;

// Query Total Sewa
$query = "SELECT COUNT(*) AS total_sewa FROM reservations";
$result = $conn->query($query);
$data['total_sewa'] = $result->fetch_assoc()['total_sewa'] ?? 0;

// Query Total Revenue
$query = "SELECT SUM(total_harga) AS total_revenue FROM payments";
$result = $conn->query($query);
$data['total_revenue'] = $result->fetch_assoc()['total_revenue'] ?? 0;

// Grafik Penyewaan dan Pendapatan
$rental_chart = [];
$query = "SELECT MONTH(tanggal_mulai) AS month, COUNT(*) AS count FROM reservations GROUP BY MONTH(tanggal_mulai)";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $rental_chart[] = $row;
}

$revenue_chart = [];
$query = "SELECT MONTH(payment_date) AS month, SUM(total_harga) AS revenue FROM payments GROUP BY MONTH(payment_date)";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $revenue_chart[] = $row;
}

// Tabel Barang Terfavorit
$barang_favorit = [];
$query = "SELECT nama AS barang, COUNT(id_produk) AS jumlah_penyewaan FROM reservations JOIN products ON id_produk = product_id GROUP BY id_produk ORDER BY jumlah_penyewaan DESC LIMIT 3";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $barang_favorit[] = $row;
}

$customer_favorit = [];
$query = "SELECT u.username AS customer, COUNT(r.user_id) AS jumlah_penyewaan 
          FROM reservations r
          JOIN users u ON r.user_id = u.user_id 
          GROUP BY r.user_id 
          ORDER BY jumlah_penyewaan DESC 
          LIMIT 3";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $customer_favorit[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Great+Vibes&family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css' rel='stylesheet' />

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Styling for page */
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
        }

        .container {
            max-width: 1400px !important;
            margin-top: 15px;
            margin-bottom: 10px;
            padding: 12px !important;
            background-color: #fff;
            border-radius: 8px;
        }

        .canvas {
            margin: 20px 0;
            width: 100%;
            max-width: 800px !important;
        }

        #calendar {
            margin-top: 20px;
        }

        h1 {
            color: #524A4E;
        }

        h2 {
            text-align: center;
            margin-bottom: 1rem;
            font-size: 2rem;
        }

        h3 {
            margin-top: 20px;
            text-align: center;
        }

        /* Styling for chart containers */
        .chart-container {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }

        /* Table styling for favorite items */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 !important;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #524A4E;
            color: #fff;
        }

        td {
            background-color: #f9f9f9;
        }

        /* kolom user */
        .row {
            margin-bottom: 20px;
        }

        .col {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            background-color: #f9f9f9;
            margin-right: 10px;
        }

        .col:last-child {
            margin-right: 0;
        }

        h5 {
            margin-bottom: 10px;
        }

        .mb-4 {
            margin-bottom: 20px;
        }

        #yearSelect {
            padding: 5px;
            font-size: 16px;
        }

        .bg-0 {
            margin: 0 !important;
            background: none !important;
        }
    </style>
</head>

<?php include 'navbar-admin.php'; ?>

<body>
    <div class="container">
        <h2>Dashboard</h2>

        <!-- Kolom untuk Total User, Total Kebaya, Total Sewa, Total Revenue -->
        <div class="row">
            <div class="col text-center" style="margin: 10px 15px 10px 15px;">
                <h5>Total User</h5>
                <p id="totalUser"><?php echo $data['total_user']; ?></p>
            </div>
            <div class="col text-center" style="margin: 10px 15px 10px 0px;">
                <h5>Total Kebaya</h5>
                <p id="totalKebaya"><?php echo $data['total_kebaya']; ?></p>
            </div>
            <div class="col text-center" style="margin: 10px 15px 10px 0px;">
                <h5>Total Sewa</h5>
                <p id="totalSewa"><?php echo $data['total_sewa']; ?></p>
            </div>
            <div class="col text-center" style="margin: 10px 15px 10px 0px;">
                <h5>Total Revenue</h5>
                <p id="totalRevenue"><?php echo number_format($data['total_revenue']); ?></p>
            </div>
        </div>

        <!-- Grafik Penyewaan dan Grafik Pendapatan di posisi kiri dan kanan -->
        <div class="chart-container">
            <div style="width: 48%">
                <canvas id="rentalChart"></canvas>
            </div>
            <div style="width: 48%">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Kalender Update -->
        <div id='calendar'></div>

        <!-- Tabel untuk Barang Paling Sering Disewa dan Customer Paling Sering Sewa -->
        <h3>Barang Paling Sering Disewa dan Customer Paling Sering Sewa</h3>
        <div class="row bg-0">
            <!-- Tabel Barang Paling Sering Disewa -->
            <div class="col" style="border: none; background: none; padding: 0;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Barang</th>
                            <th>Jumlah Penyewaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($barang_favorit as $index => $barang): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $barang['barang']; ?></td>
                            <td><?php echo $barang['jumlah_penyewaan']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tabel Customer Paling Sering Sewa -->
            <div class="col" style="border: none; background: none; padding: 0;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Customer</th>
                            <th>Jumlah Penyewaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customer_favorit as $index => $customer): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $customer['customer']; ?></td>
                            <td><?php echo $customer['jumlah_penyewaan']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3.3 JS and FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/list@5.10.1/main.min.js"></script>

    <script>
        // Menampilkan Chart.js
        const rentalData = <?php echo json_encode($rental_chart); ?>;
        const revenueData = <?php echo json_encode($revenue_chart); ?>;

        const rentalLabels = rentalData.map(item => `Bulan ${item.month}`);
        const rentalCounts = rentalData.map(item => item.count);

        const revenueLabels = revenueData.map(item => `Bulan ${item.month}`);
        const revenueAmounts = revenueData.map(item => item.revenue);

        // Grafik Penyewaan
        const ctxRental = document.getElementById('rentalChart').getContext('2d');
        const rentalChart = new Chart(ctxRental, {
            type: 'bar',
            data: {
                labels: rentalLabels,
                datasets: [{
                    label: 'Jumlah Penyewaan',
                    data: rentalCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Grafik Pendapatan
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Pendapatan',
                    data: revenueAmounts,
                    fill: false,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    tension: 0.1
                }]
            }
        });
    </script>
</body>

</html>
