<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGV - Control de Accesos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script>
        document.documentElement.setAttribute('data-bs-theme', localStorage.getItem('theme') || 'light');
    </script>
    <style>
        :root {
            --glass-bg: rgba(255, 255, 255, 0.7);
            --text-color: #34495e;
            --soft-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        [data-bs-theme="dark"] {
            --glass-bg: rgba(30, 30, 35, 0.65);
            --text-color: #f1f2f6;
            --soft-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        body { 
            background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('fondo.jpeg') no-repeat center center fixed; 
            background-size: cover; 
            min-height: 100vh;
            color: var(--text-color);
            transition: all 0.5s ease;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        /* Navbar invisible, solo burbujas flotantes */
        .navbar { 
            background: transparent !important; 
            box-shadow: none !important;
            margin-top: 20px;
        }

        /* Estilo Burbuja para Logo y Botón */
        .navbar-brand, #themeToggle { 
            background: var(--glass-bg) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 50px !important;
            box-shadow: var(--soft-shadow) !important;
            padding: 10px 25px !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            color: var(--text-color) !important;
            display: flex;
            align-items: center;
        }

        /* Tarjetas con bordes ultra suaves */
        .card { 
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 35px;
            box-shadow: var(--soft-shadow);
            padding: 15px;
        }

        .btn-primary { 
            background: #3498db; 
            border-radius: 50px; 
            border: none;
            padding: 12px 30px;
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .form-control {
            border-radius: 20px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(0,0,0,0.05);
            padding: 12px 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-shield-check text-primary me-2"></i> VISIT APP
            </a>
            
            <button class="btn fw-bold" id="themeToggle">
                <i class="bi bi-circle-half me-2 text-primary"></i> Tema
            </button>
        </div>
    </nav>
    <main class="container py-4">
