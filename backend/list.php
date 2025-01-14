<?php
$kebaya = new Kebaya();

$listKebaya = $kebaya->create([
    'model' => $model,
    'deskripsi' => $deskripsi,
    'harga' => $harga,
    'stock' => $stock,
    'foto' => $foto,
    'size' => $size,
    'created_by' => $_SESSION['user_id'] ?? null,

]);
