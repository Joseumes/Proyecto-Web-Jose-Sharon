<?php
session_start();

if (!isset($_SESSION['clientes'])) {
    $_SESSION['clientes'] = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Habitaciones Ocupadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2>Habitaciones Ocupadas</h2>

    <?php if (count($_SESSION['clientes']) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>NIT</th>
                    <th>Edad</th>
                    <th>Tipo de Habitación</th>
                    <th>Fecha de Ingreso</th>
                    <th>Fecha de Salida</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['clientes'] as $cliente): ?>
                    <tr>
                        <td><?= htmlspecialchars($cliente['nombre']) ?></td>
                        <td><?= htmlspecialchars($cliente['nit']) ?></td>
                        <td><?= htmlspecialchars($cliente['edad']) ?></td>
                        <td><?= htmlspecialchars($cliente['habitacion']) ?></td>
                        <td><?= htmlspecialchars($cliente['fecha_ingreso']) ?></td>
                        <td><?= htmlspecialchars($cliente['fecha_salida']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay habitaciones ocupadas actualmente.</p>
    <?php endif; ?>
</body>
</html>
