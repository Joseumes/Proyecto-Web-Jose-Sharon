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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#about">Sobre Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#rooms">Habitaciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#services">Servicios</a>
                </li>
                <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                    <button class="btn btn-outline-light me-2" type="button" data-bs-toggle="modal" data-bs-target="#reservaModal">
                        <i class="fas fa-calendar-check me-1"></i> Reservar
                    </button>
                </li>
                <li class="nav-item mt-2 mt-lg-0">
                    <a class="btn btn-outline-light" href="login.php">
                        <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->

    <section class="hero-section" style="background-image: url('assets/img/fondo.jpg');">
            <div class="container h-100" >
                <div class="row h-100 align-items-center">
                    <div class="col-lg-8 text-white">
                        <h1 class="display-4 fw-bold mb-4">Bienvenido al Hotel El Paraíso</h1>
                        <p class="lead mb-5">El lugar perfecto para disfrutar de unas vacaciones inolvidables con la comodidad que mereces.</p>
                        <div class="d-flex gap-3">
                            <a href="#reservaModal" class="btn btn-primary btn-lg px-4" data-bs-toggle="modal">
                                <i class="fas fa-calendar-check me-2"></i> Reservar Ahora
                            </a>
                            <a href="#rooms" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-bed me-2"></i> Ver Habitaciones
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<!-- About Section -->

    <section id="about" class="py-5 bg-secondary">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="assets/img/hotel.png" alt="Hotel El Paraíso" class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Sobre Nosotros</h2>
                    <p class="lead">El Hotel "El Paraíso" se especializa en brindar comodidad y tranquilidad a nuestros huéspedes.</p>
                    <p>Nuestro establecimiento está especialmente diseñado para personas que buscan un lugar apacible para disfrutar de sus vacaciones, con atención personalizada y servicios de calidad.</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="me-3 text-primary">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Ubicación Privilegiada</h5>
                                    <p class="mb-0">Cerca de los principales atractivos turísticos</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="me-3 text-primary">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Servicio Personalizado</h5>
                                    <p class="mb-0">Atención las 24 horas para tu comodidad</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="me-3 text-primary">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Habitaciones Cómodas</h5>
                                    <p class="mb-0">Diseñadas para tu máximo descanso</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="me-3 text-primary">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Precios Accesibles</h5>
                                    <p class="mb-0">Calidad que no afecta tu bolsillo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<!-- Rooms Section -->
    <section id="rooms" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Nuestras Habitaciones</h2>
                <p >Todas nuestras habitaciones dobles incluyen:</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm bg-dark text-white">
                        <img src="assets/img/abitacion1.jpg" class="card-img-top" alt="Habitación 1">
                        <div class="card-body">
                            <h5 class="card-title">Habitación Doble</h5>
                            <p class="card-text">Amplias habitaciones con todas las comodidades para su descanso.</p>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Cama doble king size</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> TV por cable</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Aire acondicionado</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Baño privado</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> WiFi gratis</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 pb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="text-primary mb-0">Q350 <small class="text-muted">/noche</small></h4>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm bg-dark text-white">
                        <img src="assets/img/abitacion2.jpg" class="card-img-top" alt="Habitación 2">
                        <div class="card-body">
                            <h5 class="card-title">Habitación Doble</h5>
                            <p class="card-text">Amplias habitaciones con todas las comodidades para su descanso.</p>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Cama doble king size</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> TV por cable</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Aire acondicionado</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Baño privado</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> WiFi gratis</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 pb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="text-primary mb-0">Q350 <small class="text-muted">/noche</small></h4>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm bg-dark text-white">
                        <img src="assets/img/abitacion3.jpg" class="card-img-top" alt="Habitación 3">
                        <div class="card-body">
                            <h5 class="card-title">Habitación Doble</h5>
                            <p class="card-text">Amplias habitaciones con todas las comodidades para su descanso.</p>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Cama doble king size</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> TV por cable</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Aire acondicionado</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Baño privado</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> WiFi gratis</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 pb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="text-primary mb-0">Q350 <small class="text-muted">/noche</small></h4>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Services Section -->
<section id="services" class="py-5 bg-secondary">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Nuestros Servicios</h2>
            <p >Disfruta de nuestros servicios adicionales</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm bg-dark text-white">
                    <div class="card-body text-center p-4">
                        <div class="icon-service bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-4">
                            <i class="fas fa-utensils fa-2x"></i>
                        </div>
                        <h5>Servicio de Comidas</h5>
                        <p >Disfruta de nuestros platillos en el restaurante del hotel</p>
                        <div class="mt-3">
                            <p class="mb-1"><strong>Desayuno:</strong> Q30.00</p>
                            <p class="mb-1"><strong>Almuerzo:</strong> Q65.00</p>
                            <p class="mb-0"><strong>Cena:</strong> Q75.00</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm bg-dark text-white">
                    <div class="card-body text-center p-4">
                        <div class="icon-service bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-4">
                            <i class="fas fa-spa fa-2x"></i>
                        </div>
                        <h5>Spa y Relajación</h5>
                        <p >Relájate con nuestros tratamientos especializados</p>
                        <div class="mt-3">
                            <p class="mb-1"><strong>Masaje:</strong> Q150.00</p>
                            <p class="mb-0"><strong>Tratamiento Spa:</strong> Q300.00</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm bg-dark text-white">
                    <div class="card-body text-center p-4">
                        <div class="icon-service bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-4">
                            <i class="fas fa-concierge-bell fa-2x"></i>
                        </div>
                        <h5>Otros Servicios</h5>
                        <p >Servicios adicionales para tu comodidad</p>
                        <div class="mt-3">
                            <p class="mb-1"><strong>Lavandería:</strong> Q50.00</p>
                            <p class="mb-1"><strong>Tour Guiado:</strong> Q120.00</p>
                            <p class="mb-0"><strong>Transporte:</strong> Q100.00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reservation Modal -->
<div class="modal fade" id="reservaModal" tabindex="-1" aria-labelledby="reservaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="reservaModalLabel">Reservar Habitación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="reservas.php" method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control bg-dark text-white" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nit" class="form-label">NIT</label>
                            <input type="text" class="form-control bg-dark text-white" id="nit" name="nit" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control bg-dark text-white" id="fecha_nacimiento" name="fecha_nacimiento" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control bg-dark text-white" id="telefono" name="telefono" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                            <input type="date" class="form-control bg-dark text-white" id="fecha_ingreso" name="fecha_ingreso" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_salida" class="form-label">Fecha de Salida</label>
                            <input type="date" class="form-control bg-dark text-white" id="fecha_salida" name="fecha_salida" required>
                        </div>
                        <div class="col-12">
                            <label for="comentarios" class="form-label">Comentarios o Requerimientos Especiales</label>
                            <textarea class="form-control bg-dark text-white" id="comentarios" name="comentarios" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-info mb-0">
                                <h6 class="alert-heading">¡Importante!</h6>
                                <p class="mb-0">El costo por noche es de Q350.00. Al realizar la reserva, nos comunicaremos contigo para confirmar disponibilidad.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar Reserva</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
        <hr class="my-4 bg-secondary">
        <div class="text-center">
            <p class="mb-0">&copy; 2025 Hotel El Paraíso. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
       
        document.addEventListener('DOMContentLoaded', function() {
            const fechaIngreso = document.getElementById('fecha_ingreso');
            const fechaSalida = document.getElementById('fecha_salida');
            
            if (fechaIngreso && fechaSalida) {
                
                const hoy = new Date().toISOString().split('T')[0];
                fechaIngreso.min = hoy;
                
                
                fechaIngreso.addEventListener('change', function() {
                    fechaSalida.min = this.value;
                    
                    
                    if (fechaSalida.value && fechaSalida.value < this.value) {
                        fechaSalida.value = '';
                    }
                });
            }
            

            const fechaNacimiento = document.getElementById('fecha_nacimiento');
            if (fechaNacimiento) {
                fechaNacimiento.addEventListener('change', function() {
                    const nacimiento = new Date(this.value);
                    const hoy = new Date();
                    let edad = hoy.getFullYear() - nacimiento.getFullYear();
                    const mes = hoy.getMonth() - nacimiento.getMonth();
                    
                    if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
                        edad--;
                    }
                    
                    if (edad < 18) {
                        alert('Lo sentimos, el hotel solo acepta huéspedes mayores de 18 años.');
                        this.value = '';
                    }
                });
            }
        });
    </script>
</body>
</html>