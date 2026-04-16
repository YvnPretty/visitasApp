<?php
session_start();
include_once 'db.php';
include_once 'Visita.php';

if (isset($_GET['id'])) {
    $database = new Database();
    $db = $database->getConnection();
    
    $visita = new Visita($db);
    $visita->id = $_GET['id'];
    
    if ($visita->eliminar()) {
        $_SESSION['mensaje'] = "Registro de visita eliminado.";
        $_SESSION['tipo_mensaje'] = "warning";
    } else {
        $_SESSION['mensaje'] = "Error al eliminar el registro.";
        $_SESSION['tipo_mensaje'] = "danger";
    }
}

header("Location: index.php");
exit();
?>
