<?php
session_start();
include '../database/db.php'; // Sertakan file koneksi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepared statement untuk menghindari SQL Injection
    $query = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Simpan data pengguna dalam sesi
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user'] = $user;
            $_SESSION['role'] = $user['role']; // Menyimpan role pengguna dalam sesi

            // Redirect berdasarkan role
            if ($user['role'] == 'admin') {
                header("Location: ../admin/home-admin.php"); // Redirect ke halaman admin
            } else {
                header("Location: dashboard-user.php"); // Redirect ke halaman user
            }
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak terdaftar!";
    }
}



mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background: url("../img/bg.jpg");
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            border: 5px solid #333;
            box-sizing: border-box;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .alert {
            padding: 0.5rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid #ff6b6b;
            border-radius: 5px;
            background-color: #ff8787;
            color: #fff;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }

        h2 {
            margin-bottom: 1.5rem;
            color: #000;
        }

        label {
            font-weight: bold;
            margin-bottom: 0.5rem;
            display: block;
        }

        input[type="email"],
        input[type="password"] {
            width: 80%;
            padding: 0.50rem;
            border: 1px solid #333;
            border-radius: 3px;
            outline: none;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        button {
            background-color: #333;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #fff;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Form Login</h2>

        <!-- Menampilkan pesan error jika ada -->
        <?php if (isset($error)) {
            echo "<div class='alert'>$error</div>";
        } ?>

        <form action="login-user.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <button type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="register-user.php">Daftar di sini</a></p>
    </div>

</body>

</html>