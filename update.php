<?php
// Controlador de Actualización (UPDATE)
// Utilizado primariamente para registrar la salida del visitante
session_start();
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['id'])) {
    $visita = new Visita((new Database())->getConnection());
    $visita->id = $_POST['id'];
    
    // Comprobación segura usando ciclos foreach
    foreach(['nombre_completo', 'persona_visitada', 'fecha', 'hora_entrada'] as $f) {
        if(empty(trim($_POST[$f]))) die(header("Location: index.php?error=FaltanDatos"));
        $visita->$f = htmlspecialchars(trim($_POST[$f]));
    }
    
    if(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\.]+$/", $visita->nombre_completo)) die(header("Location: index.php?error=NombreInvalido"));
    
    $visita->hora_salida = empty($_POST['hora_salida']) ? NULL : $_POST['hora_salida'];
    
    if($visita->actualizar()){
        $_SESSION['mensaje'] = "Registro actualizado exitosamente.";
        $_SESSION['tipo_mensaje'] = "info";
    }
    header("Location: index.php");
}
?>
