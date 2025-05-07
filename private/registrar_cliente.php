<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente =[
        'nombre' => $_POST['nombre'],
        'nit' => $_POST['nit'],
        'fecha_nacimiento' => $_POST['fecha_nacimiento'],
        'fecha_registro' => date('Y-m-d H:i:s'),
        'email' => $_POST['email'],
        'telefono' => $_POST['telefono'],
        'direccion' => $_POST['direccion'],
        'habitacion' => "",
        'cargos' => 0
    ];

    $edad = date_diff(date_create($cliente['fecha_nacimiento']), date_create(date('Y-m-d H:i:s')))->y;

    if ($edad < 18) {
        $cliente['habitacion'] = 'Niños';
    } elseif ($edad <= 60) {
        $cliente['habitacion'] = 'Adultos';
    } else {
        $cliente['habitacion'] = 'Tercera Edad';
    }

    $_SESSION['clientes'][] = $cliente;
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Registrar Cliente</h2>
    <form method="POST">
        <input class="form-control mb-2" name="nombre" placeholder="Nombre" required>
        <input class="form-control mb-2" name="nit" placeholder="NIT" required>
        <input class="form-control mb-2" type="date" name="fecha_nacimiento" required>
        <input class="form-control mb-2" name="email" placeholder="Correo electrónico">
        <input class="form-control mb-2" name="telefono" placeholder="Teléfono">
        <input class="form-control mb-2" name="direccion" placeholder="Dirección">
        <button class="btn btn-success">Registrar</button>
    </form>
</div>
</body>
</html>