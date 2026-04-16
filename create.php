<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingreso Institucional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>body{background:#f4f6f9;font-family:'Segoe UI',sans-serif;}.form-control, .btn, .card{border-radius:0;}</style>
</head>
<body>
    <div class="container mt-5" style="max-width:600px;">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white text-uppercase" style="border-radius:0;"><i class="bi bi-person-fill-add"></i> Registrar Nuevo Ingreso</div>
            <div class="card-body p-4 bg-white">
                <form action="store.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small text-uppercase text-secondary fw-bold">Nombre del Visitante</label>
                        <input type="text" class="form-control form-control-sm" name="nombre_completo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-uppercase text-secondary fw-bold">Autorizado o Solicitado Por</label>
                        <input type="text" class="form-control form-control-sm" name="persona_visitada" required>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <label class="form-label small text-uppercase text-secondary fw-bold">Fecha Reg.</label>
                            <input type="date" class="form-control form-control-sm bg-light" name="fecha" value="<?= date('Y-m-d') ?>" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-uppercase text-secondary fw-bold">Hora Entrada</label>
                            <input type="time" class="form-control form-control-sm bg-light" name="hora_entrada" value="<?= date('H:i') ?>" readonly>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Cancelar</a>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-save2"></i> Confirmar Acceso</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
