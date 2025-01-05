<?php include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kebaya_id = $_POST['kebaya_id'];
    $name = $_POST['name'];
    $model = $_POST['model'];
    $description = $_POST['description'];

    // Menyimpan gambar
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_path = 'uploads' . $image;
    move_uploaded_file($image_tmp, $image_path);

    // Menyimpan data ke database
    $query = "INSERT INTO gallerys (kebaya_id, name, model, description, image) 
              VALUES ('$kebaya_id', '$name', '$model', '$description', '$image')";

    if ($conn->query($query) === TRUE) {
        echo "Produk berhasil disimpan.";
        header("Location: ../admin/gallery-admin.php"); // Redirect kembali ke halaman admin produk
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
