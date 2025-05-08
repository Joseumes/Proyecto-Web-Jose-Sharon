<?php
session_start();

$mensaje = ""; 

if (!isset($_SESSION['clientes'])) {
    $_SESSION['clientes'] = []; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['clientes'] = []; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nit = $_POST['nit'];
    $clienteEcontrado = false;

    foreach ($_SESSION['clientes'] as $index => $cliente) {
        if ($cliente['nit'] === $nit) {
            $fecha_ingreso = new DateTime($cliente['fecha_ingreso']);
            $fecha_salida = new DateTime($_POST['fecha_salida']);
            $dias = $fechaIngreso->diff($fechaSalida)->days;

            if ($dias > 0) $dias = 1;

            $tarifaPorNoche = 350;
            $totaldias = $dias * $tarifaPorNoche;
            $totalFinal = $totaldias + $cliente['cargos'];

            $mensaje = "El cliente:" . $cliente['nombre'] . "<br>" .
                        "Dias de estadía: " . $dias . "<br>" .
                        "Total por habitación: Q" . $totaldias . "<br>" .
                        "Cargos extras: Q" . $cliente['cargos'] . "<br>" .
                        "<strong>Total a pagar:  Q$totalFinal</strong>";

            unset($_SESSION['clientes'][$index]);
            $clienteEcontrado = true;
            break;
        }
    }

    if (!$clienteEcontrado) {
        $mensaje = "Cliente no encontrado.";
    }
}   
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Salida del Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2>Salida de Cliente</h2>
    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="nit" class="form-label">NIT del cliente:</label>
            <input type="text" name="nit" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger">Procesar Salida</button>
    </form>
</body>
</html>
