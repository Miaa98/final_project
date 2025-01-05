<?php
include '../../database/db.php';

// Ambil kode_reservasi dari URL
$kode_reservasi = isset($_GET['kode_reservasi']) ? trim($_GET['kode_reservasi']) : '';

if (!empty($kode_reservasi)) {
    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $kode_reservasi)) {
        $error_message = "Kode reservasi tidak valid. Hanya boleh mengandung huruf, angka, tanda hubung (-), atau garis bawah (_).";
    } else {
        $query = "SELECT p.kode_reservasi, r.tanggal_mulai, r.tanggal_selesai, u.username, p.payment_method, p.total_harga, p.status 
                  FROM payments p 
                  JOIN reservations r ON p.kode_reservasi = r.kode_reservasi 
                  JOIN users u ON r.user_id = u.user_id 
                  WHERE p.kode_reservasi = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $kode_reservasi);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            $error_message = "Detail pembayaran tidak ditemukan untuk kode reservasi ini.";
        }

        $stmt->close();
    }
} else {
    $error_message = "Kode reservasi tidak ditemukan. Pastikan URL mengandung parameter kode_reservasi.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            font-size: 16px;
        }
        .container {
            max-width: 500px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            font-size: 26px;
            color: #333;
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            font-size: 18px;
        }
        th {
            font-weight: bold;
            color: #333;
            border-bottom: 2px solid #ddd;
        }
        td {
            border-bottom: 1px solid #ddd;
        }
        td strong {
            color: #555;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            font-size: 18px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
        }
        .alert {
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Detail Pembayaran</h1>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
    <?php else: ?>
        <table id="paymentDetails">
            <tr>
                <th>Kode Reservasi</th>
                <td><?php echo htmlspecialchars($row['kode_reservasi']); ?></td>
            </tr>
            <tr>
                <th>Metode Pembayaran</th>
                <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
            </tr>
            <tr>
                <th>Total Harga</th>
                <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th>Status Pembayaran</th>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
            </tr>
            <tr>
                <th>Tanggal Mulai</th>
                <td><?php echo date('d M Y', strtotime($row['tanggal_mulai'])); ?></td>
            </tr>
            <tr>
                <th>Tanggal Selesai</th>
                <td><?php echo date('d M Y', strtotime($row['tanggal_selesai'])); ?></td>
            </tr>
            <tr>
                <th>Nama Pengguna</th>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
            </tr>
        </table>
    
        <div class="footer">
            <a href="../../admin/reservasi-admin.php" class="btn">
                <i class="fas fa-home"></i>
            </a>
            <button onclick="downloadPDF()" class="btn">
                <i class="fas fa-file-pdf"></i>
            </button>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        
        doc.setFont('Poppins');
        doc.setFontSize(18);
        doc.text('Detail Pembayaran', 10, 10);

        const table = document.getElementById("paymentDetails");
        const rows = table.rows;

        let yPosition = 20;
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const col1 = row.cells[0].innerText;
            const col2 = row.cells[1].innerText;
            
            doc.text(`${col1}: ${col2}`, 10, yPosition);
            yPosition += 8;
        }

        doc.save('detail_pembayaran.pdf');
    }
</script>

</body>
</html>
