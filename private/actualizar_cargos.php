<?php
session_start();

$mensaje = "";
$servicios = [
    'Desayuno' => 30,
    'Almuerzo' => 65,
    'Cena' => 75,
    'masaje' => 150,
    'Spa' => 300,
    'lavanderia' => 50,
    'tour guiado' => 120,
    'transporte' => 100,
];

if (!isset($_SESSION['clientes'])) {
    $_SESSION['clientes'] = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $cargos_seleccionados = $_POST['cargos'] ?? [];

    $clienteEcontrado = false;

    foreach ($_SESSION['clientes'] as &$cliente) {
        if ($cliente['nombre'] === $nombre) {
            $totalExtras = 0;
            foreach ($cargos_seleccionados as $cargo) {
                    $totalExtras += $servicios[$cargo];
                }
            $cliente['cargos'] += $totalExtras;
            $clienteEcontrado = true;
            $mensaje = "Cargos actualizados exitosamente. Con un total de: Q$totalExtras.00";
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
    <title>Actualizar Cargos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2>Actualizar Cargos por Servicios Extras</h2>
    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?= $mensaje ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del cliente:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <p>Selecciona los servicios consumidos:</p>
        <?php foreach ($servicios as $nombre => $precio): ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="cargos[]" value="<?= $nombre ?>" id="<?= $nombre ?>">
                <label class="form-check-label" for="<?= $nombre ?>">
                    <?= ucfirst($nombre) ?> (Q<?= $precio ?>)
                </label>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-primary mt-3">Actualizar Cargos</button>
    </form>
</body>
</html>