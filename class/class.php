<?php
class Kebaya
{
    private $conn;
    private $table = 'hsl_kebaya';

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function create($data)
    {
        $query = "INSERT INTO " . $this->table . " (model, deskripsi, harga, stock, foto, size, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssdisis", $data['model'], $data['deskripsi'], $data['harga'], $data['stock'], $data['foto'], $data['size'], $data['created_by']);
        return $stmt->execute();
    }

    public function list()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
