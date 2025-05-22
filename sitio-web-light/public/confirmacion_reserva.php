<?php

session_start();


if (!isset($_SESSION['reserva'])) {
    header("Location: index.php");
    exit;
}


$reserva = $_SESSION['reserva'];
unset($_SESSION['reserva']); 
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
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="assets/img/logo.png" alt="Logo Hotel El Paraíso" width="40" height="40" class="d-inline-block align-top me-2">
                Hotel El Paraíso
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

        
        </div>
    </nav>

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
    </section>y

    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="text-uppercase mb-4">Hotel El Paraíso</h5>
                    <p>El mejor lugar para descansar y disfrutar de unas vacaciones tranquilas en un ambiente diseñado para tu comodidad.</p>
                    <div class="mt-4">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-tripadvisor"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="text-uppercase mb-4">Contacto</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i> 5ta calle, Ciudad Guatemala</p>
                    <p><i class="fas fa-phone me-2"></i> +502 1234 5678</p>
                    <p><i class="fas fa-envelope me-2"></i> Sharon-Jose@hotelparaiso.com</p>
                </div>
                <div class="col-lg-4">
                    <h5 class="text-uppercase mb-4">Horario</h5>
                    <p>Recepción abierta las 24 horas</p>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="text-center">
                <p class="mb-0">&copy; 2025 Hotel El Paraíso. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>