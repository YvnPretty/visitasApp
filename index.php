<?php
session_start();
include_once 'db.php';

$busqueda = $_GET['buscar'] ?? "";
$stmt = (new Visita((new Database())->getConnection()))->obtenerTodas($busqueda);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Visitantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { border-bottom: 3px solid #0056b3; }
        .box-shadow { box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .table th { background-color: #343a40 !important; color: #fff; font-weight: 500; }
        .table td { vertical-align: middle; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container-fluid px-4">
            <span class="navbar-brand mb-0 h1"><i class="bi bi-building"></i> Control de Accesos Institucional</span>
        </div>
    </nav>
    <div class="container-fluid px-4">
        <?php if(isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?> alert-dismissible rounded-0" role="alert">
                <?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger rounded-0">Error operativo: <?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <div class="card rounded-0 box-shadow p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 text-secondary">Registro</h4>
                <div class="btn-group">
                    <button onclick="generarPDF()" class="btn btn-outline-danger btn-sm rounded-0"><i class="bi bi-file-pdf"></i> PDF</button>
                    <a href="create.php" class="btn btn-primary btn-sm rounded-0"><i class="bi bi-person-plus"></i> Ingreso</a>
                </div>
            </div>
            
            <form action="" method="GET" class="mb-3">
                <div class="input-group input-group-sm w-50">
                    <input type="text" name="buscar" class="form-control rounded-0" placeholder="Filtrar por nombre o fecha..." value="<?php echo htmlspecialchars($busqueda); ?>">
                    <button class="btn btn-dark rounded-0" type="submit"><i class="bi bi-funnel"></i></button>
                    <?php if($busqueda) echo '<a href="index.php" class="btn btn-secondary rounded-0"><i class="bi bi-x"></i></a>'; ?>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered mb-0">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th>Visitante</th>
                            <th>Departamento/Persona</th>
                            <th width="10%">Fecha</th>
                            <th width="10%">Hora Entrada</th>
                            <th width="10%">Hora Salida</th>
                            <th width="10%" class="text-center">Estado</th>
                            <th width="10%" class="text-center">Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($r = $stmt->fetch()): ?>
                            <tr>
                                <td><?= $r['id'] ?></td>
                                <td><?= htmlspecialchars($r['nombre_completo']) ?></td>
                                <td><?= htmlspecialchars($r['persona_visitada']) ?></td>
                                <td><?= $r['fecha'] ?></td>
                                <td><?= date('H:i', strtotime($r['hora_entrada'])) ?></td>
                                <td><?= $r['hora_salida'] ? date('H:i', strtotime($r['hora_salida'])) : '--:--' ?></td>
                                <td class="text-center">
                                    <span class="badge rounded-0 bg-<?= $r['hora_salida'] ? 'secondary' : 'success'?>">
                                        <?= $r['hora_salida'] ? 'Finalizado' : 'En Instalaciones'?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?= $r['id'] ?>" class="btn btn-outline-primary btn-sm rounded-0 p-1 py-0"><i class="bi bi-clock-history"></i> Salida</a>
                                    <a href="delete.php?id=<?= $r['id'] ?>" onclick="return confirm('¿Confirma eliminación absoluta?');" class="btn btn-outline-danger btn-sm rounded-0 p-1 py-0"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php if($stmt->rowCount() == 0) echo "<tr><td colspan='8' class='text-center text-muted'>Sistema sin registros actuales.</td></tr>"; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
    function generarPDF() {
        var element = document.querySelector('.table-responsive');
        html2pdf().set({
          margin: 0.5,
          filename: 'Reporte_Visitas.pdf',
          jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
        }).from(element).save();
    }
    </script>
</body>
</html>
