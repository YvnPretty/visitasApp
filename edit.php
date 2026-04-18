<?php
session_start();
require_once 'config/Database.php';
require_once 'models/Visita.php';

$db = Database::getInstance()->getConnection();
$v = new Visita($db);

// Si no hay ID o el registro no existe, fuera.
if (!isset($_GET['id']) || !$v->obtenerPorId($_GET['id'])) {
    header("Location: index.php?error=NoEncontrado"); exit;
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="fw-bold mb-4 text-center">Editar Registro</h2>
        <div class="card shadow-sm border-0 p-4">
            <form action="update.php" method="POST">
                <input type="hidden" name="id" value="<?= $v->id ?>">
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">VISITANTE / DESTINO</label>
                    <input type="text" name="nombre_completo" class="form-control mb-2" value="<?= htmlspecialchars($v->nombre_completo) ?>" required>
                    <input type="text" name="persona_visitada" class="form-control" value="<?= htmlspecialchars($v->persona_visitada) ?>" required>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label small fw-bold">ENTRADA</label>
                        <input type="date" name="fecha" class="form-control mb-2" value="<?= $v->fecha ?>" required>
                        <input type="time" name="hora_entrada" class="form-control" value="<?= date('H:i', strtotime($v->hora_entrada)) ?>" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold text-primary">SALIDA</label>
                        <input type="time" name="hora_salida" class="form-control border-primary" value="<?= $v->hora_salida ? date('H:i', strtotime($v->hora_salida)) : date('H:i') ?>">
                        <small class="text-muted">Ajuste hora de retiro</small>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">Actualizar Registro</button>
                    <a href="index.php" class="btn btn-link text-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
