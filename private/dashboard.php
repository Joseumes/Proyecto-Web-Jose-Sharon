<?php
session_start();
if (!isset($_SESSION['logueado'])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenido, Administrador</h1>
        <p>Usa el siguiente menú para navegar:</p>
        <ul>
            <li><a href="registrar_cliente.php">Registrar Cliente</a></li>
            <li><a href="actualizar_cargos.php">Actualizar Cargos</a></li>
            <li><a href="salida_cliente.php">Salida de Cliente</a></li>
            <li><a href="habitaciones.php">Ver Habitaciones</a></li>
            <li><a href="logout.php">Cerrar Sesión</a></li>
        </ul>
    </div>
</body>
</html>
