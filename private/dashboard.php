<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: ../private/dashboard.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>dashboard - Hotel El Paraíso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Bienvenido</h1>
    <a href="registrar_cliente.php" class="btn btn-primary mt-3">Registrar Cliente</a>
    <a href="actualizar_cargos.php" class="btn btn-warning mt-3">Actualizar Cargos</a>
    <a href="salida_cliente.php" class="btn btn-danger mt-3">Salida de Cliente</a>
    <a href="habitaciones.php" class="btn btn-info mt-3">Ver Habitaciones</a>
    <a href="logout.php" class="btn btn-secondary mt-3">Cerrar Sesión</a>
</div>
</body>
</html>