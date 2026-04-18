<?php
class Visita {
    private $conn;
    private $table_name = "visitas";

    public $id, $nombre_completo, $persona_visitada, $fecha, $hora_entrada, $hora_salida;

    public function __construct($db) {
        $this->conn = $db;
    }

    // --- Lógica de Negocio (CRUD) ---

    public function crear() {
        if($this->validar()) {
            $query = "INSERT INTO $this->table_name (nombre_completo, persona_visitada, fecha, hora_entrada) VALUES (?, ?, ?, ?)";
            return $this->conn->prepare($query)->execute([
                htmlspecialchars(strip_tags($this->nombre_completo)),
                htmlspecialchars(strip_tags($this->persona_visitada)),
                $this->fecha,
                $this->hora_entrada
            ]);
        }
        return false;
    }

    public function obtenerTodas($busqueda = "") {
        $query = "SELECT * FROM $this->table_name";
        $params = [];
        if ($busqueda) {
            $query .= " WHERE nombre_completo LIKE ? OR fecha LIKE ?";
            $params = ["%$busqueda%", "%$busqueda%"];
        }
        $query .= " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ); // Retornamos Objetos para mejor POO
    }

    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table_name WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            foreach($row as $key => $val) $this->$key = $val;
            return true;
        }
        return false;
    }

    public function actualizar() {
        $query = "UPDATE $this->table_name SET nombre_completo=?, persona_visitada=?, fecha=?, hora_entrada=?, hora_salida=? WHERE id=?";
        return $this->conn->prepare($query)->execute([
            htmlspecialchars(strip_tags($this->nombre_completo)),
            htmlspecialchars(strip_tags($this->persona_visitada)),
            $this->fecha, $this->hora_entrada, $this->hora_salida, $this->id
        ]);
    }

    public function eliminar($id) {
        return $this->conn->prepare("DELETE FROM $this->table_name WHERE id = ?")->execute([$id]);
    }

    // --- Helpers de Presentación (Buenas Prácticas) ---

    private function validar() {
        return !empty($this->nombre_completo) && !empty($this->persona_visitada);
    }

    public function getEstadoBadge() {
        if ($this->hora_salida == NULL) {
            return '<span class="badge bg-success-subtle text-success p-2">🟢 Dentro</span>';
        }
        return '<span class="badge bg-secondary-subtle text-secondary p-2">🔴 Fuera</span>';
    }

    public function formatHora($hora) {
        return $hora ? date('H:i', strtotime($hora)) : '--:--';
    }
}
?>
