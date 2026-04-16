<?php
// Controlador para Registrar Datos (CREATE)
// Recibe los datos por POST y gestiona el flujo del modelo
session_start();
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $visita = new Visita((new Database())->getConnection());
    
    // Validación estricta iterativa de campos obligatorios
    foreach(['nombre_completo', 'persona_visitada', 'fecha', 'hora_entrada'] as $f) {
        if(empty(trim($_POST[$f]))) die(header("Location: index.php?error=FaltanDatos"));
        $visita->$f = htmlspecialchars(trim($_POST[$f]));
    }
    
    if(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\.]+$/", $visita->nombre_completo)) die(header("Location: index.php?error=NombreInvalido"));
    
    if($visita->crear()){
        $_SESSION['mensaje'] = "Registro agregado correctamente.";
        $_SESSION['tipo_mensaje'] = "success";
    }
    header("Location: index.php");
}
?>
