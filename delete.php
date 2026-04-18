<?php
session_start();
require_once 'config/Database.php';
require_once 'models/Visita.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $database = Database::getInstance();
    $db = $database->getConnection();
    $visita = new Visita($db);

    // Corregido: Pasar el ID directamente al método eliminar
    if ($visita->eliminar($id)) {
        $_SESSION['mensaje'] = "Registro eliminado con éxito";
        $_SESSION['tipo_mensaje'] = "success";
    } else {
        $_SESSION['mensaje'] = "Error al intentar eliminar";
        $_SESSION['tipo_mensaje'] = "danger";
    }
}
header("Location: index.php");
exit();
?>
