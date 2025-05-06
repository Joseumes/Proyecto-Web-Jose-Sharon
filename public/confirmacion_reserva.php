<?php
// Iniciar sesión
session_start();

// Verificar si hay datos de reserva
if (!isset($_SESSION['reserva'])) {
    header("Location: index.php");
    exit;
}

// Asignar datos de reserva a variables
$reserva = $_SESSION['reserva'];
unset($_SESSION['reserva']); // Limpiar la sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reserva - Hotel El Paraíso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- Navbar (igual que en index.php) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <!-- ... mismo navbar que en index.php ... -->
    </nav>

    <!-- Contenido principal -->
    <section class="py-5 mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-body p-5 text-center">
                            <div class="mb-4">
                                <i class="fas fa-check-circle fa-5x text-success mb-3"></i>
                                <h2 class="mb-3">¡Reserva Confirmada!</h2>
                                <p class="lead">Gracias por elegir el Hotel "El Paraíso"</p>
                            </div>
                            
                            <div class="reservation-details text-start mb-4">
                                <h4 class="mb-3">Detalles de su Reservación</h4>
                                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($reserva['nombre']); ?></p>
                                <p><strong>NIT:</strong> <?php echo htmlspecialchars($reserva['nit']); ?></p>
                                <p><strong>Edad:</strong> <?php echo $reserva['edad']; ?> años</p>
                                <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($reserva['telefono']); ?></p>
                                <p><strong>Fecha de Ingreso:</strong> <?php echo date('d/m/Y', strtotime($reserva['fecha_ingreso'])); ?></p>
                                <p><strong>Fecha de Salida:</strong> <?php echo date('d/m/Y', strtotime($reserva['fecha_salida'])); ?></p>
                                <p><strong>Días de Estadía:</strong> <?php echo $reserva['dias']; ?></p>
                                <p><strong>Total Estimado:</strong> Q<?php echo number_format($reserva['total'], 2); ?></p>
                                <?php if (!empty($reserva['comentarios'])): ?>
                                <p><strong>Comentarios:</strong> <?php echo htmlspecialchars($reserva['comentarios']); ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="alert alert-info">
                                <h5 class="alert-heading">¡Importante!</h5>
                                <p>Su reservación está pendiente de confirmación. Nos comunicaremos con usted en las próximas 24 horas al teléfono proporcionado para confirmar disponibilidad.</p>
                                <p>Para cualquier consulta, puede contactarnos al +502 1234 5678.</p>
                            </div>
                            
                            <a href="index.php" class="btn btn-primary mt-3">Volver al Inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer (igual que en index.php) -->
    <footer class="bg-dark text-white py-5">
        <!-- ... mismo footer que en index.php ... -->
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>