<?php
session_start();

if (!isset($_SESSION['clientes'])) {
    $_SESSION['clientes'] = [];
}
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $nit = $_POST['nit'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $fecha_registro = date('Y-m-d H:i:s');
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $direccion = $_POST['direccion'];
        $ocupacion = $_POST['ocupacion'];

        if (!is_numeric($nit)) {
            $mensaje = "El NIT debe ser un número valido.";
        } elseif (!is_numeric($telefono)) {
            $mensaje = "El teléfono debe ser un número valido.";
        } else {
            foreach ($_SESSION['clientes'] as $clienteExistente) {
                if ($clienteExistente['nombre'] === $nimbre) {
                    $mensaje = "El cliente ya está registrado.";
                    break;
                }
            }
        }

    $edad = date_diff(date_create($fecha_nacimiento), date_create('today'))->y;

    if ($edad < 18) {
        $habitacion = 'Niños';
    } elseif ($edad <= 60) {
        $habitacion = 'Adultos';
    } else {
        $habitacion = 'Tercera Edad';
    }

    $cliente = [
        'nombre' => $nombre,
        'nit' => $nit,
        'fecha_nacimiento' => $fecha_nacimiento,
        'fecha_registro' => $fecha_registro,
        'telefono' => $telefono,
        'correo' => $correo,
        'direccion' => $direccion,
        'ocupacion' => $ocupacion,
        'habitacion' => $habitacion,
        'cargos' => 0,
    ];


    $_SESSION['clientes'][] = $cliente;
    $mensaje = "Cliente registrado exitosamente con habitación: $habitacion.";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2>Registrar Cliente</h2>
    <?php if ($mensaje): ?>
        <div class="alert alert-success"><?= $mensaje ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>NIT:</label>
            <input type="text" name="nit" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Fecha de nacimiento:</label>
            <input type="date" name="fecha_nacimiento" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Teléfono:</label>
            <input type="text" name="telefono" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Correo:</label>
            <input type="email" name="correo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Dirección:</label>
            <input type="text" name="direccion" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Ocupación:</label>
            <input type="text" name="ocupacion" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Cliente</button>
    </form>
</body>
</html>