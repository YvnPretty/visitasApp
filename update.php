<?php
session_start();
require_once 'config/Database.php';
require_once 'models/Visita.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = Database::getInstance();
    $db = $database->getConnection();
    $visita = new Visita($db);

    $visita->id = $_POST['id'];
    $visita->nombre_completo = $_POST['nombre_completo'];
    $visita->persona_visitada = $_POST['persona_visitada'];
    $visita->fecha = $_POST['fecha'];
    $visita->hora_entrada = $_POST['hora_entrada'];
    $visita->hora_salida = $_POST['hora_salida'];

    if ($visita->actualizar()) {
        $_SESSION['mensaje'] = "Salida registrada con éxito";
        $_SESSION['tipo_mensaje'] = "success";
    } else {
        $_SESSION['mensaje'] = "Error al actualizar el registro";
        $_SESSION['tipo_mensaje'] = "danger";
    }
}
header("Location: index.php");
exit();
?>
