<?php
session_start();
require_once 'config/Database.php';
require_once 'models/Visita.php';

$db = Database::getInstance()->getConnection();
$vm = new Visita($db);
$visitas = $vm->obtenerTodas($_GET['buscar'] ?? "");

include 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0" style="color: white; text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">Panel de Control</h2>
    <div class="btn-group shadow-sm">
        <a href="create.php" class="btn btn-primary px-4"><i class="bi bi-plus-lg"></i> Registrar</a>
        <a href="export_pdf.php?buscar=<?= $_GET['buscar'] ?? '' ?>" class="btn btn-danger px-3"><i class="bi bi-file-pdf"></i></a>
    </div>
</div>

<?php if(isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?> alert-dismissible fade show border-0 shadow-sm" style="background: var(--glass-bg); color: var(--text-color);">
        <?= $_SESSION['mensaje']; unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow overflow-hidden">
    <form class="p-3 d-flex gap-2" style="background: rgba(0,0,0,0.03);">
        <input type="text" name="buscar" class="form-control w-25 border-0 shadow-none" placeholder="Buscar visitante..." value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>" style="background: rgba(var(--bs-body-bg-rgb), 0.5);">
        <button class="btn btn-dark px-4 border-0" style="background: #34495e;"><i class="bi bi-search"></i></button>
    </form>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-custom-header">
                <tr>
                    <th class="ps-3 py-3">VISITANTE / DESTINO</th>
                    <th>FECHA</th>
                    <th>HORARIOS</th>
                    <th class="text-center">ESTADO</th>
                    <th class="text-center pe-3">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($visitas as $v): ?>
                <tr>
                    <td class="ps-3 py-3">
                        <div class="fw-bold" style="color: #3498db;"><?= htmlspecialchars($v->nombre_completo) ?></div>
                        <small class="opacity-75"><?= htmlspecialchars($v->persona_visitada) ?></small>
                    </td>
                    <td><?= $v->fecha ?></td>
                    <td><small><?= $vm->formatHora($v->hora_entrada) ?> <i class="bi bi-arrow-right mx-1 opacity-50"></i> <?= $vm->formatHora($v->hora_salida) ?></small></td>
                    <td class="text-center"><?php $vm->hora_salida = $v->hora_salida; echo $vm->getEstadoBadge(); ?></td>
                    <td class="text-center pe-3">
                        <div class="btn-group btn-group-sm">
                            <a href="edit.php?id=<?= $v->id ?>" class="btn btn-light shadow-sm text-primary"><i class="bi bi-pencil-square"></i></a>
                            <a href="delete.php?id=<?= $v->id ?>" class="btn btn-light shadow-sm text-danger" onclick="return confirm('¿Eliminar?')"><i class="bi bi-trash-fill"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($visitas)): ?><tr><td colspan="5" class="text-center py-5 opacity-50">No hay registros hoy.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
