<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Hotel El Paraíso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .card-summary {
            transition: transform 0.3s;
        }
        .card-summary:hover {
            transform: translateY(-5px);
        }
        .sidebar {
            min-height: 100vh;
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 d-md-block sidebar bg-light p-3">
                <div class="text-center mb-4">
                    <img src="../assets/img/logo.png" alt="Logo" width="80">
                    <h5 class="mt-2">Hotel El Paraíso</h5>
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registrar_cliente.php">
                            <i class="fas fa-user-plus me-2"></i> Registrar Cliente
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="habitaciones.php">
                            <i class="fas fa-bed me-2"></i> Habitaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="actualizar_cargos.php">
                            <i class="fas fa-money-bill-wave me-2"></i> Actualizar Cargos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="salida_cliente.php">
                            <i class="fas fa-sign-out-alt me-2"></i> Salida Cliente
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <a class="nav-link text-danger" href="logout.php">
                            <i class="fas fa-power-off me-2"></i> Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="mb-4"><i class="fas fa-tachometer-alt me-2"></i> Panel de Control</h2>
                
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card card-summary bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Habitaciones Ocupadas</h5>
                                <h2 class="card-text">5/8</h2>
                                <p class="card-text">62.5% de ocupación</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card card-summary bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Ingresos Hoy</h5>
                                <h2 class="card-text">Q1,750.00</h2>
                                <p class="card-text">Total del día</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card card-summary bg-warning text-dark">
                            <div class="card-body">
                                <h5 class="card-title">Clientes Activos</h5>
                                <h2 class="card-text">5</h2>
                                <p class="card-text">En el hotel</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-users me-2"></i> Últimos Clientes Registrados</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>NIT</th>
                                        <th>Habitación</th>
                                        <th>Fecha Ingreso</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Juan Pérez</td>
                                        <td>1234567-8</td>
                                        <td>101</td>
                                        <td>2023-10-15</td>
                                        <td>Q700.00</td>
                                    </tr>
                                    <tr>
                                        <td>María Gómez</td>
                                        <td>8765432-1</td>
                                        <td>102</td>
                                        <td>2023-10-14</td>
                                        <td>Q1,050.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>