<?php
class Database {
    private $host = "localhost";
    private $db_name = "sistema_visitas";
    private $username = "visitas_user";
    private $password = "visitas123";
    private static $instance = null;
    public $conn;

    private function __construct() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            // In a production environment, you might want to log this instead of echoing
            error_log("Connection error: " . $exception->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
