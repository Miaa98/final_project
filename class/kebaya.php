<?php
require_once 'database.php';

class Kebaya
{
    protected $conn;
    protected $table = 'hsl_kebaya';

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function list()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
