<?php
class Database {
    private $host = "localhost";
    private $db_name = "sistema_visitas";
    private $username = "visitas_user";
    private $password = "visitas123";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

// Clase Modelo Visita
// Maneja las operaciones CRUD (Crear, Leer, Actualizar, Eliminar)
// aplicando Programación Orientada a Objetos (POO).
class Visita {
    // Propiedades de base de datos
    private $conn, $table_name = "visitas";
    
    // Propiedades del objeto Visita
    public $id, $nombre_completo, $persona_visitada, $fecha, $hora_entrada, $hora_salida;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) { $this->conn = $db; }

    // Registra una nueva visita en la base de datos (CREATE)
    // Utiliza sentencias preparadas (arreglos) para prevenir inyección SQL
    public function crear() {
        $stmt = $this->conn->prepare("INSERT INTO {$this->table_name} (nombre_completo, persona_visitada, fecha, hora_entrada, hora_salida) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$this->nombre_completo, $this->persona_visitada, $this->fecha, $this->hora_entrada, empty($this->hora_salida) ? null : $this->hora_salida]);
    }

    // Obtiene el historial de visitas, opcionalmente filtrando por nombre o fecha (READ)
    public function obtenerTodas($busqueda = "") {
        $query = "SELECT * FROM {$this->table_name} " . ($busqueda ? "WHERE nombre_completo LIKE ? OR fecha LIKE ?" : "") . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($busqueda ? ["%$busqueda%", "%$busqueda%"] : []);
        return $stmt;
    }

    // Busca los datos de un visitante específico por su ID paramétrico
    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE id = ?");
        $stmt->execute([$id]);
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            foreach($row as $key => $val) $this->$key = $val;
        }
    }

    // Actualiza el registro, especialmente útil para asignar la hora_salida (UPDATE)
    public function actualizar() {
        $stmt = $this->conn->prepare("UPDATE {$this->table_name} SET nombre_completo=?, persona_visitada=?, fecha=?, hora_entrada=?, hora_salida=? WHERE id=?");
        return $stmt->execute([$this->nombre_completo, $this->persona_visitada, $this->fecha, $this->hora_entrada, empty($this->hora_salida) ? null : $this->hora_salida, $this->id]);
    }

    // Elimina el registro por completo de la base de datos (DELETE)
    public function eliminar() {
        return $this->conn->prepare("DELETE FROM {$this->table_name} WHERE id = ?")->execute([$this->id]);
    }
}
?>
