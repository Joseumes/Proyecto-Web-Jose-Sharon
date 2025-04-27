<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel El Paraíso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" alt="Logo Hotel El Paraíso" width="40" height="40" class="d-inline-block align-text-top">
                Hotel El Paraíso
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Iniciar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero text-center py-5">
        <div class="container">
            <h1 class="display-4">Bienvenido al Hotel El Paraíso</h1>
            <p class="lead">El lugar perfecto para disfrutar de unas vacaciones inolvidables.</p>
            <img src="img/hotel.jpg" alt="Hotel El Paraíso" class="img-fluid rounded">
        </div>
    </section>

    <section class="reserva py-5">
        <div class="container">
            <h2 class="text-center mb-4">Realiza tu reserva</h2>
            <form id="formulario-reserva" class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="col-md-6">
                    <label for="nit" class="form-label">NIT</label>
                    <input type="text" class="form-control" id="nit" name="nit" required>
                </div>
                <div class="col-md-6">
                    <label for="fecha-nacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fecha-nacimiento" name="fecha-nacimiento" required>
                </div>
                <div class="col-md-6">
                    <label for="fecha-ingreso" class="form-label">Fecha de Ingreso</label>
                    <input type="date" class="form-control" id="fecha-ingreso" name="fecha-ingreso" required>
                </div>
                <div class="col-md-6">
                    <label for="fecha-salida" class="form-label">Fecha de Salida</label>
                    <input type="date" class="form-control" id="fecha-salida" name="fecha-salida" required>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Reservar</button>
                </div>
            </form>
        </div>
    </section>


    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Hotel El Paraíso. Todos los derechos reservados.</p>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>