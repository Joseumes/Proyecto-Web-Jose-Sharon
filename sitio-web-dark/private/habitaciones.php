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
    <title>Habitaciones - Hotel El Paraíso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css ">
    <style>
        .room-card {
            transition: transform 0.3s;
            height: 100%;
        }
        .room-card:hover {
            transform: translateY(-5px);
        }
        .occupied {
            border-left: 5px solid #dc3545;
        }
        .available {
            border-left: 5px solid #28a745;
        }
    </style>
</head>
<body class="bg-dark text-white">

<div class="container-fluid">
    <div class="row">
        <?php include('sidebar.php'); ?>

        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-4"><i class="fas fa-bed me-2"></i> Gestión de Habitaciones</h2>

            <div class="row g-4">
                <?php
                // Incluir conexión a la base de datos
                require_once __DIR__ . '/../private/db.php';

                // Consultar todas las habitaciones y clientes asociados
                $query = "
                    SELECT 
                        h.Numero, 
                        h.Estado, 
                        h.Distancia_Salida AS distancia_salida, 
                        c.Nombre AS Cliente,
                        c.Total_Cargos AS TotalCargos
                    FROM HABITACION h
                    LEFT JOIN CLIENTE c ON h.id_cliente = c.ID
                    ORDER BY h.Numero";

                $result = $conn->query($query);

                if ($result && $result->num_rows > 0):
                    while ($hab = $result->fetch_assoc()):
                        $estadoClass = $hab['Estado'] === 'ocupada' ? 'occupied' : 'available';
                        $badgeClass = $hab['Estado'] === 'ocupada' ? 'bg-danger' : 'bg-success';
                        $clienteNombre = $hab['Cliente'] ?? '';
                        $distancia = $hab['distancia_salida'];
                        $total = $hab['TotalCargos'] ?? 0;
                        ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card room-card shadow-sm <?= $estadoClass; ?>">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Habitación <?= $hab['Numero']; ?></h5>
                                    <span class="badge <?= $badgeClass; ?>"><?= ucfirst($hab['Estado']); ?></span>
                                </div>
                                <div class="card-body">
                                    <?php if ($hab['Estado'] == 'ocupada'): ?>
                                        <p><i class="fas fa-user me-2"></i><strong>Cliente:</strong> <?= htmlspecialchars($clienteNombre); ?></p>
                                        <p><i class="fas fa-money-bill-wave me-2"></i><strong>Total:</strong> Q<?= number_format($total, 2); ?></p>
                                        <p><i class="fas fa-route me-2"></i><strong>Distancia a salida:</strong> <?= $distancia; ?>m</p>
                                        <a href="salida_cliente.php?habitacion=<?= $hab['Numero']; ?>" class="btn btn-sm btn-danger w-100">
                                            <i class="fas fa-sign-out-alt me-1"></i> Registrar Salida
                                        </a>
                                    <?php else: ?>
                                        <p class="text-muted">Habitación disponible</p>
                                        <p><i class="fas fa-route me-2"></i><strong>Distancia a salida:</strong> <?= $distancia; ?>m</p>
                                        <a href="registrar_cliente.php?habitacion=<?= $hab['Numero']; ?>" class="btn btn-sm btn-primary w-100">
                                            <i class="fas fa-user-plus me-1"></i> Asignar Cliente
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-warning">No hay habitaciones registradas</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>