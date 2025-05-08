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
    $nit = $_POST['nit'];
    $cargos_seleccionados = $_POST['cargos'] ?? [];

    $clienteEcontrado = false;

    foreach ($_SESSION['clientes'] as &$cliente) {
        if ($cliente['nit'] === $nit) {
            $totalExtras = 0;
            foreach ($cargos_seleccionados as $cargo) {
                    $totalExtras += $servicios[$cargo];
                }
            $cliente['cargos'] += $totalExtras;
            $clienteEcontrado = true;
            $mensaje = "Cargos actualizados exitosamente. Con un total: Q$totalExtras. Total actual: Q" . $cliente['cargos'];
            break;
        }
    }

    if (!$clienteEcontrado) {
        $mensaje = "Cliente no encontrado.";
    }
}
?>
