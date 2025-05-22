<?php
session_start();

// Verificar si existe una reserva en sesión
if (!isset($_SESSION['reserva'])) {
    header("Location: index.php");
    exit;
}

// Obtener los datos de la reserva
$reserva = $_SESSION['reserva'];
unset($_SESSION['reserva']); // Limpiar sesión después de mostrar
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel El Paraíso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="bg-dark text-white">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="assets/img/logo.png" alt="Logo Hotel El Paraíso" width="40" height="40" class="d-inline-block align-top me-2">
            Hotel El Paraíso
        </a>
    </div>
</nav>


<!-- Confirmación -->
<section class="py-5 mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0 bg-secondary text-white">
                    <div class="card-body p-5 text-center">
                        <!-- Icono de confirmación -->
                        <i class="fas fa-check-circle fa-5x text-success mb-3"></i>
                        <h2 class="mb-3">¡Reserva Confirmada!</h2>
                        <p class="lead">Gracias por elegir el Hotel "El Paraíso"</p>

                        <!-- Detalles de la reserva -->
                        <div class="reservation-details text-start mt-4">
                            <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>Detalles de su Reservación</h5>
                            <ul class="list-unstyled">
                                <li><strong>Nombre:</strong> <?= htmlspecialchars($reserva['nombre']) ?></li>
                                <li><strong>NIT:</strong> <?= htmlspecialchars($reserva['nit']) ?></li>
                                <li><strong>Edad:</strong> <?= $reserva['edad'] ?> años</li>
                                <li><strong>Teléfono:</strong> <?= htmlspecialchars($reserva['telefono']) ?></li>
                                <li><strong>Fecha de Ingreso:</strong> <?= date('d/m/Y', strtotime($reserva['fecha_ingreso'])) ?></li>
                                <li><strong>Fecha de Salida:</strong> <?= date('d/m/Y', strtotime($reserva['fecha_salida'])) ?></li>
                                <li><strong>Días de Estadía:</strong> <?= $reserva['dias'] ?></li>
                                <li><strong>Total Estimado:</strong> Q<?= number_format($reserva['total'], 2) ?></li>
                                <?php if (!empty($reserva['comentarios'])): ?>
                                    <li><strong>Comentarios:</strong> <?= nl2br(htmlspecialchars($reserva['comentarios'])) ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <!-- Mensaje importante -->
                        <div class="alert alert-info mt-4 mb-0">
                            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Importante</h6>
                            <p>Su reservación está pendiente de confirmación. Nos comunicaremos con usted en las próximas 24 horas al teléfono proporcionado para confirmar disponibilidad.</p>
                            <p>Para cualquier consulta, puede contactarnos al +502 1234 5678.</p>
                        </div>

                        <!-- Botón de regreso -->
                        <a href="index.php" class="btn btn-primary mt-4 px-4">
                            <i class="fas fa-arrow-left me-2"></i>Volver al Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap @5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js " crossorigin="anonymous"></script>
</body>
</html>