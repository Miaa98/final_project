<?php
session_start();
session_destroy(); // Hapus sesi
header("Location: ../companyprofile/home.php"); // Arahkan kembali ke halaman login
exit();
?>