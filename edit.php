<?php
include_once 'db.php';
include_once 'Visita.php';

$visita = new Visita((new Database())->getConnection());
if(empty($_GET['id'])) die(header("Location: index.php"));
$visita->obtenerPorId($_GET['id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Salida Institucional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>body{background:#f4f6f9;font-family:'Segoe UI',sans-serif;}.form-control, .btn, .card{border-radius:0;}</style>
</head>
<body>
    <div class="container mt-5" style="max-width:600px;">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-secondary text-white text-uppercase" style="border-radius:0;"><i class="bi bi-clock-history"></i> Gestión de Salida</div>
            <div class="card-body p-4 bg-white">
                <form action="update.php" method="POST">
                    <input type="hidden" name="id" value="<?= $visita->id ?>">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label small text-uppercase text-secondary fw-bold">Visitante</label>
                            <input type="text" class="form-control form-control-sm bg-light" name="nombre_completo" value="<?= htmlspecialchars($visita->nombre_completo) ?>" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-uppercase text-secondary fw-bold">Visitado</label>
                            <input type="text" class="form-control form-control-sm bg-light" name="persona_visitada" value="<?= htmlspecialchars($visita->persona_visitada) ?>" readonly>
                        </div>
                    </div>
                    <div class="row mb-4 bg-light border p-2 m-0 mt-3 align-items-center">
                        <div class="col-4 p-1">
                            <label class="form-label small text-uppercase text-secondary fw-bold m-0">Fecha Reg</label>
                            <input type="date" class="form-control form-control-sm border-0 fw-bold bg-transparent" name="fecha" value="<?= $visita->fecha ?>" readonly>
                        </div>
                        <div class="col-4 p-1 border-start">
                            <label class="form-label small text-uppercase text-secondary fw-bold m-0">Entrada</label>
                            <input type="time" class="form-control form-control-sm border-0 fw-bold bg-transparent text-success" name="hora_entrada" value="<?= date('H:i', strtotime($visita->hora_entrada)) ?>" readonly>
                        </div>
                        <div class="col-4 p-1 border-start">
                            <label class="form-label small text-uppercase text-secondary fw-bold m-0">Salida Real</label>
                            <?php $hs = $visita->hora_salida ? date('H:i', strtotime($visita->hora_salida)) : date('H:i'); ?>
                            <input type="time" class="form-control form-control-sm <?= $visita->hora_salida ? 'text-secondary bg-transparent border-0' : 'border border-primary' ?> fw-bold" name="hora_salida" value="<?= $hs ?>" <?= $visita->hora_salida ? 'readonly' : '' ?>>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Atrás</a>
                        <?php if(!$visita->hora_salida): ?>
                            <button type="submit" class="btn btn-dark btn-sm"><i class="bi bi-save2"></i> Confirmar Salida</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-dark btn-sm" disabled><i class="bi bi-lock-fill"></i> Salida Ya Registrada</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
