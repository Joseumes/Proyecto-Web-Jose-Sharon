<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . '/../private/db.php';

// Verificar si la conexión está establecida
if (!isset($conn) || $conn->connect_error) {
    die("Error de conexión a la base de datos");
}

// Obtener estadísticas
$error = null;
try {
    // Habitaciones ocupadas
    $result = $conn->query("SELECT COUNT(*) as ocupadas FROM HABITACION WHERE estado = 'ocupada'");
    $row = $result->fetch_assoc();
    $ocupadas = $row['ocupadas'];
    
    $result = $conn->query("SELECT COUNT(*) as total FROM HABITACION");
    $row = $result->fetch_assoc();
    $total_habitaciones = $row['total'];
    $porcentaje_ocupacion = ($total_habitaciones > 0) ? round(($ocupadas / $total_habitaciones) * 100, 2) : 0;
    
    // Ingresos del día
    $result = $conn->query("SELECT SUM(total_pagado) as ingresos FROM HOSPEDAJE WHERE DATE(fecha_checkin) = CURDATE()");
    $row = $result->fetch_assoc();
    $ingresos_hoy = $row['ingresos'] ?? 0;
    
    // Clientes activos
    $result = $conn->query("SELECT COUNT(*) as activos FROM HOSPEDAJE WHERE fecha_checkout IS NULL");
    $row = $result->fetch_assoc();
    $clientes_activos = $row['activos'];
    
    // Últimos clientes registrados
    $ultimos_clientes = [];
    $result = $conn->query("SELECT c.nombre, c.nit, h.numero_habitacion as numero, h.fecha_checkin, h.total_pagado 
                           FROM HOSPEDAJE h 
                           JOIN CLIENTE c ON h.id_cliente = c.id 
                           ORDER BY h.fecha_checkin DESC LIMIT 5");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $ultimos_clientes[] = $row;
        }
    }
} catch(Exception $e) {
    $error = "Error al obtener datos: " . $e->getMessage();
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
        body {
            background-color: #f8f9fa;
        }
        .main-content {
            background-color: #ffffff;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include('sidebar.php'); ?>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4 main-content">
                <h2 class="mb-4"><i class="fas fa-tachometer-alt me-2"></i> Panel de Control</h2>
                
                <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card card-summary bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Habitaciones Ocupadas</h5>
                                <h2 class="card-text"><?php echo $ocupadas; ?>/<?php echo $total_habitaciones; ?></h2>
                                <p class="card-text"><?php echo $porcentaje_ocupacion; ?>% de ocupación</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card card-summary bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Ingresos Hoy</h5>
                                <h2 class="card-text">Q<?php echo number_format($ingresos_hoy, 2); ?></h2>
                                <p class="card-text">Total del día</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card card-summary bg-warning text-dark">
                            <div class="card-body">
                                <h5 class="card-title">Clientes Activos</h5>
                                <h2 class="card-text"><?php echo $clientes_activos; ?></h2>
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
                                    <?php foreach($ultimos_clientes as $cliente): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                                        <td><?php echo htmlspecialchars($cliente['nit']); ?></td>
                                        <td><?php echo htmlspecialchars($cliente['numero']); ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($cliente['fecha_checkin'])); ?></td>
                                        <td>Q<?php echo number_format($cliente['total_pagado'], 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
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