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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include('sidebar.php'); ?>

            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="mb-4"><i class="fas fa-bed me-2"></i> Gestión de Habitaciones</h2>
                
                <div class="row">
                    <?php
                    $habitaciones = [
                        ['numero' => 101, 'estado' => 'ocupada', 'cliente' => 'Juan Pérez', 'total' => 700, 'distancia' => 10],
                        ['numero' => 102, 'estado' => 'ocupada', 'cliente' => 'María Gómez', 'total' => 1050, 'distancia' => 20],
                        ['numero' => 103, 'estado' => 'libre', 'cliente' => '', 'total' => 0, 'distancia' => 30],
                        ['numero' => 104, 'estado' => 'libre', 'cliente' => '', 'total' => 0, 'distancia' => 40],
                        ['numero' => 105, 'estado' => 'ocupada', 'cliente' => 'Carlos Ruiz', 'total' => 350, 'distancia' => 50],
                        ['numero' => 106, 'estado' => 'libre', 'cliente' => '', 'total' => 0, 'distancia' => 60],
                        ['numero' => 107, 'estado' => 'ocupada', 'cliente' => 'Ana Martínez', 'total' => 700, 'distancia' => 70],
                        ['numero' => 108, 'estado' => 'ocupada', 'cliente' => 'Luis Díaz', 'total' => 350, 'distancia' => 80]
                    ];

                    foreach ($habitaciones as $hab) {
                        $estadoClass = $hab['estado'] == 'ocupada' ? 'occupied' : 'available';
                        $badgeClass = $hab['estado'] == 'ocupada' ? 'bg-danger' : 'bg-success';
                    ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card room-card shadow-sm <?php echo $estadoClass; ?>">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Habitación <?php echo $hab['numero']; ?></h5>
                                <span class="badge <?php echo $badgeClass; ?>">
                                    <?php echo ucfirst($hab['estado']); ?>
                                </span>
                            </div>
                            <div class="card-body">
                                <?php if ($hab['estado'] == 'ocupada'): ?>
                                <p><i class="fas fa-user me-2"></i> <strong>Cliente:</strong> <?php echo $hab['cliente']; ?></p>
                                <p><i class="fas fa-money-bill-wave me-2"></i> <strong>Total:</strong> Q<?php echo $hab['total']; ?></p>
                                <p><i class="fas fa-route me-2"></i> <strong>Distancia a salida:</strong> <?php echo $hab['distancia']; ?>m</p>
                                <a href="salida_cliente.php?habitacion=<?php echo $hab['numero']; ?>" class="btn btn-sm btn-danger w-100">
                                    <i class="fas fa-sign-out-alt me-1"></i> Registrar Salida
                                </a>
                                <?php else: ?>
                                <p class="text-muted">Habitación disponible</p>
                                <p><i class="fas fa-route me-2"></i> <strong>Distancia a salida:</strong> <?php echo $hab['distancia']; ?>m</p>
                                <a href="registrar_cliente.php?habitacion=<?php echo $hab['numero']; ?>" class="btn btn-sm btn-primary w-100">
                                    <i class="fas fa-user-plus me-1"></i> Asignar Cliente
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>