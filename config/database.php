<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class Database
{
    private $host = 'localhost';
    private $db_name = 'luxwatch_db';
    private $username = 'root';
    private $password = 'root';
    private $port = '8888'; // MAMP default port
    public $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
