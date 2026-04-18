<?php
session_start();
include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="fw-bold mb-4 text-center">Registrar Ingreso</h2>
        <div class="card shadow-sm border-0 p-4">
            <form action="store.php" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">DATOS DEL VISITANTE</label>
                    <input type="text" name="nombre_completo" class="form-control mb-2" placeholder="Nombre completo" required autofocus>
                    <input type="text" name="persona_visitada" class="form-control" placeholder="Persona o Depto a visitar" required>
                </div>
                
                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label small fw-bold text-secondary">FECHA</label>
                        <input type="date" name="fecha" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold text-secondary">HORA ENTRADA</label>
                        <input type="time" name="hora_entrada" class="form-control" value="<?= date('H:i') ?>" required>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">Confirmar Acceso</button>
                    <a href="index.php" class="btn btn-link text-secondary">Volver al listado</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
